<?php

namespace FGHEGC\Modules\Scc\Beneficiario;

use FGHEGC\Modules\Core\Singleton;

class BeneficiarioModel
{
   use Singleton;

   public function __construct()
   {
      $this->set_paginas();
      $this->set_roles();
      add_action('init', [$this, 'set_beneficiario']);
      add_action('rest_api_init', [$this, 'show_beneficiario_meta_fields']);
      add_action('add_meta_boxes', [$this, 'set_campos']);
      add_action('save_post', [$this, 'save_nombre']);
      add_action('save_post', [$this, 'save_p_apellido']);
      add_action('save_post', [$this, 'save_s_apellido']);
      add_action('save_post', [$this, 'save_sexo']);
      add_action('save_post', [$this, 'save_f_nacimiento']);
      add_action('save_post', [$this, 'save_f_ingreso']);
      add_action('save_post', [$this, 'save_f_salida']);
      add_action('save_post', [$this, 'save_peso']);
      add_action('save_post', [$this, 'save_estatura']);
      add_action('save_post', [$this, 'save_provincia_id']);
      add_action('save_post', [$this, 'save_canton_id']);
      add_action('save_post', [$this, 'save_distrito_id']);
      add_action('save_post', [$this, 'save_direccion']);
      add_action('save_post', [$this, 'save_email']);
      add_action('save_post', [$this, 'save_t_principal']);
      add_action('save_post', [$this, 'save_t_otros']);
      add_action('save_post', [$this, 'save_n_madre']);
      add_action('save_post', [$this, 'save_n_padre']);
      add_action('save_post', [$this, 'save_condicion']);
      add_action('save_post', [$this, 'save_f_u_actualizacion']);
      add_action('pre_get_posts', [$this, 'scc_beneficiario_set_pre_get_posts']);
      add_action('wp_ajax_f_u_actualizacion', [$this, 'f_u_actualizacion']);
      add_action('wp_ajax_beneficiario_editar', [$this, 'beneficiario_editar']);
      add_action('wp_ajax_beneficiario_agregar', [$this, 'beneficiario_gregar']);
      add_action('wp_ajax_scc_beneficiario_mantener_usuario', [$this, 'scc_beneficiario_mantener_usuario']);
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
         'supports' => array('title', 'editor', 'thumbnail', 'custom-fields', 'comments'),
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
   public function set_campos()
   {
      add_meta_box(
         '_nombre',
         'Nombre',
         [$this, 'set_nombre_cbk'],
         'beneficiario',
         'normal',
         'default'
      );
      add_meta_box(
         '_p_apellido',
         'Primer Apellido',
         [$this, 'set_p_apellido_cbk'],
         'beneficiario',
         'normal',
         'default'
      );
      add_meta_box(
         '_s_apellido',
         'Segundo Apellido',
         [$this, 'set_s_apellido_cbk'],
         'beneficiario',
         'normal',
         'default'
      );
      add_meta_box(
         '_sexo',
         'Sexo',
         [$this, 'set_sexo_cbk'],
         'beneficiario',
         'normal',
         'default'
      );
      add_meta_box(
         '_f_nacimiento',
         'Fecha de Nacimiento',
         [$this, 'set_f_nacimiento_cbk'],
         'beneficiario',
         'normal',
         'default'
      );
      add_meta_box(
         '_f_ingreso',
         'Fecha de Ingreso',
         [$this, 'set_f_ingreso_cbk'],
         'beneficiario',
         'normal',
         'default'
      );
      add_meta_box(
         '_f_salida',
         'Fecha de Salida',
         [$this, 'set_f_salida_cbk'],
         'beneficiario',
         'normal',
         'default'
      );
      add_meta_box(
         '_peso',
         'Peso en Kilos',
         [$this, 'set_peso_cbk'],
         'beneficiario',
         'normal',
         'default'
      );
      add_meta_box(
         '_estatura',
         'Estatura en',
         [$this, 'set_estatura_cbk'],
         'beneficiario',
         'normal',
         'default'
      );
      add_meta_box(
         '_provincia_id',
         'Provincia ID',
         [$this, 'set_provincia_id_cbk'],
         'beneficiario',
         'normal',
         'default'
      );
      add_meta_box(
         '_canton_id',
         'Cantón ID',
         [$this, 'set_canton_id_cbk'],
         'beneficiario',
         'normal',
         'default'
      );
      add_meta_box(
         '_distrito_id',
         'Distrito ID',
         [$this, 'set_distrito_id_cbk'],
         'beneficiario',
         'normal',
         'default'
      );
      add_meta_box(
         '_direccion',
         'Dirección',
         [$this, 'set_direccion_cbk'],
         'beneficiario',
         'normal',
         'default'
      );
      add_meta_box(
         '_email',
         'e-mail',
         [$this, 'set_email_cbk'],
         'beneficiario',
         'normal',
         'default'
      );
      add_meta_box(
         '_t_principal',
         'Teléfono Principal',
         [$this, 'set_t_principal_cbk'],
         'beneficiario',
         'normal',
         'default'
      );
      add_meta_box(
         '_t_otros',
         'Otros Teléfonos',
         [$this, 'set_t_otros_cbk'],
         'beneficiario',
         'normal',
         'default'
      );
      add_meta_box(
         '_n_madre',
         'Nombre de la Madre o Tutor',
         [$this, 'set_n_madre_cbk'],
         'beneficiario',
         'normal',
         'default'
      );
      add_meta_box(
         '_n_padre',
         'Nombre del Padre',
         [$this, 'set_n_padre_cbk'],
         'beneficiario',
         'normal',
         'default'
      );

      // comedor_id es post_parent

      add_meta_box(
         '_f_u_actualizacion',
         'Fecha Última Actualización',
         [$this, 'set_f_u_actualizacion_cbk'],
         'beneficiario',
         'normal',
         'default'
      );
      add_meta_box(
         '_condicion',
         'Condición',
         [$this, 'set_condicion_cbk'],
         'beneficiario',
         'normal',
         'default'
      );
   }
   public function set_nombre_cbk($post)
   {
      wp_nonce_field('nombre_nonce', 'nombre_nonce');
      $nombre = get_post_meta($post->ID, '_nombre', true);
      echo '<input type="text" style="width:20%" id="nombre" name="nombre" value="' . esc_attr($nombre) . '" ></input>';
   }
   public function save_nombre($post_id)
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
   public function set_p_apellido_cbk($post)
   {
      wp_nonce_field('p_apellido_nonce', 'p_apellido_nonce');
      $p_apellido = get_post_meta($post->ID, '_p_apellido', true);
      echo '<input type="text" style="width:20%" id="p_apellido" name="p_apellido" value="' . esc_attr($p_apellido) . '" ></input>';
   }
   public function save_p_apellido($post_id)
   {
      if (!isset($_POST['p_apellido_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['p_apellido_nonce'], 'p_apellido_nonce')) {
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
      if (!isset($_POST['p_apellido'])) {
         return;
      }
      $p_apellido = sanitize_text_field($_POST['p_apellido']);
      update_post_meta($post_id, '_p_apellido', $p_apellido);
   }
   public function set_s_apellido_cbk($post)
   {
      wp_nonce_field('s_apellido_nonce', 's_apellido_nonce');
      $s_apellido = get_post_meta($post->ID, '_s_apellido', true);
      echo '<input type="text" style="width:20%" id="s_apellido" name="s_apellido" value="' . esc_attr($s_apellido) . '" ></input>';
   }
   public function save_s_apellido($post_id)
   {
      if (!isset($_POST['s_apellido_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['s_apellido_nonce'], 's_apellido_nonce')) {
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
      if (!isset($_POST['s_apellido'])) {
         return;
      }
      $s_apellido = sanitize_text_field($_POST['s_apellido']);
      update_post_meta($post_id, '_s_apellido', $s_apellido);
   }
   public function set_sexo_cbk($post)
   {
      wp_nonce_field('sexo_nonce', 'sexo_nonce');
      $sexo = get_post_meta($post->ID, '_sexo', true);
      echo '<input type="number" min="1" max="2" style="width:5%" id="sexo" name="sexo" value="' . esc_attr($sexo) . '" ></input> (1=masculino,2=femenino)';
   }
   public function save_sexo($post_id)
   {
      if (!isset($_POST['sexo_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['sexo_nonce'], 'sexo_nonce')) {
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
      if (!isset($_POST['sexo'])) {
         return;
      }
      $sexo = sanitize_text_field($_POST['sexo']);
      update_post_meta($post_id, '_sexo', $sexo);
   }
   public function set_f_nacimiento_cbk($post)
   {
      wp_nonce_field('f_nacimiento_nonce', 'f_nacimiento_nonce');
      $f_nacimiento = get_post_meta($post->ID, '_f_nacimiento', true);
      echo '<input type="date" style="width:20%" id="f_nacimiento" name="f_nacimiento" value="' . esc_attr($f_nacimiento) . '" ></input>';
   }
   public function save_f_nacimiento($post_id)
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
   public function set_f_ingreso_cbk($post)
   {
      wp_nonce_field('f_ingreso_nonce', 'f_ingreso_nonce');
      $f_ingreso = get_post_meta($post->ID, '_f_ingreso', true);
      echo '<input type="date" style="width:20%" id="f_ingreso" name="f_ingreso" value="' . esc_attr($f_ingreso) . '" ></input>';
   }
   public function save_f_ingreso($post_id)
   {
      if (!isset($_POST['f_ingreso_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['f_ingreso_nonce'], 'f_ingreso_nonce')) {
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
      if (!isset($_POST['f_ingreso'])) {
         return;
      }
      $f_ingreso = sanitize_text_field($_POST['f_ingreso']);
      update_post_meta($post_id, '_f_ingreso', $f_ingreso);
   }
   public function set_f_salida_cbk($post)
   {
      wp_nonce_field('f_salida_nonce', 'f_salida_nonce');
      $f_salida = get_post_meta($post->ID, '_f_salida', true);
      echo '<input type="date" style="width:20%" id="f_salida" name="f_salida" value="' . esc_attr($f_salida) . '" ></input>';
   }
   public function save_f_salida($post_id)
   {
      if (!isset($_POST['f_salida_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['f_salida_nonce'], 'f_salida_nonce')) {
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
      if (!isset($_POST['f_salida'])) {
         return;
      }
      $f_salida = sanitize_text_field($_POST['f_salida']);
      update_post_meta($post_id, '_f_salida', $f_salida);
   }
   public function set_peso_cbk($post)
   {
      wp_nonce_field('peso_nonce', 'peso_nonce');
      $peso = get_post_meta($post->ID, '_peso', true);
      echo '<input type="text" style="width:20%" id="peso" name="peso" value="' . esc_attr($peso) . '" ></input>';
   }
   public function save_peso($post_id)
   {
      if (!isset($_POST['peso_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['peso_nonce'], 'peso_nonce')) {
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
      if (!isset($_POST['peso'])) {
         return;
      }
      $peso = sanitize_text_field($_POST['peso']);
      update_post_meta($post_id, '_peso', $peso);
   }
   public function set_estatura_cbk($post)
   {
      wp_nonce_field('estatura_nonce', 'estatura_nonce');
      $estatura = get_post_meta($post->ID, '_estatura', true);
      echo '<input type="text" style="width:20%" id="estatura" name="estatura" value="' . esc_attr($estatura) . '" ></input>';
   }
   public function save_estatura($post_id)
   {
      if (!isset($_POST['estatura_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['estatura_nonce'], 'estatura_nonce')) {
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
      if (!isset($_POST['estatura'])) {
         return;
      }
      $estatura = sanitize_text_field($_POST['estatura']);
      update_post_meta($post_id, '_estatura', $estatura);
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
   public function set_t_principal_cbk($post)
   {
      wp_nonce_field('t_principal_nonce', 't_principal_nonce');
      $t_principal = get_post_meta($post->ID, '_t_principal', true);
      echo '<input type="text" style="width:20%" id="t_principal" name="t_principal" value="' . esc_attr($t_principal) . '" ></input>';
   }
   public function save_t_principal($post_id)
   {
      if (!isset($_POST['t_principal_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['t_principal_nonce'], 't_principal_nonce')) {
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
      if (!isset($_POST['t_principal'])) {
         return;
      }
      $t_principal = sanitize_text_field($_POST['t_principal']);
      update_post_meta($post_id, '_t_principal', $t_principal);
   }
   public function set_t_otros_cbk($post)
   {
      wp_nonce_field('t_otros_nonce', 't_otros_nonce');
      $t_otros = get_post_meta($post->ID, '_t_otros', true);
      echo '<input type="text" style="width:20%" id="t_otros" name="t_otros" value="' . esc_attr($t_otros) . '" ></input>';
   }
   public function save_t_otros($post_id)
   {
      if (!isset($_POST['t_otros_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['t_otros_nonce'], 't_otros_nonce')) {
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
      if (!isset($_POST['t_otros'])) {
         return;
      }
      $t_otros = sanitize_text_field($_POST['t_otros']);
      update_post_meta($post_id, '_t_otros', $t_otros);
   }
   public function set_n_madre_cbk($post)
   {
      wp_nonce_field('n_madre_nonce', 'n_madre_nonce');
      $n_madre = get_post_meta($post->ID, '_n_madre', true);
      echo '<input type="text" style="width:20%" id="n_madre" name="n_madre" value="' . esc_attr($n_madre) . '" ></input>';
   }
   public function save_n_madre($post_id)
   {
      if (!isset($_POST['n_madre_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['n_madre_nonce'], 'n_madre_nonce')) {
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
      if (!isset($_POST['n_madre'])) {
         return;
      }
      $n_madre = sanitize_text_field($_POST['n_madre']);
      update_post_meta($post_id, '_n_madre', $n_madre);
   }
   public function set_n_padre_cbk($post)
   {
      wp_nonce_field('n_padre_nonce', 'n_padre_nonce');
      $n_padre = get_post_meta($post->ID, '_n_padre', true);
      echo '<input type="text" style="width:20%" id="n_padre" name="n_padre" value="' . esc_attr($n_padre) . '" ></input>';
   }
   public function save_n_padre($post_id)
   {
      if (!isset($_POST['n_padre_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['n_padre_nonce'], 'n_padre_nonce')) {
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
      if (!isset($_POST['n_padre'])) {
         return;
      }
      $n_padre = sanitize_text_field($_POST['n_padre']);
      update_post_meta($post_id, '_n_padre', $n_padre);
   }
   public function set_f_u_actualizacion_cbk($post)
   {
      wp_nonce_field('f_u_actualizacion_nonce', 'f_u_actualizacion_nonce');
      $f_u_actualizacion = get_post_meta($post->ID, '_f_u_actualizacion', true);
      echo '<input type="date" style="width:20%" id="f_u_actualizacion" name="f_u_actualizacion" value="' . esc_attr($f_u_actualizacion) . '" ></input>';
   }
   public function save_f_u_actualizacion($post_id)
   {
      if (!isset($_POST['f_u_actualizacion_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['f_u_actualizacion_nonce'], 'f_u_actualizacion_nonce')) {
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
      if (!isset($_POST['f_u_actualizacion'])) {
         return;
      }
      $f_u_actualizacion = sanitize_text_field($_POST['f_u_actualizacion']);
      update_post_meta($post_id, '_f_u_actualizacion', $f_u_actualizacion);
   }
   public function f_u_actualizacion()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'f_u_actualizacion')) {
         wp_send_json_error('Error de seguridad', 401);
         wp_die();
      } else {
         $post_id = sanitize_text_field($_POST['post_id']);
         $f_u_actualizacion = sanitize_text_field($_POST['f_actualizacion']);
         if (get_post_meta($post_id, '_f_u_actualizacion', true)) {
         } else {
            add_post_meta($post_id, '_f_u_actualizacion', $f_u_actualizacion, true);
         }
         wp_send_json_success($f_u_actualizacion);
      }
   }
   public function set_condicion_cbk($post)
   {
      wp_nonce_field('condicion_nonce', 'condicion_nonce');
      $condicion = get_post_meta($post->ID, '_condicion', true);
      echo '<input type="number" min="1" max="4" style="width:5%" id="condicion" name="condicion" value="' . esc_attr($condicion) . '" ></input> (1=niño,2=Adulto Mayor,3=Embarazada,4=En Lactancia)';
   }
   public function save_condicion($post_id)
   {
      if (!isset($_POST['condicion_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['condicion_nonce'], 'condicion_nonce')) {
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
      if (!isset($_POST['condicion'])) {
         return;
      }
      $condicion = sanitize_text_field($_POST['condicion']);
      update_post_meta($post_id, '_condicion', $condicion);
   }
   /**
    * 
    * Fin definición post beneficiario 
    * 
    * */
   public function show_beneficiario_meta_fields()
   {
      register_meta(
         'post',
         '_condicion',
         array(
            'type' => 'string',
            'description' => 'condicion',
            'single' => true,
            'show_in_rest' => true
         )
      );
   }
   public function scc_beneficiario_set_pre_get_posts($query)
   {
      if (!is_admin() && is_post_type_archive() && $query->is_main_query()) {
         if (is_post_type_archive('beneficiario')) {
            $query->set('posts_per_page', 20);
            $query->set('orderby', 'post_title');
            $query->set('order', 'ASC');
            if (isset($_GET['comedor_id']) && isset($_GET['condicion']) && isset($_GET['sexo'])) {
               $comedor = sanitize_text_field($_GET['comedor_id']);
               $condicion = sanitize_text_field($_GET['condicion']);
               $sexo = sanitize_text_field($_GET['sexo']);
               $query->set('post_parent', $comedor);
               $meta_query =
                  [
                     [
                        'key' => '_condicion',
                        'value' => $condicion
                     ],
                     [
                        'key' => '_sexo',
                        'value' => $sexo
                     ]
                  ];
            } elseif (isset($_GET['condicion'])) {
               $condicion = sanitize_text_field($_GET['condicion']);
               $meta_query =
                  [
                     [
                        'key' => '_condicion',
                        'value' => $condicion
                     ],
                  ];
            } elseif (isset($_GET['comedor_id'])) {
               $comedor = sanitize_text_field($_GET['comedor_id']);
               $query->set('post_parent', $comedor);
               $meta_query = [];
            } else {
               $meta_query = [];
            }
            $query->set('meta_query', $meta_query);
         }
      }
   }
   private function set_paginas()
   {
      $paginas = [
         'principal' =>
         [
            'slug' => 'beneficiario-principal',
            'titulo' => 'Sistema Comedor_ides'
         ],
         'ninos' =>
         [
            'slug' => 'beneficiario-ninos',
            'titulo' => 'Mantenimiento Niños(as)'
         ],
         'adultos' =>
         [
            'slug' => 'beneficiario-adultos',
            'titulo' => 'Mantenimiento Adultos'
         ],
         'usuario' =>
         [
            'slug' => 'beneficiario-usuario',
            'titulo' => 'Usuarios'
         ],
         'acerca' =>
         [
            'slug' => 'beneficiario-acerca',
            'titulo' => 'Acerca de Nosotros'
         ],
         'graficos' =>
         [
            'slug' => 'beneficiario-graficos',
            'titulo' => 'Información Gráfica'
         ],
         'encargados' =>
         [
            'slug' => 'beneficiario-encargados',
            'titulo' => 'Listado de Encargados'
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
   public function set_roles()
   {
      // remove_role('useradmineventos');
      // remove_role('usercoordinaeventos');

      add_role('comedores', 'Ver Comedores', get_role('subscriber')->capabilities);
      add_role('encargadocomedores', 'Enc. Comedores', get_role('subscriber')->capabilities);
      add_role('useradmincomedores', 'Adm. Comedores', get_role('subscriber')->capabilities);
   }
   public function beneficiario_agregar()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'beneficiarios')) {
         wp_send_json_error('Error de seguridad', 401);
         wp_die();
      } else {
         $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
         $charactersLength = strlen($characters);
         $randomString = '';
         for ($i = 0; $i < 15; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
         }
         $post_name = 'ben_' . $randomString;

         $post_id = sanitize_text_field($_POST['post_id']);

         require_once(ABSPATH . "wp-admin" . '/includes/image.php');
         require_once(ABSPATH . "wp-admin" . '/includes/file.php');
         require_once(ABSPATH . "wp-admin" . '/includes/media.php');
         if (get_post_thumbnail_id($post_id)) {
            delete_post_thumbnail($post_id);
         }
         $attach_id = media_handle_upload('beneficiario_imagen', $post_id);
         if (is_wp_error($attach_id)) {
            $attach_id = '';
         }
         set_post_thumbnail($post_id, $attach_id);
         $nombre = sanitize_text_field($_POST['nombre']);
         $p_apellido = sanitize_text_field($_POST['p_apellido']);
         $s_apellido = sanitize_text_field($_POST['s_apellido']);
         $post_title = $nombre . ' ' . $p_apellido . ' ' . $s_apellido;
         $sexo = sanitize_text_field($_POST['sexo']);
         $condicion = sanitize_text_field($_POST['condicion']);
         $f_nacimiento = sanitize_text_field($_POST['f_nacimiento']);
         $f_ingreso = sanitize_text_field($_POST['f_ingreso']);
         $f_salida = sanitize_text_field($_POST['f_salida']);
         $edad = sanitize_text_field($_POST['edad']);
         $peso = sanitize_text_field($_POST['peso']);
         $estatura = sanitize_text_field($_POST['estatura']);
         $provincia = sanitize_text_field($_POST['provincia']);
         $canton = sanitize_text_field($_POST['canton']);
         $distrito = sanitize_text_field($_POST['distrito']);
         $direccion = sanitize_text_field($_POST['direccion']);
         $email = sanitize_text_field($_POST['email']);
         $t_principal = sanitize_text_field($_POST['t_principal']);
         $t_otros = sanitize_text_field($_POST['t_otros']);
         $n_madre = sanitize_text_field($_POST['n_madre']);
         $n_padre = sanitize_text_field($_POST['n_padre']);
         $post_parent = sanitize_text_field($_POST['post_parent']);
         $post_content = sanitize_textarea_field($_POST['content']);

         $post_data =
            [
               'post_type' => 'beneficiario',
               'post_title' => $post_title,
               'post_name' => $post_name,
               'post_status' => 'publish',
               'post_parent' => $post_parent,
               'post_content' => $post_content,
               'meta_input' =>
               [
                  '_nombre' => $nombre,
                  '_p_apellido' => $p_apellido,
                  '_s_apellido' => $s_apellido,
                  '_sexo' => $sexo,
                  '_condicion' => $condicion,
                  '_f_nacimiento' => $f_nacimiento,
                  '_f_ingreso' => $f_ingreso,
                  '_f_salida' => $f_salida,
                  '_edad' => $edad,
                  '_peso' => $peso,
                  '_estatura' => $estatura,
                  '_provincia' => $provincia,
                  '_canton' => $canton,
                  '_distrito' => $distrito,
                  '_direccion' => $direccion,
                  '_email' => $email,
                  '_t_principal' => $t_principal,
                  '_t_otros' => $t_otros,
                  '_n_madre' => $n_madre,
                  '_n_padre' => $n_padre,
               ]
            ];
         wp_insert_post($post_data);
         wp_send_json_success(['titulo' => 'Ingreso de Beneficiarios(as)', 'msg' => 'La información del Beneficiario(a) se registró correctamente.']);
      }
   }
   public function beneficiario_editar()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'beneficiarios')) {
         wp_send_json_error('Error de seguridad', 401);
         wp_die();
      } else {
         $gestion = sanitize_text_field($_POST['gestion']);

         if ($gestion == 'modificar') {
            $this->beneficiario_modificar();
         }
         if ($gestion == 'eliminar') {
            $this->beneficiario_eliminar();
         }
      }
   }
   private function beneficiario_modificar()
   {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < 15; $i++) {
         $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      $post_name = 'ben_' . $randomString;

      $post_id = sanitize_text_field($_POST['post_id']);

      require_once(ABSPATH . "wp-admin" . '/includes/image.php');
      require_once(ABSPATH . "wp-admin" . '/includes/file.php');
      require_once(ABSPATH . "wp-admin" . '/includes/media.php');
      if (get_post_thumbnail_id($post_id)) {
         delete_post_thumbnail($post_id);
      }
      $attach_id = media_handle_upload('beneficiario_imagen', $post_id);
      if (is_wp_error($attach_id)) {
         $attach_id = '';
      }
      set_post_thumbnail($post_id, $attach_id);
      $nombre = sanitize_text_field($_POST['nombre']);
      $p_apellido = sanitize_text_field($_POST['p_apellido']);
      $s_apellido = sanitize_text_field($_POST['s_apellido']);
      $post_title = $nombre . ' ' . $p_apellido . ' ' . $s_apellido;
      $sexo = sanitize_text_field($_POST['sexo']);
      $condicion = sanitize_text_field($_POST['condicion']);
      $f_nacimiento = sanitize_text_field($_POST['f_nacimiento']);
      $f_ingreso = sanitize_text_field($_POST['f_ingreso']);
      $f_salida = sanitize_text_field($_POST['f_salida']);
      $edad = sanitize_text_field($_POST['edad']);
      $peso = sanitize_text_field($_POST['peso']);
      $estatura = sanitize_text_field($_POST['estatura']);
      $provincia = sanitize_text_field($_POST['provincia']);
      $canton = sanitize_text_field($_POST['canton']);
      $distrito = sanitize_text_field($_POST['distrito']);
      $direccion = sanitize_text_field($_POST['direccion']);
      $email = sanitize_text_field($_POST['email']);
      $t_principal = sanitize_text_field($_POST['t_principal']);
      $t_otros = sanitize_text_field($_POST['t_otros']);
      $n_madre = sanitize_text_field($_POST['n_madre']);
      $n_padre = sanitize_text_field($_POST['n_padre']);
      $post_parent = sanitize_text_field($_POST['post_parent']);
      $post_content = sanitize_textarea_field($_POST['content']);

      $post_data =
         [
            'ID' => $post_id,
            'post_type' => 'beneficiario',
            'post_title' => $post_title,
            'post_name' => $post_name,
            'post_status' => 'publish',
            'post_parent' => $post_parent,
            'post_content' => $post_content,
            'meta_input' =>
            [
               '_nombre' => $nombre,
               '_p_apellido' => $p_apellido,
               '_s_apellido' => $s_apellido,
               '_sexo' => $sexo,
               '_condicion' => $condicion,
               '_f_nacimiento' => $f_nacimiento,
               '_f_ingreso' => $f_ingreso,
               '_f_salida' => $f_salida,
               '_edad' => $edad,
               '_peso' => $peso,
               '_estatura' => $estatura,
               '_provincia' => $provincia,
               '_canton' => $canton,
               '_distrito' => $distrito,
               '_direccion' => $direccion,
               '_email' => $email,
               '_t_principal' => $t_principal,
               '_t_otros' => $t_otros,
               '_n_madre' => $n_madre,
               '_n_padre' => $n_padre,
            ]
         ];
      wp_update_post($post_data);
      wp_send_json_success(['titulo' => 'Actualización', 'msg' => 'Los datos fueron actualizados correctamente.']);
   }
   private function beneficiario_eliminar()
   {
      $post_id = sanitize_text_field($_POST['post_id']);
      wp_trash_post($post_id);
      $asistencia = get_posts(['post_type' => 'asistencia', 'posts_per_page' => -1, 'post_status' => 'publish', 'post_parent' => $post_id]);
      if ($asistencia) {
         foreach ($asistencia as $eliminar) {
            wp_trash_post($eliminar->ID);
         }
      }
      wp_send_json_success(['titulo' => 'Beneficiario Eliminado', 'msg' => 'La información personal y la bitácora de asistencia fue eliminada también.']);
   }
   public function scc_beneficiario_mantener_usuario()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'mantener_usuario')) {
         wp_send_json_error('Error de seguridad', 401);
         wp_die();
      } else {
         $boton = sanitize_text_field($_POST['boton']);
         switch ($boton) {
            case 'validar_usr':
               $user_email = sanitize_text_field($_POST['user_email']);
               $datos = get_user_by('email', $user_email);
               if (empty($datos)) {
                  wp_send_json_success('agregar');
               } else {
                  $datos_usuario['ID'] = $datos->ID;
                  $datos_usuario['first_name'] = $datos->first_name;
                  $datos_usuario['last_name'] = $datos->last_name;
                  $datos_usuario['user_login'] = $datos->user_login;
                  $datos_usuario['user_pass'] = $datos->user_pass;
                  $roles = get_userdata($datos->ID)->roles;
                  if (in_array('useradmincomedores', $roles)) {
                     $datos_usuario['role'] = '3';
                  } elseif (in_array('encargadocomedores', $roles)) {
                     $datos_usuario['role'] = '2';
                  } else {
                     $datos_usuario['role'] = '1';
                  }

                  require_once(ABSPATH . "wp-admin" . '/includes/image.php');
                  require_once(ABSPATH . "wp-admin" . '/includes/file.php');
                  require_once(ABSPATH . "wp-admin" . '/includes/media.php');

                  $attach_id = media_handle_upload('usuario_imagen', 0);
                  if (is_wp_error($attach_id)) {
                     $attach_id = '';
                     if (get_user_meta($datos->ID, 'custom_avatar', true)) {
                        $datos_usuario['avatar'] = wp_get_attachment_url(get_user_meta($datos->ID, 'custom_avatar', true));
                     } else {
                        $datos_usuario['avatar'] = FGHEGC_DIR_URI . '/assets/img/avatar03.png';
                     }
                  } else {
                     update_user_meta($datos->ID, 'custom_avatar', $attach_id);
                     $datos_usuario['avatar'] = wp_get_attachment_url(get_user_meta($datos->ID, 'custom_avatar', true));
                  }
                  wp_send_json_success($datos_usuario);
               }
               break;
            case 'validar_login':
               $user_login = sanitize_text_field($_POST['user_login']);
               $datos = get_user_by('login', $user_login);
               if (empty($datos)) {
                  wp_send_json_success('agregar');
               } else {
                  $datos_usuario['ID'] = $datos->ID;
                  $datos_usuario['user_email'] = $datos->user_email;
                  $datos_usuario['user_login'] = $datos->user_login;
                  wp_send_json_success($datos_usuario);
               }
               break;
            case 'agregar_usuario':
               require_once(ABSPATH . "wp-admin" . '/includes/image.php');
               require_once(ABSPATH . "wp-admin" . '/includes/file.php');
               require_once(ABSPATH . "wp-admin" . '/includes/media.php');

               $attach_id = media_handle_upload('usuario_imagen', 0);
               if (is_wp_error($attach_id)) {
                  $attach_id = '';
               }

               $user_email = sanitize_text_field($_POST['user_email']);
               $first_name = sanitize_text_field($_POST['first_name']);
               $last_name = sanitize_text_field($_POST['last_name']);
               $user_login = sanitize_text_field($_POST['user_login']);
               $user_pass = sanitize_text_field($_POST['user_pass']);
               $user_nicename = $first_name . '-' . $last_name;
               $nombre = $first_name . ' ' . $last_name;
               $userdata = array(
                  'user_pass' => $user_pass,
                  'user_login' => $user_login,
                  'user_nicename' => $user_nicename,
                  'user_email' => $user_email,
                  'display_name' => $nombre,
                  'nickname' => $user_login,
                  'first_name' => $first_name,
                  'last_name' => $last_name,
                  'show_admin_bar_front' => 'false'
               );
               $user_id = wp_insert_user($userdata);
               if (isset($_POST['role'])) {
                  $role = sanitize_text_field($_POST['role']);

                  $sccusuarios = get_userdata($user_id);

                  switch ($role) {
                     case '1':
                        $sccusuarios->remove_role('subscriber');
                        $sccusuarios->add_role('comedores');
                        break;

                     case '2':
                        $sccusuarios->remove_role('subscriber');
                        $sccusuarios->add_role('encargadocomedores');
                        break;

                     case '3':
                        $sccusuarios->remove_role('subscriber');
                        $sccusuarios->add_role('useradmincomedores');
                        break;
                     default:
                        $sccusuarios->remove_role('subscriber');
                        $sccusuarios->add_role('comedores');
                        break;
                  }
               }
               if ($attach_id) {
                  update_user_meta($user_id, 'custom_avatar', $attach_id);
               }
               // add_filter('avatar_defaults', 'wpb_new_gravatar');
               wp_send_json_success('Usuario Registrado');
               break;

            case 'modificar_usuario':
               $user_email = sanitize_text_field($_POST['user_email']);
               $first_name = sanitize_text_field($_POST['first_name']);
               $last_name = sanitize_text_field($_POST['last_name']);
               $user_login = sanitize_text_field($_POST['user_login']);
               $user_pass = sanitize_text_field($_POST['user_pass']);
               $user_nicename = $first_name . '-' . $last_name;
               $nombre = $first_name . ' ' . $last_name;
               $datos = get_user_by('email', $user_email);

               require_once(ABSPATH . "wp-admin" . '/includes/image.php');
               require_once(ABSPATH . "wp-admin" . '/includes/file.php');
               require_once(ABSPATH . "wp-admin" . '/includes/media.php');

               $attach_id = media_handle_upload('usuario_imagen', 0);
               if (is_wp_error($attach_id)) {
                  $attach_id = '';
               } else {
                  update_user_meta($datos->ID, 'custom_avatar', $attach_id);
               }
               $args = [
                  'ID' => $datos->ID,
                  'user_email' => $user_email,
                  'first_name' => $first_name,
                  'last_name' => $last_name,
                  'user_login' => $user_login,
                  'user_pass' => $user_pass,
                  'user_nicename' => $user_nicename,
                  'display_name' => $nombre,

               ];
               wp_update_user($args);

               if (isset($_POST['role'])) {
                  $role = sanitize_text_field($_POST['role']);
                  $sccusuarios = get_userdata($datos->ID);
                  $roles = $sccusuarios->roles;
                  if (in_array('subscriber', $roles)) {
                     $sccusuarios->remove_role('subscriber');
                  }
                  if (in_array('comedores', $roles)) {
                     $sccusuarios->remove_role('comedores');
                  }
                  if (in_array('encargadocomedores', $roles)) {
                     $sccusuarios->remove_role('encargadocomedores');
                  }
                  switch ($role) {
                     case '1':
                        if (in_array('comedores', $roles)) {
                           $sccusuarios->add_role('comedores');
                        }
                        break;

                     case '2':
                        $sccusuarios->add_role('encargadocomedores');
                        break;

                     case '3':
                        $sccusuarios->add_role('useradmincomedores');
                        break;
                     default:
                        $sccusuarios->add_role('subsciber');
                        break;
                  }
               }
               wp_send_json_success(['titulo' => 'Actualización de Usuario', 'msg', 'La información se actualizó exitosamente.']);
               break;
            case 'eliminar':
               $post_id = $_POST['post_id'];
               wp_trash_post($post_id);
               wp_send_json_success('Registro Eliminado');
               break;
         }
         wp_send_json_success(['titulo' => 'Actualización de Usuario', 'msg', 'La información se registró exitosamente.', 'usermeta' => $act]);
      }
   }
   public function scc_beneficiario_agregar_usuario()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'mantener_usuario')) {
         wp_send_json_error('Error de seguridad', 401);
         wp_die();
      } else {
         $user_email = sanitize_text_field($_POST['user_email']);
         $first_name = sanitize_text_field($_POST['first_name']);
         $last_name = sanitize_text_field($_POST['last_name']);
         $user_login = sanitize_text_field($_POST['user_login']);
         $user_pass = sanitize_text_field($_POST['user_pass']);
         $user_nicename = $first_name . '-' . $last_name;
         $nombre = $first_name . ' ' . $last_name;
         $userdata = array(
            'user_pass' => $user_pass,
            'user_login' => $user_login,
            'user_nicename' => $user_nicename,
            'user_email' => $user_email,
            'display_name' => $nombre,
            'nickname' => $user_login,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'show_admin_bar_front' => 'false'
         );
         $user_id = wp_insert_user($userdata);
         if (isset($_POST['role'])) {
            $role = sanitize_text_field($_POST['role']);
            $sccusuarios = new \WP_User($user_id);
            switch ($role) {
               case '1':
                  $sccusuarios->remove_role('subscriber');
                  $sccusuarios->add_role('comedores');
                  break;

               case '2':
                  $sccusuarios->remove_role('subscriber');
                  $sccusuarios->add_role('encargadocomedores');
                  break;

               case '3':
                  $sccusuarios->remove_role('subscriber');
                  $sccusuarios->add_role('useradmincomedores');
                  break;
               default:
                  $sccusuarios->remove_role('subscriber');
                  $sccusuarios->add_role('comedores');
                  break;
            }
         }
         add_filter('avatar_defaults', 'wpb_new_gravatar');
         wp_send_json_success(['titulo' => 'Actualización de Usuario', 'msg', 'La información se registró exitosamente.']);
      }
   }
}
