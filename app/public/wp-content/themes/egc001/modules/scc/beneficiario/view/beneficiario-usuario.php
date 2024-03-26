<?php

use EGC001\Modules\Core\CoreController;
use EGC001\Modules\Scc\Beneficiario\BeneficiarioController;

$atributos = CoreController::get_instance()->get_atributos('beneficiario');
$beneficiario = BeneficiarioController::get_instance();

?>
<section id="scc_usuarios" <?php echo $atributos['ocultarVista'] ?>>
   <div class="row">
      <div class="col-md-8">
         <div class="d-flex justify-content-center">
            <div class="col-md-6">
               <form id="mantener_usuario" enctype="multipart/form-data" class="needs-validation" novalidate>
                  <!-- Foto Usuario -->
                  <div class="col d-flex justify-content-center align-items-center my-3">
                     <div class="card">
                        <img id="imagennueva" src="<?php echo (get_user_meta(get_current_user_id(), 'custom_avatar', true)) ? wp_get_attachment_url(get_user_meta(get_current_user_id(), 'custom_avatar', true)) : EGC001_DIR_URI . '/assets/img/avatar03.png' ?>" class="object-fit-cover rounded" alt="Imágen del Usuario" style="width: 200px;">
                        <div class="card-img-overlay d-flex justify-content-center align-items-center">
                           <label class="display-1" for="usuario_imagen"><i class="fa-regular fa-file-image"></i></label>
                           <input type="file" name="usuario_imagen" id="usuario_imagen" multiple="false" hidden>
                        </div>
                     </div>
                  </div>
                  <!-- E-mail -->
                  <div class="col-md mb-3">
                     <label for="user_email" class="form-label">E-mail</label>
                     <input id="user_email" name="user_email" type="email" class="form-control" required>
                     <div class="invalid-feedback text-white">
                        Favor no dejar en blanco y en formato de email.
                     </div>
                  </div>
                  <!-- Nombre -->
                  <div class="col-md mb-3">
                     <label for="first_name" class="form-label">Nombre</label>
                     <input id="first_name" name="first_name" type="text" class="form-control" required>
                     <div class="invalid-feedback text-white">
                        Favor no dejar en blanco.
                     </div>
                  </div>
                  <!-- Apellido -->
                  <div class="col-md mb-3">
                     <label for="last_name" class="form-label">Apellido</label>
                     <input id="last_name" name="last_name" type="text" class="form-control" required>
                     <div class="invalid-feedback text-white">
                        Favor no dejar en blanco.
                     </div>
                  </div>
                  <!-- Usuario Ingreso -->
                  <div class="col-md mb-3">
                     <label for="user_login" class="form-label">Usuario de ingreso</label>
                     <input id="user_login" name="user_login" type="text" class="form-control" required>
                     <div class="invalid-feedback text-white">
                        Favor no dejar en blanco.
                     </div>
                  </div>
                  <!-- Contraseña -->
                  <div class="col-md mb-3">
                     <label for="user_pass" class="form-label">Contraseña</label>
                     <input id="user_pass" name="user_pass" type="text" class="form-control" required>
                     <div class="invalid-feedback text-white">
                        Favor no dejar en blanco.
                     </div>
                  </div>
                  <!-- Roles -->
                  <div id="roles" class="col mb-3">
                     <div class="mb-3">Roles</div>
                     <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="role" id="visualiza" value="1" checked>
                        <label class="form-check-label" for="visualizacion">Visualización</label>
                     </div>
                     <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="role" id="encargado" value="2">
                        <label class="form-check-label" for="encargado">Encargado(a)</label>
                     </div>
                     <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="role" id="administrador" value="3">
                        <label class="form-check-label" for="administrador">Administración</label>
                     </div>
                  </div>
                  <!-- Botones -->
                  <div class="form-group row mb-3">
                     <div class="col">
                        <button id="agregar_usuario" type="submit" class="btn btn-warning btn-sm disabled">Agregar</button>
                     </div>
                     <div class="col">
                        <button id="modificar_usuario" type="submit" name="modificar_usuario" class="btn btn-warning btn-sm disabled">Modificar</button>
                     </div>
                     <div class="col">
                        <button id="eliminar_usuario" type="submit" name="eliminar" class="btn btn-danger btn-sm disabled">Eliminar</button>
                     </div>
                     <div class="col">
                        <button id="btn_cancelar" type="button" class="btn btn-danger btn-sm">Cancelar</button>
                     </div>
                  </div>
                  <input type="hidden" name="action" value="scc_beneficiario_mantener_usuario">
                  <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('mantener_usuario') ?>">
                  <input type="hidden" name="endpoint" id="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
                  <input type="hidden" name="url" id="url_usuario" value="<?php echo get_site_url() . '/wp-json/wp/v2/users' ?>">
                  <input type="hidden" name="gestion" id="usuario_gestion">
                  <input type="hidden" name="post_id" id="usuario_post_id">
                  <input type="hidden" name="boton" id="boton_usuario">
               </form>
            </div>
         </div>
      </div>
      <div class="col-md-4">
         <?php get_template_part($atributos['sidebar'])
         ?>
      </div>
   </div>
</section>