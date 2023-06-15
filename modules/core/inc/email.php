<?php

function fgh000_send_email()
{
   if (!wp_verify_nonce($_POST['nonce'], 'send_email')) {
      wp_send_json_error('Error de seguridad', 401);
      die();
   }

   if (isset($_POST['enlace'])) {
      if (isset($_POST['titulo'])) {
         $titulo = sanitize_text_field($_POST['titulo']);
      } else {
         $titulo = '';
      }
      $enlace = sanitize_text_field($_POST['enlace']);
      $subject = 'Acuerdo vencido: ' . $titulo;
      $mensaje = 'Acuerdo vencido: ';
      $mensaje .= '<a href="' . $enlace . '">' . $titulo . '</a>';
   } else {
      $enlace = '';
      // Subject
      $subject = 'Mensaje de ' . sanitize_text_field($_POST['nombre']) . ' ' . sanitize_text_field($_POST['apellido']);

      //Mensaje
      $mensaje = '';
      $mensaje .= 'Mensaje de ' . sanitize_text_field($_POST['nombre']) . ' ' . sanitize_text_field($_POST['apellido']) . '<br />';
      $mensaje .= 'Correo: ' . sanitize_text_field($_POST['email']) . ' - ' . 'Teléfono: ' . sanitize_text_field($_POST['celular']) . '<br />';
      $mensaje .= 'Mensaje:' . '<br />';
      $mensaje .= sanitize_text_field($_POST['mensaje']) . '<br />';
   }

   //Who is sending the email?
   // $admin_email = get_option('admin_email');
   $admin_email = sanitize_text_field($_POST['enviado_por']);

   //Email Headers
   $headers[] = 'Content-Type: text/html; charset=UTF-8';
   $headers[] = 'From: Administrador(a) <' . $admin_email . '>';
   $headers[] = 'Replay-to: ' . $admin_email;

   //Who are we sending the email to?
   $send_to = sanitize_text_field($_POST['enviar_a']);

   try {
      if (wp_mail($send_to, $subject, $mensaje, $headers)) {
         wp_send_json_success('Email enviado');
      } else {
         wp_send_json_error('Email error');
      }
   } catch (\Exception $e) {
      wp_send_json_error($e->getMessage());
   }
}

add_action('wp_ajax_send_email', 'fgh000_send_email');
add_action('wp_ajax_nopriv_send_email', 'fgh000_send_email');
