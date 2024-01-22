<?php

/**
 * Plantilla para la pagina de menu de mantenimiento.
 * 
 * @package FGHEGC
 */

use FGHEGC\Modules\Core\CoreController;

$atributos = CoreController::get_instance()->get_atributos('acuerdo');

?>

<!-- Button trigger modal -->
<button id="btn_agregar_acuerdo" type="button" class="mb-5 btn btn-warning" data-bs-toggle="modal" data-bs-target="#mantenimiento">
   <i class="fa-solid fa-handshake"></i> Agregar Acuerdo
</button>
<!-- Modal Agregar -->
<div class="modal fade" id="mantenimiento" tabindex="-1" aria-labelledby="lbl_mantenimiento" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content text-black" style="background: rgba(255, 224, 0, 0.9)">
         <div class="modal-header">
            <h1 class="modal-title fs-5" id="lbl_mantenimiento">
               Agregar Acuerdo:
               <?php echo $atributos['subtitulo'] ?>
            </h1>
            <button id="btn_cerrar" type=" button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form id="agregar_acuerdo" class="row g-3 needs-validation" novalidate>
               <div class="row gy-2 gx-3 align-items-center">
                  <div class="col-md-4 mb-3">
                     <label for="n_acuerdo" class="form-label">Nº Acuerdo</label>
                     <input type="number" class="form-control" id="n_acuerdo" name="n_acuerdo" value="<?php echo $atributos['consecutivo'] ?>" data-n_acuerdos="<?php echo $atributos['num_acuerdos'] ?>" required>
                     <div class="invalid-feedback">
                        Favor no dejar en blanco.
                     </div>
                  </div>
                  <div class="col-md-4 mb-3">
                     <label for="mes_acuerdo" class="form-label">Mes</label>
                     <input type="text" class="form-control text-bg-secondary" id="mes_acuerdo" name="mes_acuerdo" value="<?php echo date('m', strtotime(get_post_meta($atributos['acta_id'], '_f_acta', true))) ?>" readonly>
                     <div class="invalid-feedback">
                        Favor no dejar en blanco.
                     </div>
                  </div>
                  <div class="col-md-4 mb-3">
                     <label for="year_acuerdo" class="form-label">Año</label>
                     <input type="text" class="form-control text-bg-secondary" id="year_acuerdo" name="year_acuerdo" value="<?php echo date('Y', strtotime(get_post_meta($atributos['acta_id'], '_f_acta', true))) ?>" readonly>
                     <div class="invalid-feedback">
                        Favor no dejar en blanco.
                     </div>
                  </div>
               </div>
               <div class="row gy-2 gx-3 align-items-center">
                  <div class="col-md-4 mb-3">
                     <label for="f_compromiso_agregar" class="form-label">F. Compromiso</label>
                     <input id="f_compromiso_agregar" type="date" class="form-control" name="f_compromiso" value="<?php echo date('Y-m-d') ?>" required>
                     <div class="invalid-feedback">
                        Favor no dejar en blanco.
                     </div>
                  </div>
                  <div class="col-md-4 mb-3">
                     <div class="form-check form-switch pt-3">
                        <input class="form-check-input" type="checkbox" role="switch" id="vigente_agregar" name="vigente" value="1" checked>
                        <label id="lbl_vigente_agregar" class="form-check-label" for="vigente_agregar">Vigente</label>
                     </div>
                  </div>
                  <div class="col-md-4 mb-3">
                     <label for="f_seguimiento_agregar" class="form-label">F. Ejecución</label>
                     <input id="f_seguimiento_agregar" type="date" class="form-control" name="f_seguimiento" value="" disabled>
                  </div>
               </div>
               <div class="row mb-3">
                  <label for="asignar_id" class="form-label">Acuerdo asignado a:</label>
                  <select name="asignar_id" id="asignar_id_agregar" class="form-select" aria-label="Selecionar miembro">
                     <option <?= (get_post_meta(get_the_ID(), '_asignar_id', true) == '') ? 'value="0" selected' : 'value="0"' ?>>Sin asignar</option>
                     <?php
                     $usuarios = get_users('orderby=display_name');
                     foreach ($usuarios as $usuario) {
                     ?>
                        <option <?= (get_post_meta(get_the_ID(), '_asignar_id', true) == $usuario->ID) ? 'value="' . esc_attr($usuario->ID) . '" Selected' : 'value="' . $usuario->ID . '"' ?>><?= $usuario->display_name ?></option>
                     <?php
                     }
                     ?>
                  </select>
               </div>
               <div class="row form-outline mb-3">
                  <textarea class="form-control is-valid" name="contenido" id="contenido_agregar" placeholder="Contenido del Acuerdo" cols="30" rows="10" required></textarea>
                  <!-- <label for="contenido" class="form-label"></label> -->
                  <div class="invalid-feedback">Por favor incluya el contenido del Acuerdo.</div>
               </div>

               <div class="col-12">
                  <button class="btn text-white" type="submit" style="background-color: rgba(64, 154, 247, 1);">Agregar
                     Acuerdo</button>
               </div>
               <input type="hidden" name="comite_id" value="<?php echo $atributos['comite_id'] ?>">
               <input type="hidden" name="acta_id" value="<?php echo $atributos['acta_id'] ?>">
               <input type="hidden" name="n_acta" value="<?php echo $atributos['subtitulo'] ?>">
               <input type="hidden" name="action" value="agregar_acuerdo">
               <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('agregar_acuerdo') ?>">
               <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
               <input type="hidden" name="titulo_procesado" value="Acuerdo agregado exitosamente.">
            </form>
         </div>
      </div>
   </div>
</div>