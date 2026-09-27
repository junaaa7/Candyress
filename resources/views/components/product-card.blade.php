@props(['name', 'category', 'price', 'discountPrice' => null, 'rating' => '5.0', 'sold' => 0, 'image' => null, 'detailUrl' => '#'])

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 group flex flex-col h-full">
    <!-- Thumbnail -->
    <a href="{{ $detailUrl }}" class="relative aspect-video bg-gray-50 overflow-hidden block">
        @if($image)
            <img src="{{ $image }}" alt="{{ $name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        @else
            <div class="w-full h-full bg-gradient-to-br from-brand-100 to-accent-100 flex items-center justify-center text-brand-600 font-bold text-2xl">
                {{ substr($name, 0, 1) }}
            </div>
        @endif
        
        <div class="absolute top-3 left-3">
            <span class="bg-white/90 backdrop-blur-sm text-brand-700 text-xs font-semibold px-2.5 py-1 rounded-lg">{{ $category }}</span>
        </div>

        @if($discountPrice)
            <div class="absolute top-3 right-3">
                <span class="bg-red-500/90 backdrop-blur-sm text-white text-xs font-bold px-2 py-1 rounded-lg shadow-sm">Promo</span>
            </div>
        @endif
    </a>

    <!-- Content -->
    <div class="p-5 flex flex-col flex-grow">
        <a href="{{ $detailUrl }}">
            <h3 class="text-lg font-bold text-brand-900 mb-1 group-hover:text-brand-600 transition-colors line-clamp-1">{{ $name }}</h3>
        </a>
        
        <div class="flex items-center gap-2 mb-4 text-sm text-gray-500">
            <div class="flex items-center text-yellow-400">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                <span class="ml-1 font-medium text-gray-700">{{ $rating }}</span>
            </div>
            <span>•</span>
            <span>Terjual {{ $sold }}</span>
        </div>

        <div class="mt-auto">
            <div class="flex flex-col mb-4">
                @if($discountPrice)
                    <span class="text-sm text-gray-400 line-through">Rp {{ number_format($price, 0, ',', '.') }}</span>
                    <span class="text-xl font-bold text-brand-600">Rp {{ number_format($discountPrice, 0, ',', '.') }}</span>
                @else
                    <span class="text-xl font-bold text-brand-600">Rp {{ number_format($price, 0, ',', '.') }}</span>
                @endif
            </div>

            <div class="flex gap-2">
                <a href="{{ $detailUrl }}" class="flex-1 text-center bg-brand-50 hover:bg-brand-100 text-brand-700 font-semibold py-2.5 rounded-xl transition-colors text-sm">Detail</a>
                <a href="{{ $detailUrl }}" class="flex-1 text-center bg-brand-600 hover:bg-brand-700 text-white font-semibold py-2.5 rounded-xl transition-colors shadow-sm text-sm">Beli</a>
            </div>
        </div>
    </div>
</div>