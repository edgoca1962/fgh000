<?php

use EGC001\Modules\Core\CoreController;

/**
 * 
 * Plantilla comdedor single
 * 
 * @package:EGC001
 * 
 */

$atributos = CoreController::get_instance();


?>
<section id="comedor_single" <?php echo $atributos->get_atributo('ocultarVista') ?>>
   <form id="comedor">
      <div class="form-group mb-3" <?php echo $atributos->get_atributo('ocultarVista') ?>>
         <button id="btn_editar" type="button" class="btn btn-warning mb-3"><span><i class="fa-solid fa-pen-to-square"></i></span> Editar Datos</button>
      </div><!-- Boton Editar -->
      <div class="col d-flex justify-content-center">
         <img class="object-fit-cover rounded" src="<?php echo (get_the_post_thumbnail_url()) ? get_the_post_thumbnail_url() : EGC001_DIR_URI . '/assets/img/scccomedor.png' ?>" alt="Imágen del beneficiario" style="width:200px;">
      </div><!-- Foto Comedor -->
      <div class="form-group row">
         <div class="col-md mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" placeholder="Nombre" class="form-control border-0 bg-secondary text-white" value="<?php echo get_the_title() ?>" editar>
         </div>
      </div><!-- Nombre Comedor -->
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
         <input name="direccion" class="form-control border-0 bg-secondary text-white" placeholder="Espacio para detallar la dirección" value="<?php echo get_post_meta(get_the_ID(), '_direccion', true) ?>" editar></input>
      </div><!-- dirección detallada -->
      <div class="form-group row">
         <div class="col-md-4 mb-3">
            <label class="form-label">Teléfono Principal</label>
            <input type="text" name="telefono" placeholder="Teléfono principal" class="form-control border-0 bg-secondary text-white" value="<?php echo get_post_meta(get_the_ID(), '_telefono', true) ?>" editar>
         </div>
         <div class="col-md-4 mb-3">
            <label class="form-label">e-mail</label>
            <input type="text" name="email" placeholder="e-mail" class="form-control border-0 bg-secondary text-white" value="<?php echo get_post_meta(get_the_ID(), '_email', true) ?>" editar>
         </div>
         <div class="col-md-4 mb-3">
            <label class="form-label">Encargado(a)</label>
            <input type="text" name="encargado" placeholder="encargado" class="form-control border-0 bg-secondary text-white" value="<?php echo get_user_by('ID', get_post_meta(get_the_ID(), '_contacto_id', true))->display_name ?>" editar>
            <input type="hidden" name="contacto_id" value="<?php echo get_post_meta(get_the_ID(), '_contacto_id', true) ?>">
            <input type="hidden" name="nonce_encargado" value="<?php echo wp_create_nonce('encargados') ?>">
            <input type="hidden" name="action_encargado" value="scc_comedor_encargados">
         </div>
      </div><!-- teléfono y contacto -->
      <input type="hidden" name="post_id" value="<?php the_ID() ?>">
      <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
   </form>
   <div id="menues">
      <h4>Historial de Menues</h4>
      <hr>
      <div class="row mb-3">
         <div class="col">Fecha - Comedor</div>
         <div class="col">Descripción del Menú</div>
      </div>
      <hr>
      <?php if ($atributos->get_atributo['menues']) : ?>
         <?php foreach ($atributos->get_atributo['menues'] as $menu) : ?>
            <div class="d-flex align-items-center row">
               <div class="col-4">
                  <a href="<?php echo the_permalink($menu->ID) ?>"><?php echo get_post($menu->ID)->post_title ?></a>
               </div>
               <div class="col"><?php echo get_post($menu->ID)->post_content ?></div>
            </div>
         <?php endforeach; ?>
      <?php else : ?>
         <h5>No hay menues registrados para este comedor</h5>
      <?php endif; ?>
   </div><!-- Bitácora de Menues -->
   <hr>
</section>

<section id="comedor_single_editar" hidden>
   <form id="comedor" enctype="multipart/form-data" class="needs-validation" novalidate>
      <div class="col d-flex justify-content-center align-items-center my-3">
         <div style="width: 200px; overflow:hidden; ">
            <div class="card h-100">
               <img id="imagennueva" class="object-fit-cover rounded" src="<?php echo (get_the_post_thumbnail_url()) ? get_the_post_thumbnail_url() : EGC001_DIR_URI . '/assets/img/scccomedor.png' ?>" alt="Imágen del beneficiario" style="width:200px;">
               <div class="card-img-overlay d-flex justify-content-center align-items-center">
                  <label class="display-1" for="comedor_imagen"><i class="fa-regular fa-file-image"></i></label>
                  <input type="file" name="comedor_imagen" id="comedor_imagen" multiple="false" hidden>
               </div>
            </div>
         </div>
      </div><!-- Foto comedor -->
      <div class="form-group row">
         <div class="col-md mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input id="nombre" type="text" name="nombre" placeholder="Nombre" class="form-control" required>
            <div class="invalid-feedback">
               Por favor indicar un nombre.
            </div>
         </div>
      </div><!-- Nombre Comedor -->
      <div class="form-group row">
         <div class="col-md-4 mb-3">
            <label class="form-label">Provincia</label>
            <select id="provincia" name="provincia" class="form-select" aria-label="Provincias">
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
      <div class="form-group row">
         <div class="col-md-4 mb-3">
            <label class="form-label">Teléfono Principal</label>
            <input id="telefono" type="text" name="telefono" placeholder="Teléfono principal" class="form-control" required>
            <div class="invalid-feedback">
               Por favor indicar un teléfono móvil.
            </div>
         </div>
         <div class="col-md-4 mb-3">
            <label class="form-label">e-mail</label>
            <input id="email" type="text" name="email" placeholder="e-mail" class="form-control" required>
            <div class="invalid-feedback">
               Por favor indicar un correo válido.
            </div>
         </div>
         <div class="col-md-4 mb-3">
            <label class="form-label">Encargado(a)</label>
            <select name="contacto_id" id="contacto_id" class="form-select" aria-label="Encargados">
            </select>
            <input id="nonce_encargado" type="hidden" name="nonce_encargado" value="<?php echo wp_create_nonce('encargados') ?>">
            <input id="action_encargado" type="hidden" name="action_encargado" value="scc_comedor_encargados">
         </div>
      </div><!-- teléfono y contacto -->
      <div class="form-group mb-3">
         <button name="modificar" type="submit" class="btn btn-warning btn-sm mb-3 me-5"><span><i class="fa-solid fa-floppy-disk"></i></span> Guardar</button>
         <button name="eliminar" titulo="Eliminar Comedor" msg="Se eliminará el Comedor y todos los beneficiarios con su historial de asistencia." type="submit" class="btn btn-danger btn-sm mb-3 me-5"><span><i class="fa-solid fa-trash-can"></i></span> Eliminar</button>
         <button id="btn_cancelar" type="btn" class="btn btn-sm btn-danger mb-3">Cancelar</button>
      </div><!-- Botones Guardar y Cancelar -->
      <input type="hidden" name="post_id" value="<?php the_ID() ?>">
      <input type="hidden" name="action" value="comedor_editar">
      <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('comedores') ?>">
      <input id="endpoint" type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
   </form>
</section>