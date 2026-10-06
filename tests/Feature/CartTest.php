<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_cart()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('cart.index'));
        $response->assertStatus(200);
        $response->assertViewIs('store.cart');
    }

    public function test_user_can_add_product_to_cart()
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Cat', 'slug' => 'cat']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Test Product',
            'slug' => 'test-product',
            'description' => 'Desc',
            'product_type' => 'digital',
            'price' => 10000,
        ]);
        ProductStock::create(['product_id' => $product->id, 'content' => 'Data', 'status' => 'available']);
        ProductStock::create(['product_id' => $product->id, 'content' => 'Data2', 'status' => 'available']);

        $response = $this->actingAs($user)->post(route('cart.store'), [
            'product_id' => $product->id,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('cart_items', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
    }

    public function test_user_can_update_cart_item()
    {
        $user = User::factory()->create();
        $cart = Cart::create(['user_id' => $user->id]);
        $category = Category::create(['name' => 'Cat', 'slug' => 'cat']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Test Product',
            'slug' => 'test-product',
            'description' => 'Desc',
            'product_type' => 'digital',
            'price' => 10000,
        ]);
        ProductStock::create(['product_id' => $product->id, 'content' => 'Data', 'status' => 'available']);
        ProductStock::create(['product_id' => $product->id, 'content' => 'Data2', 'status' => 'available']);
        $cartItem = CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response = $this->actingAs($user)->put(route('cart.update', $cartItem->id), [
            'action' => 'increase',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('cart_items', [
            'id' => $cartItem->id,
            'quantity' => 2,
        ]);
    }

    public function test_user_can_remove_cart_item()
    {
        $user = User::factory()->create();
        $cart = Cart::create(['user_id' => $user->id]);
        $category = Category::create(['name' => 'Cat', 'slug' => 'cat']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Test Product',
            'slug' => 'test-product',
            'description' => 'Desc',
            'product_type' => 'digital',
            'price' => 10000,
        ]);
        ProductStock::create(['product_id' => $product->id, 'content' => 'Data', 'status' => 'available']);
        ProductStock::create(['product_id' => $product->id, 'content' => 'Data2', 'status' => 'available']);
        $cartItem = CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response = $this->actingAs($user)->delete(route('cart.destroy', $cartItem->id));

        $response->assertRedirect();
        $this->assertDatabaseMissing('cart_items', [
            'id' => $cartItem->id,
        ]);
    }
}
