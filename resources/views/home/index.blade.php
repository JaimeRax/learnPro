@extends('layouts.base')

@section('main')
    @auth
        <h1>HOME</h1>
        <p>BIENVENIDO {{ auth()->user()->name ?? auth()->user()->username }} ESTAS AUTENTICADO A LA PAGINA</p>
    @endauth
@endsection
