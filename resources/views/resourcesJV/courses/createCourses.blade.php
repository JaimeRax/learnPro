<div class="p-4 md:p-5">
    <form class="space-y-4" action="courses/new" method="POST">
        @csrf
        <div>
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nombre del Curso</label>
            <input type="text" name="name" id="name"
                class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black"
                placeholder="Curso" title="Nombre del Curso" required />
        </div>
        <x-buttonAcept />
    </form>

    {{-- mensaje de exito o error al crear un curso --}}
    <x-alert-message />

</div>
