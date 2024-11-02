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
                        value="{{ strtoupper("{$studens->username} ") }}"> <!-- Cambiado aquí -->
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
                            value="{{ strtoupper("{$studens->first_name} {$studens->second_name} {$studens->first_lastname} {$studens->second_lastname}") }}">
                    </div>
                </div>
            </div>
            <div class="form-group col-md-4">
                <div class="form-control">
                    <label class="mb-0 font-bold label " for="nit">
                        <span class="label-text">
                            Codigo Personal
                        </span>
                    </label>
                    <input readonly="" id="personal_code" name="personal_code" class="w-full shadow-sm input" type="text"
                    value="{{ $studens->personal_code }}">
                </div>
            </div>
            <div class="form-group col-md-4">
                <div class="form-control">
                    <label class="mb-0 font-bold label " for="telefono">
                        <span class="label-text">
                            Genero
                        </span>
                    </label>
                    <input readonly="" id="gender" name="gender" class="w-full shadow-sm input" type="text"
                        value="{{ $studens->gender }}">
                </div>
            </div>

            <div class="form-group col-md-4">
                <div class="form-control">
                    <label class="mb-0 font-bold label " for="correo">
                        <span class="label-text">
                            Fecha de nacimiento
                        </span>
                    </label>
                    <input readonly="" id="birthdate" name="birthdate" class="w-full shadow-sm input" type="text"
                        value="{{ $studens->birthdate }}">
                </div>
            </div>
        </div>

        <div class="form-group col-md-4">
            <div class="form-control">
                <label class="mb-0 font-bold label " for="profesion">
                    <span class="label-text">
                        Etnia
                    </span>
                </label>
                <input readonly="" id="town_ethnicity" name="town_ethnicity" class="w-full shadow-sm input"
                    type="text" value="{{ $studens->town_ethnicity }}">
            </div>
        </div>
    </div>
</section>
