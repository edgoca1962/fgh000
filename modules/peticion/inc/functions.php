<?php
require get_template_directory() . "/modules/oracion/inc/oracion.php";
require get_template_directory() . "/modules/peticion/inc/peticion.php";
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
   'name' => 'peticion-principal',
]);
if (count($principal) > 0) {
} else {
   $post_data = array(
      'post_type' => 'page',
      'post_title' => 'Peticiones',
      'post_name' => 'peticion-principal',
      'post_status' => 'publish',
   );
   wp_insert_post($post_data);
}
/******************************************************************************
 * 
 * 
 * Obtiene parámetros para peticiones.
 * 
 * 
 ******************************************************************************/
if (!function_exists('fgh000_get_peticion_param')) {
   function fgh000_get_peticion_param($postType = 'peticion')
   {
      $atributos = [];

      $fullpage = false;
      $titulo = 'Peticiones';
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
      // $agregarpost = 'modules/' . $postType . '/template-parts/' . $postType . '-mantenimiento';
      $templatepart = 'modules/' . $postType . '/template-parts/' . $postType;
      // $barra = 'modules/' . $postType . '/template-parts/' . $postType . '-barra';
      $templatepartsingle = 'modules/' . $postType . '/template-parts/' . $postType . '-single';
      // $template404 = 'modules/core/template-parts/core-404';
      $btn_regresar = 'modules/core/template-parts/core-btn-regresar';
      $regresar = $postType;




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
      // $atributos['agregarpost'] = $agregarpost;
      $atributos['templatepart'] = $templatepart;
      // $atributos['barra'] = $barra;
      $atributos['templatepartsingle'] = $templatepartsingle;
      // $atributos['template404'] = $template404;
      $atributos['btn_regresar'] = $btn_regresar;
      $atributos['regresar'] = $regresar;
      return $atributos;
   }
}