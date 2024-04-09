<?php

/**
 * 
 * Plantilla para Mapas
 * 
 * @package: EGC001
 */
?>
<h3>My Google Maps Demo</h3>
<!--The div element for the map -->
<div class="d-flex justify-content-center mt-5">
   <div id="datosmapa" class="col-6 mb-3">
      <label class="form-label mb-3" for="localizacion">Dirección:</label>
      <input class="form-control mb-3" type="text" name="localizacion" id="localizacion" placeholder="Ingresar dirección" value="" />
      <div class="bg-white rounded" id="mapa" style="height: 450px;"></div>
   </div>
</div>