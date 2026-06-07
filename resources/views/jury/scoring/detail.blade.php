@extends('layouts.jury')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <section class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <div class="mb-3 flex items-center gap-2 text-sm font-bold text-slate-500">
                <a id="breadcrumbBackLink" href="{{ route('jury.scoring.index') }}" class="hover:text-blue-900">
                    Penilaian Peserta
                </a>

                <span>/</span>

                <span class="text-blue-900">
                    Detail Peserta
                </span>
            </div>

            <h1 class="text-4xl font-extrabold tracking-tight text-blue-900">
                Detail Calon Peserta
            </h1>

            <p id="pageSubtitle" class="mt-2 text-sm font-semibold leading-6 text-slate-500">
                Memuat informasi calon peserta...
            </p>
        </div>

        <div class="flex flex-col gap-3 sm:flex-row">
            <a
                id="backLink"
                href="{{ route('jury.scoring.index') }}"
                class="inline-flex h-12 items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-5 text-sm font-extrabold text-slate-700 transition hover:bg-slate-50"
            >
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                    <path d="M19 12H5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M12 19L5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Kembali
            </a>

            <a
                id="startScoringLink"
                href="#"
                class="inline-flex h-12 items-center justify-center gap-2 rounded-xl bg-blue-900 px-5 text-sm font-extrabold text-white shadow-sm transition hover:bg-blue-800"
            >
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                    <path d="M8 5L19 12L8 19V5Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                </svg>
                Mulai Penilaian
            </a>
        </div>
    </section>

    <div id="pageAlert" class="hidden rounded-xl border px-4 py-3 text-sm font-semibold"></div>

    {{-- Loading --}}
    <section id="loadingState" class="rounded-2xl border border-slate-200 bg-white p-8 text-center shadow-sm">
        <div class="mx-auto h-10 w-10 animate-spin rounded-full border-4 border-slate-200 border-t-blue-900"></div>

        <p class="mt-4 text-sm font-semibold text-slate-500">
            Memuat detail calon peserta...
        </p>
    </section>

    {{-- Content --}}
    <section id="detailContent" class="hidden space-y-6">
        {{-- Summary --}}
        <section class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-700">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none">
                            <path d="M7 4H17V20H7V4Z" stroke="currentColor" stroke-width="2"/>
                            <path d="M9 8H15M9 12H14M9 16H12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>

                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-wide text-slate-400">
                            Status Penilaian
                        </p>

                        <div id="scoringStatus" class="mt-2"></div>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-900">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none">
                            <path d="M7 3V6M17 3V6M4 9H20M5 5H19C19.552 5 20 5.448 20 6V20C20 20.552 19.552 21 19 21H5C4.448 21 4 20.552 4 20V6C4 5.448 4.448 5 5 5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>

                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-wide text-slate-400">
                            Jadwal Wawancara
                        </p>

                        <p id="scheduledAt" class="mt-2 text-base font-extrabold text-slate-900">
                            -
                        </p>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-red-50 text-red-600">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none">
                            <path d="M12 21C12 21 19 15.8 19 9.5C19 5.9 15.9 3 12 3C8.1 3 5 5.9 5 9.5C5 15.8 12 21 12 21Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                            <circle cx="12" cy="9.5" r="2.5" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </div>

                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-wide text-slate-400">
                            Lokasi
                        </p>

                        <p id="locationText" class="mt-2 text-base font-extrabold text-slate-900">
                            -
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            {{-- Left --}}
            <aside class="space-y-6 xl:col-span-1">
                {{-- Profile --}}
                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex flex-col items-center text-center">
                        <div class="relative">
                            <img
                                id="candidatePhoto"
                                src=""
                                alt="Foto calon peserta"
                                class="hidden h-40 w-40 rounded-2xl border border-slate-200 object-cover"
                            >

                            <div
                                id="candidateInitialAvatar"
                                class="flex h-40 w-40 items-center justify-center rounded-2xl border border-slate-200 bg-blue-900 text-4xl font-extrabold text-white"
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
                </section>

                {{-- Contact --}}
                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-sm font-extrabold uppercase tracking-wide text-slate-500">
                        Kontak
                    </h3>

                    <div class="mt-4 space-y-4 text-sm">
                        <div>
                            <p class="font-bold text-slate-500">
                                Email
                            </p>

                            <p id="candidateEmail" class="mt-1 break-all font-semibold text-slate-900">
                                -
                            </p>
                        </div>

                        <div>
                            <p class="font-bold text-slate-500">
                                Nomor WhatsApp
                            </p>

                            <p id="candidatePhone" class="mt-1 font-semibold text-slate-900">
                                -
                            </p>
                        </div>
                    </div>
                </section>

                {{-- Note --}}
                <section class="rounded-2xl border border-blue-200 bg-blue-50 p-5">
                    <div class="flex gap-4">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-100 text-blue-900">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                                <path d="M12 17V11" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                <path d="M12 8H12.01" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                                <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/>
                            </svg>
                        </div>

                        <div>
                            <h3 class="text-sm font-extrabold text-blue-900">
                                Catatan untuk Juri
                            </h3>

                            <p class="mt-2 text-sm font-semibold leading-6 text-slate-600">
                                Gunakan data pendaftaran, dokumen, dan hasil wawancara sebagai bahan pertimbangan sebelum memberi nilai.
                            </p>
                        </div>
                    </div>
                </section>
            </aside>

            {{-- Right --}}
            <section class="space-y-6 xl:col-span-2">
                {{-- Academic --}}
                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
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

                        <div>
                            <p class="text-xs font-extrabold uppercase tracking-wide text-slate-500">
                                Status Pendaftaran
                            </p>

                            <div id="candidateStatus" class="mt-2"></div>
                        </div>

                        <div>
                            <p class="text-xs font-extrabold uppercase tracking-wide text-slate-500">
                                Status Wawancara
                            </p>

                            <div id="interviewStatus" class="mt-2"></div>
                        </div>
                    </div>
                </section>

                {{-- Vision Mission --}}
                <section class="grid grid-cols-1 gap-6 xl:grid-cols-2">
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
                </section>

                {{-- Documents --}}
                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-start justify-between gap-4 border-b border-slate-200 pb-4">
                        <div>
                            <h2 class="text-xl font-extrabold text-slate-900">
                                Dokumen Pendukung
                            </h2>

                            <p class="mt-1 text-sm text-slate-500">
                                Dokumen yang diunggah peserta saat pendaftaran.
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
                </section>

                {{-- Criteria --}}
                <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-200 px-6 py-4">
                        <h2 class="text-xl font-extrabold text-slate-900">
                            Kriteria yang Dinilai
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Kriteria penilaian yang ditugaskan kepada kamu.
                        </p>
                    </div>

                    <div id="criteriaList" class="p-6">
                        <p class="text-sm text-slate-500">
                            Memuat kriteria...
                        </p>
                    </div>
                </section>
            </section>
        </section>
    </section>
</div>
@endsection

@push('scripts')
<script>
    const candidateId = @json($candidateId);
    let detailData = null;

    document.addEventListener('DOMContentLoaded', function () {
        const periodId = getPeriodId();

        const backUrl = `/jury/scoring?period_id=${periodId}`;
        const formUrl = `/jury/scoring/${candidateId}/form?period_id=${periodId}`;

        setHref('backLink', backUrl);
        setHref('breadcrumbBackLink', backUrl);
        setHref('startScoringLink', formUrl);

        loadCandidateDetail();
    });

    async function loadCandidateDetail() {
        showLoading();

        try {
            const periodId = getPeriodId();
            const result = await DutaJury.request(`/jury/scoring-candidates/${candidateId}?period_id=${periodId}`);

            detailData = result?.data || {};

            renderDetail();

            document.getElementById('loadingState')?.classList.add('hidden');
            document.getElementById('detailContent')?.classList.remove('hidden');
        } catch (error) {
            console.error('Gagal memuat detail peserta:', error);
            renderError(getErrorMessage(error, 'Detail calon peserta gagal dimuat.'));
        }
    }

    function renderDetail() {
        const candidate = getCandidateData();
        const criteria = getCriteriaData();
        const summary = getSummaryData();

        const filledCriteria = criteria.filter(item => item.score !== null && item.score !== undefined).length;
        const isComplete = Boolean(summary.is_complete) || (criteria.length > 0 && filledCriteria >= criteria.length);

        setText('pageSubtitle', `${candidate.registration_number || '-'} · ${candidate.full_name || '-'}`);

        setText('candidateName', candidate.full_name || '-');
        setText('candidateStudyProgram', candidate.study_program || '-');
        setText('candidateRegistrationNumber', candidate.registration_number || '-');
        setText('candidateSemester', candidate.semester ? `Semester ${candidate.semester}` : 'Semester -');
        setText('candidateEmail', candidate.email || '-');
        setText('candidatePhone', candidate.phone || candidate.whatsapp_number || '-');
        setText('candidateStudentNumber', candidate.student_number || '-');
        setText('candidateFaculty', candidate.faculty || candidate.department || '-');
        setText('candidateProgram', candidate.study_program || '-');
        setText('candidatePeriod', candidate.period?.election_year || candidate.election_year || candidate.period_year || '-');
        setText('candidateVision', candidate.vision || '-');
        setText('candidateMission', candidate.mission || '-');
        setText('scheduledAt', formatDateTime(candidate.scheduled_at || candidate.interview?.scheduled_at));
        setText('locationText', candidate.location || candidate.interview?.location || '-');

        setHtml('candidateStatus', statusBadge(candidate.status));
        setHtml('interviewStatus', interviewStatusBadge(candidate.interview_status || candidate.interview?.status));
        setHtml('scoringStatus', isComplete
            ? renderSoftBadge('Sudah Dinilai', 'success')
            : renderSoftBadge('Belum Dinilai', 'warning')
        );

        renderPhoto(candidate);
        renderDocuments(candidate);
        renderCriteria(criteria);
        renderScoringButton(isComplete);
    }

    function getCandidateData() {
        if (detailData?.candidate) {
            return detailData.candidate;
        }

        if (detailData?.candidate_data) {
            return detailData.candidate_data;
        }

        return detailData || {};
    }

    function getCriteriaData() {
        if (Array.isArray(detailData?.criteria)) {
            return detailData.criteria;
        }

        if (Array.isArray(detailData?.scores)) {
            return detailData.scores;
        }

        if (Array.isArray(detailData?.data?.criteria)) {
            return detailData.data.criteria;
        }

        return [];
    }

    function getSummaryData() {
        return detailData?.summary || {};
    }

    function renderPhoto(candidate) {
        const image = document.getElementById('candidatePhoto');
        const avatar = document.getElementById('candidateInitialAvatar');
        const badge = document.getElementById('photoStatusBadge');

        const photoFile = firstFilled([
            candidate.photo_file,
            candidate.photo_path,
            candidate.photo_url,
            candidate.profile_photo,
            candidate.profile_photo_path,
            candidate.photo,
        ]);

        if (photoFile) {
            image.src = storageUrl(photoFile);
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

    function renderDocuments(candidate) {
        const target = document.getElementById('documentList');

        if (!target) {
            return;
        }

        const documents = [];

        addDocument(documents, 'Foto Pendaftar', 'Foto profil yang diunggah peserta.', firstFilled([
            candidate.photo_file,
            candidate.photo_path,
            candidate.photo_url,
            candidate.profile_photo,
            candidate.profile_photo_path,
            candidate.photo,
        ]));

        addDocument(documents, 'Curriculum Vitae', 'CV atau daftar riwayat hidup peserta.', firstFilled([
            candidate.cv_file,
            candidate.cv_path,
            candidate.cv_url,
            candidate.curriculum_vitae,
            candidate.curriculum_vitae_file,
        ]));

        addDocument(documents, 'Portofolio', 'Dokumen portofolio peserta.', firstFilled([
            candidate.portfolio_file,
            candidate.portfolio_path,
            candidate.portfolio_url,
            candidate.portfolio,
        ]));

        addDocument(documents, 'Sertifikat / Prestasi', 'Dokumen prestasi atau sertifikat peserta.', firstFilled([
            candidate.certificate_file,
            candidate.certificate_path,
            candidate.certificate_url,
            candidate.achievement_file,
            candidate.achievement_document,
            candidate.achievement_url,
        ]));

        addDocument(documents, 'Kartu Mahasiswa', 'Dokumen identitas mahasiswa.', firstFilled([
            candidate.student_card_file,
            candidate.student_card_path,
            candidate.student_card_url,
            candidate.ktm_file,
            candidate.ktm_path,
        ]));

        addDocument(documents, 'Dokumen Pendukung', 'Berkas tambahan peserta.', firstFilled([
            candidate.supporting_file,
            candidate.supporting_path,
            candidate.supporting_document,
            candidate.document_file,
            candidate.document_path,
        ]));

        if (!documents.length) {
            target.innerHTML = `
                <div class="rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm font-semibold text-amber-800 md:col-span-2">
                    Belum ada dokumen yang bisa ditampilkan.
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
                    class="flex items-center justify-between gap-4 rounded-xl border border-slate-200 p-4 transition hover:border-blue-900 hover:bg-blue-50"
                >
                    <div class="flex min-w-0 items-center gap-3">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-900">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                                <path d="M14 3H6V21H18V7L14 3Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                                <path d="M14 3V7H18" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                                <path d="M8 13H16M8 17H13" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>

                        <div class="min-w-0">
                            <p class="truncate text-sm font-extrabold text-slate-900">
                                ${escapeHtml(documentItem.title)}
                            </p>

                            <p class="mt-1 truncate text-xs font-semibold text-slate-500">
                                ${escapeHtml(documentItem.subtitle)}
                            </p>
                        </div>
                    </div>

                    <span class="shrink-0 text-xs font-extrabold text-blue-900">
                        Lihat
                    </span>
                </a>
            `;
        }).join('');
    }

    function renderCriteria(criteria) {
        const target = document.getElementById('criteriaList');

        if (!target) {
            return;
        }

        if (!criteria.length) {
            target.innerHTML = `
                <div class="rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm font-semibold text-amber-700">
                    Belum ada kriteria yang ditugaskan.
                </div>
            `;
            return;
        }

        target.innerHTML = `
            <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                ${criteria.map(item => {
                    const filled = item.score !== null && item.score !== undefined;
                    const scoreText = filled ? `Nilai: ${item.score}` : 'Belum diisi';

                    return `
                        <div class="rounded-xl border border-slate-200 p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="text-xs font-extrabold text-blue-900">
                                        ${escapeHtml(item.code || '-')}
                                    </p>

                                    <p class="mt-1 text-sm font-extrabold leading-5 text-slate-900">
                                        ${escapeHtml(item.name || item.criterion_name || '-')}
                                    </p>

                                    <p class="mt-2 text-xs font-semibold text-slate-500">
                                        Rentang nilai: ${escapeHtml(item.min_score ?? 0)} sampai ${escapeHtml(item.max_score ?? 100)}
                                    </p>

                                    <p class="mt-1 text-xs font-bold text-slate-700">
                                        ${escapeHtml(scoreText)}
                                    </p>
                                </div>

                                ${filled
                                    ? renderSoftBadge('Terisi', 'success')
                                    : renderSoftBadge('Kosong', 'warning')
                                }
                            </div>
                        </div>
                    `;
                }).join('')}
            </div>
        `;
    }

    function renderScoringButton(isComplete) {
        const startLink = document.getElementById('startScoringLink');

        if (!startLink) {
            return;
        }

        startLink.innerHTML = isComplete
            ? `
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                    <path d="M4 20H20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M14 4L20 10L9 21H3V15L14 4Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                </svg>
                Edit Penilaian
            `
            : `
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                    <path d="M8 5L19 12L8 19V5Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                </svg>
                Mulai Penilaian
            `;
    }

    function addDocument(documents, title, subtitle, path) {
        if (!path) {
            return;
        }

        documents.push({
            title,
            subtitle,
            url: storageUrl(path),
        });
    }

    function statusBadge(status) {
        const badges = {
            pending: {
                label: 'Menunggu Verifikasi',
                className: 'bg-amber-100 text-amber-700',
            },
            valid: {
                label: 'Lolos Administrasi',
                className: 'bg-green-100 text-green-700',
            },
            invalid: {
                label: 'Ditolak',
                className: 'bg-red-100 text-red-700',
            },
            interview_scheduled: {
                label: 'Terjadwal Wawancara',
                className: 'bg-blue-100 text-blue-700',
            },
            interviewed: {
                label: 'Sudah Wawancara',
                className: 'bg-blue-100 text-blue-700',
            },
            scored: {
                label: 'Sudah Dinilai',
                className: 'bg-green-100 text-green-700',
            },
        };

        const badge = badges[status] || {
            label: status || '-',
            className: 'bg-slate-100 text-slate-700',
        };

        return `
            <span class="inline-flex rounded-full px-3 py-1 text-xs font-extrabold ${badge.className}">
                ${escapeHtml(badge.label)}
            </span>
        `;
    }

    function interviewStatusBadge(status) {
        const badges = {
            scheduled: {
                label: 'Terjadwal',
                className: 'bg-blue-100 text-blue-700',
            },
            completed: {
                label: 'Selesai',
                className: 'bg-green-100 text-green-700',
            },
            absent: {
                label: 'Tidak Hadir',
                className: 'bg-amber-100 text-amber-700',
            },
            cancelled: {
                label: 'Dibatalkan',
                className: 'bg-red-100 text-red-700',
            },
        };

        const badge = badges[status] || {
            label: status || '-',
            className: 'bg-slate-100 text-slate-700',
        };

        return `
            <span class="inline-flex rounded-full px-3 py-1 text-xs font-extrabold ${badge.className}">
                ${escapeHtml(badge.label)}
            </span>
        `;
    }

    function renderSoftBadge(label, variant = 'default') {
        const classes = {
            success: 'bg-green-100 text-green-700',
            warning: 'bg-amber-100 text-amber-700',
            danger: 'bg-red-100 text-red-700',
            primary: 'bg-blue-100 text-blue-700',
            default: 'bg-slate-100 text-slate-700',
        };

        return `
            <span class="inline-flex whitespace-nowrap rounded-full px-3 py-1 text-xs font-extrabold ${classes[variant] || classes.default}">
                ${escapeHtml(label)}
            </span>
        `;
    }

    function showLoading() {
        document.getElementById('loadingState')?.classList.remove('hidden');
        document.getElementById('detailContent')?.classList.add('hidden');
    }

    function renderError(message) {
        const loadingState = document.getElementById('loadingState');

        if (!loadingState) {
            return;
        }

        loadingState.innerHTML = `
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100 text-red-600">
                !
            </div>

            <p class="mt-4 text-sm font-semibold text-red-600">
                ${escapeHtml(message)}
            </p>

            <button
                type="button"
                onclick="loadCandidateDetail()"
                class="mt-5 inline-flex h-11 items-center justify-center rounded-lg bg-blue-900 px-4 text-sm font-bold text-white hover:bg-blue-800"
            >
                Muat Ulang
            </button>
        `;

        loadingState.className = 'rounded-2xl border border-red-200 bg-white p-8 text-center shadow-sm';
    }

    function firstFilled(values) {
        return values.find(value => value !== null && value !== undefined && String(value).trim() !== '') || '';
    }

    function storageUrl(path) {
        let value = String(path || '').trim();

        if (!value) {
            return '';
        }

        if (value.startsWith('http')) {
            return value;
        }

        value = value.replace(/^\/+/, '');
        value = value.replace(/^public\//, '');

        if (value.startsWith('storage/')) {
            return `/${value}`;
        }

        return `/storage/${value}`;
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
            day: '2-digit',
            month: 'short',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
        });
    }

    function getPeriodId() {
        const params = new URLSearchParams(window.location.search);

        return params.get('period_id') || '1';
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

    function setHtml(id, value) {
        const element = document.getElementById(id);

        if (element) {
            element.innerHTML = value;
        }
    }

    function setHref(id, value) {
        const element = document.getElementById(id);

        if (element) {
            element.href = value;
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