<?php if (verAcuerdos()[get_post_meta($post->ID, '_comite_id', true)] == 'todos' || get_current_user_id() == get_post_meta($post->ID, '_asignar_id', true)) : ?>
   <div id="elemento_<?php echo get_the_ID() ?>">
      <div class="card mb-5 shadowcss" style="background: linear-gradient(to right, rgba(64, 154, 247, 1), rgba(43, 170, 177, 1)) !important; color: #fff;">
         <div class="card-header pt-4 d-flex">
            <div class="col-md-8">
               <h6><i class="fa-solid fa-handshake me-3"></i>
                  <?php echo 'Fecha de compromiso: ' . get_post_meta($post->ID, '_f_compromiso', true) ?>
               </h6>
            </div>
            <div class="col-md-4">
               <h6>
                  <?php echo (get_post_meta($post->ID, '_vigente', true)) ? fgh000_get_param('acuerdo')['status'] : 'Ejecutado el: ' . get_post_meta($post->ID, '_f_seguimiento', true) ?>
               </h6>
            </div>
         </div>
         <div class="card-body">
            <h5 class="card-title">
               <?php echo get_post(get_post_parent($post->ID))->post_title ?>
            </h5>
            <p class="card-text">
               <?php the_content() ?>
            </p>
            <p class="card-text">
               <small>
                  <?php echo 'Asignado a: ' . get_user_by('ID', get_post_meta($post->ID, '_asignar_id', true))->display_name ?>
               </small>
            </p>
         </div>
         <?php if (fgh000_get_param($post->post_type)['userAdmin']) { ?>
            <div class="card-footer">
               <div class="d-flex row">
                  <div class="col-sm-12 col-md-8">
                     <?php echo 'Comité: ' . get_post(get_post_meta($post->ID, '_comite_id', true))->post_title ?>
                  </div>
                  <div class="col-sm-12 col-md-4">
                     <div class="d-flex row">
                        <div class="col p-0">
                           <!-- Button trigger modal editar -->
                           <button type="button" class="btn btn-outline-warning btn-sm me-3" data-bs-toggle="modal" data-bs-target="#editar" data-editar="<?php echo get_the_ID() ?>" data-url="<?php echo get_site_url() . '/wp-json/wp/v2/acuerdos/' . get_the_ID() ?>" data-usr_id=<?php echo get_post_meta($post->ID, '_asignar_id', true) ?>><i class="fa-solid fa-pencil" style="font-size: 12px;"></i> Editar</button>
                        </div>
                        <div class="col p-0">
                           <form id="<?php echo get_the_ID() ?>">
                              <button type="button" class="btn btn-outline-danger btn-sm" data-post_id="<?php echo get_the_ID() ?>" data-eliminar="elemento_<?php echo get_the_ID() ?>"><i class="fa-solid fa-trash-can" style="font-size: 12px;"></i> Eliminar</button>
                              <input type="hidden" name="action" value="eliminar_acuerdo">
                              <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('eliminar_acuerdo') ?>">
                              <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
                              <input type="hidden" name="post_id" value="<?php echo get_the_ID() ?>">
                              <input id="titulo_elemento_<?php echo get_the_ID() ?>" class="invisible" type="hidden" value="<?php echo 'Acuerdo ' . get_post_meta($post->ID, '_n_acuerdo', true) ?>">
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
         <?php } ?>
      </div>
   </div>
   <input id="msg_<?php echo $post->ID ?>" type="hidden" value="<?php echo get_post_meta($post->ID, '_n_acuerdo', true) ?>">
<?php else : ?>
   <h3>No está autorizado a ver esta información</h3>
<?php endif; ?>
<!-- Modal Editar -->
<div class="text-black modal fade" id="editar" tabindex="-1" aria-labelledby="lbl_editar" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="background: rgba(255, 224, 0, 0.9)">
         <div class="modal-header">
            <h1 id="titulo_acuerdo" class="modal-title fs-5" id="lbl_editar">Editar Acuerdo</h1>
            <button id="btn_cerrar" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form id="editar_acuerdo" class="needs-validation" novalidate>
               <div class="row gy-2 gx-3 align-items-center">
                  <div class="col-md-4 mb-3">
                     <label for="f_compromiso" class="form-label">F. Compromiso</label>
                     <input id="f_compromiso" type="date" class="form-control" name="f_compromiso" value="">
                  </div>
                  <div class="col-md-4 mb-3">
                     <div class="form-check form-switch pt-3">
                        <label for="" class="form-label"></label>
                        <input class="form-check-input" type="checkbox" role="switch" id="vigente" name="vigente" checked>
                        <label id="lbl_vigente" class="form-check-label" for="vigente">Vigente</label>
                     </div>
                  </div>
                  <div class="col-md-4 mb-3">
                     <label for="f_seguimiento" class="form-label">F. Ejecución</label>
                     <input id="f_seguimiento" type="date" class="form-control" name="f_seguimiento" disabled>
                  </div>
               </div>
               <div class="row mb-3">
                  <div class="col mb-3">
                     <label for="asignar_id" class="form-label">Acuerdo asignado a:</label>
                     <select name="asignar_id" id="asignar_id" class="form-select" aria-label="Selecionar miembro">
                        <option <?= (get_post_meta($post->ID, '_asignar_id', true) == '') ? 'value="0" selected' : 'value="0"' ?>>Sin asignar</option>
                        <?php
                        $usuarios = get_users('orderby=nicename');
                        foreach ($usuarios as $usuario) {
                        ?>
                           <option <?= (get_post_meta($post->ID, '_asignar_id', true) == $usuario->ID) ? 'value="' . esc_attr($usuario->ID) . '" Selected' : 'value="' . $usuario->ID . '"' ?>><?= $usuario->display_name ?></option>
                        <?php
                        }
                        ?>
                     </select>
                  </div>
               </div>
               <div class="row mb-3 form-outline">
                  <textarea class="form-control is-valid" name="contenido" id="contenido" placeholder="Contenido del Acuerdo" cols="30" rows="10" required></textarea>
                  <!-- <label for="contenido" class="form-label"></label> -->
                  <div class="invalid-feedback">Por favor incluya el contenido del Acuerdo.</div>
               </div>
               <div class="col">
                  <button id="btn_editar_acuerdo" class="btn text-white" type="submit" style="background-color: rgba(64, 154, 247, 1);">Actualizar Acuerdo</button>
               </div>
               <input type="hidden" name="action" value="editar_acuerdo">
               <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('editar_acuerdo') ?>">
               <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
               <input id="elemento_id" type="hidden" name="post_id" value="">
               <input type="hidden" name="msgtxt" value="Acuerdo modificado exitosamente.">
            </form>
         </div>
      </div>
   </div>
</div>