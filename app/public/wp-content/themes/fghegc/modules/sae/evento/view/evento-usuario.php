<!-- Mantenimeinto de Usuarios para eventos -->
<form id="evento_usuario" class="needs-validation" novalidate>
   <div class="">
      <div class="row row-cols-md-3 g-3 mb-3">
         <div class="col-md">
            <label for="user_email" class="form-label">E-mail</label>
            <input id="user_email" name="user_email" type="email" class="form-control" required>
            <div class="invalid-feedback text-white">
               Favor no dejar en blanco y en formato de email.
            </div>
         </div>
         <div class="col-md">
            <label for="first_name" class="form-label">Nombre</label>
            <input id="first_name" name="first_name" type="text" class="form-control" required>
            <div class="invalid-feedback text-white">
               Favor no dejar en blanco.
            </div>
         </div>
         <div class="col-md">
            <label for="last_name" class="form-label">Apellido</label>
            <input id="last_name" name="last_name" type="text" class="form-control" required>
            <div class="invalid-feedback text-white">
               Favor no dejar en blanco.
            </div>
         </div>
         <div class="col-md">
            <label for="user_login" class="form-label">Usuario de ingreso</label>
            <input id="user_login" name="user_login" type="text" class="form-control" required>
            <div class="invalid-feedback text-white">
               Favor no dejar en blanco.
            </div>
         </div>
         <div class="col-md">
            <label for="user_pass" class="form-label">Contraseña</label>
            <input id="user_pass" name="user_pass" type="text" class="form-control" required>
            <div class="invalid-feedback text-white">
               Favor no dejar en blanco.
            </div>
         </div>
         <div class="col-md pt-md-4">
            <div class="form-check">
               <input class="form-check-input" type="checkbox" value="0" id="saeadmin" name="saeadmin">
               <label class="form-check-label" for="saeadmin">
                  Administrador(a) de Eventos
               </label>
            </div>
            <div class="form-check">
               <input class="form-check-input" type="checkbox" value="0" id="saecoord" name="saecoord">
               <label class="form-check-label" for="saecoord">
                  Coordinador(a) de Eventos
               </label>
            </div>
         </div>
      </div>
   </div>
   <div class="d-flex justify-content-center mt-5">
      <div class="">
         <button id="agregar_usuario_evento" type="submit" class="btn btn-warning disabled">Agregar Usuario</button>
         <button id="modificar_usuario_evento" type="submit" class="btn btn-warning mx-3 disabled">Modificar
            Usuario</button>
         <button id="eliminar_usuario_evento" type="submit" class="btn btn-danger disabled">Eliminar Usuario</button>
      </div>
   </div>
   <input type="hidden" name="action" value="evento_usuario">
   <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('evento_usuario') ?>">
   <input type="hidden" name="endpoint" id="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
   <input type="hidden" name="url" id="url_usuario" value="<?php echo get_site_url() . '/wp-json/wp/v2/users' ?>">
   <input type="hidden" name="gestion" id="usuario_gestion">
   <input type="hidden" name="user_id" id="usuario_id">
   <input type="hidden" name="boton" id="boton_usuario">
   <input type="hidden" name="titulo_confirmar" id="usuario_titulo_confirmar">
</form>