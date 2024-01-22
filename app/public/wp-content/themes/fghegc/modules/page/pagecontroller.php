<?php

namespace FGHEGC\Modules\Page;

use FGHEGC\Modules\Core\Singleton;

class PageController
{
   use Singleton;
   private $atributos;

   private function __construct()
   {
      $this->atributos = [];
   }
   public function get_atributos()
   {
      $this->atributos['templatepartpage'] = $this->get_templatepart();
      $this->atributos['fullpage'] = $this->get_subatributos()['fullpage'];
      $this->atributos['height'] = $this->get_subatributos()['height'];
      $this->atributos['titulo'] = $this->get_subatributos()['titulo'];
      $this->atributos['subtitulo'] = $this->get_subtitulo();
      $this->atributos['div0'] = $this->get_subatributos()['div0'];
      $this->atributos['div1'] = $this->get_subatributos()['div1'];
      return $this->atributos;
   }
   private function getSlugModulo()
   {
      $slug = get_post(get_the_ID())->post_name;
      $guion = strpos($slug, '-');
      $modulo = substr($slug, 0, $guion);

      return ['slug' => $slug, 'modulo' => $modulo];
   }
   private function get_templatepart()
   {
      if (isset(get_post(get_the_ID())->post_name)) {
         $modulo = $this->getSlugModulo()['modulo'];
         $slug = $this->getSlugModulo()['slug'];
         $sca = ['comite', 'acta', 'acuerdo', 'miembro', 'puesto'];
         $scp = ['peticion', 'oracion'];
         $sae = ['evento', 'inscripcion'];
         if (in_array($modulo, $sca)) {
            $templatepart = 'modules/sca/' . $modulo . '/view/' . $slug;
         } elseif (in_array($modulo, $scp)) {
            $templatepart = 'modules/scp/' . $modulo . '/view/' . $slug;
         } elseif (in_array($modulo, $sae)) {
            $templatepart = 'modules/sae/' . $modulo . '/view/' . $slug;
         } else {
            $templatepart = 'modules/' . $modulo . '/view/' . $slug;
         }
      }
      return $templatepart;
   }
   private function get_subtitulo()
   {
      $subtitulo = '';
      if (isset($_GET['comite_id'])) {
         $comite_id = sanitize_text_field($_GET['comite_id']);
         $subtitulo = get_post($comite_id)->post_title;
      }
      if (isset($_GET['asignar_id'])) {
         $asignar_id = sanitize_text_field($_GET['asignar_id']);
         $subtitulo = 'Asignados a ' . get_user_by('ID', $asignar_id)->display_name;
      }
      return $subtitulo;
   }
   private function get_subatributos()
   {
      $subatributos = [];
      $subatributos['fullpage'] = false;
      $subatributos['div0'] = 'background-blend pt-5';
      $subatributos['div1'] = 'container';
      $subatributos['height'] = '60vh';
      $subatributos['titulo'] = get_the_title();

      if (is_front_page()) {
         $subatributos['fullpage'] = true;
         if ($subatributos['fullpage']) {
            $subatributos['height'] = '100vh';
            $subatributos['div0'] = '';
            $subatributos['div1'] = '';
         }
      } elseif (is_page('core-login')) {
         $subatributos['fullpage'] = true;
         $subatributos['height'] = '100vh';
         $subatributos['titulo'] = '';
         $subatributos['div0'] = '';
         $subatributos['div1'] = '';
      }
      return $subatributos;
   }
}
