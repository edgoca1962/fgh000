<?php

namespace FGHEGC\Modules\Scp\Peticion;

use FGHEGC\Modules\Core\Singleton;

class PeticionModel
{
   use Singleton;

   public function __construct()
   {
      add_action('add_meta_boxes', [$this, 'set_campos']);
      add_action('save_post', [$this, 'fghegc_guardar_nombre']);
      add_action('save_post', [$this, 'fghegc_guardar_apellido']);
      add_action('save_post', [$this, 'fghegc_guardar_email']);
      add_action('save_post', [$this, 'fghegc_guardar_telefono']);
      add_action('save_post', [$this, 'fghegc_guardar_vigente']);
      add_action('save_post', [$this, 'fghegc_guardar_marca_seguimiento']);
      add_action('save_post', [$this, 'fghegc_guardar_nperiodos']);
      add_action('save_post', [$this, 'fghegc_guardar_periodicidad']);
      add_action('save_post', [$this, 'fghegc_guardar_f_seguimiento']);
      add_action('save_post', [$this, 'fghegc_guardar_f_nacimiento']);
      add_action('save_post', [$this, 'fghegc_guardar_asignar_a']);
      $this->set_paginas();
      add_action('init', [$this, 'set_peticion']);
      add_action('pre_get_posts', [$this, 'scp_pre_get_posts']);
      // add_action('rest_api_init', [$this, 'show_acuerdo_meta_fields']);
   }
   public function set_peticion()
   {
      $type = 'peticion';
      $labels = $this->get_etiquetas('Petición', 'Peticiones');

      $args = array(
         'capability_type'          => ['peticion', 'peticiones'],
         'map_meta_cap'             => true,
         'labels'                   => $labels,
         'public'                   => true,
         'has_archive'              => true,
         'rewrite'                  => ['slug' => 'peticiones'],
         'show_in_rest'             => true,
         'rest_base'                => 'peticiones',
         'menu_icon'                => 'dashicons-heart',
         'supports'                 => array('title', 'editor', 'comments'),
         'taxonomies'               => ['category', 'post_tag'],
      );

      register_post_type($type, $args);
      $admin = get_role('administrator');
      $capabilities = $this->get_capacidades('peticion', 'peticiones');
      foreach ($capabilities as $capability) {
         if (!$admin->has_cap($capability)) {
            $admin->add_cap($capability);
         }
      }
   }
   private function get_etiquetas($singular, $plural)
   {
      $p_lower = strtolower($plural);
      $s_lower = strtolower($singular);

      $etiquetas = [
         'name' => _x($plural, 'post type general name', 'fghmvc'),
         'singular_name' => _x($singular, 'post type singular name', 'fghmvc'),
         'menu_name' => _x($plural, 'admin menu', 'fghmvc'),
         'name_admin_bar' => _x($singular, 'add new on admin bar', 'fghmvc'),
         'add_new' => _x("Nuevo $singular", 'prayer', 'fghmvc'),
         'add_new_item' => __("Agregar $singular", 'fghmvc'),
         'new_item' => __("Nuevo $singular", 'fghmvc'),
         'edit_item' => __("Editar $singular", 'fghmvc'),
         'view_item' => __("Ver $singular", 'fghmvc'),
         'view_items' => __("Ver $plural", 'fghmvc'),
         'all_items' => __("Todos los $plural", 'fghmvc'),
         'search_items' => __("Buscar $plural", 'fghmvc'),
         'parent_item_colon' => __("$singular padre", 'fghmvc'),
         'not_found' => __("No hay $p_lower", 'fghmvc'),
         'not_found_in_trash' => __("No hay $p_lower borrados", 'fghmvc'),
         'archives' => __("$singular achivado", 'fghmvc'),
         'attributes' => __("Atributos del $singular", 'fghmvc'),
         'insert_into_item' => __("Insertar $s_lower", 'fghmvc'),
         'uploaded_to_this_item' => __("Adjuntar a un $s_lower", 'fghmvc'),
      ];
      return $etiquetas;
   }
   private function get_capacidades($singular, $plural)
   {
      $capacidades = [
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
      return $capacidades;
   }
   public function set_campos()
   {
      add_meta_box(
         'nombre',                     // Unique ID     
         'Nombre',                     // Title
         [$this, 'fghegc_crear_nombre_cbk'],   // Callback function
         'peticion',                   // Admin page (or post type)
         'normal',                     // Context
         'default',                     // Priority
         'show_in_rest'
      );
      add_meta_box(
         'apellido',
         'Apellido',
         [$this, 'fghegc_crear_apellido_cbk'],
         'peticion',
         'normal',
         'default'
      );
      add_meta_box(
         'email',
         'Correo Electrónico',
         [$this, 'fghegc_crear_email_cbk'],
         'peticion',
         'normal',
         'default'
      );
      add_meta_box(
         'telefono',
         'Teléfono',
         [$this, 'fghegc_crear_telefono_cbk'],
         'peticion',
         'normal',
         'default'
      );
      add_meta_box(
         'vigente',
         'Vigente',
         [$this, 'fghegc_crear_vigente_cbk'],
         'peticion',
         'normal',
         'default'
      );
      add_meta_box(
         'marca_seguimiento',
         'Seguimiento',
         [$this, 'fghegc_crear_marca_seguimiento_cbk'],
         'peticion',
         'normal',
         'default'
      );
      add_meta_box(
         'nperiodos',
         'Cantidad Períodos',
         [$this, 'fghegc_crear_nperiodos_cbk'],
         'peticion',
         'normal',
         'default'
      );
      add_meta_box(
         'periodicidad',
         'Periodicidad',
         [$this, 'fghegc_crear_periodicidad_cbk'],
         'peticion',
         'normal',
         'default'
      );
      add_meta_box(
         'f_seguimiento',
         'Fecha Seguimiento',
         [$this, 'fghegc_crear_f_seguimiento_cbk'],
         'peticion',
         'normal',
         'default'
      );
      add_meta_box(
         'f_nacimiento',
         'Fecha Nacimiento',
         [$this, 'fghegc_crear_f_nacimiento_cbk'],
         'peticion',
         'normal',
         'default'
      );
      add_meta_box(
         'asignar_a',
         'Asignar Petición',
         [$this, 'fghegc_crear_asignar_a_cbk'],
         'peticion',
         'normal',
         'default'
      );
   }
   public function fghegc_crear_nombre_cbk($post)
   {
      wp_nonce_field('nombre_nonce', 'nombre_nonce');
      $nombre = get_post_meta($post->ID, '_nombre', true);
      echo '<input type="text" style="width:20%" id="nombre" name="nombre" value="' . esc_attr($nombre) . '" ></input>';
   }
   public function fghegc_crear_apellido_cbk($post)
   {
      wp_nonce_field('apellido_nonce', 'apellido_nonce');
      $apellido = get_post_meta($post->ID, '_apellido', true);
      echo '<input type="text" style="width:20%" id="apellido" name="apellido" value="' . esc_attr($apellido) . '" </input>';
   }
   public function fghegc_crear_email_cbk($post)
   {
      wp_nonce_field('email_nonce', 'email_nonce');
      $email = get_post_meta($post->ID, '_email', true);
      echo '<input type="email" style="width:20%" id="email" name="email" value="' . esc_attr($email) . '" >';
   }
   public function fghegc_crear_telefono_cbk($post)
   {
      wp_nonce_field('telefono_nonce', 'telefono_nonce');
      $telefono = get_post_meta($post->ID, '_telefono', true);
      echo '<input type="text" style="width:20%" id="telefono" name="telefono" value="' . esc_attr($telefono) . '" >';
   }
   public function fghegc_crear_vigente_cbk($post)
   {
      wp_nonce_field('vigente_nonce', 'vigente_nonce');
      $vigente = get_post_meta($post->ID, '_vigente', true);
      echo '<input type="number" style="width:5%" id="vigente" name="vigente" value="' . esc_attr($vigente) . '" > (1 = Si | 0 = No)';
   }
   public function fghegc_crear_marca_seguimiento_cbk($post)
   {
      wp_nonce_field('marca_seguimiento_nonce', 'marca_seguimiento_nonce');
      $marca_seguimiento = get_post_meta($post->ID, '_marca_seguimiento', true);
      echo '<input type="number" style="width:5%" id="marca_seguimiento" name="marca_seguimiento" value="' . esc_attr($marca_seguimiento) . '" > (1 = Si | 0 = No)';
   }
   public function fghegc_crear_nperiodos_cbk($post)
   {
      wp_nonce_field('nperiodos_nonce', 'nperiodos_nonce');
      $nperiodos = get_post_meta($post->ID, '_nperiodos', true);
      echo '<input type="number" style="width:5%" id="nperiodos" name="nperiodos" value="' . esc_attr($nperiodos) . '" >';
   }
   public function fghegc_crear_periodicidad_cbk($post)
   {
      wp_nonce_field('periodicidad_nonce', 'periodicidad_nonce');
      $periodicidad = get_post_meta($post->ID, '_periodicidad', true);
      echo '<input type="number" style="width:5%" id="periodicidad" name="periodicidad" value="' . esc_attr($periodicidad) . '" >';
   }
   public function fghegc_crear_f_seguimiento_cbk($post)
   {
      wp_nonce_field('f_seguimiento_nonce', 'f_seguimiento_nonce');
      $f_seguimiento = date('Y-m-d');
      echo '<input type="date" style="width:20%" id="f_seguimiento" name="f_seguimiento" value="' . esc_attr($f_seguimiento) . '" >';
   }
   public function fghegc_crear_f_nacimiento_cbk($post)
   {
      wp_nonce_field('f_nacimiento_nonce', 'f_nacimiento_nonce');
      $f_nacimiento = date('Y-m-d');
      echo '<input type="date" style="width:20%" id="f_nacimiento" name="f_nacimiento" value="' . esc_attr($f_nacimiento) . '" >';
   }
   public function fghegc_crear_asignar_a_cbk($post)
   {
      wp_nonce_field('asignar_a_nonce', 'asignar_a_nonce');
      $asignar_a = get_post_meta($post->ID, '_asignar_a', true);
?>
      <select name="asignar_a" id="asignar_a" class="form-select" aria-label="Selecionar miembro">
         <option <?= (get_post_meta($post->ID, '_asignar_a', true) == '') ? 'value="0" selected' : 'value="0"' ?>>Sin asignar</option>
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
   public function fghegc_guardar_nombre($post_id)
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
   public function fghegc_guardar_apellido($post_id)
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
   public function fghegc_guardar_email($post_id)
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
   public function fghegc_guardar_telefono($post_id)
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
   public function fghegc_guardar_vigente($post_id)
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
   public function fghegc_guardar_marca_seguimiento($post_id)
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
   public function fghegc_guardar_nperiodos($post_id)
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
   public function fghegc_guardar_periodicidad($post_id)
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
   public function fghegc_guardar_f_seguimiento($post_id)
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
      $f_seguimiento = date('Y-m-d');
      update_post_meta($post_id, '_f_seguimiento', $f_seguimiento);
   }
   public function fghegc_guardar_f_nacimiento($post_id)
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
   public function fghegc_guardar_asignar_a($post_id)
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
   public function show_acuerdo_meta_fields()
   {
      register_meta(
         'post',
         '_nombre',
         array(
            'type' => 'string',
            'description' => 'nombre',
            'single' => true,
            'show_in_rest' => true
         )
      );
      register_meta(
         'post',
         '_apellido',
         array(
            'type' => 'string',
            'description' => 'apellido',
            'single' => true,
            'show_in_rest' => true
         )
      );
      register_meta(
         'post',
         '_email',
         array(
            'type' => 'string',
            'description' => 'email',
            'single' => true,
            'show_in_rest' => true
         )
      );
      register_meta(
         'post',
         '_telefono',
         array(
            'type' => 'string',
            'description' => 'telefono',
            'single' => true,
            'show_in_rest' => true
         )
      );
      register_meta(
         'post',
         '_vigente',
         array(
            'type' => 'string',
            'description' => 'vigente',
            'single' => true,
            'show_in_rest' => true
         )
      );
      register_meta(
         'post',
         '_marca_seguimiento',
         array(
            'type' => 'string',
            'description' => 'marca_seguimiento',
            'single' => true,
            'show_in_rest' => true
         )
      );
      register_meta(
         'post',
         '_nperiodos',
         array(
            'type' => 'string',
            'description' => 'nperiodos',
            'single' => true,
            'show_in_rest' => true
         )
      );
      register_meta(
         'post',
         '_periodicidad',
         array(
            'type' => 'string',
            'description' => 'periodicidad',
            'single' => true,
            'show_in_rest' => true
         )
      );
      register_meta(
         'post',
         '_f_seguimiento',
         array(
            'type' => 'string',
            'description' => 'f_seguimiento',
            'single' => true,
            'show_in_rest' => true
         )
      );
      register_meta(
         'post',
         '_f_nacimiento',
         array(
            'type' => 'string',
            'description' => 'f_nacimiento',
            'single' => true,
            'show_in_rest' => true
         )
      );
      register_meta(
         'post',
         '_asignar_a',
         array(
            'type' => 'string',
            'description' => 'asignar_a',
            'single' => true,
            'show_in_rest' => true
         )
      );
   }
   public function scp_pre_get_posts($query)
   {
      if ($query->is_main_query() && !is_admin()) {
         if ($query->is_tag() || $query->is_category()) {
            $query->set('post_type', ['post', 'peticion']);
         }
      }
   }
   private function set_paginas()
   {
      $paginas = [
         'principal' =>
         [
            'slug' => 'peticion-principal',
            'titulo' => 'Ministerio de Oración'
         ],
      ];
      foreach ($paginas as $pagina) {

         $pags = get_posts([
            'post_type' => 'page',
            'post_status' => 'publish',
            'name' => $pagina['slug'],
         ]);
         if (count($pags) > 0) {
         } else {
            $post_data = array(
               'post_type' => 'page',
               'post_title' => $pagina['titulo'],
               'post_name' => $pagina['slug'],
               'post_status' => 'publish',
            );
            wp_insert_post($post_data);
         }
      }
   }
}
