<div class="d-flex justify-content-center">
   <div class="col col-md-8">
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
               <div style="height: 205px; overflow:hidden; ">
                  <div class="card text-bg-dark shadowcss h-100">
                     <img id="imagennueva" src="<?php echo get_template_directory_uri() . '/assets/img/eventos.jpeg' ?>" class="card-img h-100" alt="Imágen del evento">
                     <div class="card-img-overlay d-flex justify-content-center align-items-center">
                        <label class="display-1" for="thumbnail"><i class="fa-regular fa-file-image"></i></label>
                        <input type="file" name="thumbnail" id="thumbnail" class="invisible" style="width: 0;">
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
                  <input class="form-check-input" type="checkbox" role="switch" id="inscripcion" name="inscripcion" data-inscripcion="0">
                  <label class="form-check-label ps-2" for="inscripcion">Requiere Inscripción</label>
               </div>
            </div> <!-- requiere inscripción -->
            <div class="col-md-4 col-xl-3">
               <div class="form-check form-switch d-flex my-2">
                  <input class="form-check-input" type="checkbox" role="switch" id="donativo" name="donativo" data-donativo="0">
                  <label class="form-check-label ps-2" for="donativo">Requiere donativo</label>
               </div>
               <div class="input-group">
                  <span class="input-group-text">₡</span>
                  <input id="montodonativo" name="montodonativo" type="number" class="form-control me-auto" aria-label="Amount" min="0.00" step="1000.00" max="1000000" placeholder="Monto donativo sugerido" disabled>
               </div>
            </div> <!-- donativo -->
            <div class="col-md-4 col-xl-3">
               <div class="form-check form-switch d-flex my-2">
                  <input class="form-check-input" type="checkbox" role="switch" id="aforo" name="aforo" data-aforo="0">
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
                  <input class="form-check-input" type="checkbox" role="switch" id="dia_completo" name="dia_completo" data-opcion='0'>
                  <label class="form-check-label" for="dia_completo">Día completo</label>
               </div>
            </div> <!-- dia_completo -->
         </div> <!-- horario del evento -->
         <hr>
         <div class="row mb-3">
            <div class="row">
               <section id="unico" class="invisible" style="height:0;">
               </section> <!-- Evento único -->
               <section id="diario" class="invisible" style="height:0;">
                  <?php get_template_part('modules/evento/template-parts/evento', 'diario') ?>
               </section> <!-- Evento diario -->
               <section id="semanal" class="invisible" style="height:0;">
                  <?php get_template_part('modules/evento/template-parts/evento', 'semanal') ?>
               </section> <!-- Evento semanal -->
               <section id="mensual" class="invisible" style="height:0;">
                  <?php get_template_part('modules/evento/template-parts/evento', 'mensual') ?>
               </section> <!-- Evento mensual -->
               <section id="anual" class="invisible" style="height:0;">
                  <?php get_template_part('modules/evento/template-parts/evento', 'anual') ?>
               </section> <!-- Evento anual -->
            </div> <!-- formatos repeticion por tipo de evento -->
         </div> <!-- Fromatos de periodicidad -->
         <div class="row mb-3 d-flex align-items-center">
            <div class="col-md-6 col-xl-3 mb-3">
               <label for="f_final" class="form-label">Fecha Final ó Recurrente</label>
               <input type="date" class="form-control" id="f_final" name="f_final" value="" required>
               <div class="invalid-feedback">
                  Favor indicar fecha final.
               </div>
            </div> <!-- f_final -->
         </div> <!-- inf. base evento -->
         <div class="col-12">
            <button id="btnregistrarevento" class="btn btn-warning" type="submit"><i class="fas fa-save"></i> Registrar evento</button>
         </div> <!-- Botones para acciones -->
         <input type="hidden" name="action" value="registrarevento">
         <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('evento') ?>">
         <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
         <input type="hidden" name="post_id" value="<?php echo get_the_ID() ?>">
         <input type="hidden" name="redireccion" value="<?php echo site_url('/') ?>">
      </form>
   </div>
</div>