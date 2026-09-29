<x-customer-layout>
    <x-slot name="header">
        Profil Saya
    </x-slot>

    <div class="space-y-6">
        <!-- Flash Messages -->
        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-xl" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-xl" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Left Column: Profile Info & Stats -->
            <div class="space-y-6">
                <!-- Profile Header Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col items-center text-center">
                    @if (auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-sm mb-4">
                    @else
                        <div class="w-24 h-24 bg-brand-600 text-white rounded-full flex items-center justify-center text-4xl font-bold mb-4 shadow-sm">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    @endif
                    <h2 class="text-xl font-bold text-gray-900">{{ auth()->user()->name }}</h2>
                    <p class="text-gray-500 mb-4">{{ auth()->user()->email }}</p>
                    <div class="flex space-x-2">
                        <span class="px-3 py-1 bg-brand-100 text-brand-700 text-sm font-medium rounded-full">Customer</span>
                    </div>
                    <div class="mt-4 text-sm text-gray-500">
                        Bergabung Sejak {{ auth()->user()->created_at->format('d M Y') }}
                    </div>
                </div>

                <!-- Account Stats Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Statistik Akun</h3>
                    <ul class="space-y-4">
                        <li class="flex justify-between items-center">
                            <span class="text-gray-600">Total Pesanan</span>
                            <span class="font-bold text-gray-900">{{ auth()->user()->orders ? auth()->user()->orders()->count() : 0 }}</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span class="text-gray-600">Bergabung Sejak</span>
                            <span class="font-medium text-gray-900">{{ auth()->user()->created_at->format('d M Y') }}</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span class="text-gray-600">Status Akun</span>
                            <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">Aktif</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Right Column: Forms -->
            <div class="md:col-span-2 space-y-6">
                <!-- Update Profile Form Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Informasi Profil</h3>
                    
                    <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="space-y-6">
                            <!-- Avatar Upload -->
                            <div x-data="{ preview: null }">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Profil</label>
                                <div class="flex items-center space-x-4">
                                    <div class="shrink-0">
                                        <img x-show="preview" :src="preview" class="w-20 h-20 rounded-full object-cover border border-gray-200" style="display: none;">
                                        @if (auth()->user()->avatar)
                                            <img x-show="!preview" src="{{ asset('storage/' . auth()->user()->avatar) }}" class="w-20 h-20 rounded-full object-cover border border-gray-200">
                                        @else
                                            <div x-show="!preview" class="w-20 h-20 bg-brand-100 text-brand-600 rounded-full flex items-center justify-center text-3xl font-bold border border-gray-200">
                                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <label class="block">
                                        <span class="sr-only">Pilih foto profil</span>
                                        <input type="file" name="avatar" accept="image/*" @change="preview = URL.createObjectURL($event.target.files[0])"
                                            class="block w-full text-sm text-gray-500
                                            file:mr-4 file:py-2 file:px-4
                                            file:rounded-full file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-brand-50 file:text-brand-700
                                            hover:file:bg-brand-100 cursor-pointer
                                            "/>
                                    </label>
                                </div>
                                @error('avatar')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" required
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" id="email" value="{{ auth()->user()->email }}" disabled readonly
                                    class="w-full rounded-xl border-gray-200 bg-gray-50 shadow-sm text-gray-500 cursor-not-allowed focus:ring-0">
                                <p class="mt-1 text-xs text-gray-500">Email tidak dapat diubah di sini.</p>
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone', auth()->user()->phone) }}" placeholder="08xxxxxxxxxx"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit -->
                            <div class="flex justify-end">
                                <button type="submit" class="px-6 py-2 bg-brand-600 text-white font-medium rounded-xl hover:bg-brand-700 transition-colors shadow-sm">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Change Password Section -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Keamanan Akun</h3>
                    <p class="text-gray-600 mb-6">Untuk mengubah password atau menghapus akun, silakan kunjungi halaman pengaturan akun.</p>
                    
                    <a href="{{ route('profile.edit') }}" class="inline-flex items-center justify-center px-6 py-2 bg-gray-100 text-gray-700 border border-gray-200 font-medium rounded-xl hover:bg-gray-200 transition-colors shadow-sm">
                        Ubah Password & Pengaturan Akun
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-customer-layout>
