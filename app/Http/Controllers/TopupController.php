<?php

namespace App\Http\Controllers;

use App\Models\TopUp;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

        return view('customer.topup.show', compact('topup'));
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
