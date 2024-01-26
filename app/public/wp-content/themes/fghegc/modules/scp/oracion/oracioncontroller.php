<?php

namespace FGHEGC\Modules\Scp\Oracion;

use FGHEGC\Modules\Core\Singleton;

class OrcionController
{
   use Singleton;

   public $atributos;

   private function __construct()
   {
      $this->atributos = [];
   }
   public function get_atributos($postType)
   {
      return $this->atributos;
   }
   private function get_datosAtributos()
   {
      $datosAtributos = [];
      return $datosAtributos;
   }
}
