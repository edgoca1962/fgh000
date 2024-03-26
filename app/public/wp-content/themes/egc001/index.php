<?php

/**
 * 
 * Plantilla principal
 * 
 * @package: EGC001
 */

use EGC001\Modules\Core\CoreController;

$core = CoreController::get_instance();
$atributos = $core->get_atributos();

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
   <meta charset="<?php bloginfo('charset'); ?>">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="profile" href="https://gmpg.org/xfn/11">

   <?php wp_head(); ?>
</head>

<body class="<?php echo $core->get_atributo('body') ?>" <?php body_class(); ?>>
   <?php wp_body_open(); ?>
   <header>
      <?php get_template_part($core->get_atributo('banner'))  ?>
      <?php get_template_part($core->get_atributo('navbar'))  ?>
   </header>
   <section class="<?php echo $core->get_atributo('section') ?>">
      <!-- container -->
      <div class="<?php echo $core->get_atributo('div1') ?>">
         <!-- row -->
         <div class="<?php echo $core->get_atributo('div2') ?>">
            <!-- Sidebar Left -->
            <div class="<?php echo $core->get_atributo('div3') ?>">
               <?php get_template_part($core->get_atributo('sidebarlefttemplate')) ?>
            </div>
            <!-- centro envoltorio -->
            <div class="<?php echo $core->get_atributo('div4') ?>">
               <?php get_template_part($core->get_atributo('agregarpost')) ?>
               <!-- centro Pregunta si hay posts -->
               <div class="<?php echo $core->get_atributo('div5') ?>">
                  <?php if (have_posts()) : ?>
                     <!-- Si hay posts envoltorio 1 -->
                     <div class="<?php echo $core->get_atributo('div6') ?>">
                        <!-- Si hay posts envoltorio 2 -->
                        <div class="<?php echo $core->get_atributo('div7') ?>">
                           <?php
                           while (have_posts()) :
                              the_post();
                              get_template_part($core->get_atributo('templatepart'));
                              if (is_page()) {
                                 the_content();
                              }
                              if (comments_open() || get_comments_number()) {
                                 comments_template();
                              }
                           endwhile;
                           ?>
                        </div>
                     </div>
                  <?php else : ?>
                     <!-- Si NO hay posts -->
                     <?php get_template_part($core->get_atributo('templatepartnone')) ?>
                  <?php endif; ?>
               </div>
            </div>
            <!-- Sidebar Right -->
            <div class=" <?php echo $core->get_atributo('div8') ?>">
               <?php get_template_part($core->get_atributo('sidebarrighttemplate')) ?>
            </div>
         </div>
         <footer class="<?php echo $core->get_atributo('footerclass') ?>">
            <?php get_template_part($core->get_atributo('footertemplate')) ?>
         </footer>
      </div>
   </section>
   <?php wp_footer(); ?>
</body>

</html>