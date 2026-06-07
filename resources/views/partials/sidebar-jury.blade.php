@php
    $menus = [
        [
            'label' => 'Dashboard',
            'url' => url('/jury/dashboard'),
            'active' => 'jury/dashboard*',
            'icon' => 'dashboard',
        ],
        [
            'label' => 'Penilaian Peserta',
            'url' => url('/jury/scoring'),
            'active' => 'jury/scoring*',
            'icon' => 'score',
        ],
        [
            'label' => 'Riwayat Penilaian',
            'url' => url('/jury/history'),
            'active' => 'jury/history*',
            'icon' => 'history',
        ],
    ];
@endphp

<aside class="fixed inset-y-0 left-0 z-40 flex w-64 flex-col border-r border-slate-200 bg-white">
    {{-- Brand --}}
    <div class="flex h-20 items-center border-b border-slate-100 px-5">
        <a href="{{ url('/jury/dashboard') }}" class="flex min-w-0 items-center gap-3">
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
                    Portal Juri
                </p>
            </div>
        </a>
    </div>

    {{-- Menu --}}
    <nav class="flex-1 space-y-1 overflow-y-auto px-4 py-5">
        @foreach ($menus as $menu)
            @php
                $isActive = request()->is($menu['active']);

                $menuClass = $isActive
                    ? 'bg-yellow-300 text-slate-900 shadow-sm'
                    : 'text-slate-600 hover:bg-slate-100 hover:text-blue-900';
            @endphp

            <a
                href="{{ $menu['url'] }}"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-bold transition {{ $menuClass }}"
            >
                <span class="inline-flex h-5 w-5 shrink-0 items-center justify-center">
                    @if ($menu['icon'] === 'dashboard')
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                            <path d="M4 4H10V10H4V4Z" stroke="currentColor" stroke-width="2"/>
                            <path d="M14 4H20V10H14V4Z" stroke="currentColor" stroke-width="2"/>
                            <path d="M4 14H10V20H4V14Z" stroke="currentColor" stroke-width="2"/>
                            <path d="M14 14H20V20H14V14Z" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    @elseif ($menu['icon'] === 'score')
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                            <path d="M5 4H19V20H5V4Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                            <path d="M9 12L11 14L15.5 9.5" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    @else
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                            <path d="M12 8V13L15 15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <path d="M21 12A9 9 0 1 1 18.36 5.64" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <path d="M21 4V10H15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    @endif
                </span>

                <span class="truncate">
                    {{ $menu['label'] }}
                </span>
            </a>
        @endforeach
    </nav>

    {{-- User + Logout --}}
    <div class="border-t border-slate-100 px-4 py-5">
        <div class="mb-4 rounded-2xl bg-slate-50 px-4 py-3">
            <div class="flex items-center gap-3">
                <div
                    id="jurySidebarInitial"
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-900 text-sm font-extrabold text-white"
                >
                    J
                </div>

                <div class="min-w-0">
                    <p id="jurySidebarName" class="truncate text-sm font-extrabold text-slate-900">
                        Juri
                    </p>

                    <p id="jurySidebarEmail" class="mt-1 truncate text-xs font-semibold text-slate-500">
                        -
                    </p>
                </div>
            </div>
        </div>

        <button
            type="button"
            onclick="openModal('juryLogoutModal')"
            class="flex w-full items-center gap-3 rounded-xl px-4 py-3 text-sm font-bold text-red-600 transition hover:bg-red-50 hover:text-red-700"
        >
            <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none">
                <path d="M15 17L20 12L15 7M20 12H9M11 21H5C4.448 21 4 20.552 4 20V4C4 3.448 4.448 3 5 3H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>

            Keluar
        </button>
    </div>
</aside>