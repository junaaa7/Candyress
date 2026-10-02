<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TopUp;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopUpController extends Controller
{
    protected WalletService $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    public function index(Request $request)
    {
        $query = TopUp::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $topups = $query->latest()->paginate(15);

        return view('admin.topups.index', compact('topups'));
    }

    public function approve(TopUp $topUp)
    {
        if ($topUp->status !== 'waiting_confirmation') {
            return back()->with('error', 'Top Up tidak bisa disetujui.');
        }

        DB::transaction(function () use ($topUp) {
            $topUp->update(['status' => 'approved']);

            $this->walletService->credit(
                $topUp->user,
                $topUp->amount,
                'Top Up Saldo #'.$topUp->reference_id,
                'topup',
                $topUp->id
            );
        });

        return back()->with('success', 'Top Up berhasil disetujui.');
    }

    public function reject(Request $request, TopUp $topUp)
    {
        if (! in_array($topUp->status, ['waiting_confirmation', 'pending'])) {
            return back()->with('error', 'Top Up tidak bisa ditolak pada status saat ini.');
        }

        $request->validate([
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $topUp->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
        ]);

        return back()->with('success', 'Top Up berhasil ditolak.');
    }
}
