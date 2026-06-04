@extends('layouts.admin')

@section('content')
    <section class="mb-7">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-[34px] font-extrabold leading-none tracking-tight text-[#00288E]">
                    Detail Jadwal Wawancara
                </h1>

                <p class="mt-2 text-sm font-medium text-slate-500">
                    Lihat informasi lengkap jadwal wawancara calon Duta PNJ.
                </p>
            </div>

            <div class="flex items-center gap-2">
                <x-button href="{{ route('admin.interviews.index') }}" variant="secondary">
                    Kembali
                </x-button>

                <x-button href="{{ route('admin.interviews.edit', $interviewId) }}">
                    Edit Jadwal
                </x-button>
            </div>
        </div>
    </section>

    <div id="pageAlert" class="mb-5 hidden rounded-md border px-4 py-3 text-sm"></div>

    <x-card>
        <div id="detailContent">
            <div class="py-10 text-center text-sm text-slate-500">
                Memuat detail jadwal wawancara...
            </div>
        </div>
    </x-card>
@endsection

@push('scripts')
    <script>
        const interviewId = @json($interviewId);

        document.addEventListener('DOMContentLoaded', function () {
            loadInterviewDetail();
        });

        async function loadInterviewDetail() {
            const content = document.getElementById('detailContent');

            try {
                const result = await DutaAdmin.request(`/interviews/${interviewId}`);
                const item = result?.data;

                if (!item) {
                    throw new Error('Data jadwal wawancara tidak ditemukan.');
                }

                content.innerHTML = `
                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                        <div class="rounded-lg border border-slate-200 p-4">
                            <p class="text-xs font-bold uppercase text-slate-500">Nama Calon</p>
                            <p class="mt-1 text-base font-extrabold text-slate-900">${escapeHtml(item.full_name || '-')}</p>
                        </div>

                        <div class="rounded-lg border border-slate-200 p-4">
                            <p class="text-xs font-bold uppercase text-slate-500">NIM</p>
                            <p class="mt-1 text-base font-extrabold text-slate-900">${escapeHtml(item.student_number || '-')}</p>
                        </div>

                        <div class="rounded-lg border border-slate-200 p-4">
                            <p class="text-xs font-bold uppercase text-slate-500">Nomor Pendaftaran</p>
                            <p class="mt-1 text-base font-extrabold text-slate-900">${escapeHtml(item.registration_number || '-')}</p>
                        </div>

                        <div class="rounded-lg border border-slate-200 p-4">
                            <p class="text-xs font-bold uppercase text-slate-500">Periode</p>
                            <p class="mt-1 text-base font-extrabold text-slate-900">${escapeHtml(item.election_year || '-')}</p>
                        </div>

                        <div class="rounded-lg border border-slate-200 p-4">
                            <p class="text-xs font-bold uppercase text-slate-500">Program Studi</p>
                            <p class="mt-1 text-base font-extrabold text-slate-900">${escapeHtml(item.study_program || '-')}</p>
                        </div>

                        <div class="rounded-lg border border-slate-200 p-4">
                            <p class="text-xs font-bold uppercase text-slate-500">Email</p>
                            <p class="mt-1 text-base font-extrabold text-slate-900">${escapeHtml(item.email || '-')}</p>
                        </div>

                        <div class="rounded-lg border border-slate-200 p-4">
                            <p class="text-xs font-bold uppercase text-slate-500">Tanggal dan Jam Wawancara</p>
                            <p class="mt-1 text-base font-extrabold text-[#00288E]">${formatDateTime(item.scheduled_at)}</p>
                        </div>

                        <div class="rounded-lg border border-slate-200 p-4">
                            <p class="text-xs font-bold uppercase text-slate-500">Lokasi</p>
                            <p class="mt-1 text-base font-extrabold text-slate-900">${escapeHtml(item.location || '-')}</p>
                        </div>

                        <div class="rounded-lg border border-slate-200 p-4">
                            <p class="text-xs font-bold uppercase text-slate-500">Status Wawancara</p>
                            <div class="mt-2">${renderStatusBadge(item.status)}</div>
                        </div>

                        <div class="rounded-lg border border-slate-200 p-4">
                            <p class="text-xs font-bold uppercase text-slate-500">Dibuat Oleh</p>
                            <p class="mt-1 text-base font-extrabold text-slate-900">${escapeHtml(item.created_by_name || '-')}</p>
                        </div>
                    </div>
                `;
            } catch (error) {
                content.innerHTML = `
                    <div class="rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                        ${escapeHtml(getErrorMessage(error))}
                    </div>
                `;
            }
        }

        function renderStatusBadge(status) {
            const labels = {
                scheduled: 'Terjadwal',
                completed: 'Selesai',
                absent: 'Tidak Hadir',
                cancelled: 'Dibatalkan',
            };

            const classes = {
                scheduled: 'bg-blue-100 text-blue-700',
                completed: 'bg-green-100 text-green-700',
                absent: 'bg-yellow-100 text-yellow-700',
                cancelled: 'bg-red-100 text-red-700',
            };

            return `
                <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold ${classes[status] || 'bg-slate-100 text-slate-700'}">
                    ${labels[status] || status || '-'}
                </span>
            `;
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