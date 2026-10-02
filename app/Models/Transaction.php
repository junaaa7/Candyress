<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'stock_id', // Nanti akan diisi ID dari tabel stocks jika sudah lunas
        'unique_code', // Kode unik (contoh: 123)
        'total_amount', // Harga + Kode Unik
        'status', // PENDING, PAID, FAILED
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
