<?php

namespace FGHEGC\Modules\Sae\Evento;

use FGHEGC\Modules\Core\Singleton;

class EventoModel
{
   use Singleton;

   public function __construct()
   {
      add_action('init', [$this, 'set_evento']);
      add_action('init', [$this, 'set_roles']);
      add_action('init', [$this, 'set_fpe']);
      add_action('add_meta_boxes', [$this, 'set_campos']);
      add_action('save_post', [$this, 'sae_guardar_evento_f_inicio']);
      add_action('save_post', [$this, 'sae_guardar_evento_f_final']);
      add_action('save_post', [$this, 'sae_guardar_dia_completo']);
      add_action('save_post', [$this, 'sae_guardar_periodicidadevento']);
      add_action('save_post', [$this, 'sae_guardar_inscripcion']);
      add_action('save_post', [$this, 'sae_guardar_donativo']);
      add_action('save_post', [$this, 'sae_guardar_montodonativo']);
      add_action('save_post', [$this, 'sae_guardar_opcionesquema']);
      add_action('save_post', [$this, 'sae_guardar_npereventos']);
      add_action('save_post', [$this, 'sae_guardar_diasemanaevento']);
      add_action('save_post', [$this, 'sae_guardar_numerodiaevento']);
      add_action('save_post', [$this, 'sae_guardar_numerodiaordinalevento']);
      add_action('save_post', [$this, 'sae_guardar_mesevento']);
      add_action('save_post', [$this, 'sae_guardar_f_proxevento']);
      add_action('save_post', [$this, 'sae_guardar_q_inscripciones']);
      add_action('pre_get_posts', [$this, 'sae_pre_get_posts_eventos']);
      add_action('wp_ajax_eventosfiltros', [$this, 'sae_eventos_filtros']);
      add_action('wp_ajax_registrarevento', [$this, 'sae_registrar_evento']);
      add_action('wp_ajax_editarevento', [$this, 'sae_editarevento']);
      add_action('wp_ajax_modificarevento', [$this, 'sae_modificarevento']);
      add_action('wp_ajax_eliminarevento', [$this, 'sae_eliminarevento']);
      add_action('wp_ajax_evento_usuario', [$this, 'sae_evento_usuario']);
      $this->set_paginas();
   }
   public function set_roles()
   {
      // remove_role('useradmineventos');
      // remove_role('usercoordinaeventos');
      add_role('useradmineventos', 'Administrador(a) Eventos', get_role('subscriber')->capabilities);
      add_role('usercoordinaeventos', 'Coordinador(a) Eventos', get_role('subscriber')->capabilities);
   }
   public function set_evento()
   {
      $type = 'evento';
      $labels = $this->get_etiquetas('Evento', 'Eventos');

      $args = array(
         'capability_type' => ['evento', 'eventos'],
         'map_meta_cap' => true,
         'labels' => $labels,
         'public' => true,
         'has_archive' => true,
         'rewrite' => ['slug' => 'eventos'],
         'show_in_rest' => true,
         'rest_base' => 'eventos',
         'menu_icon' => 'dashicons-book',
         'supports' => array('title', 'editor', 'custom-fields', 'thumbnail'),
         // 'taxonomies'               => ['category', 'post_tag'],
      );

      register_post_type($type, $args);

      $admin = get_role('administrator');
      $capabilities = $this->get_capacidades('evento', 'eventos');
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
         'name' => _x($plural, 'post type general name', 'sae'),
         'singular_name' => _x($singular, 'post type singular name', 'sae'),
         'menu_name' => _x($plural, 'admin menu', 'sae'),
         'name_admin_bar' => _x($singular, 'add new on admin bar', 'sae'),
         'add_new' => _x("Nuevo $singular", 'prayer', 'sae'),
         'add_new_item' => __("Agregar $singular", 'sae'),
         'new_item' => __("Nuevo $singular", 'sae'),
         'edit_item' => __("Editar $singular", 'sae'),
         'view_item' => __("Ver $singular", 'sae'),
         'view_items' => __("Ver $plural", 'sae'),
         'all_items' => __("Todos los $plural", 'sae'),
         'search_items' => __("Buscar $plural", 'sae'),
         'parent_item_colon' => __("$singular padre", 'sae'),
         'not_found' => __("No hay $p_lower", 'sae'),
         'not_found_in_trash' => __("No hay $p_lower borrados", 'sae'),
         'archives' => __("$singular achivado", 'sae'),
         'attributes' => __("Atributos del $singular", 'sae'),
         'insert_into_item' => __("Insertar $s_lower", 'sae'),
         'uploaded_to_this_item' => __("Adjuntar a un $s_lower", 'sae'),
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
         'f_inicio',
         'Fecha Inicio',
         [$this, 'sae_crear_f_inicio_cbk'],
         'evento',
         'normal',
         'default',
      );
      add_meta_box(
         'f_final',
         'Fecha Final',
         [$this, 'sae_crear_f_final_cbk'],
         'evento',
         'normal',
         'default',
      );
      add_meta_box(
         'dia_completo',
         'Evento Día Completo',
         [$this, 'sae_crear_dia_completo_cbk'],
         'evento',
         'normal',
         'default'
      );
      add_meta_box(
         'periodicidadevento',
         'Tipo de Evento',
         [$this, 'sae_crear_periodicidadevento_cbk'],
         'evento',
         'normal',
         'default'
      );
      add_meta_box(
         'inscripcion',
         'Requiere inscripción',
         [$this, 'sae_crear_inscripcion_cbk'],
         'evento',
         'normal',
         'default'
      );
      add_meta_box(
         'donativo',
         'Requiere donativo',
         [$this, 'sae_crear_donativo_cbk'],
         'evento',
         'normal',
         'default'
      );
      add_meta_box(
         'montodonativo',
         'Monto donativo sugerido',
         [$this, 'sae_crear_montodonativo_cbk'],
         'evento',
         'normal',
         'default'
      );

      add_meta_box(
         'aforo',
         'Requiere Aforo',
         [$this, 'sae_crear_aforo_cbk'],
         'evento',
         'normal',
         'default'
      );
      add_meta_box(
         'qaforo',
         'Aforo',
         [$this, 'sae_crear_qaforo_cbk'],
         'evento',
         'normal',
         'default'
      );
      add_meta_box(
         'opcionesquema',
         'Opción Esquema Mensual o Anual',
         [$this, 'sae_crear_opcionesquema_cbk'],
         'evento',
         'normal',
         'default'
      );
      add_meta_box(
         'npereventos',
         'Número de períodos',
         [$this, 'sae_crear_npereventos_cbk'],
         'evento',
         'normal',
         'default'
      );
      add_meta_box(
         'diasemanaevento',
         'Día de la Semana',
         [$this, 'sae_crear_diasemanaevento_cbk'],
         'evento',
         'normal',
         'default'
      );
      add_meta_box(
         'numerodiaevento',
         'Número del día del mes',
         [$this, 'sae_crear_numerodiaevento_cbk'],
         'evento',
         'normal',
         'default'
      );
      add_meta_box(
         'numerodiaordinalevento',
         'Número del día del mes ordinal',
         [$this, 'sae_crear_numerodiaordinalevento_cbk'],
         'evento',
         'normal',
         'default'
      );
      add_meta_box(
         'mesevento',
         'Mes del evento',
         [$this, 'sae_crear_mesevento_cbk'],
         'evento',
         'normal',
         'default'
      );
      add_meta_box(
         'f_proxevento',
         'Fecha Próximo Evento',
         [$this, 'sae_crear_f_proxevento_cbk'],
         'evento',
         'normal',
         'default'
      );
      add_meta_box(
         'q_inscripciones',
         'Cantidad de personas inscritas',
         [$this, 'sae_crear_q_inscripciones_cbk'],
         'evento',
         'normal',
         'default'
      );
   }
   public function sae_crear_f_inicio_cbk($post)
   {
      wp_nonce_field('f_inicio_nonce', 'f_inicio_nonce');
      $f_inicio = get_post_meta($post->ID, '_f_inicio', true);
      echo '<input type="datetime-local" style="width:20%" id="f_inicio" name="f_inicio" placeholder="yyyy-mm-dd hh:mm:ss" value="' . esc_attr($f_inicio) . '" ></input>';
   }
   public function sae_crear_f_final_cbk($post)
   {
      wp_nonce_field('f_final_nonce', 'f_final_nonce');
      $f_final = get_post_meta($post->ID, '_f_final', true);
      echo '<input type="datetime-local" style="width:20%" id="f_final" name="f_final" placeholder="yyyy-mm-dd hh:mm:ss" value="' . esc_attr($f_final) . '" ></input>';
   }
   public function sae_crear_dia_completo_cbk($post)
   {
      wp_nonce_field('dia_completo_nonce', 'dia_completo_nonce');
      $dia_completo = get_post_meta($post->ID, '_dia_completo', true);
      echo '<input type="text" style="width:10%" id="dia_completo" name="dia_completo" value="' . esc_attr($dia_completo) . '" > ("off" = No, "on" = Sí)</input>';
   }
   public function sae_crear_periodicidadevento_cbk($post)
   {
      wp_nonce_field('periodicidadevento_nonce', 'periodicidadevento_nonce');
      $periodicidadevento = get_post_meta($post->ID, '_periodicidadevento', true);
?>
      <select id="periodicidadevento" name='periodicidadevento' class="form-select" aria-label="Seleccionar frecuencia">
         <option <?php echo ($periodicidadevento == '1') ? 'value="1" selected' : 'value="1"' ?>>Evento único</option>
         <option <?php echo ($periodicidadevento == '2') ? 'value="2" selected' : 'value="2"' ?>>Diario</option>
         <option <?php echo ($periodicidadevento == '3') ? 'value="3" selected' : 'value="3"' ?>>Semanal</option>
         <option <?php echo ($periodicidadevento == '4') ? 'value="4" selected' : 'value="4"' ?>>Mensual</option>
         <option <?php echo ($periodicidadevento == '5') ? 'value="5" selected' : 'value="5"' ?>>Anual</option>
      </select>
   <?php
   }
   public function sae_crear_inscripcion_cbk($post)
   {
      wp_nonce_field('inscripcion_nonce', 'inscripcion_nonce');
      $inscripcion = get_post_meta($post->ID, '_inscripcion', true);
      echo '<input type="text" style="width:10%" id="inscripcion" name="inscripcion" value="' . esc_attr($inscripcion) . '" > ("off" = No, "on" = Sí)</input>';
   }
   public function sae_crear_donativo_cbk($post)
   {
      wp_nonce_field('donativo_nonce', 'donativo_nonce');
      $donativo = get_post_meta($post->ID, '_donativo', true);
      echo '<input type="text" style="width:10%" id="donativo" name="donativo" value="' . esc_attr($donativo) . '" > ("off" = No, "on" = Sí)</input>';
   }
   public function sae_crear_montodonativo_cbk($post)
   {
      wp_nonce_field('montodonativo_nonce', 'montodonativo_nonce');
      $montodonativo = get_post_meta($post->ID, '_montodonativo', true);
      echo '<input type="number" style="width:10%" id="montodonativo" name="montodonativo" min="0.00" max="1000000.00" step="1000.00" value="' . esc_attr($montodonativo) . '" ></input>';
   }
   public function sae_crear_aforo_cbk($post)
   {
      wp_nonce_field('aforo_nonce', 'aforo_nonce');
      $aforo = get_post_meta($post->ID, '_aforo', true);
      echo '<input type="text" style="width:10%" id="aforo" name="aforo" value="' . esc_attr($aforo) . '" > ("off" = No, "on" = Sí)</input>';
   }
   public function sae_crear_qaforo_cbk($post)
   {
      wp_nonce_field('q_aforo_nonce', 'q_aforo_nonce');
      $q_aforo = get_post_meta($post->ID, '_q_aforo', true);
      echo '<input type="number" style="width:10%" id="q_aforo" name="q_aforo" min="0.00" max="1000000.00" step="1" value="' . esc_attr($q_aforo) . '" ></input>';
   }
   public function sae_crear_opcionesquema_cbk($post)
   {
      wp_nonce_field('opcionesquema_nonce', 'opcionesquema_nonce');
      $opcionesquema = get_post_meta($post->ID, '_opcionesquema', true);
      echo '<input type="text" style="width:10%" id="opcionesquema" name="opcionesquema" value="' . esc_attr($opcionesquema) . '" > ("off" = No, "on" = Sí)</input>';
   }
   public function sae_crear_npereventos_cbk($post)
   {
      wp_nonce_field('npereventos_nonce', 'npereventos_nonce');
      $npereventos = get_post_meta($post->ID, '_npereventos', true);
      echo '<input type="number" style="width:10%" id="npereventos" name="npereventos" min="1" max="100" value="' . esc_attr($npereventos) . '" ></input>';
   }
   public function sae_crear_diasemanaevento_cbk($post)
   {
      wp_nonce_field('diasemanaevento_nonce', 'diasemanaevento_nonce');

      $diasemanaevento = get_post_meta($post->ID, '_diasemanaevento', true);
      echo '<input id="diasemanaevento" type="text" name="diasemanaevento" value="' . esc_attr($diasemanaevento) . '"> (1=lunes, 2=martes, 3=miércoles, 4=jueves, 5=viernes, 6=sábado, 7=domingo)';
   }
   public function sae_crear_numerodiaevento_cbk($post)
   {
      wp_nonce_field('numerodiaevento_nonce', 'numerodiaevento_nonce');
      $numerodiaevento = get_post_meta($post->ID, '_numerodiaevento', true);
      echo '<input type="number" style="width:10%" id="numerodiaevento" name="numerodiaevento" min="1" max="100" value="' . esc_attr($numerodiaevento) . '" ></input>';
   }
   public function sae_crear_numerodiaordinalevento_cbk($post)
   {
      wp_nonce_field('numerodiaordinalevento_nonce', 'numerodiaordinalevento_nonce');
      $numerodiaordinalevento = get_post_meta($post->ID, '_numerodiaordinalevento', true);
   ?>
      <select id="numerodiaordinalevento" name='numerodiaordinalevento' class="form-select" aria-label="Seleccionar frecuencia">
         <option <?php echo ($numerodiaordinalevento == '') ? 'value="" selected' : 'value=""' ?>>No aplica</option>
         <option <?php echo ($numerodiaordinalevento == '1') ? 'value="1" selected' : 'value="1"' ?>>Primer</option>
         <option <?php echo ($numerodiaordinalevento == '2') ? 'value="2" selected' : 'value="2"' ?>>Segundo</option>
         <option <?php echo ($numerodiaordinalevento == '3') ? 'value="3" selected' : 'value="3"' ?>>Tercer</option>
         <option <?php echo ($numerodiaordinalevento == '4') ? 'value="4" selected' : 'value="4"' ?>>Cuarto</option>
         <option <?php echo ($numerodiaordinalevento == '5') ? 'value="5" selected' : 'value="5"' ?>>Último</option>
      </select>
   <?php
   }
   public function sae_crear_mesevento_cbk($post)
   {
      wp_nonce_field('mesevento_nonce', 'mesevento_nonce');
      $mesevento = get_post_meta($post->ID, '_mesevento', true);
   ?>
      <select id="mesevento" name='mesevento' class="form-select" aria-label="Seleccionar frecuencia">
         <option <?php echo ($mesevento == '') ? 'value="" selected' : 'value=""' ?>>No aplica</option>
         <option <?php echo ($mesevento == '1') ? 'value="1" selected' : 'value="1"' ?>>Enero</option>
         <option <?php echo ($mesevento == '2') ? 'value="2" selected' : 'value="2"' ?>>Febrero</option>
         <option <?php echo ($mesevento == '3') ? 'value="3" selected' : 'value="3"' ?>>Marzo</option>
         <option <?php echo ($mesevento == '4') ? 'value="4" selected' : 'value="4"' ?>>Abril</option>
         <option <?php echo ($mesevento == '5') ? 'value="5" selected' : 'value="5"' ?>>Mayo</option>
         <option <?php echo ($mesevento == '6') ? 'value="6" selected' : 'value="6"' ?>>Junio</option>
         <option <?php echo ($mesevento == '7') ? 'value="7" selected' : 'value="7"' ?>>Julio</option>
         <option <?php echo ($mesevento == '8') ? 'value="8" selected' : 'value="8"' ?>>Agosto</option>
         <option <?php echo ($mesevento == '9') ? 'value="9" selected' : 'value="9"' ?>>Septiembre</option>
         <option <?php echo ($mesevento == '10') ? 'value="10" selected' : 'value="10"' ?>>Octubre</option>
         <option <?php echo ($mesevento == '11') ? 'value="11" selected' : 'value="11"' ?>>Noviembre</option>
         <option <?php echo ($mesevento == '12') ? 'value="12" selected' : 'value="12"' ?>>Diciembre</option>
      </select>
<?php
   }

   public function sae_crear_f_proxevento_cbk($post)
   {
      wp_nonce_field('f_proxevento_nonce', 'f_proxevento_nonce');
      $f_proxevento = get_post_meta($post->ID, '_f_proxevento', true);
      echo '<input type="datetime-local" style="width:20%" id="f_proxevento" name="f_proxevento" value="' . esc_attr($f_proxevento) . '" ></input>';
   }
   public function sae_crear_q_inscripciones_cbk($post)
   {
      wp_nonce_field('q_inscripciones_nonce', 'q_inscripciones_nonce');
      $q_inscripciones = get_post_meta($post->ID, '_q_inscripciones', true);
      echo '<input type="number" style="width:10%" id="q_inscripciones" name="q_inscripciones" min="1" max="100" value="' . esc_attr($q_inscripciones) . '" ></input>';
   }
   public function sae_guardar_evento_f_inicio($post_id)
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
   public function sae_guardar_evento_f_final($post_id)
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
      if ($f_final != '') {
         $f_final = date('Y-m-d H:i:s', strtotime($f_final));
      }
      update_post_meta($post_id, '_f_final', $f_final);
   }
   public function sae_guardar_dia_completo($post_id)
   {
      if (!isset($_POST['dia_completo_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['dia_completo_nonce'], 'dia_completo_nonce')) {
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
      if (!isset($_POST['dia_completo'])) {
         return;
      }
      $dia_completo = sanitize_text_field($_POST['dia_completo']);
      update_post_meta($post_id, '_dia_completo', $dia_completo);
   }
   public function sae_guardar_periodicidadevento($post_id)
   {
      if (!isset($_POST['periodicidadevento_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['periodicidadevento_nonce'], 'periodicidadevento_nonce')) {
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
      if (!isset($_POST['periodicidadevento'])) {
         return;
      }
      $periodicidadevento = sanitize_text_field($_POST['periodicidadevento']);
      update_post_meta($post_id, '_periodicidadevento', $periodicidadevento);
   }
   public function sae_guardar_inscripcion($post_id)
   {
      if (!isset($_POST['inscripcion_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['inscripcion_nonce'], 'inscripcion_nonce')) {
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
      if (!isset($_POST['inscripcion'])) {
         return;
      }
      $inscripcion = sanitize_text_field($_POST['inscripcion']);
      update_post_meta($post_id, '_inscripcion', $inscripcion);
   }
   public function sae_guardar_donativo($post_id)
   {
      if (!isset($_POST['donativo_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['donativo_nonce'], 'donativo_nonce')) {
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
      if (!isset($_POST['donativo'])) {
         return;
      }
      $donativo = sanitize_text_field($_POST['donativo']);
      update_post_meta($post_id, '_donativo', $donativo);
   }
   public function sae_guardar_montodonativo($post_id)
   {
      if (!isset($_POST['montodonativo_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['montodonativo_nonce'], 'montodonativo_nonce')) {
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
      if (!isset($_POST['montodonativo'])) {
         return;
      }
      $montodonativo = sanitize_text_field($_POST['montodonativo']);
      update_post_meta($post_id, '_montodonativo', $montodonativo);
   }
   public function sae_guardar_aforo($post_id)
   {
      if (!isset($_POST['aforo_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['aforo_nonce'], 'aforo_nonce')) {
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
      if (!isset($_POST['aforo'])) {
         return;
      }
      $aforo = sanitize_text_field($_POST['aforo']);
      update_post_meta($post_id, '_aforo', $aforo);
   }
   public function sae_guardar_q_aforo($post_id)
   {
      if (!isset($_POST['q_aforo_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['q_aforo_nonce'], 'q_aforo_nonce')) {
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
      if (!isset($_POST['q_aforo'])) {
         return;
      }
      $q_aforo = sanitize_text_field($_POST['q_aforo']);
      update_post_meta($post_id, '_q_aforo', $q_aforo);
   }
   public function sae_guardar_opcionesquema($post_id)
   {
      if (!isset($_POST['opcionesquema_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['opcionesquema_nonce'], 'opcionesquema_nonce')) {
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
      if (!isset($_POST['opcionesquema'])) {
         return;
      }
      $opcionesquema = sanitize_text_field($_POST['opcionesquema']);
      update_post_meta($post_id, '_opcionesquema', $opcionesquema);
   }
   public function sae_guardar_npereventos($post_id)
   {
      if (!isset($_POST['npereventos_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['npereventos_nonce'], 'npereventos_nonce')) {
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
      if (!isset($_POST['npereventos'])) {
         return;
      }
      $npereventos = sanitize_text_field($_POST['npereventos']);
      update_post_meta($post_id, '_npereventos', $npereventos);
   }
   public function sae_guardar_diasemanaevento($post_id)
   {
      if (!isset($_POST['diasemanaevento_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['diasemanaevento_nonce'], 'diasemanaevento_nonce')) {
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
      if (!isset($_POST['diasemanaevento'])) {
         return;
      }
      $diasemanaevento = sanitize_text_field($_POST['diasemanaevento']);
      update_post_meta($post_id, '_diasemanaevento', $diasemanaevento);
   }
   public function sae_guardar_numerodiaevento($post_id)
   {
      if (!isset($_POST['numerodiaevento_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['numerodiaevento_nonce'], 'numerodiaevento_nonce')) {
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
      if (!isset($_POST['numerodiaevento'])) {
         return;
      }
      $numerodiaevento = sanitize_text_field($_POST['numerodiaevento']);
      update_post_meta($post_id, '_numerodiaevento', $numerodiaevento);
   }
   public function sae_guardar_numerodiaordinalevento($post_id)
   {
      if (!isset($_POST['numerodiaordinalevento_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['numerodiaordinalevento_nonce'], 'numerodiaordinalevento_nonce')) {
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
      if (!isset($_POST['numerodiaordinalevento'])) {
         return;
      }
      $numerodiaordinalevento = sanitize_text_field($_POST['numerodiaordinalevento']);
      update_post_meta($post_id, '_numerodiaordinalevento', $numerodiaordinalevento);
   }
   public function sae_guardar_mesevento($post_id)
   {
      if (!isset($_POST['mesevento_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['mesevento_nonce'], 'mesevento_nonce')) {
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
      if (!isset($_POST['mesevento'])) {
         return;
      }
      $mesevento = sanitize_text_field($_POST['mesevento']);
      update_post_meta($post_id, '_mesevento', $mesevento);
   }
   public function sae_guardar_f_proxevento($post_id)
   {
      if (!isset($_POST['f_proxevento_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['f_proxevento_nonce'], 'f_proxevento_nonce')) {
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
      if (!isset($_POST['f_proxevento'])) {
         return;
      }
      $f_proxevento = sanitize_text_field($_POST['f_proxevento']);
      $f_proxevento = date('Y-m-d H:i:s', strtotime($f_proxevento));
      update_post_meta($post_id, '_f_proxevento', $f_proxevento);
   }
   public function sae_guardar_q_inscripciones($post_id)
   {
      if (!isset($_POST['q_inscripciones_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['q_inscripciones_nonce'], 'q_inscripciones_nonce')) {
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
      if (!isset($_POST['q_inscripciones'])) {
         return;
      }
      $q_inscripciones = sanitize_text_field($_POST['q_inscripciones']);
      update_post_meta($post_id, '_q_inscripciones', $q_inscripciones);
   }
   public function sae_registrar_evento()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'evento')) {
         wp_send_json_error('Error de seguridad', 401);
         wp_die();
      } else {
         $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
         $charactersLength = strlen($characters);
         $randomString = '';
         for ($i = 0; $i < 15; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
         }
         $post_name = 'eve_' . $randomString;

         //Registro del post en la base de datos.
         $title = sanitize_text_field($_POST['title']);
         $content = sanitize_textarea_field($_POST['content']);
         $f_inicio = sanitize_text_field($_POST['f_inicio']);
         $h_inicio = sanitize_text_field($_POST['h_inicio']);
         $f_inicio = date('Y-m-d H:i:s', strtotime($f_inicio . ' ' . $h_inicio));
         $f_final = sanitize_text_field($_POST['f_final']);
         $h_final = sanitize_text_field($_POST['h_final']);
         if ($f_final != '') {
            $f_final = date('Y-m-d H:i:s', strtotime($f_final . ' ' . $h_final));
         }
         $dia_completo = sanitize_text_field($_POST['dia_completo']);
         $periodicidadevento = sanitize_text_field($_POST['periodicidadevento']);
         $inscripcion = sanitize_text_field($_POST['inscripcion']);
         $donativo = sanitize_text_field($_POST['donativo']);
         $montodonativo = sanitize_text_field($_POST['montodonativo']);
         $aforo = sanitize_text_field($_POST['aforo']);
         $q_aforo = sanitize_text_field($_POST['q_aforo']);

         if (isset($_POST['npereventosdiario'])) {
            $npereventos = sanitize_text_field($_POST['npereventosdiario']);
         }
         if (isset($_POST['npereventossemana'])) {
            $npereventos = sanitize_text_field($_POST['npereventossemana']);
         }
         if (isset($_POST['opcion_mensual'])) {
            $opcionesquema = sanitize_text_field($_POST['opcion_mensual']);
         }
         if (isset($_POST['npereventosmes1'])) {
            $npereventos = sanitize_text_field($_POST['npereventosmes1']);
         }
         if (isset($_POST['npereventosmes2'])) {
            $npereventos = sanitize_text_field($_POST['npereventosmes2']);
         }
         if (isset($_POST['opcion_anual'])) {
            $opcionesquema = sanitize_text_field($_POST['opcion_anual']);
         }
         if (isset($_POST['npereventosanno1'])) {
            $npereventos = sanitize_text_field($_POST['npereventosanno1']);
         }
         if (isset($_POST['npereventosanno2'])) {
            $npereventos = sanitize_text_field($_POST['npereventosanno2']);
         }
         if ($npereventos == '') {
            $npereventos = 1;
         }
         if (isset($_POST['mesop1'])) {
            $mesevento = sanitize_text_field($_POST['mesop1']);
         }
         if (isset($_POST['mesop2'])) {
            $mesevento = sanitize_text_field($_POST['mesop2']);
         }
         if (isset($_POST['mesop1anno'])) {
            $mesevento = sanitize_text_field($_POST['mesop1']);
         }
         if (isset($_POST['mesop2anno'])) {
            $mesevento = sanitize_text_field($_POST['mesop2']);
         }
         if (isset($_POST['numerodiaevento'])) {
            $numerodiaevento = sanitize_text_field($_POST['numerodiaevento']);
         }

         if (isset($_POST['numerodiaordinalevento'])) {
            $diaordinal = sanitize_text_field($_POST['numerodiaordinalevento']);
         }
         if (isset($_POST['numerodiaordinaleventoanno'])) {
            $diaordinal = sanitize_text_field($_POST['numerodiaordinaleventoanno']);
         }
         $diasemanaevento = sanitize_text_field($_POST['diasemanaevento']);

         require_once(ABSPATH . "wp-admin" . '/includes/image.php');
         require_once(ABSPATH . "wp-admin" . '/includes/file.php');
         require_once(ABSPATH . "wp-admin" . '/includes/media.php');


         $attach_id = media_handle_upload('evento_imagen', $_POST['post_id']);
         if (is_wp_error($attach_id)) {
            $attach_id = '';
         }

         /*
         multiple files loader
         if ($_FILES) {
            foreach ($_FILES as $file => $array) {
               if ($_FILES[$file]['error'] !== UPLOAD_ERR_OK) {
                  echo "upload error : " . $_FILES[$file]['error'];
               }
               $attach_id = media_handle_upload($file, $_POST['post_id']);
            }
         }
         */

         $post_data = array(
            'post_type' => 'evento',
            'post_title' => $title,
            'post_content' => $content,
            'post_name' => $post_name,
            'post_status' => 'publish',
            'meta_input' => array(
               '_f_inicio' => $f_inicio,
               '_f_final' => $f_final,
               '_dia_completo' => $dia_completo,
               '_thumbnail_id' => $attach_id,
               '_periodicidadevento' => $periodicidadevento,
               '_inscripcion' => $inscripcion,
               '_donativo' => $donativo,
               '_montodonativo' => $montodonativo,
               '_aforo' => $aforo,
               '_q_aforo' => $q_aforo,
               '_opcionesquema' => $opcionesquema,
               '_npereventos' => $npereventos,
               '_diasemanaevento' => $diasemanaevento,
               '_numerodiaevento' => $numerodiaevento,
               '_numerodiaordinalevento' => $diaordinal,
               '_mesevento' => $mesevento,
               '_f_proxevento' => $f_inicio
            )
         );
         wp_insert_post($post_data);
         wp_send_json_success(['titulo' => 'Evento Registrado', 'msg' => 'El Evento se registró exitosamente.']);
         wp_die();
      }
   }
   public function set_fpe()
   {
      if (isset($_GET['fpe'])) {
         $fpe_param = sanitize_text_field($_GET['fpe']);
         $mesEvento = date('F', strtotime($fpe_param));
         $annoEvento = date('Y', strtotime($fpe_param));
      } else {
         $fpe_param = 0;
         $mesEvento = isset($_GET['mes']) ? sanitize_text_field($_GET['mes']) : date('F');
         $annoEvento = isset($_GET['anno']) ? sanitize_text_field($_GET['anno']) : date('Y');
      }

      $eventos = get_posts([
         'post_type' => 'evento',
         'post_status' => ['publish', 'private'],
         'posts_per_page' => -1,
      ]);
      foreach ($eventos as $evento) {
         $fechasevento = EventoController::get_instance()->sae_fechasevento(
            $evento->ID,
            date('Y-m-d H:i:s', strtotime(get_post_meta($evento->ID, '_f_inicio', true))),
            get_post_meta($evento->ID, '_f_final', true),
            get_post_meta($evento->ID, '_periodicidadevento', true),
            get_post_meta($evento->ID, '_npereventos', true),
            get_post_meta($evento->ID, '_opcionesquema', true),
            get_post_meta($evento->ID, '_numerodiaordinalevento', true),
            explode(',', get_post_meta($evento->ID, '_diasemanaevento', true)),
            $mesEvento,
            $annoEvento,
            $fpe_param
         );
         if (count($fechasevento)) {
            if ($fpe_param != 0) {
               $fpe_param = date('Y-m-d H:i:s', strtotime(date('Y-m-d', strtotime($fpe_param)) . ' ' . date('H:i:s', strtotime(get_post_meta($evento->ID, '_f_inicio', true)))));
               if (in_array($fpe_param, $fechasevento)) {
                  $fpe = $fpe_param;
               } else {
                  $fpe = date('Y-m-d H:i:s', strtotime(get_post_meta($evento->ID, '_f_inicio', true)));
               }
            } else {
               if ($mesEvento == date('F') && $annoEvento == date('Y')) {
                  $fpe_actual = [];
                  foreach ($fechasevento as $fecha) {
                     if (date('Y-m-d H:i:s', strtotime($fecha)) >= date('Y-m-d H:i:s')) {
                        $fpe_actual[] = $fecha;
                     }
                  }
                  if (count($fpe_actual)) {
                     $fpe = min($fpe_actual);
                  } else {
                     $fpe = date('Y-m-d H:i:s', strtotime(get_post_meta($evento->ID, '_f_inicio', true)));
                  }
               } else {
                  $fpe = min($fechasevento);
               }
            }
         } else {
            $fpe = date('Y-m-d H:i:s', strtotime(get_post_meta($evento->ID, '_f_inicio', true)));
         }
         update_post_meta($evento->ID, '_f_proxevento', $fpe);
      }
   }
   private function set_paginas()
   {
      $paginas = [
         'principal' =>
         [
            'slug' => 'evento-principal',
            'titulo' => 'Eventos'
         ],
         'mantenimiento' =>
         [
            'slug' => 'evento-mantenimiento',
            'titulo' => 'Mantenimiento de Eventos'
         ],
         'usuario' =>
         [
            'slug' => 'evento-usuario',
            'titulo' => 'Usuarios para Eventos'
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
   public function sae_pre_get_posts_eventos($query)
   {
      if ($query->is_main_query() && !is_admin()) {
         if (is_post_type_archive('evento')) {

            if (isset($_GET['recurrencia'])) {
               $recurrencia = sanitize_text_field($_GET['recurrencia']);
               if ($recurrencia == '6') {
                  $recurrencia = '';
                  $comparar = '!=';
               } else {
                  $recurrencia = $recurrencia;
                  $comparar = '=';
               }
            } else {
               $recurrencia = '';
               $comparar = '!=';
            }

            if (isset($_GET['mes']) && isset($_GET['anno'])) {
               $mes = sanitize_text_field($_GET['mes']);
               $anno = sanitize_text_field($_GET['anno']);
               $f_inicio = date('Y-m-d H:i:s', strtotime('first day of ' . $mes . ' ' . $anno));
               $f_final = date('Y-m-d H:i:s', strtotime('last day of ' . $mes . ' ' . $anno));
            } else {
               $f_inicio = date('Y-m-d H:i:s', strtotime('first day of ' . date('F') . ' ' . date('Y')));
               $f_final = date('Y-m-d H:i:s', strtotime('last day of ' . date('F') . ' ' . date('Y')));
            }
            if (isset($_GET['fpe'])) {
               $fecha =  sanitize_text_field(($_GET['fpe']));
               $f_inicio = date('Y-m-d H:i:s', strtotime($fecha));
               $f_final = date('Y-m-d 24:00:00', strtotime($fecha));
            }
            $meta_query =
               [
                  [
                     'key' => '_f_proxevento',
                     'value' => [$f_inicio, $f_final],
                     'compare' => 'BETWEEN'
                  ],
                  [
                     'key' => '_periodicidadevento',
                     'value' => $recurrencia,
                     'compare' => $comparar
                  ]
               ];

            $query->set('post_status', ['publish', 'private']);
            $query->set('meta_query', $meta_query);
            $query->set('posts_per_page', 9);
            $query->set('meta_key', '_f_proxevento');
            $query->set('orderby', 'meta_value');
            $query->set('order', 'ASC');
         }
      }
   }
   public function sae_editarevento()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'editarevento')) {
         wp_send_json_error('Error de seguridad', 401);
         wp_die();
      } else {
         $post_id = sanitize_text_field($_POST['post_id']);
         $evento =
            [
               'titulo' => get_post($post_id)->post_title,
               'contenido' => get_post($post_id)->post_content,
               'imagen' => (get_post_meta($post_id, '_thumbnail_id', true)) ? wp_get_attachment_url(get_post_meta($post_id, '_thumbnail_id', true)) : get_template_directory_uri() . '/assets/img/eventos.jpeg',
               'tipevento' => get_post_meta($post_id, '_periodicidadevento', true),
               'inscripcion' => (get_post_meta($post_id, '_inscripcion', true)) ? get_post_meta($post_id, '_inscripcion', true) : 'off',
               'donativo' => (get_post_meta($post_id, '_donativo', true)) ? get_post_meta($post_id, '_donativo', true) : 'off',
               'montodonativo' => get_post_meta($post_id, '_montodonativo', true),
               'aforo' => (get_post_meta($post_id, '_aforo', true)) ? get_post_meta($post_id, '_aforo', true) : 'off',
               'q_aforo' => get_post_meta($post_id, 'q_aforo', true),
               'f_inicio' => date('Y-m-d', strtotime(get_post_meta($post_id, '_f_inicio', true))),
               'h_inicio' => date('H:i:s', strtotime(get_post_meta($post_id, '_f_inicio', true))),
               'f_final' => (get_post_meta($post_id, '_f_final', true) == '') ? '' : date('Y-m-d', strtotime(get_post_meta($post_id, '_f_final', true))),
               'h_final' => (get_post_meta($post_id, '_f_final', true) == '') ? '' : date('H:i:s', strtotime(get_post_meta($post_id, '_f_final', true))),
               'dia_completo' => get_post_meta($post_id, '_dia_completo', true),
               'opciones_esquema' => get_post_meta($post_id, '_opcionesquema', true),
               'npereventos' => get_post_meta($post_id, '_npereventos', true),
               'diasemanaevento' => explode(',', get_post_meta($post_id, '_diasemanaevento', true)),
               'numerodiaevento' => get_post_meta($post_id, '_numerodiaevento', true),
               'numerodiaordinalevento' => get_post_meta($post_id, '_numerodiaordinalevento', true),
               'mesevento' => get_post_meta($post_id, '_mesevento', true)
            ];

         wp_send_json_success($evento);
         wp_die();
      }
   }
   public function sae_modificarevento()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'modificarevento')) {
         wp_send_json_error('Error de seguridad', 401);
         wp_die();
      } else {

         //Registro del post en la base de datos.
         $post_id = sanitize_text_field($_POST['post_id']);
         $title = sanitize_text_field($_POST['title']);
         $content = sanitize_textarea_field($_POST['content']);
         $f_inicio = sanitize_text_field($_POST['f_inicio']);
         $h_inicio = sanitize_text_field($_POST['h_inicio']);
         $f_inicio = date('Y-m-d H:i:s', strtotime($f_inicio . ' ' . $h_inicio));
         $f_final = sanitize_text_field($_POST['f_final']);
         $h_final = sanitize_text_field($_POST['h_final']);
         if ($f_final != '') {
            $f_final = date('Y-m-d H:i:s', strtotime($f_final . ' ' . $h_final));
         }
         $dia_completo = sanitize_text_field($_POST['dia_completo']);
         $periodicidadevento = sanitize_text_field($_POST['periodicidadevento']);
         $inscripcion = sanitize_text_field($_POST['inscripcion']);
         $donativo = sanitize_text_field($_POST['donativo']);
         $montodonativo = sanitize_text_field($_POST['montodonativo']);
         $aforo = sanitize_text_field($_POST['aforo']);
         $q_aforo = sanitize_text_field($_POST['q_aforo']);

         if (isset($_POST['npereventosdiario'])) {
            $npereventos = sanitize_text_field($_POST['npereventosdiario']);
         }
         if (isset($_POST['npereventossemana'])) {
            $npereventos = sanitize_text_field($_POST['npereventossemana']);
         }
         if (isset($_POST['opcion_mensual'])) {
            $opcionesquema = sanitize_text_field($_POST['opcion_mensual']);
         }
         if (isset($_POST['npereventosmes1'])) {
            $npereventos = sanitize_text_field($_POST['npereventosmes1']);
         }
         if (isset($_POST['npereventosmes2'])) {
            $npereventos = sanitize_text_field($_POST['npereventosmes2']);
         }
         if (isset($_POST['opcion_anual'])) {
            $opcionesquema = sanitize_text_field($_POST['opcion_anual']);
         }
         if (isset($_POST['npereventosanno1'])) {
            $npereventos = sanitize_text_field($_POST['npereventosanno1']);
         }
         if (isset($_POST['npereventosanno2'])) {
            $npereventos = sanitize_text_field($_POST['npereventosanno2']);
         }
         if ($npereventos == '') {
            $npereventos = 1;
         }
         if (isset($_POST['mesop1'])) {
            $mesevento = sanitize_text_field($_POST['mesop1']);
         }
         if (isset($_POST['mesop2'])) {
            $mesevento = sanitize_text_field($_POST['mesop2']);
         }
         if (isset($_POST['mesop1anno'])) {
            $mesevento = sanitize_text_field($_POST['mesop1']);
         }
         if (isset($_POST['mesop2anno'])) {
            $mesevento = sanitize_text_field($_POST['mesop2']);
         }
         if (isset($_POST['numerodiaevento'])) {
            $numerodiaevento = sanitize_text_field($_POST['numerodiaevento']);
         }

         if (isset($_POST['numerodiaordinalevento'])) {
            $diaordinal = sanitize_text_field($_POST['numerodiaordinalevento']);
         }
         if (isset($_POST['numerodiaordinaleventoanno'])) {
            $diaordinal = sanitize_text_field($_POST['numerodiaordinaleventoanno']);
         }
         $diasemanaevento = sanitize_text_field($_POST['diasemanaevento']);

         require_once(ABSPATH . "wp-admin" . '/includes/image.php');
         // require_once(ABSPATH . "wp-admin" . '/includes/file.php');
         // require_once(ABSPATH . "wp-admin" . '/includes/media.php');

         $attach_id = media_handle_upload('evento_imagen', $post_id);
         if (is_wp_error($attach_id)) {
            $attach_id = '';
         }
         if ($attach_id == '' && get_post_meta($post_id, '_thumbnail_id', true)) {
            $attach_id = get_post_meta($post_id, '_thumbnail_id', true);
         }

         /*
         multiple files loader
         if ($_FILES) {
            foreach ($_FILES as $file => $array) {
               if ($_FILES[$file]['error'] !== UPLOAD_ERR_OK) {
                  echo "upload error : " . $_FILES[$file]['error'];
               }
               $attach_id = media_handle_upload($file, $_POST['post_id']);
            }
         }
         */

         $post_data = array(
            'ID' => $post_id,
            'post_type' => 'evento',
            'post_title' => $title,
            'post_content' => $content,
            'post_status' => 'publish',
            'meta_input' => array(
               '_thumbnail_id' => $attach_id,
               '_f_inicio' => $f_inicio,
               '_f_final' => $f_final,
               '_dia_completo' => $dia_completo,
               '_periodicidadevento' => $periodicidadevento,
               '_inscripcion' => $inscripcion,
               '_donativo' => $donativo,
               '_montodonativo' => $montodonativo,
               '_aforo' => $aforo,
               '_q_aforo' => $q_aforo,
               '_opcionesquema' => $opcionesquema,
               '_npereventos' => $npereventos,
               '_diasemanaevento' => $diasemanaevento,
               '_numerodiaevento' => $numerodiaevento,
               '_numerodiaordinalevento' => $diaordinal,
               '_mesevento' => $mesevento,
               '_f_proxevento' => $f_inicio
            )
         );

         wp_update_post($post_data);
         wp_send_json_success(['titulo' => 'Evento Modificado', 'msg' => 'El Evento fue modificado exitosamente.']);
         wp_die();
      }
   }
   public function sae_eliminarevento()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'eliminarevento')) {
         wp_send_json_error('Error de seguridad', 401);
         wp_die();
      } else {
         $post_id = sanitize_text_field($_POST['post_id']);
         wp_delete_post($post_id, true);
         wp_send_json_success(['titulo' => 'Evento Eliminado', 'msg' => 'El evento se eliminó correctamente.']);
         wp_die();
      }
   }
   public function sae_evento_usuario()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'evento_usuario')) {
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
                  wp_die();
               } else {
                  $datos_usuario['ID'] = $datos->ID;
                  $datos_usuario['first_name'] = $datos->first_name;
                  $datos_usuario['last_name'] = $datos->last_name;
                  $datos_usuario['user_login'] = $datos->user_login;
                  $datos_usuario['user_pass'] = $datos->user_pass;
                  wp_send_json_success($datos_usuario);
                  wp_die();
               }
               break;
            case 'validar_login':
               $user_login = sanitize_text_field($_POST['user_login']);
               $datos = get_user_by('login', $user_login);
               if (empty($datos)) {
                  wp_send_json_success('agregar');
                  wp_die();
               } else {
                  $datos_usuario['ID'] = $datos->ID;
                  $datos_usuario['user_email'] = $datos->user_email;
                  $datos_usuario['user_login'] = $datos->user_login;
                  wp_send_json_success($datos_usuario);
                  wp_die();
               }
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
               if (isset($_POST['saeadmin']) || isset($_POST['saecoord'])) {
                  $saeroles = new \WP_User($user_id);
                  // $saeroles->remove_role('subscriber');
                  if (isset($_POST['saeadmin'])) {
                     $saeroles->add_role('useradminevento');
                  } elseif (isset($_POST['saecoord'])) {
                     $saeroles->add_role('usercoordinaeventos');
                  }
               }
               wp_send_json_success(['titulo' => 'Usuario Registrado', 'msg' => 'El usuario fue registrado exitosamente.']);
               wp_die();
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
               wp_send_json_success(['titulo' => 'Usuario Modificado', 'msg' => 'El usuario fue modificado exitosamente.']);
               wp_die();
               break;
            case 'eliminar_usuario':
               $user_id = $_POST['user_id'];
               wp_delete_user($user_id);
               wp_send_json_success(['titulo' => 'Usuario Eliminado', 'msg' => 'El usuario fue eliminado exitosamente.']);
               wp_die();
               break;
         }
      }
   }
}
