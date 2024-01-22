<?php

namespace FGHEGC\Modules\Sca\Acta;

use FGHEGC\modules\core\Singleton;

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

      $this->atributos['titulo'] = $this->get_parametros($postType)['titulo'];
      $this->atributos['subtitulo'] = $this->get_parametros($postType)['subtitulo'];
      $this->atributos['div2'] = 'row';
      $this->atributos['div3'] = 'col-md-8';
      $this->atributos['div4'] = $this->get_parametros($postType)['div4'];
      $this->atributos['div5'] = 'col-md-4';
      $this->atributos['agregarpost'] = $this->get_parametros($postType)['agregarpost'];
      $this->atributos['sidebar'] = 'modules/sca/acuerdo/view/sidebar-busquedas';
      $this->atributos['templatepart'] = $this->get_parametros($postType)['templatepart'];
      $this->atributos['regresar'] = $postType;
      $this->atributos['comite_id'] = $this->get_parametros($postType)['comite_id'];
      $this->atributos['consecutivo'] = $this->get_parametros($postType)['qryconsecutivo'];
      $this->atributos['num_actas'] = $this->get_parametros($postType)['num_actas'];
      $this->atributos['prefijo'] = $this->get_parametros($postType)['prefijo'];

      return $this->atributos;
   }
   private function get_parametros($postType)
   {
      $atributos = [];
      if (is_user_logged_in()) {
         $usuarioRoles = wp_get_current_user()->roles;
         if (in_array('administrator', $usuarioRoles) || in_array('useradmingeneral', $usuarioRoles) || in_array('useradmincomite', $usuarioRoles)) {
            $subatributos['agregarpost'] = 'modules/sca/' . $postType . '/view/' . $postType . '-agregar';
         } else {
            $subatributos['agregarpost'] = '';
         }
      }
      if (is_single()) {
         $subatributos['templatepart'] = 'modules/sca/' . $postType . '/view/' . $postType . '-single';
         $subatributos['subtitulo'] = get_the_title();
         $subatributos['div4'] = '';
      } else {
         $subatributos['templatepart'] = 'modules/sca/' . $postType . '/view/' . $postType;
         $subatributos['subtitulo'] = '';
         $subatributos['div4'] = 'row row-cols-1 row-cols-md-2 g-4 pb-3';
      }
      if (isset($_GET['comite_id']) != null) {
         $comite_id = sanitize_text_field($_GET['comite_id']);
         $subatributos['comite_id'] = $comite_id;
         $comite = get_post($comite_id)->post_title;
         if (preg_match("/Junta/i", $comite)) {
            $subatributos['titulo'] = "Actas de " . $comite;
            $subatributos['prefijo'] = 'Acta';
         } else {
            $subatributos['titulo'] = "Minutas del " . $comite;
            $subatributos['prefijo'] = 'Minuta';
         }
         global $wpdb;

         $subatributos['qryconsecutivo'] = $wpdb->get_var(
            "SELECT MAX(cast(t01.meta_value as unsigned))+1 consecutivo
            FROM wp_posts
            INNER JOIN wp_postmeta t01 ON (ID = t01.post_id)
            INNER JOIN wp_postmeta t02 ON (ID = t02.post_id)
            WHERE 1=1
            AND (
            (t01.meta_key = '_n_acta')
            AND (t02.meta_key = '_comite_id' and t02.meta_value = " . $comite_id . ")
            )
            AND post_type = 'acta' AND post_status = 'publish'"
         );
         $qry_n_actas = $wpdb->get_results(
            "SELECT t01.meta_value
            FROM wp_posts
            INNER JOIN wp_postmeta t01 ON (ID = t01.post_id)
            INNER JOIN wp_postmeta t02 ON (ID = t02.post_id)
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
         $subatributos['num_actas'] = $num_actas;
      } else {
         $subatributos['titulo'] = 'Minutas y Actas';
         $subatributos['prefijo'] = 'Minutas o Actas';
         $subatributos['comite_id'] = '';
         $subatributos['qryconsecutivo'] = 0;
         $subatributos['num_actas'] = '';
         $subatributos['prefijo'] = '';
      }

      return $subatributos;
   }
}
