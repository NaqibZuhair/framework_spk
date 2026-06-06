@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div>
            <a
                href="{{ route('admin.candidates.index') }}"
                class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-blue-900"
            >
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none">
                    <path d="M19 12H5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M12 19L5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Kembali ke Data Pendaftar
            </a>

            <h1 class="mt-4 text-3xl font-extrabold tracking-tight text-slate-900">
                Detail Verifikasi Pendaftar
            </h1>

            <p id="pageSubtitle" class="mt-2 text-sm text-slate-500">
                Memuat informasi pendaftar...
            </p>
        </div>

        <div id="headerStatusBadge"></div>
    </div>

    <div id="pageAlert" class="hidden rounded-xl border px-4 py-3 text-sm font-semibold"></div>

    <div id="loadingState" class="rounded-2xl border border-slate-200 bg-white p-8 text-center shadow-sm">
        <div class="mx-auto h-10 w-10 animate-spin rounded-full border-4 border-slate-200 border-t-blue-900"></div>

        <p class="mt-4 text-sm font-semibold text-slate-500">
            Memuat detail pendaftar...
        </p>
    </div>

    <div id="detailState" class="hidden space-y-6">
        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <aside class="space-y-6 xl:col-span-1">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex flex-col items-center text-center">
                        <div class="relative">
                            <img
                                id="candidatePhoto"
                                src=""
                                alt="Foto pendaftar"
                                class="hidden h-36 w-36 rounded-2xl border border-slate-200 object-cover"
                            >

                            <div
                                id="candidateInitialAvatar"
                                class="flex h-36 w-36 items-center justify-center rounded-2xl border border-slate-200 bg-blue-900 text-4xl font-extrabold text-white"
                            >
                                -
                            </div>

                            <span id="photoStatusBadge" class="absolute -bottom-2 -right-2 hidden rounded-full bg-green-500 p-2 text-white shadow">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none">
                                    <path d="M5 12.5L9.5 17L19 7" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        </div>

                        <h2 id="candidateName" class="mt-5 text-xl font-extrabold text-slate-900">
                            -
                        </h2>

                        <p id="candidateStudyProgram" class="mt-1 text-sm font-bold text-blue-900">
                            -
                        </p>

                        <div class="mt-4 flex flex-wrap justify-center gap-2">
                            <span id="candidateRegistrationNumber" class="rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-700">
                                -
                            </span>

                            <span id="candidateSemester" class="rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-700">
                                -
                            </span>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-sm font-extrabold uppercase tracking-wide text-slate-500">
                        Kontak
                    </h3>

                    <div class="mt-4 space-y-4 text-sm">
                        <div>
                            <p class="font-bold text-slate-500">Email</p>
                            <p id="candidateEmail" class="mt-1 font-semibold text-slate-900">-</p>
                        </div>

                        <div>
                            <p class="font-bold text-slate-500">Nomor WhatsApp</p>
                            <p id="candidatePhone" class="mt-1 font-semibold text-slate-900">-</p>
                        </div>
                    </div>
                </div>
            </aside>

            <section class="space-y-6 xl:col-span-2">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-start justify-between gap-4 border-b border-slate-200 pb-4">
                        <div>
                            <h2 class="text-xl font-extrabold text-slate-900">
                                Informasi Akademik
                            </h2>

                            <p class="mt-1 text-sm text-slate-500">
                                Data akademik yang diisi saat pendaftaran.
                            </p>
                        </div>

                        <svg class="h-6 w-6 text-blue-900" viewBox="0 0 24 24" fill="none">
                            <path d="M12 4L21 8.5L12 13L3 8.5L12 4Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                            <path d="M6 11V16C6 17.7 8.7 19 12 19C15.3 19 18 17.7 18 16V11" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>

                    <div class="mt-5 grid grid-cols-1 gap-5 md:grid-cols-2">
                        <div>
                            <p class="text-xs font-extrabold uppercase tracking-wide text-slate-500">
                                Nomor Induk Mahasiswa
                            </p>
                            <p id="candidateStudentNumber" class="mt-1 text-sm font-semibold text-slate-900">-</p>
                        </div>

                        <div>
                            <p class="text-xs font-extrabold uppercase tracking-wide text-slate-500">
                                Fakultas / Jurusan
                            </p>
                            <p id="candidateFaculty" class="mt-1 text-sm font-semibold text-slate-900">-</p>
                        </div>

                        <div>
                            <p class="text-xs font-extrabold uppercase tracking-wide text-slate-500">
                                Program Studi
                            </p>
                            <p id="candidateProgram" class="mt-1 text-sm font-semibold text-slate-900">-</p>
                        </div>

                        <div>
                            <p class="text-xs font-extrabold uppercase tracking-wide text-slate-500">
                                Periode Seleksi
                            </p>
                            <p id="candidatePeriod" class="mt-1 text-sm font-semibold text-slate-900">-</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h2 class="text-xl font-extrabold text-slate-900">
                            Visi
                        </h2>

                        <p id="candidateVision" class="mt-4 min-h-24 rounded-xl bg-slate-50 p-4 text-sm leading-6 text-slate-700">
                            -
                        </p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h2 class="text-xl font-extrabold text-slate-900">
                            Misi
                        </h2>

                        <p id="candidateMission" class="mt-4 min-h-24 rounded-xl bg-slate-50 p-4 text-sm leading-6 text-slate-700">
                            -
                        </p>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-start justify-between gap-4 border-b border-slate-200 pb-4">
                        <div>
                            <h2 class="text-xl font-extrabold text-slate-900">
                                Dokumen Pendukung
                            </h2>

                            <p class="mt-1 text-sm text-slate-500">
                                Dokumen yang diunggah saat pendaftaran.
                            </p>
                        </div>

                        <svg class="h-6 w-6 text-blue-900" viewBox="0 0 24 24" fill="none">
                            <path d="M4 6.5H10L12 8.5H20V18.5H4V6.5Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                        </svg>
                    </div>

                    <div id="documentList" class="mt-5 grid grid-cols-1 gap-4 md:grid-cols-2">
                        <p class="text-sm text-slate-500">
                            Memuat dokumen...
                        </p>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-xl font-extrabold text-slate-900">
                        Status Verifikasi
                    </h2>

                    <div class="mt-5 grid grid-cols-1 gap-5 md:grid-cols-2">
                        <div>
                            <p class="text-xs font-extrabold uppercase tracking-wide text-slate-500">
                                Diverifikasi Oleh
                            </p>
                            <p id="validatedBy" class="mt-1 text-sm font-semibold text-slate-900">-</p>
                        </div>

                        <div>
                            <p class="text-xs font-extrabold uppercase tracking-wide text-slate-500">
                                Tanggal Verifikasi
                            </p>
                            <p id="validatedAt" class="mt-1 text-sm font-semibold text-slate-900">-</p>
                        </div>
                    </div>

                    <div id="rejectionBox" class="mt-5 hidden rounded-xl border border-red-200 bg-red-50 p-4">
                        <p class="text-xs font-extrabold uppercase tracking-wide text-red-700">
                            Alasan Penolakan
                        </p>
                        <p id="rejectionReason" class="mt-2 text-sm leading-6 text-red-700">-</p>
                    </div>
                </div>
            </section>
        </div>

        <div id="actionBar" class="sticky bottom-4 z-10 rounded-2xl border border-slate-200 bg-white p-4 shadow-lg">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <p id="actionText" class="text-sm font-semibold text-slate-500">
                    Tinjau data pendaftar sebelum mengambil keputusan.
                </p>

                <div id="pendingActions" class="flex flex-col gap-3 sm:flex-row">
                    <button
                        type="button"
                        onclick="openRejectModal()"
                        class="inline-flex items-center justify-center rounded-lg border border-red-300 px-5 py-3 text-sm font-extrabold text-red-600 hover:bg-red-50"
                    >
                        Tolak Pendaftaran
                    </button>

                    <button
                        type="button"
                        onclick="openAcceptModal()"
                        class="inline-flex items-center justify-center rounded-lg bg-blue-900 px-5 py-3 text-sm font-extrabold text-white hover:bg-blue-800"
                    >
                        Verifikasi & Terima
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="acceptModal" class="fixed inset-0 z-50 hidden items-center justify-center backdrop-blur-sm bg-opacity-50 px-4">
        <div class="w-full max-w-md rounded-2xl bg-white shadow-xl">
            <div class="border-b border-slate-200 px-6 py-4">
                <h3 class="text-lg font-extrabold text-slate-900">
                    Konfirmasi Terima Pendaftar
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Status pendaftar akan berubah menjadi diterima.
                </p>
            </div>

            <div class="px-6 py-5">
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                    <p id="acceptCandidateName" class="font-extrabold text-slate-900">-</p>
                    <p id="acceptCandidateMeta" class="mt-1 text-sm text-slate-500">-</p>
                </div>

                <p class="mt-4 text-sm leading-6 text-slate-600">
                    Setelah dikonfirmasi, sistem akan mengirim email pemberitahuan ke pendaftar.
                </p>
            </div>

            <div class="flex justify-end gap-3 border-t border-slate-200 px-6 py-4">
                <button
                    type="button"
                    onclick="closeAcceptModal()"
                    class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-bold text-slate-700 hover:bg-slate-50"
                >
                    Batal
                </button>

                <button
                    id="acceptButton"
                    type="button"
                    onclick="acceptCandidate()"
                    class="rounded-lg bg-blue-900 px-4 py-2 text-sm font-bold text-white hover:bg-blue-800"
                >
                    Konfirmasi Terima
                </button>
            </div>
        </div>
    </div>

    <div id="rejectModal" class="fixed inset-0 z-50 hidden items-center justify-center backdrop-blur-sm bg-opacity-50 px-4">
        <div class="w-full max-w-md rounded-2xl bg-white shadow-xl">
            <div class="border-b border-slate-200 px-6 py-4">
                <h3 class="text-lg font-extrabold text-slate-900">
                    Tolak Pendaftaran
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Berikan alasan penolakan dengan jelas.
                </p>
            </div>

            <div class="px-6 py-5">
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                    <p id="rejectCandidateName" class="font-extrabold text-slate-900">-</p>
                    <p id="rejectCandidateMeta" class="mt-1 text-sm text-slate-500">-</p>
                </div>

                <div class="mt-4">
                    <label for="rejectReasonInput" class="text-sm font-bold text-slate-700">
                        Alasan Penolakan
                    </label>

                    <textarea
                        id="rejectReasonInput"
                        rows="4"
                        class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-900 focus:ring-2 focus:ring-blue-100"
                        placeholder="Contoh: Dokumen CV belum sesuai ketentuan."
                    ></textarea>

                    <p id="rejectReasonError" class="mt-2 hidden text-sm font-semibold text-red-600">
                        Alasan penolakan wajib diisi.
                    </p>
                </div>
            </div>

            <div class="flex justify-end gap-3 border-t border-slate-200 px-6 py-4">
                <button
                    type="button"
                    onclick="closeRejectModal()"
                    class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-bold text-slate-700 hover:bg-slate-50"
                >
                    Batal
                </button>

                <button
                    id="rejectButton"
                    type="button"
                    onclick="rejectCandidate()"
                    class="rounded-lg bg-red-600 px-4 py-2 text-sm font-bold text-white hover:bg-red-700"
                >
                    Konfirmasi Tolak
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const candidateId = @json($candidateId);
    let candidate = null;

    document.addEventListener('DOMContentLoaded', function () {
        loadCandidate();
    });

    async function loadCandidate() {
        showLoading();

        try {
            const result = await DutaAdmin.request(`/candidates/${candidateId}`);
            candidate = result?.data?.candidate || null;

            if (!candidate) {
                throw new Error('Data pendaftar tidak ditemukan.');
            }

            renderCandidate();
        } catch (error) {
            console.error('Gagal memuat detail pendaftar:', error);
            showAlert('error', getErrorMessage(error, 'Detail pendaftar gagal dimuat.'));
            showErrorState();
        }
    }

    function renderCandidate() {
        document.getElementById('loadingState')?.classList.add('hidden');
        document.getElementById('detailState')?.classList.remove('hidden');

        setText('pageSubtitle', `${candidate.registration_number || '-'} · ${candidate.full_name || '-'}`);

        setText('candidateName', candidate.full_name || '-');
        setText('candidateStudyProgram', candidate.study_program || '-');
        setText('candidateRegistrationNumber', candidate.registration_number || '-');
        setText('candidateSemester', candidate.semester ? `Semester ${candidate.semester}` : 'Semester -');
        setText('candidateEmail', candidate.email || '-');
        setText('candidatePhone', candidate.phone || '-');
        setText('candidateStudentNumber', candidate.student_number || '-');
        setText('candidateFaculty', candidate.faculty || '-');
        setText('candidateProgram', candidate.study_program || '-');
        setText('candidatePeriod', candidate.period?.election_year || '-');
        setText('candidateVision', candidate.vision || '-');
        setText('candidateMission', candidate.mission || '-');
        setText('validatedBy', candidate.validator?.name || '-');
        setText('validatedAt', formatDateTime(candidate.validated_at));

        setPhoto();
        setStatus();
        renderDocuments();
        renderRejection();
        renderActions();

        setText('acceptCandidateName', candidate.full_name || '-');
        setText('acceptCandidateMeta', `${candidate.student_number || '-'} · ${candidate.study_program || '-'}`);
        setText('rejectCandidateName', candidate.full_name || '-');
        setText('rejectCandidateMeta', `${candidate.student_number || '-'} · ${candidate.study_program || '-'}`);
    }

    function setPhoto() {
        const image = document.getElementById('candidatePhoto');
        const avatar = document.getElementById('candidateInitialAvatar');
        const badge = document.getElementById('photoStatusBadge');

        if (candidate.photo_file) {
            image.src = storageUrl(candidate.photo_file);
            image.classList.remove('hidden');
            avatar.classList.add('hidden');
            badge?.classList.remove('hidden');
            return;
        }

        image.classList.add('hidden');
        avatar.classList.remove('hidden');
        avatar.textContent = getInitials(candidate.full_name || 'P');
        badge?.classList.add('hidden');
    }

    function setStatus() {
        const target = document.getElementById('headerStatusBadge');

        if (target) {
            target.innerHTML = statusBadge(candidate.status);
        }
    }

    function renderDocuments() {
        const target = document.getElementById('documentList');

        if (!target) {
            return;
        }

        const documents = [];

        if (candidate.cv_file) {
            documents.push({
                title: 'Curriculum Vitae',
                subtitle: 'Dokumen CV pendaftar',
                url: storageUrl(candidate.cv_file),
            });
        }

        if (candidate.photo_file) {
            documents.push({
                title: 'Foto Pendaftar',
                subtitle: 'Foto profil pendaftar',
                url: storageUrl(candidate.photo_file),
            });
        }

        if (!documents.length) {
            target.innerHTML = `
                <div class="rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm font-semibold text-amber-800">
                    Belum ada dokumen yang diunggah.
                </div>
            `;
            return;
        }

        target.innerHTML = documents.map(function (documentItem) {
            return `
                <a
                    href="${documentItem.url}"
                    target="_blank"
                    rel="noopener"
                    class="flex items-center justify-between gap-4 rounded-xl border border-slate-200 p-4 hover:border-blue-900 hover:bg-blue-50"
                >
                    <div>
                        <p class="text-sm font-extrabold text-slate-900">
                            ${escapeHtml(documentItem.title)}
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            ${escapeHtml(documentItem.subtitle)}
                        </p>
                    </div>

                    <svg class="h-5 w-5 shrink-0 text-blue-900" viewBox="0 0 24 24" fill="none">
                        <path d="M14 3H6V21H18V7L14 3Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                        <path d="M14 3V7H18" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                    </svg>
                </a>
            `;
        }).join('');
    }

    function renderRejection() {
        const box = document.getElementById('rejectionBox');

        if (!box) {
            return;
        }

        if (candidate.status === 'invalid' && candidate.rejection_reason) {
            setText('rejectionReason', candidate.rejection_reason);
            box.classList.remove('hidden');
            return;
        }

        box.classList.add('hidden');
    }

    function renderActions() {
        const pendingActions = document.getElementById('pendingActions');
        const actionText = document.getElementById('actionText');

        if (!pendingActions || !actionText) {
            return;
        }

        if (candidate.status === 'pending') {
            pendingActions.classList.remove('hidden');
            actionText.textContent = 'Tinjau data pendaftar sebelum mengambil keputusan.';
            return;
        }

        pendingActions.classList.add('hidden');

        if (candidate.status === 'valid') {
            actionText.textContent = 'Pendaftar ini sudah diterima.';
            return;
        }

        if (candidate.status === 'invalid') {
            actionText.textContent = 'Pendaftar ini sudah ditolak.';
            return;
        }

        actionText.textContent = 'Status pendaftar sudah diproses.';
    }

    function openAcceptModal() {
        document.getElementById('acceptModal')?.classList.remove('hidden');
        document.getElementById('acceptModal')?.classList.add('flex');
    }

    function closeAcceptModal() {
        document.getElementById('acceptModal')?.classList.add('hidden');
        document.getElementById('acceptModal')?.classList.remove('flex');
    }

    function openRejectModal() {
        const input = document.getElementById('rejectReasonInput');

        if (input) {
            input.value = '';
        }

        document.getElementById('rejectReasonError')?.classList.add('hidden');
        document.getElementById('rejectModal')?.classList.remove('hidden');
        document.getElementById('rejectModal')?.classList.add('flex');
    }

    function closeRejectModal() {
        document.getElementById('rejectModal')?.classList.add('hidden');
        document.getElementById('rejectModal')?.classList.remove('flex');
    }

    async function acceptCandidate() {
        const button = document.getElementById('acceptButton');

        setButtonLoading(button, 'Memproses...');

        try {
            await DutaAdmin.request(`/candidates/${candidateId}/validate`, {
                method: 'PATCH',
            });

            closeAcceptModal();
            showAlert('success', 'Pendaftar berhasil diterima.');
            await loadCandidate();
        } catch (error) {
            console.error('Gagal menerima pendaftar:', error);
            showAlert('error', getErrorMessage(error, 'Pendaftar gagal diterima.'));
        } finally {
            resetButton(button, 'Konfirmasi Terima');
        }
    }

    async function rejectCandidate() {
        const input = document.getElementById('rejectReasonInput');
        const error = document.getElementById('rejectReasonError');
        const button = document.getElementById('rejectButton');
        const reason = input?.value.trim() || '';

        if (!reason) {
            error?.classList.remove('hidden');
            input?.focus();
            return;
        }

        error?.classList.add('hidden');
        setButtonLoading(button, 'Memproses...');

        try {
            await DutaAdmin.request(`/candidates/${candidateId}/reject`, {
                method: 'PATCH',
                body: JSON.stringify({
                    rejection_reason: reason,
                }),
            });

            closeRejectModal();
            showAlert('success', 'Pendaftar berhasil ditolak.');
            await loadCandidate();
        } catch (error) {
            console.error('Gagal menolak pendaftar:', error);
            showAlert('error', getErrorMessage(error, 'Pendaftar gagal ditolak.'));
        } finally {
            resetButton(button, 'Konfirmasi Tolak');
        }
    }

    function showLoading() {
        document.getElementById('loadingState')?.classList.remove('hidden');
        document.getElementById('detailState')?.classList.add('hidden');
    }

    function showErrorState() {
        const loadingState = document.getElementById('loadingState');

        if (!loadingState) {
            return;
        }

        loadingState.innerHTML = `
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100 text-red-600">
                !
            </div>

            <p class="mt-4 text-sm font-semibold text-red-600">
                Detail pendaftar gagal dimuat.
            </p>

            <a
                href="{{ route('admin.candidates.index') }}"
                class="mt-5 inline-flex rounded-lg border border-slate-300 px-4 py-2 text-sm font-bold text-slate-700 hover:bg-slate-50"
            >
                Kembali ke Data Pendaftar
            </a>
        `;
    }

    function statusBadge(status) {
        const badges = {
            pending: {
                label: 'Menunggu Verifikasi',
                className: 'bg-amber-100 text-amber-700 border-amber-200',
            },
            valid: {
                label: 'Diterima',
                className: 'bg-green-100 text-green-700 border-green-200',
            },
            invalid: {
                label: 'Ditolak',
                className: 'bg-red-100 text-red-700 border-red-200',
            },
        };

        const badge = badges[status] || {
            label: status || '-',
            className: 'bg-slate-100 text-slate-700 border-slate-200',
        };

        return `
            <span class="inline-flex rounded-full border px-4 py-2 text-sm font-extrabold ${badge.className}">
                ${badge.label}
            </span>
        `;
    }

    function storageUrl(path) {
        if (!path) {
            return '';
        }

        const cleanPath = String(path).replace(/^\/+/, '');

        if (cleanPath.startsWith('http')) {
            return cleanPath;
        }

        if (cleanPath.startsWith('storage/')) {
            return `{{ asset('') }}${cleanPath}`;
        }

        return `{{ asset('storage') }}/${cleanPath}`;
    }

    function getInitials(name) {
        return String(name || 'P')
            .trim()
            .split(/\s+/)
            .slice(0, 2)
            .map(function (word) {
                return word.charAt(0).toUpperCase();
            })
            .join('');
    }

    function formatDateTime(value) {
        if (!value) {
            return '-';
        }

        const date = new Date(value);

        if (Number.isNaN(date.getTime())) {
            return value;
        }

        return date.toLocaleString('id-ID', {
            dateStyle: 'medium',
            timeStyle: 'short',
        });
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
            element.textContent = value ?? '-';
        }
    }

    function setButtonLoading(button, text) {
        if (!button) {
            return;
        }

        button.disabled = true;
        button.textContent = text;
        button.classList.add('cursor-not-allowed', 'opacity-70');
    }

    function resetButton(button, text) {
        if (!button) {
            return;
        }

        button.disabled = false;
        button.textContent = text;
        button.classList.remove('cursor-not-allowed', 'opacity-70');
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