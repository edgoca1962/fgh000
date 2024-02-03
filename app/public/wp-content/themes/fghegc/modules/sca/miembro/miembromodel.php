<?php

namespace FGHEGC\Modules\Sca\Miembro;

use FGHEGC\modules\core\Singleton;

class MiembroModel
{
   use Singleton;
   private $etiquetas;
   private $capacidades;
   public function __construct()
   {
      add_action('init', [$this, 'set_miembro']);
      add_action('add_meta_boxes', [$this, 'set_campos']);
      add_action('save_post', [$this, 'save_usr_id_miembro']);
      add_action('save_post', [$this, 'save_comite_id_miembro']);
      add_action('save_post', [$this, 'save_puesto_id_miembro']);
      add_action('save_post', [$this, 'save_f_inicio_miembro']);
      add_action('save_post', [$this, 'save_f_final_miembro']);
      add_action('rest_api_init', [$this, 'show_miembro_meta_fields']);
      add_filter('rest_miembro_query', [$this, 'rest_api_consulta_miembros'], 10, 2);
      add_action('wp_ajax_mantener_membresia', [$this, 'mantener_membresia']);
      $this->set_paginas();
   }
   private function set_paginas()
   {
      $miembro = get_posts([
         'post_type' => 'page',
         'post_status' => 'publish',
         'name' => 'miembro-mantener',
      ]);
      if (count($miembro) > 0) {
      } else {
         $post_data = array(
            'post_type' => 'page',
            'post_title' => 'Membresía',
            'post_name' => 'miembro-mantener',
            'post_status' => 'publish',
         );
         wp_insert_post($post_data);
      }
   }
   public function rest_api_consulta_miembros($args, $request)
   {
      if (isset($request['usr_id'])) {
         $mq_usr_id =            [
            'key' => '_usr_id',
            'value' => $request['usr_id']
         ];
      } else {
         $mq_usr_id = [];
      }
      if (isset($rquest['comite_id'])) {
         $mq_comite_id =            [
            'key' => '_comite_id',
            'value' => $request['comite_id']
         ];
      } else {
         $mq_comite_id = [];
      }
      if (isset($request['puesto_id'])) {
         $mq_puesto_id =             [
            'key' => '_puesto_id',
            'value' => $request['puesto_id']
         ];
      } else {
         $mq_puesto_id = [];
      }
      $args += [
         'meta_query' => [
            $mq_usr_id,
            $mq_comite_id,
            $mq_puesto_id
         ]
      ];

      return $args;
   }
   public function set_miembro()
   {
      $type = 'miembro';
      $labels = $this->get_etiquetas('Miembro', 'Miembros');

      $args = array(
         'capability_type' => ['miembro', 'miembros'],
         'map_meta_cap' => true,
         'labels' => $labels,
         'public' => true,
         'has_archive' => true,
         'rewrite' => ['slug' => 'miembros'],
         'show_in_rest' => true,
         'rest_base' => 'miembros',
         'menu_icon' => 'dashicons-book',
         'supports' => array('title', 'custom-fields'),
      );

      register_post_type($type, $args);

      $admin = get_role('administrator');
      $capabilities = $this->get_capacidades('miembro', 'miembros');
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

      $this->etiquetas = [
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
      return $this->etiquetas;
   }
   private function get_capacidades($singular, $plural)
   {
      $this->capacidades = [
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
      return $this->capacidades;
   }
   public function set_campos()
   {
      add_meta_box(
         'usr_id',
         'ID Miembro',
         [$this, 'set_usr_id_miembro_cbk'],
         'miembro',
         'normal',
         'default'
      );
      add_meta_box(
         'comite_id',
         'ID Comité',
         [$this, 'set_comite_id_miembro_cbk'],
         'miembro',
         'normal',
         'default',
         'show_in_rest'
      );
      add_meta_box(
         'puesto_id',
         'ID Puesto',
         [$this, 'set_puesto_id_miembro_cbk'],
         'miembro',
         'normal',
         'default',
         'show_in_rest',
      );
      add_meta_box(
         'f_inicio',
         'Fecha Inicio',
         [$this, 'set_f_inicio_miembro_cbk'],
         'miembro',
         'normal',
         'default',
         'show_in_rest'
      );
      add_meta_box(
         'f_final',
         'Fecha Final',
         [$this, 'set_f_final_miembro_cbk'],
         'miembro',
         'normal',
         'default',
         'show_in_rest',
      );
   }
   public function set_usr_id_miembro_cbk($post)
   {
      wp_nonce_field('usr_id_nonce', 'usr_id_nonce');
      $usr_id = get_post_meta($post->ID, '_usr_id', true);
?>
      <select name="usr_id" id="usr_id" class="form-select" aria-label="Selecionar miembro">
         <option <?= (get_post_meta($post->ID, '_usr_id', true) == '') ? 'value="0" selected' : 'value="0"' ?>>Sin asignar
         </option>
         <?php
         $usuarios = get_users('orderby=nicename');
         foreach ($usuarios as $usuario) {
         ?>
            <option <?= (get_post_meta($post->ID, '_usr_id', true) == $usuario->ID) ? 'value="' . esc_attr($usuario->ID) . '" Selected' : 'value="' . $usuario->ID . '"' ?>><?= $usuario->display_name ?></option>
         <?php
         }
         ?>
      </select>
   <?php
   }
   public function set_comite_id_miembro_cbk($post)
   {
      wp_nonce_field('comite_id_nonce', 'comite_id_nonce');
      $comite_id = get_post_meta($post->ID, '_comite_id', true);
   ?>
      <select name="comite_id" id="comite_id" class="form-select" aria-label="Selecionar miembro">
         <option <?= (get_post_meta($post->ID, '_comite_id', true) == '') ? 'value="0" selected' : 'value="0"' ?>>Sin asignar
         </option>
         <?php
         $comites = get_posts(['post_type' => 'comite', 'posts_per_page' => -1, 'post_status' => 'publish',]);
         foreach ($comites as $comite) {
         ?>
            <option <?php echo (get_post_meta($post->ID, '_comite_id', true) == $comite->ID) ? 'value="' . esc_attr($comite->ID) . '" Selected' : 'value="' . $comite->ID . '"' ?>><?php echo $comite->post_title ?></option>
         <?php
         }
         ?>
      </select>
   <?php
   }
   public function set_puesto_id_miembro_cbk($post)
   {
      wp_nonce_field('puesto_id_nonce', 'puesto_id_nonce');
      $puesto_id = get_post_meta($post->ID, '_puesto_id', true);
   ?>
      <select name="puesto_id" id="puesto_id" class="form-select" aria-label="Selecionar miembro">
         <option <?= (get_post_meta($post->ID, '_puesto_id', true) == '') ? 'value="0" selected' : 'value="0"' ?>>Sin asignar
         </option>
         <?php
         $puestos = get_posts(['post_type' => 'puesto', 'posts_per_page' => -1, 'post_status' => 'publish',]);
         foreach ($puestos as $puesto) {
         ?>
            <option <?php echo (get_post_meta($post->ID, '_puesto_id', true) == $puesto->ID) ? 'value="' . esc_attr($puesto->ID) . '" Selected' : 'value="' . $puesto->ID . '"' ?>><?php echo $puesto->post_title ?></option>
         <?php
         }
         ?>
      </select>
<?php
   }
   public function set_f_inicio_miembro_cbk($post)
   {
      wp_nonce_field('f_inicio_nonce', 'f_inicio_nonce');
      $f_inicio = get_post_meta($post->ID, '_f_inicio', true);
      echo '<input type="date" style="width:20%" id="f_inicio" name="f_inicio" value="' . esc_attr($f_inicio) . '" ></input>';
   }
   public function set_f_final_miembro_cbk($post)
   {
      wp_nonce_field('f_final_nonce', 'f_final_nonce');
      $f_final = get_post_meta($post->ID, '_f_final', true);
      echo '<input type="date" style="width:20%" id="f_final" name="f_final" value="' . esc_attr($f_final) . '" ></input>';
   }
   public function save_usr_id_miembro($post_id)
   {
      if (!isset($_POST['usr_id_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['usr_id_nonce'], 'usr_id_nonce')) {
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
      if (!isset($_POST['usr_id'])) {
         return;
      }
      $usr_id = sanitize_text_field($_POST['usr_id']);
      update_post_meta($post_id, '_usr_id', $usr_id);
   }
   public function save_comite_id_miembro($post_id)
   {
      if (!isset($_POST['comite_id_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['comite_id_nonce'], 'comite_id_nonce')) {
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
      if (!isset($_POST['comite_id'])) {
         return;
      }
      $comite_id = sanitize_text_field($_POST['comite_id']);
      update_post_meta($post_id, '_comite_id', $comite_id);
   }
   public function save_puesto_id_miembro($post_id)
   {
      if (!isset($_POST['puesto_id_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['puesto_id_nonce'], 'puesto_id_nonce')) {
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
      if (!isset($_POST['puesto_id'])) {
         return;
      }
      $puesto_id = sanitize_text_field($_POST['puesto_id']);
      update_post_meta($post_id, '_puesto_id', $puesto_id);
   }
   function save_f_inicio_miembro($post_id)
   {
      if (!isset($_POST['f_inicio_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['f_inicio_nonce'], 'f_inicio_nonce')) {
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
      if (!isset($_POST['f_inicio'])) {
         return;
      }
      $f_inicio = sanitize_text_field($_POST['f_inicio']);
      update_post_meta($post_id, '_f_inicio', $f_inicio);
   }
   function save_f_final_miembro($post_id)
   {
      if (!isset($_POST['f_final_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['f_final_nonce'], 'f_final_nonce')) {
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
      if (!isset($_POST['f_final'])) {
         return;
      }
      $f_final = sanitize_text_field($_POST['f_final']);
      update_post_meta($post_id, '_f_final', $f_final);
   }
   public function show_miembro_meta_fields()
   {
      register_meta('post', '_usr_id', array('type' => 'string', 'description' => 'usr_id', 'single' => true, 'show_in_rest' => true));
      register_meta('post', '_comite_id', array('type' => 'string', 'description' => 'comite_id', 'single' => true, 'show_in_rest' => true));
      register_meta('post', '_puesto_id', array('type' => 'string', 'description' => 'puesto_id', 'single' => true, 'show_in_rest' => true));
      register_meta('post', '_f_inicio', array('type' => 'string', 'description' => 'f_inicio', 'single' => true, 'show_in_rest' => true));
      register_meta('post', '_f_final', array('type' => 'string', 'description' => 'f_final', 'single' => true, 'show_in_rest' => true));
   }
   public function mantener_membresia()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'mantener_membresia')) {
         wp_send_json_error('Error de seguridad', 401);
         wp_die();
      } else {
         $boton = sanitize_text_field($_POST['boton']);
         switch ($boton) {
            case 'duplicados':
               $usr_id = sanitize_text_field($_POST['usr_id']);
               $comite_id = sanitize_text_field($_POST['comite_id']);
               $duplicados = get_posts(
                  [
                     'post_type' => 'miembro',
                     'post_status' => 'publish',
                     'meta_query' => [
                        [
                           'key' => '_usr_id',
                           'value' => $usr_id
                        ],
                        [
                           'key' => '_comite_id',
                           'value' => $comite_id
                        ]
                     ]
                  ]
               );
               if (count($duplicados)) {
                  foreach ($duplicados as $duplicado) {
                     $datos_miembro['ID'] = $duplicado->ID;
                     $datos_miembro['puesto_id'] = get_post_meta($duplicado->ID, '_puesto_id', true);
                     $datos_miembro['f_inicio'] = get_post_meta($duplicado->ID, '_f_inicio', true);
                     $datos_miembro['f_final'] = get_post_meta($duplicado->ID, '_f_final', true);
                  }
                  wp_send_json_success($datos_miembro);
               } else {
                  wp_send_json_success('agregar');
               }
               break;
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
            case 'agregar_miembro':
               $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
               $charactersLength = strlen($characters);
               $randomString = '';
               for ($i = 0; $i < 15; $i++) {
                  $randomString .= $characters[rand(0, $charactersLength - 1)];
               }
               $post_name = 'mid_' . $randomString;
               //Registro del post en la base de datos. 
               $usr_id = sanitize_text_field($_POST['usr_id']);
               $nombre = get_userdata($usr_id)->display_name;
               $comite_id = sanitize_text_field($_POST['comite_id']);
               $puesto_id = sanitize_text_field($_POST['puesto_id']);
               $title = $nombre . ' - ' . get_post($comite_id)->post_title . ' - ' . get_post($puesto_id)->post_title;
               $f_inicio = sanitize_textarea_field($_POST['f_inicio']);
               $f_final = sanitize_textarea_field($_POST['f_final']);

               $post_data = array(
                  'post_type' => 'miembro',
                  'post_title' => $title,
                  'post_name' => $post_name,
                  'post_status' => 'publish',
                  'meta_input' => array(
                     '_usr_id' => $usr_id,
                     '_comite_id' => $comite_id,
                     '_puesto_id' => $puesto_id,
                     '_f_inicio' => $f_inicio,
                     '_f_final' => $f_final,
                  )
               );
               wp_insert_post($post_data);
               wp_send_json_success('Miembro Registrado');
               break;
            case 'agregar_puesto':
               $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
               $charactersLength = strlen($characters);
               $randomString = '';
               for ($i = 0; $i < 15; $i++) {
                  $randomString .= $characters[rand(0, $charactersLength - 1)];
               }
               $post_name = 'pid_' . $randomString;
               $title = sanitize_text_field($_POST['nombrePuesto']);
               $post_data = array(
                  'post_type' => 'puesto',
                  'post_title' => $title,
                  'post_name' => $post_name,
                  'post_status' => 'publish',
               );
               wp_insert_post($post_data);
               wp_send_json_success('Puesto Registrado');
               break;
            case 'agregar_usuario':
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
               if (isset($_POST['scaadmin'])) {
                  $scaadmin = new \WP_User($user_id);
                  $scaadmin->remove_role('subscriber');
                  $scaadmin->add_role('useradmingeneral');
               }
               wp_send_json_success('Usuario Registrado');
               break;
            case 'modificar_miembro':
               $post_id = $_POST['post_id'];
               $usr_id = $_POST['usr_id'];
               $comite_id = $_POST['comite_id'];
               $puesto_id = $_POST['puesto_id'];
               $f_inicio = $_POST['f_inicio'];
               $f_final = $_POST['f_final'];
               $nombre = get_user_by('ID', $usr_id)->display_name;
               $comite = get_post($comite_id)->post_title;
               $puesto = get_post($puesto_id)->post_title;
               $title = $nombre . ' - ' . $comite . ' - ' . $puesto;

               $args = [
                  'ID' => $post_id,
                  'post_title' => $title,
                  'meta_input' =>
                  [
                     '_usr_id' => $usr_id,
                     '_comite_id' => $comite_id,
                     '_puesto_id' => $puesto_id,
                     '_f_inicio' => $f_inicio,
                     '_f_final' => $f_final,
                  ]
               ];

               wp_update_post($args);
               wp_send_json_success($args);
               break;
            case 'modificar_usuario':
               $user_email = sanitize_text_field($_POST['user_email']);
               $first_name = sanitize_text_field($_POST['first_name']);
               $last_name = sanitize_text_field($_POST['last_name']);
               $user_login = sanitize_text_field($_POST['user_login']);
               $user_pass = sanitize_text_field($_POST['user_pass']);
               $user_nicename = $first_name . '-' . $last_name;
               $nombre = $first_name . ' ' . $last_name;

               $args = [
                  'user_email' => $user_email,
                  'first_name' => $first_name,
                  'last_name' => $last_name,
                  'user_login' => $user_login,
                  'user_pass' => $user_pass,
                  'user_nicename' => $user_nicename,
                  'display_name' => $nombre,

               ];
               wp_insert_user($args);
               wp_send_json_success('Usuario Modificado');
               break;
            case 'modificar_puesto':
               $post_id = $_POST['post_id'];
               $title = $_POST['nombrePuesto'];

               $args = [
                  'ID' => $post_id,
                  'title' => $title,
               ];
               wp_update_post($args);
               wp_send_json_success('Puesto Modificado');
               break;
            case 'eliminar':
               $post_id = $_POST['post_id'];
               wp_trash_post($post_id);
               wp_send_json_success('Registro Eliminado');
               break;
         }
         die();
      }
   }
}
