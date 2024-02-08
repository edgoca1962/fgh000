<?php

use FGHEGC\Modules\Core\CoreController;
use FGHEGC\Modules\Scc\Beneficiario\BeneficiarioController;

$core = CoreController::get_instance();
$atributos = $core->get_atributos('beneficiario');
$divpolcri = BeneficiarioController::get_instance();

?>

<div class="row">
   <div class="col col-md-8">
      <h2 class="mb-3 text-center">Información del beneficiario</h2>
      <form id="beneficiario" class="needs-validation" novalidate>
         <div class="col d-flex justify-content-center align-items-center my-3">
            <img src="<?php echo FGHEGC_DIR_URI . '/assets/img/avatar01.png' ?>" class="rounded-circle bg-white" alt="beneficiario" style="width: 200px;">
         </div>
         <div class="form-group row">
            <div class="col-md mb-3">
               <input type="text" name="nombre" placeholder="Nombre" class="form-control" required>
               <div class="invalid-feedback">
                  Por favor indicar un nombre.
               </div>
            </div>
            <div class="col-md mb-3">
               <input type="text" name="p_apellido" placeholder="Primer Apellido" class="form-control" required>
               <div class="invalid-feedback">
                  Por favor indicar un apellido.
               </div>
            </div>
            <div class="col-md mb-3">
               <input type="text" name="s_apellido" placeholder="Segundo Apellido" class="form-control" required>
               <div class="invalid-feedback">
                  Por favor indicar un apellido.
               </div>
            </div>
         </div>
         <div class="form-group row">
            <div class="col-md mb-3">
               <label for="f_nacimiento" class="form-label">Fecha Nacimiento</label>
               <input type="date" name="f_nacimiento" placeholder="Fecha Nacimiento" class="form-control" required>
               <div class="invalid-feedback">
                  Por favor indicar la fecha de nacimiento.
               </div>
            </div>
            <div class="col-md mb-3">
               <label for="f_ingreso" class="form-label">Fecha Ingreso</label>
               <input type="date" name="f_ingreso" placeholder="Fecha Nacimiento" class="form-control" required>
               <div class="invalid-feedback">
                  Por favor indicar la fecha de ingreso.
               </div>
            </div>
            <div class="col-md mb-3">
               <label for="" class="form-label">Fecha Salida</label>
               <input type="date" name="f_nacimiento" placeholder="Fecha Nacimiento" class="form-control">
            </div>
         </div>
         <div class="form-group row">
            <div class="col-md mb-3">
               <select id="provincia" class="form-select" aria-label="Provincias">
                  <option selected>Seleccionar Provincia</option>
                  <?php foreach ($divpolcri->get_provincias() as $provincia) : ?>
                     <option value="<?php echo $provincia['ID'] ?> "><?php echo $provincia['provincia'] ?></option>
                  <?php endforeach; ?>
               </select>
            </div>
            <div class="col-md mb-3">
               <select id="canton" class="form-select" aria-label="Cantones">
                  <option selected>Seleccionar Cantón</option>
               </select>
               <input id="nonce_canton" type="hidden" name="nonce_canton" value="<?php echo wp_create_nonce('cantones') ?>">
               <input id="action_canton" type="hidden" name="action_canton" value="canton">
            </div>
            <div class="col-md mb-3">
               <select id="distrito" class="form-select" aria-label="Distritos">
                  <option selected>Seleccionar Distrito</option>
               </select>
               <input id="nonce_distrito" type="hidden" name="nonce_distrito" value="<?php echo wp_create_nonce('distritos') ?>">
               <input id="action_distrito" type="hidden" name="action_distrito" value="distrito">
            </div>
         </div>
         <div class="form-group mb-3">
            <textarea name="peticion" cols="30" rows="5" class="form-control" placeholder="Espacio para detallar la dirección"></textarea>
         </div>
         <div class="form-group row">
            <div class="col-lg-6 mb-3">
               <input type="email" name="email" placeholder="e-mail" class="form-control" required>
               <div class="invalid-feedback">
                  Por favor indicar un correo válido.
               </div>
            </div>
            <div class="col-lg-6 mb-3">
               <input type="text" name="telefono" placeholder="Teléfono móvil" class="form-control" required>
               <div class="invalid-feedback">
                  Por favor indicar un teléfono móvil.
               </div>
            </div>
         </div>
         <div class="form-group row">
            <div class="col-md mb-3">
               <input type="text" name="nombre" placeholder="Nombre de la madre" class="form-control" required>
               <div class="invalid-feedback">
                  Por favor indicar un nombre de la madre.
               </div>
            </div>
            <div class="col-md mb-3">
               <input type="text" name="nombre" placeholder="Nombre del padre" class="form-control" required>
               <div class="invalid-feedback">
                  Por favor indicar un nombre del padre.
               </div>
            </div>
         </div>
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
   <!-- <div class="col col-md-4">
      <h3>Sidebar</h3>
      <?php get_template_part('')
      ?>
   </div> -->
</div>