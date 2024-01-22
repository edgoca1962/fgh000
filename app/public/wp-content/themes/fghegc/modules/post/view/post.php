<?php

/**
 * Plantilla para mostar los artículos del Blog
 * 
 * @package FGHEGC
 */

use FGHEGC\Modules\Core\CoreController;

$atributos = CoreController::get_instance()->get_atributos(get_post_type());

?>
<div class='col'>
   <div class="card h-100 shadow" style="background-color: rgba(40,48,61,1);">
      <img src="<?php echo (get_the_post_thumbnail_url()) ? get_the_post_thumbnail_url() : FGHEGC_DIR_URI . '/assets/img/bg.jpg' ?>" class="card-img-top" alt="post image">
      <div class="card-body">
         <h4 id="title_<?php get_the_ID() ?>" class="card-title">
            <?php echo the_title(sprintf('<h4><a href="%s" rel="bookmark">', esc_attr(esc_url(get_permalink() . '?pag=' . $atributos['pag']))), '</a></h4>') ?>
         </h4>
         <p class="card-text">
            <?php echo the_excerpt() ?>
         </p>
      </div>
      <div class="card-footer">
         <div class="row">
            <div class="col">
               <small class="text">
                  <?php if (has_tag()) {
                     echo get_the_tag_list('<p><span><i class="fas fa-tag"></i></span> Etiquetas: ', ', ', '</p>');
                  } else {
                     echo '<span><i class="fas fa-tag"></i></span> Sin etiquetas.';
                  } ?>
               </small>
            </div>
         </div>
         <div class="row">
            <div class="d-flex justify-content-around">
               <!-- Enviar e-mail -->
               <div class="p-0">
                  <!-- Botón trigger mensaje e-mail -->
                  <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#email_modal_<?php echo get_the_ID() ?>" data-send_email="true" data-post_id="<?php echo get_the_ID() ?>">
                     <i class="fa-solid fa-envelope-circle-check"></i> e-mail
                  </button>
                  <!-- Modal Captura mensaje e-mail -->
                  <div class="modal fade" id="email_modal_<?php echo get_the_ID() ?>" tabindex="-1" aria-labelledby="send_email" aria-hidden="true">
                     <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content text-black">
                           <form id="email_<?php echo get_the_ID() ?>" class="needs-validation" novalidate>
                              <div class="modal-header">
                                 <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de correo</h1>
                                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                 <div class="row form-outline mb-3">
                                    <textarea class="form-control is-valid" name="mensaje" id="mensaje_<?php echo get_the_ID() ?>" placeholder="Contenido del Mensaje" cols="30" rows="10" required></textarea>
                                    <div class="invalid-feedback">Por favor incluya el contenido del Mensaje.</div>
                                 </div>
                                 <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
                                 <input type="hidden" name="action" value="send_email">
                                 <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('send_email'); ?>">
                                 <input type="hidden" name="titulo_procesado" value="El mensaje ha sido enviado">
                                 <input type="hidden" name="origen" value="<?php echo get_post_type() ?>">
                                 <input type="hidden" name="enviado_por" value="<?php echo get_userdata($atributos['usuario_id'])->user_email ?>">
                                 <input type="hidden" name="enviar_a" value="edgoca1962@hotmail.com">
                                 <input type="hidden" name="enlace" value="<?php echo get_permalink() ?>">
                                 <input type="hidden" name="titulo" value="<?php echo get_the_title() ?>">
                              </div>
                              <div class="modal-footer">
                                 <button class="btn btn-outline-success btn-sm" type="submit" data-send_email="true" data-post_id="<?php echo get_the_ID() ?>">
                                    <i class="fa-solid fa-envelope-circle-check"></i> enviar mensaje
                                 </button>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
               <?php if ($atributos['userAdmin']) : ?>
                  <!-- Button trigger modal editar -->
                  <div class="p-0">
                     <button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modal_<?php echo get_the_ID() ?>" data-post_type="<?php echo get_post_type() ?>" data-post_id="<?php echo get_the_ID() ?>" data-url="<?php echo get_site_url() . '/wp-json/wp/v2/posts/' . get_the_ID() ?>" data-usr_id=<?php echo get_post_meta($post->ID, '_asignar_id', true) ?>><i class="fa-solid fa-pencil" style="font-size: 12px;"></i> Editar</button>
                  </div>
                  <!-- Button eliminar -->
                  <div class="p-0">
                     <form id="eliminar_<?php echo get_the_ID() ?>" class="needs-validation">
                        <button type="submit" class="btn btn-outline-danger btn-sm" data-post_id="<?php echo get_the_ID() ?>" data-eliminar="eliminar"><i class="fa-solid fa-trash-can" style="font-size: 12px;"></i> Eliminar</button>
                        <input type="hidden" name="action" value="eliminar_post">
                        <input type="hidden" name="gestion" value="eliminar">
                        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('eliminar_post') ?>">
                        <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
                        <input type="hidden" name="post_id" value="<?php echo get_the_ID() ?>">
                        <input type="hidden" name="titulo_confirmar" value="Se eliminará: <?php echo get_the_title() ?>">
                        <input type="hidden" name="titulo_procesado" value="El Artículo ha sido eliminado.">
                     </form>
                  </div>
               <?php endif; ?>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Modal Editar -->
<div class="modal fade text-black " id="modal_<?php echo get_the_ID() ?>" tabindex="-1" aria-labelledby="lbl_editar" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="background: rgba(255, 224, 0, 0.9)">
         <div class="modal-header">
            <h1 id="titulo_<?php echo get_the_ID() ?>" class="modal-title fs-5" id="lbl_<?php echo get_the_ID() ?>"></h1>
            <button id="btn_cerrar_<?php echo get_the_ID() ?>" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form id="editar_<?php echo get_the_ID() ?>" class="needs-validation" novalidate>
               <div class="row gy-2 gx-3 align-items-center">
                  <div class="col-md-6 mb-3">
                     <label for="titulo_post_<?php echo get_the_ID() ?>" class="form-label">Título</label>
                     <input id="titulo_post_<?php echo get_the_ID() ?>" type="text" class="form-control" name="titulo" required>
                     <div class="invalid-feedback">Por favor incluya el Título del Artículo.</div>
                  </div>
               </div>
               <div class="col">
                  <button id="btn_editar_post_<?php echo get_the_ID() ?>" class="btn text-white" type="submit" style="background-color: rgba(64, 154, 247, 1);">Actualizar Artículo</button>
               </div>
               <input type="hidden" name="action" value="editar_post">
               <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('editar_post') ?>">
               <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
               <input type="hidden" name="titulo_procesado" value="El Artículo ha sido modificado">
            </form>
         </div>
      </div>
   </div>
</div>