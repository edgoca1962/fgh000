<?php

use FGHEGC\Modules\Core\CoreController;
use FGHEGC\Modules\Scc\Beneficiario\BeneficiarioController;

$beneficiario = BeneficiarioController::get_instance();
$atributos = CoreController::get_instance()->get_atributos(get_post_type());

?>
<form id="<?php the_ID() ?>" class="needs-validation" novalidate <?php echo $atributos['ocultar'] ?>>
   <div class="d-flex align-items-center form-group row mb-3">
      <div class="col-2">
         <img src="<?php echo (get_the_post_thumbnail_url(get_the_ID())) ? get_the_post_thumbnail_url(get_the_ID()) : $beneficiario->get_avatar(get_the_ID()) ?>" class="object-fit-cover rounded" style="width:50px;" alt="imagen beneficiario">
      </div>
      <div class="col fs-4">
         <a href="<?php echo get_the_permalink() ?>" class="text-reset">
            <?php echo get_the_title() ?>
         </a>
      </div>
      <input type="hidden" name="nombre" value="<?php echo get_the_title() ?>">
   </div>
   <div class="form-group row mb-3">
      <div class="col col-md-3 mb-3">
         <input type="date" class="form-control" name="f_asistencia" placeholder="Fecha" value="<?php echo date('Y-m-d') ?>" required>
      </div>
      <div class="col mb-3">
         <div class="form-check">
            <input class="form-check-input" type="checkbox" value="No" name="reflexion" id="reflexion_<?php the_ID() ?>">
            <label class="form-check-label" for="reflexion">
               Reflexión
            </label>
         </div>
      </div>
      <div class="col mb-3">
         <div class="form-check">
            <input class="form-check-input" type="checkbox" value="No" name="alimentacion" id="alimentacion_<?php the_ID() ?>">
            <label class="form-check-label" for="alimentacion">
               Alimentación
            </label>
         </div>
      </div>
      <div class="col mb-3">
         <div class="input-group mb-3">
            <input type="number" class="form-control" step="1" name="q_alimentacion" placeholder="Cantidad" value="1" required>
            <span class="input-group-text">Q</span>
         </div>
      </div>
      <div class="col">
         <button type="submit" class="btn btn-info btn-sm mb-3" data-b_id="<?php the_ID() ?>"><span><i class="fa-solid fa-floppy-disk"></i></span> Actualizar</button>
      </div>
   </div>
   <input type="hidden" name="nombre" value="<?php echo get_post(get_the_ID())->post_title ?>">
   <input type="hidden" name="post_parent" value="<?php the_ID() ?>">
   <input type="hidden" name="action" value="agregar_asistencia">
   <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('asistencia') ?>">
   <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
</form>