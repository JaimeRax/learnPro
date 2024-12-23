@extends('layouts.base')

@section('header')
    <x-route route="/" previousRouteName="INICIO" currentRouteName="INSCRIPCIÓN DE ESTUDIANTES" />
@endsection


@section('main')
    <div class="flex justify-end col-md-2">
        <x-button-link href="/student" class="mt-2 text-white bg-orange-400">
            <x-iconos.volver /> Volver
        </x-button-link>
    </div>

    <div class="grid grid-cols-1 gap-2 mt-8">
        <div class="container-sm">
            <form action="{{ url('student/newStudent') }}" method="POST" enctype="multipart/form-data" id="studentForm">
                @csrf

                <ol class="relative text-gray-500 border-gray-200 border-s dark:border-gray-700 dark:text-gray-400">

                    {{-- DATOS ESTUDIANTE --}}
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
                                        <label class="mb-0 font-bold label " for="first_name">
                                            <span class="label-text">
                                                Primer nombre *
                                            </span>
                                        </label>
                                        <input id="first_name" required name="first_name" class="w-full shadow-sm input"
                                            type="text" value="{{ old('first_name') }}">
                                        <div id="first_name_error" class="text-red-500 text-sm error-message"
                                            style="display:none;">Este campo es
                                            obligatorio.</div>
                                    </div>
                                    <div>
                                        <label class="mb-0 font-bold label " for="second_name">
                                            <span class="label-text">
                                                Segundo nombre
                                            </span>
                                        </label>
                                        <input id="second_name" name="second_name" class="w-full shadow-sm input"
                                            type="text" value="{{ old('second_name') }}">
                                    </div>
                                    <div class="group">
                                        <label class="mb-0 font-bold label " for="first_lastname">
                                            <span class="label-text">
                                                Primer Apellido *
                                            </span>
                                        </label>
                                        <input id="first_lastname" required name="first_lastname"
                                            class="w-full shadow-sm input" type="text"
                                            value="{{ old('first_lastname') }}">
                                        <div id="first_lastname_error" class="text-red-500 text-sm error-message"
                                            style="display:none;">Este
                                            campo es
                                            obligatorio.</div>
                                    </div>
                                    <div>
                                        <label class="mb-0 font-bold label " for="second_lastname">
                                            <span class="label-text">
                                                Segundo apellido
                                            </span>
                                        </label>
                                        <input id="second_lastname" name="second_lastname" class="w-full shadow-sm input"
                                            type="text" value="{{ old('second_lastname') }}">
                                    </div>
                                    <div class="group">
                                        <label class="mb-0 font-bold label" for="personal_code">
                                            <span class="label-text">
                                                Código Personal *
                                            </span>
                                        </label>
                                        <input id="personal_code" required name="personal_code"
                                            class="w-full shadow-sm input" type="text"
                                            value="{{ old('personal_code') }}">
                                        <div id="personal_code_error" class="text-red-500 text-sm error-message"
                                            style="display:none;">Este campo
                                            es
                                            obligatorio.</div>
                                    </div>
                                    <div class="group">
                                        <label class="mb-0 font-bold label " for="birthdate">
                                            <span class="label-text">
                                                Fecha de nacimiento *
                                            </span>
                                        </label>
                                        <input id="birthdate" required name="birthdate" class="w-full shadow-sm input"
                                            type="date" value="{{ old('birthdate') }}">
                                        <div id="birthdate_error" class="text-red-500 text-sm error-message"
                                            style="display:none;">Este campo es
                                            obligatorio.</div>
                                    </div>
                                    <div class="group">
                                        <label class="mb-0 font-bold label " for="gender">
                                            <span class="label-text">
                                                Género *
                                            </span>
                                        </label>
                                        <select id="gender" name="gender" value="{{ old('gender') }}" required
                                            class="w-full shadow-sm select">
                                            <option value="">Seleccionar una opción</option>
                                            <option value="MASCULINO">Masculino</option>
                                            <option value="FEMENINO">Femenino</option>
                                        </select>
                                        <div id="gender_error" class="text-red-500 text-sm error-message"
                                            style="display:none;">Este campo es
                                            obligatorio.</div>
                                    </div>
                                    <div class="group">
                                        <label class="mb-0 font-bold label " for="town_ethnicity">
                                            <span class="label-text">
                                                Pueblo/Etnia *
                                            </span>
                                        </label>
                                        <select id="town_ethnicity" name="town_ethnicity"
                                            value="{{ old('town_ethnicity') }}" class="w-full shadow-sm select"
                                            type="text" required>
                                            <option value="">Seleccionar una opción</option>
                                            <option value="MAYA">maya</option>
                                            <option value="XINKA">Xinca</option>
                                            <option value="GARIFUNA">Garifuna</option>
                                            <option value="LADINO">Ladino</option>
                                        </select>
                                        <div id="town_ethnicity_error" class="text-red-500 text-sm error-message"
                                            style="display:none;">Este
                                            campo
                                            es
                                            obligatorio.</div>
                                    </div>
                                </div>
                                <div class="group">
                                    <button class="justify-start mt-2 text-white btn bg-success next-btn" type="button"
                                        data-next-step="step-2" onclick="validateSection(1)">
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
                                        <label class="mb-0 font-bold label " for="charge_first_name">
                                            <span class="label-text">
                                                Primer nombre *
                                            </span>
                                        </label>
                                        <input id="charge_first_name" name="charge_first_name" required
                                            class="w-full shadow-sm input" type="text"
                                            value="{{ old('charge_first_name') }}">
                                        <div id="first_name_charge_error" class="text-red-500 text-sm error-message"
                                            style="display:none;">Este campo es
                                            obligatorio.</div>
                                    </div>
                                    <div>
                                        <label class="mb-0 font-bold label " for="charge_second_name">
                                            <span class="label-text">
                                                Segundo nombre
                                            </span>
                                        </label>
                                        <input id="charge_second_name" name="charge_second_name"
                                            class="w-full shadow-sm input" type="text"
                                            value="{{ old('charge_second_name') }}">
                                    </div>
                                    <div class="group">
                                        <label class="mb-0 font-bold label " for="charge_first_lastname">
                                            <span class="label-text">
                                                Primer Apellido *
                                            </span>
                                        </label>
                                        <input id="charge_first_lastname" name="charge_first_lastname"
                                            class="w-full shadow-sm input" type="text"
                                            value="{{ old('charge_first_lastname') }}" required>
                                        <div id="first_lastname_charge_error" class="text-red-500 text-sm error-message"
                                            style="display:none;">Este campo es
                                            obligatorio.</div>
                                    </div>
                                    <div>
                                        <label class="mb-0 font-bold label " for="charge_second_lastname">
                                            <span class="label-text">
                                                Segundo apellido
                                            </span>
                                        </label>
                                        <input id="charge_second_lastname" name="charge_second_lastname"
                                            class="w-full shadow-sm input" type="text"
                                            value="{{ old('charge_second_lastname') }}">
                                    </div>
                                    <div class="group">
                                        <label class="mb-0 font-bold label " for="charge_dpi">
                                            <span class="label-text">
                                                DPI *
                                            </span>
                                        </label>
                                        <input id="charge_dpi" name="charge_dpi" class="w-full shadow-sm input"
                                            type="text" placeholder="XXXX XXXXX XXXX" required maxlength="13"
                                            pattern="\d{13}" value="{{ old('charge_dpi') }}">
                                        <div id="dpi_charge_error" class="text-red-500 text-sm error-message"
                                            style="display:none;">Este campo es
                                            obligatorio.</div>
                                    </div>
                                    <div class="group">
                                        <label class="mb-0 font-bold label " for="charge_phone">
                                            <span class="label-text">
                                                Teléfono *
                                            </span>
                                        </label>
                                        <input id="charge_phone" name="charge_phone" class="w-full shadow-sm input"
                                            type="number" maxlength="8" value="{{ old('charge_phone') }}" required>
                                        <div id="phone_charge_error" class="text-red-500 text-sm error-message"
                                            style="display:none;">Este campo es
                                            obligatorio.</div>
                                    </div>
                                    <div class="group">
                                        <label class="mb-0 font-bold label " for="charge_address">
                                            <span class="label-text">
                                                Direccion *
                                            </span>
                                        </label>
                                        <input id="charge_address" name="charge_address" required
                                            class="w-full shadow-sm input" type="text"
                                            value="{{ old('charge_address') }}">
                                        <div id="address_charge_error" class="text-red-500 text-sm error-message"
                                            style="display:none;">Este campo es
                                            obligatorio.</div>
                                    </div>
                                    <div class="group">
                                        <label class="mb-0 font-bold label" for="charge_relationship">
                                            <span class="label-text">Parentesco *</span>
                                        </label>
                                        <select name="charge_relationship" class="w-full shadow-sm select parentesco"
                                            onchange="toggleComentario(this)" required>
                                            <option value="">Seleccionar una opción</option>
                                            @foreach ($familiares as $familiar)
                                                <option value="{{ $familiar }}">{{ $familiar }}</option>
                                            @endforeach
                                        </select>
                                        <div id="relationship_charge_error" class="text-red-500 text-sm error-message"
                                            style="display:none;">Este campo es
                                            obligatorio.</div>
                                    </div>
                                    <div class="group charge_comment" style="display: none;">
                                        <label class="mb-0 font-bold label" for="charge_comment">
                                            <span class="label-text">Especifique *</span>
                                        </label>
                                        <input name="charge_comment" class="w-full shadow-sm input" type="text"
                                            value="{{ old('charge_comment') }}">
                                        <div id="comment_charge_error" class="text-red-500 text-sm error-message"
                                            style="display:none;">Este campo es
                                            obligatorio.</div>
                                    </div>
                                </div>
                                <div class="group">
                                    <button class="justify-start mt-2 text-white btn bg-neutral prev-btn" type="button"
                                        data-prev-step="step-1">
                                        Anterior
                                    </button>
                                    <button class="justify-start mt-2 text-white btn bg-success next-btn" type="button"
                                        data-next-step="step-3" onclick="validateSection(2)">
                                        Siguiente
                                    </button>
                                </div>
                            </div>
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
                                        <label class="mb-0 font-bold label " for="charge_first_name_2">
                                            <span class="label-text">
                                                Primer nombre
                                            </span>
                                        </label>
                                        <input id="charge_first_name_2" name="charge_first_name_2"
                                            class="w-full shadow-sm input" type="text"
                                            value="{{ old('charge_first_name_2') }}">
                                    </div>
                                    <div>
                                        <label class="mb-0 font-bold label " for="charge_second_name_2">
                                            <span class="label-text">
                                                Segundo nombre
                                            </span>
                                        </label>
                                        <input id="charge_second_name_2" name="charge_second_name_2"
                                            class="w-full shadow-sm input" type="text"
                                            value="{{ old('charge_second_name_2') }}">
                                    </div>
                                    <div class="group">
                                        <label class="mb-0 font-bold label " for="charge_first_lastname_2">
                                            <span class="label-text">
                                                Primer Apellido
                                            </span>
                                        </label>
                                        <input id="charge_first_lastname_2" name="charge_first_lastname_2"
                                            class="w-full shadow-sm input" type="text"
                                            value="{{ old('charge_first_lastname_2') }}">
                                    </div>
                                    <div>
                                        <label class="mb-0 font-bold label " for="charge_second_lastname_2">
                                            <span class="label-text">
                                                Segundo apellido
                                            </span>
                                        </label>
                                        <input id="charge_second_lastname_2" name="charge_second_lastname_2"
                                            class="w-full shadow-sm input" type="text"
                                            value="{{ old('charge_second_lastname_2') }}">
                                    </div>
                                    <div class="group">
                                        <label class="mb-0 font-bold label " for="charge_dpi_2">
                                            <span class="label-text">
                                                DPI
                                            </span>
                                        </label>
                                        <input id="charge_dpi_2" name="charge_dpi_2" class="w-full shadow-sm input"
                                            type="text" placeholder="XXXX XXXXX XXXX" maxlength="13" pattern="\d{13}"
                                            value="{{ old('charge_dpi_2') }}">
                                    </div>
                                    <div class="group">
                                        <label class="mb-0 font-bold label " for="charge_phone_2">
                                            <span class="label-text">
                                                Teléfono
                                            </span>
                                        </label>
                                        <input id="charge_phone_2" name="charge_phone_2" class="w-full shadow-sm input"
                                            type="number" maxlength="8" value="{{ old('charge_phone_2') }}">
                                    </div>
                                    <div class="group">
                                        <label class="mb-0 font-bold label " for="charge_address_2">
                                            <span class="label-text">
                                                Direccion
                                            </span>
                                        </label>
                                        <input id="charge_address_2" name="charge_address_2"
                                            class="w-full shadow-sm input" type="text"
                                            value="{{ old('charge_address_2') }}">
                                    </div>
                                    <div class="group">
                                        <label class="mb-0 font-bold label" for="charge_relationship_2">
                                            <span class="label-text">Parentesco</span>
                                        </label>
                                        <select name="charge_relationship_2"class="w-full shadow-sm select parentesco"
                                            onchange="toggleComentario(this)">
                                            <option value="">Seleccionar una opción</option>
                                            @foreach ($familiares as $familiar)
                                                <option value="{{ $familiar }}">{{ $familiar }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="group charge_comment_2" style="display: none;">
                                        <label class="mb-0 font-bold label" for="charge_comment_2">
                                            <span class="label-text">Especifique *</span>
                                        </label>
                                        <input name="charge_comment_2" class="w-full shadow-sm input" type="text"
                                            value="{{ old('charge_comment_2') }}">
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
                                        <label class="mb-0 font-bold label " for="charge_first_name_3">
                                            <span class="label-text">
                                                Primer nombre
                                            </span>
                                        </label>
                                        <input id="charge_first_name_3" name="charge_first_name_3"
                                            class="w-full shadow-sm input" type="text" value="">
                                    </div>
                                    <div>
                                        <label class="mb-0 font-bold label " for="charge_second_name_3">
                                            <span class="label-text">
                                                Segundo nombre
                                            </span>
                                        </label>
                                        <input id="charge_second_name_3" name="charge_second_name_3"
                                            class="w-full shadow-sm input" type="text" value="">
                                    </div>
                                    <div class="group">
                                        <label class="mb-0 font-bold label " for="charge_first_lastname_3">
                                            <span class="label-text">
                                                Primer Apellido
                                            </span>
                                        </label>
                                        <input id="charge_first_lastname_3" name="charge_first_lastname_3"
                                            class="w-full shadow-sm input" type="text" value="">
                                    </div>
                                    <div>
                                        <label class="mb-0 font-bold label " for="charge_second_lastname_3">
                                            <span class="label-text">
                                                Segundo apellido
                                            </span>
                                        </label>
                                        <input id="charge_second_lastname_3" name="charge_second_lastname_3"
                                            class="w-full shadow-sm input" type="text" value="">
                                    </div>
                                    <div class="group">
                                        <label class="mb-0 font-bold label " for="charge_dpi_3">
                                            <span class="label-text">
                                                DPI
                                            </span>
                                        </label>
                                        <input id="charge_dpi_3" name="charge_dpi_3" class="w-full shadow-sm input"
                                            type="text" placeholder="XXXX XXXXX XXXX" maxlength="13" pattern="\d{13}"
                                            value="">
                                    </div>
                                    <div class="group">
                                        <label class="mb-0 font-bold label " for="charge_phone_3">
                                            <span class="label-text">
                                                Teléfono
                                            </span>
                                        </label>
                                        <input id="charge_phone_3" name="charge_phone_3" class="w-full shadow-sm input"
                                            type="number" min="10000000" max="99999999" value="">
                                    </div>
                                    <div class="group">
                                        <label class="mb-0 font-bold label " for="charge_address_3">
                                            <span class="label-text">
                                                Direccion
                                            </span>
                                        </label>
                                        <input id="charge_address_3" name="charge_address_3"
                                            class="w-full shadow-sm input" type="text" value="">
                                    </div>
                                    <div class="group">
                                        <div class="form-control">
                                            <label class="mb-0 font-bold label" for="charge_relationship_3">
                                                <span class="label-text">Parentesco </span>
                                            </label>
                                            <select name="charge_relationship_3"class="w-full shadow-sm select parentesco"
                                                onchange="toggleComentario(this)">
                                                <option value="">Seleccionar una opción</option>
                                                @foreach ($familiares as $familiar)
                                                    <option value="{{ $familiar }}">{{ $familiar }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="group charge_comment_3" style="display: none;">
                                        <label class="mb-0 font-bold label" for="charge_comment_3">
                                            <span class="label-text">Especifique *</span>
                                        </label>
                                        <input name="charge_comment_3" class="w-full shadow-sm input" type="text"
                                            value="">
                                    </div>
                                </div>
                                <div class="group">
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
    </div>
@endsection

<script src="{{ asset('js/reloadPage.js') }}"></script>
<script src="{{ asset('js/student/formCreate.js') }}"></script>
