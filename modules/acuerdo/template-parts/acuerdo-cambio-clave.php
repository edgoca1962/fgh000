<section class="d-flex justify-content-center pt-5">
   <div class="card text-black shadowcss" style="width:34rem;">
      <div class="card-body">
         <h3 class="card-title text-center">Cambiar Contraseña</h3>
         <form id="cambiar_clave" class="row g-3 needs-validation" novalidate>
            <div class="row gy-2 gx-3 align-items-center">
               <div class="col-md-6 mb-3">
                  <label for="clave_actual" class="form-label">Contraseña Actual</label>
                  <div class="input-group mb-3">
                     <input id="clave_actual" type="password" class="form-control" name="clave_actual" required>
                     <span class="input-group-text rounded-end" id="ver_clave_actual"><i class="fa-solid fa-eye-slash"></i></i></span>
                     <div class="invalid-feedback">
                        Favor no dejar en blanco.
                     </div>
                  </div>
               </div>
            </div>
            <div class="row gy-2 gx-3 align-items-center mb-5">
               <div class="col-md-6 mb-3">
                  <label for="clave_nueva" class="form-label">Nueva Contraseña</label>
                  <div class="input-group">
                     <input id="clave_nueva" type="password" class="form-control" name="clave_nueva" value="" required>
                     <span id="ver_nueva_clave" class="input-group-text rounded-end"><i id="ojo1" class="fa-solid fa-eye-slash"></i></span>
                     <div class="invalid-feedback">
                        Favor no dejar en blanco.
                     </div>
                  </div>
               </div>
               <div class="col-md-6 mb-3">
                  <label for="clave_nueva2" class="form-label">Comprobación</label>
                  <div class="input-group">
                     <input id="clave_nueva2" type="password" class="form-control" name="clave_nueva2" value="" required>
                     <span id="ver_nueva_clave2" class="input-group-text rounded-end"><i id="ojo2" class="fa-solid fa-eye-slash"></i></span>
                     <div class="invalid-feedback">
                        Favor no dejar en blanco.
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col text-center form-group mb-3">
                  <button type="submit" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cambiarclave">
                     <span class="me-1"><i id="ojo3" class="fa-solid fa-key"></i></span>Cambiar contraseña
                  </button>
               </div>
            </div>
            <input type="hidden" name="action" value="cambiar_clave">
            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('cambiar_clave') ?>">
            <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
            <input type="hidden" name="msgtxt" value="Cambio de clave exitoso.">
         </form>
      </div>
   </div>
</section>