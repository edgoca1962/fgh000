<div id="elemento_<?php echo get_the_ID() ?>" class="col">
   <div class="card mb-5 shadowcss" style="background: linear-gradient(to right, rgba(64, 154, 247, 1), rgba(43, 170, 177, 1)) !important; color: #fff;">
      <div class="card-header pt-4 d-flex">
         <div class="col-md-8">
            <h6><i class="fa-solid fa-handshake me-3"></i>
               <?php echo 'Fecha de compromiso: ' . get_post_meta(get_the_ID(), '_f_compromiso', true) ?>
            </h6>
         </div>
         <div class="col-md-4">
            <h6>
               <?php echo (get_post_meta(get_the_ID(), '_vigente', true)) ? fgh000_get_param('acuerdo')['status'] : 'Ejecutado el: ' . get_post_meta(get_the_ID(), '_f_seguimiento', true) ?>
            </h6>
         </div>
      </div>
      <div class="card-body">
         <h5 class="card-title"> <a class="text-white" href="<?php echo esc_attr(esc_url(get_the_permalink() . '?pag=' . fgh000_get_param(get_post_type())['pag'] . '&' . fgh000_get_param(get_post_type())['parametros'])) ?>"><?php echo get_the_title() ?></a></h5>
         <p class="card-text">
            <?php echo the_excerpt() ?>
         </p>
         <p class="card-text">
            <small>
               <?php echo 'Asignado a: ' . get_user_by('ID', get_post_meta(get_the_ID(), '_asignar_id', true))->display_name ?>
            </small>
         </p>
      </div>
      <?php if (fgh000_get_param(get_post_type())['userAdmin']) : ?>
         <div class="card-footer">
            <div class="d-flex row">
               <div class="col-sm-12 col-md-8">
                  <?php echo 'Comité: ' . get_post(get_post_meta(get_the_ID(), '_comite_id', true))->post_title ?>
               </div>
               <div class="col-sm-12 col-md-4">
                  <div class="d-flex row">
                     <!-- Button trigger modal editar -->
                     <div class="col p-0">
                        <button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editar" data-editar="<?php echo get_the_ID() ?>" data-url="<?php echo get_site_url() . '/wp-json/wp/v2/acuerdos/' . get_the_ID() ?>" data-usr_id=<?php echo get_post_meta(get_the_ID(), '_asignar_id', true) ?>><i class="fa-solid fa-pencil" style="font-size: 12px;"></i> Editar</button>
                     </div>

                     <div class="col p-0">
                        <form id="<?php echo get_the_ID() ?>">
                           <button type="button" class="btn btn-outline-danger btn-sm" data-post_id="<?php echo get_the_ID() ?>" data-eliminar="elemento_<?php echo get_the_ID() ?>"><i class="fa-solid fa-trash-can" style="font-size: 12px;"></i> Eliminar</button>
                           <input type="hidden" name="action" value="eliminar_acuerdo">
                           <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('eliminar_acuerdo') ?>">
                           <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
                           <input type="hidden" name="post_id" value="<?php echo get_the_ID() ?>">
                           <input id="titulo_elemento_<?php echo get_the_ID() ?>" class="invisible" type="hidden" value="<?php echo 'Acuerdo ' . get_post_meta(get_the_ID(), '_n_acuerdo', true) ?>">
                           <input id="msg_elemento_<?php echo get_the_ID() ?>" class="invisible" type="hidden" value="Se eliminará este acuerdo del Acta.">
                           <input id="msg2_elemento_<?php echo get_the_ID() ?>" class="invisible" type="hidden" value="El acuerdo ha sido eliminado.">
                        </form>
                     </div>
                     <div class="col p-0">
                        <form id="send_email_<?php echo get_the_ID() ?>">
                           <button class="btn btn-warning btn-sm" type="submit" data-send_email="true" data-post_id="send_email_<?php echo get_the_ID() ?>">
                              <i class="fa-solid fa-envelope-circle-check"></i> e-mail
                           </button>
                           <input type="hidden" name="enviado_por" value="rvalverde@monterrey.ed.cr">
                           <input type="hidden" name="enviar_a" value="<?php echo get_user_by('ID', get_post_meta(get_the_ID(), '_asignar_id', true))->user_email ?>">
                           <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
                           <input type="hidden" name="action" value="send_email">
                           <input type="hidden" name="enlace" value="<?php echo get_permalink() ?>">
                           <input type="hidden" name="titulo" value="<?php echo get_the_title() ?>">
                           <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('send_email'); ?>">
                           <input type="hidden" name="msgtxt" value="Mensaje enviado.">
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      <?php endif; ?>
   </div>
</div>
<input id="msg_<?php echo get_the_ID() ?>" type="hidden" value="<?php echo get_post_meta(get_the_ID(), '_n_acuerdo', true) ?>">