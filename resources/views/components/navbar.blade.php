<nav class="bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="/" class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-brand-600 to-accent-500 tracking-tight">
                    Candyress.
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex space-x-8 items-center">
                <a href="/" class="text-sm font-medium text-gray-700 hover:text-brand-600 transition">Home</a>
                <a href="#" class="text-sm font-medium text-gray-700 hover:text-brand-600 transition">Produk</a>
                <a href="#" class="text-sm font-medium text-gray-700 hover:text-brand-600 transition">Kategori</a>
                
                <div class="flex items-center space-x-4 border-l pl-4 border-gray-200">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-brand-600">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-700">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-brand-600">Login</a>
                        <a href="{{ route('register') }}" class="bg-brand-600 hover:bg-brand-700 text-white px-4 py-2 rounded-full text-sm font-semibold transition shadow-sm hover:shadow-md">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>