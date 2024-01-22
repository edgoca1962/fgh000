<div class="col">
   <div class="card bg-transparent shadow mb-3">
      <div class="row g-0">
         <div class="col-md-9">
            <div class="card-body">
               <h5 class="card-title">Inscripción de:</h5>
               <p> <?php the_title() ?></p>
               <?php if (get_post_meta(wp_get_post_parent_id(), '_donativo', true) == 'on') : ?>
                  <p> Referencia de pago:
                     <?php

                     echo ' Fecha: ' . get_post_meta(get_the_ID(), '_f_pago_inscripcion', true) . ' Referencia: ' . get_post_meta(get_the_ID(), '_n_referencia', true) . ' Monto: ' . number_format(get_post_meta(get_the_ID(), '_monto_pago_inscripcion', true), 2, '.', ',');

                     ?>
                  </p>
               <?php endif; ?>
               <p class="card-text"> Participantes inscritos:</p>
               <?php the_content() ?>
            </div>
         </div>
         <?php if (get_post_meta(wp_get_post_parent_id(), '_donativo', true) == 'on') : ?>
            <div id="cp_<?php echo get_the_ID() ?>" class="col-md-3 d-flex align-items-center justify-content-center p-3" data-cp_post_id="<?php echo get_the_ID() ?>">
               <img data-cp_post_id="<?php echo get_the_ID() ?>" src=" <?php echo (get_the_post_thumbnail_url()) ? get_the_post_thumbnail_url() : FGHMVC_DIR_URI . '/assets/img/comprobante_pago_default.jpeg' ?>" class="rounded w-50 shadow" alt="factura">
            </div>
         <?php endif; ?>
      </div>
   </div>
</div>

<!-- Modal -->
<div class="modal fade" id="cp_modal_id_<?php echo get_the_ID() ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog  modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <img id="cp_img_<?php echo get_the_ID() ?>" src="" class="img-fluid" alt="comprobante_pago">
         </div>
      </div>
   </div>
</div>