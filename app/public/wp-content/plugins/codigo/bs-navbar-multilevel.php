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
         <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item">
               <a class="nav-link" href="<?php echo esc_url(site_url('/')) ?>">Home</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                  Dropdown
               </a>
               <ul class="dropdown-menu">
                  <li class="dropstart">
                     <a class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" href="#">Submenu</a>
                     <ul class="dropdown-menu">
                        <li><a href="<?php echo esc_url(site_url('/core-csv-files')) ?>" class="dropdown-item">Import CSV Files</a></li>
                        <li><a href="#" class="dropdown-item">Item 2</a></li>
                        <li class="dropstart">
                           <a class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown" href="#">Submenu</a>
                           <ul class="dropdown-menu">
                              <li><a href="#" class="dropdown-item">Item 1</a></li>
                              <li><a href="#" class="dropdown-item">Item 2</a></li>
                              <li><a href="<?php echo esc_url(site_url('/core-cambio-clave')) ?>" class="dropdown-item">Item 3</a></li>
                           </ul>
                        </li>
                     </ul>
                  </li>
                  <li><a class="dropdown-item" href="#">Another action</a></li>
                  <li>
                     <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item" href="#">Something else here</a></li>
               </ul>
            </li>
            <li class="nav-item">
               <a class="nav-link disabled" aria-disabled="true">Disabled</a>
            </li>
            <li class="nav-item">
               <?php if (is_user_logged_in()) : ?>
                  <a class="nav-link" aria-current="page" href="<?= wp_logout_url('/') ?>"></span><i class="fas fa-sign-out-alt"></i> Salir</a>
               <?php else : ?>
                  <a class="nav-link" aria-current="page" href="<?= esc_url(site_url('/core-login')) ?>"><i class="fas fa-sign-in-alt"></i> Ingresar</a>
               <?php endif ?>
            </li>
         </ul>
      </div>
   </div>
</nav>

<style>
   @media (max-width: 576px) {

      /*dropend*/
      .dropdown-item::after {
         transform: rotate(90deg)
      }

      /* dropstart
      .dropdown-item::before {
         transform: rotate(-90deg)
      }*/
   }
</style>