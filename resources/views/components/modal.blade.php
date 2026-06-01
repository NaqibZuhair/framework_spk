@props([
    'id',
    'title' => null,
    'size' => 'md',
])

@php
    $sizes = [
        'sm' => 'max-w-md',
        'md' => 'max-w-lg',
        'lg' => 'max-w-2xl',
        'xl' => 'max-w-4xl',
    ];

    $modalSize = $sizes[$size] ?? $sizes['md'];
@endphp

<div id="{{ $id }}" class="fixed inset-0 z-80 hidden">
    <div class="absolute inset-0 bg-slate-900/50" onclick="closeModal('{{ $id }}')"></div>

    <div class="relative mx-auto mt-20 w-[92%] {{ $modalSize }}">
        <div class="overflow-hidden rounded-xl bg-white shadow-xl">
            <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                <h3 class="text-base font-extrabold text-slate-900">
                    {{ $title }}
                </h3>

                <button type="button" onclick="closeModal('{{ $id }}')" class="rounded-md p-1 text-slate-500 hover:bg-slate-100 hover:text-slate-800">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                        <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                    </svg>
                </button>
            </div>

            <div class="px-5 py-5">
                {{ $slot }}
            </div>

            @isset($footer)
                <div class="flex justify-end gap-2 border-t border-slate-200 bg-slate-50 px-5 py-4">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>