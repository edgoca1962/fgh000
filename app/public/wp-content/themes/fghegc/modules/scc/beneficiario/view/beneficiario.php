<?php

use FGHEGC\Modules\Scc\Beneficiario\BeneficiarioController;

?>
<form id="<?php the_ID() ?>" class="needs-validation" novalidate>
   <div class="row mb-3">
      <div class="row row-cols-auto form-group align-items-center">
         <div class="col">
            <img src="<?php echo (get_the_post_thumbnail_url(get_the_ID())) ? get_the_post_thumbnail_url(get_the_ID()) : BeneficiarioController::get_instance()->get_avatar(get_the_ID()) ?>" class="object-fit-cover rounded" style="width:50px;" alt="imagen beneficiario">
         </div>
         <div class="col fs-4">
            <a href="<?php echo get_the_permalink() ?>" class="text-reset">
               <?php the_title() ?>
            </a>
         </div>
      </div>
      <div class="container row row-cols-auto g-3">
         <div class="col-4">
            <input type="date" class="form-control" name="f_actualizacion" id="f_actualizacion_<?php the_ID() ?>" placeholder="Fecha" value="<?php echo date('Y-m-d') ?>" required>
         </div>
         <div class="col">
            <div class="form-check">
               <input class="form-check-input" type="checkbox" value="" name="reflexion_<?php the_ID() ?>">
               <label class="form-check-label" for="reflexion">
                  Reflexión
               </label>
            </div>
         </div>
         <div class="col">
            <div class="form-check">
               <input class="form-check-input" type="checkbox" value="" name="alimentacion_<?php the_ID() ?>">
               <label class="form-check-label" for="alimentacion">
                  Alimentación
               </label>
            </div>
         </div>
         <div class="col-md-2">
            <div class="input-group mb-3">
               <input type="number" class="form-control" step="1" name="q_alimentación_<?php the_ID() ?>" placeholder="Cantidad" value="1" required>
               <span class="input-group-text" id="q_alimentacion">Cantidad</span>
            </div>
         </div>
         <div class="col mb-3">
            <button type="submit" class="btn btn-info btn-sm mb-3" data-b_id="<?php the_ID() ?>"><span><i class="fa-solid fa-floppy-disk"></i></span> Actualizar</button>
         </div>
      </div>
   </div>
   <input type="hidden" name="post_id" value="<?php the_ID() ?>">
   <input type="hidden" name="action" value="f_u_actualizacion">
   <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('f_u_actualizacion') ?>">
   <input id="endpoint" type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
</form>