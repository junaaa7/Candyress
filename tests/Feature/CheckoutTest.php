<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_checkout()
    {
        $user = User::factory()->create();
        $cart = Cart::create(['user_id' => $user->id]);
        $category = \App\Models\Category::create(['name' => 'Cat', 'slug' => 'cat']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Test Product',
            'slug' => 'test-product',
            'description' => 'Desc',
            'product_type' => 'digital',
            'price' => 10000,
        ]);
        \App\Models\ProductStock::create(['product_id' => $product->id, 'content' => 'Data', 'status' => 'available']);
        \App\Models\ProductStock::create(['product_id' => $product->id, 'content' => 'Data2', 'status' => 'available']);
        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response = $this->actingAs($user)->get(route('checkout.index'));
        $response->assertStatus(200);
        $response->assertViewIs('store.checkout');
    }

    public function test_checkout_redirects_if_cart_empty()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('checkout.index'));
        $response->assertRedirect(route('cart.index'));
    }

    public function test_user_can_process_checkout()
    {
        $user = User::factory()->create();
        $cart = Cart::create(['user_id' => $user->id]);
        $category = \App\Models\Category::create(['name' => 'Cat', 'slug' => 'cat']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Test Product',
            'slug' => 'test-product',
            'description' => 'Desc',
            'product_type' => 'digital',
            'price' => 10000,
        ]);
        \App\Models\ProductStock::create(['product_id' => $product->id, 'content' => 'Data', 'status' => 'available']);
        \App\Models\ProductStock::create(['product_id' => $product->id, 'content' => 'Data2', 'status' => 'available']);
        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response = $this->actingAs($user)->post(route('checkout.process'), [
            'payment_method' => 'QRIS',
        ]);

        $order = Order::where('user_id', $user->id)->first();
        $this->assertNotNull($order);
        $response->assertRedirect(route('checkout.success', $order->order_number));
        $this->assertDatabaseMissing('cart_items', [
            'cart_id' => $cart->id,
        ]);
    }

    public function test_checkout_success_page()
    {
        $user = User::factory()->create();
        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'ORD-TEST1234',
            'total_price' => 10000,
            'status' => 'pending',
        ]);
        \App\Models\Payment::create([
            'order_id' => $order->id,
            'payment_method' => 'QRIS',
            'amount' => 10000,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user)->get(route('checkout.success', $order->order_number));
        $response->assertStatus(200);
        $response->assertViewIs('store.success');
    }
}
