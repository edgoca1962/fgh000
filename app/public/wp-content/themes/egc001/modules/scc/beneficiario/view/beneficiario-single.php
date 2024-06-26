<?php

use EGC001\Modules\Core\CoreController;

/**
 * 
 * Plantilla para la información Single
 * 
 * @package:EGC001
 * 
 */

$atributos = CoreController::get_instance()

?>
<!-- Plantilla Single -->
<section id="seccion_beneficiario_single" <?php echo $atributos->get_atributo('ocultarVista') ?>>
   <form id="asistenia_single" class="needs-validation" <?php echo $atributos->get_atributo('ocultarMantenimiento') ?>>
      <div class="form-group mb-3">
         <div id="asistencia">
            <hr>
            <h3>Actualizar Asistencia: </h3>
            <div class="form-group row mb-3">
               <div class="col mb-3">
                  <input name="f_asistencia" type="date" class="form-control" value="<?php echo date('Y-m-d') ?>">
               </div>
               <div class="col mb-3">
                  <div class="form-check">
                     <input name="reflexion" class="form-check-input" type="checkbox" value="No" id="reflexion" checked>
                     <label class="form-check-label" for="reflexion">
                        Reflexión
                     </label>
                  </div>
               </div>
               <div class="col-4 col-xl-2 mb-3">
                  <div class="input-group mb-3">
                     <span class="input-group-text">Alim.</span>
                     <input type="number" class="form-control" step="1" name="q_alimentacion" placeholder="Cantidad" value="1" required>
                  </div>
               </div>
               <div class="col" <?php echo $atributos->get_atributo('ocultarBoton') ?>>
                  <button type="submit" class="btn btn-info btn-sm mb-3" data-b_id="<?php the_ID() ?>"><span><i class="fa-solid fa-floppy-disk"></i></span> Actualizar</button>
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
      <div class="form-group mb-3" <?php echo $atributos->get_atributo('ocultarBoton') ?>>
         <button id="btn_editar_beneficiario" type="button" class="btn btn-warning mb-3" data-scc_post_id="<?php the_ID() ?>" data-action="beneficiario_editar" data-nonce="<?php echo wp_create_nonce('beneficiario_editar') ?>"><span><i class="fa-solid fa-pen-to-square"></i></span> Editar Datos</button>
      </div><!-- Boton Editar -->
      <div class="col d-flex justify-content-center">
         <img class="object-fit-cover rounded" src="<?php echo (get_the_post_thumbnail_url()) ? get_the_post_thumbnail_url() : $atributos->get_atributo('avatar') ?>" alt="Imágen del beneficiario" style="width:200px;">
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
         </div><!-- Sexo -->
         <div class="col mb-3">
            <div class="mb-3">Condición</div>
            <div class="form-check form-check-inline">
               <input class="form-check-input" type="radio" name="condicion" value="1" <?php echo (get_post_meta(get_the_ID(), '_condicion', true) == 1) ? 'checked' : '' ?> editar>
               <label class="form-check-label" for="nino">Niño(a)</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="form-check-input" type="radio" name="condicion" value="2" <?php echo (get_post_meta(get_the_ID(), '_condicion', true) == 2) ? 'checked' : '' ?> editar>
               <label class="form-check-label" for="adultomayor">Aldulto(a) Mayor</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="form-check-input" type="radio" name="condicion" value="3" <?php echo (get_post_meta(get_the_ID(), '_condicion', true) == 3) ? 'checked' : '' ?> editar>
               <label class="form-check-label" for="embarazada">Embarazada</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="form-check-input" type="radio" name="condicion" value="4" <?php echo (get_post_meta(get_the_ID(), '_condicion', true) == 4) ? 'checked' : '' ?> editar>
               <label class="form-check-label" for="lactancia">En Lactancia</label>
            </div>
         </div><!-- Condición -->
      </div><!-- Sexo y Condición -->
      <div class="form-group row">
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
      </div><!-- Fecha nacimiento, ingreso y salida -->
      <input type="hidden" name="condicion" value="1">
      <div class="form-group row">
         <div class="col-md-4 mb-3">
            <label class="form-label">Edad</label>
            <input id="editar_edad" name="edad" type="text" class="form-control border-0 bg-secondary text-white" editar>
         </div>
         <div class="col-md-4 mb-3">
            <label class="form-label">Peso (kg)</label>
            <input name="peso" type="text" class="form-control border-0 bg-secondary text-white" value="<?php echo get_post_meta(get_the_ID(), '_peso', true) ?>" editar>
         </div>
         <div class="col-md-4 mb-3">
            <label class="form-label">Estatura (m)</label>
            <input name="estatura" type="text" class="form-control border-0 bg-secondary text-white" value="<?php echo get_post_meta(get_the_ID(), '_estatura', true) ?>" editar>
         </div>
      </div><!-- Edad, peso y estatura -->
      <div class="form-group row">
         <div class="col-md-4 mb-3">
            <label class="form-label">Provincia</label>
            <input name="provincia" type="text" class="form-control border-0 bg-secondary text-white" value="<?php echo $atributos->get_atributo('provincia') ?>" editar>
            <input type="hidden" name="provincia_id" value="<?php echo get_post_meta(get_the_ID(), '_provincia_id', true) ?>">
            <input id="nonce_provincia_single" type="hidden" name="nonce_provincia" value="<?php echo wp_create_nonce('provincias') ?>">
            <input id="action_provincia_single" type="hidden" name="action_provincia" value="provincia">
         </div>
         <div class="col-md-4 mb-3">
            <label class="form-label">Cantón</label>
            <input name="canton" type="text" class="form-control border-0 bg-secondary text-white" value="<?php echo $atributos->get_atributo('canton') ?>" editar>
            <input type="hidden" name="canton_id" value="<?php echo get_post_meta(get_the_ID(), '_canton_id', true) ?>">
            <input id="nonce_canton_single" type="hidden" name="nonce_canton" value="<?php echo wp_create_nonce('cantones') ?>">
            <input id="action_canton_single" type="hidden" name="action_canton" value="canton">
         </div>
         <div class="col-md-4 mb-3">
            <label class="form-label">Distrito</label>
            <input name="distrito" type="text" class="form-control border-0 bg-secondary text-white" value="<?php echo $atributos->get_atributo('distrito') ?>" editar>
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
            <label class="form-label">e-mail</label>
            <input name="email" type="text" class="form-control border-0 bg-secondary text-white" value="<?php echo get_post_meta(get_the_ID(), '_email', true) ?>" editar>
         </div>
         <div class="col-md-4 mb-3">
            <label class="form-label">Teléfono Principal</label>
            <input name="t_principal" type="text" class="form-control border-0 bg-secondary text-white" value="<?php echo get_post_meta(get_the_ID(), '_t_principal', true) ?>" editar>
         </div>
         <div class="col-md-4 mb-3">
            <label class="form-label">Otros Teléfonos</label>
            <input name="t_otros" type="text" class="form-control border-0 bg-secondary text-white" value="<?php echo get_post_meta(get_the_ID(), '_t_otros', true) ?>" editar>
         </div>
      </div><!-- correo y teléfono -->
      <div class="form-group row">
         <div class="col-md-4 mb-3">
            <label class="form-label">Nombre de la Madre o Tutor(a)</label>
            <input name="n_madre" type="text" class="form-control border-0 bg-secondary text-white" value="<?php echo get_post_meta(get_the_ID(), '_n_madre', true) ?>" editar>
         </div>
         <div class="col-md-4 mb-3">
            <label class="form-label">Nombre del Padre</label>
            <input name="n_padre" type="text" class="form-control border-0 bg-secondary text-white" value="<?php echo get_post_meta(get_the_ID(), '_n_padre', true) ?>" editar>
         </div>
         <div class="col-md-4 mb-3">
            <label class="form-label">Comedor</label>
            <input name="comedor" type="text" class="form-control border-0 bg-secondary text-white" value="<?php echo (wp_get_post_parent_id(get_the_ID())) ? get_post(wp_get_post_parent_id(get_the_ID()))->post_title : 'Sin asignar' ?>" editar>
            <input type="hidden" name="post_parent" value="<?php echo wp_get_post_parent_id(get_the_ID()) ?>">
            <input id="nonce_comedor" type="hidden" name="nonce_comedor" value="<?php echo wp_create_nonce('comedores') ?>">
            <input id="action_comedor" type="hidden" name="action_comedor" value="comedores">
         </div>
      </div><!-- Madre, Tutor, Padre y Comedor -->
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
      </div>
      <hr>
      <?php if ($atributos->get_atributo('asistencias')) : ?>
         <?php foreach ($atributos->get_atributo('asistencias') as $asistencia) : ?>
            <div class="row">
               <div class="col"><?php echo date('Y-m-d', strtotime($asistencia->post_date)) ?></div>
               <div class="col"><?php echo get_post_meta($asistencia->ID, '_reflexion', true) ?></div>
               <div class="col"><?php echo get_post_meta($asistencia->ID, '_q_alimentacion', true) ?></div>
            </div>
         <?php endforeach; ?>
      <?php else : ?>
         <h5>No hay una bitácora de asistencia registrada</h5>
      <?php endif; ?>
   </div><!-- Bitácora de Asistencia -->
   <hr>
</section>
<!-- Formulario Single de edición -->
<section id="seccion_beneficiario_single_editar" hidden>
   <form id="beneficiario_single_editar" enctype="multipart/form-data" class="needs-validation" novalidate>
      <div class="col d-flex justify-content-center align-items-center my-3">
         <div class="card">
            <img id="imagennueva" src="<?php echo (get_the_post_thumbnail_url()) ? get_the_post_thumbnail_url() : $atributos->get_atributo('avatar') ?>" class="object-fit-cover rounded" alt="Imágen del beneficiario" style="width: 200px;">
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
               <input class="form-check-input" type="radio" name="sexo" id="masculino" value="1" checked>
               <label class="form-check-label" for="masculino">Masculino</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="form-check-input" type="radio" name="sexo" id="femenino" value="2">
               <label class="form-check-label" for="femenino">Femenino</label>
            </div>
         </div><!-- Sexo -->
         <div class="col mb-3">
            <div class="mb-3">Condición</div>
            <div class="form-check form-check-inline">
               <input class="form-check-input" type="radio" name="condicion" id="nino" value="1">
               <label class="form-check-label" for="nino">Niño(a)</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="form-check-input" type="radio" name="condicion" id="adultomayor" value="2">
               <label class="form-check-label" for="adultomayor">Aldulto(a) Mayor</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="form-check-input" type="radio" name="condicion" id="embarazada" value="3">
               <label class="form-check-label" for="embarazada">Embarazada</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="form-check-input" type="radio" name="condicion" id="lactancia" value="4">
               <label class="form-check-label" for="lactancia">En Lactancia</label>
            </div>
         </div><!-- Condición -->
      </div><!-- Sexo y Condición -->
      <div class="form-group row">
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
      </div><!-- Fecha nacimiento, ingreso y salida -->
      <div class="form-group row">
         <div class="col-md-4 mb-3">
            <label class="form-label">Edad</label>
            <input id="edad" type="text" placeholder="Edad (este dato se calcula)" class="form-control" disabled>
            <input id="edad_capturar" name="edad" type="hidden">
         </div>
         <div class="col-md-4 mb-3">
            <label class="form-label">Peso (kg)</label>
            <input id="peso" type="text" name="peso" placeholder="Peso en kilos" class="form-control">
         </div>
         <div class="col-md-4 mb-3">
            <label class="form-label">Estatura (m)</label>
            <input id="estatura" type="text" name="estatura" placeholder="Estatura en metros" class="form-control">
         </div>
      </div><!-- Edad, peso y estatura -->
      <div class="form-group row">
         <div class="col-md-4 mb-3">
            <label class="form-label">Provincia</label>
            <select id="provincia" name="provincia" class="form-select" aria-label="Provincias">
            </select>
         </div>
         <div class="col-md-4 mb-3">
            <label class="form-label">Cantón</label>
            <select id="canton" name="canton" class="form-select" aria-label="Cantones">
            </select>
            <input id="nonce_canton" type="hidden" name="nonce_canton" value="<?php echo wp_create_nonce('cantones') ?>">
            <input id="action_canton" type="hidden" name="action_canton" value="canton">
         </div>
         <div class="col-md-4 mb-3">
            <label class="form-label">Distrito</label>
            <select id="distrito" name="distrito" class="form-select" aria-label="Distritos">
            </select>
            <input id="nonce_distrito" type="hidden" name="nonce_distrito" value="<?php echo wp_create_nonce('distritos') ?>">
            <input id="action_distrito" type="hidden" name="action_distrito" value="distrito">
         </div>
      </div><!-- Provincia, Cantón y Distrito -->
      <div class="form-group mb-3">
         <label class="form-label">Detalle de dirección</label>
         <input id="direccion" name="direccion" class="form-control" placeholder="Espacio para detallar la dirección"></input>
      </div><!-- dirección detallada -->
      <div class="form-group row">
         <div class="col-md-4 mb-3">
            <label class="form-label">e-mail</label>
            <input id="email" type="text" name="email" placeholder="e-mail" class="form-control" required>
            <div class="invalid-feedback">
               Por favor indicar un correo válido.
            </div>
         </div>
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
      </div><!-- correo y teléfono -->
      <div class="form-group row">
         <div class="col-md-4 mb-3">
            <label class="form-label">Nombre de la Madre o Tutor(a)</label>
            <input id="n_madre" type="text" name="n_madre" placeholder="Nombre de la madre o tutor(a)" class="form-control" required>
            <div class="invalid-feedback">
               Por favor indicar un nombre de la madre o tutor.
            </div>
         </div>
         <div class="col-md-4 mb-3">
            <label class="form-label">Nombre del Padre</label>
            <input id="n_padre" type="text" name="n_padre" placeholder="Nombre del padre" class="form-control" required>
            <div class="invalid-feedback">
               Por favor indicar un nombre del padre.
            </div>
         </div>
         <div class="col-md-4 mb-3">
            <label class="form-label">Comedor</label>
            <select id="comedor" name="post_parent" class="form-select" aria-label="Comedores"></select>
         </div>
      </div><!-- Madre, Tutor, Padre y Comedor -->
      <div class=" form-group mb-3">
         <label for="content" class="form-label fs-4">Reseña</label>
         <textarea id="content" name="content" cols="30" rows="5" class="form-control" placeholder="Reseña del beneficiario"></textarea>
      </div><!-- Reseña -->
      <div class="form-group mb-3">
         <button name="modificar" type="submit" class="btn btn-warning btn-sm mb-3 me-5"><span><i class="fa-solid fa-floppy-disk"></i></span> Guardar</button>
         <button name="eliminar" titulo="Eliminar Beneficiario" msg="Se eliminará el beneficiario y todo su historial de asistencia." type="submit" class="btn btn-danger btn-sm mb-3 me-5" <?php echo $atributos->get_atributo('ocultarElemento') ?>><span><i class="fa-solid fa-trash-can" <?php echo $atributos->get_atributo('ocultarElemento') ?>></i></span> Eliminar</button>
         <button id="btn_cancelar" type="btn" class="btn btn-sm btn-secondary mb-3">Cancelar</button>
      </div><!-- Botones Guardar y Cancelar -->
      <input type="hidden" name="post_id" value="<?php the_ID() ?>">
      <input type="hidden" name="action" value="beneficiario_editar">
      <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('beneficiarios') ?>">
      <input id="endpoint" type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
      <hr>
   </form>
</section>