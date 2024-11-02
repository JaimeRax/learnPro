@extends('layouts.base')

@section('header')
    <route route="/" previousRouteName="Inicio" currentRouteName="degrees" />
@endsection


@section('main')
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <div class="grid grid-cols-1 gap-2">
        <div class="container-sm">
            <form action="{{ url('student/edit/' . $studens->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <ol class="relative text-gray-500 border-gray-200 border-s dark:border-gray-700 dark:text-gray-400">
                    <div class="ms-6">
                        <span
                            class="absolute flex items-center justify-center w-8 rounded-full bg-neutral-content -start-4">
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <h3 class="font-medium leading-tight">INFORMACIÓN PERSONAL DEL ESTUDIANTE</h3>
                    </div>
                    <div class="col-span-2 ml-10 lg:ml-32">
                        <section class="steps activo step-1" id="step-1">
                            <div class="flex-col p-2">
                                <div class="grid grid-cols-1 gap-2 md:grid-cols-3">
                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="first_name">
                                                <span class="label-text">
                                                    Primer nombre *
                                                </span>
                                            </label>
                                            <input id="first_name" required name="first_name" class="w-full shadow-sm input"
                                                type="text" value="{{ old('first_name', $studens->first_name) }}">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="mb-0 font-bold label " for="second_name">
                                            <span class="label-text">
                                                Segundo nombre
                                            </span>
                                        </label>
                                        <input id="second_name" name="second_name" class="w-full shadow-sm input"
                                            type="text" value="{{ old('second_name', $studens->second_name) }}">
                                    </div>
                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="first_lastname">
                                                <span class="label-text">
                                                    Primer Apellido *
                                                </span>
                                            </label>
                                            <input id="first_lastname" required name="first_lastname"
                                                class="w-full shadow-sm input" type="text"
                                                value="{{ old('first_lastname', $studens->first_lastname) }}">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="mb-0 font-bold label " for="second_lastname">
                                            <span class="label-text">
                                                Segundo apellido
                                            </span>
                                        </label>
                                        <input id="second_lastname" name="second_lastname" class="w-full shadow-sm input"
                                            type="text" value="{{ old('second_lastname', $studens->second_lastname) }}">
                                    </div>
                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label" for="personal_code">
                                                <span class="label-text">
                                                    Código Personal *
                                                </span>
                                            </label>
                                            <input id="personal_code" required name="personal_code"
                                                class="w-full shadow-sm input" type="text"
                                                value="{{ old('personal_code', $studens->personal_code) }}">
                                        </div>
                                    </div>
                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="birthdate">
                                                <span class="label-text">
                                                    Fecha de nacimiento *
                                                </span>
                                            </label>
                                            <input id="birthdate" required name="birthdate" class="w-full shadow-sm input"
                                                type="date" value="{{ old('birthdate', $studens->birthdate) }}">
                                        </div>
                                    </div>
                                    <div class="group">
                                        <div class="form-control">
                                            <label class="mb-0 font-bold label" for="gender">
                                                <span class="label-text">
                                                    Género *
                                                </span>
                                            </label>
                                            <select id="gender" name="gender" required class="w-full shadow-sm select">
                                                <option value="">Seleccionar una opción</option>
                                                <option value="MASCULINO"
                                                    {{ old('gender', $studens->gender) == 'MASCULINO' ? 'selected' : '' }}>
                                                    Masculino</option>
                                                <option value="FEMENINO"
                                                    {{ old('gender', $studens->gender) == 'FEMENINO' ? 'selected' : '' }}>
                                                    Femenino</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="group">
                                        <div class="form-control">
                                            <label class="mb-0 font-bold label" for="town_ethnicity">
                                                <span class="label-text">
                                                    Pueblo/Etnia *
                                                </span>
                                            </label>
                                            <select id="town_ethnicity" name="town_ethnicity" required
                                                class="w-full shadow-sm select">
                                                <option value="">Seleccionar una opción</option>
                                                <option value="MAYA"
                                                    {{ old('town_ethnicity', $studens->town_ethnicity) == 'MAYA' ? 'selected' : '' }}>
                                                    Maya</option>
                                                <option value="XINKA"
                                                    {{ old('town_ethnicity', $studens->town_ethnicity) == 'XINKA' ? 'selected' : '' }}>
                                                    Xinca</option>
                                                <option value="GARIFUNA"
                                                    {{ old('town_ethnicity', $studens->town_ethnicity) == 'GARIFUNA' ? 'selected' : '' }}>
                                                    Garifuna</option>
                                                <option value="LADINO"
                                                    {{ old('town_ethnicity', $studens->town_ethnicity) == 'LADINO' ? 'selected' : '' }}>
                                                    Ladino</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="group">
                                    <button class="justify-start mt-2 text-white btn bg-success next-btn" type="button"
                                        data-next-step="step-2">
                                        Siguiente
                                    </button>
                                </div>
                            </div>
                        </section>
                    </div>

                    {{-- PRIMER ENCARGADO --}}

                    <div class="ms-6">
                        <span
                            class="absolute flex items-center justify-center w-8 rounded-full bg-neutral-content -start-4">
                            <i class="fa-solid fa-house-user"></i>
                        </span>
                        <h3 class="font-medium leading-tight">DATOS DEL PADRE/MADRE DE FAMILIA</h3>
                    </div>
                    <div class="col-span-2 ml-10 lg:ml-32">
                        <section class="hidden steps step-2" id="step-2">
                            <div class="flex-col p-2">
                                <div class="grid grid-cols-1 gap-2 md:grid-cols-3">
                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label" for="charge_first_name">
                                                <span class="label-text">Primer nombre *</span>
                                            </label>
                                            <input id="charge_first_name" name="charge_first_name" required
                                                class="w-full shadow-sm input" type="text"
                                                value="{{ old('charge_first_name', $inCharge->charge_first_name ?? '') }}">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="mb-0 font-bold label " for="charge_second_name">
                                            <span class="label-text">
                                                Segundo nombre
                                            </span>
                                        </label>
                                        <input id="charge_second_name" name="charge_second_name"
                                            class="w-full shadow-sm input" type="text"
                                            value="{{ old('charge_second_name', $inCharge->charge_second_name ?? '') }}">
                                    </div>
                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="charge_first_lastname">
                                                <span class="label-text">
                                                    Primer Apellido *
                                                </span>
                                            </label>
                                            <input id="charge_first_lastname" name="charge_first_lastname"
                                                class="w-full shadow-sm input" type="text"
                                                value="{{ old('charge_first_lastname', $inCharge->charge_first_lastname ?? '') }}"
                                                required>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="mb-0 font-bold label " for="charge_second_lastname">
                                            <span class="label-text">
                                                Segundo apellido
                                            </span>
                                        </label>
                                        <input id="charge_second_lastname" name="charge_second_lastname"
                                            class="w-full shadow-sm input" type="text"
                                            value="{{ old('charge_second_lastname', $inCharge->charge_second_lastname ?? '') }}">
                                    </div>
                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="charge_dpi">
                                                <span class="label-text">
                                                    DPI *
                                                </span>
                                            </label>
                                            <input id="charge_dpi" name="charge_dpi" class="w-full shadow-sm input"
                                                type="text" placeholder="XXXX XXXXX XXXX" required maxlength="13"
                                                pattern="\d{13}"
                                                value="{{ old('charge_dpi', $inCharge->charge_dpi ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="charge_phone">
                                                <span class="label-text">
                                                    Teléfono *
                                                </span>
                                            </label>
                                            <input id="charge_phone" name="charge_phone" class="w-full shadow-sm input"
                                                type="number" maxlength="8"
                                                value="{{ old('charge_phone', $inCharge->charge_phone ?? '') }}" required>
                                        </div>
                                    </div>
                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="charge_address">
                                                <span class="label-text">
                                                    Direccion *
                                                </span>
                                            </label>
                                            <input id="charge_address" name="charge_address" required
                                                class="w-full shadow-sm input" type="text"
                                                value="{{ old('charge_address', $inCharge->charge_address ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="group">
                                        <div class="form-control">
                                            <label class="mb-0 font-bold label" for="charge_relationship">
                                                <span class="label-text">Parentesco *</span>
                                            </label>
                                            <select name="charge_relationship" class="w-full shadow-sm select parentesco"
                                                onchange="toggleComentario(this)" required>
                                                <option value="">Seleccionar una opción</option>
                                                @foreach ($familiares as $familiar)
                                                    <option value="{{ $familiar }}"
                                                        {{ old('charge_relationship', $inCharge->charge_relationship ?? '') == $familiar ? 'selected' : '' }}>
                                                        {{ $familiar }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="group charge_comment" style="display: none;">
                                        <label class="mb-0 font-bold label" for="charge_comment">
                                            <span class="label-text">Especifique *</span>
                                        </label>
                                        <input name="charge_comment" class="w-full shadow-sm input" type="text"
                                            value="{{ old('charge_comment', $inCharge->charge_comment ?? '') }}">
                                    </div>
                                </div>
                                <div class="group">
                                    <button class="justify-start mt-2 text-white btn bg-neutral prev-btn" type="button"
                                        data-prev-step="step-1">
                                        Anterior
                                    </button> <button class="justify-start mt-2 text-white btn bg-success next-btn"
                                        type="button" data-next-step="step-3">
                                        Siguiente
                                    </button>
                                </div>
                            </div>
                        </section>
                        </section>
                    </div>

                    {{-- SEGUNDO ENCARGADO --}}

                    <div class="ms-6">
                        <span
                            class="absolute flex items-center justify-center w-8 rounded-full bg-neutral-content -start-4">
                            <i class="fa-solid fa-house-user"></i>
                        </span>
                        <h3 class="font-medium leading-tight">DATOS DEL ENCARGADO</h3>
                    </div>
                    <div class="col-span-2 ml-10 lg:ml-32">
                        <section class="hidden steps step-3" id="step-3">
                            <div class="flex-col p-2">
                                <div class="grid grid-cols-1 gap-2 md:grid-cols-3">
                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="charge_first_name_2">
                                                <span class="label-text">
                                                    Primer nombre
                                                </span>
                                            </label>
                                            <input id="charge_first_name_2" name="charge_first_name_2"
                                                class="w-full shadow-sm input" type="text"
                                                value="{{ old('charge_first_name_2', $inCharge->charge_first_name_2 ?? '') }}">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="mb-0 font-bold label " for="charge_second_name_2">
                                            <span class="label-text">
                                                Segundo nombre
                                            </span>
                                        </label>
                                        <input id="charge_second_name_2" name="charge_second_name_2"
                                            class="w-full shadow-sm input" type="text"
                                            value="{{ old('charge_second_name_2', $inCharge->charge_second_name_2 ?? '') }}">
                                    </div>
                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="charge_first_lastname_2">
                                                <span class="label-text">
                                                    Primer Apellido
                                                </span>
                                            </label>
                                            <input id="charge_first_lastname_2" name="charge_first_lastname_2"
                                                class="w-full shadow-sm input" type="text"
                                                value="{{ old('charge_first_lastname_2', $inCharge->charge_first_lastname_2 ?? '') }}">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="mb-0 font-bold label " for="charge_second_lastname_2">
                                            <span class="label-text">
                                                Segundo apellido
                                            </span>
                                        </label>
                                        <input id="charge_second_lastname_2" name="charge_second_lastname_2"
                                            class="w-full shadow-sm input" type="text"
                                            value="{{ old('charge_second_lastname_2', $inCharge->charge_second_lastname_2 ?? '') }}">
                                    </div>
                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="charge_dpi_2">
                                                <span class="label-text">
                                                    DPI
                                                </span>
                                            </label>
                                            <input id="charge_dpi_2" name="charge_dpi_2" class="w-full shadow-sm input"
                                                type="text" placeholder="XXXX XXXXX XXXX"
                                                value="{{ old('charge_dpi_2', $inCharge->charge_dpi_2 ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="charge_phone_2">
                                                <span class="label-text">
                                                    Teléfono
                                                </span>
                                            </label>
                                            <input id="charge_phone_2" name="charge_phone_2"
                                                class="w-full shadow-sm input" type="number" maxlength="8"
                                                value="{{ old('charge_phone_2', $inCharge->charge_phone_2 ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="charge_address_2">
                                                <span class="label-text">
                                                    Direccion
                                                </span>
                                            </label>
                                            <input id="charge_address_2" name="charge_address_2"
                                                class="w-full shadow-sm input" type="text"
                                                value="{{ old('charge_address_2', $inCharge->charge_address_2 ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="group">
                                        <div class="form-control">
                                            <label class="mb-0 font-bold label" for="charge_relationship_2">
                                                <span class="label-text">Parentesco</span>
                                            </label>
                                            <select name="charge_relationship_2"
                                                class="w-full shadow-sm select parentesco"
                                                onchange="toggleComentario(this)">
                                                <option value="">Seleccionar una opción</option>
                                                @foreach ($familiares as $familiar)
                                                    <option value="{{ $familiar }}"
                                                        {{ old('charge_relationship_2', $inCharge->charge_relationship_2 ?? '') == $familiar ? 'selected' : '' }}>
                                                        {{ $familiar }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="group charge_comment_2" style="display: none;">
                                        <label class="mb-0 font-bold label" for="charge_comment_2">
                                            <span class="label-text">Especifique *</span>
                                        </label>
                                        <input name="charge_comment_2" class="w-full shadow-sm input" type="text"
                                            value="{{ old('charge_comment_2', $inCharge->charge_comment_2 ?? '') }}">
                                    </div>
                                </div>
                                <div class="group">
                                    <button class="justify-start mt-2 text-white btn bg-neutral prev-btn" type="button"
                                        data-prev-step="step-2">
                                        Anterior
                                    </button> <button class="justify-start mt-2 text-white btn bg-success next-btn"
                                        type="button" data-next-step="step-4">
                                        Siguiente
                                    </button>
                                </div>
                            </div>
                        </section>
                        </section>
                    </div>

                    {{-- TERCER ENCARGADO --}}

                    <div class="ms-6">
                        <span
                            class="absolute flex items-center justify-center w-8 rounded-full bg-neutral-content -start-4">
                            <i class="fa-solid fa-house-user"></i>
                        </span>
                        <h3 class="font-medium leading-tight">OTROS</h3>
                    </div>
                    <div class="col-span-2 ml-10 lg:ml-32">
                        <section class="hidden steps step-4" id="step-4">
                            <div class="flex-col p-2">
                                <div class="grid grid-cols-1 gap-2 md:grid-cols-3">
                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="charge_first_name_3">
                                                <span class="label-text">
                                                    Primer nombre
                                                </span>
                                            </label>
                                            <input id="charge_first_name_3" name="charge_first_name_3"
                                                class="w-full shadow-sm input" type="text"
                                                value="{{ old('charge_first_name_3', $inCharge->charge_first_name_3 ?? '') }}">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="mb-0 font-bold label " for="charge_second_name_3">
                                            <span class="label-text">
                                                Segundo nombre
                                            </span>
                                        </label>
                                        <input id="charge_second_name_3" name="charge_second_name_3"
                                            class="w-full shadow-sm input" type="text"
                                            value="{{ old('charge_second_name_3', $inCharge->charge_second_name_3 ?? '') }}">
                                    </div>
                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="charge_first_lastname_3">
                                                <span class="label-text">
                                                    Primer Apellido
                                                </span>
                                            </label>
                                            <input id="charge_first_lastname_3" name="charge_first_lastname_3"
                                                class="w-full shadow-sm input" type="text"
                                                value="{{ old('charge_first_lastname_3', $inCharge->charge_first_lastname_3 ?? '') }}">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="mb-0 font-bold label " for="charge_second_lastname_3">
                                            <span class="label-text">
                                                Segundo apellido
                                            </span>
                                        </label>
                                        <input id="charge_second_lastname_3" name="charge_second_lastname_3"
                                            class="w-full shadow-sm input" type="text"
                                            value="{{ old('charge_second_lastname_3', $inCharge->charge_second_lastname_3 ?? '') }}">
                                    </div>
                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="charge_dpi_3">
                                                <span class="label-text">
                                                    DPI
                                                </span>
                                            </label>
                                            <input id="charge_dpi_3" name="charge_dpi_3" class="w-full shadow-sm input"
                                                type="text" placeholder="XXXX XXXXX XXXX"
                                                value="{{ old('charge_dpi_3', $inCharge->charge_dpi_3 ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="charge_phone_3">
                                                <span class="label-text">
                                                    Teléfono
                                                </span>
                                            </label>
                                            <input id="charge_phone_3" name="charge_phone_3"
                                                class="w-full shadow-sm input" type="number" min="10000000"
                                                max="99999999"
                                                value="{{ old('charge_phone_3', $inCharge->charge_phone_3 ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="charge_address_3">
                                                <span class="label-text">
                                                    Direccion
                                                </span>
                                            </label>
                                            <input id="charge_address_3" name="charge_address_3"
                                                class="w-full shadow-sm input" type="text"
                                                value="{{ old('charge_address_3', $inCharge->charge_address_3 ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="group">
                                        <div class="form-control">
                                            <label class="mb-0 font-bold label" for="charge_relationship_3">
                                                <span class="label-text">Parentesco</span>
                                            </label>
                                            <select name="charge_relationship_3"
                                                class="w-full shadow-sm select parentesco"
                                                onchange="toggleComentario(this)">
                                                <option value="">Seleccionar una opción</option>
                                                @foreach ($familiares as $familiar)
                                                    <option value="{{ $familiar }}"
                                                        {{ old('charge_relationship_3', $inCharge->charge_relationship_3 ?? '') == $familiar ? 'selected' : '' }}>
                                                        {{ $familiar }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="group charge_comment_3" style="display: none;">
                                        <label class="mb-0 font-bold label" for="charge_comment_3">
                                            <span class="label-text">Especifique *</span>
                                        </label>
                                        <input name="charge_comment_3" class="w-full shadow-sm input" type="text"
                                            value="{{ old('charge_comment_3', $inCharge->charge_comment_3 ?? '') }}">
                                    </div>
                                </div>
                                <div class="group">
                                    <x-button-link href="/student" class="mt-2 text-white bg-cyan-700">
                                        Cancelar
                                    </x-button-link>

                                    <button class="justify-start mt-2 text-white btn bg-neutral prev-btn" type="button"
                                        data-prev-step="step-3">
                                        Anterior
                                    </button>
                                    <button class="justify-start mt-2 text-white btn bg-success" type="submit">
                                        Enviar
                                    </button>
                                </div>
                            </div>
                        </section>
                    </div>
                </ol>
            </form>
            <x-alert-message />
        </div>

        <style>
            .hidden {
                display: none;
            }
        </style>
        <script></script>
    @endsection

    <script src="{{ asset('js/reloadPage.js') }}"></script>
    <script src="{{ asset('js/student/editStudent.js') }}"></script>

