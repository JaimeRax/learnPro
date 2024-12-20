<div class='w-full overflow-auto rounded-lg shadow-sm max-h-128'>
    <table {{ $attributes->merge(['class' => 'table-auto w-full text-center']) }}>
        <x-tablas.thead class="bg-gray-200">
            {{ $thead }}
        </x-tablas.thead>

        <x-tablas.body class="odd:bg-gray-100 even:bg-white">
            {{ $tbody }}
        </x-tablas.body>
    </table>
</div>
