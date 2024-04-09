<?php

/**
 * 
 * Plantilla para el Botón Regresar de los posts
 * 
 * @package: EGC001
 */


use EGC001\Modules\Core\CoreController;

$core = CoreController::get_instance();

?>

<button class="btn btn-warning btn-sm mb-3">
   <a class="text-black" href="<?php echo get_post_type_archive_link($core->get_atributo('regresar')) . 'page/' . $core->get_atributo('pag_ant') . '/?' . $core->get_atributo('parametros') ?>">Regresar</a>
</button>