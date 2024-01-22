<?php

namespace FGHEGC\Modules\Sae\Inscripcion;

use FGHEGC\Modules\Core\Singleton;

class InscripcionController
{
   use Singleton;
   public $atributos;

   public function __construct()
   {
      $this->atributos = [];
   }
   public function get_atributos($postType)
   {

      $this->atributos['titulo'] = 'Inscripciones';
      if (isset($_GET['pid'])) {
         $post_parent = sanitize_text_field($_GET['pid']);
         $subtitulo = get_post($post_parent)->post_title;
         $this->atributos['post_parent'] = $post_parent;
      } else {
         $subtitulo = '';
         $this->atributos['post_parent'] = '';
      }
      $this->atributos['templatepart'] = 'modules/evt/' . $postType . '/view/' . $postType;
      $this->atributos['templatepartnone'] = 'modules/evt/' . $postType . '/view/' . $postType . '-none';
      $this->atributos['subtitulo'] = $subtitulo;
      $this->atributos['subtitulo2'] = '';
      $this->atributos['div2'] = 'row';
      $this->atributos['div3'] = 'col-xl-9';
      $this->atributos['div4'] = 'row row-cols-1 g-4 mb-5';
      $this->atributos['div5'] = 'col-xl-3';
      $this->atributos['agregarpost'] = 'modules/evt/inscripcion/view/inscripcion-csv';
      $this->atributos['sidebar'] = 'modules/evt/evento/view/evento-calendario';
      $this->atributos['regresar'] = $postType;
      $this->atributos['imagen'] = FGHEGC_DIR_URI . '/assets/img/mano.jpeg';

      $this->atributos['mes'] = $this->get_subatributos()['mes'];
      $this->atributos['anno'] = $this->get_subatributos()['anno'];
      $this->atributos['espacios'] = $this->get_subatributos()['espacios'];
      $this->atributos['restante'] = $this->get_subatributos()['restante'];
      $this->atributos['mesConsulta'] = $this->get_subatributos()['mesConsulta'];
      $this->atributos['mesConsultaLink'] = $this->get_subatributos()['mesConsultaLink'];
      $this->atributos['diaSemanaPost'] = $this->get_subatributos()['diaSemanaPost'];

      return $this->atributos;
   }
   private function get_subatributos()
   {

      $subatributos = [];
      $subatributos['espacios'] = 0;
      $subatributos['restante'] = 0;
      $subatributos['subtitulo2'] = '';
      $subatributos['diaSemanaPost'] = ['Monday' => 'Lunes', 'Tuesday' => 'Martes', 'Wednesday' => 'Miércoles', 'Thursday' => 'Jueves', 'Friday' => 'Viernes', 'Saturday' => 'Sábado', 'Sunday' => 'Domingo'];

      $subatributos['mes'] = date('F');
      $subatributos['anno'] = date('Y');
      $subatributos['mesConsultaLink'] = 'mes=' . $subatributos['mes'];
      $subatributos['mesConsulta'] = $subatributos['mes'];
      $subatributos['espacios'] = date('N', strtotime('first day of ' . $subatributos['mes'])) - 1;
      $subatributos['restante'] = 8 - $subatributos['espacios'];

      return $subatributos;
   }
}
