<?php

namespace Tests\Feature;

use App\Models\TopUp;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TopupTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_topups()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('customer.topup.index'));

        $response->assertStatus(200);
        $response->assertViewIs('customer.topup.index');
    }

    public function test_user_can_request_topup()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('customer.topup.store'), [
            'amount' => 50000,
        ]);

        $topup = TopUp::where('user_id', $user->id)->first();
        $this->assertNotNull($topup);
        $response->assertRedirect(route('customer.topup.show', $topup->reference_id));
    }

    public function test_user_can_view_topup_detail()
    {
        $user = User::factory()->create();
        $topup = TopUp::create([
            'user_id' => $user->id,
            'reference_id' => 'TU-12345',
            'amount' => 50000,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user)->get(route('customer.topup.show', $topup->reference_id));

        $response->assertStatus(200);
        $response->assertViewIs('customer.topup.show');
    }

    public function test_user_can_upload_topup_proof()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $topup = TopUp::create([
            'user_id' => $user->id,
            'reference_id' => 'TU-12345',
            'amount' => 50000,
            'status' => 'pending',
        ]);

        $file = UploadedFile::fake()->image('proof.jpg');

        $response = $this->actingAs($user)->post(route('customer.topup.upload-proof', $topup->reference_id), [
            'proof_image' => $file,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('topups', [
            'id' => $topup->id,
            'status' => 'waiting_confirmation',
        ]);
    }
}
