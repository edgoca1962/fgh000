<?php

/**
 * Plantilla para la pagina vigencia-comites.
 * 
 * @package FGHEGC
 */

use FGHEGC\Modules\Core\CoreController;
use FGHEGC\Modules\Sca\Acuerdo\AcuerdoController;

$atributos = CoreController::get_instance()->get_atributos('acuerdo');
$acuerdo = AcuerdoController::get_instance();

?>

<div class="row">
   <div class="col-xl-8">
      <div class="row row-cols-1 row-cols-md-2 g-4 mb-5">
         <div class="col">
            <div class="card h-100" style="background: linear-gradient(to right, rgba(64, 154, 247, 1), rgba(43, 170, 177, 1)) !important;color: #fff;">
               <div class="d-flex p-4">
                  <div class=""><i class="fa-solid fa-handshake" style="font-size:30px;"></i></div>
                  <div class="ms-3 pt-2">
                     <h5>
                        <a class="text-white" href="<?php echo get_post_type_archive_link('acuerdo') . '?cpt=acuerdo&vigencia=1&comite_id=' . $atributos['comite_id'] ?>">Acuerdos
                           Vencidos
                        </a>
                        <span class="ms-1">(
                           <?php
                           if ($acuerdo->get_verAcuerdos()[$atributos['comite_id']] == 'asignados') {
                              echo $acuerdo->get_totalAcuerdosComiteUsr($atributos['comite_id'], $atributos['usuario_id'])['vencidos'];
                           } else {
                              echo $acuerdo->get_totalAcuerdosComite($atributos['comite_id'])['vencidos'];
                           }
                           ?>)
                        </span>
                     </h5>
                  </div>
               </div>
            </div>
         </div>
         <div class="col">
            <div class="card" style="background: linear-gradient(to right, rgba(64, 154, 247, 1), rgba(43, 170, 177, 1)) !important;color: #fff;">
               <div class="d-flex p-4">
                  <div class=""><i class="fa-solid fa-handshake" style="font-size:30px;"></i></div>
                  <div class="ms-3 pt-2">
                     <h5><a class="text-white" href="<?php echo get_post_type_archive_link('acuerdo') . '?cpt=acuerdo&vigencia=2&comite_id=' . $atributos['comite_id'] ?>">Acuerdos
                           por vencer este mes</a>
                        <span class="ms-1">(
                           <?php
                           if ($acuerdo->get_verAcuerdos()[$atributos['comite_id']] == 'asignados') {
                              echo $acuerdo->get_totalAcuerdosComiteUsr($atributos['comite_id'], $atributos['usuario_id'])['porvencer'];
                           } else {
                              echo $acuerdo->get_totalAcuerdosComite($atributos['comite_id'])['porvencer'];
                           }
                           ?>)
                        </span>
                     </h5>
                  </div>
               </div>
            </div>
         </div>
         <div class="col">
            <div class="card" style="background: linear-gradient(to right, rgba(64, 154, 247, 1), rgba(43, 170, 177, 1)) !important;color: #fff;">
               <div class="d-flex p-4">
                  <div class=""><i class="fa-solid fa-handshake" style="font-size:30px;"></i></div>
                  <div class="ms-3 pt-2">
                     <h5><a class="text-white" href="<?php echo get_post_type_archive_link('acuerdo') . '?cpt=acuerdo&vigencia=3&comite_id=' . $atributos['comite_id'] ?>">Acuerdos
                           en proceso</a>
                        <span class="ms-1">(
                           <?php
                           if ($acuerdo->get_verAcuerdos()[$atributos['comite_id']] == 'asignados') {
                              echo $acuerdo->get_totalAcuerdosComiteUsr($atributos['comite_id'], $atributos['usuario_id'])['proceso'];
                           } else {
                              echo $acuerdo->get_totalAcuerdosComite($atributos['comite_id'])['proceso'];
                           }
                           ?>)
                        </span>
                     </h5>
                  </div>
               </div>
            </div>
         </div>
         <div class="col">
            <div class="card" style="background: linear-gradient(to right, rgba(64, 154, 247, 1), rgba(43, 170, 177, 1)) !important;color: #fff;">
               <div class="d-flex p-4">
                  <div class=""><i class="fa-solid fa-handshake" style="font-size:30px;"></i></div>
                  <div class="ms-3 pt-2">
                     <h5><a class="text-white" href="<?php echo get_post_type_archive_link('acuerdo') . '?cpt=acuerdo&vigencia=4&comite_id=' . $atributos['comite_id'] ?>">Acuerdos
                           Ejecutados</a>
                        <span class="ms-1">(
                           <?php
                           if ($acuerdo->get_verAcuerdos()[$atributos['comite_id']] == 'asignados') {
                              echo $acuerdo->get_totalAcuerdosComiteUsr($atributos['comite_id'], $atributos['usuario_id'])['ejecutados'];
                           } else {
                              echo $acuerdo->get_totalAcuerdosComite($atributos['comite_id'])['ejecutados'];
                           }
                           ?>)
                        </span>
                     </h5>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-xl-4">
      <?php get_template_part($atributos['sidebar']) ?>
   </div>
</div>