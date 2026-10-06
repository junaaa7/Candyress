<?php

namespace Tests\Feature;

use App\Models\Topup;
use App\Models\User;
use App\Services\PaymentGatewayService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class WebhookTest extends TestCase
{
    use RefreshDatabase;

    public function test_webhook_handles_payment_success()
    {
        $user = User::factory()->create();
        $topup = Topup::create([
            'user_id' => $user->id,
            'reference_id' => 'TU-12345',
            'amount' => 50000,
            'status' => 'pending',
            'payment_status' => 'pending',
        ]);

        $mockGateway = Mockery::mock(PaymentGatewayService::class);
        $mockGateway->shouldReceive('validateWebhookSignature')->andReturn(true);
        $this->app->instance(PaymentGatewayService::class, $mockGateway);

        $response = $this->postJson(route('webhook.payment'), [
            'reference_id' => 'TU-12345',
            'status' => 'success',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('topups', [
            'id' => $topup->id,
            'status' => 'paid',
        ]);
        
        // Assert user balance increased
        $this->assertEquals(50000, $user->fresh()->balance);
    }
}
