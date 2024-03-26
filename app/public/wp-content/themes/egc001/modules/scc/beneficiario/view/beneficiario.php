<?php

use EGC001\Modules\Core\CoreController;
use EGC001\Modules\Scc\Beneficiario\BeneficiarioController;

$core = CoreController::get_instance();
$atributos = $core->get_atributos(get_post_type());

$beneficiario = BeneficiarioController::get_instance();
if ($atributos['ocultarVista'] == 'hidden') {
   $core->set_atributo('verNavegacionPosts', false);
}
//  /beneficiarios/ben_ecx7z8w83dlqjlv/
?>
<form id="<?php the_ID() ?>" class="needs-validation" novalidate <?php echo $atributos['ocultarVista'] ?>>
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
   <div class="form-group row mb-3" <?php echo $atributos['ocultarMantenimiento'] ?>>
      <div class="col col-md-3 mb-3">
         <input type="date" class="form-control" name="f_asistencia" placeholder="Fecha" value="<?php echo date('Y-m-d') ?>" required>
      </div>
      <div class="col mb-3">
         <div class="form-check">
            <input class="form-check-input" type="checkbox" value="No" name="reflexion" id="reflexion_<?php the_ID() ?>" checked>
            <label class="form-check-label" for="reflexion">
               Reflexión
            </label>
         </div>
      </div>
      <div class="col-4 col-xl-2 mb-3">
         <div class="input-group mb-3">
            <span class="input-group-text">Alim.</span>
            <input type="number" class="form-control" step="1" name="q_alimentacion" placeholder="Cantidad" value="1" required>
         </div>
      </div>
      <div class="col" <?php echo $atributos['ocultarBoton'] ?>>
         <button type="submit" class="btn btn-info btn-sm mb-3" data-b_id="<?php the_ID() ?>"><span><i class="fa-solid fa-floppy-disk"></i></span> Actualizar</button>
      </div>
   </div>
   <input type="hidden" name="nombre" value="<?php echo get_post(get_the_ID())->post_title ?>">
   <input type="hidden" name="post_parent" value="<?php the_ID() ?>">
   <input type="hidden" name="action" value="agregar_asistencia">
   <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('asistencia') ?>">
   <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
</form>