@extends('layouts.admin')

@section('content')
    <section class="mb-7">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-[34px] font-extrabold leading-none tracking-tight text-[#00288E]">
                    Assign Kriteria Juri
                </h1>

                <p class="mt-2 text-sm font-medium text-slate-500">
                    Tentukan kriteria penilaian yang menjadi tanggung jawab masing-masing juri.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <x-button type="button" variant="secondary" onclick="loadOptions()">
                    Muat Ulang
                </x-button>

                <x-button type="button" onclick="saveAssignment()">
                    Simpan Penugasan
                </x-button>
            </div>
        </div>
    </section>

    <div id="pageAlert" class="mb-5 hidden rounded-md border px-4 py-3 text-sm"></div>

    <section class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <x-card>
            <p class="text-sm font-semibold text-slate-700">Total Juri</p>
            <h2 id="totalJuries" class="mt-2 text-3xl font-extrabold text-slate-900">0</h2>
        </x-card>

        <x-card>
            <p class="text-sm font-semibold text-slate-700">Total Kriteria</p>
            <h2 id="totalCriteria" class="mt-2 text-3xl font-extrabold text-slate-900">0</h2>
        </x-card>

        <x-card>
            <p class="text-sm font-semibold text-slate-700">Kriteria Dipilih</p>
            <h2 id="selectedCriteriaCount" class="mt-2 text-3xl font-extrabold text-slate-900">0</h2>
        </x-card>
    </section>

    <section class="mt-7 grid grid-cols-1 gap-5 lg:grid-cols-[360px_1fr]">
        <x-card title="Pilih Juri" subtitle="Pilih juri yang akan diberikan kriteria penilaian.">
            <div class="space-y-4">
                <div>
                    <label for="periodIdInput" class="mb-2 block text-sm font-bold text-slate-700">
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
                    <label for="jurySelect" class="mb-2 block text-sm font-bold text-slate-700">
                        Nama Juri
                    </label>

                    <select
                        id="jurySelect"
                        onchange="onJuryChanged()"
                        class="h-11 w-full rounded-md border border-slate-300 bg-white px-4 text-sm outline-none focus:border-[#00288E] focus:ring-2 focus:ring-blue-100"
                    >
                        <option value="">Memuat data juri...</option>
                    </select>
                </div>

                <div id="juryInfoBox" class="hidden rounded-md border border-slate-200 bg-slate-50 px-4 py-3">
                    <p class="text-sm font-extrabold text-slate-900" id="juryNameText">-</p>
                    <p class="mt-1 text-xs text-slate-500" id="juryEmailText">-</p>
                    <p class="mt-1 text-xs text-slate-500" id="juryStatusText">-</p>
                </div>

                <x-alert type="info" title="Catatan">
                    Juri hanya akan melihat dan menilai kriteria yang ditugaskan oleh admin.
                </x-alert>
            </div>
        </x-card>

        <x-card title="Daftar Kriteria" subtitle="Centang kriteria yang akan dinilai oleh juri terpilih." padding="p-0">
            <div class="border-b border-slate-200 px-5 py-4">
                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <label class="inline-flex items-center gap-2 text-sm font-bold text-slate-700">
                        <input
                            id="selectAllCriteria"
                            type="checkbox"
                            onchange="toggleAllCriteria(this.checked)"
                            class="rounded border-slate-300"
                        >
                        Pilih semua kriteria
                    </label>

                    <div id="weightSummary" class="rounded-md border border-slate-200 bg-slate-50 px-3 py-2 text-sm font-bold text-slate-700">
                        Total bobot dipilih: 0%
                    </div>
                </div>
            </div>

            <div id="criteriaList" class="divide-y divide-slate-200">
                <div class="px-5 py-8 text-center text-slate-500">
                    Memuat data kriteria...
                </div>
            </div>
        </x-card>
    </section>

    <section class="mt-7">
        <x-card title="Ringkasan Penugasan" subtitle="Ringkasan kriteria yang sedang ditugaskan kepada juri.">
            <div id="assignmentSummary" class="text-sm text-slate-600">
                Pilih juri terlebih dahulu.
            </div>
        </x-card>
    </section>

    {{-- Modal Warning --}}
    <div id="warningModal" class="fixed inset-0 z-[90] hidden">
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
        let period = null;
        let juries = [];
        let criteria = [];
        let groupedAssignments = {};
        let selectedJuryId = null;
        let selectedCriteriaIds = [];

        document.addEventListener('DOMContentLoaded', function () {
            loadOptions();

            document.getElementById('periodIdInput')?.addEventListener('change', function () {
                loadOptions();
            });
        });

        async function loadOptions() {
            const criteriaList = document.getElementById('criteriaList');

            criteriaList.innerHTML = `
                <div class="px-5 py-8 text-center text-slate-500">
                    Memuat data kriteria...
                </div>
            `;

            try {
                const periodId = getPeriodId();
                const result = await DutaAdmin.request(`/jury-criteria/options?period_id=${periodId}`);

                const data = result?.data || {};

                period = data.period || null;
                juries = data.juries || [];
                criteria = data.criteria || [];
                groupedAssignments = data.grouped_assignments || {};

                renderStats();
                renderJurySelect();
                renderCriteriaList();

                const firstJury = juries[0];

                if (firstJury) {
                    document.getElementById('jurySelect').value = firstJury.id;
                    onJuryChanged();
                } else {
                    selectedJuryId = null;
                    selectedCriteriaIds = [];
                    renderJuryInfo();
                    renderAssignmentSummary();
                }
            } catch (error) {
                console.error(error);
                showAlert('danger', getErrorMessage(error));

                criteriaList.innerHTML = `
                    <div class="px-5 py-8 text-center text-red-600">
                        ${escapeHtml(getErrorMessage(error))}
                    </div>
                `;
            }
        }

        function renderStats() {
            setText('totalJuries', juries.length);
            setText('totalCriteria', criteria.length);
            setText('selectedCriteriaCount', selectedCriteriaIds.length);
        }

        function renderJurySelect() {
            const select = document.getElementById('jurySelect');

            if (!juries.length) {
                select.innerHTML = `<option value="">Belum ada data juri</option>`;
                return;
            }

            select.innerHTML = `
                <option value="">Pilih juri</option>
                ${juries.map(jury => `
                    <option value="${jury.id}">
                        ${escapeHtml(jury.name)} - ${escapeHtml(jury.email)}
                    </option>
                `).join('')}
            `;
        }

        function onJuryChanged() {
            selectedJuryId = Number(document.getElementById('jurySelect').value || 0);

            const assigned = groupedAssignments[selectedJuryId] || [];
            selectedCriteriaIds = assigned.map(id => Number(id));

            renderJuryInfo();
            renderCriteriaList();
            renderAssignmentSummary();
            renderStats();
        }

        function renderJuryInfo() {
            const box = document.getElementById('juryInfoBox');
            const jury = juries.find(item => Number(item.id) === Number(selectedJuryId));

            if (!jury) {
                box.classList.add('hidden');
                return;
            }

            document.getElementById('juryNameText').textContent = jury.name || '-';
            document.getElementById('juryEmailText').textContent = jury.email || '-';
            document.getElementById('juryStatusText').textContent = isActive(jury.is_active)
                ? 'Status akun: Aktif'
                : 'Status akun: Nonaktif';

            box.classList.remove('hidden');
        }

        function renderCriteriaList() {
            const container = document.getElementById('criteriaList');

            if (!criteria.length) {
                container.innerHTML = `
                    <div class="px-5 py-8 text-center text-slate-500">
                        Belum ada data kriteria pada periode ini.
                    </div>
                `;
                updateWeightSummary();
                return;
            }

            container.innerHTML = criteria.map(item => {
                const checked = selectedCriteriaIds.includes(Number(item.id)) ? 'checked' : '';
                const disabled = isActive(item.is_active) ? '' : 'disabled';

                return `
                    <label class="flex cursor-pointer items-start gap-4 px-5 py-4 hover:bg-slate-50 ${disabled ? 'opacity-60' : ''}">
                        <input
                            type="checkbox"
                            value="${item.id}"
                            ${checked}
                            ${disabled}
                            onchange="toggleCriterion(${item.id}, this.checked)"
                            class="mt-1 rounded border-slate-300"
                        >

                        <div class="flex-1">
                            <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                                <div>
                                    <p class="font-extrabold text-slate-900">
                                        ${escapeHtml(item.code)} - ${escapeHtml(item.name)}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-500">
                                        Rentang nilai ${escapeHtml(item.min_score ?? 0)} sampai ${escapeHtml(item.max_score ?? 100)}
                                    </p>
                                </div>

                                <div class="flex flex-wrap items-center gap-2">
                                    ${renderTypeBadge(item.type)}
                                    ${renderStatusBadge(item.is_active)}

                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-700">
                                        Bobot ${formatNumber(Number(item.weight || 0) * 100)}%
                                    </span>
                                </div>
                            </div>
                        </div>
                    </label>
                `;
            }).join('');

            updateSelectAllState();
            updateWeightSummary();
        }

        function toggleCriterion(id, checked) {
            id = Number(id);

            if (checked) {
                if (!selectedCriteriaIds.includes(id)) {
                    selectedCriteriaIds.push(id);
                }
            } else {
                selectedCriteriaIds = selectedCriteriaIds.filter(item => Number(item) !== id);
            }

            updateSelectAllState();
            updateWeightSummary();
            renderAssignmentSummary();
            renderStats();
        }

        function toggleAllCriteria(checked) {
            if (checked) {
                selectedCriteriaIds = criteria
                    .filter(item => isActive(item.is_active))
                    .map(item => Number(item.id));
            } else {
                selectedCriteriaIds = [];
            }

            renderCriteriaList();
            renderAssignmentSummary();
            renderStats();
        }

        function updateSelectAllState() {
            const checkbox = document.getElementById('selectAllCriteria');
            const activeCriteriaIds = criteria
                .filter(item => isActive(item.is_active))
                .map(item => Number(item.id));

            if (!activeCriteriaIds.length) {
                checkbox.checked = false;
                checkbox.indeterminate = false;
                return;
            }

            const selectedActiveCount = activeCriteriaIds.filter(id => selectedCriteriaIds.includes(id)).length;

            checkbox.checked = selectedActiveCount === activeCriteriaIds.length;
            checkbox.indeterminate = selectedActiveCount > 0 && selectedActiveCount < activeCriteriaIds.length;
        }

        function updateWeightSummary() {
            const totalWeight = criteria
                .filter(item => selectedCriteriaIds.includes(Number(item.id)))
                .reduce((sum, item) => sum + Number(item.weight || 0) * 100, 0);

            const summary = document.getElementById('weightSummary');

            summary.textContent = `Total bobot dipilih: ${formatNumber(totalWeight)}%`;

            summary.classList.remove(
                'border-slate-200',
                'bg-slate-50',
                'text-slate-700',
                'border-green-200',
                'bg-green-50',
                'text-green-700',
                'border-yellow-200',
                'bg-yellow-50',
                'text-yellow-800'
            );

            if (Math.abs(totalWeight - 100) <= 0.01) {
                summary.classList.add('border-green-200', 'bg-green-50', 'text-green-700');
            } else {
                summary.classList.add('border-yellow-200', 'bg-yellow-50', 'text-yellow-800');
            }
        }

        function renderAssignmentSummary() {
            const container = document.getElementById('assignmentSummary');
            const jury = juries.find(item => Number(item.id) === Number(selectedJuryId));

            if (!jury) {
                container.innerHTML = `Pilih juri terlebih dahulu.`;
                return;
            }

            const selected = criteria.filter(item => selectedCriteriaIds.includes(Number(item.id)));

            if (!selected.length) {
                container.innerHTML = `
                    <p class="text-red-600 font-semibold">
                        Belum ada kriteria yang dipilih untuk ${escapeHtml(jury.name)}.
                    </p>
                `;
                return;
            }

            container.innerHTML = `
                <p class="font-semibold text-slate-700">
                    ${escapeHtml(jury.name)} akan menilai ${selected.length} kriteria:
                </p>

                <div class="mt-3 flex flex-wrap gap-2">
                    ${selected.map(item => `
                        <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-700">
                            ${escapeHtml(item.code)}
                        </span>
                    `).join('')}
                </div>
            `;
        }

        async function saveAssignment() {
            if (!selectedJuryId) {
                showWarningModal('Juri belum dipilih', 'Pilih juri terlebih dahulu sebelum menyimpan penugasan.');
                return;
            }

            if (!selectedCriteriaIds.length) {
                showWarningModal('Kriteria belum dipilih', 'Pilih minimal satu kriteria untuk juri ini.');
                return;
            }

            const jury = juries.find(item => Number(item.id) === Number(selectedJuryId));

            if (jury && !isActive(jury.is_active)) {
                showWarningModal('Akun juri nonaktif', 'Penugasan tidak dapat disimpan karena akun juri sedang nonaktif.');
                return;
            }

            const payload = {
                period_id: getPeriodId(),
                user_id: selectedJuryId,
                criteria: selectedCriteriaIds,
            };

            try {
                await DutaAdmin.request('/jury-criteria/sync', {
                    method: 'POST',
                    body: JSON.stringify(payload),
                });

                showAlert('success', 'Penugasan kriteria juri berhasil disimpan.');
                await loadOptions();
            } catch (error) {
                console.error(error);
                showWarningModal('Gagal menyimpan penugasan', getErrorMessage(error));
            }
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

        function showWarningModal(title, message) {
            document.getElementById('warningModalTitle').textContent = title || 'Peringatan';
            document.getElementById('warningModalMessage').textContent = message || 'Terjadi kesalahan.';
            document.getElementById('warningModal').classList.remove('hidden');
        }

        function closeWarningModal() {
            document.getElementById('warningModal').classList.add('hidden');
        }

        function getErrorMessage(error) {
            if (error?.errors) {
                return Object.values(error.errors).flat().join(' ');
            }

            return error?.message || 'Terjadi kesalahan.';
        }

        function isActive(value) {
            return value === true || value === 1 || value === '1';
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
    </script>
@endpush