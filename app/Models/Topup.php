<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topup extends Model
{
    protected $fillable = [
        'user_id',
        'reference_id',
        'amount',
        'payment_method',
        'payment_status',
        'qr_string',
        'qr_code_url',
        'payload',
        'expired_at',
    ];

    protected function casts(): array
    {
        return [
            'payload' => 'array',
            'expired_at' => 'datetime',
            'amount' => 'integer',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isPending(): bool
    {
        return $this->payment_status === 'pending';
    }

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    public function isExpired(): bool
    {
        return $this->payment_status === 'expired' || 
               ($this->expired_at && $this->expired_at->isPast());
    }
}
