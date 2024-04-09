<?php

/**
 * 
 * Lógica para la actualización de datos importados.
 * 
 * @package:EGC001
 * 
 */


if (1 == 2) {
   $beneficiarios = get_posts(['post_type' => 'beneficiario', 'posts_per_page' => -1]);

   foreach ($beneficiarios as $beneficiario) {
      echo $beneficiario->post_title . ' Comedor ID: ' . $beneficiario->post_parent . '<br>';
      // echo $beneficiario->post_title . ' Comedor ID: ' . $beneficiario->post_parent . ' Asignado a: ' . comiteId() . '<br>';
      // wp_update_post(['ID' => $beneficiario->ID, 'post_parent' => comiteId()]);
   }
   function comiteId()
   {
      $comite_id_rand = rand(580, 588);
      if ($comite_id_rand % 2 == 0) {
         $comite_id = $comite_id_rand;
      } else {
         $comite_id = $comite_id_rand + 1;
      }
      return $comite_id;
   }
}
if (1 == 2) {
   $beneficiarios = get_posts(['post_type' => 'beneficiario', 'posts_per_page' => -1]);
   $asistencias = get_posts(['post_type' => 'asistencia', 'posts_per_page' => -1]);

   foreach ($beneficiarios as $beneficiario) {
      echo $beneficiario->ID . ' ' . $beneficiario->post_title . '<br>';
      foreach ($asistencias as $asistencia) {
         if ($beneficiario->post_title === $asistencia->post_title) {
            echo $asistencia->post_title . ' Beneficiario: ' . $asistencia->post_parent . '<br>';
            wp_update_post(['ID' => $asistencia->ID, 'post_parent' => $beneficiario->ID]);
         }
      }
   }
}
