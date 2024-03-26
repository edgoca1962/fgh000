<?php

use FGHEGC\Modules\Core\CoreController;

$core = CoreController::get_instance();
$atributos = $core->get_atributos('menu');
$comedores = get_posts(['post_type' => 'comedor', 'posts_per_page' => -1, 'orderby' => 'post_title', 'order' => 'ASC']);
?>
<!-- Captura de Menues -->
<div class="row">
   <div class="col-md-8">
      <form id="menu_agregar" class="needs-validation" novalidate>
         <div class="form-group row mb-3">
            <div class="col-md-4 mb-3">
               <label class="form-label">Fecha</label>
               <input type="date" class="form-control" name="post_date" value="<?php echo date('Y-m-d') ?>">
            </div>
            <div class="col-md-4 mb-3">
               <label class="form-label">Comedor</label>
               <select name="post_parent" class="form-select" aria-label="Comedores">
                  <option value="0" selected>Seleccionar Comedor</option>
                  <?php foreach ($comedores as $comedor) : ?>
                     <option value="<?php echo $comedor->ID ?> "><?php echo $comedor->post_title ?></option>
                  <?php endforeach; ?>
               </select>
            </div>
         </div>
         <div class="form-group row mb-3">
            <div class="col">
               <textarea class="form-control" name="post_content" cols="30" rows="5" placeholder="Descripción del menú"></textarea>
            </div>
         </div>
         <div class="form-group row mb-3">
            <div class="col-3 d-flex align-items-center">
               <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="cereales" name="cereales">
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
                  <input class="form-check-input" type="checkbox" value="verduras" name="verduras">
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
                  <input class="form-check-input" type="checkbox" value="leguminosas" name="leguminosas">
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
                  <input class="form-check-input" type="checkbox" value="frutas" name="frutas">
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
                  <input class="form-check-input" type="checkbox" value="vegetales" name="vegetales">
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
                  <input class="form-check-input" type="checkbox" value="animales" name="animales">
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
                  <input class="form-check-input" type="checkbox" value="grasas" name="grasas">
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
                  <input class="form-check-input" type="checkbox" value="bebidas" name="bebidas">
                  <label class="form-check-label" for="bebidas">
                     Bebidas
                  </label>
               </div>
            </div>
            <div class="col">Marque esta opción si el menú contiene cualquier tipo de bebida que contenga agua.
            </div>
         </div>
         <hr>
         <div class="form-group mb-3">
            <button type="submit" class="btn btn-warning btn-sm mb-3 me-5"><span><i class="fa-solid fa-floppy-disk"></i></span> Guardar</button>
            <button id="btn_cancelar" type="btn" class="btn btn-sm btn-danger mb-3">Cancelar</button>
         </div><!-- Botones Guardar y Cancelar -->
         <input type="hidden" name="action" value="menu_agregar">
         <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('menues') ?>">
         <input id="endpoint" type="hidden" name="endpoint" value="<?php echo admin_url('admin-ajax.php') ?>">
      </form>
   </div>
   <div class="col-md-4">
      <?php get_template_part($atributos['sidebar']); ?>
   </div>
</div>