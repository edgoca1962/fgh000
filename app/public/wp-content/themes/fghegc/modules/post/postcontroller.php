<?php

namespace FGHEGC\Modules\Post;

use FGHEGC\Modules\Core\Singleton;

class PostController
{
   use Singleton;
   private $atributos;

   private function __construct($postType = 'post')
   {
      $this->atributos['titulo'] = 'Blog';
      $this->atributos['div4'] = $this->get_atributos($postType)['div4'];
      $this->atributos['regresar'] = $postType;
      $this->atributos['templatepart'] = $this->get_atributos($postType)['templatepart'];

      return $this->atributos;
   }

   private function get_atributos($postType)
   {
      if (is_single()) {
         $datosAtributos['templatepart'] = 'modules/' . $postType . '/view/' . $postType . '-single';
         $datosAtributos['div4'] = '';
      } else {
         $datosAtributos['templatepart'] = 'modules/' . $postType . '/view/' . $postType;
         $datosAtributos['div4'] = 'row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4 pb-3';
      }
      $datosAtributos['templatepartnone'] = 'modules/' . $postType . '/view/' . $postType . '-none';
      return $datosAtributos;
   }
}