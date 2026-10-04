<x-customer-layout>
    <x-slot name="title">Katalog Produk</x-slot>
    <x-slot name="header">Katalog Produk</x-slot>

    <div class="space-y-6">
        {{-- Search & Filter Bar --}}
        <div class="cute-card p-4 sm:p-5">
            <form method="GET" action="{{ route('customer.products.index') }}" class="flex flex-col gap-3 sm:flex-row">
                {{-- Search Input --}}
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-brand-300">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </span>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari produk digital..."
                           class="cute-input py-2.5 pl-11 pr-4 text-sm" />
                </div>

                {{-- Category Filter --}}
                <select name="category"
                        class="cute-select py-2.5 text-sm sm:w-48">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>

                {{-- Submit --}}
                <button type="submit"
                        class="cute-btn cute-btn-primary px-5 py-2.5 text-sm">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                    </svg>
                    Filter
                </button>

                @if(request('search') || request('category'))
                    <a href="{{ route('customer.products.index') }}"
                       class="cute-btn cute-btn-ghost px-4 py-2.5 text-sm">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        {{-- Active Filters Info --}}
        @if(request('search') || request('category'))
            <div class="flex items-center gap-2 text-sm text-mauve">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                </svg>
                <span>
                    Menampilkan {{ $products->total() }} produk
                    @if(request('search')) untuk "<strong>{{ request('search') }}</strong>" @endif
                    @if(request('category'))
                        @php $catName = $categories->firstWhere('id', request('category'))?->name @endphp
                        @if($catName) di kategori <strong>{{ $catName }}</strong> @endif
                    @endif
                </span>
            </div>
        @endif

        {{-- Product Grid --}}
        @if($products->count())
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($products as $product)
                    <a href="{{ route('product.show', $product->slug) }}"
                       class="cute-card cute-lift group flex flex-col overflow-hidden">
                        {{-- Thumbnail --}}
                        <div class="relative aspect-video overflow-hidden bg-brand-50">
                            @if($product->thumbnail)
                                <img src="{{ asset('storage/' . $product->thumbnail) }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                            @else
                                <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-brand-100 to-accent-100">
                                    <span class="font-display text-4xl font-bold text-brand-600 opacity-70">{{ strtoupper(substr($product->name, 0, 1)) }}</span>
                                </div>
                            @endif

                            {{-- Category Badge --}}
                            <span class="cute-pill absolute left-3 top-3 bg-white/90 backdrop-blur-sm">
                                {{ $product->category->name ?? '-' }}
                            </span>

                            @if($product->discount_price)
                                <span class="absolute right-3 top-3 rounded-full border-2 border-white bg-brand-600 px-3 py-0.5 text-xs font-bold text-white shadow-sm">Promo</span>
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="flex flex-grow flex-col p-5">
                            <h3 class="mb-1 line-clamp-1 text-base font-bold transition-colors group-hover:text-brand-600">
                                {{ $product->name }}
                            </h3>

                            <div class="mb-3 flex items-center gap-1.5 text-xs text-mauve flex-wrap">
                                <div class="flex items-center text-amber-400">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <span class="ml-1 font-bold text-brand-900">{{ $product->rating }}</span>
                                </div>
                                <span>•</span>
                                <span>Terjual {{ $product->sold }}</span>
                                <span>&bull;</span>
                                @if($product->available_stock_count > 0)
                                    <span class="text-green-600 font-semibold text-xs bg-green-50 px-1.5 py-0.5 rounded">Stok: {{ $product->available_stock_count }}</span>
                                @else
                                    <span class="text-rose-500 font-semibold text-xs bg-rose-50 px-1.5 py-0.5 rounded">Habis</span>
                                @endif
                            </div>

                            <div class="mt-auto flex items-end justify-between">
                                <div>
                                    @if($product->discount_price)
                                        <span class="block text-xs text-mauve/70 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        <span class="font-display text-lg font-bold text-brand-600">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                                    @else
                                        <span class="font-display text-lg font-bold text-brand-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    @endif
                                </div>
                                <span class="inline-flex items-center gap-1 text-xs font-bold text-brand-600 transition-colors group-hover:text-brand-700">
                                    Lihat
                                    <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        @else
            <div class="cute-card py-16 text-center">
                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-brand-100">
                    <svg class="w-8 h-8 text-brand-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                </div>
                <h3 class="mb-1 text-lg font-semibold">Produk tidak ditemukan</h3>
                <p class="text-sm text-mauve">Coba ubah kata kunci pencarian atau filter kategori.</p>
            </div>
        @endif
    </div>
</x-customer-layout>
