<?php

use EGC001\Modules\Core\CoreController;

$atributos = CoreController::get_instance()->get_atributos('beneficiario');
$encargados = get_users(['orderby' => 'display_name', 'role__in' => ['encargadocomedores']])

?>

<section id="encargados" <?php echo $atributos['ocultarVista'] ?>>
   <div class="row">
      <div class="row col-md-8">
         <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($encargados as $encargado) : ?>
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
      </div>
      <div class="col-md-4">
         <?php get_template_part($atributos['sidebar'])
         ?>
      </div>
   </div>
</section>