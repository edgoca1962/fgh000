<div class="row mb-3">
   <div class="form-check form-switch d-flex justify-content-center">
      <input class="form-check-input" type="checkbox" role="switch" id="opcion_anual" name="opcion_anual" checked data-opcion="on">
      <label class="form-check-label ms-2" for="opcion_anual">Cambio entre opciones de priodicidad anual</label>
   </div>
</div> <!-- Switch de opciones anuales -->
<div class="row">
   <div id="opcionanualuno" class="col">
      <div class="col-xl-6 mb-3">
         <div class="d-flex">
            <div class="col form-control border-0 bg-transparent text-white">Cada</div>
            <input type="number" class="form-control op1anual" id="npereventosanno1" name="npereventosanno1" min="1" max="100" value="1">
            <div class="col form-control border-0 bg-transparent text-white">años</div>
         </div>
      </div> <!-- Cantidad períodos -->
      <div class="col-xl-6 mb-3">
         <label for="numerodiaeventoanno" class="form-label">Número del Día</label>
         <input type="number" class="form-control op1anual" id="numerodiaeventoanno" name="numerodiaevento" min="1" max="31" value="1">
      </div> <!-- número día del mes -->
      <div class="col-xl-6 mb-3">
         <label for="mesop1" class="form-label">Mes del año</label>
         <select id="mesop1" name='mesop1' class="form-select op1anual" aria-label="Seleccionar frecuencia">
            <option value="1" selected>Enero</option>
            <option value="2">Febrero</option>
            <option value="3">Marzo</option>
            <option value="4">Abril</option>
            <option value="5">Mayo</option>
            <option value="6">Junio</option>
            <option value="7">Julio</option>
            <option value="8">Agosto</option>
            <option value="9">Septiembre</option>
            <option value="10">Octubre</option>
            <option value="11">Noviembre</option>
            <option value="12">Diciembre</option>
         </select>
      </div> <!-- mes del año -->
   </div> <!-- Primera opción anual -->
   <div id="opcionanualdos" class="col">
      <div class="col-xl-6 mb-3">
         <div class="d-flex">
            <div class="col form-control border-0 bg-transparent text-white">Cada</div>
            <input type="number" class="form-control op2anual bg-secondary" id="npereventosanno2" name="npereventosanno2" min="1" max="100" value="1" disabled>
            <div class="col form-control border-0 bg-transparent text-white">años</div>
         </div>
      </div> <!-- Cantidad períodos -->
      <div class="col-xl-6">
         <label class="form-label">Día ordinal</label>
         <select id="numerodiaordinaleventoanno" name='numerodiaordinaleventoanno' class="form-select op2anual bg-secondary" aria-label="Seleccionar frecuencia" disabled>
            <option value="1" selected>Primer</option>
            <option value="2">Segundo</option>
            <option value="3">Tercer</option>
            <option value="4">Cuarto</option>
            <option value="5">Último</option>
         </select>
      </div> <!-- día ordinal -->
      <div class="col my-3">
         <div><label class="form-label">Día de la semana</label></div>
         <div>
            <div class="form-check form-check-inline">
               <input class="diasemana form-check-input op2anual" type="checkbox" value="1" disabled>
               <label class="form-check-label">Lunes</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="diasemana form-check-input op2anual" type="checkbox" value="2" disabled>
               <label class="form-check-label">Martes</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="diasemana form-check-input op2anual" type="checkbox" value="3" disabled>
               <label class="form-check-label">Miércoles</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="diasemana form-check-input op2anual" type="checkbox" value="4" disabled>
               <label class="form-check-label">Jueves</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="diasemana form-check-input op2anual" type="checkbox" value="5" disabled>
               <label class="form-check-label">Viernes</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="diasemana form-check-input op2anual" type="checkbox" value="6" disabled>
               <label class="form-check-label">Sábado</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="diasemana form-check-input op2anual" type="checkbox" value="7" disabled>
               <label class="form-check-label">Domingo</label>
            </div>
         </div>
      </div> <!-- día de la semana -->
      <div class="col-xl-6">
         <label for="mesop2anno" class="form-label">Mes de año</label>
         <select id="mesop2anno" name='mesop2anno' class="form-select op2anual bg-secondary" aria-label="Seleccionar frecuencia" disabled>
            <option value="1" selected>Enero</option>
            <option value="2">Febrero</option>
            <option value="3">Marzo</option>
            <option value="4">Abril</option>
            <option value="5">Mayo</option>
            <option value="6">Junio</option>
            <option value="7">Julio</option>
            <option value="8">Agosto</option>
            <option value="9">Septiembre</option>
            <option value="10">Octubre</option>
            <option value="11">Noviembre</option>
            <option value="12">Diciembre</option>
         </select>
      </div> <!-- mes del año -->
   </div> <!-- Segunda opción anual -->
</div> <!-- Opciones anuales -->