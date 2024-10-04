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
            <form action="{{ url('student/newStudent') }}" method="POST" enctype="multipart/form-data">
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
                                            <input id="first_name" name="first_name" required class="w-full shadow-sm input" type="text" value="">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="mb-0 font-bold label " for="second_name">
                                            <span class="label-text">
                                                Segundo nombre
                                            </span>

                                        </label>
                                        <input id="second_name" name="second_name"
                                            class="w-full shadow-sm input" type="text" value="">
                                    </div>
                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="first_lastname">
                                                <span class="label-text">
                                                    Primer Apellido *
                                                </span>

                                            </label>
                                            <input id="first_lastname" name="first_lastname"
                                                required="" class="w-full shadow-sm input" type="text" value="">
                                        </div>
                                        <span class="text-error" id="error_primer_apellido_cliente"></span>
                                    </div>
                                    <div>
                                        <label class="mb-0 font-bold label " for="second_lastname">
                                            <span class="label-text">
                                                Segundo apellido
                                            </span>

                                        </label>
                                        <input id="second_lastname" name="second_lastname"
                                            class="w-full shadow-sm input" type="text" value="">
                                    </div>

                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label" for="personal_code">
                                                <span class="label-text">
                                                    Código Personal *
                                                </span>
                                            </label>
                                            <input id="personal_code" name="personal_code" required
                                                class="w-full shadow-sm input" type="text"
                                                pattern="^\d{13}$" placeholder="Ingrese el número de documento"
                                                value="{{ old('personal_code') }}">
                                        </div>
                                        @error('personal_code')
                                            <span class="text-error" id="error_codigo_personal">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="birthdate">
                                                <span class="label-text">
                                                    Fecha de nacimiento *
                                                </span>

                                            </label>
                                            <input id="birthdate" name="birthdate" required=""
                                                class="w-full shadow-sm input" type="date" value="">
                                        </div>
                                        <span class="text-error" id="error_fecha_nacimiento"></span>
                                    </div>


                                    <div class="group">
                                        <div class="form-control">
                                            <label class="mb-0 font-bold label " for="gender">
                                                <span class="label-text">
                                                    Género *
                                                </span>

                                            </label>
                                            <select id="gender" name="gender" value=""
                                                class="w-full shadow-sm select">
                                                <option value="">Seleccionar una opción</option>
                                                <option value="MASCULINO">Masculino</option>
                                                <option value="FEMENINO">Femenino</option>
                                            </select>
                                        </div>
                                        <span class="text-error" id="error_genero"></span>
                                    </div>
                                    <div class="group">
                                        <div class="form-control">
                                            <label class="mb-0 font-bold label " for="town_ethnicity">
                                                <span class="label-text">
                                                    Pueblo/Etnia *
                                                </span>

                                            </label>
                                            <select id="town_ethnicity" name="town_ethnicity" value=""
                                                class="w-full shadow-sm select" type="text">
                                                <option value="">Seleccionar una opción</option>
                                                <!--[if BLOCK]><![endif]-->
                                                <option value="MAYA">maya</option>
                                                <option value="XINKA">Xinca</option>
                                                <option value="GARIFUNA">Garifuna</option>
                                                <option value="LADINO">Ladino</option>
                                                <!--[if ENDBLOCK]><![endif]-->
                                            </select>
                                        </div>
                                        <span class="text-error" id="error_estado_civil"></span>
                                    </div>
                                </div>
                                <div class="group">
                                    <!--[if BLOCK]><![endif]--> <button
                                        class="justify-start mt-2 text-white btn bg-success next-btn" type="button"
                                        data-next-step="step-2">
                                        Siguiente
                                    </button>
                                    <!--[if ENDBLOCK]><![endif]-->
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
                        <h3 class="font-medium leading-tight">DATOS DEL ENCARGADO</h3>
                    </div>
                    <div class="col-span-2 ml-10 lg:ml-32">
                        <section class="hidden steps step-2" id="step-2">
                            <div class="flex-col p-2">
                                <div class="grid grid-cols-1 gap-2 md:grid-cols-3">

                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="charge_first_name">
                                                <span class="label-text">
                                                    Primer nombre *
                                                </span>

                                            </label>
                                            <input id="charge_first_name" name="charge_first_name" required=""
                                                class="w-full shadow-sm input" type="text" value="">
                                        </div>
                                        <span class="text-error" id="error_primer_nombre_cliente"></span>
                                    </div>
                                    <div>
                                        <label class="mb-0 font-bold label " for="charge_second_name">
                                            <span class="label-text">
                                                Segundo nombre
                                            </span>

                                        </label>
                                        <input id="charge_second_name" name="charge_second_name"
                                            class="w-full shadow-sm input" type="text" value="">
                                    </div>
                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="charge_first_lastname">
                                                <span class="label-text">
                                                    Primer Apellido *
                                                </span>

                                            </label>
                                            <input id="charge_first_lastname" name="charge_first_lastname"
                                                required="" class="w-full shadow-sm input" type="text"
                                                value="">
                                        </div>
                                        <span class="text-error" id="error_primer_apellido_cliente"></span>
                                    </div>
                                    <div>
                                        <label class="mb-0 font-bold label " for="charge_second_lastname">
                                            <span class="label-text">
                                                Segundo apellido
                                            </span>

                                        </label>
                                        <input id="charge_second_lastname" name="charge_second_lastname"
                                            class="w-full shadow-sm input" type="text" value="">
                                    </div>

                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="charge_dpi">
                                                <span class="label-text">
                                                    DPI *
                                                </span>

                                            </label>
                                            <input id="charge_dpi" name="charge_dpi" required=""
                                                class="w-full shadow-sm input" type="text"
                                                placeholder="Ingrese el número de documento" value="">
                                        </div>
                                        <span class="text-error" id="error_dpi_cliente"></span>
                                    </div>

                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="charge_phone">
                                                <span class="label-text">
                                                    Teléfono *
                                                </span>

                                            </label>
                                            <input id="charge_phone" name="charge_phone" required=""
                                                class="w-full shadow-sm input" type="number" min="10000000"
                                                max="99999999" value="">
                                        </div>
                                        <span class="text-error" id="error_telefono"></span>

                                    </div>
                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="charge_address">
                                                <span class="label-text">
                                                    Direccion *
                                                </span>

                                            </label>
                                            <input id="charge_address" name="charge_address" required=""
                                                class="w-full shadow-sm input" type="text" value="">
                                        </div>
                                        <span class="text-error" id="error_referencia_casa"></span>
                                    </div>
                                    <div class="group">
                                        <div class="form-control">
                                            <label class="mb-0 font-bold label" for="charge_relationship">
                                                <span class="label-text">Parentesco *</span>
                                            </label>
                                            <select name="charge_relationship"class="w-full shadow-sm select parentesco"
                                                onchange="toggleComentario(this)">
                                                <option value="">Seleccionar una opción</option>
                                                <option value="ABUELA">abuela</option>
                                                <option value="ABUELO">abuelo</option>
                                                <option value="AMIGO">amigo</option>
                                                <option value="CUÑADA">cuñada</option>
                                                <option value="CUÑADO">cuñado</option>
                                                <option value="ESPOSA">esposa</option>
                                                <option value="ESPOSO">esposo</option>
                                                <option value="HERMANA">hermana</option>
                                                <option value="HERMANO">hermano</option>
                                                <option value="HIJA">hija</option>
                                                <option value="HIJO">hijo</option>
                                                <option value="MADRE">madre</option>
                                                <option value="NINGUNO">ninguno</option>
                                                <option value="PADRE">padre</option>
                                                <option value="PRIMA">prima</option>
                                                <option value="PRIMO">primo</option>
                                                <option value="SUEGRA">suegra</option>
                                                <option value="SUEGRO">suegro</option>
                                                <option value="TIA">tia</option>
                                                <option value="TIO">tio</option>
                                                <option value="OTROS">otros</option>
                                            </select>
                                        </div>
                                        <span class="text-error" id="error_parentesco"></span>
                                    </div>
                                    <div class="group charge_comment" style="display: none;">
                                        <label class="mb-0 font-bold label" for="charge_comment">
                                            <span class="label-text">Especifique *</span>
                                        </label>
                                        <input name="charge_comment" class="w-full shadow-sm input" type="text"
                                            value="">
                                    </div>

                                </div>
                                <div class="group">
                                    <button
                                        class="justify-start mt-2 text-white btn bg-neutral prev-btn" type="button"
                                        data-prev-step="step-1">
                                        Anterior
                                    </button> <button
                                    class="justify-start mt-2 text-white btn bg-success next-btn" type="button"
                                    data-next-step="step-3">
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
                                                    Primer nombre *
                                                </span>

                                            </label>
                                            <input id="charge_first_name_2" name="charge_first_name_2" required=""
                                                class="w-full shadow-sm input" type="text" value="">
                                        </div>
                                        <span class="text-error" id="error_charge_first_name_2"></span>
                                    </div>
                                    <div>
                                        <label class="mb-0 font-bold label " for="charge_second_name_2">
                                            <span class="label-text">
                                                Segundo nombre
                                            </span>

                                        </label>
                                        <input id="charge_second_name_2" name="charge_second_name_2"
                                            class="w-full shadow-sm input" type="text" value="">
                                    </div>
                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="charge_first_lastname_2">
                                                <span class="label-text">
                                                    Primer Apellido *
                                                </span>

                                            </label>
                                            <input id="charge_first_lastname_2" name="charge_first_lastname_2"
                                                required="" class="w-full shadow-sm input" type="text"
                                                value="">
                                        </div>
                                        <span class="text-error" id="error_charge_first_lastname_2"></span>
                                    </div>
                                    <div>
                                        <label class="mb-0 font-bold label " for="charge_second_lastname_2">
                                            <span class="label-text">
                                                Segundo apellido
                                            </span>

                                        </label>
                                        <input id="charge_second_lastname_2" name="charge_second_lastname_2"
                                            class="w-full shadow-sm input" type="text" value="">
                                    </div>

                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="charge_dpi_2">
                                                <span class="label-text">
                                                    DPI *
                                                </span>

                                            </label>
                                            <input id="charge_dpi_2" name="charge_dpi_2" required=""
                                                class="w-full shadow-sm input" type="text"
                                                placeholder="Ingrese el número de documento" value="">
                                        </div>
                                        <span class="text-error" id="error_charge_dpi_2"></span>
                                    </div>

                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="charge_phone_2">
                                                <span class="label-text">
                                                    Teléfono *
                                                </span>

                                            </label>
                                            <input id="charge_phone_2" name="charge_phone_2" required=""
                                                class="w-full shadow-sm input" type="number" min="10000000"
                                                max="99999999" value="">
                                        </div>
                                        <span class="text-error" id="error_telefono"></span>

                                    </div>
                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="charge_address_2">
                                                <span class="label-text">
                                                    Direccion *
                                                </span>

                                            </label>
                                            <input id="charge_address_2" name="charge_address_2" required=""
                                                class="w-full shadow-sm input" type="text" value="">
                                        </div>
                                        <span class="text-error" id="error_charge_address_2"></span>
                                    </div>
                                    <div class="group">
                                        <div class="form-control">
                                            <label class="mb-0 font-bold label" for="charge_relationship_2">
                                                <span class="label-text">Parentesco *</span>
                                            </label>
                                            <select name="charge_relationship_2"class="w-full shadow-sm select parentesco"
                                                onchange="toggleComentario(this)">
                                                <option value="">Seleccionar una opción</option>
                                                <option value="ABUELA">abuela</option>
                                                <option value="ABUELO">abuelo</option>
                                                <option value="AMIGO">amigo</option>
                                                <option value="CUÑADA">cuñada</option>
                                                <option value="CUÑADO">cuñado</option>
                                                <option value="HERMANA">hermana</option>
                                                <option value="HERMANO">hermano</option>
                                                <option value="HIJA">hija</option>
                                                <option value="HIJO">hijo</option>
                                                <option value="MADRE">madre</option>
                                                <option value="PADRE">padre</option>
                                                <option value="PRIMA">prima</option>
                                                <option value="PRIMO">primo</option>
                                                <option value="TIA">tia</option>
                                                <option value="TIO">tio</option>
                                                <option value="OTROS">otros</option>
                                            </select>
                                        </div>
                                        <span class="text-error" id="error_charge_relationship_2"></span>
                                    </div>
                                    <div class="group charge_comment_2" style="display: none;">
                                        <label class="mb-0 font-bold label" for="charge_comment_2">
                                            <span class="label-text">Especifique *</span>
                                        </label>
                                        <input name="charge_comment_2" class="w-full shadow-sm input" type="text"
                                            value="">
                                    </div>

                                </div>
                                <div class="group">
                                    <button
                                        class="justify-start mt-2 text-white btn bg-neutral prev-btn" type="button"
                                        data-prev-step="step-2">
                                        Anterior
                                    </button> <button
                                    class="justify-start mt-2 text-white btn bg-success next-btn" type="button"
                                    data-next-step="step-4">
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
                        <h3 class="font-medium leading-tight">DATOS DEL ENCARGADO</h3>
                    </div>
                    <div class="col-span-2 ml-10 lg:ml-32">
                        <section class="hidden steps step-4" id="step-4">
                            <div class="flex-col p-2">
                                <div class="grid grid-cols-1 gap-2 md:grid-cols-3">

                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="charge_first_name_3">
                                                <span class="label-text">
                                                    Primer nombre *
                                                </span>

                                            </label>
                                            <input id="charge_first_name_3" name="charge_first_name_3"
                                                class="w-full shadow-sm input" type="text" value="">
                                        </div>
                                        <span class="text-error" id="error_charge_first_name_3"></span>
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
                                        <div>
                                            <label class="mb-0 font-bold label " for="charge_first_lastname_3">
                                                <span class="label-text">
                                                    Primer Apellido *
                                                </span>

                                            </label>
                                            <input id="charge_first_lastname_3" name="charge_first_lastname_3"
                                                class="w-full shadow-sm input" type="text"
                                                value="">
                                        </div>
                                        <span class="text-error" id="error_charge_first_lastname_3"></span>
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
                                        <div>
                                            <label class="mb-0 font-bold label " for="charge_dpi_3">
                                                <span class="label-text">
                                                    DPI *
                                                </span>

                                            </label>
                                            <input id="charge_dpi_3" name="charge_dpi_3"
                                                class="w-full shadow-sm input" type="text"
                                                placeholder="Ingrese el número de documento" value="">
                                        </div>
                                        <span class="text-error" id="error_charge_dpi_3"></span>
                                    </div>

                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="charge_phone_3">
                                                <span class="label-text">
                                                    Teléfono *
                                                </span>

                                            </label>
                                            <input id="charge_phone_3" name="charge_phone_3"
                                                class="w-full shadow-sm input" type="number" min="10000000"
                                                max="99999999" value="">
                                        </div>
                                        <span class="text-error" id="error_charge_phone_3"></span>

                                    </div>
                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="charge_address_3">
                                                <span class="label-text">
                                                    Direccion *
                                                </span>

                                            </label>
                                            <input id="charge_address_3" name="charge_address_3"
                                                class="w-full shadow-sm input" type="text" value="">
                                        </div>
                                        <span class="text-error" id="error_charge_address_3"></span>
                                    </div>
                                    <div class="group">
                                        <div class="form-control">
                                            <label class="mb-0 font-bold label" for="charge_relationship_3">
                                                <span class="label-text">Parentesco *</span>
                                            </label>
                                            <select name="charge_relationship_3"class="w-full shadow-sm select parentesco"
                                                onchange="toggleComentario(this)">
                                                <option value="">Seleccionar una opción</option>
                                                <option value="ABUELA">abuela</option>
                                                <option value="ABUELO">abuelo</option>
                                                <option value="AMIGO">amigo</option>
                                                <option value="CUÑADA">cuñada</option>
                                                <option value="CUÑADO">cuñado</option>
                                                <option value="ESPOSA">esposa</option>
                                                <option value="ESPOSO">esposo</option>
                                                <option value="HERMANA">hermana</option>
                                                <option value="HERMANO">hermano</option>
                                                <option value="HIJA">hija</option>
                                                <option value="HIJO">hijo</option>
                                                <option value="MADRE">madre</option>
                                                <option value="NINGUNO">ninguno</option>
                                                <option value="PADRE">padre</option>
                                                <option value="PRIMA">prima</option>
                                                <option value="PRIMO">primo</option>
                                                <option value="SUEGRA">suegra</option>
                                                <option value="SUEGRO">suegro</option>
                                                <option value="TIA">tia</option>
                                                <option value="TIO">tio</option>
                                                <option value="OTROS">otros</option>
                                            </select>
                                        </div>
                                        <span class="text-error" id="error_charge_relationship_3"></span>
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
                                    <button
                                        class="justify-start mt-2 text-white btn bg-neutral prev-btn" type="button"
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
        </div>

        <style>
            .hidden {
                display: none;
            }
        </style>
        <script></script>
    @endsection

    <script src="{{ asset('js/reloadPage.js') }}"></script>
    <script src="{{ asset('js/student/formCreate.js') }}"></script>
