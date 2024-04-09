<?php

use EGC001\Modules\Core\CoreController;

/**
 * 
 * Plantilla para el post Comedor
 * 
 * @package:EGC001
 * 
 */

$atributos = CoreController::get_instance();

?>
<form id="<?php the_ID() ?>" <?php echo $atributos->get_atributo('ocultarVista') ?>>
   <div class="card mb-3 bg-dark text-white shadow h-100">
      <img src="<?php echo (get_the_post_thumbnail_url(get_the_ID())) ? get_the_post_thumbnail_url(get_the_ID()) : EGC001_DIR_URI . '/assets/img/scc/scccomedor.png' ?>" class="object-fit-cover rounded-top" alt="Imagen Comedor">
      <div class="card-body">
         <h5 class="card-title"><a href="<?php echo get_the_permalink() ?>" class="text-reset"><?php echo get_the_title() ?></a></h5>
         <p> <!-- Provincia, Cantón y Distrito -->
            Provincia: <?php echo $atributos->get_atributo('provincia') ?>
            Cantón: <?php echo $atributos->get_atributo('canton') ?><br>
            Distrito: <?php echo $atributos->get_atributo('distrito') ?><br>
            Dirección: <?php echo get_post_meta(get_the_ID(), '_direccion', true) ?><br>
            Teléfono: <?php echo get_post_meta(get_the_ID(), '_telefono', true) ?><br>
            email: <?php echo get_post_meta(get_the_ID(), '_email', true) ?><br>
            Encargada(o): <?php echo (get_user_by('ID', get_post_meta(get_the_ID(), '_contacto_id', true))) ? get_user_by('ID', get_post_meta(get_the_ID(), '_contacto_id', true))->display_name : 'No Asignado' ?>
         </p>
      </div>
   </div>
</form>