<!-- Button trigger modal -->
<button id="btn_agregar_post" type="button" class="mb-5 btn btn-warning" data-bs-toggle="modal" data-bs-target="#mantenimiento">
   <i class="fa-solid fa-book"></i> Agregar Post
</button>
<!-- Modal Agregar -->
<div class="modal fade" id="mantenimiento" tabindex="-1" aria-labelledby="lbl_mantenimiento" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="background-color: rgba(9,8,11,0.85);">
         <div class="modal-header">
            <h1 class="modal-title fs-5" id="lbl_mantenimiento">Agregar Post</h1>
            <button id="btn_cerrar" type=" button" class="btn btn-danger btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form id="agregar_post" class="needs-validation" novalidate>
               <div class="form-floating mb-3">
                  <input type="text" class="form-control bg-transparent text-white" id="agregar_titulo" placeholder="Título" required>
                  <label for="agregar_titulo">Título</label>
               </div>
               <div class="form-floating mb-3">
                  <textarea class="form-control bg-transparent text-white" name="agregar_contenido" style="height: 15em;" id="agregar_contenido" placeholder="Contenido del Post" required></textarea>
                  <label for="agregar_contenido">Contenido del Post</label>
               </div>
               <div class="col-12">
                  <button class="btn btn-warning" type="submit">Agregar Post</button>
               </div>
               <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
               <input type="hidden" name="action" value="agregar_post">
               <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('agregar_post') ?>">
               <input type="hidden" name="titulo_procesado" value="Artículo agregado exitosamente.">
            </form>
         </div>
      </div>
   </div>
</div>
<!-- Modal Editar -->
<div class="modal fade" id="editar" tabindex="-1" aria-labelledby="lbl_editar" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="background: rgba(9,8,11,0.85)">
         <div class="modal-header">
            <h1 id="titulo_post" class="modal-title fs-5" id="lbl_editar">Editar Posts</h1>
            <button id="btn_cerrar" type="button" class="btn btn-danger btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form id="editar_post" class="needs-validation" novalidate>
               <div class="form-floating mb-3">
                  <input type="text" class="form-control bg-transparent text-white" id="editar_titulo" name="editar_titulo" placeholder="Título" required>
                  <label for="editar_titulo">Título</label>
               </div>
               <div class="form-floating mb-3">
                  <textarea class="form-control bg-transparent text-white" name="editar_contenido" style="height: 15em;" id="editar_contenido" placeholder="Contenido del Post" required></textarea>
                  <label for="editar_contenido">Contenido del Post</label>
               </div>
               <div class="col-12">
                  <button id="btn_editar_post" class="btn btn-warning" type="submit">Actualizar Post</button>
               </div>
               <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
               <input type="hidden" name="action" value="editar_post">
               <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('editar_post') ?>">
               <input type="hidden" name="titulo_procesado" value="Post modificado exitosamente.">
            </form>
         </div>
      </div>
   </div>
</div>