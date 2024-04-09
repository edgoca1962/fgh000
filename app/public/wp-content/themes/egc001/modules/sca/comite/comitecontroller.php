<?php

namespace EGC001\Modules\Sca\Comite;

use EGC001\modules\core\Singleton;

class ComiteController
{
   use Singleton;
   public $atributos;

   private function __construct()
   {
      $this->atributos = [];
   }
   public function get_atributos($postType)
   {
      $this->atributos['titulo'] = 'Comités';
      $this->atributos['subtitulo'] = $this->get_datosAtributos($postType)['subtitulo'];
      $this->atributos['div2'] = 'row';
      $this->atributos['div3'] = 'col-md-8';
      $this->atributos['div4'] = $this->get_datosAtributos($postType)['div4'];
      $this->atributos['div5'] = 'col-md-4';
      $this->atributos['agregarpost'] = $this->get_datosAtributos($postType)['agregarpost'];
      $this->atributos['templatepart'] = $this->get_datosAtributos($postType)['templatepart'];
      $this->atributos['templatepartnone'] = 'modules/sca/' . $postType . '/view/' . $postType . '-none';
      $this->atributos['sidebar'] = 'modules/sca/acuerdo/view/sidebar-busquedas';
      $this->atributos['miembros'] = $this->get_datosAtributos($postType)['miembros'];
      $this->atributos['actas'] = $this->get_datosAtributos($postType)['actas'];
      $this->atributos['acuerdos'] = $this->get_datosAtributos($postType)['acuerdos'];

      return $this->atributos;
   }
   private function get_datosAtributos($postType)
   {
      $datosAtributos = [];
      $datosAtributos['agregarpost'] = '';
      if (is_user_logged_in()) {
         $usuarioRoles = wp_get_current_user()->roles;
         if (in_array('administrator', $usuarioRoles) || in_array('useradmingeneral', $usuarioRoles) || in_array('useradmincomite', $usuarioRoles)) {
            $datosAtributos['agregarpost'] = 'modules/sca/' . $postType . '/view/' . $postType . '-agregar';
         }
      }

      if (is_single()) {
         $datosAtributos['templatepart'] = 'modules/sca/' . $postType . '/view/' . $postType . '-single';
         $datosAtributos['subtitulo'] = get_the_title();
         $datosAtributos['div4'] = '';
      } else {
         $datosAtributos['templatepart'] = 'modules/sca/' . $postType . '/view/' . $postType;
         $datosAtributos['subtitulo'] = '';
         $datosAtributos['div4'] = 'row row-cols-1 row-cols-md-2 g-4 pb-3';
      }

      $miembros = get_posts(
         [
            'numberposts' => -1,
            'post_type' => 'miembro',
            'post_status' => 'publish',
            'meta_key' => '_comite_id',
            'meta_value' => get_the_ID()
         ]
      );
      $datosAtributos['miembros'] = count($miembros);

      $actas = get_posts(
         [
            'numberposts' => -1,
            'post_type' => 'acta',
            'post_status' => 'publish',
            'meta_key' => '_comite_id',
            'meta_value' => get_the_ID()
         ]
      );
      $datosAtributos['actas'] = count($actas);

      $acuerdos = get_posts([
         'numberposts' => -1,
         'post_type' => 'acuerdo',
         'post_status' => 'publish',
         'meta_key' => '_comite_id',
         'meta_value' => get_the_ID()
      ]);
      $datosAtributos['acuerdos'] = count($acuerdos);

      return $datosAtributos;
   }
}
