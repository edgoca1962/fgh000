<?php

/**
 * Plantilla para la pagina vigencia-usuarios.
 * 
 * @package EGC001
 */

use EGC001\Modules\Core\CoreController;

$core = CoreController::get_instance();
$vigenciaAsignado = isset($core->get_atributo('totalAcuerdos')['vigenciaAsignado']) ? $core->get_atributo('totalAcuerdos')['vigenciaAsignado'] : [];

?>
<?php if ($core->get_atributo('visualizar')) : ?>
   <div class="row row-cols-1 row-cols-md-2 g-4 mb-5">
      <?php foreach ($vigenciaAsignado as $codVigencia => $dato) { ?>
         <div class="col">
            <div class="card h-100" style="background: linear-gradient(to right, rgba(64, 154, 247, 1), rgba(43, 170, 177, 1)) !important;color: #fff;">
               <div class="d-flex p-4">
                  <div class=""><i class="fa-solid fa-handshake" style="font-size:30px;"></i></div>
                  <div class="ms-3 pt-2">
                     <h5>
                        <a class="text-white" href="<?php echo get_post_type_archive_link('acuerdo') . '?cpt=acuerdo&vigencia=' . $codVigencia . '&asignar_id=' . $core->get_atributo('asignar_id') ?>"><?php echo $dato['etiqueta'] ?></a>
                        <span class="ms-1">( <?php echo $dato['total']; ?> )</span>
                     </h5>
                  </div>
               </div>
            </div>
         </div>
      <?php } ?>
   </div>
<?php endif; ?>