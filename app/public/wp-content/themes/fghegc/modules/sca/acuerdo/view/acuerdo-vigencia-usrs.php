<?php

/**
 * Plantilla para la pagina vigencia-usuarios.
 * 
 * @package FGHEGC
 */

use FGHEGC\Modules\Core\CoreController;

$atributos = CoreController::get_instance()->get_atributos('acuerdo');
$vigenciaAsignado = $atributos['totalAcuerdos']['vigenciaAsignado'];

?>
<?php if ($atributos['visualizar']) : ?>
   <div class="row">
      <div class="col-xl-8">
         <div class="row row-cols-1 row-cols-md-2 g-4 mb-5">
            <?php foreach ($vigenciaAsignado as $codVigencia => $dato) { ?>
               <div class="col">
                  <div class="card h-100" style="background: linear-gradient(to right, rgba(64, 154, 247, 1), rgba(43, 170, 177, 1)) !important;color: #fff;">
                     <div class="d-flex p-4">
                        <div class=""><i class="fa-solid fa-handshake" style="font-size:30px;"></i></div>
                        <div class="ms-3 pt-2">
                           <h5>
                              <a class="text-white" href="<?php echo get_post_type_archive_link('acuerdo') . '?cpt=acuerdo&vigencia=' . $codVigencia . '&asignar_id=' . $atributos['asignar_id'] ?>"><?php echo $dato['etiqueta'] ?></a>
                              <span class="ms-1">( <?php echo $dato['total']; ?> )</span>
                           </h5>
                        </div>
                     </div>
                  </div>
               </div>
            <?php } ?>
         </div>
      </div>
      <div class="col-xl-4">
         <?php get_template_part($atributos['sidebar'], '', $atributos) ?>
      </div>
   </div>
<?php endif; ?>