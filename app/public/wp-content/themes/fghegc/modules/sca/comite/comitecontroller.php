<?php

namespace FGHEGC\Modules\Sca\Comite;

use FGHEGC\modules\core\Singleton;

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
      $this->atributos['subtitulo'] = $this->get_parametros($postType)['subtitulo'];
      $this->atributos['div2'] = 'row';
      $this->atributos['div3'] = 'col-md-8';
      $this->atributos['div4'] = $this->get_parametros($postType)['div4'];
      $this->atributos['div5'] = 'col-md-4';
      $this->atributos['agregarpost'] = $this->get_parametros($postType)['agregarpost'];
      $this->atributos['templatepart'] = $this->get_parametros($postType)['templatepart'];
      $this->atributos['sidebar'] = 'modules/sca/acuerdo/view/sidebar-busquedas';
      $this->atributos['miembros'] = $this->get_parametros($postType)['miembros'];
      $this->atributos['actas'] = $this->get_parametros($postType)['actas'];
      $this->atributos['acuerdos'] = $this->get_parametros($postType)['acuerdos'];

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

      $miembros = get_posts(
         [
            'numberposts' => -1,
            'post_type' => 'miembro',
            'post_status' => 'publish',
            'meta_key' => '_comite_id',
            'meta_value' => get_the_ID()
         ]
      );
      $parametros['miembros'] = count($miembros);

      $actas = get_posts(
         [
            'numberposts' => -1,
            'post_type' => 'acta',
            'post_status' => 'publish',
            'meta_key' => '_comite_id',
            'meta_value' => get_the_ID()
         ]
      );
      $parametros['actas'] = count($actas);

      $acuerdos = get_posts([
         'numberposts' => -1,
         'post_type' => 'acuerdo',
         'post_status' => 'publish',
         'meta_key' => '_comite_id',
         'meta_value' => get_the_ID()
      ]);
      $parametros['acuerdos'] = count($acuerdos);

      return $parametros;
   }
}
