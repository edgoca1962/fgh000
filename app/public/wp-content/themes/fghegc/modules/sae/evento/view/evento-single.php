<?php

use FGHEGC\Modules\Core\CoreController;

$atributos = CoreController::get_instance()->get_atributos(get_post_type());

?>

<!-- Evento Single Template -->
<div id="single_event" class="card mb-3 bg-transparent text-white shadow">
   <div class="row g-0">
      <div class="col-md-4">
         <img src="<?php echo (get_the_post_thumbnail_url()) ? get_the_post_thumbnail_url() : FGHEGC_DIR_URI . '/assets/img/manoevt.jpeg' ?>" class="img-fluid rounded-start" style="" alt="imagenevento">
      </div>
      <div class="col-md-8">
         <div class="card-body">
            <span class="fs-2 fw-bolder"><?php echo $atributos['datos_evento']['diaSemana'] . ' ' . $atributos['datos_evento']['nDiaSemana'] ?></span>
            <p class="fs-2 fw-bolder"><?php echo $atributos['datos_evento']['h_inicio'] ?></p>
            <p class="fs-5 fw-bolder" <?php echo $atributos['datos_evento']['ocultarDiasSemana'] ?>><?php echo '(' . $atributos['datos_evento']['diasSemana'] . ')' ?></p>
            <h1 class="card-title"><?php the_title() ?></h1>
            <p class="card-text"><?php the_content() ?></p>
            <p class="card-text" <?php echo $atributos['datos_evento']['ocultarAforo'] ?>><small class="text-body-secondary">El cupo es limitado</small></p>
            <p <?php echo $atributos['datos_evento']['ocultarDonativo'] ?>>El monto de la inscripción es de ¢<?php echo number_format($atributos['datos_evento']['montoDonativo'], 2, ',', '.') ?></p>
            <button type="button" class="btn btn-outline-warning me-3" data-bs-toggle="modal" data-bs-target="#inscripcion_modal_<?php echo get_the_ID() ?>" <?php echo $atributos['datos_evento']['ocultarBtnInscripcion'] ?>>Inscribirse</button>
            <a href="<?php echo esc_url(get_post_type_archive_link('inscripcion')) . '?cpt=inscripcion&pid=' . get_the_ID() ?>">
               <button type="button" class="btn btn-outline-info me-3" <?php echo $atributos['datos_evento']['ocultarDatosInscripcion'] ?>>Ver Inscripciones</button>
            </a>
            <h4 class="mt-3" <?php echo $atributos['datos_evento']['ocultarDatosInscripcion'] ?>>Total personas inscritas: <?php echo get_post_meta(get_the_ID(), '_q_inscripciones', true) ?></h4>
            <p class="card-text mt-3"><small class="text-body-secondary"><?php echo $atributos['datos_evento']['tipEve'] ?></small></p>
         </div>
      </div>
      <div class="card-footer" <?php echo $atributos['datos_evento']['displayFooter'] ?>>
         <div class="row">
            <!-- Editar Evento -->
            <div class="d-flex justify-content-start">
               <form id="editar_evento">
                  <button id="btn_edit_single" type="button" class="btn btn-outline-warning btn-sm me-3"><i class="fa-solid fa-pencil" style="font-size: 12px;"></i> Editar</button>
                  <input type="hidden" name="action" value="editarevento">
                  <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('editarevento') ?>">
                  <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
                  <input type="hidden" name="post_id" value="<?php echo get_the_ID() ?>">
               </form>

               <!-- Button eliminar -->
               <form id="eliminar_<?php echo get_the_ID() ?>" class="needs-validation">
                  <button type="submit" class="btn btn-outline-danger btn-sm" data-post_id="<?php echo get_the_ID() ?>" data-eliminar="eliminar"><i class="fa-solid fa-trash-can" style="font-size: 12px;"></i> Eliminar</button>
                  <input type="hidden" name="action" value="eliminarevento">
                  <input type="hidden" name="gestion" value="eliminar">
                  <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('eliminarevento') ?>">
                  <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
                  <input type="hidden" name="post_id" value="<?php echo get_the_ID() ?>">
                  <input type="hidden" name="titulo_confirmar" value="Se eliminará: <?php echo get_the_title() ?>">
                  <input type="hidden" name="titulo_procesado" value="El Artículo ha sido eliminado.">
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
                     <input type="email" class="form-control bg-transparent shadow-none text-white rounded-0 border-0 border-bottom border-1" id="email_<?php echo get_the_ID() ?>" name="email" placeholder="email" required>
                     <label for="email">Correo Electrónico</label>
                     <div class="invalid-feedback">
                        Favor no dejar en blanco.
                     </div>
                  </div>
                  <div class="col form-floating">
                     <input type="tel" class="form-control bg-transparent shadow-none text-white rounded-0 border-0 border-bottom border-1" id="celular_<?php get_the_ID() ?>" name="celular" placeholder="Celular" required>
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
                        <input id="n_referencia_<?php get_the_ID() ?>" name="n_referencia" class="form-control" type="text" placeholder="Referencia" <?php echo $atributos['datos_evento']['requiereDonativo'] ?>>
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
<!-- Editar -->
<section id="edit_event" hidden>
   <form id="evento" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate style="overflow:hidden;">
      <div class="col mb-3">
         <label for="title" class="form-label">Título del evento</label>
         <input id="title" name="title" type="text" class="form-control" value="" required>
         <div class="invalid-feedback">
            Por favor indicar un título para el evento
         </div>
      </div> <!-- Título -->
      <div class="row mb-3 d-flex">
         <div class="col-md-6 mb-3">
            <label class="mb-3" for="content">Descripción del evento</label>
            <textarea class="form-control" name="content" id="content" style="height:200px;"></textarea>
         </div> <!-- descripción del evento -->
         <div class="col-md-6">
            <div class="mb-3">
               <label>Escoger imágen del evento: </label>
            </div>
            <div class="rounded d-flex justify-content-center" style="height: 205px; overflow:hidden; ">
               <div class="card text-bg-dark shadow h-100">
                  <img id="imagennueva" src="<?php echo get_template_directory_uri() . '/assets/img/eventos.jpeg' ?>" class="h-100" style="width:min-content" alt="Imágen del evento">
                  <div class="card-img-overlay d-flex justify-content-center align-items-center">
                     <label class="display-1" for="evento_imagen"><i class="fa-regular fa-file-image"></i></label>
                     <input type="file" name="evento_imagen" id="evento_imagen" hidden>
                  </div>
               </div>
            </div>
         </div> <!-- imagen del evento -->
      </div> <!-- descripción e imagen del evento -->
      <div class="row d-flex">
         <div class="col-md-4 col-xl-3 mb-2">
            <label class="form-label">Tipo de evento </label>
            <select id="periodicidadevento" name='periodicidadevento' class="form-select" aria-label="Seleccionar frecuencia">
               <option value="1" selected>Evento único</option>
               <option value="2">Se repite diariamente</option>
               <option value="3">Se repite semanalmente</option>
               <option value="4">Se repite mensualmente</option>
               <option value="5">Se repite anualmente</option>
            </select>
         </div> <!-- Repetición evento -->
         <div class="col-md-4 col-xl-3 mt-md-4 pt-3 pe-0">
            <div class="form-check form-switch d-flex ">
               <input class="form-check-input" type="checkbox" role="switch" id="inscripcion" name="inscripcion" data-inscripcion="off" value="off">
               <label class="form-check-label ps-2" for="inscripcion">Requiere Inscripción</label>
            </div>
         </div> <!-- requiere inscripción -->
         <div class="col-md-4 col-xl-3">
            <div class="form-check form-switch d-flex my-2">
               <input class="form-check-input" type="checkbox" role="switch" id="donativo" name="donativo" data-donativo="off" value="off">
               <label class="form-check-label ps-2" for="donativo">Requiere donativo</label>
            </div>
            <div class="input-group">
               <span class="input-group-text">₡</span>
               <input id="montodonativo" name="montodonativo" type="number" class="form-control me-auto" aria-label="Amount" min="0.00" step="1000.00" max="1000000" placeholder="Monto donativo sugerido" disabled>
            </div>
         </div> <!-- donativo -->
         <div class="col-md-4 col-xl-3">
            <div class="form-check form-switch d-flex my-2">
               <input class="form-check-input" type="checkbox" role="switch" id="aforo" name="aforo" data-aforo="off" value="off">
               <label class="form-check-label ps-2" for="aforo">Requiere Aforo</label>
            </div>
            <input id="q_aforo" name="q_aforo" type="number" class="form-control me-auto" aria-label="Amount" min="0" max="10000" placeholder="Cantidad Aforo" disabled>
         </div> <!-- Requiere Aforo -->
      </div> <!-- Tipo evento, inscripción, donativo y Aforo -->
      <hr class="mt-3" />
      <div class="row d-flex align-items-center">
         <h4>Horario del evento</h4>
         <div class="col-md-4 col-xl-3 mb-3">
            <label for="f_inicio" class="form-label">Feha Inicio</label>
            <input type="date" class="form-control" id="f_inicio" name="f_inicio" value="<?php echo date('Y-m-d') ?>" required>
            <div class="invalid-feedback">
               Favor indicar fecha inicial.
            </div>
         </div> <!-- f_inicio -->
         <div class="col-md-4 col-xl-3 mb-3">
            <label for="h_inicio" class="form-label">Hora Inicio</label>
            <input type="time" class="form-control" id="h_inicio" name="h_inicio" value="<?php echo date('H:00', strtotime('+2 hours')) ?>">
         </div> <!-- h_inicio -->
         <div class="col-md-4 col-xl-3 mb-3">
            <label for="h_final" class="form-label">Hora Final</label>
            <input type="time" class="form-control" id="h_final" name="h_final" value="<?php echo date('H:00', strtotime('+3 hours')); ?>">
         </div> <!-- h_final -->
         <div class="col-md-4 col-xl-3">
            <div id="diacompleto" class="form-check form-switch mt-xl-3">
               <input class="form-check-input" type="checkbox" role="switch" id="dia_completo" name="dia_completo" data-opcion='off'>
               <label class="form-check-label" for="dia_completo">Día completo</label>
            </div>
         </div> <!-- dia_completo -->
      </div> <!-- horario del evento -->
      <hr>
      <div id="formatos_repeticion" class="row mb-3">
         <div class="row">
            <section id="unico" hidden>
            </section> <!-- Evento único -->
            <section id="diario" hidden>
               <?php get_template_part($atributos['evento_diario']) ?>
            </section> <!-- Evento diario -->
            <section id="semanal" hidden>
               <?php get_template_part($atributos['evento_semanal']) ?>
            </section> <!-- Evento semanal -->
            <section id="mensual" hidden>
               <?php get_template_part($atributos['evento_mensual']) ?>
            </section> <!-- Evento mensual -->
            <section id="anual" hidden>
               <?php get_template_part($atributos['evento_anual']) ?>
            </section> <!-- Evento anual -->
         </div> <!-- formatos repeticion por tipo de evento -->
      </div> <!-- Fromatos de periodicidad -->
      <div class="row mb-3 d-flex align-items-center">
         <div class="col-md-6 col-xl-3 mb-3">
            <label for="f_final" class="form-label">Fecha Final ó Recurrente</label>
            <input type="date" class="form-control" id="f_final" name="f_final" value="<?php echo date('Y-m-d') ?>">
            <div class="invalid-feedback">
               Favor indicar fecha final.
            </div>
         </div> <!-- f_final -->
      </div> <!-- inf. base evento -->
      <div class="col-12 mb-3">
         <button id="btncancelaredicionevento" type="button" class="btn btn-secondary me-3">Canelar edición</button>
         <button id=" btnregistrarevento" class="btn btn-success" type="submit"><i class="fas fa-save"></i> Guardar cambios</button>
      </div> <!-- Botones para acciones -->
      <input type="hidden" name="action" value="modificarevento">
      <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('modificarevento') ?>">
      <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
      <input type="hidden" name="post_id" value="<?php echo get_the_ID() ?>">
   </form>
   <p class="card-text mt-3"><small class="text-body-secondary"><?php echo $atributos['datos_evento']['tipEve'] ?></small></p>

   <hr>
</section>