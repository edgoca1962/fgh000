<?php

/******************************************************************************
 * 
 * 
 * Creación de páginas generales.
 * 
 * 
 *****************************************************************************/
$principal = get_posts([
   'post_type' => 'page',
   'post_status' => 'publish',
   'name' => 'sca-principal',
]);
if (count($principal) > 0) {
} else {
   $post_data = array(
      'post_type' => 'page',
      'post_title' => 'Sistema de Control de Acuerdos',
      'post_name' => 'sca-principal',
      'post_status' => 'publish',
   );
   wp_insert_post($post_data);
}

$acuerdos = get_posts([
   'post_type' => 'page',
   'post_status' => 'publish',
   'name' => 'sca-consulta-acuerdos',
]);
if (count($acuerdos) > 0) {
} else {
   $post_data = array(
      'post_type' => 'page',
      'post_title' => 'Consulta de Acuerdos',
      'post_name' => 'sca-consulta-acuerdos',
      'post_status' => 'publish',
   );
   wp_insert_post($post_data);
}
$mantenimiento = get_posts([
   'post_type' => 'page',
   'post_status' => 'publish',
   'name' => 'sca-mantenimiento',
]);
if (count($mantenimiento) > 0) {
} else {
   $post_data = array(
      'post_type' => 'page',
      'post_title' => 'Mantenimiento',
      'post_name' => 'sca-mantenimiento',
      'post_status' => 'publish',
   );
   wp_insert_post($post_data);
}
$mat_acta = get_posts([
   'post_type' => 'page',
   'name' => 'sca-mantener-acta',
   'post_status' => 'publish',
]);
if (count($mat_acta) > 0) {
} else {
   $post_data = array(
      'post_type' => 'page',
      'post_title' => 'Mantenimiento de Actas o Minutas',
      'post_name' => 'sca-mantener-acta',
      'post_status' => 'publish',
   );
   wp_insert_post($post_data);
}


$mat_acuerdo = get_posts([
   'post_type' => 'page',
   'name' => 'sca-mantener-acuerdo',
   'post_status' => 'publish',
]);
if (count($mat_acuerdo) > 0) {
} else {
   $post_data = array(
      'post_type' => 'page',
      'post_title' => 'Mantenimiento de Acuerdos',
      'post_name' => 'sca-mantener-acuerdo',
      'post_status' => 'publish',
   );
   wp_insert_post($post_data);
}

$cons_acuerdo = get_posts([
   'post_type' => 'page',
   'name' => 'sca-vigencia-acuerdos',
   'post_status' => 'publish',
]);
if (count($cons_acuerdo) > 0) {
} else {
   $post_data = array(
      'post_type' => 'page',
      'post_title' => 'Consulta de Acuerdos por Vigencia',
      'post_name' => 'sca-vigencia-acuerdos',
      'post_status' => 'publish',
   );
   wp_insert_post($post_data);
}

$con_acu_usr = get_posts([
   'post_type' => 'page',
   'name' => 'sca-vigencia-acuerdos-usrs',
   'post_status' => 'publish',
]);
if (count($con_acu_usr) > 0) {
} else {
   $post_data = array(
      'post_type' => 'page',
      'post_title' => 'Consulta de Acuerdos por Usuario y Vigencia',
      'post_name' => 'sca-vigencia-acuerdos-usrs',
      'post_status' => 'publish',

   );
   wp_insert_post($post_data);
}
$con_acu_com = get_posts([
   'post_type' => 'page',
   'name' => 'sca-vigencia-acuerdos-comite',
   'post_status' => 'publish',
]);
if (count($con_acu_com) > 0) {
} else {
   $post_data = array(
      'post_type' => 'page',
      'post_title' => 'Consulta de Acuerdos por Comité y Vigencia',
      'post_name' => 'sca-vigencia-acuerdos-comite',
      'post_status' => 'publish',

   );
   wp_insert_post($post_data);
}
$con_acu_gra = get_posts([
   'post_type' => 'page',
   'name' => 'sca-vigencia-acuerdos-comite-grafico',
   'post_status' => 'publish',
]);
if (count($con_acu_gra) > 0) {
} else {
   $post_data = array(
      'post_type' => 'page',
      'post_title' => 'Consulta de Acuerdos por Comité y Vigencia',
      'post_name' => 'sca-vigencia-acuerdos-comite-grafico',
      'post_status' => 'publish',

   );
   wp_insert_post($post_data);
}

$mant_comite = get_posts([
   'post_type' => 'page',
   'name' => 'sca-mantener-comite',
   'post_status' => 'publish',
]);
if (count($mant_comite) > 0) {
} else {
   $post_data = array(
      'post_type' => 'page',
      'post_title' => 'Mantenimiento de Comités',
      'post_name' => 'sca-mantener-comite',
      'post_status' => 'publish',
   );
   wp_insert_post($post_data);
}

$mant_miembro = get_posts([
   'post_type' => 'page',
   'post_status' => 'publish',
   'name' => 'sca-mantener-miembro',
]);
if (count($mant_miembro) > 0) {
} else {
   $post_data = array(
      'post_type' => 'page',
      'post_title' => 'Mantenimiento de Membresía, Usuarios y Puestos',
      'post_name' => 'sca-mantener-miembro',
      'post_status' => 'publish',
   );
   wp_insert_post($post_data);
}

$clave = get_posts([
   'post_type' => 'page',
   'post_status' => 'publish',
   'name' => 'sca-cambio-clave',
]);
if (count($clave) > 0) {
} else {
   $post_data = array(
      'post_type' => 'page',
      'post_title' => 'Cambio de Contraseña',
      'post_name' => 'sca-cambio-clave',
      'post_status' => 'publish',
   );
   wp_insert_post($post_data);
}
/***************************
 * 
 * Crea roles para usuarios
 * 
 **************************/
add_action('init', function () {
   add_role('scaadmin', 'SCA_Administrador');
});

/******************************************************************************
 * 
 * 
 * Obtiene acuerdos según su vigencia
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
 * Mantenimiento de comites
 * 
 * 
 *****************************************************************************/
function fgh000_registrar_comite()
{
   //Validación de seguridad
   if (!wp_verify_nonce($_POST['nonce'], 'agregar_comite')) {
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
      $post_name = 'cid_' . $randomString;
      $title = sanitize_text_field($_POST['title']);

      $post_data = array(
         'post_type' => 'comite',
         'post_title' => $title,
         'post_name' => $post_name,
         'post_status' => 'publish',
      );
      wp_insert_post($post_data);
      wp_send_json_success('registrado');
      wp_die();
   }
}
add_action('wp_ajax_agregar_comite', 'fgh000_registrar_comite');

function fgh000_editar_comite()
{
   if (!wp_verify_nonce($_POST['nonce'], 'editar_comite')) {
      wp_send_json_error('Error de seguridad', 401);
      die();
   } else {
      $post_id = sanitize_text_field($_POST['post_id']);
      $post_title = sanitize_text_field($_POST['nombrecomite']);

      $post_data = [
         'ID' => $post_id,
         'post_title' => $post_title,
      ];
      wp_update_post($post_data);
      wp_send_json_success($post_id);
      wp_die();
   }
}
add_action('wp_ajax_editar_comite', 'fgh000_editar_comite');

function fgh000_eliminar_comite()
{
   if (!wp_verify_nonce($_POST['nonce'], 'eliminar_comite')) {
      wp_send_json_error('Error de seguridad', 401);
      die();
   } else {
      $post_id = sanitize_text_field($_POST['post_id']);
      /**
       * Elimina Comité
       */
      wp_trash_post($post_id);
      /**
       * Elimina actas del comité
       */
      $actas = get_posts([
         'post_type' => 'acta',
         'numberposts' => -1,
         'post_status' => 'publish',
         'meta_key' => '_comite_id',
         'meta_value' => $post_id,
      ]);
      if (count($actas)) {
         foreach ($actas as $acta) {
            wp_trash_post($acta->ID);
         }
      }
      /**
       * Elimina acuerdos de las actas del comité
       */
      $acuerdos = get_posts([
         'post_type' => 'acuerdo',
         'numberposts' => -1,
         'post_status' => 'publish',
         'meta_key' => '_comite_id',
         'meta_value' => $post_id,
      ]);
      if (count($acuerdos)) {
         foreach ($acuerdos as $acuerdo) {
            wp_trash_post($acuerdo->ID);
         }
      }

      wp_send_json_success('Eliminacion total');
      wp_die();
   }
}
add_action('wp_ajax_eliminar_comite', 'fgh000_eliminar_comite');
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
/*
function fgh000_editar_acta()
{
//Validación de seguridad
if (!wp_verify_nonce($_POST['nonce'], 'editar')) {
wp_send_json_error('Error de seguridad', 401);
die();
} else {
wp_update_post($post_data);
$etiquetas = sanitize_text_field($_POST['etiquetas']);
wp_set_post_tags($post_id, $etiquetas);
wp_send_json_success('Acta Actualizada');
wp_die();
}
}
add_action('wp_ajax_editar', 'fgh000_editar_acta');
*/

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
/******************************************************************************
 * 
 * 
 * Mantenimiento de membresía
 * 
 * 
 *****************************************************************************/
function fgh000_mantener_membresia()
{
   //Validación de seguridad
   if (!wp_verify_nonce($_POST['nonce'], 'mantener_membresia')) {
      wp_send_json_error('Error de seguridad', 401);
      wp_die();
   } else {
      $boton = sanitize_text_field($_POST['boton']);

      switch ($boton) {
         case 'duplicados':
            $usr_id = sanitize_text_field($_POST['usr_id']);
            $comite_id = sanitize_text_field($_POST['comite_id']);
            $duplicados = get_posts(
               [
                  'post_type' => 'miembro',
                  'post_status' => 'publish',
                  'meta_query' => [
                     [
                        'key' => '_usr_id',
                        'value' => $usr_id
                     ],
                     [
                        'key' => '_comite_id',
                        'value' => $comite_id
                     ]
                  ]
               ]
            );
            if (count($duplicados)) {
               foreach ($duplicados as $duplicado) {
                  $datos_miembro['ID'] = $duplicado->ID;
                  $datos_miembro['puesto_id'] = get_post_meta($duplicado->ID, '_puesto_id', true);
                  $datos_miembro['f_inicio'] = get_post_meta($duplicado->ID, '_f_inicio', true);
                  $datos_miembro['f_final'] = get_post_meta($duplicado->ID, '_f_final', true);
               }
               wp_send_json_success($datos_miembro);
            } else {
               wp_send_json_success('agregar');
            }
            break;
         case 'validar_usr':
            $user_email = sanitize_text_field($_POST['user_email']);
            $datos = get_user_by('email', $user_email);
            if (empty($datos)) {
               wp_send_json_success('agregar');
            } else {
               $datos_usuario['ID'] = $datos->ID;
               $datos_usuario['first_name'] = $datos->first_name;
               $datos_usuario['last_name'] = $datos->last_name;
               $datos_usuario['user_login'] = $datos->user_login;
               $datos_usuario['user_pass'] = $datos->user_pass;
               wp_send_json_success($datos_usuario);
            }
            break;
         case 'validar_login':
            $user_login = sanitize_text_field($_POST['user_login']);
            $datos = get_user_by('login', $user_login);
            if (empty($datos)) {
               wp_send_json_success('agregar');
            } else {
               $datos_usuario['ID'] = $datos->ID;
               $datos_usuario['user_email'] = $datos->user_email;
               $datos_usuario['user_login'] = $datos->user_login;
               wp_send_json_success($datos_usuario);
            }
            break;
         case 'agregar_miembro':
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 15; $i++) {
               $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $post_name = 'mid_' . $randomString;

            //Registro del post en la base de datos.
            $usr_id = sanitize_text_field($_POST['usr_id']);
            $nombre = get_userdata($usr_id)->display_name;
            $comite_id = sanitize_text_field($_POST['comite_id']);
            $puesto_id = sanitize_text_field($_POST['puesto_id']);
            $title = $nombre . ' - ' . get_post($comite_id)->post_title . ' - ' . get_post($puesto_id)->post_title;
            $f_inicio = sanitize_textarea_field($_POST['f_inicio']);
            $f_final = sanitize_textarea_field($_POST['f_final']);

            $post_data = array(
               'post_type' => 'miembro',
               'post_title' => $title,
               'post_name' => $post_name,
               'post_status' => 'publish',
               'meta_input' => array(
                  '_usr_id' => $usr_id,
                  '_comite_id' => $comite_id,
                  '_puesto_id' => $puesto_id,
                  '_f_inicio' => $f_inicio,
                  '_f_final' => $f_final,
               )
            );
            wp_insert_post($post_data);
            wp_send_json_success('Miembro Registrado');
            break;
         case 'agregar_puesto':
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 15; $i++) {
               $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $post_name = 'pid_' . $randomString;

            $title = sanitize_text_field($_POST['nombrePuesto']);
            $post_data = array(
               'post_type' => 'puesto',
               'post_title' => $title,
               'post_name' => $post_name,
               'post_status' => 'publish',
            );
            wp_insert_post($post_data);
            wp_send_json_success('Puesto Registrado');
            break;
         case 'agregar_usuario':
            $user_email = sanitize_text_field($_POST['user_email']);
            $first_name = sanitize_text_field($_POST['first_name']);
            $last_name = sanitize_text_field($_POST['last_name']);
            $user_login = sanitize_text_field($_POST['user_login']);
            $user_pass = sanitize_text_field($_POST['user_pass']);

            /**Agrega dos roles al usuario con ID 12 */
            /**
             * $scaadmin = new WP_User(12); 
             * $scaadmin->add_role('scaadmin'); 
             */

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
            if (isset($_POST['scaadmin'])) {
               $scaadmin = new WP_User($user_id);
               $scaadmin->add_role('scaadmin');
            }
            wp_send_json_success('Usuario Registrado');
            break;
         case 'modificar_miembro':
            $post_id = $_POST['post_id'];
            $usr_id = $_POST['usr_id'];
            $comite_id = $_POST['comite_id'];
            $puesto_id = $_POST['puesto_id'];
            $f_inicio = $_POST['f_inicio'];
            $f_final = $_POST['f_final'];
            $nombre = get_user_by('ID', $usr_id)->display_name;
            $comite = get_post($comite_id)->post_title;
            $puesto = get_post($comite_id)->post_title;
            $title = $nombre . ' - ' . $comite . ' - ' . $puesto;

            $args = [
               'ID' => $post_id,
               'title' => $title,
               'meta_input' =>
               [
                  'usr_id' => $usr_id,
                  'comite_id' => $comite_id,
                  'puesto_id' => $puesto_id,
                  'f_inicio' => $f_inicio,
                  'f_final' => $f_final,
               ]
            ];

            wp_update_post($args);
            wp_send_json_success('Miembro Modificado');
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
            wp_send_json_success('Usuario Modificado');
            break;
         case 'modificar_puesto':
            $post_id = $_POST['post_id'];
            $title = $_POST['nombrePuesto'];

            $args = [
               'ID' => $post_id,
               'title' => $title,
            ];
            wp_update_post($args);
            wp_send_json_success('Puesto Modificado');
            break;
         case 'eliminar':
            $post_id = $_POST['post_id'];
            wp_trash_post($post_id);
            wp_send_json_success('Registro Eliminado');
            break;
      }

      wp_die();
   }
}
add_action('wp_ajax_mantener_membresia', 'fgh000_mantener_membresia');
/******************************************************************************
 * 
 * 
 * Función para determinar la visualización de acuerdos y 
 * sus vistas disponibles.
 * 
 * 
 *****************************************************************************/
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
   if (fgh000_get_page_att()['userAdmin']) {
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
/******************************************************************************
 * 
 * 
 * Obtener acuerdos por comités y vigencia para graficarlos.
 * 
 * 
 *****************************************************************************/
function fgh000_get_comites()
{
   $datosComites = [];
   $comites = get_posts([
      'post_type' => 'comite',
      'numberposts' => -1,
      'post_status' => 'publish',
      'orderby' => 'ID',
      'order' => 'ASC'
   ]);
   $datosComites['comites'] = $comites;

   $datosComite = [];
   array_push($datosComite, ['ID' => 'todos', 'nombre' => 'Resumen General']);
   foreach ($comites as $comite) {
      array_push($datosComite, ['ID' => $comite->ID, 'nombre' => get_post($comite)->post_title]);
   }
   $datosComites['datosComite'] = $datosComite;

   return $datosComites;
}
/******************************************************************************
 * 
 * 
 * Filtra los posts actas y acuerdos por ID y _asignar_id y los
 * orderna por fecha en forma descendente.
 * 
 * 
 *****************************************************************************/

function fgh000_pre_get_acuerdo($query)
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
               if (fgh000_miembroJunta() || fgh000_get_page_att()['userAdmin']) {
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
            if (fgh000_get_page_att()['userAdmin']) {
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
add_action('pre_get_posts', 'fgh000_pre_get_acuerdo');