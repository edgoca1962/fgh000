<?php

use EGC001\Modules\Core\CoreController;

/**
 * 
 * Plantilla para el Sidebar
 * 
 * @package:EGC001
 * 
 */

$atributos = CoreController::get_instance();

?>
<section class="my-5" <?php echo $atributos->get_atributo('ocultarVista') ?>>
   <div class="row mb-3">
      <div class="position-relative">
         <form id="frmbuscar" class="d-flex">
            <input id="impbuscar" class="form-control w-75 me-2" type="text" style="width: 0;" placeholder="buscar beneficiarios(as)" aria-label="Search">
         </form>
         <div id="resultados" class="container invisible position-absolute search-overlay rounded-3 w-75" style="height:300px;">
            <div class="d-flex justify-content-between">
               <h4>Beneficiarios(as)</h4><span id="btn_cerrar"><i class="far fa-times-circle"></i></span>
            </div>
            <div id="resultados_busqueda" data-url="<?php echo get_site_url() . '/wp-json/wp/v2/beneficiarios/?search=' ?>"></div>
         </div>
      </div>
   </div>
   <div class="row mb-3">
      <h4>Beneficiarios(as) por Comedor</h4>
      <?php foreach ($atributos->get_atributo('listado') as $item) : ?>
         <?php if ($item['nivel'] == 1) : ?>
            <a href="<?php echo $item['enlace'] ?>"><?php echo $item['descripcion'] ?></a>
         <?php else : ?>
            <li>
               <a href="<?php echo $item['enlace'] ?>"> <?php echo $item['descripcion'] ?></a>
            </li>
         <?php endif; ?>
      <?php endforeach; ?>
   </div>
   <div class="row mb-3">
      <h4>
         <a href="<?php echo get_post_type_archive_link('comedor') ?>">Listado de Comedores</a>
      </h4>
   </div>
   <div class="row mb-3">
      <h4>
         <a href="<?php echo site_url('/beneficiario-encargados') ?>">Listado de Encargados</a>
      </h4>
   </div>
   <div class="row mb-3">
      <h4>
         <a href="<?php echo site_url('/beneficiario-export-csv') ?>">Listado de Beneficiarios(as)</a>
      </h4>
   </div>
   <div class="row mb-3" <?php echo $atributos->get_atributo('ocultarMantenimiento') ?>>
      <h4>Mantenimiento</h4>
      <li><a href="<?php echo site_url('/menu-mantenimiento') ?>">Incluir Menú</a></li>
      <li><a href="<?php echo site_url('/beneficiario-incluir') ?>">Incluir Beneficiario(a)</a></li>
      <div <?php echo $atributos->get_atributo('ocultarElemento') ?>>
         <li><a href="<?php echo site_url('/comedor-mantenimiento') ?>">Incluir Comedor</a></li>
         <li><a href="<?php echo site_url('/beneficiario-usuario') ?>">Administrar Usuarios</a></li>
      </div>
   </div>
</section>