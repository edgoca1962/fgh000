<h4>
   <?php echo get_the_title() . ' ' . get_the_ID() ?>
</h4>
<h5>Fecha próxima reunión:
   <?php echo date('l', strtotime(get_post_meta($post->ID, '_f_proxevento', true))) . ' - ' . date('d-M-Y', strtotime(get_post_meta($post->ID, '_f_proxevento', true))); ?>
</h5>

<p>
   <?php echo 'Tipo evento: ' . get_post_meta(get_the_ID(), '_periodicidadevento', true) . '<br/>' ?>
   <?php echo 'Fecha inicio: ' . date('Y-m-d H:i:s', strtotime(get_post_meta(get_the_ID(), '_f_inicio', true))) . '<br/>' ?>
   <?php echo 'Hora inicio: ' . date('H:i:s', strtotime(get_post_meta(get_the_ID(), '_f_inicio', true))) . '<br/>' ?>
   <?php if (get_post_meta(get_the_ID(), '_f_final', true) == '') : ?>
      <?php echo 'Fecha final: Recurrente <br/>' ?>
      <?php echo 'Hora final: Recurrente <br/>' ?>
   <?php else : ?>
      <?php echo 'Fecha final: ' . date('Y-m-d H:i:s', strtotime(get_post_meta(get_the_ID(), '_f_final', true))) . '<br/>' ?>
      <?php echo 'Hora final: ' . date('H:i:s', strtotime(get_post_meta(get_the_ID(), '_f_final', true))) . '<br/>' ?>
   <?php endif; ?>
   <?php echo 'Indicador dia completo: ' . get_post_meta(get_the_ID(), '_dia_completo', true) . '<br/>' ?>
   <?php echo 'Inscripción: ' . get_post_meta(get_the_ID(), '_inscripcion', true) . '<br/>' ?>
   <?php echo 'Donativo: ' . get_post_meta(get_the_ID(), '_donativo', true) . '<br/>' ?>
   <?php echo 'Monto sugerido: ' . get_post_meta(get_the_ID(), '_montodonativo', true) . '<br/>' ?>
   <?php if (get_post_meta(get_the_ID(), '_periodicidadevento', true) == '2') : ?>
      <?php echo 'Número de periodos: ' . get_post_meta(get_the_ID(), '_npereventos', true) ?>
   <?php endif; ?>
   <?php if (get_post_meta(get_the_ID(), '_periodicidadevento', true) == '3') : ?>
      <?php echo 'Número de periodos: ' . get_post_meta(get_the_ID(), '_npereventos', true) . '<br/>' ?>
      <?php echo 'Día semana: ' . get_post_meta(get_the_ID(), '_diasemanaevento', true) ?>
   <?php endif; ?>
   <?php if (get_post_meta(get_the_ID(), '_periodicidadevento', true) == '4') : ?>
   <?php endif; ?>
</p>
<?php if (get_post_meta(get_the_ID(), '_periodicidadevento', true) == '4' || get_post_meta(get_the_ID(), '_periodicidadevento', true) == '5') : ?>
   <?php if (get_post_meta(get_the_ID(), '_opcionesquema', true) == 'on') : ?>
      <p>Opcion 1 mensual - anual</p>
      <p>
         <?php echo 'Opción Esquema mensual - anual: ' . get_post_meta(get_the_ID(), '_opcionesquema', true) . '<br/>' ?>
         <?php echo 'Número de día: ' . get_post_meta(get_the_ID(), '_numerodiaevento', true) . '<br/>' ?>
         <?php echo 'Mes: ' . get_post_meta(get_the_ID(), '_mesevento', true) . '<br/>' ?>
      </p>
   <?php else : ?>
      <p>Opcion 2 mensual - anual</p>
      <p>
         <?php echo 'Opción Esquema mensual - anual: ' . get_post_meta(get_the_ID(), '_opcionesquema', true) . '<br/>' ?>
         <?php echo 'Dia ordinal: ' . get_post_meta(get_the_ID(), '_numerodiaordinalevento', true) . '<br/>' ?>
         <?php echo 'Dia semana: ' . get_post_meta(get_the_ID(), '_diasemanaevento', true) . '<br/>' ?>
         <?php echo 'Mes: ' . get_post_meta(get_the_ID(), '_mesevento', true) . '<br/>' ?>
      </p>
   <?php endif; ?>
<?php endif; ?>