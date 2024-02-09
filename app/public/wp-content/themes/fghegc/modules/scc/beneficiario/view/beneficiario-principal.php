<?php

use FGHEGC\Modules\Core\CoreController;
use FGHEGC\Modules\Scc\Beneficiario\BeneficiarioController;

$core = CoreController::get_instance();
$atributos = $core->get_atributos('beneficiario');
$provincias = BeneficiarioController::get_instance()->scc_get_provincias();

?>

<div class="row">
   <div class="col-md-8">
      <h2 class="mb-3 text-center">Información del beneficiario(a)</h2>
      <form id="beneficiario" enctype="multipart/form-data" class="needs-validation" novalidate>
         <div class="col d-flex justify-content-center align-items-center my-3">
            <div style="height: 205px; overflow:hidden; ">
               <div class="card h-100">
                  <img id="imagennueva" src="<?php echo FGHEGC_DIR_URI . '/assets/img/avatar01.png' ?>" class="card-img h-100" alt="Imágen del beneficiario">
                  <div class="card-img-overlay d-flex justify-content-center align-items-center">
                     <label class="display-1" for="beneficiario_imagen"><i class="fa-regular fa-file-image"></i></label>
                     <input type="file" name="beneficiario_imagen" id="beneficiario_imagen" multiple="false" hidden>
                  </div>
               </div>
            </div>
         </div><!-- Foto beneficiario -->
         <div class="form-group row">
            <div class="col-md-4 mb-3">
               <label class="form-label">Nombre</label>
               <input type="text" name="nombre" placeholder="Nombre" class="form-control" required>
               <div class="invalid-feedback">
                  Por favor indicar un nombre.
               </div>
            </div>
            <div class="col-md-4 mb-3">
               <label class="form-label">Primer Apellido</label>
               <input type="text" name="p_apellido" placeholder="Primer Apellido" class="form-control" required>
               <div class="invalid-feedback">
                  Por favor indicar un apellido.
               </div>
            </div>
            <div class="col-md-4 mb-3">
               <label class="form-label">Segundo Apellido</label>
               <input type="text" name="s_apellido" placeholder="Segundo Apellido" class="form-control" required>
               <div class="invalid-feedback">
                  Por favor indicar un apellido.
               </div>
            </div>
         </div><!-- Nombre y apellidos -->
         <div class="form-group row">
            <div class="col-md-4 mb-3">
               <label class="form-label">Fecha Nacimiento</label>
               <input type="date" name="f_nacimiento" placeholder="Fecha de Nacimiento" class="form-control" id="f_nacimiento" required>
               <div class="invalid-feedback">
                  Por favor indicar la fecha de nacimiento.
               </div>
            </div>
            <div class="col-md-4 mb-3">
               <label class="form-label">Fecha Ingreso</label>
               <input type="date" name="f_ingreso" placeholder="Fecha de Ingreso" class="form-control" required>
               <div class="invalid-feedback">
                  Por favor indicar la fecha de ingreso.
               </div>
            </div>
            <div class="col-md-4 mb-3">
               <label class="form-label">Fecha Salida</label>
               <input type="date" name="f_salida" placeholder="Fecha de Salida" class="form-control">
            </div>
         </div><!-- fecha nacimiento, ingreso y salida -->
         <div class="form-group row">
            <div class="col-md-4 mb-3">
               <label class="form-label">Edad</label>
               <input type="text" name="edad" placeholder="Edad (este dato se calcula)" class="form-control" id="edad" disabled>
            </div>
            <div class="col-md-4 mb-3">
               <label class="form-label">Peso (kg)</label>
               <input type="text" name="peso" placeholder="Peso en kilos" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
               <label class="form-label">Estatura (m)</label>
               <input type="text" name="estatura" placeholder="Estatura en metros" class="form-control">
            </div>
         </div><!-- Edad, peso y estatura -->
         <div class="form-group row">
            <div class="col-md-4 mb-3">
               <label class="form-label">Provincia</label>
               <select id="provincia" name="provincia" class="form-select" aria-label="Provincias">
                  <option selected>Seleccionar Provincia</option>
                  <?php foreach ($provincias as $provincia) : ?>
                     <option value="<?php echo $provincia['ID'] ?> "><?php echo $provincia['provincia'] ?></option>
                  <?php endforeach; ?>
               </select>
            </div>
            <div class="col-md-4 mb-3">
               <label class="form-label">Cantón</label>
               <select id="canton" name="canton" class="form-select" aria-label="Cantones">
                  <option selected>Seleccionar Cantón</option>
               </select>
               <input id="nonce_canton" type="hidden" name="nonce_canton" value="<?php echo wp_create_nonce('cantones') ?>">
               <input id="action_canton" type="hidden" name="action_canton" value="canton">
            </div>
            <div class="col-md-4 mb-3">
               <label class="form-label">Distrito</label>
               <select id="distrito" name="distrito" class="form-select" aria-label="Distritos">
                  <option selected>Seleccionar Distrito</option>
               </select>
               <input id="nonce_distrito" type="hidden" name="nonce_distrito" value="<?php echo wp_create_nonce('distritos') ?>">
               <input id="action_distrito" type="hidden" name="action_distrito" value="distrito">
            </div>
         </div><!-- Provincia, Cantón y Distrito -->
         <div class="form-group mb-3">
            <label class="form-label">Detalle de dirección</label>
            <input name="direccion" class="form-control" placeholder="Espacio para detallar la dirección"></input>
         </div><!-- dirección detallada -->
         <div class="form-group row">
            <div class="col-md-4 mb-3">
               <label class="form-label">e-mail</label>
               <input type="email" name="email" placeholder="e-mail" class="form-control" required>
               <div class="invalid-feedback">
                  Por favor indicar un correo válido.
               </div>
            </div>
            <div class="col-md-4 mb-3">
               <label class="form-label">Teléfono Principal</label>
               <input type="text" name="t_principal" placeholder="Teléfono principal" class="form-control" required>
               <div class="invalid-feedback">
                  Por favor indicar un teléfono móvil.
               </div>
            </div>
            <div class="col-md-4 mb-3">
               <label class="form-label">Otros Teléfonos</label>
               <input type="text" name="t_otros" placeholder="Otros Teléfonos" class="form-control">
            </div>
         </div><!-- correo y teléfono -->
         <div class="form-group row">
            <div class="col-md-4 mb-3">
               <label class="form-label">Nombre de la Madre o Tutor(a)</label>
               <input type="text" name="n_madre" placeholder="Nombre de la madre o tutor(a)" class="form-control" required>
               <div class="invalid-feedback">
                  Por favor indicar un nombre de la madre o tutor.
               </div>
            </div>
            <div class="col-md-4 mb-3">
               <label class="form-label">Nombre del Padre</label>
               <input type="text" name="n_padre" placeholder="Nombre del padre" class="form-control" required>
               <div class="invalid-feedback">
                  Por favor indicar un nombre del padre.
               </div>
            </div>
         </div><!-- Madre, Tutor, Padre -->
         <div class="form-group mb-3">
            <label for="content" class="form-label fs-4">Rerseña</label>
            <textarea name="content" cols="30" rows="5" class="form-control" placeholder="Reseña del beneficiario"></textarea>
         </div><!-- Reseña -->
         <div class="form-group mb-3">
            <div class="col">
               <button type="submit" class="btn btn-warning mb-3"><span><i class="fa-solid fa-floppy-disk"></i></span> Guardar</button>
            </div>
         </div>
         <input type="hidden" name="action" value="beneficiario">
         <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('beneficiarios') ?>">
         <input id="endpoint" type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
         <input type="hidden" name="msgtxt" value="Gracias por enviarnos tu petición. Estaremos contactándote lo antes posible.">
      </form>
   </div>
   <div class="col-md-4">
      <?php get_template_part($atributos['sidebar'])
      ?>
   </div>
</div>