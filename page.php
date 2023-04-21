<?php

/**
 * The main template file
 *
 * @package Aplicación_Web
 */
get_header();
?>
<?php if (is_user_logged_in()): ?>
   <header>
      <?php
      get_template_part('modules/core/template-parts/core', 'header-banner');
      get_template_part('modules/core/template-parts/core', 'header-nav');
      ?>
   </header>
   <section
      class="<?php echo isset(fgh000_get_param(get_post_type())['div0']) ? fgh000_get_param(get_post_type())['div0'] : '' ?>">
      <?php if (have_posts()): ?>
         <?php while (have_posts()) {
            the_post(); ?>
            <?php if (!fgh000_get_param(get_post_type())['fullpage']): ?>
               <div
                  class="<?php echo isset(fgh000_get_param(get_post_type())['div1']) ? fgh000_get_param(get_post_type())['div1'] : '' ?>">
                  <?php if (the_content()) {
                     echo 'Hola';
                     the_content();
                  } else {
                     get_template_part(fgh000_get_param(get_post_type())['templatepart']);
                  }
                  if (comments_open() || get_comments_number()) {
                     comments_template();
                  } ?>
               </div>
            <?php endif; ?>
         <?php } ?>
      <?php else: ?>
         <?php get_template_part('modules/core/template-parts/core', 'none'); ?>
      <?php endif; ?>
      <?php get_footer(); ?>
   </section>
<?php else: ?>
   <header>
      <?php
      if (is_page('core-login')) {
         get_template_part(fgh000_get_param(get_post_type())['templatepart']);
      } else {
         get_template_part('modules/core/template-parts/core', 'header-banner');
         get_template_part('modules/core/template-parts/core', 'header-nav');
      }
      ?>
   </header>
   <?php get_footer(); ?>
<?php endif; ?>
