<?php

/**
 * 
 * Template Name: Cambio-Clave
 * Plantilla para cambio de clave
 * 
 * @package: EGC001
 */
?>
<style>
   .form-floating>label::after {
      background: none !important;
   }

   .form-floating>.form-control:focus~label,
   .form-floating>.form-control:not(:placeholder-shown)~label,
   .form-floating>.form-control-plaintext~label,
   .form-floating>.form-select~label {
      color: rgba(var(--bs-info-rgb), 0.65);
      transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
   }
</style>
<section class="d-flex justify-content-center pt-5">
   <div class="col-md-6">
      <form id="cambiar_clave" class="row g-3 needs-validation" novalidate>
         <div class="row mb-3">
            <div class="col-10 me-0 pe-0">
               <div class="form-floating">
                  <input id="clave_actual" name="clave_actual" type="password" class="form-control bg-transparent shadow-none text-white rounded-0 border-0 border-bottom border-1" placeholder="Contraseña" required>
                  <label for="clave_actual">Contraseña Actual</label>
                  <div class="invalid-feedback">
                     Favor no dejar en blanco.
                  </div>
               </div>
            </div>
            <div class="d-flex align-items-center col-2 ms-0 ps-0">
               <span class="input-group-text bg-transparent text-white border-0" id="ver_clave_actual"><i id="ver_clave_actual_i" class="fa-solid fa-eye-slash"></i></i></span>
            </div>
         </div>
         <div class="row mb-3">
            <div class="col-10 me-0 pe-0">
               <div class="form-floating">
                  <input id="clave_nueva" type="password" class="form-control bg-transparent shadow-none text-white rounded-0 border-0 border-bottom border-1" name="clave_nueva" placeholder="Nueva Contraseña" required>
                  <label for="clave_nueva" class="form-label">Nueva Contraseña</label>
                  <div class="invalid-feedback">
                     Favor no dejar en blanco.
                  </div>
               </div>
            </div>
            <div class="d-flex align-items-center col-2 ms-0 ps-0">
               <span id="ver_nueva_clave" class="input-group-text bg-transparent text-white border-0"><i id="ojo1" class="fa-solid fa-eye-slash"></i></span>
            </div>
         </div>
         <div class="row mb-3">
            <div class="col-10">
               <div class="form-floating">
                  <input id="clave_nueva2" type="password" class="form-control bg-transparent shadow-none text-white rounded-0 border-0 border-bottom border-1" name="clave_nueva2" placeholder="Comprobación" required>
                  <label for="clave_nueva2" class="form-label">Comprobación</label>
                  <div class="invalid-feedback">
                     Favor no dejar en blanco.
                  </div>
               </div>
            </div>
            <div class="d-flex align-items-center col-2 ms-0 ps-0">
               <span id="ver_nueva_clave2" class="input-group-text bg-transparent text-white border-0"><i id="ojo2" class="fa-solid fa-eye-slash"></i></span>
            </div>
         </div>
         <div class="row mt-5">
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
</section>