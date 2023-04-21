<?php

/******************************************************************************
 * 
 * 
 * Crea las etiquetas del post
 * 
 * 
 *****************************************************************************/
function fgh000_crea_etiquetas_peticion($singular = 'Post', $plural = 'Posts')
{
   $p_lower = strtolower($plural);
   $s_lower = strtolower($singular);

   return [
      'name' => _x($plural, 'post type general name', 'fgh000'),
      'singular_name' => _x($singular, 'post type singular name', 'fgh000'),
      'menu_name' => _x($plural, 'admin menu', 'fgh000'),
      'name_admin_bar' => _x($singular, 'add new on admin bar', 'fgh000'),
      'add_new' => _x("Nueva $singular", 'prayer', 'fgh000'),
      'add_new_item' => __("Agregar $singular", 'fgh000'),
      'new_item' => __("Nueva $singular", 'fgh000'),
      'edit_item' => __("Editar $singular", 'fgh000'),
      'view_item' => __("Ver $singular", 'fgh000'),
      'view_items' => __("Ver $plural", 'fgh000'),
      'all_items' => __("Todas las $plural", 'fgh000'),
      'search_items' => __("Buscar $plural", 'fgh000'),
      'parent_item_colon' => __("$singular madres", 'fgh000'),
      'not_found' => __("$plural no encontradas", 'fgh000'),
      'not_found_in_trash' => __("$plural no encotradas en basurero", 'fgh000'),
      'archives' => __("Archivo $singular", 'fgh000'),
      'attributes' => __("Atributos de $singular", 'fgh000'),
      'insert_into_item' => __("Insertar $s_lower", 'fgh000'),
      'uploaded_to_this_item' => __("Adjuntar a una $s_lower", 'fgh000'),
   ];
}
/******************************************************************************
 * 
 * 
 * Aplica capacidades al post
 * 
 * 
 *****************************************************************************/
function fgh000_capacidades_peticion($singular = 'post', $plural = 'posts')
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
function fgh000_peticion_post_type()
{
   $type = 'peticion';
   $labels = fgh000_crea_etiquetas_peticion('Peticion', 'Peticiones');
   $capabilities = fgh000_capacidades_peticion('peticion', 'peticiones');

   $args = array(
      'capability_type' => ['peticion', 'peticiones'],
      'map_meta_cap' => true,
      'labels' => $labels,
      'public' => true,
      'has_archive' => true,
      'rewrite' => ['slug' => 'peticiones'],
      'show_in_rest' => true,
      'rest_base' => 'peticiones',
      'menu_icon' => 'dashicons-book',
      'supports' => array('title', 'comments', 'custom-fields'),
      'taxonomies' => ['category', 'post_tag'],
   );

   register_post_type($type, $args);
}
add_action('init', 'fgh000_peticion_post_type');


function staging_crear_campos()
{
   add_meta_box(
      'nombre',
      // Unique ID     
      'Nombre',
      // Title
      'staging_crear_nombre_cbk',
      // Callback function
      'peticion',
      // Admin page (or post type)
      'normal',
      // Context
      'default',
      // Priority
      'show_in_rest'
   );
   function staging_crear_nombre_cbk($post)
   {
      wp_nonce_field('nombre_nonce', 'nombre_nonce');
      $nombre = get_post_meta($post->ID, '_nombre', true);
      echo '<input type="text" style="width:20%" id="nombre" name="nombre" value="' . esc_attr($nombre) . '" ></input>';
   }

   add_meta_box(
      'apellido',
      'Apellido',
      'staging_crear_apellido_cbk',
      'peticion',
      'normal',
      'default'
   );
   function staging_crear_apellido_cbk($post)
   {
      wp_nonce_field('apellido_nonce', 'apellido_nonce');
      $apellido = get_post_meta($post->ID, '_apellido', true);
      echo '<input type="text" style="width:20%" id="apellido" name="apellido" value="' . esc_attr($apellido) . '" </input>';
   }

   add_meta_box(
      'email',
      'Correo Electrónico',
      'staging_crear_email_cbk',
      'peticion',
      'normal',
      'default'
   );
   function staging_crear_email_cbk($post)
   {
      wp_nonce_field('email_nonce', 'email_nonce');
      $email = get_post_meta($post->ID, '_email', true);
      echo '<input type="email" style="width:20%" id="email" name="email" value="' . esc_attr($email) . '" >';
   }

   add_meta_box(
      'telefono',
      'Teléfono',
      'staging_crear_telefono_cbk',
      'peticion',
      'normal',
      'default'
   );
   function staging_crear_telefono_cbk($post)
   {
      wp_nonce_field('telefono_nonce', 'telefono_nonce');
      $telefono = get_post_meta($post->ID, '_telefono', true);
      echo '<input type="text" style="width:20%" id="telefono" name="telefono" value="' . esc_attr($telefono) . '" >';
   }

   add_meta_box(
      'vigente',
      'Vigente',
      'staging_crear_vigente_cbk',
      'peticion',
      'normal',
      'default'
   );
   function staging_crear_vigente_cbk($post)
   {
      wp_nonce_field('vigente_nonce', 'vigente_nonce');
      $vigente = get_post_meta($post->ID, '_vigente', true);
      echo '<input type="number" style="width:5%" id="vigente" name="vigente" value="' . esc_attr($vigente) . '" > (1 = Si | 0 = No)';
   }

   add_meta_box(
      'marca_seguimiento',
      'Seguimiento',
      'staging_crear_marca_seguimiento_cbk',
      'peticion',
      'normal',
      'default'
   );
   function staging_crear_marca_seguimiento_cbk($post)
   {
      wp_nonce_field('marca_seguimiento_nonce', 'marca_seguimiento_nonce');
      $marca_seguimiento = get_post_meta($post->ID, '_marca_seguimiento', true);
      echo '<input type="number" style="width:5%" id="marca_seguimiento" name="marca_seguimiento" value="' . esc_attr($marca_seguimiento) . '" > (1 = Si | 0 = No)';
   }

   add_meta_box(
      'nperiodos',
      'Cantidad Períodos',
      'staging_crear_nperiodos_cbk',
      'peticion',
      'normal',
      'default'
   );
   function staging_crear_nperiodos_cbk($post)
   {
      wp_nonce_field('nperiodos_nonce', 'nperiodos_nonce');
      $nperiodos = get_post_meta($post->ID, '_nperiodos', true);
      echo '<input type="number" style="width:5%" id="nperiodos" name="nperiodos" value="' . esc_attr($nperiodos) . '" >';
   }

   add_meta_box(
      'periodicidad',
      'Periodicidad',
      'staging_crear_periodicidad_cbk',
      'peticion',
      'normal',
      'default'
   );
   function staging_crear_periodicidad_cbk($post)
   {
      wp_nonce_field('periodicidad_nonce', 'periodicidad_nonce');
      $periodicidad = get_post_meta($post->ID, '_periodicidad', true);
      echo '<input type="number" style="width:5%" id="periodicidad" name="periodicidad" value="' . esc_attr($periodicidad) . '" >';
   }

   add_meta_box(
      'f_seguimiento',
      'Fecha Seguimiento',
      'staging_crear_f_seguimiento_cbk',
      'peticion',
      'normal',
      'default'
   );
   function staging_crear_f_seguimiento_cbk($post)
   {
      wp_nonce_field('f_seguimiento_nonce', 'f_seguimiento_nonce');
      $f_seg = new DateTime(get_post_meta($post->ID, '_f_seguimiento', true), new DateTimeZone('America/Costa_Rica'));
      $f_seguimiento = $f_seg->format('Y-m-d');
      echo '<input type="date" style="width:20%" id="f_seguimiento" name="f_seguimiento" value="' . esc_attr($f_seguimiento) . '" >';
   }

   add_meta_box(
      'f_nacimiento',
      'Fecha Nacimiento',
      'staging_crear_f_nacimiento_cbk',
      'peticion',
      'normal',
      'default'
   );
   function staging_crear_f_nacimiento_cbk($post)
   {
      wp_nonce_field('f_nacimiento_nonce', 'f_nacimiento_nonce');
      $f_nacimiento = date('Y-m-d', strtotime(get_post_meta($post->ID, '_f_nacimiento', true)));
      echo '<input type="date" style="width:20%" id="f_nacimiento" name="f_nacimiento" value="' . esc_attr($f_nacimiento) . '" >';
   }

   add_meta_box(
      'asignar_a',
      'Asignar Petición',
      'staging_crear_asignar_a_cbk',
      'peticion',
      'normal',
      'default'
   );
   function staging_crear_asignar_a_cbk($post)
   {
      wp_nonce_field('asignar_a_nonce', 'asignar_a_nonce');
      $asignar_a = get_post_meta($post->ID, '_asignar_a', true);
      ?>
      <select name="asignar_a" id="asignar_a" class="form-select" aria-label="Selecionar miembro">
         <option <?= (get_post_meta($post->ID, '_asignar_a', true) == '') ? 'value="0" selected' : 'value="0"' ?>>Sin asignar
         </option>
         <?php
         $usuarios = get_users('orderby=nicename');
         foreach ($usuarios as $usuario) {
            ?>
            <option <?= (get_post_meta($post->ID, '_asignar_a', true) == $usuario->ID) ? 'value="' . esc_attr($usuario->ID) . '" Selected' : 'value="' . $usuario->ID . '"' ?>><?= $usuario->display_name ?></option>
            <?php
         }
         ?>
      </select>

      <?php
      echo '<input type="number" style="width:20%" id="" name="" value="' . esc_attr($asignar_a) . '" disabled>';
   }
}
add_action('add_meta_boxes', 'staging_crear_campos');

/**
 * Rutinas para editar y guardar la 
 * información de los campos personalizados
 * en el editor de WP.
 */

function staging_guardar_nombre($post_id)
{
   if (!isset($_POST['nombre_nonce'])) {
      return;
   }
   if (!wp_verify_nonce($_POST['nombre_nonce'], 'nombre_nonce')) {
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
   if (!isset($_POST['nombre'])) {
      return;
   }
   $nombre = sanitize_text_field($_POST['nombre']);
   update_post_meta($post_id, '_nombre', $nombre);
}
add_action('save_post', 'staging_guardar_nombre');

function staging_guardar_apellido($post_id)
{
   if (!isset($_POST['apellido_nonce'])) {
      return;
   }
   if (!wp_verify_nonce($_POST['apellido_nonce'], 'apellido_nonce')) {
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
   if (!isset($_POST['apellido'])) {
      return;
   }
   $apellido = sanitize_text_field($_POST['apellido']);
   update_post_meta($post_id, '_apellido', $apellido);
}
add_action('save_post', 'staging_guardar_apellido');


function staging_guardar_email($post_id)
{
   if (!isset($_POST['email_nonce'])) {
      return;
   }
   if (!wp_verify_nonce($_POST['email_nonce'], 'email_nonce')) {
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
   if (!isset($_POST['email'])) {
      return;
   }
   $email = sanitize_text_field($_POST['email']);
   update_post_meta($post_id, '_email', $email);
}
add_action('save_post', 'staging_guardar_email');


function staging_guardar_telefono($post_id)
{
   if (!isset($_POST['telefono_nonce'])) {
      return;
   }
   if (!wp_verify_nonce($_POST['telefono_nonce'], 'telefono_nonce')) {
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
   if (!isset($_POST['telefono'])) {
      return;
   }
   $telefono = sanitize_text_field($_POST['telefono']);
   update_post_meta($post_id, '_telefono', $telefono);
}
add_action('save_post', 'staging_guardar_telefono');


function staging_guardar_vigente($post_id)
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
add_action('save_post', 'staging_guardar_vigente');


function staging_guardar_marca_seguimiento($post_id)
{
   if (!isset($_POST['marca_seguimiento_nonce'])) {
      return;
   }
   if (!wp_verify_nonce($_POST['marca_seguimiento_nonce'], 'marca_seguimiento_nonce')) {
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
   if (!isset($_POST['marca_seguimiento'])) {
      return;
   }
   $marca_seguimiento = sanitize_text_field($_POST['marca_seguimiento']);
   update_post_meta($post_id, '_marca_seguimiento', $marca_seguimiento);
}
add_action('save_post', 'staging_guardar_marca_seguimiento');


function staging_guardar_nperiodos($post_id)
{
   if (!isset($_POST['nperiodos_nonce'])) {
      return;
   }
   if (!wp_verify_nonce($_POST['nperiodos_nonce'], 'nperiodos_nonce')) {
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
   if (!isset($_POST['nperiodos'])) {
      return;
   }
   $nperiodos = sanitize_text_field($_POST['nperiodos']);
   update_post_meta($post_id, '_nperiodos', $nperiodos);
}
add_action('save_post', 'staging_guardar_nperiodos');


function staging_guardar_periodicidad($post_id)
{
   if (!isset($_POST['periodicidad_nonce'])) {
      return;
   }
   if (!wp_verify_nonce($_POST['periodicidad_nonce'], 'periodicidad_nonce')) {
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
   if (!isset($_POST['periodicidad'])) {
      return;
   }
   $periodicidad = sanitize_text_field($_POST['periodicidad']);
   update_post_meta($post_id, '_periodicidad', $periodicidad);
}
add_action('save_post', 'staging_guardar_periodicidad');


function staging_guardar_f_seguimiento($post_id)
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
add_action('save_post', 'staging_guardar_f_seguimiento');


function staging_guardar_f_nacimiento($post_id)
{
   if (!isset($_POST['f_nacimiento_nonce'])) {
      return;
   }
   if (!wp_verify_nonce($_POST['f_nacimiento_nonce'], 'f_nacimiento_nonce')) {
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
   if (!isset($_POST['f_nacimiento'])) {
      return;
   }
   $f_nacimiento = sanitize_text_field($_POST['f_nacimiento']);
   update_post_meta($post_id, '_f_nacimiento', $f_nacimiento);
}
add_action('save_post', 'staging_guardar_f_nacimiento');


function staging_guardar_asignar_a($post_id)
{
   if (!isset($_POST['asignar_a_nonce'])) {
      return;
   }
   if (!wp_verify_nonce($_POST['asignar_a_nonce'], 'asignar_a_nonce')) {
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
   if (!isset($_POST['asignar_a'])) {
      return;
   }
   $asignar_a = sanitize_text_field($_POST['asignar_a']);
   update_post_meta($post_id, '_asignar_a', $asignar_a);
}
add_action('save_post', 'staging_guardar_asignar_a');

add_action('init', function () {
   $admin = get_role('administrator');
   $capabilities = fgh000_capacidades_peticion('peticion', 'peticiones');
   foreach ($capabilities as $capability) {
      if (!$admin->has_cap($capability)) {
         $admin->add_cap($capability);
      }
   }
});


/**
 * Muestra los campos personalizados
 * en la REST API.
 */
/*
$object_type = 'post';
$meta_args = array(
'type'         => 'string',
'description'  => 'Nombre del peticionario.',
'single'       => true,
'show_in_rest' => true,
);
register_meta($object_type, '_nombre', $meta_args);
*/