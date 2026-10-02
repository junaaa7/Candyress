<x-customer-layout>
    <x-slot name="header">
        Saldo & Top Up
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Saldo Card --}}
            <div class="cute-card overflow-hidden bg-gradient-to-br from-brand-500 to-brand-600 p-7 text-white shadow-xl shadow-brand-500/25">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-brand-100">Saldo Anda Saat Ini</p>
                        <p class="mt-1 font-display text-4xl font-bold tracking-tight">Rp {{ number_format(auth()->user()->balance, 0, ',', '.') }}</p>
                    </div>
                    <div class="rounded-2xl bg-white/15 p-4 backdrop-blur-sm">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

                {{-- Form Top Up --}}
                <div class="lg:col-span-1">
                    <div class="cute-card overflow-hidden">
                        <div class="border-b-2 border-dashed border-brand-100 bg-brand-100/60 px-6 py-5">
                            <h3 class="text-lg font-semibold">Top Up Saldo 💰</h3>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('customer.topup.store') }}" method="POST">
                                @csrf

                                <div class="mb-5 grid grid-cols-2 gap-2.5" x-data="{ selected: null }">
                                    @foreach([10000, 25000, 50000, 100000, 200000, 500000] as $preset)
                                        <button type="button"
                                            @click="selected = {{ $preset }}; document.getElementById('amount-input').value = {{ $preset }}"
                                            :class="selected === {{ $preset }} ? 'border-brand-500 bg-brand-50 ring-2 ring-brand-500 text-brand-700' : 'border-brand-100 bg-white text-mauve hover:border-brand-300'"
                                            class="rounded-xl border-2 px-3 py-2.5 text-sm font-bold transition-all">
                                            Rp {{ number_format($preset, 0, ',', '.') }}
                                        </button>
                                    @endforeach
                                </div>

                                <div class="mb-5">
                                    <label class="cute-label">Nominal Lainnya</label>
                                    <input type="number" id="amount-input" name="amount" min="10000" max="5000000" step="1000" placeholder="Masukkan nominal" class="cute-input" required>
                                    @error('amount')
                                        <p class="mt-2 text-sm font-semibold text-rose-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <button type="submit" class="cute-btn cute-btn-primary w-full py-3 text-sm">
                                    Lanjut ke Pembayaran
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Riwayat Top Up --}}
                <div class="lg:col-span-2">
                    <div class="cute-card overflow-hidden">
                        <div class="border-b-2 border-dashed border-brand-100 bg-brand-100/60 px-6 py-5">
                            <h3 class="text-lg font-semibold">Riwayat Top Up 📋</h3>
                        </div>
                        <div class="p-6">
                            @if($topups->isEmpty())
                                <div class="py-12 text-center">
                                    <div class="text-6xl mb-4">💳</div>
                                    <p class="text-mauve font-medium">Belum ada riwayat top up.</p>
                                    <p class="text-sm text-mauve/60 mt-1">Isi saldo Anda untuk mulai belanja!</p>
                                </div>
                            @else
                                <div class="space-y-3">
                                    @foreach($topups as $topup)
                                        <a href="{{ route('customer.topup.show', $topup->reference_id) }}"
                                           class="flex items-center justify-between rounded-2xl border-2 border-brand-100 bg-white px-5 py-4 transition-all hover:border-brand-300 hover:shadow-sm">
                                            <div>
                                                <p class="font-mono text-sm font-bold">#{{ $topup->reference_id }}</p>
                                                <p class="text-sm text-mauve">{{ $topup->created_at->format('d M Y, H:i') }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="font-bold text-brand-600">Rp {{ number_format($topup->amount, 0, ',', '.') }}</p>
                                                @if($topup->status === 'pending')
                                                    <span class="inline-flex items-center rounded-full border-2 border-amber-200 bg-amber-50 px-2.5 py-0.5 text-xs font-bold text-amber-700">Pending</span>
                                                @elseif($topup->status === 'waiting_confirmation')
                                                    <span class="inline-flex items-center rounded-full border-2 border-accent-200 bg-accent-100 px-2.5 py-0.5 text-xs font-bold text-purple-600">Menunggu Konfirmasi</span>
                                                @elseif($topup->status === 'approved')
                                                    <span class="inline-flex items-center rounded-full border-2 border-emerald-200 bg-mint px-2.5 py-0.5 text-xs font-bold text-emerald-700">Disetujui</span>
                                                @elseif($topup->status === 'rejected')
                                                    <span class="inline-flex items-center rounded-full border-2 border-brand-300 bg-brand-100 px-2.5 py-0.5 text-xs font-bold text-rose-600">Ditolak</span>
                                                @endif
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-customer-layout>
