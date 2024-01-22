<?php

use FGHEGC\Modules\Sca\Acuerdo\AcuerdoController;

$atributos = AcuerdoController::get_instance()->get_atributos('acuerdo');
?>
<div class="col-md-8">
   <h3>No hay <span class="strong"><?php echo $atributos['subtitulo'] ?></span> registrados.</h3>
</div>