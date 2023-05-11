<header>
   <nav id="main_navbar" class="navbar navbar-expand-lg navbar-dark fixed-top shadow">
      <div class="container">
         <div id="logo" class="navbar-brand logo">
            <?php
            if (has_custom_logo()) { ?>
               <div class="d-flex justify-content-center">
                  <a href="<?= esc_url(site_url('/')) ?>">
                     <img class="bg-transparent" style="width: 60px; height:auto;"
                        src="<?= wp_get_attachment_image_src(get_theme_mod('custom_logo'))[0] ?>" alt="Logo">
                  </a>
               </div>
               <?php
            }
            ?>
         </div>
         <button id="btnmenu" class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
         </button>
         <div class="justify-content-end collapse navbar-collapse" id="navbarSupportedContent">
            <?php if (is_user_logged_in()): ?>
               <?php
               wp_nav_menu(
                  array(
                     'theme_location' => 'principal',
                     'container' => false,
                     'menu_class' => 'nav navbar-nav ms-auto mb-2 mb-lg-0',
                     'walker' => new Walker_Nav_Primary()
                  )
               );
               ?>
            <?php endif; ?>
            <div id="btn_menu" class="navbar nav-item">
               <button type="button" class="btn btn-warning btn-sm">
                  <?php if (is_user_logged_in()): ?>
                     <a class="nav-link text-dark" aria-current="page" href="<?= wp_logout_url('/') ?>"></span><i
                           class="fas fa-sign-out-alt"></i> Salir</a>
                  <?php else: ?>
                     <a class="nav-link text-dark" aria-current="page" href="<?= esc_url(site_url('/core-login')) ?>"><i
                           class="fas fa-sign-in-alt"></i> Ingresar</a>
                  <?php endif ?>
               </button>
            </div>
         </div>
      </div>
   </nav>
</header>
<input type="hidden" name="" id="userAdmin" value="<?php echo fgh000_get_param(get_post_type())['userAdmin'] ?>">
