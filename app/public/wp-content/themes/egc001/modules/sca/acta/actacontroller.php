<?php

namespace EGC001\Modules\Sca\Acta;

use EGC001\modules\core\Singleton;

class ActaController
{
   use Singleton;
   public $atributos;

   private function __construct()
   {
      $this->atributos = [];
   }
   public function get_atributos($postType)
   {
      $this->atributos['titulo'] = $this->get_datosAtributos($postType)['titulo'];
      $this->atributos['subtitulo'] = $this->get_datosAtributos($postType)['subtitulo'];
      $this->atributos['div2'] = 'row';
      $this->atributos['div3'] = 'col-md-8';
      $this->atributos['div4'] = $this->get_datosAtributos($postType)['div4'];
      $this->atributos['div5'] = 'col-md-4';
      $this->atributos['agregarpost'] = $this->get_datosAtributos($postType)['agregarpost'];
      $this->atributos['sidebar'] = 'modules/sca/acuerdo/view/sidebar-busquedas';
      $this->atributos['templatepart'] = $this->get_datosAtributos($postType)['templatepart'];
      $this->atributos['templatepartnone'] = 'modules/sca/' . $postType . '/view/' . $postType . '-none';
      $this->atributos['regresar'] = $postType;
      $this->atributos['comite_id'] = $this->get_datosAtributos($postType)['comite_id'];
      $this->atributos['consecutivo'] = $this->get_datosAtributos($postType)['qryconsecutivo'];
      $this->atributos['num_actas'] = $this->get_datosAtributos($postType)['num_actas'];
      $this->atributos['prefijo'] = $this->get_datosAtributos($postType)['prefijo'];

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
      if (isset($_GET['comite_id']) != null) {
         $comite_id = sanitize_text_field($_GET['comite_id']);
         $datosAtributos['comite_id'] = $comite_id;
         $comite = get_post($comite_id)->post_title;
         if (preg_match("/Junta/i", $comite)) {
            $datosAtributos['titulo'] = "Actas de " . $comite;
            $datosAtributos['prefijo'] = 'Acta';
         } else {
            $datosAtributos['titulo'] = "Minutas del " . $comite;
            $datosAtributos['prefijo'] = 'Minuta';
         }
         global $wpdb;

         $datosAtributos['qryconsecutivo'] = $wpdb->get_var(
            "SELECT MAX(cast(t01.meta_value as unsigned))+1 consecutivo
            FROM $wpdb->posts
            INNER JOIN $wpdb->postmeta t01 ON (ID = t01.post_id)
            INNER JOIN $wpdb->postmeta t02 ON (ID = t02.post_id)
            WHERE 1=1
            AND (
            (t01.meta_key = '_n_acta')
            AND (t02.meta_key = '_comite_id' and t02.meta_value = " . $comite_id . ")
            )
            AND post_type = 'acta' AND post_status = 'publish'"
         );
         $qry_n_actas = $wpdb->get_results(
            "SELECT t01.meta_value
            FROM $wpdb->posts
            INNER JOIN $wpdb->postmeta t01 ON (ID = t01.post_id)
            INNER JOIN $wpdb->postmeta t02 ON (ID = t02.post_id)
            WHERE 1 = 1
            AND (
            (t01.meta_key = '_n_acta' AND t01.meta_value != '')
            AND (t02.meta_key = '_comite_id' and t02.meta_value = " . $comite_id . ")
            )
            AND post_type = 'acta' and post_status = 'publish'",
            ARRAY_A
         );
         $num_actas = '';
         foreach ($qry_n_actas as $acta) {
            $num_actas .= $acta['meta_value'] . ',';
         }
         $datosAtributos['num_actas'] = $num_actas;
      } else {
         $datosAtributos['titulo'] = 'Minutas y Actas';
         $datosAtributos['prefijo'] = 'Minutas o Actas';
         $datosAtributos['comite_id'] = '';
         $datosAtributos['qryconsecutivo'] = 0;
         $datosAtributos['num_actas'] = '';
         $datosAtributos['prefijo'] = '';
      }

      return $datosAtributos;
   }
}
