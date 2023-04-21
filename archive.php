<?php

/**
 * The main template file.
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
<?php if (is_user_logged_in()): ?>
   <section class="background-blend">
      <?php if (!fgh000_get_param(get_post_type())['fullpage']): ?>
         <div
            class="<?php echo isset(fgh000_get_param(get_post_type())['div0']) ? fgh000_get_param(get_post_type())['div0'] : 'container' ?>">
            <?php if (have_posts()): ?>
               <?php if (fgh000_get_param(get_post_type())['userAdmin']): ?>
                  <?php
                  if (isset(fgh000_get_param(get_post_type())['agregarpost'])) {
                     get_template_part(fgh000_get_param(get_post_type())['agregarpost']);
                  }
                  ?>
               <?php endif; ?>
               <div
                  class="<?php echo isset(fgh000_get_param(get_post_type())['div1']) ? fgh000_get_param(get_post_type())['div1'] : '' ?>">
                  <div
                     class="<?php echo isset(fgh000_get_param(get_post_type())['div2']) ? fgh000_get_param(get_post_type())['div2'] : '' ?>">
                     <div
                        class="<?php echo isset(fgh000_get_param(get_post_type())['div3']) ? fgh000_get_param(get_post_type())['div3'] : '' ?>">
                        <?php while (have_posts()): ?>
                           <?php
                           the_post();
                           if (isset(fgh000_get_param(get_post_type())['templatepart'])) {
                              get_template_part(fgh000_get_param(get_post_type())['templatepart']);
                           } else {
                              the_content();
                           }
                           ?>
                        <?php endwhile; ?>
                     </div>
                     <div class="my-3">
                        <?php twenty_twenty_one_the_posts_navigation() ?>
                     </div>
                  </div>
                  <div
                     class="<?php echo isset(fgh000_get_param(get_post_type())['div4']) ? fgh000_get_param(get_post_type())['div4'] : '' ?>">
                     <?php
                     if (isset(fgh000_get_param(get_post_type())['barra'])) {
                        get_template_part(fgh000_get_param(get_post_type())['barra']);
                     }
                     ?>
                  </div>
               </div>
            <?php else: ?>
               <?php
               if (isset(fgh000_get_param()['templatenone'])) {
                  get_template_part(fgh000_get_param()['templatenone']);
               } else {
                  echo '<h3>No hay información registrada.</h3>';
               }
               ?>
            <?php endif; ?>
         </div>
      <?php endif; ?>
   </section>
   <?php get_footer() ?>
<?php else: ?>
   <?php
   get_footer()
      ?>
<?php endif; ?>
