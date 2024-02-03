<?php

/**
 * Plantilla para listar CPT Miembro.
 * 
 * @package FGHEGC
 */

use FGHEGC\Modules\Core\CoreController;

$core = CoreController::get_instance();
$atributos = CoreController::get_instance()->get_atributos(get_post_type());

?>
<?php if ($atributos['userAdmin']) : ?>
   <div class="col">
      <div class="card shadow h-100" style="background: linear-gradient(to right, rgba(64, 154, 247, 1), rgba(43, 170, 177, 1)); color: #fff;">
         <div class="card-body">
            <h4 class="card-title"><?php the_title() ?></h4>
         </div>
      </div>
   </div>
<?php else : ?>
   <?php $core->set_atributo('verNavegacionPosts', false) ?>
<?php endif; ?>