<tr {{ $attributes->merge(['class' => 'odd:bg-white even:bg-gray-200']) }}>

    {{ $slot ?? '' }}

</tr>
