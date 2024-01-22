<?php

/**
 * Crea post Acuerdo
 * 
 * @package FGHEGC
 */

namespace FGHEGC\Modules\Sca\Acuerdo;

use FGHEGC\modules\core\Singleton;

class AcuerdoModel
{
   use Singleton;
   private $funcionesAcuerdo;

   public function __construct()
   {
      $this->funcionesAcuerdo = AcuerdoController::get_instance();
      add_action('init', [$this, 'set_acuerdo']);
      add_action('add_meta_boxes', [$this, 'set_campos']);
      add_action('save_post', [$this, 'save_asignar_id']);
      add_action('save_post', [$this, 'save_acta_id']);
      add_action('save_post', [$this, 'save_comite_id']);
      add_action('save_post', [$this, 'save_n_acuerdo']);
      add_action('save_post', [$this, 'save_vigente']);
      add_action('save_post', [$this, 'save_f_compromiso']);
      add_action('save_post', [$this, 'save_f_seguimiento']);
      add_action('rest_api_init', [$this, 'show_acuerdo_meta_fields']);
      add_action('pre_get_posts', [$this, 'acuerdo_pre_get_posts']);
      add_action('wp_ajax_agregar_acuerdo', [$this, 'sca_registrar_acuerdo']);
      add_action('wp_ajax_editar_acuerdo', [$this, 'sca_editar_acuerdo']);
      add_action('wp_ajax_eliminar_acuerdo', [$this, 'sca_eliminar_acuerdo']);
      // add_filter('rest_acuerdo_query', [$this, 'acuerdo_meta_request_params'], 99, 2);
      $this->set_paginas();
   }
   public function set_acuerdo()
   {
      $type = 'acuerdo';
      $labels = $this->get_etiquetas('Acuerdo', 'Acuerdos');

      $args = array(
         'capability_type' => ['acuerdo', 'acuerdos'],
         'map_meta_cap' => true,
         'labels' => $labels,
         'public' => true,
         'has_archive' => true,
         'rewrite' => ['slug' => 'acuerdos'],
         'show_in_rest' => true,
         'rest_base' => 'acuerdos',
         'menu_icon' => 'dashicons-book',
         'supports' => array('title', 'editor', 'custom-fields', 'comments'),
         // 'taxonomies'               => ['category', 'post_tag'],
      );

      register_post_type($type, $args);

      $admin = get_role('administrator');
      $capabilities = $this->get_capacidades('acuerdo', 'acuerdos');
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
         'archives' => __("$singular achivado", 'fghmvc'),
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
   public function set_campos()
   {
      add_meta_box(
         'asignar_id',
         'ID Asignado',
         [$this, 'set_asignar_id_cbk'],
         'acuerdo',
         'normal',
         'default'
      );
      add_meta_box(
         'acta_id',
         'ID Acta',
         [$this, 'set_acta_id_cbk'],
         'acuerdo',
         'normal',
         'default'
      );
      add_meta_box(
         'comite_id',
         'ID Comité',
         [$this, 'set_comite_id_cbk'],
         'acuerdo',
         'normal',
         'default'
      );
      add_meta_box(
         'n_acuerdo',
         'Nùmero de Acuerdo',
         [$this, 'set_n_acuerdo_cbk'],
         'acuerdo',
         'normal',
         'default'
      );
      add_meta_box(
         'vigente',
         'Acuerdo Vigente',
         [$this, 'set_vigente_cbk'],
         'acuerdo',
         'normal',
         'default'
      );
      add_meta_box(
         'f_compromiso',
         'Fecha de Compromiso',
         [$this, 'set_f_compromiso_cbk'],
         'acuerdo',
         'normal',
         'default'
      );
      add_meta_box(
         'f_seguimiento',
         'Fecha Seguimiento',
         [$this, 'set_f_seguimiento_cbk'],
         'acuerdo',
         'normal',
         'default'
      );
   }
   public function set_asignar_id_cbk($post)
   {
      wp_nonce_field('asignar_id_nonce', 'asignar_id_nonce');
      $asignar_id = get_post_meta($post->ID, '_asignar_id', true);
?>
      <select name="asignar_id" id="asignar_id" class="form-select" aria-label="Selecionar miembro">
         <option <?= (get_post_meta($post->ID, '_asignar_id', true) == '') ? 'value="0" selected' : 'value="0"' ?>>Sin asignar
         </option>
         <?php
         $usuarios = get_users('orderby=nicename');
         foreach ($usuarios as $usuario) {
         ?>
            <option <?= (get_post_meta($post->ID, '_asignar_id', true) == $usuario->ID) ? 'value="' . esc_attr($usuario->ID) . '" Selected' : 'value="' . $usuario->ID . '"' ?>><?= $usuario->display_name ?></option>
         <?php
         }
         ?>
      </select>
<?php
   }
   public function set_acta_id_cbk($post)
   {
      wp_nonce_field('acta_id_nonce', 'acta_id_nonce');
      $acta_id = get_post_meta($post->ID, '_acta_id', true);
      echo '<input type="text" style="width:20%" id="acta_id" name="acta_id" value="' . esc_attr($acta_id) . '" </input>';
   }
   public function set_comite_id_cbk($post)
   {
      wp_nonce_field('comite_id_nonce', 'comite_id_nonce');
      $comite_id = get_post_meta($post->ID, '_comite_id', true);
      echo '<input type="text" style="width:20%" id="comite_id" name="comite_id" value="' . esc_attr($comite_id) . '" </input>';
   }
   public function set_n_acuerdo_cbk($post)
   {
      wp_nonce_field('n_acuerdo_nonce', 'n_acuerdo_nonce');
      $n_acuerdo = get_post_meta($post->ID, '_n_acuerdo', true);
      echo '<input type="text" style="width:20%" id="n_acuerdo" name="n_acuerdo" value="' . esc_attr($n_acuerdo) . '" </input>';
   }
   function set_vigente_cbk($post)
   {
      wp_nonce_field('vigente_nonce', 'vigente_nonce');
      $vigente = get_post_meta($post->ID, '_vigente', true);
      echo '<input type="text" style="width:5%" id="vigente" name="vigente" value="' . esc_attr($vigente) . '" > (on = Si | vacío = No)';
   }
   public function set_f_compromiso_cbk($post)
   {
      wp_nonce_field('f_compromiso_nonce', 'f_compromiso_nonce');
      $f_compromiso = get_post_meta($post->ID, '_f_compromiso', true);
      echo '<input type="date" style="width:20%" id="f_compromiso" name="f_compromiso" value="' . esc_attr($f_compromiso) . '" >';
   }
   public function set_f_seguimiento_cbk($post)
   {
      wp_nonce_field('f_seguimiento_nonce', 'f_seguimiento_nonce');
      $f_seguimiento = get_post_meta($post->ID, '_f_seguimiento', true);
      echo '<input type="date" style="width:20%" id="f_seguimiento" name="f_seguimiento" value="' . esc_attr($f_seguimiento) . '" >';
   }
   public function save_asignar_id($post_id)
   {
      if (!isset($_POST['asignar_id_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['asignar_id_nonce'], 'asignar_id_nonce')) {
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
      if (!isset($_POST['asignar_id'])) {
         return;
      }
      $asignar_id = sanitize_text_field($_POST['asignar_id']);
      update_post_meta($post_id, '_asignar_id', $asignar_id);
   }
   public function save_acta_id($post_id)
   {
      if (!isset($_POST['acta_id_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['acta_id_nonce'], 'acta_id_nonce')) {
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
      if (!isset($_POST['acta_id'])) {
         return;
      }
      $acta_id = sanitize_text_field($_POST['acta_id']);
      update_post_meta($post_id, '_acta_id', $acta_id);
   }
   public function save_comite_id($post_id)
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
   public function save_n_acuerdo($post_id)
   {
      if (!isset($_POST['n_acuerdo_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['n_acuerdo_nonce'], 'n_acuerdo_nonce')) {
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
      if (!isset($_POST['n_acuerdo'])) {
         return;
      }
      $n_acuerdo = sanitize_text_field($_POST['n_acuerdo']);
      update_post_meta($post_id, '_n_acuerdo', $n_acuerdo);
   }
   public function save_vigente($post_id)
   {
      if (!isset($_POST['vigente_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['vigente_nonce'], 'vigente_nonce')) {
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
      if (!isset($_POST['vigente'])) {
         return;
      }
      $vigente = sanitize_text_field($_POST['vigente']);
      update_post_meta($post_id, '_vigente', $vigente);
   }
   public function save_f_compromiso($post_id)
   {
      if (!isset($_POST['f_compromiso_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['f_compromiso_nonce'], 'f_compromiso_nonce')) {
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
      if (!isset($_POST['f_compromiso'])) {
         return;
      }
      $f_compromiso = sanitize_text_field($_POST['f_compromiso']);
      update_post_meta($post_id, '_f_compromiso', $f_compromiso);
   }
   public function save_f_seguimiento($post_id)
   {
      if (!isset($_POST['f_seguimiento_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['f_seguimiento_nonce'], 'f_seguimiento_nonce')) {
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
      if (!isset($_POST['f_seguimiento'])) {
         return;
      }
      $f_seguimiento = date('Y-m-d');
      update_post_meta($post_id, '_f_seguimiento', $f_seguimiento);
   }
   public function show_acuerdo_meta_fields()
   {
      register_meta(
         'post',
         '_asignar_id',
         array(
            'type' => 'string',
            'description' => 'asignado',
            'single' => true,
            'show_in_rest' => true
         )
      );

      register_meta(
         'post',
         '_comite_id',
         array(
            'type' => 'string',
            'description' => 'comite',
            'single' => true,
            'show_in_rest' => true
         )
      );

      register_meta(
         'post',
         '_acta_id',
         array(
            'type' => 'string',
            'description' => 'acta',
            'single' => true,
            'show_in_rest' => true
         )
      );
      register_meta(
         'post',
         '_n_acuerdo',
         array(
            'type' => 'string',
            'description' => 'n_acuerdo',
            'single' => true,
            'show_in_rest' => true
         )
      );
      register_meta(
         'post',
         '_f_compromiso',
         array(
            'type' => 'string',
            'description' => 'f_compromiso',
            'single' => true,
            'show_in_rest' => true
         )
      );
      register_meta(
         'post',
         '_vigente',
         array(
            'type' => 'string',
            'description' => 'vigente',
            'single' => true,
            'show_in_rest' => true
         )
      );
      register_meta(
         'post',
         '_f_seguimiento',
         array(
            'type' => 'string',
            'description' => 'f_seguimiento',
            'single' => true,
            'show_in_rest' => true
         )
      );
   }
   public function acuerdo_meta_request_params($args, $request)
   {
      $args += array(
         'meta_key' => $request['meta_key'],
         'meta_value' => $request['meta_value'],
         'meta_query' => $request['meta_query'],
      );
      return $args;
   }
   private function set_roles()
   {
      // remove_role('useradminacuerdos');
      add_role('useradminacuerdos', 'Administrador(a) Acuerdos', get_role('subscriber')->capabilities);
   }
   public function acuerdo_pre_get_posts($query)
   {
      if ($query->is_main_query() && !is_admin()) {

         if (is_post_type_archive('acuerdo')) {

            $query->set('meta_key', '_n_acuerdo');
            $query->set('orderby', 'meta_value_num');
            $query->set('order', 'DESC');

            $roles = wp_get_current_user()->roles;
            if (in_array('administrator', $roles) || in_array('useradmingeneral', $roles)) {
               $userAdmin = true;
            } else {
               $userAdmin = false;
            }

            if (isset($_GET['comite_id']) && $_GET['comite_id'] != '') {
               $comite_id = intval(sanitize_text_field($_GET['comite_id']));
               $comite_id_mq =
                  [
                     'key' => '_comite_id',
                     'value' => $comite_id
                  ];
            } else {
               $comite_id_mq =
                  [
                     'key' => '_comite_id',
                     'value' => '',
                     'compare' => '!='
                  ];
            }

            if (isset($_GET['acta_id']) && $_GET['acta_id'] != '') {
               $acta_id = intval(sanitize_text_field($_GET['acta_id']));
               $acta_id_mq =
                  [
                     'key' => '_acta_id',
                     'value' => $acta_id
                  ];
            } else {
               $acta_id_mq =
                  [
                     'key' => '_acta_id',
                     'value' => '',
                     'compare' => '!='
                  ];
            }

            if (isset($_GET['asignar_id']) && $_GET['asignar_id'] != '') {
               $asignar_id = sanitize_text_field($_GET['asignar_id']);
               if ($asignar_id == wp_get_current_user()->ID) {
                  if (isset($_GET['comite_id']) && $_GET['comite_id'] != '') {
                     $comite_id = sanitize_text_field($_GET['comite_id']);
                     if ($comite_id != '') {
                        if ($this->funcionesAcuerdo->get_verAcuerdos()[$comite_id] == 'asignados') {
                           $asignar_id_mq =
                              [
                                 'key' => '_asignar_id',
                                 'value' => $asignar_id
                              ];
                        } else {
                           $asignar_id_mq =
                              [
                                 'key' => '_asignar_id',
                                 'value' => '',
                                 'compare' => '!='
                              ];
                        }
                     } else {
                        $asignar_id_mq =
                           [
                              'key' => '_asignar_id',
                              'value' => $asignar_id
                           ];
                     }
                  } else {
                     $asignar_id_mq =
                        [
                           'key' => '_asignar_id',
                           'value' => wp_get_current_user()->ID
                        ];
                  }
               } else {
                  if ($this->funcionesAcuerdo->get_miembroJunta() || $userAdmin) {
                     $asignar_id_mq =
                        [
                           'key' => '_asignar_id',
                           'value' => $asignar_id
                        ];
                  } else {
                     $asignar_id_mq =
                        [
                           'key' => '_asignar_id',
                           'value' => wp_get_current_user()->ID,
                        ];
                  }
               }
            } else {
               if ($userAdmin) {
                  $asignar_id_mq =
                     [
                        'key' => '_asignar_id',
                        'value' => '',
                        'compare' => '!='
                     ];
               } else {
                  if (isset($_GET['comite_id']) && $_GET['comite_id'] != '') {

                     $comite_id = sanitize_text_field($_GET['comite_id']);
                     if ($this->funcionesAcuerdo->get_verAcuerdos()[$comite_id] == 'todos') {
                        $asignar_id_mq =
                           [
                              'key' => '_asignar_id',
                              'value' => '',
                              'compare' => '!='
                           ];
                     } else {
                        $asignar_id_mq =
                           [
                              'key' => '_asignar_id',
                              'value' => wp_get_current_user()->ID,
                           ];
                     }
                  } else {
                     $asignar_id_mq =
                        [
                           'key' => '_asignar_id',
                           'value' => wp_get_current_user()->ID,
                        ];
                  }
               }
            }

            if (isset($_GET['vigencia']) && $_GET['vigencia'] != '') {

               $vigencia = sanitize_text_field($_GET['vigencia']);

               $fechaInicial = date('Y-m-d', strtotime('First day of ' . date('F')));
               $fechaFinal = date('Y-m-d', strtotime('Last day of ' . date('F')));

               switch ($vigencia) {
                  case '1':
                     $filtrovigencia =
                        [
                           'key' => '_f_compromiso',
                           'value' => $fechaInicial,
                           'compare' => '<'
                        ];
                     $statusvigencia = [
                        'key' => '_vigente',
                        'value' => '1',
                     ];
                     break;

                  case '2':
                     $filtrovigencia =
                        [
                           'key' => '_f_compromiso',
                           'value' => [$fechaInicial, $fechaFinal],
                           'compare' => 'BETWEEN'
                        ];
                     $statusvigencia =
                        [
                           'key' => '_vigente',
                           'value' => '1',
                        ];
                     break;

                  case '3':
                     $filtrovigencia =
                        [
                           'key' => '_f_compromiso',
                           'value' => $fechaFinal,
                           'compare' => '>'
                        ];
                     $statusvigencia =
                        [
                           'key' => '_vigente',
                           'value' => '1',
                        ];
                     break;

                  case '4':
                     $filtrovigencia =
                        [
                           'key' => '_f_compromiso',
                           'value' => '',
                           'compare' => '!='
                        ];
                     $statusvigencia =
                        [
                           'key' => '_vigente',
                           'value' => '0',
                        ];
                     break;

                  default:
                     $filtrovigencia = [];
                     $statusvigencia = [];
                     break;
               }
            } else {
               $filtrovigencia = [];
               $statusvigencia = [];
            }

            $query->set(
               'meta_query',
               [
                  $comite_id_mq,
                  $acta_id_mq,
                  $asignar_id_mq,
                  $filtrovigencia,
                  $statusvigencia
               ]
            );
         }

         if (is_post_type_archive('acta')) {

            $query->set('orderby', 'post_date');
            $query->set('order', 'DESC');

            if (isset($_GET['comite_id']) && $_GET['comite_id'] != '') {
               $comite_id = intval(sanitize_text_field($_GET['comite_id']));
               $comite_id_mq =
                  [
                     'key' => '_comite_id',
                     'value' => $comite_id
                  ];
            } else {
               $comite_id_mq =
                  [
                     'key' => '_comite_id',
                     'value' => '',
                     'compare' => '!='
                  ];
            }

            if (isset($_GET['acta_id']) && $_GET['acta_id'] != '') {
               $acta_id = intval(sanitize_text_field($_GET['acta_id']));
               $acta_id_mq =
                  [
                     'key' => '_n_acta',
                     'value' => $acta_id
                  ];
            } else {
               $acta_id_mq =
                  [
                     'key' => '_n_acta',
                     'value' => '',
                     'compare' => '!='
                  ];
            }

            $query->set(
               'meta_query',
               [
                  $comite_id_mq,
                  $acta_id_mq,
               ]
            );
         }
      }
   }
   public function sca_registrar_acuerdo()
   {
      //Validación de seguridad
      if (!wp_verify_nonce($_POST['nonce'], 'agregar_acuerdo')) {
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
         $post_name = 'aid_' . $randomString;

         //Registro del post en la base de datos.
         $n_acuerdo = sanitize_text_field($_POST['n_acuerdo']);
         $comite_id = sanitize_text_field($_POST['comite_id']);
         $acta_id = sanitize_text_field($_POST['acta_id']);
         $n_acta = sanitize_text_field($_POST['n_acta']);

         $titulo = 'Acuerdo-' . $n_acuerdo . ' - ' . $n_acta;
         $content = sanitize_textarea_field($_POST['contenido']);
         $post_parent = $acta_id;

         $asignar_id = sanitize_textarea_field($_POST['asignar_id']);
         $f_compromiso = sanitize_textarea_field($_POST['f_compromiso']);
         $vigente = sanitize_textarea_field($_POST['vigente']);
         $f_seguimiento = sanitize_textarea_field($_POST['f_seguimiento']);
         $asignar_id = sanitize_text_field($_POST['asignar_id']);

         $post_data = array(
            'post_type' => 'acuerdo',
            'post_title' => $titulo,
            'post_content' => $content,
            'post_name' => $post_name,
            'post_date' => get_post($post_parent)->post_date,
            'post_status' => 'publish',
            'post_parent' => $post_parent,
            'meta_input' => array(
               '_asignar_id' => $asignar_id,
               '_comite_id' => $comite_id,
               '_acta_id' => $acta_id,
               '_n_acuerdo' => $n_acuerdo,
               '_vigente' => $vigente,
               '_f_compromiso' => $f_compromiso,
               '_f_seguimiento' => $f_seguimiento,
            )

         );

         wp_insert_post($post_data);
         wp_send_json_success(['titulo' => 'Acuerdo Registrado', 'msg' => 'El acuerdo fue procesado exitosamente.']);
         wp_die();
      }
   }
   public function sca_editar_acuerdo()
   {
      //Validación de seguridad
      if (!wp_verify_nonce($_POST['nonce'], 'editar_acuerdo')) {
         wp_send_json_error('Error de seguridad', 401);
         die();
      } else {
         $post_id = sanitize_text_field($_POST['post_id']);
         $f_compromiso = sanitize_text_field($_POST['f_compromiso']);
         $vigente = sanitize_text_field($_POST['vigente']);
         $f_seguimiento = sanitize_text_field($_POST['f_seguimiento']);
         $asingar_id = sanitize_text_field($_POST['asignar_id']);
         $contenido = sanitize_textarea_field($_POST['contenido']);

         $post_data = [
            'ID' => $post_id,
            'post_content' => $contenido,
            'meta_input' => [
               '_f_compromiso' => $f_compromiso,
               '_vigente' => $vigente,
               '_f_seguimiento' => $f_seguimiento,
               '_asignar_id' => $asingar_id,
            ]
         ];
         wp_update_post($post_data);
         wp_send_json_success(['titulo' => 'Acuerdo Modificado', 'msg' => 'El acuerdo fue modificado exitosamente.']);
         wp_die();
      }
   }
   public function sca_eliminar_acuerdo()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'eliminar_acuerdo')) {
         wp_send_json_error('Error de seguridad', 401);
         die();
      } else {
         $post_id = sanitize_text_field($_POST['post_id']);
         wp_trash_post($post_id);
         wp_send_json_success(['titulo' => 'Acuerdo Eliminado', 'msg' => 'El acuerdo fue eliminado exitosamente.']);
         wp_die();
      }
   }
   private function set_paginas()
   {
      $paginas = [
         'principal' =>
         [
            'slug' => 'acuerdo-principal',
            'titulo' => 'Sistema Control Acuerdos'
         ],
         'acuerdo_consultas' =>
         [
            'slug' => 'acuerdo-consultas',
            'titulo' => 'Consulta de Acuerdos'
         ],
         'acuerdo_mantenimiento_menu' => [
            'slug' => 'acuerdo-mantenimiento-menu',
            'titulo' => 'Mantenimiento Comites, Minutas/Actas, Acuerdos y Membresía'
         ],
         'acuerdo_vigencia_comite' =>
         [
            'slug' => 'acuerdo-vigencia-comite',
            'titulo' => 'Vigencia de Acuerdos por Comité'
         ],
         'acuerdo_vigencia_usrs' =>
         [
            'slug' => 'acuerdo-vigencia-usrs',
            'titulo' => 'Vigencia de Acuerdos por Responsable'
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
}
