<?php

/**
 * Plantilla para listar de acuerdos.
 * 
 * @package FGHEGC
 */

use FGHEGC\Modules\Core\CoreController;
use FGHEGC\Modules\Sca\Acuerdo\AcuerdoController;

$core = CoreController::get_instance();
$atributos = CoreController::get_instance()->get_atributos('acuerdo');
$acuerdo = AcuerdoController::get_instance();

$status = $acuerdo->get_vigencia_acuerdos(get_post_meta(get_the_ID(), '_f_compromiso', true), get_post_meta(get_the_ID(), '_vigente', true));
$asignado = (get_post_meta(get_the_ID(), '_asignar_id', true) === 0) ? false : get_userdata(get_post_meta(get_the_ID(), '_asignar_id', true));

?>
<?php if ($atributos['userAdmin']) : ?>

   <div id="elemento_<?php echo get_the_ID() ?>" class="col">
      <div class="card mb-5 shadow" style="background: linear-gradient(to right, rgba(64, 154, 247, 1), rgba(43, 170, 177, 1)); color: #fff;">
         <div class="card-header pt-4 row d-flex">
            <div class="col-12 col-md-8 d-flex justify-content-start justify-content-md-start">
               <h6><i class="fa-solid fa-handshake me-3"></i>
                  <?php echo 'Fecha de compromiso: ' . get_post_meta(get_the_ID(), '_f_compromiso', true) ?>
               </h6>
            </div>
            <div class="col-12 col-md-4 d-flex justify-content-start justify-content-md-end">
               <h6>
                  Estatus:
                  <?php echo (get_post_meta(get_the_ID(), '_vigente', true)) ? $status : 'Ejecutado el: ' . get_post_meta(get_the_ID(), '_f_seguimiento', true) ?>
               </h6>
            </div>
         </div>
         <div class="card-body">
            <h5 class="card-title"> <a class="text-white" href="<?php echo esc_attr(esc_url(get_the_permalink() . '?pag=' . $atributos['pag'] . '&' . $atributos['parametros'])) ?>"><?php echo get_the_title() ?></a></h5>
            <p class="card-text">
               <?php echo the_excerpt() ?>
            </p>
            <p class="card-text">
               <small>
                  <!-- <?php echo ($asignado) ? 'Asignado a: ' . $asignado->display_name : 'Asignado a: Acuerdo sin asignar a responsable'; ?> -->
               </small>
            </p>
         </div>
         <div class="card-footer">
            <div class="d-flex row">
               <div class="col-sm-12 col-md-4">
                  <?php echo 'Comité: ' . get_post(get_post_meta(get_the_ID(), '_comite_id', true))->post_title ?>
               </div>
               <div class="col-sm-12 col-md-8">
                  <div class="d-flex justify-content-md-end mt-3 mt-md-0">
                     <?php if ($atributos['userAdmin']) : ?>
                        <!-- Button Editar -->
                        <button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modal_<?php echo get_the_ID() ?>" data-post_type="<?php echo get_post_type() ?>" data-post_id="<?php echo get_the_ID() ?>" data-url="<?php echo get_site_url() . '/wp-json/wp/v2/acuerdos/' . get_the_ID() ?>" data-usr_id=<?php echo get_post_meta($post->ID, '_asignar_id', true) ?>><i class="fa-solid fa-pencil" style="font-size: 12px;"></i> Editar</button>
                        <!-- Button Eliminar -->
                        <form id="eliminar_<?php echo get_the_ID() ?>" class="needs-validation">
                           <button type="submit" class="btn btn-outline-danger btn-sm mx-3" data-post_id="<?php echo get_the_ID() ?>" data-eliminar="true"><i class="fa-solid fa-trash-can" style="font-size: 12px;"></i> Eliminar</button>
                           <input type="hidden" name="action" value="eliminar_acuerdo">
                           <input type="hidden" name="gestion" value="eliminar">
                           <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('eliminar_acuerdo') ?>">
                           <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
                           <input type="hidden" name="post_id" value="<?php echo get_the_ID() ?>">
                           <input type="hidden" name="titulo_confirmar" value="Se eliminará: <?php echo get_the_title() ?>">
                           <input type="hidden" name="titulo_procesado" value="El Acuerdo ha sido eliminado.">
                        </form>
                     <?php endif; ?>
                     <!-- Button e-mail -->
                     <?php if ($status === 'Vencido' && $atributos['userAdmin']) : ?>
                        <form id="email_<?php echo get_the_ID() ?>" class="needs-validation">
                           <button type="submit" class="btn btn-warning btn-sm" data-send_email="true" data-post_id="send_email_<?php echo get_the_ID() ?>" <?php echo ($asignado) ? '' : 'disabled' ?>>
                              <i class="fa-solid fa-envelope-circle-check"></i> e-mail
                           </button>
                           <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
                           <input type="hidden" name="action" value="send_email">
                           <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('send_email'); ?>">
                           <input type="hidden" name="origen" value="<?php echo get_post_type() ?>">
                           <input type="hidden" name="enviado_por" value="<?php echo $atributos['usradmingeneralemail'] ?>">
                           <input type="hidden" name="con_copia_nombre" value="<?php echo $atributos['usradmingeneralname'] ?>">
                           <input type="hidden" name="enviar_a" value="<?php echo ($asignado) ? $asignado->user_email : '' ?>">
                           <input type="hidden" name="estatus" value="vencido">
                           <input type="hidden" name="enlace" value="<?php echo get_permalink() ?>">
                           <input type="hidden" name="titulo" value="<?php echo get_the_title() ?>">
                           <input type="hidden" name="titulo_procesado" value="El mensaje ha sido enviado.">
                        </form>
                     <?php else : ?>
                        <!-- Botón trigger captura mensaje e-mail -->
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#email_modal_<?php echo get_the_ID() ?>" data-send_email="true" data-post_id="<?php echo get_the_ID() ?>">
                           <i class="fa-solid fa-envelope-circle-check"></i> e-mail
                        </button>
                        <!-- Modal Captura mensaje e-mail -->
                        <div class="modal fade" id="email_modal_<?php echo get_the_ID() ?>" tabindex="-1" aria-labelledby="send_email" aria-hidden="true">
                           <div class="modal-dialog modal-dialog-centered">
                              <div class="modal-content text-black">
                                 <form id="email_<?php echo get_the_ID() ?>" class="needs-validation" novalidate>
                                    <div class="modal-header">
                                       <h1 class="modal-title fs-5" id="exampleModalLabel">Enviar Mnesaje</h1>
                                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                       <p>
                                          De : <?php echo get_userdata($atributos['usuario_id'])->user_email ?><br>
                                          Para: <?php echo $asignado->user_email ?><br>
                                          CC : <?php echo $atributos['usradmingeneralemail'] ?><br>
                                          Asunto: <?php echo get_the_title() ?>
                                       </p>
                                       <div class="row form-outline mb-3">
                                          <textarea class="form-control is-valid" name="mensaje" id="mensaje_<?php echo get_the_ID() ?>" placeholder="Contenido del Mensaje" cols="25" rows="3" required></textarea>
                                          <div class="invalid-feedback">Por favor incluya el contenido del Mensaje.</div>
                                       </div>
                                       <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
                                       <input type="hidden" name="action" value="send_email">
                                       <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('send_email'); ?>">
                                       <input type="hidden" name="estatus" value="no_vencido">
                                       <input type="hidden" name="enviado_por" value="<?php echo get_userdata($atributos['usuario_id'])->user_email ?>">
                                       <input type="hidden" name="enviar_a" value="<?php echo ($asignado) ? $asignado->user_email : '' ?>">
                                       <input type="hidden" name="con_copia" value="<?php echo $atributos['usradmingeneralemail'] ?>">
                                       <input type="hidden" name="con_copia_nombre" value="<?php echo $atributos['usradmingeneralname'] ?>">
                                       <input type="hidden" name="titulo_procesado" value="El mensaje ha sido enviado">
                                       <input type="hidden" name="origen" value="<?php echo get_post_type() ?>">
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
                     <?php endif; ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <input id="msg_<?php echo get_the_ID() ?>" type="hidden" value="<?php echo get_post_meta(get_the_ID(), '_n_acuerdo', true) ?>">
   <!-- Modal Editar -->
   <div class="modal fade text-black " id="modal_<?php echo get_the_ID() ?>" tabindex="-1" aria-labelledby="lbl_editar" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content" style="background: rgba(255, 224, 0, 0.9)">
            <div class="modal-header">
               <h1 id="titulo_<?php echo get_the_ID() ?>" class="modal-title fs-5" id="lbl_<?php echo get_the_ID() ?>"></h1>
               <button id="btn_cerrar_<?php echo get_the_ID() ?>" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <form id="acuerdo_<?php echo get_the_ID() ?>" class="needs-validation" novalidate>
                  <div class="row gy-2 gx-3 align-items-center">
                     <div class="col-md-4 mb-3">
                        <label for="f_compromiso" class="form-label">F. Compromiso</label>
                        <input id="f_compromiso_<?php echo get_the_ID() ?>" type="date" class="form-control" name="f_compromiso" value="">
                     </div>
                     <div class="col-md-4 mb-3">
                        <div class="form-check form-switch pt-3">
                           <input class="form-check-input" type="checkbox" role="switch" id="vigente_<?php echo get_the_ID() ?>" name="vigente" data-vigente="<?php echo get_the_ID() ?>" checked>
                           <label id="lbl_vigente_<?php echo get_the_ID() ?>" class="form-check-label" for="vigente">Vigente</label>
                        </div>
                     </div>
                     <div class="col-md-4 mb-3">
                        <label for="f_seguimiento" class="form-label">F. Ejecución</label>
                        <input id="f_seguimiento_<?php echo get_the_ID() ?>" type="date" class="form-control" name="f_seguimiento" disabled>
                     </div>
                  </div>
                  <div class="row mb-3">
                     <div class="col mb-3">
                        <label for="asignar_id_<?php echo get_the_ID() ?>" class="form-label">Acuerdo asignado a:</label>
                        <select name="asignar_id" id="asignar_id_<?php echo get_the_ID() ?>" class="form-select" aria-label="Selecionar miembro">
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
                     <textarea class="form-control is-valid" name="contenido" id="contenido_<?php echo get_the_ID() ?>" placeholder="Contenido del Acuerdo" cols="30" rows="10" required></textarea>
                     <div class="invalid-feedback">Por favor incluya el contenido del Acuerdo.</div>
                  </div>
                  <div class="col">
                     <button id="btn_editar_acuerdo_<?php echo get_the_ID() ?>" class="btn text-white" type="submit" style="background-color: rgba(64, 154, 247, 1);">Actualizar Acuerdo</button>
                  </div>
                  <input type="hidden" name="action" value="editar_acuerdo">
                  <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('editar_acuerdo') ?>">
                  <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
                  <input type="hidden" name="post_id" value="<?php echo get_the_ID() ?>">
                  <input type="hidden" name="titulo_procesado" value="Acuerdo modificado exitosamente.">
               </form>
            </div>
         </div>
      </div>
   </div>
<?php else : ?>
   <?php $core->set_atributo('verNavegacionPosts', false) ?>
<?php endif; ?>