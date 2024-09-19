@props(['id', 'titulo' => null, 'required' => false, 'value' => null, 'options' => []])

<div class="form-control">
    <label class="label mb-0 font-bold {{ $titulo ? '' : 'hidden' }}" for="{{ $id }}">
        <span class="label-text">
            {{ $titulo }}{{ $required ? ' *' : '' }}
        </span>
        {{ $slot ?? '' }}
    </label>
    <select id="{{ $id }}" name="{{ $id }}" value="{{ $value }}"
        {{ $attributes->merge(['class' => 'select w-full shadow-sm']) }}>
        <option value="{{ null }}">Seleccionar una opción</option>
        @foreach ($options as $key => $val)
            <option value="{{ $key }}" @selected($key == $value)>{{ $val }}</option>
        @endforeach
    </select>
</div>
