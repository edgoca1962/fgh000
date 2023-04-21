<?php

/******************************************************************************
 * 
 * 
 * Crea las etiquetas del post
 * 
 * 
 *****************************************************************************/
function fgh000_crea_etiquetas_acuerdo($singular = 'Post', $plural = 'Posts')
{
   $p_lower = strtolower($plural);
   $s_lower = strtolower($singular);

   return [
      'name' => _x($plural, 'post type general name', 'fgh000'),
      'singular_name' => _x($singular, 'post type singular name', 'fgh000'),
      'menu_name' => _x($plural, 'admin menu', 'fgh000'),
      'name_admin_bar' => _x($singular, 'add new on admin bar', 'fgh000'),
      'add_new' => _x("Nuevo $singular", 'prayer', 'fgh000'),
      'add_new_item' => __("Agregar $singular", 'fgh000'),
      'new_item' => __("Nuevo $singular", 'fgh000'),
      'edit_item' => __("Editar $singular", 'fgh000'),
      'view_item' => __("Ver $singular", 'fgh000'),
      'view_items' => __("Ver $plural", 'fgh000'),
      'all_items' => __("Todos los $plural", 'fgh000'),
      'search_items' => __("Buscar $plural", 'fgh000'),
      'parent_item_colon' => __("Parent $singular", 'fgh000'),
      'not_found' => __("No $p_lower found", 'fgh000'),
      'not_found_in_trash' => __("No $p_lower found in trash", 'fgh000'),
      'archives' => __("$singular Archives", 'fgh000'),
      'attributes' => __("$singular Attributes", 'fgh000'),
      'insert_into_item' => __("Insertar $s_lower", 'fgh000'),
      'uploaded_to_this_item' => __("Adjuntar a un $s_lower", 'fgh000'),
   ];
}
/******************************************************************************
 * 
 * 
 * Aplica capacidades al post 
 * 
 * 
 *****************************************************************************/
function fgh000_capacidades_acuerdo($singular = 'post', $plural = 'posts')
{
   return [
      'edit_post' => "edit_$singular",
      'read_post' => "read_$singular",
      'delete_post' => "delete_$singular",
      'edit_posts' => "edit_$plural",
      'edit_others_posts' => "edit_others_$plural",
      'publish_posts' => "publish_$plural",
      'read_private_posts' => "read_private_$plural",
      'read' => "read",
      'delete_posts' => "delete_$plural",
      'delete_private_posts' => "delete_private_$plural",
      'delete_published_posts' => "delete_published_$plural",
      'delete_others_posts' => "delete_others_$plural",
      'edit_private_posts' => "edit_private_$plural",
      'edit_published_posts' => "edit_published_$plural",
      'create_posts' => "edit_$plural",
   ];
}
/******************************************************************************
 * 
 * 
 * Crea el post personalizado
 * 
 * 
 *****************************************************************************/
function fgh000_acuerdo_post_type()
{
   $type = 'acuerdo';
   $labels = fgh000_crea_etiquetas_acuerdo('Acuerdo', 'Acuerdos');
   $capabilities = fgh000_capacidades_acuerdo('acuerdo', 'acuerdos');

   $args = array(
      'capability_type' => ['acuerdo', 'acuerdos'],
      'map_meta_cap' => true,
      'labels' => $labels,
      'public' => true,
      'has_archive' => true,
      'rewrite' => ['slug' => 'acuerdos'],
      'show_in_rest' => true,
      'rest_base' => 'acuerdos',
      'menu_icon' => 'dashicons-book',
      'supports' => array('title', 'editor', 'custom-fields'),
      // 'taxonomies'               => ['category', 'post_tag'],
   );

   register_post_type($type, $args);
}
add_action('init', 'fgh000_acuerdo_post_type');
/******************************************************************************
 * 
 * 
 * Agrega a acuerdos para consultar por
 * Categorías y etiquetas.
 * 
 * 
 *****************************************************************************/
/*
function acuerdo_taxonomia_filter($query)
{
if (!is_admin() && $query->is_main_query()) {
if ($query->is_category() || $query->is_tag()) {
$query->set('post_type', array('post', 'acuerdo'));
}
}
}
add_action('pre_get_posts', 'acuerdo_taxonomia_filter');
*/

/******************************************************************************
 * 
 * 
 * 
 * Creación de campos personalizados 
 * 
 * 
 * 
 *****************************************************************************/
function fgh000_crear_campos_acuerdo()
{
   add_meta_box(
      'asignar_id',
      'ID Asignado',
      'fgh000_crear_asignar_id_cbk',
      'acuerdo',
      'normal',
      'default'
   );
   function fgh000_crear_asignar_id_cbk($post)
   {
      wp_nonce_field('asignar_id_nonce', 'asignar_id_nonce');
      $asignar_id = get_post_meta($post->ID, '_asignar_id', true);
      ?>
      <select name="asignar_id" id="asignar_id" class="form-select" aria-label="Selecionar miembro">
         <option <?= (get_post_meta($post->ID, '_asignar_id', true) == '') ? 'value="0" selected' : 'value="0"' ?>>Sin asignar
         </option>
         <?php
         $usuarios = get_users('orderby=nicename');
         foreach ($usuarios as $usuario) {
            ?>
            <option <?= (get_post_meta($post->ID, '_asignar_id', true) == $usuario->ID) ? 'value="' . esc_attr($usuario->ID) . '" Selected' : 'value="' . $usuario->ID . '"' ?>><?= $usuario->display_name ?></option>
            <?php
         }
         ?>
      </select>
      <?php
   }

   add_meta_box(
      'acta_id',
      'ID Acta',
      'fgh000_crear_acta_id_cbk',
      'acuerdo',
      'normal',
      'default'
   );
   function fgh000_crear_acta_id_cbk($post)
   {
      wp_nonce_field('acta_id_nonce', 'acta_id_nonce');
      $acta_id = get_post_meta($post->ID, '_acta_id', true);
      echo '<input type="text" style="width:20%" id="acta_id" name="acta_id" value="' . esc_attr($acta_id) . '" </input>';
   }

   add_meta_box(
      'comite_id',
      'ID Comité',
      'fgh000_crear_comite_id_cbk',
      'acuerdo',
      'normal',
      'default'
   );
   function fgh000_crear_comite_id_cbk($post)
   {
      wp_nonce_field('comite_id_nonce', 'comite_id_nonce');
      $comite_id = get_post_meta($post->ID, '_comite_id', true);
      echo '<input type="text" style="width:20%" id="comite_id" name="comite_id" value="' . esc_attr($comite_id) . '" </input>';
   }

   add_meta_box(
      'n_acuerdo',
      'Nùmero de Acuerdo',
      'fgh000_crear_n_acuerdo_cbk',
      'acuerdo',
      'normal',
      'default'
   );
   function fgh000_crear_n_acuerdo_cbk($post)
   {
      wp_nonce_field('n_acuerdo_nonce', 'n_acuerdo_nonce');
      $n_acuerdo = get_post_meta($post->ID, '_n_acuerdo', true);
      echo '<input type="text" style="width:20%" id="n_acuerdo" name="n_acuerdo" value="' . esc_attr($n_acuerdo) . '" </input>';
   }

   add_meta_box(
      'vigente',
      'Acuerdo Vigente',
      'fgh000_crear_acuerdo_vigente_cbk',
      'acuerdo',
      'normal',
      'default'
   );
   function fgh000_crear_acuerdo_vigente_cbk($post)
   {
      wp_nonce_field('vigente_nonce', 'vigente_nonce');
      $vigente = get_post_meta($post->ID, '_vigente', true);
      echo '<input type="text" style="width:5%" id="vigente" name="vigente" value="' . esc_attr($vigente) . '" > (on = Si | vacío = No)';
   }

   add_meta_box(
      'f_compromiso',
      'Fecha de Compromiso',
      'fgh000_crear_f_compromiso_cbk',
      'acuerdo',
      'normal',
      'default'
   );
   function fgh000_crear_f_compromiso_cbk($post)
   {
      wp_nonce_field('f_compromiso_nonce', 'f_compromiso_nonce');
      $f_compromiso = get_post_meta($post->ID, '_f_compromiso', true);
      echo '<input type="date" style="width:20%" id="f_compromiso" name="f_compromiso" value="' . esc_attr($f_compromiso) . '" >';
   }

   add_meta_box(
      'f_seguimiento',
      'Fecha Seguimiento',
      'fgh000_crear_acuerdo_f_seguimiento_cbk',
      'acuerdo',
      'normal',
      'default'
   );
   function fgh000_crear_acuerdo_f_seguimiento_cbk($post)
   {
      wp_nonce_field('f_seguimiento_nonce', 'f_seguimiento_nonce');
      $f_seguimiento = get_post_meta($post->ID, '_f_seguimiento', true);
      echo '<input type="date" style="width:20%" id="f_seguimiento" name="f_seguimiento" value="' . esc_attr($f_seguimiento) . '" >';
   }
}
add_action('add_meta_boxes', 'fgh000_crear_campos_acuerdo');
/******************************************************************************
 * 
 * 
 * Rutinas para editar y guardar la 
 * información de los campos personalizados
 * en el editor de WP.
 * 
 * 
 *****************************************************************************/
function fgh000_guardar_asignar_id($post_id)
{
   if (!isset($_POST['asignar_id_nonce'])) {
      return;
   }
   if (!wp_verify_nonce($_POST['asignar_id_nonce'], 'asignar_id_nonce')) {
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
   if (!isset($_POST['asignar_id'])) {
      return;
   }
   $asignar_id = sanitize_text_field($_POST['asignar_id']);
   update_post_meta($post_id, '_asignar_id', $asignar_id);
}
add_action('save_post', 'fgh000_guardar_asignar_id');

function fgh000_guardar_acta_id($post_id)
{
   if (!isset($_POST['acta_id_nonce'])) {
      return;
   }
   if (!wp_verify_nonce($_POST['acta_id_nonce'], 'acta_id_nonce')) {
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
   if (!isset($_POST['acta_id'])) {
      return;
   }
   $acta_id = sanitize_text_field($_POST['acta_id']);
   update_post_meta($post_id, '_acta_id', $acta_id);
}
add_action('save_post', 'fgh000_guardar_acta_id');

function fgh000_guardar_comite_id($post_id)
{
   if (!isset($_POST['comite_id_nonce'])) {
      return;
   }
   if (!wp_verify_nonce($_POST['comite_id_nonce'], 'comite_id_nonce')) {
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
   if (!isset($_POST['comite_id'])) {
      return;
   }
   $comite_id = sanitize_text_field($_POST['comite_id']);
   update_post_meta($post_id, '_comite_id', $comite_id);
}
add_action('save_post', 'fgh000_guardar_comite_id');

function fgh000_guardar_n_acuerdo($post_id)
{
   if (!isset($_POST['n_acuerdo_nonce'])) {
      return;
   }
   if (!wp_verify_nonce($_POST['n_acuerdo_nonce'], 'n_acuerdo_nonce')) {
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
   if (!isset($_POST['n_acuerdo'])) {
      return;
   }
   $n_acuerdo = sanitize_text_field($_POST['n_acuerdo']);
   update_post_meta($post_id, '_n_acuerdo', $n_acuerdo);
}
add_action('save_post', 'fgh000_guardar_n_acuerdo');

function fgh000_guardar_acuerdo_vigente($post_id)
{
   if (!isset($_POST['vigente_nonce'])) {
      return;
   }
   if (!wp_verify_nonce($_POST['vigente_nonce'], 'vigente_nonce')) {
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
   if (!isset($_POST['vigente'])) {
      return;
   }
   $vigente = sanitize_text_field($_POST['vigente']);
   update_post_meta($post_id, '_vigente', $vigente);
}
add_action('save_post', 'fgh000_guardar_acuerdo_vigente');

function fgh000_guardar_f_compromiso($post_id)
{
   if (!isset($_POST['f_compromiso_nonce'])) {
      return;
   }
   if (!wp_verify_nonce($_POST['f_compromiso_nonce'], 'f_compromiso_nonce')) {
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
   if (!isset($_POST['f_compromiso'])) {
      return;
   }
   $f_compromiso = sanitize_text_field($_POST['f_compromiso']);
   update_post_meta($post_id, '_f_compromiso', $f_compromiso);
}
add_action('save_post', 'fgh000_guardar_f_compromiso');

function fgh000_guardar_acuerdo_f_seguimiento($post_id)
{
   if (!isset($_POST['f_seguimiento_nonce'])) {
      return;
   }
   if (!wp_verify_nonce($_POST['f_seguimiento_nonce'], 'f_seguimiento_nonce')) {
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
   if (!isset($_POST['f_seguimiento'])) {
      return;
   }
   $f_seg = new DateTime(sanitize_text_field($_POST['f_seguimiento']), new DateTimeZone('America/Costa_Rica'));
   $f_seguimiento = $f_seg->format('Y-m-d');
   update_post_meta($post_id, '_f_seguimiento', $f_seguimiento);
}
add_action('save_post', 'fgh000_guardar_acuerdo_f_seguimiento');

/******************************************************************************
 * 
 * 
 * Muestra los campos personalizados
 * en la REST API.
 * 
 * 
 *****************************************************************************/

function fgh000_agregar_acuerdo_meta_fields()
{
   register_meta('post', '_asignar_id', array(
      'type' => 'string',
      'description' => 'asignado',
      'single' => true,
      'show_in_rest' => true
   )
   );

   register_meta('post', '_comite_id', array(
      'type' => 'string',
      'description' => 'comite',
      'single' => true,
      'show_in_rest' => true
   )
   );

   register_meta('post', '_acta_id', array(
      'type' => 'string',
      'description' => 'acta',
      'single' => true,
      'show_in_rest' => true
   )
   );
   register_meta('post', '_n_acuerdo', array(
      'type' => 'string',
      'description' => 'n_acuerdo',
      'single' => true,
      'show_in_rest' => true
   )
   );
   register_meta('post', '_f_compromiso', array(
      'type' => 'string',
      'description' => 'f_compromiso',
      'single' => true,
      'show_in_rest' => true
   )
   );
   register_meta('post', '_vigente', array(
      'type' => 'string',
      'description' => 'vigente',
      'single' => true,
      'show_in_rest' => true
   )
   );
   register_meta('post', '_f_seguimiento', array(
      'type' => 'string',
      'description' => 'f_seguimiento',
      'single' => true,
      'show_in_rest' => true
   )
   );
}
add_action('rest_api_init', 'fgh000_agregar_acuerdo_meta_fields');

if (!function_exists('fgh000_acuerdo_meta_request_params')) {
   function fgh000_acuerdo_meta_request_params($args, $request)
   {
      $args += array(
         'meta_key' => $request['meta_key'],
         'meta_value' => $request['meta_value'],
         'meta_query' => $request['meta_query'],
      );
      return $args;
   }
   add_filter('rest_acuerdo_query', 'fgh000_acuerdo_meta_request_params', 99, 2);
}
/******************************************************************************
 * 
 * 
 * Crea la página para el manejo la creación de acuerdos.
 * 
 * 
 *****************************************************************************/
/*
if (!get_page_by_title(' Acta')) {
$post_data = array(
'post_type' => 'page',
'post_title' => 'Crear Acta',
'post_name' => 'crear-acta',
'post_status' => 'publish',
);
wp_insert_post($post_data);
}
*/
/******************************************************************************
 * 
 * 
 * Crea roles para usuarios
 * 
 * 
 *****************************************************************************/
/*
add_action('init', function () {
if (!get_role('acuerdos')) {
add_role('acuerdos', 'acuerdos');
}
});
*/
/******************************************************************************
 * 
 * 
 * Otorga facultados a los roles para los custom posts type
 * 
 * 
 *****************************************************************************/
add_action('init', function () {
   $admin = get_role('administrator');
   $capabilities = fgh000_capacidades_acuerdo('acuerdo', 'acuerdos');
   foreach ($capabilities as $capability) {
      if (!$admin->has_cap($capability)) {
         $admin->add_cap($capability);
      }
   }
});