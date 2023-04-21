<?php

/******************************************************************************
 * 
 * 
 * Crea las etiquetas del post
 * 
 * 
 *****************************************************************************/
function fgh001_crea_etiquetas_movie($singular = 'Post', $plural = 'Posts')
{
   $p_lower = strtolower($plural);
   $s_lower = strtolower($singular);

   return [
      'name'                     => _x($plural, 'post type general name', 'fgh001'),
      'singular_name'            => _x($singular, 'post type singular name', 'fgh001'),
      'menu_name'                => _x($plural, 'admin menu', 'fgh001'),
      'name_admin_bar'           => _x($singular, 'add new on admin bar', 'fgh001'),
      'add_new'                  => _x("Nuevo $singular", 'prayer', 'fgh001'),
      'add_new_item'             => __("Agregar $singular", 'fgh001'),
      'new_item'                 => __("Nuevo $singular", 'fgh001'),
      'edit_item'                => __("Editar $singular", 'fgh001'),
      'view_item'                => __("Ver $singular", 'fgh001'),
      'view_items'               => __("Ver $plural", 'fgh001'),
      'all_items'                => __("Todos $plural", 'fgh001'),
      'search_items'             => __("Buscar $plural", 'fgh001'),
      'parent_item_colon'        => __("Parent $singular", 'fgh001'),
      'not_found'                => __("No $p_lower found", 'fgh001'),
      'not_found_in_trash'       => __("No $p_lower found in trash", 'fgh001'),
      'archives'                 => __("$singular Archives", 'fgh001'),
      'attributes'               => __("$singular Attributes", 'fgh001'),
      'insert_into_item'         => __("Insertar $s_lower", 'fgh001'),
      'uploaded_to_this_item'    => __("Adjuntar a un $s_lower", 'fgh001'),
   ];
}
/******************************************************************************
 * 
 * 
 * Aplica capacidades al post
 * 
 * 
 *****************************************************************************/
function fgh001_capacidades_movie($singular = 'post', $plural = 'posts')
{
   return [
      'edit_post'                => "edit_$singular",
      'read_post'                => "read_$singular",
      'delete_post'              => "delete_$singular",
      'edit_posts'               => "edit_$plural",
      'edit_others_posts'        => "edit_others_$plural",
      'publish_posts'            => "publish_$plural",
      'read_private_posts'       => "read_private_$plural",
      'read'                     => "read",
      'delete_posts'             => "delete_$plural",
      'delete_private_posts'     => "delete_private_$plural",
      'delete_published_posts'   => "delete_published_$plural",
      'delete_others_posts'      => "delete_others_$plural",
      'edit_private_posts'       => "edit_private_$plural",
      'edit_published_posts'     => "edit_published_$plural",
      'create_posts'             => "edit_$plural",
   ];
}
/******************************************************************************
 * 
 * 
 * Crea el post personalizado
 * 
 * 
 *****************************************************************************/
function fgh001_movie_post_type()
{
   $type = 'movie';
   $labels = fgh001_crea_etiquetas_movie('movie', 'movies');
   $capabilities = fgh001_capacidades_movie('movie', 'movies');

   $args = array(
      'capability_type'          => ['movie', 'movies'],
      'map_meta_cap'             => true,
      'labels'                   => $labels,
      'public'                   => true,
      'has_archive'              => true,
      'rewrite'                  => ['slug' => 'movies'],
      'show_in_rest'             => true,
      'rest_base'                => 'movies',
      'menu_icon'                => 'dashicons-book',
      'supports'                 => array('title', 'editor', 'custom-fields'),
      'taxonomies'               => ['movie_genre'],
   );

   register_post_type($type, $args);
}
add_action('init', 'fgh001_movie_post_type');
/******************************************************************************
 * 
 * 
 * Add custom taxonomies
 *
 * Additional custom taxonomies can be defined here
 * https://codex.wordpress.org/Function_Reference/register_taxonomy
 * 
 * 
 * 
 *****************************************************************************/
function add_genre_taxonomies()
{
   // Add new taxonomy, make it hierarchical (like categories)
   $labels = array(
      'name'              => _x('Genres', 'taxonomy general name'),
      'singular_name'     => _x('Genre', 'taxonomy singular name'),
      'search_items'      => __('Search Genres'),
      'all_items'         => __('All Genres'),
      'parent_item'       => __('Parent Genre'),
      'parent_item_colon' => __('Parent Genre:'),
      'edit_item'         => __('Edit Genre'),
      'update_item'       => __('Update Genre'),
      'add_new_item'      => __('Add New Genre'),
      'new_item_name'     => __('New Genre Name'),
      'menu_name'         => __('Genre'),
   );

   $args = array(
      'hierarchical'      => true,
      'labels'            => $labels,
      'show_ui'           => true,
      'show_admin_column' => true,
      'show_in_rest'      => true,
      'query_var'         => true,
      'rewrite'           => array('slug' => 'genre'),
   );

   register_taxonomy('movie_genre', array('movie'), $args);
}
add_action('init', 'add_genre_taxonomies', 0);
/***************************************************
 * Agrega a movie para consultar por
 * Categorías y etiquetas.
 **************************************************/
function movie_taxonomia_filter($query)
{
   if (!is_admin() && $query->is_main_query()) {
      if ($query->is_category() || $query->is_tag()) {
         $query->set('post_type', array('movie'));
      }
   }
}
add_action('pre_get_posts', 'movie_taxonomia_filter');
/******************************************************************************
 * 
 * 
 * Otorga facultados a los roles para los custom posts type
 * 
 * 
 *****************************************************************************/
add_action('init', function () {
   $admin = get_role('administrator');
   $capabilities = fgh001_capacidades_movie('movie', 'movies');
   foreach ($capabilities as $capability) {
      if (!$admin->has_cap($capability)) {
         $admin->add_cap($capability);
      }
   }
});
/******************************************************************************
 * 
 * 
 * Cambia el ordenamiento de los posts tipo comité
 * 
 * 
 *****************************************************************************/
function fgh001_orden_movies($query)
{
   if (!is_admin() && is_post_type_archive() && $query->is_main_query()) {
      $query->set('orderby', ['ID']);
      $query->set('order', 'ASC');
   }
}
add_action('pre_get_posts', 'fgh001_orden_movies');
/******************************************************************************
 * 
 * 
 * 
 * Creación de campos personalizados 
 * 
 * 
 * 
 *****************************************************************************/
function fgh_001_crear_campos_movie()
{
   add_meta_box(
      'adult',
      'Adult',
      'fgh001_crear_adult_cbk',
      'movie',
      'normal',
      'default'
   );
   function fgh001_crear_adult_cbk($post)
   {
      wp_nonce_field('adult_nonce', 'adult_nonce');
      $adult = get_post_meta($post->ID, '_adult', true);
      echo '<input type="text" style="width:5%" id="adult" name="adult" value="' . esc_attr($adult) . '" </input> (0=false/1=true)';
   }

   add_meta_box(
      'backdrop_path',
      'Backdrop',
      'fgh001_crear_backdrop_path_cbk',
      'movie',
      'normal',
      'default'
   );
   function fgh001_crear_backdrop_path_cbk($post)
   {
      wp_nonce_field('backdrop_path_nonce', 'backdrop_path_nonce');
      $backdrop_path = get_post_meta($post->ID, '_backdrop_path', true);
      echo '<input type="text" style="width:30%" id="backdrop_path" name="backdrop_path" value="' . esc_attr($backdrop_path) . '" </input>';
   }

   // Movie id as ID

   add_meta_box(
      'original_language',
      'Original Language',
      'fgh001_crear_original_language_cbk',
      'movie',
      'normal',
      'default'
   );
   function fgh001_crear_original_language_cbk($post)
   {
      wp_nonce_field('original_language_nonce', 'original_language_nonce');
      $original_language = get_post_meta($post->ID, '_original_language', true);
      echo '<input type="text" style="width:20%" id="original_language" name="original_language" value="' . esc_attr($original_language) . '" </input>';
   }

   add_meta_box(
      'original_title',
      'Original Title',
      'fgh001_crear_original_title_cbk',
      'movie',
      'normal',
      'default'
   );
   function fgh001_crear_original_title_cbk($post)
   {
      wp_nonce_field('original_title_nonce', 'original_title_nonce');
      $original_title = get_post_meta($post->ID, '_original_title', true);
      echo '<input type="text" style="width:20%" id="original_title" name="original_title" value="' . esc_attr($original_title) . '" </input>';
   }

   //overview = content


   add_meta_box(
      'popularity',
      'Popularity',
      'fgh001_crear_popularity_cbk',
      'movie',
      'normal',
      'default'
   );
   function fgh001_crear_popularity_cbk($post)
   {
      wp_nonce_field('popularity_nonce', 'popularity_nonce');
      $popularity = get_post_meta($post->ID, '_popularity', true);
      echo '<input type="text" style="width:20%" id="popularity" name="popularity" value="' . esc_attr($popularity) . '" </input>';
   }

   add_meta_box(
      'poster_path',
      'Poster',
      'fgh001_crear_poster_path_cbk',
      'movie',
      'normal',
      'default'
   );
   function fgh001_crear_poster_path_cbk($post)
   {
      wp_nonce_field('poster_path_nonce', 'poster_path_nonce');
      $poster_path = get_post_meta($post->ID, '_poster_path', true);
      echo '<input type="text" style="width:20%" id="poster_path" name="poster_path" value="' . esc_attr($poster_path) . '" </input>';
   }

   // release_date = post_date


   // title = title


   add_meta_box(
      'video',
      'Video',
      'fgh001_crear_video_cbk',
      'movie',
      'normal',
      'default'
   );
   function fgh001_crear_video_cbk($post)
   {
      wp_nonce_field('video_nonce', 'video_nonce');
      $video = get_post_meta($post->ID, '_video', true);
      echo '<input type="text" style="width:20%" id="video" name="video" value="' . esc_attr($video) . '" </input>';
   }

   add_meta_box(
      'vote_average',
      'Vote Average',
      'fgh001_crear_vote_average_cbk',
      'movie',
      'normal',
      'default'
   );
   function fgh001_crear_vote_average_cbk($post)
   {
      wp_nonce_field('vote_average_nonce', 'vote_average_nonce');
      $vote_average = get_post_meta($post->ID, '_vote_average', true);
      echo '<input type="text" style="width:20%" id="vote_average" name="vote_average" value="' . esc_attr($vote_average) . '" </input>';
   }

   add_meta_box(
      'vote_count',
      'Vote Count',
      'fgh001_crear_vote_count_cbk',
      'movie',
      'normal',
      'default'
   );
   function fgh001_crear_vote_count_cbk($post)
   {
      wp_nonce_field('vote_count_nonce', 'vote_count_nonce');
      $vote_count = get_post_meta($post->ID, '_vote_count', true);
      echo '<input type="text" style="width:20%" id="vote_count" name="vote_count" value="' . esc_attr($vote_count) . '" </input>';
   }
}
add_action('add_meta_boxes', 'fgh_001_crear_campos_movie');
function fgh001_guardar_adult($post_id)
{
   if (!isset($_POST['adult_nonce'])) {
      return;
   }
   if (!wp_verify_nonce($_POST['adult_nonce'], 'adult_nonce')) {
      return;
   }
   if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return;
   }
   if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
      if (!current_user_can('edit_page', $post_id)) {
         return;
      }
   } else {
      if (!current_user_can('edit_post', $post_id)) {
         return;
      }
   }
   if (!isset($_POST['adult'])) {
      return;
   }
   $adult = sanitize_text_field($_POST['adult']);
   update_post_meta($post_id, '_adult', $adult);
}
add_action('save_post', 'fgh001_guardar_adult');


function fgh001_guardar_backdrop_path($post_id)
{
   if (!isset($_POST['backdrop_path_nonce'])) {
      return;
   }
   if (!wp_verify_nonce($_POST['backdrop_path_nonce'], 'backdrop_path_nonce')) {
      return;
   }
   if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return;
   }
   if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
      if (!current_user_can('edit_page', $post_id)) {
         return;
      }
   } else {
      if (!current_user_can('edit_post', $post_id)) {
         return;
      }
   }
   if (!isset($_POST['backdrop_path'])) {
      return;
   }
   $backdrop_path = sanitize_text_field($_POST['backdrop_path']);
   update_post_meta($post_id, '_backdrop_path', $backdrop_path);
}
add_action('save_post', 'fgh001_guardar_backdrop_path');

function fgh001_guardar_original_language($post_id)
{
   if (!isset($_POST['original_language_nonce'])) {
      return;
   }
   if (!wp_verify_nonce($_POST['original_language_nonce'], 'original_language_nonce')) {
      return;
   }
   if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return;
   }
   if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
      if (!current_user_can('edit_page', $post_id)) {
         return;
      }
   } else {
      if (!current_user_can('edit_post', $post_id)) {
         return;
      }
   }
   if (!isset($_POST['original_language'])) {
      return;
   }
   $original_language = sanitize_text_field($_POST['original_language']);
   update_post_meta($post_id, '_original_language', $original_language);
}
add_action('save_post', 'fgh001_guardar_original_language');

function fgh001_guardar_popularity($post_id)
{
   if (!isset($_POST['popularity_nonce'])) {
      return;
   }
   if (!wp_verify_nonce($_POST['popularity_nonce'], 'popularity_nonce')) {
      return;
   }
   if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return;
   }
   if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
      if (!current_user_can('edit_page', $post_id)) {
         return;
      }
   } else {
      if (!current_user_can('edit_post', $post_id)) {
         return;
      }
   }
   if (!isset($_POST['popularity'])) {
      return;
   }
   $popularity = sanitize_text_field($_POST['popularity']);
   update_post_meta($post_id, '_popularity', $popularity);
}
add_action('save_post', 'fgh001_guardar_popularity');

function fgh001_guardar_poster_path($post_id)
{
   if (!isset($_POST['poster_path_nonce'])) {
      return;
   }
   if (!wp_verify_nonce($_POST['poster_path_nonce'], 'poster_path_nonce')) {
      return;
   }
   if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return;
   }
   if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
      if (!current_user_can('edit_page', $post_id)) {
         return;
      }
   } else {
      if (!current_user_can('edit_post', $post_id)) {
         return;
      }
   }
   if (!isset($_POST['poster_path'])) {
      return;
   }
   $poster_path = sanitize_text_field($_POST['poster_path']);
   update_post_meta($post_id, '_poster_path', $poster_path);
}
add_action('save_post', 'fgh001_guardar_poster_path');

function fgh001_guardar_video($post_id)
{
   if (!isset($_POST['video_nonce'])) {
      return;
   }
   if (!wp_verify_nonce($_POST['video_nonce'], 'video_nonce')) {
      return;
   }
   if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return;
   }
   if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
      if (!current_user_can('edit_page', $post_id)) {
         return;
      }
   } else {
      if (!current_user_can('edit_post', $post_id)) {
         return;
      }
   }
   if (!isset($_POST['video'])) {
      return;
   }
   $video = sanitize_text_field($_POST['video']);
   update_post_meta($post_id, '_video', $video);
}
add_action('save_post', 'fgh001_guardar_video');

function fgh001_guardar_vote_average($post_id)
{
   if (!isset($_POST['vote_average_nonce'])) {
      return;
   }
   if (!wp_verify_nonce($_POST['vote_average_nonce'], 'vote_average_nonce')) {
      return;
   }
   if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return;
   }
   if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
      if (!current_user_can('edit_page', $post_id)) {
         return;
      }
   } else {
      if (!current_user_can('edit_post', $post_id)) {
         return;
      }
   }
   if (!isset($_POST['vote_average'])) {
      return;
   }
   $vote_average = sanitize_text_field($_POST['vote_average']);
   update_post_meta($post_id, '_vote_average', $vote_average);
}
add_action('save_post', 'fgh001_guardar_vote_average');

function fgh001_guardar_vote_count($post_id)
{
   if (!isset($_POST['vote_count_nonce'])) {
      return;
   }
   if (!wp_verify_nonce($_POST['vote_count_nonce'], 'vote_count_nonce')) {
      return;
   }
   if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return;
   }
   if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
      if (!current_user_can('edit_page', $post_id)) {
         return;
      }
   } else {
      if (!current_user_can('edit_post', $post_id)) {
         return;
      }
   }
   if (!isset($_POST['vote_count'])) {
      return;
   }
   $vote_count = sanitize_text_field($_POST['vote_count']);
   update_post_meta($post_id, '_vote_count', $vote_count);
}
add_action('save_post', 'fgh001_guardar_vote_count');
/******************************************************************************
 * 
 * 
 * Ordena movies para consultar por
 * Categorías y etiquetas.
 * 
 * 
 *****************************************************************************/
function fgh_001_orden_movies($query)
{
   if (!is_admin() && is_post_type_archive('movie') && $query->is_main_query()) {
      $query->set('meta_key', '_vote_average');
      $query->set('orderby', ['meta_value_num' => 'DESC', 'type' => 'number']);
      $query->set('posts_per_page', 12);
   }
   if (!is_admin() &&  is_tax('movie_genre') && $query->is_main_query()) {
      $query->set('meta_key', '_vote_average');
      $query->set('orderby', ['meta_value_num' => 'DESC', 'type' => 'number']);
      $query->set('posts_per_page', 12);
   }
}
add_action('pre_get_posts', 'fgh_001_orden_movies');
/******************************************************************************
 * 
 * 
 * Muestra los campos personalizados
 * en la REST API.
 * 
 * 
 *****************************************************************************/
if (!function_exists('fgh_001_movie_meta_request_params')) {
   function fgh_001_agregar_movie_meta_fields()
   {
      register_meta('post', '_adult', array(
         'type' => 'string',
         'description' => 'adult',
         'single' => true,
         'show_in_rest' => true
      ));
      register_meta('post', '_backdrop_path', array(
         'type' => 'string',
         'description' => 'backdrop_path',
         'single' => true,
         'show_in_rest' => true
      ));
      register_meta('post', '_original_language', array(
         'type' => 'string',
         'description' => 'original_language',
         'single' => true,
         'show_in_rest' => true
      ));
      register_meta('post', '_original_title', array(
         'type' => 'string',
         'description' => 'original_title',
         'single' => true,
         'show_in_rest' => true
      ));
      register_meta('post', '_popularity', array(
         'type' => 'string',
         'description' => 'popularity',
         'single' => true,
         'show_in_rest' => true
      ));
      register_meta('post', '_poster_path', array(
         'type' => 'string',
         'description' => 'poster_path',
         'single' => true,
         'show_in_rest' => true
      ));
      register_meta('post', '_video', array(
         'type' => 'string',
         'description' => 'video',
         'single' => true,
         'show_in_rest' => true
      ));
      register_meta('post', '_vote_average', array(
         'type' => 'string',
         'description' => 'vote_average',
         'single' => true,
         'show_in_rest' => true
      ));
      register_meta('post', '_vote_count', array(
         'type' => 'string',
         'description' => 'vote_count',
         'single' => true,
         'show_in_rest' => true
      ));
   }

   add_action('rest_api_init', 'fgh_001_agregar_movie_meta_fields');
}
if (!function_exists('fgh_001_movie_meta_request_params')) {
   function fgh_001_movie_meta_request_params($args, $request)
   {
      $args += array(
         'meta_key'   => $request['meta_key'],
         'meta_value' => $request['meta_value'],
         'meta_query' => $request['meta_query'],
      );
      return $args;
   }
   add_filter('rest_movie_query', 'fgh_001_movie_meta_request_params', 99, 2);
}
