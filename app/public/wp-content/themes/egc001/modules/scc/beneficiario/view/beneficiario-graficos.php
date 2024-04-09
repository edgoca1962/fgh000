<?php

use EGC001\Modules\Core\CoreController;

/**
 * 
 * Plantilla para Información Gráfica
 * 
 * @package:EGC001
 * 
 */

$atributos = CoreController::get_instance();

?>
<div id="beneficiario_graficos" <?php echo $atributos->get_atributo('ocultarVista') ?>>
   <div class="form-group row mb-3">
      <div class="col col-md-4">
         <select id="mes" class="form-select mb-3">
            <?php foreach ($atributos->get_atributo('datosGraficos')['mesesEspanol'] as $numero => $nombre) : ?>
               <option value="<?php echo $numero ?>" <?php echo ($atributos->get_atributo('mesSel') == $numero) ? 'selected' : '' ?>><?php echo $nombre ?></option>
            <?php endforeach; ?>
         </select>
      </div>
      <div class="col col-md-4">
         <select id="anno" class="col-3 form-select mb-3">
            <?php for ($i = 2023; $i < 2035; $i++) : ?>
               <option value="<?php echo $i ?>" <?php echo ($atributos->get_atributo('annoSel') == $i) ? 'selected' : '' ?>><?php echo $i ?></option>
            <?php endfor; ?>
         </select>
      </div>
   </div>
   <h3 id="sin_informacion" <?php echo ($atributos->get_atributo('datosGraficos')['cantidad']) ? 'hidden' : '' ?>>No hay información para ese mes y año</h3>
   <section <?php echo ($atributos->get_atributo('datosGraficos')['cantidad']) ? '' : 'hidden' ?>>
      <div class="row mb-5">
         <canvas class="bg-white rounded" id="myChart"></canvas>
         <input id="GraGenLabels" type="hidden" value='<?php echo json_encode($atributos->get_atributo('datosGraficos')['labels']) ?>'>
         <input id="GraGenAsistencia" type="hidden" value='<?php echo json_encode($atributos->get_atributo('datosGraficos')['asistencia']) ?>'>
         <input id="GraGenAusencia" type="hidden" value='<?php echo json_encode($atributos->get_atributo('datosGraficos')['ausencia']) ?>'>
         <input id="GraGenCantidad" type="hidden" value='<?php echo json_encode($atributos->get_atributo('datosGraficos')['cantidad']) ?>'>
      </div>
      <div class="row row-cols-1 row-cols-md-2 g-4 mb-5">
         <?php $i = 0;
         foreach ($atributos->get_atributo('datosGraficos')['donas'] as $comedor) : ?>
            <div>
               <h3><?php echo $comedor['titulo'] ?></h3>
               <canvas class="bg-white rounded" id="grafico_<?php echo $i ?>"></canvas>
               <input id="titulo_<?php echo $i ?>" type="hidden" value='<?php echo $comedor['titulo'] ?>'>
               <input id="datos_<?php echo $i ?>" type="hidden" value='<?php echo json_encode($comedor['datos']) ?>'>
            </div>
         <?php $i++;
         endforeach; ?>
         <input type="hidden" id="totalComedores" value="<?php echo count($atributos->get_atributo('datosGraficos')['donas']) ?>">
      </div>
   </section>
   <input type="hidden" id="url" value=<?php echo site_url('/beneficiario-graficos') ?>>
   <input id="action" type="hidden" name="action" value="beneficiario_graficos">
   <input id="nonce" type="hidden" name="nonce" value="<?php echo wp_create_nonce('graficos') ?>">
   <input id="endpoint" type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
</div>