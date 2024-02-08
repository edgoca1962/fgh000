<?php

namespace FGHEGC\Modules\Scc\DivPolCri;

use FGHEGC\Modules\Core\Singleton;

class DivPolCri
{
   use Singleton;
   private $atributos;
   private function __construct()
   {
      $this->atributos = [];
   }
   public function get_atributos($postType)
   {
      $this->atributos['titulo'] = 'División Política de Costa Rica';
      $this->atributos['div2'] = 'row';
      $this->atributos['div3'] = 'col-md-8';
      $this->atributos['div5'] = 'col-md-4';
      $this->atributos['templatepartnone'] = 'modules/scc/' . $postType . '/view/' . $postType . '-none';
      $this->atributos['sidebar'] = 'modules/scc/acuerdo/view/beneficiario-sidebar';
      $this->atributos['imagen'] = FGHEGC_DIR_URI . '/assets/img/scclogotransparente.png';

      $this->atributos['subtitulo'] = $this->get_datosAtributos($postType)['subtitulo'];
      $this->atributos['div4'] = $this->get_datosAtributos($postType)['div4'];
      $this->atributos['agregarpost'] = $this->get_datosAtributos($postType)['agregarpost'];
      $this->atributos['templatepart'] = $this->get_datosAtributos($postType)['templatepart'];

      return $this->atributos;
   }
   private function get_datosAtributos($postType)
   {
      $datosAtributos = [];
      $datosAtributos['agregarpost'] = '';
      $datosAtributos['verbeneficiarios'] = false;
      $datosAtributos['userAdmin'] = false;
      if (is_user_logged_in()) {
         $usuarioRoles = wp_get_current_user()->roles;
         if (in_array('administrator', $usuarioRoles) || in_array('useradmingeneral', $usuarioRoles) || in_array('useradminbeneficiarios', $usuarioRoles) || in_array('beneficiarios', $usuarioRoles)) {
            $datosAtributos['verbeneficiarios'] = true;
            if (in_array('administrator', $usuarioRoles) || in_array('useradmingeneral', $usuarioRoles) || in_array('useradminbeneficiarios', $usuarioRoles)) {
               $datosAtributos['userAdmin'] = true;
               $datosAtributos['agregarpost'] = 'modules/scc/' . $postType . '/view/' . $postType . '-agregar';
            }
         }
      }

      if (is_single()) {
         $datosAtributos['templatepart'] = 'modules/scc/' . $postType . '/view/' . $postType . '-single';
         $datosAtributos['subtitulo'] = get_the_title();
         $datosAtributos['div4'] = '';
      } else {
         $datosAtributos['templatepart'] = 'modules/scc/' . $postType . '/view/' . $postType;
         $datosAtributos['subtitulo'] = '';
         $datosAtributos['div4'] = 'row row-cols-1 row-cols-md-2 g-4 pb-3';
      }

      return $datosAtributos;
   }
}
