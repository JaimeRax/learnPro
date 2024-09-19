@props([
    'disabled' => false,
    'tooltip' => null,
    'tooltipclass' => null,
])

@if (isset($tooltip))
    <div class="tooltip tooltip-left {{ $tooltipClass ?? '' }}" data-tip="{{ $tooltip }}">
        <a {{ $attributes->merge([
            'class' => 'btn no-underline border-none'
        ]) }}
            {{ $disabled ? 'disabled' : '' }}>
            {{ $slot }}
        </a>
    </div>
@else
    <a {{ $attributes->merge([
        'class' => 'btn border-none'
    ]) }} {{ $disabled ? 'disabled' : '' }}>
        {{ $slot }}
    </a>
@endif
