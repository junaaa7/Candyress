<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads_correctly()
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
    }

    public function test_product_show_page_loads_correctly()
    {
        $category = Category::create(['name' => 'Cat', 'slug' => 'cat']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Store Product',
            'slug' => 'store-product',
            'description' => 'Desc',
            'product_type' => 'digital',
            'price' => 15000,
            'is_active' => true,
        ]);

        $response = $this->get(route('product.show', $product->slug));

        $response->assertStatus(200);
    }
}
