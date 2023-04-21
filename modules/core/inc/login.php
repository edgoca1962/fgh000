<?php
function fgh000ingresar()
{
   //Validación de seguridad
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
         wp_send_json_error('error_ingreso');
      } else {
         wp_send_json_success('ingreso');
      }
      wp_die();
   }
}
add_action('wp_ajax_nopriv_ingresar', 'fgh000ingresar');

function fgh000cambiar_clave()
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
               wp_send_json_error('Información incorrecta.');
            } else {
               wp_set_password($clave_nueva, $current_user->ID);
               wp_send_json_success('Cambio clave exitoso');
            }
         } else {
            wp_send_json_error('Información incorrecta.');
         }
      } else {
         wp_send_json_error('Información incorrecta.');
      }
   }
   wp_die();
}
add_action('wp_ajax_cambiar_clave', 'fgh000cambiar_clave');