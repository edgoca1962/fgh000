<?php
get_header();
$imagen = get_template_directory_uri() . '/assets/img/peticiones.jpeg';
$height = '100vh'
?>
<div class="background-blend">
   <section id="hero-page" class="d-flex flex-column justify-content-center align-items-center text-white" style="background: linear-gradient(rgba(0,0,0,0.8),rgba(0,0,0,0.8)), url(<?= $imagen ?>) no-repeat center / cover; height: <?= $height ?>;">
      <div class="row">
         <main id="primary" style="margin-top: 20vh;">
            <?php
            while (have_posts()) :
               the_post();
               get_template_part('template-parts/content', 'login');
            endwhile; // End of the loop.
            ?>
         </main><!-- #main -->
      </div>
   </section>

   <?php
   get_footer();
