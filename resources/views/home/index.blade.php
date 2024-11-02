@extends('layouts.base')

@section('main')
    @auth
    <div class="flex flex-col items-center justify-start p-16 bg-white">
        <!-- Imagen en la parte superior -->
        <div class="flex flex-col items-center mb-20">
            <img class="w-40 h-auto" src="/Imagenes/jv-logo.png" alt="jv-logo" />
        </div>

        <!-- Contenedor para Misión y Visión -->
        <div class="grid w-full max-w-3xl grid-cols-2 gap-8">
            <div class="h-auto p-16 text-sm text-justify bg-gray-200 rounded-lg shadow-lg">
                <h1 class="mb-4 text-2xl font-extrabold text-gray-900">Misión</h1>
                <h2>Somos una Institución Educativa con modalidad Cooperativa, con el propósito de brindar una educación
                    integral a los estudiantes, en un ambiente agradable, armónico y seguro, donde se respeta, valora y se
                    fortalece las características, habilidades y aptitudes individuales de los estudiantes; formando
                    ciudadanos líderes, creativos, reflexivos, comunicativos, para ser personas de éxito.
                </h2>
            </div>
            <div class="h-auto p-20 text-sm text-justify bg-gray-200 rounded-lg shadow-lg">
                <h1 class="mb-4 text-2xl font-extrabold text-gray-900">Visión</h1>
                <h2>Ser una Institución Educativa líder de la región, en la formación académica de excelencia, con
                    principios y valores para alcanzar una educación sólida que ayude al estudiante a desarrollarse como
                    ciudadano útil en los distintos aspectos de la vida.
                </h2>
            </div>
        </div>

        <!-- Sección para Valores -->
        <div class="w-full h-auto max-w-3xl p-4 text-sm text-center bg-gray-200 rounded-lg shadow-lg mt-7"> <!-- Ajusta el ancho aquí -->
            <h1 class="mb-4 text-2xl font-extrabold text-center text-gray-900">Valores</h1>
            <div class="flex justify-center space-x-28">
                <span>Disciplina</span>
                <span>Respeto</span>
                <span>Orden</span>
                <span>Limpieza</span>
            </div>
        </div>
    </div>

    @endauth
@endsection
