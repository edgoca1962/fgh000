<?php

namespace EGC001\Modules\Core;

use EGC001\Modules\Page\PageController;
use EGC001\Modules\Post\PostController;
use EGC001\Modules\Scc\Asistencia\AsistenciaModel;
use EGC001\Modules\Scc\Beneficiario\BeneficiarioController;
use EGC001\Modules\Scc\Beneficiario\BeneficiarioModel;
use EGC001\Modules\Scc\Comedor\ComedorModel;
use EGC001\Modules\Scc\Menu\MenuModel;

class CoreController
{
   use Singleton;
   private $atributo;
   private function __construct()
   {
      ThemeSetup::get_instance();
      AsistenciaModel::get_instance();
      BeneficiarioModel::get_instance();
      ComedorModel::get_instance();
      MenuModel::get_instance();
      $this->set_paginas();
   }
   public function set_atributo($parametro, $valor)
   {
      $this->atributo[$parametro] = $valor;
   }
   public function get_atributo($parametro)
   {
      return $this->atributo[$parametro];
   }
   public function get_atributos()
   {
      $postType = '';
      if (isset($_GET['cpt'])) {
         $postType = sanitize_text_field($_GET['cpt']);
      } else {
         if (get_post_type() == 'page') {
            if (in_array($this->getSlugModulo()['modulo'], EGC001_CPT)) {
               $postType = $this->getSlugModulo()['modulo'];
            } else {
               $postType = get_post_type();
            }
         } else {
            $postType = get_post_type();
         }
      }
      $atributosCore['banner'] = 'modules/core/view/banner';
      $atributosCore['navbar'] = 'modules/core/view/navbar';
      // variables del banner
      $atributosCore['imagen'] = $this->get_datos_atributos()['imagen'];
      $atributosCore['height'] = '60vh';
      $atributosCore['fontweight'] = 'fw-bold';
      $atributosCore['display'] = 'display-3';
      $atributosCore['titulo'] = get_the_title();
      $atributosCore['displaysub'] = 'display-4';
      $atributosCore['subtitulo'] = 'Subtitulo';
      $atributosCore['displaysub2'] = 'display-5';
      $atributosCore['subtitulo2'] = 'Cita, imagen, boton';
      //fin variables banner
      $atributosCore['body'] = 'bg-dark bg-gradient text-white';
      $atributosCore['section'] = '';
      $atributosCore['div1'] = 'container';
      $atributosCore['div2'] = 'row';
      $atributosCore['agregarpost'] = 'modules/core/view/agregarpost';
      $atributosCore['div3'] = '';
      $atributosCore['sidebarlefttemplate'] = '';
      $atributosCore['div4'] = 'col-md-8';
      $atributosCore['div5'] = '';
      $atributosCore['div6'] = '';
      $atributosCore['div7'] = '';
      $atributosCore['templatepart'] = 'modules/core/view/' . $this->getSlugModulo()['slug'];
      $atributosCore['comentarios'] = true;
      $atributosCore['templatepartnone'] = '';
      $atributosCore['div8'] = 'col-md-4';
      $atributosCore['sidebarrighttemplate'] = 'modules/core/view/core-sidebar-right';
      $atributosCore['footerclass'] = 'container pt-5';
      $atributosCore['footertemplate'] = 'modules/core/view/core-footer';
      $atributosModulo = $this->get_atributos_modulo($postType);

      return $this->atributo = array_replace_recursive($atributosCore, $atributosModulo);
   }
   private function get_datos_atributos()
   {
      $datosAtributos = [];
      //Imagen
      $datosAtributos['imagen'] = (get_the_post_thumbnail()) ? get_the_post_thumbnail() : EGC001_DIR_URI . '/assets/img/bg.jpg';

      return $datosAtributos;
   }
   private function get_atributos_modulo($postType)
   {
      switch ($postType) {
         case 'page':
            $atributosModulo = PageController::get_instance()->get_atributos();
            break;

         case 'post':
            $atributosModulo = PostController::get_instance()->get_atributos();
            break;

         case 'beneficiario':
            $atributosModulo = BeneficiarioController::get_instance()->get_atributos();
            break;

         default:
            if (isset($_GET['cpt']) || in_array($this->getSlugModulo()['modulo'], EGC001_CPT)) {
               $titulo = 'No hay un información registrada';
            } else {
               $titulo = 'Página no existe';
            }
            $atributosModulo['navbar'] = 'modules/core/view/navbar';
            $atributosModulo['height'] = '100vh';
            $atributosModulo['titulo'] = $titulo;
            $atributosModulo['sidebarlefttemplate'] = '';
            $atributosModulo['sidebarrightclass'] = '';
            $atributosModulo['sidebarrighttemplate'] = '';
            $atributosModulo['agregarpost'] = '';
            $atributosModulo['footerclass'] = '';
            $atributosModulo['footertemplate'] = '';
            break;
      }
      return $atributosModulo;
   }
   private function getSlugModulo()
   {
      $slug = '';
      $modulo = '';
      if (get_post(get_the_ID())) {
         $slug = get_post(get_the_ID())->post_name;
         $guion = strpos($slug, '-');
         $modulo = substr($slug, 0, $guion);
      }
      return ['slug' => $slug, 'modulo' => $modulo];
   }
   private function set_paginas()
   {
      $paginas = [
         'principal' =>
         [
            'slug' => 'core-principal',
            'titulo' => 'Página Principal'
         ],
         'cambio_clave' =>
         [
            'slug' => 'core-cambio-clave',
            'titulo' => 'Cambio de Contraseña'
         ],
         'login' =>
         [
            'slug' => 'core-login',
            'titulo' => 'Login'
         ],
      ];
      foreach ($paginas as $pagina) {
         $pags = get_posts([
            'post_type' => 'page',
            'post_status' => 'publish',
            'name' => $pagina['slug'],
         ]);
         if (count($pags) > 0) {
         } else {
            $post_data = array(
               'post_type' => 'page',
               'post_title' => $pagina['titulo'],
               'post_name' => $pagina['slug'],
               'post_status' => 'publish',
            );
            wp_insert_post($post_data);
         }
      }
   }
}
