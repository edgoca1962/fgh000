<?php

namespace FGHEGC\Modules\Core;

class CoreModel
{
   use Singleton;

   private function __construct()
   {
      add_action('wp_ajax_nopriv_ingresar', [$this, 'fghegc_ingresar']);
      add_action('wp_ajax_cambiar_clave', [$this, 'fghegc_cambiar_clave']);
      add_action('wp_ajax_csvfile', [$this, 'fghegc_csvfile']);
      // add_action('admin_menu', [$this, 'fghegc_export_posts_to_csv']);
      $this->set_paginas();
   }
   public function fghegc_ingresar()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'frm_ingreso')) {
         wp_send_json_error('Error de seguridad', 401);
         wp_die();
      } else {
         $credenciales = array();
         $credenciales['user_login'] = $_POST['usuario'];
         $credenciales['user_password'] = $_POST['clave'];
         $credenciales['remember'] = true;
         $ingresar = wp_signon($credenciales, false);
         if (is_wp_error($ingresar)) {
            wp_send_json_error(['titulo' => 'Error', 'msg' => 'El usuario y la contraseña no coinciden.']);
         } else {
            wp_send_json_success('ingreso');
         }
         wp_die();
      }
   }
   public function fghegc_cambiar_clave()
   {

      if (!wp_verify_nonce($_POST['nonce'], 'cambiar_clave')) {
         wp_send_json_error('Error de seguridad', 401);
         wp_die();
      } else {
         if (isset($_POST['clave_actual'])) {
            $clave_actual = sanitize_text_field($_POST['clave_actual']);
            $clave_nueva = sanitize_text_field($_POST['clave_nueva']);
            $clave_nueva2 = sanitize_text_field($_POST['clave_nueva2']);
            $user_id = get_current_user_id();
            $current_user = get_user_by('id', $user_id);
            if ($current_user && wp_check_password($clave_actual, $current_user->data->user_pass, $current_user->ID)) {
               if ($clave_nueva != $clave_nueva2) {
                  wp_send_json_error(['titulo' => 'Error', 'msg' => 'Error en la información.']);
               } else {
                  wp_set_password($clave_nueva, $current_user->ID);
                  wp_send_json_success('Cambio clave exitoso');
               }
            } else {
               wp_send_json_error(['titulo' => 'Error', 'msg' => 'Error en la información.']);
            }
         } else {
            wp_send_json_error(['titulo' => 'Error', 'msg' => 'Error en la información.']);
         }
      }
      wp_die();
   }
   public function fghegc_csvfile()
   {
      if (!wp_verify_nonce($_POST['nonce'], 'csvfile')) {
         wp_send_json_error('Error de seguridad', 401);
         die();
      } else {

         $campos = [];
         $registro = 0;
         $post_fields = [];
         $post_meta = [];
         $args = [];

         if (($file = fopen($_FILES['csvfile']['tmp_name'], "r")) !== FALSE) {
            $campos = fgetcsv($file);
            while (($data = fgetcsv($file)) !== false) {
               $registro = count($campos);
               $primerRegistro = true;
               for ($i = 0; $i < $registro; $i++) {
                  if ($primerRegistro && ctype_digit($data[$i])) {
                     $post_fields['import_id'] = $data[$i];
                  } elseif (substr(trim($campos[$i]), 0, 4) === 'post') {
                     $post_fields[$campos[$i]] = $data[$i];
                  } else {
                     $post_meta[$campos[$i]] = $data[$i];
                  }
                  $primerRegistro = false;
               }
               if (count($post_meta)) {
                  $args = array_merge($post_fields, array('meta_input' => $post_meta));
               } else {
                  $args = $post_fields;
               }
               wp_insert_post($args);
            }
            wp_send_json_success(['titulo' => 'Procesado', 'msg' => 'El archivo fue procesado exitosamente.']);
         } else {
            wp_send_json_error(['titulo' => 'Error', 'msg' => 'Archivo no encontrado.']);
         }
         fclose($file);
         die();
      }
   }
   public function fghegc_export_miembros_to_csv()
   {
      global $wpdb;

      // Query posts from WordPress.
      $posts = $wpdb->get_results("SELECT post_title, post_content, post_date FROM {$wpdb->posts} WHERE post_type = 'post'");

      // Define the CSV file path.
      $csv_file = plugin_dir_path(__FILE__) . 'exported-posts.csv';

      // Open the CSV file for writing.
      $csv_handle = fopen($csv_file, 'w');

      // Add headers to the CSV file.
      fputcsv($csv_handle, array('Post Title', 'Post Content', 'Post Date'));

      // Loop through the posts and write data to the CSV file.
      foreach ($posts as $post) {
         $data = array(
            $post->post_title,
            $post->post_content,
            $post->post_date
         );
         fputcsv($csv_handle, $data);
      }

      // Close the CSV file.
      fclose($csv_handle);

      // Provide a download link for the CSV file.
      header('Content-Type: text/csv');
      header('Content-Disposition: attachment; filename="exported-posts.csv"');
      readfile($csv_file);
      exit;
   }
   private function set_paginas()
   {
      $paginas = [
         'principal' =>
         [
            'slug' => 'core-principal',
            'titulo' => 'Página Principal'
         ],
         'cambio_clave' =>
         [
            'slug' => 'core-cambio-clave',
            'titulo' => 'Cambio de Contraseña'
         ],
         'login' =>
         [
            'slug' => 'core-login',
            'titulo' => 'Login'
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
}
