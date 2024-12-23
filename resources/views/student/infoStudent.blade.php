<section>
    <!-- Información del estudiante -->
    <div class="container">

        <div class="space-y-6 p-6">

            <!-- Nombre Completo -->
            <div class="flex flex-col text-left">
                <label for="nombres" class="text-sm font-semibold text-gray-700 mb-2">
                    NOMBRE COMPLETO:
                </label>
                <input type="text" id="nombres" name="nombres"
                    class="w-full rounded-md border border-gray-400 bg-gray-200 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none px-4 py-2 text-gray-800"
                    readonly
                    value="{{ strtoupper("{$studens->first_name} {$studens->second_name} {$studens->first_lastname} {$studens->second_lastname}") }}">
            </div>

            <!-- Código Personal -->
            <div class="flex flex-col text-left">
                <label for="personal_code" class="text-sm font-semibold text-gray-700 mb-2">
                    CÓDIGO PERSONAL:
                </label>
                <input type="text" id="personal_code" name="personal_code"
                    class="w-full rounded-md border border-gray-400 bg-gray-200 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none px-4 py-2 text-gray-800"
                    readonly value="{{ $studens->personal_code }}">
            </div>

            <!-- Género -->
            <div class="flex flex-col text-left">
                <label for="gender" class="text-sm font-semibold text-gray-700 mb-2">
                    GÉNERO:
                </label>
                <input type="text" id="gender" name="gender"
                    class="w-full rounded-md border border-gray-400 bg-gray-200 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none px-4 py-2 text-gray-800"
                    readonly value="{{ $studens->gender }}">
            </div>

            <!-- Fecha de Nacimiento -->
            <div class="flex flex-col text-left">
                <label for="birthdate" class="text-sm font-semibold text-gray-700 mb-2">
                    FECHA DE NACIMIENTO:
                </label>
                <input type="text" id="birthdate" name="birthdate"
                    class="w-full rounded-md border border-gray-400 bg-gray-200 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none px-4 py-2 text-gray-800"
                    readonly value="{{ $studens->birthdate }}">
            </div>

            <div class="flex flex-col text-left">
                <label for="etnia" class="text-sm font-semibold text-gray-700 mb-2">
                    ETNIA:
                </label>
                <input type="text" id="birthdate" name="birthdate"
                    class="w-full rounded-md border border-gray-400 bg-gray-200 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none px-4 py-2 text-gray-800"
                    readonly value="{{ $studens->town_ethnicity }}">
            </div>
        </div>
    </div>
</section>
