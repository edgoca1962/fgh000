<?php

namespace FGHEGC\Modules\Sae\Evento;

use FGHEGC\Modules\Core\Singleton;

class EventoController
{
   use Singleton;

   public $atributos;

   private function __construct()
   {
      $this->atributos = [];
   }

   public function get_atributos($postType)
   {
      $this->atributos = [];
      $this->atributos['periodicidadevento'] = ['1' => 'Evento Único', '2' => 'Evento Diario', '3' => 'Evento Semanal', '4' => 'Evento Mensual', '5' => 'Evento Anual'];
      $this->atributos['diaordinal'] = ['1' => 'first', '2' => 'second', '3' => 'third', '4' => 'fourth', '5' => 'last'];
      $this->atributos['diaordinalesp'] = ['1' => 'Primer', '2' => 'Segundo', '3' => 'Tercer', '4' => 'Cuarto', '5' => 'Último'];
      $this->atributos['diasemana'] = ['1' => 'Monday', '2' => 'Tuesday', '3' => 'Wednesday', '4' => 'Thursday', '5' => 'Friday', '6' => 'Saturday', '7' => 'Sunday'];
      $this->atributos['diasemanaesp'] = ['1' => 'Lunes', '2' => 'Martes', '3' => 'Miércoles', '4' => 'Jueves', '5' => 'Viernes', '6' => 'Sábado', '7' => 'Domingo'];
      $this->atributos['mesesanno'] = ['1' => 'Jan', '2' => 'Feb', '3' => 'Mar', '4' => 'Apr', '5' => 'May', '6' => 'Jun', '7' => 'Jul', '8' => 'Aug', '9' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec'];
      $this->atributos['mesannoesp'] = ["1" => "Enero", "2" => "Febrero", "3" => "Marzo", "4" => "Abril", "5" => "Mayo", "6" => "Junio", "7" => "Julio", "8" => "Agosto", "9" => "Septiembre", "10" => "Octubre", "11" => "Noviembre", "12" => "Diciembre"];
      $this->atributos['periodos'] = ['2' => 'días', '3' => 'semanas', '4' => 'meses', '5' => 'años'];
      $this->atributos['monthName'] = ["January" => "Enero", "February" => "Febrero", "March" => "Marzo", "April" => "Abril", "May" => "Mayo", "June" => "Junio", "July" => "Julio", "August" => "Agosto", "September" => "Septiembre", "October" => "Octubre", "November" => "Noviembre", "December" => "Diciembre"];
      $this->atributos['diaSemanaPost'] = ['Monday' => 'Lunes', 'Tuesday' => 'Martes', 'Wednesday' => 'Miércoles', 'Thursday' => 'Jueves', 'Friday' => 'Viernes', 'Saturday' => 'Sábado', 'Sunday' => 'Domingo'];
      if (in_array('useradmineventos', wp_get_current_user()->roles) || in_array('usercoordinaeventos', wp_get_current_user()->roles)) {
         $this->atributos['userAdminEventos'] = true;
      }
      if (in_array('usercoordinaeventos', wp_get_current_user()->roles)) {
      }
      $this->atributos['titulo'] = 'Eventos';
      $this->atributos['subtitulo'] = $this->get_subatributos()['subtitulo'];
      $this->atributos['subtitulo2'] = $this->get_subatributos()['subtitulo2'];
      $this->atributos['div2'] = 'row';
      $this->atributos['div3'] = 'col-xl-9';
      $this->atributos['div5'] = 'col-xl-3';
      $this->atributos['templatepart'] = $this->get_templatepart($postType);
      $this->atributos['templatepartnone'] = 'modules/sae/' . $postType . '/view/' . $postType . '-none';
      $this->atributos['agregarpost'] = '';
      $this->atributos['sidebar'] = 'modules/sae/' . $postType . '/view/' . $postType . '-calendario';
      $this->atributos['regresar'] = $postType;
      $this->atributos['imagen'] = FGHEGC_DIR_URI . '/assets/img/mano.jpeg';

      $this->atributos['mes'] = $this->get_subatributos()['mes'];
      $this->atributos['anno'] = $this->get_subatributos()['anno'];
      $this->atributos['espacios'] = $this->get_subatributos()['espacios'];
      $this->atributos['restante'] = $this->get_subatributos()['restante'];
      $this->atributos['mesConsulta'] = $this->get_subatributos()['mesConsulta'];
      $this->atributos['mesConsultaLink'] = $this->get_subatributos()['mesConsultaLink'];
      $this->atributos['datos_evento'] = $this->get_datos_evento();
      $this->atributos['evento_diario'] = 'modules/sae/evento/view/evento-diario';
      $this->atributos['evento_semanal'] = 'modules/sae/evento/view/evento-semanal';
      $this->atributos['evento_mensual'] = 'modules/sae/evento/view/evento-mensual';
      $this->atributos['evento_anual'] = 'modules/sae/evento/view/evento-anual';

      return $this->atributos;
   }
   private function get_subatributos()
   {
      $subatributos = [];
      $mesannoesp = $this->atributos['mesannoesp'];
      $subatributos['espacios'] = 0;
      $subatributos['restante'] = 0;
      $subatributos['subtitulo2'] = '';

      if (isset($_GET['fpe'])) {
         $subatributos['mesConsultaLink'] = 'fpe=' . sanitize_text_field($_GET['fpe']);
         $subatributos['mesConsulta'] = date('F', strtotime(sanitize_text_field($_GET['fpe'])));
         $subatributos['mes'] = date('F', strtotime(sanitize_text_field($_GET['fpe'])));
         $subatributos['anno'] = date('Y', strtotime(sanitize_text_field($_GET['fpe'])));
         $subatributos['espacios'] = date('N', strtotime('first day of ' . $subatributos['mes'] . ' ' . $subatributos['anno'])) - 1;
         $subatributos['restante'] = 8 - $subatributos['espacios'];
         $subatributos['subtitulo'] = date('d', strtotime(sanitize_text_field($_GET['fpe']))) . ' de ' . $this->atributos['monthName'][date('F', strtotime(sanitize_text_field($_GET['fpe'])))] . ' del ' . date('Y', strtotime(sanitize_text_field($_GET['fpe'])));
      } else {
         if (isset($_GET['mes']) && isset($_GET['anno'])) {
            $subatributos['mes'] = sanitize_text_field($_GET['mes']);
            $subatributos['anno'] = sanitize_text_field($_GET['anno']);
            $subatributos['mesConsultaLink'] = 'mes=' . $subatributos['mes'];
            $subatributos['mesConsulta'] = $subatributos['mes'];
            $subatributos['espacios'] = date('N', strtotime('first day of ' . $subatributos['mes'] . ' ' . $subatributos['anno'])) - 1;
            $subatributos['restante'] = 8 - $subatributos['espacios'];
            if (is_single()) {
               $subatributos['subtitulo2'] = get_the_title();
            }
         } else {
            $subatributos['mes'] = date('F');
            $subatributos['anno'] = date('Y');
            $subatributos['mesConsultaLink'] = 'mes=' . $subatributos['mes'];
            $subatributos['mesConsulta'] = $subatributos['mes'];
            $subatributos['espacios'] = date('N', strtotime('first day of ' . $subatributos['mes'])) - 1;
            $subatributos['restante'] = 8 - $subatributos['espacios'];
         }
         if (is_single()) {
            $subatributos['subtitulo'] = $mesannoesp[date('n', strtotime(get_post_meta(get_the_ID(), '_f_proxevento', true)))] . ' - ' . date('Y', strtotime(get_post_meta(get_the_ID(), '_f_proxevento', true)));
            $subatributos['subtitulo2'] = get_the_title();
         } else {
            $subatributos['subtitulo'] = $this->atributos['monthName'][$subatributos['mes']] . ' del ' . $subatributos['anno'];
         }
      }
      return $subatributos;
   }
   private function get_templatepart($postType)
   {
      if (is_single()) {
         $templatepart = 'modules/sae/' . $postType . '/view/' . $postType . '-single';
         $this->atributos['div4'] = '';
      } else {
         $templatepart = 'modules/sae/' . $postType . '/view/' . $postType;
         $this->atributos['div4'] = 'row row-cols-1 row-cols-md-3 g-4 mb-5';
      }
      return $templatepart;
   }

   public function sae_fechasevento($evento_ID, $finicio = '', $ffinal = '', $tipoevento = '', $npereventos = '', $opcionesquema = '', $diaordinalevento = '', $diasemanaevento = [], $mesConsulta = '', $anno = '', $fpe_param)
   {
      $diaordinal = ['1' => 'first', '2' => 'second', '3' => 'third', '4' => 'fourth', '5' => 'last'];
      $diasemana = ['1' => 'Monday', '2' => 'Tuesday', '3' => 'Wednesday', '4' => 'Thursday', '5' => 'Friday', '6' => 'Saturday', '7' => 'Sunday'];
      $mesesanno = ['1' => 'Jan', '2' => 'Feb', '3' => 'Mar', '4' => 'Apr', '5' => 'May', '6' => 'Jun', '7' => 'Jul', '8' => 'Aug', '9' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec'];
      $fechasevento = [];

      $f_inicio_mes = date('Y-m-d H:i:s', strtotime('first day of ' . $mesConsulta . ' ' . $anno));
      $f_final_mes = date('Y-m-d H:i:s', strtotime('last day of ' . $mesConsulta . ' ' . $anno));
      /********************************************************
       * 
       * Obtiene todas las fechas de un mes para todos los
       * evntos: Recurrentes y eventos diarios, semanales, 
       * mensuales y anuales. 
       * 
       ********************************************************/

      switch ($tipoevento) {
         case '1';
            if (($finicio <= $f_final_mes && $ffinal >= $f_inicio_mes)) {
               $fechasevento[] = $finicio;
            }
            break;
         case '2':
            $divisor = 86400;
            if (($finicio <= $f_final_mes && $ffinal >= $f_inicio_mes) || ($finicio <= $f_final_mes && $ffinal == '')) {
               if ($ffinal == '') {
                  $dias = round(abs((((strtotime($f_final_mes) - strtotime($finicio)) / $divisor) / $npereventos))) + 1;
               } else {
                  $dias = round(abs((((strtotime($ffinal) - strtotime($finicio)) / $divisor) / $npereventos))) + 1;
               }
               for ($i = 0; $i < $dias; $i++) {
                  $fechaCal = date('Y-m-d H:i:s', strtotime('+' . $i * $npereventos . ' day', strtotime($finicio)));
                  if (date('Ym', strtotime($fechaCal)) == date('Ym', strtotime($f_inicio_mes))) {
                     $fechasevento[] = $fechaCal;
                  }
               }
            }
            break;
         case '3':
            $divisor = 604800;
            if (($finicio <= $f_final_mes && $ffinal >= $f_inicio_mes) || ($finicio <= $f_final_mes && $ffinal == '')) {
               if ($ffinal > $f_final_mes || $ffinal == '') {
                  $f_final_cal = $f_final_mes;
               } else {
                  $f_final_cal = $ffinal;
               }
               $semanas = round(((strtotime($f_inicio_mes) - strtotime($finicio)) / $divisor) / $npereventos);
               if ($semanas < 0) {
                  $semanas = 0;
               }
               $fechaCal = date('Y-m-d H:i:s', strtotime($finicio . ' +' . $semanas * $npereventos . ' week'));
               while ($fechaCal <= $f_final_cal) {
                  $fechasevento[] = $fechaCal;
                  $fechaCal = date('Y-m-d H:i:s', strtotime($fechaCal . ' +' . $npereventos . ' week'));
               }
            }
            break;
         case '4':
            $divisor = 2818784;
            if (($finicio <= $f_final_mes && $ffinal >= $f_inicio_mes) || ($finicio <= $f_final_mes && $ffinal == '')) {
               $meses = round(((strtotime($f_inicio_mes) - strtotime($finicio)) / $divisor) / $npereventos) + 1;
               $fechaCal = date('Y-m-d H:i:s', strtotime($finicio . ' +' . $meses * $npereventos . ' month'));
               if ($opcionesquema == 'on') {
                  if (date('d', strtotime('last day of ' . date('F', strtotime($fechaCal)) . ' ' . date('Y', strtotime($fechaCal)), strtotime($fechaCal))) < date('d', strtotime($finicio))) {
                     $fechasevento[] = date('Y-m-d H:i:s', strtotime('last day of ' . date('F', strtotime($fechaCal)) . ' ' . date('Y', strtotime($fechaCal)), strtotime($fechaCal)));
                  } else {
                     $fechasevento[] = $fechaCal;
                  }
               } else {
                  foreach ($diasemanaevento as $d_semana) {
                     $fechaCal = date('Y-m-d H:i:s', strtotime(date('H:i:s', strtotime($fechaCal)), strtotime($diaordinal[$diaordinalevento] . ' ' . $diasemana[$d_semana] . ' of ' . date('F', strtotime($fechaCal)) . ' ' . date('Y', strtotime($fechaCal)))));
                     if (date('d', strtotime('last day of ' . date('F', strtotime($fechaCal)) . ' ' . date('Y', strtotime($fechaCal)), strtotime($fechaCal))) < date('d', strtotime($finicio))) {
                        $fechaCal = date('Y-m-d H:i:s', strtotime('last day of ' . date('F', strtotime($fechaCal)) . ' ' . date('Y', strtotime($fechaCal)), strtotime($fechaCal)));
                     }
                     $fechasevento[] = $fechaCal;
                  }
               }
            }
            break;
         case '5':
            $divisor = 31425408;
            $npereventos = 1;
            $annos = floor(abs(((strtotime($f_final_mes) - strtotime($finicio)) / $divisor) / $npereventos));
            $fechaCal = date('Y-m-d H:i:s', strtotime($finicio . ' +' . $annos * $npereventos . ' year'));
            if (date('d', strtotime('last day of ' . date('F', strtotime($fechaCal)) . ' ' . date('Y', strtotime($fechaCal)), strtotime($fechaCal))) < date('d', strtotime($finicio))) {
               $fechaCal = date('Y-m-d H:i:s', strtotime('last day of ' . date('F', strtotime($fechaCal)) . ' ' . date('Y', strtotime($fechaCal)), strtotime($fechaCal)));
            }
            if ($opcionesquema == 'on') {
               $fechasevento[] = $fechaCal;
            } else {
               foreach ($diasemanaevento as $d_semana) {
                  $fechaCal = date('Y-m-d H:i:s', strtotime(date('H:i:s', strtotime($fechaCal)), strtotime($diaordinal[$diaordinalevento] . ' ' . $diasemana[$d_semana] . ' of ' . date('F', strtotime($fechaCal)) . ' ' . date('Y', strtotime($fechaCal)))));
                  if (date('d', strtotime('last day of ' . date('F', strtotime($fechaCal)) . ' ' . date('Y', strtotime($fechaCal)), strtotime($fechaCal))) < date('d', strtotime($finicio))) {
                     $fechaCal = date('Y-m-d H:i:s', strtotime('last day of ' . date('F', strtotime($fechaCal)) . ' ' . date('Y', strtotime($fechaCal)), strtotime($fechaCal)));
                  }
                  $fechasevento[] = $fechaCal;
               }
            }
            break;
         default:
            $fechasevento[] = '1962-01-04 19:45:00';
            break;
      }
      return $fechasevento;
   }
   public function sae_fpe($evento_ID, $finicio = '', $ffinal = '', $tipoevento = '', $npereventos = '', $opcionesquema = '', $numerodiames = '', $diaordinalevento = '', $diasemanaevento = [], $mesevento)
   {

      $diaordinal = ['1' => 'first', '2' => 'second', '3' => 'third', '4' => 'fourth', '5' => 'last'];
      $diasemana = ['1' => 'Monday', '2' => 'Tuesday', '3' => 'Wednesday', '4' => 'Thursday', '5' => 'Friday', '6' => 'Saturday', '7' => 'Sunday'];
      $mesesanno = ['1' => 'Jan', '2' => 'Feb', '3' => 'Mar', '4' => 'Apr', '5' => 'May', '6' => 'Jun', '7' => 'Jul', '8' => 'Aug', '9' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec'];
      $fecha = '';
      $fechas = [];

      /********************************************************
       * 
       * Obtiene la fecha del próximo evento y su hora para 
       * todo tipo de eventos: recurrentes, eventos diarios,
       * semanales, mensuales y anuales. 
       * 
       ********************************************************/

      if (date('Y-m-d H:i:s') <= date('Y-m-d H:i:s', strtotime($finicio)) && $ffinal != '') {
         $fecha = date('Y-m-d H:i:s', strtotime($finicio));
      } else {
         if ((date('Y-m-d H:i:s') >= date('Y-m-d H:i:s', strtotime($finicio)) && date('Y-m-d H:i:s') <= date('Y-m-d H:i:s', strtotime($ffinal))) || $ffinal == '') {
            switch ($tipoevento) {
               case '1': //Evento único
                  $fecha = date('Y-m-d H:i:s', strtotime(date('H:i:s', strtotime($finicio))));
                  break;

               case '2': //Se repite diariamente
                  if ($npereventos > 1) {
                     $fecha = date('Y-m-d H:i:s', strtotime('next day', strtotime(date('H:i:s', strtotime($finicio)))));
                  } else {
                     $fecha = date('Y-m-d H:i:s', strtotime(date('H:i:s', strtotime($finicio))));
                  }
                  break;

               case '3': //Se repite semanalmente
                  foreach ($diasemanaevento as $dia) {
                     $fecha = date('Y-m-d H:i:s', strtotime(date('H:i:s', strtotime($finicio)), strtotime((($dia == '7') ? 'Next ' : '') . $diasemana[$dia])));
                     if (date('Y-m-d H:i:s') <= $fecha) {
                        $fechas[] = $fecha;
                     }
                  }
                  if (count($fechas) == 1) {
                     $fecha = $fecha;
                  } else {
                     $fecha = min($fechas);
                  }
                  break;

               case '4': //Se repite mensualmente
                  if ($opcionesquema == 'on') {
                     if (date('j') > $numerodiames) {
                        $fecha = date('Y-m-d H:i:s', strtotime('next month', strtotime(date('Y') . '-' . date('m') . '-' . date('d', strtotime($finicio)) . ' ' . date('H:i:s', strtotime($finicio)))));
                     } else {
                        $fecha = date('Y-m-d H:i:s', strtotime(date('Y') . '-' . date('m') . '-' . date('d', strtotime($finicio)) . ' ' . date('H:i:s', strtotime($finicio))));
                     }
                  } else {
                     foreach ($diasemanaevento as $dia) {
                        $f_1 = $diaordinal[$diaordinalevento] . ' ' . $diasemana[$dia] . ' of ' . date('F');
                        $hora = date('H:i:s', strtotime($finicio));
                        $fecha = date('Y-m-d H:i:s', strtotime($hora, strtotime($f_1)));

                        if (date('Y-m-d H:i:s') <= $fecha) {
                           $fechas[] = $fecha;
                        } else {
                           $f_1 = $diaordinal[$diaordinalevento] . ' ' . $diasemana[$dia] . ' of ' . date('F', strtotime('next month'));
                           $fechas[] = date('Y-m-d H:i:s', strtotime($hora, strtotime($f_1)));
                        }
                     }
                     if (count($fechas) == 1) {
                        $fecha = $fecha;
                     } else {
                        $fecha = min($fechas);
                     }
                  }
                  break;

               case '5': //Se repite anualmente
                  if ($opcionesquema == 'on') {
                     $strtotime = date('Y', strtotime($finicio)) . '-' . date('m', strtotime($finicio)) . '-' . $numerodiames . ' ' . date('H:i:s', strtotime($finicio));
                     if (date('Y-m-d H:i:s') <= date('Y-m-d H:i:s', strtotime($strtotime))) {
                        $fecha = date('Y-m-d H:i:s', strtotime($strtotime));
                     } else {
                        $strtotime = date('Y') . '-' . date('m', strtotime($finicio)) . '-' . $numerodiames . ' ' . date('H:i:s', strtotime($finicio));
                        $fecha = date('Y-m-d H:i:s', strtotime('next year', strtotime($strtotime)));
                     }
                  } else {
                     foreach ($diasemanaevento as $dia) {
                        $f_1 = $diaordinal[$diaordinalevento] . ' ' . $diasemana[$dia] . ' of ' . $mesesanno[$mesevento];
                        $hora = date('H:i:s', strtotime($finicio));
                        $fechaCal = date('Y-m-d H:i:s', strtotime($hora, strtotime($f_1)));
                        if (date('Y-m-d H:i:s') <= $fechaCal) {
                           $fechas[] = $fechaCal;
                        } else {
                           $fecha = date('Y-m-d H:i:s', strtotime('next year', strtotime($fechaCal)));
                           $fechas[] = $fecha;
                        }
                     }
                     if (count($fechas) == 1) {
                        $fecha = $fecha;
                     } else {
                        $fecha = min($fechas);
                     }
                  }
                  break;
               default:
                  date('2023-04-01 09:13:25');
                  break;
            }
         } else {
            $fecha = date('Y-m-d H:i:s', strtotime($finicio));
         }
      }

      return $fecha;
   }
   private function get_datos_evento()
   {
      $datos_evento = [];

      $userRoles = wp_get_current_user()->roles;
      $datos_evento['roles'] = $userRoles;
      if (in_array('administrator', $userRoles) || in_array('useradmingeneral', $userRoles) || in_array('useradmineventos', $userRoles)) {
         $datos_evento['displayFooter'] = '';
      } else {
         if (in_array('usercoordinaeventos', $userRoles) && get_current_user_id() == get_the_author_meta('ID')) {
            $datos_evento['displayFooter'] = '';
         } else {
            $datos_evento['displayFooter'] = 'hidden';
         }
      }

      $datos_evento['diaSemana'] = $this->atributos['diasemanaesp'][date('N', strtotime(get_post_meta(get_the_ID(), '_f_proxevento', true)))];
      $datos_evento['nDiaSemana'] = date('j', strtotime(get_post_meta(get_the_ID(), '_f_proxevento', true)));

      if (get_post_meta(get_the_ID(), '_diasemanaevento', true) != '') {
         $dias_semana = explode(',', get_post_meta(get_the_ID(), '_diasemanaevento', true));
         $dias = '';
         foreach ($dias_semana as $dia) {
            $dias .= $this->atributos['diasemanaesp'][$dia] . ', ';
         }
         $dias = substr_replace($dias, '', -2);
         $dias_array = explode(',', $dias);
         $total = count($dias_array);
         if ($total > 1) {
            $dias = '';
            for (
               $i = 0;
               $i < $total;
               $i++
            ) {
               if ($i < $total - 1) {
                  $dias .= $dias_array[$i] . ', ';
               } else {
                  $dias = substr_replace($dias, '', -2);
                  $dias .= ' y ' . $dias_array[$i];
               }
            }
         }
         $datos_evento['diasSemana'] = $dias;
         $datos_evento['ocultarDiasSemana'] = '';
      } else {
         $datos_evento['diasSemana'] = '';
         $datos_evento['ocultarDiasSemana'] = 'hidden';
      }

      $datos_evento['h_inicio'] = date('H:i', strtotime(get_post_meta(get_the_ID(), '_f_proxevento', true)));

      if (get_post_meta(get_the_ID(), '_inscripcion', true) == '') {
         $datos_evento['ocultarBtnInscripcion'] = 'hidden';
      } else {
         if (get_post_meta(get_the_ID(), '_f_final', true) == '') {
            $datos_evento['ocultarBtnInscripcion'] = '';
         } else {
            if (date('Y-m-d H:i:s', strtotime(get_post_meta(get_the_ID(), '_f_final', true))) < date('Y-m-d H:i:s')) {
               $datos_evento['ocultarBtnInscripcion'] = 'hidden';
            } else {
               $datos_evento['ocultarBtnInscripcion'] = '';
            }
         }
      }

      if (get_post_meta(get_the_ID(), '_inscripcion', true) == 'on') {
         $datos_evento['ocultarDatosInscripcion'] = '';
      } else {
         $datos_evento['ocultarDatosInscripcion'] = 'hidden';
      }

      if (get_post_meta(get_the_ID(), '_donativo', true) == 'on') {
         $datos_evento['ocultarDonativo'] = '';
         $datos_evento['montoDonativo'] = get_post_meta(get_the_ID(), '_montodonativo', true);
         $datos_evento['requiereDonativo'] = 'required';
         $datos_evento['dataBoleta'] = 'on';
      } else {
         $datos_evento['ocultarDonativo'] = 'hidden';
         $datos_evento['montoDonativo'] = 0;
         $datos_evento['requiereDonativo'] = '';
         $datos_evento['dataBoleta'] = 'off';
      }

      if (get_post_meta(get_the_ID(), '_aforo', true) == 'on') {
         $datos_evento['ocultarAforo'] = '';
      } else {
         $datos_evento['ocultarAforo'] = 'hidden';
      }

      $descripcionTipoEvento = '';
      if (get_post_meta(get_the_ID(), '_periodicidadevento', true) != '') {
         $descripcionTipoEvento .= $this->atributos['periodicidadevento'][get_post_meta(get_the_ID(), '_periodicidadevento', true)];
      }
      /**
       * 
       * Descripción del tipo de Evento 
       * 
       * */
      $descripcionTipoEvento .= get_post_meta(get_the_ID(), '_diames', true);

      if (get_post_meta(get_the_ID(), '_f_final', true) == '') {
         $descripcionTipoEvento .= ' recurrente ';
      }
      if (get_post_meta(get_the_ID(), '_numerodiaevento', true) != '') {
         $descripcionTipoEvento .= ' el día ' . get_post_meta(get_the_ID(), '_numerodiaevento', true) . ' ';
      }
      if (get_post_meta(get_the_ID(), '_dia_completo', true) == 'on') {
         $descripcionTipoEvento .= ' de día completo';
      }
      if (get_post_meta(get_the_ID(), '_numerodiaordinalevento', true) != '' && get_post_meta(get_the_ID(), '_numerodiaordinalevento', true) != '') {
         $descripcionTipoEvento .= ' el ' . $this->atributos['diaordinalesp'][get_post_meta(get_the_ID(), '_numerodiaordinalevento', true)];
      }
      if (get_post_meta(get_the_ID(), '_diasemanaevento', true) != '' && get_post_meta(get_the_ID(), '_numerodiaordinalevento', true) == '') {
         $descripcionTipoEvento .= ' los días ' . $datos_evento['diasSemana'];
      } else {
         $descripcionTipoEvento .= ' ' . $datos_evento['diasSemana'];
      }
      if (get_post_meta(get_the_ID(), '_npereventos', true) > 1) {
         $descripcionTipoEvento .= ' y se repite cada ' . get_post_meta(get_the_ID(), '_npereventos', true) . ' ' . $this->atributos['periodos'][get_post_meta(get_the_ID(), '_periodicidadevento', true)];
      }
      if (get_post_meta(get_the_ID(), '_periodicidadevento', true) == '5') {
         $descripcionTipoEvento .= (get_post_meta(get_the_ID(), '_mesevento', true)) ? ' durante el mes de ' . $this->atributos['mesannoesp'][get_post_meta(get_the_ID(), '_mesevento', true)] : '';
      }
      if (get_post_meta(get_the_ID(), '_f_final', true) != '') {
         $descripcionTipoEvento .= ' con fecha final del ' . date('d-m-Y', strtotime(get_post_meta(get_the_ID(), '_f_final', true))) . '';
      }
      if (get_post_meta(get_the_ID(), '_inscripcion', true) == 'on') {
         $descripcionTipoEvento .= ' y requiere inscribirse. <br>';
      }
      $datos_evento['tipEve'] = $descripcionTipoEvento;
      if (in_array('administrator', wp_get_current_user()->roles)) {
         $datos_evento['ocultarTipEve'] = '';
      } else {
         $datos_evento['ocultarTipEve'] = 'hidden';
      }

      return $datos_evento;
   }
}
