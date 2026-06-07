@extends('layouts.admin')

@section('content')
    <section class="mb-7">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-[34px] font-extrabold leading-none tracking-tight text-[#00288E]">
                    Manajemen Kriteria
                </h1>

                <p class="mt-2 text-sm font-medium text-slate-500">
                    Kelola seluruh kriteria sebagai satu paket agar total bobot tetap 100%.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <x-button type="button" variant="secondary" id="reloadButton" onclick="loadCriteria()">
                    Muat Ulang
                </x-button>

                <x-button type="button" id="editAllButton" onclick="enterEditMode()">
                    Edit Semua Kriteria
                </x-button>
            </div>
        </div>
    </section>

    <div id="pageAlert" class="mb-5 hidden rounded-md border px-4 py-3 text-sm"></div>

    <section class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
        <x-card>
            <p class="text-sm font-semibold text-slate-700">Total Kriteria</p>
            <h2 id="totalCriteria" class="mt-2 text-3xl font-extrabold text-slate-900">0</h2>
        </x-card>

        <x-card>
            <p class="text-sm font-semibold text-slate-700">Kriteria Aktif</p>
            <h2 id="activeCriteria" class="mt-2 text-3xl font-extrabold text-slate-900">0</h2>
        </x-card>

        <x-card>
            <p class="text-sm font-semibold text-slate-700">Kriteria Benefit</p>
            <h2 id="benefitCriteria" class="mt-2 text-3xl font-extrabold text-slate-900">0</h2>
        </x-card>

        <x-card>
            <p class="text-sm font-semibold text-slate-700">Total Bobot Aktif</p>
            <h2 id="totalWeight" class="mt-2 text-3xl font-extrabold text-slate-900">0%</h2>
        </x-card>
    </section>

    <section class="mt-7">
        <x-card padding="p-0">
            <div class="border-b border-slate-200 px-5 py-4">
                <div class="grid grid-cols-1 gap-3 md:grid-cols-[170px_1fr_180px]">
                    <div>
                        <label for="periodIdInput" class="mb-1 block text-xs font-bold text-slate-600">
                            Periode ID
                        </label>
                        <input
                            id="periodIdInput"
                            type="number"
                            min="1"
                            value="1"
                            class="h-11 w-full rounded-md border border-slate-300 bg-white px-4 text-sm outline-none focus:border-[#00288E] focus:ring-2 focus:ring-blue-100"
                        >
                    </div>

                    <div>
                        <label for="searchInput" class="mb-1 block text-xs font-bold text-slate-600">
                            Pencarian
                        </label>
                        <input
                            id="searchInput"
                            type="text"
                            placeholder="Cari kode atau nama kriteria..."
                            class="h-11 w-full rounded-md border border-slate-300 bg-white px-4 text-sm outline-none focus:border-[#00288E] focus:ring-2 focus:ring-blue-100"
                        >
                    </div>

                    <div>
                        <label for="statusFilter" class="mb-1 block text-xs font-bold text-slate-600">
                            Status
                        </label>
                        <select
                            id="statusFilter"
                            class="h-11 w-full rounded-md border border-slate-300 bg-white px-4 text-sm outline-none focus:border-[#00288E] focus:ring-2 focus:ring-blue-100"
                        >
                            <option value="">Semua Status</option>
                            <option value="active">Aktif</option>
                            <option value="inactive">Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div id="editActions" class="mt-4 hidden rounded-md border border-yellow-200 bg-yellow-50 px-4 py-3">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                        <p class="text-sm font-semibold text-yellow-800">
                            Mode edit aktif. Tambah, hapus, dan ubah kriteria di tabel, lalu simpan semuanya sekaligus.
                        </p>

                        <div class="flex flex-wrap gap-2">
                            <x-button type="button" variant="secondary" size="sm" onclick="addDraftRow()">
                                Tambah Baris
                            </x-button>

                            <x-button type="button" variant="secondary" size="sm" onclick="cancelEditMode()">
                                Batal
                            </x-button>

                            <x-button type="button" size="sm" onclick="saveAllCriteria()">
                                Simpan Semua
                            </x-button>
                        </div>
                    </div>

                    <div id="weightWarningBox" class="mt-3 hidden rounded-md border px-4 py-3 text-sm font-semibold"></div>
                </div>
            </div>

            <x-table
                :headers="['Kode', 'Nama Kriteria', 'Bobot', 'Tipe', 'Rentang Nilai', 'Status', 'Aksi']"
                tbody-id="criteriaTableBody"
                class="rounded-none border-0 shadow-none"
            >
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-slate-500">
                        Memuat data kriteria...
                    </td>
                </tr>
            </x-table>
        </x-card>
    </section>

    {{-- Modal Warning --}}
    <div id="warningModal" class="fixed inset-0 z-90 hidden">
        <div class="absolute inset-0 bg-slate-900/50"></div>

        <div class="relative mx-auto mt-28 w-[92%] max-w-md">
            <div class="overflow-hidden rounded-xl bg-white shadow-xl">
                <div class="border-b border-slate-200 px-5 py-4">
                    <h2 id="warningModalTitle" class="text-lg font-extrabold text-slate-900">
                        Peringatan
                    </h2>
                </div>

                <div class="px-5 py-5">
                    <p id="warningModalMessage" class="text-sm leading-6 text-slate-600">
                        Terjadi kesalahan.
                    </p>
                </div>

                <div class="flex justify-end border-t border-slate-200 bg-slate-50 px-5 py-4">
                    <button
                        type="button"
                        onclick="closeWarningModal()"
                        class="rounded-md bg-[#00288E] px-4 py-2 text-sm font-bold text-white hover:bg-[#001F73]"
                    >
                        Mengerti
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let criteriaData = [];
        let draftCriteria = [];
        let isEditing = false;

        document.addEventListener('DOMContentLoaded', function () {
            loadCriteria();

            document.getElementById('searchInput')?.addEventListener('input', function () {
                if (!isEditing) {
                    renderReadTable();
                }
            });

            document.getElementById('statusFilter')?.addEventListener('change', function () {
                if (!isEditing) {
                    renderReadTable();
                }
            });

            document.getElementById('periodIdInput')?.addEventListener('change', function () {
                if (!isEditing) {
                    loadCriteria();
                }
            });
        });

        async function loadCriteria() {
            if (isEditing) {
                showAlert('warning', 'Selesaikan atau batalkan mode edit terlebih dahulu.');
                return;
            }

            const tableBody = document.getElementById('criteriaTableBody');

            tableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-slate-500">
                        Memuat data kriteria...
                    </td>
                </tr>
            `;

            try {
                const periodId = getPeriodId();
                const result = await DutaAdmin.request(`/criteria?period_id=${periodId}&per_page=100`);

                criteriaData = normalizeCollection(result);

                renderStats(criteriaData);
                renderReadTable();
            } catch (error) {
                console.error(error);

                tableBody.innerHTML = `
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-red-600">
                            ${escapeHtml(getErrorMessage(error))}
                        </td>
                    </tr>
                `;
            }
        }

        function showWarningModal(title, message) {
            document.getElementById('warningModalTitle').textContent = title || 'Peringatan';
            document.getElementById('warningModalMessage').textContent = message || 'Terjadi kesalahan.';
            document.getElementById('warningModal').classList.remove('hidden');
        }

        function closeWarningModal() {
            document.getElementById('warningModal').classList.add('hidden');
        }

        function enterEditMode() {
            isEditing = true;

            draftCriteria = criteriaData.map(item => ({
                _key: `row_${item.id}`,
                id: item.id,
                period_id: Number(item.period_id || getPeriodId()),
                code: item.code || '',
                name: item.name || '',
                weight_percent: Number(item.weight || 0) * 100,
                type: item.type || 'benefit',
                min_score: Number(item.min_score ?? 0),
                max_score: Number(item.max_score ?? 100),
                is_active: isActive(item.is_active),
            }));

            document.getElementById('editActions').classList.remove('hidden');
            document.getElementById('editAllButton').classList.add('hidden');
            document.getElementById('reloadButton').classList.add('hidden');
            document.getElementById('searchInput').disabled = true;
            document.getElementById('statusFilter').disabled = true;
            document.getElementById('periodIdInput').disabled = true;

            renderEditTable();
            renderStats(draftCriteria, true);
        }

        function cancelEditMode() {
            isEditing = false;
            draftCriteria = [];

            document.getElementById('editActions').classList.add('hidden');
            document.getElementById('editAllButton').classList.remove('hidden');
            document.getElementById('reloadButton').classList.remove('hidden');
            document.getElementById('searchInput').disabled = false;
            document.getElementById('statusFilter').disabled = false;
            document.getElementById('periodIdInput').disabled = false;

            renderStats(criteriaData);
            renderReadTable();
        }

        function addDraftRow() {
            draftCriteria.push({
                _key: `new_${Date.now()}_${Math.floor(Math.random() * 1000)}`,
                id: null,
                period_id: getPeriodId(),
                code: '',
                name: '',
                weight_percent: 0,
                type: 'benefit',
                min_score: 0,
                max_score: 100,
                is_active: true,
            });

            renderEditTable();
            renderStats(draftCriteria, true);
        }

        function removeDraftRow(key) {
            draftCriteria = draftCriteria.filter(row => row._key !== key);

            renderEditTable();
            renderStats(draftCriteria, true);
        }

        function updateDraftRow(key, field, value) {
            const row = draftCriteria.find(item => item._key === key);

            if (!row) return;

            if (['weight_percent', 'min_score', 'max_score'].includes(field)) {
                row[field] = Number(value || 0);
            } else if (field === 'is_active') {
                row[field] = Boolean(value);
            } else if (field === 'code') {
                row[field] = String(value || '').toUpperCase();
            } else {
                row[field] = value;
            }

            renderStats(draftCriteria, true);
        }

        function renderReadTable() {
            const tableBody = document.getElementById('criteriaTableBody');
            const search = document.getElementById('searchInput')?.value?.toLowerCase() || '';
            const status = document.getElementById('statusFilter')?.value || '';

            let filtered = criteriaData.filter(item => {
                const text = [
                    item.code,
                    item.name,
                    item.type,
                ].join(' ').toLowerCase();

                let matchStatus = true;

                if (status === 'active') {
                    matchStatus = isActive(item.is_active);
                }

                if (status === 'inactive') {
                    matchStatus = !isActive(item.is_active);
                }

                return text.includes(search) && matchStatus;
            });

            if (!filtered.length) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-slate-500">
                            Tidak ada data kriteria.
                        </td>
                    </tr>
                `;
                return;
            }

            tableBody.innerHTML = filtered.map(item => `
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4">
                        <span class="font-extrabold text-[#00288E]">
                            ${escapeHtml(item.code || '-')}
                        </span>
                    </td>

                    <td class="px-6 py-4">
                        <p class="font-bold text-slate-900">
                            ${escapeHtml(item.name || '-')}
                        </p>
                        <p class="mt-1 text-xs text-slate-500">
                            Periode ${escapeHtml(item.election_year || item.period_id || '-')}
                        </p>
                    </td>

                    <td class="px-6 py-4 font-semibold text-slate-700">
                        ${formatNumber(Number(item.weight || 0) * 100)}%
                    </td>

                    <td class="px-6 py-4">
                        ${renderTypeBadge(item.type)}
                    </td>

                    <td class="px-6 py-4 text-slate-600">
                        ${escapeHtml(item.min_score ?? 0)} sampai ${escapeHtml(item.max_score ?? 100)}
                    </td>

                    <td class="px-6 py-4">
                        ${renderStatusBadge(item.is_active)}
                    </td>

                    <td class="px-6 py-4 text-sm text-slate-500">
                        Edit melalui tombol Edit Semua
                    </td>
                </tr>
            `).join('');
        }

        function renderEditTable() {
            const tableBody = document.getElementById('criteriaTableBody');

            if (!draftCriteria.length) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-slate-500">
                            Belum ada baris kriteria. Klik Tambah Baris untuk membuat kriteria.
                        </td>
                    </tr>
                `;
                return;
            }

            tableBody.innerHTML = draftCriteria.map(row => `
                <tr class="bg-white">
                    <td class="px-6 py-4 align-top">
                        <input
                            type="text"
                            value="${escapeAttr(row.code)}"
                            oninput="updateDraftRow('${row._key}', 'code', this.value)"
                            class="h-10 w-24 rounded-md border border-slate-300 px-3 text-sm font-bold uppercase outline-none focus:border-[#00288E] focus:ring-2 focus:ring-blue-100"
                            placeholder="C1"
                        >
                    </td>

                    <td class="px-6 py-4 align-top">
                        <input
                            type="text"
                            value="${escapeAttr(row.name)}"
                            oninput="updateDraftRow('${row._key}', 'name', this.value)"
                            class="h-10 w-full min-w-[260px] rounded-md border border-slate-300 px-3 text-sm outline-none focus:border-[#00288E] focus:ring-2 focus:ring-blue-100"
                            placeholder="Nama kriteria"
                        >
                    </td>

                    <td class="px-6 py-4 align-top">
                        <div class="flex items-center gap-2">
                            <input
                                type="number"
                                min="0"
                                step="0.01"
                                value="${Number(row.weight_percent || 0)}"
                                oninput="updateDraftRow('${row._key}', 'weight_percent', this.value)"
                                class="h-10 w-24 rounded-md border border-slate-300 px-3 text-sm outline-none focus:border-[#00288E] focus:ring-2 focus:ring-blue-100"
                            >
                            <span class="text-sm font-bold text-slate-500">%</span>
                        </div>
                    </td>

                    <td class="px-6 py-4 align-top">
                        <select
                            onchange="updateDraftRow('${row._key}', 'type', this.value)"
                            class="h-10 rounded-md border border-slate-300 bg-white px-3 text-sm outline-none focus:border-[#00288E] focus:ring-2 focus:ring-blue-100"
                        >
                            <option value="benefit" ${row.type === 'benefit' ? 'selected' : ''}>Benefit</option>
                            <option value="cost" ${row.type === 'cost' ? 'selected' : ''}>Cost</option>
                        </select>
                    </td>

                    <td class="px-6 py-4 align-top">
                        <div class="flex items-center gap-2">
                            <input
                                type="number"
                                min="0"
                                step="1"
                                value="${Number(row.min_score || 0)}"
                                oninput="updateDraftRow('${row._key}', 'min_score', this.value)"
                                class="h-10 w-20 rounded-md border border-slate-300 px-3 text-sm outline-none focus:border-[#00288E] focus:ring-2 focus:ring-blue-100"
                            >

                            <span class="text-sm text-slate-500">s/d</span>

                            <input
                                type="number"
                                min="1"
                                step="1"
                                value="${Number(row.max_score || 100)}"
                                oninput="updateDraftRow('${row._key}', 'max_score', this.value)"
                                class="h-10 w-20 rounded-md border border-slate-300 px-3 text-sm outline-none focus:border-[#00288E] focus:ring-2 focus:ring-blue-100"
                            >
                        </div>
                    </td>

                    <td class="px-6 py-4 align-top">
                        <label class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700">
                            <input
                                type="checkbox"
                                ${row.is_active ? 'checked' : ''}
                                onchange="updateDraftRow('${row._key}', 'is_active', this.checked)"
                                class="rounded border-slate-300"
                            >
                            Aktif
                        </label>
                    </td>

                    <td class="px-6 py-4 align-top">
                        <button
                            type="button"
                            onclick="removeDraftRow('${row._key}')"
                            class="rounded-md border border-red-200 px-3 py-2 text-xs font-bold text-red-600 hover:bg-red-50"
                        >
                            Hapus Baris
                        </button>
                    </td>
                </tr>
            `).join('');
        }

        async function saveAllCriteria() {
            const validationMessage = validateDraftCriteria();

            if (validationMessage) {
                showWarningModal('Data belum bisa disimpan', validationMessage);
                return;
            }

            const payload = {
                period_id: getPeriodId(),
                criteria: draftCriteria.map(row => ({
                    id: row.id,
                    code: String(row.code || '').trim().toUpperCase(),
                    name: String(row.name || '').trim(),
                    weight: Number(row.weight_percent || 0) / 100,
                    type: row.type || 'benefit',
                    min_score: Number(row.min_score || 0),
                    max_score: Number(row.max_score || 100),
                    is_active: Boolean(row.is_active),
                })),
            };

            try {
                await DutaAdmin.request('/criteria/sync', {
                    method: 'POST',
                    body: JSON.stringify(payload),
                });

                showAlert('success', 'Seluruh kriteria berhasil disimpan.');

                isEditing = false;
                draftCriteria = [];

                document.getElementById('editActions').classList.add('hidden');
                document.getElementById('editAllButton').classList.remove('hidden');
                document.getElementById('reloadButton').classList.remove('hidden');
                document.getElementById('searchInput').disabled = false;
                document.getElementById('statusFilter').disabled = false;
                document.getElementById('periodIdInput').disabled = false;

                await loadCriteria();
            } catch (error) {
                console.error(error);
                showAlert('danger', getErrorMessage(error));
            }
        }

        function validateDraftCriteria() {
            if (!draftCriteria.length) {
                return 'Minimal harus ada satu kriteria.';
            }

            const codes = {};
            const names = {};
            let activeWeight = 0;

            for (let i = 0; i < draftCriteria.length; i++) {
                const row = draftCriteria[i];
                const rowNumber = i + 1;
                const code = String(row.code || '').trim().toUpperCase();
                const name = String(row.name || '').trim().toLowerCase();

                if (!code) {
                    return `Kode kriteria pada baris ${rowNumber} wajib diisi.`;
                }

                if (!name) {
                    return `Nama kriteria pada baris ${rowNumber} wajib diisi.`;
                }

                if (codes[code]) {
                    return `Kode ${code} digunakan lebih dari satu kali.`;
                }

                if (names[name]) {
                    return `Nama kriteria pada baris ${rowNumber} digunakan lebih dari satu kali.`;
                }

                if (Number(row.min_score) >= Number(row.max_score)) {
                    return `Nilai maksimal harus lebih besar dari nilai minimal pada baris ${rowNumber}.`;
                }

                codes[code] = true;
                names[name] = true;

                if (row.is_active) {
                    activeWeight += Number(row.weight_percent || 0);
                }
            }

            if (Math.abs(activeWeight - 100) > 0.01) {
                return `Total bobot kriteria aktif harus 100%. Total saat ini ${formatNumber(activeWeight)}%.`;
            }

            return null;
        }

        function renderStats(rows, fromDraft = false) {
            const total = rows.length;
            const active = rows.filter(item => isActive(item.is_active)).length;
            const benefit = rows.filter(item => item.type === 'benefit').length;

            const totalWeight = rows
                .filter(item => isActive(item.is_active))
                .reduce((sum, item) => {
                    const weight = fromDraft
                        ? Number(item.weight_percent || 0)
                        : Number(item.weight || 0) * 100;

                    return sum + weight;
                }, 0);

            setText('totalCriteria', total);
            setText('activeCriteria', active);
            setText('benefitCriteria', benefit);
            setText('totalWeight', `${formatNumber(totalWeight)}%`);

            const totalWeightElement = document.getElementById('totalWeight');

            if (totalWeightElement) {
                totalWeightElement.classList.remove('text-red-600', 'text-green-700', 'text-slate-900');

                if (Math.abs(totalWeight - 100) <= 0.01) {
                    totalWeightElement.classList.add('text-green-700');
                } else {
                    totalWeightElement.classList.add('text-red-600');
                }
            }

            const warningBox = document.getElementById('weightWarningBox');

            if (warningBox && isEditing) {
                warningBox.classList.remove(
                    'hidden',
                    'border-red-200',
                    'bg-red-50',
                    'text-red-700',
                    'border-green-200',
                    'bg-green-50',
                    'text-green-700'
                );

                if (Math.abs(totalWeight - 100) <= 0.01) {
                    warningBox.classList.add('border-green-200', 'bg-green-50', 'text-green-700');
                    warningBox.textContent = `Total bobot aktif sudah 100%. Data siap disimpan.`;
                } else {
                    warningBox.classList.add('border-red-200', 'bg-red-50', 'text-red-700');
                    warningBox.textContent = `Total bobot aktif saat ini ${formatNumber(totalWeight)}%. Total bobot harus tepat 100% sebelum disimpan.`;
                }
            }
        }

        function normalizeCollection(result) {
            if (Array.isArray(result?.data)) {
                return result.data;
            }

            if (Array.isArray(result?.data?.data)) {
                return result.data.data;
            }

            return [];
        }

        function getPeriodId() {
            return Number(document.getElementById('periodIdInput')?.value || 1);
        }

        function renderTypeBadge(type) {
            if (type === 'cost') {
                return `<span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-bold text-yellow-700">Cost</span>`;
            }

            return `<span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-700">Benefit</span>`;
        }

        function renderStatusBadge(value) {
            if (isActive(value)) {
                return `<span class="rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-700">Aktif</span>`;
            }

            return `<span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">Nonaktif</span>`;
        }

        function isActive(value) {
            return value === true || value === 1 || value === '1';
        }

        function showAlert(type, message) {
            const alert = document.getElementById('pageAlert');

            const classes = {
                success: 'border-green-200 bg-green-50 text-green-800',
                danger: 'border-red-200 bg-red-50 text-red-800',
                warning: 'border-yellow-200 bg-yellow-50 text-yellow-800',
                info: 'border-blue-200 bg-blue-50 text-blue-800',
            };

            alert.className = `mb-5 rounded-md border px-4 py-3 text-sm ${classes[type] || classes.info}`;
            alert.textContent = message;
            alert.classList.remove('hidden');

            setTimeout(() => {
                alert.classList.add('hidden');
            }, 5000);
        }

        function getErrorMessage(error) {
            if (error?.errors) {
                return Object.values(error.errors).flat().join(' ');
            }

            return error?.message || 'Terjadi kesalahan.';
        }

        function setText(id, value) {
            const element = document.getElementById(id);

            if (element) {
                element.textContent = value;
            }
        }

        function formatNumber(value) {
            return Number(value || 0).toLocaleString('id-ID', {
                maximumFractionDigits: 2,
            });
        }

        function escapeHtml(value) {
            return String(value ?? '')
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');
        }

        function escapeAttr(value) {
            return escapeHtml(value).replaceAll('`', '&#096;');
        }
    </script>
@endpush