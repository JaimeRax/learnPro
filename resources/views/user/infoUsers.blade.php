<section>
    <!-- Información del cliente -->
    <div class="container">
        <div class="form-row">
            <div class="form-group col-md-4">
                <div class="form-control">
                    <label class="mb-0 font-bold label " for="dpi">
                        <span class="label-text">
                            Nombre de Usuario
                        </span>
                    </label>
                    <input readonly="" id="name" name="name" class="w-full shadow-sm input" type="text"
                        value="{{ strtoupper("{$user->username} ") }}"> <!-- Cambiado aquí -->
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <div class="form-control">
                        <label class="mb-0 font-bold label " for="nombres">
                            <span class="label-text">
                                Nombre Completo
                            </span>
                        </label>
                        <input readonly="" id="nombres" name="nombres" class="w-full shadow-sm input" type="text"
                            value="{{ strtoupper("{$user->first_name} {$user->second_name} {$user->first_lastname} {$user->second_lastname}") }}">
                    </div>
                </div>
            </div>
            <div class="form-group col-md-4">
                <div class="form-control">
                    <label class="mb-0 font-bold label " for="nit">
                        <span class="label-text">
                            DPI
                        </span>
                    </label>
                    <input readonly="" id="dpi" name="dpi" class="w-full shadow-sm input" type="text"
                    value="{{ $user->dpi }}">
                </div>
            </div>
            <div class="form-group col-md-4">
                <div class="form-control">
                    <label class="mb-0 font-bold label " for="telefono">
                        <span class="label-text">
                            Teléfono
                        </span>
                    </label>
                    <input readonly="" id="telefono" name="telefono" class="w-full shadow-sm input" type="text"
                        value="{{ $user->phone }}">
                </div>
            </div>

            <div class="form-group col-md-4">
                <div class="form-control">
                    <label class="mb-0 font-bold label " for="correo">
                        <span class="label-text">
                            Correo electrònico
                        </span>
                    </label>
                    <input readonly="" id="correo" name="correo" class="w-full shadow-sm input" type="text"
                        value="{{ $user->email }}">
                </div>
            </div>
        </div>

        <div class="form-group col-md-4">
            <div class="form-control">
                <label class="mb-0 font-bold label " for="profesion">
                    <span class="label-text">
                        Grado Academico
                    </span>
                </label>
                <input readonly="" id="profesion" name="profesion" class="w-full shadow-sm input"
                    type="text" value="{{ $user->academic_degree }}">
            </div>
        </div>


        <div class="form-group col-md-4">
            <div class="form-control">
                <label class="mb-0 font-bold label " for="profesion">
                    <span class="label-text">
                        Tiempo de servicio
                    </span>
                </label>
                <input readonly="" id="servie" name="service" class="w-full shadow-sm input"
                    type="text" value="{{ $user->service_time }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col">
                <div class="form-control">
                    <label class="mb-0 font-bold label " for="direccion">
                        <span class="label-text">
                            Dirección
                        </span>
                    </label>
                    <input readonly="" id="direccion" name="direccion" class="w-full shadow-sm input"
                        type="text" value="{{ $user->address }}">
                </div>
            </div>
        </div>

    </div>
</section>
