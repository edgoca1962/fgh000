<?php
$usuario = wp_get_current_user();
$roles = $usuario->roles;
?>
<div class="row mb-5">
   <div class="position-relative">
      <form id="frmbuscar" class="d-flex">
         <input id="impbuscar" class="form-control w-100 me-2" type="text" style="width: 0;" placeholder="Buscar pelìcula" aria-label="Search">
      </form>
      <div id="resultados" class="container invisible position-absolute search-overlay rounded-3 text-black" style="height:350px; width:90%;">
         <div class="d-flex justify-content-between">
            <h5>Resultados</h5><span><i class="far fa-times-circle" id="btn_cerrar"></i></span>
         </div>
         <div id="resultados_busqueda" data-url="<?= get_site_url() . '/wp-json/wp/v2/movies?search=' ?>"></div>
      </div>
   </div>
</div>
<div class="row ms-3 mb-5">
   <h4>Categorías</h4>
   <?php
   $args = [
      'taxonomy' => 'movie_genre',
      'hide_empty' => false,
      'orderby'   => 'name',
      'hierarchical' => true
   ];

   $terms = get_terms($args);
   if (!empty($terms) && !is_wp_error($terms)) {
      foreach ($terms as $term) {
         $term_link = get_term_link($term->slug, 'movie_genre');
         if (!is_wp_error($term_link)) {
            echo '<a href="' . esc_url($term_link) . '">' . $term->name . ' (' . $term->count . ')</a>';
         }
      }
   }
   ?>
</div>
<div class="row ms-3 mb-5">
   <h4>Fecha de salida</h4>
   <?php get_posts(
      [
         'post_type' => 'movie'
      ]
   )
   ?>
</div>