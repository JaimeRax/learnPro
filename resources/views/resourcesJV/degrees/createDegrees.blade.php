<div class="p-4 md:p-5">
    <form class="space-y-4" action="degrees/new" method="POST">
        @csrf
        <div>
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Nombre del Grado</label>
            <input type="text" name="name" id="name"
                class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 text-black"
                required placeholder="Grado" title="Nombre grado" />
        </div>
        <x-buttonAcept />
    </form>
    <x-alert-message />
</div>
