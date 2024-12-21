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
        <x-buttonAcept />
    </form>

    {{-- mensaje de exito o error al crear un curso --}}
    <x-alert-message />
</div>
