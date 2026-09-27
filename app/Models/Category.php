<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * Kolom yang diizinkan untuk diisi secara massal (mass assignment).
     */
    protected $fillable = [
        'name',
        'slug',
        'icon',
    ];

    /**
     * Relasi One-to-Many: Satu kategori memiliki banyak produk.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}