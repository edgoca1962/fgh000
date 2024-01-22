<?php

use FGHMVC\modules\core\controller\Atributos;

$atributos = Atributos::get_instance()->get_atributos('inscripcion');
$evento_id = sanitize_text_field($_GET['pid']);
if (get_post_meta($evento_id, '_inscripcion', true) == 'on') {
   $inscripciones = ($atributos['total_inscripciones']) ? intval($atributos['total_inscripciones']) : 0;
} else {
   $inscripciones = 0;
}
$aforo = (get_post_meta($evento_id, '_q_aforo', true)) ? intval(get_post_meta($evento_id, '_q_aforo', true)) : 0;
$restante = ($aforo) ? $inscripciones - $aforo : 0;
$inscripciones_rel = ($aforo) ? round(($inscripciones / $aforo) * 100) : 0;
?>

<div class="container">
   <div class="row ">
      <div class="col col-xl-3 col-lg-3">
         <div class="card l-bg-cherry">
            <div class="card-statistic-3 p-4">
               <div class="card-icon card-icon-large"><i class="fas fa-shopping-cart"></i></div>
               <div class="mb-4">
                  <h5 class="card-title mb-0">Inscripciones</h5>
               </div>
               <div class="row align-items-center mb-2 d-flex">
                  <div class="col-8">
                     <h2 class="d-flex align-items-center mb-0">
                        <?php echo $inscripciones ?>
                     </h2>
                  </div>
                  <div class="col-4">
                     <a href="https://google.com">Listar</a>
                  </div>
               </div>
               <div class="progress mt-1 " data-height="8" style="height: 8px;">
                  <div class="progress-bar l-bg-cyan" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $inscripciones_rel ?>%;"></div>
               </div>
            </div>
         </div>
      </div>
      <div class="col col-xl-3 col-lg-3">
         <div class="card l-bg-blue-dark">
            <div class="card-statistic-3 p-4">
               <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
               <div class="mb-4">
                  <h5 class="card-title mb-0">Aforo</h5>
               </div>
               <div class="row align-items-center mb-2 d-flex">
                  <div class="col-8">
                     <h2 class="d-flex align-items-center mb-0">
                        <?php echo ($aforo) ? $aforo : 'No Aplica' ?>
                     </h2>
                  </div>
               </div>
               <div class="progress mt-1 " data-height="8" style="height: 8px;">
                  <div class="progress-bar l-bg-green" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
               </div>
            </div>
         </div>
      </div>
      <div class="col col-xl-3 col-lg-3">
         <div class="card l-bg-green-dark">
            <div class="card-statistic-3 p-4">
               <div class="card-icon card-icon-large"><i class="fas fa-ticket-alt"></i></div>
               <div class="mb-4">
                  <h5 class="card-title mb-0">Disponibilidad</h5>
               </div>
               <div class="row align-items-center mb-2 d-flex">
                  <div class="col-8">
                     <h2 class="d-flex align-items-center mb-0">
                        <?php echo ($restante) ? $restante : 'No Aplica' ?>
                     </h2>
                  </div>
               </div>
               <div class="progress mt-1 " data-height="8" style="height: 8px;">
                  <div class="progress-bar l-bg-orange" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 75%;"></div>
               </div>
            </div>
         </div>
      </div>
      <div class="col col-xl-3 col-lg-3">
         <div class="card l-bg-orange-dark">
            <div class="card-statistic-3 p-4">
               <div class="card-icon card-icon-large"><i class="fas fa-dollar-sign"></i></div>
               <div class="mb-4">
                  <h5 class="card-title mb-0">Recaudo</h5>
               </div>
               <div class="row align-items-center mb-2 d-flex">
                  <div class="col-8">
                     <h2 class="d-flex align-items-center mb-0">
                        ¢150,000
                     </h2>
                  </div>
               </div>
               <div class="progress mt-1 " data-height="8" style="height: 8px;">
                  <div class="progress-bar l-bg-cyan" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <?php if (get_post_meta($evento_id, '_inscripcion', true) == 'on') : ?>
      <div class="row">
         <a href="<?php echo esc_url(get_post_type_archive_link('inscripcion')) . '?pid=' . $atributos['post_parent'] ?>">
            <button type="button" class="btn btn-outline-primary me-3">
               Listar
            </button>
         </a>
      </div>
   <?php endif; ?>

</div>