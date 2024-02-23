<?php

use FGHEGC\Modules\Core\CoreController;
use FGHEGC\Modules\Scc\Beneficiario\BeneficiarioController;

$atributos = CoreController::get_instance()->get_atributos(get_post_type());
$beneficiario = BeneficiarioController::get_instance();
$asistencias = get_posts(['post_type' => 'asistencia', 'posts_per_page' => -1, 'post_parent' => get_the_id()]);
$comedores = get_posts(['post_type' => 'comedor', 'posts_per_page' => -1]);

?>
<!-- Plantilla Single -->
<section id="seccion_beneficiario_single">
   <form id="asistenia_single" class="needs-validation">
      <div class="form-group mb-3">
         <div id="asistencia">
            <hr>
            <h3>Actualizar Asistencia: </h3>
            <div class="row row-cols-auto mb-3 aling-middle">
               <div class="col mb-3">
                  <input name="f_asistencia" type="date" class="form-control" value="<?php echo date('Y-m-d') ?>">
               </div>
               <div class="col mb-3">
                  <div class="form-check">
                     <input name="reflexion" class="form-check-input" type="checkbox" value="No" id="reflexion">
                     <label class="form-check-label" for="reflexion">
                        Reflexión
                     </label>
                  </div>
               </div>
               <div class="col mb-3">
                  <div class="form-check">
                     <input name="alimentacion" class="form-check-input" type="checkbox" value="No" id="alimentacion">
                     <label class="form-check-label" for="alimentacion">
                        Alimentación
                     </label>
                  </div>
               </div>
               <div class="col col-xl-2 mb-3">
                  <div class="input-group mb-3">
                     <input name="q_alimentacion" type="number" class="form-control" step="1" placeholder="Cantidad" value="1">
                     <span class="input-group-text">Q</span>
                  </div>
               </div>
               <div class="col mb-3">
                  <button id="btn_actualizar_asistencia" type="submit" class="btn btn-info  btn-sm mb-3"><span><i class="fa-solid fa-floppy-disk"></i></span> Actualizar</button>
               </div>
            </div>
            <hr>
         </div>
      </div>
      <input type="hidden" name="nombre" value="<?php echo get_post(get_the_ID())->post_title ?>">
      <input type="hidden" name="post_parent" value="<?php the_ID() ?>">
      <input type="hidden" name="action" value="agregar_asistencia">
      <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('asistencia') ?>">
      <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
   </form><!-- Actualizar Asistencia -->
   <form id="beneficiario_single">
      <div class="form-group mb-3">
         <button id="btn_editar_beneficiario" type="button" class="btn btn-warning mb-3" data-scc_post_id="<?php the_ID() ?>" data-action="beneficiario_editar" data-nonce="<?php echo wp_create_nonce('beneficiario_editar') ?>"><span><i class="fa-solid fa-pen-to-square"></i></span> Editar Datos</button>
      </div><!-- Boton Editar -->
      <div class="col d-flex justify-content-center">
         <img class="object-fit-cover rounded" src="<?php echo (get_the_post_thumbnail_url()) ? get_the_post_thumbnail_url() : $beneficiario->get_avatar(get_the_ID()) ?>" alt="Imágen del beneficiario" style="width:200px;">
      </div><!-- Foto beneficiario -->
      <div class="form-group row">
         <div class="col-md-4 mb-3">
            <label class="form-label">Nombre</label>
            <input name="nombre" type="text" class="form-control border-0 bg-secondary text-white" value="<?php echo get_post_meta(get_the_ID(), '_nombre', true) ?>" editar>
         </div>
         <div class="col-md-4 mb-3">
            <label class="form-label">Primer Apellido</label>
            <input name="p_apellido" type="text" class="form-control border-0 bg-secondary text-white" value="<?php echo get_post_meta(get_the_ID(), '_p_apellido', true) ?>" editar>
         </div>
         <div class="col-md-4 mb-3">
            <label class="form-label">Segundo Apellido</label>
            <input name="s_apellido" type="text" class="form-control border-0 bg-secondary text-white" value="<?php echo get_post_meta(get_the_ID(), '_s_apellido', true) ?>" editar>
         </div>
      </div><!-- Nombre y apellidos -->
      <div class="form-group row">
         <div class="col-md-4 mb-3">
            <div class="mb-3">Sexo</div>
            <div class="form-check form-check-inline">
               <input class="form-check-input" type="radio" name="sexo" value="1" <?php echo (get_post_meta(get_the_ID(), '_sexo', true) == 1) ? 'checked' : '' ?> editar>
               <label class="form-check-label" for="masculino">Masculino</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="form-check-input" type="radio" name="sexo" value="2" <?php echo (get_post_meta(get_the_ID(), '_sexo', true) == '2') ? 'checked' : '' ?> editar>
               <label class="form-check-label" for="femenino">Femenino</label>
            </div>
         </div>
         <div class="col-md mb-3">
            <label class="form-label">Fecha Nacimiento</label>
            <input id="f_nacimiento_editar" name="f_nacimiento" type="text" class="form-control border-0 bg-secondary text-white" value="<?php echo get_post_meta(get_the_ID(), '_f_nacimiento', true) ?>" editar>
         </div>
         <div class="col-md mb-3">
            <label class="form-label">Fecha Ingreso</label>
            <input name="f_ingreso" type="text" class="form-control border-0 bg-secondary text-white" value="<?php echo get_post_meta(get_the_ID(), '_f_ingreso', true) ?>" editar>
         </div>
         <div class="col-md mb-3">
            <label class="form-label">Fecha Salida</label>
            <input name="f_salida" type="text" class="form-control border-0 bg-secondary text-white" value="<?php echo get_post_meta(get_the_ID(), '_f_salida', true) ?>" editar>
         </div>
      </div><!-- Sexo, fecha nacimiento, ingreso y salida -->
      <div class="form-group row">
         <div class="col-md-6 mb-3">
            <div class="mb-3">Condición</div>
            <div class="form-check form-check-inline">
               <input class="form-check-input" type="radio" name="condicion" value="2" <?php echo (get_post_meta(get_the_ID(), '_condicion', true) == '2') ? 'checked' : '' ?> editar>
               <label class="form-check-label" for="adlutomayor">Aldulto(a) Mayor</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="form-check-input" type="radio" name="condicion" value="3" <?php echo (get_post_meta(get_the_ID(), '_condicion', true) == '3') ? 'checked' : '' ?> editar>
               <label class="form-check-label" for="embarazada">Embarazada</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="form-check-input" type="radio" name="condicion" value="4" <?php echo (get_post_meta(get_the_ID(), '_condicion', true) == '4') ? 'checked' : '' ?> editar>
               <label class="form-check-label" for="lactancia">En Lactancia</label>
            </div>
         </div>
         <div class="col-md-2 mb-3">
            <label class="form-label">Edad</label>
            <input id="editar_edad" name="edad" type="text" class="form-control border-0 bg-secondary text-white" editar>
         </div>
      </div><!-- Condición y Edad -->
      <div class="form-group row">
         <div class="col-md-4 mb-3">
            <label class="form-label">Provincia</label>
            <input name="provincia" type="text" class="form-control border-0 bg-secondary text-white" value="<?php echo $beneficiario->get_provincias(get_post_meta(get_the_ID(), '_provincia_id', true)) ?>" editar>
            <input type="hidden" name="provincia_id" value="<?php echo get_post_meta(get_the_ID(), '_provincia_id', true) ?>">
            <input id="nonce_provincia_single" type="hidden" name="nonce_provincia" value="<?php echo wp_create_nonce('provincias') ?>">
            <input id="action_provincia_single" type="hidden" name="action_provincia" value="provincia">
         </div>
         <div class="col-md-4 mb-3">
            <label class="form-label">Cantón</label>
            <input name="canton" type="text" class="form-control border-0 bg-secondary text-white" value="<?php echo $beneficiario->get_cantones(get_post_meta(get_the_ID(), '_canton_id', true)) ?>" editar>
            <input type="hidden" name="canton_id" value="<?php echo get_post_meta(get_the_ID(), '_canton_id', true) ?>">
            <input id="nonce_canton_single" type="hidden" name="nonce_canton" value="<?php echo wp_create_nonce('cantones') ?>">
            <input id="action_canton_single" type="hidden" name="action_canton" value="canton">
         </div>
         <div class="col-md-4 mb-3">
            <label class="form-label">Distrito</label>
            <input name="distrito" type="text" class="form-control border-0 bg-secondary text-white" value="<?php echo $beneficiario->get_distritos(get_post_meta(get_the_ID(), '_distrito_id', true)) ?>" editar>
            <input type="hidden" name="distrito_id" value="<?php echo get_post_meta(get_the_ID(), '_distrito_id', true) ?>">
            <input id="nonce_distrito_single" type="hidden" name="nonce_distrito" value="<?php echo wp_create_nonce('distritos') ?>">
            <input id="action_distrito_single" type="hidden" name="action_distrito" value="distrito">
         </div>
      </div><!-- Provincia, Cantón y Distrito -->
      <div class="form-group mb-3">
         <label class="form-label">Detalle de dirección</label>
         <input name="direccion" type="text" class="form-control border-0 bg-secondary text-white" value="<?php echo get_post_meta(get_the_ID(), '_direccion', true) ?>" editar>
      </div><!-- dirección detallada -->
      <div class="form-group row">
         <div class="col-md-4 mb-3">
            <label class="form-label">Teléfono Principal</label>
            <input name="t_principal" type="text" class="form-control border-0 bg-secondary text-white" value="<?php echo get_post_meta(get_the_ID(), '_t_principal', true) ?>" editar>
         </div>
         <div class="col-md-4 mb-3">
            <label class="form-label">Otros Teléfonos</label>
            <input name="t_otros" type="text" class="form-control border-0 bg-secondary text-white" value="<?php echo get_post_meta(get_the_ID(), '_t_otros', true) ?>" editar>
         </div>
         <div class="col-md-4 mb-3">
            <label class="form-label">Comedor</label>
            <input name="comedor" type="text" class="form-control border-0 bg-secondary text-white" value="<?php echo (wp_get_post_parent_id(get_the_ID())) ? get_post(wp_get_post_parent_id(get_the_ID()))->post_title : 'Sin asignar' ?>" editar>
            <input type="hidden" name="post_parent" value="<?php echo wp_get_post_parent_id(get_the_ID()) ?>">
            <input id="nonce_comedor" type="hidden" name="nonce_comedor" value="<?php echo wp_create_nonce('comedores') ?>">
            <input id="action_comedor" type="hidden" name="action_comedor" value="comedores">
         </div>
      </div><!-- teléfonos y Comedor -->
      <div class="form-group mb-3">
         <label class="form-label fs-4">Reseña</label>
         <textarea id="content_single" name="content" cols="30" rows="10" class="form-control border-0 bg-secondary text-white" placeholder="Reseña del beneficiario" editar><?php echo get_the_content() ?></textarea>
      </div><!-- Reseña -->
   </form>
   <div id="asistencia">
      <h4>Bitácora de Asistencia</h4>
      <hr>
      <div class="row mb-3">
         <div class="col">fecha</div>
         <div class="col">Reflexion</div>
         <div class="col">Alimentación</div>
         <div class="col">Cantidad</div>
      </div>
      <hr>
      <?php if ($asistencias) : ?>
         <?php foreach ($asistencias as $asistencia) : ?>
            <div class="row">
               <div class="col"><?php echo date('Y-m-d', strtotime($asistencia->post_date)) ?></div>
               <div class="col"><?php echo get_post_meta($asistencia->ID, '_reflexion', true) ?></div>
               <div class="col"><?php echo get_post_meta($asistencia->ID, '_alimentacion', true) ?></div>
               <div class="col"><?php echo get_post_meta($asistencia->ID, '_q_alimentacion', true) ?></div>
            </div>
         <?php endforeach; ?>
      <?php else : ?>
         <h5>No hay una bitácora de asistencia registrada</h5>
      <?php endif; ?>
   </div><!-- Bitácora de Asistencia -->
   <hr>
</section>
<section id="seccion_beneficiario_single_editar" hidden>
   <h2 class="mb-3 text-center">Información del Adulto(a)</h2>
   <form id="beneficiario_single_editar" enctype="multipart/form-data" class="needs-validation" novalidate>
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
            <label for="nombre" class="form-label">Nombre</label>
            <input id="nombre" type="text" name="nombre" placeholder="Nombre" class="form-control" required>
            <div class="invalid-feedback">
               Por favor indicar un nombre.
            </div>
         </div>
         <div class="col-md-4 mb-3">
            <label for="p_apellido" class="form-label">Primer Apellido</label>
            <input id="p_apellido" type="text" name="p_apellido" placeholder="Primer Apellido" class="form-control" required>
            <div class="invalid-feedback">
               Por favor indicar un apellido.
            </div>
         </div>
         <div class="col-md-4 mb-3">
            <label for="s_apellido" class="form-label">Segundo Apellido</label>
            <input id="s_apellido" type="text" name="s_apellido" placeholder="Segundo Apellido" class="form-control" required>
            <div class="invalid-feedback">
               Por favor indicar un apellido.
            </div>
         </div>
      </div><!-- Nombre y apellidos -->
      <div class="form-group row">
         <div class="col-md-4 mb-3">
            <div class="mb-3">Sexo</div>
            <div class="form-check form-check-inline">
               <input class="form-check-input" type="radio" name="sexo" id="masculino" value="1">
               <label class="form-check-label" for="masculino">Masculino</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="form-check-input" type="radio" name="sexo" id="femenino" value="2">
               <label class="form-check-label" for="femenino">Femenino</label>
            </div>
         </div>
         <div class="col-md mb-3">
            <label class="form-label">Fecha Nacimiento</label>
            <input id="f_nacimiento" type="date" name="f_nacimiento" placeholder="Fecha de Nacimiento" class="form-control" required>
            <div class="invalid-feedback">
               Por favor indicar la fecha de nacimiento.
            </div>
         </div>
         <div class="col-md mb-3">
            <label class="form-label">Fecha Ingreso</label>
            <input id="f_ingreso" type="date" name="f_ingreso" placeholder="Fecha de Ingreso" class="form-control" required>
            <div class="invalid-feedback">
               Por favor indicar la fecha de ingreso.
            </div>
         </div>
         <div class="col-md mb-3">
            <label class="form-label">Fecha Salida</label>
            <input id="f_salida" type="date" name="f_salida" placeholder="Fecha de Salida" class="form-control">
         </div>
      </div><!-- Sexo, fecha nacimiento, ingreso y salida -->
      <div class="form-group row">
         <div class="col-md-6 mb-3">
            <div class="mb-3">Condición</div>
            <div class="form-check form-check-inline">
               <input class="form-check-input" type="radio" name="condicion" id="adultomayor" value="2">
               <label class="form-check-label" for="masculino">Aldulto(a) Mayor</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="form-check-input" type="radio" name="condicion" id="embarazada" value="3">
               <label class="form-check-label" for="femenino">Embarazada</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="form-check-input" type="radio" name="condicion" id="lactancia" value="4">
               <label class="form-check-label" for="femenino">En Lactancia</label>
            </div>
         </div>
         <div class="col-md-4 mb-3">
            <label class="form-label">Edad</label>
            <input id="edad" type="text" placeholder="Edad (este dato se calcula)" class="form-control" disabled>
            <input id="edad_capturar" name="edad" type="hidden">
         </div>
      </div><!-- Condición y Edad -->
      <input type="hidden" name="peso" value="0">
      <input type="hidden" name="estatura" value="0">
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
         <input id="direccion" name="direccion" class="form-control" placeholder="Espacio para detallar la dirección"></input>
      </div><!-- dirección detallada -->
      <input type="hidden" name="email" value="no aplica">
      <div class="form-group row">
         <div class="col-md-4 mb-3">
            <label class="form-label">Teléfono Principal</label>
            <input id="t_principal" type="text" name="t_principal" placeholder="Teléfono principal" class="form-control" required>
            <div class="invalid-feedback">
               Por favor indicar un teléfono móvil.
            </div>
         </div>
         <div class="col-md-4 mb-3">
            <label class="form-label">Otros Teléfonos</label>
            <input id="t_otros" type="text" name="t_otros" placeholder="Otros Teléfonos" class="form-control">
         </div>
         <div class="col-md-4 mb-3">
            <label class="form-label">Comedor</label>
            <select id="comedor" name="post_parent" class="form-select" aria-label="Comedores"></select>
         </div>
      </div><!-- teléfonos y Comedor -->
      <input type="hidden" name="n_padre" value="no aplica">
      <input type="hidden" name="n_madre" value="no aplica">
      <div class="form-group mb-3">
         <label for="content" class="form-label fs-4">Rerseña</label>
         <textarea id="content" name="content" cols="30" rows="5" class="form-control" placeholder="Reseña del beneficiario"></textarea>
      </div><!-- Reseña -->
      <div class="form-group mb-3">
         <button type="submit" class="btn btn-warning btn-sm mb-3 me-5"><span><i class="fa-solid fa-floppy-disk"></i></span> Guardar</button>
         <button id="btn_cancelar" type="btn" class="btn btn-sm btn-danger mb-3">Cancelar</button>
      </div><!-- Botones Guardar y Cancelar -->
      <input type="hidden" name="post_id" value="<?php the_ID() ?>">
      <input type="hidden" name="action" value="beneficiario_editar">
      <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('beneficiarios') ?>">
      <input id="endpoint" type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
   </form>
</section>