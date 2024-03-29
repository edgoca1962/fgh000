<?php

namespace FGHEGC\Modules\Music;

use FGHEGC\modules\core\Singleton;

class MusicController
{
   use Singleton;
   public $atributos;
   private function __construct()
   {
      $this->atributos = [];
   }
   public function get_atributos($postType)
   {
      $this->atributos['titulo'] = 'Música';
      $this->atributos['subtitulo'] = $this->get_datosAtributos($postType)['subtitulo'];
      $this->atributos['div2'] = 'row';
      $this->atributos['div3'] = 'col-md-9';
      $this->atributos['div4'] = $this->get_datosAtributos($postType)['div4'];
      $this->atributos['div5'] = 'col-md-3';
      $this->atributos['agregarpost'] = $this->get_datosAtributos($postType)['agregarpost'];
      $this->atributos['sidebar'] = $this->get_datosAtributos($postType)['sidebar'];
      $this->atributos['templatepart'] = $this->get_datosAtributos($postType)['templatepart'];
      $this->atributos['templatepartnone'] = $this->get_datosAtributos($postType)['templatepartnone'];
      $this->atributos['regresar'] = $postType;

      return $this->atributos;
   }
   private function get_datosAtributos($postType)
   {
      $datosAtributos = [];
      $datosAtributos['agregarpost'] = '';

      if (is_user_logged_in()) {
         $usuarioRoles = wp_get_current_user()->roles;
         $datosAtributos['userAdminMusic'] = false;
         if (in_array('administrator', $usuarioRoles) || in_array('useradmingeneral', $usuarioRoles) || in_array('useradminmusic', $usuarioRoles)) {
            $datosAtributos['userAdminMusic'] = true;
            $datosAtributos['agregarpost'] = 'modules/' . $postType . '/view/' . $postType . '-agregar';
         }
      }

      if (is_single()) {
         $datosAtributos['templatepart'] = 'modules/' . $postType . '/view/' . $postType . '-single';
         $datosAtributos['subtitulo'] = get_the_title();
         $datosAtributos['div4'] = '';
      } else {
         $datosAtributos['templatepart'] = 'modules/' . $postType . '/view/' . $postType;
         $datosAtributos['subtitulo'] = '';
         $datosAtributos['div4'] = 'row row-cols-1 row-cols-md-4 g-4 pb-3';
      }

      $datosAtributos['sidebar'] = '';
      if (!isset($_GET['cpt'])) {
         $datosAtributos['sidebar'] = 'modules/' . $postType . '/view/' . $postType . '-sidebar';
      }
      $datosAtributos['templatepartnone'] = 'modules/' . $postType . '/view/' . $postType . '-none';

      return $datosAtributos;
   }
}
