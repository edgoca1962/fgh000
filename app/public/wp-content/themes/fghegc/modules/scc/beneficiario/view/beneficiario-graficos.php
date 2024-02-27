<?php

use FGHEGC\Modules\Core\CoreController;

$atributos = CoreController::get_instance()->get_atributos('beneficiario');

if (isset($_GET['mes'])) {
   $mesSel = sanitize_text_field($_GET['mes']);
} else {
   $mesSel = date('n');
}
if (isset($_GET['anno'])) {
   $annoSel = sanitize_text_field($_GET['anno']);
} else {
   $annoSel = date('Y');
}
$totalComedores = count($atributos['datosGraficos']['donas']);
$comedoresId = [];
foreach ($atributos['datosGraficos']['donas'] as $comedor) {
   $comedoresId[] = $comedor['ID'];
}
$comedoresId = json_encode($comedoresId);
$comedoresId = str_replace('"', '', $comedoresId);

?>

<div id="beneficiario_graficos" class="row" <?php echo $atributos['ocultarVista'] ?>>
   <div class="col-md-8">
      <div class="container">
         <div class="form-group row mb-3">
            <div class="col col-md-4">
               <select id="mes" class="form-select mb-3">
                  <?php foreach ($atributos['datosGraficos']['mesesEspanol'] as $numero => $nombre) : ?>
                     <option value="<?php echo $numero ?>" <?php echo ($mesSel == $numero) ? 'selected' : '' ?>><?php echo $nombre ?></option>
                  <?php endforeach; ?>
               </select>
            </div>
            <div class="col col-md-4">
               <select id="anno" class="col-3 form-select mb-3">
                  <?php for ($i = 2024; $i < 2035; $i++) : ?>
                     <option value="<?php echo $i ?>" <?php echo ($annoSel == $i) ? 'selected' : '' ?>><?php echo $i ?></option>
                  <?php endfor; ?>
               </select>
            </div>
         </div>
         <div class="row mb-5">
            <canvas class="bg-white rounded" id="myChart"></canvas>
            <input id="GraGenLabels" type="hidden" value='<?php echo json_encode($atributos['datosGraficos']['labels']) ?>'>
            <input id="GraGenAsistencia" type="hidden" value='<?php echo json_encode($atributos['datosGraficos']['asistencia']) ?>'>
            <input id="GraGenAusencia" type="hidden" value='<?php echo json_encode($atributos['datosGraficos']['ausencia']) ?>'>
            <input id="GraGenCantidad" type="hidden" value='<?php echo json_encode($atributos['datosGraficos']['cantidad']) ?>'>
         </div>
         <div class="row row-cols-1 row-cols-md-2 g-4 mb-5">
            <?php $i = 0;
            foreach ($atributos['datosGraficos']['donas'] as $comedor) : ?>
               <div>
                  <h3><?php echo $comedor['titulo'] ?></h3>
                  <canvas class="bg-white rounded" id="grafico_<?php echo $i ?>"></canvas>
                  <input id="titulo_<?php echo $i ?>" type="hidden" value='<?php echo $comedor['titulo'] ?>'>
                  <input id="datos_<?php echo $i ?>" type="hidden" value='<?php echo json_encode($comedor['datos']) ?>'>
               </div>
            <?php $i++;
            endforeach; ?>
            <input type="hidden" id="totalComedores" value="<?php echo $totalComedores  ?>">
         </div>
      </div>
   </div>
   <input type="hidden" id="url" value=<?php echo site_url('/beneficiario-graficos') ?>>
   <input id="action" type="hidden" name="action" value="beneficiario_graficos">
   <input id="nonce" type="hidden" name="nonce" value="<?php echo wp_create_nonce('graficos') ?>">
   <input id="endpoint" type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
   <div class="col-md-4">
      <?php get_template_part($atributos['sidebar'])
      ?>
   </div>
</div>