<?php
require get_template_directory() . "/modules/evento/inc/evento.php";
require get_template_directory() . "/modules/evento/inc/fechas_evento.php";
require get_template_directory() . "/modules/evento/inc/fpe.php";

/******************************************************************************
 * 
 * 
 * Crea las páginas para los eventos.
 * 
 * 
 *****************************************************************************/
$evento_mes = get_posts([
   'post_type' => 'page',
   'post_status' => 'publish',
   'name' => 'evento-mantenimiento',
]);
if (count($evento_mes) > 0) {
} else {
   $post_data = array(
      'post_type' => 'page',
      'post_title' => 'Manenimiento de Eventos',
      'post_name' => 'evento-mantenimiento',
      'post_status' => 'publish',
   );
   wp_insert_post($post_data);
}
/******************************************************************************
 * 
 * 
 * Parámetros para evento.
 * 
 * 
 *****************************************************************************/
if (!function_exists('fgh000_get_evento_param')) {
   function fgh000_get_evento_param($postType = 'evento')
   {
      $atributos = [];

      $fullpage = false;
      $titulo = 'Eventos';
      $fontweight = 'fw-lighter';
      $display = 'display-4';
      $subtitulo = '';
      $displaysub = 'display-5';
      $subtitulo2 = '';
      $displaysub2 = 'display-6';
      $height = '60vh';
      $div0 = 'container py-5';
      $div1 = 'row';
      $div2 = 'col-xl-9';
      $div3 = '';
      $div4 = 'col-xl-3';
      $agregarpost = '';
      $templatepart = 'modules/' . $postType . '/template-parts/' . $postType;
      $templatenone = 'modules/core/template-parts/core-none';
      $barra = 'modules/' . $postType . '/template-parts/' . $postType . '-calendario';
      $templatepartsingle = 'modules/' . $postType . '/template-parts/' . $postType . '-single';
      $btn_regresar = 'modules/' . $postType . '/template-parts/' . $postType . '-regresar';
      $regresar = $postType;

      $mes = '';
      $espacios = '';
      $restante = '';
      $mesConsulta = '';
      $mesConsultaLink = '';
      $diaSemanaPost = ['Monday' => 'Lunes', 'Tuesday' => 'Martes', 'Wednesday' => 'Miércoles', 'Thursday' => 'Jueves', 'Friday' => 'Viernes', 'Saturday' => 'Sábado', 'Sunday' => 'Domingo'];
      $monthName = ["January" => "Enero", "February" => "Febrero", "March" => "Marzo", "April" => "Abril", "May" => "Mayo", "June" => "Junio", "July" => "Julio", "August" => "Agosto", "September" => "Septiembre", "October" => "Octubre", "November" => "Noviembre", "December" => "Diciembre"];



      if (get_the_post_thumbnail_url()) {
         $imagen = get_the_post_thumbnail_url();
      } else {
         $imagen = get_template_directory_uri() . '/assets/img/bg.jpg';
      }
      if (is_single()) {
         $subtitulo = get_the_title();
      } else {
         $div3 = '';
      }



      $eventos = get_posts(['post_type' => 'evento', 'numberposts' => -1]);
      foreach ($eventos as $evento) {
         if (get_post_meta($evento->ID, '_f_final', true) > date('Y-m-d') || get_post_meta($evento->ID, '_f_final', true) == '') {
            $f_proxevento =
               fgh000_fpe(
                  get_post_meta($evento->ID, '_f_inicio', true),
                  get_post_meta($evento->ID, '_h_inicio', true),
                  get_post_meta($evento->ID, '_f_final', true),
                  get_post_meta($evento->ID, '_periodicidadevento', true),
                  get_post_meta($evento->ID, '_opcionesquema', true),
                  get_post_meta($evento->ID, '_numerodiaevento', true),
                  get_post_meta($evento->ID, '_numerodiaordinalevento', true),
                  explode(',', get_post_meta($evento->ID, '_diasemanaevento', true)),
                  get_post_meta($evento->ID, '_mesevento', true)
               );
            update_post_meta($evento->ID, '_f_proxevento', $f_proxevento);
         }
      }

      if (isset($_GET['fpe'])) {
         $mesConsultaLink = 'fpe=' . sanitize_text_field($_GET['fpe']);
         $mesConsulta = date('F', strtotime(sanitize_text_field($_GET['fpe'])));
         $mes = date('F', strtotime(sanitize_text_field($_GET['fpe'])));
         $subtitulo = date('d', strtotime(sanitize_text_field($_GET['fpe']))) . ' de ' . $monthName[date('F', strtotime(sanitize_text_field($_GET['fpe'])))] . ' del ' . date('Y');
         $displaysub = 'display-4';
      } else {
         if (isset($_GET['mes'])) {
            $mes = sanitize_text_field($_GET['mes']);
            $mesConsultaLink = 'mes=' . $mes;
            $mesConsulta = $mes;
         } else {
            $mes = date('F');
            $mesConsultaLink = 'mes=' . $mes;
            $mesConsulta = $mes;
         }
         $subtitulo = $monthName[$mes] . ' del ' . date('Y');
      }
      if (isset($mes)) {
         $espacios = date('N', strtotime('first day of ' . $mes)) - 1;
         $restante = 8 - $espacios;
         $displaysub = 'display-4';
         if (is_single()) {
            $subtitulo2 = get_the_title();
            $displaysub2 = 'display-5';
         }
      }




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
      $atributos['templatenone'] = $templatenone;
      $atributos['barra'] = $barra;
      $atributos['templatepartsingle'] = $templatepartsingle;
      $atributos['btn_regresar'] = $btn_regresar;
      $atributos['regresar'] = $regresar;
      $atributos['mes'] = $mes;
      $atributos['espacios'] = $espacios;
      $atributos['restante'] = $restante;
      $atributos['mesConsulta'] = $mesConsulta;
      $atributos['mesConsultaLink'] = $mesConsultaLink;
      $atributos['diaSemanaPost'] = $diaSemanaPost;

      return $atributos;
   }
}

/******************************************************************************
 * 
 * 
 * Filtra los posts eventos por fecha del próximo evento y los ordena
 * por la fecha del próximo evento.
 * 
 * 
 *****************************************************************************/
function fgh000_pre_get_posts_eventos($query)
{
   if ($query->is_main_query() && !is_admin()) {
      if (is_post_type_archive('evento')) {
         if (isset($_GET['fpe'])) {
            $fpe = date('Y-m-d', strtotime(sanitize_text_field($_GET['fpe'])));
            $mesConsulta = date('F', strtotime($fpe));
            $eventoID = [];
            $eventos = get_posts(['post_type' => 'evento', 'numberposts' => -1]);
            foreach ($eventos as $evento) {
               $fechasevento = fgh000_fechasevento(
                  get_post_meta($evento->ID, '_f_inicio', true),
                  get_post_meta($evento->ID, '_f_final', true),
                  get_post_meta($evento->ID, '_periodicidadevento', true),
                  get_post_meta($evento->ID, '_opcionesquema', true),
                  get_post_meta($evento->ID, '_numerodiaevento', true),
                  get_post_meta($evento->ID, '_numerodiaordinalevento', true),
                  explode(',', get_post_meta($evento->ID, '_diasemanaevento', true)),
                  get_post_meta($evento->ID, '_mesevento', true),
                  $mesConsulta
               );
               if (in_array($fpe, $fechasevento, true)) {
                  $eventoID[] = $evento->ID;
               }
            }
            $query->set('post__in', $eventoID);
         } else {
            if (isset($_GET['mes'])) {
               $mes = sanitize_text_field($_GET['mes']);
               $f_inicial = date('Y-m-d', strtotime('first day of' . $mes . ' ' . date('Y')));
               $f_final = date('Y-m-d', strtotime('last day of' . $mes . ' ' . date('Y')));
            } else {
               $mes = date('F');
               $f_inicial = date('Y-m-d');
               $f_final = date('Y-m-d', strtotime('last day of' . $mes . ' ' . date('Y')));
            }
            $mesConsulta = $mes;
            $eventoID = [];
            $eventos = get_posts(['post_type' => 'evento', 'numberposts' => -1]);
            foreach ($eventos as $evento) {
               $fechasevento = fgh000_fechasevento(
                  get_post_meta($evento->ID, '_f_inicio', true),
                  get_post_meta($evento->ID, '_f_final', true),
                  get_post_meta($evento->ID, '_periodicidadevento', true),
                  get_post_meta($evento->ID, '_opcionesquema', true),
                  get_post_meta($evento->ID, '_numerodiaevento', true),
                  get_post_meta($evento->ID, '_numerodiaordinalevento', true),
                  explode(',', get_post_meta($evento->ID, '_diasemanaevento', true)),
                  get_post_meta($evento->ID, '_mesevento', true),
                  $mesConsulta
               );
               if (count($fechasevento) > 0) {
                  $eventoID[] = $evento->ID;
               }
               $query->set('post__in', $eventoID);
            }
         }
         $query->set('meta_key', '_f_proxevento');
         $query->set('orderby', 'meta_value');
         $query->set('order', 'ASC');
      }
   }
}
add_action('pre_get_posts', 'fgh000_pre_get_posts_eventos');

function fgh000_registrar_evento()
{
   //Validación de seguridad
   if (!wp_verify_nonce($_POST['nonce'], 'evento')) {
      wp_send_json_error('Error de seguridad', 401);
      wp_die();
   } else {
      $tdy = new DateTime('now', new DateTimeZone('America/Costa_Rica'));
      $today = $tdy->format('Y-m-d');

      //Creación aleatoria del nombre del permalink del post
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
      $f_final = sanitize_text_field($_POST['f_final']);
      $h_final = sanitize_text_field($_POST['h_final']);
      $dia_completo = sanitize_text_field($_POST['dia_completo']);
      $periodicidadevento = sanitize_text_field($_POST['periodicidadevento']);
      $inscripcion = sanitize_text_field($_POST['inscripcion']);
      $donativo = sanitize_text_field($_POST['donativo']);
      $montodonativo = sanitize_text_field($_POST['montodonativo']);

      if (isset($_POST['opcion_mensual'])) {
         $opcionesquema = sanitize_text_field($_POST['opcion_mensual']);
      }
      if (isset($_POST['opcion_anual'])) {
         $opcionesquema = sanitize_text_field($_POST['opcion_anual']);
      }

      if (isset($_POST['npereventosdiario'])) {
         $npereventos = sanitize_text_field($_POST['npereventosdiario']);
      }
      if (isset($_POST['npereventossemana'])) {
         $npereventos = sanitize_text_field($_POST['npereventossemana']);
      }
      if (isset($_POST['npereventosmes1'])) {
         $npereventos = sanitize_text_field($_POST['npereventosmes1']);
      }
      if (isset($_POST['npereventosmes2'])) {
         $npereventos = sanitize_text_field($_POST['npereventosmes2']);
      }

      $diasemanaevento = sanitize_text_field($_POST['diasemanaevento']);
      $numerodiaevento = sanitize_text_field($_POST['numerodiaevento']);
      $diaordinal = sanitize_text_field($_POST['numerodiaordinalevento']);

      if (isset($_POST['mesop1'])) {
         $mesevento = sanitize_text_field($_POST['mesop1']);
      } else {
         $mesevento = sanitize_text_field($_POST['mesop2']);
      }

      require_once(ABSPATH . "wp-admin" . '/includes/image.php');
      require_once(ABSPATH . "wp-admin" . '/includes/file.php');
      require_once(ABSPATH . "wp-admin" . '/includes/media.php');


      $attach_id = media_handle_upload('thumbnail', $_POST['post_id']);

      if (is_wp_error($attach_id)) {
         $attach_id = '';
      }

      /*multiple files loader
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
            '_h_inicio' => $h_inicio,
            '_f_final' => $f_final,
            '_h_final' => $h_final,
            '_dia_completo' => $dia_completo,
            '_thumbnail_id' => $attach_id,
            '_periodicidadevento' => $periodicidadevento,
            '_inscripcion' => $inscripcion,
            '_donativo' => $donativo,
            '_montodonativo' => $montodonativo,
            '_opcionesquema' => $opcionesquema,
            '_npereventos' => $npereventos,
            '_diasemanaevento' => $diasemanaevento,
            '_numerodiaevento' => $numerodiaevento,
            '_numerodiaordinalevento' => $diaordinal,
            '_mesevento' => $mesevento
         )

      );
      wp_insert_post($post_data);
      wp_send_json_success('registrado');
      wp_die();
   }
}
add_action('wp_ajax_registrarevento', 'fgh000_registrar_evento');