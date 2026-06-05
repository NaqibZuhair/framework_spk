@extends('layouts.admin')

@section('content')
    <section class="mb-7">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <div class="mb-3 flex items-center gap-2 text-sm font-semibold text-slate-500">
                    <a href="{{ route('admin.juries.index') }}" class="hover:text-[#00288E]">Akun Juri</a>
                    <span>/</span>
                    <span class="text-[#00288E]">Detail Juri</span>
                </div>

                <h1 class="text-[34px] font-extrabold leading-none tracking-tight text-[#00288E]">
                    Detail Akun Juri
                </h1>

                <p class="mt-2 text-sm font-medium text-slate-500">
                    Lihat informasi akun juri dan kriteria yang ditugaskan.
                </p>
            </div>

            <div class="flex items-center gap-2">
                <x-button href="{{ route('admin.juries.index') }}" variant="secondary">
                    Kembali
                </x-button>

                <x-button href="{{ route('admin.juries.edit', $juryId) }}">
                    Edit Juri
                </x-button>
            </div>
        </div>
    </section>

    <div id="pageAlert" class="mb-5 hidden rounded-md border px-4 py-3 text-sm"></div>

    <div id="loadingState">
        <x-card>
            <div class="py-8 text-center text-sm text-slate-500">
                Memuat detail akun juri...
            </div>
        </x-card>
    </div>

    <div id="detailContent" class="hidden space-y-6">
        <section class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <x-card>
                <p class="text-sm font-semibold text-slate-700">Status Akun</p>
                <div id="juryStatus" class="mt-3"></div>
            </x-card>

            <x-card>
                <p class="text-sm font-semibold text-slate-700">Total Kriteria</p>
                <h2 id="criteriaCount" class="mt-2 text-3xl font-extrabold text-slate-900">0</h2>
            </x-card>

            <x-card>
                <p class="text-sm font-semibold text-slate-700">Role</p>
                <h2 id="juryRole" class="mt-2 text-3xl font-extrabold text-slate-900">-</h2>
            </x-card>
        </section>

        <x-card>
            <div class="mb-5 border-b border-slate-200 pb-4">
                <h2 class="text-lg font-extrabold text-slate-900">
                    Informasi Akun
                </h2>
                <p class="mt-1 text-sm text-slate-500">
                    Data akun juri yang digunakan untuk login dan akses penilaian.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div>
                    <p class="text-xs font-bold uppercase text-slate-500">Nama Juri</p>
                    <p id="juryName" class="mt-1 text-base font-extrabold text-slate-900">-</p>
                </div>

                <div>
                    <p class="text-xs font-bold uppercase text-slate-500">Email</p>
                    <p id="juryEmail" class="mt-1 text-base font-semibold text-slate-700">-</p>
                </div>

                <div>
                    <p class="text-xs font-bold uppercase text-slate-500">Nomor HP</p>
                    <p id="juryPhone" class="mt-1 text-base font-semibold text-slate-700">-</p>
                </div>

                <div>
                    <p class="text-xs font-bold uppercase text-slate-500">ID Juri</p>
                    <p id="juryIdText" class="mt-1 text-base font-semibold text-slate-700">-</p>
                </div>
            </div>
        </x-card>

        <x-card padding="p-0">
            <div class="border-b border-slate-200 px-5 py-4">
                <h2 class="text-lg font-extrabold text-slate-900">
                    Kriteria yang Ditugaskan
                </h2>
                <p class="mt-1 text-sm text-slate-500">
                    Daftar kriteria yang dapat dinilai oleh juri ini.
                </p>
            </div>

            <x-table
                :headers="['Kode', 'Nama Kriteria', 'Bobot', 'Tipe', 'Rentang Nilai', 'Status']"
                tbody-id="criteriaTableBody"
                class="rounded-none border-0 shadow-none"
            >
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                        Memuat data kriteria...
                    </td>
                </tr>
            </x-table>
        </x-card>
    </div>
@endsection

@push('scripts')
    <script>
        const juryId = @json($juryId);

        document.addEventListener('DOMContentLoaded', function () {
            loadJuryDetail();
        });

        async function loadJuryDetail() {
            try {
                const result = await DutaAdmin.request(`/juries/${juryId}`);
                const jury = result?.data;

                if (!jury) {
                    throw new Error('Data juri tidak ditemukan.');
                }

                renderJuryDetail(jury);

                document.getElementById('loadingState').classList.add('hidden');
                document.getElementById('detailContent').classList.remove('hidden');
            } catch (error) {
                document.getElementById('loadingState').innerHTML = `
                    <x-card>
                        <div class="rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                            ${escapeHtml(getErrorMessage(error))}
                        </div>
                    </x-card>
                `;
            }
        }

        function renderJuryDetail(jury) {
            const criteria = jury.criteria || [];

            setText('juryName', jury.name || '-');
            setText('juryEmail', jury.email || '-');
            setText('juryPhone', jury.phone || '-');
            setText('juryIdText', jury.id || '-');
            setText('criteriaCount', criteria.length);
            setText('juryRole', jury.role || 'juri');

            document.getElementById('juryStatus').innerHTML = renderStatusBadge(jury.is_active);

            renderCriteriaTable(criteria);
        }

        function renderCriteriaTable(criteria) {
            const tableBody = document.getElementById('criteriaTableBody');

            if (!criteria.length) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                            Belum ada kriteria yang ditugaskan kepada juri ini.
                        </td>
                    </tr>
                `;
                return;
            }

            tableBody.innerHTML = criteria.map(item => `
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4 font-extrabold text-[#00288E]">
                        ${escapeHtml(item.code || '-')}
                    </td>

                    <td class="px-6 py-4 font-semibold text-slate-900">
                        ${escapeHtml(item.name || '-')}
                    </td>

                    <td class="px-6 py-4 text-slate-700">
                        ${formatWeight(item.weight)}
                    </td>

                    <td class="px-6 py-4">
                        ${renderTypeBadge(item.type)}
                    </td>

                    <td class="px-6 py-4 text-slate-700">
                        ${escapeHtml(item.min_score ?? '0')} - ${escapeHtml(item.max_score ?? '100')}
                    </td>

                    <td class="px-6 py-4">
                        ${renderActiveBadge(item.is_active)}
                    </td>
                </tr>
            `).join('');
        }

        function renderStatusBadge(isActive) {
            return isActiveValue(isActive)
                ? `<span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-700">Aktif</span>`
                : `<span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-bold text-red-700">Nonaktif</span>`;
        }

        function renderActiveBadge(isActive) {
            return isActiveValue(isActive)
                ? `<span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-700">Aktif</span>`
                : `<span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">Nonaktif</span>`;
        }

        function renderTypeBadge(type) {
            const value = String(type || '-').toLowerCase();

            if (value === 'benefit') {
                return `<span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-700">Benefit</span>`;
            }

            if (value === 'cost') {
                return `<span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-bold text-yellow-700">Cost</span>`;
            }

            return `<span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">-</span>`;
        }

        function formatWeight(value) {
            const number = Number(value || 0);

            if (number <= 1) {
                return `${formatNumber(number * 100)}%`;
            }

            return `${formatNumber(number)}%`;
        }

        function isActiveValue(value) {
            return value === true || value === 1 || value === '1';
        }

        function formatNumber(value) {
            const number = Number(value || 0);

            return new Intl.NumberFormat('id-ID', {
                maximumFractionDigits: 2,
            }).format(number);
        }

        function setText(id, value) {
            const element = document.getElementById(id);

            if (element) {
                element.textContent = value;
            }
        }

        function getErrorMessage(error) {
            return error?.message || 'Terjadi kesalahan.';
        }

        function escapeHtml(value) {
            return String(value)
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');
        }
    </script>
@endpush