<?php

use EGC001\Modules\Core\CoreController;

/**
 * 
 * Plantilla para Página Principal Beneficiarios(as)
 * 
 * @package:EGC001
 * 
 */

$atributos = CoreController::get_instance();

?>
<section id="hero-page" class="d-flex flex-column justify-content-center align-items-center text-white" style="background: linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)), url(<?php echo $atributos->get_atributo('imagen') ?>) no-repeat center /cover; height: <?php echo $atributos->get_atributo('height') ?>;">
   <div id="logo" class="navbar-brand logo">
      <div class="d-flex justify-content-center animate__animated animate__fadeInDown">
         <a href="<?= esc_url(site_url('/')) ?>">
            <img class="rounded-circle" style="width: 200px; height:auto;" src="<?php echo (has_custom_logo()) ? wp_get_attachment_image_src(get_theme_mod('custom_logo'))[0] : EGC001_DIR_URI . '/assets/img/fghblanco.png' ?>" class="rounded bg-white" alt="Logo">
         </a>
      </div>
   </div>
   <p class="animate__animated animate__fadeInDown mb-3 text-center  <?php echo $atributos->get_atributo('fontweight') ?>  <?php echo $atributos->get_atributo('display') ?>">
      <?php echo $atributos->get_atributo('titulo') ?></p>
   <p class="animate__animated animate__fadeInUp mb-3 text-center fw-lighter fs-3">
      <?php echo $atributos->get_atributo('subtitulo') ?></p>
   <p class="animate__animated animate__fadeInUp text-center  fs-5 fw-lighter">
      <?php echo  $atributos->get_atributo('subtitulo2') ?></p>
</section>