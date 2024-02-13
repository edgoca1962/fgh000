<?php

use FGHEGC\Modules\Core\CoreController;

$atributos = CoreController::get_instance()->get_atributos('beneficiario');

?>
<section>
   <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
         <?php foreach ($atributos['carrusel'] as $imagen) : ?>
            <div class="carousel-item active">
               <img src="<?php echo $imagen ?>" class="d-block w-100" alt="">
            </div>
            <div class="carousel-caption d-none d-md-block">
               <h5>Comedor Grano de Trigo</h5>
               <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto inventore dicta, quaerat corporis laborum non.</p>
            </div>
         <?php endforeach; ?>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
         <span class="carousel-control-prev-icon" aria-hidden="true"></span>
         <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
         <span class="carousel-control-next-icon" aria-hidden="true"></span>
         <span class="visually-hidden">Next</span>
      </button>
   </div>
</section>
<section>
   <div class="bg-white text-black p-3">
      <h1 class="text-center fw-bold">Nuestro Valores</h1>
      <div class="row">
         <div class="col-6">
            <img src="<?php echo FGHEGC_DIR_URI . '/assets/img/comedores01.png' ?>" class="w-100 p-3 rounded" alt="">
         </div>
         <div class="col-6">
            <h3>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ducimus veritatis atque, autem in recusandae id eos, illo error soluta, reiciendis repudiandae est voluptatem exercitationem magni deserunt sint consectetur unde aliquid sunt commodi? Sequi incidunt, eius nesciunt aliquid ipsa placeat odit inventore natus praesentium voluptatem quisquam hic, nisi dicta accusantium minima saepe alias voluptatibus modi debitis officiis dolor necessitatibus explicabo ad! Recusandae, ullam doloremque iste neque, voluptatem fugiat blanditiis labore dolorum sint iure eum earum quia, porro explicabo officia impedit ut suscipit possimus accusantium nihil natus totam aspernatur hic. </h3>
         </div>
      </div>
   </div>
</section>