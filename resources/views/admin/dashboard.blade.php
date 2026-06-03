@extends('layouts.admin')

@section('content')
    <section class="mb-7">
        <h1 class="text-[36px] font-extrabold leading-none tracking-tight text-[#00288E]">
            Ringkasan Dashboard
        </h1>

        <p class="mt-2 text-sm font-medium text-slate-500">
            Selamat datang kembali, Admin Seleksi Duta PNJ {{ now()->year }}.
        </p>
    </section>

    {{-- Statistik Utama --}}
    <section class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
        <x-card>
            <div class="flex items-start justify-between">
                <div class="flex h-10 w-10 items-center justify-center rounded-md bg-blue-50 text-[#00288E]">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                        <path d="M16 11C17.657 11 19 9.657 19 8M8 11C9.657 11 11 9.657 11 8C11 6.343 9.657 5 8 5C6.343 5 5 6.343 5 8C5 9.657 6.343 11 8 11ZM8 13C5.239 13 3 15.239 3 18V19H13V18C13 15.239 10.761 13 8 13Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>

                <span class="rounded-full bg-blue-50 px-2 py-1 text-[11px] font-bold text-[#00288E]">
                    Data
                </span>
            </div>

            <p class="mt-3 text-sm font-semibold text-slate-700">
                Total Pendaftar
            </p>

            <h2 id="totalCandidates" class="mt-1 text-[28px] font-extrabold leading-tight text-slate-900">
                0
            </h2>
        </x-card>

        <x-card>
            <div class="flex h-10 w-10 items-center justify-center rounded-md bg-yellow-50 text-yellow-700">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                    <path d="M7 4H17V20H7V4Z" stroke="currentColor" stroke-width="2"/>
                    <path d="M9 8H15M9 12H14M9 16H12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>

            <p class="mt-7 text-sm font-semibold text-slate-700">
                Menunggu Verifikasi
            </p>

            <h2 id="pendingCandidates" class="mt-1 text-[28px] font-extrabold leading-tight text-slate-900">
                0
            </h2>
        </x-card>

        <x-card>
            <div class="flex h-10 w-10 items-center justify-center rounded-md bg-green-50 text-green-700">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                    <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>

            <p class="mt-7 text-sm font-semibold text-slate-700">
                Lolos Administrasi
            </p>

            <h2 id="validCandidates" class="mt-1 text-[28px] font-extrabold leading-tight text-slate-900">
                0
            </h2>
        </x-card>

        <x-card>
            <div class="flex h-10 w-10 items-center justify-center rounded-md bg-red-50 text-red-600">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                    <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                </svg>
            </div>

            <p class="mt-7 text-sm font-semibold text-slate-700">
                Ditolak
            </p>

            <h2 id="invalidCandidates" class="mt-1 text-[28px] font-extrabold leading-tight text-slate-900">
                0
            </h2>
        </x-card>
    </section>

    {{-- Statistik Lanjutan --}}
    <section class="mt-5 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
        <x-card>
            <div class="flex h-10 w-10 items-center justify-center rounded-md bg-blue-50 text-[#00288E]">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                    <path d="M7 3V6M17 3V6M4 9H20M5 5H19V21H5V5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>

            <p class="mt-7 text-sm font-semibold text-slate-700">
                Dijadwalkan
            </p>

            <h2 id="scheduledCandidates" class="mt-1 text-[28px] font-extrabold leading-tight text-slate-900">
                0
            </h2>
        </x-card>

        <x-card>
            <div class="flex h-10 w-10 items-center justify-center rounded-md bg-purple-50 text-purple-700">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                    <path d="M4 5H20V17H8L4 21V5Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                    <path d="M8 9H16M8 13H13" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>

            <p class="mt-7 text-sm font-semibold text-slate-700">
                Sudah Dinilai
            </p>

            <h2 id="scoredCandidates" class="mt-1 text-[28px] font-extrabold leading-tight text-slate-900">
                0
            </h2>
        </x-card>

        <div class="rounded-xl bg-[#00288E] p-5 text-white shadow-sm md:col-span-2">
            <div class="flex items-start justify-between">
                <div class="flex h-9 w-9 items-center justify-center rounded-md bg-white/15">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                        <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/>
                        <path d="M12 8H12.01M11 12H12V17H13" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>

                <span class="rounded-full bg-white/15 px-3 py-1 text-[12px] font-semibold">
                    Sistem Aktif
                </span>
            </div>

            <p class="mt-5 text-sm font-medium text-blue-100">
                Status Pengumuman
            </p>

            <h2 id="announcementStatus" class="text-[24px] font-extrabold leading-tight">
                Belum Dibuka
            </h2>
        </div>
    </section>

    {{-- Progress Seleksi --}}
    <section class="mt-10">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-[24px] font-extrabold text-slate-800">
                Progress Seleksi
            </h2>

            <a href="{{ url('/admin/aras') }}" class="text-sm font-bold text-[#00288E] hover:underline">
                Detail Alur ›
            </a>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white px-8 py-7 shadow-sm">
            <div class="grid grid-cols-1 gap-5 md:grid-cols-6">
                <div class="progress-item" data-step="registration">
                    <span class="progress-number active">1</span>
                    <p class="progress-label active">Pendaftaran</p>
                </div>

                <div class="progress-item" data-step="verification">
                    <span class="progress-number active">2</span>
                    <p class="progress-label active">Verifikasi</p>
                </div>

                <div class="progress-item" data-step="schedule">
                    <span class="progress-number">3</span>
                    <p class="progress-label">Jadwal Wawancara</p>
                </div>

                <div class="progress-item" data-step="scoring">
                    <span class="progress-number">4</span>
                    <p class="progress-label">Penilaian Juri</p>
                </div>

                <div class="progress-item" data-step="aras">
                    <span class="progress-number">5</span>
                    <p class="progress-label">Perhitungan ARAS</p>
                </div>

                <div class="progress-item" data-step="announcement">
                    <span class="progress-number">6</span>
                    <p class="progress-label">Pengumuman</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Pendaftar Terbaru --}}
    <section class="mt-10">
        <div class="mb-4 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <h2 class="text-[24px] font-extrabold text-slate-800">
                Pendaftar Terbaru
            </h2>

            <div class="flex items-center gap-2">
                <x-button variant="secondary" size="sm" type="button">
                    Filter
                </x-button>

                <x-button size="sm" type="button">
                    Ekspor Data
                </x-button>
            </div>
        </div>

        <x-table :headers="['Nama', 'NIM', 'Program Studi', 'Status', 'Tanggal Daftar', 'Aksi']">
            <tbody id="latestCandidatesTable" class="divide-y divide-slate-200 text-sm">
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                        Memuat data pendaftar...
                    </td>
                </tr>
            </tbody>
        </x-table>

        <div class="flex items-center justify-between rounded-b-xl border-x border-b border-slate-200 bg-slate-50 px-6 py-4 text-sm text-slate-600">
            <span id="tableInfo">
                Menampilkan data pendaftar terbaru
            </span>

            <div class="flex items-center gap-1">
                <button type="button" class="flex h-6 w-6 items-center justify-center rounded border border-slate-300 text-slate-400">
                    ‹
                </button>

                <button type="button" class="flex h-6 w-6 items-center justify-center rounded border border-slate-300 text-slate-500">
                    ›
                </button>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .progress-item {
            text-align: center;
        }

        .progress-number {
            display: flex;
            width: 40px;
            height: 40px;
            margin: 0 auto;
            align-items: center;
            justify-content: center;
            border-radius: 9999px;
            background: #e2e8f0;
            color: #64748b;
            font-size: 14px;
            font-weight: 800;
        }

        .progress-number.active {
            background: #00288E;
            color: white;
        }

        .progress-label {
            margin-top: 8px;
            font-size: 13px;
            font-weight: 700;
            color: #64748b;
        }

        .progress-label.active {
            color: #00288E;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            loadDashboardData();

            const searchInput = document.getElementById('globalSearchInput');

            let searchTimer = null;

            searchInput?.addEventListener('input', function () {
                clearTimeout(searchTimer);

                searchTimer = setTimeout(() => {
                    loadLatestCandidates(this.value);
                }, 400);
            });
        });

        async function loadDashboardData() {
            try {
                const result = await DutaAdmin.request('/candidates?per_page=100');

                const candidates = normalizeCollection(result);
                const total = normalizeTotal(result, candidates.length);

                renderStats(candidates, total);
                renderLatestCandidates(candidates.slice(0, 5), total);
            } catch (error) {
                console.error(error);
                renderDashboardError(error?.message || 'Gagal memuat data dashboard.');
            }
        }

        async function loadLatestCandidates(keyword = '') {
            try {
                const result = await DutaAdmin.request('/candidates?per_page=100');
                const candidates = normalizeCollection(result);
                const total = normalizeTotal(result, candidates.length);

                const filtered = keyword
                    ? candidates.filter(candidate => {
                        const value = [
                            candidate.full_name,
                            candidate.student_number,
                            candidate.study_program,
                            candidate.status,
                        ].join(' ').toLowerCase();

                        return value.includes(keyword.toLowerCase());
                    })
                    : candidates;

                renderLatestCandidates(filtered.slice(0, 5), filtered.length || total);
            } catch (error) {
                console.error(error);
                renderDashboardError(error?.message || 'Gagal memuat data pendaftar.');
            }
        }

        function normalizeCollection(result) {
            if (!result) return [];

            if (Array.isArray(result.data)) {
                return result.data;
            }

            if (Array.isArray(result.data?.data)) {
                return result.data.data;
            }

            if (Array.isArray(result.data?.items)) {
                return result.data.items;
            }

            return [];
        }

        function normalizeTotal(result, fallback = 0) {
            return result?.data?.total ?? result?.total ?? fallback;
        }

        function renderStats(candidates, total) {
            const pending = candidates.filter(item => item.status === 'pending').length;
            const valid = candidates.filter(item => item.status === 'valid').length;
            const invalid = candidates.filter(item => item.status === 'invalid').length;
            const scheduled = candidates.filter(item => item.status === 'interview_scheduled').length;
            const scored = candidates.filter(item => item.status === 'scored').length;

            setText('totalCandidates', total);
            setText('pendingCandidates', pending);
            setText('validCandidates', valid);
            setText('invalidCandidates', invalid);
            setText('scheduledCandidates', scheduled);
            setText('scoredCandidates', scored);
        }

        function renderLatestCandidates(candidates, total) {
            const tableBody = document.getElementById('latestCandidatesTable');
            const tableInfo = document.getElementById('tableInfo');

            if (!tableBody) return;

            if (!candidates.length) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                            Belum ada data pendaftar.
                        </td>
                    </tr>
                `;

                if (tableInfo) {
                    tableInfo.textContent = 'Menampilkan 0 data pendaftar';
                }

                return;
            }

            tableBody.innerHTML = candidates.map(candidate => {
                const name = candidate.full_name || '-';
                const nim = candidate.student_number || '-';
                const program = candidate.study_program || '-';
                const status = candidate.status || '-';
                const createdAt = formatDate(candidate.created_at);
                const initial = getInitial(name);

                return `
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 text-xs font-extrabold text-[#00288E]">
                                    ${initial}
                                </div>

                                <span class="font-extrabold text-slate-900">
                                    ${escapeHtml(name)}
                                </span>
                            </div>
                        </td>

                        <td class="px-6 py-4 text-slate-600">
                            ${escapeHtml(nim)}
                        </td>

                        <td class="px-6 py-4 text-slate-600">
                            ${escapeHtml(program)}
                        </td>

                        <td class="px-6 py-4">
                            ${renderStatusBadge(status)}
                        </td>

                        <td class="px-6 py-4 text-slate-600">
                            ${createdAt}
                        </td>

                        <td class="px-6 py-4 text-right">
                            <a href="/admin/candidates" class="font-extrabold text-[#00288E] hover:underline">
                                Detail
                            </a>
                        </td>
                    </tr>
                `;
            }).join('');

            if (tableInfo) {
                tableInfo.textContent = `Menampilkan ${candidates.length} dari ${total} pendaftar`;
            }
        }

        function renderDashboardError(message) {
            const tableBody = document.getElementById('latestCandidatesTable');

            if (tableBody) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-red-600">
                            ${escapeHtml(message)}
                        </td>
                    </tr>
                `;
            }
        }

        function renderStatusBadge(status) {
            const labels = {
                pending: 'Menunggu',
                valid: 'Terverifikasi',
                invalid: 'Ditolak',
                interview_scheduled: 'Dijadwalkan',
                interviewed: 'Sudah Wawancara',
                scored: 'Sudah Dinilai',
            };

            const classes = {
                pending: 'bg-yellow-100 text-yellow-700',
                valid: 'bg-green-100 text-green-700',
                invalid: 'bg-red-100 text-red-700',
                interview_scheduled: 'bg-blue-100 text-blue-700',
                interviewed: 'bg-indigo-100 text-indigo-700',
                scored: 'bg-purple-100 text-purple-700',
            };

            const label = labels[status] || status || '-';
            const badgeClass = classes[status] || 'bg-slate-100 text-slate-600';

            return `
                <span class="rounded-full px-3 py-1 text-xs font-bold ${badgeClass}">
                    ${escapeHtml(label)}
                </span>
            `;
        }

        function getInitial(name) {
            if (!name || name === '-') return '-';

            return name
                .split(' ')
                .filter(Boolean)
                .slice(0, 2)
                .map(word => word.charAt(0))
                .join('')
                .toUpperCase();
        }

        function formatDate(value) {
            if (!value) return '-';

            const date = new Date(value);

            if (Number.isNaN(date.getTime())) return '-';

            return date.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
            });
        }

        function setText(id, value) {
            const element = document.getElementById(id);

            if (element) {
                element.textContent = value;
            }
        }

        function escapeHtml(value) {
            return String(value ?? '')
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');
        }
    </script>
@endpush