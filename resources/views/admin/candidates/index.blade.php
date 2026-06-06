@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
                Data Pendaftar
            </h1>

            <p class="mt-2 text-sm text-slate-500">
                Kelola dan verifikasi seluruh calon pendaftar seleksi Duta PNJ.
            </p>
        </div>
    </div>

    <div id="pageAlert" class="hidden rounded-xl border px-4 py-3 text-sm font-semibold"></div>

    <div class="grid grid-cols-1 gap-4 xl:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm xl:col-span-3">
            <div class="grid grid-cols-1 gap-3 md:grid-cols-12">
                <div class="md:col-span-7">
                    <label for="keywordInput" class="mb-2 block text-sm font-bold text-slate-700">
                        Pencarian
                    </label>

                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                                <path d="M21 21L16.65 16.65" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/>
                            </svg>
                        </span>

                        <input
                            id="keywordInput"
                            type="text"
                            placeholder="Cari nama, NIM, email, atau program studi..."
                            class="w-full rounded-xl border border-slate-300 bg-slate-50 py-3 pl-10 pr-4 text-sm outline-none transition focus:border-blue-900 focus:bg-white focus:ring-2 focus:ring-blue-100"
                        >
                    </div>
                </div>

                <div class="md:col-span-3">
                    <label for="statusInput" class="mb-2 block text-sm font-bold text-slate-700">
                        Status
                    </label>

                    <select
                        id="statusInput"
                        class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-blue-900 focus:bg-white focus:ring-2 focus:ring-blue-100"
                    >
                        <option value="">Semua Status</option>
                        <option value="pending">Menunggu Verifikasi</option>
                        <option value="valid">Diterima</option>
                        <option value="invalid">Ditolak</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-bold text-transparent">
                        Aksi
                    </label>

                    <button
                        id="filterBtn"
                        type="button"
                        class="flex w-full items-center justify-center gap-2 rounded-xl bg-blue-900 px-4 py-3 text-sm font-extrabold text-white transition hover:bg-blue-800"
                    >
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none">
                            <path d="M4 6H20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <path d="M7 12H17" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <path d="M10 18H14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        Filter
                    </button>
                </div>
            </div>
        </div>

        <div class="rounded-2xl bg-blue-900 p-5 text-white shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold text-blue-100">
                        Total Pendaftar
                    </p>

                    <h2 id="totalCandidates" class="mt-2 text-3xl font-extrabold">
                        0
                    </h2>

                    <p id="totalDescription" class="mt-3 text-xs font-semibold text-blue-100">
                        Berdasarkan filter aktif
                    </p>
                </div>

                <div class="rounded-full bg-white bg-opacity-10 p-3">
                    <svg class="h-7 w-7 text-blue-100" viewBox="0 0 24 24" fill="none">
                        <path d="M16 20V18C16 15.8 14.2 14 12 14H6C3.8 14 2 15.8 2 18V20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="2"/>
                        <path d="M19 8V14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M22 11H16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-5 py-4 text-left font-extrabold uppercase tracking-wide text-slate-500">No</th>
                        <th class="px-5 py-4 text-left font-extrabold uppercase tracking-wide text-slate-500">Nama & NIM</th>
                        <th class="px-5 py-4 text-left font-extrabold uppercase tracking-wide text-slate-500">Program Studi</th>
                        <th class="px-5 py-4 text-left font-extrabold uppercase tracking-wide text-slate-500">Status</th>
                        <th class="px-5 py-4 text-left font-extrabold uppercase tracking-wide text-slate-500">Tanggal Daftar</th>
                        <th class="px-5 py-4 text-center font-extrabold uppercase tracking-wide text-slate-500">Aksi</th>
                    </tr>
                </thead>

                <tbody id="candidateTableBody" class="divide-y divide-slate-100 bg-white">
                    <tr>
                        <td colspan="6" class="px-5 py-8 text-center text-slate-500">
                            Memuat data pendaftar...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex flex-col gap-3 border-t border-slate-200 bg-slate-50 px-5 py-4 md:flex-row md:items-center md:justify-between">
            <p id="paginationInfo" class="text-sm text-slate-600">
                Menampilkan 0 data
            </p>

            <div id="paginationWrapper" class="flex flex-wrap items-center gap-2"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let currentPage = 1;
    let lastPage = 1;

    const showBaseUrl = "{{ url('/admin/candidates') }}";

    document.addEventListener('DOMContentLoaded', function () {
        loadCandidates();

        document.getElementById('filterBtn')?.addEventListener('click', function () {
            currentPage = 1;
            loadCandidates();
        });

        document.getElementById('keywordInput')?.addEventListener('keyup', function (event) {
            if (event.key === 'Enter') {
                currentPage = 1;
                loadCandidates();
            }
        });

        document.getElementById('statusInput')?.addEventListener('change', function () {
            currentPage = 1;
            loadCandidates();
        });

        document.getElementById('paginationWrapper')?.addEventListener('click', function (event) {
            const button = event.target.closest('button');

            if (!button || button.disabled) {
                return;
            }

            const page = Number(button.dataset.page);

            if (!page || page === currentPage) {
                return;
            }

            currentPage = page;
            loadCandidates();
        });
    });

    async function loadCandidates() {
        setTableLoading();

        const params = new URLSearchParams();
        const keyword = document.getElementById('keywordInput')?.value.trim() || '';
        const status = document.getElementById('statusInput')?.value || '';

        params.append('page', currentPage);
        params.append('per_page', '10');

        if (keyword) {
            params.append('keyword', keyword);
        }

        if (status) {
            params.append('status', status);
        }

        try {
            const result = await DutaAdmin.request(`/candidates?${params.toString()}`);
            const paginator = result?.data || {};
            const candidates = Array.isArray(paginator.data) ? paginator.data : [];

            currentPage = Number(paginator.current_page || 1);
            lastPage = Number(paginator.last_page || 1);

            renderCandidates(candidates, paginator);
            renderPagination(paginator);
            setText('totalCandidates', formatNumber(paginator.total || candidates.length));
        } catch (error) {
            console.error('Gagal memuat data pendaftar:', error);
            renderTableError(getErrorMessage(error, 'Data pendaftar gagal dimuat.'));
        }
    }

    function renderCandidates(candidates, paginator) {
        const tableBody = document.getElementById('candidateTableBody');

        if (!tableBody) {
            return;
        }

        if (!candidates.length) {
            tableBody.innerHTML = emptyRow('Belum ada data pendaftar.');
            setText('paginationInfo', 'Menampilkan 0 data');
            return;
        }

        const firstItem = Number(paginator.from || 1);

        tableBody.innerHTML = candidates.map(function (candidate, index) {
            return `
                <tr class="hover:bg-slate-50">
                    <td class="px-5 py-4 text-slate-600">
                        ${firstItem + index}
                    </td>

                    <td class="px-5 py-4">
                        <p class="font-extrabold text-slate-900">
                            ${escapeHtml(candidate.full_name || '-')}
                        </p>
                        <p class="mt-1 text-xs text-slate-500">
                            ${escapeHtml(candidate.student_number || '-')}
                        </p>
                    </td>

                    <td class="px-5 py-4">
                        <p class="font-semibold text-slate-800">
                            ${escapeHtml(candidate.study_program || '-')}
                        </p>
                        <p class="mt-1 text-xs text-slate-500">
                            ${escapeHtml(candidate.faculty || '-')}
                        </p>
                    </td>

                    <td class="px-5 py-4">
                        ${statusBadge(candidate.status)}
                    </td>

                    <td class="px-5 py-4 text-slate-600">
                        ${formatDate(candidate.created_at)}
                    </td>

                    <td class="px-5 py-4">
                        <div class="flex items-center justify-center">
                            <a
                                href="${showBaseUrl}/${candidate.id}"
                                class="inline-flex items-center justify-center rounded-lg border border-blue-200 px-3 py-2 text-sm font-bold text-blue-900 hover:bg-blue-50"
                                title="Lihat Detail"
                            >
                                Detail
                            </a>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');

        const from = paginator.from || 1;
        const to = paginator.to || candidates.length;
        const total = paginator.total || candidates.length;

        setText('paginationInfo', `Menampilkan ${formatNumber(from)} - ${formatNumber(to)} dari ${formatNumber(total)} data`);
    }

    function renderPagination(paginator) {
        const wrapper = document.getElementById('paginationWrapper');

        if (!wrapper) {
            return;
        }

        const current = Number(paginator.current_page || 1);
        const last = Number(paginator.last_page || 1);

        if (last <= 1) {
            wrapper.innerHTML = '';
            return;
        }

        const pages = getPaginationPages(current, last);

        wrapper.innerHTML = `
            <button
                type="button"
                data-page="${current - 1}"
                ${current <= 1 ? 'disabled' : ''}
                class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-bold text-slate-700 hover:bg-slate-100 disabled:cursor-not-allowed disabled:opacity-40"
            >
                Sebelumnya
            </button>

            ${pages.map(function (page) {
                if (page === '...') {
                    return `
                        <span class="px-2 py-2 text-sm font-bold text-slate-400">
                            ...
                        </span>
                    `;
                }

                const activeClass = page === current
                    ? 'border-blue-900 bg-blue-900 text-white'
                    : 'border-slate-300 bg-white text-slate-700 hover:bg-slate-100';

                return `
                    <button
                        type="button"
                        data-page="${page}"
                        class="rounded-lg border px-3 py-2 text-sm font-bold ${activeClass}"
                    >
                        ${page}
                    </button>
                `;
            }).join('')}

            <button
                type="button"
                data-page="${current + 1}"
                ${current >= last ? 'disabled' : ''}
                class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-bold text-slate-700 hover:bg-slate-100 disabled:cursor-not-allowed disabled:opacity-40"
            >
                Berikutnya
            </button>
        `;
    }

    function getPaginationPages(current, last) {
        const pages = [];

        if (last <= 7) {
            for (let page = 1; page <= last; page++) {
                pages.push(page);
            }

            return pages;
        }

        pages.push(1);

        if (current > 4) {
            pages.push('...');
        }

        const start = Math.max(2, current - 1);
        const end = Math.min(last - 1, current + 1);

        for (let page = start; page <= end; page++) {
            pages.push(page);
        }

        if (current < last - 3) {
            pages.push('...');
        }

        pages.push(last);

        return pages;
    }

    function setTableLoading() {
        const tableBody = document.getElementById('candidateTableBody');

        if (tableBody) {
            tableBody.innerHTML = emptyRow('Memuat data pendaftar...');
        }
    }

    function renderTableError(message) {
        const tableBody = document.getElementById('candidateTableBody');

        if (tableBody) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="6" class="px-5 py-8 text-center text-red-600">
                        ${escapeHtml(message)}
                    </td>
                </tr>
            `;
        }

        setText('paginationInfo', 'Data gagal dimuat');
        showAlert('error', message);
    }

    function emptyRow(message) {
        return `
            <tr>
                <td colspan="6" class="px-5 py-8 text-center text-slate-500">
                    ${escapeHtml(message)}
                </td>
            </tr>
        `;
    }

    function statusBadge(status) {
        const badges = {
            pending: {
                label: 'Menunggu Verifikasi',
                className: 'bg-amber-100 text-amber-700',
            },
            valid: {
                label: 'Diterima',
                className: 'bg-green-100 text-green-700',
            },
            invalid: {
                label: 'Ditolak',
                className: 'bg-red-100 text-red-700',
            },
        };

        const badge = badges[status] || {
            label: status || '-',
            className: 'bg-slate-100 text-slate-700',
        };

        return `
            <span class="inline-flex rounded-full px-3 py-1 text-xs font-extrabold ${badge.className}">
                ${badge.label}
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

        setTimeout(function () {
            alert.classList.add('hidden');
        }, 4000);
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