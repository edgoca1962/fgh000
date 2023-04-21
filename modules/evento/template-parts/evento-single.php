<?php
if (isset($_GET['mes'])) {
   $mesConsulta = sanitize_text_field($_GET['mes']);
} else {
   $mesConsulta = date('F');
}
if (get_post_meta('_f_final') < date('Y-m-d') || get_post_meta('_f_final') == '') {
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
$fechasevento = fgh000_fechasevento(
   get_post_meta($post->ID, '_f_inicio', true),
   get_post_meta($post->ID, '_f_final', true),
   get_post_meta($post->ID, '_periodicidadevento', true),
   get_post_meta($post->ID, '_opcionesquema', true),
   get_post_meta($post->ID, '_numerodiaevento', true),
   get_post_meta($post->ID, '_numerodiaordinalevento', true),
   explode(',', get_post_meta($post->ID, '_diasemanaevento', true)),
   get_post_meta($post->ID, '_mesevento', true),
   $mesConsulta
);

$diasemanapost = ['Monday' => 'Lunes', 'Tuesday' => 'Martes', 'Wednesday' => 'Miércoles', 'Thursday' => 'Jueves', 'Friday' => 'Viernes', 'Saturday' => 'Sábado', 'Sunday' => 'Domingo'];

?>

<h4>
   <?php echo get_the_title() ?>
</h4>
<h5>Fecha próxima reunión:
   <?php echo $diasemanapost[date('l', strtotime(get_post_meta($post->ID, '_f_proxevento', true)))] . ' - ' . date('d-M-Y', strtotime(get_post_meta($post->ID, '_f_proxevento', true))); ?>
</h5>

<p>
   <?php echo 'Tipo evento: ' . get_post_meta($post->ID, '_periodicidadevento', true) . '<br/>' ?>
   <?php echo 'Fecha inicio: ' . get_post_meta($post->ID, '_f_inicio', true) . '<br/>' ?>
   <?php echo 'Hora inicio: ' . get_post_meta($post->ID, '_h_inicio', true) . '<br/>' ?>
   <?php echo 'Fecha final: ' . get_post_meta($post->ID, '_f_final', true) . '<br/>' ?>
   <?php echo 'Hora final: ' . get_post_meta($post->ID, '_h_final', true) . '<br/>' ?>
   <?php echo 'Indicador dia completo: ' . get_post_meta($post->ID, '_dia_completo', true) . '<br/>' ?>
   <?php echo 'Inscripción: ' . get_post_meta($post->ID, '_inscripcion', true) . '<br/>' ?>
   <?php echo 'Donativo: ' . get_post_meta($post->ID, '_donativo', true) . '<br/>' ?>
   <?php echo 'Monto sugerido: ' . get_post_meta($post->ID, '_montodonativo', true) . '<br/>' ?>
   <?php if (get_post_meta($post->ID, '_periodicidadevento', true) == '2'): ?>
      <?php echo 'Número de periodos: ' . get_post_meta($post->ID, '_npereventos', true) ?>
   <?php endif; ?>
   <?php if (get_post_meta($post->ID, '_periodicidadevento', true) == '3'): ?>
      <?php echo 'Número de periodos: ' . get_post_meta($post->ID, '_npereventos', true) . '<br/>' ?>
      <?php echo 'Día semana: ' . get_post_meta($post->ID, '_diasemanaevento', true) ?>
   <?php endif; ?>
   <?php if (get_post_meta($post->ID, '_periodicidadevento', true) == '4'): ?>
   <?php endif; ?>
</p>
<?php if (get_post_meta($post->ID, '_periodicidadevento', true) == '4' || get_post_meta($post->ID, '_periodicidadevento', true) == '5'): ?>
   <?php if (get_post_meta($post->ID, '_opcionesquema', true) == 'on'): ?>
      <p>Opcion 1 mensual - anual</p>
      <p>
         <?php echo 'Opción Esquema mensual - anual: ' . get_post_meta($post->ID, '_opcionesquema', true) . '<br/>' ?>
         <?php echo 'Número de día: ' . get_post_meta($post->ID, '_numerodiaevento', true) . '<br/>' ?>
         <?php echo 'Mes: ' . get_post_meta($post->ID, '_mesevento', true) . '<br/>' ?>
      </p>
   <?php else: ?>
      <p>Opcion 2 mensual - anual</p>
      <p>
         <?php echo 'Opción Esquema mensual - anual: ' . get_post_meta($post->ID, '_opcionesquema', true) . '<br/>' ?>
         <?php echo 'Dia ordinal: ' . get_post_meta($post->ID, '_numerodiaordinalevento', true) . '<br/>' ?>
         <?php echo 'Dia semana: ' . get_post_meta($post->ID, '_diasemanaevento', true) . '<br/>' ?>
         <?php echo 'Mes: ' . get_post_meta($post->ID, '_mesevento', true) . '<br/>' ?>
      </p>
   <?php endif; ?>
<?php endif; ?>
<pre>
   <?php echo print_r($fechasevento) ?>
</pre>
