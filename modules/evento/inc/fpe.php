<?php

function fgh000_fpe($finicio = '', $horainicio = '', $ffinal = '', $tipoevento = '', $opcionesquema = '', $numerodiames = '', $diaordinalevento = '', $diasemanaevento = [], $mesevento)
{

   $diaordinal = ['1' => 'first', '2' => 'second', '3' => 'third', '4' => 'fourth', '5' => 'last'];
   $diasemana = ['1' => 'Monday', '2' => 'Tuesday', '3' => 'Wednesday', '4' => 'Thursday', '5' => 'Friday', '6' => 'Saturday', '7' => 'Sunday'];
   $mesesanno = ['1' => 'Jan', '2' => 'Feb', '3' => 'Mar', '4' => 'Apr', '5' => 'May', '6' => 'Jun', '7' => 'Jul', '8' => 'Aug', '9' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec'];
   $fecha = '';
   $fechas = [];
   $fechaproximoevento = '';
   /********************************************************
    * 
    * Obtiene la fecha del próximo evento y su hora para 
    * todo tipo de eventos: recurrentes, eventos diarios,
    * semanales, mensuales y anuales. 
    * 
    ********************************************************/
   switch ($tipoevento) {
      case '1': //Evento único
         if (date('Y-m-d') == $finicio) {
            if (date('H:i') < $horainicio) {
               $fecha = $finicio;
            } else {
               if (date('Y-m-d') < $ffinal || $ffinal == '')
                  $fecha = date('Y-m-d', strtotime('next day'));
            }
         }
         if (date('Y-m-d') < $finicio) {
            $fecha = $finicio;
         }
         if (date('Y-m-d') > $finicio) {
            if (date('Y-m-d') <= $ffinal || $ffinal == '') {
               $fecha = date('Y-m-d');
            } else {
               $fecha = $finicio;
            }
         }
         $fechaproximoevento = $fecha;
         break;
      case '2': //Se repite diariamente
         if (date('Y-m-d') == $finicio) {
            if (date('H:i') < $horainicio) {
               $fecha = $finicio;
            } else {
               if (date('Y-m-d') < $ffinal || $ffinal == '') {
                  $fecha = date('Y-m-d', strtotime('next day'));
               } else {
                  $fecha = '';
               }
            }
         }
         if (date('Y-m-d') < $finicio) {
            $fecha = $finicio;
         }
         if (date('Y-m-d') > $finicio) {
            if (date('Y-m-d') < $ffinal || $ffinal == '') {
               if (date('H:i') < $horainicio) {
                  $fecha = date('Y-m-d');
               } else {
                  $fecha = date('Y-m-d', strtotime('next day'));
               }
            } else {
               $fecha = $finicio;
            }
         }
         $fechaproximoevento = $fecha;
         break;
      case '3': //Se repite semanalmente
         if (date('Y-m-d') < $ffinal || $ffinal == '') {
            foreach ($diasemanaevento as $dia) {
               $fecha = date('Y-m-d', strtotime((($dia == '7') ? 'Next ' : '') . $diasemana[$dia]));
               if (date('Y-m-d') == $fecha) {
                  if (date('H:i') < $horainicio) {
                     $fechas[] = $fecha;
                  }
               } else if (date('Y-m-d') < $fecha) {
                  $fechas[] = $fecha;
               }
            }
            if (count($fechas) == 1) {
               $fechaproximoevento = $fecha;
            } else {
               $fechaproximoevento = min($fechas);
            }
         }
         break;
      case '4': //Se repite mensualmente
         if (date('Y-m-d') < $ffinal || $ffinal == '') {
            if ($opcionesquema == 'on') {
               if (date('j') > $numerodiames) {
                  $fechaproximoevento = date('Y-m-d', mktime(0, 0, 0, date('m') + 1, $numerodiames, date('Y')));
               } else {
                  if (date('H') < $horainicio) {
                     $fechaproximoevento = date('Y-m-d', mktime(0, 0, 0, date('m'), $numerodiames, date('Y')));
                  } else {
                     $fechaproximoevento = date('Y-m-d', mktime(0, 0, 0, date('m') + 1, $numerodiames, date('Y')));
                  }
               }
            } else {
               foreach ($diasemanaevento as $dia) {
                  $strtotime = $diaordinal[$diaordinalevento] . ' ' . $diasemana[$dia] . ' of ' . date('F');
                  $fecha = date('Y-m-d', strtotime($strtotime));
                  if (date('Y-m-d') == $fecha) {
                     if (date('H:m') < $horainicio) {
                        $fechas[] = $fecha;
                     }
                  }
                  if (date('Y-m-d') < $fecha) {
                     $fechas[] = $fecha;
                  }
                  if (date('Y-m-d') > $fecha) {
                     $fechas[] = date('Y-m-d', strtotime($diaordinal[$diaordinalevento] . ' ' . $diasemana[$dia] . ' of ' . date('F', strtotime('next month'))));
                  }
               }
               if (count($fechas) == 1) {
                  $fechaproximoevento = $fecha;
               } else {
                  $fechaproximoevento = min($fechas);
               }
            }
         }
         break;
      case '5': //Se repite anualmente
         if (date('Y-m-d') < $ffinal || $ffinal == '') {
            if ($opcionesquema == 'on') {
               if (date('d') == $numerodiames && date('m') == $mesevento) {
                  if (date('H') < $horainicio) {
                     $fecha = date('Y-m-d');
                  } else {
                     $fecha = date('Y-m-d', strtotime('next year'));
                  }
               } else {
                  if (date('m') == $mesevento) {
                     if (date('d') < $numerodiames) {
                        $fecha = date('Y-m-d', mktime(0, 0, 0, $mesevento, $numerodiames, date('Y')));
                     } else if (date('d') > $numerodiames) {
                        $fecha = date('Y-m-d', mktime(0, 0, 0, $mesevento, $numerodiames, date('Y') + 1));
                     }
                  } else {
                     if (date('m') < $mesevento) {
                        $fecha = date('Y-m-d', mktime(0, 0, 0, $mesevento, $numerodiames, date('Y')));
                     } else if (date('m') > $mesevento) {
                        $fecha = date('Y-m-d', mktime(0, 0, 0, $mesevento, $numerodiames, date('Y') + 1));
                     }
                  }
               }
               $fechaproximoevento = $fecha;
            } else {
               foreach ($diasemanaevento as $dia) {

                  $fecha = date('Y-m-d', strtotime($diaordinal[$diaordinalevento] . ' ' . $diasemana[$dia] . ' of ' . $mesesanno[$mesevento]));

                  if (date('Y-m-d') == $fecha) {
                     if (date('H:i') < $horainicio) {
                        $fechas[] = $fecha;
                     }
                  }
                  if (date('Y-m-d') < $fecha) {
                     $fechas[] = $fecha;
                  }
                  if (date('Y-m-d') > $fecha) {
                     $fecha = date('Y-m-d', mktime(0, 0, 0, date('m', strtotime($fecha)), date('d', strtotime($fecha)), date('Y', strtotime($fecha)) + 1));
                     $fechas[] = $fecha;
                  }
               }
               if (count($fechas) == 1) {
                  $fechaproximoevento = $fecha;
               } else {
                  $fecha = min($fechas);
                  $fechaproximoevento = $fecha;
               }
            }
         }
         break;
      default:

         break;
   }
   return $fechaproximoevento;
}