@if (isset($tooltip))
    <div class="tooltip tooltip-left {{ $tooltipClass ?? '' }}" data-tip="{{ $tooltip }}">
        <button {{ $attributes->merge([
            'class' => 'btn'
        ]) }}>
            {{ $slot }}
        </button>
    </div>
@else
    <button {{ $attributes->merge([
        'class' => 'btn'
    ]) }}>
        {{ $slot }}
    </button>
@endif
