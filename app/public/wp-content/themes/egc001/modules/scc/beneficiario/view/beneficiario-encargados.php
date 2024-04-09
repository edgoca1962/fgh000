<?php

use EGC001\Modules\Core\CoreController;

/**
 * 
 * Plantilla para listar encargados
 * 
 * @package:EGC001
 * 
 */

$atributos = CoreController::get_instance();

?>

<section id="encargados" <?php echo $atributos->get_atributo('ocultarVista') ?>>
   <?php if ($atributos->get_atributo('encargados')) : ?>
      <div class="row row-cols-1 row-cols-md-3 g-4">
         <?php foreach ($atributos->get_atributo('encargados') as $encargado) : ?>
            <div class="col">
               <div class="card h-100 shadow">
                  <img src="<?php echo (get_user_meta($encargado->ID, 'custom_avatar', true)) ? wp_get_attachment_url(get_user_meta($encargado->ID, 'custom_avatar', true)) : EGC001_DIR_URI . '/assets/img/avatar03.png' ?>" alt="Imágen Encargado">
                  <div class="card-body">
                     <h5 class="card-title"><?php echo $encargado->display_name ?></h5>
                     <p class="card-text"><?php echo $encargado->user_email ?></p>
                  </div>
               </div>
            </div>
         <?php endforeach; ?>
      </div>
   <?php else : ?>
      <h3>No hay encargados registrados.</h3>
   <?php endif; ?>
</section>