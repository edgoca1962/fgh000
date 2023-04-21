<div class="card mb-3" style="background-color: #28303d;">
   <div class="row g-0">
      <div class="col-md-4">
         <img src="<?php echo get_post_meta($post->ID, '_poster_path', true) ?>" class="img-fluid rounded-start" alt="<?php the_title() ?>">
      </div>
      <div class="col-md-8">
         <div class="card-body">
            <h5 class="card-title"><?php the_title() ?></h5>
            <p class="card-text"><?php the_content() ?></p>
            <?php print_r(get_the_term_list($post->ID, 'movie_genre', '
            <p><strong>Géneros: </strong>', ', ', '</p>')) ?>
            <p>Fecha de lanzamiento: <?php echo date('Y-m-d', strtotime($post->post_date)) ?></p>
            <p>Popularidad: <?php echo round(get_post_meta($post->ID, '_popularity', true)) ?></p>
            <p>Calificación promedio: <?php echo get_post_meta($post->ID, '_vote_average', true) ?></p>
            <p>Cantidad de calificaciones: <?php echo get_post_meta($post->ID, '_vote_count', true) ?></p>
         </div>
      </div>
   </div>
</div>