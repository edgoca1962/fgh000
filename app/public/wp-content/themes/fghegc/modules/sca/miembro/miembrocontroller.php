<?php

namespace FGHEGC\Modules\Sca\Miembro;

use FGHEGC\modules\core\Singleton;

class MiembroController
{
   use Singleton;
   public $atributos;
   private function __construct()
   {
      $this->atributos = [];
   }
   public function get_atributos($postType)
   {
      $this->atributos['titulo'] = 'Miembros';
      $this->atributos['subtitulo'] = $this->get_parametros($postType)['subtitulo'];
      $this->atributos['div2'] = 'row';
      $this->atributos['div3'] = 'col-md-8';
      $this->atributos['div4'] = $this->get_parametros($postType)['div4'];
      $this->atributos['div5'] = 'col-md-4';
      $this->atributos['agregarpost'] = $this->get_parametros($postType)['agregarpost'];
      $this->atributos['sidebar'] = 'modules/sca/acuerdo/view/sidebar-busquedas';
      $this->atributos['templatepart'] = $this->get_parametros($postType)['templatepart'];
      $this->atributos['regresar'] = $postType;

      return $this->atributos;
   }
   private function get_parametros($postType)
   {
      $parametros = [];
      if (is_user_logged_in()) {
         $usuarioRoles = wp_get_current_user()->roles;
         if (in_array('administrator', $usuarioRoles) || in_array('useradmingeneral', $usuarioRoles) || in_array('useradmincomite', $usuarioRoles)) {
            $parametros['agregarpost'] = 'modules/sca/' . $postType . '/view/' . $postType . '-agregar';
         } else {
            $parametros['agregarpost'] = '';
         }
      }

      if (is_single()) {
         $parametros['templatepart'] = 'modules/sca/' . $postType . '/view/' . $postType . '-single';
         $parametros['subtitulo'] = get_the_title();
         $parametros['div4'] = '';
      } else {
         $parametros['templatepart'] = 'modules/sca/' . $postType . '/view/' . $postType;
         $parametros['subtitulo'] = '';
         $parametros['div4'] = 'row row-cols-1 row-cols-md-2 g-4 pb-3';
      }
      return $parametros;
   }
}
