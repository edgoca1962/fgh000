<section class="col vh-100 d-flex justify-content-center">
   <div class='position-relative'>
      <div class="d-flex justify-content-center">
         <a href="<?= esc_url(site_url('/')) ?>" style="z-index:5">
            <img src="<?= wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full')[0] ?>" class="rounded-circle shadowcss" style="width:100px;" alt="Logo">
         </a>
      </div>
      <div class="ingreso-bg p-5 rounded-5 shadowcss" style="margin-top:-3rem;">
         <form id="ingreso" novalidate>
            <div class="mb-4 bg-transparent">
               <label id="lblusuario" class="ms-2 fw-light fs-5" for="usuario" style="transition: all 0.3s ease-in-out; transform:translateY(150%)">Usuario</label>
               <input id="usuario" type="text" name="usuario" class="fs-4 fw-lighter form-control text-white rounded-0 border-0 border-bottom bg-transparent shadow-none" required />
               <div class="invalid-feedback">
                  Por favor digitar el usuario.
               </div>
            </div>

            <div class="mb-4 bg-transparent">
               <label id="lblclave" class="ms-2 fw-light fs-5" for="clave" style="transition: all 0.3s ease-in-out; transform:translateY(150%)">Contraseña</label>
               <input id="clave" type="password" name="clave" class="fs-4 fw-lighter form-control text-white rounded-0 border-0 border-bottom bg-transparent shadow-none" required />
               <div class="invalid-feedback">
                  Por favor digitar la contraseña.
               </div>
            </div>

            <div class="mb-4">
               <input class="form-check-input" type="checkbox" value="" id="recordarme">
               <label class="form-check-label fw-light" for="recordarme">
                  Recordarme
               </label>
            </div>
            <div class="text-center form-group">
               <button type="submit" class="btn btn-warning btn-lg mb-3"><i class="fas fa-sign-in-alt"></i> Ingresar</button>
            </div>
            <input type="hidden" name="action" value="ingresar">
            <input type="hidden" name="nonce" value="<?= wp_create_nonce('frm_ingreso') ?>">
            <input type="hidden" name="redireccion" value="<?= site_url('/') ?>">
            <input type="hidden" name="endpoint" value="<?= admin_url('admin-ajax.php') ?>">
         </form>
      </div>
   </div>
</section>