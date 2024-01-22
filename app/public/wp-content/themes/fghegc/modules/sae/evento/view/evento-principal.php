<?php

use FGHEGC\Modules\Core\CoreController;
use FGHEGC\Modules\Sae\Evento\EventoController;

$atributos = CoreController::get_instance()->get_atributos('page');
$eventosAtributos = EventoController::get_instance()->get_atributos('evento');

$finicial = date('Y-m-d', strtotime('first day of next month'));
$finicial = date('Y-m-d');
$ffinal = date('Y-m-d', strtotime('last day of next month'));

$eventos = get_posts(
   [
      'post_type' => 'evento',
      'posts_per_page' => -1,
      'meta_key' => '_f_proxevento',
      'orderby' => 'meta_value',
      'order' => 'ASC',
      'meta_query' =>
      [
         [
            'key' => '_f_proxevento',
            'value' => [$finicial, $ffinal],
            'compare' => 'BETWEEN'
         ],
      ]
   ]
)

?>

<section id="hero-page" class="d-flex flex-column justify-content-center align-items-center text-white" style="background: linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)), url(<?php echo $atributos['imagen'] ?>) no-repeat center /cover; height: <?php echo $atributos['height'] ?>;">
   <p class="animate__animated animate__fadeInDown mb-3 text-center  <?php echo $atributos['fontweight'] ?>  <?php echo $atributos['display'] ?>">
      <?php echo 'Próximos ' . $atributos['titulo'] ?></p>
   <div class="container d-flex justify-content-center">
      <div class="col-6 animate__animated animate__fadeInUp">
         <?php foreach ($eventos as $evento) { ?>
            <div class="row">
               <div class="col-md-6 text-md-end"><?php echo $evento->post_title ?></div>
               <div class="col-md-6 "><?php echo $eventosAtributos['diasemanaesp'][date('N', strtotime(get_post_meta($evento->ID, '_f_proxevento', true)))] . ' ' . date('j', strtotime(get_post_meta($evento->ID, '_f_proxevento', true))) . ' de ' . $eventosAtributos['mesannoesp'][date('n', strtotime(get_post_meta($evento->ID, '_f_proxevento', true)))] . ' a las ' . date('H', strtotime(get_post_meta($evento->ID, '_f_proxevento', true))) . ' horas' ?></div>
            </div>
         <?php } ?>
         <div class="row animate__animated animate__fadeInUp">
            <div class="col d-flex align-items-center justify-content-center">
               <img style="width: 250px; height:auto;" src="<?php echo FGHEGC_DIR_URI . '/assets/img/piepagina.png' ?>" alt="piepagina">
            </div>
         </div>
      </div>
   </div>
</section>