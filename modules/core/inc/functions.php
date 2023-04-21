<?php

/**
 * Agrega todas las funcionalidades de los diferentes módulos
 */
require get_template_directory() . "/modules/core/inc/login.php";
require get_template_directory() . "/modules/core/inc/import_csv_file.php";
require get_template_directory() . '/modules/core/inc/twentytwentyone/class-twenty-twenty-one-svg-icons.php';
require get_template_directory() . '/modules/core/inc/twentytwentyone/template-functions.php';
require get_template_directory() . '/modules/core/inc/twentytwentyone/template-tags.php';
require get_template_directory() . "/modules/core/inc/walker.php";
require get_template_directory() . "/modules/post/inc/functions.php";
require get_template_directory() . "/modules/acuerdo/inc/functions.php";
require get_template_directory() . "/modules/evento/inc/functions.php";
require get_template_directory() . "/modules/peticion/inc/functions.php";

/**
 * Crea páginas requeridas.
 */

$login = get_posts([
   'post_type' => 'page',
   'name' => 'core-login',
   'post_status' => 'publish',
]);
if (count($login) > 0) {
} else {
   $post_data = array(
      'post_type' => 'page',
      'post_title' => 'Login',
      'post_name' => 'core-login',
      'post_status' => 'publish',
   );
   wp_insert_post($post_data);
}

/**
 * Obtiene parámetros para todas las plantillas.
 */
if (!function_exists('fgh000_get_param')) {
   function fgh000_get_param($postType = '')
   {
      $atributos = [];

      if (is_user_logged_in()) {
         $usuario = wp_get_current_user();
         $usuario_id = $usuario->ID;
         $usuarioRoles = $usuario->roles;
         if (in_array('administrator', $usuarioRoles) || in_array('author', $usuarioRoles)) {
            $userAdmin = true;
         } else {
            $userAdmin = false;
         }
      } else {
         $usuario_id = '';
         $userAdmin = '';
         $postType = 'page';
      }
      if (is_404()) {
         if (isset($_GET['cpt'])) {
            $postType = sanitize_text_field($_GET['cpt']);
         } else {
            $postType = 'page';
         }
      }
      if (get_the_post_thumbnail_url()) {
         $imagen = get_the_post_thumbnail_url();
      } else {
         $imagen = get_template_directory_uri() . '/assets/img/bg.jpg';
      }
      if (isset(get_post(get_the_ID())->post_name)) {
         $slug = get_post(get_the_ID())->post_name;
         $guion = strpos($slug, '-');
         $modulo = substr($slug, 0, $guion);
         $templatepart = 'modules/' . $modulo . '/template-parts/' . $slug;
      } else {
         $slug = '';
         $modulo = '';
         $templatepart = '';
      }
      if (isset($_GET['cpt'])) {
         $postType = sanitize_text_field($_GET['cpt']);
      }
      if (isset(explode("/", $_SERVER['REQUEST_URI'])[3])) {
         if (explode("/", $_SERVER['REQUEST_URI'])[3] != '') {
            if (explode("/", $_SERVER['REQUEST_URI'])[3] == 'page') {
               $pag = 0; //explode("/", $_SERVER['REQUEST_URI'])[4];
            } else {
               $pag = explode("/", $_SERVER['REQUEST_URI'])[3];
            }
         } else {
            $pag = 0;
         }
      } else {
         $pag = 1;
      }
      if (isset($_GET['pag'])) {
         $pag_ant = sanitize_text_field($_GET['pag']);
      } else {
         $pag_ant = 1;
      }

      $atributos['fullpage'] = true;
      $atributos['height'] = '100vh';
      $atributos['imagen'] = $imagen;

      switch ($postType) {
         case 'page':
            $fullpage = false;
            if (isset($_GET['cptpg'])) {
               $cptpg = sanitize_text_field($_GET['cptpg']);
               if ($cptpg == 'acuerdo') {
                  $titulo = fgh000_get_acuerdo_param('page')['titulo'];
               } else {
                  $titulo = get_the_title();
               }
            } else {
               $titulo = get_the_title();
            }
            $fontweight = 'fw-lighter';
            $display = 'display-4';
            $subtitulo = '';
            $displaysub = 'display-5';
            $subtitulo2 = '';
            $displaysub2 = 'display-6';
            $height = '60vh';
            $div0 = 'background-blend py-5';
            $div1 = 'container';
            if (is_user_logged_in()) {
               if (is_front_page()) {
                  $fullpage = false;
                  $height = '60vh';
               } elseif (is_page('core-none')) {
                  $fullpage = true;
                  $height = '100vh';
                  $div0 = '';
               } elseif (is_404()) {
                  $fullpage = true;
                  $height = '100vh';
                  $titulo = 'Página no existe';
                  $div0 = '';
               } else {
                  $fullpage = false;
                  $height = '60vh';
               }
            } else {
               if (is_page('core-login')) {
                  $fullpage = true;
                  $height = '100vh';
                  $templatepart = 'modules/core/template-parts/core-login';
               } elseif (is_front_page()) {
                  $fullpage = true;
                  $height = '100vh';
                  $titulo = get_the_title();
               } elseif (is_404()) {
                  $fullpage = true;
                  $height = '100vh';
                  $titulo = 'Página no existe';
               } else {
                  $titulo = 'Favor ingresar a la aplicación';
                  $fullpage = true;
                  $height = '100vh';
               }
               $fullpage = true;
            }
            $atributos['imagen'] = $imagen;
            $atributos['fullpage'] = $fullpage;
            $atributos['div1'] = $div1;
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
            $atributos['templatepart'] = $templatepart;
            break;

         case 'post':
            $atributos = fgh000_get_post_param($postType);
            break;

         case 'comite':
            $atributos = fgh000_get_comite_param($postType);
            break;

         case 'acta':
            $atributos = fgh000_get_acta_param($postType);
            break;

         case 'acuerdo':
            $atributos = fgh000_get_acuerdo_param($postType);
            break;

         case 'miembro':
            $atributos = fgh000_get_miembro_param($postType);
            break;

         case 'puesto':
            $atributos = fgh000_get_puesto_param($postType);
            break;

         case 'evento':
            $atributos = fgh000_get_evento_param($postType);
            break;

         case 'peticion':
            $atributos = fgh000_get_peticion_param($postType);
            break;

         default:
            $fullpage = false;
            $titulo = 'Título';
            $fontweight = 'fw-lighter';
            $display = 'display-4';
            $subtitulo = 'Subtítulo';
            $displaysub = 'display-5';
            $subtitulo2 = 'Segundo Subtítulo';
            $displaysub2 = 'display-6';
            $imagen = '';
            $height = '60vh';
            $div1 = 'row';
            break;
      }
      $atributos['usuario_id'] = $usuario_id;
      $atributos['userAdmin'] = $userAdmin;
      $atributos['pag'] = $pag;
      $atributos['pag_ant'] = $pag_ant;
      return $atributos;
   }
}