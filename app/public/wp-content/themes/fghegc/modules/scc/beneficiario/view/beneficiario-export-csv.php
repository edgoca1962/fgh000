<?php

use FGHEGC\Modules\Core\CoreController;
use FGHEGC\Modules\Scc\Beneficiario\BeneficiarioModel;

$atributos = CoreController::get_instance()->get_atributos('beneficiario');
$beneficiarios = BeneficiarioModel::get_instance()->scc_beneficiario_listado();

?>
<section id="seccion_beneficiario_export_csv" <?php echo $atributos['ocultarVista'] ?>>
   <div class="row">
      <div class="col-md-8">
         <form id="beneficiario_export_csv" enctype="multipart/form-data" class="needs-validation mb-5">
            <button type="submit" class="btn btn-info">Generar Archivo</button>
            <button class="btn btn-danger">
               <a href="<?php echo wp_upload_dir()['url'] . '/beneficiarios.csv' ?>" download>Extraer Archivo (CSV)</a>
            </button>
            <input type="hidden" name="action" value="scc_beneficiario_csv">
            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('beneficiarios_csv') ?>">
            <input id="endpoint" type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
         </form>
         <table class="table table-striped">
            <thead>
               <tr class="table-dark">
                  <th scope="col">Comedor</th>
                  <th scope="col">Nombre</th>
                  <th scope="col">Condición</th>
                  <th scope="col">Edad</th>
                  <th scope="col">Estatura</th>
               </tr>
            </thead>
            <tbody>
               <?php $i = 1;
               foreach ($beneficiarios as $beneficiario) : ?>
                  <tr>
                     <th scope="row"><?php echo $i . ' - ' .  get_post($beneficiario->comedor)->post_title ?></th>
                     <td><?php echo $beneficiario->nombre ?></td>
                     <td><?php echo $beneficiario->condicion ?></td>
                     <td><?php echo $beneficiario->edad ?></td>
                     <td><?php echo $beneficiario->estatura ?></td>
                  </tr>
               <?php $i++;
               endforeach; ?>
            </tbody>
         </table>
      </div>
      <div class="col-md-4">
         <?php get_template_part($atributos['sidebar']) ?>
      </div>
   </div>
</section>