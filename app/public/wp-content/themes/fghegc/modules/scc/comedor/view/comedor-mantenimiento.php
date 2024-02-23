<?php

use FGHEGC\Modules\Core\CoreController;
use FGHEGC\Modules\Scc\Beneficiario\BeneficiarioController;

$core = CoreController::get_instance();
$atributos = $core->get_atributos('beneficiario');
$provincias = BeneficiarioController::get_instance()->scc_get_provincias();
$encargados = get_users(['role' => 'comedores', 'orderby' => 'nicename']);

?>
<section>
   <div class="row">
      <div class="col-md-8">
         <h2 class="mb-3 text-center">Información del Comedor</h2>
         <form id="comedor" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="col d-flex justify-content-center align-items-center my-3">
               <div style="width: 200px; overflow:hidden; ">
                  <div class="card h-100">
                     <img id="imagennueva" src="<?php echo FGHEGC_DIR_URI . '/assets/img/scccomedor.png' ?>" class="card-img h-100" alt="Imágen del comedor">
                     <div class="card-img-overlay d-flex justify-content-center align-items-center">
                        <label class="display-1" for="comedor_imagen"><i class="fa-regular fa-file-image"></i></label>
                        <input type="file" name="comedor_imagen" id="comedor_imagen" multiple="false" hidden>
                     </div>
                  </div>
               </div>
            </div><!-- Foto comedor -->
            <div class="form-group row">
               <div class="col-md mb-3">
                  <label class="form-label">Nombre</label>
                  <input type="text" name="nombre" placeholder="Nombre" class="form-control" required>
                  <div class="invalid-feedback">
                     Por favor indicar un nombre.
                  </div>
               </div>
            </div><!-- Nombre Comedor -->
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
                  <label class="form-label">Teléfono Principal</label>
                  <input type="text" name="t_principal" placeholder="Teléfono principal" class="form-control" required>
                  <div class="invalid-feedback">
                     Por favor indicar un teléfono móvil.
                  </div>
               </div>
               <div class="col-md-4 mb-3">
                  <label class="form-label">e-mail</label>
                  <input type="text" name="email" placeholder="e-mail" class="form-control" required>
                  <div class="invalid-feedback">
                     Por favor indicar un correo válido.
                  </div>
               </div>
               <div class="col-md-4 mb-3">
                  <label class="form-label">Encargado(a)</label>
                  <select name="contacto_id" id="contacto_id" class="form-select" aria-label="Provincias">
                     <option selected>Seleccionar Encargado</option>
                     <?php foreach ($encargados as $encargado) : ?>
                        <option value="<?php echo $encargado->ID ?>"><?php echo $encargado->display_name ?></option>
                     <?php endforeach; ?>
                  </select>
               </div>
            </div><!-- teléfono y contacto -->
            <div class="form-group mb-3">
               <button type="submit" class="btn btn-warning btn-sm mb-3 me-5"><span><i class="fa-solid fa-floppy-disk"></i></span> Guardar</button>
               <button id="btn_cancelar" type="btn" class="btn btn-sm btn-danger mb-3">Cancelar</button>
            </div><!-- Botones Guardar y Cancelar -->
            <input type="hidden" name="post_id" value="<?php the_ID() ?>">
            <input type="hidden" name="action" value="comedor_agregar">
            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('comedores') ?>">
            <input id="endpoint" type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
         </form>
      </div>
      <div class="col-md-4">
         <?php get_template_part($atributos['sidebar']); ?>
      </div>
   </div>
</section>