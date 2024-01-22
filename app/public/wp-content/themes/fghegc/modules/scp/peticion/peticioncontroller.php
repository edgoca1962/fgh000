<?php

namespace FGHEGC\Modules\Scp\Peticion;

use FGHEGC\Modules\Core\Singleton;

class PeticionController
{
   use Singleton;
   public $atributos;
   private function __construct($postType = 'peticion')
   {
      $this->atributos = [];
      $this->atributos['titulo'] = 'Peticiones';
      $this->atributos['subtitulo'] = $this->get_atributos($postType)['subtitulo'];
      $this->atributos['div2'] = 'row';
      $this->atributos['div3'] = 'col-md-9';
      $this->atributos['div4'] = $this->get_atributos($postType)['div4'];
      $this->atributos['div5'] = 'col-md-3';
      $this->atributos['agregarpost'] = $this->get_atributos($postType)['agregarpost'];
      $this->atributos['sidebar'] = $this->get_atributos($postType)['sidebar'];
      $this->atributos['templatepart'] = $this->get_atributos($postType)['templatepart'];
      $this->atributos['templatepartnone'] = $this->get_atributos($postType)['templatepartnone'];
      $this->atributos['regresar'] = $postType;
   }
   private function get_atributos($postType)
   {
      $datosAtributos['agregarpost'] = '';
      $datosAtributos['sidebar'] = '';
      if (is_user_logged_in()) {
         $usuarioRoles = wp_get_current_user()->roles;
         if (in_array('administrator', $usuarioRoles) || in_array('useradmingeneral', $usuarioRoles) || in_array('useradminpeticion', $usuarioRoles)) {
            $datosAtributos['agregarpost'] = 'modules/scp/' . $postType . '/view/' . $postType . '-agregar';
            $datosAtributos['sidebar'] = 'modules/scp/' . $postType . '/view/' . $postType . '-busquedas';
         }
      }

      $datosAtributos['templatepart'] = 'modules/scp/' . $postType . '/view/' . $postType;
      $datosAtributos['subtitulo'] = '';
      $datosAtributos['div4'] = 'row row-cols-1 g-4 pb-3';
      $datosAtributos['templatepartnone'] = 'modules/scp/' . $postType . '/view/' . $postType . '-none';
      if (is_single()) {
         $datosAtributos['templatepart'] = 'modules/scp/' . $postType . '/view/' . $postType . '-single';
         $datosAtributos['subtitulo'] = get_the_title();
         $datosAtributos['div4'] = '';
      }

      return $datosAtributos;
   }
}
