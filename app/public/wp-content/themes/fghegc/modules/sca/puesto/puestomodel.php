<?php

namespace FGHEGC\Modules\Sca\Puesto;

use FGHEGC\modules\core\Singleton;

class PuestoModel
{
   use Singleton;
   public function __construct()
   {
      add_action('init', [$this, 'set_puesto']);
      add_action('pre_get_posts', [$this, 'set_pre_get_posts']);
   }
   public function set_puesto()
   {
      $type = 'puesto';
      $labels = $this->get_etiquetas('Puesto', 'Puestos');

      $args = array(
         'capability_type' => ['puesto', 'puestos'],
         'map_meta_cap' => true,
         'labels' => $labels,
         'public' => true,
         'has_archive' => true,
         'rewrite' => ['slug' => 'puestos'],
         'show_in_rest' => true,
         'rest_base' => 'puestos',
         'menu_icon' => 'dashicons-book',
         'supports' => array('title', 'custom-fields'),
         // 'taxonomies'               => ['category', 'post_tag'],
      );

      register_post_type($type, $args);

      $admin = get_role('administrator');
      $capabilities = $this->get_capacidades('puesto', 'puestos');
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
         'archives' => __("$singular Archivados", 'fghmvc'),
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
}
