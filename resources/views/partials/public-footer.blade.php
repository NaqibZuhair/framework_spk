<footer class="border-t border-slate-200 bg-white">
    <div class="mx-auto grid max-w-7xl grid-cols-1 gap-10 px-6 py-12 lg:grid-cols-3 lg:px-8">
        <div>
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-900">
                    <img
                        src="{{ asset('images/logo-duta.png') }}"
                        alt="Logo Duta PNJ"
                        class="h-8 w-8 object-contain"
                    >
                </div>

                <div>
                    <p class="text-xl font-extrabold leading-tight text-blue-900">
                        Duta PNJ
                    </p>
                    <p class="text-xs font-semibold text-slate-500">
                        Sistem Seleksi Mahasiswa
                    </p>
                </div>
            </div>

            <p class="mt-4 max-w-sm text-sm font-medium leading-6 text-slate-500">
                Sistem seleksi Duta PNJ digunakan untuk pendaftaran, verifikasi, penilaian, dan pengumuman hasil seleksi secara terstruktur.
            </p>
        </div>

        <div>
            <h3 class="text-sm font-extrabold uppercase tracking-wide text-slate-800">
                Navigasi
            </h3>

            <ul class="mt-4 space-y-3 text-sm font-semibold text-slate-500">
                <li>
                    <a href="{{ url('/#beranda') }}" class="transition hover:text-blue-900">
                        Beranda
                    </a>
                </li>
                <li>
                    <a href="{{ url('/#persyaratan') }}" class="transition hover:text-blue-900">
                        Persyaratan
                    </a>
                </li>
                <li>
                    <a href="{{ url('/#jadwal') }}" class="transition hover:text-blue-900">
                        Jadwal Seleksi
                    </a>
                </li>
                <li>
                    <a href="{{ route('public.results') }}" class="transition hover:text-blue-900">
                        Pengumuman
                    </a>
                </li>
            </ul>
        </div>

        <div>
            <h3 class="text-sm font-extrabold uppercase tracking-wide text-slate-800">
                Bantuan
            </h3>

            <ul class="mt-4 space-y-3 text-sm font-semibold text-slate-500">
                <li>
                    <a href="{{ url('/#kontak') }}" class="transition hover:text-blue-900">
                        Kontak Panitia
                    </a>
                </li>
                <li>
                    <a href="{{ url('/#persyaratan') }}" class="transition hover:text-blue-900">
                        Panduan Seleksi
                    </a>
                </li>
                <li>
                    <span>
                        Kebijakan Privasi
                    </span>
                </li>
                <li>
                    <span>
                        Pusat Bantuan
                    </span>
                </li>
            </ul>
        </div>
    </div>

    <div class="border-t border-slate-200 px-6 py-5">
        <p class="mx-auto max-w-7xl text-center text-sm font-medium text-slate-500 md:text-left">
            © {{ date('Y') }} Panitia Pemilihan Duta PNJ. Seluruh Hak Cipta Dilindungi.
        </p>
    </div>
</footer>