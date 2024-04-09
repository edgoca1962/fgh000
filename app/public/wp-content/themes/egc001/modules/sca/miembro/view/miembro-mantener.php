<?php

/**
 * Plantilla para menú Membresía.
 *
 * @package EGC001
 */

use EGC001\Modules\Core\CoreController;

$atributos = CoreController::get_instance()->get_atributos('miembro');

?>

<!-- Menú de Mantenimiento -->
<div class="row">
   <div class="col-md-8">
      <div class="row row-cols-1 row-cols-xl-2 g-4 mb-5">
         <div class="col-md">
            <button id="btn_mantener_miembro" type="button" class="btn" data-bs-toggle="modal" data-bs-target="#comiteModal">
               <div id="m_comites" class="card shadow" style="background: linear-gradient(to right, rgba(64, 154, 247, 1), rgba(43, 170, 177, 1)) !important;color: #fff;">
                  <div class="d-flex align-items-center p-4">
                     <div class=""><i class="fas fa-users" style="font-size:110px;"></i></div>
                     <div class="ms-3 mb-4">
                        <h4>Mantenimiento de Membresía</h4>
                     </div>
                  </div>
               </div>
            </button>
         </div>
         <div class="col-md">
            <button id="btn_mantener_usuario" type="button" class="btn" data-bs-toggle="modal" data-bs-target="#usuarioModal">
               <div id="m_usuarios" class="card shadow" style="background: linear-gradient(to right, rgba(64, 154, 247, 1), rgba(43, 170, 177, 1)) !important;color: #fff;">
                  <div class="d-flex align-items-center p-4">
                     <div class=""><i class="fa-solid fa-user-plus" style="font-size:110px;"></i></div>
                     <div class="ms-3 mb-4">
                        <h4>Mantenimiento de Usuarios</h4>
                     </div>
                  </div>
               </div>
            </button>
         </div>
         <div class="col-md">
            <button id="btn_agregar_puesto" type="button" class="btn" data-bs-toggle="modal" data-bs-target="#puestoModal">
               <div id="m_puestos" class="card shadow" style="background: linear-gradient(to right, rgba(64, 154, 247, 1), rgba(43, 170, 177, 1)) !important;color: #fff;">
                  <div class="d-flex align-items-center p-4">
                     <div class=""><i class="fa-solid fa-user-tag" style="font-size:110px;"></i></div>
                     <div class="ms-3 mb-4">
                        <h4>Mantenimiento de Puestos</h4>
                     </div>
                  </div>
               </div>
            </button>
         </div>
      </div>
   </div>
   <div class="col-xl-4">
      <?php get_template_part($atributos['sidebar']) ?>
   </div>
</div>
<!-- Mantenimiemto de Membresía -->
<div class="modal fade" id="comiteModal" tabindex="-1" aria-labelledby="comiteModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content" style="background-color: rgba(174, 102, 221, 1);">
         <form id="mantener_membresia" class="needs-validation" novalidate>
            <div class="modal-header">
               <h1 class="modal-title fs-5" id="comiteModalLabel">Mantenimiento de Membresía</h1>
               <button id="btn_cerrar_miembro" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="row row-cols-md-3 g-3 mb-3">
                  <div class="col-md">
                     <label for="usr_id" class="form-label">Usuario</label>
                     <select name="usr_id" id="usr_id" class="form-select" aria-label="Selecionar miembro" required>
                        <option value="0" selected>Sin Asignar</option>
                        <?php
                        $usuarios = get_users('orderby=nicename');
                        foreach ($usuarios as $usuario) {
                        ?>
                           <option <?= (get_post_meta($post->ID, '_usr_id', true) == $usuario->ID) ? 'value="' . esc_attr($usuario->ID) . '" Selected' : 'value="' . $usuario->ID . '"' ?>><?= $usuario->display_name ?></option>
                        <?php
                        }
                        ?>
                     </select>
                     <div class="invalid-feedback">
                        Favor no dejar en blanco.
                     </div>
                  </div>
                  <div class="col-md">
                     <label for="comite_id" class="form-label">Comité</label>
                     <select name="comite_id" id="comite_id" class="form-select" aria-label="Selecionar miembro" required>
                        <option value="0" selected>Sin asignar</option>
                        <?php
                        $comites = get_posts(['post_type' => 'comite', 'posts_per_page' => -1, 'post_status' => 'publish', 'orderby' => 'ID']);
                        foreach ($comites as $comite) {
                        ?>
                           <option <?php echo (get_post_meta($post->ID, '_comite_id', true) == $comite->ID) ? 'value="' . esc_attr($comite->ID) . '" Selected' : 'value="' . $comite->ID . '"' ?>><?php echo $comite->post_title ?></option>
                        <?php
                        }
                        ?>
                     </select>
                     <div class="invalid-feedback">
                        Favor no dejar en blanco.
                     </div>
                  </div>
                  <div class="col-md">
                     <label for="puesto_id" class="form-label">Puesto</label>
                     <select name="puesto_id" id="puesto_id" class="form-select" aria-label="Selecionar miembro" required>
                        <option value="0" selected>Sin asignar</option>
                        <?php
                        $puestos = get_posts(['post_type' => 'puesto', 'posts_per_page' => -1, 'post_status' => 'publish', 'orderby' => 'ID']);
                        foreach ($puestos as $puesto) {
                        ?>
                           <option <?php echo (get_post_meta($post->ID, '_puesto_id', true) == $puesto->ID) ? 'value="' . esc_attr($puesto->ID) . '" Selected' : 'value="' . $puesto->ID . '"' ?>><?php echo $puesto->post_title ?></option>
                        <?php
                        }
                        ?>
                     </select>
                     <div class="invalid-feedback">
                        Favor no dejar en blanco.
                     </div>
                  </div>
                  <div class="col-md">
                     <label for="f_inicio" class="form-label">Fecha Inicio</label>
                     <input type="date" class="form-control" name="f_inicio" id="f_inicio" value="<?php echo date('Y-m-d') ?>" required>
                     <div class="invalid-feedback">
                        Favor no dejar en blanco.
                     </div>
                  </div>
                  <div class="col-md">
                     <label for="f_final" class="form-label">Fecha Final</label>
                     <input type="date" class="form-control" name="f_final" id="f_final">
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button id="agregar_miembro" type="submit" class="btn btn-warning disabled">Agregar Miembro</button>
               <button id="modificar_miembro" type="submit" class="btn btn-warning mx-3 disabled">Modificar
                  Miembro</button>
               <button id="eliminar_miembro" type="submit" class="btn btn-danger disabled">Eliminar Miembro</button>
            </div>
            <input type="hidden" name="action" value="mantener_membresia">
            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('mantener_membresia') ?>">
            <input type="hidden" name="endpoint" id="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
            <input type="hidden" name="url" id="url_miembro" value="<?php echo get_site_url() . '/wp-json/wp/v2/miembros' ?>">
            <input type="hidden" name="titulo_procesado" value="Mantenimiento de Puesto realizado exitosamente.">
            <input type="hidden" name="gestion" id="miembro_gestion">
            <input type="hidden" name="post_id" id="miembro_post_id">
            <input type="hidden" name="boton" id="boton_miembro">
            <input type="hidden" name="titulo_confirmar" id="miembro_titulo_confirmar">
         </form>
      </div>
   </div>
</div>
<!-- Mantenimeinto de Usuarios -->
<div class="modal fade" id="usuarioModal" tabindex="-1" aria-labelledby="usuarioModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content" style="background-color: rgba(174, 102, 221, 1);">
         <form id="mantener_usuario" class="needs-validation" novalidate>
            <div class="modal-header">
               <h1 class="modal-title fs-5" id="usuarioModalLabel">Mantenimiento de Usuarios</h1>
               <button id="btn_cerrar_usuario" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="row row-cols-md-3 g-3 mb-3">
                  <div class="col-md">
                     <label for="user_email" class="form-label">E-mail</label>
                     <input id="user_email" name="user_email" type="email" class="form-control" required>
                     <div class="invalid-feedback text-white">
                        Favor no dejar en blanco y en formato de email.
                     </div>
                  </div>
                  <div class="col-md">
                     <label for="first_name" class="form-label">Nombre</label>
                     <input id="first_name" name="first_name" type="text" class="form-control" required>
                     <div class="invalid-feedback text-white">
                        Favor no dejar en blanco.
                     </div>
                  </div>
                  <div class="col-md">
                     <label for="last_name" class="form-label">Apellido</label>
                     <input id="last_name" name="last_name" type="text" class="form-control" required>
                     <div class="invalid-feedback text-white">
                        Favor no dejar en blanco.
                     </div>
                  </div>
                  <div class="col-md">
                     <label for="user_login" class="form-label">Usuario de ingreso</label>
                     <input id="user_login" name="user_login" type="text" class="form-control" required>
                     <div class="invalid-feedback text-white">
                        Favor no dejar en blanco.
                     </div>
                  </div>
                  <div class="col-md">
                     <label for="user_pass" class="form-label">Contraseña</label>
                     <input id="user_pass" name="user_pass" type="text" class="form-control" required>
                     <div class="invalid-feedback text-white">
                        Favor no dejar en blanco.
                     </div>
                  </div>
                  <div class="col-md pt-md-4">
                     <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="0" id="scaadmin" name="scaadmin">
                        <label class="form-check-label" for="scaadmin">
                           Usuario Adm. del Sistema
                        </label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button id="agregar_usuario" type="submit" class="btn btn-warning disabled">Agregar Usuario</button>
               <button id="modificar_usuario" type="submit" class="btn btn-warning mx-3 disabled">Modificar
                  Usuario</button>
               <button id="eliminar_usuario" type="submit" class="btn btn-danger disabled">Eliminar Usuario</button>
            </div>

            <input type="hidden" name="action" value="mantener_membresia">
            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('mantener_membresia') ?>">
            <input type="hidden" name="endpoint" id="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
            <input type="hidden" name="url" id="url_usuario" value="<?php echo get_site_url() . '/wp-json/wp/v2/users' ?>">
            <input type="hidden" name="titulo_procesado" value="Mantenimiento de Puesto realizado exitosamente.">
            <input type="hidden" name="gestion" id="usuario_gestion">
            <input type="hidden" name="post_id" id="usuario_post_id">
            <input type="hidden" name="boton" id="boton_usuario">
            <input type="hidden" name="titulo_confirmar" id="usuario_titulo_confirmar">

         </form>
      </div>
   </div>
</div>
<!-- Mantenimiento de Puestos -->
<div class="modal fade" id="puestoModal" tabindex="-1" aria-labelledby="puestoModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="background-color: rgba(174, 102, 221, 1);">
         <form id="mantener_puesto" class="needs-validation" novalidate>
            <div class="modal-header">
               <h1 class="modal-title fs-5" id="puestoModalLabel">Mantenimiento de Puestos</h1>
               <button id="btn_cerrar_puesto" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="row row-cols-md-2 g-3 mb-3">
                  <div class="col-md">
                     <label for="nombrePuesto" class="form-label">Nombre del Puesto</label>
                     <input id="nombrePuesto" class="form-control" name="nombrePuesto" type="text" list="puestos" required>
                     <datalist id="puestos">
                        <?php
                        $puestos = get_posts(['post_type' => 'puesto', 'posts_per_page' => -1, 'post_status' => 'publish',]);
                        foreach ($puestos as $puesto) {
                        ?>
                           <option value="<?php echo $puesto->ID . ' - ' . $puesto->post_title ?>">
                           <?php
                        }
                           ?>
                     </datalist>
                     <div class="invalid-feedback">
                        Favor no dejar en blanco.
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer text-center">
               <button id="agregar_puesto" type="submit" class="btn btn-warning disabled">Agregar Puesto</button>
               <button id="modificar_puesto" type="submit" class="btn btn-warning mx-3 disabled">Modificar
                  Puesto</button>
               <button id="eliminar_puesto" type="submit" class="btn btn-danger disabled">Eliminar Puesto</button>
            </div>
            <input type="hidden" name="action" value="mantener_membresia">
            <input id="puesto_gestion" type="hidden" name="gestion" value="">
            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('mantener_membresia') ?>">
            <input id="endpoint" type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
            <input id="puesto_post_id" type="hidden" name="post_id" value="">
            <input type="hidden" name="titulo_procesado" value="Mantenimiento de Puesto realizado exitosamente.">
            <input id="url_puesto" type="hidden" name="url" value="<?php echo get_site_url() . '/wp-json/wp/v2/puestos?search=' ?>">
            <input id="boton_puesto" type="hidden" name="boton">
            <input type="hidden" name="titulo_confirmar" value="Se eliminará: <?php echo get_the_title() ?>">
         </form>
      </div>
   </div>
</div>