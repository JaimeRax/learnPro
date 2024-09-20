<div class="p-4 md:p-5">
    <form class="space-y-4" action="courses/new" method="POST">
        @csrf
        <div>
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nombre del Curso</label>
            <input type="text" name="name" id="name"
                class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black"
                required />
        </div>

        {{-- seleccionar a que grado pertenece el curso --}}
        <x-inputs.select-option id="degree_id" titulo="Grado" name="degree_id" :options="$degrees->pluck('name', 'id')->toArray()" required />
        <button type="submit"
            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Agregar</button>
    </form>

    {{-- mensaje de exito o error al crear un curso --}}

    <x-alert-message />

</div>
