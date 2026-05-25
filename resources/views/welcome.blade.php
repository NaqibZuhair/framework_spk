@extends('layouts.app')

@section('content')
<section class="min-h-screen flex items-center justify-center px-6">
    <div class="w-full max-w-xl rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
        <p class="text-sm font-semibold text-blue-600">
            Laravel 12 + Tailwind
        </p>

        <h1 class="mt-3 text-3xl font-bold text-slate-900">
            Pemilihan Duta Kampus
        </h1>

        <p class="mt-4 text-slate-600">
            Tailwind sudah aktif. Website siap dikembangkan dengan Blade, REST API, dan MySQL.
        </p>

        <div class="mt-6 flex gap-3">
            <a href="#" class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700">
                Mulai Pendaftaran
            </a>

            <a href="#" class="rounded-xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100">
                Login Admin
            </a>
        </div>
    </div>
</section>
@endsection
