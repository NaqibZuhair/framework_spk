@props([
    'type' => 'info',
    'title' => null,
])

@php
    $styles = [
        'info' => 'border-blue-200 bg-blue-50 text-blue-800',
        'success' => 'border-green-200 bg-green-50 text-green-800',
        'warning' => 'border-yellow-200 bg-yellow-50 text-yellow-800',
        'danger' => 'border-red-200 bg-red-50 text-red-800',
    ];

    $class = $styles[$type] ?? $styles['info'];
@endphp

<div {{ $attributes->merge([
    'class' => 'rounded-md border px-4 py-3 text-sm ' . $class
]) }}>
    @if ($title)
        <p class="mb-1 font-extrabold">
            {{ $title }}
        </p>
    @endif

    <div>
        {{ $slot }}
    </div>
</div>