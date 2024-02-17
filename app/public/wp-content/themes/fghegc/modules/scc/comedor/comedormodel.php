<?php

namespace FGHEGC\Modules\Scc\Comedor;

use FGHEGC\Modules\Core\Singleton;

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
      add_action('wp_ajax_comedores', [$this, 'scc_get_comedores']);
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
         'name' => _x($plural, 'post type general name', 'FGHEGC'),
         'singular_name' => _x($singular, 'post type singular name', 'FGHEGC'),
         'menu_name' => _x($plural, 'admin menu', 'FGHEGC'),
         'name_admin_bar' => _x($singular, 'add new on admin bar', 'FGHEGC'),
         'add_new' => _x("Nuevo $singular", 'prayer', 'FGHEGC'),
         'add_new_item' => __("Agregar $singular", 'FGHEGC'),
         'new_item' => __("Nuevo $singular", 'FGHEGC'),
         'edit_item' => __("Editar $singular", 'FGHEGC'),
         'view_item' => __("Ver $singular", 'FGHEGC'),
         'view_items' => __("Ver $plural", 'FGHEGC'),
         'all_items' => __("Todos los $plural", 'FGHEGC'),
         'search_items' => __("Buscar $plural", 'FGHEGC'),
         'parent_item_colon' => __("$singular padre", 'FGHEGC'),
         'not_found' => __("No hay $p_lower", 'FGHEGC'),
         'not_found_in_trash' => __("No hay $p_lower borrados", 'FGHEGC'),
         'archives' => __("$singular Archivado", 'FGHEGC'),
         'attributes' => __("Atributos del $singular", 'FGHEGC'),
         'insert_into_item' => __("Insertar $s_lower", 'FGHEGC'),
         'uploaded_to_this_item' => __("Adjuntar a un $s_lower", 'FGHEGC'),
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
}
