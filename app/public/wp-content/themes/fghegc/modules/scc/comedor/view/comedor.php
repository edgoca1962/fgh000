<?php

use FGHEGC\Modules\Core\CoreController;
use FGHEGC\Modules\DivPolCri\DivPolCriModel;

$atributos = CoreController::get_instance()->get_atributos('beneficiario');
$divpolcri = DivPolCriModel::get_instance();

?>
<form id="<?php the_ID() ?>" <?php echo $atributos['ocultarVista'] ?>>
   <div class="card mb-3 bg-dark text-white shadow h-100">
      <img src="<?php echo (get_the_post_thumbnail_url(get_the_ID())) ? get_the_post_thumbnail_url(get_the_ID()) : FGHEGC_DIR_URI . '/assets/img/scccomedor.png' ?>" class="object-fit-cover rounded-top" alt="Imagen Comedor">
      <div class="card-body">
         <h5 class="card-title"><a href="<?php echo get_the_permalink() ?>" class="text-reset"><?php echo get_the_title() ?></a></h5>
         <p> <!-- Provincia, Cantón y Distrito -->
            Provincia: <?php echo $divpolcri->scc_divpolcri_get_provincia(get_post_meta(get_the_ID(), '_provincia_id', true)) ?>
            Cantón: <?php echo $divpolcri->scc_divpolcri_get_canton(get_post_meta(get_the_ID(), '_canton_id', true)) ?><br>
            Distrito: <?php echo $divpolcri->scc_divpolcri_get_distrito(get_post_meta(get_the_ID(), '_distrito_id', true)) ?><br>
            Dirección: <?php echo get_post_meta(get_the_ID(), '_direccion', true) ?><br>
            Teléfono: <?php echo get_post_meta(get_the_ID(), '_telefono', true) ?><br>
            email: <?php echo get_post_meta(get_the_ID(), '_email', true) ?><br>
            Encargada(o): <?php echo get_user_by('ID', get_post_meta(get_the_ID(), '_contacto_id', true))->display_name ?>
         </p>
      </div>
   </div>
</form>