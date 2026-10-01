<x-customer-layout>
    <x-slot name="header">
        Profil Saya
    </x-slot>

    <div class="space-y-6">
        <!-- Flash Messages -->
        @if (session('success'))
            <div class="mb-4 rounded-2xl border-2 border-dashed border-emerald-300 bg-mint p-4 text-sm font-bold text-emerald-700" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 rounded-2xl border-2 border-dashed border-brand-300 bg-brand-100 p-4 text-sm font-bold text-rose-700" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            <!-- Left Column: Profile Info & Stats -->
            <div class="space-y-6">
                <!-- Profile Header Card -->
                <div class="cute-card flex flex-col items-center p-6 text-center">
                    @if (auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="mb-4 h-24 w-24 rounded-full border-4 border-white object-cover shadow-sticker-sm ring-4 ring-brand-100">
                    @else
                        <div class="mb-4 flex h-24 w-24 items-center justify-center rounded-full border-4 border-white bg-gradient-to-br from-brand-300 to-brand-500 font-display text-4xl font-bold text-white ring-4 ring-brand-100">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    @endif
                    <h2 class="text-xl font-bold">{{ auth()->user()->name }}</h2>
                    <p class="mb-4 text-mauve">{{ auth()->user()->email }}</p>
                    <div class="flex space-x-2">
                        <span class="cute-pill">Customer</span>
                    </div>
                    <div class="mt-4 text-sm text-mauve">
                        Bergabung Sejak {{ auth()->user()->created_at->format('d M Y') }}
                    </div>
                </div>

                <!-- Account Stats Card -->
                <div class="cute-card p-6">
                    <h3 class="mb-4 text-lg font-semibold">Statistik Akun</h3>
                    <ul class="space-y-4">
                        <li class="flex items-center justify-between">
                            <span class="text-mauve">Total Pesanan</span>
                            <span class="font-bold">{{ auth()->user()->orders ? auth()->user()->orders()->count() : 0 }}</span>
                        </li>
                        <li class="flex items-center justify-between">
                            <span class="text-mauve">Bergabung Sejak</span>
                            <span class="font-bold">{{ auth()->user()->created_at->format('d M Y') }}</span>
                        </li>
                        <li class="flex items-center justify-between">
                            <span class="text-mauve">Status Akun</span>
                            <span class="rounded-full border-2 border-emerald-200 bg-mint px-3 py-0.5 text-xs font-bold text-emerald-700">Aktif</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Right Column: Forms -->
            <div class="space-y-6 md:col-span-2">
                <!-- Update Profile Form Card -->
                <div class="cute-card p-6">
                    <h3 class="mb-6 text-lg font-semibold">Informasi Profil</h3>

                    <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="space-y-6">
                            <!-- Avatar Upload -->
                            <div x-data="{ preview: null }">
                                <label class="cute-label">Foto Profil</label>
                                <div class="flex items-center space-x-4">
                                    <div class="shrink-0">
                                        <img x-show="preview" :src="preview" class="h-20 w-20 rounded-full border-2 border-brand-100 object-cover" style="display: none;">
                                        @if (auth()->user()->avatar)
                                            <img x-show="!preview" src="{{ asset('storage/' . auth()->user()->avatar) }}" class="h-20 w-20 rounded-full border-2 border-brand-100 object-cover">
                                        @else
                                            <div x-show="!preview" class="flex h-20 w-20 items-center justify-center rounded-full border-2 border-brand-100 bg-brand-100 font-display text-3xl font-bold text-brand-600">
                                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <label class="block">
                                        <span class="sr-only">Pilih foto profil</span>
                                        <input type="file" name="avatar" accept="image/*" @change="preview = URL.createObjectURL($event.target.files[0])"
                                            class="block w-full cursor-pointer text-sm text-mauve
                                            file:mr-4 file:cursor-pointer file:rounded-full file:border-0
                                            file:bg-brand-100 file:px-5 file:py-2.5
                                            file:text-sm file:font-bold file:text-brand-600
                                            hover:file:bg-brand-200
                                            "/>
                                    </label>
                                </div>
                                @error('avatar')
                                    <p class="mt-1 text-sm font-semibold text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Name -->
                            <div>
                                <label for="name" class="cute-label">Nama Lengkap</label>
                                <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" required
                                    class="cute-input">
                                @error('name')
                                    <p class="mt-1 text-sm font-semibold text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="cute-label">Email</label>
                                <input type="email" id="email" value="{{ auth()->user()->email }}" disabled readonly
                                    class="cute-input cursor-not-allowed bg-brand-50 text-mauve opacity-80 focus:ring-0">
                                <p class="cute-hint">Email tidak dapat diubah di sini.</p>
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="cute-label">Nomor Telepon</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone', auth()->user()->phone) }}" placeholder="08xxxxxxxxxx"
                                    class="cute-input">
                                @error('phone')
                                    <p class="mt-1 text-sm font-semibold text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit -->
                            <div class="flex justify-end">
                                <button type="submit" class="cute-btn cute-btn-primary px-8 py-2.5 text-sm">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Change Password Section -->
                <div class="cute-card p-6">
                    <h3 class="mb-2 text-lg font-semibold">Keamanan Akun 🔒</h3>
                    <p class="mb-6 text-mauve">Untuk mengubah password atau menghapus akun, silakan kunjungi halaman pengaturan akun.</p>

                    <a href="{{ route('profile.edit') }}" class="cute-btn cute-btn-ghost px-6 py-2.5 text-sm">
                        Ubah Password & Pengaturan Akun
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-customer-layout>