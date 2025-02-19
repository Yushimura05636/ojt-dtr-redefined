@props([
    'label' => 'label',
    'labelClass' => '',
    'leftIcon' => '',
    'rightIcon' => '',
    'className' => '',
    'submit' => false,
    'button' => false,
    'routePath' => '',
    'closeModal' => false,
    'openModal' => false,
    'primary' => false,
    'secondary' => false,
    'tertiary' => false,
    'onClick' => '', // New: JavaScript function or event handler
    'name' => '',
    'loading' => false,
    'disabled' => false,
    'showLabel' => false,
    'big' => false,
    'params' => [],
])

@php
    $primaryClasses =
        'px-16 py-3 rounded-full relative overflow-hidden font-medium text-white flex items-center justify-center gap-2 animate-transition bg-gradient-to-r from-[#F57D11] via-[#F57D11]/70 to-[#F53C11] hover:bg-[#F53C11] disabled:opacity-50 lg:text-sm text-xs';
    $secondaryClasses =
        'px-16 py-3 border rounded-full bg-white border-white font-semibold hover:bg-gray-200 text-[#F57D11] animate-transition flex items-center justify-center lg:text-sm text-xs';
    $tertiaryClasses =
        'px-16 py-3 border rounded-full text-[#F57D11] hover:border-[#F57D11] animate-transition flex items-center justify-center gap-2 lg:text-sm text-xs';

    // Assign correct classes based on button type
    $buttonClass = $primary ? $primaryClasses : ($secondary ? $secondaryClasses : ($tertiary ? $tertiaryClasses : ''));

@endphp

<!-- Main Button -->
{{-- disable this button --}}
<button
    class="{{ $className }} {{ $buttonClass }} @if ($big) 'py-4 lg:text-lg sm:text-base text-sm' @endif"
    name="{{ $name }}"
    @if ($closeModal) data-pd-overlay="{{ $closeModal }}" data-modal-target="{{ $closeModal }}" @endif
    @if ($openModal) data-pd-overlay="# . {{ $openModal }}" data-modal-target="{{ $openModal }}" data-modal-toggle="{{ $openModal }}" @endif
    @if ($submit) type="submit" @elseif ($button) type="button" @endif
    @if ($onClick) onclick="{{ $onClick }}" @endif
    @if ($routePath) onclick="window.location.href='{{ route($routePath, $params) }}'" @endif>

    @if ($leftIcon)
        <div class="w-auto h-auto">
            <span class="{{ $leftIcon }}"></span>
        </div>
    @endif

    @if ($showLabel)
        <p class="md:block hidden">{{ $label }}</p>
    @else
        <p>{{ $label }}</p>
    @endif

    @if ($rightIcon)
        <div class="w-auto h-auto">
            <span class="{{ $rightIcon }}"></span>
        </div>
    @endif


</button>
