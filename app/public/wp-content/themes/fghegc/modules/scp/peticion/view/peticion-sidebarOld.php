<?php
$usuario = wp_get_current_user();

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
         'value' => date('Y-m-d'),
         'compare' => '<=',
      ],
   ]
];


$nacimientoDiario = [
   'post_type' => 'peticion',
   'posts_per_page' => -1,
   'meta_query' => [
      [
         'key' => '_f_nacimiento',
         'type' => 'CHAR',
         'value' =>   date('m-d'),
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
   'meta_query' => [
      [
         'key' => '_f_nacimiento',
         'type' => 'CHAR',
         'value' =>   date('m'),
         'compare' => 'LIKE',
      ],
      [
         'key' => '_vigente',
         'value' => 1,
      ],
   ]
];

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
            'value' => date('Y-m-d'),
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
         <div id="resultados_busqueda" data-url="<?php echo get_site_url() ?>"></div>
      </div>
   </div>
</div>
<div class="row">
   <div class="col-6">
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
                     'post_date' => date('Y-m-d'),
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
                  <a href="<?php echo esc_url(get_the_permalink()) ?>"><?php echo get_the_title() ?><?php echo (get_post_meta($post->ID, '_asignar_a', true) != '0') ? ' Asignada a: ' . get_user_by('id', get_post_meta($post->ID, '_asignar_a', true))->display_name : ' - Sin asignar' ?>
                     <span><i class="fas fa-praying-hands"></i></span><span><?php echo ' ' . $conteoOraciones->found_posts ?></span>
                  </a>
               </li>
            <?php endwhile; ?>
         </ul>
      <?php
      endif;
      wp_reset_postdata();
      ?>
   </div>
   <div class="col-6">
      <h4>Cumpleaños de hoy:</h4>
      <?php
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
                        <?php echo get_post_meta($post->ID, '_nombre', true) . ' ' . get_post_meta($post->ID, '_apellido', true) ?>
                     </td>
                     <td>
                        <div class="ps-3">
                           <a href="tel: <?php echo get_post_meta($post->ID, '_telefono', true) ?>"><span class="pe-2"><i class="bi bi-telephone"></i></span><?php echo get_post_meta($post->ID, '_telefono', true) ?></a>
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
      ?>
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
                     'post_date' => date('Y-m-d'),
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
                  <a href="<?php echo esc_url(get_the_permalink()) ?>"><?php echo get_the_title() ?>
                     <span><i class="fas fa-praying-hands"></i></span><span><?php echo ' ' . $conteoOraciones->found_posts ?></span>
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
         'post_status' => 'publish',
         'post_type' => 'peticion'
      ));

      if ($recent_comments) {
         echo '<ol style="color: rgb(163, 158, 158);" class="has-dates has-excerpts wp-block-latest-comments">';
         foreach ((array) $recent_comments as $comment) { ?>

            <li class="wp-block-latest-comments__comment">
               <article>
                  <footer class="wp-block-latest-comments__comment-meta">
                     <a href="<?php echo esc_url(get_comment_link($comment)) ?>"><span>Comentario de <?php echo $comment->comment_author ?> en </span><?php echo get_the_title($comment->comment_post_ID) ?></a>
                     <time datetime="<?php echo $comment->comment_date ?>" class="wp-block-latest-comments__comment-date"><?php echo $comment->comment_date ?></time>
                  </footer>
                  <div class="wp-block-latest-comments__comment-excerpt">
                     <p><?php echo $comment->comment_content ?></p>
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
      $peticiones = get_posts(
         array(
            'post_type' => 'peticion',
            'numberposts' => -1,
            'fields' => 'ids',
         )
      );
      $categorias = get_categories(['object_ids' => $peticiones]);
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
      echo wp_tag_cloud(
         [
            'object_ids' => $peticiones,
            'smallest' => 12,
            'largest' => 22,
            'unit' => 'px',
            'orderby' => 'count',
            'order' => 'DESC',
            'show_count' => 1
         ]
      );
      ?>
   </div>
</div>
<?php
