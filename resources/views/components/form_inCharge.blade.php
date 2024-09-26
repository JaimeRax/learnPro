<div class="flex-col p-2">
    <div class="grid grid-cols-1 gap-2 md:grid-cols-3">

        <div class="group">
            <div>
                <label class="mb-0 font-bold label " for="primer_nombre">
                    <span class="label-text">
                        Primer nombre *
                    </span>

                </label>
                <input id="primer_nombre" name="primer_nombre" required="" class="w-full shadow-sm input" type="text"
                    value="">
            </div>
            <span class="text-error" id="error_primer_nombre"></span>
        </div>
        <div class="group">
            <div>
                <label class="mb-0 font-bold label " for="segundo_nombre">
                    <span class="label-text">
                        Segundo nombre
                    </span>

                </label>
                <input id="segundo_nombre" name="segundo_nombre" class="w-full shadow-sm input" type="text"
                    value="">
            </div>
            <span class="text-error" id="error_segundo_nombre"></span>

        </div>
        <div class="group">
            <div>
                <label class="mb-0 font-bold label " for="primer_apellido">
                    <span class="label-text">
                        Primer Apellido *
                    </span>

                </label>
                <input id="primer_apellido" name="primer_apellido" required="" class="w-full shadow-sm input"
                    type="text" value="">
            </div>
            <span class="text-error" id="error_primer_apellido"></span>
        </div>
        <div class="group">
            <div>
                <label class="mb-0 font-bold label " for="segundo_apellido">
                    <span class="label-text">
                        Segundo apellido
                    </span>

                </label>
                <input id="segundo_apellido" name="segundo_apellido" class="w-full shadow-sm input" type="text"
                    value="">
            </div>
            <span class="text-error" id="error_segundo_apellido"></span>
        </div>

        <div class="group">
            <div>
                <label class="mb-0 font-bold label " for="dpi">
                    <span class="label-text">
                        DPI *
                    </span>

                </label>
                <input id="dpi" name="dpi" required="" class="w-full shadow-sm input" type="text"
                    minlength="13" maxlength="13" pattern="^\d{13}$" placeholder="Ingrese el número de documento"
                    value="">
            </div>
            <span class="text-error" id="error_dpi"></span>
        </div>

        <div class="group">
            <div>
                <label class="mb-0 font-bold label " for="telefono">
                    <span class="label-text">
                        Teléfono *
                    </span>

                </label>
                <input id="telefono" name="telefono" required="" class="w-full shadow-sm input" type="number"
                    min="10000000" max="99999999" value="">
            </div>
            <span class="text-error" id="error_telefono"></span>

        </div>
        <div class="group">
            <div>
                <label class="mb-0 font-bold label " for="direccion">
                    <span class="label-text">
                        Direccion *
                    </span>

                </label>
                <input id="direccion" name="direccion" required="" class="w-full shadow-sm input" type="text"
                    value="">
            </div>
            <span class="text-error" id="error_direccion"></span>
        </div>
        <div class="group">
            <div class="form-control">
                <label class="mb-0 font-bold label" for="parentesco">
                    <span class="label-text">Parentesco *</span>
                </label>
                <select id="parentesco" name="parentesco" class="w-full shadow-sm select" onchange="toggleComentario()">
                    <option value="">Seleccionar una opción</option>
                    <option value="ABUELA">abuela</option>
                    <option value="ABUELO">abuelo</option>
                    <option value="AMIGO">amigo</option>
                    <option value="CUÑADA">cuñada</option>
                    <option value="CUÑADO">cuñado</option>
                    <option value="ESPOSA">esposa</option>
                    <option value="ESPOSO">esposo</option>
                    <option value="HERMANA">hermana</option>
                    <option value="HERMANO">hermano</option>
                    <option value="HIJA">hija</option>
                    <option value="HIJO">hijo</option>
                    <option value="MADRE">madre</option>
                    <option value="NINGUNO">ninguno</option>
                    <option value="PADRE">padre</option>
                    <option value="PRIMA">prima</option>
                    <option value="PRIMO">primo</option>
                    <option value="SUEGRA">suegra</option>
                    <option value="SUEGRO">suegro</option>
                    <option value="TIA">tia</option>
                    <option value="TIO">tio</option>
                    <option value="OTROS">otros</option>
                </select>
            </div>
            <span class="text-error" id="error_parentesco"></span>
        </div>

        <div class="group" id="comentario" style="display: none;">
            <div>
                <label class="mb-0 font-bold label" for="comentario">
                    <span class="label-text">Especifique *</span>
                </label>
                <input id="comentario" name="comentario" class="w-full shadow-sm input" type="text"
                    value="">
            </div>
            <span class="text-error" id="error_comentario"></span>
        </div>
    </div>
    <div class="group">
        <!--[if BLOCK]><![endif]--> <button class="justify-start mt-2 text-white btn bg-neutral prev-btn"
            type="button" data-prev-step="step-2">
            Anterior
        </button>
        <!--[if ENDBLOCK]><![endif]-->
        <!--[if BLOCK]><![endif]--> <button class="justify-start mt-2 text-white btn bg-success next-btn"
            type="button" data-next-step="step-4">
            Siguiente
        </button>
        <!--[if ENDBLOCK]><![endif]-->
    </div>

</div>
