<?php

/**
 * Plantilla básica para listar eventos
 * 
 * @package FGHEGC
 * linear-gradient(0.25turn, #3f87a6, #ebf8e1, #f69d3c);
 */

use FGHEGC\Modules\Core\CoreController;

$atributos = CoreController::get_instance()->get_atributos(get_post_type());

?>
<div class='col'>
   <div class="card h-100 border-0 shadow text-white" style="background: linear-gradient(rgba(0, 0, 0,0.85),rgba(0, 0, 0,0.85)), url(<?php echo (get_the_post_thumbnail_url()) ? get_the_post_thumbnail_url() : FGHEGC_DIR_URI . '/assets/img/manoevt.jpeg' ?>) no-repeat center /cover;">
      <div id="evento_<?php echo get_the_ID() ?>" class="card-body">
         <span class="fs-2 fw-bolder"><?php echo $atributos['datos_evento']['diaSemana'] . ' ' . $atributos['datos_evento']['nDiaSemana'] ?></span>
         <p class="fs-2 fw-bolder"><?php echo $atributos['datos_evento']['h_inicio'] ?></p>
         <p class="fs-5 fw-bolder" <?php echo $atributos['datos_evento']['ocultarDiasSemana'] ?>><?php echo '(' . $atributos['datos_evento']['diasSemana'] . ')' ?></p>
         <?php echo the_title(sprintf('<h1><a href="%s" rel="bookmark">', esc_attr(esc_url(get_the_permalink() . '?pag=' . $atributos['pag']))), '</a></h1>') ?>
         <p class="card-text"><?php the_content() ?></p>
         <p class="card-text" <?php echo $atributos['datos_evento']['ocultarAforo'] ?>><small class="text-body-secondary">El cupo es limitado</small></p>
         <p <?php echo $atributos['datos_evento']['ocultarDonativo'] ?>>El monto de la inscripción es de ¢<?php echo number_format($atributos['datos_evento']['montoDonativo'], 2, ',', '.') ?></p>
         <button type="button" class="btn btn-outline-warning me-3" data-bs-toggle="modal" data-bs-target="#inscripcion_modal_<?php echo get_the_ID() ?>" <?php echo $atributos['datos_evento']['ocultarBtnInscripcion'] ?>>Inscribirse</button>
         <p class="card-text mt-3" <?php echo $atributos['datos_evento']['ocultarTipEve'] ?>><small class="text-body-secondary"><?php echo $atributos['datos_evento']['tipEve'] ?></small></p>
      </div>
      <div class="card-footer" <?php echo $atributos['datos_evento']['displayFooter'] ?>>
         <div class="row">
            <!-- Button trigger modal editar -->
            <div class="d-flex justify-content-start">
               <form id="eliminar_<?php echo get_the_ID() ?>" class="needs-validation">
                  <button type="submit" class="btn btn-outline-danger btn-sm" data-post_id="<?php echo get_the_ID() ?>" data-eliminar="eliminar"><i class="fa-solid fa-trash-can" style="font-size: 12px;"></i> Eliminar</button>
                  <input type="hidden" name="action" value="eliminarevento">
                  <input type="hidden" name="gestion" value="eliminar">
                  <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('eliminarevento') ?>">
                  <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
                  <input type="hidden" name="post_id" value="<?php echo get_the_ID() ?>">
                  <input type="hidden" name="titulo_confirmar" value="Se eliminará: <?php echo get_the_title() ?>">
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Inscripción -->
<div class="modal fade" id="inscripcion_modal_<?php echo get_the_ID() ?>" tabindex="-1" aria-labelledby="inscripcionLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content shadow">
         <form class="needs-validation" id="inscripcion_<?php echo get_the_ID() ?>" enctype="multipart/form-data" novalidate>
            <div class="modal-header">
               <h1 class="modal-title fs-5 text-black" id="inscripcionLabel">Inscripción: <?php echo get_the_title(get_the_ID()) ?></h1>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" data-btn_cancelar="<?php echo get_the_ID() ?>"></button>
            </div>
            <div class="modal-body" style="background-color: rgba(40,48,61,0.95);">
               <div class="row mt-5 mb-3">
                  <div class="col form-floating">
                     <input type="email" class="form-control shadow-none text-white rounded-0 border-0 border-bottom border-1" id="email_<?php echo get_the_ID() ?>" name="email" placeholder="email" required>
                     <label for="email">Correo Electrónico</label>
                     <div class="invalid-feedback">
                        Favor no dejar en blanco.
                     </div>
                  </div>
                  <div class="col form-floating">
                     <input type="tel" class="form-control shadow-none text-white rounded-0 border-0 border-bottom border-1" id="celular_<?php get_the_ID() ?>" name="celular" placeholder="Celular" required>
                     <label for="celular">Celular</label>
                     <div class="invalid-feedback">
                        Favor no dejar en blanco.
                     </div>
                  </div>
               </div>
               <div class="row mb-3" <?php echo $atributos['datos_evento']['ocultarDonativo'] ?>>
                  <div class="row mb-3 text-center">
                     <h4>Datos del pago</h4>
                     <div class="col">
                        <input id="f_pago_<?php get_the_ID() ?>" name="f_pago_inscripcion" class="form-control" type="date" placeholder="Fecha de Pago" value="<?php echo date('Y-m-d') ?>" <?php echo $atributos['datos_evento']['requiereDonativo'] ?>>
                        <div class="invalid-feedback">
                           Favor no dejar en blanco.
                        </div>
                     </div>
                     <div class="col">
                        <input id="n_referencia_<?php get_the_ID() ?>" name="n_referencia" class="form-control" type="text" placeholder="Referencia" <?php  ?>>
                        <div class="invalid-feedback">
                           Favor no dejar en blanco.
                        </div>
                     </div>
                     <div class="col input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">¢</span>
                        <input id="monto_pago_<?php get_the_ID() ?>" name="monto_pago_inscripcion" type="numeric" class="form-control rounded-end" placeholder="Monto" aria-label="Username" aria-describedby="basic-addon1" <?php echo $atributos['datos_evento']['requiereDonativo'] ?>>
                        <div class="invalid-feedback">
                           Favor no dejar en blanco.
                        </div>
                     </div>
                  </div>
                  <div class="row justify-content-center mb-3">
                     <div class="col-8">
                        <label id="lbl_comprobante_pago_<?php echo get_the_ID() ?>" for="btn_comprobante_pago_<?php echo get_the_ID() ?>" class="form-control text-center bg-warning border-0 mb-3" data-post_id="<?php echo get_the_ID() ?>"><i class="fa-solid fa-magnifying-glass"></i> Adjuntar Comprobante de Pago</label>
                        <input type="file" name="comprobante_pago" id="btn_comprobante_pago_<?php echo get_the_ID() ?>" class="form-control" value="" hidden>
                     </div>
                  </div>
               </div>
               <hr <?php echo $atributos['datos_evento']['ocultarDonativo'] ?>>
               <div class="row mb-3">
                  <h4>Participantes</h4>
                  <div class="col form-floating">
                     <input type="text" class="form-control bg-transparent shadow-none text-white rounded-0 border-0 border-bottom border-1" id="nombre_<?php echo get_the_ID() ?>" name="nombre" placeholder="Nombre">
                     <label for="nombre_<?php echo get_the_ID() ?>">Nombre</label>
                     <div class="invalid-feedback">
                        Favor no dejar en blanco.
                     </div>
                  </div>
                  <div class="col form-floating mb-3">
                     <input type="text" class="form-control bg-transparent shadow-none text-white rounded-0 border-0 border-bottom border-1" id="apellido_<?php echo get_the_ID() ?>" name="apellido" placeholder="Apellido">
                     <label for="apellido_<?php echo get_the_ID() ?>">Apellido</label>
                     <div class="invalid-feedback">
                        Favor no dejar en blanco.
                     </div>
                  </div>
                  <div class="col-2">
                     <button id="btn_insert_<?php echo get_the_ID() ?>" type="button" class="btn btn-warning fs-4 fw_bolder" data-btn_post_id="<?php echo get_the_ID() ?>"><i class="fa-solid fa-user-plus" data-btn_post_id="<?php echo get_the_ID() ?>" data-boleta="<?php echo $atributos['datos_evento']['dataBoleta'] ?>"></i></button>
                  </div>
               </div>
               <div class="row mb-5">
                  <div class="col">
                     <label for="post_content_<?php echo get_the_ID() ?>">Lista de participantes</label>
                     <textarea class="form-control" placeholder="Participantes" id="post_content_<?php echo get_the_ID() ?>" cols="30" rows="5" disabled></textarea>
                  </div>
                  <textarea class="form-control" name="content_inscripcion" placeholder="Participantes" id="content_inscripcion_<?php echo get_the_ID() ?>" hidden></textarea>
               </div>
            </div>
            <div class="modal-footer">
               <button id="btn_cancelar_<?php echo get_the_ID() ?>" data-btn_cancelar="<?php echo get_the_ID() ?>" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
               <button id="btn_inscribirse_<?php echo get_the_ID() ?>" type="submit" class="btn btn-outline-primary" disabled>Inscribirse</button>
               <input id="q_inscripciones_<?php echo get_the_ID() ?>" type="hidden" name="q_inscripciones">
               <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
               <input type="hidden" name="action" value="registrar_inscripcion">
               <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('inscribir'); ?>">
               <input type="hidden" name="post_parent" value="<?php echo get_the_ID(); ?>">
               <input type="hidden" name="origen" value="<?php echo get_post_type() ?>">
               <input type="hidden" name="enlace" value="<?php echo get_permalink() ?>">
               <input type="hidden" name="titulo" value="<?php echo get_the_title() ?>">
               <input type="hidden" name="enviado_por" value="<?php echo $atributos['usradmingeneralemail'] ?>">
               <input type="hidden" name="con_copia_nombre" value="<?php echo $atributos['usradmingeneralname'] ?>">
            </div>
         </form>
      </div>
   </div>
</div>
<?php
