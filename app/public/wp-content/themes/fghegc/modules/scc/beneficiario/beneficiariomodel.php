<?php

namespace FGHEGC\Modules\Scc\Beneficiario;

use FGHEGC\Modules\Core\Singleton;

class BeneficiarioModel
{
   use Singleton;

   public function __construct()
   {
      $this->set_paginas();
   }
   public function set_beneficiario()
   {
      $type = 'beneficiario';
      $labels = $this->get_etiquetas('Beneficiario', 'Beneficiarios');

      $args = array(
         'capability_type' => ['beneficiario', 'beneficiarios'],
         'map_meta_cap' => true,
         'labels' => $labels,
         'public' => true,
         'has_archive' => true,
         'rewrite' => ['slug' => 'beneficiarios'],
         'show_in_rest' => true,
         'rest_base' => 'beneficiarios',
         'menu_icon' => 'dashicons-book',
         'supports' => array('title', 'editor', 'custom-fields', 'comments'),
      );

      register_post_type($type, $args);

      $admin = get_role('administrator');
      $capabilities = $this->get_capacidades('beneficiario', 'beneficiarios');
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
   public function set_pre_get_posts($query)
   {
      if (!is_admin() && is_post_type_archive() && $query->is_main_query()) {
      }
   }
   private function set_paginas()
   {
      $paginas = [
         'principal' =>
         [
            'slug' => 'beneficiario-principal',
            'titulo' => 'Sistema Comedores'
         ],
         'mantenimiento' =>
         [
            'slug' => 'beneficiario-mantenimiento',
            'titulo' => 'Mantenimiento de Beneficiarios'
         ],
         'usuario' =>
         [
            'slug' => 'beneficiario-usuario',
            'titulo' => 'Usuarios'
         ]
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
   public function set_roles()
   {
      // remove_role('useradmineventos');
      // remove_role('usercoordinaeventos');
      add_role('useradminbeneficiarios', 'Administrador(a) Beneficiarios', get_role('subscriber')->capabilities);
      add_role('beneficiarios', 'Beneficiarios', get_role('subscriber')->capabilities);
   }
}
