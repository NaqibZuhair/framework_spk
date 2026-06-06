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
    <div class="absolute inset-0 bg-slate-950/50 backdrop-blur-sm" onclick="closeModal('{{ $id }}')"></div>

    <div class="relative flex min-h-full items-center justify-center px-4 py-6">
        <div class="w-full {{ $modalSize }}">
            <div class="overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-slate-900/10">
                @if ($title)
                    <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
                        <h3 class="text-base font-extrabold text-slate-900">
                            {{ $title }}
                        </h3>

                        <button
                            type="button"
                            onclick="closeModal('{{ $id }}')"
                            class="rounded-lg p-1.5 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                            aria-label="Tutup modal"
                        >
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                                <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                            </svg>
                        </button>
                    </div>
                @endif

                <div class="px-6 py-5">
                    {{ $slot }}
                </div>

                @isset($footer)
                    <div class="flex justify-end gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4">
                        {{ $footer }}
                    </div>
                @endisset
            </div>
        </div>
    </div>
</div>