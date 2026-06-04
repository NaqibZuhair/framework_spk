@extends('layouts.admin')

@section('content')
    <section class="mb-7">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-[34px] font-extrabold leading-none tracking-tight text-[#00288E]">
                    Edit Jadwal Wawancara
                </h1>

                <p class="mt-2 text-sm font-medium text-slate-500">
                    Ubah tanggal, lokasi, dan status jadwal wawancara.
                </p>
            </div>

            <div class="flex items-center gap-2">
                <x-button href="{{ route('admin.interviews.show', $interviewId) }}" variant="secondary">
                    Detail
                </x-button>

                <x-button href="{{ route('admin.interviews.index') }}" variant="secondary">
                    Kembali
                </x-button>
            </div>
        </div>
    </section>

    <div id="pageAlert" class="mb-5 hidden rounded-md border px-4 py-3 text-sm"></div>

    <x-card>
        <div id="loadingState" class="py-8 text-center text-sm text-slate-500">
            Memuat data jadwal wawancara...
        </div>

        <form id="interviewForm" class="hidden space-y-5">
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-bold text-slate-700">
                        Nama Calon
                    </label>

                    <input
                        id="candidateName"
                        type="text"
                        disabled
                        class="h-11 w-full rounded-md border border-slate-200 bg-slate-100 px-4 text-sm text-slate-700"
                    >
                </div>

                <div>
                    <label class="mb-2 block text-sm font-bold text-slate-700">
                        NIM
                    </label>

                    <input
                        id="studentNumber"
                        type="text"
                        disabled
                        class="h-11 w-full rounded-md border border-slate-200 bg-slate-100 px-4 text-sm text-slate-700"
                    >
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <x-input
                    label="Tanggal dan Jam Wawancara"
                    name="scheduled_at"
                    type="datetime-local"
                    required
                />

                <div>
                    <label for="status" class="mb-2 block text-sm font-bold text-slate-700">
                        Status <span class="text-red-600">*</span>
                    </label>

                    <select
                        id="status"
                        required
                        class="h-11 w-full rounded-md border border-slate-300 bg-white px-4 text-sm outline-none focus:border-[#00288E] focus:ring-2 focus:ring-blue-100"
                    >
                        <option value="scheduled">Terjadwal</option>
                        <option value="completed">Selesai</option>
                        <option value="absent">Tidak Hadir</option>
                        <option value="cancelled">Dibatalkan</option>
                    </select>
                </div>
            </div>

            <x-input
                label="Lokasi"
                name="location"
                placeholder="Contoh: Ruang Aula PNJ"
            />

            <div class="flex justify-end gap-2 border-t border-slate-200 pt-5">
                <x-button href="{{ route('admin.interviews.index') }}" variant="secondary">
                    Batal
                </x-button>

                <x-button type="submit">
                    Simpan Perubahan
                </x-button>
            </div>
        </form>
    </x-card>
@endsection

@push('scripts')
    <script>
        const interviewId = @json($interviewId);

        document.addEventListener('DOMContentLoaded', function () {
            loadInterview();

            document.getElementById('interviewForm')?.addEventListener('submit', submitInterview);
        });

        async function loadInterview() {
            try {
                const result = await DutaAdmin.request(`/interviews/${interviewId}`);
                const item = result?.data;

                if (!item) {
                    throw new Error('Data jadwal wawancara tidak ditemukan.');
                }

                document.getElementById('candidateName').value = item.full_name || '-';
                document.getElementById('studentNumber').value = item.student_number || '-';
                document.getElementById('scheduled_at').value = toDatetimeLocalValue(item.scheduled_at);
                document.getElementById('location').value = item.location || '';
                document.getElementById('status').value = item.status || 'scheduled';

                document.getElementById('loadingState').classList.add('hidden');
                document.getElementById('interviewForm').classList.remove('hidden');
            } catch (error) {
                document.getElementById('loadingState').innerHTML = `
                    <div class="rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                        ${escapeHtml(getErrorMessage(error))}
                    </div>
                `;
            }
        }

        async function submitInterview(event) {
            event.preventDefault();

            const payload = {
                scheduled_at: document.getElementById('scheduled_at').value,
                location: document.getElementById('location').value || null,
                status: document.getElementById('status').value,
            };

            try {
                const result = await DutaAdmin.request(`/interviews/${interviewId}`, {
                    method: 'PATCH',
                    body: JSON.stringify(payload),
                });

                showAlert('success', result.message || 'Jadwal wawancara berhasil diperbarui.');

                setTimeout(() => {
                    window.location.href = `/admin/interviews/${interviewId}`;
                }, 700);
            } catch (error) {
                showAlert('danger', getErrorMessage(error));
            }
        }

        function toDatetimeLocalValue(value) {
            if (!value) return '';

            const date = new Date(value);

            if (Number.isNaN(date.getTime())) return '';

            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            const hour = String(date.getHours()).padStart(2, '0');
            const minute = String(date.getMinutes()).padStart(2, '0');

            return `${year}-${month}-${day}T${hour}:${minute}`;
        }

        function showAlert(type, message) {
            const alert = document.getElementById('pageAlert');

            const classes = {
                success: 'border-green-200 bg-green-50 text-green-800',
                danger: 'border-red-200 bg-red-50 text-red-800',
                info: 'border-blue-200 bg-blue-50 text-blue-800',
            };

            alert.className = `mb-5 rounded-md border px-4 py-3 text-sm ${classes[type] || classes.info}`;
            alert.textContent = message;
            alert.classList.remove('hidden');
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
