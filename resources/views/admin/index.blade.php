<x-admin-layout>
    <!-- Font Nunito & Fredoka (pindahkan ke <head> admin-layout jika ingin dimuat sekali untuk semua halaman admin) -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Fredoka:wght@500;600;700&family=Nunito:wght@400;600;700&display=swap">

    <style>
        .adm {
            --c-blush: #FFF5F8; --c-petal: #FFE1EA; --c-rose: #FF9EBB; --c-berry: #D6477F; --c-cocoa: #5B3A4A;
            --c-lilac: #EBDDFB; --c-peach: #FFE6D6; --c-mint: #DDF3EA;
            font-family: 'Nunito', system-ui, sans-serif; color: var(--c-cocoa);
            max-width: 80rem; margin: 0 auto; padding: 1.5rem;
            background: linear-gradient(180deg, #FFEAF1 0%, var(--c-blush) 60%);
            border-radius: 1.75rem;
        }
        .adm-head { display: flex; flex-wrap: wrap; gap: 1rem; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
        .adm-title { font-family: 'Fredoka', sans-serif; font-weight: 700; font-size: 1.85rem; margin: 0; color: var(--c-cocoa); }
        .adm-title span { color: var(--c-berry); }

        /* Tombol */
        .adm-btn { display: inline-flex; align-items: center; justify-content: center; gap: .4rem; text-decoration: none; cursor: pointer;
            padding: .7rem 1.5rem; border: 0; border-radius: 999px; background: var(--c-rose); color: #fff;
            font-family: 'Fredoka', sans-serif; font-weight: 600; font-size: 1rem; box-shadow: 0 4px 0 var(--c-berry);
            transition: transform .15s ease, box-shadow .15s ease; }
        .adm-btn:hover { transform: translateY(2px); box-shadow: 0 2px 0 var(--c-berry); }
        .adm-btn:focus-visible, .acc-act:focus-visible { outline: 3px solid var(--c-berry); outline-offset: 3px; }

        /* Notifikasi sukses */
        .acc-alert { display: flex; align-items: center; gap: .75rem; margin-bottom: 1.25rem; padding: .9rem 1.25rem;
            background: var(--c-mint); color: #1F7A57; font-weight: 700; border: 2px dashed #8FD3B6; border-radius: 1.25rem; }
        .acc-alert svg { flex: none; width: 1.4rem; height: 1.4rem; }

        /* Panel + tabel */
        .acc-panel { background: #fff; border: 2px solid var(--c-petal); border-radius: 1.75rem; box-shadow: 0 6px 0 var(--c-petal); padding: .75rem; overflow-x: auto; }
        .acc-table { width: 100%; min-width: 46rem; border-collapse: separate; border-spacing: 0; }
        .acc-table thead th { background: var(--c-petal); padding: .85rem 1.5rem; text-align: left; font-size: .75rem; font-weight: 700;
            letter-spacing: .06em; text-transform: uppercase; color: var(--c-berry); }
        .acc-table thead th:first-child { border-radius: 1rem 0 0 1rem; }
        .acc-table thead th:last-child { border-radius: 0 1rem 1rem 0; }
        .acc-table td { padding: 1rem 1.5rem; font-size: .92rem; vertical-align: middle; border-top: 2px dashed var(--c-petal); }
        .acc-table tbody tr:first-child td { border-top: 0; }
        .acc-table tbody tr:hover td { background: var(--c-blush); }
        .acc-name { font-weight: 700; color: var(--c-cocoa); }
        .acc-mono { font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; }
        .acc-email { color: var(--c-cocoa); font-size: .9rem; }
        .acc-pass { display: inline-block; margin-top: .3rem; padding: .1rem .6rem; border-radius: .6rem; background: var(--c-petal); color: #9C7A8A; font-size: .78rem; }
        .acc-date { color: var(--c-cocoa); }
        .acc-empty { text-align: center; color: #9C7A8A; font-weight: 600; }

        /* Status */
        .acc-pill { display: inline-block; padding: .2rem .85rem; border-radius: 999px; font-size: .8rem; font-weight: 700; border: 2px solid transparent; }
        .acc-ok { background: var(--c-mint); color: #1F7A57; border-color: #BFE6D4; }
        .acc-sold { background: var(--c-petal); color: #C2255F; border-color: var(--c-rose); }

        /* Aksi */
        .acc-actions { display: flex; align-items: center; gap: .6rem; }
        .acc-act { display: inline-block; padding: .3rem .95rem; border-radius: 999px; font-family: inherit; font-size: .85rem; font-weight: 700;
            text-decoration: none; cursor: pointer; border: 2px solid transparent; transition: background-color .2s ease, transform .15s ease; }
        .acc-act:hover { transform: translateY(-1px); }
        .acc-edit { background: var(--c-lilac); color: #7A4FC4; border-color: #DCC6F7; }
        .acc-edit:hover { background: #DCC6F7; }
        .acc-del { background: #fff; color: #C2255F; border-color: var(--c-rose); }
        .acc-del:hover { background: var(--c-petal); }
    </style>

    <div class="adm">
        <div class="adm-head">
            <h1 class="adm-title">Manajemen <span>Stok Akun</span> 🔑</h1>
            <a href="{{ route('admin.premium-accounts.create') }}" class="adm-btn">
                + Tambah Stok Akun
            </a>
        </div>

        @if(session('success'))
            <div class="acc-alert" role="status">
                <svg viewBox="0 0 24 24" fill="#fff" stroke="#1F7A57" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="12" r="9"/><path d="M8 12.5l3 3 5-6" fill="none"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="acc-panel">
            <table class="acc-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Kredensial (Email / Pass)</th>
                        <th>Masa Berlaku</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($accounts as $account)
                    <tr>
                        <td>
                            <span class="acc-name">{{ $account->product->name ?? 'Produk Dihapus' }}</span>
                        </td>
                        <td>
                            <div class="acc-email acc-mono">{{ $account->email }}</div>
                            <div class="acc-pass acc-mono">P: {{ $account->password }}</div>
                        </td>
                        <td class="acc-date">
                            {{ $account->expired_at ? $account->expired_at->format('d M Y') : 'Tanpa batas' }}
                        </td>
                        <td>
                            @if($account->status == 'tersedia')
                                <span class="acc-pill acc-ok">Tersedia</span>
                            @else
                                <span class="acc-pill acc-sold">Terjual</span>
                            @endif
                        </td>
                        <td>
                            <div class="acc-actions">
                                <a href="{{ route('admin.premium-accounts.edit', $account->id) }}" class="acc-act acc-edit">Edit</a>
                                <form action="{{ route('admin.premium-accounts.destroy', $account->id) }}" method="POST" onsubmit="return confirm('Hapus akun ini dari stok?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="acc-act acc-del">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="acc-empty">Belum ada stok akun yang ditambahkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
