<?php
require get_template_directory() . "/modules/comite/inc/comite.php";
/******************************************************************************
 * 
 * 
 * Parámetros para comités.
 * 
 * 
 *****************************************************************************/
if (!function_exists('fgh000_get_comite_param')) {
   function fgh000_get_comite_param($postType = 'comite')
   {
      $atributos = [];

      $fullpage = false;
      $titulo = 'Comités';
      $fontweight = 'fw-lighter';
      $display = 'display-4';
      $subtitulo = '';
      $displaysub = 'display-5';
      $subtitulo2 = '';
      $displaysub2 = 'display-6';
      $height = '60vh';
      $div0 = 'container py-5';
      $div1 = 'row';
      $div2 = 'col-md-8';
      $div3 = '';
      $div4 = 'col-md-4';
      $agregarpost = 'modules/' . $postType . '/template-parts/' . $postType . '-mantenimiento';
      $templatepart = 'modules/' . $postType . '/template-parts/' . $postType;
      $templatenone = 'modules/acuerdo/template-parts/acuerdo-none';
      $barra = 'modules/acuerdo/template-parts/acuerdo-busquedas';
      $templatepartsingle = 'modules/' . $postType . '/template-parts/' . $postType . '-single';
      $template404 = 'modules/acuerdo/template-parts/acuerdo-404';
      $btn_regresar = 'modules/' . $postType . '/template-parts/' . $postType . '-regresar';
      $regresar = $postType;
      if (get_the_post_thumbnail_url()) {
         $imagen = get_the_post_thumbnail_url();
      } else {
         $imagen = get_template_directory_uri() . '/assets/img/bg.jpg';
      }
      if (is_single()) {
         $subtitulo = get_the_title();
      } else {
         $div3 = 'row row-cols-1 row-cols-md-2 row-cols-lg-2 g-4';
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
      $atributos['barra'] = $barra;
      $atributos['templatepartsingle'] = $templatepartsingle;
      $atributos['templatenone'] = $templatenone;
      $atributos['template404'] = $template404;
      $atributos['btn_regresar'] = $btn_regresar;
      $atributos['regresar'] = $regresar;
      $objeto = new fgh000Conteos();
      $conteos = $objeto->conteos;
      $atributos = array_merge($atributos, $conteos);
      return $atributos;
   }
}
class fgh000Conteos
{
   public $conteos;
   private $miembros;
   private $actas;
   private $acuerdos;

   public function __construct()
   {
      $this->conteos['miembros'] = $this->get_miembros();
      $this->conteos['actas'] = $this->get_actas();
      $this->conteos['acuerdos'] = $this->get_acuerdos();
      return $this->conteos;
   }
   private function get_miembros()
   {
      $this->miembros = get_posts(
         [
            'numberposts' => -1,
            'post_type' => 'miembro',
            'post_status' => 'publish',
            'meta_key' => '_comite_id',
            'meta_value' => get_the_ID()
         ]
      );

      return count($this->miembros);
   }
   private function get_actas()
   {
      $this->actas = get_posts(
         [
            'numberposts' => -1,
            'post_type' => 'acta',
            'post_status' => 'publish',
            'meta_key' => '_comite_id',
            'meta_value' => get_the_ID()
         ]
      );
      return count($this->actas);
   }
   private function get_acuerdos()
   {
      $this->acuerdos = get_posts([
         'numberposts' => -1,
         'post_type' => 'acuerdo',
         'post_status' => 'publish',
         'meta_key' => '_comite_id',
         'meta_value' => get_the_ID()
      ]);
      return count($this->acuerdos);
   }
}
/******************************************************************************
 * 
 * 
 * Obtiene el ID y el nombre de los comités.
 * 
 * 
 *****************************************************************************/
if (!function_exists('fgh000_get_comites')) {
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