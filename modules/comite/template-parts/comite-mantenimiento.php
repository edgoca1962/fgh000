<!-- Button trigger modal -->
<button id="btn_agregar_comite" type="button" class="animate__animated animate__fadeInUp btn btn-warning mb-3" data-bs-toggle="modal" data-bs-target="#mantenimiento">
   <i class="fa-solid fa-users-gear"></i> Agregar Comité
</button>
<!-- Modal Agregar-->
<div class="modal fade" id="mantenimiento" tabindex="-1" aria-labelledby="lbl_mantenimiento" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content text-black" style="background: rgba(255, 224, 0, 0.9)">
         <div class="modal-header">
            <h1 class="modal-title fs-5" id="lbl_mantenimiento">Agregar Comité</h1>
            <button id="btn_cerrar_comite" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form id="agregar_comite" class="row g-3 needs-validation" novalidate>
               <div class="col">
                  <label for="title" class="form-label">Título del Comité</label>
                  <input type="text" class="form-control" id="title" name="title" required>
                  <div class="invalid-feedback">
                     Favor no dejar en blanco.
                  </div>
               </div>
               <div class="col-12">
                  <button class="btn text-white" type="submit" style="background-color: rgba(64, 154, 247, 1);">Agregar Comité</button>
               </div>
               <input type="hidden" name="action" value="agregar_comite">
               <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('agregar_comite') ?>">
               <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
               <input type="hidden" name="msgtxt" value="Comité agregado exitosamente.">
            </form>
         </div>
      </div>
   </div>
</div>
<!-- Modal Editar-->
<div class="modal fade" id="editar" tabindex="-1" aria-labelledby="lbl_editar" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content text-black" style="background: rgba(255, 224, 0, 0.9)">
         <div class="modal-header">
            <h1 class="modal-title fs-5" id="lbl_editar">Editar Nombre de Comité </h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form id="editar_nombre_comite" class="row g-3 needs-validation" novalidate>
               <div class="col">
                  <label for="nombrecomite" class="form-label">Nombre del Comité</label>
                  <input type="text" class="form-control" id="nombrecomite" name="nombrecomite" required>
                  <div class="invalid-feedback">
                     No dejar en blanco
                  </div>
               </div>
               <div class="col-12">
                  <button class="btn text-white" type="submit" style="background-color: rgba(64, 154, 247, 1);">Actualizar Comité</button>
               </div>
               <input type="hidden" name="action" value="editar_comite">
               <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('editar_comite') ?>">
               <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
               <input id="elemento_id" type="hidden" name="post_id" value="">
               <input type="hidden" name="msgtxt" value="Comité modificado exitosamente.">
            </form>
         </div>
      </div>
   </div>
</div>