<div class="navbar bg-neutral text-neutral-content">

    <div class="flex-none">
        <label for="main-drawer" class="btn btn-square btn-ghost drawer-button">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                class="inline-block w-5 h-5 stroke-current">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </label>
    </div>

    <div class="flex-1">
        <a class="text-xl btn btn-ghost" href="/">Basico JV</a>
    </div>

    <div class="flex-none">
        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                <!-- Mostrar el icono de login por defecto -->
                <img src="https://icon-library.com/images/icon-login/icon-login-4.jpg" alt="Login Icon"
                    class="w-10 h-10">

                {{-- <x-avatar :url="auth()->user()->photo ?? 'n/a'" class="w-10" role="button" /> --}}
            </div>
            <ul tabindex="0" class="menu menu-sm dropdown-content bg-neutral rounded-box z-[1] mt-3 w-52 p-2 shadow">
                <li>
                    <a href='/Usuarios/perfil'>
                        Perfil
                    </a>
                </li>
                <li>
                    <label class="w-full swap swap-rotate">
                        <!-- this hidden checkbox controls the state -->
                        <input id="theme-changer" type="checkbox" class="theme-controller"
                            onchange="toggleTheme(this)" />
                        <!-- sun icon -->
                        <div class="fill-current swap-off">
                            <i class="fa-solid fa-sun"></i>
                        </div>
                        <!-- moon icon -->
                        <div class='fill-current swap-on'>
                            <i class="fa-solid fa-moon"></i>
                        </div>
                    </label>
                </li>
                <li>
                    {{-- <form id="logout-form" action="{{ url('logout') }}" method="POST">
                        {{ csrf_field() }}
                        <button type="submit">Cerrar sesión</button>
                    </form> --}}
                    <p><a href="/logout">Logout</a></p>
                </li>
            </ul>
        </div>
    </div>
</div>
