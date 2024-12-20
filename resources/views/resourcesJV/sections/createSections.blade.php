<div class="p-4 md:p-5">
    <form class="space-y-4" action="sections/new" method="POST">
        @csrf
        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900">Ingrese sección:</label>
            <input type="text" name="name" id="name"
                class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black"
                oninput="this.value = this.value.toUpperCase();" maxlength="1" required placeholder="Sección"
                title="Letra de Sección" />
        </div>

        <button type="submit"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4  rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Agregar</button>

    </form>
    <x-alert-message />
</div>
