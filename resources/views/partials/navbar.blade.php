<header class="fixed left-0 right-0 top-0 z-40 h-[54px] border-b border-slate-200 bg-white">
    <div class="flex h-full items-center justify-between px-5">
        <div class="flex items-center gap-3">
            <button
                type="button"
                id="adminSidebarToggle"
                class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-slate-300 text-slate-600 hover:bg-slate-50 lg:hidden"
            >
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                    <path d="M4 7H20M4 12H20M4 17H20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </button>

            <a href="{{ url('/admin/dashboard') }}" class="text-[21px] font-extrabold tracking-tight text-[#00288E]">
                Duta PNJ
            </a>
        </div>

        <div class="hidden w-[520px] items-center rounded-md border border-slate-300 bg-slate-50 px-3 py-2 md:flex">
            <svg class="mr-2 h-4 w-4 text-slate-500" viewBox="0 0 24 24" fill="none">
                <path d="M21 21L16.65 16.65M19 11C19 15.4183 15.4183 19 11 19C6.58172 19 3 15.4183 3 11C3 6.58172 6.58172 3 11 3C15.4183 3 19 6.58172 19 11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>

            <input
                id="globalSearchInput"
                type="text"
                placeholder="Cari data..."
                class="w-full bg-transparent text-sm outline-none placeholder:text-slate-400"
            >
        </div>

        <div class="flex items-center gap-4">
            <button type="button" class="text-slate-600 hover:text-[#00288E]" title="Notifikasi">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                    <path d="M18 8A6 6 0 0 0 6 8C6 15 3 17 3 17H21C21 17 18 15 18 8Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M13.73 21A2 2 0 0 1 10.27 21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </button>

            <div class="hidden text-right md:block">
                <p id="navbarUserName" class="text-sm font-extrabold text-slate-800">
                    Admin
                </p>
                <p id="navbarUserRole" class="text-xs font-medium text-slate-500">
                    Administrator
                </p>
            </div>

            <div class="h-8 w-8 overflow-hidden rounded-full bg-[#00288E]">
                <div id="navbarUserInitial" class="flex h-full w-full items-center justify-center text-xs font-bold text-white">
                    A
                </div>
            </div>
        </div>
    </div>
</header>