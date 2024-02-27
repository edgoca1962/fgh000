<?php

namespace FGHEGC\Modules\Scc\Asistencia;

use FGHEGC\Modules\Core\Singleton;

class AsistenciaModel
{
   use Singleton;

   public function __construct()
   {
      add_action('init', [$this, 'set_asistencia']);
      add_action('add_meta_boxes', [$this, 'set_campos']);
      add_action('save_post', [$this, 'save_reflexion']);
      add_action('save_post', [$this, 'save_alimentacion']);
      add_action('save_post', [$this, 'save_q_alimentacion']);
      add_action('wp_ajax_agregar_asistencia', [$this, 'scc_agregar_asistencia']);
   }
   public function set_asistencia()
   {
      $type = 'asistencia';
      $labels = $this->get_etiquetas('Asistencia', 'Asistencias');

      $args = array(
         'capability_type' => ['asistencia', 'asistencias'],
         'map_meta_cap' => true,
         'labels' => $labels,
         'public' => true,
         'has_archive' => true,
         'rewrite' => ['slug' => 'asistencias'],
         'show_in_rest' => true,
         'rest_base' => 'asistencias',
         'menu_icon' => 'dashicons-book',
         'supports' => array('title', 'editor', 'thumbnail', 'custom-fields', 'comments'),
      );

      register_post_type($type, $args);

      $admin = get_role('administrator');
      $capabilities = $this->get_capacidades('asistencia', 'asistencias');
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
      // Fecha Asistenia es post_date
      // post_parent es el ID del beneficiario


      add_meta_box(
         '_reflexion',
         'Asistencia a reflexion',
         [$this, 'set_reflexion_cbk'],
         'asistencia',
         'normal',
         'default'
      );
      add_meta_box(
         '_q_alimentacion',
         'Cantiad Porciones Alimentación',
         [$this, 'set_q_alimentacion_cbk'],
         'asistencia',
         'normal',
         'default'
      );
   }
   public function set_reflexion_cbk($post)
   {
      wp_nonce_field('reflexion_nonce', 'reflexion_nonce');
      $reflexion = get_post_meta($post->ID, '_reflexion', true);
      echo '<input type="text" style="width:20%" id="reflexion" name="reflexion" value="' . esc_attr($reflexion) . '" ></input>';
   }
   public function save_reflexion($post_id)
   {
      if (!isset($_POST['reflexion_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['reflexion_nonce'], 'reflexion_nonce')) {
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
      if (!isset($_POST['reflexion'])) {
         return;
      }
      $reflexion = sanitize_text_field($_POST['reflexion']);
      update_post_meta($post_id, '_reflexion', $reflexion);
   }
   public function set_alimentacion_cbk($post)
   {
      wp_nonce_field('alimentacion_nonce', 'alimentacion_nonce');
      $alimentacion = get_post_meta($post->ID, '_alimentacion', true);
      echo '<input type="text" style="width:20%" id="alimentacion" name="alimentacion" value="' . esc_attr($alimentacion) . '" ></input>';
   }
   public function save_alimentacion($post_id)
   {
      if (!isset($_POST['alimentacion_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['alimentacion_nonce'], 'alimentacion_nonce')) {
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
      if (!isset($_POST['alimentacion'])) {
         return;
      }
      $alimentacion = sanitize_text_field($_POST['alimentacion']);
      update_post_meta($post_id, '_alimentacion', $alimentacion);
   }
   public function set_q_alimentacion_cbk($post)
   {
      wp_nonce_field('q_alimentacion_nonce', 'q_alimentacion_nonce');
      $q_alimentacion = get_post_meta($post->ID, '_q_alimentacion', true);
      echo '<input type="number" min="0" max="4" style="width:5%" id="q_alimentacion" name="q_alimentacion" value="' . esc_attr($q_alimentacion) . '" ></input>';
   }
   public function save_q_alimentacion($post_id)
   {
      if (!isset($_POST['q_alimentacion_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['q_alimentacion_nonce'], 'q_alimentacion_nonce')) {
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
      if (!isset($_POST['q_alimentacion'])) {
         return;
      }
      $q_alimentacion = sanitize_text_field($_POST['q_alimentacion']);
      update_post_meta($post_id, '_q_alimentacion', $q_alimentacion);
   }

   public function scc_agregar_asistencia()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'asistencia')) {
         wp_send_json_error('Error de seguridad', 401);
         wp_die();
      } else {
         $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
         $charactersLength = strlen($characters);
         $randomString = '';
         for ($i = 0; $i < 15; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
         }
         $post_name = 'asi_' . $randomString;

         $f_asistencia = sanitize_text_field($_POST['f_asistencia']);
         $reflexion = sanitize_text_field($_POST['reflexion']);
         $q_alimentacion = sanitize_text_field($_POST['q_alimentacion']);
         $post_parent = sanitize_text_field($_POST['post_parent']);
         $titulo = sanitize_text_field($_POST['nombre']);

         global $wpdb;
         $sql =
            "SELECT ID
            FROM $wpdb->posts
            WHERE post_type ='asistencia' 
              AND post_parent = $post_parent
              AND post_status = 'publish'
              AND post_date = '$f_asistencia'
            ";
         $registrado = $wpdb->get_var($sql);
         if ($registrado) {
            $post_data = array(
               'ID' => $registrado,
               'post_type' => 'asistencia',
               'post_title' => $titulo,
               'post_name' => $post_name,
               'post_status' => 'publish',
               'post_parent' => $post_parent,
               'post_date' => $f_asistencia,
               'meta_input' => array(
                  '_reflexion' => $reflexion,
                  '_q_alimentacion' => $q_alimentacion,
               )
            );
            wp_update_post($post_data);
            $mensaje = 'La información fue ACTUALIZADA exitosamente.';
         } else {
            $post_data = array(
               'post_type' => 'asistencia',
               'post_title' => $titulo,
               'post_name' => $post_name,
               'post_status' => 'publish',
               'post_parent' => $post_parent,
               'post_date' => $f_asistencia,
               'meta_input' => array(
                  '_reflexion' => $reflexion,
                  '_q_alimentacion' => $q_alimentacion,
               )
            );
            $mensaje = 'La información fue registrada exitosamente.';
            wp_insert_post($post_data);
            update_post_meta($post_parent, '_f_u_actualizacion', $f_asistencia);
         }
         wp_send_json_success(['titulo' => 'Asistencia Actualizada', 'msg' => $mensaje]);
      }
   }
}
