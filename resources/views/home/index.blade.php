@extends('layouts.base')

@section('main')
    @auth

        <div class="flex flex-col items-center justify-start rounded-lg shadow-lg bg-gray-200 mt-14">
            <!-- Imagen en la parte superior -->
            <div class="flex flex-col items-center mb-4 mt-8">
                <img class="w-40 h-auto" src="/Imagenes/jv-logo.png" alt="jv-logo" />
            </div>

            <!-- Contenedor para Misión y Visión -->
            <div class="grid w-full max-w-5xl grid-cols-1 gap-8 md:grid-cols-2 mt-4">
                <!-- Misión -->
                <div class="p-8 text-sm text-justify bg-white border border-gray-200 rounded-lg shadow-lg mr-2 ml-4">
                    <h1 class="mb-4 text-2xl font-extrabold text-gray-900">Misión</h1>
                    <p>
                        Somos una Institución Educativa con modalidad Cooperativa, con el propósito de brindar una educación
                        integral a los estudiantes, en un ambiente agradable, armónico y seguro, donde se respeta, valora y se
                        fortalecen las características, habilidades y aptitudes individuales de los estudiantes; formando
                        ciudadanos líderes, creativos, reflexivos, comunicativos, para ser personas de éxito.
                    </p>
                </div>
                <!-- Visión -->
                <div class="p-8 text-sm text-justify bg-white border border-gray-200 rounded-lg shadow-lg mr-4 ml-2">
                    <h1 class="mb-4 text-2xl font-extrabold text-gray-900">Visión</h1>
                    <p>
                        Ser una Institución Educativa líder de la región, en la formación académica de excelencia, con
                        principios y valores para alcanzar una educación sólida que ayude al estudiante a desarrollarse como
                        ciudadano útil en los distintos aspectos de la vida.
                    </p>
                </div>
            </div>

            <!-- Contenedor para Valores -->
            <div class="grid w-full max-w-5xl grid-cols-1 gap-8">
                <!-- Sección para Valores -->
                <div class="p-8 text-justify bg-white border border-gray-200 rounded-lg shadow-lg mt-4 mr-4 ml-4 mb-16">
                    <h1 class="mb-4 text-2xl font-extrabold text-center text-gray-900">Valores</h1>
                    <div class="flex flex-wrap justify-center gap-4 text-sm">
                        <span class="text-gray-900 bg-gradient-to-r from-yellow-200 via-yellow-400 to-yellow-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:focus:ring-yellow-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 rounded-full">Disciplina</span>
                        <span class="text-gray-900 bg-gradient-to-r from-yellow-200 via-yellow-400 to-yellow-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:focus:ring-yellow-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 rounded-full">Respeto</span>
                        <span class="text-gray-900 bg-gradient-to-r from-yellow-200 via-yellow-400 to-yellow-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:focus:ring-yellow-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 rounded-full">Orden</span>
                        <span class="text-gray-900 bg-gradient-to-r from-yellow-200 via-yellow-400 to-yellow-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:focus:ring-yellow-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 rounded-full">Limpieza</span>
                    </div>
                </div>
            </div>
        </div>

    @endauth
@endsection
