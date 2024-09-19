<div class='w-full overflow-auto rounded-lg shadow-sm max-h-96'>

    <table {{ $attributes->merge(['class' => 'table-sm w-full']) }}>

    <x-tablas.thead>

    {{ $thead }}

    </x-tablas.thead>

    <x-tablas.body>

    {{ $tbody }}

    </x-tablas.body>

    </table>

    </div>
