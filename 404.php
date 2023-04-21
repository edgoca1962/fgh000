<?php

/**
 * The main template file
 *
 * @package Aplicación_Web
 */
get_header();
?>
<header>
   <?php
   get_template_part('modules/core/template-parts/core', 'header-banner');
   get_template_part('modules/core/template-parts/core', 'header-nav');
   ?>
</header>
<?php if (!fgh000_get_param(get_post_type())['fullpage']): ?>
   <section
      class="<?php echo isset(fgh000_get_param(get_post_type())['div0']) ? fgh000_get_param(get_post_type())['div0'] : '' ?>">
      <div
         class="<?php echo isset(fgh000_get_param(get_post_type())['div1']) ? fgh000_get_param(get_post_type())['div1'] : '' ?>">
         <?php
         if (isset($_GET['cpt'])) {
            $postType = sanitize_text_field($_GET['cpt']);
            if (isset(fgh000_get_param($postType)['template404'])) {
               get_template_part(fgh000_get_param($postType)['template404']);
            } else {
               echo '<h3>La información consultada no puede ser mostrada.</h3>';
            }
         } else {
            echo '<h3>La información consultada no puede ser mostrada.</h3>';
         }
         ?>
      </div>
      <?php get_footer(); ?>
   </section>
<?php else: ?>
   <?php get_footer(); ?>
<?php endif; ?>
