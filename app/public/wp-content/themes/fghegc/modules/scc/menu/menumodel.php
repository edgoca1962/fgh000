<?php

namespace FGHEGC\Modules\Scc\Menu;

use FGHEGC\Modules\Core\Singleton;

class MenuModel
{
   use Singleton;

   public function __construct()
   {
      add_action('init', [$this, 'set_menu']);
      add_action('add_meta_boxes', [$this, 'set_campos']);
      add_action('save_post', [$this, 'save_cereales']);
      add_action('save_post', [$this, 'save_verduras']);
      add_action('save_post', [$this, 'save_leguminosas']);
      add_action('save_post', [$this, 'save_vegetales']);
      add_action('save_post', [$this, 'save_animales']);
      add_action('save_post', [$this, 'save_grasas']);
      add_action('save_post', [$this, 'save_bebidas']);
      add_action('wp_ajax_menu_agregar', [$this, 'scc_agregar_menu']);
      add_action('wp_ajax_menu_editar', [$this, 'scc_menu_editar']);
      $this->set_paginas();
   }
   public function set_menu()
   {
      $type = 'menu';
      $labels = $this->get_etiquetas('Menu', 'Menues');

      $args = array(
         'capability_type' => ['menu', 'menues'],
         'map_meta_cap' => true,
         'labels' => $labels,
         'public' => true,
         'has_archive' => true,
         'rewrite' => ['slug' => 'menues'],
         'show_in_rest' => true,
         'rest_base' => 'menues',
         'menu_icon' => 'dashicons-book',
         'supports' => array('title', 'editor', 'thumbnail', 'custom-fields', 'comments'),
      );

      register_post_type($type, $args);

      $admin = get_role('administrator');
      $capabilities = $this->get_capacidades('menu', 'menues');
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
      // Fecha menu es post_date
      // post_parent es el ID del Comedor
      // Descripción del menu es content

      add_meta_box(
         '_cereales',
         'Cereales y sus derivados',
         [$this, 'set_cereales_cbk'],
         'menu',
         'normal',
         'default'
      );
      add_meta_box(
         '_verduras',
         'Verduras Harinosas',
         [$this, 'set_verduras_cbk'],
         'menu',
         'normal',
         'default'
      );
      add_meta_box(
         '_leguminosas',
         'Leguminosas',
         [$this, 'set_leguminosas_cbk'],
         'menu',
         'normal',
         'default'
      );
      add_meta_box(
         '_vegetales',
         'Vegetales',
         [$this, 'set_vegetales_cbk'],
         'menu',
         'normal',
         'default'
      );
      add_meta_box(
         '_animales',
         'Alimentos de origen animal',
         [$this, 'set_animales_cbk'],
         'menu',
         'normal',
         'default'
      );
      add_meta_box(
         '_grasas',
         'Grasas',
         [$this, 'set_grasas_cbk'],
         'menu',
         'normal',
         'default'
      );
      add_meta_box(
         '_bebidas',
         'Grasas',
         [$this, 'set_bebidas_cbk'],
         'menu',
         'normal',
         'default'
      );
   }
   public function set_cereales_cbk($post)
   {
      wp_nonce_field('cereales_nonce', 'cereales_nonce');
      $cereales = get_post_meta($post->ID, '_cereales', true);
      echo '<input type="text" style="width:20%" id="cereales" name="cereales" value="' . esc_attr($cereales) . '" ></input>';
   }
   public function save_cereales($post_id)
   {
      if (!isset($_POST['cereales_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['cereales_nonce'], 'cereales_nonce')) {
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
      if (!isset($_POST['cereales'])) {
         return;
      }
      $cereales = sanitize_text_field($_POST['cereales']);
      update_post_meta($post_id, '_cereales', $cereales);
   }
   public function set_verduras_cbk($post)
   {
      wp_nonce_field('verduras_nonce', 'verduras_nonce');
      $verduras = get_post_meta($post->ID, '_verduras', true);
      echo '<input type="text" style="width:20%" id="verduras" name="verduras" value="' . esc_attr($verduras) . '" ></input>';
   }
   public function save_verduras($post_id)
   {
      if (!isset($_POST['verduras_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['verduras_nonce'], 'verduras_nonce')) {
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
      if (!isset($_POST['verduras'])) {
         return;
      }
      $verduras = sanitize_text_field($_POST['verduras']);
      update_post_meta($post_id, '_verduras', $verduras);
   }
   public function set_leguminosas_cbk($post)
   {
      wp_nonce_field('leguminosas_nonce', 'leguminosas_nonce');
      $leguminosas = get_post_meta($post->ID, '_leguminosas', true);
      echo '<input type="text" style="width:20%" id="leguminosas" name="leguminosas" value="' . esc_attr($leguminosas) . '" ></input>';
   }
   public function save_leguminosas($post_id)
   {
      if (!isset($_POST['leguminosas_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['leguminosas_nonce'], 'leguminosas_nonce')) {
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
      if (!isset($_POST['leguminosas'])) {
         return;
      }
      $leguminosas = sanitize_text_field($_POST['leguminosas']);
      update_post_meta($post_id, '_leguminosas', $leguminosas);
   }
   public function set_vegetales_cbk($post)
   {
      wp_nonce_field('vegetales_nonce', 'vegetales_nonce');
      $vegetales = get_post_meta($post->ID, '_vegetales', true);
      echo '<input type="text" style="width:20%" id="vegetales" name="vegetales" value="' . esc_attr($vegetales) . '" ></input>';
   }
   public function save_vegetales($post_id)
   {
      if (!isset($_POST['vegetales_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['vegetales_nonce'], 'vegetales_nonce')) {
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
      if (!isset($_POST['vegetales'])) {
         return;
      }
      $vegetales = sanitize_text_field($_POST['vegetales']);
      update_post_meta($post_id, '_vegetales', $vegetales);
   }
   public function set_animales_cbk($post)
   {
      wp_nonce_field('animales_nonce', 'animales_nonce');
      $animales = get_post_meta($post->ID, '_animales', true);
      echo '<input type="text" style="width:20%" id="animales" name="animales" value="' . esc_attr($animales) . '" ></input>';
   }
   public function save_animales($post_id)
   {
      if (!isset($_POST['animales_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['animales_nonce'], 'animales_nonce')) {
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
      if (!isset($_POST['animales'])) {
         return;
      }
      $animales = sanitize_text_field($_POST['animales']);
      update_post_meta($post_id, '_animales', $animales);
   }
   public function set_grasas_cbk($post)
   {
      wp_nonce_field('grasas_nonce', 'grasas_nonce');
      $grasas = get_post_meta($post->ID, '_grasas', true);
      echo '<input type="text" style="width:20%" id="grasas" name="grasas" value="' . esc_attr($grasas) . '" ></input>';
   }
   public function save_grasas($post_id)
   {
      if (!isset($_POST['grasas_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['grasas_nonce'], 'grasas_nonce')) {
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
      if (!isset($_POST['grasas'])) {
         return;
      }
      $grasas = sanitize_text_field($_POST['grasas']);
      update_post_meta($post_id, '_grasas', $grasas);
   }
   public function set_bebidas_cbk($post)
   {
      wp_nonce_field('bebidas_nonce', 'bebidas_nonce');
      $bebidas = get_post_meta($post->ID, '_bebidas', true);
      echo '<input type="text" style="width:20%" id="bebidas" name="bebidas" value="' . esc_attr($bebidas) . '" ></input>';
   }
   public function save_bebidas($post_id)
   {
      if (!isset($_POST['bebidas_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['bebidas_nonce'], 'bebidas_nonce')) {
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
      if (!isset($_POST['bebidas'])) {
         return;
      }
      $bebidas = sanitize_text_field($_POST['bebidas']);
      update_post_meta($post_id, '_bebidas', $bebidas);
   }
   /**
    * 
    * Fin definición post menu
    * 
    * */
   private function set_paginas()
   {
      $paginas = [
         'menu' =>
         [
            'slug' => 'menu-mantenimiento',
            'titulo' => 'Ingresar Menú'
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
   public function scc_agregar_menu()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'menues')) {
         wp_send_json_error('Error de seguridad', 401);
         wp_die();
      } else {
         $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
         $charactersLength = strlen($characters);
         $randomString = '';
         for ($i = 0; $i < 15; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
         }
         $post_name = 'men_' . $randomString;

         $post_date = sanitize_text_field($_POST['post_date']);
         $post_parent = sanitize_text_field($_POST['post_parent']);
         $post_title = $post_date . ' - ' . get_post($post_parent)->post_title;
         $post_content = sanitize_textarea_field($_POST['post_content']);
         $cereales = sanitize_text_field($_POST['cereales']);
         $verduras = sanitize_text_field($_POST['verduras']);
         $leguminosas = sanitize_text_field($_POST['leguminosas']);
         $frutas = sanitize_text_field($_POST['frutas']);
         $vegetales = sanitize_text_field($_POST['vegetales']);
         $animales = sanitize_text_field($_POST['animales']);
         $grasas = sanitize_text_field($_POST['grasas']);
         $bebidas = sanitize_text_field($_POST['bebidas']);

         $post_data = array(
            'post_type' => 'menu',
            'post_title' => $post_title,
            'post_content' => $post_content,
            'post_name' => $post_name,
            'post_status' => 'publish',
            'post_parent' => $post_parent,
            'post_date' => $post_date,
            'meta_input' => array(
               '_cereales' => $cereales,
               '_verduras' => $verduras,
               '_leguminosas' => $leguminosas,
               '_frutas' => $frutas,
               '_vegetales' => $vegetales,
               '_animales' => $animales,
               '_grasas' => $grasas,
               '_bebidas' => $bebidas,
            )
         );
         wp_insert_post($post_data);
         wp_send_json_success(['titulo' => 'Registro de Menú', 'msg' => 'El menú fue registrado exitosamente.']);
      }
   }
   public function scc_menu_editar()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'menues')) {
         wp_send_json_error('Error de seguridad', 401);
         wp_die();
      } else {
         $post_id = sanitize_text_field($_POST['post_id']);
         $post_date = sanitize_text_field($_POST['post_date']);
         $post_parent = sanitize_text_field($_POST['post_parent']);
         $post_title = $post_date . ' - ' . get_post($post_parent)->post_title;
         $post_content = sanitize_textarea_field($_POST['post_content']);
         $cereales = sanitize_text_field($_POST['cereales']);
         $verduras = sanitize_text_field($_POST['verduras']);
         $leguminosas = sanitize_text_field($_POST['leguminosas']);
         $frutas = sanitize_text_field($_POST['frutas']);
         $vegetales = sanitize_text_field($_POST['vegetales']);
         $animales = sanitize_text_field($_POST['animales']);
         $grasas = sanitize_text_field($_POST['grasas']);
         $bebidas = sanitize_text_field($_POST['bebidas']);

         $post_data = array(
            'ID' => $post_id,
            'post_type' => 'menu',
            'post_title' => $post_title,
            'post_content' => $post_content,
            'post_date' => $post_date,
            'meta_input' => array(
               '_cereales' => $cereales,
               '_verduras' => $verduras,
               '_leguminosas' => $leguminosas,
               '_frutas' => $frutas,
               '_vegetales' => $vegetales,
               '_animales' => $animales,
               '_grasas' => $grasas,
               '_bebidas' => $bebidas,
            )
         );
         wp_update_post($post_data);
         wp_send_json_success(['titulo' => 'Actualizar Menú', 'msg' => 'El menú fue actualizado exitosamente.']);
      }
   }
}
