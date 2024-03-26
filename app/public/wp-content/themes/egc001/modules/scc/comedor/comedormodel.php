<?php

namespace EGC001\Modules\Scc\Comedor;

use EGC001\Modules\Core\Singleton;
//Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis, accusamus ea voluptas architecto consequuntur doloremque.
class ComedorModel
{
   use Singleton;
   public function __construct()
   {
      add_action('init', [$this, 'set_comedor']);
      add_action('add_meta_boxes', [$this, 'set_campos']);
      add_action('save_post', [$this, 'save_provincia_id']);
      add_action('save_post', [$this, 'save_canton_id']);
      add_action('save_post', [$this, 'save_distrito_id']);
      add_action('save_post', [$this, 'save_direccion']);
      add_action('save_post', [$this, 'save_email']);
      add_action('save_post', [$this, 'save_telefono']);
      add_action('save_post', [$this, 'save_contacto_id']);
      add_action('pre_get_posts', [$this, 'scc_comedor_set_pre_get_posts']);
      add_action('wp_ajax_comedores', [$this, 'scc_get_comedores']);
      add_action('wp_ajax_scc_comedor_encargados', [$this, 'scc_comedor_get_encargados']);
      add_action('wp_ajax_comedor_agregar', [$this, 'comedor_agregar']);
      add_action('wp_ajax_comedor_editar', [$this, 'comedor_editar']);
   }
   public function set_comedor()
   {
      $type = 'comedor';
      $labels = $this->get_etiquetas('Comedor', 'Comedores');

      $args = array(
         'capability_type' => ['comedor', 'comedores'],
         'map_meta_cap' => true,
         'labels' => $labels,
         'public' => true,
         'has_archive' => true,
         'rewrite' => ['slug' => 'comedores'],
         'show_in_rest' => true,
         'rest_base' => 'comedores',
         'menu_icon' => 'dashicons-book',
         'supports' => array('title', 'editor', 'thumbnail', 'custom-fields', 'comments'),
      );

      register_post_type($type, $args);

      $admin = get_role('administrator');
      $capabilities = $this->get_capacidades('comedor', 'comedores');
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
         'name' => _x($plural, 'post type general name', 'EGC001'),
         'singular_name' => _x($singular, 'post type singular name', 'EGC001'),
         'menu_name' => _x($plural, 'admin menu', 'EGC001'),
         'name_admin_bar' => _x($singular, 'add new on admin bar', 'EGC001'),
         'add_new' => _x("Nuevo $singular", 'prayer', 'EGC001'),
         'add_new_item' => __("Agregar $singular", 'EGC001'),
         'new_item' => __("Nuevo $singular", 'EGC001'),
         'edit_item' => __("Editar $singular", 'EGC001'),
         'view_item' => __("Ver $singular", 'EGC001'),
         'view_items' => __("Ver $plural", 'EGC001'),
         'all_items' => __("Todos los $plural", 'EGC001'),
         'search_items' => __("Buscar $plural", 'EGC001'),
         'parent_item_colon' => __("$singular padre", 'EGC001'),
         'not_found' => __("No hay $p_lower", 'EGC001'),
         'not_found_in_trash' => __("No hay $p_lower borrados", 'EGC001'),
         'archives' => __("$singular Archivado", 'EGC001'),
         'attributes' => __("Atributos del $singular", 'EGC001'),
         'insert_into_item' => __("Insertar $s_lower", 'EGC001'),
         'uploaded_to_this_item' => __("Adjuntar a un $s_lower", 'EGC001'),
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
      // Nombre es post_title

      add_meta_box(
         '_provincia_id',
         'Provincia ID',
         [$this, 'set_provincia_id_cbk'],
         'comedor',
         'normal',
         'default'
      );
      add_meta_box(
         '_canton_id',
         'Cantón ID',
         [$this, 'set_canton_id_cbk'],
         'comedor',
         'normal',
         'default'
      );
      add_meta_box(
         '_distrito_id',
         'Distrito ID',
         [$this, 'set_distrito_id_cbk'],
         'comedor',
         'normal',
         'default'
      );
      add_meta_box(
         '_direccion',
         'Dirección',
         [$this, 'set_direccion_cbk'],
         'comedor',
         'normal',
         'default'
      );
      add_meta_box(
         '_email',
         'e-mail',
         [$this, 'set_email_cbk'],
         'comedor',
         'normal',
         'default'
      );
      add_meta_box(
         '_telefono',
         'Teléfono Contacto',
         [$this, 'set_telefono_cbk'],
         'comedor',
         'normal',
         'default'
      );
      add_meta_box(
         '_contacto_id',
         'Encargado(a)',
         [$this, 'set_contacto_id_cbk'],
         'comedor',
         'normal',
         'default'
      );
   }
   public function set_provincia_id_cbk($post)
   {
      wp_nonce_field('provincia_id_nonce', 'provincia_id_nonce');
      $provincia_id = get_post_meta($post->ID, '_provincia_id', true);
      echo '<input type="text" style="width:5%" id="provincia_id" name="provincia_id" value="' . esc_attr($provincia_id) . '" ></input>';
   }
   public function save_provincia_id($post_id)
   {
      if (!isset($_POST['provincia_id_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['provincia_id_nonce'], 'provincia_id_nonce')) {
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
      if (!isset($_POST['provincia_id'])) {
         return;
      }
      $provincia_id = sanitize_text_field($_POST['provincia_id']);
      update_post_meta($post_id, '_provincia_id', $provincia_id);
   }
   public function set_canton_id_cbk($post)
   {
      wp_nonce_field('canton_id_nonce', 'canton_id_nonce');
      $canton_id = get_post_meta($post->ID, '_canton_id', true);
      echo '<input type="text" style="width:5%" id="canton_id" name="canton_id" value="' . esc_attr($canton_id) . '" ></input>';
   }
   public function save_canton_id($post_id)
   {
      if (!isset($_POST['canton_id_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['canton_id_nonce'], 'canton_id_nonce')) {
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
      if (!isset($_POST['canton_id'])) {
         return;
      }
      $canton_id = sanitize_text_field($_POST['canton_id']);
      update_post_meta($post_id, '_canton_id', $canton_id);
   }
   public function set_distrito_id_cbk($post)
   {
      wp_nonce_field('distrito_id_nonce', 'distrito_id_nonce');
      $distrito_id = get_post_meta($post->ID, '_distrito_id', true);
      echo '<input type="text" style="width:5%" id="distrito_id" name="distrito_id" value="' . esc_attr($distrito_id) . '" ></input>';
   }
   public function save_distrito_id($post_id)
   {
      if (!isset($_POST['distrito_id_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['distrito_id_nonce'], 'distrito_id_nonce')) {
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
      if (!isset($_POST['distrito_id'])) {
         return;
      }
      $distrito_id = sanitize_text_field($_POST['distrito_id']);
      update_post_meta($post_id, '_distrito_id', $distrito_id);
   }
   public function set_direccion_cbk($post)
   {
      wp_nonce_field('direccion_nonce', 'direccion_nonce');
      $direccion = get_post_meta($post->ID, '_direccion', true);
      echo '<input type="text" style="width:50%" id="direccion" name="direccion" value="' . esc_attr($direccion) . '" ></input>';
   }
   public function save_direccion($post_id)
   {
      if (!isset($_POST['direccion_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['direccion_nonce'], 'direccion_nonce')) {
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
      if (!isset($_POST['direccion'])) {
         return;
      }
      $direccion = sanitize_text_field($_POST['direccion']);
      update_post_meta($post_id, '_direccion', $direccion);
   }
   public function set_email_cbk($post)
   {
      wp_nonce_field('email_nonce', 'email_nonce');
      $email = get_post_meta($post->ID, '_email', true);
      echo '<input type="email" style="width:20%" id="email" name="email" value="' . esc_attr($email) . '" ></input>';
   }
   public function save_email($post_id)
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
   public function set_telefono_cbk($post)
   {
      wp_nonce_field('telefono_nonce', 'telefono_nonce');
      $telefono = get_post_meta($post->ID, '_telefono', true);
      echo '<input type="text" style="width:20%" id="telefono" name="telefono" value="' . esc_attr($telefono) . '" ></input>';
   }
   public function save_telefono($post_id)
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
   public function set_contacto_id_cbk($post)
   {
      wp_nonce_field('contacto_id_nonce', 'contacto_id_nonce');
      $contacto_id = get_post_meta($post->ID, '_contacto_id', true);
      echo '<input type="text" style="width:5%" id="contacto_id" name="contacto_id" value="' . esc_attr($contacto_id) . '" ></input>';
   }
   public function save_contacto_id($post_id)
   {
      if (!isset($_POST['contacto_id_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['contacto_id_nonce'], 'contacto_id_nonce')) {
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
      if (!isset($_POST['contacto_id'])) {
         return;
      }
      $contacto_id = sanitize_text_field($_POST['contacto_id']);
      update_post_meta($post_id, '_contacto_id', $contacto_id);
   }
   public function scc_comedor_set_pre_get_posts($query)
   {
      if (!is_admin() && is_post_type_archive() && $query->is_main_query()) {
         if (is_post_type_archive('comedor')) {
            $query->set('orderby', 'post_title');
            $query->set('order', 'ASC');
         }
      }
   }


   private function set_paginas()
   {
      $paginas = [
         'comedor' =>
         [
            'slug' => 'comedor-mantenimiento',
            'titulo' => 'Ingresar Comedores'
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
   public function scc_get_comedores()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'comedores')) {
         wp_send_json_error('Error de seguridad', 401);
         wp_die();
      } else {

         global $wpdb;

         $sql =
            "SELECT ID, post_title AS comedor
            FROM $wpdb->posts
            WHERE post_type = 'comedor' AND post_status = 'publish'
            ORDER BY post_title
            ";

         $comedores = $wpdb->get_results($sql, ARRAY_A);
         if ($comedores) {
            wp_send_json_success($comedores);
         } else {
            wp_send_json_success([['ID' => 0, 'comedor' => 'No hay comedores definidos']]);
         }
      }
   }
   public function comedor_agregar()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'comedores')) {
         wp_send_json_error('Error de seguridad', 401);
         wp_die();
      } else {
         $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
         $charactersLength = strlen($characters);
         $randomString = '';
         for ($i = 0; $i < 15; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
         }
         $post_name = 'com_' . $randomString;

         require_once(ABSPATH . "wp-admin" . '/includes/image.php');
         require_once(ABSPATH . "wp-admin" . '/includes/file.php');
         require_once(ABSPATH . "wp-admin" . '/includes/media.php');

         $attach_id = media_handle_upload('comedor_imagen', $post_id);
         if (is_wp_error($attach_id)) {
            $attach_id = '';
         }
         $post_title = sanitize_text_field($_POST['nombre']);
         $provincia = sanitize_text_field($_POST['provincia']);
         $canton = sanitize_text_field($_POST['canton']);
         $distrito = sanitize_text_field($_POST['distrito']);
         $direccion = sanitize_text_field($_POST['direccion']);
         $telefono = sanitize_text_field($_POST['t_principal']);
         $email = sanitize_text_field($_POST['email']);
         $contacto_id = sanitize_text_field($_POST['contacto_id']);
         $post_data =
            [
               'post_type' => 'comedor',
               'post_title' => $post_title,
               'post_name' => $post_name,
               'post_status' => 'publish',
               'meta_input' =>
               [
                  '_nombre' => $nombre,
                  '_provincia_id' => $provincia,
                  '_canton_id' => $canton,
                  '_distrito_id' => $distrito,
                  '_direccion' => $direccion,
                  '_email' => $email,
                  '_telefono' => $telefono,
                  '_contacto_id' => $contacto_id
               ]

            ];
         $post_id = wp_insert_post($post_data);
         set_post_thumbnail($post_id, $attach_id);
         wp_send_json_success(['titulo' => 'Comedores', 'msg' => 'La información del Comedor se registró correctamente.']);
      }
   }
   public function comedor_editar()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'comedores')) {
         wp_send_json_error('Error de seguridad', 401);
         wp_die();
      } else {
         $gestion = sanitize_text_field($_POST['gestion']);

         if ($gestion == 'modificar') {
            $this->comedor_modificar();
         }
         if ($gestion == 'eliminar') {
            $this->comedor_eliminar();
         }
      }
   }
   private function comedor_modificar()
   {
      $post_id = sanitize_text_field($_POST['post_id']);

      require_once(ABSPATH . "wp-admin" . '/includes/image.php');
      require_once(ABSPATH . "wp-admin" . '/includes/file.php');
      require_once(ABSPATH . "wp-admin" . '/includes/media.php');

      $attach_id = media_handle_upload('comedor_imagen', $post_id);
      if (is_wp_error($attach_id)) {
         $attach_id = '';
      }
      set_post_thumbnail($post_id, $attach_id);

      $post_title = sanitize_text_field($_POST['nombre']);
      $provincia = sanitize_text_field($_POST['provincia']);
      $canton = sanitize_text_field($_POST['canton']);
      $distrito = sanitize_text_field($_POST['distrito']);
      $direccion = sanitize_text_field($_POST['direccion']);
      $telefono = sanitize_text_field($_POST['telefono']);
      $email = sanitize_text_field($_POST['email']);
      $contacto_id = sanitize_text_field($_POST['contacto_id']);

      $post_data =
         [
            'ID' => $post_id,
            'post_type' => 'comedor',
            'post_title' => $post_title,
            'post_status' => 'publish',
            'meta_input' =>
            [
               '_provincia_id' => $provincia,
               '_canton_id' => $canton,
               '_distrito_id' => $distrito,
               '_direccion' => $direccion,
               '_email' => $email,
               '_telefono' => $telefono,
               '_contacto_id' => $contacto_id
            ]
         ];

      wp_update_post($post_data);
      wp_send_json_success(['titulo' => 'Comedores', 'msg' => 'La información del Comedor se registró correctamente.']);
   }
   private function comedor_eliminar()
   {
      $post_id = sanitize_text_field($_POST['post_id']);
      wp_trash_post($post_id);
      $beneficiarios = get_posts(['post_type' => 'beneficiario', 'posts_per_page' => -1, 'post_status' => 'publish', 'post_parent' => $post_id]);
      if ($beneficiarios) {
         foreach ($beneficiarios as $eliminar) {
            wp_trash_post($eliminar->ID);
            $asistencia = get_posts(['post_type' => 'asistencia', 'posts_per_page' => -1, 'post_status' => 'publish', 'post_parent' => $eliminar->ID]);
            if ($asistencia) {
               foreach ($asistencia as $eliminar) {
                  wp_trash_post($eliminar->ID);
               }
            }
         }
      }

      wp_send_json_success(['titulo' => 'Comedor Eliminado', 'msg' => 'La información del Comedor, Beneficiarios y su bitácora de asistencia fue eliminada también.']);
   }
   public function scc_comedor_get_encargados()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'encargados')) {
         wp_send_json_error('Error de seguridad', 401);
         wp_die();
      } else {
         $contactos = get_users(['role' => 'encargadocomedores', 'orderby' => 'nicename']);
         $encargados = [];
         foreach ($contactos as $encargado) {
            $encargados[] =
               [
                  'ID' => $encargado->ID,
                  'nombre' => $encargado->display_name
               ];
         }
         wp_send_json_success($encargados);
      }
   }
}
