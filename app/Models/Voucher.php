<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'valid_until',
        'is_active',
    ];

    protected $casts = [
        'valid_until' => 'date',
        'is_active' => 'boolean',
    ];

    public function isExpired(): bool
    {
        if (! $this->expires_at && ! $this->valid_until && ! $this->masa_berlaku) {
            return false;
        }

        $expiryDate = $this->expires_at ?? $this->valid_until ?? $this->masa_berlaku;

        return Carbon::parse($expiryDate)->endOfDay()->isPast();
    }
}
