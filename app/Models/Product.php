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
        'login_instructions',
        'duration_label',
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

    /**
     * Relasi One-to-Many ke ProductStock (Daftar Akun Premium)
     */
    public function productStocks()
    {
        return $this->hasMany(ProductStock::class);
    }

    /**
     * Accessor untuk mendapatkan S&K mutlak dari Kategori / Aplikasi induknya
     */
    public function getTermsAttribute()
    {
        return $this->category ? $this->category->default_snk : null;
    }

    /**
     * Accessor lama (bisa dihapus atau dibiarkan untuk fallback legacy)
     */
    public function getResolvedSnkAttribute()
    {
        return $this->terms_and_conditions ?: $this->terms;
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getAverageRatingAttribute(): float
    {
        // Cek apakah relasi reviews ada dan hitung rata-rata langsung
        $avg = $this->reviews()->avg('rating');

        return (float) ($avg ? round($avg, 1) : 0.0);
    }

    public function getReviewsCountAttribute(): int
    {
        return (int) $this->reviews()->count();
    }
}
