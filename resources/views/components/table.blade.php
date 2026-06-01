@props([
    'headers' => [],
    'tbodyId' => null,
    'tbodyClass' => 'divide-y divide-slate-200 text-sm',
])

<div {{ $attributes->merge([
    'class' => 'overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm'
]) }}>
    <div class="overflow-x-auto">
        <table class="min-w-full text-left">
            @if (!empty($headers))
                <thead class="bg-slate-50">
                    <tr class="border-b border-slate-200 text-xs uppercase tracking-wider text-slate-600">
                        @foreach ($headers as $header)
                            <th class="px-6 py-4 font-extrabold">
                                {{ $header }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
            @endif

            <tbody
                @if ($tbodyId) id="{{ $tbodyId }}" @endif
                class="{{ $tbodyClass }}"
            >
                {{ $slot }}
            </tbody>
        </table>
    </div>
</div>