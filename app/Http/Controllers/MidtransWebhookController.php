<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\TopUp;
use App\Services\OrderFulfillmentService;
use App\Services\PaymentGatewayService;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request, PaymentGatewayService $paymentGatewayService)
    {
        $payload = $request->all();

        // 1. Validate signature key
        $orderId = $payload['order_id'] ?? null;
        $statusCode = $payload['status_code'] ?? null;
        $grossAmount = $payload['gross_amount'] ?? null;
        $signatureKey = $payload['signature_key'] ?? null;

        $serverKey = config('midtrans.server_key');
        $expectedSignature = hash('sha512', $orderId.$statusCode.$grossAmount.$serverKey);

        if ($expectedSignature !== $signatureKey) {
            Log::warning('Midtrans Webhook: Invalid Signature', $payload);

            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // 2. Cek apakah ini Topup atau Order
        if (str_starts_with($orderId, 'TU-')) {
            $topup = TopUp::where('reference_id', $orderId)->first();
            if (! $topup) {
                Log::warning('Midtrans Webhook: Topup not found', ['order_id' => $orderId]);

                return response()->json(['message' => 'Topup not found'], 404);
            }

            if ($topup->status === 'success' || $topup->status === 'approved') {
                return response()->json(['message' => 'Topup already processed']);
            }

            $transactionStatus = $payload['transaction_status'] ?? null;
            $fraudStatus = $payload['fraud_status'] ?? null;

            if ($transactionStatus == 'settlement' || ($transactionStatus == 'capture' && $fraudStatus == 'accept')) {
                // Tambah saldo user
                app(WalletService::class)->addBalance($topup->user, $topup->amount, 'Topup Saldo', 'topup', $topup->id);
                $topup->status = 'success';
                $topup->save();
            } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
                $topup->status = 'failed';
                $topup->save();
            }

            return response()->json(['message' => 'Topup Success']);
        }

        // 3. Cari Order
        $order = Order::where('order_number', $orderId)->first();
        if (! $order) {
            Log::warning('Midtrans Webhook: Order not found', ['order_id' => $orderId]);

            return response()->json(['message' => 'Order not found'], 404);
        }

        $payment = $order->payment;
        if (! $payment) {
            Log::warning('Midtrans Webhook: Payment record not found', ['order_id' => $orderId]);

            return response()->json(['message' => 'Payment record not found'], 404);
        }

        if ($order->status === 'completed' || $payment->status === 'approved') {
            return response()->json(['message' => 'Order already processed']);
        }

        // 3. Update Status
        $transactionStatus = $payload['transaction_status'] ?? null;
        $fraudStatus = $payload['fraud_status'] ?? null;

        DB::beginTransaction();
        try {
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'challenge') {
                    $payment->status = 'pending';
                } elseif ($fraudStatus == 'accept') {
                    $payment->status = 'approved';
                    $order->status = 'processing'; // Ready to be fulfilled
                }
            } elseif ($transactionStatus == 'settlement') {
                $payment->status = 'approved';
                $order->status = 'processing';
            } elseif ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
                $payment->status = 'rejected';
                $order->status = 'failed';
            } elseif ($transactionStatus == 'pending') {
                $payment->status = 'pending';
            }

            $payment->save();
            $order->save();

            // 4. Auto Fulfillment jika approved (seperti saat payment SALDO)
            if ($payment->status === 'approved' && $order->status === 'processing') {
                // Ensure fulfillment only happens once. Check if it has account credentials or is already completed.
                // Assuming OrderFulfillmentService handles idempotency or we check status before calling.
                app(OrderFulfillmentService::class)->fulfill($order);
            }

            DB::commit();

            return response()->json(['message' => 'Success']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Midtrans Webhook: Error processing order', [
                'order_id' => $orderId,
                'error' => $e->getMessage(),
            ]);

            return response()->json(['message' => 'Internal server error'], 500);
        }
    }
}
