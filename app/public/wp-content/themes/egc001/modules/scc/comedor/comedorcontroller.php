<?php

namespace EGC001\Modules\Scc\Comedor;

use EGC001\Modules\Core\Singleton;

class ComedorController
{
   use Singleton;
   private $atributos;
   private function __construct()
   {
      $this->atributos = [];
   }
   public function get_atributos($postType)
   {
      $this->atributos['titulo'] = 'Listado de Comedores';
      $this->atributos['div2'] = 'row';
      $this->atributos['div3'] = 'col-md-8';
      $this->atributos['div5'] = 'col-md-4';
      $this->atributos['displaysub'] = 'fs-4';
      $this->atributos['displaysub2'] = 'fs-5';
      $this->atributos['templatepartnone'] = 'modules/scc/' . $postType . '/view/' . $postType . '-none';
      $this->atributos['sidebar'] = 'modules/scc/beneficiario/view/beneficiario-sidebar';
      $this->atributos['imagen'] = EGC001_DIR_URI . '/assets/img/manosorando.jpeg';
      $this->atributos['regresar'] = $postType;

      $this->atributos['templatepart'] = $this->get_datosAtributos($postType)['templatepart'];
      $this->atributos['subtitulo'] = $this->get_datosAtributos($postType)['subtitulo'];
      $this->atributos['subtitulo2'] = $this->get_datosAtributos($postType)['subtitulo2'];
      $this->atributos['div4'] = $this->get_datosAtributos($postType)['div4'];

      return $this->atributos;
   }
   private function get_datosAtributos($postType)
   {
      if (is_single()) {
         $datosAtributos['templatepart'] = 'modules/scc/' . $postType . '/view/' . $postType . '-single';
         $datosAtributos['subtitulo'] = '';
         $datosAtributos['subtitulo2'] = get_the_title();
         $datosAtributos['div4'] = '';
      } else {
         $datosAtributos['templatepart'] = 'modules/scc/' . $postType . '/view/' . $postType;
         $datosAtributos['subtitulo'] = 'Pero Jesús Dijo: Dejad a los niños venir a mi, y no se lo inpidáis; porque de los tales es el reino de los cielos.';
         $datosAtributos['subtitulo2'] = 'Mateo 19:14 (RVR1960)';
         $datosAtributos['div4'] = 'row row-cols-1 row-cols-md-3 g-4';
      }
      return $datosAtributos;
   }
}
