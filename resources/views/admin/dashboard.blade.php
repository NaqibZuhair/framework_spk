@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    {{-- Header --}}
    <section class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <h1 class="text-4xl font-extrabold tracking-tight text-blue-900">
                Ringkasan Dashboard
            </h1>

            <p id="dashboardSubtitle" class="mt-2 text-sm font-semibold text-slate-500">
                Memuat ringkasan periode seleksi aktif...
            </p>
        </div>

        <div class="flex flex-wrap gap-3">
            <a
                href="{{ route('admin.candidates.index') }}"
                class="inline-flex h-11 items-center justify-center rounded-lg border border-slate-300 bg-white px-4 text-sm font-bold text-slate-700 transition hover:bg-slate-50"
            >
                Data Pendaftar
            </a>

            <a
                href="{{ route('admin.aras.index') }}"
                class="inline-flex h-11 items-center justify-center rounded-lg bg-blue-900 px-4 text-sm font-bold text-white transition hover:bg-blue-800"
            >
                Lihat Hasil ARAS
            </a>
        </div>
    </section>

    <div id="pageAlert" class="hidden rounded-xl border px-4 py-3 text-sm font-semibold"></div>

    {{-- Periode Aktif --}}
    <section class="grid grid-cols-1 gap-5 xl:grid-cols-3">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm xl:col-span-2">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <p class="text-sm font-extrabold uppercase tracking-wide text-slate-400">
                        Periode Aktif
                    </p>

                    <h2 id="activePeriodTitle" class="mt-2 text-3xl font-extrabold text-slate-900">
                        -
                    </h2>

                    <p id="activePeriodDescription" class="mt-2 text-sm leading-6 text-slate-500">
                        Data periode belum tersedia.
                    </p>
                </div>

                <div id="activePeriodBadge">
                    <span class="inline-flex rounded-full border border-slate-200 bg-slate-100 px-4 py-2 text-sm font-extrabold text-slate-700">
                        Memuat
                    </span>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-3">
                <div class="rounded-xl bg-slate-50 p-4">
                    <p class="text-xs font-extrabold uppercase tracking-wide text-slate-400">
                        Pendaftaran
                    </p>
                    <p id="registrationRange" class="mt-2 text-sm font-bold text-slate-800">
                        -
                    </p>
                </div>

                <div class="rounded-xl bg-slate-50 p-4">
                    <p class="text-xs font-extrabold uppercase tracking-wide text-slate-400">
                        Wawancara
                    </p>
                    <p id="interviewRange" class="mt-2 text-sm font-bold text-slate-800">
                        -
                    </p>
                </div>

                <div class="rounded-xl bg-slate-50 p-4">
                    <p class="text-xs font-extrabold uppercase tracking-wide text-slate-400">
                        Pengumuman
                    </p>
                    <p id="announcementSummary" class="mt-2 text-sm font-bold text-slate-800">
                        Belum dipublish
                    </p>
                </div>
            </div>
        </div>

        <div class="rounded-2xl bg-blue-900 p-6 text-white shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold text-blue-100">
                        Status Sistem
                    </p>

                    <h2 id="systemStatusTitle" class="mt-3 text-3xl font-extrabold">
                        Memuat
                    </h2>

                    <p id="systemStatusDescription" class="mt-3 text-sm font-semibold leading-6 text-blue-100">
                        Sistem sedang memuat ringkasan data.
                    </p>
                </div>

                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-white text-blue-900">
                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none">
                        <path d="M12 3L20 7V12C20 17 16.5 20.2 12 21C7.5 20.2 4 17 4 12V7L12 3Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                        <path d="M9 12L11 14L15.5 9.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    {{-- Statistik Utama --}}
    <section class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-900">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none">
                    <path d="M16 11C17.657 11 19 9.657 19 8C19 6.343 17.657 5 16 5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M8 11C9.657 11 11 9.657 11 8C11 6.343 9.657 5 8 5C6.343 5 5 6.343 5 8C5 9.657 6.343 11 8 11Z" stroke="currentColor" stroke-width="2"/>
                    <path d="M8 13C5.239 13 3 15.239 3 18V19H13V18C13 15.239 10.761 13 8 13Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M17 13C19.209 13 21 14.791 21 17V19H17" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>

            <p class="mt-5 text-sm font-bold text-slate-600">
                Total Pendaftar
            </p>

            <h2 id="totalCandidates" class="mt-2 text-4xl font-extrabold text-slate-900">
                0
            </h2>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-700">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none">
                    <path d="M7 4H17V20H7V4Z" stroke="currentColor" stroke-width="2"/>
                    <path d="M9 8H15M9 12H14M9 16H12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>

            <p class="mt-5 text-sm font-bold text-slate-600">
                Menunggu Verifikasi
            </p>

            <h2 id="pendingCandidates" class="mt-2 text-4xl font-extrabold text-amber-600">
                0
            </h2>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-green-50 text-green-700">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none">
                    <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>

            <p class="mt-5 text-sm font-bold text-slate-600">
                Lolos Administrasi
            </p>

            <h2 id="validCandidates" class="mt-2 text-4xl font-extrabold text-green-600">
                0
            </h2>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-50 text-red-600">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none">
                    <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                </svg>
            </div>

            <p class="mt-5 text-sm font-bold text-slate-600">
                Ditolak
            </p>

            <h2 id="invalidCandidates" class="mt-2 text-4xl font-extrabold text-red-600">
                0
            </h2>
        </div>
    </section>

    {{-- Statistik Proses --}}
    <section class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-bold text-slate-600">
                Terjadwal Wawancara
            </p>
            <h2 id="scheduledCandidates" class="mt-2 text-4xl font-extrabold text-slate-900">
                0
            </h2>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-bold text-slate-600">
                Sudah Dinilai
            </p>
            <h2 id="scoredCandidates" class="mt-2 text-4xl font-extrabold text-slate-900">
                0
            </h2>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-bold text-slate-600">
                Juri Aktif
            </p>
            <h2 id="activeJuries" class="mt-2 text-4xl font-extrabold text-slate-900">
                0
            </h2>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-bold text-slate-600">
                Hasil ARAS
            </p>
            <h2 id="arasResultCount" class="mt-2 text-4xl font-extrabold text-slate-900">
                0
            </h2>
        </div>
    </section>

    {{-- Perlu Tindakan --}}
    <section>
        <div class="mb-4 flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-900">
                    Perlu Tindakan
                </h2>

                <p class="mt-1 text-sm font-semibold text-slate-500">
                    Daftar pekerjaan yang perlu diproses admin berdasarkan kondisi data saat ini.
                </p>
            </div>
        </div>

        <div id="actionItems" class="grid grid-cols-1 gap-4 lg:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-semibold text-slate-500">
                    Memuat rekomendasi tindakan...
                </p>
            </div>
        </div>
    </section>

    {{-- Progress Seleksi --}}
    <section>
        <div class="mb-4 flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-900">
                    Progress Seleksi
                </h2>

                <p class="mt-1 text-sm font-semibold text-slate-500">
                    Tahapan seleksi berdasarkan data yang sudah diproses.
                </p>
            </div>

            <a href="{{ route('admin.monitoring.index') }}" class="text-sm font-extrabold text-blue-900 hover:underline">
                Cek Monitoring
            </a>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div id="progressSteps" class="grid grid-cols-1 gap-4 md:grid-cols-3 xl:grid-cols-6"></div>
        </div>
    </section>

    {{-- Pendaftar Terbaru --}}
    <section>
        <div class="mb-4 flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-900">
                    Pendaftar Terbaru
                </h2>

                <p class="mt-1 text-sm font-semibold text-slate-500">
                    Lima data pendaftar terbaru pada periode aktif.
                </p>
            </div>

            <a href="{{ route('admin.candidates.index') }}" class="text-sm font-extrabold text-blue-900 hover:underline">
                Lihat Semua Pendaftar
            </a>
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

            <div class="border-t border-slate-200 bg-slate-50 px-5 py-4">
                <p id="tableInfo" class="text-sm font-semibold text-slate-500">
                    Menampilkan data pendaftar terbaru.
                </p>
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
        juries: [],
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
                juriesResult,
                interviewsResult,
                arasResult,
                publicResult,
            ] = await Promise.allSettled([
                DutaAdmin.request(`/candidates?${query.toString()}`),
                DutaAdmin.request(`/juries?${query.toString()}`),
                DutaAdmin.request(`/interviews?${query.toString()}`),
                DutaAdmin.request(`/aras-results?${query.toString()}`),
                DutaAdmin.request(`/public/results?period_id=${periodId}`),
            ]);

            dashboard.candidates = normalizeCollection(getSettledValue(candidatesResult));
            dashboard.juries = normalizeCollection(getSettledValue(juriesResult));
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

        renderActivePeriod();
        renderStats(summary);
        renderSystemStatus(summary);
        renderActionItems(summary);
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

        const activeJuries = dashboard.juries.filter(item => {
            return item.is_active === true || item.is_active === 1 || item.status === 'active';
        }).length || dashboard.juries.length;

        return {
            total: candidates.length,
            pending,
            valid,
            invalid,
            scheduled,
            scored,
            activeJuries,
            arasCount: dashboard.arasResults.length,
            published: dashboard.announcementPublished,
            notScheduled: Math.max(valid - scheduled, 0),
            scoringIncomplete: Math.max(scheduled - scored, 0),
        };
    }

    function renderActivePeriod() {
        const period = dashboard.activePeriod;

        if (!period) {
            setText('dashboardSubtitle', 'Belum ada periode seleksi yang tersedia.');
            setText('activePeriodTitle', 'Periode belum tersedia');
            setText('activePeriodDescription', 'Tambahkan periode seleksi terlebih dahulu sebelum mengelola proses seleksi.');
            setText('registrationRange', '-');
            setText('interviewRange', '-');
            setText('announcementSummary', 'Belum dipublish');

            setHtml('activePeriodBadge', statusBadge('default', 'Belum Ada Periode'));
            return;
        }

        const year = period.election_year || period.year || '-';
        const status = period.status || 'draft';

        setText('dashboardSubtitle', `Selamat datang kembali. Berikut ringkasan seleksi Duta PNJ periode ${year}.`);
        setText('activePeriodTitle', `Duta PNJ ${year}`);
        setText('activePeriodDescription', getPeriodStatusDescription(status));
        setText('registrationRange', formatRange(period.registration_start, period.registration_end));
        setText('interviewRange', formatRange(period.interview_start, period.interview_end));
        setText('announcementSummary', dashboard.announcementPublished ? 'Sudah dipublish' : 'Belum dipublish');

        setHtml('activePeriodBadge', periodStatusBadge(status));
    }

    function renderStats(summary) {
        setText('totalCandidates', formatNumber(summary.total));
        setText('pendingCandidates', formatNumber(summary.pending));
        setText('validCandidates', formatNumber(summary.valid));
        setText('invalidCandidates', formatNumber(summary.invalid));
        setText('scheduledCandidates', formatNumber(summary.scheduled));
        setText('scoredCandidates', formatNumber(summary.scored));
        setText('activeJuries', formatNumber(summary.activeJuries));
        setText('arasResultCount', formatNumber(summary.arasCount));
    }

    function renderSystemStatus(summary) {
        if (!dashboard.activePeriod) {
            setText('systemStatusTitle', 'Perlu Periode');
            setText('systemStatusDescription', 'Buat periode seleksi terlebih dahulu agar data dashboard dapat ditampilkan dengan benar.');
            return;
        }

        if (summary.pending > 0) {
            setText('systemStatusTitle', 'Perlu Verifikasi');
            setText('systemStatusDescription', `${summary.pending} pendaftar masih menunggu verifikasi admin.`);
            return;
        }

        if (summary.notScheduled > 0) {
            setText('systemStatusTitle', 'Perlu Jadwal');
            setText('systemStatusDescription', `${summary.notScheduled} pendaftar lolos administrasi belum dijadwalkan wawancara.`);
            return;
        }

        if (summary.scoringIncomplete > 0) {
            setText('systemStatusTitle', 'Penilaian Berjalan');
            setText('systemStatusDescription', `${summary.scoringIncomplete} peserta terjadwal belum selesai dinilai.`);
            return;
        }

        if (summary.arasCount > 0 && !summary.published) {
            setText('systemStatusTitle', 'Siap Publish');
            setText('systemStatusDescription', 'Hasil ARAS sudah tersedia. Periksa ulang sebelum pengumuman dipublish.');
            return;
        }

        if (summary.published) {
            setText('systemStatusTitle', 'Selesai');
            setText('systemStatusDescription', 'Hasil seleksi sudah dipublish dan dapat dilihat publik.');
            return;
        }

        setText('systemStatusTitle', 'Berjalan');
        setText('systemStatusDescription', 'Belum ada tindakan mendesak pada periode aktif.');
    }

    function renderActionItems(summary) {
        const target = document.getElementById('actionItems');

        if (!target) {
            return;
        }

        const items = [
            {
                title: 'Verifikasi Pendaftar',
                count: summary.pending,
                description: 'Pendaftar menunggu validasi data dan dokumen.',
                href: '{{ route('admin.candidates.index') }}',
                action: 'Buka Data Pendaftar',
                variant: 'warning',
            },
            {
                title: 'Generate Jadwal',
                count: summary.notScheduled,
                description: 'Pendaftar lolos administrasi belum memiliki jadwal wawancara.',
                href: '{{ route('admin.interviews.index') }}',
                action: 'Atur Jadwal',
                variant: 'primary',
            },
            {
                title: 'Cek Penilaian',
                count: summary.scoringIncomplete,
                description: 'Peserta terjadwal belum selesai dinilai oleh juri.',
                href: '{{ route('admin.monitoring.index') }}',
                action: 'Cek Monitoring',
                variant: 'info',
            },
            {
                title: 'Publish Pengumuman',
                count: summary.arasCount > 0 && !summary.published ? 1 : 0,
                description: 'Hasil ARAS tersedia dan menunggu pengumuman.',
                href: '{{ route('admin.announcements.index') }}',
                action: 'Kelola Pengumuman',
                variant: 'success',
            },
        ];

        const visibleItems = items.filter(item => item.count > 0);

        if (!visibleItems.length) {
            target.innerHTML = `
                <div class="rounded-2xl border border-green-200 bg-green-50 p-5 shadow-sm lg:col-span-2 xl:col-span-4">
                    <p class="text-base font-extrabold text-green-700">
                        Tidak ada tindakan mendesak.
                    </p>
                    <p class="mt-2 text-sm font-semibold leading-6 text-green-700">
                        Semua proses utama pada periode aktif sudah berada dalam kondisi aman.
                    </p>
                </div>
            `;
            return;
        }

        target.innerHTML = visibleItems.map(item => actionCard(item)).join('');
    }

    function actionCard(item) {
        const color = {
            warning: 'border-amber-200 bg-amber-50 text-amber-700',
            primary: 'border-blue-200 bg-blue-50 text-blue-700',
            info: 'border-sky-200 bg-sky-50 text-sky-700',
            success: 'border-green-200 bg-green-50 text-green-700',
        }[item.variant] || 'border-slate-200 bg-white text-slate-700';

        return `
            <div class="rounded-2xl border ${color} p-5 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-extrabold">
                            ${escapeHtml(item.title)}
                        </p>

                        <p class="mt-2 text-3xl font-extrabold">
                            ${formatNumber(item.count)}
                        </p>
                    </div>
                </div>

                <p class="mt-3 text-sm font-semibold leading-6">
                    ${escapeHtml(item.description)}
                </p>

                <a href="${item.href}" class="mt-4 inline-flex text-sm font-extrabold hover:underline">
                    ${escapeHtml(item.action)}
                </a>
            </div>
        `;
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
                label: 'Wawancara',
                active: summary.scheduled > 0 || dashboard.interviews.length > 0,
            },
            {
                number: 4,
                label: 'Penilaian',
                active: summary.scored > 0,
            },
            {
                number: 5,
                label: 'ARAS',
                active: summary.arasCount > 0,
            },
            {
                number: 6,
                label: 'Pengumuman',
                active: summary.published,
            },
        ];

        target.innerHTML = steps.map(step => {
            const numberClass = step.active
                ? 'bg-blue-900 text-white'
                : 'bg-slate-100 text-slate-400';

            const textClass = step.active
                ? 'text-blue-900'
                : 'text-slate-400';

            return `
                <div class="text-center">
                    <div class="mx-auto flex h-11 w-11 items-center justify-center rounded-full text-sm font-extrabold ${numberClass}">
                        ${step.number}
                    </div>

                    <p class="mt-3 text-sm font-extrabold ${textClass}">
                        ${step.label}
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

        tableBody.innerHTML = candidates.map(candidate => {
            const name = candidate.full_name || '-';
            const nim = candidate.student_number || '-';
            const program = candidate.study_program || '-';
            const faculty = candidate.faculty || '-';
            const status = candidate.status || '-';
            const createdAt = formatDate(candidate.created_at);
            const initial = getInitial(name);
            const detailUrl = `/admin/candidates/${candidate.id}`;

            return `
                <tr class="hover:bg-slate-50">
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-blue-100 text-xs font-extrabold text-blue-900">
                                ${escapeHtml(initial)}
                            </div>

                            <div>
                                <p class="font-extrabold text-slate-900">
                                    ${escapeHtml(name)}
                                </p>
                                <p class="mt-1 text-xs font-semibold text-slate-500">
                                    ${escapeHtml(candidate.registration_number || '-')}
                                </p>
                            </div>
                        </div>
                    </td>

                    <td class="px-5 py-4 font-semibold text-slate-600">
                        ${escapeHtml(nim)}
                    </td>

                    <td class="px-5 py-4">
                        <p class="font-semibold text-slate-800">
                            ${escapeHtml(program)}
                        </p>
                        <p class="mt-1 text-xs font-semibold text-slate-500">
                            ${escapeHtml(faculty)}
                        </p>
                    </td>

                    <td class="px-5 py-4">
                        ${renderStatusBadge(status)}
                    </td>

                    <td class="px-5 py-4 font-semibold text-slate-600">
                        ${createdAt}
                    </td>

                    <td class="px-5 py-4 text-right">
                        <a href="${detailUrl}" class="inline-flex h-9 items-center justify-center rounded-lg border border-blue-200 px-3 text-sm font-extrabold text-blue-900 hover:bg-blue-50">
                            Detail
                        </a>
                    </td>
                </tr>
            `;
        }).join('');

        if (tableInfo) {
            tableInfo.textContent = `Menampilkan ${candidates.length} dari ${dashboard.candidates.length} pendaftar periode aktif.`;
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

        if (Array.isArray(result.data?.items)) {
            return result.data.items;
        }

        if (Array.isArray(result.items)) {
            return result.items;
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

    function periodStatusBadge(status) {
        const badges = {
            draft: {
                label: 'Draft',
                type: 'default',
            },
            registration: {
                label: 'Pendaftaran Dibuka',
                type: 'success',
            },
            interview: {
                label: 'Tahap Wawancara',
                type: 'primary',
            },
            scoring: {
                label: 'Tahap Penilaian',
                type: 'warning',
            },
            finished: {
                label: 'Selesai',
                type: 'default',
            },
        };

        const badge = badges[status] || {
            label: status || '-',
            type: 'default',
        };

        return statusBadge(badge.type, badge.label);
    }

    function statusBadge(type, label) {
        const classes = {
            default: 'border-slate-200 bg-slate-100 text-slate-700',
            primary: 'border-blue-200 bg-blue-100 text-blue-700',
            success: 'border-green-200 bg-green-100 text-green-700',
            warning: 'border-amber-200 bg-amber-100 text-amber-700',
            danger: 'border-red-200 bg-red-100 text-red-700',
        };

        return `
            <span class="inline-flex rounded-full border px-4 py-2 text-sm font-extrabold ${classes[type] || classes.default}">
                ${escapeHtml(label)}
            </span>
        `;
    }

    function renderStatusBadge(status) {
        const labels = {
            pending: 'Menunggu Verifikasi',
            valid: 'Lolos Administrasi',
            invalid: 'Ditolak',
            interview_scheduled: 'Terjadwal Wawancara',
            interviewed: 'Sudah Wawancara',
            scored: 'Sudah Dinilai',
        };

        const classes = {
            pending: 'bg-amber-100 text-amber-700',
            valid: 'bg-green-100 text-green-700',
            invalid: 'bg-red-100 text-red-700',
            interview_scheduled: 'bg-blue-100 text-blue-700',
            interviewed: 'bg-indigo-100 text-indigo-700',
            scored: 'bg-purple-100 text-purple-700',
        };

        return `
            <span class="inline-flex rounded-full px-3 py-1 text-xs font-extrabold ${classes[status] || 'bg-slate-100 text-slate-700'}">
                ${escapeHtml(labels[status] || status || '-')}
            </span>
        `;
    }

    function getPeriodStatusDescription(status) {
        const descriptions = {
            draft: 'Periode seleksi sudah dibuat, tetapi belum dibuka untuk pendaftaran.',
            registration: 'Periode pendaftaran sedang berjalan. Admin dapat memantau dan memverifikasi pendaftar.',
            interview: 'Tahap wawancara sedang berjalan. Pastikan semua peserta memiliki jadwal.',
            scoring: 'Tahap penilaian sedang berjalan. Pantau kelengkapan nilai dari juri.',
            finished: 'Periode seleksi sudah selesai. Hasil dapat dikelola pada halaman pengumuman.',
        };

        return descriptions[status] || 'Periode seleksi sedang berjalan.';
    }

    function formatRange(start, end) {
        if (!start && !end) {
            return '-';
        }

        return `${formatDate(start)} sampai ${formatDate(end)}`;
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

    function setHtml(id, value) {
        const element = document.getElementById(id);

        if (element) {
            element.innerHTML = value;
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