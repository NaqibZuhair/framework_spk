@extends('layouts.admin')

@section('content')
    <section class="mb-7">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <div class="mb-3 text-sm font-semibold text-slate-500">
                    <a href="{{ url('/admin/dashboard') }}" class="hover:text-[#00288E]">Dashboard</a>
                    <span class="mx-2">›</span>
                    <a href="{{ url('/admin/juries') }}" class="hover:text-[#00288E]">Akun Juri</a>
                    <span class="mx-2">›</span>
                    <span class="text-[#00288E]">Edit Juri</span>
                </div>

                <h1 class="text-[34px] font-extrabold leading-none tracking-tight text-[#00288E]">
                    Edit Akun Juri
                </h1>

                <p class="mt-2 text-sm font-medium text-slate-500">
                    Perbarui data akun juri dan kriteria yang menjadi tugas penilaiannya.
                </p>
            </div>

            <x-button href="{{ url('/admin/juries') }}" variant="secondary">
                Kembali
            </x-button>
        </div>
    </section>

    <div id="pageAlert" class="mb-5 hidden rounded-md border px-4 py-3 text-sm"></div>

    <form id="juryForm" class="grid grid-cols-1 gap-6 xl:grid-cols-[1fr_340px]">
        <div class="space-y-6">
            <x-card>
                <div class="mb-5 border-b border-slate-200 pb-4">
                    <h2 class="text-base font-extrabold uppercase tracking-wide text-[#00288E]">
                        Informasi Akun Juri
                    </h2>

                    <p class="mt-2 text-sm italic text-slate-500">
                        Kosongkan kata sandi jika tidak ingin mengubah kata sandi akun juri.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <div>
                        <label for="name" class="mb-2 block text-sm font-bold text-slate-700">
                            Nama Lengkap <span class="text-red-600">*</span>
                        </label>

                        <input
                            id="name"
                            type="text"
                            required
                            placeholder="Contoh: Dr. Andi Wijaya"
                            class="h-11 w-full rounded-md border border-slate-300 bg-white px-4 text-sm outline-none focus:border-[#00288E] focus:ring-2 focus:ring-blue-100"
                        >
                    </div>

                    <div>
                        <label for="email" class="mb-2 block text-sm font-bold text-slate-700">
                            Alamat Email <span class="text-red-600">*</span>
                        </label>

                        <input
                            id="email"
                            type="email"
                            required
                            placeholder="andi@pnj.ac.id"
                            class="h-11 w-full rounded-md border border-slate-300 bg-white px-4 text-sm outline-none focus:border-[#00288E] focus:ring-2 focus:ring-blue-100"
                        >
                    </div>

                    <div>
                        <label for="phone" class="mb-2 block text-sm font-bold text-slate-700">
                            Nomor HP
                        </label>

                        <input
                            id="phone"
                            type="text"
                            placeholder="0812XXXXXXXX"
                            class="h-11 w-full rounded-md border border-slate-300 bg-white px-4 text-sm outline-none focus:border-[#00288E] focus:ring-2 focus:ring-blue-100"
                        >
                    </div>

                    <div>
                        <label for="is_active" class="mb-2 block text-sm font-bold text-slate-700">
                            Status Akun <span class="text-red-600">*</span>
                        </label>

                        <select
                            id="is_active"
                            required
                            class="h-11 w-full rounded-md border border-slate-300 bg-white px-4 text-sm outline-none focus:border-[#00288E] focus:ring-2 focus:ring-blue-100"
                        >
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-bold text-slate-700">
                            Kata Sandi Baru
                        </label>

                        <div class="relative">
                            <input
                                id="password"
                                type="password"
                                minlength="8"
                                autocomplete="new-password"
                                placeholder="Kosongkan jika tidak diubah"
                                class="h-11 w-full rounded-md border border-slate-300 bg-white px-4 pr-12 text-sm outline-none focus:border-[#00288E] focus:ring-2 focus:ring-blue-100"
                            >

                            <button
                                type="button"
                                onclick="togglePasswordVisibility('password', this)"
                                aria-label="Lihat kata sandi baru"
                                aria-pressed="false"
                                class="absolute right-3 top-1/2 -translate-y-1/2 rounded-md p-1.5 text-slate-500 hover:bg-slate-100 hover:text-[#00288E] focus:outline-none focus:ring-2 focus:ring-blue-100"
                            >
                                <span class="sr-only">Lihat kata sandi baru</span>

                                <svg class="icon-eye h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12s-3.75 6.75-9.75 6.75S2.25 12 2.25 12z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>

                                <svg class="icon-eye-off hidden h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.58 10.58A2 2 0 0012 14a2 2 0 001.42-.58" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.88 5.25A9.89 9.89 0 0112 5.03c6 0 9.75 6.97 9.75 6.97a18.28 18.28 0 01-3.08 3.95" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.61 6.61C3.85 8.48 2.25 12 2.25 12s3.75 6.75 9.75 6.75a9.92 9.92 0 004.15-.9" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label for="password_confirmation" class="mb-2 block text-sm font-bold text-slate-700">
                            Konfirmasi Kata Sandi Baru
                        </label>

                        <div class="relative">
                            <input
                                id="password_confirmation"
                                type="password"
                                minlength="8"
                                autocomplete="new-password"
                                placeholder="Ulangi kata sandi baru"
                                class="h-11 w-full rounded-md border border-slate-300 bg-white px-4 pr-12 text-sm outline-none focus:border-[#00288E] focus:ring-2 focus:ring-blue-100"
                            >

                            <button
                                type="button"
                                onclick="togglePasswordVisibility('password_confirmation', this)"
                                aria-label="Lihat konfirmasi kata sandi baru"
                                aria-pressed="false"
                                class="absolute right-3 top-1/2 -translate-y-1/2 rounded-md p-1.5 text-slate-500 hover:bg-slate-100 hover:text-[#00288E] focus:outline-none focus:ring-2 focus:ring-blue-100"
                            >
                                <span class="sr-only">Lihat konfirmasi kata sandi baru</span>

                                <svg class="icon-eye h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12s-3.75 6.75-9.75 6.75S2.25 12 2.25 12z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>

                                <svg class="icon-eye-off hidden h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.58 10.58A2 2 0 0012 14a2 2 0 001.42-.58" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.88 5.25A9.89 9.89 0 0112 5.03c6 0 9.75 6.97 9.75 6.97a18.28 18.28 0 01-3.08 3.95" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.61 6.61C3.85 8.48 2.25 12 2.25 12s3.75 6.75 9.75 6.75a9.92 9.92 0 004.15-.9" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <p class="mt-2 text-xs text-slate-500">
                    Kosongkan jika tidak ingin mengubah kata sandi. Jika diisi, gunakan minimal 8 karakter dengan huruf besar, huruf kecil, angka, dan simbol.
                </p>

            </x-card>

            <x-card>
                <div class="mb-5 flex flex-col gap-3 border-b border-slate-200 pb-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="text-base font-extrabold uppercase tracking-wide text-[#00288E]">
                            Kriteria yang Dinilai
                        </h2>

                        <p class="mt-2 text-sm text-slate-500">
                            Perbarui kriteria yang menjadi tanggung jawab juri ini.
                        </p>
                    </div>

                    <div class="w-full md:w-40">
                        <label for="period_id" class="mb-1 block text-xs font-bold text-slate-600">
                            Periode ID
                        </label>

                        <input
                            id="period_id"
                            type="number"
                            min="1"
                            value="1"
                            class="h-10 w-full rounded-md border border-slate-300 bg-white px-3 text-sm outline-none focus:border-[#00288E] focus:ring-2 focus:ring-blue-100"
                        >
                    </div>
                </div>

                <div class="mb-4 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <label class="inline-flex items-center gap-2 text-sm font-bold text-slate-700">
                        <input
                            id="selectAllCriteria"
                            type="checkbox"
                            onchange="toggleAllCriteria(this.checked)"
                            class="rounded border-slate-300"
                        >
                        Pilih semua kriteria aktif
                    </label>

                    <div id="criteriaWeightInfo" class="rounded-md border border-slate-200 bg-slate-50 px-3 py-2 text-sm font-bold text-slate-700">
                        Total bobot dipilih: 0%
                    </div>
                </div>

                <div class="overflow-hidden rounded-lg border border-slate-200">
                    <table class="min-w-full text-left">
                        <thead class="bg-slate-100">
                            <tr class="text-xs uppercase tracking-wider text-slate-600">
                                <th class="px-4 py-4 font-extrabold">Pilih</th>
                                <th class="px-4 py-4 font-extrabold">Kode</th>
                                <th class="px-4 py-4 font-extrabold">Nama Kriteria</th>
                                <th class="px-4 py-4 font-extrabold">Bobot</th>
                                <th class="px-4 py-4 font-extrabold">Tipe</th>
                            </tr>
                        </thead>

                        <tbody id="criteriaTableBody" class="divide-y divide-slate-200 text-sm">
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-slate-500">
                                    Memuat data kriteria...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>

        <aside class="space-y-5">
            <x-card padding="p-0">
                <div class="rounded-t-xl bg-[#00288E] px-5 py-4">
                    <h2 class="text-sm font-extrabold uppercase tracking-wide text-white">
                        Ringkasan Akun
                    </h2>
                </div>

                <div class="space-y-5 p-5">
                    <div>
                        <p class="text-xs font-extrabold uppercase text-slate-500">
                            ID Juri
                        </p>

                        <p id="summaryJuryId" class="mt-1 text-sm font-extrabold text-slate-900">
                            -
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-extrabold uppercase text-slate-500">
                            Nama Juri
                        </p>

                        <p id="summaryName" class="mt-1 text-sm font-extrabold text-slate-900">
                            -
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 border-y border-slate-200 py-4">
                        <div>
                            <p class="text-xs font-extrabold uppercase text-slate-500">
                                Kriteria Dipilih
                            </p>

                            <p id="summaryCriteriaCount" class="mt-1 text-3xl font-extrabold text-[#00288E]">
                                0
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-extrabold uppercase text-slate-500">
                                Status
                            </p>

                            <span id="summaryStatus" class="mt-2 inline-flex rounded-md bg-yellow-100 px-3 py-1 text-sm font-extrabold text-yellow-800">
                                AKTIF
                            </span>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-extrabold uppercase text-slate-500">
                            Kode Kriteria
                        </p>

                        <div id="summaryCriteriaCodes" class="mt-2 flex flex-wrap gap-1.5">
                            <span class="text-sm text-slate-500">Belum ada kriteria dipilih.</span>
                        </div>
                    </div>

                    <div class="space-y-2 pt-2">
                        <x-button type="submit" class="w-full" id="submitButton">
                            Simpan Perubahan
                        </x-button>

                        <x-button href="{{ url('/admin/juries') }}" variant="secondary" class="w-full">
                            Batal
                        </x-button>
                    </div>
                </div>
            </x-card>

            <x-alert type="warning" title="Catatan">
                Jika juri sudah memberi nilai, beberapa kriteria mungkin tidak bisa dihapus dari penugasan.
            </x-alert>
        </aside>
    </form>

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
        const juryId = @json($juryId ?? null);

        let juryData = null;
        let criteriaData = [];
        let selectedCriteriaIds = [];

        document.addEventListener('DOMContentLoaded', function () {
            if (!juryId) {
                showWarningModal('Data tidak valid', 'ID juri tidak ditemukan.');
                return;
            }

            loadInitialData();

            document.getElementById('period_id')?.addEventListener('change', function () {
                selectedCriteriaIds = [];
                loadInitialData();
            });

            document.getElementById('name')?.addEventListener('input', updateSummary);
            document.getElementById('is_active')?.addEventListener('change', updateSummary);
            document.getElementById('juryForm')?.addEventListener('submit', submitJuryForm);
        });

        async function loadInitialData() {
            const tableBody = document.getElementById('criteriaTableBody');

            tableBody.innerHTML = `
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-slate-500">
                        Memuat data akun juri...
                    </td>
                </tr>
            `;

            try {
                const periodId = getPeriodId();

                const optionsResult = await DutaAdmin.request(`/juries/options?period_id=${periodId}`);
                const juryResult = await DutaAdmin.request(`/juries/${juryId}?period_id=${periodId}`);

                const optionsData = optionsResult?.data || {};
                criteriaData = optionsData.criteria || [];

                juryData = juryResult?.data || null;

                if (!juryData) {
                    showWarningModal('Data tidak ditemukan', 'Akun juri tidak ditemukan.');
                    return;
                }

                fillForm();
                renderCriteriaTable();
                updateSummary();
            } catch (error) {
                console.error(error);

                tableBody.innerHTML = `
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-red-600">
                            ${escapeHtml(getErrorMessage(error))}
                        </td>
                    </tr>
                `;

                showWarningModal('Gagal memuat data', getErrorMessage(error));
            }
        }

        function fillForm() {
            document.getElementById('name').value = juryData.name || '';
            document.getElementById('email').value = juryData.email || '';
            document.getElementById('phone').value = juryData.phone || '';
            document.getElementById('is_active').value = isActive(juryData.is_active) ? '1' : '0';
            document.getElementById('password').value = '';
            document.getElementById('password_confirmation').value = '';

            selectedCriteriaIds = (juryData.criteria || [])
                .map(item => Number(item.id))
                .filter(Boolean);

            setText('summaryJuryId', juryData.id || '-');
        }

        function renderCriteriaTable() {
            const tableBody = document.getElementById('criteriaTableBody');

            if (!criteriaData.length) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-slate-500">
                            Belum ada kriteria pada periode ini.
                        </td>
                    </tr>
                `;

                updateWeightInfo();
                updateSummary();
                return;
            }

            tableBody.innerHTML = criteriaData.map(item => {
                const id = Number(item.id);
                const checked = selectedCriteriaIds.includes(id) ? 'checked' : '';
                const disabled = isActive(item.is_active) ? '' : 'disabled';

                return `
                    <tr class="${disabled ? 'bg-slate-50 opacity-60' : 'hover:bg-slate-50'}">
                        <td class="px-4 py-4">
                            <input
                                type="checkbox"
                                value="${id}"
                                ${checked}
                                ${disabled}
                                onchange="toggleCriterion(${id}, this.checked)"
                                class="rounded border-slate-300"
                            >
                        </td>

                        <td class="px-4 py-4">
                            <span class="font-extrabold text-[#00288E]">
                                ${escapeHtml(item.code || '-')}
                            </span>
                        </td>

                        <td class="px-4 py-4">
                            <p class="font-bold text-slate-900">
                                ${escapeHtml(item.name || '-')}
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                Rentang nilai ${escapeHtml(item.min_score ?? 0)} sampai ${escapeHtml(item.max_score ?? 100)}
                            </p>
                        </td>

                        <td class="px-4 py-4 font-semibold text-slate-700">
                            ${formatNumber(Number(item.weight || 0) * 100)}%
                        </td>

                        <td class="px-4 py-4">
                            ${renderTypeBadge(item.type)}
                        </td>
                    </tr>
                `;
            }).join('');

            updateSelectAllState();
            updateWeightInfo();
            updateSummary();
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
            updateWeightInfo();
            updateSummary();
        }

        function toggleAllCriteria(checked) {
            if (checked) {
                selectedCriteriaIds = criteriaData
                    .filter(item => isActive(item.is_active))
                    .map(item => Number(item.id));
            } else {
                selectedCriteriaIds = [];
            }

            renderCriteriaTable();
        }

        function updateSelectAllState() {
            const selectAll = document.getElementById('selectAllCriteria');

            if (!selectAll) return;

            const activeCriteriaIds = criteriaData
                .filter(item => isActive(item.is_active))
                .map(item => Number(item.id));

            if (!activeCriteriaIds.length) {
                selectAll.checked = false;
                selectAll.indeterminate = false;
                return;
            }

            const selectedActiveCount = activeCriteriaIds.filter(id => selectedCriteriaIds.includes(id)).length;

            selectAll.checked = selectedActiveCount === activeCriteriaIds.length;
            selectAll.indeterminate = selectedActiveCount > 0 && selectedActiveCount < activeCriteriaIds.length;
        }

        function updateWeightInfo() {
            const totalWeight = criteriaData
                .filter(item => selectedCriteriaIds.includes(Number(item.id)))
                .reduce((sum, item) => sum + (Number(item.weight || 0) * 100), 0);

            const element = document.getElementById('criteriaWeightInfo');

            element.textContent = `Total bobot dipilih: ${formatNumber(totalWeight)}%`;

            element.classList.remove(
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

            if (selectedCriteriaIds.length === 0) {
                element.classList.add('border-slate-200', 'bg-slate-50', 'text-slate-700');
            } else if (Math.abs(totalWeight - 100) <= 0.01) {
                element.classList.add('border-green-200', 'bg-green-50', 'text-green-700');
            } else {
                element.classList.add('border-yellow-200', 'bg-yellow-50', 'text-yellow-800');
            }
        }

        function updateSummary() {
            const name = document.getElementById('name')?.value?.trim() || '-';
            const isActiveAccount = document.getElementById('is_active')?.value === '1';

            setText('summaryName', name);
            setText('summaryCriteriaCount', selectedCriteriaIds.length);

            const status = document.getElementById('summaryStatus');

            if (isActiveAccount) {
                status.textContent = 'AKTIF';
                status.className = 'mt-2 inline-flex rounded-md bg-yellow-100 px-3 py-1 text-sm font-extrabold text-yellow-800';
            } else {
                status.textContent = 'NONAKTIF';
                status.className = 'mt-2 inline-flex rounded-md bg-slate-200 px-3 py-1 text-sm font-extrabold text-slate-600';
            }

            const selected = criteriaData.filter(item => selectedCriteriaIds.includes(Number(item.id)));
            const codesContainer = document.getElementById('summaryCriteriaCodes');

            if (!selected.length) {
                codesContainer.innerHTML = `<span class="text-sm text-slate-500">Belum ada kriteria dipilih.</span>`;
                return;
            }

            codesContainer.innerHTML = selected.map(item => `
                <span class="rounded-md bg-blue-100 px-2 py-1 text-xs font-extrabold text-[#00288E]">
                    ${escapeHtml(item.code)}
                </span>
            `).join('');
        }

        async function submitJuryForm(event) {
            event.preventDefault();

            const validationMessage = validateForm();

            if (validationMessage) {
                showWarningModal('Data belum lengkap', validationMessage);
                return;
            }

            const submitButton = document.getElementById('submitButton');
            submitButton.disabled = true;
            submitButton.textContent = 'Menyimpan...';

            const payload = {
                period_id: getPeriodId(),
                name: document.getElementById('name').value.trim(),
                email: document.getElementById('email').value.trim().toLowerCase(),
                phone: document.getElementById('phone').value.trim(),
                is_active: document.getElementById('is_active').value === '1',
                criteria: selectedCriteriaIds,
            };

            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;

            if (password || passwordConfirmation) {
                payload.password = password;
                payload.password_confirmation = passwordConfirmation;
            }

            try {
                await DutaAdmin.request(`/juries/${juryId}`, {
                    method: 'PUT',
                    body: JSON.stringify(payload),
                });

                showAlert('success', 'Akun juri berhasil diperbarui. Mengalihkan ke daftar akun juri...');

                setTimeout(() => {
                    window.location.href = '/admin/juries';
                }, 900);
            } catch (error) {
                console.error(error);
                showWarningModal('Gagal menyimpan perubahan', getErrorMessage(error));
            } finally {
                submitButton.disabled = false;
                submitButton.textContent = 'Simpan Perubahan';
            }
        }

        function validateForm() {
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;

            if (!name) {
                return 'Nama lengkap juri wajib diisi.';
            }

            if (!email) {
                return 'Email juri wajib diisi.';
            }

            if (password || passwordConfirmation) {
                const passwordMessage = getStrongPasswordMessage(password, 'Kata sandi baru');

                if (passwordMessage) {
                    return passwordMessage;
                }

                if (password !== passwordConfirmation) {
                    return 'Kata sandi baru tidak sama.';
                }
            }

            if (!selectedCriteriaIds.length) {
                return 'Pilih minimal satu kriteria yang akan dinilai oleh juri.';
            }

            return null;
        }

        function getStrongPasswordMessage(password, label = 'Kata sandi') {
            if (password.length < 8) {
                return `${label} minimal 8 karakter.`;
            }

            const missing = [];

            if (!/[a-z]/.test(password)) {
                missing.push('huruf kecil');
            }

            if (!/[A-Z]/.test(password)) {
                missing.push('huruf besar');
            }

            if (!/[0-9]/.test(password)) {
                missing.push('angka');
            }

            if (!/[^A-Za-z0-9]/.test(password)) {
                missing.push('simbol');
            }

            if (missing.length) {
                return `${label} harus memiliki ${missing.join(', ')}. Contoh: DutaPNJ@2026`;
            }

            return null;
        }

        function getPeriodId() {
            return Number(document.getElementById('period_id')?.value || 1);
        }

        function renderTypeBadge(type) {
            if (type === 'cost') {
                return `<span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-bold text-yellow-700">Cost</span>`;
            }

            return `<span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-700">Benefit</span>`;
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

        function togglePasswordVisibility(inputId, button) {
            const input = document.getElementById(inputId);

            if (!input || !button) {
                return;
            }

            const iconEye = button.querySelector('.icon-eye');
            const iconEyeOff = button.querySelector('.icon-eye-off');
            const label = button.querySelector('.sr-only');

            const isHidden = input.type === 'password';

            input.type = isHidden ? 'text' : 'password';

            iconEye?.classList.toggle('hidden', isHidden);
            iconEyeOff?.classList.toggle('hidden', !isHidden);

            button.setAttribute('aria-pressed', isHidden ? 'true' : 'false');
            button.setAttribute('aria-label', isHidden ? 'Sembunyikan kata sandi' : 'Lihat kata sandi');

            if (label) {
                label.textContent = isHidden ? 'Sembunyikan kata sandi' : 'Lihat kata sandi';
            }
        }
    </script>
@endpush