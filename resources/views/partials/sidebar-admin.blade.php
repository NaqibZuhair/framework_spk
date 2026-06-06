@php
    $mode = $mode ?? 'desktop';
    $isMobile = $mode === 'mobile';

    $asideId = $isMobile ? 'adminSidebarMobile' : 'adminSidebarDesktop';

    $asideClass = $isMobile
        ? 'fixed inset-y-0 left-0 z-50 hidden w-[258px] border-r border-slate-200 bg-white lg:hidden'
        : 'fixed inset-y-0 left-0 z-30 hidden w-[258px] border-r border-slate-200 bg-white lg:block';

    $menus = [
        [
            'label' => 'Dashboard',
            'url' => url('/admin/dashboard'),
            'active' => 'admin/dashboard*',
            'icon' => 'grid',
        ],
        [
            'label' => 'Periode Seleksi',
            'url' => url('/admin/periods'),
            'active' => 'admin/periods*',
            'icon' => 'calendar',
        ],
        [
            'label' => 'Data Pendaftar',
            'url' => url('/admin/candidates'),
            'active' => 'admin/candidates*',
            'icon' => 'users',
        ],
        [
            'label' => 'Jadwal Wawancara',
            'url' => url('/admin/interviews'),
            'active' => 'admin/interviews*',
            'icon' => 'calendar-check',
        ],
        [
            'label' => 'Akun Juri',
            'url' => url('/admin/juries'),
            'active' => 'admin/juries*',
            'icon' => 'jury',
        ],
        [
            'label' => 'Kriteria',
            'url' => url('/admin/criteria'),
            'active' => 'admin/criteria*',
            'icon' => 'criteria',
        ],
        [
            'label' => 'Monitoring Penilaian',
            'url' => url('/admin/monitoring'),
            'active' => 'admin/monitoring*',
            'icon' => 'chart',
        ],
        [
            'label' => 'Hasil ARAS',
            'url' => url('/admin/aras'),
            'active' => 'admin/aras*',
            'icon' => 'rank',
        ],
        [
            'label' => 'Pengumuman',
            'url' => url('/admin/announcements'),
            'active' => 'admin/announcements*',
            'icon' => 'announcement',
        ],
    ];
@endphp

<aside id="{{ $asideId }}" class="{{ $asideClass }}">
    <div class="flex h-full flex-col">
        {{-- Brand --}}
        <div class="flex h-20 items-center justify-between border-b border-slate-100 px-5">
            <a href="{{ url('/admin/dashboard') }}" class="flex min-w-0 items-center gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-900">
                    <img
                        src="{{ asset('images/LOGO DUTA.png') }}"
                        alt="Logo Duta PNJ"
                        class="h-8 w-8 object-contain"
                    >
                </div>

                <div class="min-w-0">
                    <h1 class="truncate text-xl font-extrabold leading-tight text-blue-900">
                        Duta PNJ
                    </h1>

                    <p class="truncate text-xs font-semibold text-slate-500">
                        Sistem Seleksi Mahasiswa
                    </p>
                </div>
            </a>

            @if ($isMobile)
                <button
                    type="button"
                    id="adminSidebarClose"
                    class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-800"
                    aria-label="Tutup sidebar"
                >
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                        <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                    </svg>
                </button>
            @endif
        </div>

        {{-- Menu --}}
        <div class="flex-1 overflow-y-auto px-4 py-5">
            <nav class="space-y-1">
                @foreach ($menus as $menu)
                    @php
                        $active = request()->is($menu['active']);

                        $menuClass = $active
                            ? 'bg-yellow-300 text-slate-900 shadow-sm'
                            : 'text-slate-600 hover:bg-slate-100 hover:text-blue-900';
                    @endphp

                    <a
                        href="{{ $menu['url'] }}"
                        class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-bold transition {{ $menuClass }}"
                    >
                        <span class="inline-flex h-5 w-5 shrink-0 items-center justify-center">
                            @if ($menu['icon'] === 'grid')
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                                    <path d="M4 4H10V10H4V4Z" stroke="currentColor" stroke-width="2"/>
                                    <path d="M14 4H20V10H14V4Z" stroke="currentColor" stroke-width="2"/>
                                    <path d="M4 14H10V20H4V14Z" stroke="currentColor" stroke-width="2"/>
                                    <path d="M14 14H20V20H14V14Z" stroke="currentColor" stroke-width="2"/>
                                </svg>
                            @elseif ($menu['icon'] === 'users')
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                                    <path d="M16 11C17.657 11 19 9.657 19 8C19 6.343 17.657 5 16 5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    <path d="M8 11C9.657 11 11 9.657 11 8C11 6.343 9.657 5 8 5C6.343 5 5 6.343 5 8C5 9.657 6.343 11 8 11Z" stroke="currentColor" stroke-width="2"/>
                                    <path d="M8 13C5.239 13 3 15.239 3 18V19H13V18C13 15.239 10.761 13 8 13Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    <path d="M17 13C19.209 13 21 14.791 21 17V19H17" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            @elseif ($menu['icon'] === 'calendar')
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                                    <path d="M7 3V6M17 3V6M4 9H20M5 5H19C19.552 5 20 5.448 20 6V20C20 20.552 19.552 21 19 21H5C4.448 21 4 20.552 4 20V6C4 5.448 4.448 5 5 5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            @elseif ($menu['icon'] === 'calendar-check')
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                                    <path d="M7 3V6M17 3V6M4 9H20M5 5H19C19.552 5 20 5.448 20 6V20C20 20.552 19.552 21 19 21H5C4.448 21 4 20.552 4 20V6C4 5.448 4.448 5 5 5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    <path d="M8 15L11 18L16 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            @elseif ($menu['icon'] === 'jury')
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                                    <path d="M4 19H20M6 17L15 8M9 6L18 15M5 14L10 19M14 5L19 10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            @elseif ($menu['icon'] === 'criteria')
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                                    <path d="M4 5H20V19H4V5Z" stroke="currentColor" stroke-width="2"/>
                                    <path d="M8 9H16M8 13H13M8 17H15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            @elseif ($menu['icon'] === 'chart')
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                                    <path d="M4 19V13M10 19V9M16 19V5M22 19H2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            @elseif ($menu['icon'] === 'rank')
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                                    <path d="M5 20H19M7 20V10M12 20V4M17 20V14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            @else
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                                    <path d="M4 14V10L15 5V19L4 14Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                                    <path d="M4 14L6 20H9L7 15" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                                </svg>
                            @endif
                        </span>

                        <span class="truncate">
                            {{ $menu['label'] }}
                        </span>
                    </a>
                @endforeach
            </nav>
        </div>

        {{-- Logout --}}
        <div class="border-t border-slate-100 px-4 py-5">
            <button
                type="button"
                onclick="openModal('logoutModal')"
                class="flex w-full items-center gap-3 rounded-xl px-4 py-3 text-sm font-bold text-red-600 transition hover:bg-red-50 hover:text-red-700"
            >
                <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none">
                    <path d="M15 17L20 12L15 7M20 12H9M11 21H5C4.448 21 4 20.552 4 20V4C4 3.448 4.448 3 5 3H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Keluar
            </button>
        </div>
    </div>
</aside>

<x-modal id="logoutModal" title="Keluar dari Dashboard" size="sm">
    <div class="flex gap-4">
        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-red-50 text-red-600">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none">
                <path d="M15 17L20 12L15 7M20 12H9M11 21H5C4.448 21 4 20.552 4 20V4C4 3.448 4.448 3 5 3H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>

        <div>
            <p class="text-sm font-semibold leading-6 text-slate-700">
                Anda yakin ingin keluar dari dashboard admin?
            </p>

            <p class="mt-2 text-sm leading-6 text-slate-500">
                Setelah keluar, Anda perlu login kembali untuk mengakses halaman admin.
            </p>
        </div>
    </div>

    <x-slot:footer>
        <button
            type="button"
            onclick="closeModal('logoutModal')"
            class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-bold text-slate-700 transition hover:bg-slate-50"
        >
            Batal
        </button>

        <button
            id="confirmLogoutButton"
            type="button"
            onclick="confirmLogout()"
            class="rounded-lg bg-red-600 px-4 py-2 text-sm font-bold text-white transition hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-70"
        >
            Ya, Keluar
        </button>
    </x-slot:footer>
</x-modal>