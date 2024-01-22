<?php

/**
 * Plantilla para cuando no hay eventos.
 * 
 * @package sae
 */

use FGHEGC\Modules\Core\CoreController;

$atributos = CoreController::get_instance()->get_atributos('evento');

?>
<div class="col-md-9">
   <h3>No hay eventos registrados.</h3>
</div>