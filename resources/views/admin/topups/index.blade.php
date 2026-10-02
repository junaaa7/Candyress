<x-admin-layout>
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            Manajemen Top Up 💰
            <span class="bg-brand-100 text-brand-600 text-sm py-1 px-2 rounded-full">{{ $topups->total() }}</span>
        </h1>
    </div>

    <!-- Filter Tabs -->
    <div class="mb-6 flex flex-wrap gap-2">
        @php
            $currentStatus = request('status');
        @endphp
        <a href="{{ route('admin.topups.index') }}" class="cute-btn {{ !$currentStatus ? 'cute-btn-primary' : 'bg-white text-gray-600 border border-gray-200' }}">Semua</a>
        <a href="{{ route('admin.topups.index', ['status' => 'waiting_confirmation']) }}" class="cute-btn {{ $currentStatus === 'waiting_confirmation' ? 'cute-btn-primary' : 'bg-white text-gray-600 border border-gray-200' }}">Menunggu Konfirmasi</a>
        <a href="{{ route('admin.topups.index', ['status' => 'pending']) }}" class="cute-btn {{ $currentStatus === 'pending' ? 'cute-btn-primary' : 'bg-white text-gray-600 border border-gray-200' }}">Pending</a>
        <a href="{{ route('admin.topups.index', ['status' => 'approved']) }}" class="cute-btn {{ $currentStatus === 'approved' ? 'cute-btn-primary' : 'bg-white text-gray-600 border border-gray-200' }}">Disetujui</a>
        <a href="{{ route('admin.topups.index', ['status' => 'rejected']) }}" class="cute-btn {{ $currentStatus === 'rejected' ? 'cute-btn-primary' : 'bg-white text-gray-600 border border-gray-200' }}">Ditolak</a>
    </div>

    <div class="cute-card overflow-hidden">
        @if($topups->isEmpty())
            <div class="p-8 text-center text-gray-500">
                <div class="text-4xl mb-3">🥺</div>
                <p>Belum ada data Top Up yang ditemukan.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-brand-50/50 border-b border-brand-100 border-dashed">
                            <th class="p-4 font-semibold text-gray-700">Customer</th>
                            <th class="p-4 font-semibold text-gray-700">Referensi</th>
                            <th class="p-4 font-semibold text-gray-700">Nominal</th>
                            <th class="p-4 font-semibold text-gray-700">Bukti Transfer</th>
                            <th class="p-4 font-semibold text-gray-700">Status</th>
                            <th class="p-4 font-semibold text-gray-700">Tanggal</th>
                            <th class="p-4 font-semibold text-gray-700 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 border-dashed">
                        @foreach($topups as $topup)
                            <tr class="hover:bg-brand-50/30 transition-colors" x-data="{ showRejectModal: false }">
                                <td class="p-4">
                                    <div class="font-medium text-gray-800">{{ $topup->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $topup->user->email }}</div>
                                </td>
                                <td class="p-4">
                                    <span class="font-mono text-sm bg-gray-100 px-2 py-1 rounded text-gray-600">{{ $topup->reference_id }}</span>
                                </td>
                                <td class="p-4 font-bold text-gray-800">
                                    Rp {{ number_format($topup->amount, 0, ',', '.') }}
                                </td>
                                <td class="p-4">
                                    @if($topup->proof_image)
                                        <a href="{{ asset('storage/' . $topup->proof_image) }}" target="_blank" class="block w-16 h-16 border-2 border-dashed border-brand-200 rounded overflow-hidden hover:border-brand-400 transition-colors">
                                            <img src="{{ asset('storage/' . $topup->proof_image) }}" alt="Bukti" class="w-full h-full object-cover">
                                        </a>
                                    @else
                                        <span class="text-sm text-gray-400 italic">Belum ada</span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    @if($topup->status === 'pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">Pending</span>
                                    @elseif($topup->status === 'waiting_confirmation')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 border border-purple-200">Menunggu</span>
                                    @elseif($topup->status === 'approved')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">Disetujui</span>
                                    @elseif($topup->status === 'rejected')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-800 border border-rose-200">Ditolak</span>
                                    @endif
                                </td>
                                <td class="p-4 text-sm text-gray-600">
                                    {{ $topup->created_at->format('d M Y H:i') }}
                                </td>
                                <td class="p-4">
                                    <div class="flex flex-col gap-2 items-center">
                                        @if($topup->status === 'waiting_confirmation')
                                            <div class="flex gap-2 justify-center">
                                                <form action="{{ route('admin.topups.approve', $topup) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="cute-btn bg-emerald-500 hover:bg-emerald-600 text-white text-xs py-1 px-3">
                                                        Approve
                                                    </button>
                                                </form>
                                                <button type="button" @click="showRejectModal = !showRejectModal" class="cute-btn bg-rose-500 hover:bg-rose-600 text-white text-xs py-1 px-3">
                                                    Tolak
                                                </button>
                                            </div>
                                        @elseif($topup->status === 'pending')
                                            <button type="button" @click="showRejectModal = !showRejectModal" class="cute-btn bg-rose-500 hover:bg-rose-600 text-white text-xs py-1 px-3">
                                                Tolak
                                            </button>
                                        @else
                                            <span class="text-xs text-gray-400">-</span>
                                        @endif
                                    </div>
                                    
                                    <!-- Reject Form (Inline) -->
                                    <div x-show="showRejectModal" x-collapse class="mt-3 bg-rose-50 p-3 rounded-lg border border-rose-100 w-full min-w-[200px]" style="display: none;">
                                        <form action="{{ route('admin.topups.reject', $topup) }}" method="POST">
                                            @csrf
                                            <label class="block text-xs text-gray-700 mb-1 font-medium">Alasan Penolakan (Opsional)</label>
                                            <textarea name="admin_notes" rows="2" class="cute-input w-full text-sm p-2 mb-2" placeholder="Contoh: Bukti transfer tidak jelas"></textarea>
                                            <div class="flex justify-end gap-2">
                                                <button type="button" @click="showRejectModal = false" class="text-xs text-gray-500 hover:text-gray-700">Batal</button>
                                                <button type="submit" class="cute-btn bg-rose-600 hover:bg-rose-700 text-white text-xs py-1 px-3">Konfirmasi Tolak</button>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-gray-100 border-dashed">
                {{ $topups->withQueryString()->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
