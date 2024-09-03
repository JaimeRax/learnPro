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
        <main class="h-screen bg-gradient-to-tl from-gray-600 to-sky-700 flex flex-col">
            <!-- Contenedor principal centrado -->
            <div class="flex flex-1 items-center justify-center">
                <div class="grid grid-cols-1 m-3 md:grid-cols-2" id="main-grid">

                    <!-- contenedor de imágenes y logos -->
                    <div class="p-8 bg-sky-600 h-[30rem] rounded shadow-md md:rounded-l-lg md:rounded-none"
                        id="logo-container">
                        <!-- centrador de imágenes y logos -->
                        <div class="flex flex-col items-center justify-center h-full">
                            <img class="h-auto w-36" src="/Imagenes/jv-logo.png" alt="jv-logo" />
                            <h1 class="text-3xl text-white uppercase font-bold">
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
                                        <input name="username" id="username" type="email"
                                            placeholder="Correo electrónico" class="input w-full shadow-sm" required />
                                        <input name="password" id="password" type="password" placeholder="Contraseña"
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

            <!-- Nueva Imagen en la parte inferior -->
            <div class="flex flex-col items-center justify-center py-3">
                <img class="w-20 h-auto" src="/Imagenes/umg.svg" alt="UMG Logo" />
                <h4 class="text-base text-white uppercase mt-4">
                    UNIVERSIDAD MARIANO GÁLVEZ DE GUATEMALA
                </h4>
                <h4 class="text-base text-white uppercase mt-1">
                    Facultad de Ingeniería en Sistemas
                </h4>
            </div>
        </main>

        <script>
            // redireccion al login pasado 5 segundos
            document.addEventListener('DOMContentLoaded', function() {
                let countdown = 5; // Tiempo inicial en segundos
                const countdownLabel = document.getElementById('countdown-label');
                countdownLabel.textContent = `Regresando al inicio en ${countdown} segundos...`;

                // Función para actualizar el contador
                const updateCountdown = () => {
                    countdown -= 1;
                    if (countdown > 0) {
                        countdownLabel.textContent = `Regresando al inicio en ${countdown} segundos...`;
                    } else {
                        countdownLabel.textContent = `Redirigiendo al inicio...`;
                        clearInterval(countdownInterval);
                        // Redirige a la URL después de 5 segundos
                        window.location.href = "/login";
                    }
                };

                // Actualiza el contador cada segundo
                const countdownInterval = setInterval(updateCountdown, 1000);
            });

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
    </body>
</html>
