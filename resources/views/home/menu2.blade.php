@extends('layouts.base')

@section('main')
    @auth
        <div class="flex flex-col items-center justify-center h-screen bg-gray-100">
            <h1 class="text-4xl font-bold text-gray-800">Bienvenido al modulo de pagos</h1>
            <p class="mt-4 text-lg text-gray-600">
                Hola, {{ auth()->user()->name ?? auth()->user()->username }}. Estás autenticado.
            </p>
        </div>
    @endauth
@endsection
