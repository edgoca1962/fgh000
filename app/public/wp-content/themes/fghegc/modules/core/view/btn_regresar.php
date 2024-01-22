<?php

use FGHEGC\Modules\Core\CoreController;

$atributos = CoreController::get_instance()->get_atributos(get_post_type());

?>

<button class="btn btn-warning btn-sm mb-3">
   <a class="text-black" href="<?php echo get_post_type_archive_link($atributos['regresar']) . 'page/' . $atributos['pag_ant'] . '/?' . $atributos['parametros'] ?>">Regresar</a>
</button>