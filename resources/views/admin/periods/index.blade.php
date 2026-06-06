@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <section class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <h1 class="text-4xl font-extrabold tracking-tight text-blue-900">
                Manajemen Periode Seleksi
            </h1>

            <p class="mt-2 text-sm font-semibold leading-6 text-slate-500">
                Kelola tahun pemilihan, jadwal pendaftaran, jadwal wawancara, dan status proses seleksi.
            </p>
        </div>

        <button
            type="button"
            id="btnOpenCreateModal"
            class="inline-flex h-12 items-center justify-center rounded-xl bg-blue-900 px-5 text-sm font-extrabold text-white shadow-sm transition hover:bg-blue-800"
        >
            Tambah Periode
        </button>
    </section>

    {{-- Alert --}}
    <div id="alertBox" class="hidden rounded-xl border px-4 py-3 text-sm font-semibold"></div>

    {{-- Statistik --}}
    <section class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-semibold text-slate-500">Total Periode</p>
            <h2 id="totalPeriod" class="mt-2 text-4xl font-extrabold text-slate-900">0</h2>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-semibold text-slate-500">Pendaftaran Aktif</p>
            <h2 id="registrationPeriod" class="mt-2 text-4xl font-extrabold text-green-600">0</h2>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-semibold text-slate-500">Tahap Penilaian</p>
            <h2 id="scoringPeriod" class="mt-2 text-4xl font-extrabold text-amber-600">0</h2>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-semibold text-slate-500">Selesai</p>
            <h2 id="finishedPeriod" class="mt-2 text-4xl font-extrabold text-slate-900">0</h2>
        </div>
    </section>

    {{-- Filter --}}
    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-12">
            <div class="lg:col-span-5">
                <label for="filterYear" class="mb-2 block text-sm font-bold text-slate-700">
                    Tahun Pemilihan
                </label>

                <input
                    type="number"
                    id="filterYear"
                    placeholder="Cari tahun, contoh: 2026"
                    class="h-12 w-full rounded-xl border border-slate-300 bg-white px-4 text-sm outline-none transition focus:border-blue-900 focus:ring-2 focus:ring-blue-100"
                >
            </div>

            <div class="lg:col-span-4">
                <label for="filterStatus" class="mb-2 block text-sm font-bold text-slate-700">
                    Status
                </label>

                <select
                    id="filterStatus"
                    class="h-12 w-full rounded-xl border border-slate-300 bg-white px-4 text-sm outline-none transition focus:border-blue-900 focus:ring-2 focus:ring-blue-100"
                >
                    <option value="">Semua Status</option>
                    <option value="draft">Draft</option>
                    <option value="registration">Pendaftaran Dibuka</option>
                    <option value="interview">Tahap Wawancara</option>
                    <option value="scoring">Tahap Penilaian</option>
                    <option value="finished">Selesai</option>
                </select>
            </div>

            <div class="lg:col-span-3">
                <label class="mb-2 block text-sm font-bold text-transparent">
                    Aksi
                </label>

                <div class="grid grid-cols-2 gap-3">
                    <button
                        type="button"
                        id="btnFilter"
                        class="inline-flex h-12 items-center justify-center rounded-xl border border-slate-300 bg-white px-4 text-sm font-extrabold text-slate-700 transition hover:bg-slate-50"
                    >
                        Filter
                    </button>

                    <button
                        type="button"
                        id="btnResetFilter"
                        class="inline-flex h-12 items-center justify-center rounded-xl bg-slate-100 px-4 text-sm font-extrabold text-slate-700 transition hover:bg-slate-200"
                    >
                        Reset
                    </button>
                </div>
            </div>
        </div>
    </section>

    {{-- Table --}}
    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-5 py-4 text-left font-extrabold uppercase tracking-wide text-slate-500">
                            Tahun
                        </th>
                        <th class="px-5 py-4 text-left font-extrabold uppercase tracking-wide text-slate-500">
                            Pendaftaran
                        </th>
                        <th class="px-5 py-4 text-left font-extrabold uppercase tracking-wide text-slate-500">
                            Wawancara
                        </th>
                        <th class="px-5 py-4 text-left font-extrabold uppercase tracking-wide text-slate-500">
                            Status
                        </th>
                        <th class="px-5 py-4 text-right font-extrabold uppercase tracking-wide text-slate-500">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody id="periodTable" class="divide-y divide-slate-100 bg-white">
                    <tr>
                        <td colspan="5" class="px-5 py-8 text-center text-slate-500">
                            Memuat data periode...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    {{-- Modal Tambah/Edit --}}
    <div id="periodFormModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/50 px-4 py-6">
        <div class="w-full max-w-2xl overflow-hidden rounded-2xl bg-white shadow-2xl">
            <div class="flex items-start justify-between gap-4 border-b border-slate-100 px-6 py-5">
                <div>
                    <h2 id="formTitle" class="text-xl font-extrabold text-slate-900">
                        Tambah Periode
                    </h2>

                    <p id="formDescription" class="mt-1 text-sm leading-6 text-slate-500">
                        Lengkapi data periode seleksi dengan benar.
                    </p>
                </div>

                <button
                    type="button"
                    id="btnCloseFormModal"
                    class="rounded-lg p-1.5 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                    aria-label="Tutup modal"
                >
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                        <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                    </svg>
                </button>
            </div>

            <form id="periodForm">
                <input type="hidden" id="periodId">

                <div class="grid grid-cols-1 gap-5 px-6 py-5 md:grid-cols-2">
                    <div>
                        <label for="electionYear" class="mb-2 block text-sm font-bold text-slate-700">
                            Tahun Pemilihan
                        </label>

                        <input
                            type="number"
                            id="electionYear"
                            min="2000"
                            max="2100"
                            required
                            placeholder="Contoh: 2026"
                            class="h-12 w-full rounded-xl border border-slate-300 bg-white px-4 text-sm outline-none transition focus:border-blue-900 focus:ring-2 focus:ring-blue-100"
                        >
                    </div>

                    <div>
                        <label for="status" class="mb-2 block text-sm font-bold text-slate-700">
                            Status Periode
                        </label>

                        <select
                            id="status"
                            required
                            class="h-12 w-full rounded-xl border border-slate-300 bg-white px-4 text-sm outline-none transition focus:border-blue-900 focus:ring-2 focus:ring-blue-100"
                        >
                            <option value="draft">Draft</option>
                            <option value="registration">Pendaftaran Dibuka</option>
                            <option value="interview">Tahap Wawancara</option>
                            <option value="scoring">Tahap Penilaian</option>
                            <option value="finished">Selesai</option>
                        </select>
                    </div>

                    <div>
                        <label for="registrationStart" class="mb-2 block text-sm font-bold text-slate-700">
                            Mulai Pendaftaran
                        </label>

                        <input
                            type="datetime-local"
                            id="registrationStart"
                            class="h-12 w-full rounded-xl border border-slate-300 bg-white px-4 text-sm outline-none transition focus:border-blue-900 focus:ring-2 focus:ring-blue-100"
                        >
                    </div>

                    <div>
                        <label for="registrationEnd" class="mb-2 block text-sm font-bold text-slate-700">
                            Akhir Pendaftaran
                        </label>

                        <input
                            type="datetime-local"
                            id="registrationEnd"
                            class="h-12 w-full rounded-xl border border-slate-300 bg-white px-4 text-sm outline-none transition focus:border-blue-900 focus:ring-2 focus:ring-blue-100"
                        >
                    </div>

                    <div>
                        <label for="interviewStart" class="mb-2 block text-sm font-bold text-slate-700">
                            Mulai Wawancara
                        </label>

                        <input
                            type="datetime-local"
                            id="interviewStart"
                            class="h-12 w-full rounded-xl border border-slate-300 bg-white px-4 text-sm outline-none transition focus:border-blue-900 focus:ring-2 focus:ring-blue-100"
                        >
                    </div>

                    <div>
                        <label for="interviewEnd" class="mb-2 block text-sm font-bold text-slate-700">
                            Akhir Wawancara
                        </label>

                        <input
                            type="datetime-local"
                            id="interviewEnd"
                            class="h-12 w-full rounded-xl border border-slate-300 bg-white px-4 text-sm outline-none transition focus:border-blue-900 focus:ring-2 focus:ring-blue-100"
                        >
                    </div>

                    <div id="formError" class="hidden rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700 md:col-span-2"></div>
                </div>

                <div class="flex justify-end gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4">
                    <button
                        type="button"
                        id="btnResetForm"
                        class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-bold text-slate-700 transition hover:bg-slate-50"
                    >
                        Reset
                    </button>

                    <button
                        type="submit"
                        id="btnSubmitForm"
                        class="rounded-lg bg-blue-900 px-4 py-2 text-sm font-bold text-white transition hover:bg-blue-800 disabled:cursor-not-allowed disabled:opacity-70"
                    >
                        Simpan Periode
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Hapus --}}
    <div id="deleteConfirmModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/50 px-4 py-6">
        <div class="w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl">
            <div class="flex items-start justify-between gap-4 border-b border-slate-100 px-6 py-5">
                <div>
                    <h2 class="text-xl font-extrabold text-slate-900">
                        Hapus Periode
                    </h2>

                    <p class="mt-1 text-sm leading-6 text-slate-500">
                        Tindakan ini dapat memengaruhi data yang terkait dengan periode ini.
                    </p>
                </div>

                <button
                    type="button"
                    id="btnCloseDeleteModal"
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
                            <path d="M6 7H18M10 11V17M14 11V17M9 7L10 4H14L15 7M8 7L9 20H15L16 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>

                    <div>
                        <p id="deletePeriodText" class="text-sm font-semibold leading-6 text-slate-700">
                            Yakin ingin menghapus periode ini?
                        </p>

                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            Jika periode sudah memiliki pendaftar atau data penilaian, penghapusan bisa gagal dari sistem.
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4">
                <button
                    type="button"
                    id="btnCancelDelete"
                    class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-bold text-slate-700 transition hover:bg-slate-50"
                >
                    Batal
                </button>

                <button
                    type="button"
                    id="btnConfirmDelete"
                    class="rounded-lg bg-red-600 px-4 py-2 text-sm font-bold text-white transition hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-70"
                >
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    let periods = [];
    let selectedDeleteId = null;

    const elements = {
        alertBox: document.getElementById('alertBox'),

        totalPeriod: document.getElementById('totalPeriod'),
        registrationPeriod: document.getElementById('registrationPeriod'),
        scoringPeriod: document.getElementById('scoringPeriod'),
        finishedPeriod: document.getElementById('finishedPeriod'),

        periodFormModal: document.getElementById('periodFormModal'),
        formTitle: document.getElementById('formTitle'),
        formDescription: document.getElementById('formDescription'),
        periodForm: document.getElementById('periodForm'),
        formError: document.getElementById('formError'),

        periodId: document.getElementById('periodId'),
        electionYear: document.getElementById('electionYear'),
        status: document.getElementById('status'),
        registrationStart: document.getElementById('registrationStart'),
        registrationEnd: document.getElementById('registrationEnd'),
        interviewStart: document.getElementById('interviewStart'),
        interviewEnd: document.getElementById('interviewEnd'),

        filterYear: document.getElementById('filterYear'),
        filterStatus: document.getElementById('filterStatus'),
        periodTable: document.getElementById('periodTable'),

        btnOpenCreateModal: document.getElementById('btnOpenCreateModal'),
        btnCloseFormModal: document.getElementById('btnCloseFormModal'),
        btnResetForm: document.getElementById('btnResetForm'),
        btnSubmitForm: document.getElementById('btnSubmitForm'),
        btnFilter: document.getElementById('btnFilter'),
        btnResetFilter: document.getElementById('btnResetFilter'),

        deleteConfirmModal: document.getElementById('deleteConfirmModal'),
        deletePeriodText: document.getElementById('deletePeriodText'),
        btnCloseDeleteModal: document.getElementById('btnCloseDeleteModal'),
        btnCancelDelete: document.getElementById('btnCancelDelete'),
        btnConfirmDelete: document.getElementById('btnConfirmDelete'),
    };

    async function apiRequest(endpoint, options = {}) {
        if (!window.DutaAdmin) {
            throw new Error('Helper request admin tidak ditemukan.');
        }

        const cleanEndpoint = endpoint.startsWith('/api')
            ? endpoint.slice(4)
            : endpoint;

        const result = await DutaAdmin.request(cleanEndpoint, options);

        return result || {};
    }

    function extractPeriodItems(result) {
        if (Array.isArray(result)) {
            return result;
        }

        if (Array.isArray(result?.data?.data)) {
            return result.data.data;
        }

        if (Array.isArray(result?.data)) {
            return result.data;
        }

        if (Array.isArray(result?.items)) {
            return result.items;
        }

        if (Array.isArray(result?.data?.items)) {
            return result.data.items;
        }

        return [];
    }

    function loadPeriods() {
        setLoadingTable();

        const params = new URLSearchParams();
        const year = elements.filterYear.value.trim();
        const status = elements.filterStatus.value.trim();

        if (year !== '') {
            params.append('election_year', year);
        }

        if (status !== '') {
            params.append('status', status);
        }

        params.append('per_page', '50');

        apiRequest('/periods?' + params.toString(), {
            method: 'GET',
        })
            .then(function (result) {
                periods = extractPeriodItems(result);

                renderStats();
                renderTable();
            })
            .catch(function (error) {
                console.error('Gagal memuat periode:', error);

                periods = [];
                renderStats();

                elements.periodTable.innerHTML = `
                    <tr>
                        <td colspan="5" class="px-5 py-8 text-center text-red-600">
                            ${escapeHtml(getErrorMessage(error, 'Data periode gagal dimuat.'))}
                        </td>
                    </tr>
                `;
            });
    }

    function renderStats() {
        elements.totalPeriod.textContent = periods.length;
        elements.registrationPeriod.textContent = periods.filter(item => item.status === 'registration').length;
        elements.scoringPeriod.textContent = periods.filter(item => item.status === 'scoring').length;
        elements.finishedPeriod.textContent = periods.filter(item => item.status === 'finished').length;
    }

    function renderTable() {
        if (!periods.length) {
            elements.periodTable.innerHTML = `
                <tr>
                    <td colspan="5" class="px-5 py-8 text-center text-slate-500">
                        Belum ada data periode seleksi.
                    </td>
                </tr>
            `;
            return;
        }

        elements.periodTable.innerHTML = periods.map(function (period) {
            return `
                <tr class="hover:bg-slate-50">
                    <td class="px-5 py-5">
                        <p class="text-base font-extrabold text-slate-900">
                            ${escapeHtml(period.election_year || '-')}
                        </p>
                    </td>

                    <td class="px-5 py-5 text-sm text-slate-600">
                        <p class="font-semibold text-slate-800">
                            ${formatDate(period.registration_start)}
                        </p>
                        <p class="mt-1 text-xs font-semibold text-slate-400">
                            sampai ${formatDate(period.registration_end)}
                        </p>
                    </td>

                    <td class="px-5 py-5 text-sm text-slate-600">
                        <p class="font-semibold text-slate-800">
                            ${formatDate(period.interview_start)}
                        </p>
                        <p class="mt-1 text-xs font-semibold text-slate-400">
                            sampai ${formatDate(period.interview_end)}
                        </p>
                    </td>

                    <td class="px-5 py-5">
                        ${getStatusBadge(period.status)}
                    </td>

                    <td class="px-5 py-5 text-right">
                        <div class="flex justify-end gap-2">
                            <button
                                type="button"
                                data-action="edit"
                                data-id="${period.id}"
                                class="inline-flex h-9 items-center justify-center rounded-lg border border-blue-200 px-3 text-sm font-extrabold text-blue-900 transition hover:bg-blue-50"
                            >
                                Edit
                            </button>

                            <button
                                type="button"
                                data-action="delete"
                                data-id="${period.id}"
                                class="inline-flex h-9 items-center justify-center rounded-lg border border-red-200 px-3 text-sm font-extrabold text-red-600 transition hover:bg-red-50"
                            >
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');
    }

    function setLoadingTable(message = 'Memuat data periode...') {
        elements.periodTable.innerHTML = `
            <tr>
                <td colspan="5" class="px-5 py-8 text-center text-slate-500">
                    ${escapeHtml(message)}
                </td>
            </tr>
        `;
    }

    function openCreateModal() {
        resetForm();
        elements.formTitle.textContent = 'Tambah Periode';
        elements.formDescription.textContent = 'Lengkapi data periode seleksi dengan benar.';
        elements.btnSubmitForm.textContent = 'Simpan Periode';
        openModalElement(elements.periodFormModal);

        setTimeout(function () {
            elements.electionYear.focus();
        }, 100);
    }

    function openEditModal(id) {
        const period = periods.find(function (item) {
            return Number(item.id) === Number(id);
        });

        if (!period) {
            showAlert('Data periode tidak ditemukan pada tabel.', 'error');
            return;
        }

        resetForm();

        elements.formTitle.textContent = 'Edit Periode ' + (period.election_year || '');
        elements.formDescription.textContent = 'Perbarui jadwal dan status periode seleksi.';
        elements.btnSubmitForm.textContent = 'Update Periode';

        elements.periodId.value = period.id;
        elements.electionYear.value = period.election_year || '';
        elements.status.value = period.status || 'draft';
        elements.registrationStart.value = toInputDateTime(period.registration_start);
        elements.registrationEnd.value = toInputDateTime(period.registration_end);
        elements.interviewStart.value = toInputDateTime(period.interview_start);
        elements.interviewEnd.value = toInputDateTime(period.interview_end);

        openModalElement(elements.periodFormModal);
    }

    function closeFormModal() {
        closeModalElement(elements.periodFormModal);
        resetForm();
    }

    function resetForm() {
        elements.periodId.value = '';
        elements.periodForm.reset();
        elements.status.value = 'draft';
        clearFormError();
    }

    function savePeriod(event) {
        event.preventDefault();
        clearFormError();

        const id = elements.periodId.value;

        const payload = {
            election_year: Number(elements.electionYear.value),
            status: elements.status.value,
            registration_start: normalizeDateTime(elements.registrationStart.value),
            registration_end: normalizeDateTime(elements.registrationEnd.value),
            interview_start: normalizeDateTime(elements.interviewStart.value),
            interview_end: normalizeDateTime(elements.interviewEnd.value),
        };

        const endpoint = id ? '/periods/' + id : '/periods';
        const method = id ? 'PUT' : 'POST';

        elements.btnSubmitForm.disabled = true;
        elements.btnSubmitForm.textContent = id ? 'Mengupdate...' : 'Menyimpan...';

        apiRequest(endpoint, {
            method: method,
            body: JSON.stringify(payload),
        })
            .then(function () {
                showAlert(id ? 'Periode berhasil diperbarui.' : 'Periode berhasil ditambahkan.', 'success');
                closeFormModal();
                loadPeriods();
            })
            .catch(function (error) {
                console.error('Gagal menyimpan periode:', error);

                showFormError(
                    getErrorMessage(error, 'Periode gagal disimpan.'),
                    getErrorValidation(error)
                );
            })
            .finally(function () {
                elements.btnSubmitForm.disabled = false;
                elements.btnSubmitForm.textContent = id ? 'Update Periode' : 'Simpan Periode';
            });
    }

    function openDeleteModal(id) {
        const period = periods.find(function (item) {
            return Number(item.id) === Number(id);
        });

        if (!period) {
            showAlert('Data periode tidak ditemukan pada tabel.', 'error');
            return;
        }

        selectedDeleteId = id;
        elements.deletePeriodText.textContent = `Yakin ingin menghapus periode ${period.election_year}?`;
        openModalElement(elements.deleteConfirmModal);
    }

    function closeDeleteModal() {
        selectedDeleteId = null;
        closeModalElement(elements.deleteConfirmModal);
        elements.btnConfirmDelete.disabled = false;
        elements.btnConfirmDelete.textContent = 'Ya, Hapus';
    }

    function confirmDelete() {
        if (!selectedDeleteId) {
            return;
        }

        elements.btnConfirmDelete.disabled = true;
        elements.btnConfirmDelete.textContent = 'Menghapus...';

        apiRequest('/periods/' + selectedDeleteId, {
            method: 'DELETE',
        })
            .then(function () {
                showAlert('Periode berhasil dihapus.', 'success');
                closeDeleteModal();
                loadPeriods();
            })
            .catch(function (error) {
                console.error('Gagal menghapus periode:', error);
                showAlert(getErrorMessage(error, 'Periode gagal dihapus.'), 'error');

                elements.btnConfirmDelete.disabled = false;
                elements.btnConfirmDelete.textContent = 'Ya, Hapus';
            });
    }

    function resetFilter() {
        elements.filterYear.value = '';
        elements.filterStatus.value = '';
        loadPeriods();
    }

    function openModalElement(modal) {
        if (!modal) {
            return;
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModalElement(modal) {
        if (!modal) {
            return;
        }

        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function showAlert(message, type = 'success') {
        const classes = {
            success: 'border-green-200 bg-green-50 text-green-700',
            error: 'border-red-200 bg-red-50 text-red-700',
            info: 'border-blue-200 bg-blue-50 text-blue-700',
        };

        elements.alertBox.className = 'rounded-xl border px-4 py-3 text-sm font-semibold ' + (classes[type] || classes.info);
        elements.alertBox.textContent = message;
        elements.alertBox.classList.remove('hidden');

        setTimeout(function () {
            elements.alertBox.classList.add('hidden');
        }, 3500);
    }

    function showFormError(message, errors = null) {
        let html = escapeHtml(message || 'Terjadi kesalahan.');

        if (errors) {
            html += '<ul class="mt-2 list-disc pl-5">';

            Object.values(errors).forEach(function (messages) {
                if (Array.isArray(messages)) {
                    messages.forEach(function (item) {
                        html += `<li>${escapeHtml(item)}</li>`;
                    });

                    return;
                }

                html += `<li>${escapeHtml(messages)}</li>`;
            });

            html += '</ul>';
        }

        elements.formError.innerHTML = html;
        elements.formError.classList.remove('hidden');
    }

    function clearFormError() {
        elements.formError.innerHTML = '';
        elements.formError.classList.add('hidden');
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

    function getErrorValidation(error) {
        if (error?.errors) {
            return error.errors;
        }

        if (error?.response?.errors) {
            return error.response.errors;
        }

        return null;
    }

    function formatDate(value) {
        if (!value) {
            return '-';
        }

        const date = new Date(value);

        if (Number.isNaN(date.getTime())) {
            return '-';
        }

        return date.toLocaleString('id-ID', {
            day: '2-digit',
            month: 'short',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
        });
    }

    function toInputDateTime(value) {
        if (!value) {
            return '';
        }

        const date = new Date(value);

        if (Number.isNaN(date.getTime())) {
            return '';
        }

        const pad = function (number) {
            return String(number).padStart(2, '0');
        };

        return `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(date.getDate())}T${pad(date.getHours())}:${pad(date.getMinutes())}`;
    }

    function normalizeDateTime(value) {
        if (!value) {
            return null;
        }

        return value.replace('T', ' ') + ':00';
    }

    function getStatusLabel(status) {
        const labels = {
            draft: 'Draft',
            registration: 'Pendaftaran Dibuka',
            interview: 'Tahap Wawancara',
            scoring: 'Tahap Penilaian',
            finished: 'Selesai',
        };

        return labels[status] || status || '-';
    }

    function getStatusBadge(status) {
        const classes = {
            draft: 'border-slate-200 bg-slate-100 text-slate-700',
            registration: 'border-green-200 bg-green-100 text-green-700',
            interview: 'border-blue-200 bg-blue-100 text-blue-700',
            scoring: 'border-amber-200 bg-amber-100 text-amber-700',
            finished: 'border-purple-200 bg-purple-100 text-purple-700',
        };

        return `
            <span class="inline-flex rounded-full border px-3 py-1 text-xs font-extrabold ${classes[status] || 'border-slate-200 bg-slate-100 text-slate-700'}">
                ${escapeHtml(getStatusLabel(status))}
            </span>
        `;
    }

    function escapeHtml(value) {
        return String(value ?? '-')
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

    elements.btnOpenCreateModal?.addEventListener('click', openCreateModal);
    elements.btnCloseFormModal?.addEventListener('click', closeFormModal);
    elements.btnResetForm?.addEventListener('click', resetForm);
    elements.periodForm?.addEventListener('submit', savePeriod);

    elements.btnFilter?.addEventListener('click', loadPeriods);
    elements.btnResetFilter?.addEventListener('click', resetFilter);

    elements.filterStatus?.addEventListener('change', loadPeriods);

    elements.filterYear?.addEventListener('keyup', function (event) {
        if (event.key === 'Enter') {
            loadPeriods();
        }
    });

    elements.periodTable?.addEventListener('click', function (event) {
        const button = event.target.closest('button');

        if (!button) {
            return;
        }

        const action = button.dataset.action;
        const id = button.dataset.id;

        if (action === 'edit') {
            openEditModal(id);
        }

        if (action === 'delete') {
            openDeleteModal(id);
        }
    });

    elements.btnCloseDeleteModal?.addEventListener('click', closeDeleteModal);
    elements.btnCancelDelete?.addEventListener('click', closeDeleteModal);
    elements.btnConfirmDelete?.addEventListener('click', confirmDelete);

    elements.periodFormModal?.addEventListener('click', function (event) {
        if (event.target === elements.periodFormModal) {
            closeFormModal();
        }
    });

    elements.deleteConfirmModal?.addEventListener('click', function (event) {
        if (event.target === elements.deleteConfirmModal) {
            closeDeleteModal();
        }
    });

    loadPeriods();
});
</script>
@endpush