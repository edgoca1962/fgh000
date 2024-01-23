<?php

namespace FGHEGC\Modules\Sae\Inscripcion;

use FGHEGC\Modules\Core\Singleton;

class InscripcionController
{
   use Singleton;
   public $atributos;

   private function __construct()
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

      $this->atributos['mes'] = $this->get_datosAtributos()['mes'];
      $this->atributos['anno'] = $this->get_datosAtributos()['anno'];
      $this->atributos['espacios'] = $this->get_datosAtributos()['espacios'];
      $this->atributos['restante'] = $this->get_datosAtributos()['restante'];
      $this->atributos['mesConsulta'] = $this->get_datosAtributos()['mesConsulta'];
      $this->atributos['mesConsultaLink'] = $this->get_datosAtributos()['mesConsultaLink'];
      $this->atributos['diaSemanaPost'] = $this->get_datosAtributos()['diaSemanaPost'];

      return $this->atributos;
   }
   private function get_datosAtributos()
   {

      $datosAtributos = [];
      $datosAtributos['espacios'] = 0;
      $datosAtributos['restante'] = 0;
      $datosAtributos['subtitulo2'] = '';
      $datosAtributos['diaSemanaPost'] = ['Monday' => 'Lunes', 'Tuesday' => 'Martes', 'Wednesday' => 'Miércoles', 'Thursday' => 'Jueves', 'Friday' => 'Viernes', 'Saturday' => 'Sábado', 'Sunday' => 'Domingo'];

      $datosAtributos['mes'] = date('F');
      $datosAtributos['anno'] = date('Y');
      $datosAtributos['mesConsultaLink'] = 'mes=' . $datosAtributos['mes'];
      $datosAtributos['mesConsulta'] = $datosAtributos['mes'];
      $datosAtributos['espacios'] = date('N', strtotime('first day of ' . $datosAtributos['mes'])) - 1;
      $datosAtributos['restante'] = 8 - $datosAtributos['espacios'];

      return $datosAtributos;
   }
}
