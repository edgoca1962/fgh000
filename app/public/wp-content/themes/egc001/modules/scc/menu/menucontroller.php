<?php

namespace EGC001\Modules\Scc\Menu;

use EGC001\Modules\Core\Singleton;
use EGC001\Modules\Scc\Beneficiario\BeneficiarioController;

class MenuController
{
   use Singleton;
   private $atributos;
   private function __construct()
   {
      $this->atributos = [];
   }
   public function get_atributos($postType = 'menu')
   {
      $this->atributos = BeneficiarioController::get_instance()->get_atributos();
      $this->atributos['titulo'] = get_the_title();
      $this->atributos['templatepart'] = $this->get_datosAtributos($postType)['templatepart'];
      $this->atributos['div7'] = $this->get_datosAtributos($postType)['div7'];

      return $this->atributos;
   }
   private function get_datosAtributos($postType)
   {
      if (is_single()) {
         $datosAtributos['templatepart'] = 'modules/scc/' . $postType . '/view/' . $postType . '-single';
         $datosAtributos['subtitulo'] = '';
         $datosAtributos['subtitulo2'] = get_the_title();
         $datosAtributos['div7'] = '';
      } else {
         if (is_page()) {
            $datosAtributos['templatepart'] = 'modules/scc/' . $postType . '/view/' . get_post(get_the_ID())->post_name;
            $datosAtributos['div7'] = '';
         } else {
            $datosAtributos['templatepart'] = 'modules/scc/' . $postType . '/view/' . $postType;
            $datosAtributos['div7'] = 'row row-cols-1 row-cols-md-3 g-4';
         }
      }

      return $datosAtributos;
   }
}
