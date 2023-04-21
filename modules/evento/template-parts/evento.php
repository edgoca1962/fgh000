<h4> <a
      href="<?php echo esc_attr(esc_url(get_the_permalink() . '?pag=' . fgh000_get_param(get_post_type())['pag'] . '&' . fgh000_get_param(get_post_type())['mesConsultaLink'])) ?>">
      <?php echo get_the_title() ?></a></h4>
<h5>Fecha próxima reunión:
   <?php echo fgh000_get_param(get_post_type())['diaSemanaPost'][date('l', strtotime(get_post_meta(get_the_ID(), '_f_proxevento', true)))] . ' - ' . date('d-M-Y', strtotime(get_post_meta(get_the_ID(), '_f_proxevento', true))); ?>
</h5>

<p>
   <?php echo 'Tipo evento: ' . get_post_meta(get_the_ID(), '_periodicidadevento', true) . '<br/>' ?>
   <?php echo 'Fecha inicio: ' . get_post_meta(get_the_ID(), '_f_inicio', true) . '<br/>' ?>
   <?php echo 'Hora inicio: ' . get_post_meta(get_the_ID(), '_h_inicio', true) . '<br/>' ?>
   <?php echo 'Fecha final: ' . get_post_meta(get_the_ID(), '_f_final', true) . '<br/>' ?>
   <?php echo 'Hora final: ' . get_post_meta(get_the_ID(), '_h_final', true) . '<br/>' ?>
   <?php echo 'Indicador dia completo: ' . get_post_meta(get_the_ID(), '_dia_completo', true) . '<br/>' ?>
   <?php echo 'Inscripción: ' . get_post_meta(get_the_ID(), '_inscripcion', true) . '<br/>' ?>
   <?php
   echo fgh000_get_param(get_post_type())['mesConsulta'] . '<br>';
   $fechasevento = fgh000_fechasevento(
      get_post_meta(get_the_ID(), '_f_inicio', true),
      get_post_meta(get_the_ID(), '_f_final', true),
      get_post_meta(get_the_ID(), '_periodicidadevento', true),
      get_post_meta(get_the_ID(), '_opcionesquema', true),
      get_post_meta(get_the_ID(), '_numerodiaevento', true),
      get_post_meta(get_the_ID(), '_numerodiaordinalevento', true),
      explode(',', get_post_meta(get_the_ID(), '_diasemanaevento', true)),
      get_post_meta(get_the_ID(), '_mesevento', true),
      fgh000_get_param(get_post_type())['mesConsulta']
   );
   print_r($fechasevento);
   ?>
</p>
<div class="mb-3 <?php echo (get_post_meta(get_the_ID(), '_inscripcion', true) == 'on') ? '' : 'invisible' ?>" <?php echo (get_post_meta(get_the_ID(), '_inscripcion', true) == 'on') ? '' : 'style = "width:0; height:0;"' ?>>
   <button type="button" class="btn btn-warning">Inscribirme</button>
</div>
<p>
   <?php echo 'Donativo: ' . get_post_meta(get_the_ID(), '_donativo', true) . '<br/>' ?>
   <?php echo 'Monto sugerido: ' . get_post_meta(get_the_ID(), '_montodonativo', true) . '<br/>' ?>
   <?php if (get_post_meta(get_the_ID(), '_periodicidadevento', true) == '2'): ?>
      <?php echo 'Número de periodos: ' . get_post_meta(get_the_ID(), '_npereventos', true) ?>
   <?php endif; ?>
   <?php if (get_post_meta(get_the_ID(), '_periodicidadevento', true) == '3'): ?>
      <?php echo 'Número de periodos: ' . get_post_meta(get_the_ID(), '_npereventos', true) . '<br/>' ?>
      <?php echo 'Día semana: ' . get_post_meta(get_the_ID(), '_diasemanaevento', true) ?>
   <?php endif; ?>
   <?php if (get_post_meta(get_the_ID(), '_periodicidadevento', true) == '4'): ?>
   <?php endif; ?>
</p>
<?php if (get_post_meta(get_the_ID(), '_periodicidadevento', true) == '4' || get_post_meta(get_the_ID(), '_periodicidadevento', true) == '5'): ?>
   <?php if (get_post_meta(get_the_ID(), '_opcionesquema', true) == 'on'): ?>
      <p>Opcion 1 mensual - anual</p>
      <p>
         <?php echo 'Opción Esquema mensual - anual: ' . get_post_meta(get_the_ID(), '_opcionesquema', true) . '<br/>' ?>
         <?php echo 'Número de día: ' . get_post_meta(get_the_ID(), '_numerodiaevento', true) . '<br/>' ?>
         <?php echo 'Mes: ' . get_post_meta(get_the_ID(), '_mesevento', true) . '<br/>' ?>
      </p>
   <?php else: ?>
      <p>Opcion 2 mensual - anual</p>
      <p>
         <?php echo 'Opción Esquema mensual - anual: ' . get_post_meta(get_the_ID(), '_opcionesquema', true) . '<br/>' ?>
         <?php echo 'Dia ordinal: ' . get_post_meta(get_the_ID(), '_numerodiaordinalevento', true) . '<br/>' ?>
         <?php echo 'Dia semana: ' . get_post_meta(get_the_ID(), '_diasemanaevento', true) . '<br/>' ?>
         <?php echo 'Mes: ' . get_post_meta(get_the_ID(), '_mesevento', true) . '<br/>' ?>
      </p>
   <?php endif; ?>
<?php endif; ?>
