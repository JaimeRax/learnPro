<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>learnPro</title>
        @vite(['resources/js/app.js', 'resources/sass/app.scss'])
    </head>
    <body>
        <!-- contenido del gradiante -->
        <main class="lg:h-screen md:h-screen sm:h-auto bg-gradient-to-tl from-gray-600 to-sky-700">
            <div class="flex items-center justify-center h-full" id='main-container'>
                <div class="grid grid-cols-1 m-3 md:grid-cols-2" id="main-grid">

                    <!-- contenedor de imágenes y logos -->
                    <div class="p-8 bg-sky-600 h-[30rem] rounded shadow-md md:rounded-l-lg md:rounded-none"
                        id="logo-container">
                        <!-- centrador de imágenes y logos -->
                        <div class="flex flex-col items-center justify-center h-full">
                            <img class="h-auto w-36" src="/Imagenes/jv-logo.png" alt="jv-logo" />
                            <h1 class="text-3xl text-white uppercase">
                                BASICO J.V.
                            </h1>
                        </div>
                    </div>

                    <!-- contenedor del formulario -->
                    <div class="p-8 border rounded shadow-md bg-white/10 border-white/30 backdrop-blur-sm md:rounded-r-lg md:rounded-none"
                        id="form-container">
                        <!-- Login Form -->
                        <div class="flex flex-col items-center justify-center h-full p-3" id="login-form">
                            <section class='w-full'>

                                <form method="POST" action="/login">
                                    @csrf
                                    <div class="grid grid-cols-1 gap-3">
                                        <h2 class="text-2xl font-bold text-center text-white">
                                            Bienvenido
                                        </h2>
                                        <input id="username" type="text" placeholder="Correo electrónico"
                                            class="input w-full shadow-sm" required />
                                        <input id="password" type="password" placeholder="Contraseña"
                                            class="input w-full shadow-sm" required />
                                        <div class="flex items-center justify-between">
                                            <a href="#" id="forgot-password"
                                                class="flex items-center text-gray-200 transition hover:text-gray-400">
                                                <small>Olvidé mi Contraseña</small>
                                            </a>
                                            <button type="button" onclick="togglePassword()"
                                                class="flex items-center text-gray-200 transition hover:text-gray-400">
                                                <small id="text-password">Mostrar contraseña</small>
                                                <i id="togglePassword" class='w-6 far fa-eye'></i>
                                            </button>
                                        </div>
                                        <button type="submit"
                                            class="p-3 font-bold text-white transition rounded-md bg-sky-600 hover:bg-sky-800 hover:text-gray-400">
                                            Iniciar sesión
                                        </button>
                                    </div>
                                </form>
                            </section>
                            <section class="grid grid-cols-4 gap-3 mt-3">
                                <a href="https://www.facebook.com/basicoporcooperativachamelcoav" target="_blank"
                                    class="text-white transition hover:text-gray-400">
                                    <i class="fab fa-facebook fa-2x"></i>
                                </a>
                                <a href="#" target="_blank" class="text-white transition hover:text-gray-400">
                                    <i class="fab fa-whatsapp fa-2x"></i>
                                </a>
                                <a href="#" target="_blank" class="text-white transition hover:text-gray-400">
                                    <i class="fab fa-instagram fa-2x"></i>
                                </a>
                                <a href="#" target="_blank" class="text-white transition hover:text-gray-400">
                                    <i class="fab fa-youtube fa-2x"></i>
                                </a>
                            </section>
                        </div>

                        <!-- Forgot Password Form -->
                        <div class="items-center justify-center hidden h-full p-3 " id="forgot-password-form">

                            <section class="w-full">
                                <div class="text-2xl font-bold text-center text-white card-header">
                                    Recuperar Contraseña
                                </div>
                                <br>
                                <form method="POST" action="#">
                                    @csrf
                                    <div class="grid grid-cols-1 gap-3 justify-items-center">
                                        <div class="col-span-1">
                                            <input id="email" type="email" placeholder="Correo electrónico"
                                                class="input w-full shadow-sm" required autocomplete="email"
                                                autofocus />
                                        </div>
                                        <!-- Campo oculto para la URL -->
                                        <input type="hidden" name="urlForm" value="#">
                                        <div class="col-span-1">
                                            <button type="submit"
                                                class="p-3 font-bold text-white transition rounded-md bg-sky-600 hover:bg-sky-700 hover:text-gray-400">
                                                Enviar enlace de recuperación
                                            </button>
                                        </div>
                                        <div class="col-span-1">
                                            <button type="button" onclick="showLoginForm()"
                                                class="p-3 font-bold text-white transition bg-gray-800 rounded-md hover:bg-gray-400 hover:text-gray-800">
                                                Regresar
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <script>
            // // redireccion al login pasado 5 segundos
            // document.addEventListener('DOMContentLoaded', function() {
            //     let countdown = 5; // Tiempo inicial en segundos
            //     const countdownLabel = document.getElementById('countdown-label');
            //     countdownLabel.textContent = `Regresando al inicio en ${countdown} segundos...`;
            //
            //     // Función para actualizar el contador
            //     const updateCountdown = () => {
            //         countdown -= 1;
            //         if (countdown > 0) {
            //             countdownLabel.textContent = `Regresando al inicio en ${countdown} segundos...`;
            //         } else {
            //             countdownLabel.textContent = `Redirigiendo al inicio...`;
            //             clearInterval(countdownInterval);
            //             // Redirige a la URL después de 5 segundos
            //             window.location.href = "/login";
            //         }
            //     };
            //
            //     // Actualiza el contador cada segundo
            //     const countdownInterval = setInterval(updateCountdown, 1000);
            // });


            function togglePassword() {
                const passwordField = document.getElementById("password");
                const icon = document.getElementById("togglePassword");
                const textPassword = document.getElementById("text-password");

                const isPasswordVisible = passwordField.type !== "password";

                if (isPasswordVisible) {
                    passwordField.type = "password";
                    textPassword.textContent = "Mostrar contraseña";
                    icon.classList.remove("fa-eye-slash");
                    icon.classList.add("fa-eye");
                } else {
                    passwordField.type = "text";
                    textPassword.textContent = "Ocultar contraseña";
                    icon.classList.remove("fa-eye");
                    icon.classList.add("fa-eye-slash");
                }
            }

            function showForgotPasswordForm() {
                document.getElementById('login-form').classList.add('hidden');
                document.getElementById('forgot-password-form').classList.remove('hidden');
            }

            function showLoginForm() {
                document.getElementById('forgot-password-form').classList.add('hidden');
                document.getElementById('login-form').classList.remove('hidden');
            }

            document.getElementById('forgot-password').addEventListener('click', function(event) {
                event.preventDefault();
                showForgotPasswordForm();
            });
        </script>



        {{-- <section class="bg-gray-50 dark:bg-gray-900"> --}}
        {{--     <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0"> --}}
        {{--         <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white"> --}}
        {{--             <img class="w-8 h-8 mr-2" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo.svg" --}}
        {{--                 alt="logo"> --}}
        {{--             Flowbite --}}
        {{--         </a> --}}
        {{--         <h1 --}}
        {{--             class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white"> --}}
        {{--             Sign in to your account --}}
        {{--         </h1> --}}
        {{--         <form class="space-y-4 md:space-y-6" action="/login" method="POST"> --}}
        {{--             @csrf --}}
        {{--             <div> --}}
        {{--                 <label for="username" --}}
        {{--                     class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label> --}}
        {{--                 <input type="text" name="username" id="username" --}}
        {{--                     class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" --}}
        {{--                     required=""> --}}
        {{--             </div> --}}
        {{--             <div> --}}
        {{--                 <label for="password" --}}
        {{--                     class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label> --}}
        {{--                 <input type="password" name="password" id="password" placeholder="••••••••" --}}
        {{--                     class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" --}}
        {{--                     required=""> --}}
        {{--             </div> --}}
        {{--             <div class="flex items-center justify-between"> --}}
        {{--                 <a href="#" --}}
        {{--                     class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">Forgot --}}
        {{--                     password?</a> --}}
        {{--             </div> --}}
        {{--             <button type="submit" --}}
        {{--                 class="w-full text-white bg-blue-600 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Sign --}}
        {{--                 in</button> --}}
        {{--             <p class="text-sm font-light text-gray-500 dark:text-gray-400"> --}}
        {{--                 Don’t have an account yet? <a href="/register" --}}
        {{--                     class="font-medium text-primary-600 hover:underline dark:text-primary-500">Sign up</a> --}}
        {{--             </p> --}}
        {{--         </form> --}}
        {{--     </div> --}}
        {{-- </section> --}}
    </body>
</html>
