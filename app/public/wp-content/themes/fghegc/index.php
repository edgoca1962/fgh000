<?php

/**
 * Main template
 * 
 * @packgae FGHMVC
 */

use FGHEGC\Modules\Core\CoreController;

$core = CoreController::get_instance();

$atributos = CoreController::get_instance()->get_atributos(get_post_type());
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
   <meta charset="<?php bloginfo('charset'); ?>">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="profile" href="https://gmpg.org/xfn/11">

   <?php wp_head(); ?>
</head>

<body class="background-blend" <?php body_class(); ?>>
   <?php wp_body_open(); ?>
   <header>
      <?php
      get_template_part($atributos['navbar']);
      get_template_part($atributos['banner']);
      ?>
   </header>
   <section class="<?php echo $atributos['div0'] ?>">
      <div class="<?php echo $atributos['div1'] ?>">
         <?php get_template_part($atributos['agregarpost']) ?>
         <div class="<?php echo $atributos['div2'] ?>">
            <?php if (have_posts()) : ?>
               <div class="<?php echo $atributos['div3'] ?>">
                  <div class="<?php echo $atributos['div4'] ?>">
                     <?php
                     while (have_posts()) :
                        the_post();
                        get_template_part($atributos['templatepart']);
                     endwhile;
                     ?>
                  </div>
                  <?php ($core->atributos['verNavegacionPosts']) ? twenty_twenty_one_the_posts_navigation() : '' ?>
                  <?php get_template_part($atributos['btnregresar']) ?>
               </div>
            <?php else : ?>
               <?php get_template_part($atributos['templatepartnone']) ?>
            <?php endif; ?>
            <div class="<?php echo $atributos['div5'] ?>">
               <?php get_template_part($atributos['sidebar']) ?>
            </div>
         </div>
         <?php if (!$atributos['fullpage']) : ?>
            <footer class="container pt-5">
               <?php get_template_part($atributos['piepagina']) ?>
            </footer>
         <?php endif; ?>
      </div>
   </section>
   <?php wp_footer(); ?>
</body>

</html>