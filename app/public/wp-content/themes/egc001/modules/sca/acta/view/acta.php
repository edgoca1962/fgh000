<?php

/**
 * Plantilla para el boton regresar de la página single.
 * 
 * @package EGC001
 */

use EGC001\Modules\Core\CoreController;

$core = CoreController::get_instance();
$atributos = EGC001\modules\core\CoreController::get_instance()->get_atributos(get_post_type());

?>
<?php if ($atributos['userAdmin']) : ?>
   <div class="col actas">
      <div class="card h-100" style="background: linear-gradient(to right, rgba(64, 154, 247, 1), rgba(43, 170, 177, 1)) !important; color: #fff;">
         <div class="d-flex align-items-center justify-content-center p-4">
            <div class=""><i class="fas fa-book-open" style="font-size:30px;"></i></div>
            <div class="ms-3 mb-4">
               <h6 class="card-title mb-0"><a class="text-white" href="<?php echo get_post_type_archive_link('acuerdo') . '?cpt=acuerdo&acta_id=' . get_the_ID() . '&comite_id=' . $atributos['comite_id'] ?>"><?php the_title() ?></a></h6>
            </div>
         </div>
         <?php if ($atributos['userAdmin']) : ?>
            <div class="card-footer">
               <div class="row">
                  <div class="d-flex justify-content-around">
                     <form id="eliminar_<?php echo get_the_ID() ?>" class="needs-validation">
                        <button type="submit" class="btn btn-outline-danger btn-sm" data-post_id="<?php echo get_the_ID() ?>" data-eliminar="true"><i class="fa-solid fa-trash-can" style="font-size: 12px;"></i> Eliminar</button>
                        <input type="hidden" name="action" value="eliminar_acta">
                        <input type="hidden" name="gestion" value="eliminar">
                        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('eliminar_acta') ?>">
                        <input type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
                        <input type="hidden" name="post_id" value="<?php echo get_the_ID() ?>">
                        <input type="hidden" name="titulo_confirmar" value="Se eliminará: <?php echo get_the_title() ?>">
                        <input type="hidden" name="msg_confirmar" value="Si elimina esta Minuta/Acta se eliminarán también TODOS sus acuerdos.">
                        <input type="hidden" name="titulo_procesado" value="La minuta/acta ha sido eliminada.">
                        <input type="hidden" name="msg_procesado" value="La Minuta/acta y sus acuerdos han sido eliminados.">
                     </form>
                  </div>
               </div>
            </div>
         <?php endif; ?>
      </div>
   </div>
<?php else : ?>
   <?php $core->set_atributo('verNavegacionPosts', false) ?>
<?php endif; ?>