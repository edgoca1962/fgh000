<?php
require get_template_directory() . "/modules/acta/inc/acta.php";
if (!function_exists('fgh_002_get_acta_param')) {
   function fgh000_get_acta_param($postType = 'acta')
   {
      $atributos = [];

      $fullpage = false;
      $titulo = 'Actas';
      $fontweight = 'fw-lighter';
      $display = 'display-4';
      $subtitulo = '';
      $displaysub = 'display-5';
      $subtitulo2 = '';
      $displaysub2 = 'display-6';
      $height = '60vh';
      $div0 = 'container py-5';
      $div1 = 'row';
      $div2 = 'col-xl-8';
      $div3 = "row row-cols-1 row-cols-md-2 g-4 mb-5";
      $div4 = 'col-xl-4';
      $agregarpost = 'modules/' . $postType . '/template-parts/' . $postType . '-mantenimiento';
      $templatepart = 'modules/' . $postType . '/template-parts/' . $postType;
      $barra = 'modules/acuerdo/template-parts/acuerdo-busquedas';
      $templatepartsingle = 'modules/' . $postType . '/template-parts/' . $postType . '-single';
      $templatenone = 'modules/acuerdo/template-parts/acuerdo-none';
      $template404 = 'modules/acuerdo/template-parts/acuerdo-404';
      $btn_regresar = 'modules/' . $postType . '/template-parts/' . $postType . '-regresar';
      $regresar = $postType;
      $comite_id = '';
      $prefijo = 'Minuta';
      $num_actas = 0;
      if (get_the_post_thumbnail_url()) {
         $imagen = get_the_post_thumbnail_url();
      } else {
         $imagen = get_template_directory_uri() . '/assets/img/bg.jpg';
      }

      /***********************************************************************/

      if (is_single()) {
         $titulo = get_the_title();
      }
      if (isset($_GET['comite_id']) != null) {
         $comite_id = sanitize_text_field($_GET['comite_id']);
         $comite = get_post($comite_id)->post_title;
         if (preg_match("/Junta/i", $comite)) {
            $titulo = "Actas de " . $comite;
            $prefijo = 'Acta';
         } else {
            $titulo = "Minutas del " . $comite;
            $prefijo = 'Minuta';
         }
         global $wpdb;
         $qryconsecutivo = $wpdb->get_var(
            "
                        SELECT MAX(cast(t01.meta_value as unsigned))+1 consecutivo
                        FROM wp_posts
                        INNER JOIN wp_postmeta t01 ON (ID = t01.post_id)
                        INNER JOIN wp_postmeta t02 ON (ID = t02.post_id)
                        WHERE 1=1
                        AND (
                        (t01.meta_key = '_n_acta')
                        AND (t02.meta_key = '_comite_id' and t02.meta_value = " . $comite_id . ")
                        )
                        AND post_type = 'acta' AND post_status = 'publish'
                        "
         );
         $qry_n_actas = $wpdb->get_results(
            "
                        SELECT t01.meta_value
                        FROM wp_posts
                        INNER JOIN wp_postmeta t01 ON (ID = t01.post_id)
                        INNER JOIN wp_postmeta t02 ON (ID = t02.post_id)
                        WHERE 1 = 1
                        AND (
                        (t01.meta_key = '_n_acta' AND t01.meta_value != '')
                        AND (t02.meta_key = '_comite_id' and t02.meta_value = " . $comite_id . ")
                        )
                        AND post_type = 'acta' and post_status = 'publish'
                        ",
            ARRAY_A
         );
         $num_actas = '';
         foreach ($qry_n_actas as $acta) {
            $num_actas .= $acta['meta_value'] . ',';
         }
      } else {
         $titulo = 'Minutas y Actas';
         $prefijo = 'Minutas o Actas';
         $qryconsecutivo = 0;
      }

      /***********************************************************************/

      $atributos['imagen'] = $imagen;
      $atributos['fullpage'] = $fullpage;
      $atributos['titulo'] = $titulo;
      $atributos['fontweight'] = $fontweight;
      $atributos['display'] = $display;
      $atributos['subtitulo'] = $subtitulo;
      $atributos['displaysub'] = $displaysub;
      $atributos['subtitulo2'] = $subtitulo2;
      $atributos['displaysub2'] = $displaysub2;
      $atributos['height'] = $height;
      $atributos['div0'] = $div0;
      $atributos['div1'] = $div1;
      $atributos['div2'] = $div2;
      $atributos['div3'] = $div3;
      $atributos['div4'] = $div4;
      $atributos['agregarpost'] = $agregarpost;
      $atributos['templatepart'] = $templatepart;
      $atributos['barra'] = $barra;
      $atributos['templatepartsingle'] = $templatepartsingle;
      $atributos['templatenone'] = $templatenone;
      $atributos['template404'] = $template404;
      $atributos['btn_regresar'] = $btn_regresar;
      $atributos['regresar'] = $regresar;
      $atributos['comite_id'] = $comite_id;
      $atributos['consecutivo'] = $qryconsecutivo;
      $atributos['num_actas'] = $num_actas;
      $atributos['prefijo'] = $prefijo;

      return $atributos;
   }
}

/******************************************************************************
 * 
 * 
 * Mantenimiento de actas
 * 
 * 
 *****************************************************************************/
function fgh000_registrar_acta()
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
      wp_send_json_success('registrado');
      wp_die();
   }
}
add_action('wp_ajax_agregar_acta', 'fgh000_registrar_acta');

function fgh000_eliminar_acta()
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

      wp_send_json_success('Acta o Minuta y sus acuerdos eliminados');
   }
}
add_action('wp_ajax_eliminar_acta', 'fgh000_eliminar_acta');