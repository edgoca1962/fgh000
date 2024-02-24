<h3>Pruebas Funcionales</h3>
<?php
$asistencia = get_posts(['post_type' => 'asistencia', 'posts_per_page' => -1, 'post_status' => 'publish', 'post_parent' => 77938]);
if ($asistencia) {
   foreach ($asistencia as $eliminar) {
      echo $eliminar->ID . ' ' . get_post($eliminar->post_parent)->post_title . '<br>';
   }
} else {
   echo 'No tiene bitácora de asistencia';
}
