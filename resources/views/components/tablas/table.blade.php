<div class='w-full overflow-auto rounded-lg shadow-sm max-h-128'>
    <table {{ $attributes->merge(['class' => 'table-auto w-full text-center']) }}>
        <x-tablas.thead>
            {{ $thead }}
        </x-tablas.thead>

        <x-tablas.body>
            {{ $tbody }}
        </x-tablas.body>
    </table>
</div>
