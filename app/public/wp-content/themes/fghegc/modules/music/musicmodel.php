<?php

namespace FGHEGC\Modules\Music;

use FGHEGC\Modules\Core\Singleton;

class MusicModel
{
   use Singleton;

   public function __construct()
   {
      add_action('init', [$this, 'set_music']);
      add_action('add_meta_boxes', [$this, 'set_campos']);
      add_action('save_post', [$this, 'guardar_music_artista']);
      add_action('save_post', [$this, 'guardar_music_titulocancion']);
      add_action('save_post', [$this, 'guardar_anno']);
      add_action('save_post', [$this, 'guardar_encodedby']);
      add_action('save_post', [$this, 'guardar_tituloalbum']);
      add_action('save_post', [$this, 'guardar_banda']);
      add_action('save_post', [$this, 'guardar_numerocancion']);
      add_action('save_post', [$this, 'guardar_nuevaruta']);
      add_action('save_post', [$this, 'guardar_tituloalbum']);
      add_action('wp_ajax_registrarmusic', [$this, 'registrar_music']);
      add_action('wp_ajax_editarmusic', [$this, 'editar_music']);
      add_action('wp_ajax_modificarmusic', [$this, 'modificar_music']);
      add_action('wp_ajax_eliminarmusic', [$this, 'eliminar_music']);
      $this->set_paginas();
   }
   public function set_roles()
   {
      // remove_role('useradminmusic');
      // remove_role('usercoordinamusic');
      add_role('useradminmusic', 'Administrador(a) Musica', get_role('subscriber')->capabilities);
      add_role('usercoordinamusic', 'Coordinador(a) Musica', get_role('subscriber')->capabilities);
   }
   public function set_music()
   {
      $type = 'music';
      $labels = $this->get_etiquetas('Music', 'Musics');

      $args = array(
         'capability_type' => ['music', 'musics'],
         'map_meta_cap' => true,
         'labels' => $labels,
         'public' => true,
         'has_archive' => true,
         'rewrite' => ['slug' => 'music'],
         'show_in_rest' => true,
         'rest_base' => 'music',
         'menu_icon' => 'dashicons-book',
         'supports' => array('title', 'editor', 'custom-fields', 'thumbnail'),
         // 'taxonomies'               => ['category', 'post_tag'],
      );

      register_post_type($type, $args);

      $admin = get_role('administrator');
      $capabilities = $this->get_capacidades('music', 'musics');
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
         'add_new' => _x("Nueva $singular", 'prayer', 'FGHEGC'),
         'add_new_item' => __("Agregar $singular", 'FGHEGC'),
         'new_item' => __("Nueva $singular", 'FGHEGC'),
         'edit_item' => __("Editar $singular", 'FGHEGC'),
         'view_item' => __("Ver $singular", 'FGHEGC'),
         'view_items' => __("Ver $plural", 'FGHEGC'),
         'all_items' => __("Toda la $plural", 'FGHEGC'),
         'search_items' => __("Buscar $plural", 'FGHEGC'),
         'parent_item_colon' => __("$singular padre", 'FGHEGC'),
         'not_found' => __("No hay $p_lower", 'FGHEGC'),
         'not_found_in_trash' => __("No hay $p_lower borrados", 'FGHEGC'),
         'archives' => __("$singular achivado", 'FGHEGC'),
         'attributes' => __("Atributos de la $singular", 'FGHEGC'),
         'insert_into_item' => __("Insertar $s_lower", 'FGHEGC'),
         'uploaded_to_this_item' => __("Adjuntar a $s_lower", 'FGHEGC'),
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
         'artista',
         'Artista',
         [$this, 'crear_artista_cbk'],
         'music',
         'normal',
         'default',
      );
      add_meta_box(
         'titulocancion',
         'Título Canción',
         [$this, 'crear_titulocancion_cbk'],
         'music',
         'normal',
         'default',
      );
      add_meta_box(
         'anno',
         'Año',
         [$this, 'crear_anno_cbk'],
         'music',
         'normal',
         'default'
      );
      add_meta_box(
         'encodedby',
         'Encoded By',
         [$this, 'crear_encodedby_cbk'],
         'music',
         'normal',
         'default'
      );
      add_meta_box(
         'tituloalbum',
         'Título Album',
         [$this, 'crear_tituloalbum_cbk'],
         'music',
         'normal',
         'default'
      );
      add_meta_box(
         'banda',
         'Banda',
         [$this, 'crear_banda_cbk'],
         'music',
         'normal',
         'default'
      );
      add_meta_box(
         'numerocancion',
         'Número Canción',
         [$this, 'crear_numerocancion_cbk'],
         'music',
         'normal',
         'default'
      );

      add_meta_box(
         'bitrate',
         'Bit Rate',
         [$this, 'crear_bitrate_cbk'],
         'music',
         'normal',
         'default'
      );
      add_meta_box(
         'rutaactual',
         'Ruta Actual',
         [$this, 'crear_rutaactual_cbk'],
         'music',
         'normal',
         'default'
      );
      add_meta_box(
         'Nueva Ruta',
         'Nueva Ruta',
         [$this, 'crear_nuevaruta_cbk'],
         'music',
         'normal',
         'default'
      );
   }
   public function crear_artista_cbk($post)
   {
      wp_nonce_field('artista_nonce', 'artista_nonce');
      $artista = get_post_meta($post->ID, '_artista', true);
      echo '<input type="text" style="width:50%" id="artista" name="artista" placeholder="Nombre del Artista" value="' . esc_attr($artista) . '" ></input>';
   }
   public function crear_titulocancion_cbk($post)
   {
      wp_nonce_field('titulocancion_nonce', 'titulocancion_nonce');
      $titulocancion = get_post_meta($post->ID, '_titulocancion', true);
      echo '<input type="text" style="width:50%" id="titulocancion" name="titulocancion" placeholder="Título de la Canción" value="' . esc_attr($titulocancion) . '" ></input>';
   }
   public function crear_anno_cbk($post)
   {
      wp_nonce_field('anno_nonce', 'anno_nonce');
      $_anno = get_post_meta($post->ID, '_anno', true);
      echo '<input type="number" style="width:10%" id="_anno" name="_anno" value="' . esc_attr($_anno) . '" ></input>';
   }
   public function crear_encodedby_cbk($post)
   {
      wp_nonce_field('encodedby_nonce', 'encodedby_nonce');
      $encodedby = get_post_meta($post->ID, '_encodedby', true);
      echo '<input type="number" style="width:10%" id="encodedby" name="encodedby" placeholdeer="Encoded By" value="' . esc_attr($encodedby) . '" ></input>';
   }
   public function crear_tituloalbum_cbk($post)
   {
      wp_nonce_field('tituloalbum_nonce', 'tituloalbum_nonce');
      $tituloalbum = get_post_meta($post->ID, '_tituloalbum', true);
      echo '<input type="text" style="width:50%" id="tituloalbum" name="tituloalbum" placeholder="Título del Album" value="' . esc_attr($tituloalbum) . '" ></input>';
   }
   public function crear_banda_cbk($post)
   {
      wp_nonce_field('banda_nonce', 'banda_nonce');
      $banda = get_post_meta($post->ID, '_banda', true);
      echo '<input type="text" style="width:50%" id="banda" name="banda" placeholder="Nombre de la Banda" value="' . esc_attr($banda) . '" ></input>';
   }
   public function crear_numerocancion_cbk($post)
   {
      wp_nonce_field('numerocancion_nonce', 'numerocancion_nonce');
      $numerocancion = get_post_meta($post->ID, '_numerocancion', true);
      echo '<input type="number" style="width:10%" id="numerocancion" name="numerocancion" min="1" max="100" step="1" value="' . esc_attr($numerocancion) . '" ></input>';
   }
   public function crear_bitrate_cbk($post)
   {
      wp_nonce_field('bitrate_nonce', 'bitrate_nonce');
      $bitrate = get_post_meta($post->ID, '_bitrate', true);
      echo '<input type="number" style="width:10%" id="bitrate" name="bitrate" value="' . esc_attr($bitrate) . '" ></input>';
   }
   public function crear_rutaactual_cbk($post)
   {
      wp_nonce_field('rutaactual_nonce', 'rutaactual_nonce');
      $rutaactual = get_post_meta($post->ID, '_rutaactual', true);
      echo '<input type="number" style="width:50%" id="rutaactual" name="rutaactual" placeholder="Ruta Actual" value="' . esc_attr($rutaactual) . '" ></input>';
   }
   public function crear_nuevaruta_cbk($post)
   {
      wp_nonce_field('nuevaruta_nonce', 'nuevaruta_nonce');
      $nuevaruta = get_post_meta($post->ID, '_nuevaruta', true);
      echo '<input type="text" style="width:50%" id="nuevaruta" name="nuevaruta" placeholder="Nueva Ruta" value="' . esc_attr($nuevaruta) . '" ></input>';
   }
   /**
    * 
    * Guardar valor de los campos en WP Admin
    * 
    */
   public function guardar_music_artista($post_id)
   {
      if (!isset($_POST['artista_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['artista_nonce'], 'artista_nonce')) {
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
      if (!isset($_POST['artista'])) {
         return;
      }
      $artista = sanitize_text_field($_POST['artista']);
      update_post_meta($post_id, '_artista', $artista);
   }
   public function guardar_music_titulocancion($post_id)
   {
      if (!isset($_POST['titulocancion_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['titulocancion_nonce'], 'titulocancion_nonce')) {
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
      if (!isset($_POST['titulocancion'])) {
         return;
      }
      $titulocancion = sanitize_text_field($_POST['titulocancion']);
      if ($titulocancion != '') {
         $titulocancion = date('Y-m-d H:i:s', strtotime($titulocancion));
      }
      update_post_meta($post_id, '_titulocancion', $titulocancion);
   }
   public function guardar_anno($post_id)
   {
      if (!isset($_POST['_anno_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['_anno_nonce'], '_anno_nonce')) {
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
      if (!isset($_POST['_anno'])) {
         return;
      }
      $_anno = sanitize_text_field($_POST['_anno']);
      update_post_meta($post_id, '_anno', $_anno);
   }
   public function guardar_encodedby($post_id)
   {
      if (!isset($_POST['_encodedby_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['_encodedby_nonce'], '_encodedby_nonce')) {
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
      if (!isset($_POST['_encodedby'])) {
         return;
      }
      $_encodedby = sanitize_text_field($_POST['_encodedby']);
      update_post_meta($post_id, '_encodedby', $_encodedby);
   }
   public function guardar_tituloalbum($post_id)
   {
      if (!isset($_POST['tituloalbum_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['tituloalbum_nonce'], 'tituloalbum_nonce')) {
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
      if (!isset($_POST['tituloalbum'])) {
         return;
      }
      $tituloalbum = sanitize_text_field($_POST['tituloalbum']);
      update_post_meta($post_id, '_tituloalbum', $tituloalbum);
   }
   public function guardar_banda($post_id)
   {
      if (!isset($_POST['banda_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['banda_nonce'], 'banda_nonce')) {
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
      if (!isset($_POST['banda'])) {
         return;
      }
      $banda = sanitize_text_field($_POST['banda']);
      update_post_meta($post_id, '_banda', $banda);
   }
   public function guardar_numerocancion($post_id)
   {
      if (!isset($_POST['numerocancion_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['numerocancion_nonce'], 'numerocancion_nonce')) {
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
      if (!isset($_POST['numerocancion'])) {
         return;
      }
      $numerocancion = sanitize_text_field($_POST['numerocancion']);
      update_post_meta($post_id, '_numerocancion', $numerocancion);
   }
   public function guardar_bitrate($post_id)
   {
      if (!isset($_POST['bitrate_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['bitrate_nonce'], 'bitrate_nonce')) {
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
      if (!isset($_POST['bitrate'])) {
         return;
      }
      $bitrate = sanitize_text_field($_POST['bitrate']);
      update_post_meta($post_id, '_bitrate', $bitrate);
   }
   public function guardar_nuevaruta($post_id)
   {
      if (!isset($_POST['nuevaruta_nonce'])) {
         return;
      }
      if (!wp_verify_nonce($_POST['nuevaruta_nonce'], 'nuevaruta_nonce')) {
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
      if (!isset($_POST['nuevaruta'])) {
         return;
      }
      $nuevaruta = sanitize_text_field($_POST['nuevaruta']);
      update_post_meta($post_id, '_nuevaruta', $nuevaruta);
   }

   private function set_paginas()
   {
      $paginas = [
         'principal' =>
         [
            'slug' => 'music-principal',
            'titulo' => 'Música'
         ],
         'mantenimiento' =>
         [
            'slug' => 'music-mantenimiento',
            'titulo' => 'Mantenimiento de Música'
         ],
         'usuario' =>
         [
            'slug' => 'music-usuario',
            'titulo' => 'Usuarios para Música'
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
   /**
    * 
    * Mantenimiento (ABC) de la Música
    * 
    */
   public function registrar_music()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'registrarmusic')) {
         wp_send_json_error('Error de seguridad', 401);
         wp_die();
      } else {
      }
   }
   public function editar_music()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'editarmusic')) {
         wp_send_json_error('Error de seguridad', 401);
         wp_die();
      } else {
      }
   }
   public function modificar_music()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'modificarmusic')) {
         wp_send_json_error('Error de seguridad', 401);
         wp_die();
      } else {
      }
   }
   public function eliminar_music()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'eliminarmusic')) {
         wp_send_json_error('Error de seguridad', 401);
         wp_die();
      } else {
      }
   }
   public function eliminar_music_masiva()
   {
      $musics = get_posts(['post_type' => 'music', 'posts_per_page' => -1]);
      foreach ($musics as $music) {
         wp_delete_post($music->ID, true);
      }
      echo 'terminó';
   }

   public function get_fileinfo_mp3tag($file)
   {
      //  '/Volumes/Hitachi_03/MusicLlaves/Lexar/1979 -Trabuco Venezolano/23201.mp3'
      $id3 = new \getID3;
      return $id3->analyze($file);
   }
   public function get_mp3tag($ruta_cancion)
   {
      $tagInfo = [];
      // '/Volumes/Hitachi_03/MusicLlaves/Lexar/Charly García - 1987 - Parte de la religión/01 - Necesito tu amor.mp3'
      $id3 = new \getID3;
      $fileInfo = $id3->analyze($ruta_cancion);

      $tagInfo['artista'] = isset($fileInfo['tags']['id3v2']['artist'][0]) ? iconv('UTF-8', 'ISO-8859-1', $fileInfo['tags']['id3v2']['artist'][0]) : 'vacio';
      $tagInfo['titulo'] = isset($fileInfo['tags']['id3v2']['title'][0]) ? $fileInfo['tags']['id3v2']['title'][0] : 'vacio';
      $tagInfo['año'] = isset($fileInfo['tags']['id3v2']['year'][0]) ? $fileInfo['tags']['id3v2']['year'][0] : 'vacio';
      $tagInfo['encoded_by'] = isset($fileInfo['tags']['id3v2']['encoded_by'][0]) ? $fileInfo['tags']['id3v2']['encoded_by'][0] : 'vacio';
      $tagInfo['album'] = isset($fileInfo['tags']['id3v2']['album'][0]) ? $fileInfo['tags']['id3v2']['album'][0] : 'vacio';
      $tagInfo['band'] = isset($fileInfo['tags']['id3v2']['band'][0]) ? iconv('UTF-8', 'ISO-8859-1', $fileInfo['tags']['id3v2']['band'][0]) : 'vacio';
      $tagInfo['track_number'] = isset($fileInfo['tags']['id3v2']['track_number'][0]) ? $fileInfo['tags']['id3v2']['track_number'][0] : 'vacio';
      $tagInfo['bitrate'] = isset($fileInfo['audio']['bitrate']) ? round($fileInfo['audio']['bitrate'] / 1000) : 'vacio';
      $tagInfo['rutaActual'] = isset($fileInfo['filenamepath']) ? $fileInfo['filenamepath'] : 'vacio';
      $tagInfo['newRuta'] = '/Volumes/Hitachi_03/Music/' . $tagInfo['artista'] . '/' . $tagInfo['año'] . ' ' . $tagInfo['album'] . '/' . $tagInfo['track_number'] . ' ' . $tagInfo['titulo'] . '.mp3';

      return $tagInfo;
   }
   public function scanDirectory($dir)
   {

      //  '/Volumes/Hitachi_03/MusicLlaves'

      $id3 = new \getID3;
      $audioExtensions = ['mp3', 'wav', 'ogg', 'flac', 'aac', 'wma', 'm4a'];
      $result = [];
      $contents = scandir($dir);
      foreach ($contents as $item) {
         if ($item !== '.' && $item !== '..' && $item !== '.DS_Store') {
            $path = $dir . '/' . $item;
            if (is_dir($path)) {
               $result[$item] = $this->scanDirectory($path);
            } else {
               $fileExt = end(explode('.', $item));
               if (in_array($fileExt, $audioExtensions)) {
                  $fileInfo = $id3->analyze($path);
                  $artista = isset($fileInfo['tags']['id3v2']['artist'][0]) ? $fileInfo['tags']['id3v2']['artist'][0] : 'vacio';
                  $artista = iconv('UTF-8', 'ISO-8859-1', $artista);
                  $titulo = isset($fileInfo['tags']['id3v2']['title'][0]) ? $fileInfo['tags']['id3v2']['title'][0] : 'vacio';
                  $año = isset($fileInfo['tags']['id3v2']['year'][0]) ? $fileInfo['tags']['id3v2']['year'][0] : 'vacio';
                  $encoded_by = isset($fileInfo['tags']['id3v2']['encoded_by'][0]) ? $fileInfo['tags']['id3v2']['encoded_by'][0] : 'vacio';
                  $album = isset($fileInfo['tags']['id3v2']['album'][0]) ? $fileInfo['tags']['id3v2']['album'][0] : 'vacio';
                  $band = isset($fileInfo['tags']['id3v2']['band'][0]) ? $fileInfo['tags']['id3v2']['band'][0] : 'vacio';
                  $track_number = isset($fileInfo['tags']['id3v2']['track_number'][0]) ? $fileInfo['tags']['id3v2']['track_number'][0] : 'vacio';
                  $bitrate = isset($fileInfo['audio']['bitrate']) ? round($fileInfo['audio']['bitrate'] / 1000) : 'vacio';
                  $ruta = isset($fileInfo['filenamepath']) ? $fileInfo['filenamepath'] : 'vacio';
                  $newRuta = '/Volumes/Hitachi_03/Music/' . $artista . '/' . $año . ' ' . $album . '/' . $track_number . ' ' . '.' . $fileExt;
                  $title = $año . '-' . $artista . '-' . $titulo;

                  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                  $charactersLength = strlen($characters);
                  $randomString = '';
                  for ($i = 0; $i < 15; $i++) {
                     $randomString .= $characters[rand(0, $charactersLength - 1)];
                  }
                  $post_name = 'm_id_' . $randomString;
                  $title = $title;
                  $post_data = array(
                     'post_type' => 'music',
                     'post_title' => $title,
                     'post_name' => $post_name,
                     'post_status' => 'publish',
                     'meta_input' => array(
                        '_artista' => $artista,
                        '_titulocancion' => $titulo,
                        '_anno' => $año,
                        '_encodeby' => $encoded_by,
                        '_tituloalbum' => $album,
                        '_banda' => $band,
                        '_numerocancion' => $track_number,
                        '_bitrate' => $bitrate,
                        '_rutaactual' => $ruta,
                        '_nuevaruta' => $newRuta
                     )
                  );
                  wp_insert_post($post_data);
                  $result[] = $item;
               }
            }
         }
      }
      return $result;
      if (1 == 2) {
         $image = getimagesize($path);
         $tags['attached_picture'][0] = [
            'data' => file_get_contents($path),
            'picturetypeid' => $image[2] ?? null,
            'description' => 'cover',
            'mime' => $image['mime'],
         ];
      }
   }
   public function exportar_music_cvs()
   {
      ob_start();
      header('Content-Type: text/csv; charset=utf-8');
      header('Content-Disposition: attachment; filename=csv_export.csv');
      $header_args = array('ID', 'post_title', 'Artista', 'TítuloCancion', 'Año', 'Album', 'RutaActual', 'NuevaRuta');
      $music = get_posts(['post_type' => 'music', 'posts_per_page' => -1]);
      $data = [];
      foreach ($music as $cancion) {
         $data[] =
            [
               $cancion->ID,
               $cancion->post_title,
               get_post_meta($cancion->ID, '_artista', true),
               get_post_meta($cancion->ID, '_titulocancion', true),
               get_post_meta($cancion->ID, '_anno', true),
               get_post_meta($cancion->ID, '_tituloalbum', true),
               get_post_meta($cancion->ID, '_rutaactual', true),
               get_post_meta($cancion->ID, '_rutanueva', true),
            ];
      }
      ob_end_clean();
      $output = fopen(get_template_directory() . '/music.csv', 'w');
      fputcsv($output, $header_args);
      foreach ($data as $data_item) {
         fputcsv($output, $data_item);
      }
      fclose($output);
   }
}
