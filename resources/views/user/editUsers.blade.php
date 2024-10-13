@extends('layouts.base')

@section('header')
    <route route="/" previousRouteName="Inicio" currentRouteName="degrees" />
@endsection


@section('main')
    <div class="grid grid-cols-1 gap-2">
        <div class="container-sm">
            <form action="/users/edit/{{ $user->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                <ol class="relative text-gray-500 border-gray-200 border-s dark:border-gray-700 dark:text-gray-400">
                    <div class="ms-6">
                        <span
                            class="absolute flex items-center justify-center w-8 rounded-full bg-neutral-content -start-4">
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <h3 class="font-medium leading-tight">INFORMACIÓN PERSONAL</h3>
                    </div>
                    <div class="col-span-2 ml-10 lg:ml-32">
                        <section class="steps activo step-1" id="step-1">
                            <div class="flex-col p-2">
                                <div class="grid grid-cols-1 gap-2 md:grid-cols-3">
                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="first_name">
                                                <span class="label-text">
                                                    Nombre de usuario *
                                                </span>
                                            </label>
                                            <input id="username" required name="username" class="w-full shadow-sm input"
                                                type="text" value="{{ old('name', $user->username) }}">
                                        </div>
                                    </div>

                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label" for="email">
                                                <span class="label-text">
                                                    Email *
                                                </span>
                                            </label>
                                            <input id="email" required name="email"
                                                class="w-full shadow-sm input" type="text"
                                                value="{{ old('email', $user->email) }}">
                                        </div>
                                    </div>

                                </div>

                            </div>


                        </section>

                    </div>

                    <div class="ms-6">
                        <span
                            class="absolute flex items-center justify-center w-8 rounded-full bg-neutral-content -start-4">
                            <i class="fa-solid fa-house-user"></i>
                        </span>
                        <h3 class="font-medium leading-tight">DATOS PERSONALES DEL DOCENTE</h3>
                    </div>
                    <div class="col-span-2 ml-10 lg:ml-32">
                        <section class=" steps step-2" id="step-2">
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
                                                type="text" value="{{ old('first_name', $user->first_name) }}">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="mb-0 font-bold label " for="second_name">
                                            <span class="label-text">
                                                Segundo nombre
                                            </span>
                                        </label>
                                        <input id="second_name" name="second_name" class="w-full shadow-sm input"
                                            type="text" value="{{ old('second_name', $user->second_name) }}">
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
                                                value="{{ old('first_lastname', $user->first_lastname) }}">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="mb-0 font-bold label " for="second_lastname">
                                            <span class="label-text">
                                                Segundo apellido
                                            </span>
                                        </label>
                                        <input id="second_lastname" name="second_lastname" class="w-full shadow-sm input"
                                            type="text" value="{{ old('second_lastname', $user->second_lastname) }}">
                                    </div>
                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="dpi">
                                                <span class="label-text">
                                                    DPI *
                                                </span>
                                            </label>
                                            <input id="dpi" name="dpi" class="w-full shadow-sm input"
                                                type="text" placeholder="XXXX XXXXX XXXX" required
                                                value="{{ old('dpi', $user->dpi) }}">
                                        </div>
                                    </div>
                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="phone">
                                                <span class="label-text">
                                                    Teléfono *
                                                </span>
                                            </label>
                                            <input id="phone" name="phone" class="w-full shadow-sm input"
                                                type="number" maxlength="8" value="{{ old('phone', $user->phone) }}" required>
                                        </div>
                                    </div>
                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="address">
                                                <span class="label-text">
                                                    Direccion *
                                                </span>
                                            </label>
                                            <input id="address" name="address" required class="w-full shadow-sm input"
                                                type="text" value="{{ old('address', $user->address) }}">
                                        </div>
                                    </div>
                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="academic_degree">
                                                <span class="label-text">
                                                    Grado acadèmico *
                                                </span>
                                            </label>
                                            <input id="academic_degree" name="academic_degree" required
                                                class="w-full shadow-sm input" type="text"
                                                value="{{ old('academic_degree', $user->academic_degree) }}">
                                        </div>
                                    </div>

                                    <div class="group">
                                        <div>
                                            <label class="mb-0 font-bold label " for="service_time">
                                                <span class="label-text">
                                                    Inicio de labores *
                                                </span>
                                            </label>
                                            <input id="service_time" required name="service_time"
                                                class="w-full shadow-sm input" type="date"
                                                value="{{ old('service_time', $user->service_time) }}">
                                        </div>
                                    </div>
                                    <div class="flex items-center mt-4 space-x-4"> <!-- Agregado un margen superior -->
                                        @foreach ($roles as $id => $role)
                                            <div class="flex items-center"> <!-- Cada rol en un div flex -->
                                                <label class="flex items-center mr-4"> <!-- Clase mr-4 para espacio entre checkboxes -->
                                                    <input class="mr-2 form-check-input" type="checkbox" name="roles[]"
                                                    value="{{ $id }}" {{ $user->roles->contains($id) ? 'checked' : '' }}>

                                                    <span class="form-check-sign">
                                                        <span class="check" value=""></span>
                                                    </span>
                                                    {{ $role }} <!-- Texto al lado del checkbox -->
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>


                                <div class="group">
                                    <x-button-link href="/users" class="mt-2 text-white bg-orange-400">

                                    Cancelar

                                    </x-button-link>
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
    @endsection

    <script src="{{ asset('js/reloadPage.js') }}"></script>
