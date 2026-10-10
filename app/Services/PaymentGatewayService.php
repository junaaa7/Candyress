<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Topup;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentGatewayService
{
    /**
     * Create a QRIS payment request.
     * In production, replace this with actual Midtrans/Tripay API call.
     */
    public function createQrisCharge(Topup $topup): array
    {
        // ── MOCK IMPLEMENTATION ──
        // Replace this block with real payment gateway integration.
        //
        // Example Midtrans Core API:
        // $params = [
        //     'payment_type' => 'qris',
        //     'transaction_details' => [
        //         'order_id' => $topup->reference_id,
        //         'gross_amount' => $topup->amount,
        //     ],
        // ];
        // $response = \Midtrans\CoreApi::charge($params);

        $expiredAt = now()->addMinutes(15);

        // Generate a mock QR string (in production this comes from the gateway)
        $qrString = 'MOCK-QRIS-'.$topup->reference_id.'-'.$topup->amount;

        // Use a free QR code generator API for the QR image
        $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data='.urlencode($qrString);

        return [
            'qr_string' => $qrString,
            'qr_code_url' => $qrCodeUrl,
            'expired_at' => $expiredAt,
        ];
    }

    /**
     * Validate incoming webhook signature.
     * In production, verify using your gateway's secret key.
     */
    public function validateWebhookSignature(array $payload): bool
    {
        // ── MOCK: Always return true ──
        // Production example for Midtrans:
        $serverKey = config('midtrans.server_key');
        $orderId = $payload['order_id'] ?? '';
        $statusCode = $payload['status_code'] ?? '';
        $grossAmount = $payload['gross_amount'] ?? '';
        $expectedSignature = hash('sha512', $orderId.$statusCode.$grossAmount.$serverKey);

        return hash_equals($expectedSignature, $payload['signature_key'] ?? '');
    }

    /**
     * Generate Midtrans Snap Token for an Order
     */
    public function generateSnapToken(Order $order): ?string
    {
        // Konfigurasi Midtrans
        Config::$serverKey = trim(config('midtrans.server_key') ?? env('MIDTRANS_SERVER_KEY'));
        Config::$clientKey = trim(config('midtrans.client_key') ?? env('MIDTRANS_CLIENT_KEY'));
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = config('midtrans.is_sanitized', true);
        Config::$is3ds = config('midtrans.is_3ds', true);
        Config::$curlOptions = [];

        $params = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => (int) $order->total_price,
            ],
            'customer_details' => [
                'first_name' => $order->user->name ?? 'Customer',
                'email' => $order->user->email ?? 'customer@mail.com',
                'phone' => $order->user->phone ?? '',
            ],
            // Memprioritaskan metode pembayaran QRIS / E-Wallet di Midtrans
            'enabled_payments' => ['qris', 'gopay', 'shopeepay'],
        ];

        try {
            return Snap::getSnapToken($params);
        } catch (\Exception $e) {
            Log::error('Midtrans Error: '.$e->getMessage());
            throw $e;
        }
    }

    /**
     * Generate Midtrans Snap Token for a Topup
     */
    public function generateTopupSnapToken(Topup $topup): ?string
    {
        // Konfigurasi Midtrans
        Config::$serverKey = trim(config('midtrans.server_key') ?? env('MIDTRANS_SERVER_KEY'));
        Config::$clientKey = trim(config('midtrans.client_key') ?? env('MIDTRANS_CLIENT_KEY'));
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = config('midtrans.is_sanitized', true);
        Config::$is3ds = config('midtrans.is_3ds', true);
        Config::$curlOptions = [];

        $params = [
            'transaction_details' => [
                'order_id' => $topup->reference_id,
                'gross_amount' => (int) $topup->amount,
            ],
            'customer_details' => [
                'first_name' => $topup->user->name ?? 'Customer',
                'email' => $topup->user->email ?? 'customer@mail.com',
                'phone' => $topup->user->phone ?? '',
            ],
            'enabled_payments' => ['qris', 'gopay', 'shopeepay'],
        ];

        try {
            return Snap::getSnapToken($params);
        } catch (\Exception $e) {
            Log::error('Midtrans Topup Error: '.$e->getMessage());
            throw $e;
        }
    }
}
