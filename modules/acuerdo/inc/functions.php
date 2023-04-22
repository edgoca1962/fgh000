<?php
require get_template_directory() . "/modules/acuerdo/inc/acuerdo.php";
require get_template_directory() . "/modules/acuerdo/inc/f_totalacuerdos.php";
require get_template_directory() . "/modules/comite/inc/functions.php";
require get_template_directory() . "/modules/acta/inc/functions.php";
require get_template_directory() . "/modules/miembro/inc/functions.php";
require get_template_directory() . "/modules/puesto/inc/functions.php";

if (!function_exists('fgh000_get_acuerdo_param')) {
   function fgh000_get_acuerdo_param($postType = 'acuerdo')
   {
      $atributos = [];

      $fullpage = false;
      // $titulo = '';

      if ($postType == 'page') {
         if (isset($_GET['asignar_id'])) {
            $asignar_id = sanitize_text_field($_GET['asignar_id']);
            $atributos['titulo'] = 'Acuerdos Asignados a ' . get_user_by('ID', $asignar_id)->display_name;
         }
         if (isset($_GET['comite_id'])) {
            $comite_id = sanitize_text_field($_GET['comite_id']);
            if (get_post($comite_id)) {
               $atributos['titulo'] = 'Acuerdos ' . get_post($comite_id)->post_title;
            } else {
               $atributos['titulo'] = get_the_title();
            }
         }
      }



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
      $div3 = "row row-cols-1 g-4 mb-5";
      $div4 = 'col-xl-4';
      $agregarpost = '';
      $templatepart = 'modules/' . $postType . '/template-parts/' . $postType;
      $barra = 'modules/' . $postType . '/template-parts/' . $postType . '-busquedas';
      $templatepartsingle = 'modules/' . $postType . '/template-parts/' . $postType . '-single';
      $btn_regresar = 'modules/core/template-parts/core-btn-regresar';
      $templatenone = 'modules/' . $postType . '/template-parts/' . $postType . '-none';
      $template404 = 'modules/' . $postType . '/template-parts/' . $postType . '-404';
      $regresar = $postType;
      $comite_id = '';
      $prefijo = 'Minuta';
      $num_actas = '';
      $qryconsecutivo = 0;
      $comite_id = '';
      $acta_id = '';
      $num_acuerdos = '';
      $status = '';
      $asignar_id = '';
      $parametros = '';

      if (get_the_post_thumbnail_url()) {
         $imagen = get_the_post_thumbnail_url();
      } else {
         $imagen = get_template_directory_uri() . '/assets/img/bg.jpg';
      }
      /***********************************************************************/

      if (isset($_GET['comite_id']) != null && isset($_GET['acta_id']) != null) {
         $comite_id = sanitize_text_field($_GET['comite_id']);
         $acta_id = sanitize_text_field($_GET['acta_id']);
         global $wpdb;
         $qryconsecutivo = $wpdb->get_var(
            "
                    SELECT
                    MAX(cast(t01.meta_value as unsigned)) + 1 consecutivo
                    FROM
                        wp_posts
                        INNER JOIN wp_postmeta t01 ON (ID = t01.post_id)
                        INNER JOIN wp_postmeta t02 ON (ID = t02.post_id)
                        INNER JOIN wp_postmeta t03 ON (ID = t03.post_id)
                    WHERE 1 = 1 
                        AND (
                            (t01.meta_key = '_n_acuerdo' AND t01.meta_value != '')
                            AND (t02.meta_key = '_comite_id' AND t02.meta_value ='" . $comite_id . "')
                            AND (t03.meta_key = '_acta_id' AND t03.meta_value = '" . $acta_id . "')
                        )
                        AND post_type = 'acuerdo'
                        AND post_status = 'publish';
                    "
         );
         $qry_n_acuerdos = $wpdb->get_results(
            "
                        SELECT
                        t01.meta_value
                        FROM
                            wp_posts
                            INNER JOIN wp_postmeta t01 ON (ID = t01.post_id)
                            INNER JOIN wp_postmeta t02 ON (ID = t02.post_id)
                            INNER JOIN wp_postmeta t03 ON (ID = t03.post_id)
                        WHERE 1 = 1
                            AND(
                                (t01.meta_key = '_n_acuerdo' AND t01.meta_value != '')
                                AND (t02.meta_key = '_comite_id' AND t02.meta_value = '" . $comite_id . "')
                                AND (t03.meta_key = '_acta_id' AND t03.meta_value = '" . $acta_id . "')
                                )
                            AND post_type = 'acuerdo'
                            AND post_status = 'publish'
                        ",
            ARRAY_A
         );
         $num_acuerdos = '';
         foreach ($qry_n_acuerdos as $acuerdo) {
            $num_acuerdos .= $acuerdo['meta_value'] . ',';
         }
         $parametros = 'acta_id=' . $acta_id . '&comite_id=' . $comite_id;
      } else {
         $qryconsecutivo = 0;
      }
      if (isset($_GET['comite_id'])) {
         $comite_id = sanitize_text_field($_GET['comite_id']);
         if (get_post($comite_id)) {
            $comite = get_post($comite_id)->post_title;
            if (preg_match("/Junta/i", $comite)) {
               $titulo = "Actas de " . $comite;
            } else {
               $titulo = "Minutas del " . $comite;
            }
         } else {
            $titulo = get_the_title();
         }
      } else {
         if (isset($_GET['asignar_id'])) {
            $asignar_id = sanitize_text_field($_GET['asignar_id']);
            $titulo = 'Acuerdos Asignados a ' . get_user_by('ID', $asignar_id)->display_name;
         } else {
            $titulo = 'Consulta de Acuerdos';
         }
      }
      if (isset($_GET['acta_id']) != null) {
         $agregarpost = 'modules/' . $postType . '/template-parts/' . $postType . '-mantenimiento';
         $acta_id = sanitize_text_field($_GET['acta_id']);
         if (get_post($acta_id)) {
            $subtitulo = get_post($acta_id)->post_title;
         }
      }
      if (isset($_GET['vigencia'])) {
         $vigencia = sanitize_text_field($_GET['vigencia']);
         if (isset($_GET['comite_id'])) {
            $comite_id = sanitize_text_field($_GET['comite_id']);
            $titulo = 'Acuerdos ' . get_post($comite_id)->post_title;
            $parametros = 'vigencia=' . $vigencia . '&comite_id=' . $comite_id;
         }
         if (isset($_GET['asignar_id'])) {
            $asignar_id = sanitize_text_field($_GET['asignar_id']);
            $titulo = 'Acuerdos asignados a ' . get_user_by('ID', $asignar_id)->display_name;
            $parametros = 'vigencia=' . $vigencia . '&asignar_id=' . $asignar_id;
         }
         switch ($vigencia) {
            case '1':
               $subtitulo = 'Acuerdos Vencidos';
               $status = 'Vencido';
               break;

            case '2':
               $subtitulo = 'Acuerdos Vigentes';
               $status = 'Vence este mes';
               break;

            case '3':
               $subtitulo = 'Acuerdos en Proceso';
               $status = 'Proceso';
               break;

            case '4':
               $subtitulo = 'Acuerdos Ejecutados';
               break;

            default:
               # code...
               break;
         }
      }
      if (is_single()) {
         $titulo = get_the_title();
         $display = 'display-6';
         $status = fgh000_vigencia_acuerdos(get_post_meta(get_the_ID(), '_f_compromiso', true), get_post_meta(get_the_ID(), '_vigente', true));
      } else {
         $display = 'display-4';
      }

      /***********************************************************************/

      $atributos['fullpage'] = $fullpage;
      $atributos['imagen'] = $imagen;
      $atributos['height'] = $height;
      $atributos['fontweight'] = $fontweight;
      $atributos['display'] = $display;
      $atributos['displaysub'] = $displaysub;
      $atributos['displaysub2'] = $displaysub2;
      $atributos['titulo'] = $titulo;
      $atributos['subtitulo'] = $subtitulo;
      $atributos['subtitulo2'] = $subtitulo2;
      $atributos['div0'] = $div0;
      $atributos['div1'] = $div1;
      $atributos['div2'] = $div2;
      $atributos['div3'] = $div3;
      $atributos['div4'] = $div4;
      $atributos['templatepart'] = $templatepart;
      $atributos['agregarpost'] = $agregarpost;
      $atributos['barra'] = $barra;
      $atributos['templatepartsingle'] = $templatepartsingle;
      $atributos['btn_regresar'] = $btn_regresar;
      $atributos['templatenone'] = $templatenone;
      $atributos['template404'] = $template404;
      $atributos['regresar'] = $regresar;
      $atributos['prefijo'] = $prefijo;
      $atributos['consecutivo'] = $qryconsecutivo;
      $atributos['comite_id'] = $comite_id;
      $atributos['num_actas'] = $num_actas;
      $atributos['acta_id'] = $acta_id;
      $atributos['num_acuerdos'] = $num_acuerdos;
      $atributos['status'] = $status;
      $atributos['asignar_id'] = $asignar_id;
      $atributos['parametros'] = $parametros;
      return $atributos;
   }
}

/******************************************************************************
 * 
 * 
 * Crea páginas requeridas.
 * 
 * 
 ******************************************************************************/
$principal = get_posts([
   'post_type' => 'page',
   'post_status' => 'publish',
   'name' => 'acuerdo-principal',
]);
if (count($principal) > 0) {
} else {
   $post_data = array(
      'post_type' => 'page',
      'post_title' => 'Sistema Control Acuerdos',
      'post_name' => 'acuerdo-principal',
      'post_status' => 'publish',
   );
   wp_insert_post($post_data);
}

$clave = get_posts([
   'post_type' => 'page',
   'post_status' => 'publish',
   'name' => 'acuerdo-cambio-clave',
]);
if (count($clave) > 0) {
} else {
   $post_data = array(
      'post_type' => 'page',
      'post_title' => 'Cambio de Contraseña',
      'post_name' => 'acuerdo-cambio-clave',
      'post_status' => 'publish',
   );
   wp_insert_post($post_data);
}

$consultas = get_posts([
   'post_type' => 'page',
   'post_status' => 'publish',
   'name' => 'acuerdo-consultas',
]);
if (count($consultas) > 0) {
} else {
   $post_data = array(
      'post_type' => 'page',
      'post_title' => 'Consulta Acuerdos',
      'post_name' => 'acuerdo-consultas',
      'post_status' => 'publish',
   );
   wp_insert_post($post_data);
}

$mantenimiento = get_posts([
   'post_type' => 'page',
   'post_status' => 'publish',
   'name' => 'acuerdo-mantenimiento-menu',
]);
if (count($mantenimiento) > 0) {
} else {
   $post_data = array(
      'post_type' => 'page',
      'post_title' => 'Mantenimiento',
      'post_name' => 'acuerdo-mantenimiento-menu',
      'post_status' => 'publish',
   );
   wp_insert_post($post_data);
}

$vigencia_comite = get_posts([
   'post_type' => 'page',
   'name' => 'acuerdo-vigencia-comite',
   'post_status' => 'publish',
]);
if (count($vigencia_comite) > 0) {
} else {
   $post_data = array(
      'post_type' => 'page',
      'post_title' => 'Vigencia Acuerdos Comité',
      'post_name' => 'acuerdo-vigencia-comite',
      'post_status' => 'publish',
   );
   wp_insert_post($post_data);
}

$vigencia_usr = get_posts([
   'post_type' => 'page',
   'name' => 'acuerdo-vigencia-usrs',
   'post_status' => 'publish',
]);
if (count($vigencia_usr) > 0) {
} else {
   $post_data = array(
      'post_type' => 'page',
      'post_title' => 'Vigencia Acuerdos Asignados',
      'post_name' => 'acuerdo-vigencia-usrs',
      'post_status' => 'publish',
   );
   wp_insert_post($post_data);
}

/******************************************************************************
 * 
 * 
 * Obtiene la vigencia de un acuerdo para la página Single.
 * 
 * 
 *****************************************************************************/

if (!function_exists('fgh000_vigencia_acuerdos')) {
   function fgh000_vigencia_acuerdos($f_compromiso, $vigente)
   {
      $fechaInicial = date('Y-m-d', strtotime('First day of ' . date('F')));
      $fechaFinal = date('Y-m-d', strtotime('Last day of ' . date('F')));
      if ($f_compromiso < $fechaInicial && $vigente == 1) {
         $status = 'Vencido';
      } elseif ($f_compromiso >= $fechaInicial && $f_compromiso <= $fechaFinal && $vigente == 1) {
         $status = 'Vence este mes';
      } elseif ($f_compromiso > $fechaFinal && $vigente == 1) {
         $status = 'Proceso';
      } else {
         $status = '';
      }
      return $status;
   }
}

/******************************************************************************
 * 
 * 
 * Filtra los posts actas y acuerdos por ID y _asignar_id y los
 * orderna por fecha en forma descendente.
 * 
 * 
 *****************************************************************************/

function fgh000_pre_get_posts($query)
{
   if ($query->is_main_query() && !is_admin()) {

      if (is_post_type_archive('acuerdo')) {

         $query->set('meta_key', '_n_acuerdo');
         $query->set('orderby', 'meta_value_num');
         $query->set('order', 'DESC');

         if (isset($_GET['comite_id'])) {
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

         if (isset($_GET['acta_id'])) {
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

         if (isset($_GET['asignar_id'])) {
            $asignar_id = sanitize_text_field($_GET['asignar_id']);
            if ($asignar_id == wp_get_current_user()->ID) {
               if (isset($_GET['comite_id'])) {
                  $comite_id = sanitize_text_field($_GET['comite_id']);
                  if ($comite_id != '') {
                     if (verAcuerdos()[$comite_id] == 'asignados') {
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
               if (fgh000_miembroJunta() || fgh000_get_param(get_post_type())['userAdmin']) {
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
            if (fgh000_get_param(get_post_type())['userAdmin']) {
               $asignar_id_mq =
                  [
                     'key' => '_asignar_id',
                     'value' => '',
                     'compare' => '!='
                  ];
            } else {
               if (isset($_GET['comite_id'])) {
                  $comite_id = sanitize_text_field($_GET['comite_id']);
                  if (verAcuerdos()[$comite_id] == 'todos') {
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

         if (isset($_GET['vigencia'])) {

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
                  $statusvigencia =
                     [
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

         if (isset($_GET['comite_id'])) {
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

         if (isset($_GET['acta_id'])) {
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
add_action('pre_get_posts', 'fgh000_pre_get_posts');
/******************************************************************************
 * 
 * 
 * Obtiene si el usuario es miembro de Junta.
 * 
 * 
 *****************************************************************************/
if (!function_exists('fgh000_miembroJunta')) {
   function fgh000_miembroJunta()
   {
      $usuario = wp_get_current_user();

      $miembros = get_posts([
         'post_type' => 'miembro',
         'numberposts' => -1,
         'post_status' => 'publish',
         'meta_key' => '_usr_id',
         'meta_value' => $usuario->ID,
      ]);

      if (count($miembros)) {
         foreach ($miembros as $miembro) {
            if ($usuario->ID == get_post_meta($miembro->ID, '_usr_id', true)) {
               if (preg_match("/Junta/i", $miembro->post_title)) {
                  $miembroJunta = true;
               }
            }
         }
      } else {
         $miembroJunta = false;
      }
      return $miembroJunta;
   }
}

/******************************************************************************
 * 
 * 
 * Obtiene los comités y la faculdad del usuario para ver los
 * acuerdos.
 * 
 * 
 *****************************************************************************/
if (!function_exists('verAcuerdos')) {
   function verAcuerdos()
   {
      $usuario = wp_get_current_user();
      $roles = $usuario->roles;

      $comites = get_posts([
         'post_type' => 'comite',
         'numberposts' => -1,
         'post_status' => 'publish',
      ]);

      $acuerdos = get_posts([
         'post_type' => 'acuerdo',
         'numberposts' => -1,
         'post_status' => 'publish',
      ]);

      $miembros = get_posts([
         'post_type' => 'miembro',
         'numberposts' => -1,
         'post_status' => 'publish',
         'meta_key' => '_usr_id',
         'meta_value' => $usuario->ID,
      ]);

      $verAcuerdosComite = [];
      if (fgh000_get_param(get_post_type())['userAdmin']) {
         foreach ($comites as $comite) {
            $verAcuerdosComite[$comite->ID] = 'todos';
         }
      } else {
         $miembroJunta = false;
         foreach ($miembros as $miembro) {
            if (preg_match("/Junta/i", $miembro->post_title)) {
               $miembroJunta = true;
            }
         }
         if ($miembroJunta) {
            foreach ($comites as $comite) {
               $verAcuerdosComite[$comite->ID] = 'todos';
            }
         } else {
            $coordinador = false;
            foreach ($miembros as $miembro) {
               if (preg_match("/Coordina/i", $miembro->post_title)) {
                  $verAcuerdosComite[get_post_meta($miembro->ID, '_comite_id', true)] = 'todos';
                  $coordinador = true;
               }
            }
            if ($coordinador) {
               foreach ($comites as $comite) {
                  if ($verAcuerdosComite[$comite->ID] == null) {
                     $verAcuerdosComite[$comite->ID] = 'asignados';
                  }
               }
            } else {
               foreach ($comites as $comite) {
                  $verAcuerdosComite[$comite->ID] = 'asignados';
               }
            }
         }
      }
      return $verAcuerdosComite;
   }
}

/******************************************************************************
 * 
 * 
 * Mantenimiento de acuerdos
 * 
 * 
 *****************************************************************************/
function fgh000_registrar_acuerdo()
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
      wp_send_json_success('Acuerdo Registrado');
      wp_die();
   }
}
add_action('wp_ajax_agregar_acuerdo', 'fgh000_registrar_acuerdo');

function fgh000_editar_acuerdo()
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
      wp_send_json_success('Acuerdo Editado');
      wp_die();
   }
}
add_action('wp_ajax_editar_acuerdo', 'fgh000_editar_acuerdo');

function fgh000_eliminar_acuerdo()
{
   if (!wp_verify_nonce($_POST['nonce'], 'eliminar_acuerdo')) {
      wp_send_json_error('Error de seguridad', 401);
      die();
   } else {
      $post_id = sanitize_text_field($_POST['post_id']);
      wp_trash_post($post_id);
      wp_send_json_success('Acuerdo Eliminado');
      wp_die();
   }
}
add_action('wp_ajax_eliminar_acuerdo', 'fgh000_eliminar_acuerdo');
function verAcuerdos()
{
   $usuario = wp_get_current_user();
   $roles = $usuario->roles;

   $comites = get_posts([
      'post_type' => 'comite',
      'numberposts' => -1,
      'post_status' => 'publish',
   ]);

   $acuerdos = get_posts([
      'post_type' => 'acuerdo',
      'numberposts' => -1,
      'post_status' => 'publish',
   ]);

   $miembros = get_posts([
      'post_type' => 'miembro',
      'numberposts' => -1,
      'post_status' => 'publish',
      'meta_key' => '_usr_id',
      'meta_value' => $usuario->ID,
   ]);

   $verAcuerdosComite = [];
   if (fgh000_get_param()['userAdmin']) {
      foreach ($comites as $comite) {
         $verAcuerdosComite[$comite->ID] = 'todos';
      }
   } else {
      $miembroJunta = false;
      foreach ($miembros as $miembro) {
         if (preg_match("/Junta/i", $miembro->post_title)) {
            $miembroJunta = true;
         }
      }
      if ($miembroJunta) {
         foreach ($comites as $comite) {
            $verAcuerdosComite[$comite->ID] = 'todos';
         }
      } else {
         $coordinador = false;
         foreach ($miembros as $miembro) {
            if (preg_match("/Coordina/i", $miembro->post_title)) {
               $verAcuerdosComite[get_post_meta($miembro->ID, '_comite_id', true)] = 'todos';
               $coordinador = true;
            }
         }
         if ($coordinador) {
            foreach ($comites as $comite) {
               if ($verAcuerdosComite[$comite->ID] == null) {
                  $verAcuerdosComite[$comite->ID] = 'asignados';
               }
            }
         } else {
            foreach ($comites as $comite) {
               $verAcuerdosComite[$comite->ID] = 'asignados';
            }
         }
      }
   }
   return $verAcuerdosComite;
}