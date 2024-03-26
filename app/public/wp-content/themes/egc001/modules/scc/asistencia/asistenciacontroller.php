<?php

namespace EGC001\Modules\Scc\Asistencia;

use EGC001\Modules\Core\Singleton;

class AsistenciaController
{
   use Singleton;
   private $atributos;
   private function __construct()
   {
      $this->atributos = [];
   }
   public function get_atributos($postType = 'beneficiario')
   {
      $this->atributos['titulo'] = 'Forjadores de Esperanza';
      $this->atributos['templatepartnone'] = 'modules/scc/' . $postType . '/view/' . $postType . '-none';
      $this->atributos['sidebar'] = 'modules/scc/beneficiario/view/beneficiario-sidebar';
      $this->atributos['imagen'] = EGC001_DIR_URI . '/assets/img/manosorando.jpeg';
      $this->atributos['regresar'] = $postType;

      return $this->atributos;
   }
}
