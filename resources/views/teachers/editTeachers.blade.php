@extends('layouts.base')

@section('header')
    <route route="/" previousRouteName="Inicio" currentRouteName="degrees" />
@endsection


@section('main')
    <div class="grid grid-cols-1 gap-2">
        <div class="container-sm">
            <form action="/teachers/edit/{{ $user->id }}" method="POST" enctype="multipart/form-data">
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
                                            <label class="mb-0 font-bold label" for="personal_code">
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


                        </section>
                        <div class="group">
                            <x-button-link href="/teachers" class="mt-2 text-white bg-orange-400">

                            Cancelar

                            </x-button-link>
                            <button class="justify-start mt-2 text-white btn bg-success" type="submit">
                                Enviar
                            </button>
                        </div>
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
