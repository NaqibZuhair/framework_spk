<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Juri - Duta PNJ' }}</title>
    @include('partials.app-icon')

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="min-h-screen bg-slate-100 text-slate-900">
    @include('partials.sidebar-jury')

    <div class="min-h-screen pl-64">
        <header class="sticky top-0 z-30 h-16 border-b border-slate-200 bg-white">
            <div class="flex h-full items-center justify-between px-6 lg:px-8">
                <div>
                    <p class="text-xs font-extrabold uppercase tracking-wide text-slate-400">
                        Panel Juri
                    </p>

                    <p class="mt-0.5 text-sm font-extrabold text-slate-800">
                        {{ $title ?? 'Dashboard Juri' }}
                    </p>
                </div>

                <div class="flex items-center gap-5">
                    <button
                        type="button"
                        class="rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-blue-900"
                        aria-label="Notifikasi"
                    >
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none">
                            <path d="M18 8A6 6 0 0 0 6 8C6 15 3 17 3 17H21C21 17 18 15 18 8Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M10 21H14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </button>

                    <div class="flex items-center gap-3">
                        <div class="text-right">
                            <p id="juryTopbarName" class="text-sm font-extrabold text-slate-900">
                                Juri
                            </p>

                            <p class="text-xs font-semibold text-slate-500">
                                Tim Penilai
                            </p>
                        </div>

                        <div
                            id="juryTopbarInitial"
                            class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-900 text-sm font-extrabold text-white"
                        >
                            J
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-6 py-8 lg:px-8">
            @yield('content')
        </main>
    </div>

    <div id="juryLogoutModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/25 px-4 py-6 backdrop-blur-sm">
        <div class="w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-slate-900/10">
            <div class="flex items-start justify-between gap-4 border-b border-slate-100 px-6 py-5">
                <div>
                    <h3 class="text-lg font-extrabold text-slate-900">
                        Keluar dari Portal Juri
                    </h3>

                    <p class="mt-1 text-sm leading-6 text-slate-500">
                        Konfirmasi sebelum keluar dari halaman penilaian.
                    </p>
                </div>

                <button
                    type="button"
                    onclick="closeModal('juryLogoutModal')"
                    class="rounded-lg p-1.5 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                    aria-label="Tutup modal"
                >
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                        <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                    </svg>
                </button>
            </div>

            <div class="px-6 py-5">
                <div class="flex gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-red-50 text-red-600">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none">
                            <path d="M15 17L20 12L15 7M20 12H9M11 21H5C4.448 21 4 20.552 4 20V4C4 3.448 4.448 3 5 3H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>

                    <div>
                        <p class="text-sm font-extrabold leading-6 text-slate-800">
                            Anda yakin ingin keluar?
                        </p>

                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            Setelah keluar, Anda perlu login kembali untuk mengakses portal juri.
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4">
                <button
                    type="button"
                    onclick="closeModal('juryLogoutModal')"
                    class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-bold text-slate-700 transition hover:bg-slate-50"
                >
                    Batal
                </button>

                <button
                    id="confirmJuryLogoutButton"
                    type="button"
                    onclick="confirmLogoutJury()"
                    class="rounded-lg bg-red-600 px-4 py-2 text-sm font-bold text-white transition hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-70"
                >
                    Ya, Keluar
                </button>
            </div>
        </div>
    </div>

    @php
        $authUser = auth()->user();
        $authUserData = $authUser
            ? $authUser->only(['id', 'name', 'email', 'role'])
            : null;
    @endphp

    <script>
        window.DutaJury = {
            apiBase: "{{ url('/api') }}",
            loginUrl: "{{ route('login') }}",
            logoutUrl: "{{ route('logout') }}",
            csrfToken: "{{ csrf_token() }}",
            currentUser: @json($authUserData),

            user() {
                return this.currentUser;
            },

            headers() {
                return {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                };
            },

            async request(path, options = {}) {
                const response = await fetch(`${this.apiBase}${path}`, {
                    ...options,
                    credentials: 'same-origin',
                    headers: {
                        ...this.headers(),
                        ...(options.headers || {}),
                    },
                });

                if (response.status === 401 || response.status === 419) {
                    window.location.href = this.loginUrl;
                    throw new Error('Sesi login sudah berakhir.');
                }

                const result = await response.json().catch(() => null);

                if (!response.ok) {
                    const message = result?.errors
                        ? Object.values(result.errors).flat().join(' ')
                        : result?.message;

                    throw new Error(message || 'Terjadi kesalahan.');
                }

                return result;
            },
        };

        document.addEventListener('DOMContentLoaded', function () {
            const user = DutaJury.user();

            if (!user || user.role !== 'juri') {
                window.location.href = DutaJury.loginUrl;
                return;
            }

            const juryName = user.name || 'Juri';
            const initial = juryName.charAt(0).toUpperCase();

            const juryTopbarName = document.getElementById('juryTopbarName');
            const juryTopbarInitial = document.getElementById('juryTopbarInitial');
            const jurySidebarName = document.getElementById('jurySidebarName');
            const jurySidebarEmail = document.getElementById('jurySidebarEmail');
            const jurySidebarInitial = document.getElementById('jurySidebarInitial');

            if (juryTopbarName) juryTopbarName.textContent = juryName;
            if (juryTopbarInitial) juryTopbarInitial.textContent = initial;
            if (jurySidebarName) jurySidebarName.textContent = juryName;
            if (jurySidebarEmail) jurySidebarEmail.textContent = user.email || '-';
            if (jurySidebarInitial) jurySidebarInitial.textContent = initial;

            const logoutModal = document.getElementById('juryLogoutModal');

            logoutModal?.addEventListener('click', function (event) {
                if (event.target === logoutModal) {
                    closeModal('juryLogoutModal');
                }
            });
        });

        async function logoutJury() {
            try {
                await fetch(DutaJury.logoutUrl, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'text/html,application/xhtml+xml',
                        'X-CSRF-TOKEN': DutaJury.csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });
            } catch (error) {
                console.error(error);
            } finally {
                window.location.href = DutaJury.loginUrl;
            }
        }

        async function loadPeriodOptions(selectId = 'periodIdInput', selectedValue = null) {
            const select = document.getElementById(selectId);

            if (!select || !window.DutaJury) {
                return;
            }

            const currentValue = selectedValue || select.value || '1';

            try {
                const result = await DutaJury.request('/periods');

                const periods = Array.isArray(result?.data)
                    ? result.data
                    : (result?.data?.data || []);

                if (!periods.length) {
                    return;
                }

                select.innerHTML = periods.map(period => `
                    <option value="${period.id}" ${String(period.id) === String(currentValue) ? 'selected' : ''}>
                        ${period.election_year}
                    </option>
                `).join('');
            } catch (error) {
                console.error('Gagal memuat periode:', error);
            }
        }

        function openModal(id) {
            const modal = document.getElementById(id);

            if (!modal) {
                return;
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal(id) {
            const modal = document.getElementById(id);

            if (!modal) {
                return;
            }

            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        async function confirmLogoutJury() {
            const button = document.getElementById('confirmJuryLogoutButton');

            if (button) {
                button.disabled = true;
                button.textContent = 'Keluar...';
            }

            await logoutJury();
        }
    </script>

    @stack('scripts')
</body>
</html>