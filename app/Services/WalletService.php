<?php

namespace App\Services;

use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;

class WalletService
{
    /**
     * Credit (add) balance to user wallet — atomic with lockForUpdate.
     */
    public function credit(User $user, int $amount, string $description, ?string $referenceType = null, ?int $referenceId = null): WalletTransaction
    {
        return DB::transaction(function () use ($user, $amount, $description, $referenceType, $referenceId) {
            // Lock the user row to prevent concurrent balance changes
            $lockedUser = User::lockForUpdate()->find($user->id);

            $balanceBefore = $lockedUser->balance;
            $balanceAfter = $balanceBefore + $amount;

            $lockedUser->update(['balance' => $balanceAfter]);

            return WalletTransaction::create([
                'user_id' => $lockedUser->id,
                'type' => 'credit',
                'reference_type' => $referenceType,
                'reference_id' => $referenceId,
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'description' => $description,
            ]);
        });
    }

    /**
     * Debit (subtract) balance from user wallet — atomic with lockForUpdate.
     * Throws exception if insufficient balance.
     */
    public function debit(User $user, int $amount, string $description, ?string $referenceType = null, ?int $referenceId = null): WalletTransaction
    {
        return DB::transaction(function () use ($user, $amount, $description, $referenceType, $referenceId) {
            $lockedUser = User::lockForUpdate()->find($user->id);

            if ($lockedUser->balance < $amount) {
                throw new \App\Exceptions\InsufficientBalanceException(
                    'Saldo tidak mencukupi. Saldo saat ini: Rp ' . number_format($lockedUser->balance, 0, ',', '.')
                );
            }

            $balanceBefore = $lockedUser->balance;
            $balanceAfter = $balanceBefore - $amount;

            $lockedUser->update(['balance' => $balanceAfter]);

            return WalletTransaction::create([
                'user_id' => $lockedUser->id,
                'type' => 'debit',
                'reference_type' => $referenceType,
                'reference_id' => $referenceId,
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'description' => $description,
            ]);
        });
    }

    /**
     * Check if user has enough balance.
     */
    public function hasSufficientBalance(User $user, int $amount): bool
    {
        return $user->balance >= $amount;
    }
}
