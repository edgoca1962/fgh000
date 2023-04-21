<?php

/*****************************
 * Crea las etiquetas del post
 ****************************/
function fgh000_crea_etiquetas_evento($singular = 'Post', $plural = 'Posts')
{
   $p_lower = strtolower($plural);
   $s_lower = strtolower($singular);

   return [
      'name' => _x($plural, 'post type general name', 'fgh000'),
      'singular_name' => _x($singular, 'post type singular name', 'fgh000'),
      'menu_name' => _x($plural, 'admin menu', 'fgh000'),
      'name_admin_bar' => _x($singular, 'add new on admin bar', 'fgh000'),
      'add_new' => _x("Nuevo $singular", 'prayer', 'fgh000'),
      'add_new_item' => __("Agregar $singular", 'fgh000'),
      'new_item' => __("Nuevo $singular", 'fgh000'),
      'edit_item' => __("Editar $singular", 'fgh000'),
      'view_item' => __("Ver $singular", 'fgh000'),
      'view_items' => __("Ver $plural", 'fgh000'),
      'all_items' => __("Todos los $plural", 'fgh000'),
      'search_items' => __("Buscar $plural", 'fgh000'),
      'parent_item_colon' => __("$singular padre", 'fgh000'),
      'not_found' => __("$plural no encontrados", 'fgh000'),
      'not_found_in_trash' => __("$plural no encontrados en borrados", 'fgh000'),
      'archives' => __("Archivos de $singular", 'fgh000'),
      'attributes' => __("Atributos de $singular", 'fgh000'),
      'insert_into_item' => __("Insertar en $s_lower", 'fgh000'),
      'uploaded_to_this_item' => __("Adjuntar al evento $s_lower", 'fgh000'),
   ];
}
/****************************
 * Aplica capacidades al post
 ***************************/
function fgh000_capacidades_evento($singular = 'post', $plural = 'posts')
{
   return [
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
}
/****************************
 * Crea el post personalizado
 ***************************/
function fgh000_evento_post_type()
{
   $type = 'evento';
   $labels = fgh000_crea_etiquetas_evento('Evento', 'Eventos');

   $args = array(
      'capability_type' => ['evento', 'eventos'],
      'map_meta_cap' => true,
      'labels' => $labels,
      'public' => true,
      'has_archive' => true,
      'rewrite' => ['slug' => 'eventos'],
      'show_in_rest' => true,
      'rest_base' => 'eventos',
      'menu_icon' => 'dashicons-calendar-alt',
      'supports' => array('title', 'editor', 'thumbnail'),
   );

   register_post_type($type, $args);
}
add_action('init', 'fgh000_evento_post_type');
/***********************************
 * Creación de campos personalizados 
 **********************************/
function fgh000_crear_campos_evento()
{
   add_meta_box(
      'f_inicio',
      // Unique ID     
      'Fecha Inicio',
      // Title
      'fgh000_crear_f_inicio_cbk',
      // Callback function
      'evento',
      // Admin page (or post type)
      'normal',
      // Context
      'default',
      // Priority
      'show_in_rest'
   );
   function fgh000_crear_f_inicio_cbk($post)
   {
      wp_nonce_field('f_inicio_nonce', 'f_inicio_nonce');
      $f_inicio = get_post_meta($post->ID, '_f_inicio', true);
      echo '<input type="date" style="width:20%" id="f_inicio" name="f_inicio" value="' . esc_attr($f_inicio) . '" ></input>';
   }
   add_meta_box(
      'h_inicio',
      'Hora Inicio',
      'fgh000_crear_h_inicio_cbk',
      'evento',
      'normal',
      'default',
      'show_in_rest',
   );
   function fgh000_crear_h_inicio_cbk($post)
   {
      wp_nonce_field('h_inicio_nonce', 'h_inicio_nonce');
      $h_inicio = get_post_meta($post->ID, '_h_inicio', true);
      echo '<input type="time" style="width:10%" id="h_inicio" name="h_inicio" value="' . esc_attr($h_inicio) . '" ></input>';
   }
   add_meta_box(
      'f_final',
      'Fecha Final',
      'fgh000_crear_f_final_cbk',
      'evento',
      'normal',
      'default',
      'show_in_rest',
   );
   function fgh000_crear_f_final_cbk($post)
   {
      wp_nonce_field('f_final_nonce', 'f_final_nonce');
      $f_final = get_post_meta($post->ID, '_f_final', true);
      echo '<input type="date" style="width:20%" id="f_final" name="f_final" value="' . esc_attr($f_final) . '" ></input>';
   }
   add_meta_box(
      'h_final',
      'Hora Final',
      'fgh000_crear_h_final_cbk',
      'evento',
      'normal',
      'default',
      'show_in_rest',
   );
   function fgh000_crear_h_final_cbk($post)
   {
      wp_nonce_field('h_final_nonce', 'h_final_nonce');
      $h_final = get_post_meta($post->ID, '_h_final', true);
      echo '<input type="time" style="width:10%" id="h_final" name="h_final" value="' . esc_attr($h_final) . '" ></input>';
   }
   add_meta_box(
      'dia_completo',
      'Evento Día Completo',
      'fgh000_crear_dia_completo_cbk',
      'evento',
      'normal',
      'default',
      'show_in_rest',
   );
   function fgh000_crear_dia_completo_cbk($post)
   {
      wp_nonce_field('dia_completo_nonce', 'dia_completo_nonce');
      $dia_completo = get_post_meta($post->ID, '_dia_completo', true);
      echo '<input type="text" style="width:10%" id="dia_completo" name="dia_completo" value="' . esc_attr($dia_completo) . '" > ("" = No, "on" = Sí)</input>';
   }
   add_meta_box(
      'periodicidadevento',
      'Tipo de Evento',
      'fgh000_crear_periodicidadevento_cbk',
      'evento',
      'normal',
      'default',
      'show_in_rest',
   );
   function fgh000_crear_periodicidadevento_cbk($post)
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
   add_meta_box(
      'inscripcion',
      'Requiere inscripción',
      'fgh000_crear_inscripcion_cbk',
      'evento',
      'normal',
      'default',
      'show_in_rest',
   );
   function fgh000_crear_inscripcion_cbk($post)
   {
      wp_nonce_field('inscripcion_nonce', 'inscripcion_nonce');
      $inscripcion = get_post_meta($post->ID, '_inscripcion', true);
      echo '<input type="text" style="width:10%" id="inscripcion" name="inscripcion" value="' . esc_attr($inscripcion) . '" > ("" = No, "on" = Sí)</input>';
   }
   add_meta_box(
      'donativo',
      'Requiere donativo',
      'fgh000_crear_donativo_cbk',
      'evento',
      'normal',
      'default',
      'show_in_rest',
   );
   function fgh000_crear_donativo_cbk($post)
   {
      wp_nonce_field('donativo_nonce', 'donativo_nonce');
      $donativo = get_post_meta($post->ID, '_donativo', true);
      echo '<input type="text" style="width:10%" id="donativo" name="donativo" value="' . esc_attr($donativo) . '" > ("" = No, "on" = Sí)</input>';
   }
   add_meta_box(
      'montodonativo',
      'Monto donativo sugerido',
      'fgh000_crear_montodonativo_cbk',
      'evento',
      'normal',
      'default',
      'show_in_rest',
   );
   function fgh000_crear_montodonativo_cbk($post)
   {
      wp_nonce_field('montodonativo_nonce', 'montodonativo_nonce');
      $montodonativo = get_post_meta($post->ID, '_montodonativo', true);
      echo '<input type="number" style="width:10%" id="montodonativo" name="montodonativo" min="0.00" max="1000000.00" step="1000.00" value="' . esc_attr($montodonativo) . '" ></input>';
   }
   add_meta_box(
      'opcionesquema',
      'Opción Esquema Mensual o Anual',
      'fgh000_crear_opcionesquema_cbk',
      'evento',
      'normal',
      'default',
      'show_in_rest',
   );
   function fgh000_crear_opcionesquema_cbk($post)
   {
      wp_nonce_field('opcionesquema_nonce', 'opcionesquema_nonce');
      $opcionesquema = get_post_meta($post->ID, '_opcionesquema', true);
      echo '<input type="text" style="width:10%" id="opcionesquema" name="opcionesquema" value="' . esc_attr($opcionesquema) . '" > ("" = No, "on" = Sí)</input>';
   }

   add_meta_box(
      'npereventos',
      'Número de períodos',
      'fgh000_crear_npereventos_cbk',
      'evento',
      'normal',
      'default',
      'show_in_rest',
   );
   function fgh000_crear_npereventos_cbk($post)
   {
      wp_nonce_field('npereventos_nonce', 'npereventos_nonce');
      $npereventos = get_post_meta($post->ID, '_npereventos', true);
      echo '<input type="number" style="width:10%" id="npereventos" name="npereventos" min="1" max="100" value="' . esc_attr($npereventos) . '" ></input>';
   }
   add_meta_box(
      'diasemanaevento',
      'Día de la Semana',
      'fgh000_crear_diasemanaevento_cbk',
      'evento',
      'normal',
      'default',
      'show_in_rest',
   );
   function fgh000_crear_diasemanaevento_cbk($post)
   {
      wp_nonce_field('diasemanaevento_nonce', 'diasemanaevento_nonce');

      $diasemanaevento = get_post_meta($post->ID, '_diasemanaevento', true);
      echo '<input id="diasemanaevento" type="text" name="diasemanaevento" value="' . esc_attr($diasemanaevento) . '"> (1=lunes, 2=martes, 3=miércoles, 4=jueves, 5=viernes, 6=sábado, 7=domingo)';
   }
   add_meta_box(
      'numerodiaevento',
      'Número del día del mes',
      'fgh000_crear_numerodiaevento_cbk',
      'evento',
      'normal',
      'default',
      'show_in_rest',
   );
   function fgh000_crear_numerodiaevento_cbk($post)
   {
      wp_nonce_field('numerodiaevento_nonce', 'numerodiaevento_nonce');
      $numerodiaevento = get_post_meta($post->ID, '_numerodiaevento', true);
      echo '<input type="number" style="width:10%" id="numerodiaevento" name="numerodiaevento" min="1" max="31" value="' . esc_attr($numerodiaevento) . '"></input>';
   }
   add_meta_box(
      'numerodiaordinalevento',
      'Número del día del mes ordinal',
      'fgh000_crear_numerodiaordinalevento_cbk',
      'evento',
      'normal',
      'default',
      'show_in_rest',
   );
   function fgh000_crear_numerodiaordinalevento_cbk($post)
   {
      wp_nonce_field('numerodiaordinalevento_nonce', 'numerodiaordinalevento_nonce');
      $numerodiaordinalevento = get_post_meta($post->ID, '_numerodiaordinalevento', true);
      ?>
      <select id="numerodiaordinalevento" name='numerodiaordinalevento' class="form-select"
         aria-label="Seleccionar frecuencia">
         <option <?php echo ($numerodiaordinalevento == '') ? 'value="" selected' : 'value=""' ?>>No aplica</option>
         <option <?php echo ($numerodiaordinalevento == '1') ? 'value="1" selected' : 'value="1"' ?>>Primer</option>
         <option <?php echo ($numerodiaordinalevento == '2') ? 'value="2" selected' : 'value="2"' ?>>Segundo</option>
         <option <?php echo ($numerodiaordinalevento == '3') ? 'value="3" selected' : 'value="3"' ?>>Tercer</option>
         <option <?php echo ($numerodiaordinalevento == '4') ? 'value="4" selected' : 'value="4"' ?>>Cuarto</option>
         <option <?php echo ($numerodiaordinalevento == '5') ? 'value="5" selected' : 'value="5"' ?>>Último</option>
      </select>
      <?php
   }
   add_meta_box(
      'mesevento',
      'Mes del año',
      'fgh000_crear_mesevento_cbk',
      'evento',
      'normal',
      'default',
      'show_in_rest',
   );
   function fgh000_crear_mesevento_cbk($post)
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
   add_meta_box(
      'f_proxevento',
      'Fecha Próximo Evento',
      'fgh000_crear_f_proxevento_cbk',
      'evento',
      'normal',
      'default',
      'show_in_rest',
   );
   function fgh000_crear_f_proxevento_cbk($post)
   {
      wp_nonce_field('f_proxevento_nonce', 'f_proxevento_nonce');
      $f_proxevento = get_post_meta($post->ID, '_f_proxevento', true);
      echo '<input type="date" style="width:20%" id="f_proxevento" name="f_proxevento" value="' . esc_attr($f_proxevento) . '" ></input>';
   }
}
add_action('add_meta_boxes', 'fgh000_crear_campos_evento');

/*******************************************
 * Rutinas para editar y guardar la 
 * información de los campos personalizados
 * en el editor de WP.
 *****************************************/

function fgh000_guardar_evento_f_inicio($post_id)
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
add_action('save_post', 'fgh000_guardar_evento_f_inicio');

function fgh000_guardar_h_inicio($post_id)
{
   if (!isset($_POST['h_inicio_nonce'])) {
      return;
   }
   if (!wp_verify_nonce($_POST['h_inicio_nonce'], 'h_inicio_nonce')) {
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
   if (!isset($_POST['h_inicio'])) {
      return;
   }
   $h_inicio = sanitize_text_field($_POST['h_inicio']);
   update_post_meta($post_id, '_h_inicio', $h_inicio);
}
add_action('save_post', 'fgh000_guardar_h_inicio');

function fgh000_guardar_evento_f_final($post_id)
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
add_action('save_post', 'fgh000_guardar_evento_f_final');

function fgh000_guardar_h_final($post_id)
{
   if (!isset($_POST['h_final_nonce'])) {
      return;
   }
   if (!wp_verify_nonce($_POST['h_final_nonce'], 'h_final_nonce')) {
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
   if (!isset($_POST['h_final'])) {
      return;
   }
   $h_final = sanitize_text_field($_POST['h_final']);
   update_post_meta($post_id, '_h_final', $h_final);
}
add_action('save_post', 'fgh000_guardar_h_final');

function fgh000_guardar_dia_completo($post_id)
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
add_action('save_post', 'fgh000_guardar_dia_completo');

function fgh000_guardar_periodicidadevento($post_id)
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
add_action('save_post', 'fgh000_guardar_periodicidadevento');

function fgh000_guardar_inscripcion($post_id)
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
add_action('save_post', 'fgh000_guardar_inscripcion');

function fgh000_guardar_donativo($post_id)
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
add_action('save_post', 'fgh000_guardar_donativo');

function fgh000_guardar_montodonativo($post_id)
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
add_action('save_post', 'fgh000_guardar_montodonativo');

function fgh000_guardar_opcionesquema($post_id)
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
add_action('save_post', 'fgh000_guardar_opcionesquema');


function fgh000_guardar_npereventos($post_id)
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
add_action('save_post', 'fgh000_guardar_npereventos');

function fgh000_guardar_diasemanaevento($post_id)
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
add_action('save_post', 'fgh000_guardar_diasemanaevento');

function fgh000_guardar_numerodiaevento($post_id)
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
add_action('save_post', 'fgh000_guardar_numerodiaevento');

function fgh000_guardar_numerodiaordinalevento($post_id)
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
add_action('save_post', 'fgh000_guardar_numerodiaordinalevento');

function fgh000_guardar_mesevento($post_id)
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
add_action('save_post', 'fgh000_guardar_mesevento');

function fgh000_guardar_f_proxevento($post_id)
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
   update_post_meta($post_id, '_f_proxevento', $f_proxevento);
}
add_action('save_post', 'fgh000_guardar_f_proxevento');
/******************************************************************************
 * 
 * 
 * Otorga facultados a los roles para los custom posts type
 * 
 * 
 *****************************************************************************/
add_action('init', function () {
   $admin = get_role('administrator');
   $capabilities = fgh000_capacidades_evento('evento', 'eventos');
   foreach ($capabilities as $capability) {
      if (!$admin->has_cap($capability)) {
         $admin->add_cap($capability);
      }
   }
});