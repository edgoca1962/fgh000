<?php

/**
 * 
 * Login Template
 * 
 * @package: EGC001
 */

use EGC001\Modules\Core\CoreController;

$core = CoreController::get_instance();
$atributos = $core->get_atributos();

?>
<style>
   .form-login>label::after {
      background: none !important;
   }

   .form-login>.form-control:focus~label,
   .form-login>.form-control:not(:placeholder-shown)~label,
   .form-login>.form-control-plaintext~label,
   .form-login>.form-select~label {
      color: rgba(var(--bs-info-rgb), 0.65);
      transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
   }
</style>
<section id="hero-page" class="d-flex flex-column justify-content-center align-items-center text-white" style="background: linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)), url(<?php echo $core->get_atributo('imagen') ?>) no-repeat center /cover; height: <?php echo $core->get_atributo('height') ?>;">
   <div class="col d-flex align-items-center justify-content-center">
      <div class='position-relative'>
         <div class="d-flex justify-content-center">
            <a href="<?php echo esc_url(site_url('/')) ?>" style="z-index:5">
               <img style="width: 100px; height:auto;" src="<?php echo (has_custom_logo()) ? wp_get_attachment_image_src(get_theme_mod('custom_logo'))[0] : EGC001_DIR_URI . '/assets/img/fghblanco.png' ?>" alt="Logo">
            </a>
         </div>
         <div class="ingreso-bg p-5 rounded-5 shadow" style="margin-top:-2.3rem; width:20rem;">
            <form class="needs-validation" id="ingreso" novalidate>
               <div class="form-floating form-login mb-3 border-bottom">
                  <input type="text" class="form-control bg-transparent border-0 shadow-none text-white" id="usuario" name="usuario" placeholder="usuario" required>
                  <label for="usuario">Usuario</label>
               </div>
               <div class="d-flex form-floating form-login mb-3 border-bottom">
                  <input type="password" class="form-control bg-transparent border-0 shadow-none text-white" id="clave" name="clave" placeholder="contraseña" required>
                  <label for="clave">Contraseña </label>
                  <span class="mt-4" id="ver_clave" style="font-size: 70%;"><i id="ver_clave_i" class="fa-solid fa-eye-slash"></i></i></span>
               </div>
               <div class="mb-4">
                  <input class="form-check-input" type="checkbox" value="" id="recordarme">
                  <label class="form-check-label fw-light" for="recordarme">
                     Recordarme
                  </label>
               </div>
               <div class="text-center form-group">
                  <button id="btn_login" type="submit" class="btn btn-warning btn-sm mb-3"><i class="fas fa-sign-in-alt"></i>
                     Ingresar</button>
               </div>
               <input type="hidden" name="action" value="ingresar">
               <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('frm_ingreso') ?>">
               <input type="hidden" name="redireccion" value="<?php echo site_url('/') ?>">
               <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
            </form>
         </div>
      </div>
   </div>
</section>