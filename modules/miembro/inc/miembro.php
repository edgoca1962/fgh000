<?php

/******************************************************************************
 * 
 * 
 * Crea las etiquetas del post
 * 
 * 
 *****************************************************************************/
function fgh000_crea_etiquetas_miembro($singular = 'Post', $plural = 'Posts')
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
function fgh000_capacidades_miembro($singular = 'post', $plural = 'posts')
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
function fgh000_miembro_post_type()
{
   $type = 'miembro';
   $labels = fgh000_crea_etiquetas_miembro('Miembro', 'Miembros');
   $capabilities = fgh000_capacidades_miembro('miembro', 'miembros');

   $args = array(
      'capability_type' => ['miembro', 'miembros'],
      'map_meta_cap' => true,
      'labels' => $labels,
      'public' => true,
      'has_archive' => true,
      'rewrite' => ['slug' => 'miembros'],
      'show_in_rest' => true,
      'rest_base' => 'miembros',
      'menu_icon' => 'dashicons-book',
      'supports' => array('title', 'custom-fields'),
      // 'taxonomies'               => ['category', 'post_tag'],
   );

   register_post_type($type, $args);
}
add_action('init', 'fgh000_miembro_post_type');
/******************************************************************************
 * 
 * 
 * Agrega a miembros para consultar por
 * Categorías y etiquetas.
 * 
 * 
 *****************************************************************************/
/*
function miembro_taxonomia_filter($query)
{
if (!is_admin() && $query->is_main_query()) {
if ($query->is_category() || $query->is_tag()) {
$query->set('post_type', array('post', 'miembro'));
}
}
}
add_action('pre_get_posts', 'miembro_taxonomia_filter');
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
if (!get_role('miembros')) {
add_role('miembros', 'miembros');
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
   $capabilities = fgh000_capacidades_miembro('miembro', 'miembros');
   foreach ($capabilities as $capability) {
      if (!$admin->has_cap($capability)) {
         $admin->add_cap($capability);
      }
   }
});
/******************************************************************************
 * 
 * 
 * 
 * Creación de campos personalizados 
 * 
 * 
 * 
 *****************************************************************************/
function fgh000_crear_campos_miembro()
{

   add_meta_box(
      'usr_id',
      'ID Miembro',
      'fgh000_crear_usr_id_miembro_cbk',
      'miembro',
      'normal',
      'default'
   );
   function fgh000_crear_usr_id_miembro_cbk($post)
   {
      wp_nonce_field('usr_id_nonce', 'usr_id_nonce');
      $usr_id = get_post_meta($post->ID, '_usr_id', true);
      ?>
      <select name="usr_id" id="usr_id" class="form-select" aria-label="Selecionar miembro">
         <option <?= (get_post_meta($post->ID, '_usr_id', true) == '') ? 'value="0" selected' : 'value="0"' ?>>Sin asignar
         </option>
         <?php
         $usuarios = get_users('orderby=nicename');
         foreach ($usuarios as $usuario) {
            ?>
            <option <?= (get_post_meta($post->ID, '_usr_id', true) == $usuario->ID) ? 'value="' . esc_attr($usuario->ID) . '" Selected' : 'value="' . $usuario->ID . '"' ?>><?= $usuario->display_name ?></option>
            <?php
         }
         ?>
      </select>
      <?php
   }

   add_meta_box(
      'comite_id',
      'ID Comité',
      'puesto_crear_comite_id_miembro_cbk',
      'miembro',
      'normal',
      'default',
      'show_in_rest'
   );
   function puesto_crear_comite_id_miembro_cbk($post)
   {
      wp_nonce_field('comite_id_nonce', 'comite_id_nonce');
      $comite_id = get_post_meta($post->ID, '_comite_id', true);
      ?>
      <select name="comite_id" id="comite_id" class="form-select" aria-label="Selecionar miembro">
         <option <?= (get_post_meta($post->ID, '_comite_id', true) == '') ? 'value="0" selected' : 'value="0"' ?>>Sin asignar
         </option>
         <?php
         $comites = get_posts(['post_type' => 'comite', 'posts_per_page' => -1, 'post_status' => 'publish',]);
         foreach ($comites as $comite) {
            ?>
            <option <?php echo (get_post_meta($post->ID, '_comite_id', true) == $comite->ID) ? 'value="' . esc_attr($comite->ID) . '" Selected' : 'value="' . $comite->ID . '"' ?>><?php echo $comite->post_title ?></option>
            <?php
         }
         ?>
      </select>
      <?php
   }

   add_meta_box(
      'puesto_id',
      'ID Puesto',
      'fgh000_crear_puesto_id_cbk',
      'miembro',
      'normal',
      'default',
      'show_in_rest',
   );
   function fgh000_crear_puesto_id_cbk($post)
   {
      wp_nonce_field('puesto_id_nonce', 'puesto_id_nonce');
      $puesto_id = get_post_meta($post->ID, '_puesto_id', true);
      ?>
      <select name="puesto_id" id="puesto_id" class="form-select" aria-label="Selecionar miembro">
         <option <?= (get_post_meta($post->ID, '_puesto_id', true) == '') ? 'value="0" selected' : 'value="0"' ?>>Sin asignar
         </option>
         <?php
         $puestos = get_posts(['post_type' => 'puesto', 'posts_per_page' => -1, 'post_status' => 'publish',]);
         foreach ($puestos as $puesto) {
            ?>
            <option <?php echo (get_post_meta($post->ID, '_puesto_id', true) == $puesto->ID) ? 'value="' . esc_attr($puesto->ID) . '" Selected' : 'value="' . $puesto->ID . '"' ?>><?php echo $puesto->post_title ?></option>
            <?php
         }
         ?>
      </select>
      <?php
   }

   add_meta_box(
      'f_inicio',
      'Fecha Inicio',
      'puesto_crear_f_inicio_cbk',
      'miembro',
      'normal',
      'default',
      'show_in_rest'
   );
   function puesto_crear_f_inicio_cbk($post)
   {
      wp_nonce_field('f_inicio_nonce', 'f_inicio_nonce');
      $f_inicio = get_post_meta($post->ID, '_f_inicio', true);
      echo '<input type="date" style="width:20%" id="f_inicio" name="f_inicio" value="' . esc_attr($f_inicio) . '" ></input>';
   }
   add_meta_box(
      'f_final',
      'Fecha Final',
      'puesto_crear_f_final_cbk',
      'miembro',
      'normal',
      'default',
      'show_in_rest',
   );
   function puesto_crear_f_final_cbk($post)
   {
      wp_nonce_field('f_final_nonce', 'f_final_nonce');
      $f_final = get_post_meta($post->ID, '_f_final', true);
      echo '<input type="date" style="width:20%" id="f_final" name="f_final" value="' . esc_attr($f_final) . '" ></input>';
   }
}
add_action('add_meta_boxes', 'fgh000_crear_campos_miembro');
/******************************************************************************
 * 
 * 
 * Rutinas para editar y guardar la 
 * información de los campos personalizados
 * en el editor de WP.
 * 
 * 
 *****************************************************************************/
function fgh000_guardar_usr_id_miembro($post_id)
{
   if (!isset($_POST['usr_id_nonce'])) {
      return;
   }
   if (!wp_verify_nonce($_POST['usr_id_nonce'], 'usr_id_nonce')) {
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
   if (!isset($_POST['usr_id'])) {
      return;
   }
   $usr_id = sanitize_text_field($_POST['usr_id']);
   update_post_meta($post_id, '_usr_id', $usr_id);
}

add_action('save_post', 'fgh000_guardar_usr_id_miembro');

function fgh000_guardar_comite_id_miembro($post_id)
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
add_action('save_post', 'fgh000_guardar_comite_id_miembro');

function fgh000_guardar_puesto_id_miembro($post_id)
{
   if (!isset($_POST['puesto_id_nonce'])) {
      return;
   }
   if (!wp_verify_nonce($_POST['puesto_id_nonce'], 'puesto_id_nonce')) {
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
   if (!isset($_POST['puesto_id'])) {
      return;
   }
   $puesto_id = sanitize_text_field($_POST['puesto_id']);
   update_post_meta($post_id, '_puesto_id', $puesto_id);
}
add_action('save_post', 'fgh000_guardar_puesto_id_miembro');

function fgh000_guardar_miembro_f_inicio($post_id)
{
   if (!isset($_POST['f_inicio_nonce'])) {
      return;
   }
   if (!wp_verify_nonce($_POST['f_inicio_nonce'], 'f_inicio_nonce')) {
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
   if (!isset($_POST['f_inicio'])) {
      return;
   }
   $f_inicio = sanitize_text_field($_POST['f_inicio']);
   update_post_meta($post_id, '_f_inicio', $f_inicio);
}
add_action('save_post', 'fgh000_guardar_miembro_f_inicio');

function fgh000_guardar_miembro_f_final($post_id)
{
   if (!isset($_POST['f_final_nonce'])) {
      return;
   }
   if (!wp_verify_nonce($_POST['f_final_nonce'], 'f_final_nonce')) {
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
   if (!isset($_POST['f_final'])) {
      return;
   }
   $f_final = sanitize_text_field($_POST['f_final']);
   update_post_meta($post_id, '_f_final', $f_final);
}
add_action('save_post', 'fgh000_guardar_miembro_f_final');
/******************************************************************************
 * 
 * 
 * Muestra los campos personalizados
 * en la REST API.
 * 
 * 
 *****************************************************************************/

function fgh000_agregar_miembro_meta_fields()
{
   register_meta('post', '_usr_id', array(
      'type' => 'string',
      'description' => 'usr_id',
      'single' => true,
      'show_in_rest' => true
   )
   );
   register_meta('post', '_comite_id', array(
      'type' => 'string',
      'description' => 'comite_id',
      'single' => true,
      'show_in_rest' => true
   )
   );
}
add_action('rest_api_init', 'fgh000_agregar_miembro_meta_fields');

if (!function_exists('fgh000_miembro_meta_request_params')) {
   function fgh000_miembro_meta_request_params($args, $request)
   {
      $args += array(
         'meta_key' => $request['meta_key'],
         'meta_value' => $request['meta_value'],
         'meta_query' => $request['meta_query'],
      );
      return $args;
   }
   add_filter('rest_miembro_query', 'fgh000_miembro_meta_request_params', 99, 2);
}