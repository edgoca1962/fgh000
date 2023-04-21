<?php

function fgh000_fechasevento($finicio = '', $ffinal = '', $tipoevento = '', $opcionesquema = '', $numerodiames = '', $diaordinalevento = '', $diasemanaevento = [], $mesevento = '', $mesConsulta = '')
{

   $diaordinal = ['1' => 'first', '2' => 'second', '3' => 'third', '4' => 'fourth', '5' => 'last'];
   $diasemana = ['1' => 'Monday', '2' => 'Tuesday', '3' => 'Wednesday', '4' => 'Thursday', '5' => 'Friday', '6' => 'Saturday', '7' => 'Sunday'];
   $mesesanno = ['1' => 'Jan', '2' => 'Feb', '3' => 'Mar', '4' => 'Apr', '5' => 'May', '6' => 'Jun', '7' => 'Jul', '8' => 'Aug', '9' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec'];
   $fechas = [];
   $fechastotales = [];

   /********************************************************
    * 
    * Obtiene todas las fechas de un mes para todos los
    * evntos: Recurrentes y eventos diarios, semanales, 
    * mensuales y anuales. 
    * 
    ********************************************************/
   switch ($tipoevento) {
      case '1':
         if ($ffinal == '') {
            $fechas = [];
         } else {
            if ($finicio > date('Y-m-d', strtotime('last day of ' . $mesConsulta)) || $ffinal < date('Y-m-d', strtotime('first day of ' . $mesConsulta))) {
               $fechas = [];
            } else {
               if ($finicio >= date('Y-m-d', strtotime('first day of ' . $mesConsulta)) && $ffinal <= date('Y-m-d', strtotime('last day of ' . $mesConsulta))) {
                  $f1 = date_create($finicio);
                  $f2 = date_create($ffinal);
               }
               if ($finicio < date('Y-m-d', strtotime('first day of ' . $mesConsulta)) && $ffinal > date('Y-m-d', strtotime('last day of ' . $mesConsulta))) {
                  $f1 = date_create(date('Y-m-d', strtotime('first day of ' . $mesConsulta)));
                  $f2 = date_create(date('Y-m-d', strtotime('last day of ' . $mesConsulta)));
               }
               if ($finicio < date('Y-m-d', strtotime('first day of ' . $mesConsulta)) && $ffinal < date('Y-m-d', strtotime('last day of ' . $mesConsulta))) {
                  $f1 = date_create(date('Y-m-d', strtotime('first day of ' . $mesConsulta)));
                  $f2 = date_create($ffinal);
               }
               if ($finicio > date('Y-m-d', strtotime('first day of ' . $mesConsulta)) && $ffinal > date('Y-m-d', strtotime('last day of ' . $mesConsulta))) {
                  $f1 = date_create($finicio);
                  $f2 = date_create(date('Y-m-d', strtotime('last day of ' . $mesConsulta)));
               }
               $n_dias = date_diff($f1, $f2);
               $numerodiasevento = $n_dias->format('%d') + 1;
               $fecha = date_format($f1, 'Y-m-d');
               for ($i = 0; $i < $numerodiasevento; $i++) {
                  $f1_1 = date_create($fecha);
                  $f1_2 = date_date_set($f1_1, date('Y', strtotime($fecha)), date('m', strtotime($fecha)), date('d', strtotime($fecha)) + $i);
                  $f1_3 = date_format($f1_2, 'Y-m-d');
                  if ($finicio <= $f1_3) {
                     $fechas[] = $f1_3;
                  }
               }
            }
         }
         break;
      case '2':
         if ($ffinal == '') {
            $fechas = [];
         } else {
            if ($finicio > date('Y-m-d', strtotime('last day of ' . $mesConsulta)) || $ffinal < date('Y-m-d', strtotime('first day of ' . $mesConsulta))) {
               $fechas = [];
            } else {

               if ($finicio >= date('Y-m-d', strtotime('first day of ' . $mesConsulta)) && $ffinal <= date('Y-m-d', strtotime('last day of ' . $mesConsulta))) {
                  $f1 = date_create($finicio);
                  $f2 = date_create($ffinal);
               }
               if ($finicio < date('Y-m-d', strtotime('first day of ' . $mesConsulta)) && $ffinal > date('Y-m-d', strtotime('last day of ' . $mesConsulta))) {
                  $f1 = date_create(date('Y-m-d', strtotime('first day of ' . $mesConsulta)));
                  $f2 = date_create(date('Y-m-d', strtotime('last day of ' . $mesConsulta)));
               }
               if ($finicio < date('Y-m-d', strtotime('first day of ' . $mesConsulta)) && $ffinal < date('Y-m-d', strtotime('last day of ' . $mesConsulta))) {
                  $f1 = date_create(date('Y-m-d', strtotime('first day of ' . $mesConsulta)));
                  $f2 = date_create($ffinal);
               }
               if ($finicio > date('Y-m-d', strtotime('first day of ' . $mesConsulta)) && $ffinal > date('Y-m-d', strtotime('last day of ' . $mesConsulta))) {
                  $f1 = date_create($finicio);
                  $f2 = date_create(date('Y-m-d', strtotime('last day of ' . $mesConsulta)));
               }
               $n_dias = date_diff($f1, $f2);
               $numerodiasevento = $n_dias->format('%d') + 1;
               $fecha = date_format($f1, 'Y-m-d');
               for ($i = 0; $i < $numerodiasevento; $i++) {
                  $f1_1 = date_create($fecha);
                  $f1_2 = date_date_set($f1_1, date('Y', strtotime($fecha)), date('m', strtotime($fecha)), date('d', strtotime($fecha)) + $i);
                  $f1_3 = date_format($f1_2, 'Y-m-d');
                  if ($finicio <= $f1_3) {
                     $fechas[] = $f1_3;
                  }
               }
            }
         }
         break;
      case '3':
         if ($ffinal == '' || $ffinal >= date('Y-m-d', strtotime('first day of ' . $mesConsulta))) {
            if ($finicio <= date('Y-m-d', strtotime('last day of ' . $mesConsulta))) {
               if ($ffinal == '') {
                  if ($finicio >= date('Y-m-d', strtotime('first day of ' . $mesConsulta)) && $finicio <= date('Y-m-d', strtotime('last day of ' . $mesConsulta))) {
                     $f1 = date_create($finicio);
                     $f2 = date_create(date('Y-m-d', strtotime('last day of ' . $mesConsulta)));
                  }
                  if ($finicio < date('Y-m-d', strtotime('first day of ' . $mesConsulta))) {
                     $f1 = date_create(date('Y-m-d', strtotime('first day of ' . $mesConsulta)));
                     $f2 = date_create(date('Y-m-d', strtotime('last day of ' . $mesConsulta)));
                  }
                  $n_dias = date_diff($f1, $f2);
                  $numerodiasevento = $n_dias->format('%d') + 1;
                  $fecha = date_format($f1, 'Y-m-d');
                  for ($i = 0; $i < $numerodiasevento; $i++) {
                     $f1_1 = date_create($fecha);
                     $f1_2 = date_date_set($f1_1, date('Y', strtotime($fecha)), date('m', strtotime($fecha)), date('d', strtotime($fecha)) + $i);
                     $f1_3 = date_format($f1_2, 'Y-m-d');
                     if ($finicio <= $f1_3) {
                        $fechastotales[] = $f1_3;
                     }
                  }
                  foreach ($fechastotales as $fechadiaria) {
                     foreach ($diasemanaevento as $dia) {
                        if (date('N', strtotime($fechadiaria)) == $dia) {
                           $fechas[] = $fechadiaria;
                        }
                     }
                  }
               } else {
                  if ($finicio >= date('Y-m-d', strtotime('first day of ' . $mesConsulta)) && $ffinal <= date('Y-m-d', strtotime('last day of ' . $mesConsulta))) {
                     $f1 = date_create($finicio);
                     $f2 = date_create($ffinal);
                  }
                  if ($finicio < date('Y-m-d', strtotime('first day of ' . $mesConsulta)) && $ffinal > date('Y-m-d', strtotime('last day of ' . $mesConsulta))) {
                     $f1 = date_create(date('Y-m-d', strtotime('first day of ' . $mesConsulta)));
                     $f2 = date_create(date('Y-m-d', strtotime('last day of ' . $mesConsulta)));
                  }
                  if ($finicio < date('Y-m-d', strtotime('first day of ' . $mesConsulta)) && $ffinal < date('Y-m-d', strtotime('last day of ' . $mesConsulta))) {
                     $f1 = date_create(date('Y-m-d', strtotime('first day of ' . $mesConsulta)));
                     $f2 = date_create($ffinal);
                  }
                  if ($finicio > date('Y-m-d', strtotime('first day of ' . $mesConsulta)) && $ffinal > date('Y-m-d', strtotime('last day of ' . $mesConsulta))) {
                     $f1 = date_create($finicio);
                     $f2 = date_create(date('Y-m-d', strtotime('last day of ' . $mesConsulta)));
                  }
                  $n_dias = date_diff($f1, $f2);
                  $numerodiasevento = $n_dias->format('%d') + 1;
                  $fecha = date_format($f1, 'Y-m-d');

                  for ($i = 0; $i < $numerodiasevento; $i++) {
                     $f1_1 = date_create($fecha);
                     $f1_2 = date_date_set($f1_1, date('Y', strtotime($fecha)), date('m', strtotime($fecha)), date('d', strtotime($fecha)) + $i);
                     $f1_3 = date_format($f1_2, 'Y-m-d');
                     if ($finicio <= $f1_3) {
                        $fechastotales[] = $f1_3;
                     }
                  }
                  foreach ($fechastotales as $fechadiaria) {
                     foreach ($diasemanaevento as $dia) {
                        if (date('N', strtotime($fechadiaria)) == $dia) {
                           $fechas[] = $fechadiaria;
                        }
                     }
                  }
               }
            } else {
               $fechas = [];
            }
         } else {
            $fechas = [];
         }
         break;
      case '4':
         if ($ffinal == '' || $ffinal >= date('Y-m-d', strtotime('first day of ' . $mesConsulta))) {
            if ($finicio <= date('Y-m-d', strtotime('last day of ' . $mesConsulta))) {
               if ($opcionesquema == 'on') {
                  $fecha = date('Y-m-d');
                  $f1_1 = date_create($fecha);
                  $f1_2 = date_date_set($f1_1, date('Y'), date('m'), $numerodiames);
                  $f1_3 = date_format($f1_2, 'Y-m-d');
                  if (date('F', strtotime($f1_3)) === $mesConsulta) {
                     if ($finicio <= $f1_3) {
                        $fechas[] = $f1_3;
                     }
                  }
               } else {
                  foreach ($diasemanaevento as $dia) {
                     $strtotime = $diaordinal[$diaordinalevento] . ' ' . $diasemana[$dia] . ' of ' . $mesConsulta;
                     if ($finicio <= date('Y-m-d', strtotime($strtotime))) {
                        $fechas[] = date('Y-m-d', strtotime($strtotime));
                     }
                  }
               }
            } else {
               $fechas = [];
            }
         } else {
            $fechas = [];
         }
         break;
      case '5':
         if ($ffinal == '' || $ffinal >= date('Y-m-d', strtotime('first day of ' . $mesConsulta))) {
            if ($finicio <= date('Y-m-d', strtotime('last day of ' . $mesConsulta))) {
               if ($opcionesquema == 'on') {
                  if (date('m') == $mesevento) {
                     $fecha = date('Y-m-d');
                     $f1_1 = date_create($fecha);
                     $f1_2 = date_date_set($f1_1, date('Y'), date('m'), $numerodiames);
                     $f1_3 = date_format($f1_2, 'Y-m-d');
                     if ($finicio <= $f1_3) {
                        $fechas[] = $f1_3;
                     }
                  } else {
                     $fechas = [];
                  }
               } else {
                  if (date('m') == $mesevento) {
                     foreach ($diasemanaevento as $dia) {
                        $fecha = date('Y-m-d', strtotime($diaordinal[$diaordinalevento] . ' ' . $diasemana[$dia] . ' of ' . $mesesanno[$mesevento]));
                        if ($finicio <= $fecha) {
                           $fechas[] = $fecha;
                        }
                     }
                  } else {
                     $fechas = [];
                  }
               }
            } else {
               $fechas = [];
            }
         } else {
            $fechas = [];
         }
         break;
      default:

         break;
   }
   return $fechas;
}