@extends('layouts.admin')

@section('content')
<div class="space-y-7">
    {{-- Header --}}
    <section>
        <h1 class="text-4xl font-extrabold tracking-tight text-blue-900">
            Ringkasan Dashboard
        </h1>

        <p id="dashboardSubtitle" class="mt-2 text-sm font-semibold leading-6 text-slate-500">
            Selamat datang kembali, Admin Seleksi. Berikut ringkasan proses seleksi Duta PNJ.
        </p>
    </section>

    <div id="pageAlert" class="hidden rounded-xl border px-4 py-3 text-sm font-semibold"></div>

    {{-- Statistik --}}
    <section class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-50 text-blue-900">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                        <path d="M16 11C17.657 11 19 9.657 19 8C19 6.343 17.657 5 16 5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M8 11C9.657 11 11 9.657 11 8C11 6.343 9.657 5 8 5C6.343 5 5 6.343 5 8C5 9.657 6.343 11 8 11Z" stroke="currentColor" stroke-width="2"/>
                        <path d="M8 13C5.239 13 3 15.239 3 18V19H13V18C13 15.239 10.761 13 8 13Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M17 13C19.209 13 21 14.791 21 17V19H17" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>

                <span class="rounded-full bg-blue-50 px-2 py-1 text-xs font-extrabold text-blue-900">
                    +12%
                </span>
            </div>

            <p class="mt-4 text-sm font-semibold text-slate-600">
                Total Pendaftar
            </p>

            <h2 id="totalCandidates" class="mt-1 text-3xl font-extrabold text-slate-900">
                0
            </h2>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-50 text-amber-700">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                    <path d="M7 4H17V20H7V4Z" stroke="currentColor" stroke-width="2"/>
                    <path d="M9 8H15M9 12H14M9 16H12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>

            <p class="mt-4 text-sm font-semibold text-slate-600">
                Menunggu Verifikasi
            </p>

            <h2 id="pendingCandidates" class="mt-1 text-3xl font-extrabold text-slate-900">
                0
            </h2>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-50 text-green-700">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                    <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>

            <p class="mt-4 text-sm font-semibold text-slate-600">
                Lolos Administrasi
            </p>

            <h2 id="validCandidates" class="mt-1 text-3xl font-extrabold text-slate-900">
                0
            </h2>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-50 text-red-600">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                    <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/>
                </svg>
            </div>

            <p class="mt-4 text-sm font-semibold text-slate-600">
                Ditolak
            </p>

            <h2 id="invalidCandidates" class="mt-1 text-3xl font-extrabold text-slate-900">
                0
            </h2>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-50 text-blue-900">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                    <path d="M7 3V6M17 3V6M4 9H20M5 5H19C19.552 5 20 5.448 20 6V20C20 20.552 19.552 21 19 21H5C4.448 21 4 20.552 4 20V6C4 5.448 4.448 5 5 5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M8 15L11 18L16 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>

            <p class="mt-4 text-sm font-semibold text-slate-600">
                Dijadwalkan
            </p>

            <h2 id="scheduledCandidates" class="mt-1 text-3xl font-extrabold text-slate-900">
                0
            </h2>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-50 text-amber-700">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                    <path d="M4 19V13M10 19V9M16 19V5M22 19H2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>

            <p class="mt-4 text-sm font-semibold text-slate-600">
                Sudah Dinilai
            </p>

            <h2 id="scoredCandidates" class="mt-1 text-3xl font-extrabold text-slate-900">
                0
            </h2>
        </div>

        <div class="rounded-2xl bg-blue-900 p-5 text-white shadow-sm xl:col-span-2">
            <div class="flex h-full min-h-36 flex-col justify-between">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-white/15 text-white">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                            <path d="M12 3L20 7V12C20 17 16.5 20.2 12 21C7.5 20.2 4 17 4 12V7L12 3Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                            <path d="M9 12L11 14L15.5 9.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>

                    <span id="systemBadge" class="rounded-full bg-white/15 px-3 py-1 text-xs font-extrabold text-white">
                        Sistem Aktif
                    </span>
                </div>

                <div class="mt-5">
                    <p class="text-sm font-semibold text-blue-100">
                        Status Pengumuman
                    </p>

                    <h2 id="systemStatusTitle" class="mt-1 text-2xl font-extrabold">
                        Memuat
                    </h2>

                    <p id="systemStatusDescription" class="mt-2 max-w-md text-sm font-semibold leading-6 text-blue-100">
                        Sistem sedang memuat ringkasan data.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Progress Seleksi --}}
    <section>
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-2xl font-extrabold text-slate-900">
                Progress Seleksi
            </h2>

            <a href="{{ route('admin.monitoring.index') }}" class="text-sm font-extrabold text-blue-900 hover:underline">
                Detail Alur
            </a>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div id="progressSteps" class="grid grid-cols-1 gap-4 md:grid-cols-3 xl:grid-cols-6"></div>
        </div>
    </section>

    {{-- Pendaftar Terbaru --}}
    <section>
        <div class="mb-4 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <h2 class="text-2xl font-extrabold text-slate-900">
                Pendaftar Terbaru
            </h2>

            <div class="flex flex-wrap gap-3">
                <a
                    href="{{ route('admin.candidates.index') }}"
                    class="inline-flex h-10 items-center justify-center rounded-lg border border-slate-300 bg-white px-4 text-sm font-bold text-slate-700 hover:bg-slate-50"
                >
                    Filter
                </a>

                <a
                    href="{{ route('admin.candidates.index') }}"
                    class="inline-flex h-10 items-center justify-center rounded-lg bg-blue-900 px-4 text-sm font-bold text-white hover:bg-blue-800"
                >
                    Lihat Semua
                </a>
            </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-5 py-4 text-left font-extrabold uppercase tracking-wide text-slate-500">
                                Nama
                            </th>
                            <th class="px-5 py-4 text-left font-extrabold uppercase tracking-wide text-slate-500">
                                NIM
                            </th>
                            <th class="px-5 py-4 text-left font-extrabold uppercase tracking-wide text-slate-500">
                                Program Studi
                            </th>
                            <th class="px-5 py-4 text-left font-extrabold uppercase tracking-wide text-slate-500">
                                Status
                            </th>
                            <th class="px-5 py-4 text-left font-extrabold uppercase tracking-wide text-slate-500">
                                Tanggal Daftar
                            </th>
                            <th class="px-5 py-4 text-right font-extrabold uppercase tracking-wide text-slate-500">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody id="latestCandidatesTable" class="divide-y divide-slate-100 bg-white">
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-slate-500">
                                Memuat data pendaftar...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-between border-t border-slate-200 bg-slate-50 px-5 py-4">
                <p id="tableInfo" class="text-sm font-semibold text-slate-500">
                    Menampilkan data pendaftar terbaru.
                </p>

                <div class="flex items-center gap-2 text-slate-400">
                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg border border-slate-200 bg-white">
                        ‹
                    </span>
                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg border border-slate-200 bg-white">
                        ›
                    </span>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    const dashboard = {
        activePeriod: null,
        candidates: [],
        interviews: [],
        arasResults: [],
        announcementPublished: false,
    };

    document.addEventListener('DOMContentLoaded', function () {
        loadDashboardData();
    });

    async function loadDashboardData() {
        try {
            const periodResult = await safeRequest('/periods?per_page=100');
            const periods = normalizeCollection(periodResult);

            dashboard.activePeriod = pickActivePeriod(periods);

            const periodId = dashboard.activePeriod?.id || 1;
            const query = new URLSearchParams({
                period_id: periodId,
                per_page: 100,
            });

            const [
                candidatesResult,
                interviewsResult,
                arasResult,
                publicResult,
            ] = await Promise.allSettled([
                DutaAdmin.request(`/candidates?${query.toString()}`),
                DutaAdmin.request(`/interviews?${query.toString()}`),
                DutaAdmin.request(`/aras-results?${query.toString()}`),
                DutaAdmin.request(`/public/results?period_id=${periodId}`),
            ]);

            dashboard.candidates = normalizeCollection(getSettledValue(candidatesResult));
            dashboard.interviews = normalizeCollection(getSettledValue(interviewsResult));
            dashboard.arasResults = normalizeCollection(getSettledValue(arasResult));
            dashboard.announcementPublished = detectPublishedAnnouncement(getSettledValue(publicResult));

            renderDashboard();
        } catch (error) {
            console.error('Gagal memuat dashboard:', error);
            showAlert('error', getErrorMessage(error, 'Dashboard gagal dimuat.'));
            renderErrorState();
        }
    }

    async function safeRequest(endpoint) {
        try {
            return await DutaAdmin.request(endpoint);
        } catch (error) {
            console.warn(`Request gagal: ${endpoint}`, error);
            return null;
        }
    }

    function renderDashboard() {
        const summary = getSummary();

        renderSubtitle();
        renderStats(summary);
        renderSystemStatus(summary);
        renderProgress(summary);
        renderLatestCandidates();
    }

    function getSummary() {
        const candidates = dashboard.candidates;

        const pending = candidates.filter(item => item.status === 'pending').length;
        const valid = candidates.filter(item => item.status === 'valid').length;
        const invalid = candidates.filter(item => item.status === 'invalid').length;

        const scheduled = candidates.filter(item => {
            return ['interview_scheduled', 'interviewed', 'scored'].includes(item.status);
        }).length;

        const scored = candidates.filter(item => item.status === 'scored').length;

        return {
            total: candidates.length,
            pending,
            valid,
            invalid,
            scheduled,
            scored,
            arasCount: dashboard.arasResults.length,
            published: dashboard.announcementPublished,
        };
    }

    function renderSubtitle() {
        const year = dashboard.activePeriod?.election_year || dashboard.activePeriod?.year || new Date().getFullYear();

        setText(
            'dashboardSubtitle',
            `Selamat datang kembali, Admin Seleksi Duta PNJ ${year}.`
        );
    }

    function renderStats(summary) {
        setText('totalCandidates', formatNumber(summary.total));
        setText('pendingCandidates', formatNumber(summary.pending));
        setText('validCandidates', formatNumber(summary.valid));
        setText('invalidCandidates', formatNumber(summary.invalid));
        setText('scheduledCandidates', formatNumber(summary.scheduled));
        setText('scoredCandidates', formatNumber(summary.scored));
    }

    function renderSystemStatus(summary) {
        if (!dashboard.activePeriod) {
            setText('systemStatusTitle', 'Belum Dibuka');
            setText('systemStatusDescription', 'Periode seleksi belum tersedia.');
            return;
        }

        if (summary.published) {
            setText('systemStatusTitle', 'Sudah Dipublish');
            setText('systemStatusDescription', 'Hasil seleksi sudah dapat dilihat publik.');
            return;
        }

        if (summary.arasCount > 0) {
            setText('systemStatusTitle', 'Siap Publish');
            setText('systemStatusDescription', 'Hasil ARAS sudah tersedia dan menunggu pengumuman.');
            return;
        }

        const status = dashboard.activePeriod.status || 'draft';

        const labels = {
            draft: 'Belum Dibuka',
            registration: 'Pendaftaran Dibuka',
            interview: 'Tahap Wawancara',
            scoring: 'Tahap Penilaian',
            finished: 'Selesai',
        };

        const descriptions = {
            draft: 'Periode sudah dibuat, tetapi pendaftaran belum dibuka.',
            registration: 'Pendaftaran sedang berjalan. Pantau dan verifikasi data pendaftar.',
            interview: 'Tahap wawancara sedang berjalan.',
            scoring: 'Tahap penilaian sedang berjalan.',
            finished: 'Periode sudah selesai. Kelola hasil pada halaman pengumuman.',
        };

        setText('systemStatusTitle', labels[status] || 'Berjalan');
        setText('systemStatusDescription', descriptions[status] || 'Sistem berjalan normal.');
    }

    function renderProgress(summary) {
        const target = document.getElementById('progressSteps');

        if (!target) {
            return;
        }

        const steps = [
            {
                number: 1,
                label: 'Pendaftaran',
                active: Boolean(dashboard.activePeriod) || summary.total > 0,
            },
            {
                number: 2,
                label: 'Verifikasi',
                active: summary.pending + summary.valid + summary.invalid > 0,
            },
            {
                number: 3,
                label: 'Jadwal Wawancara',
                active: summary.scheduled > 0 || dashboard.interviews.length > 0,
            },
            {
                number: 4,
                label: 'Penilaian Juri',
                active: summary.scored > 0,
            },
            {
                number: 5,
                label: 'Perhitungan ARAS',
                active: summary.arasCount > 0,
            },
            {
                number: 6,
                label: 'Pengumuman',
                active: summary.published,
            },
        ];

        target.innerHTML = steps.map(function (step, index) {
            const activeNumber = step.active
                ? 'bg-blue-900 text-white'
                : 'bg-slate-200 text-slate-500';

            const activeText = step.active
                ? 'text-blue-900'
                : 'text-slate-500';

            const connector = index < steps.length - 1
                ? `<div class="hidden xl:block absolute left-[calc(50%+24px)] right-[calc(-50%+24px)] top-5 h-px bg-slate-300"></div>`
                : '';

            return `
                <div class="relative text-center">
                    ${connector}

                    <div class="relative mx-auto flex h-11 w-11 items-center justify-center rounded-full text-sm font-extrabold ${activeNumber}">
                        ${step.number}
                    </div>

                    <p class="mt-3 text-xs font-extrabold ${activeText}">
                        ${escapeHtml(step.label)}
                    </p>
                </div>
            `;
        }).join('');
    }

    function renderLatestCandidates() {
        const tableBody = document.getElementById('latestCandidatesTable');
        const tableInfo = document.getElementById('tableInfo');

        if (!tableBody) {
            return;
        }

        const candidates = [...dashboard.candidates]
            .sort((a, b) => new Date(b.created_at || 0) - new Date(a.created_at || 0))
            .slice(0, 5);

        if (!candidates.length) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="6" class="px-5 py-8 text-center text-slate-500">
                        Belum ada data pendaftar pada periode aktif.
                    </td>
                </tr>
            `;

            if (tableInfo) {
                tableInfo.textContent = 'Menampilkan 0 data pendaftar.';
            }

            return;
        }

        tableBody.innerHTML = candidates.map(function (candidate) {
            const name = candidate.full_name || '-';
            const initial = getInitial(name);
            const detailUrl = `/admin/candidates/${candidate.id}`;

            return `
                <tr class="hover:bg-slate-50">
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-50 text-xs font-extrabold text-blue-900">
                                ${escapeHtml(initial)}
                            </div>

                            <p class="font-extrabold text-slate-900">
                                ${escapeHtml(name)}
                            </p>
                        </div>
                    </td>

                    <td class="px-5 py-4 font-semibold text-slate-600">
                        ${escapeHtml(candidate.student_number || '-')}
                    </td>

                    <td class="px-5 py-4 font-semibold text-slate-600">
                        ${escapeHtml(candidate.study_program || '-')}
                    </td>

                    <td class="px-5 py-4">
                        ${renderStatusBadge(candidate.status)}
                    </td>

                    <td class="px-5 py-4 font-semibold text-slate-600">
                        ${formatDate(candidate.created_at)}
                    </td>

                    <td class="px-5 py-4 text-right">
                        <a href="${detailUrl}" class="text-sm font-extrabold text-blue-900 hover:underline">
                            Detail
                        </a>
                    </td>
                </tr>
            `;
        }).join('');

        if (tableInfo) {
            tableInfo.textContent = `Menampilkan ${candidates.length} dari ${dashboard.candidates.length} pendaftar.`;
        }
    }

    function renderErrorState() {
        const tableBody = document.getElementById('latestCandidatesTable');

        if (tableBody) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="6" class="px-5 py-8 text-center text-red-600">
                        Dashboard gagal memuat data. Coba refresh halaman.
                    </td>
                </tr>
            `;
        }
    }

    function pickActivePeriod(periods) {
        if (!periods.length) {
            return null;
        }

        const activeStatuses = ['registration', 'interview', 'scoring'];
        const active = periods.find(period => activeStatuses.includes(period.status));

        if (active) {
            return active;
        }

        return [...periods].sort((a, b) => {
            return Number(b.election_year || 0) - Number(a.election_year || 0);
        })[0];
    }

    function normalizeCollection(result) {
        if (!result) {
            return [];
        }

        if (Array.isArray(result)) {
            return result;
        }

        if (Array.isArray(result.data?.data)) {
            return result.data.data;
        }

        if (Array.isArray(result.data)) {
            return result.data;
        }

        if (Array.isArray(result.items)) {
            return result.items;
        }

        if (Array.isArray(result.data?.items)) {
            return result.data.items;
        }

        if (Array.isArray(result.data?.results)) {
            return result.data.results;
        }

        return [];
    }

    function getSettledValue(result) {
        return result.status === 'fulfilled' ? result.value : null;
    }

    function detectPublishedAnnouncement(result) {
        if (!result) {
            return false;
        }

        if (result.data?.is_published === true) {
            return true;
        }

        if (result.data?.published_at) {
            return true;
        }

        if (Array.isArray(result.data?.results) && result.data.results.length > 0) {
            return true;
        }

        if (Array.isArray(result.data) && result.data.length > 0) {
            return true;
        }

        return false;
    }

    function renderStatusBadge(status) {
        const labels = {
            pending: 'Menunggu',
            valid: 'Terverifikasi',
            invalid: 'Ditolak',
            interview_scheduled: 'Terjadwal',
            interviewed: 'Wawancara',
            scored: 'Sudah Dinilai',
        };

        const classes = {
            pending: 'bg-amber-100 text-amber-700',
            valid: 'bg-green-100 text-green-700',
            invalid: 'bg-red-100 text-red-700',
            interview_scheduled: 'bg-slate-100 text-slate-700',
            interviewed: 'bg-slate-100 text-slate-700',
            scored: 'bg-slate-100 text-slate-700',
        };

        return `
            <span class="inline-flex rounded-full px-3 py-1 text-xs font-extrabold ${classes[status] || 'bg-slate-100 text-slate-700'}">
                ${escapeHtml(labels[status] || status || '-')}
            </span>
        `;
    }

    function formatDate(value) {
        if (!value) {
            return '-';
        }

        const date = new Date(value);

        if (Number.isNaN(date.getTime())) {
            return '-';
        }

        return date.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'short',
            year: 'numeric',
        });
    }

    function formatNumber(value) {
        return new Intl.NumberFormat('id-ID').format(Number(value || 0));
    }

    function getInitial(name) {
        return String(name || '-')
            .trim()
            .split(/\s+/)
            .slice(0, 2)
            .map(word => word.charAt(0).toUpperCase())
            .join('');
    }

    function showAlert(type, message) {
        const alert = document.getElementById('pageAlert');

        if (!alert) {
            return;
        }

        const classes = {
            success: 'border-green-200 bg-green-50 text-green-700',
            error: 'border-red-200 bg-red-50 text-red-700',
            info: 'border-blue-200 bg-blue-50 text-blue-700',
        };

        alert.className = `rounded-xl border px-4 py-3 text-sm font-semibold ${classes[type] || classes.info}`;
        alert.textContent = message;
        alert.classList.remove('hidden');
    }

    function getErrorMessage(error, fallback = 'Terjadi kesalahan.') {
        if (typeof error === 'string') {
            return error;
        }

        if (error?.message) {
            return error.message;
        }

        return fallback;
    }

    function setText(id, value) {
        const element = document.getElementById(id);

        if (element) {
            element.textContent = value;
        }
    }

    function escapeHtml(value) {
        return String(value ?? '-')
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }
</script>
@endpush