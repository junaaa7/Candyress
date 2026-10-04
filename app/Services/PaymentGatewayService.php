<?php

namespace App\Services;

use App\Models\Topup;

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
        // $serverKey = config('services.midtrans.server_key');
        // $orderId = $payload['order_id'];
        // $statusCode = $payload['status_code'];
        // $grossAmount = $payload['gross_amount'];
        // $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
        // return hash_equals($expectedSignature, $payload['signature_key'] ?? '');

        return true;
    }
}
