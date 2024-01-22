<?php

namespace FGHEGC\Modules\sca\acta;

use FGHEGC\modules\core\Singleton;

class ActaModel
{
   use Singleton;
   private $etiquetas;
   private $capacidades;
   private function __construct()
   {
      add_action('init', [$this, 'set_acta']);
      add_action('add_meta_boxes', [$this, 'set_campos']);
      add_action('save_post', [$this, 'save_n_acta']);
      add_action('save_post', [$this, 'save_f_acta']);
      add_action('save_post', [$this, 'save_comite_id_acta']);
      add_action('rest_api_init', [$this, 'show_acta_meta_fields']);
      add_action('wp_ajax_agregar_acta', [$this, 'fghmvc_sca_registro_acta']);
      add_action('wp_ajax_eliminar_acta', [$this, 'fghmvc_sca_eliminar_acta']);
   }
   public function set_acta()
   {
      $type = 'acta';
      $labels = $this->get_etiquetas('Minuta o Acta', 'Minutas o Actas');

      $args = array(
         'capability_type' => ['acta', 'actas'],
         'map_meta_cap' => true,
         'labels' => $labels,
         'public' => true,
         'has_archive' => true,
         'rewrite' => ['slug' => 'actas'],
         'show_in_rest' => true,
         'rest_base' => 'actas',
         'menu_icon' => 'dashicons-book',
         'supports' => array('title', 'custom-fields'),
         // 'taxonomies'               => ['category', 'post_tag'],
      );

      register_post_type($type, $args);

      $admin = get_role('administrator');
      $capabilities = $this->get_capacidades('acta', 'actas');
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
         'add_new' => _x("Nueva $singular", 'prayer', 'fghmvc'),
         'add_new_item' => __("Agregar $singular", 'fghmvc'),
         'new_item' => __("Nueva $singular", 'fghmvc'),
         'edit_item' => __("Editar $singular", 'fghmvc'),
         'view_item' => __("Ver $singular", 'fghmvc'),
         'view_items' => __("Ver $plural", 'fghmvc'),
         'all_items' => __("Todas las $plural", 'fghmvc'),
         'search_items' => __("Buscar $plural", 'fghmvc'),
         'parent_item_colon' => __("Parent $singular", 'fghmvc'),
         'not_found' => __("No hay $p_lower", 'fghmvc'),
         'not_found_in_trash' => __("No hay $p_lower eliminadas", 'fghmvc'),
         'archives' => __("$singular Archivadas", 'fghmvc'),
         'attributes' => __("$singular Atributos", 'fghmvc'),
         'insert_into_item' => __("Incluir $s_lower", 'fghmvc'),
         'uploaded_to_this_item' => __("Adjuntar a una $s_lower", 'fghmvc'),
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
         'n_acta',
         'Número de acta',
         [$this, 'set_n_acta_cbk'],
         'acta',
         'normal',
         'default'
      );
      add_meta_box(
         'f_acta',
         'Fecha de acta',
         [$this, 'set_f_acta_cbk'],
         'acta',
         'normal',
         'default'
      );
      add_meta_box(
         'comite_id',
         'ID Comité',
         [$this, 'set_comite_id_acta_cbk'],
         'acta',
         'normal',
         'default'
      );
   }
   public function set_n_acta_cbk($post)
   {
      wp_nonce_field('n_acta_nonce', 'n_acta_nonce');
      $n_acta = get_post_meta($post->ID, '_n_acta', true);
      echo '<input type="number" style="width:20%" id="n_acta" name="n_acta" value="' . esc_attr($n_acta) . '" </input>';
   }
   public function set_f_acta_cbk($post)
   {
      wp_nonce_field('f_acta_nonce', 'f_acta_nonce');
      $f_acta = get_post_meta($post->ID, '_f_acta', true);
      echo '<input type="date" style="width:20%" id="f_acta" name="f_acta" value="' . esc_attr($f_acta) . '" >';
   }
   public function set_comite_id_acta_cbk($post)
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
   public function save_n_acta($post_id)
   {
      if (!isset($_POST['n_acta_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['n_acta_nonce'], 'n_acta_nonce')) {
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
      if (!isset($_POST['n_acta'])) {
         return;
      }
      $n_acta = sanitize_text_field($_POST['n_acta']);
      update_post_meta($post_id, '_n_acta', $n_acta);
   }
   public function save_f_acta($post_id)
   {
      if (!isset($_POST['f_acta_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['f_acta_nonce'], 'f_acta_nonce')) {
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
      if (!isset($_POST['f_acta'])) {
         return;
      }
      $f_acta = sanitize_text_field($_POST['f_acta']);
      update_post_meta($post_id, '_f_acta', $f_acta);
   }
   public function save_comite_id_acta($post_id)
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
   function show_acta_meta_fields()
   {
      register_meta('post', '_n_acta', array('type' => 'string', 'description' => 'n_acta', 'single' => true, 'show_in_rest' => true));
      register_meta('post', '_f_acta', array('type' => 'string', 'description' => 'f_acta', 'single' => true, 'show_in_rest' => true));
      register_meta('post', '_comite_id', array('type' => 'string', 'description' => 'comite_id', 'single' => true, 'show_in_rest' => true));
   }
   public function fghmvc_sca_registro_acta()
   {
      //Validación de seguridad
      if (!wp_verify_nonce($_POST['nonce'], 'agregar_acta')) {
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
         $n_acta = sanitize_text_field($_POST['n_acta']);
         $comite_id = sanitize_text_field($_POST['comite_id']);
         $f_acta = sanitize_textarea_field($_POST['f_acta']);
         $prefijo = sanitize_textarea_field($_POST['prefijo']);
         $title = $prefijo . '-' . $n_acta . ' del ' . date('m', strtotime($f_acta)) . '-' . date('Y', strtotime($f_acta)) . '-' . get_post($comite_id)->post_title;
         $post_parent = $comite_id;

         $post_data = array(
            'post_type' => 'acta',
            'post_title' => $title,
            'post_name' => $post_name,
            'post_date' => $f_acta,
            'post_status' => 'publish',
            'post_parent' => $post_parent,
            'meta_input' => array(
               '_n_acta' => $n_acta,
               '_f_acta' => $f_acta,
               '_comite_id' => $comite_id,
            )

         );
         wp_insert_post($post_data);
         wp_send_json_success(['titulo' => 'Minuta/Acta Registrada', 'msg' => 'La Minuta/Acta fue registrada exitosamente.']);
         wp_die();
      }
   }
   public function fghmvc_sca_eliminar_acta()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'eliminar_acta')) {
         wp_send_json_error('Error de seguridad', 401);
         die();
      } else {

         $post_id = sanitize_text_field($_POST['post_id']);
         /**
          * Elimina Acta
          */
         wp_trash_post($post_id);
         /**
          * Elimina acuerdos del actas
          */
         $acuerdos = get_posts([
            'post_type' => 'acuerdo',
            'numberposts' => -1,
            'meta_key' => '_acta_id',
            'meta_value' => $post_id,
         ]);
         if (count($acuerdos)) {
            foreach ($acuerdos as $acuerdo) {
               wp_trash_post($acuerdo->ID);
            }
         }

         wp_send_json_success(['titulo' => 'Procesado', 'msg' => 'Acta y acuerdos eliminados exitosamente.']);
      }
   }
}
