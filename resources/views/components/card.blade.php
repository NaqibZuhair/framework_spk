@props([
    'title' => null,
    'subtitle' => null,
    'padding' => 'p-5',
])

<div {{ $attributes->merge([
    'class' => 'rounded-xl border border-slate-200 bg-white shadow-sm'
]) }}>
    @if ($title || $subtitle || isset($actions))
        <div class="flex items-start justify-between gap-4 border-b border-slate-200 px-5 py-4">
            <div>
                @if ($title)
                    <h3 class="text-base font-extrabold text-slate-900">
                        {{ $title }}
                    </h3>
                @endif

                @if ($subtitle)
                    <p class="mt-1 text-sm text-slate-500">
                        {{ $subtitle }}
                    </p>
                @endif
            </div>

            @isset($actions)
                <div>
                    {{ $actions }}
                </div>
            @endisset
        </div>
    @endif

    <div class="{{ $padding }}">
        {{ $slot }}
    </div>
</div>