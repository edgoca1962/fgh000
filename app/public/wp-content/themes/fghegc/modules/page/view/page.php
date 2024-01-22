<?php

/**
 * Plantilla para el post de las páginas.
 * 
 * @package FGHEGC
 */

use FGHEGC\Modules\Core\CoreController;

$atributos = CoreController::get_instance()->get_atributos(get_post_type());

if (!$atributos['fullpage']) {
   if (the_content()) {
      the_content();
   } else {
      get_template_part($atributos['templatepartpage']);
   }
   if (comments_open() || get_comments_number()) {
      comments_template();
   }
} else {
   if (the_content()) {
      the_content();
   } else {
      get_template_part($atributos['templatepartpage']);
   }
}
