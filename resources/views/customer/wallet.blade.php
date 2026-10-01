<x-customer-layout>
    <x-slot name="title">Saldo & Top-Up</x-slot>
    <x-slot name="header">Saldo & Top-Up</x-slot>

    <div class="space-y-6">
        {{-- Balance Card --}}
        <div class="relative overflow-hidden rounded-4xl bg-gradient-to-r from-brand-300 to-brand-500 p-6 text-white shadow-xl shadow-brand-600/20 sm:p-8">
            <div class="absolute -right-12 -top-12 h-48 w-48 rounded-full bg-white/15"></div>
            <div class="absolute -bottom-8 -left-8 h-32 w-32 rounded-full bg-white/10"></div>
            <div class="relative">
                <p class="mb-1 text-sm font-bold text-white/90">Saldo Anda 💰</p>
                <p class="font-display text-3xl font-bold tracking-tight sm:text-4xl">Rp {{ number_format($user->balance, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- Pending Top-Up Alert --}}
        @if($pendingTopup)
            <div class="flex flex-col items-start justify-between gap-4 rounded-2xl border-2 border-dashed border-amber-300 bg-amber-50 p-5 sm:flex-row sm:items-center">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-amber-100 text-amber-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-amber-800">Top-up sedang menunggu pembayaran</p>
                        <p class="text-xs text-amber-600">{{ $pendingTopup->reference_id }} — Rp {{ number_format($pendingTopup->amount, 0, ',', '.') }}</p>
                    </div>
                </div>
                <a href="{{ route('customer.topup.show', $pendingTopup->reference_id) }}" class="cute-btn cute-btn-primary px-5 py-2 text-sm">
                    Bayar Sekarang
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                </a>
            </div>
        @endif

        {{-- Top-Up Form --}}
        <div class="cute-card p-6">
            <h3 class="mb-1 text-lg font-semibold">Top-Up Saldo via QRIS</h3>
            <p class="mb-6 text-sm text-mauve">Pilih nominal atau masukkan jumlah custom, lalu bayar menggunakan QRIS.</p>

            <form method="POST" action="{{ route('customer.topup.store') }}" x-data="{ amount: '' }">
                @csrf

                {{-- Preset Buttons --}}
                <div class="mb-5 grid grid-cols-2 gap-3 sm:grid-cols-4">
                    @foreach([10000, 25000, 50000, 100000, 150000, 200000, 500000, 1000000] as $preset)
                        <button type="button"
                                @click="amount = {{ $preset }}; $refs.amountInput.value = {{ $preset }}"
                                :class="amount == {{ $preset }} ? 'border-brand-300 bg-brand-100 text-brand-600 ring-4 ring-brand-300/30' : 'border-brand-100 text-brand-900 hover:border-brand-300 hover:bg-brand-50'"
                                class="rounded-2xl border-2 px-4 py-3 text-center text-sm font-bold transition-all">
                            Rp {{ number_format($preset, 0, ',', '.') }}
                        </button>
                    @endforeach
                </div>

                {{-- Custom Input --}}
                <div class="mb-6">
                    <label for="amount" class="cute-label">Nominal Custom (Rp)</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-sm font-bold text-brand-300">Rp</span>
                        <input type="number"
                               name="amount"
                               id="amount"
                               x-ref="amountInput"
                               x-model="amount"
                               min="10000"
                               max="10000000"
                               step="1000"
                               placeholder="Min. 10.000"
                               required
                               class="cute-input py-3 pl-12 pr-4 text-lg font-bold" />
                    </div>
                    @error('amount')
                        <p class="mt-1.5 text-sm font-semibold text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="cute-btn cute-btn-primary w-full px-8 py-3.5 text-base sm:w-auto">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z" />
                    </svg>
                    Buat QRIS & Bayar
                </button>
            </form>
        </div>

        {{-- Transaction History --}}
        <div class="cute-card overflow-hidden">
            <div class="border-b-2 border-dashed border-brand-100 bg-brand-100/60 p-6">
                <h3 class="text-lg font-semibold">Riwayat Mutasi Saldo 📒</h3>
            </div>

            <div class="overflow-x-auto p-3">
                <table class="cute-table min-w-[40rem]">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Tipe</th>
                            <th>Keterangan</th>
                            <th class="text-right">Nominal</th>
                            <th class="text-right">Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $tx)
                            <tr>
                                <td class="text-mauve">
                                    {{ $tx->created_at->format('d M Y, H:i') }}
                                </td>
                                <td>
                                    @if($tx->isCredit())
                                        <span class="inline-flex items-center rounded-full border-2 border-emerald-200 bg-mint px-3 py-0.5 text-xs font-bold text-emerald-700">
                                            + Masuk
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full border-2 border-brand-300 bg-brand-100 px-3 py-0.5 text-xs font-bold text-rose-600">
                                            − Keluar
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    {{ $tx->description ?? '-' }}
                                </td>
                                <td class="text-right font-bold {{ $tx->isCredit() ? 'text-emerald-600' : 'text-rose-600' }}">
                                    {{ $tx->isCredit() ? '+' : '-' }} Rp {{ number_format($tx->amount, 0, ',', '.') }}
                                </td>
                                <td class="text-right font-bold">
                                    Rp {{ number_format($tx->balance_after, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="mb-3 flex h-14 w-14 items-center justify-center rounded-full bg-brand-100">
                                            <svg class="w-7 h-7 text-brand-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                                            </svg>
                                        </div>
                                        <p class="text-sm font-semibold text-mauve">Belum ada mutasi saldo.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($transactions->hasPages())
                <div class="border-t-2 border-dashed border-brand-100 px-6 py-4">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>
</x-customer-layout>