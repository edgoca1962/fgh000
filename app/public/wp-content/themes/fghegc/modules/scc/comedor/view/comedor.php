<?php

use FGHEGC\Modules\Core\CoreController;
use FGHEGC\Modules\DivPolCri\DivPolCriModel;

$atributos = CoreController::get_instance()->get_atributos(get_post_type());
$divpolcri = DivPolCriModel::get_instance();

?>
<form id="<?php the_ID() ?>">
   <div class="card mb-3 bg-dark text-white">
      <div class="row g-0">
         <div class="col-md-4">
            <img src="<?php echo FGHEGC_DIR_URI . '/assets/img/scccomedor.png' ?>" class="img-fluid rounded-start" alt="...">
         </div>
         <div class="col-md-8">
            <div class="card-body">
               <h5 class="card-title">
                  <a href="<?php echo get_the_permalink() ?>" class="text-reset">
                     <?php echo get_the_title() ?>
                  </a>
               </h5>
               <div class="form-group row">
                  <div class="col-md-4 mb-3">
                     <label class="form-label">Provincia: </label>
                     <label class="form-label"><?php echo $divpolcri->scc_divpolcri_get_provincia(get_post_meta(get_the_ID(), '_provincia_id', true)) ?></label>
                  </div>
                  <div class="col-md-4 mb-3">
                     <label class="form-label">Cantón: </label>
                     <label class="form-label"><?php echo $divpolcri->scc_divpolcri_get_canton(get_post_meta(get_the_ID(), '_canton_id', true)) ?></label>
                  </div>
                  <div class="col-md-4 mb-3">
                     <label class="form-label">Distrito: </label>
                     <label class="form-label"><?php echo $divpolcri->scc_divpolcri_get_distrito(get_post_meta(get_the_ID(), '_distrito_id', true)) ?></label>
                  </div>
               </div><!-- Provincia, Cantón y Distrito -->
               <div class="form-group mb-3">
                  <label class="form-label">Dirección: </label><br>
                  <label class="form-label"><?php echo get_post_meta(get_the_ID(), '_direccion', true) ?></label>
               </div><!-- dirección detallada -->
               <div class="form-group row">
                  <div class="col-md-4 mb-3">
                     <label class="form-label">Teléfono: </label><br>
                     <label class="form-label"><?php echo get_post_meta(get_the_ID(), '_telefono', true) ?></label>
                  </div>
                  <div class="col-md-4 mb-3">
                     <label class="form-label">email: </label><br>
                     <label class="form-label"><?php echo get_post_meta(get_the_ID(), '_email', true) ?></label>
                  </div>
                  <div class="col-md-4 mb-3">
                     <label class="form-label">Encargada(o): </label><br>
                     <label class="form-label"><?php echo get_user_by('ID', get_post_meta(get_the_ID(), '_contacto_id', true))->display_name ?></label>
                  </div>
               </div><!-- teléfono y contacto -->
            </div>
         </div>
      </div>
   </div>
</form>