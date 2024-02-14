<?php

namespace FGHEGC\Modules\Scc\Beneficiario;

use FGHEGC\Modules\Core\Singleton;

class BeneficiarioController
{
   use Singleton;
   private $atributos;
   private function __construct()
   {
      $this->atributos = [];
   }
   public function get_atributos($postType)
   {
      $this->atributos['titulo'] = 'Comedor Grano de Trigo';
      $this->atributos['div2'] = 'row';
      $this->atributos['div3'] = 'col-md-8';
      $this->atributos['div5'] = 'col-md-4';
      $this->atributos['templatepartnone'] = 'modules/scc/' . $postType . '/view/' . $postType . '-none';
      $this->atributos['sidebar'] = 'modules/scc/beneficiario/view/beneficiario-sidebar';
      $this->atributos['imagen'] = FGHEGC_DIR_URI . '/assets/img/manosorando.jpeg';
      $this->atributos['regresar'] = $postType;
      $this->atributos['displaysub'] = 'fs-4';
      $this->atributos['displaysub2'] = 'fs-5';

      $this->atributos['subtitulo'] = $this->get_datosAtributos($postType)['subtitulo'];
      $this->atributos['subtitulo2'] = $this->get_datosAtributos($postType)['subtitulo2'];
      $this->atributos['div4'] = $this->get_datosAtributos($postType)['div4'];
      $this->atributos['agregarpost'] = $this->get_datosAtributos($postType)['agregarpost'];
      $this->atributos['templatepart'] = $this->get_datosAtributos($postType)['templatepart'];
      $this->atributos['carrusel'] = $this->get_datosAtributos($postType)['carrusel'];
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
         $datosAtributos['subtitulo'] = '<figcaption class="blockquote-footer fs-4 fw-bold"><cite title="Source Title">Pero Jesús Dijo: Dejad a los niños venir a mi, y no se lo inpidáis; porque de los tales es el reino de los cielos.</cite></figcaption>';
         $datosAtributos['subtitulo2'] = get_the_title();
         $datosAtributos['div4'] = '';
      } else {
         $datosAtributos['templatepart'] = 'modules/scc/' . $postType . '/view/' . $postType;
         $datosAtributos['subtitulo'] = 'Pero Jesús Dijo: Dejad a los niños venir a mi, y no se lo inpidáis; porque de los tales es el reino de los cielos.';
         $datosAtributos['subtitulo2'] = 'Mateo 19:14 (RVR1960)';
         $datosAtributos['div4'] = '';
      }

      $datosAtributos['carrusel'] = [
         'imagen01' => FGHEGC_DIR_URI . '/assets/img/comedores01.png',
         'imagen02' => FGHEGC_DIR_URI . '/assets/img/comedores02.jpeg',
         'imagen03' => FGHEGC_DIR_URI . '/assets/img/comedores03.jpeg',
         'imagen04' => FGHEGC_DIR_URI . '/assets/img/comedores04.jpeg',
      ];

      return $datosAtributos;
   }
   public function scc_get_provincias()
   {
      global $wpdb;

      $sql =
         "SELECT DISTINCT t1.meta_value AS ID, t2.meta_value AS provincia
      FROM $wpdb->posts
      INNER JOIN $wpdb->postmeta t1
         ON (ID = t1.post_id)
      INNER JOIN $wpdb->postmeta t2
         ON (ID = t2.post_id)
      WHERE post_type = 'divpolcri'
         AND (t1.meta_key = '_provincia_id' AND t1.meta_value !='')
         AND (t2.meta_key = '_provincia' AND t2.meta_value !='')
      ORDER BY t2.meta_value
      ";

      $provincias = $wpdb->get_results($sql, ARRAY_A);

      return $provincias;
   }
   public function get_provincias($provincia_id)
   {
      global $wpdb;

      $sql =
         "SELECT t2.meta_value AS provincia
      FROM $wpdb->posts
      INNER JOIN $wpdb->postmeta t1
         ON (ID = t1.post_id)
      INNER JOIN $wpdb->postmeta t2
         ON (ID = t2.post_id)
      WHERE post_type = 'divpolcri'
         AND (t1.meta_key = '_provincia_id' AND t1.meta_value = $provincia_id)
         AND (t2.meta_key = '_provincia' AND t2.meta_value !='')
      ORDER BY t2.meta_value
      ";

      $provincias = $wpdb->get_var($sql);

      return $provincias;
   }
   public function get_cantones($canton_id)
   {
      global $wpdb;

      $sql =
         "SELECT t2.meta_value AS canton
      FROM $wpdb->posts
      INNER JOIN $wpdb->postmeta t1
         ON (ID = t1.post_id)
      INNER JOIN $wpdb->postmeta t2
         ON (ID = t2.post_id)
      WHERE post_type = 'divpolcri'
         AND (t1.meta_key = '_canton_id' AND t1.meta_value = $canton_id)
         AND (t2.meta_key = '_canton' AND t2.meta_value !='')
      ORDER BY t2.meta_value
      ";

      $cantones = $wpdb->get_var($sql);

      return $cantones;
   }
   public function get_distritos($distrito_id)
   {
      global $wpdb;

      $sql =
         "SELECT t2.meta_value AS distrito
      FROM $wpdb->posts
      INNER JOIN $wpdb->postmeta t1
         ON (ID = t1.post_id)
      INNER JOIN $wpdb->postmeta t2
         ON (ID = t2.post_id)
      WHERE post_type = 'divpolcri'
         AND (t1.meta_key = '_distrito_id' AND t1.meta_value = $distrito_id)
         AND (t2.meta_key = '_distrito' AND t2.meta_value !='')
      ORDER BY t2.meta_value
      ";

      $distritos = $wpdb->get_var($sql);

      return $distritos;
   }
   public function get_avatar($post_id)
   {
      if (get_post_meta($post_id, '_sexo', true) == '2') {
         $avatar = FGHEGC_DIR_URI . '/assets/img/avatar_femenino.png';
      } else {
         $avatar = FGHEGC_DIR_URI . '/assets/img/avatar_masculino.png';
      }
      return $avatar;
   }
}
