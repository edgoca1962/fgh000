<?php

use FGHEGC\Modules\Core\CoreController;
use FGHEGC\Modules\Scc\Beneficiario\BeneficiarioController;

$atributos = CoreController::get_instance()->get_atributos('beneficiario');
$beneficiario = BeneficiarioController::get_instance();
$asistencias = get_posts(['post_type' => 'asistencia', 'posts_per_page' => -1, 'post_parent' => get_the_id()]);
$comedores = get_posts(['post_type' => 'comedor', 'posts_per_page' => -1]);

?>
<!-- Captura de Beneficiarios Niños(as) -->
<div class="container">
   <div class="row">
      <div class="col-md-8">
         <h2 class="mb-3 text-center">Información del Niño(a)</h2>
         <form id="beneficiario_ninos" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="col d-flex justify-content-center align-items-center my-3">
               <div class="card">
                  <img id="imagennueva" src="<?php echo (get_the_post_thumbnail_url()) ? get_the_post_thumbnail_url() : $beneficiario->get_avatar(get_the_ID()) ?>" class="object-fit-cover rounded" alt="Imágen del beneficiario" style="width: 200px;">
                  <div class="card-img-overlay d-flex justify-content-center align-items-center">
                     <label class="display-1" for="beneficiario_imagen"><i class="fa-regular fa-file-image"></i></label>
                     <input type="file" name="beneficiario_imagen" id="beneficiario_imagen" multiple="false" hidden>
                  </div>
               </div>
            </div><!-- Foto beneficiario -->
            <div class="form-group row">
               <div class="col-md-4 mb-3">
                  <label class="form-label">Nombre</label>
                  <input type="text" name="nombre" placeholder="Nombre" class="form-control" required>
                  <div class="invalid-feedback">
                     Por favor indicar un nombre.
                  </div>
               </div>
               <div class="col-md-4 mb-3">
                  <label class="form-label">Primer Apellido</label>
                  <input type="text" name="p_apellido" placeholder="Primer Apellido" class="form-control" required>
                  <div class="invalid-feedback">
                     Por favor indicar un apellido.
                  </div>
               </div>
               <div class="col-md-4 mb-3">
                  <label class="form-label">Segundo Apellido</label>
                  <input type="text" name="s_apellido" placeholder="Segundo Apellido" class="form-control" required>
                  <div class="invalid-feedback">
                     Por favor indicar un apellido.
                  </div>
               </div>
            </div><!-- Nombre y apellidos -->
            <div class="form-group row">
               <div class="col-md-4 mb-3">
                  <div class="mb-3">Sexo</div>
                  <div class="form-check form-check-inline">
                     <input class="form-check-input" type="radio" name="sexo" id="masculino" value="1" checked>
                     <label class="form-check-label" for="masculino">Masculino</label>
                  </div>
                  <div class="form-check form-check-inline">
                     <input class="form-check-input" type="radio" name="sexo" id="femenino" value="2">
                     <label class="form-check-label" for="femenino">Femenino</label>
                  </div>
               </div>
               <input type="hidden" name="condicion" value="1">
               <div class="col-md mb-3">
                  <label class="form-label">Fecha Nacimiento</label>
                  <input id="f_nacimiento" type="date" name="f_nacimiento" placeholder="Fecha de Nacimiento" class="form-control" required>
                  <div class="invalid-feedback">
                     Por favor indicar la fecha de nacimiento.
                  </div>
               </div>
               <div class="col-md mb-3">
                  <label class="form-label">Fecha Ingreso</label>
                  <input type="date" name="f_ingreso" placeholder="Fecha de Ingreso" class="form-control" required>
                  <div class="invalid-feedback">
                     Por favor indicar la fecha de ingreso.
                  </div>
               </div>
               <div class="col-md mb-3">
                  <label class="form-label">Fecha Salida</label>
                  <input type="date" name="f_salida" placeholder="Fecha de Salida" class="form-control">
               </div>
            </div><!-- Sexo, fecha nacimiento, ingreso y salida -->
            <div class="form-group row">
               <div class="col-md-4 mb-3">
                  <label class="form-label">Edad</label>
                  <input type="text" placeholder="Edad (este dato se calcula)" class="form-control" id="edad" disabled>
                  <input id="edad_capturar" name="edad" type="hidden">
               </div>
               <div class="col-md-4 mb-3">
                  <label class="form-label">Peso (kg)</label>
                  <input type="text" name="peso" placeholder="Peso en kilos" class="form-control">
               </div>
               <div class="col-md-4 mb-3">
                  <label class="form-label">Estatura (m)</label>
                  <input type="text" name="estatura" placeholder="Estatura en metros" class="form-control">
               </div>
            </div><!-- Edad, peso y estatura -->
            <div class="form-group row">
               <div class="col-md-4 mb-3">
                  <label class="form-label">Provincia</label>
                  <select id="provincia" name="provincia" class="form-select" aria-label="Provincias">
                     <option selected>Seleccionar Provincia</option>
                     <?php foreach ($provincias as $provincia) : ?>
                        <option value="<?php echo $provincia['ID'] ?> "><?php echo $provincia['provincia'] ?></option>
                     <?php endforeach; ?>
                  </select>
               </div>
               <div class="col-md-4 mb-3">
                  <label class="form-label">Cantón</label>
                  <select id="canton" name="canton" class="form-select" aria-label="Cantones">
                     <option selected>Seleccionar Cantón</option>
                  </select>
                  <input id="nonce_canton" type="hidden" name="nonce_canton" value="<?php echo wp_create_nonce('cantones') ?>">
                  <input id="action_canton" type="hidden" name="action_canton" value="canton">
               </div>
               <div class="col-md-4 mb-3">
                  <label class="form-label">Distrito</label>
                  <select id="distrito" name="distrito" class="form-select" aria-label="Distritos">
                     <option selected>Seleccionar Distrito</option>
                  </select>
                  <input id="nonce_distrito" type="hidden" name="nonce_distrito" value="<?php echo wp_create_nonce('distritos') ?>">
                  <input id="action_distrito" type="hidden" name="action_distrito" value="distrito">
               </div>
            </div><!-- Provincia, Cantón y Distrito -->
            <div class="form-group mb-3">
               <label class="form-label">Detalle de dirección</label>
               <input name="direccion" class="form-control" placeholder="Espacio para detallar la dirección"></input>
            </div><!-- dirección detallada -->
            <div class="form-group row">
               <div class="col-md-4 mb-3">
                  <label class="form-label">e-mail</label>
                  <input type="email" name="email" placeholder="e-mail" class="form-control" required>
                  <div class="invalid-feedback">
                     Por favor indicar un correo válido.
                  </div>
               </div>
               <div class="col-md-4 mb-3">
                  <label class="form-label">Teléfono Principal</label>
                  <input type="text" name="t_principal" placeholder="Teléfono principal" class="form-control" required>
                  <div class="invalid-feedback">
                     Por favor indicar un teléfono móvil.
                  </div>
               </div>
               <div class="col-md-4 mb-3">
                  <label class="form-label">Otros Teléfonos</label>
                  <input type="text" name="t_otros" placeholder="Otros Teléfonos" class="form-control">
               </div>
            </div><!-- correo y teléfono -->
            <div class="form-group row">
               <div class="col-md-4 mb-3">
                  <label class="form-label">Nombre de la Madre o Tutor(a)</label>
                  <input type="text" name="n_madre" placeholder="Nombre de la madre o tutor(a)" class="form-control" required>
                  <div class="invalid-feedback">
                     Por favor indicar un nombre de la madre o tutor.
                  </div>
               </div>
               <div class="col-md-4 mb-3">
                  <label class="form-label">Nombre del Padre</label>
                  <input type="text" name="n_padre" placeholder="Nombre del padre" class="form-control" required>
                  <div class="invalid-feedback">
                     Por favor indicar un nombre del padre.
                  </div>
               </div>
               <div class="col-md-4 mb-3">
                  <label class="form-label">Comedor</label>
                  <select name="post_parent" class="form-select" aria-label="Comedores">
                     <option value="0" selected>Seleccionar Comedor</option>
                     <?php foreach ($comedores as $comedor) : ?>
                        <option value="<?php echo $comedor->ID ?> "><?php echo $comedor->post_title ?></option>
                     <?php endforeach; ?>
                  </select>
               </div>
            </div><!-- Madre, Tutor, Padre y Comedor-->
            <div class="form-group mb-3">
               <label for="content" class="form-label fs-4">Rerseña</label>
               <textarea name="content" cols="30" rows="5" class="form-control" placeholder="Reseña del beneficiario"></textarea>
            </div><!-- Reseña -->
            <div class="form-group mb-3">
               <button type="submit" class="btn btn-warning btn-sm mb-3 me-5"><span><i class="fa-solid fa-floppy-disk"></i></span> Guardar</button>
               <button id="btn_cancelar" type="btn" class="btn btn-sm btn-danger mb-3">Cancelar</button>
            </div><!-- Botones Guardar y Cancelar -->
            <input type="hidden" name="post_id" value="<?php the_ID() ?>">
            <input type="hidden" name="action" value="beneficiario_agregar">
            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('beneficiarios') ?>">
            <input id="endpoint" type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
         </form>
      </div>
      <div class="col-md-4">
         <?php get_template_part($atributos['sidebar'])
         ?>
      </div>
   </div>
</div>