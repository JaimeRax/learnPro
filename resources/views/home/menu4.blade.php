@extends('layouts.base')

@section('main')
    @auth
        <div class="grid grid-cols-12 gap-4 p-6 bg-gray-100">
            <div class="col-span-12">
                <h1 class="text-3xl font-bold text-gray-800">Reporteria</h1>
            </div>
            <div class="col-span-8">
                <div class="p-4 bg-white rounded-lg shadow">
                    <p class="mt-2 text-gray-600">Has iniciado sesión y puedes acceder a todas las funcionalidades.</p>
                </div>
            </div>
            <div class="col-span-4">
                <div class="p-4 bg-white rounded-lg shadow">
                    <h3 class="text-lg font-medium">Opciones Rápidas</h3>
                    <ul class="mt-2 space-y-2">
                        <li><a href="#" class="text-blue-500 hover:underline">Reportes Anuales</a></li>
                    </ul>
                </div>
            </div>
        </div>
    @endauth
@endsection
