<div class="row mb-3">
   <div class="position-relative">
      <form id="frmbuscar" class="d-flex">
         <input id="impbuscar" class="form-control w-100 me-2" type="text" style="width: 0;" placeholder="Buscar Evento" aria-label="Search">
      </form>
      <div id="resultados" class="container invisible position-absolute search-overlay rounded-3 w-100" style="height:300px;">
         <div class="d-flex justify-content-between">
            <h5>Resultados</h5><span id="btn_cerrar"><i class="far fa-times-circle"></i></span>
         </div>
         <div id="resultados_busqueda" data-url="<?php echo get_site_url() . '/wp-json/wp/v2/eventos?search=' ?>" data-msg="No se encontraron Eventos"></div>
      </div>

   </div>
</div>
<div class="row">
   <div class="col">
      <select id="mesEvento" class="form-control" name="">
         <option value="January" <?php echo (fgh000_get_param(get_post_type())['mes'] === "January") ? 'selected' : '' ?>>Enero</option>
         <option value="February" <?php echo (fgh000_get_param(get_post_type())['mes'] === "February") ? 'selected' : '' ?>>Febrero</option>
         <option value="March" <?php echo (fgh000_get_param(get_post_type())['mes'] === "March") ? 'selected' : '' ?>>Marzo</option>
         <option value="April" <?php echo (fgh000_get_param(get_post_type())['mes'] === "April") ? 'selected' : '' ?>>Abril</option>
         <option value="May" <?php echo (fgh000_get_param(get_post_type())['mes'] === "May") ? 'selected' : '' ?>>Mayo</option>
         <option value="June" <?php echo (fgh000_get_param(get_post_type())['mes'] === "June") ? 'selected' : '' ?>>Junio</option>
         <option value="July" <?php echo (fgh000_get_param(get_post_type())['mes'] === "July") ? 'selected' : '' ?>>Julio</option>
         <option value="August" <?php echo (fgh000_get_param(get_post_type())['mes'] === "August") ? 'selected' : '' ?>>Agosto</option>
         <option value="September" <?php echo (fgh000_get_param(get_post_type())['mes'] === "September") ? 'selected' : '' ?>>Septiembre</option>
         <option value="October" <?php echo (fgh000_get_param(get_post_type())['mes'] === "October") ? 'selected' : '' ?>>Octubre</option>
         <option value="November" <?php echo (fgh000_get_param(get_post_type())['mes'] === "November") ? 'selected' : '' ?>>Noviembre</option>
         <option value="December" <?php echo (fgh000_get_param(get_post_type())['mes'] === "December") ? 'selected' : '' ?>>Diciembre</option>
      </select>
      <input type="hidden" id="url" value=<?php echo get_post_type_archive_link('evento') ?>>
      <script>
         document.getElementById('mesEvento').addEventListener('change', function() {
            window.location.href = document.getElementById('url').value + '?mes=' + document.getElementById('mesEvento').value
         })
      </script>
   </div>
</div>
<div class="row my-3">
   <div class="table-responsive">
      <table class="table table-dark">
         <thead>
            <tr>
               <th class="text-center" scope="col">L</th>
               <th class="text-center" scope="col">K</th>
               <th class="text-center" scope="col">M</th>
               <th class="text-center" scope="col">J</th>
               <th class="text-center" scope="col">V</th>
               <th class="text-center" scope="col">S</th>
               <th class="text-center" scope="col">D</th>
            </tr>
         </thead>
         <tbody">
            <?php for ($semana = 1; $semana < 8; $semana++) : ?>
               <?php if ($semana == 1) : ?>
                  <tr>
                     <?php if (fgh000_get_param(get_post_type())['espacios'] > 0) : ?>
                        <td colspan="<?php echo fgh000_get_param(get_post_type())['espacios'] ?>"></td>
                     <?php endif; ?>
                     <?php for ($dia = 1; $dia < fgh000_get_param(get_post_type())['restante']; $dia++) : ?>
                        <td class="text-center">
                           <a href=" <?php echo get_post_type_archive_link('evento') . '?fpe=' . date('Ymd', strtotime($dia . fgh000_get_param(get_post_type())['mes'] . date('Y'))) ?>">
                              <span class="<?php echo (date('Ymd') == date('Ymd', strtotime($dia . fgh000_get_param(get_post_type())['mes'] . date('Y')))) ? 'badge rounded-pill text-bg-danger' : '' ?>"><?php echo $dia ?></span>
                           </a>
                        </td>
                     <?php endfor; ?>
                  </tr>
               <?php else : ?>
                  <tr>
                     <?php for ($diasemana = 1; $diasemana < 8; $diasemana++) : ?>
                        <?php if ($dia < date('j', strtotime('last day of ' . fgh000_get_param(get_post_type())['mes']))) : ?>
                           <td class="text-center">
                              <a href=" <?php echo get_post_type_archive_link('evento') . '?fpe=' . date('Ymd', strtotime($dia . fgh000_get_param(get_post_type())['mes'] . date('Y'))) ?>">
                                 <span class="<?php echo (date('Ymd') == date('Ymd', strtotime($dia . fgh000_get_param(get_post_type())['mes'] . date('Y')))) ? 'badge rounded-pill text-bg-danger' : '' ?>"><?php echo $dia++ ?></span>
                              </a>
                           </td>
                        <?php else : ?>
                           <?php if ($dia == date('j', strtotime('last day of ' . fgh000_get_param(get_post_type())['mes']))) : ?>
                              <td class="text-center">
                                 <a href=" <?php echo get_post_type_archive_link('evento') . '?fpe=' . date('Ymd', strtotime($dia . fgh000_get_param(get_post_type())['mes'] . date('Y'))) ?>">
                                    <span class="<?php echo (date('Ymd') == date('Ymd', strtotime($dia . fgh000_get_param(get_post_type())['mes'] . date('Y')))) ? 'badge rounded-pill text-bg-danger' : '' ?>"><?php echo $dia++ ?></span>
                                 </a>
                              </td>
                              <?php if (7 - $diasemana > 0) :  ?>
                                 <td colspan="<?php echo 7 - $diasemana ?>"></td>
                              <?php endif; ?>
                           <?php endif; ?>
                        <?php endif; ?>
                     <?php endfor; ?>
                  </tr>
               <?php endif; ?>
            <?php endfor; ?>
            </tbody>
      </table>
   </div>
</div>