<?php

namespace EGC001\Modules\Post;

use EGC001\Modules\Core\Singleton;

class PostController
{
   use Singleton;
   private $atributos;

   private function __construct()
   {
      $this->atributos = [];
   }

   public function get_atributos($postType = 'post')
   {
      $this->atributos['titulo'] = 'Blog';
      $this->atributos['div7'] = $this->get_datosAtributos($postType)['div7'];
      $this->atributos['regresar'] = $postType;
      $this->atributos['templatepart'] = $this->get_datosAtributos($postType)['templatepart'];
      $this->atributos['userAdminPost'] = $this->get_datosAtributos($postType)['userAdminPosts'];

      return $this->atributos;
   }
   private function get_datosAtributos($postType)
   {
      $datosAtributos['userAdminPosts'] = true;
      if (is_user_logged_in()) {
         $usuarioRoles = wp_get_current_user()->roles;
         $datosAtributos['userAdminPosts'] = false;
         if (in_array('administrator', $usuarioRoles) || in_array('useradmingeneral', $usuarioRoles) || in_array('useradminposts', $usuarioRoles)) {
            $datosAtributos['userAdminPosts'] = true;
         }
      }
      if (is_single()) {
         $datosAtributos['templatepart'] = 'modules/' . $postType . '/view/' . $postType . '-single';
         $datosAtributos['div7'] = '';
      } else {
         $datosAtributos['templatepart'] = 'modules/' . $postType . '/view/' . $postType;
         $datosAtributos['div7'] = 'row row-cols-1 row-cols-md-3 g-4 pb-3';
      }
      $datosAtributos['templatepartnone'] = 'modules/' . $postType . '/view/' . $postType . '-none';
      return $datosAtributos;
   }
}
