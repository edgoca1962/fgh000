<?php
function fgh000_csvfile()
{
   if (!wp_verify_nonce($_POST['nonce'], 'csvfile')) {
      wp_send_json_error('Error de seguridad', 401);
      die();
   } else {
      $postID = sanitize_text_field($_POST['consecutivo']);
      $campos = [];
      $registro = 0;
      $post_meta = 0;
      $meta = 0;
      /****************************************************
       * Obtiene los campos del archivo
       ***************************************************/
      if (($file = fopen(get_template_directory("__FILE__") . '/csv/' . basename($_FILES['csvfile']['name']), "r")) !== FALSE) {
         $campos = fgetcsv($file);
         if (($data = fgetcsv($file))) {
            $data = fgetcsv($file);
            $postmeta = 0;
            $meta = 0;
            if (($data = fgetcsv($file)) !== FALSE) {
               $registro = count($campos);
               for ($i = 0; $i < $registro; $i++) {
                  if (trim(substr($campos[$i], 0, 4)) !== 'post') {
                     $postmeta += 1;
                  }
               }
               $meta = $registro - $postmeta;
            }
            fclose($file);
         }
      }
      /**************************************************** * Importa e Inserta los datos ***************************************************/
      if (($file = fopen(get_template_directory("__FILE__") . '/csv/' . basename($_FILES['csvfile']['name']), "r")) !== FALSE) {
         if (($data = fgetcsv($file)) !== FALSE) {
            $post_fields = [];
            $post_meta = [];
            $args = [];
            while (($data = fgetcsv($file)) !== FALSE) {
               for ($i = 0; $i < $registro; $i++) {
                  if ($data[$i]) {
                     if ($i < $meta) {
                        $post_fields['import_id'] = $postID;
                        $post_fields[$campos[$i]] = $data[$i];
                     } else {
                        $post_meta[$campos[$i]] = $data[$i];
                     }
                  }
               }
               if (count($post_meta)) {
                  $args = array_merge($post_fields, array('meta_input' => $post_meta));
               } else {
                  $args = $post_fields;
               }
               wp_insert_post($args);
               $postID++;
            }
            wp_send_json_success('El archivo CSV fue procesado correctamente.'); //'CSV File procesado'
         } else {
            wp_send_json_error('El archivo CSV no contiene información.');
         }
      } else {
         wp_send_json_error('El archivo CSV no existe.');
      }
      fclose($file);
      wp_die();
   }
}
add_action('wp_ajax_csvfile', 'fgh000_csvfile');