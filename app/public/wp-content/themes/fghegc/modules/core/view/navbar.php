<?php

use FGHEGC\Modules\Core\CoreController;

$atributos = CoreController::get_instance()->get_atributos(get_post_type());

?>
<header>
   <nav id="main_navbar" class="navbar navbar-expand-lg navbar-dark fixed-top shadow">
      <div class="container-fluid">
         <div id="logo" class="navbar-brand logo">
            <div class="d-flex justify-content-center">
               <a href="<?= esc_url(site_url('/')) ?>">
                  <img style="width: 50px; height:auto;" src="<?php echo (has_custom_logo()) ? wp_get_attachment_image_src(get_theme_mod('custom_logo'))[0] : FGHEGC_DIR_URI . '/assets/img/fghblanco.png' ?>" alt="Logo">
               </a>
            </div>
         </div>
         <button id="btnmenu" class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
         </button>
         <div class="justify-content-end collapse navbar-collapse" id="navbarSupportedContent">
            <?php
            if (is_user_logged_in()) {
               wp_nav_menu(
                  array(
                     'theme_location' => 'principal',
                     'container' => false,
                     'menu_class' => 'nav navbar-nav ms-auto mb-2 mb-lg-0',
                     'walker' => new Walker_Nav_Primary()
                  )
               );
            }
            if ($atributos['userAdmin']) {
               wp_nav_menu(
                  array(
                     'theme_location' => 'administrador',
                     'container' => false,
                     'menu_class' => 'nav navbar-nav mb-2 mb-lg-0',
                     'walker' => new Walker_Nav_Primary()
                  )
               );
            }
            ?>
            <div id="btn_menu" class="navbar nav-item ms-2">
               <button type="button" class="btn btn-warning">
                  <?php if (is_user_logged_in()) : ?>
                     <a class="nav-link text-dark" aria-current="page" href="<?= wp_logout_url('/') ?>"></span><i class="fas fa-sign-out-alt"></i> Salir</a>
                  <?php else : ?>
                     <a class="nav-link text-dark" aria-current="page" href="<?= esc_url(site_url('/core-login')) ?>"><i class="fas fa-sign-in-alt"></i> Ingresar</a>
                  <?php endif ?>
               </button>
            </div>
         </div>
      </div>
   </nav>
</header>