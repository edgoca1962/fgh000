<?php

namespace EGC001\Modules\Scc\Asistencia;

use EGC001\Modules\Core\Singleton;

class AsistenciaController
{
   use Singleton;
   private $atributos;
   private function __construct()
   {
      $this->atributos = $this->get_atributos();
   }
   public function get_atributos()
   {
      $this->atributos = [];

      /*
      $this->atributos['imagen'] = EGC001_DIR_URI . '/assets/img/manosorando.jpeg';
      $this->atributos['titulo'] = 'Forjadores de Esperanza';
      $this->atributos['displaysub'] = 'fs-4';
      $this->atributos['displaysub2'] = 'fs-5';
      $this->atributos['div3'] = '';
      $this->atributos['sidebarlefttemplate'] = '';
      $this->atributos['div4'] = 'col-md-8';
      $this->atributos['templatepartnone'] = 'modules/scc/beneficiario/view/beneficiario-none';
      $this->atributos['div8'] = 'col-md-4';
      $this->atributos['sidebarrighttemplate'] = 'modules/scc/beneficiario/view/beneficiario-sidebar';
      $this->atributos['footerclass'] = 'pt-5';
      $this->atributos['footertemplate'] = 'modules/scc/beneficiario/view/beneficiario-footer';
      */

      return $this->atributos;
   }
}
