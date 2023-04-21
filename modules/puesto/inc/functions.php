<?php
require get_template_directory() . "/modules/puesto/inc/puesto.php";
/******************************************************************************
 * 
 * 
 * Parámetros para puesto.
 * 
 * 
 *****************************************************************************/
if (!function_exists('fgh000_get_puesto_param')) {
   function fgh000_get_puesto_param($postType = 'puesto')
   {
      $atributos = [];

      $fullpage = false;
      $titulo = 'Puestos';
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
      $barra = 'modules/acuerdo/template-parts/acuerdo-busquedas';
      $templatepartsingle = 'modules/' . $postType . '/template-parts/' . $postType . '-single';
      $templatenone = 'modules/acuerdo/template-parts/acuerdo-none';
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
      return $atributos;
   }
}