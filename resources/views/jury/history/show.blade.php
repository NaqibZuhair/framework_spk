@extends('layouts.jury')

@section('content')
    <section class="mb-7">
        <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
            <div>
                <div class="mb-3 flex items-center gap-2 text-sm font-semibold text-slate-500">
                    <a href="{{ route('jury.history.index') }}" class="hover:text-[#00288E]">Riwayat Penilaian</a>
                    <span>/</span>
                    <span class="text-[#00288E]">Detail</span>
                </div>

                <h1 class="text-[34px] font-extrabold leading-tight tracking-tight text-[#00288E]">
                    Detail Riwayat Penilaian
                </h1>

                <p class="mt-2 text-sm font-medium text-slate-500">
                    Lihat rekap nilai yang sudah kamu berikan untuk peserta ini.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a
                    id="editScoreLink"
                    href="#"
                    class="hidden rounded-md bg-[#00288E] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#001F73]"
                >
                    Edit Nilai
                </a>

                <a
                    id="backLink"
                    href="{{ route('jury.history.index') }}"
                    class="rounded-md border border-slate-300 bg-white px-5 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-50"
                >
                    Kembali
                </a>
            </div>
        </div>
    </section>

    <div id="pageAlert" class="mb-5 hidden rounded-md border px-4 py-3 text-sm"></div>

    <section id="loadingState">
        <x-card>
            <div class="py-10 text-center text-sm text-slate-500">
                Memuat detail riwayat...
            </div>
        </x-card>
    </section>

    <section id="detailContent" class="hidden space-y-6">
        <section class="grid grid-cols-1 gap-4 md:grid-cols-4">
            <x-card>
                <p class="text-sm font-semibold text-slate-700">Nama Peserta</p>
                <h2 id="candidateName" class="mt-2 text-xl font-extrabold text-slate-900">-</h2>
            </x-card>

            <x-card>
                <p class="text-sm font-semibold text-slate-700">Kriteria Terisi</p>
                <h2 id="filledCriteria" class="mt-2 text-3xl font-extrabold text-[#00288E]">0/0</h2>
            </x-card>

            <x-card>
                <p class="text-sm font-semibold text-slate-700">Rata-rata Nilai</p>
                <h2 id="averageScore" class="mt-2 text-3xl font-extrabold text-slate-900">0</h2>
            </x-card>

            <x-card>
                <p class="text-sm font-semibold text-slate-700">Status Nilai</p>
                <div id="lockStatus" class="mt-3"></div>
            </x-card>
        </section>

        <x-card>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div class="flex items-start gap-3 rounded-xl bg-slate-50 px-4 py-4">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-900">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                            <path d="M7 4H17V20H7V4Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                            <path d="M9 8H15M9 12H15M9 16H12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>

                    <div class="min-w-0">
                        <p class="text-xs font-extrabold uppercase tracking-wide text-slate-400">
                            NIM
                        </p>

                        <p id="studentNumber" class="mt-1 truncate text-base font-extrabold text-slate-900">
                            -
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-3 rounded-xl bg-slate-50 px-4 py-4">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-900">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                            <path d="M4 6H20V18H4V6Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                            <path d="M8 10H16M8 14H13" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>

                    <div class="min-w-0">
                        <p class="text-xs font-extrabold uppercase tracking-wide text-slate-400">
                            Nomor Pendaftaran
                        </p>

                        <p id="registrationNumber" class="mt-1 truncate text-base font-extrabold text-slate-900">
                            -
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-3 rounded-xl bg-slate-50 px-4 py-4">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-900">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                            <path d="M12 4L21 8.5L12 13L3 8.5L12 4Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                            <path d="M6 11V16C6 17.7 8.7 19 12 19C15.3 19 18 17.7 18 16V11" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>

                    <div class="min-w-0">
                        <p class="text-xs font-extrabold uppercase tracking-wide text-slate-400">
                            Program Studi
                        </p>

                        <p id="studyProgram" class="mt-1 truncate text-base font-extrabold text-slate-900">
                            -
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-3 rounded-xl bg-slate-50 px-4 py-4">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-900">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                            <path d="M12 3L20 7V12C20 17 16.5 20.2 12 21C7.5 20.2 4 17 4 12V7L12 3Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                            <path d="M9 12L11 14L15.5 9.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>

                    <div class="min-w-0">
                        <p class="text-xs font-extrabold uppercase tracking-wide text-slate-400">
                            Status Peserta
                        </p>

                        <div id="candidateStatus" class="mt-2"></div>
                    </div>
                </div>
            </div>
        </x-card>

        <x-card padding="p-0">
            <div class="border-b border-slate-200 px-5 py-4">
                <h2 class="text-lg font-extrabold text-[#00288E]">
                    Tabel Nilai Kriteria
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Detail nilai per kriteria yang ditugaskan kepada kamu.
                </p>
            </div>

            <x-table
                :headers="['Kode', 'Nama Kriteria', 'Tipe', 'Rentang Nilai', 'Nilai Saya', 'Terakhir Diubah', 'Status']"
                tbody-id="criteriaTableBody"
                class="rounded-none border-0 shadow-none"
            >
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-slate-500">
                        Memuat detail nilai...
                    </td>
                </tr>
            </x-table>
        </x-card>
    </section>
@endsection

@push('scripts')
    <script>
        const candidateId = @json($candidateId);
        let detailData = null;

        document.addEventListener('DOMContentLoaded', function () {
            const periodId = getPeriodId();

            document.getElementById('backLink').href = `/jury/history?period_id=${periodId}`;
            document.getElementById('editScoreLink').href = `/jury/scoring/${candidateId}/form?period_id=${periodId}`;

            loadHistoryDetail();
        });

        async function loadHistoryDetail() {
            try {
                const params = new URLSearchParams({
                    period_id: getPeriodId(),
                });

                const result = await DutaJury.request(`/jury/scoring-history/${candidateId}?${params.toString()}`);

                detailData = result?.data;

                renderDetail();
                renderCriteriaTable();

                document.getElementById('loadingState').classList.add('hidden');
                document.getElementById('detailContent').classList.remove('hidden');
            } catch (error) {
                document.getElementById('loadingState').innerHTML = `
                    <div class="rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-semibold text-red-700">
                        ${escapeHtml(getErrorMessage(error))}
                    </div>
                `;
            }
        }

        function renderDetail() {
            const candidate = detailData?.candidate || {};
            const summary = detailData?.summary || {};

            setText('candidateName', candidate.full_name || '-');
            setText('studentNumber', candidate.student_number || '-');
            setText('registrationNumber', candidate.registration_number || '-');
            setText('studyProgram', candidate.study_program || '-');
            setText('filledCriteria', `${summary.filled_count || 0}/${summary.criteria_count || 0}`);
            setText('averageScore', summary.average_score === null ? '-' : formatNumber(summary.average_score));

            document.getElementById('candidateStatus').innerHTML = renderSimpleBadge(candidate.status || '-');

            if (detailData?.is_result_published) {
                document.getElementById('lockStatus').innerHTML = renderBadge('Terkunci', 'red');
                document.getElementById('editScoreLink').classList.add('hidden');
            } else {
                document.getElementById('lockStatus').innerHTML = renderBadge('Masih Bisa Diedit', 'green');
                document.getElementById('editScoreLink').classList.remove('hidden');
            }
        }

        function renderCriteriaTable() {
            const tableBody = document.getElementById('criteriaTableBody');
            const criteria = detailData?.criteria || [];

            if (!criteria.length) {
                tableBody.innerHTML = emptyRow(7, 'Belum ada kriteria yang ditugaskan.');
                return;
            }

            tableBody.innerHTML = criteria.map(item => `
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4 font-extrabold text-[#00288E]">
                        ${escapeHtml(item.code || '-')}
                    </td>

                    <td class="px-6 py-4">
                        <p class="font-semibold text-slate-900">${escapeHtml(item.name || '-')}</p>
                    </td>

                    <td class="px-6 py-4">
                        ${renderSimpleBadge(item.type || 'benefit')}
                    </td>

                    <td class="px-6 py-4 text-slate-700">
                        ${escapeHtml(item.min_score ?? 0)} - ${escapeHtml(item.max_score ?? 100)}
                    </td>

                    <td class="px-6 py-4 font-extrabold text-slate-900">
                        ${item.score === null ? '-' : formatNumber(item.score)}
                    </td>

                    <td class="px-6 py-4 text-slate-700">
                        ${formatDateTime(item.updated_at)}
                    </td>

                    <td class="px-6 py-4">
                        ${item.score === null
                            ? renderBadge('Belum Terisi', 'yellow')
                            : renderBadge('Terisi', 'green')
                        }
                    </td>
                </tr>
            `).join('');
        }

        function renderSimpleBadge(text) {
            return `
                <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-700">
                    ${escapeHtml(text)}
                </span>
            `;
        }

        function renderBadge(text, color) {
            const classes = {
                green: 'bg-green-100 text-green-700',
                yellow: 'bg-yellow-100 text-yellow-700',
                red: 'bg-red-100 text-red-700',
            };

            return `
                <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold ${classes[color] || classes.green}">
                    ${escapeHtml(text)}
                </span>
            `;
        }

        function getPeriodId() {
            const params = new URLSearchParams(window.location.search);
            return params.get('period_id') || 1;
        }

        function formatNumber(value) {
            return new Intl.NumberFormat('id-ID', {
                maximumFractionDigits: 2,
            }).format(Number(value || 0));
        }

        function formatDateTime(value) {
            if (!value) return '-';

            const date = new Date(value);

            if (Number.isNaN(date.getTime())) return value;

            return date.toLocaleString('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
            });
        }

        function emptyRow(colspan, message) {
            return `
                <tr>
                    <td colspan="${colspan}" class="px-6 py-8 text-center text-slate-500">
                        ${escapeHtml(message)}
                    </td>
                </tr>
            `;
        }

        function getErrorMessage(error) {
            return error?.message || 'Terjadi kesalahan.';
        }

        function setText(id, value) {
            const element = document.getElementById(id);
            if (element) element.textContent = value;
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