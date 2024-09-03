@extends('layouts.base')

@section('main')
    @auth
        <div class="relative flex items-center justify-center h-screen bg-center bg-cover" style="background-image: url('/path/to/your/image.jpg');">
            <div class="absolute inset-0"></div>
            <div class="relative z-10 text-center text-blue">
                <h1 class="text-5xl font-bold">¡Bienvenido al modulo de caja, {{ auth()->user()->name ?? auth()->user()->username }}!</h1>
                <p class="mt-4 text-xl">Estás autenticado y listo para explorar la página.</p>
            </div>
        </div>
    @endauth
@endsection
