@props([
    'label' => false,
    'type' => 'text',
    'name_id',
    'value' => '',
    'placeholder' => '',
    'labelClass' => '',
    'small' => false,
    'big' => false,
    'hidden' => false,
    'options' => [], // Dropdown options
    'disabled' => false,
])

<div class="space-y-3">
    @if ($label)
        <label for="{{ $name_id }}" @class([
            '{{ $labelClass }} lg:text-base text-sm font-semibold text-gray-700',
            'border-[#F53C11]' => $errors->has($name_id),
        ])>{{ $label }}</label>
    @endif

    @if ($type === 'select')
        <!-- Dropdown Selection -->
        <select id="{{ $name_id }}" name="{{ $name_id }}" @class([
            'border border-gray-300 w-full tracking-wider focus:ring-2 focus:ring-[#F57D11] focus:outline-none focus:border-[#F57D11] bg-white',
            '!border-[#F53C11]' => $errors->has($name_id),
            'px-4 py-2 rounded-lg' => $small,
            'px-5 py-4 rounded-xl' => $big,
            'hidden' => $hidden,
            'opacity-50 cursor-not-allowed bg-gray-100' => $disabled,
        ])
            @if ($disabled) disabled aria-disabled="true" tabindex="-1" @endif>
            <option value="" disabled selected>{{ $placeholder }}</option>
            @foreach ($options as $key => $option)
                <option value="{{ $key }}" {{ old($name_id, $value) == $key ? 'selected' : '' }}>
                    {{ $option }}
                </option>
            @endforeach
        </select>
    @else
        <!-- Normal Input Field -->
        <input type="{{ $type }}" id="{{ $name_id }}" name="{{ $name_id }}"
            value="{{ old($name_id, $value) }}" placeholder="{{ $placeholder }}" @class([
                'border border-gray-300 w-full tracking-wider focus:ring-2 focus:ring-[#F57D11] focus:outline-none focus:border-[#F57D11] lg:text-base text-sm',
                '!border-[#F53C11]' => $errors->has($name_id),
                'px-4 py-2 rounded-lg' => $small,
                'px-5 py-4 rounded-xl' => $big,
                'hidden' => $hidden,
                'opacity-50 cursor-not-allowed bg-gray-100' => $disabled,
            ])
            @if ($disabled) disabled aria-disabled="true" tabindex="-1" @endif>
    @endif

    <x-form.error name="{{ $name_id }}" />
</div>
