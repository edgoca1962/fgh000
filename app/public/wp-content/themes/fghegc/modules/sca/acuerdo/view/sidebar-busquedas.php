<?php

/**
 * Plantilla para la barra de búsquedas del SCA.
 * 
 * @package FGHEGC
 */

use FGHEGC\Modules\Core\CoreController;
use FGHEGC\Modules\Sca\Acuerdo\AcuerdoController;

$atributos = CoreController::get_instance()->get_atributos('acuerdo');
$totalAcuerdos=$atributos['totalAcuerdos'];
$acuerdo = AcuerdoController::get_instance();

?>

<div class="row mb-5">
   <div class="position-relative">
      <form id="frmbuscar" class="d-flex">
         <input id="impbuscar" class="form-control w-100 me-2" type="text" style="width: 0;" placeholder="Buscar Acuerdo" aria-label="Search">
      </form>
      <div id="resultados" class="container invisible position-absolute search-overlay rounded-3 w-100" style="background-color: rgba(17, 153, 142, 1); height:300px;">
         <div class="d-flex justify-content-between">
            <h5>Resultados</h5><span id="btn_cerrar"><i class="far fa-times-circle"></i></span>
         </div>
         <div id="resultados_busqueda" data-url="<?= get_site_url() . '/wp-json/wp/v2/acuerdos?search=' ?>" data-msg="No se encontraron acuerdos"></div>
      </div>

   </div>
</div>

<div class="row ms-3 mb-5">
   <h5>Acuerdos por Estatus</h5>
   <?php foreach ($totalAcuerdos['vigencias'] as $dato) { ?>
      <div class="row">
         <div class="col">
            <a href="<?php echo get_post_type_archive_link('acuerdo') . '?cpt=acuerdo&vigencia=' . $dato['codigo'] . '&asignar_id=' . get_current_user_id() ?>">Acuerdos <?php echo $dato['etiqueta'] ?></a>
            <span class="ms-1">(
               <?php echo $dato['total'] ?> )
            </span>
         </div>
      </div>
   <?php } ?>
</div>

<div class="row ms-3 mb-5">
   <h5>Acuerdos por Comité</h5>
   <?php foreach ($totalAcuerdos['comites'] as $dato) { ?>
      <div class="row">
         <div class="col">
            <a href="<?php echo esc_url(site_url('/acuerdo-vigencia-comite')) . '?comite_id=' . $dato['comite_id'] ?>">
               <?php echo $dato['nombre'] ?>
            </a>
            <span class="ms-1">(
               <?php echo $dato['total'] ?> )
            </span>
         </div>
      </div>
   <?php } ?>
</div>

<?php if ($atributos['userAdmin'] || $acuerdo->get_miembroJunta()) : ?>
   <div class="row ms-3 mb-5">
      <h5>Acuerdos asignados a:</h5>
      <div class="row row-cols-1">
         <?php foreach ($totalAcuerdos['asignados'] as $usr_id => $dato) { ?>
            <div class="row">
               <div class="col">
                  <a href="<?php echo esc_url(site_url('/acuerdo-vigencia-usrs')) . '?asignar_id=' . $usr_id ?>">
                     <?php echo $dato['nombre'] ?>
                  </a>
                  <span class="ms-1">(
                     <?php echo $dato['total'] ?> )
                  </span>
               </div>
            </div>
         <?php } ?>
      </div>
   </div>
<?php endif; ?>