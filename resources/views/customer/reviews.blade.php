<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-display text-xl font-semibold leading-tight">
            {{ __('Ulasan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="mb-6 rounded-2xl border-2 border-dashed border-emerald-300 bg-mint p-4 font-bold text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 rounded-2xl border-2 border-dashed border-brand-300 bg-brand-100 p-4 font-bold text-rose-700">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Write Review Section --}}
            @if ($reviewableProducts->isNotEmpty())
                <div class="cute-card mb-8 p-6">
                    <h3 class="mb-1 text-xl font-semibold">✍️ Tulis Review Baru</h3>
                    <p class="mb-6 text-sm text-mauve">Beri ulasan untuk produk yang sudah Anda beli</p>

                    <form action="{{ route('customer.reviews.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="product_id" class="cute-label">Produk</label>
                            <select name="product_id" id="product_id" class="cute-select" required>
                                <option value="">Pilih Produk...</option>
                                @foreach ($reviewableProducts as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <p class="mt-1 text-sm font-semibold text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="cute-label">Penilaian</label>
                            <div x-data="{ rating: {{ old('rating', 0) }} }">
                                <input type="hidden" name="rating" x-bind:value="rating">
                                <div class="flex gap-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button type="button" @click="rating = {{ $i }}"
                                            :class="rating >= {{ $i }} ? 'text-amber-400' : 'text-brand-200'"
                                            class="text-3xl focus:outline-none transition hover:scale-110">
                                            ★
                                        </button>
                                    @endfor
                                </div>
                            </div>
                            @error('rating')
                                <p class="mt-1 text-sm font-semibold text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="comment" class="cute-label">Komentar</label>
                            <textarea name="comment" id="comment" rows="4" class="cute-input resize-y" placeholder="Ceritakan pengalaman Anda..." required>{{ old('comment') }}</textarea>
                            @error('comment')
                                <p class="mt-1 text-sm font-semibold text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="cute-btn cute-btn-primary px-8 py-2.5 text-sm">
                                Kirim Review
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            {{-- My Reviews List --}}
            <div class="mb-6">
                <h3 class="text-xl font-semibold">📝 Ulasan Saya</h3>
            </div>

            @forelse ($reviews as $review)
                <div class="cute-card mb-4 p-6">
                    <div class="flex items-start gap-4">
                        @if ($review->product->thumbnail)
                            <img src="{{ Storage::url($review->product->thumbnail) }}" alt="{{ $review->product->name }}" class="h-16 w-16 rounded-2xl border-2 border-brand-100 object-cover">
                        @else
                            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-brand-100 text-brand-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif

                        <div class="flex-1">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h4 class="font-bold">{{ $review->product->name }}</h4>
                                    <div class="mt-1 flex gap-1 text-sm text-amber-400">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $review->rating)
                                                <span>★</span>
                                            @else
                                                <span class="text-brand-200">★</span>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-mauve">{{ $review->created_at->format('d M Y') }}</p>
                                    <div class="mt-2">
                                        @if ($review->is_visible)
                                            <span class="inline-flex items-center rounded-full border-2 border-emerald-200 bg-mint px-3 py-0.5 text-xs font-bold text-emerald-700">
                                                Ditampilkan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-full border-2 border-brand-200 bg-brand-50 px-3 py-0.5 text-xs font-bold text-mauve">
                                                Disembunyikan
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <p>{{ $review->comment }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="cute-card p-12 text-center">
                    <div class="mb-4 inline-flex h-16 w-16 items-center justify-center rounded-full bg-brand-100 text-brand-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <h3 class="mb-1 text-lg font-semibold">Belum ada ulasan</h3>
                    <p class="text-mauve">Anda belum menulis ulasan apapun.</p>
                </div>
            @endforelse

            {{-- Pagination --}}
            @if ($reviews->hasPages())
                <div class="mt-6">
                    {{ $reviews->links() }}
                </div>
            @endif

        </div>
    </div>
</x-customer-layout>
