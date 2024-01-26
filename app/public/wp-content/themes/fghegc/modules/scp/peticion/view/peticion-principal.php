<?php
if (is_user_logged_in()) {
   $class = "";
} else {
   $class = "d-flex justify-content-center";
}
?>
<div class="row <?php echo $class ?>">
   <h2 class="mb-3 text-center">Envíanos tu Petición</h2>
   <div class="col col-md-6">
      <form id="peticiones" class="needs-validation" novalidate>
         <div class="form-group row">
            <div class="col-lg-6 mb-3">
               <input type="text" name="nombre" placeholder="Nombre" class="form-control" required>
               <div class="invalid-feedback">
                  Por favor indicar un nombre.
               </div>
            </div>
            <div class="col-lg-6 mb-3">
               <input type="text" name="apellido" placeholder="Apellido" class="form-control" required>
               <div class="invalid-feedback">
                  Por favor indicar un apellido.
               </div>
            </div>
         </div>
         <div class="form-group row">
            <div class="col-lg-6 mb-3">
               <input type="email" name="email" placeholder="e-mail" class="form-control" required>
               <div class="invalid-feedback">
                  Por favor indicar un correo válido.
               </div>
            </div>
            <div class="col-lg-6 mb-3">
               <input type="text" name="telefono" placeholder="Teléfono móvil" class="form-control" required>
               <div class="invalid-feedback">
                  Por favor indicar un teléfono móvil.
               </div>
            </div>
         </div>
         <div class="form-group">
            <h4 class="text-center">Motivos de oración</h4>
            <div class="table-responsive">
               <table class="table text-reset align-middle table-sm">
                  <tbody>
                     <tr>
                        <td class="fs-4">Salvación:</td>
                        <td>
                           <div class="form-check form-check-inline">
                              <input class="form-check-input" name="cat1" type="checkbox" value="5">
                              <label class="form-check-label">Personal</label>
                           </div>
                        </td>
                        <td>
                           <div class="form-check form-check-inline">
                              <input class="form-check-input" name="cat2" type="checkbox" value="6">
                              <label class="form-check-label">Familiares</label>
                           </div>
                        </td>
                        <td>
                           <div class="form-check form-check-inline">
                              <input class="form-check-input" name="cat3" type="checkbox" value="7">
                              <label class="form-check-label">Otros</label>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td class="fs-4">Salud:</td>
                        <td>
                           <div class="form-check form-check-inline">
                              <input class="form-check-input" name="cat4" type="checkbox" value="8">
                              <label class="form-check-label">Personal</label>
                           </div>
                        </td>
                        <td>
                           <div class="form-check form-check-inline">
                              <input class="form-check-input" name="cat5" type="checkbox" value="9">
                              <label class="form-check-label">Familiares</label>
                           </div>
                        </td>
                        <td>
                           <div class="form-check form-check-inline">
                              <input class="form-check-input" name="cat6" type="checkbox" value="10">
                              <label class="form-check-label">Otros</label>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td class="fs-4">Matrimonio:</td>
                        <td>
                           <div class="form-check form-check-inline">
                              <input class="form-check-input" name="cat7" type="checkbox" value="11">
                              <label class="form-check-label">Personal</label>
                           </div>
                        </td>
                        <td>
                           <div class="form-check form-check-inline">
                              <input class="form-check-input" name="cat8" type="checkbox" value="12">
                              <label class="form-check-label">Familiares</label>
                           </div>
                        </td>
                        <td>
                           <div class="form-check form-check-inline">
                              <input class="form-check-input" name="cat9" type="checkbox" value="13">
                              <label class="form-check-label">Otros</label>
                           </div>
                        </td>
                        <td></td>
                     </tr>
                     <tr>
                        <td class="fs-4">Provisión:</td>
                        <td>
                           <div class="form-check  form-check-inline">
                              <input class="form-check-input" name="cat10" type="checkbox" value="14">
                              <label class="form-check-label">Trabajo</label>
                           </div>
                        </td>
                        <td>
                           <div class="form-check  form-check-inline">
                              <input class="form-check-input" name="cat11" type="checkbox" value="15">
                              <label class="form-check-label">Manejo Finanzas</label>
                           </div>
                        </td>
                        <td>
                           <div class="form-check  form-check-inline">
                              <input class="form-check-input" name="cat12" type="checkbox" value="16">
                              <label class="form-check-label">Otro</label>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td class="fs-4">Otros:</td>
                        <td>
                           <div class="form-check  form-check-inline">
                              <input class="form-check-input" name="cat13" type="checkbox" value="17">
                              <label class="form-check-label">Favor detallar</label>
                           </div>
                        <td></td>
                        <td></td>
                     </tr>
                  </tbody>
               </table>
            </div>
            <div class="form-group mb-3 alert alert-danger text-center" role="alert">
               <h4>Todas las peticiones se manejarán de forma confidencial.</h4>
            </div>
            <div class="form-group mb-3">
               <textarea name="peticion" cols="30" rows="5" class="form-control" placeholder="Espacio para detallar tu petición"></textarea>
            </div>
            <div class="form-group d-grid mb-3">
               <button type="submit" class="btn btn-warning mb-3">Enviar petición</button>
            </div>
            <input type="hidden" name="action" value="peticion">
            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('peticiones') ?>">
            <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
            <input type="hidden" name="f_peticion" value="<?php echo date('Y-m-d H:i');  ?>">
            <input type="hidden" name="msgtxt" value="Gracias por enviarnos tu petición. Estaremos contactándote lo antes posible.">
         </div>
      </form>

   </div>
   <?php if (is_user_logged_in()) : ?>
      <div class="col col-md-6">
         <?php get_template_part('modules/scp/peticion/view/peticion-busquedas') ?>
      </div>
   <?php endif; ?>
</div>