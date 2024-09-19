<tbody {{ $attributes->merge(['class' => 'bg-base-100']) }}>
    {{ $slot ?? '' }}
</tbody>
