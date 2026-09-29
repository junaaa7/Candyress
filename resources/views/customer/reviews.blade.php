<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ulasan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-200 text-green-700 rounded-2xl">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 bg-red-100 border border-red-200 text-red-700 rounded-2xl">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Write Review Section --}}
            @if ($reviewableProducts->isNotEmpty())
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm mb-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-1">✍️ Tulis Review Baru</h3>
                    <p class="text-sm text-gray-500 mb-6">Beri ulasan untuk produk yang sudah Anda beli</p>

                    <form action="{{ route('customer.reviews.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="product_id" class="block text-sm font-medium text-gray-700 mb-1">Produk</label>
                            <select name="product_id" id="product_id" class="w-full border-gray-300 rounded-xl shadow-sm focus:border-brand-500 focus:ring-brand-500" required>
                                <option value="">Pilih Produk...</option>
                                @foreach ($reviewableProducts as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Penilaian</label>
                            <div x-data="{ rating: {{ old('rating', 0) }} }">
                                <input type="hidden" name="rating" x-bind:value="rating">
                                <div class="flex gap-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button type="button" @click="rating = {{ $i }}" 
                                            :class="rating >= {{ $i }} ? 'text-yellow-400' : 'text-gray-300'"
                                            class="text-3xl focus:outline-none transition">
                                            ★
                                        </button>
                                    @endfor
                                </div>
                            </div>
                            @error('rating')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">Komentar</label>
                            <textarea name="comment" id="comment" rows="4" class="w-full border-gray-300 rounded-xl shadow-sm focus:border-brand-500 focus:ring-brand-500" placeholder="Ceritakan pengalaman Anda..." required>{{ old('comment') }}</textarea>
                            @error('comment')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-brand-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-brand-700 focus:bg-brand-700 active:bg-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Kirim Review
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            {{-- My Reviews List --}}
            <div class="mb-6">
                <h3 class="text-xl font-bold text-gray-800">📝 Ulasan Saya</h3>
            </div>

            @forelse ($reviews as $review)
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm mb-4">
                    <div class="flex items-start gap-4">
                        @if ($review->product->thumbnail)
                            <img src="{{ Storage::url($review->product->thumbnail) }}" alt="{{ $review->product->name }}" class="w-16 h-16 object-cover rounded-xl border border-gray-100">
                        @else
                            <div class="w-16 h-16 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif

                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-bold text-gray-900">{{ $review->product->name }}</h4>
                                    <div class="flex gap-1 mt-1 text-sm text-yellow-400">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $review->rating)
                                                <span>★</span>
                                            @else
                                                <span class="text-gray-300">★</span>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-500">{{ $review->created_at->format('d M Y') }}</p>
                                    <div class="mt-2">
                                        @if ($review->is_visible)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                                Ditampilkan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
                                                Disembunyikan
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4 text-gray-600">
                                <p>{{ $review->comment }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl p-12 border border-gray-100 shadow-sm text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 text-gray-400 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">Belum ada ulasan</h3>
                    <p class="text-gray-500">Anda belum menulis ulasan apapun.</p>
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
