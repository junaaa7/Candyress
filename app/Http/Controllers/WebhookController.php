<?php

namespace App\Http\Controllers;

use App\Models\Topup;
use App\Services\PaymentGatewayService;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function __construct(
        protected PaymentGatewayService $paymentGateway,
        protected WalletService $walletService
    ) {}

    /**
     * Handle incoming payment webhook/callback.
     * Idempotent: ignores duplicate notifications for already-paid topups.
     */
    public function handlePayment(Request $request)
    {
        $payload = $request->all();

        // 1. Validate webhook signature
        if (! $this->paymentGateway->validateWebhookSignature($payload)) {
            Log::warning('Webhook signature invalid', $payload);

            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // 2. Extract reference_id from payload
        // Adapt this key based on your payment gateway's callback format
        $referenceId = $payload['reference_id'] ?? $payload['order_id'] ?? null;
        $status = $payload['status'] ?? $payload['transaction_status'] ?? null;

        if (! $referenceId) {
            return response()->json(['message' => 'Missing reference_id'], 400);
        }

        // 3. Find the topup record
        $topup = Topup::where('reference_id', $referenceId)->first();

        if (! $topup) {
            Log::warning('Webhook topup not found', ['reference_id' => $referenceId]);

            return response()->json(['message' => 'Topup not found'], 404);
        }

        // 4. Idempotency check: skip if already processed
        if ($topup->isPaid()) {
            return response()->json(['message' => 'Already processed'], 200);
        }

        // 5. Process based on status
        $mappedStatus = $this->mapPaymentStatus($status);

        if ($mappedStatus === 'paid') {
            // Credit the user's wallet via atomic transaction
            $this->walletService->credit(
                $topup->user,
                $topup->amount,
                'Top-up saldo via QRIS ('.$topup->reference_id.')',
                'topup',
                $topup->id
            );

            $topup->update([
                'status' => 'paid',
                'payload' => $payload,
            ]);

            Log::info('Topup paid successfully', ['reference_id' => $referenceId, 'amount' => $topup->amount]);
        } elseif (in_array($mappedStatus, ['expired', 'failed'])) {
            $topup->update([
                'status' => $mappedStatus,
                'payload' => $payload,
            ]);
        }

        return response()->json(['message' => 'OK'], 200);
    }

    /**
     * Map various gateway status strings to our internal statuses.
     */
    private function mapPaymentStatus(?string $status): string
    {
        return match (strtolower($status ?? '')) {
            'paid', 'settlement', 'capture', 'success' => 'paid',
            'expire', 'expired' => 'expired',
            'cancel', 'deny', 'failure', 'failed' => 'failed',
            default => 'pending',
        };
    }
}
