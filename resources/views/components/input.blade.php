@props([
    'label' => null,
    'name',
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'helper' => null,
])

<div>
    @if ($label)
        <label for="{{ $name }}" class="mb-2 block text-sm font-bold text-slate-700">
            {{ $label }}

            @if ($required)
                <span class="text-red-600">*</span>
            @endif
        </label>
    @endif

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge([
            'class' => 'h-11 w-full rounded-md border border-slate-300 bg-white px-4 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-[#00288E] focus:ring-2 focus:ring-blue-100'
        ]) }}
    >

    @if ($helper)
        <p class="mt-1.5 text-xs text-slate-500">
            {{ $helper }}
        </p>
    @endif

    @error($name)
        <p class="mt-1.5 text-xs font-semibold text-red-600">
            {{ $message }}
        </p>
    @enderror
</div>