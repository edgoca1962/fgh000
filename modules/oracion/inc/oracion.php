<?php

/**
 * Template for CPT Oraciones.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package staging
 */

function staging_oracion_post_type()
{
   $labels = array(
      'name'                  => _x('Oraciones', 'post type general name', 'staging'),
      'singular_name'         => _x('Oración', 'post type singular name', 'staging'),
      'menu_name'             => _x('Oraciones', 'admin menu', 'staging'),
      'name_admin_bar'        => _x('Oración', 'add new on admin bar', 'staging'),
      'add_new'               => _x('Agregar', 'book', 'staging'),
      'add_new_item'          => __('Agregar Oración', 'staging'),
      'new_item'              => __('Nueva Oración', 'staging'),
      'edit_item'             => __('Editar Oración', 'staging'),
      'view_item'             => __('Ver Oración', 'staging'),
      'all_items'             => __('Oraciones (todas)', 'staging'),
      'search_items'          => __('Buscar Oraciones', 'staging'),
      'parent_item_colon'     => __('Parent Oraciones:', 'staging'),
      'not_found'             => __('Se se encontraron oraciones.', 'staging'),
      'not_found_in_trash'    => __('Se se encontraron oraciones borradas.', 'staging')
   );

   $args = array(
      'labels'                => $labels,
      'public'                => true,
      'show_in_menu'          => true,
      'has_archive'           => true,
      'show_in_rest'          => true,
      'supports'              => array('title')
   );

   register_post_type('oracion', $args);
}
add_action('init', 'staging_oracion_post_type');

function staging_crear_campos_oracion()
{
   add_meta_box(
      'peticion',                         // Unique ID     
      'Petición',                         // Title
      'staging_crear_campo_peticion_cbk', // Callback function
      'oracion',                         // Admin page (or post type)
      'normal',                           // Context
      'default',                          // Priority
      'show_in_rest'                      // Show REST API
   );
   function staging_crear_campo_peticion_cbk($post)
   {
      wp_nonce_field('peticion_nonce', 'peticion_nonce');
      $peticion = get_post_meta($post->ID, '_peticion', true);
      echo '<input type="number" style="width:8%" id="peticion" name="peticion" value="' . esc_attr($peticion) . '" ></input>';
   }
}
add_action('add_meta_boxes', 'staging_crear_campos_oracion');

function staging_guardar_campo_peticion($post_id)
{
   if (!isset($_POST['peticion_nonce'])) {
      return;
   }
   if (!wp_verify_nonce($_POST['peticion_nonce'], 'peticion_nonce')) {
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
   if (!isset($_POST['peticion'])) {
      return;
   }
   $peticion = sanitize_text_field($_POST['peticion']);
   update_post_meta($post_id, '_peticion', $peticion);
}
add_action('save_post', 'staging_guardar_campo_peticion');
