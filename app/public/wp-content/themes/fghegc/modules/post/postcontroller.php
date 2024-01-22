<?php

namespace FGHEGC\Modules\Post;

use FGHEGC\Modules\Core\Singleton;

class PostController
{
   use Singleton;
   private $atributos;

   private function __construct()
   {
      $this->atributos = [];
   }

   public function get_atributos($postType)
   {
      $this->atributos['titulo'] = 'Blog';
      $this->atributos['div4'] = $this->get_div4();
      $this->atributos['regresar'] = $postType;
      $this->atributos['templatepart'] = $this->get_templatepart($postType);

      return $this->atributos;
   }
   private function get_div4()
   {
      if (is_single()) {
         $div4 = '';
      } else {
         $div4 = 'row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4 pb-3';
      }
      return $div4;
   }
   private function get_templatepart($postType)
   {
      if (is_single()) {
         $templatepart = 'modules/' . $postType . '/view/' . $postType . '-single';
      } else {
         $templatepart = 'modules/' . $postType . '/view/' . $postType;
      }
      return $templatepart;
   }
}
