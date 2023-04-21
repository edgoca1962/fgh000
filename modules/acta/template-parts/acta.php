<div class="col actas">
   <div class="card h-100"
      style="background: linear-gradient(to right, rgba(64, 154, 247, 1), rgba(43, 170, 177, 1)) !important; color: #fff;">
      <div class="d-flex align-items-center justify-content-center p-4">
         <div class=""><i class="fas fa-book-open" style="font-size:30px;"></i></div>
         <div class="ms-3 mb-4">
            <h6 class="card-title mb-0"><a class="text-white"
                  href="<?php echo get_post_type_archive_link('acuerdo') . '?cpt=acuerdo&acta_id=' . get_the_ID() . '&comite_id=' . fgh000_get_param(get_post_type())['comite_id'] ?>"><?php the_title() ?></a></h6>
         </div>
      </div>
      <?php if (fgh000_get_param(get_post_type())['userAdmin']): ?>
         <div class="d-flex card-footer">
            <button type="button" class="btn btn-outline-danger btn-sm" data-post_id="<?php echo get_the_ID() ?>"
               data-eliminar="elemento_<?php echo get_the_ID() ?>"><i class="fa-solid fa-trash-can"
                  style="font-size: 12px;"></i> Eliminar</button>

            <form id="<?php echo get_the_ID() ?>">
               <input type="hidden" name="action" value="eliminar_acta">
               <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('eliminar_acta') ?>">
               <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
               <input type="hidden" name="post_id" value="<?php echo get_the_ID() ?>">
            </form>

            <input id="titulo_elemento_<?php echo get_the_ID() ?>" class="invisible" type="hidden"
               value="<?php the_title() ?>">
            <input id="msg_elemento_<?php echo get_the_ID() ?>" class="invisible" type="hidden"
               value="Si elimina esta Acta se eliminarán también todos sus acuerdos.">
            <input id="msg2_elemento_<?php echo get_the_ID() ?>" class="invisible" type="hidden"
               value="El Acta y todos sus acuerdos han sido eliminados.">
         </div>
      <?php endif; ?>
   </div>
</div>
