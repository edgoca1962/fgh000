<?php

use FGHEGC\Modules\Core\CoreController;

$atributos = CoreController::get_instance()->get_atributos('beneficiario');

?>
<section id="graficos">
   <div class="row">
      <div class="col col-md-8">
         <h3>Gráficos</h3>
      </div>
      <div class="col-md-4">
         <?php get_template_part($atributos['sidebar'])
         ?>
      </div>
   </div>
</section>