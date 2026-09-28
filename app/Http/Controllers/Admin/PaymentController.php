<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // 1. Melihat semua pembayaran
    public function index()
    {
        // Memuat pembayaran beserta relasi order dan user
        $payments = Payment::with('order.user')->latest()->get();
        return view('admin.payments.index', compact('payments'));
    }

    // 2. Melihat detail dan bukti pembayaran
    public function show(Payment $payment)
    {
        $payment->load('order.user');
        return view('admin.payments.show', compact('payment'));
    }

    // 3. Verifikasi (Menyetujui / Menolak)
    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'rejection_reason' => 'nullable|string|required_if:status,rejected'
        ]);

        $payment->update([
            'status' => $validated['status'],
            'rejection_reason' => $validated['status'] == 'rejected' ? $validated['rejection_reason'] : null,
        ]);

        // Sinkronisasi status order secara otomatis
        if ($validated['status'] == 'approved') {
            $payment->order->update(['status' => 'processing']); // Otomatis diproses
        } elseif ($validated['status'] == 'rejected') {
            $payment->order->update(['status' => 'pending']); // Kembalikan ke pending agar user bayar ulang
        }

        return redirect()->back()->with('success', 'Status pembayaran berhasil diverifikasi!');
    }
}