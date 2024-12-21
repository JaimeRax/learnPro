 <div class="flex-col p-2">
     <div class="grid grid-cols-1 gap-2 md:grid-cols-3">

         <div class="group">
             <div>
                 <label class="mb-0 font-bold label " for="charge_first_name">
                     <span class="label-text">
                         Primer nombre *
                     </span>

                 </label>
                 <input id="charge_first_name" name="charge_first_name" required="" class="w-full shadow-sm input"
                     type="text" value="">
             </div>
             <span class="text-error" id="error_primer_nombre_cliente"></span>
         </div>
         <div>
             <label class="mb-0 font-bold label " for="charge_second_name">
                 <span class="label-text">
                     Segundo nombre
                 </span>

             </label>
             <input id="charge_second_name" name="charge_second_name" class="w-full shadow-sm input" type="text"
                 value="">
         </div>
         <div class="group">
             <div>
                 <label class="mb-0 font-bold label " for="charge_first_lastname">
                     <span class="label-text">
                         Primer Apellido *
                     </span>

                 </label>
                 <input id="charge_first_lastname" name="charge_first_lastname" required=""
                     class="w-full shadow-sm input" type="text" value="">
             </div>
             <span class="text-error" id="error_primer_apellido_cliente"></span>
         </div>
         <div>
             <label class="mb-0 font-bold label " for="charge_second_lastname">
                 <span class="label-text">
                     Segundo apellido
                 </span>

             </label>
             <input id="charge_second_lastname" name="charge_second_lastname" class="w-full shadow-sm input"
                 type="text" value="">
         </div>

         <div class="group">
             <div>
                 <label class="mb-0 font-bold label " for="charge_dpi">
                     <span class="label-text">
                         DPI *
                     </span>

                 </label>
                 <input id="charge_dpi" name="charge_dpi" required="" class="w-full shadow-sm input" type="text"
                     minlength="13" maxlength="13" pattern="^\d{13}$" placeholder="Ingrese el número de documento"
                     value="">
             </div>
             <span class="text-error" id="error_dpi_cliente"></span>
         </div>

         <div class="group">
             <div>
                 <label class="mb-0 font-bold label " for="charge_phone">
                     <span class="label-text">
                         Teléfono *
                     </span>

                 </label>
                 <input id="charge_phone" name="charge_phone" required="" class="w-full shadow-sm input"
                     type="number" min="10000000" max="99999999" value="">
             </div>
             <span class="text-error" id="error_telefono"></span>

         </div>
         <div class="group">
             <div>
                 <label class="mb-0 font-bold label " for="charge_address">
                     <span class="label-text">
                         Direccion *
                     </span>

                 </label>
                 <input id="charge_address" name="charge_address" required="" class="w-full shadow-sm input"
                     type="text" value="">
             </div>
             <span class="text-error" id="error_referencia_casa"></span>
         </div>
         <div class="group">
             <div class="form-control">
                 <label class="mb-0 font-bold label" for="charge_relationship">
                     <span class="label-text">Parentesco *</span>
                 </label>
                 <select name="charge_relationship"class="w-full shadow-sm select parentesco"
                     onchange="toggleComentario(this)">
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
         <div class="group charge_comment" style="display: none;">
             <label class="mb-0 font-bold label" for="charge_comment">
                 <span class="label-text">Especifique *</span>
             </label>
             <input name="charge_comment" class="w-full shadow-sm input" type="text" value="">
         </div>

     </div>
     <div class="group">
         <button class="justify-start mt-2 text-white btn bg-neutral prev-btn"
             type="button" data-prev-step="step-2">
             Anterior
         </button>
          <button class="justify-start mt-2 text-white btn bg-success next-btn"
             type="button" data-next-step="step-3">
             Siguiente
         </button>
     </div>
 </div>

 <script src="{{ asset('js/student/formCreate.js') }}"></script>
