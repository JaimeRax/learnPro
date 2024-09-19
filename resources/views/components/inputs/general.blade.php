@props(['id', 'titulo' => null, 'required' => false, 'disabled' => false])

<div>
    <label class="label mb-0 font-bold {{ $titulo ? '' : 'hidden' }}" for={{ $id }}>
        <span class="label-text">
            {{ $titulo }}{{ $required ? ' *' : '' }}
        </span>
        {{ $slot ?? '' }}
    </label>
    <input id="{{ $id }}" name="{{ $id }}" {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->merge([
            'class' => 'input w-full shadow-sm',
            'type' => 'text'
        ]) }}>
</div>
