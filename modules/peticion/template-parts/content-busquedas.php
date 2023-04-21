<?php
$usuario = wp_get_current_user();
$fecha_hoy = new DateTime('now', new DateTimeZone('America/Costa_Rica'));


$seguimiento = [
   'post_type' => 'peticion',
   'orderby' => get_the_date(),
   'order' => 'DESC',
   'posts_per_page' => -1,
   'meta_query' =>
   [
      [
         'key' => '_vigente',
         'value' => '1',
      ],
      [
         'key' => '_f_seguimiento',
         'type' => 'DATE',
         'value' => $fecha_hoy->format('Y-m-d'),
         'compare' => '<=',
      ],
   ]
];

$now = $fecha_hoy->format('m-d');
$nacimientoDiario = [
   'post_type' => 'peticion',
   'posts_per_page' => -1,
   'meta_query' => [
      [
         'key' => '_f_nacimiento',
         'type' => 'CHAR',
         'value' =>   $fecha_hoy->format('m-d'),
         'compare' => 'LIKE'
      ],
      [
         'key' => '_vigente',
         'value' => 1,
      ],
   ]
];

$nacimiento = [
   'post_type' => 'peticion',
   'posts_per_page' => -1,
   'meta_key' => '_vigente',
   'meta_value' => 1,
];
$fechanacimiento = [];
$query = new WP_Query($nacimiento);
if ($query->have_posts()) {
   while ($query->have_posts()) {
      $query->the_post();
      $fecha = get_post_meta($post->ID, '_f_nacimiento', true);
      if (date('Y', strtotime($fecha)) != '-0001') {
         $fecnac = date('Y-m-d', mktime(0, 0, 0, date('m', strtotime($fecha)), date('d', strtotime(date($fecha))), date('Y')));
         if (date('Y-m', strtotime($fecnac)) == date('Y-m')) {
            $fechanacimiento[] = [
               'dia' => date('d', strtotime($fecnac)),
               'nombre' => get_post_meta($post->ID, '_nombre', true),
               'apellido' => get_post_meta($post->ID, '_apellido', true),
               'telefono' => get_post_meta($post->ID, '_telefono', true),
            ];
         }
      } else {
         $fechacorrecta = 'No ';
         $fecha_cumple_mes = '';
      }
   }
   wp_reset_postdata();
}
sort($fechanacimiento);

$asignar_a = $usuario->ID;
$asignados =
   [
      'post_type' => 'peticion',
      'orderby' => '_f_seguimiento',
      'order' => 'DESC',
      'posts_per_page' => -1,
      'meta_query' =>
      [
         'relation' => 'AND',
         [
            'key' => '_vigente',
            'value' => 1,
         ],
         [
            'key' => '_f_seguimiento',
            'type' => 'DATE',
            'value' => $fecha_hoy->format('Y-m-d'),
            'compare' => '<=',
         ],
         [
            'key' => '_asignar_a',
            'value' => $asignar_a,
         ],
      ]
   ];

?>
<div class="row mb-3">
   <div class="position-relative">
      <form id="frmbuscar" class="d-flex">
         <input id="impbuscar" class="form-control w-75 me-2" type="text" style="width: 0;" placeholder="Buscar" aria-label="Search">
      </form>
      <div id="resultados" class="container invisible position-absolute search-overlay rounded-3 w-75" style="height:300px;">
         <div class="d-flex justify-content-between">
            <h4>Peticiones</h4><span id="btn_cerrar"><i class="far fa-times-circle"></i></span>
         </div>
         <div id="resultados_busqueda" data-url="<?= get_site_url() ?>"></div>
      </div>
   </div>
</div>
<div class="row">
   <div class="col-md-6">
      <h4>Hoy debemos orar por:</h4>
      <?php
      // $query2 = new WP_Query($seguimientonuevo);
      $query = new WP_Query($seguimiento);
      if ($query->have_posts()) :
      ?>
         <ul class="wp-block-categories-list wp-block-categories">
            <?php
            while ($query->have_posts()) :
               $query->the_post();
               $conteoOraciones = new WP_Query(
                  [
                     'post_type' => 'oracion',
                     'post_date' => $fecha_hoy->format('Y-m-d'),
                     'meta_query' => [
                        [
                           'key' => '_peticion',
                           'value' => $post->ID,
                        ],
                     ]
                  ]
               );
            ?>
               <li>
                  <a href="<?= esc_url(get_the_permalink()) ?>"><?= get_the_title() ?><?= (get_post_meta($post->ID, '_asignar_a', true) != '0') ? ' Asignada a: ' . get_user_by('id', get_post_meta($post->ID, '_asignar_a', true))->display_name : ' - Sin asignar' ?>
                     <span><i class="fas fa-praying-hands"></i></span><span><?= ' ' . $conteoOraciones->found_posts ?></span>
                  </a>
               </li>
            <?php endwhile; ?>
         </ul>
      <?php
      endif;
      wp_reset_postdata();
      ?>
   </div>
   <div class="col-md-6">
      <h4>Cumpleaños del mes:</h4>
      <table class="table table-responsive table-sm table-borderless text-white">
         <thead class="table-dark">
            <tr>
               <th scope="col">Día</th>
               <th scope="col">Nombre</th>
               <th scope="col">Teléfono</th>
            </tr>
         </thead>
         <tbody>
            <?php
            for ($i = 0; $i < count($fechanacimiento); $i++) {
               if (date('d') == $fechanacimiento[strval($i)]['dia']) {
                  $class = 'table-light';
               } else {
                  $class = '';
               }
            ?>
               <tr class="<?php echo $class ?>">
                  <th scope="row"><?php echo $fechanacimiento[strval($i)]['dia'] ?></th>
                  <td><?php echo $fechanacimiento[strval($i)]['nombre'] . ' ' . $fechanacimiento[strval($i)]['apellido'] ?></td>
                  <td><?php echo '<a href="tel:' . $fechanacimiento[strval($i)]['telefono'] . '">' . $fechanacimiento[strval($i)]['telefono'] . '</a>'  ?></td>
               </tr>
            <?php
            }
            ?>
         </tbody>
      </table>
      <?php /*
      $query = new WP_Query($nacimientoDiario);
      if ($query->have_posts()) :
      ?>
         <table>
            <tbody>
               <?php
               while ($query->have_posts()) :
                  $query->the_post();
               ?>
                  <tr>
                     <td>
                        <?= get_post_meta($post->ID, '_nombre', true) . ' ' . get_post_meta($post->ID, '_apellido', true) ?>
                     </td>
                     <td>
                        <div class="ps-3">
                           <a href="tel: <?= get_post_meta($post->ID, '_telefono', true) ?>"><span class="pe-2"><i class="bi bi-telephone"></i></span><?= get_post_meta($post->ID, '_telefono', true) ?></a>
                        </div>
                     </td>
                  </tr>
               <?php endwhile; ?>
            </tbody>
         </table>
      <?php
      endif;
      // Reset the `$post` data to the current post in main query.
      wp_reset_postdata();
     */ ?>
   </div>
</div>
<div class="row">
   <div class="col-6">
      <h4>Seguimiento asignado para hoy:</h4>
      <?php
      $query = new WP_Query($asignados);
      if ($query->have_posts()) :
      ?>
         <ul class="wp-block-categories-list wp-block-categories">
            <?php
            while ($query->have_posts()) :
               $query->the_post();
               $conteoOraciones = new WP_Query(
                  [
                     'post_type' => 'oracion',
                     'post_date' => $fecha_hoy->format('Y-m-d'),
                     'meta_query' => [
                        [
                           'key' => 'peticion',
                           'value' => get_the_ID(),
                        ],
                     ]
                  ]
               );
            ?>
               <li>
                  <a href="<?= esc_url(get_the_permalink()) ?>"><?= get_the_title() ?>
                     <span><i class="fas fa-praying-hands"></i></span><span><?= ' ' . $conteoOraciones->found_posts ?></span>
                  </a>
               </li>
            <?php endwhile; ?>
         </ul>
      <?php
      endif;
      // Reset the `$post` data to the current post in main query.
      wp_reset_postdata();
      ?>

   </div>
   <div class="col-6">
      <h4>Asignadas a:</h4>
      <?php
      $usuarios = get_users('orderby=name&role=peticiones');
      echo '<ul>';
      foreach ($usuarios as $usuario) {
         echo '<li><a href="' . site_url('/asignado-' . $usuario->ID) . '">' . $usuario->display_name . '</a></li>';
      }
      echo '</ul>';
      ?>
   </div>
</div>
<div class="row">
   <div class="col-12 wp-block-group__inner-container">
      <h4>Comentarios de seguimiento</h4>
      <?php $recent_comments = get_comments(array(
         'number'      => 5,
         'status'      => 'approve',
         'post_status' => 'publish'
      ));

      if ($recent_comments) {
         echo '<ol style="color: rgb(163, 158, 158);" class="has-dates has-excerpts wp-block-latest-comments">';
         foreach ((array) $recent_comments as $comment) { ?>

            <li class="wp-block-latest-comments__comment">
               <article>
                  <footer class="wp-block-latest-comments__comment-meta">
                     <a href="<?= esc_url(get_comment_link($comment)) ?>"><span>Comentario de <?= $comment->comment_author ?> en </span><?= get_the_title($comment->comment_post_ID) ?></a>
                     <time datetime="<?= $comment->comment_date ?>" class="wp-block-latest-comments__comment-date"><?= $comment->comment_date ?></time>
                  </footer>
                  <div class="wp-block-latest-comments__comment-excerpt">
                     <p><?= $comment->comment_content ?></p>
                  </div>
               </article>
            </li>
         <?php
         }
         ?>
         </ol>

      <?php } ?>
   </div>
</div>
<div class="row">
   <div class="col-md-6">
      <h4>Motivos de oración</h4>
      <?php
      $args = [
         'orderby'   => 'name'
      ];
      $categorias = get_categories($args);
      ?>
      <ul>
         <?php foreach ($categorias as $categoria) :
         ?>
            <li>
               <a class="tag-cloud-link" href="<?= get_category_link($categoria->cat_ID) ?>"><?= $categoria->name ?><span>(<?= $categoria->count ?>)</span></a>
            </li>
         <?php endforeach; ?>
      </ul>
   </div>
   <div class="col-md-6">

      <h4><i class="fas fa-tag"></i> Palabras clave</h4>
      <?php
      echo $tags_list = wp_tag_cloud('smallest=12&largest=22&unit=px&orderby=count&order=DESC&show_count=1');
      ?>
   </div>
</div>
<?php
