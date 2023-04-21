<?php

function totalAcuerdos($comite_id)
{
   $totalAcuerdos = [];
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
   $totalAcuerdos['proceso'] = count(get_posts($proceso));
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
   $totalAcuerdos['porvencer'] = count(get_posts($mes));
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
   $totalAcuerdos['vencidos'] = count(get_posts($vencidos));
   return $totalAcuerdos;
}
function totalAcuerdosAnno($anno)
{
   $totalAcuerdos = [];
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
   $totalAcuerdos['proceso'] = count(get_posts($proceso));

   $totalAcuerdos['porvencer'] = 0;

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
   $totalAcuerdos['vencidos'] = count(get_posts($vencidos));

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
   $totalAcuerdos['ejecutados'] = count(get_posts($ejecutados));
   return $totalAcuerdos;
}

function totalAcuerdosUsr($usr_id)
{
   $totalAcuerdos = [];
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
   $totalAcuerdos['proceso'] = count(get_posts($proceso));
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
   $totalAcuerdos['porvencer'] = count(get_posts($mes));
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
   $totalAcuerdos['vencidos'] = count(get_posts($vencidos));
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
   $totalAcuerdos['ejecutados'] = count(get_posts($ejecutados));
   return $totalAcuerdos;
}
function totalAcuerdosComite($comite_id)
{
   $totalAcuerdos = [];
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
   $totalAcuerdos['proceso'] = count(get_posts($proceso));
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
   $totalAcuerdos['porvencer'] = count(get_posts($mes));
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
   $totalAcuerdos['vencidos'] = count(get_posts($vencidos));
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
   $totalAcuerdos['ejecutados'] = count(get_posts($ejecutados));
   return $totalAcuerdos;
}
function totalAcuerdosComiteUsr($comite_id, $usr_id)
{
   $totalAcuerdos = [];
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
   $totalAcuerdos['proceso'] = count(get_posts($proceso));
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
   $totalAcuerdos['porvencer'] = count(get_posts($mes));
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
   $totalAcuerdos['vencidos'] = count(get_posts($vencidos));
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
   $totalAcuerdos['ejecutados'] = count(get_posts($ejecutados));
   return $totalAcuerdos;
}
function totalAcuerdosComiteFiltrados($comite_id, $usr_id, $tipofiltro)
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
   $totalAcuerdos = count(get_posts($Acuerdos));
   return $totalAcuerdos;
}
