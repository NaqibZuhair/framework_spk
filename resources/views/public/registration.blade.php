<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Formulir Pendaftaran Duta PNJ</title>
    @include('partials.app-icon')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 text-slate-900">
    @include('partials.public-navbar', ['active' => 'registration'])

    {{-- Main --}}
    <main class="mx-auto max-w-7xl px-6 py-10 lg:px-10">
        <section class="mb-10">
            <p class="inline-flex rounded-full bg-yellow-300 px-4 py-2 text-sm font-bold text-yellow-950">
                Pendaftaran Dibuka
            </p>

            <h1 class="mt-5 max-w-3xl text-4xl font-extrabold leading-tight tracking-tight text-blue-900">
                Formulir Pendaftaran Duta PNJ
            </h1>

            <p class="mt-4 max-w-3xl text-base leading-7 text-slate-600">
                Lengkapi data diri Anda dengan teliti untuk mengikuti seleksi Pemilihan Duta
                Politeknik Negeri Jakarta. Pastikan semua data dan berkas pendukung sudah sesuai
                dengan ketentuan.
            </p>
        </section>

        <div id="formAlert" class="mb-6 hidden rounded-xl border px-5 py-4 text-sm font-semibold"></div>

        <form
            id="registrationForm"
            method="POST"
            action="{{ url('/api/candidates/register') }}"
            enctype="multipart/form-data"
            class="space-y-6"
            novalidate
        >
            @csrf

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                {{-- Informasi Pribadi --}}
                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="mb-6">
                        <h2 class="text-2xl font-extrabold tracking-tight text-slate-900">
                            Informasi Pribadi
                        </h2>

                        <p class="mt-2 text-sm text-slate-500">
                            Isi identitas akademik dan kontak yang aktif.
                        </p>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label for="full_name" class="mb-2 block text-sm font-bold text-slate-800">
                                Nama Lengkap
                            </label>

                            <input
                                id="full_name"
                                name="full_name"
                                type="text"
                                placeholder="Contoh: Budi Santoso"
                                class="h-12 w-full rounded-lg border border-slate-300 bg-white px-4 text-sm outline-none focus:border-blue-900 focus:ring-2 focus:ring-blue-100"
                                required
                            >
                        </div>

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label for="student_number" class="mb-2 block text-sm font-bold text-slate-800">
                                    NIM
                                </label>

                                <input
                                    id="student_number"
                                    name="student_number"
                                    type="text"
                                    placeholder="Contoh: 2103421xxx"
                                    class="h-12 w-full rounded-lg border border-slate-300 bg-white px-4 text-sm outline-none focus:border-blue-900 focus:ring-2 focus:ring-blue-100"
                                    required
                                >
                            </div>

                            <div>
                                <label for="semester" class="mb-2 block text-sm font-bold text-slate-800">
                                    Semester
                                </label>

                                <select
                                    id="semester"
                                    name="semester"
                                    class="h-12 w-full rounded-lg border border-slate-300 bg-white px-4 text-sm outline-none focus:border-blue-900 focus:ring-2 focus:ring-blue-100"
                                >
                                    <option value="">Pilih Semester</option>
                                    @for ($semester = 1; $semester <= 14; $semester++)
                                        <option value="{{ $semester }}">Semester {{ $semester }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="faculty" class="mb-2 block text-sm font-bold text-slate-800">
                                Jurusan
                            </label>

                            <input
                                id="faculty"
                                name="faculty"
                                type="text"
                                placeholder="Contoh: Teknik Informatika dan Komputer"
                                class="h-12 w-full rounded-lg border border-slate-300 bg-white px-4 text-sm outline-none focus:border-blue-900 focus:ring-2 focus:ring-blue-100"
                            >
                        </div>

                        <div>
                            <label for="study_program" class="mb-2 block text-sm font-bold text-slate-800">
                                Program Studi
                            </label>

                            <input
                                id="study_program"
                                name="study_program"
                                type="text"
                                placeholder="Contoh: Teknik Informatika"
                                class="h-12 w-full rounded-lg border border-slate-300 bg-white px-4 text-sm outline-none focus:border-blue-900 focus:ring-2 focus:ring-blue-100"
                            >
                        </div>

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label for="email" class="mb-2 block text-sm font-bold text-slate-800">
                                    Email Institusi
                                </label>

                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    placeholder="nama@mhs.pnj.ac.id"
                                    class="h-12 w-full rounded-lg border border-slate-300 bg-white px-4 text-sm outline-none focus:border-blue-900 focus:ring-2 focus:ring-blue-100"
                                    required
                                >
                            </div>

                            <div>
                                <label for="phone" class="mb-2 block text-sm font-bold text-slate-800">
                                    Nomor HP / WhatsApp
                                </label>

                                <input
                                    id="phone"
                                    name="phone"
                                    type="text"
                                    placeholder="08xxxxxxxxxx"
                                    class="h-12 w-full rounded-lg border border-slate-300 bg-white px-4 text-sm outline-none focus:border-blue-900 focus:ring-2 focus:ring-blue-100"
                                >
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Visi Misi --}}
                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="mb-6">
                        <h2 class="text-2xl font-extrabold tracking-tight text-slate-900">
                            Visi & Misi
                        </h2>

                        <p class="mt-2 text-sm text-slate-500">
                            Jelaskan tujuan dan kontribusi yang ingin Anda bawa sebagai Duta PNJ.
                        </p>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label for="vision" class="mb-2 block text-sm font-bold text-slate-800">
                                Visi sebagai Duta PNJ
                            </label>

                            <textarea
                                id="vision"
                                name="vision"
                                rows="6"
                                placeholder="Tuliskan visi Anda..."
                                class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm leading-6 outline-none focus:border-blue-900 focus:ring-2 focus:ring-blue-100"
                            ></textarea>
                        </div>

                        <div>
                            <label for="mission" class="mb-2 block text-sm font-bold text-slate-800">
                                Misi sebagai Duta PNJ
                            </label>

                            <textarea
                                id="mission"
                                name="mission"
                                rows="6"
                                placeholder="Tuliskan misi Anda..."
                                class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm leading-6 outline-none focus:border-blue-900 focus:ring-2 focus:ring-blue-100"
                            ></textarea>
                        </div>
                    </div>
                </section>
            </div>

            {{-- Upload --}}
            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-6">
                    <h2 class="text-2xl font-extrabold tracking-tight text-slate-900">
                        Unggah Berkas
                    </h2>

                    <p class="mt-2 text-sm text-slate-500">
                        Unggah foto formal dan CV sesuai format yang diminta.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <div>
                        <label for="photo_file" class="mb-2 block text-sm font-bold text-slate-800">
                            Foto Formal
                        </label>

                        <label
                            for="photo_file"
                            class="flex min-h-40 cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 px-5 py-6 text-center hover:border-blue-900 hover:bg-blue-50"
                        >
                            <svg class="h-9 w-9 text-blue-900" viewBox="0 0 24 24" fill="none">
                                <path d="M4 17.5V19C4 20.1 4.9 21 6 21H18C19.1 21 20 20.1 20 19V17.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                <path d="M12 16V3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                <path d="M7 8L12 3L17 8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>

                            <p id="photoFileName" class="mt-3 text-sm font-bold text-slate-800">
                                Klik untuk memilih foto
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                JPG, JPEG, PNG, WEBP. Maksimal 2 MB.
                            </p>
                        </label>

                        <input
                            id="photo_file"
                            name="photo_file"
                            type="file"
                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                            class="hidden"
                        >
                    </div>

                    <div>
                        <label for="cv_file" class="mb-2 block text-sm font-bold text-slate-800">
                            Curriculum Vitae
                        </label>

                        <label
                            for="cv_file"
                            class="flex min-h-40 cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 px-5 py-6 text-center hover:border-blue-900 hover:bg-blue-50"
                        >
                            <svg class="h-9 w-9 text-blue-900" viewBox="0 0 24 24" fill="none">
                                <path d="M14 3H6V21H18V7L14 3Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                                <path d="M14 3V7H18" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                                <path d="M8 13H16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                <path d="M8 17H13" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>

                            <p id="cvFileName" class="mt-3 text-sm font-bold text-slate-800">
                                Klik untuk memilih CV
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                PDF, DOC, DOCX. Maksimal 5 MB.
                            </p>
                        </label>

                        <input
                            id="cv_file"
                            name="cv_file"
                            type="file"
                            accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                            class="hidden"
                        >
                    </div>
                </div>
            </section>

            {{-- Action --}}
            <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:items-center sm:justify-between">
                <a
                    href="{{ url('/') }}"
                    class="inline-flex h-12 items-center justify-center rounded-lg border border-slate-300 px-6 text-sm font-bold text-slate-700 hover:bg-slate-100"
                >
                    Kembali
                </a>

                <button
                    id="submitButton"
                    type="submit"
                    class="inline-flex h-12 items-center justify-center rounded-lg bg-blue-900 px-8 text-sm font-extrabold text-white hover:bg-blue-800 disabled:cursor-not-allowed disabled:opacity-70"
                >
                    Kirim Pendaftaran
                </button>
            </div>
        </form>
    </main>

    @include('partials.public-footer')

    <script>
        const registrationForm = document.getElementById('registrationForm');
        const submitButton = document.getElementById('submitButton');
        const formAlert = document.getElementById('formAlert');

        document.getElementById('photo_file')?.addEventListener('change', function () {
            setFileName('photoFileName', this.files[0], 'Klik untuk memilih foto');
        });

        document.getElementById('cv_file')?.addEventListener('change', function () {
            setFileName('cvFileName', this.files[0], 'Klik untuk memilih CV');
        });

        registrationForm?.addEventListener('submit', async function (event) {
            event.preventDefault();

            hideAlert();

            if (!registrationForm.checkValidity()) {
                registrationForm.reportValidity();
                return;
            }

            const photoFile = document.getElementById('photo_file')?.files[0] || null;
            const cvFile = document.getElementById('cv_file')?.files[0] || null;

            if (photoFile && photoFile.size > 2 * 1024 * 1024) {
                showAlert('error', 'Ukuran foto maksimal 2 MB.');
                return;
            }

            if (cvFile && cvFile.size > 5 * 1024 * 1024) {
                showAlert('error', 'Ukuran CV maksimal 5 MB.');
                return;
            }

            const formData = new FormData(registrationForm);

            const csrfToken = document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute('content') || '';

            setLoading(true);

            try {
                const response = await fetch(registrationForm.action, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: formData,
                });

                const result = await response.json().catch(() => null);

                if (response.status === 419) {
                    throw {
                        message: 'Sesi formulir tidak valid. Silakan refresh halaman lalu kirim ulang pendaftaran.',
                    };
                }

                if (!response.ok) {
                    throw result || {
                        message: 'Pendaftaran gagal dikirim.',
                    };
                }

                const registrationNumber = result?.data?.registration_number || '';

                const successUrl = new URL("{{ route('registration.success') }}", window.location.origin);

                if (registrationNumber) {
                    successUrl.searchParams.set('registration_number', registrationNumber);
                }

                window.location.href = successUrl.toString();
            } catch (error) {
                showAlert('error', getErrorMessage(error));
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth',
                });
            } finally {
                setLoading(false);
            }
        });

        function setFileName(targetId, file, fallback) {
            const target = document.getElementById(targetId);

            if (!target) {
                return;
            }

            target.textContent = file ? file.name : fallback;
        }

        function setLoading(isLoading) {
            if (!submitButton) {
                return;
            }

            submitButton.disabled = isLoading;
            submitButton.textContent = isLoading ? 'Mengirim Pendaftaran...' : 'Kirim Pendaftaran';
        }

        function showAlert(type, message) {
            if (!formAlert) {
                return;
            }

            const classes = {
                success: 'border-green-200 bg-green-50 text-green-700',
                error: 'border-red-200 bg-red-50 text-red-700',
                info: 'border-blue-200 bg-blue-50 text-blue-700',
            };

            formAlert.className = `mb-6 rounded-xl border px-5 py-4 text-sm font-semibold ${classes[type] || classes.info}`;
            formAlert.innerHTML = message;
            formAlert.classList.remove('hidden');
        }

        function hideAlert() {
            if (formAlert) {
                formAlert.classList.add('hidden');
                formAlert.innerHTML = '';
            }
        }

        function getErrorMessage(error) {
            if (error?.errors) {
                return Object.values(error.errors)
                    .flat()
                    .map(function (message) {
                        return `<div>${escapeHtml(message)}</div>`;
                    })
                    .join('');
            }

            if (error?.message) {
                return escapeHtml(error.message);
            }

            return 'Terjadi kesalahan saat mengirim pendaftaran.';
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
</body>
</html>