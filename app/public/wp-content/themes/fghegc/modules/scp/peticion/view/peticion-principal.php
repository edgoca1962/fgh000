<?php

use FGHEGC\Modules\Core\CoreController;

$atributos = CoreController::get_instance()->get_atributos('peticion');

?>

<div class="row <?php echo $atributos['peticionClass'] ?>">
   <div class="col col-md-6">
      <h2 class="mb-3 text-center">Envíanos tu Petición</h2>
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
               <table class="table table-sm align-middle">
                  <tbody>
                     <?php foreach ($atributos['motivos'] as $motivos => $datos) : ?>
                        <tr>
                           <td class="text-white bg-transparent fs-4"><?php echo $motivos ?>:</td>
                           <?php foreach ($datos as $dato) : ?>
                              <td class="text-white bg-transparent">
                                 <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="<?php echo $dato['name'] ?>" type="checkbox" value="<?php echo term_exists($dato['value'], 'motivo', '')['term_id']  ?>" <?php echo $dato['hidden'] ?>>
                                    <label class="form-check-label"><?php echo $dato['label'] ?></label>
                                 </div>
                              </td>
                           <?php endforeach; ?>
                        </tr>
                     <?php endforeach; ?>
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
   <div class="col col-md-6" <?php echo $atributos['ocultarSidebar'] ?>>
      <?php get_template_part($atributos['sidebar'])
      ?>
   </div>
</div>
<?php
