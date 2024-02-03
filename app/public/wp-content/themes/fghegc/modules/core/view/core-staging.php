<h3>Pruebas Funcionales</h3>
<?php

/*
$peticiones =

   get_posts([
      'post_type' => 'peticion',
      'orderby' => get_the_date(),
      'order' => 'DESC',
      'posts_per_page' => -1,
   ]);
foreach ($peticiones as $peticion) {
   $peticionCategories = wp_get_post_categories($peticion->ID);
   foreach ($peticionCategories as $value) {
      $slug = get_category($value)->slug;
      if (term_exists($slug, 'motivo', '')) {
         $termIdMotivo = term_exists($slug, 'motivo', '')['term_id'];
         $termIdCategory = term_exists($slug, 'category', '')['term_id'];
         echo $slug . '  ' . $termIdMotivo . '  ' . $termIdCategory . '<br />';
         wp_set_object_terms($peticion->ID, intval($termIdMotivo), 'motivo');
      }
   }
}
*/