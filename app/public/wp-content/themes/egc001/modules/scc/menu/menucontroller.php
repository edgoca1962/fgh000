<?php

namespace EGC001\Modules\Scc\Menu;

use EGC001\Modules\Core\Singleton;

class MenuController
{
   use Singleton;
   private $atributos;
   private function __construct()
   {
      $this->atributos = [];
   }
   public function get_atributos($postType)
   {
      $this->atributos['titulo'] = 'Comedor Grano de Trigo';
      $this->atributos['div2'] = 'row';
      $this->atributos['div3'] = 'col-md-8';
      $this->atributos['div5'] = 'col-md-4';
      if (is_single()) {
         $this->atributos['templatepart'] = 'modules/scc/' . $postType . '/view/' . $postType . '-single';
      }
      $this->atributos['templatepartnone'] = 'modules/scc/' . $postType . '/view/' . $postType . '-none';
      $this->atributos['sidebar'] = 'modules/scc/beneficiario/view/beneficiario-sidebar';
      $this->atributos['imagen'] = EGC001_DIR_URI . '/assets/img/DiosdePactos/manosorando.jpeg';
      $this->atributos['regresar'] = $postType;

      return $this->atributos;
   }
}
