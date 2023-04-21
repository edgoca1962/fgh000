<?php

if (!function_exists('fgh000_get_post_param')) {
   function fgh000_get_post_param($postType = 'post')
   {
      $atributos = [];

      $fullpage = false;
      $titulo = 'Blog';
      $fontweight = 'fw-lighter';
      $display = 'display-4';
      $subtitulo = '';
      $displaysub = 'display-5';
      $subtitulo2 = '';
      $displaysub2 = 'display-6';
      $height = '60vh';
      $div0 = 'container py-5';
      $div1 = '';
      $div2 = '';
      $div3 = '';
      $div4 = '';
      $agregarpost = '';
      $templatepart = 'modules/' . $postType . '/template-parts/' . $postType;
      $barra = '';
      $templatepartsingle = 'modules/' . $postType . '/template-parts/' . $postType . '-single';
      $btn_regresar = 'modules/' . $postType . '/template-parts/' . $postType . '-regresar';
      $regresar = $postType;
      if (get_the_post_thumbnail_url()) {
         $imagen = get_the_post_thumbnail_url();
      } else {
         $imagen = get_template_directory_uri() . '/assets/img/bg.jpg';
      }
      if (get_the_archive_title() == 'Archives' || get_the_archive_title() == 'Archivos') {
         $subtitulo = '';
      } else {
         $subtitulo = str_replace('Tag', 'Etiqueta', get_the_archive_title(), $count);
      }
      if (is_single()) {
         $subtitulo = get_the_title();
      } else {
         $div3 = 'row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4';
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
      $atributos['btn_regresar'] = $btn_regresar;
      $atributos['regresar'] = $regresar;
      return $atributos;
   }
}