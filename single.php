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
<section class="background-blend py-5">
   <div class="<?php echo fgh000_get_param(get_post_type())['div0'] ?>">
      <div class="<?php echo fgh000_get_param(get_post_type())['div1'] ?>">
         <div class="<?php echo fgh000_get_param(get_post_type())['div2'] ?>">
            <?php if (have_posts()): ?>
               <?php
               while (have_posts()):
                  the_post();
                  get_template_part(fgh000_get_param(get_post_type())['templatepartsingle']);
               endwhile;
               ?>
            <?php else: ?>
               <?php get_template_part('modules/core/template-parts/core', 'none'); ?>
            <?php endif ?>
            <?php if (fgh000_get_param(get_post_type())['pag_ant'] != 0): ?>
               <?php get_template_part(fgh000_get_param(get_post_type())['btn_regresar']) ?>
            <?php endif; ?>
         </div>
         <?php if (get_post_type() == 'post'): ?>
            <div class="<?php echo fgh000_get_param(get_post_type())['div4'] ?>">
               <?php get_template_part(fgh000_get_param(get_post_type())['barra']) ?>
            </div>
         <?php else: ?>
            <div class="<?php echo fgh000_get_param(get_post_type())['div4'] ?>">
               <?php get_template_part(fgh000_get_param(get_post_type())['barra']) ?>
            </div>
         <?php endif; ?>
      </div>
   </div>
</section>
<?php
get_footer();