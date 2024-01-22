<?php

/**
 * Plantilla para la barra de búsquedas del SCA.
 * 
 * @package FGHEGC
 */

use FGHEGC\Modules\Core\CoreController;

$atributos = CoreController::get_instance()->get_atributos('acuerdo');
$graficos = $atributos['totalAcuerdos']['graficos'];

?>
<div class="row">
   <div class="col-xl-8">
      <div class="row row-cols-1 row-cols-md-2 g-4 mb-5">
         <input id="pagina" type="hidden" value="<?php echo esc_url(site_url('/vigencia-acuerdos-comite')) ?>">
         <input id="comites" type="hidden" value="<?php echo count($atributos['comites']) + 1 ?>">
         <?php
         $i = 0;
         foreach ($graficos as $comite => $dato) {
         ?>
            <div class="col">
               <div class="card text-black">
                  <div class="card-body">
                     <h5 class="card-title">
                        <?php echo $dato['nombre'] ?>
                     </h5>
                     <input id="comite_grafico_<?php echo $i ?>" type="hidden" value="<?php echo $comite ?>">
                     <input id="valgra_<?php echo $i ?>" type="hidden" value='<?php echo json_encode($dato['vigencias']) ?>'>
                     <canvas id="grafico_<?php echo $i ?>" class="rounded-2" width="400" height="400"></canvas>
                  </div>
               </div>
            </div>
            <?php $i = $i + 1 ?>
         <?php } ?>
      </div>
   </div>
   <div class="col-xl-4">
      <?php get_template_part($atributos['sidebar']) ?>
   </div>
</div>