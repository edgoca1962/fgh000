<?php

namespace FGHEGC\Modules\DivPolCri;

use FGHEGC\Modules\Core\Singleton;

class DivPolCriModel
{
   use Singleton;

   public function __construct()
   {
      add_action('init', [$this, 'set_divpolcri']);
      add_action('add_meta_boxes', [$this, 'set_campos']);
      add_action('save_post', [$this, 'save_provincia_id']);
      add_action('save_post', [$this, 'save_provincia']);
      add_action('save_post', [$this, 'save_canton_id']);
      add_action('save_post', [$this, 'save_canton']);
      add_action('save_post', [$this, 'save_distrito_id']);
      add_action('save_post', [$this, 'save_distrito']);
      add_action('wp_ajax_beneficiario_csvfile', [$this, 'fghegc_beneficiario_csvfile']);
      $this->set_paginas();
      add_action('wp_ajax_provincia', [$this, 'dpc_get_provincia']);
      add_action('wp_ajax_canton', [$this, 'dpc_get_canton']);
      add_action('wp_ajax_distrito', [$this, 'dpc_get_distrito']);
   }
   public function set_divpolcri()
   {
      $type = 'divpolcri';
      $labels = $this->get_etiquetas('Div_Pol_CRI', 'Div_Pol_CRIs');

      $args = array(
         'capability_type' => ['divpolcri', 'divpolcris'],
         'map_meta_cap' => true,
         'labels' => $labels,
         'public' => true,
         'has_archive' => true,
         'rewrite' => ['slug' => 'divpolcris'],
         'show_in_rest' => true,
         'rest_base' => 'divpolcris',
         'menu_icon' => 'dashicons-book',
         'supports' => array('title'),
      );

      register_post_type($type, $args);

      $admin = get_role('administrator');
      $capabilities = $this->get_capacidades('divpolcri', 'divpolcris');
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
      add_meta_box(
         '_provincia_id',
         'Provincia ID',
         [$this, 'set_provincia_id_cbk'],
         'divpolcri',
         'normal',
         'default'
      );
      add_meta_box(
         '_provincia',
         'Provincia',
         [$this, 'set_provincia_cbk'],
         'divpolcri',
         'normal',
         'default'
      );
      add_meta_box(
         '_canton_id',
         'Cantón ID',
         [$this, 'set_canton_id_cbk'],
         'divpolcri',
         'normal',
         'default'
      );
      add_meta_box(
         '_canton',
         'Cantón',
         [$this, 'set_canton_cbk'],
         'divpolcri',
         'normal',
         'default'
      );
      add_meta_box(
         '_distrito_id',
         'Distrito ID',
         [$this, 'set_distrito_id_cbk'],
         'divpolcri',
         'normal',
         'default'
      );
      add_meta_box(
         '_distrito',
         'Distrito',
         [$this, 'set_distrito_cbk'],
         'divpolcri',
         'normal',
         'default'
      );
   }
   public function set_provincia_id_cbk($post)
   {
      wp_nonce_field('provincia_id_nonce', 'provincia_id_nonce');
      $provincia_id = get_post_meta($post->ID, '_provincia_id', true);
      echo '<input type="text" style="width:20%" id="provincia_id" name="provincia_id" value="' . esc_attr($provincia_id) . '" ></input>';
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
   public function set_provincia_cbk($post)
   {
      wp_nonce_field('provincia_nonce', 'provincia_nonce');
      $provincia = get_post_meta($post->ID, '_provincia', true);
      echo '<input type="text" style="width:20%" id="provincia" name="provincia" value="' . esc_attr($provincia) . '" ></input>';
   }
   public function save_provincia($post_id)
   {
      if (!isset($_POST['provincia_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['provincia_nonce'], 'provincia_nonce')) {
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
      if (!isset($_POST['provincia'])) {
         return;
      }
      $provincia = sanitize_text_field($_POST['provincia']);
      update_post_meta($post_id, '_provincia', $provincia);
   }
   public function set_canton_id_cbk($post)
   {
      wp_nonce_field('canton_id_nonce', 'canton_id_nonce');
      $canton_id = get_post_meta($post->ID, '_canton_id', true);
      echo '<input type="text" style="width:20%" id="canton_id" name="canton_id" value="' . esc_attr($canton_id) . '" ></input>';
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
   public function set_canton_cbk($post)
   {
      wp_nonce_field('canton_nonce', 'canton_nonce');
      $canton = get_post_meta($post->ID, '_canton', true);
      echo '<input type="text" style="width:20%" id="canton" name="canton" value="' . esc_attr($canton) . '" ></input>';
   }
   public function save_canton($post_id)
   {
      if (!isset($_POST['canton_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['canton_nonce'], 'canton_nonce')) {
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
      if (!isset($_POST['canton'])) {
         return;
      }
      $canton = sanitize_text_field($_POST['canton']);
      update_post_meta($post_id, '_canton', $canton);
   }
   public function set_distrito_id_cbk($post)
   {
      wp_nonce_field('distrito_id_nonce', 'distrito_id_nonce');
      $distrito_id = get_post_meta($post->ID, '_distrito_id', true);
      echo '<input type="text" style="width:20%" id="distrito_id" name="distrito_id" value="' . esc_attr($distrito_id) . '" ></input>';
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
   public function set_distrito_cbk($post)
   {
      wp_nonce_field('distrito_nonce', 'distrito_nonce');
      $distrito = get_post_meta($post->ID, '_distrito', true);
      echo '<input type="text" style="width:20%" id="distrito" name="distrito" value="' . esc_attr($distrito) . '" ></input>';
   }
   public function save_distrito($post_id)
   {
      if (!isset($_POST['distrito_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['distrito_nonce'], 'distrito_nonce')) {
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
      if (!isset($_POST['distrito'])) {
         return;
      }
      $distrito = sanitize_text_field($_POST['distrito']);
      update_post_meta($post_id, '_distrito', $distrito);
   }
   private function set_paginas()
   {
      $paginas = [
         'csv' =>
         [
            'slug' => 'beneficiario-csv',
            'titulo' => 'Import CSV'
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
   public function dpc_get_provincia()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'provincias')) {
         wp_send_json_error('Error de seguridad', 401);
         wp_die();
      } else {

         global $wpdb;

         $sql =
            "SELECT DISTINCT t1.meta_value AS ID, t2.meta_value AS provincia
            FROM $wpdb->posts
            INNER JOIN $wpdb->postmeta t1
               ON (ID = t1.post_id)
            INNER JOIN $wpdb->postmeta t2
               ON (ID = t2.post_id)
            WHERE post_type = 'divpolcri'
               AND (t1.meta_key = '_provincia_id' AND t1.meta_value !='')
               AND (t2.meta_key = '_provincia' AND t2.meta_value !='')
            ORDER BY t2.meta_value
            ";

         $provincias = $wpdb->get_results($sql, ARRAY_A);
         wp_send_json_success($provincias);
      }
   }
   public function dpc_get_canton()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'cantones')) {
         wp_send_json_error('Error de seguridad', 401);
         wp_die();
      } else {
         $provincia_id = sanitize_text_field($_POST['provincia_id']);
         global $wpdb;

         $sql =
            "SELECT DISTINCT t1.meta_value AS ID, t2.meta_value AS canton
            FROM $wpdb->posts
            INNER JOIN $wpdb->postmeta t1
               ON (ID = t1.post_id)
            INNER JOIN $wpdb->postmeta t2
               ON (ID = t2.post_id)
            INNER JOIN $wpdb->postmeta t3
               ON (ID = t3.post_id)
            WHERE post_type = 'divpolcri'
               AND (t1.meta_key = '_canton_id' AND t1.meta_value !='')
               AND (t2.meta_key = '_canton' AND t2.meta_value !='')
               AND (t3.meta_key = '_provincia_id' AND t3.meta_value = $provincia_id)
            ORDER BY t2.meta_value
            ";

         $cantones = $wpdb->get_results($sql, ARRAY_A);
         wp_send_json_success($cantones);
      }
   }
   public function dpc_get_distrito()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'distritos')) {
         wp_send_json_error('Error de seguridad', 401);
         wp_die();
      } else {
         $canton_id = sanitize_text_field($_POST['canton_id']);
         global $wpdb;

         $sql =
            "SELECT DISTINCT t1.meta_value AS ID, t2.meta_value AS distrito
            FROM $wpdb->posts
            INNER JOIN $wpdb->postmeta t1
               ON (ID = t1.post_id)
            INNER JOIN $wpdb->postmeta t2
               ON (ID = t2.post_id)
            INNER JOIN $wpdb->postmeta t3
               ON (ID = t3.post_id)
            WHERE post_type = 'divpolcri'
               AND (t1.meta_key = '_distrito_id' AND t1.meta_value != '')
               AND (t2.meta_key = '_distrito' AND t2.meta_value != '')
               AND (t3.meta_key = '_canton_id' AND t3.meta_value = $canton_id)
            ORDER BY t2.meta_value
            ";

         $distritos = $wpdb->get_results($sql, ARRAY_A);
         wp_send_json_success($distritos);
      }
   }
   public function scc_divpolcri_get_provincia($provincia_id)
   {
      global $wpdb;

      $sql =
         "SELECT t2.meta_value AS provincia
      FROM $wpdb->posts
      INNER JOIN $wpdb->postmeta t1
         ON (ID = t1.post_id)
      INNER JOIN $wpdb->postmeta t2
         ON (ID = t2.post_id)
      WHERE post_type = 'divpolcri'
         AND (t1.meta_key = '_provincia_id' AND t1.meta_value = $provincia_id)
         AND (t2.meta_key = '_provincia' AND t2.meta_value !='')
      ORDER BY t2.meta_value
      ";

      $provincia = $wpdb->get_var($sql);

      return $provincia;
   }
   public function scc_divpolcri_get_canton($canton_id)
   {
      global $wpdb;

      $sql =
         "SELECT t2.meta_value AS canton
      FROM $wpdb->posts
      INNER JOIN $wpdb->postmeta t1
         ON (ID = t1.post_id)
      INNER JOIN $wpdb->postmeta t2
         ON (ID = t2.post_id)
      WHERE post_type = 'divpolcri'
         AND (t1.meta_key = '_canton_id' AND t1.meta_value = $canton_id)
         AND (t2.meta_key = '_canton' AND t2.meta_value !='')
      ORDER BY t2.meta_value
      ";

      $cantone = $wpdb->get_var($sql);

      return $cantone;
   }
   public function scc_divpolcri_get_distrito($distrito_id)
   {
      global $wpdb;

      $sql =
         "SELECT t2.meta_value AS distrito
      FROM $wpdb->posts
      INNER JOIN $wpdb->postmeta t1
         ON (ID = t1.post_id)
      INNER JOIN $wpdb->postmeta t2
         ON (ID = t2.post_id)
      WHERE post_type = 'divpolcri'
         AND (t1.meta_key = '_distrito_id' AND t1.meta_value = $distrito_id)
         AND (t2.meta_key = '_distrito' AND t2.meta_value !='')
      ORDER BY t2.meta_value
      ";

      $distrito = $wpdb->get_var($sql);

      return $distrito;
   }
}
