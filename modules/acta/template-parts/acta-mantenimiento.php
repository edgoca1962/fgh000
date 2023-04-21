<!-- Button trigger modal -->
<?php if (fgh000_get_param(get_post_type())['comite_id'] != ''): ?>
   <button id="btn_agregar_acta" type="button" class="btn btn-warning mb-3" data-bs-toggle="modal"
      data-bs-target="#mantenimiento">
      <i class="fa-solid fa-users-gear"></i> Agregar
      <?php echo fgh000_get_param(get_post_type())['prefijo'] ?>
   </button>
<?php endif; ?>
<!-- Modal agregar -->
<div class="modal fade" id="mantenimiento" tabindex="-1" aria-labelledby="lbl_mantenimiento" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content text-black" style="background: rgba(255, 224, 0, 0.9)">
         <div class="modal-header">
            <h1 class="modal-title fs-5" id="lbl_mantenimiento">Agregar
               <?php echo fgh000_get_param(get_post_type())['prefijo'] ?>
            </h1>
            <button id="btn_cerrar" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form id="agregar_acta" class="row g-3 needs-validation" novalidate>
               <div class="col-md-4">
                  <label for="n_acta" class="form-label">Número de
                     <?php echo fgh000_get_param(get_post_type())['prefijo'] ?>
                  </label>
                  <input type="text" class="form-control" id="n_acta" name="n_acta"
                     value="<?php echo fgh000_get_param(get_post_type())['consecutivo'] ?>"
                     data-n_actas="<?php echo fgh000_get_param(get_post_type())['num_actas'] ?>" required>
                  <div class="invalid-feedback">
                     Indicar Número
                  </div>
               </div>
               <div class="col-md-4">
                  <label for="f_acta" class="form-label">Fecha de
                     <?php echo fgh000_get_param(get_post_type())['prefijo'] ?>
                  </label>
                  <input type="date" class="form-control" id="f_acta" name="f_acta" required>
                  <div class="invalid-feedback">
                     Indicar Fecha
                  </div>
               </div>
               <div class="col-12">
                  <button class="btn text-white" type="submit" style="background-color: rgba(64, 154, 247, 1);">Agregar
                     <?php echo fgh000_get_param(get_post_type())['prefijo'] ?>
                  </button>
               </div>
               <input type="hidden" name="comite_id"
                  value="<?php echo fgh000_get_param(get_post_type())['comite_id'] ?>">
               <input type="hidden" name="action" value="agregar_acta">
               <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('agregar_acta') ?>">
               <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
               <input type="hidden" name="msgtxt"
                  value="<?php echo fgh000_get_param(get_post_type())['prefijo'] ?> agregada exitosamente.">
               <input type="hidden" name="prefijo" value="<?php echo fgh000_get_param(get_post_type())['prefijo'] ?>">
            </form>
         </div>
      </div>
   </div>
</div>
