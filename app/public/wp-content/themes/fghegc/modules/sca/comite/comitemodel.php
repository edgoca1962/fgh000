<?php

namespace FGHEGC\Modules\Sca\Comite;

use FGHEGC\modules\core\Singleton;

class ComiteModel
{
   use Singleton;

   public function __construct()
   {
      add_action('init', [$this, 'set_comite']);
      add_action('pre_get_posts', [$this, 'set_pre_get_posts']);
      add_action('wp_ajax_agregar_comite', [$this, 'sca_registrar_comite']);
      add_action('wp_ajax_editar_comite', [$this, 'sca_editar_comite']);
      add_action('wp_ajax_eliminar_comite', [$this, 'sca_eliminar_comite']);
   }
   public function set_comite()
   {
      $type = 'comite';
      $labels = $this->get_etiquetas('Comite', 'Comites');

      $args = array(
         'capability_type' => ['comite', 'comites'],
         'map_meta_cap' => true,
         'labels' => $labels,
         'public' => true,
         'has_archive' => true,
         'rewrite' => ['slug' => 'comites'],
         'show_in_rest' => true,
         'rest_base' => 'comites',
         'menu_icon' => 'dashicons-book',
         'supports' => array('title'),
         // 'taxonomies'               => ['category', 'post_tag'],
      );

      register_post_type($type, $args);

      $admin = get_role('administrator');
      $capabilities = $this->get_capacidades('comite', 'comites');
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
         'archives' => __("$singular Archivado", 'fghmvc'),
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
   public function set_pre_get_posts($query)
   {
      if (!is_admin() && is_post_type_archive() && $query->is_main_query()) {
         $query->set('orderby', ['ID']);
         $query->set('order', 'ASC');
      }
   }
   public function sca_registrar_comite()
   {
      //Validación de seguridad
      if (!wp_verify_nonce($_POST['nonce'], 'agregar_comite')) {
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
         $post_name = 'cid_' . $randomString;
         $title = sanitize_text_field($_POST['title']);

         $post_data = array(
            'post_type' => 'comite',
            'post_title' => $title,
            'post_name' => $post_name,
            'post_status' => 'publish',
         );
         wp_insert_post($post_data);
         wp_send_json_success(['titulo' => 'Comité Registrado', 'msg' => 'El Comité fue registrado exitosamente.']);
         wp_die();
      }
   }
   function sca_editar_comite()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'editar_comite')) {
         wp_send_json_error('Error de seguridad', 401);
         die();
      } else {
         $post_id = sanitize_text_field($_POST['post_id']);
         $post_title = sanitize_text_field($_POST['nombrecomite']);

         $post_data = [
            'ID' => $post_id,
            'post_title' => $post_title,
         ];
         wp_update_post($post_data);
         wp_send_json_success(['titulo' => 'Comité Modificado', 'msg' => 'El Comité fue modificado exitosamente.']);
         wp_die();
      }
   }
   function sca_eliminar_comite()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'eliminar_comite')) {
         wp_send_json_error('Error de seguridad', 401);
         die();
      } else {
         $post_id = sanitize_text_field($_POST['post_id']);
         /**
          * Elimina Comité
          */
         wp_trash_post($post_id);
         /**
          * Elimina actas del comité
          */
         $actas = get_posts([
            'post_type' => 'acta',
            'numberposts' => -1,
            'post_status' => 'publish',
            'meta_key' => '_comite_id',
            'meta_value' => $post_id,
         ]);
         if (count($actas)) {
            foreach ($actas as $acta) {
               wp_trash_post($acta->ID);
            }
         }
         /**
          * Elimina acuerdos de las actas del comité
          */
         $acuerdos = get_posts([
            'post_type' => 'acuerdo',
            'numberposts' => -1,
            'post_status' => 'publish',
            'meta_key' => '_comite_id',
            'meta_value' => $post_id,
         ]);
         if (count($acuerdos)) {
            foreach ($acuerdos as $acuerdo) {
               wp_trash_post($acuerdo->ID);
            }
         }

         wp_send_json_success(['titulo' => 'Comité Eliminado', 'msg' => 'El Comité fue eliminado exitosamente.']);
         wp_die();
      }
   }
}
