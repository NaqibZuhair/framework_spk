<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil - Duta PNJ</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#F5F7FB] text-slate-900">

    @include('partials.public-navbar', ['active' => 'registration'])

    <!-- Main Content -->
    <main class="mx-auto flex min-h-190 max-w-7xl items-center justify-center px-6 py-12 lg:px-10">
        <section class="w-full max-w-142.5 rounded-xl border border-slate-300 bg-white px-12 py-14 text-center shadow-sm">

            <!-- Icon Success -->
            <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-indigo-100">
                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-[#00288E] text-white">
                    <svg class="h-9 w-9" viewBox="0 0 24 24" fill="none">
                        <path
                            d="M20 6L9 17L4 12"
                            stroke="currentColor"
                            stroke-width="3"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </div>
            </div>

            <h1 class="mt-8 text-[36px] font-extrabold leading-tight text-[#00288E]">
                Pendaftaran Berhasil
            </h1>

            <p class="mt-4 text-[17px] font-medium text-slate-700">
                Terima kasih telah mendaftar sebagai Calon Duta PNJ.
            </p>

            <p class="mx-auto mt-5 max-w-107.5 text-[15px] leading-7 text-slate-600">
                Data Anda telah kami terima dan akan segera diverifikasi oleh tim administrasi.
                Hasil seleksi administrasi akan dikirimkan melalui alamat email yang Anda daftarkan.
            </p>

            <!-- Status Box -->
            <div class="mx-auto mt-10 flex max-w-117.5 items-center gap-4 rounded-md bg-slate-100 px-7 py-5 text-left">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-yellow-500 text-white">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                        <path
                            d="M4 7H20V17H4V7Z"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linejoin="round"
                        />
                        <path
                            d="M4 7L12 13L20 7"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linejoin="round"
                        />
                    </svg>
                </div>

                <div>
                    <p class="text-sm font-extrabold text-slate-800">
                        Status Pendaftaran
                    </p>
                    <p class="mt-1 text-sm font-medium text-slate-600">
                        Menunggu Verifikasi Dokumen
                    </p>
                </div>
            </div>

            <!-- Optional Registration Number -->
            <div id="registrationBox" class="mx-auto mt-5 hidden max-w-117.5 rounded-md border border-slate-200 bg-white px-7 py-4 text-left">
                <p class="text-sm font-bold text-slate-500">Nomor Pendaftaran</p>
                <p id="registrationNumber" class="mt-1 text-xl font-extrabold text-[#00288E]">-</p>
            </div>

            <!-- Action Buttons -->
            <div class="mt-10 grid grid-cols-1 gap-4 sm:grid-cols-2">
                <a href="{{ url('/') }}"
                   class="inline-flex h-14 items-center justify-center gap-3 rounded-md border border-slate-500 bg-white text-sm font-bold text-slate-800 hover:bg-slate-50">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                        <path
                            d="M3 10.5L12 3L21 10.5"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                        <path
                            d="M5 10V21H19V10"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linejoin="round"
                        />
                        <path
                            d="M9 21V14H15V21"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linejoin="round"
                        />
                    </svg>

                    <span>
                        Kembali ke<br>
                        Beranda
                    </span>
                </a>

                <a href="{{ url('/#pengumuman') }}"
                   class="inline-flex h-14 items-center justify-center gap-3 rounded-md bg-[#00288E] text-sm font-bold text-white hover:bg-[#001F73]">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                        <path
                            d="M2 12C4.5 7.5 8 5.5 12 5.5C16 5.5 19.5 7.5 22 12C19.5 16.5 16 18.5 12 18.5C8 18.5 4.5 16.5 2 12Z"
                            stroke="currentColor"
                            stroke-width="2"
                        />
                        <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/>
                    </svg>

                    <span>
                        Lihat<br>
                        Pengumuman
                    </span>
                </a>
            </div>

            <p class="mt-12 text-xs font-medium text-slate-500">
                © Sistem Pendaftaran Resmi Politeknik Negeri Jakarta
            </p>
        </section>
    </main>

    @include('partials.public-footer')

    <script>
        const params = new URLSearchParams(window.location.search);
        const registrationNumber = params.get('registration_number');

        if (registrationNumber) {
            document.getElementById('registrationBox').classList.remove('hidden');
            document.getElementById('registrationNumber').textContent = registrationNumber;
        }
    </script>
</body>
</html>
