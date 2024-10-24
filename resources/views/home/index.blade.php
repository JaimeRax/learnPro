@extends('layouts.base')

@section('main')
    @auth
        <div class="flex flex-col items-center justify-start bg-white column-row">
            <!-- Imagen en la parte superior -->
            <div class="flex flex-col items-center mb-12">
                <img class="w-40 h-auto" src="/Imagenes/jv-logo.png" alt="jv-logo" />
            </div>
            <div class="grid grid-cols-2 gap-20">
                <div class="max-w-xs p-8 text-sm text-justify bg-gray-200 rounded-lg shadow-lg w-80 h-96">
                    <h1 class="mb-4 text-2xl font-extrabold text-gray-900">Misión</h1>
                    <h2>Somos una Institución Educativa con modalidad Cooperativa, con el propósito de brindar una educación
                        integral a los estudiantes, en un ambiente agradable, armónico y seguro, donde se respeta, valora y se
                        fortalece las características, habilidades y aptitudes individuales de los estudiantes; formando
                        ciudadanos
                        líderes, creativos, reflexivos, comunicativos, para ser personas de éxito.
                    </h2>
                </div>
                <div class="max-w-xs p-8 text-sm text-justify bg-gray-200 rounded-lg shadow-lg w-80 h-96">
                    <h1 class="mb-4 text-2xl font-extrabold text-gray-900">Visión</h1>
                    <h2>Ser una Institución Educativa líder de la región, en la formación académica de excelencia, con
                        principios y valores para alcanzar una educación sólida que ayude al estudiante a desarrollarse como
                        ciudadano útil,
                        enlos distintos aspectos de la vida.
                    </h2>
                </div>
            </div>
            <div class="w-1/2 h-auto p-5 mt-5 text-sm text-center bg-gray-200 rounded-lg shadow-lg">
                <h1 class="mb-1 text-2xl font-extrabold text-center text-gray-900">Valores</h1>
                <h2>Disciplina Respeto Orden Limpieza</h2>
            </div>

            <h1 class="text-white">fsd</h1>
        </div>
    @endauth
@endsection
