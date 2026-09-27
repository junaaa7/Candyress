<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * Kolom yang diizinkan untuk diisi secara massal (mass assignment).
     */
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'discount_price',
        'thumbnail',
        'banner',
        'duration',
        'product_type',
        'stock',
        'is_active',
        'rating',
        'sold',
        'features',
        'usage_instructions',
        'terms_and_conditions',
    ];

    /**
     * Relasi Belongs-To: Banyak produk dimiliki oleh satu kategori.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}