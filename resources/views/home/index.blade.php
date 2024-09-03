@extends('layouts.base')

@section('main')
    @auth
        <div class="flex flex-col items-center justify-center h-screen bg-white">
            <div class="max-w-2xl p-8 rounded-lg shadow-lg bg-gray-50">
                <h1 class="mb-4 text-3xl font-extrabold text-gray-900">Bienvenido a la Página</h1>
                <p class="text-lg text-gray-700">
                    Hola, {{ auth()->user()->name ?? auth()->user()->username }}. Estás autenticado.
                </p>
            </div>
        </div>
    @endauth
@endsection
