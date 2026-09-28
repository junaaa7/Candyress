<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Mengubah 'total_amount' menjadi 'total_price' dan 'account_credentials' menjadi 'payment_method' sesuai migration Anda
    protected $fillable = ['user_id', 'order_number', 'total_price', 'status', 'payment_method'];

    public function items() {
        return $this->hasMany(OrderItem::class);
    }
    public function payment() {
        return $this->hasOne(Payment::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Relasi balik ke produk
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }
}