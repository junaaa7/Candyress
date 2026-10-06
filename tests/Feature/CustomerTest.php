<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_view_products()
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Cat', 'slug' => 'cat']);
        Product::create([
            'category_id' => $category->id,
            'name' => 'Product 1',
            'slug' => 'product-1',
            'description' => 'Desc',
            'product_type' => 'digital',
            'price' => 100,
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->get(route('customer.products.index'));

        $response->assertStatus(200);
        $response->assertViewIs('customer.products');
    }

    public function test_customer_can_view_orders()
    {
        $user = User::factory()->create();
        Order::create([
            'user_id' => $user->id,
            'order_number' => 'ORD-123',
            'total_price' => 100,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user)->get(route('customer.orders.index'));

        $response->assertStatus(200);
        $response->assertViewIs('customer.orders');
    }

    public function test_customer_can_upload_payment_proof()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'ORD-123',
            'total_price' => 100,
            'status' => 'pending',
        ]);

        $file = UploadedFile::fake()->image('proof.jpg');

        $response = $this->actingAs($user)->post(route('customer.payment.upload', $order->order_number), [
            'payment_proof' => $file,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('payments', [
            'order_id' => $order->id,
        ]);
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'processing',
        ]);
    }

    public function test_customer_can_update_profile()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('customer.profile.update'), [
            'name' => 'New Name',
            'phone' => '08123456789',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'New Name',
            'whatsapp' => '08123456789',
        ]);
    }
}
