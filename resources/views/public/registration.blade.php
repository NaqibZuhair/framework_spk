<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran Duta PNJ</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#F5F7FB] text-slate-900">

    <!-- Navbar -->
    {{-- <header class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-6 lg:px-10">
            <a href="{{ url('/') }}" class="text-[22px] font-extrabold text-[#00288E]">
                Duta PNJ
            </a>

            <nav class="hidden items-center gap-8 text-sm font-medium text-slate-700 md:flex">
                <a href="{{ url('/') }}" class="hover:text-[#00288E]">Beranda</a>
                <a href="{{ url('/#persyaratan') }}" class="hover:text-[#00288E]">Persyaratan</a>
                <a href="{{ url('/#jadwal') }}" class="hover:text-[#00288E]">Jadwal</a>
                <a href="{{ url('/#pengumuman') }}" class="hover:text-[#00288E]">Pengumuman</a>
            </nav>

            <div class="flex items-center gap-3">
                <a href="{{ url('/login') }}" class="text-sm font-semibold text-[#00288E] hover:underline">
                    Login
                </a>

                <a href="{{ url('/registration') }}"
                   class="rounded-md bg-[#00288E] px-6 py-2.5 text-sm font-bold text-white hover:bg-[#001F73]">
                    Daftar
                </a>
            </div>
        </div>
    </header> --}}

    <!-- Main -->
    <main class="mx-auto max-w-7xl px-6 py-12 lg:px-10">
        <section class="mb-10">
            <h1 class="text-[40px] font-extrabold leading-tight text-[#00288E]">
                Formulir Pendaftaran Duta PNJ 2024
            </h1>

            <p class="mt-4 max-w-2xl text-[16px] leading-7 text-slate-600">
                Lengkapi data diri Anda dengan teliti untuk mengikuti seleksi Pemilihan Duta
                Politeknik Negeri Jakarta 2024. Pastikan semua berkas telah disiapkan
                sesuai dengan ketentuan.
            </p>
        </section>

        <div id="formAlert" class="mb-6 hidden rounded-lg border px-5 py-4 text-sm"></div>

        <form id="registrationForm" enctype="multipart/form-data" method="POST" action="javascript:void(0);">
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

                <!-- Informasi Pribadi -->
                <section class="rounded-xl border border-slate-300 bg-white p-6 shadow-sm">
                    <h2 class="mb-6 text-[22px] font-extrabold text-slate-800">
                        Informasi Pribadi
                    </h2>

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
                                class="h-11 w-full border border-slate-300 bg-white px-4 text-sm outline-none focus:border-[#00288E] focus:ring-1 focus:ring-[#00288E]"
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
                                    placeholder="2103421xxx"
                                    class="h-11 w-full border border-slate-300 bg-white px-4 text-sm outline-none focus:border-[#00288E] focus:ring-1 focus:ring-[#00288E]"
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
                                    class="h-11 w-full border border-slate-300 bg-white px-4 text-sm text-slate-600 outline-none focus:border-[#00288E] focus:ring-1 focus:ring-[#00288E]"
                                >
                                    <option value="">Pilih Semester</option>
                                    <option value="1">Semester 1</option>
                                    <option value="2">Semester 2</option>
                                    <option value="3">Semester 3</option>
                                    <option value="4">Semester 4</option>
                                    <option value="5">Semester 5</option>
                                    <option value="6">Semester 6</option>
                                    <option value="7">Semester 7</option>
                                    <option value="8">Semester 8</option>
                                    <option value="9">Semester 9</option>
                                    <option value="10">Semester 10</option>
                                    <option value="11">Semester 11</option>
                                    <option value="12">Semester 12</option>
                                    <option value="13">Semester 13</option>
                                    <option value="14">Semester 14</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label for="faculty" class="mb-2 block text-sm font-bold text-slate-800">
                                    Jurusan
                                </label>
                                <input
                                    id="faculty"
                                    name="faculty"
                                    type="text"
                                    placeholder="Contoh: Teknik Informatika"
                                    class="h-11 w-full border border-slate-300 bg-white px-4 text-sm outline-none focus:border-[#00288E] focus:ring-1 focus:ring-[#00288E]"
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
                                    placeholder="Contoh: D4 Teknik Informatika"
                                    class="h-11 w-full border border-slate-300 bg-white px-4 text-sm outline-none focus:border-[#00288E] focus:ring-1 focus:ring-[#00288E]"
                                >
                            </div>
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
                                placeholder="nama@pnj.ac.id"
                                class="h-11 w-full border border-slate-300 bg-white px-4 text-sm outline-none focus:border-[#00288E] focus:ring-1 focus:ring-[#00288E]"
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
                                    placeholder="0812xxx xxxx"
                                    class="h-11 w-full border border-slate-300 bg-white px-4 text-sm outline-none focus:border-[#00288E] focus:ring-1 focus:ring-[#00288E]"
                                >
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Visi Misi dan Upload -->
                <div class="space-y-6">

                    <!-- Visi & Misi -->
                    <section class="rounded-xl border border-slate-300 bg-white p-6 shadow-sm">
                        <h2 class="mb-5 text-[22px] font-extrabold text-slate-800">
                            Visi & Misi
                        </h2>

                        <div class="space-y-5">
                            <div>
                                <label for="vision" class="mb-2 block text-sm font-bold text-slate-800">
                                    Visi sebagai Duta PNJ
                                </label>

                                <textarea
                                    id="vision"
                                    name="vision"
                                    rows="4"
                                    placeholder="Tuliskan visi Anda sebagai calon Duta PNJ..."
                                    class="w-full resize-none border border-slate-300 bg-white px-4 py-3 text-sm outline-none focus:border-[#00288E] focus:ring-1 focus:ring-[#00288E]"
                                ></textarea>
                            </div>

                            <div>
                                <label for="mission" class="mb-2 block text-sm font-bold text-slate-800">
                                    Misi sebagai Duta PNJ
                                </label>

                                <textarea
                                    id="mission"
                                    name="mission"
                                    rows="4"
                                    placeholder="Tuliskan misi, program, atau kontribusi yang ingin Anda lakukan sebagai Duta PNJ..."
                                    class="w-full resize-none border border-slate-300 bg-white px-4 py-3 text-sm outline-none focus:border-[#00288E] focus:ring-1 focus:ring-[#00288E]"
                                ></textarea>
                            </div>
                        </div>
                    </section>

                    <!-- Upload Berkas -->
                    <section class="rounded-xl border border-slate-300 bg-white p-6 shadow-sm">
                        <h2 class="mb-5 text-[22px] font-extrabold text-slate-800">
                            Unggah Berkas
                        </h2>

                        <div class="space-y-5">

                            <div>
                                <label for="photo_file" class="mb-2 block text-sm font-bold text-slate-800">
                                    Foto Formal (3x4)
                                </label>

                                <label class="flex h-14 cursor-pointer items-center justify-center border border-dashed border-slate-400 bg-white px-4 text-center text-sm text-slate-600 hover:border-[#00288E] hover:bg-blue-50">
                                    <span id="photoLabel">Klik atau seret file foto di sini (Maks 2MB, JPG/PNG)</span>
                                    <input
                                        id="photo_file"
                                        name="photo_file"
                                        type="file"
                                        accept=".jpg,.jpeg,.png,.webp"
                                        class="hidden"
                                    >
                                </label>
                            </div>

                            <div>
                                <label for="cv_file" class="mb-2 block text-sm font-bold text-slate-800">
                                    Curriculum Vitae (CV)
                                </label>

                                <label class="flex h-14 cursor-pointer items-center justify-center border border-dashed border-slate-400 bg-white px-4 text-center text-sm text-slate-600 hover:border-[#00288E] hover:bg-blue-50">
                                    <span id="cvLabel">Klik atau seret file PDF di sini (Maks 5MB)</span>
                                    <input
                                        id="cv_file"
                                        name="cv_file"
                                        type="file"
                                        accept=".pdf,.doc,.docx"
                                        class="hidden"
                                    >
                                </label>
                            </div>

                        </div>
                    </section>
                </div>
            </div>

            <!-- Buttons -->
            <div class="mt-7 border-t border-slate-300 pt-6">
                <div class="flex items-center gap-4">
                    <a href="{{ url('/') }}"
                       class="inline-flex h-12 w-40 items-center justify-center rounded-md border border-[#00288E] bg-white text-sm font-bold text-[#00288E] hover:bg-blue-50">
                        Kembali
                    </a>

                    <button
                        id="submitButton"
                        type="submit"
                        class="inline-flex h-12 w-56 items-center justify-center rounded-md bg-[#00288E] text-sm font-bold text-white hover:bg-[#001F73] disabled:cursor-not-allowed disabled:opacity-70"
                    >
                        <span id="submitButtonText">Kirim Pendaftaran</span>
                    </button>
                </div>
            </div>
        </form>
    </main>

    <!-- Footer -->
    <footer class="mt-16 border-t border-slate-300 bg-slate-100">
        <div class="mx-auto grid max-w-7xl grid-cols-1 gap-10 px-6 py-12 lg:grid-cols-3 lg:px-10">
            <div>
                <h2 class="text-[24px] font-extrabold text-[#00288E]">Duta PNJ</h2>
                <p class="mt-4 max-w-sm text-sm leading-6 text-slate-600">
                    Wadah inspirasi dan representasi mahasiswa terbaik Politeknik Negeri Jakarta
                    untuk berkontribusi pada institusi dan masyarakat.
                </p>
            </div>

            <div></div>

            <div class="grid grid-cols-2 gap-8 text-sm">
                <div>
                    <h3 class="mb-4 font-extrabold text-yellow-700">Tautan Penting</h3>
                    <ul class="space-y-3 text-slate-600">
                        <li><a href="#" class="hover:text-[#00288E]">Panduan Seleksi</a></li>
                        <li><a href="#" class="hover:text-[#00288E]">Kontak Panitia</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="mb-4 font-extrabold text-yellow-700">Legalitas</h3>
                    <ul class="space-y-3 text-slate-600">
                        <li><a href="#" class="hover:text-[#00288E]">Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:text-[#00288E]">Pusat Bantuan</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="border-t border-slate-300 px-6 py-4 lg:px-10">
            <div class="mx-auto flex max-w-7xl items-center justify-between text-xs text-slate-600">
                <p>© 2024 Panitia Pemilihan Duta PNJ. Seluruh Hak Cipta Dilindungi.</p>

                <div class="flex items-center gap-4">
                    <span>🌐</span>
                    <span>↗</span>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('registrationForm');
            const formAlert = document.getElementById('formAlert');
            const submitButton = document.getElementById('submitButton');
            const submitButtonText = document.getElementById('submitButtonText');

            const photoInput = document.getElementById('photo_file');
            const cvInput = document.getElementById('cv_file');
            const supportingInput = document.getElementById('supporting_file');

            if (!form) {
                console.error('Form registrationForm tidak ditemukan.');
                return;
            }

            if (photoInput) {
                photoInput.addEventListener('change', function () {
                    document.getElementById('photoLabel').textContent =
                        this.files[0]?.name || 'Klik atau seret file foto di sini (Maks 2MB, JPG/PNG)';
                });
            }

            if (cvInput) {
                cvInput.addEventListener('change', function () {
                    document.getElementById('cvLabel').textContent =
                        this.files[0]?.name || 'Klik atau seret file PDF di sini (Maks 5MB)';
                });
            }

            if (supportingInput) {
                supportingInput.addEventListener('change', function () {
                    document.getElementById('supportingLabel').textContent =
                        this.files[0]?.name || 'Sertifikat, portofolio, dsb. Belum disimpan ke database';
                });
            }

            form.addEventListener('submit', async function (event) {
                event.preventDefault();

                hideAlert();

                submitButton.disabled = true;
                submitButtonText.textContent = 'Mengirim...';

                const formData = new FormData();

                formData.append('full_name', document.getElementById('full_name').value);
                formData.append('student_number', document.getElementById('student_number').value);
                formData.append('email', document.getElementById('email').value);
                formData.append('phone', document.getElementById('phone').value);
                formData.append('faculty', document.getElementById('faculty').value);
                formData.append('study_program', document.getElementById('study_program').value);
                formData.append('semester', document.getElementById('semester').value);
                formData.append('vision', document.getElementById('vision').value);
                formData.append('mission', document.getElementById('mission').value);

                if (photoInput && photoInput.files[0]) {
                    formData.append('photo_file', photoInput.files[0]);
                }

                if (cvInput && cvInput.files[0]) {
                    formData.append('cv_file', cvInput.files[0]);
                }

                try {
                    const response = await fetch("{{ url('/api/candidates/register') }}", {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                        },
                        body: formData,
                    });

                    const result = await response.json();

                    if (!response.ok) {
                        let message = result.message || 'Pendaftaran gagal dikirim.';

                        if (result.errors) {
                            message = Object.values(result.errors)
                                .flat()
                                .join('<br>');
                        }

                        showAlert(message, 'error');
                        return;
                    }

                    const registrationNumber =
                        result.data?.registration_number ||
                        result.data?.candidate?.registration_number ||
                        '-';

                    showAlert(
                        `Pendaftaran berhasil dikirim. Nomor pendaftaran Anda: <strong>${registrationNumber}</strong>`,
                        'success'
                    );

                    form.reset();

                    if (document.getElementById('photoLabel')) {
                        document.getElementById('photoLabel').textContent =
                            'Klik atau seret file foto di sini (Maks 2MB, JPG/PNG)';
                    }

                    if (document.getElementById('cvLabel')) {
                        document.getElementById('cvLabel').textContent =
                            'Klik atau seret file PDF di sini (Maks 5MB)';
                    }

                    if (document.getElementById('supportingLabel')) {
                        document.getElementById('supportingLabel').textContent =
                            'Sertifikat, portofolio, dsb. Belum disimpan ke database';
                    }

                    setTimeout(() => {
                        window.location.href =
                            "{{ url('/registration-success') }}?registration_number=" +
                            encodeURIComponent(registrationNumber);
                    }, 1200);

                } catch (error) {
                    console.error(error);
                    showAlert('Tidak dapat terhubung ke server. Pastikan Laravel sedang berjalan.', 'error');
                } finally {
                    submitButton.disabled = false;
                    submitButtonText.textContent = 'Kirim Pendaftaran';
                }
            });

            function showAlert(message, type) {
                formAlert.innerHTML = message;
                formAlert.classList.remove('hidden');

                formAlert.className = 'mb-6 rounded-lg border px-5 py-4 text-sm';

                if (type === 'success') {
                    formAlert.classList.add('border-green-200', 'bg-green-50', 'text-green-700');
                } else {
                    formAlert.classList.add('border-red-200', 'bg-red-50', 'text-red-700');
                }

                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }

            function hideAlert() {
                formAlert.classList.add('hidden');
                formAlert.innerHTML = '';
            }
        });
    </script>
</body>
</html>
