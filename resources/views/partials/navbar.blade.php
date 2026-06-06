<header class="fixed left-0 right-0 top-0 z-20 h-16 border-b border-slate-200 bg-white lg:left-64.5">
    <div class="flex h-full items-center justify-between px-6 lg:px-8">
        <div class="hidden lg:block">
            <p class="text-xs font-bold uppercase tracking-wide text-slate-400">
                Administrator Panel
            </p>

            <p class="mt-0.5 text-sm font-extrabold text-slate-700">
                {{ $title ?? 'Dashboard' }}
            </p>
        </div>

        <div class="flex items-center gap-5">
            <button
                type="button"
                class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 hover:text-blue-900"
                aria-label="Notifikasi"
            >
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none">
                    <path d="M18 8A6 6 0 0 0 6 8C6 15 3 17 3 17H21C21 17 18 15 18 8Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M10 21H14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </button>

            <div class="flex items-center gap-3">
                <div class="text-right">
                    <p id="navbarUserName" class="text-sm font-extrabold text-slate-900">
                        Admin Seleksi
                    </p>
                    <p id="navbarUserRole" class="text-xs font-semibold text-slate-500">
                        Administrator
                    </p>
                </div>

                <div
                    id="navbarUserInitial"
                    class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-900 text-sm font-extrabold text-white"
                >
                    A
                </div>
            </div>
        </div>
    </div>
</header>