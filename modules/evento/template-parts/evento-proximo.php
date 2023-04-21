<?php

/**
 * The main template file
 *
 * @package Aplicación_Web
 */


$ordenamiento = [
   'posts_per_page' => -1,
   'post_type' => 'evento'
];

$fpe = new WP_Query($ordenamiento);
if ($fpe->have_posts()) {
   while ($fpe->have_posts()) {
      $fpe->the_post();
      $f_proxevento =
         fgh000_fpe(
            get_post_meta($post->ID, '_f_inicio', true),
            get_post_meta($post->ID, '_h_inicio', true),
            get_post_meta($post->ID, '_f_final', true),
            get_post_meta($post->ID, '_periodicidadevento', true),
            get_post_meta($post->ID, '_opcionesquema', true),
            get_post_meta($post->ID, '_numerodiaevento', true),
            get_post_meta($post->ID, '_numerodiaordinalevento', true),
            explode(',', get_post_meta($post->ID, '_diasemanaevento', true)),
            get_post_meta($post->ID, '_mesevento', true)
         );
      update_post_meta($post->ID, '_f_proxevento', $f_proxevento);
   }
   wp_reset_postdata();
}

$eventos = [
   'posts_per_page' => -1,
   'post_type' => 'evento',
   'meta_key' => '_f_proxevento',
   'orderby' => 'meta_value',
   'order' => 'ASC',
];
$query = new WP_Query($eventos);

$diasemanapost = ['Monday' => 'LUN', 'Tuesday' => 'MAR', 'Wednesday' => 'MIE', 'Thursday' => 'JUE', 'Friday' => 'VIE', 'Saturday' => 'SAB', 'Sunday' => 'DOM'];

$mesesEn = ['1' => 'January', '2' => 'February', '3' => 'March', '4' => 'April', '5' => 'May', '6' => 'June', '7' => 'July', '8' => 'August', '9' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'];

get_header();

?>
<section class="container py-5">
   <?php

   if ($query->have_posts()) {
      $titulo = get_the_archive_title();
      ?>
      <div class="row">
         <div class="col-md">
            <h3>Nuestras Reuniones del mes</h3>
            <?php
            while ($query->have_posts()) {
               $query->the_post(); ?>
               <?php if (date('Ym') == date('Ym', strtotime(get_post_meta($post->ID, '_f_proxevento', true))) && get_post_meta($post->ID, '_f_final', true) == ''):
                  ?>

                  <div class="row d-flex align-items-center">
                     <div class="col-6 col-md-6 col-xl-3 text-black rounded-circle mb-3"
                        style="width:75px; height:75px; background-color: <?php echo (get_post_meta($post->ID, '_f_final', true) == '') ? '#0dcaf0' : 'orange' ?>;">
                        <div class="fs-3 fw-bold text-center mt-2">
                           <?php echo $diasemanapost[date('l', strtotime(get_post_meta($post->ID, '_f_proxevento', true)))] ?>
                        </div>
                        <div class="fs-3 fw-bold text-center mt-n3">
                           <?php echo date('d', strtotime(get_post_meta($post->ID, '_f_proxevento', true))) ?>
                        </div>
                     </div>
                     <div class="col-6 col-md-6 col-xl9">
                        <h6><a href="<?php echo get_the_permalink() ?>"> <?php echo get_the_title() ?></a></h6>
                        <?php echo 'FI: ' . get_post_meta($post->ID, '_f_inicio', true) . ' FPE: ' . get_post_meta($post->ID, '_f_proxevento', true) . ' FF: ' . get_post_meta($post->ID, '_f_final', true) ?>
                     </div>
                  </div>
               <?php endif;
            }
            ?>
         </div>
         <div class="col-md">
            <h3>Eventos en curso este mes</h3>
            <?php
            while ($query->have_posts()) {
               $query->the_post(); ?>
               <?php if (get_post_meta($post->ID, '_f_final', true) != '' and date('Y-m-d') < get_post_meta($post->ID, '_f_final', true) && date('Ym') == date('Ym', strtotime(get_post_meta($post->ID, '_f_proxevento', true)))): ?>
                  <div class="row d-flex align-items-center">
                     <div class="col-6 col-md-6 col-xl-3 text-black rounded-circle mb-3"
                        style="width:75px; height:75px; background-color: <?php echo (get_post_meta($post->ID, '_f_final', true) == '') ? '#0dcaf0' : 'orange' ?>;">
                        <div class="fs-3 fw-bold text-center mt-2">
                           <?php echo $diasemanapost[date('l', strtotime(get_post_meta($post->ID, '_f_proxevento', true)))] ?>
                        </div>
                        <div class="fs-3 fw-bold text-center mt-n3">
                           <?php echo date('d', strtotime(get_post_meta($post->ID, '_f_proxevento', true))) ?>
                        </div>
                     </div>
                     <div class="col-6 col-md-6 col-xl-9">
                        <h6><a href="<?php echo get_the_permalink() ?>"> <?php echo get_the_title() ?></a></h6>
                        <?php echo 'FPE: ' . get_post_meta($post->ID, '_f_proxevento', true) . ' FF: ' . get_post_meta($post->ID, '_f_final', true) ?>
                     </div>
                  </div>
               <?php endif;
            } ?>
         </div>
         <div class="col-md">
            <h3>Eventos para el próximo mes</h3>
            <?php
            while ($query->have_posts()) {
               $query->the_post(); ?>
               <?php if (date('Ym') + 1 == date('Ym', strtotime(get_post_meta($post->ID, '_f_proxevento', true)))): ?>
                  <div class="row d-flex align-items-center">
                     <div class="col-6 col-md-6 col-xl-3 text-black rounded-circle mb-3"
                        style="width:75px; height:75px; background-color: <?php echo (get_post_meta($post->ID, '_f_final', true) == '') ? '#0dcaf0' : 'orange' ?>;">
                        <div class="fs-3 fw-bold text-center mt-2">
                           <?php echo date('M', strtotime(get_post_meta($post->ID, '_f_proxevento', true))) ?>
                        </div>
                        <div class="fs-3 fw-bold text-center mt-n3">
                           <?php echo date('d', strtotime(get_post_meta($post->ID, '_f_proxevento', true))) ?>
                        </div>
                     </div>
                     <div class="col-6 col-md-6 col-xl-9">
                        <h6><a href="<?php echo get_the_permalink() ?>"> <?php echo get_the_title() ?></a></h6>
                        <?php echo 'FPE: ' . get_post_meta($post->ID, '_f_proxevento', true) . ' FF: ' . get_post_meta($post->ID, '_f_final', true) ?>
                     </div>
                  </div>
               <?php endif;
            } ?>
         </div>
      </div>
      <?php
      wp_reset_postdata();
   } else {
      get_template_part('template-parts/content', 'none');
   }
   ?>
</section>
<?php
get_footer();