<?php

/******************************************************************************
 * 
 * 
 * Crea la página para el manejo la creación de movies.
 * 
 * 
 *****************************************************************************/
$consulta = get_posts([
   'post_type' => 'page',
   'name' => 'sctv-consulta',
   'post_status' => 'publish',
]);
if (count($consulta) > 0) {
} else {
   $post_data = array(
      'post_type' => 'page',
      'post_title' => 'Consulta de Películas y Series',
      'post_name' => 'sctv-consulta',
      'post_status' => 'publish',
   );
   wp_insert_post($post_data);
}
if (!function_exists('fgh000_get_movie_param')) {
   function fgh000_get_movie_param($postType = 'movie')
   {
      $atributos = [];

      $fullpage = false;
      $titulo = 'Películas';
      $fontweight = 'fw-lighter';
      $display = 'display-4';
      $subtitulo = '';
      $displaysub = 'display-5';
      $subtitulo2 = '';
      $displaysub2 = 'display-6';
      $height = '60vh';
      $div0 = 'container py-5';
      $div1 = '';
      $div2 = '';
      $div3 = '';
      $div4 = '';
      $agregarpost = '';
      $templatepart = ''; //'modules/' . $postType . '/template-parts/' . $postType;
      $barra = '';
      $templatepartsingle = ''; //'modules/' . $postType . '/template-parts/' . $postType . '-single';
      $btn_regresar = ''; //'modules/' . $postType . '/template-parts/' . $postType . '-regresar';
      $regresar = $postType;
      if (get_the_post_thumbnail_url()) {
         $imagen = get_the_post_thumbnail_url();
      } else {
         $imagen = get_template_directory_uri() . '/assets/img/bg.jpg';
      }
      if (get_the_archive_title() == 'Archives' || get_the_archive_title() == 'Archivos') {
         $subtitulo = '';
      } else {
         $subtitulo = str_replace('Tag', 'Etiqueta', get_the_archive_title(), $count);
      }
      if (is_single()) {
         $subtitulo = get_the_title();
      } else {
         $div3 = 'row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4';
      }
      $atributos['imagen'] = $imagen;
      $atributos['fullpage'] = $fullpage;
      $atributos['titulo'] = $titulo;
      $atributos['fontweight'] = $fontweight;
      $atributos['display'] = $display;
      $atributos['subtitulo'] = $subtitulo;
      $atributos['displaysub'] = $displaysub;
      $atributos['subtitulo2'] = $subtitulo2;
      $atributos['displaysub2'] = $displaysub2;
      $atributos['height'] = $height;
      $atributos['div0'] = $div0;
      $atributos['div1'] = $div1;
      $atributos['div2'] = $div2;
      $atributos['div3'] = $div3;
      $atributos['div4'] = $div4;
      $atributos['agregarpost'] = $agregarpost;
      $atributos['templatepart'] = $templatepart;
      $atributos['barra'] = $barra;
      $atributos['templatepartsingle'] = $templatepartsingle;
      $atributos['btn_regresar'] = $btn_regresar;
      $atributos['regresar'] = $regresar;
      return $atributos;
   }
}

if (!function_exists('fgh001_insertar_movies')) {

   function fgh001_insertar_movies()
   {
      //Validación de seguridad
      if (!wp_verify_nonce($_POST['nonce'], 'agregar_pelicula')) {
         wp_send_json_error('Error de seguridad', 401);
         wp_die();
      } else {

         //Creación aleatoria del nombre del permalink del post
         $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
         $charactersLength = strlen($characters);
         $randomString = '';
         for ($i = 0; $i < 15; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
         }

         $adult = (sanitize_text_field($_POST['adult']) == 'false') ? 0 : 1;
         $backdrop_path = sanitize_text_field($_POST['backdrop_path']);

         $cat28 = (empty($_POST['cat28'])) ? '' : 'Acción';
         $cat12 = (empty($_POST['cat12'])) ? '' : 'Aventura';
         $cat16 = (empty($_POST['cat16'])) ? '' : 'Animación';
         $cat35 = (empty($_POST['cat35'])) ? '' : 'Comedia';
         $cat80 = (empty($_POST['cat80'])) ? '' : 'Crimen';
         $cat99 = (empty($_POST['cat99'])) ? '' : 'Documental';
         $cat18 = (empty($_POST['cat18'])) ? '' : 'Drama';
         $cat10751 = (empty($_POST['cat10751'])) ? '' : 'Familia';
         $cat14 = (empty($_POST['cat14'])) ? '' : 'Fantasía';
         $cat36 = (empty($_POST['cat36'])) ? '' : 'Historia';
         $cat27 = (empty($_POST['cat27'])) ? '' : 'Terror';
         $cat10402 = (empty($_POST['cat10402'])) ? '' : 'Música';
         $cat9648 = (empty($_POST['cat9648'])) ? '' : 'Misterio';
         $cat10749 = (empty($_POST['cat10749'])) ? '' : 'Romance';
         $cat878 = (empty($_POST['cat878'])) ? '' : 'Ciencia ficción';
         $cat10770 = (empty($_POST['cat10770'])) ? '' : 'Película de TV';
         $cat53 = (empty($_POST['cat53'])) ? '' : 'Suspenso';
         $cat10752 = (empty($_POST['cat10752'])) ? '' : 'Bélica';
         $cat37 = (empty($_POST['cat37'])) ? '' : 'Western';
         $post_id = sanitize_text_field($_POST['post_id']);
         $original_language = sanitize_text_field($_POST['original_language']);
         $original_title = sanitize_text_field($_POST['original_title']);
         $post_content = sanitize_text_field($_POST['post_content']);
         $popularity = sanitize_text_field($_POST['popularity']);
         $poster_path = sanitize_text_field($_POST['poster_path']);
         $post_date = sanitize_text_field($_POST['post_date']);
         $post_title = sanitize_text_field($_POST['post_title']);
         $video = sanitize_text_field($_POST['video']);
         $vote_average = sanitize_text_field($_POST['vote_average']);
         $vote_count = sanitize_text_field($_POST['vote_count']);
         $post_name = 'movie_' . $randomString;

         $genres = array(
            $cat28,
            $cat12,
            $cat16,
            $cat35,
            $cat80,
            $cat99,
            $cat18,
            $cat10751,
            $cat14,
            $cat36,
            $cat27,
            $cat10402,
            $cat9648,
            $cat10749,
            $cat878,
            $cat10770,
            $cat53,
            $cat10752,
            $cat37
         );

         //wakanda = 505642

         $post_data = array(
            'import_id' => $post_id,
            'post_type' => 'movie',
            'post_title' => $post_title,
            'post_content' => $post_content,
            'post_name' => $post_name,
            'post_date' => $post_date,
            'post_status' => 'publish',
            'post_parent' => '',
            'meta_input' => array(
               '_adult' => $adult,
               '_backdrop_path' => $backdrop_path,
               '_original_language' => $original_language,
               '_original_title' => $original_title,
               '_popularity' => $popularity,
               '_poster_path' => $poster_path,
               '_video' => $video,
               '_vote_average' => $vote_average,
               '_vote_count' => $vote_count
            )
         );

         wp_insert_post($post_data);
         wp_set_object_terms($post_id, $genres, 'movie_genre', true);
         wp_send_json_success('ok');
         wp_die();
      }
   }
   add_action('wp_ajax_agregar_pelicula', 'fgh001_insertar_movies');
}
if (!function_exists('fgh001_agregar_movie_data')) {

   function fgh001_agregar_movie_data()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'agregar_movie_data')) {
         wp_send_json_error('Error de seguridad', 401);
         wp_die();
      } else {

         $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
         $charactersLength = strlen($characters);
         $randomString = '';
         for ($i = 0; $i < 15; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
         }

         $image_base_url = 'http://image.tmdb.org/t/p/w342';

         $adult = (sanitize_text_field($_POST['adult']) == 'false') ? 0 : 1;
         $backdrop_path = $image_base_url . sanitize_text_field($_POST['backdrop_path']);
         $cat28 = (empty($_POST['genre_ids_28'])) ? '' : 'Acción';
         $cat12 = (empty($_POST['genre_ids_12'])) ? '' : 'Aventura';
         $cat16 = (empty($_POST['genre_ids_16'])) ? '' : 'Animación';
         $cat35 = (empty($_POST['genre_ids_35'])) ? '' : 'Comedia';
         $cat80 = (empty($_POST['genre_ids_80'])) ? '' : 'Crimen';
         $cat99 = (empty($_POST['genre_ids_99'])) ? '' : 'Documental';
         $cat18 = (empty($_POST['genre_ids_18'])) ? '' : 'Drama';
         $cat10751 = (empty($_POST['genre_ids_10751'])) ? '' : 'Familia';
         $cat14 = (empty($_POST['genre_ids_14'])) ? '' : 'Fantasía';
         $cat36 = (empty($_POST['genre_ids_36'])) ? '' : 'Historia';
         $cat27 = (empty($_POST['genre_ids_27'])) ? '' : 'Terror';
         $cat10402 = (empty($_POST['genre_ids_10402'])) ? '' : 'Música';
         $cat9648 = (empty($_POST['genre_ids_9648'])) ? '' : 'Misterio';
         $cat10749 = (empty($_POST['genre_ids_10749'])) ? '' : 'Romance';
         $cat878 = (empty($_POST['genre_ids_878'])) ? '' : 'Ciencia ficción';
         $cat10770 = (empty($_POST['genre_ids_10770'])) ? '' : 'Película de TV';
         $cat53 = (empty($_POST['genre_ids_53'])) ? '' : 'Suspenso';
         $cat10752 = (empty($_POST['genre_ids_10752'])) ? '' : 'Bélica';
         $cat37 = (empty($_POST['genre_ids_37'])) ? '' : 'Western';
         $post_id = sanitize_text_field($_POST['id']);
         $original_language = sanitize_text_field($_POST['original_language']);
         $original_title = sanitize_text_field($_POST['original_title']);
         $post_content = sanitize_text_field($_POST['overview']);
         $popularity = sanitize_text_field($_POST['popularity']);
         $poster_path = $image_base_url . sanitize_text_field($_POST['poster_path']);
         $post_date = sanitize_text_field($_POST['release_date']);
         $post_title = sanitize_text_field($_POST['title']);
         $video = sanitize_text_field($_POST['video']);
         $vote_average = sanitize_text_field($_POST['vote_average']);
         $vote_count = sanitize_text_field($_POST['vote_count']);
         $post_name = 'movie_' . $randomString;

         $genres = array(
            $cat28,
            $cat12,
            $cat16,
            $cat35,
            $cat80,
            $cat99,
            $cat18,
            $cat10751,
            $cat14,
            $cat36,
            $cat27,
            $cat10402,
            $cat9648,
            $cat10749,
            $cat878,
            $cat10770,
            $cat53,
            $cat10752,
            $cat37
         );
         $post_data = array(
            'import_id' => $post_id,
            'post_type' => 'movie',
            'post_title' => $post_title,
            'post_content' => $post_content,
            'post_name' => $post_name,
            'post_date' => $post_date,
            'post_status' => 'publish',
            'post_parent' => '',
            'meta_input' => array(
               '_adult' => $adult,
               '_backdrop_path' => $backdrop_path,
               '_original_language' => $original_language,
               '_original_title' => $original_title,
               '_popularity' => $popularity,
               '_poster_path' => $poster_path,
               '_video' => $video,
               '_vote_average' => $vote_average,
               '_vote_count' => $vote_count
            )
         );

         wp_insert_post($post_data);
         wp_set_object_terms($post_id, $genres, 'movie_genre', true);
         wp_send_json_success($_POST);
         wp_die();
      }
   }
   add_action('wp_ajax_agregar_movie_data', 'fgh001_agregar_movie_data');
}