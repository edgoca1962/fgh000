<?php

use FGHEGC\Modules\Core\CoreController;
use FGHEGC\Modules\Scp\Peticion\PeticionController;

$atributos = CoreController::get_instance()->get_atributos('peticion');
$peticiones = PeticionController::get_instance();
?>
<?php if ($atributos['verPeticiones']) : ?>
   <div class="row mb-3">
      <div class="position-relative">
         <form id="frmbuscar" class="d-flex">
            <input id="impbuscar" class="form-control w-75 me-2" type="text" style="width: 0;" placeholder="Buscar petición" aria-label="Search">
         </form>
         <div id="resultados" class="container invisible position-absolute search-overlay rounded-3 w-75" style="height:300px;">
            <div class="d-flex justify-content-between">
               <h4>Peticiones</h4><span id="btn_cerrar"><i class="far fa-times-circle"></i></span>
            </div>
            <div id="resultados_busqueda" data-url="<?php echo get_site_url() . '/wp-json/wp/v2/peticiones/?search=' ?>"></div>
         </div>
      </div>
   </div>
   <div class="row mb-3">
      <div class="col">
         <h4>Hoy debemos orar por:</h4>
         <?php foreach ($atributos['seguimiento'] as $post) : ?>
            <a href="<?php echo esc_url(get_the_permalink()) ?>"><?php echo get_the_title() ?><?php echo (get_post_meta($post->ID, '_asignar_a', true) != '0') ? ' Asignada a: ' . get_user_by('id', get_post_meta($post->ID, '_asignar_a', true))->display_name : ' - Sin asignar' ?>
               <span><i class="fas fa-praying-hands"></i></span><span><?php echo ' ' . $peticiones->get_oraciones(get_the_ID()) ?></span><br>
            </a>
         <?php endforeach; ?>
      </div>
      <div class="col">
         <table class="table table-sm table-borderless text-white">
            <thead>
               <tr class="table-dark">
                  <th scope="col">Día</th>
                  <th scope="col">Nombre</th>
                  <th scope="col">Teléfono</th>
               </tr>
            </thead>
            <tbody>
               <?php foreach ($atributos['cumpleanos'] as $peticion) : ?>
                  <tr>
                     <th scope="row" class="<?php echo $peticion['bg'] ?>">
                        <?php echo $peticion['dia']  ?>
                     </th>
                     <td class="<?php echo $peticion['bg'] ?>">
                        <?php echo $peticion['nombre'] ?>
                     </td>
                     <td class="<?php echo $peticion['bg'] ?>">
                        <a href="tel: <?php echo $peticion['telefono']  ?>" class="<?php echo $peticion['bg'] ?>"><span class="pe-2"><i class="bi bi-telephone"></i></span><?php echo $peticion['telefono'] ?></a>
                     </td>
                  </tr>
               <?php endforeach; ?>
            </tbody>
         </table>
      </div>
   </div>
   <div class="row">
      <div class="col">
         <h4>Mi seguimiento</h4>
         <?php if ($atributos['peticionesAsignadas']) : ?>
            <?php foreach ($atributos['peticionesAsignadas'] as $peticion) : ?>
               <a href="<?php echo esc_url(get_the_permalink()) ?>"><?php echo get_the_title() ?><?php echo (get_post_meta($peticion->ID, '_asignar_a', true) != '0') ? ' Asignada a: ' . get_user_by('id', get_post_meta($peticion->ID, '_asignar_a', true))->display_name : ' - Sin asignar' ?>
                  <span><i class="fas fa-praying-hands"></i></span><span><?php echo ' ' . $peticiones->get_oraciones(get_the_ID()) ?></span><br>
               </a>
            <?php endforeach; ?>
         <?php else : ?>
            <h5>No hay periciones asignadas</h5>
         <?php endif; ?>
      </div>
      <div class="col">
         <h4>Peticiones asignadas a:</h4>
         <?php
         foreach ($atributos['asignacion'] as $dato) {
            echo "<a href=" . esc_url(get_post_type_archive_link("peticion")) . "?cpt=peticion&asignado=" . $dato['usr_id'] . ">";
            echo get_user_by('ID', $dato['usr_id'])->display_name . ' (' . $dato['total'] . ')';
            echo '</a><br>';
         }
         ?>
      </div>
   </div>
   <div class="row">
      <h4>Comentarios de seguimiento</h4>
      <div id="comentarios" class="mt-3">
         <?php
         if (comments_open() || get_comments_number())
            comments_template('/modules/scp/peticion/view/peticion-comments-sidebar.php')
         ?>
      </div>
   </div>
   <div class="row">
      <div class="col">
         <h4>Motivos de Oración</h4>
         <ul>
            <?php wp_list_categories(
               [
                  'show_option_none'   => __('No hay Motivos'),
                  'orderby'            => 'name',
                  'order'              => 'ASC',
                  'style'              => 'list',
                  'show_count'         => 1,
                  'hide_empty'         => 1,
                  'use_desc_for_title' => 1,
                  'child_of'           => 0,
                  'hierarchical'       => true,
                  'title_li'           => '',
                  'number'             => NULL,
                  'echo'               => 1,
                  'depth'              => 0,
                  'current_category'   => 0,
                  'pad_counts'         => 0,
                  'taxonomy'           => 'motivo',
                  'hide_title_if_empty' => false,
                  'separator'          => '<br />',
               ]
            ) ?>
         </ul>
      </div>
      <div class="col">
         <h4>Palabras Clave</h4>
      </div>
   </div>
<?php endif; ?>