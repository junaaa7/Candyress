<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi Many-to-Many ke Order melalui tabel order_items
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }
}