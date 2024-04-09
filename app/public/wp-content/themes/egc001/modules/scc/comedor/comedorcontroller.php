<?php

namespace EGC001\Modules\Scc\Comedor;

use EGC001\Modules\Core\Singleton;
use EGC001\Modules\Scc\Beneficiario\BeneficiarioController;

class ComedorController
{
   use Singleton;
   private $atributos;
   private function __construct()
   {
      $this->atributos = $this->get_atributos();
   }
   public function get_atributos($postType = 'comedor')
   {
      $this->atributos = BeneficiarioController::get_instance()->get_atributos();
      $this->atributos['titulo'] = get_the_title();
      $this->atributos['templatepart'] = $this->get_datosAtributos($postType)['templatepart'];
      $this->atributos['div6'] = $this->get_datosAtributos($postType)['div6'];
      $this->atributos['div7'] = $this->get_datosAtributos($postType)['div7'];
      $this->atributos['menues'] = $this->get_datosAtributos($postType)['menues'];

      return $this->atributos;
   }
   private function get_datosAtributos($postType)
   {
      $datosAtributos['div6'] = '';
      $datosAtributos['div7'] = '';
      $datosAtributos['menues'] = get_posts(['post_type' => 'menu', 'posts_per_page' => -1, 'post_status' => 'publish', 'post_parent' => get_the_ID()]);

      if (is_single()) {
         $datosAtributos['templatepart'] = 'modules/scc/' . $postType . '/view/' . $postType . '-single';
         $datosAtributos['subtitulo'] = '';
         $datosAtributos['subtitulo2'] = get_the_title();
      } else {
         if (is_page()) {
            $datosAtributos['templatepart'] = 'modules/scc/' . $postType . '/view/' . get_post(get_the_ID())->post_name;
         } else {
            $datosAtributos['templatepart'] = 'modules/scc/' . $postType . '/view/' . $postType;
            $datosAtributos['div6'] = 'container my-5';
            $datosAtributos['div7'] = 'row row-cols-1 row-cols-md-3 g-4';
         }
      }

      return $datosAtributos;
   }
}
