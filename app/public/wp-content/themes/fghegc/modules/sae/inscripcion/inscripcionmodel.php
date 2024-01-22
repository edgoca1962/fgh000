<?php

namespace FGHEGC\Modules\Sae\Inscripcion;

use FGHEGC\Modules\Core\Singleton;

class InscripcionModel
{
   use Singleton;

   public function __construct()
   {
      add_action('init', [$this, 'set_inscripcion']);
      add_action('add_meta_boxes', [$this, 'set_campos']);
      add_action('save_post', [$this, 'fghmvc_guardar_email']);
      add_action('save_post', [$this, 'fghmvc_guardar_celular']);
      add_action('save_post', [$this, 'fghmvc_guardar_f_pago_inscripcion']);
      add_action('save_post', [$this, 'fghmvc_guardar_n_referencia']);
      add_action('save_post', [$this, 'fghmvc_guardar_monto_pago_inscripcion']);
      add_action('pre_get_posts', [$this, 'fghmvc_pre_get_posts_inscripcion']);
      add_action('wp_ajax_registrar_inscripcion', [$this, 'fghmvc_registrar_inscripcion']);
      add_action('wp_ajax_inscripciones_csvfile', [$this, 'fghmvc_inscripciones_csvfile']);
      $this->set_paginas();
   }
   public function set_inscripcion()
   {
      $type = 'inscripcion';
      $labels = $this->get_etiquetas('Inscripción', 'Inscripciones');

      $args = array(
         'capability_type' => ['inscripcion', 'inscripciones'],
         'map_meta_cap' => true,
         'labels' => $labels,
         'public' => true,
         'has_archive' => true,
         'rewrite' => ['slug' => 'inscripciones'],
         'show_in_rest' => true,
         'rest_base' => 'inscripciones',
         'menu_icon' => 'dashicons-book',
         'supports' => array('title', 'editor', 'custom-fields', 'thumbnail'),
         // 'taxonomies' => ['category', 'post_tag'],
      );

      register_post_type($type, $args);

      $admin = get_role('administrator');
      $capabilities = $this->get_capacidades('inscripcion', 'inscripciones');
      foreach ($capabilities as $capability) {
         if (!$admin->has_cap($capability)) {
            $admin->add_cap($capability);
         }
      }
   }
   public function limpiar_inscripcion()
   {
      $args = [
         'post_type' => 'inscripcion',
         'posts_per_page' => -1,
      ];
      $inscripciones = get_posts($args);
      foreach ($inscripciones as $inscripcion) {
         $ffinal = get_post_meta($inscripcion->post_parent, '_f_final', true);
         if ($ffinal != '') {
            if (date('Y-m-d') > date('Y-m-d', strtotime('+2 month', strtotime($ffinal)))) {
               if (get_post_meta($inscripcion->post_parent, '_inscripcion', true) == 'on') {
                  if (get_post_meta($inscripcion->post_parent, '_donativo', true) == 'on') {
                     wp_delete_post($inscripcion->ID, true);
                     wp_delete_post(get_post_meta($inscripcion->ID, '_thumbnail_id', true), true);
                  } else {
                     wp_delete_post($inscripcion->ID, true);
                  }
               }
            }
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
         'add_new' => _x("Nueva $singular", 'prayer', 'fghmvc'),
         'add_new_item' => __("Agregar $singular", 'fghmvc'),
         'new_item' => __("Nueva $singular", 'fghmvc'),
         'edit_item' => __("Editar $singular", 'fghmvc'),
         'view_item' => __("Ver $singular", 'fghmvc'),
         'view_items' => __("Ver $plural", 'fghmvc'),
         'all_items' => __("Todas las $plural", 'fghmvc'),
         'search_items' => __("Buscar $plural", 'fghmvc'),
         'parent_item_colon' => __("$singular padre", 'fghmvc'),
         'not_found' => __("No hay $p_lower", 'fghmvc'),
         'not_found_in_trash' => __("No hay $p_lower borradas", 'fghmvc'),
         'archives' => __("$singular achivada", 'fghmvc'),
         'attributes' => __("Atributos de la $singular", 'fghmvc'),
         'insert_into_item' => __("Insertar $s_lower", 'fghmvc'),
         'uploaded_to_this_item' => __("Adjuntar a una $s_lower", 'fghmvc'),
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
         'email',
         'Correo Electrónico',
         [$this, 'fghmvc_crear_email_cbk'],
         'inscripcion',
         'normal',
         'default'
      );
      add_meta_box(
         'celular',
         'Celular',
         [$this, 'fghmvc_crear_celular_cbk'],
         'inscripcion',
         'normal',
         'default'
      );
      add_meta_box(
         'f_pago_inscripcion',
         'Fecha Pago',
         [$this, 'fghmvc_crear_f_pago_inscripcion_cbk'],
         'inscripcion',
         'normal',
         'default'
      );
      add_meta_box(
         'n_referencia',
         'Referencia',
         [$this, 'fghmvc_crear_n_referencia_cbk'],
         'inscripcion',
         'normal',
         'default'
      );
      add_meta_box(
         'monto_pago',
         'Monto Pago',
         [$this, 'fghmvc_crear_monto_pago_inscripcion_cbk'],
         'inscripcion',
         'normal',
         'default'
      );
   }
   public function fghmvc_crear_email_cbk($post)
   {
      wp_nonce_field('email_nonce', 'email_nonce');
      $email = get_post_meta($post->ID, '_email_inscripcion', true);
      echo '<input type="email" style="width:20%" id="email" name="email" value="' . esc_attr($email) . '" >';
   }
   public function fghmvc_crear_celular_cbk($post)
   {
      wp_nonce_field('celular_nonce', 'celular_nonce');
      $celular = get_post_meta($post->ID, '_celular_inscripcion', true);
      echo '<input type="text" style="width:20%" id="celular" name="celular" value="' . esc_attr($celular) . '" >';
   }
   public function fghmvc_crear_f_pago_inscripcion_cbk($post)
   {
      wp_nonce_field('f_pago_inscripcion_nonce', 'f_pago_inscripcion_nonce');
      $f_pago = get_post_meta($post->ID, '_f_pago_inscripcion', true);
      echo '<input type="date" style="width:20%" id="f_pago_inscripcion" name="f_pago_inscripcion" value="' . esc_attr($f_pago) . '" >';
   }
   public function fghmvc_crear_n_referencia_cbk($post)
   {
      wp_nonce_field('n_referencia_nonce', 'n_referencia_nonce');
      $n_referencia = get_post_meta($post->ID, '_n_referencia', true);
      echo '<input type="text" style="width:20%" id="n_referencia" name="n_referencia" value="' . esc_attr($n_referencia) . '" >';
   }
   public function fghmvc_crear_monto_pago_inscripcion_cbk($post)
   {
      wp_nonce_field('monto_pago_inscripcion_nonce', 'monto_pago_inscripcion_nonce');
      $monto_pago_inscripcion = get_post_meta($post->ID, '_monto_pago_inscripcion', true);
      echo '<input type="numeric" style="width:20%" id="monto_pago_inscripcion" name="monto_pago_inscripcion" value="' . esc_attr($monto_pago_inscripcion) . '" >';
   }
   public function fghmvc_guardar_email($post_id)
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
      update_post_meta($post_id, '_email_inscripcion', $email);
   }
   public function fghmvc_guardar_celular($post_id)
   {
      if (!isset($_POST['celular_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['celular_nonce'], 'celular_nonce')) {
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
      if (!isset($_POST['celular'])) {
         return;
      }
      $celular = sanitize_text_field($_POST['celular']);
      update_post_meta($post_id, '_celular_inscripcion', $celular);
   }
   public function fghmvc_guardar_f_pago_inscripcion($post_id)
   {
      if (!isset($_POST['f_pago_inscripcion_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['f_pago_inscripcion_nonce'], 'f_pago_inscripcion_nonce')) {
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
      if (!isset($_POST['f_pago_inscripcion'])) {
         return;
      }
      $f_pago_inscripcion = sanitize_text_field($_POST['f_pago_inscripcion']);
      update_post_meta($post_id, '_f_pago_inscripcion', $f_pago_inscripcion);
   }
   public function fghmvc_guardar_n_referencia($post_id)
   {
      if (!isset($_POST['n_referencia_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['n_referencia_nonce'], 'n_referencia_nonce')) {
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
      if (!isset($_POST['n_referencia'])) {
         return;
      }
      $n_referencia = sanitize_text_field($_POST['n_referencia']);
      update_post_meta($post_id, '_n_referencia', $n_referencia);
   }
   public function fghmvc_guardar_monto_pago_inscripcion($post_id)
   {
      if (!isset($_POST['monto_pago_inscripcion_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['monto_pago_inscripcion_nonce'], 'monto_pago_inscripcion_nonce')) {
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
      if (!isset($_POST['monto_pago_inscripcion'])) {
         return;
      }
      $monto_pago_inscripcion = sanitize_text_field($_POST['monto_pago_inscripcion']);
      update_post_meta($post_id, '_monto_pago_inscripcion', $monto_pago_inscripcion);
   }
   public function fghmvc_registrar_inscripcion()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'inscribir')) {
         wp_send_json_error('Error de seguridad', 401);
         wp_die();
      } else {
         require_once(ABSPATH . "wp-admin" . '/includes/image.php');
         require_once(ABSPATH . "wp-admin" . '/includes/file.php');
         require_once(ABSPATH . "wp-admin" . '/includes/media.php');

         $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
         $charactersLength = strlen($characters);
         $randomString = '';
         for ($i = 0; $i < 15; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
         }
         $post_name = 'ins_' . $randomString;
         $email = sanitize_text_field($_POST['email']);
         $celular = sanitize_text_field($_POST['celular']);
         $post_parent = sanitize_text_field($_POST['post_parent']);
         $evento_name = get_post($post_parent)->post_title;
         $title = $evento_name . ' ' . $email . ' ' . $celular;
         $post_content = sanitize_textarea_field($_POST['content_inscripcion']);
         if (isset($_POST['f_pago_inscripcion'])) {
            $f_pago_inscripcion = sanitize_text_field($_POST['f_pago_inscripcion']);
            $n_referencia = sanitize_text_field($_POST['n_referencia']);
            $monto_pago_inscripcion = sanitize_text_field($_POST['monto_pago_inscripcion']);
         } else {
            $f_pago_inscripcion = '';
            $n_referencia = '';
            $monto_pago_inscripcion = '';
         }
         $enviado_por = sanitize_textarea_field($_POST['enviado_por']);
         $con_copia_nombre = sanitize_textarea_field($_POST['con_copia_nombre']);
         $titulo = get_post($post_parent)->post_title;
         $enlace = get_the_permalink($post_paretn);
         $q_inscritos = sanitize_text_field($_POST['q_inscripciones']);
         $q_inscripciones = get_post_meta($post_parent, '_q_inscripciones', true);
         $q_inscripciones = intval($q_inscripciones) + intval($q_inscritos);
         update_post_meta($post_parent, '_q_inscripciones', $q_inscripciones);
         $attach_id = media_handle_upload('comprobante_pago', '');
         if (is_wp_error($attach_id)) {
            $attach_id = '';
         }
         $post_data = array(
            'post_type' => 'inscripcion',
            'post_title' => $title,
            'post_content' => $post_content,
            'post_name' => $post_name,
            'post_parent' => $post_parent,
            'post_status' => 'publish',
            'meta_input' => array(
               '_celular_inscripcion' => $celular,
               '_email_inscripcion' => $email,
               '_f_pago_inscripcion' => $f_pago_inscripcion,
               '_n_referencia' => $n_referencia,
               '_monto_pago_inscripcion' => $monto_pago_inscripcion,
               '_thumbnail_id' => $attach_id
            )
         );
         wp_insert_post($post_data);
         $confirmacion = $this->fghmvc_inscripcion_email($email, $enviado_por, $con_copia_nombre, $titulo, $enlace, $post_content);
         if ($confirmacion) {
            wp_send_json_success(['titulo' => '¡Bendiciones!', 'msg' => 'La inscripción ha sido registrada. Gracias.']);
         } else {
            wp_send_json_error(['titulo' => '¡Error!', 'msg' => 'Error en el proceso de la inscripción.']);
         }
         wp_die();
      }
   }
   public function fghmvc_pre_get_posts_inscripcion($query)
   {
      if ($query->is_main_query() && !is_admin()) {
         if (is_post_type_archive('inscripcion')) {
            if (isset($_GET['pid'])) {
               $post_parent = sanitize_text_field($_GET['pid']);
               $query->set('post_status', ['publish', 'private']);
               $query->set('posts_per_page', 10);
               $query->set('post_parent', $post_parent);
            }
         }
      }
   }
   private function set_paginas()
   {
      $paginas = [
         'principal' =>
         [
            'slug' => 'inscripcion-tablero',
            'titulo' => 'Inscripciones'
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
   private function fghmvc_inscripcion_email($enviar_a, $from_email, $con_copia_nombre, $titulo, $enlace, $post_content)
   {
      $contenido = wpautop($post_content);
      $send_to = $enviar_a;
      $subject = "Confirmación de Inscripción al evento: $titulo";

      $mensaje = '';
      $mensaje .= 'Bendiciones, <br><br>';
      $mensaje .= 'Confirmamos la inscripción al evento cuyo detalle puede consultarse en el siguiente enlace: ' . '<a href="' . $enlace . '">' . $titulo . '</a><br><br>';
      $mensaje .= 'Participantes confirmados: <br><br>';
      $mensaje .= $contenido . '<br><br>';
      $mensaje .= 'Gracias por su valiosa colaboración y apoyo en este evento. <br><br>';
      $mensaje .= 'Un caluroso abrazo.';

      $headers[] = 'Content-Type: text/html; charset=UTF-8';
      $headers[] = "From: Administración de Eventos <admin@email.com>";
      $headers[] = "Cc: $con_copia_nombre <$from_email>";
      $headers[] = $from_email;

      if (wp_mail($send_to, $subject, $mensaje, $headers)) {
         return true;
      } else {
         return false;
      }
   }
   public function fghmvc_inscripciones_csvfile()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'csvfile')) {
         wp_send_json_error('Error de seguridad', 401);
         wp_die();
      } else {

         $post_parent = sanitize_text_field($_POST['post_parent']);
         $args = array(
            'post_type' => 'inscripcion',
            'post_parent' => $post_parent,
            'posts_per_page' => -1,
         );
         $inscripciones = get_posts($args);

         if ($inscripciones) {
            $csvfile = [];
            $linea = [];
            foreach ($inscripciones as $inscripcion) {
               $linea['f_pago'] = get_post_meta($inscripcion->ID, '_f_pago_inscripcion', true);
               $linea['n_referencia'] = get_post_meta($inscripcion->ID, '_n_referencia', true);
               $linea['monto'] = get_post_meta($inscripcion->ID, '_monto_pago_inscripcion', true);
               array_push($csvfile, $linea);
            }
            wp_send_json_success(['titulo' => 'Inscripciones', 'msg' => 'Inscripciones extraídas exitosamente.', 'inscripciones' => $csvfile]);
            wp_die();
         }
      }
   }
}
