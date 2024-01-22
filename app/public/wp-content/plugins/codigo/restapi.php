<?php
function mcssca_restapi()
{
   register_rest_route('mcssca/v1', 'search', [
      'methots' => WP_REST_Server::READABLE,
      'callback' => 'mcssca_SearchResults',
   ]);
}

add_action('rest_api_init', 'mcssca_restapi');

function mcssca_SearchResults($data)
{
   $mainQuery = new WP_Query([
      'post_type' => ['post', 'page', 'acuerdo'],
      // 'posts_per_page' => -1,
      's' => sanitize_text_field($data['term'])
   ]);
   $resultados = [
      'posts' => [],
      'pages' => [],
      'acuerdos' => []
   ];
   while ($mainQuery->have_posts()) {
      $mainQuery->the_post();

      if (get_post_type() == 'post') {
         array_push(
            $resultados['posts'],
            [
               'titulo' => get_the_title(),
               'permalink' => get_the_permalink(),
            ]
         );
      }
      if (get_post_type() == 'page') {
         array_push(
            $resultados['pages'],
            [
               'titulo' => get_the_title(),
               'permalink' => get_the_permalink(),
            ]
         );
      }
      if (get_post_type() == 'acuerdo') {
         array_push(
            $resultados['acuerdos'],
            [
               'titulo' => get_the_title(),
               'permalink' => get_the_permalink(),
               'acta' => get_post(get_post_meta(get_the_ID(), '_acta_id', true))->post_title,
               'comite' => get_post(get_post_meta(get_the_ID(), '_comite_id', true))->post_title,
               'acuerdo' => get_post_meta(get_the_ID(), '_n_acuerdo', true),
               'asignado' => get_user_by('ID', get_post_meta(get_the_ID(), '_asignar_id', true))->display_name,
            ]
         );
      }
   }
   return $resultados;
}
