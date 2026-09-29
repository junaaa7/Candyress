<x-customer-layout>
    <x-slot name="title">Saldo & Top-Up</x-slot>
    <x-slot name="header">Saldo & Top-Up</x-slot>

    <div class="space-y-6">
        {{-- Balance Card --}}
        <div class="bg-gradient-to-r from-brand-600 to-brand-700 rounded-2xl p-6 sm:p-8 text-white shadow-lg relative overflow-hidden">
            <div class="absolute -top-12 -right-12 w-48 h-48 bg-white/5 rounded-full"></div>
            <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-white/5 rounded-full"></div>
            <div class="relative">
                <p class="text-brand-100 text-sm font-medium mb-1">Saldo Anda</p>
                <p class="text-3xl sm:text-4xl font-extrabold tracking-tight">Rp {{ number_format($user->balance, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- Pending Top-Up Alert --}}
        @if($pendingTopup)
            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-amber-800">Top-up sedang menunggu pembayaran</p>
                        <p class="text-xs text-amber-600">{{ $pendingTopup->reference_id }} — Rp {{ number_format($pendingTopup->amount, 0, ',', '.') }}</p>
                    </div>
                </div>
                <a href="{{ route('customer.topup.show', $pendingTopup->reference_id) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white text-sm font-semibold rounded-xl transition shadow-sm">
                    Bayar Sekarang
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                </a>
            </div>
        @endif

        {{-- Top-Up Form --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-1">Top-Up Saldo via QRIS</h3>
            <p class="text-sm text-gray-500 mb-6">Pilih nominal atau masukkan jumlah custom, lalu bayar menggunakan QRIS.</p>

            <form method="POST" action="{{ route('customer.topup.store') }}" x-data="{ amount: '' }">
                @csrf

                {{-- Preset Buttons --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-5">
                    @foreach([10000, 25000, 50000, 100000, 150000, 200000, 500000, 1000000] as $preset)
                        <button type="button"
                                @click="amount = {{ $preset }}; $refs.amountInput.value = {{ $preset }}"
                                :class="amount == {{ $preset }} ? 'border-brand-500 bg-brand-50 text-brand-700 ring-2 ring-brand-500/20' : 'border-gray-200 text-gray-700 hover:border-brand-300 hover:bg-gray-50'"
                                class="px-4 py-3 rounded-xl border text-sm font-semibold transition-all text-center">
                            Rp {{ number_format($preset, 0, ',', '.') }}
                        </button>
                    @endforeach
                </div>

                {{-- Custom Input --}}
                <div class="mb-6">
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">Nominal Custom (Rp)</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 font-semibold text-sm">Rp</span>
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
                               class="w-full pl-12 pr-4 py-3 text-lg font-semibold border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition" />
                    </div>
                    @error('amount')
                        <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl transition shadow-md hover:shadow-lg text-base">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z" />
                    </svg>
                    Buat QRIS & Bayar
                </button>
            </form>
        </div>

        {{-- Transaction History --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-900">Riwayat Mutasi Saldo</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-sm">
                            <th class="px-6 py-4 font-medium">Tanggal</th>
                            <th class="px-6 py-4 font-medium">Tipe</th>
                            <th class="px-6 py-4 font-medium">Keterangan</th>
                            <th class="px-6 py-4 font-medium text-right">Nominal</th>
                            <th class="px-6 py-4 font-medium text-right">Saldo</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($transactions as $tx)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $tx->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($tx->isCredit())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                            + Masuk
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                            − Keluar
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $tx->description ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-right {{ $tx->isCredit() ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $tx->isCredit() ? '+' : '-' }} Rp {{ number_format($tx->amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 text-right">
                                    Rp {{ number_format($tx->balance_after, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                            <svg class="w-7 h-7 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                                            </svg>
                                        </div>
                                        <p class="text-gray-500 text-sm">Belum ada mutasi saldo.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($transactions->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>
</x-customer-layout>
