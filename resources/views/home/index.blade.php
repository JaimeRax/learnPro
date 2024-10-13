@extends('layouts.base')

@section('main')
    @auth
    <div class="flex flex-col items-center justify-center h-screen bg-white">
        <!-- Imagen en la parte superior -->
        <div class="flex flex-col items-center mb-20">
            <img class="w-40 h-auto" src="/Imagenes/jv-logo.png" alt="jv-logo" />
        </div>
        <!-- Contenedor de columnas -->
        <div class="flex flex-row items-stretch justify-center space-x-4">
            <div class="max-w-xs p-8 text-sm text-justify rounded-lg shadow-lg w-80 bg-gray-50 h-96">
                <h1 class="mb-4 text-2xl font-extrabold text-gray-900">Misión</h1>
                <h2>Somos una Institución Educativa con modalidad Cooperativa, con el propósito de brindar una educación
                    integral a los estudiantes, en un ambiente agradable, armónico y seguro, donde se respeta, valora y se
                    fortalece las características, habilidades y aptitudes individuales de los estudiantes; formando ciudadanos
                    líderes, creativos, reflexivos, comunicativos, para ser personas de éxito.</h2>
            </div>
            <div class="max-w-xs p-8 text-sm text-justify rounded-lg shadow-lg w-80 bg-gray-50 h-96">
                <h1 class="mb-4 text-2xl font-extrabold text-gray-900">Visión</h1>
                <h2>Ser una Institución Educativa líder de la región, en la formación académica de excelencia, con principios y
                    valores para alcanzar una educación sólida que ayude al estudiante a desarrollarse como ciudadano útil, en
                    los distintos aspectos de la vida.</h2>
            </div>
            <div class="max-w-xs p-8 text-sm text-justify rounded-lg shadow-lg w-80 bg-gray-50 h-96">
                <h1 class="mb-4 text-2xl font-extrabold text-gray-900">Valores</h1>
                <div class="flex flex-col space-y-2">
                    <span class="block">DISCIPLINA</span>
                    <span class="block">RESPETO</span>
                    <span class="block">ORDEN</span>
                    <span class="block">LIMPIEZA</span>
                </div>
            </div>
        </div>
    </div>

    @endauth
@endsection
