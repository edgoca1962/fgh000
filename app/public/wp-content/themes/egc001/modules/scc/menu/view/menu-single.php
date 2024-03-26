<?php

use FGHEGC\Modules\Core\CoreController;
use FGHEGC\Modules\Scc\Beneficiario\BeneficiarioController;

$core = CoreController::get_instance();
$atributos = $core->get_atributos('menu');
$beneficiario = BeneficiarioController::get_instance()->get_atributos('beneficiario');
$comedores = get_posts(['post_type' => 'comedor', 'posts_per_page' => -1, 'orderby' => 'post_title', 'order' => 'ASC']);

?>
<section id="seccion_menu_single" <?php echo $beneficiario['ocultarVista'] ?>>
   <form id="menu_single" class="needs-validation" novalidate>
      <div class="form-group mb-3" <?php echo $beneficiario['ocultarBoton'] ?>>
         <button id="btn_editar_menu" type="button" class="btn btn-warning mb-3" data-scc_post_id="<?php the_ID() ?>" data-action="menu_editar" data-nonce="<?php echo wp_create_nonce('menu_editar') ?>"><span><i class="fa-solid fa-pen-to-square"></i></span> Editar Datos</button>
      </div><!-- Boton Editar -->
      <div class="form-group row mb-3">
         <div class="col-md-4 mb-3">
            <label class="form-label">Fecha</label>
            <input type="date" class="form-control bg-secondary border-0 " name="post_date" value="<?php echo date('Y-m-d', strtotime(get_post(get_the_ID())->post_date)) ?>" disabled editar>
         </div>
         <div class="col-md-4 mb-3">
            <label class="form-label">Comedor</label>
            <select name="post_parent" class="form-select bg-secondary border-0" aria-label="Comedores" disabled editar>
               <?php foreach ($comedores as $comedor) : ?>
                  <option value="<?php echo $comedor->ID ?>" <?php ($comedor->ID == get_post(get_the_ID())->post_parent) ? 'selected' : '' ?>><?php echo $comedor->post_title ?></option>
               <?php endforeach; ?>
            </select>
         </div>
      </div>
      <div class="form-group row mb-3">
         <div class="col">
            <textarea class="form-control bg-secondary border-0" name="post_content" cols="30" rows="5" placeholder="Descripción del menú" disabled editar><?php echo get_post(get_the_ID())->post_content ?></textarea>
         </div>
      </div>
      <div class="form-group row mb-3">
         <div class="col-3 d-flex align-items-center">
            <div class="form-check">
               <input class="form-check-input" type="checkbox" value="cereales" name="cereales" <?php echo (get_post_meta(get_the_ID(), '_cereales', true) == 'cereales') ? 'checked' : '' ?> disabled editar>
               <label class="form-check-label" for="cereales">
                  Cereales
               </label>
            </div>
         </div>
         <div class="col">Marque esta opción si el menú contiene alguno de estos cereales: Maíz y sus derivados como harina de maíz (masa) y tortillas,Trigo y sus derivados como harina de trigo, el pan y la pasta, Arroz o Avena.
         </div>
      </div>
      <div class="form-group row mb-3">
         <div class="col-3 d-flex align-items-center">
            <div class="form-check">
               <input class="form-check-input" type="checkbox" value="verduras" name="verduras" <?php echo (get_post_meta(get_the_ID(), '_verduras', true) == 'verduras') ? 'checked' : '' ?> disabled editar>
               <label class="form-check-label" for="verduras">
                  Verduras Harinosas
               </label>
            </div>
         </div>
         <div class="col">Marque esta opción si el menú contiene alguno de estas verduras: Tubérculos como papa, camote, yuca, tiquisque, ñampí y malanga; plátanos verdes y maduros, pejibaye y fruta de pan.
         </div>
      </div>
      <div class="form-group row mb-3">
         <div class="col-3 d-flex align-items-center">
            <div class="form-check">
               <input class="form-check-input" type="checkbox" value="leguminosas" name="leguminosas" <?php echo (get_post_meta(get_the_ID(), '_leguminosas', true) == 'leguminosas') ? 'checked' : '' ?> disabled editar>
               <label class="form-check-label" for="leguminosas">
                  Leguminosas
               </label>
            </div>
         </div>
         <div class="col">Marque esta opción si el menú contiene alguna de estas leguminosas: Todos tipo de frijoles: negros, rojos, blancos, cubaces, gandules, pintos, etc., los garbanzos y lentejas.
         </div>
      </div>
      <div class="form-group row mb-3">
         <div class="col-3 d-flex align-items-center">
            <div class="form-check">
               <input class="form-check-input" type="checkbox" value="frutas" name="frutas" <?php echo (get_post_meta(get_the_ID(), '_frutas', true) == 'frutas') ? 'checked' : '' ?> disabled editar>
               <label class="form-check-label" for="frutas">
                  Frutas
               </label>
            </div>
         </div>
         <div class="col">Marque esta opción si el menú contiene alguna de estas frutas: Mango, papaya, melón, sandía, jocote, guayaba, mora, piña, carambola, cas, naranja, mandarina, guanábana, limón dulce, anona y fresas, entre otras.
         </div>
      </div>
      <div class="form-group row mb-3">
         <div class="col-3 d-flex align-items-center">
            <div class="form-check">
               <input class="form-check-input" type="checkbox" value="vegetales" name="vegetales" <?php echo (get_post_meta(get_the_ID(), '_vegetales', true) == 'vegetales') ? 'checked' : '' ?> disabled editar>
               <label class="form-check-label" for="vegetales">
                  Vegetales
               </label>
            </div>
         </div>
         <div class="col">Marque esta opción si el menú contiene alguna de estos vegetales: Zapallo, ayote, chayote, tacaco; las hojas como lechuga, repollo,espinaca, hojas de remolacha o de rábano, mostaza, zorrillo, berrosy el chicasquil. En este grupo también están el brócoli, coliflor, zanahoria, pepino, tomate, rábano, hongos, entre otros. También incluye todos los olores como cebolla, ajo, culantro, chile dulce, apio y perejil.
         </div>
      </div>
      <div class="form-group row mb-3">
         <div class="col-3 d-flex align-items-center">
            <div class="form-check">
               <input class="form-check-input" type="checkbox" value="animales" name="animales" <?php echo (get_post_meta(get_the_ID(), '_animales', true) == 'animales') ? 'checked' : '' ?> disabled editar>
               <label class="form-check-label" for="animales">
                  Alimentos de origen aninal
               </label>
            </div>
         </div>
         <div class="col">Marque esta opción si el menú contiene alguna de estos productos: Carnes de res, cerdo, pollo, pescado y mariscos, así como el huevo, queso blanco, yogurt, y leche.
         </div>
      </div>
      <div class="form-group row mb-3">
         <div class="col-3 d-flex align-items-center">
            <div class="form-check">
               <input class="form-check-input" type="checkbox" value="grasas" name="grasas" <?php echo (get_post_meta(get_the_ID(), '_grasas', true) == 'grasas') ? 'checked' : '' ?> disabled editar>
               <label class="form-check-label" for="grasas">
                  Grasas
               </label>
            </div>
         </div>
         <div class="col">Marque esta opción si el menú contiene alguna de estas grasas: Aceites (aceite de canola, soya, girasol, maíz y oliva) aguacate y semillas
            (maní, marañón, pistachos, almendras) y otros tipos de grasa como (aceite de coco, aceite de palma y las grasas sólidas como margarinas, mantequillas, manteca y natilla.)</div>
      </div>
      <div class="form-group row mb-3">
         <div class="col-3 d-flex align-items-center">
            <div class="form-check">
               <input class="form-check-input" type="checkbox" value="bebidas" name="bebidas" <?php echo (get_post_meta(get_the_ID(), '_bebidas', true) == 'bebidas') ? 'checked' : '' ?> disabled editar>
               <label class="form-check-label" for="bebidas">
                  Bebidas
               </label>
            </div>
         </div>
         <div class="col">Marque esta opción si el menú contiene cualquier tipo de bebida que contenga agua.
         </div>
      </div>
      <div id="menu_botones" class="form-group mb-3" hidden>
         <button name="modificar" type="submit" class="btn btn-warning btn-sm mb-3 me-5"><span><i class="fa-solid fa-floppy-disk"></i></span> Guardar</button>
         <button name="eliminar" titulo="Eliminar Menu" msg="Se eliminará el menu." type="submit" class="btn btn-danger btn-sm mb-3 me-5" <?php echo $beneficiario['ocultarElemento'] ?>><span><i class="fa-solid fa-trash-can" <?php echo $beneficiario['ocultarElemento'] ?>></i></span> Eliminar</button>
         <button id="btn_cancelar" type="btn" class="btn btn-sm btn-secondary mb-3">Cancelar</button>
      </div><!-- Botones Guardar y Cancelar -->
      <input type="hidden" name="post_id" value="<?php the_ID() ?>">
      <input type="hidden" name="action" value="menu_editar">
      <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('menues') ?>">
      <input id="endpoint" type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
      <hr>
   </form>
</section>