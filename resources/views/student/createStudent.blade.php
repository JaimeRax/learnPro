@extends('layouts.base')



@section('header')
    <route route="/" previousRouteName="Inicio" currentRouteName="degrees" />
@endsection


@section('main')
    <div class="grid grid-cols-1 gap-2">
        <div class="container-sm">
            <form id="financing-submit" action="#" method="post" enctype="multipart/form-data" novalidate>
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
                                            <label class="mb-0 font-bold label " for="primer_nombre_cliente">
                                                <span class="label-text">
                                                    Primer nombre *
                                                </span>

                                            </label>
                                            <input id="primer_nombre_cliente" name="primer_nombre_cliente" required=""
                                                class="w-full shadow-sm input" type="text" value="">
                                        </div>
                                        <span class="text-error" id="error_primer_nombre_cliente"></span>
                                    </div>
                                    <div>
                                        <label class="mb-0 font-bold label " for="segundo_nombre_cliente">
                                            <span class="label-text">
                                                Segundo nombre
                                            </span>

                                        </label>
                                        <input id="segundo_nombre_cliente" name="segundo_nombre_cliente"
                                            class="w-full shadow-sm input" type="text" value="">
                                    </div>
                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="primer_apellido_cliente">
                                                <span class="label-text">
                                                    Primer Apellido *
                                                </span>

                                            </label>
                                            <input id="primer_apellido_cliente" name="primer_apellido_cliente"
                                                required="" class="w-full shadow-sm input" type="text" value="">
                                        </div>
                                        <span class="text-error" id="error_primer_apellido_cliente"></span>
                                    </div>
                                    <div>
                                        <label class="mb-0 font-bold label " for="segundo_apellido_cliente">
                                            <span class="label-text">
                                                Segundo apellido
                                            </span>

                                        </label>
                                        <input id="segundo_apellido_cliente" name="segundo_apellido_cliente"
                                            class="w-full shadow-sm input" type="text" value="">
                                    </div>

                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="codigo_personal">
                                                <span class="label-text">
                                                    Codigo Personal *
                                                </span>

                                            </label>
                                            <input id="codigo_personal" name="codigo_personal" required=""
                                                class="w-full shadow-sm input" type="text" minlength="13" maxlength="13"
                                                pattern="^\d{13}$" placeholder="Ingrese el número de documento"
                                                value="">
                                        </div>
                                        <span class="text-error" id="error_codigo_personal"></span>
                                    </div>
                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="fecha_nacimiento">
                                                <span class="label-text">
                                                    Fecha de nacimiento *
                                                </span>

                                            </label>
                                            <input id="fecha_nacimiento" name="fecha_nacimiento" required=""
                                                class="w-full shadow-sm input" type="date" value="">
                                        </div>
                                        <span class="text-error" id="error_fecha_nacimiento"></span>
                                    </div>


                                    <div class="group">
                                        <div class="form-control">
                                            <label class="mb-0 font-bold label " for="genero">
                                                <span class="label-text">
                                                    Género *
                                                </span>

                                            </label>
                                            <select id="genero" name="genero" value=""
                                                class="w-full shadow-sm select">
                                                <option value="">Seleccionar una opción</option>
                                                <!--[if BLOCK]><![endif]-->
                                                <option value="MASCULINO">Masculino</option>
                                                <option value="FEMENINO">Femenino</option>
                                                <!--[if ENDBLOCK]><![endif]-->
                                            </select>
                                        </div>
                                        <span class="text-error" id="error_genero"></span>
                                    </div>
                                    <div class="group">
                                        <div class="form-control">
                                            <label class="mb-0 font-bold label " for="estado_civil">
                                                <span class="label-text">
                                                    Pueblo/Etnia *
                                                </span>

                                            </label>
                                            <select id="pueblo_etnia" name="pueblo_etnia" value=""
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


                    <div class="ms-6">
                        <span
                            class="absolute flex items-center justify-center w-8 rounded-full bg-neutral-content -start-4">
                            <i class="fa-solid fa-house-user"></i>
                        </span>
                        <h3 class="font-medium leading-tight">DATOS DEL ENCARGADO</h3>
                    </div>
                    <div class="col-span-2 ml-10 lg:ml-32">
                        <section class="hidden steps step-2" id="step-2">
                            @include('components.form_inCharge')

                        </section>
                    </div>


                    <div class="ms-6">
                        <span
                            class="absolute flex items-center justify-center w-8 rounded-full bg-neutral-content -start-4">
                            <i class="fa-solid fa-house-user"></i>
                        </span>
                        <h3 class="font-medium leading-tight">DATOS DEL ENCARGADO</h3>
                    </div>
                    <div class="col-span-2 ml-10 lg:ml-32">

                        <section class="hidden steps step-3" id="step-3">
                            @include('components.form_inCharge')

                        </section>

                    </div>

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
                                            <label class="mb-0 font-bold label " for="primer_nombre_cliente">
                                                <span class="label-text">
                                                    Primer nombre *
                                                </span>

                                            </label>
                                            <input id="primer_nombre_cliente" name="primer_nombre_cliente" required=""
                                                class="w-full shadow-sm input" type="text" value="">
                                        </div>
                                        <span class="text-error" id="error_primer_nombre_cliente"></span>
                                    </div>
                                    <div>
                                        <label class="mb-0 font-bold label " for="segundo_nombre_cliente">
                                            <span class="label-text">
                                                Segundo nombre
                                            </span>

                                        </label>
                                        <input id="segundo_nombre_cliente" name="segundo_nombre_cliente"
                                            class="w-full shadow-sm input" type="text" value="">
                                    </div>
                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="primer_apellido_cliente">
                                                <span class="label-text">
                                                    Primer Apellido *
                                                </span>

                                            </label>
                                            <input id="primer_apellido_cliente" name="primer_apellido_cliente"
                                                required="" class="w-full shadow-sm input" type="text"
                                                value="">
                                        </div>
                                        <span class="text-error" id="error_primer_apellido_cliente"></span>
                                    </div>
                                    <div>
                                        <label class="mb-0 font-bold label " for="segundo_apellido_cliente">
                                            <span class="label-text">
                                                Segundo apellido
                                            </span>

                                        </label>
                                        <input id="segundo_apellido_cliente" name="segundo_apellido_cliente"
                                            class="w-full shadow-sm input" type="text" value="">
                                    </div>

                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="dpi_cliente">
                                                <span class="label-text">
                                                    DPI *
                                                </span>

                                            </label>
                                            <input id="dpi_cliente" name="dpi_cliente" required=""
                                                class="w-full shadow-sm input" type="text" minlength="13"
                                                maxlength="13" pattern="^\d{13}$"
                                                placeholder="Ingrese el número de documento" value="">
                                        </div>
                                        <span class="text-error" id="error_dpi_cliente"></span>
                                    </div>

                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="telefono">
                                                <span class="label-text">
                                                    Teléfono *
                                                </span>

                                            </label>
                                            <input id="telefono" name="telefono" required=""
                                                class="w-full shadow-sm input" type="number" min="10000000"
                                                max="99999999" value="">
                                        </div>
                                        <span class="text-error" id="error_telefono"></span>

                                    </div>
                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="referencia_casa">
                                                <span class="label-text">
                                                    Direccion *
                                                </span>

                                            </label>
                                            <input id="referencia_casa" name="referencia_casa" required=""
                                                class="w-full shadow-sm input" type="text" value="">
                                        </div>
                                        <span class="text-error" id="error_referencia_casa"></span>
                                    </div>
                                    <div class="group">
                                        <div class="form-control">
                                            <label class="mb-0 font-bold label" for="parentesco">
                                                <span class="label-text">Parentesco *</span>
                                            </label>
                                            <select id="parentesco" name="parentesco" class="w-full shadow-sm select"
                                                onchange="toggleComentario()">
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

                                    <div class="group" id="comentario" style="display: none;">
                                        <div>
                                            <label class="mb-0 font-bold label" for="comentario">
                                                <span class="label-text">Especifique *</span>
                                            </label>
                                            <input id="comentario" name="comentario" class="w-full shadow-sm input"
                                                type="text" value="">
                                        </div>
                                        <span class="text-error" id="error_comentario"></span>
                                    </div>
                                </div>
                                <div class="group">
                                    <!--[if BLOCK]><![endif]--> <button
                                        class="justify-start mt-2 text-white btn bg-neutral prev-btn" type="button"
                                        data-prev-step="step-2">
                                        Anterior
                                    </button>
                                    <!--[if ENDBLOCK]><![endif]-->
                                    <button class="justify-start mt-2 text-white btn bg-success" type="submit">
                                        Enviar
                                        <!--[if ENDBLOCK]><![endif]-->
                                    </button>
                                    <!--[if ENDBLOCK]><![endif]-->
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
