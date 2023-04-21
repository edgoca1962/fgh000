<nav class="main-navigation">
   <?php /*wp_nav_menu(array('theme_location' => 'menucabecera')); */ ?>
   <ul>
      <li <?php if (is_page('about-us') or wp_get_post_parent_id(0)) echo 'class="current-menu-item"' ?>><a href="<?= site_url('/about-us') ?>">About Us</a></li>
      <li <?php if (get_post_type() == 'programa') echo 'class="current-menu-item"' ?>><a href="<?= get_post_type_archive_link('programa') ?>">Programs</a></li>
      <li <?php if (get_post_type() == 'evento' or is_page('past-events')) echo 'class="current-menu-item"' ?>><a href="<?= get_post_type_archive_link('evento') ?>">Events</a></li>
      <li <?php if (get_post_type() == 'campus') echo 'class="current-menu-item"' ?>><a href="<?= get_post_type_archive_link('campus') ?>">Campuses</a></li>
      <li <?php if (get_post_type() == 'post') echo 'class="current-menu-item"' ?>><a href="<?= site_url('/blog'); ?>">Blog</a></li>
   </ul>
</nav>


<li class="dropstart">
   <a href="" class="dropdown-item dropdown-toggle" role="button" data-bs-auto-close="outside" data-bs-toggle="dropdown" aria-expanded="false">Item 3</a>
   <ul class="dropdown-menu">
      <li><a href="<?php echo esc_url(site_url('/sca-cambio-clave')) ?>" class="dropdown-item">Item 1</a></li>
      <li><a href="" class="dropdown-item">Item 2</a></li>
      <li><a href="" class="dropdown-item">Item 3</a></li>
      <li><a href="" class="dropdown-item">Item 4</a></li>
   </ul>
</li>