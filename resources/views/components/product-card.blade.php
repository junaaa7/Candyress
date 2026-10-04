@props(['name', 'category', 'price', 'discountPrice' => null, 'rating' => '5.0', 'sold' => 0, 'image' => null, 'detailUrl' => '#'])

<div class="cute-card cute-lift group flex h-full flex-col overflow-hidden">
    <!-- Thumbnail -->
    <a href="{{ $detailUrl }}" class="relative block aspect-video overflow-hidden bg-brand-50">
        @if($image)
            <img src="{{ $image }}" alt="{{ $name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        @else
            <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-brand-100 to-accent-100 font-display text-2xl font-bold text-brand-600">
                {{ substr($name, 0, 1) }}
            </div>
        @endif

        <div class="absolute top-3 left-3">
            <span class="cute-pill bg-white/90 backdrop-blur-sm">{{ $category }}</span>
        </div>

        @if($discountPrice)
            <div class="absolute top-3 right-3">
                <span class="rounded-full border-2 border-white bg-brand-600 px-3 py-1 text-xs font-bold text-white shadow-sm">Promo</span>
            </div>
        @endif
    </a>

    <!-- Content -->
    <div class="p-5 flex flex-col flex-grow">
        <a href="{{ $detailUrl }}">
            <h3 class="mb-1 line-clamp-1 text-lg font-bold transition-colors group-hover:text-brand-600">{{ $name }}</h3>
        </a>

        <div class="mb-4 flex items-center gap-2 text-sm text-mauve">
            <div class="flex items-center text-amber-400">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                <span class="ml-1 font-bold text-brand-900">{{ $rating }}</span>
            </div>
            <span>•</span>
            <span>Terjual {{ $sold }}</span>
        </div>

        <div class="mt-auto">
            <div class="flex flex-col mb-4">
                @if($discountPrice)
                    <span class="text-sm text-mauve/70 line-through">Rp {{ number_format($price, 0, ',', '.') }}</span>
                    <span class="font-display text-xl font-bold text-brand-600">Rp {{ number_format($discountPrice, 0, ',', '.') }}</span>
                @else
                    <span class="font-display text-xl font-bold text-brand-600">Rp {{ number_format($price, 0, ',', '.') }}</span>
                @endif
            </div>

            <div class="flex gap-2">
                <a href="{{ $detailUrl }}" class="cute-btn cute-btn-ghost flex-1 px-4 py-2 text-sm">Detail</a>
                <a href="{{ $detailUrl }}" class="cute-btn cute-btn-primary flex-1 px-4 py-2 text-sm">Beli</a>
            </div>
        </div>
    </div>
</div>
