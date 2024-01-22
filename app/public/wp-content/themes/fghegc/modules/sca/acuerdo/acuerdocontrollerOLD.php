<?php

namespace FGHEGC\Modules\Sca\Acuerdo;

use FGHEGC\modules\core\Singleton;

class AcuerdoController
{
   use Singleton;

   public $atributos;
   public $totalAcuerdos;
   public $verAcuerdosComite;
   public $miembroJunta;
   public $datosComites;
   public $status;

   public function __construct()
   {
      $this->atributos = [];
      $this->totalAcuerdos = [];
      $this->verAcuerdosComite = [];
      $this->miembroJunta = false;
      $this->datosComites = [];
      $this->status = '';
   }

   public function get_atributos($postType)
   {
      if (isset($_GET['comite_id'])) {
         $comite_id = sanitize_text_field($_GET['comite_id']);
      } else {
         $comite_id = '';
      }
      if (isset($_GET['acta_id'])) {
         $acta_id = sanitize_text_field($_GET['acta_id']);
      } else {
         $acta_id = '';
      }
      if (isset($_GET['asignar_id'])) {
         $asignar_id = sanitize_text_field($_GET['asignar_id']);
      } else {
         $asignar_id = '';
      }
      if (isset($_GET['vigencia'])) {
         $vigencia = sanitize_text_field($_GET['vigencia']);
      } else {
         $vigencia = '';
      }

      $this->atributos['titulo'] = $this->get_titulo($comite_id, $asignar_id, $vigencia);
      $this->atributos['subtitulo'] = $this->get_subtitulo($acta_id, $vigencia);
      $this->atributos['subtitulo2'] = $this->get_subtitulo2($vigencia, $acta_id);
      $this->atributos['div2'] = 'row';
      $this->atributos['div3'] = 'col-md-8';
      $this->atributos['div4'] = 'row row-cols-1 g-4 mb-5';
      $this->atributos['div5'] = 'col-md-4';
      $this->atributos['templatepart'] = $this->get_templatepart($postType);
      $this->atributos['templatepartnone'] = 'modules/sca/acuerdo/view/acuerdo-none';
      $this->atributos['agregarpost'] = $this->get_agregarpost($postType, $acta_id);
      $this->atributos['sidebar'] = 'modules/sca/acuerdo/view/sidebar-busquedas';
      $this->atributos['regresar'] = $postType;

      $this->atributos['prefijo'] = 'Minuta';
      $this->atributos['consecutivo'] = $this->get_qryconsecutivo($comite_id, $acta_id);
      $this->atributos['comite_id'] = $comite_id;
      $this->atributos['acta_id'] = $acta_id;
      $this->atributos['num_acuerdos'] = $this->get_num_acuerdos($comite_id, $acta_id);
      $this->atributos['asignar_id'] = $asignar_id;
      $this->atributos['parametros'] = $this->get_parametros($vigencia, $comite_id, $acta_id, $asignar_id);
      $this->atributos['comites'] = $this->get_datosComites()['comites'];
      $this->atributos['datosComite'] = $this->get_datosComites()['datosComite'];
      $this->atributos['totalAcuerdos'] = $this->get_totalAcuerdos();

      return $this->atributos;
   }
   private function get_templatepart($postType)
   {
      if (is_single()) {
         $templatepart = 'modules/sca/' . $postType . '/view/' . $postType . '-single';
      } else {
         $templatepart = 'modules/sca/' . $postType . '/view/' . $postType;
      }
      return $templatepart;
   }
   private function get_titulo($comite_id, $asignar_id, $vigencia)
   {
      if ($vigencia != '' && $comite_id != '') {
         $titulo = 'Acuerdos';
         if (get_post($comite_id)) {
            $comite = get_post($comite_id)->post_title;
         }
         $titulo = 'Acuerdos ' . $comite;
      } else {
         if ($comite_id != '') {
            if (get_post($comite_id)) {
               $comite = get_post($comite_id)->post_title;
               if (preg_match("/Junta/i", $comite)) {
                  $titulo = "Actas de " . $comite;
               } else {
                  $titulo = "Minutas del " . $comite;
               }
            } else {
               $titulo = get_the_title();
            }
         } elseif ($asignar_id != '') {
            $titulo = 'Acuerdos Asignados a ' . get_user_by('ID', $asignar_id)->display_name;
         } elseif ($vigencia != '') {
            if ($comite_id != '') {
               $titulo = 'Acuerdos ' . get_post($comite_id)->post_title;
            }
            if ($asignar_id != '') {
               $titulo = 'Acuerdos asignados a ' . get_user_by('ID', $asignar_id)->display_name;
            } else {
               $titulo = 'Consulta de Acuerdos';
            }
         } elseif (is_single()) {
            $titulo =  get_the_title();
         } else {
            $titulo = '';
         }
      }

      return $titulo;
   }
   private function get_subtitulo($acta_id, $vigencia)
   {
      if ($vigencia != '') {
         switch ($vigencia) {
            case '1':
               $subtitulo = 'Acuerdos Vencidos';
               break;
            case '2':
               $subtitulo = 'Acuerdos que vencen este mes';
               break;
            case '3':
               $subtitulo = 'Acuerdos en Proceso';
               break;
            default:
               $subtitulo = 'Acuerdos Ejecutados';
               break;
         }
      } else {
         if (get_post($acta_id)) {
            $subtitulo = get_post($acta_id)->post_title;
         } else {
            $subtitulo = '';
         }
      }

      return $subtitulo;
   }
   private function get_subtitulo2($vigencia, $acta_id)
   {
      $subtitulo2 = '';
      if ($vigencia || $acta_id) {
         if (is_single()) {
            $subtitulo2 = get_the_title();
         }
      }
      return $subtitulo2;
   }
   private function get_qryconsecutivo($comite_id, $acta_id)
   {
      if ($comite_id != '' && $acta_id != '') {
         global $wpdb;
         $qryconsecutivo = $wpdb->get_var(
            "
                    SELECT
                    MAX(cast(t01.meta_value as unsigned)) + 1 consecutivo
                    FROM
                        wp_posts
                        INNER JOIN wp_postmeta t01 ON (ID = t01.post_id)
                        INNER JOIN wp_postmeta t02 ON (ID = t02.post_id)
                        INNER JOIN wp_postmeta t03 ON (ID = t03.post_id)
                    WHERE 1 = 1 
                        AND (
                            (t01.meta_key = '_n_acuerdo' AND t01.meta_value != '')
                            AND (t02.meta_key = '_comite_id' AND t02.meta_value ='" . $comite_id . "')
                            AND (t03.meta_key = '_acta_id' AND t03.meta_value = '" . $acta_id . "')
                        )
                        AND post_type = 'acuerdo'
                        AND post_status = 'publish';
                    "
         );
      } else {
         $qryconsecutivo = 0;
      }
      return $qryconsecutivo;
   }
   private function get_num_acuerdos($comite_id, $acta_id)
   {
      $num_acuerdos = '';
      if ($comite_id != '' && $acta_id != '') {
         global $wpdb;
         $qry_n_acuerdos = $wpdb->get_results(
            "
                        SELECT
                        t01.meta_value
                        FROM
                            wp_posts
                            INNER JOIN wp_postmeta t01 ON (ID = t01.post_id)
                            INNER JOIN wp_postmeta t02 ON (ID = t02.post_id)
                            INNER JOIN wp_postmeta t03 ON (ID = t03.post_id)
                        WHERE 1 = 1
                            AND(
                                (t01.meta_key = '_n_acuerdo' AND t01.meta_value != '')
                                AND (t02.meta_key = '_comite_id' AND t02.meta_value = '" . $comite_id . "')
                                AND (t03.meta_key = '_acta_id' AND t03.meta_value = '" . $acta_id . "')
                                )
                            AND post_type = 'acuerdo'
                            AND post_status = 'publish'
                        ",
            ARRAY_A
         );
         foreach ($qry_n_acuerdos as $acuerdo) {
            $num_acuerdos .= $acuerdo['meta_value'] . ',';
         }
      }
      return $num_acuerdos;
   }
   private function get_parametros($vigencia, $comite_id, $acta_id, $asignar_id)
   {
      $parametros = '';
      if ($vigencia != '') {
         if ($comite_id != '') {
            $parametros = 'vigencia=' . $vigencia . '&comite_id=' . $comite_id;
         }
         if ($asignar_id != '') {
            $parametros = 'vigencia=' . $vigencia . '&asignar_id=' . $asignar_id;
         }
      }
      if ($comite_id && $acta_id) {
         $parametros = 'comite_id=' . $comite_id . '&acta_id=' . $acta_id;
      }
      return $parametros;
   }
   private function get_agregarpost($postType, $acta_id)
   {
      if ($acta_id != '') {
         $agregarpost = 'modules/sca/' . $postType . '/view/' . $postType . '-agregar';
      } else {
         $agregarpost = '';
      }
      return $agregarpost;
   }
   public function get_totalAcuerdos()
   {
      global $wpdb;
      $datos = [];
      $fechaInicial = date('Y-m-d', strtotime('First day of ' . date('F')));
      $fechaFinal = date('Y-m-d', strtotime('Last day of ' . date('F')));
      $sql = "
      SELECT t4.meta_value AS asignado,
           t1.meta_value AS comite_id,
           t3.meta_value AS vigencia,
           CASE
              WHEN t2.meta_value < '" . $fechaInicial . "' then 1
              WHEN t2.meta_value BETWEEN '" . $fechaInicial . "' 
              AND '" . $fechaFinal . "' then 2
              WHEN t2.meta_value > '" . $fechaFinal . "' then 3
           END AS etiqueta,
           count(ID) as total
        FROM
           wp_posts
           INNER JOIN wp_postmeta AS t1 ON (ID = t1.post_id)
           INNER JOIN wp_postmeta AS t2 ON (ID = t2.post_id)
           INNER JOIN wp_postmeta AS t3 ON (ID = t3.post_id)
           INNER JOIN wp_postmeta AS t4 ON (ID = t4.post_id)
        WHERE
           1 = 1
           AND (
              (
                 t1.meta_key = '_comite_id'
                 AND t1.meta_value != ''
              )
              AND (
                 t2.meta_key = '_f_compromiso'
                 AND t2.meta_value != ''
              )
              AND (
                 t3.meta_key = '_vigente'
                 AND t3.meta_value != ''
              )
              AND (
                 t4.meta_key = '_asignar_id'
                 AND t4.meta_value != ''
              )
           )
           AND (
              (
                 wp_posts.post_type = 'acuerdo'
                 AND (
                    wp_posts.post_status = 'publish'
                    OR wp_posts.post_status = 'private'
                 )
              )
           )
        GROUP BY t4.meta_value,
           t1.meta_value,
           t3.meta_value,
           CASE
              WHEN t2.meta_value < '" . $fechaInicial . "' then 1
              WHEN t2.meta_value BETWEEN '" . $fechaInicial . "' 
              AND '" . $fechaFinal . "' then 2
              WHEN t2.meta_value > '" . $fechaFinal . "' then 3
           END
        ORDER BY t4.meta_value,
           t1.meta_value,
           t3.meta_value,
           CASE
              WHEN t2.meta_value < '" . $fechaInicial . "' then 1
              WHEN t2.meta_value BETWEEN '" . $fechaInicial . "' 
              AND '" . $fechaFinal . "' then 2
              WHEN t2.meta_value > '" . $fechaFinal . "' then 3
           END
      ";
      $datos = $wpdb->get_results($sql, ARRAY_A);

      $acuerdosTotales = [];
      $estatus = ['1' => 'vencidos', '2' => 'porvencer', '3' => 'proceso', '4' => 'ejecutados'];
      $estatus2 = ['1' => 'vencidos', '2' => 'por vencer este mes', '3' => 'en proceso', '4' => 'ejecutados'];
      $verAcuerdos = $this->get_verAcuerdos();
      $comites = $this->atributos['comites'];
      $usuario = get_current_user_id();
      $usuarios = get_users(['orderby' => 'display_name']);

      /*
      $verAcuerdos = [
         '32000' => 'asignados',
         '32001' => 'asignados',
         '32002' => 'todos',
         '32003' => 'asignados',
         '32004' => 'asignados',
         '32005' => 'todos',
         '32006' => 'asignados',
         '32007' => 'asignados',
      ];
      */


      $elements = [];
      foreach ($comites as $comite) {
         $vigencias = [];
         foreach ($estatus as $sts => $label) {
            $contador = 0;
            foreach ($datos as $dato) {
               if ($dato['vigencia'] == '1' && $comite['ID'] == 'todos' && $sts == $dato['etiqueta']) {
                  $contador = $contador + $dato['total'];
               } else {
                  if ($dato['vigencia'] == '1' && $comite['ID'] == $dato['comite_id'] && $sts == $dato['etiqueta']) {
                     $contador = $contador + $dato['total'];
                  }
               }
            }
            if ($sts != '4') {
               $vigencias[$label] = $contador;
            }
         }
         if ($comite['ID'] == 'todos') {
            $nombre = 'Resumen General';
         } else {
            $nombre = get_post($comite['ID'])->post_title;
         }
         $elements[$comite['ID']] = ['nombre' => $nombre, 'vigencias' => $vigencias];
      }
      $acuerdosTotales['graficos'] = $elements;

      $elements = [];
      foreach ($estatus2 as $sts => $label) {
         $contador = 0;
         foreach ($datos as $dato) {
            if ($dato['asignado'] == $usuario) {
               if ($dato['vigencia'] == '1') {
                  if ($sts == $dato['etiqueta']) {
                     $contador = $contador + $dato['total'];
                  }
               } else {
                  if ($sts == '4') {
                     $contador = $contador + $dato['total'];
                  }
               }
            }
         }
         $elements[] = ['codigo' => $sts, 'etiqueta' => $label, 'total' => $contador];
      }
      $acuerdosTotales['vigencias'] = $elements;

      $elements = [];
      foreach ($verAcuerdos as $comite => $facultad) {
         $contador = 0;
         foreach ($datos as $dato) {
            if ($comite == $dato['comite_id']) {
               if ($facultad == 'todos') {
                  $contador = $contador + $dato['total'];
               } else {
                  if ($usuario == $dato['asignado']) {
                     $contador = $contador + $dato['total'];
                  }
               }
            }
         }
         $elements[] = ['comite_id' => $comite, 'nombre' => get_post($comite)->post_title, 'total' => $contador];
      }
      $acuerdosTotales['comites'] = $elements;

      $elements = [];
      foreach ($usuarios as $user) {
         $contador = 0;
         foreach ($datos as $dato) {
            if ($user->ID == $dato['asignado']) {
               $contador = $contador + $dato['total'];
            }
         }
         $elements[$user->ID] = ['nombre' => get_user_by('ID', $user->ID)->display_name, 'total' => $contador];
      }
      $acuerdosTotales['asignados'] = $elements;

      if ($_GET['comite_id']) {
         $comite_id = sanitize_text_field($_GET['comite_id']);
         $vencidos = 0;
         $porvencer = 0;
         $proceso = 0;
         $ejecutados = 0;

         foreach ($datos as $dato) {
            if ($dato['comite_id'] == $comite_id) {
               if ($verAcuerdos[$comite_id] == 'todos') {
                  if ($dato['vigencia'] == '0') {
                     $ejecutados = $ejecutados + $dato['total'];
                  } else {
                     switch ($dato['etiqueta']) {
                        case '1':
                           $vencidos = $vencidos + $dato['total'];
                           break;
                        case '2':
                           $porvencer = $porvencer + $dato['total'];
                           break;
                        case '3':
                           $proceso = $proceso + $dato['total'];
                           break;
                     }
                  }
               } else {
                  if ($dato['asignado'] == $usuario) {
                     if ($dato['vigencia'] == '0') {
                        $ejecutados = $ejecutados + $dato['total'];
                     } else {
                        switch ($dato['etiqueta']) {
                           case '1':
                              $vencidos = $vencidos + $dato['total'];
                              break;
                           case '2':
                              $porvencer = $porvencer + $dato['total'];
                              break;
                           case '3':
                              $proceso = $proceso + $dato['total'];
                              break;
                        }
                     }
                  }
               }
            }
         }

         $acuerdosTotales['comiteAsignado'] =
            [
               '1' => ['etiqueta' => 'Acuerdos vencidos', 'total' => $vencidos], '2' => ['etiqueta' => 'Acuerdos por vencer este mes', 'total' => $porvencer], '3' => ['etiqueta' => 'Acuerdos en proceso', 'total' => $proceso], '4' => ['etiqueta' => 'Acuerdos ejecutados', 'total' => $ejecutados]
            ];
      }
      if ($_GET['asignar_id']) {
         $asignar_id = sanitize_text_field($_GET['asignar_id']);
         $vencidos = 10;
         $porvencer = 10;
         $proceso = 10;
         $ejecutados = 10;
         foreach ($datos as $dato) {
            if ($dato['asignado'] == $asignar_id) {
               if ($dato['vigencia'] == '0') {
                  $ejecutados = $ejecutados + $dato['total'];
               } else {
                  switch ($dato['etiqueta']) {
                     case '1':
                        $vencidos = $vencidos + $dato['total'];
                        break;
                     case '2':
                        $porvencer = $porvencer + $dato['total'];
                        break;
                     case '3':
                        $proceso = $proceso + $dato['total'];
                        break;
                  }
               }
            }
         }
         $acuerdosTotales['vigenciaAsignado'] =
            [
               '1' => ['etiqueta' => 'Acuerdos vencidos', 'total' => $vencidos], '2' => ['etiqueta' => 'Acuerdos por vencer este mes', 'total' => $porvencer], '3' => ['etiqueta' => 'Acuerdos en proceso', 'total' => $proceso], '4' => ['etiqueta' => 'Acuerdos ejecutados', 'total' => $ejecutados]
            ];
      }

      return $acuerdosTotales;
   }
   public function get_totalAcuerdosAnno($anno)
   {

      $fechaInicial = date($anno . '-01-01');
      $fechaFinal = date($anno . '-12-31');
      $proceso = array(
         'post_type' => 'acuerdo',
         'posts_per_page' => -1,
         'post_status' => 'publish',
         'orderby' => '_f_compromiso',
         'order' => 'ASC',
         'meta_query' => [
            [
               'key' => '_f_compromiso',
               'value' => $fechaFinal,
               'compare' => '>'
            ],
            [
               'key' => '_vigente',
               'value' => '1',
            ],
         ]
      );
      $this->totalAcuerdos['proceso'] = count(get_posts($proceso));

      $this->totalAcuerdos['porvencer'] = 0;

      $vencidos = array(
         'post_type' => 'acuerdo',
         'posts_per_page' => -1,
         'post_status' => 'publish',
         'orderby' => '_f_compromiso',
         'order' => 'ASC',
         'meta_query' => [
            [
               'key' => '_f_compromiso',
               'value' => [$fechaInicial, $fechaFinal],
               'compare' => 'BETWEEN'
            ],
            [
               'key' => '_vigente',
               'value' => '1',
            ],
         ]
      );
      $this->totalAcuerdos['vencidos'] = count(get_posts($vencidos));

      $ejecutados = array(
         'post_type' => 'acuerdo',
         'posts_per_page' => -1,
         'post_status' => 'publish',
         'orderby' => '_f_compromiso',
         'order' => 'ASC',
         'meta_query' => [
            [
               'key' => '_f_compromiso',
               'value' => [$fechaInicial, $fechaFinal],
               'compare' => 'BETWEEN'
            ],
            [
               'key' => '_vigente',
               'value' => '0',
            ],
         ]
      );
      $this->totalAcuerdos['ejecutados'] = count(get_posts($ejecutados));
      return $this->totalAcuerdos;
   }
   public function get_totalAcuerdosUsr($usr_id)
   {
      global $wpdb;

      $fechaInicial = date('Y-m-d', strtotime('First day of ' . date('F')));
      $fechaFinal = date('Y-m-d', strtotime('Last day of ' . date('F')));

      $sql = "SELECT 
               CASE 
                  WHEN t2.meta_value < '" . $fechaInicial . "' then '1' 
                  WHEN t2.meta_value BETWEEN '" . $fechaInicial . "' AND '" . $fechaFinal . "' then 2
                  WHEN t2.meta_value > '" . $fechaFinal . "' then 3
               END AS vigencia, 
               CASE 
                  WHEN t2.meta_value < '" . $fechaInicial . "' then 'vencidos' 
                  WHEN t2.meta_value BETWEEN '" . $fechaInicial . "' AND '" . $fechaFinal . "' then 'vencen este mes' 
                  WHEN t2.meta_value > '" . $fechaFinal . "' then 'en proceso'
               END AS status, 
               count(ID) as total 
            FROM wp_posts 
            INNER JOIN wp_postmeta AS t1 ON (ID = t1.post_id) 
            INNER JOIN wp_postmeta AS t2 ON (ID = t2.post_id) 
            INNER JOIN wp_postmeta AS t3 ON (ID = t3.post_id) 
            WHERE post_type = 'acuerdo' 
               AND ( 
                  ( t1.meta_key = '_asignar_id' AND t1.meta_value = $usr_id ) 
                  AND ( t3.meta_key = '_vigente' AND t3.meta_value = '1' ) ) 
            GROUP BY 
               CASE 
                  WHEN t2.meta_value < '" . $fechaInicial . "' then '1' 
                  WHEN t2.meta_value BETWEEN '" . $fechaInicial . "' AND '" . $fechaFinal . "' then 2
                  WHEN t2.meta_value > '" . $fechaFinal . "' then 3
               END,
               CASE 
                  WHEN t2.meta_value < '" . $fechaInicial . "' then 'vencidos' 
                  WHEN t2.meta_value BETWEEN '" . $fechaInicial . "' AND '" . $fechaFinal . "' then 'vencen este mes' 
                  WHEN t2.meta_value > '" . $fechaFinal . "' then 'en proceso'
               END";

      $this->totalAcuerdos = $wpdb->get_results($sql, ARRAY_A);

      return $this->totalAcuerdos;
   }
   public function get_totalAcuerdosComite()
   {
      global $wpdb;

      $user_id = get_current_user_id();
      $verAcuerdos = $this->get_verAcuerdos();
      $datosAcuerdos = [];
      foreach ($verAcuerdos as $comite => $facultad) {
         if ($facultad == 'todos') {
            $sql = "
                  SELECT t1.meta_value AS ID, 
                     count(ID) as total 
                  FROM wp_posts 
                  INNER JOIN wp_postmeta AS t1 ON (ID = t1.post_id) 
                  WHERE post_type = 'acuerdo' 
                  AND (  t1.meta_key = '_comite_id' AND t1.meta_value = $comite ) 
                  GROUP BY t1.meta_value
                  ";
            $sqlResult = $wpdb->get_results($sql, ARRAY_A);
         } else {
            $sql = "
                  SELECT t1.meta_value AS ID, 
                     count(ID) as total 
                  FROM wp_posts 
                  INNER JOIN wp_postmeta AS t1 ON (ID = t1.post_id) 
                  INNER JOIN wp_postmeta AS t2 ON (ID = t2.post_id) 
                  WHERE post_type = 'acuerdo' 
                  AND ( 
                        ( t1.meta_key = '_comite_id' AND t1.meta_value = $comite ) 
                     AND ( t2.meta_key = '_asingnar_a' AND t2.meta_value = $user_id ) 
                     ) 
                  GROUP BY t1.meta_key
                  ";
            $sqlResult = $wpdb->get_results($sql, ARRAY_A);
         }
         array_push($datosAcuerdos, $sqlResult);
      }
      sort($datosAcuerdos);
      return $this->totalAcuerdos = $datosAcuerdos;
   }
   public function get_totalAcuerdosComiteUsr($comite_id, $usr_id)
   {

      $fechaInicial = date('Y-m-d', strtotime('First day of ' . date('F')));
      $fechaFinal = date('Y-m-d', strtotime('Last day of ' . date('F')));
      $proceso = array(
         'post_type' => 'acuerdo',
         'posts_per_page' => -1,
         'post_status' => 'publish',
         'orderby' => '_f_compromiso',
         'order' => 'ASC',
         'meta_query' => [
            [
               'key' => '_f_compromiso',
               'value' => $fechaFinal,
               'compare' => '>'
            ],
            [
               'key' => '_vigente',
               'value' => '1',
            ],
            [
               'key' => '_comite_id',
               'value' => $comite_id,
            ],
            [
               'key' => '_asignar_id',
               'value' => $usr_id,
            ],
         ]
      );
      $this->totalAcuerdos['proceso'] = count(get_posts($proceso));
      $mes = array(
         'post_type' => 'acuerdo',
         'posts_per_page' => -1,
         'post_status' => 'publish',
         'orderby' => '_f_compromiso',
         'order' => 'ASC',
         'meta_query' => [
            [
               'key' => '_f_compromiso',
               'value' => [$fechaInicial, $fechaFinal],
               'compare' => 'BETWEEN'
            ],
            [
               'key' => '_vigente',
               'value' => '1',
            ],
            [
               'key' => '_comite_id',
               'value' => $comite_id,
            ],
            [
               'key' => '_asignar_id',
               'value' => $usr_id,
            ],
         ]
      );
      $this->totalAcuerdos['porvencer'] = count(get_posts($mes));
      $vencidos = array(
         'post_type' => 'acuerdo',
         'posts_per_page' => -1,
         'post_status' => 'publish',
         'orderby' => '_f_compromiso',
         'order' => 'ASC',
         'meta_query' => [
            [
               'key' => '_f_compromiso',
               'value' => $fechaInicial,
               'compare' => '<'
            ],
            [
               'key' => '_vigente',
               'value' => '1',
            ],
            [
               'key' => '_comite_id',
               'value' => $comite_id,
            ],
            [
               'key' => '_asignar_id',
               'value' => $usr_id,
            ],
         ]
      );
      $this->totalAcuerdos['vencidos'] = count(get_posts($vencidos));
      $ejecutados = array(
         'post_type' => 'acuerdo',
         'posts_per_page' => -1,
         'post_status' => 'publish',
         'orderby' => '_f_compromiso',
         'order' => 'ASC',
         'meta_query' => [
            [
               'key' => '_vigente',
               'value' => '0',
            ],
            [
               'key' => '_comite_id',
               'value' => $comite_id,
            ],
            [
               'key' => '_asignar_id',
               'value' => $usr_id,
            ],
         ]
      );
      $this->totalAcuerdos['ejecutados'] = count(get_posts($ejecutados));
      return $this->totalAcuerdos;
   }
   public function get_totalAcuerdosComiteFiltrados($comite_id, $usr_id, $tipofiltro)
   {
      if ($tipofiltro) {
         $Acuerdos = array(
            'post_type' => 'acuerdo',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'meta_query' => [
               [
                  'key' => '_comite_id',
                  'value' => $comite_id,
               ],
               [
                  'key' => '_asignar_id',
                  'value' => $usr_id,
               ],
            ]
         );
      } else {
         $Acuerdos = array(
            'post_type' => 'acuerdo',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'meta_query' => [
               [
                  'key' => '_comite_id',
                  'value' => $comite_id,
               ],
            ]
         );
      }
      $this->totalAcuerdos = count(get_posts($Acuerdos));
      return $this->totalAcuerdos;
   }
   public function get_vigencia_acuerdos($f_compromiso, $vigente)
   {
      $fechaInicial = date('Y-m-d', strtotime('First day of ' . date('F')));
      $fechaFinal = date('Y-m-d', strtotime('Last day of ' . date('F')));
      if ($f_compromiso < $fechaInicial && $vigente == 1) {
         $this->status = 'Vencido';
      } elseif ($f_compromiso >= $fechaInicial && $f_compromiso <= $fechaFinal && $vigente == 1) {
         $this->status = 'Vence este mes';
      } elseif ($f_compromiso > $fechaFinal && $vigente == 1) {
         $this->status = 'Proceso';
      } else {
         $this->status = '';
      }
      return $this->status;
   }
   public function get_verAcuerdos()
   {
      if (is_user_logged_in()) {
         $usuario = wp_get_current_user();
         $usuarioRoles = $usuario->roles;
         if (in_array('administrator', $usuarioRoles) || in_array('useradmingeneral', $usuarioRoles)) {
            $userAdmin = true;
         } else {
            $userAdmin = false;
         }
      }
      $comites = get_posts([
         'post_type' => 'comite',
         'numberposts' => -1,
         'post_status' => 'publish',
      ]);

      $miembros = get_posts([
         'post_type' => 'miembro',
         'numberposts' => -1,
         'post_status' => 'publish',
         'meta_key' => '_usr_id',
         'meta_value' => $usuario->ID,
      ]);


      if ($userAdmin) {
         foreach ($comites as $comite) {
            $this->verAcuerdosComite[$comite->ID] = 'todos';
         }
      } else {
         $miembroJunta = false;
         foreach ($miembros as $miembro) {
            if (preg_match("/Junta/i", $miembro->post_title)) {
               $miembroJunta = true;
            }
         }
         if ($miembroJunta) {
            foreach ($comites as $comite) {
               $this->verAcuerdosComite[$comite->ID] = 'todos';
            }
         } else {
            $coordinador = false;
            foreach ($miembros as $miembro) {
               if (preg_match("/Coordina/i", $miembro->post_title)) {
                  $this->verAcuerdosComite[get_post_meta($miembro->ID, '_comite_id', true)] = 'todos';
                  $coordinador = true;
               }
            }
            if ($coordinador) {
               foreach ($comites as $comite) {
                  if ($this->verAcuerdosComite[$comite->ID] == null) {
                     $this->verAcuerdosComite[$comite->ID] = 'asignados';
                  }
               }
            } else {
               foreach ($comites as $comite) {
                  $this->verAcuerdosComite[$comite->ID] = 'asignados';
               }
            }
         }
      }
      return $this->verAcuerdosComite;
   }
   public function get_miembroJunta()
   {
      $this->miembroJunta = false;
      $usuario = wp_get_current_user();

      $miembros = get_posts([
         'post_type' => 'miembro',
         'numberposts' => -1,
         'post_status' => 'publish',
         'meta_key' => '_usr_id',
         'meta_value' => $usuario->ID,
      ]);

      if (count($miembros)) {
         foreach ($miembros as $miembro) {
            if ($usuario->ID == get_post_meta($miembro->ID, '_usr_id', true)) {
               if (preg_match("/Junta/i", $miembro->post_title)) {
                  $this->miembroJunta = true;
               }
            }
         }
      } else {
         $this->miembroJunta = false;
      }
      return $this->miembroJunta;
   }
   public function get_datosComites()
   {
      $comites = get_posts([
         'post_type' => 'comite',
         'numberposts' => -1,
         'post_status' => 'publish',
         'orderby' => 'ID',
         'order' => 'ASC'
      ]);

      $datosComite = [];
      array_push($datosComite, ['ID' => 'todos', 'nombre' => 'Resumen General']);
      foreach ($comites as $comite) {
         array_push($datosComite, ['ID' => $comite->ID, 'nombre' => get_post($comite)->post_title]);
      }
      $this->datosComites['comites'] = $datosComite;

      $status = ['vencidos', 'porvencer', 'proceso'];
      $datosComiteStatus = [];
      foreach ($datosComite as $comite) {
         foreach ($status as $sts) {
            array_push($datosComiteStatus, ['ID' => $comite['ID'], 'nombre' => $comite['nombre'], 'status' => $sts, 'total' => 0]);
         }
      }

      $this->datosComites['datosComite'] = $datosComiteStatus;

      return $this->datosComites;
   }
   public function get_totalAcuerdosOld($comite_id)
   {

      $fechaInicial = date('Y-m-d', strtotime('First day of ' . date('F')));
      $fechaFinal = date('Y-m-d', strtotime('Last day of ' . date('F')));
      if ($comite_id == 'todos') {
         $filtroComite = [];
      } else {
         $filtroComite =
            [
               'key' => '_comite_id',
               'value' => $comite_id,
            ];
      }
      $proceso = array(
         'post_type' => 'acuerdo',
         'posts_per_page' => -1,
         'post_status' => 'publish',
         'orderby' => '_f_compromiso',
         'order' => 'ASC',
         'meta_query' => [
            [
               'key' => '_f_compromiso',
               'value' => $fechaFinal,
               'compare' => '>'
            ],
            [
               'key' => '_vigente',
               'value' => '1',
            ],
            $filtroComite,
         ]
      );
      $this->totalAcuerdos['proceso'] = count(get_posts($proceso));
      $mes = array(
         'post_type' => 'acuerdo',
         'posts_per_page' => -1,
         'post_status' => 'publish',
         'orderby' => '_f_compromiso',
         'order' => 'ASC',
         'meta_query' => [
            [
               'key' => '_f_compromiso',
               'value' => [$fechaInicial, $fechaFinal],
               'compare' => 'BETWEEN'
            ],
            [
               'key' => '_vigente',
               'value' => '1',
            ],
            $filtroComite,
         ]
      );
      $this->totalAcuerdos['porvencer'] = count(get_posts($mes));
      $vencidos = array(
         'post_type' => 'acuerdo',
         'posts_per_page' => -1,
         'post_status' => 'publish',
         'orderby' => '_f_compromiso',
         'order' => 'ASC',
         'meta_query' => [
            [
               'key' => '_f_compromiso',
               'value' => $fechaInicial,
               'compare' => '<'
            ],
            [
               'key' => '_vigente',
               'value' => '1',
            ],
            $filtroComite,
         ]
      );
      $this->totalAcuerdos['vencidos'] = count(get_posts($vencidos));
      return $this->totalAcuerdos;
   }
   public function get_totalAcuerdosUsrOld($usr_id)
   {

      $fechaInicial = date('Y-m-d', strtotime('First day of ' . date('F')));
      $fechaFinal = date('Y-m-d', strtotime('Last day of ' . date('F')));
      $proceso = array(
         'post_type' => 'acuerdo',
         'posts_per_page' => -1,
         'post_status' => 'publish',
         'orderby' => '_f_compromiso',
         'order' => 'ASC',
         'meta_query' => [
            [
               'key' => '_f_compromiso',
               'value' => $fechaFinal,
               'compare' => '>'
            ],
            [
               'key' => '_vigente',
               'value' => '1',
            ],
            [
               'key' => '_asignar_id',
               'value' => $usr_id,
            ],
         ]
      );
      $this->totalAcuerdos['proceso'] = count(get_posts($proceso));
      $mes = array(
         'post_type' => 'acuerdo',
         'posts_per_page' => -1,
         'post_status' => 'publish',
         'orderby' => '_f_compromiso',
         'order' => 'ASC',
         'meta_query' => [
            [
               'key' => '_f_compromiso',
               'value' => [$fechaInicial, $fechaFinal],
               'compare' => 'BETWEEN'
            ],
            [
               'key' => '_vigente',
               'value' => '1',
            ],
            [
               'key' => '_asignar_id',
               'value' => $usr_id,
            ],
         ]
      );
      $this->totalAcuerdos['porvencer'] = count(get_posts($mes));
      $vencidos = array(
         'post_type' => 'acuerdo',
         'posts_per_page' => -1,
         'post_status' => 'publish',
         'orderby' => '_f_compromiso',
         'order' => 'ASC',
         'meta_query' => [
            [
               'key' => '_f_compromiso',
               'value' => $fechaInicial,
               'compare' => '<'
            ],
            [
               'key' => '_vigente',
               'value' => '1',
            ],
            [
               'key' => '_asignar_id',
               'value' => $usr_id,
            ],
         ]
      );
      $this->totalAcuerdos['vencidos'] = count(get_posts($vencidos));
      $ejecutados = array(
         'post_type' => 'acuerdo',
         'posts_per_page' => -1,
         'post_status' => 'publish',
         'orderby' => '_f_compromiso',
         'order' => 'ASC',
         'meta_query' => [
            [
               'key' => '_vigente',
               'value' => '0',
            ],
            [
               'key' => '_asignar_id',
               'value' => $usr_id,
            ],
         ]
      );
      $this->totalAcuerdos['ejecutados'] = count(get_posts($ejecutados));
      return $this->totalAcuerdos;
   }
   public function get_totalAcuerdosComiteOLD($comite_id)
   {

      $fechaInicial = date('Y-m-d', strtotime('First day of ' . date('F')));
      $fechaFinal = date('Y-m-d', strtotime('Last day of ' . date('F')));
      $proceso = array(
         'post_type' => 'acuerdo',
         'posts_per_page' => -1,
         'post_status' => 'publish',
         'orderby' => '_f_compromiso',
         'order' => 'ASC',
         'meta_query' => [
            [
               'key' => '_f_compromiso',
               'value' => $fechaFinal,
               'compare' => '>'
            ],
            [
               'key' => '_vigente',
               'value' => '1',
            ],
            [
               'key' => '_comite_id',
               'value' => $comite_id,
            ],
         ]
      );
      $this->totalAcuerdos['proceso'] = count(get_posts($proceso));
      $mes = array(
         'post_type' => 'acuerdo',
         'posts_per_page' => -1,
         'post_status' => 'publish',
         'orderby' => '_f_compromiso',
         'order' => 'ASC',
         'meta_query' => [
            [
               'key' => '_f_compromiso',
               'value' => [$fechaInicial, $fechaFinal],
               'compare' => 'BETWEEN'
            ],
            [
               'key' => '_vigente',
               'value' => '1',
            ],
            [
               'key' => '_comite_id',
               'value' => $comite_id,
            ],
         ]
      );
      $this->totalAcuerdos['porvencer'] = count(get_posts($mes));
      $vencidos = array(
         'post_type' => 'acuerdo',
         'posts_per_page' => -1,
         'post_status' => 'publish',
         'orderby' => '_f_compromiso',
         'order' => 'ASC',
         'meta_query' => [
            [
               'key' => '_f_compromiso',
               'value' => $fechaInicial,
               'compare' => '<'
            ],
            [
               'key' => '_vigente',
               'value' => '1',
            ],
            [
               'key' => '_comite_id',
               'value' => $comite_id,
            ],
         ]
      );
      $this->totalAcuerdos['vencidos'] = count(get_posts($vencidos));
      $ejecutados = array(
         'post_type' => 'acuerdo',
         'posts_per_page' => -1,
         'post_status' => 'publish',
         'orderby' => '_f_compromiso',
         'order' => 'ASC',
         'meta_query' => [
            [
               'key' => '_vigente',
               'value' => '0',
            ],
            [
               'key' => '_comite_id',
               'value' => $comite_id,
            ],
         ]
      );
      $this->totalAcuerdos['ejecutados'] = count(get_posts($ejecutados));
      return $this->totalAcuerdos;
   }
}
