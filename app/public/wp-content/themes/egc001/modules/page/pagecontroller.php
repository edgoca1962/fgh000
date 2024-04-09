<?php

namespace EGC001\Modules\Page;

use EGC001\Modules\Core\Singleton;
use EGC001\Modules\Scc\Beneficiario\BeneficiarioController;

/**
 * 
 * Controlador de los posts tipo Page
 * 
 * @package:EGC001
 * 
 */

class PageController
{
   use Singleton;
   private $atributo;
   private function __construct()
   {
      $this->atributo = [];
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
      $this->atributo['agregarpost'] = '';

      if (is_front_page() || is_page('core-principal') || is_page('core-login')) {
         $fullpage = false;
         if ($fullpage) {
            $this->atributo['height'] = ($fullpage) ? '100dvh' : '30dvh';
         }

         if (is_page('core-login')) {
            $this->atributo['banner'] = '';
            $this->atributo['navbar'] = '';
            $this->atributo['titulo'] = '';
            $this->atributo['height'] = '100dvh';
            $this->atributo['section'] = '';
            $this->atributo['div1'] = '';
            $this->atributo['div2'] = '';
            $this->atributo['agregarpost'] = '';
            $this->atributo['div3'] = '';
            $this->atributo['sidebarlefttemplate'] = '';
            $this->atributo['div4'] = '';
            $this->atributo['div5'] = '';
            $this->atributo['div6'] = '';
            $this->atributo['div7'] = '';
            $this->atributo['div8'] = '';
            $this->atributo['sidebarrighttemplate'] = '';
         }
         $this->atributo['footerclass'] = '';
         $this->atributo['footertemplate'] = '';
      }
      return $this->atributo;
   }
}
