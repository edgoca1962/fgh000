<?php

use EGC001\Modules\Core\CoreController;

$core = CoreController::get_instance();
?>
<div class="col-md-8">
   <h3>No hay <span class="strong"><?php echo $core->get_atributo('subtitulo') ?></span> registrados.</h3>
</div>