   <div class="row mb-3">
      <div class="position-relative">
         <form id="frmbuscar" class="d-flex">
            <input id="impbuscar" class="form-control w-75 me-2" type="text" style="width: 0;" placeholder="buscar beneficiarios" aria-label="Search">
         </form>
         <div id="resultados" class="container invisible position-absolute search-overlay rounded-3 w-75" style="height:300px;">
            <div class="d-flex justify-content-between">
               <h4>Peticiones</h4><span id="btn_cerrar"><i class="far fa-times-circle"></i></span>
            </div>
            <div id="resultados_busqueda" data-url="<?php echo get_site_url() . '/wp-json/wp/v2/beneficiarios/?search=' ?>"></div>
         </div>
      </div>
   </div>