<?php

namespace FGHEGC\Modules\Page;

use FGHEGC\Modules\Core\Singleton;

class PageController
{
   use Singleton;
   public $atributos;

   private function __construct()
   {
      $this->atributos = [];
   }
   public function get_atributos()
   {
      $this->atributos['templatepartpage'] = $this->get_datosAtributos()['templatepart'];
      $this->atributos['fullpage'] = $this->get_datosAtributos()['fullpage'];
      $this->atributos['height'] = $this->get_datosAtributos()['height'];
      $this->atributos['titulo'] = $this->get_datosAtributos()['titulo'];
      $this->atributos['subtitulo'] = $this->get_datosAtributos()['subtitulo'];
      $this->atributos['div0'] = $this->get_datosAtributos()['div0'];
      $this->atributos['div1'] = $this->get_datosAtributos()['div1'];
      $this->atributos['comentarios'] = $this->get_datosAtributos()['comentarios'];

      return $this->atributos;
   }
   private function get_datosAtributos()
   {
      $datosAtributos['comentarios'] = true;
      if (isset(get_post(get_the_ID())->post_name)) {
         $modulo = $this->getSlugModulo()['modulo'];
         $slug = $this->getSlugModulo()['slug'];
         $sca = ['comite', 'acta', 'acuerdo', 'miembro', 'puesto'];
         $scp = ['peticion', 'oracion'];
         $sae = ['evento', 'inscripcion'];
         if (in_array($modulo, $sca)) {
            $datosAtributos['templatepart'] = 'modules/sca/' . $modulo . '/view/' . $slug;
         } elseif (in_array($modulo, $scp)) {
            $datosAtributos['templatepart'] = 'modules/scp/' . $modulo . '/view/' . $slug;
            if (!is_single()) {
               $datosAtributos['comentarios'] = false;
            }
         } elseif (in_array($modulo, $sae)) {
            $datosAtributos['templatepart'] = 'modules/sae/' . $modulo . '/view/' . $slug;
         } else {
            $datosAtributos['templatepart'] = 'modules/' . $modulo . '/view/' . $slug;
         }
      }

      $datosAtributos['subtitulo'] = '';
      if (isset($_GET['comite_id'])) {
         $comite_id = sanitize_text_field($_GET['comite_id']);
         $datosAtributos['subtitulo'] = get_post($comite_id)->post_title;
      }
      if (isset($_GET['asignar_id'])) {
         $asignar_id = sanitize_text_field($_GET['asignar_id']);
         $datosAtributos['subtitulo'] = 'Asignados a ' . get_user_by('ID', $asignar_id)->display_name;
      }

      $datosAtributos['fullpage'] = false;
      $datosAtributos['div0'] = 'background-blend pt-5';
      $datosAtributos['div1'] = 'container';
      $datosAtributos['height'] = '60vh';
      $datosAtributos['titulo'] = get_the_title();

      if (is_front_page()) {
         $datosAtributos['fullpage'] = true;
         if ($datosAtributos['fullpage']) {
            $datosAtributos['height'] = '100vh';
            $datosAtributos['div0'] = '';
            $datosAtributos['div1'] = '';
         }
      } elseif (is_page('core-login')) {
         $datosAtributos['fullpage'] = true;
         $datosAtributos['height'] = '100vh';
         $datosAtributos['titulo'] = '';
         $datosAtributos['div0'] = '';
         $datosAtributos['div1'] = '';
      }


      return $datosAtributos;
   }
   private function getSlugModulo()
   {
      $slug = get_post(get_the_ID())->post_name;
      $guion = strpos($slug, '-');
      $modulo = substr($slug, 0, $guion);

      return ['slug' => $slug, 'modulo' => $modulo];
   }
}
