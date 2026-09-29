<?php

namespace App\Http\Controllers;

use App\Models\Topup;
use App\Models\WalletTransaction;
use App\Services\PaymentGatewayService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TopupController extends Controller
{
    public function __construct(
        protected PaymentGatewayService $paymentGateway
    ) {}

    /**
     * Show wallet dashboard with balance, top-up form, and transaction history.
     */
    public function index()
    {
        $user = auth()->user();

        $transactions = WalletTransaction::where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        $pendingTopup = Topup::where('user_id', $user->id)
            ->where('payment_status', 'pending')
            ->where('expired_at', '>', now())
            ->latest()
            ->first();

        return view('customer.wallet', compact('user', 'transactions', 'pendingTopup'));
    }

    /**
     * Process top-up request: create topup record + generate QRIS.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer|min:10000|max:10000000',
        ], [
            'amount.required' => 'Nominal top-up wajib diisi.',
            'amount.integer' => 'Nominal harus berupa angka.',
            'amount.min' => 'Minimal top-up Rp 10.000.',
            'amount.max' => 'Maksimal top-up Rp 10.000.000.',
        ]);

        // Create topup record
        $topup = Topup::create([
            'user_id' => auth()->id(),
            'reference_id' => 'TU-' . strtoupper(Str::random(12)),
            'amount' => $request->amount,
            'payment_method' => 'qris',
            'payment_status' => 'pending',
        ]);

        // Call payment gateway to generate QRIS
        $qrisData = $this->paymentGateway->createQrisCharge($topup);

        $topup->update([
            'qr_string' => $qrisData['qr_string'],
            'qr_code_url' => $qrisData['qr_code_url'],
            'expired_at' => $qrisData['expired_at'],
        ]);

        return redirect()->route('customer.topup.show', $topup->reference_id);
    }

    /**
     * Show QRIS payment page with QR code and countdown timer.
     */
    public function show(string $referenceId)
    {
        $topup = Topup::where('reference_id', $referenceId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Auto-expire if past deadline
        if ($topup->isPending() && $topup->expired_at && $topup->expired_at->isPast()) {
            $topup->update(['payment_status' => 'expired']);
        }

        return view('customer.topup-show', compact('topup'));
    }
}
