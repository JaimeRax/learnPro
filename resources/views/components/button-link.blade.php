@props(['disabled' => false, 'tooltip' => null, 'tooltipclass' => null])

@if (isset($tooltip))
    <div class="tooltip tooltip-left {{ $tooltipClass ?? '' }}" data-tip="{{ $tooltip }}">
        <a {{ $attributes->merge([
            'class' => 'btn no-underline'
        ]) }}
            {{ $disabled ? 'disabled' : '' }}>
            {{ $slot }}
        </a>
    </div>
@else
    <a {{ $attributes->merge([
        'class' => 'btn'
    ]) }} {{ $disabled ? 'disabled' : '' }}>
        {{ $slot }}
    </a>
@endif
