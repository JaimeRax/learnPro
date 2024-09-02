<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Home</title>
    </head>
    <body>
        @auth
            <h1>HOME</h1>
            <p>BIENVENIDO {{ auth()->user()->name ?? auth()->user()->username }} ESTAS AUTENTICADO A LA PAGINA</p>
            <p><a href="/logout">Logout</a></p>
        @endauth

@guest
    <p>PARA VER EL CONTENIDO <a href="/login"> inicia sesion</a></p>
@endguest
    </body>
</html>
