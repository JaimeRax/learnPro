<div class="p-4 md:p-5">
    <form class="space-y-4" action="activity/edit/{{ $activity->id }}" method="POST">
        @csrf
        <x-inputs.general id="year" name="year" readonly style="text-align: center; font-weight: bold;" value="{{ \Carbon\Carbon::now()->format('Y') }}" class="hidden" required />

        <x-inputs.general type="date" name="date_entity" id="date_entity" titulo="Fecha de entrega"
            class=" bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black"
            required value="{{ $activity->date_entity }}"/>

        <x-inputs.general type="text" name="name" id="name" titulo="Nombre de la actividad"
            class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black"
            required value="{{ $activity->name }}"/>

        <div class="flex items-center justify-end pb-1 space-x-4 border-b-2 border-gray-300">
            <div>
                <x-inputs.select-option name="bimester" id="bimester" titulo="Bimestre" :options="[
                    '1' => 'I Bimestre',
                    '2' => 'II Bimestre',
                    '3' => 'III Bimestre',
                    '4' => 'IV Bimestre'
                ]" required
                    class="border-2 border-gray-300" value="{{ $activity->bimester }}"/>
            </div>
            <div>
                <x-inputs.general type="number" name="plucking" id="plucking" titulo="Punteo" min="0"
                    class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black"
                    required value="{{ $activity->plucking }}"/>
            </div>
        </div>

        <div class="flex items-center justify-end pb-1 space-x-4 border-b-2 border-gray-300">
            <div>
                <x-inputs.select-option id="degree_id" titulo="Grado" name="degree_id"
                    :options="$degrees->pluck('name', 'id')->toArray()"
                    :selected="$activity->degrees_id" required />  <!-- Cambiado a $activity -->
            </div>
            <div>
                <x-inputs.select-option id="section_id" titulo="Sección" name="section_id"
                    :options="$sections->pluck('name', 'id')->toArray()"
                    :selected="$activity->section_id" required />  <!-- Cambiado a $activity -->
            </div>
            <div>
                <x-inputs.select-option id="course_id" titulo="Curso" name="course_id"
                    :options="$courses->pluck('name', 'id')->toArray()"
                    :selected="$activity->course_id" required />  <!-- Cambiado a $activity -->
            </div>
        </div>


        <button type="submit"
            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Agregar</button>
    </form>

    {{-- mensaje de exito o error al crear un curso --}}

    <x-alert-message />
</div>
