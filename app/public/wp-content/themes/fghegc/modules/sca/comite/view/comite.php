<?php

/**
 * Plantilla para listar CPT comité.
 * 
 * @package fghmvc
 */

use FGHEGC\Modules\Core\CoreController;

$atributos = CoreController::get_instance()->get_atributos(get_post_type())

?>

<?php if ($atributos['userAdmin']) : ?>
   <div id="elemento_<?php echo get_the_ID() ?>" class="col">
      <div class="card" style="background: linear-gradient(to right, rgba(64, 154, 247, 1), rgba(43, 170, 177, 1)) !important; color: #fff;">
         <div class="d-flex p-4">
            <div class=""><i class="fas fa-users" style="font-size:55px;"></i></div>
            <div class="d-flex ms-3 mb-4">
               <a id="enlace_elemento_<?php echo get_the_ID() ?>" class="text-white" href="<?php echo get_post_type_archive_link('acta') . '?cpt=acta&comite_id=' . get_the_ID() ?>">
                  <h4 class="mb-0">
                     <?php the_title() ?>
                  </h4>
               </a>
            </div>
         </div>
         <div class="d-flex px-3">
            <p class="me-3"><i class="fas fa-users"></i> Miembros:
               <?php echo $atributos['miembros'] ?>
            </p>
            <p class="me-3"><i class="fa-solid fa-book-open"></i>
               <?php echo (substr(get_the_title(), 0, 5) == 'Junta') ? 'Actas' : 'Minutas' ?>
               <?php echo $atributos['actas'] ?>
            </p>
            <p class="me-3"><i class="fa-solid fa-handshake"></i> Acuerdos:
               <?php echo $atributos['acuerdos'] ?>
            </p>
         </div>
         <?php if ($atributos['userAdmin']) { ?>
            <div class="card-footer">
               <div class="row">
                  <div class="d-flex justify-content-around">
                     <!-- Button Editar -->
                     <div class="p-0">
                        <button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editar_<?php echo get_the_ID() ?>" data-post_id="<?php echo get_the_ID() ?>" data-post_type="<?php echo get_post_type() ?>" data-editar="true" data-url="<?php echo get_site_url() . '/wp-json/wp/v2/comites/' . get_the_ID() ?>">
                           <i class="fa-solid fa-pencil" style="font-size: 12px;"></i> Editar
                        </button>
                     </div>
                     <div class="p-0">
                        <!-- Button Eliminar -->
                        <form id="eliminar_<?php echo get_the_ID() ?>" class="needs-validation">
                           <button type="submit" class="btn btn-outline-danger btn-sm" data-post_id="<?php echo get_the_ID() ?>" data-eliminar="elemento_<?php echo get_the_ID() ?>"><i class="fa-solid fa-trash-can" style="font-size: 12px;"></i> Eliminar</button>
                           <input type="hidden" name="action" value="eliminar_comite">
                           <input type="hidden" name="gestion" value="eliminar">
                           <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('eliminar_comite') ?>">
                           <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
                           <input type="hidden" name="post_id" value="<?php echo get_the_ID() ?>">
                           <input type="hidden" name="titulo_confirmar" value="Se eliminará: <?php echo get_the_title() ?>">
                           <input type="hidden" name="msg_confirmar" value="Si elimina este comité se eliminarán también TODOS sus miembros, TODAS sus minutas/actas y TODOS sus acuerdos.">
                           <input type="hidden" name="titulo_procesado" value="El Comité ha sido eliminado.">
                           <input type="hidden" name="msg_procesado" value="El comité, sus miembros, sus minutas/actas y acuerdos han sido eliminados.">
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         <?php } ?>
      </div>
   </div>
   <!-- Modal Editar-->
   <div class="modal fade" id="editar_<?php echo get_the_ID() ?>" tabindex="-1" aria-labelledby="lbl_editar" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content text-black" style="background: rgba(255, 224, 0, 0.9)">
            <div class="modal-header">
               <h1 class="modal-title fs-5" id="lbl_editar_<?php echo get_the_ID() ?>">Editar Nombre de Comité </h1>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <form id="editar_<?php echo get_the_ID() ?>" class="row g-3 needs-validation" novalidate>
                  <div class="col">
                     <label for="nombrecomite" class="form-label">Nombre del Comité</label>
                     <input type="text" class="form-control" id="titulo_<?php echo get_the_ID() ?>" name="titulo" required>
                     <div class="invalid-feedback">
                        No dejar en blanco
                     </div>
                  </div>
                  <div class="col-12">
                     <button class="btn text-white" type="submit" style="background-color: rgba(64, 154, 247, 1);">Actualizar Comité</button>
                  </div>
                  <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
                  <input type="hidden" name="action" value="editar_comite">
                  <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('editar_comite') ?>">
                  <input type="hidden" name="titulo_procesado" value="Comité modificado exitosamente.">
                  <input type="hidden" name="post_id" value="<?php get_the_ID() ?>">
               </form>
            </div>
         </div>
      </div>
   </div>
<?php endif; ?>