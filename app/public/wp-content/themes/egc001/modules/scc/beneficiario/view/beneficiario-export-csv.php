<?php

use EGC001\Modules\Core\CoreController;

/**
 * 
 * Plantilla para listar beneficiarios(as)
 * 
 * @package:EGC001
 * 
 */

$atributos = CoreController::get_instance();

?>
<section id="seccion_beneficiario_export_csv" <?php echo $atributos->get_atributo('ocultarVista') ?>>
   <form id="beneficiario_export_csv" enctype="multipart/form-data" class="needs-validation mb-5">
      <button type="submit" class="btn btn-info">Generar Archivo</button>
      <button class="btn btn-danger">
         <a href="<?php echo wp_upload_dir()['url'] . '/beneficiarios.csv' ?>" download="beneficiarios.csv">Extraer Archivo (CSV)</a>
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
         foreach ($atributos->get_atributo('listadoBeneficiarios') as $beneficiario) : ?>
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
</section>