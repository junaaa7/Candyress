<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PremiumAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'email',
        'password',
        'status', 
        'expired_at' // Kolom baru untuk masa berlaku
    ];

    protected $casts = [
        'expired_at' => 'date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}