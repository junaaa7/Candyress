<?php

namespace App\Http\Controllers;

use App\Models\TopUp;
use App\Services\PaymentGatewayService;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Transaction;

class TopupController extends Controller
{
    public function __construct(
        protected WalletService $walletService
    ) {}

    public function index()
    {
        $topups = TopUp::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.topup.index', compact('topups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000|max:5000000',
        ]);

        $topup = TopUp::create([
            'user_id' => auth()->id(),
            'reference_id' => 'TU-'.strtoupper(Str::random(8)),
            'amount' => $request->amount,
            'status' => 'pending',
        ]);

        return redirect()->route('customer.topup.show', $topup->reference_id)
            ->with('success', 'Request top up berhasil dibuat!');
    }

    public function show($referenceId)
    {
        $topup = TopUp::where('reference_id', $referenceId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Auto-Sync dengan Midtrans jika status masih pending
        if ($topup->status === 'pending') {
            Config::$serverKey = trim(config('midtrans.server_key') ?? env('MIDTRANS_SERVER_KEY'));
            Config::$isProduction = config('midtrans.is_production', false);
            Config::$curlOptions = [];

            try {
                // Coba sinkronisasi status
                $midtransStatus = Transaction::status($topup->reference_id);
                if ($midtransStatus) {
                    $status = $midtransStatus->transaction_status ?? null;
                    $fraud = $midtransStatus->fraud_status ?? null;

                    if ($status == 'settlement' || ($status == 'capture' && $fraud == 'accept')) {
                        // Tambah saldo user
                        $this->walletService->addBalance($topup->user, $topup->amount, 'Topup Saldo', 'topup', $topup->id);
                        $topup->status = 'success';
                        $topup->save();
                    } elseif (in_array($status, ['deny', 'cancel', 'expire'])) {
                        $topup->status = 'failed';
                        $topup->save();
                    }
                }
            } catch (\Exception $e) {
                // Mungkin transaksi belum ada di Midtrans, lanjut generate token
            }

            // Generate Snap Token jika masih pending dan belum ada token valid
            if ($topup->status === 'pending' && (empty($topup->snap_token) || ! str_contains($topup->snap_token, '-'))) {
                try {
                    $snapToken = app(PaymentGatewayService::class)->generateTopupSnapToken($topup);
                    if ($snapToken) {
                        $topup->snap_token = $snapToken;
                        $topup->save();
                    }
                } catch (\Exception $e) {
                    session()->flash('midtrans_error', 'Gagal memuat Midtrans: '.$e->getMessage());
                }
            }
        }

        return view('customer.topup.show', [
            'topup' => $topup,
            'snapToken' => $topup->snap_token,
        ]);
    }

    /**
     * Handle proof of payment upload for a top-up request.
     */
    public function uploadProof(Request $request, string $referenceId)
    {
        $request->validate([
            'proof_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $topup = TopUp::where('reference_id', $referenceId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if (! in_array($topup->status, ['pending', 'rejected'])) {
            return back()->with('error', 'Top up ini tidak dapat menerima bukti pembayaran saat ini.');
        }

        $path = $request->file('proof_image')->store('proofs', 'public');

        $topup->update([
            'proof_image' => $path,
            'status' => 'waiting_confirmation',
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diupload! Silakan tunggu konfirmasi admin.');
    }
}
