<?php

use FGHEGC\Modules\Core\CoreController;

$core = CoreController::get_instance();
$atributos = $core->get_atributos('beneficiario');
$imagen = false;
?>
<h3>Beneficiarios</h3>
<div class="card" style="width:18rem;">
   <img src="<?php echo $core->get_atributo('imagen') ?>" class="card-img-top" alt="...">
   <div class="card-body">
      <h5 class="card-title">Card title</h5>
      <div class="row mb-3 p-0">
         <div class="col-md-3">
            <?php if ($imagen) : ?>
               <img src="<?php echo $core->get_atributo('imagen') ?>" class="rounded-circle shadow" alt="niño" style="width: 50px;">
            <?php else : ?>
               <span class="display-5 text-secondary"><i class="fa-solid fa-circle-user"></i></span>
            <?php endif; ?>
         </div>
         <div class="col-md-9 d-flex align-items-center">
            <h6 class="card-subtitle mb-2 ">Card subtitle</h6>
         </div>
      </div>
      <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
      b5
   </div>
   <div class="card-footer bg-warning">
      <img src="<?php echo FGHEGC_DIR_URI . '/assets/img/scclogotransparente200.png' ?>" class="rounded-circle" alt="niño" style="width: 50px;">
   </div>
</div>
<?php
