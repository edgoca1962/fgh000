<form id="b_<?php get_the_ID() ?>">
   <div class="row">
      <div class="row form-group mb-3 align-items-center">
         <div class="col-2 col-md-1">
            <img src="<?php echo (get_the_post_thumbnail_url(get_the_ID())) ? get_the_post_thumbnail_url(get_the_ID()) : FGHEGC_DIR_URI . '/assets/img/avatar03.png' ?>" class="rounded-circle" style="width:50px;" alt="imagen beneficiario">
         </div>
         <div class="col fs-4"><?php the_title() ?></div>
      </div>
      <div class="container row justify-content-center">
         <div class="col-4 col-md-3">
            <div class="form-check">
               <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
               <label class="form-check-label" for="flexCheckDefault">
                  Reflexión
               </label>
            </div>
         </div>
         <div class="col-4 col-md-3">
            <div class="form-check">
               <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
               <label class="form-check-label" for="flexCheckDefault">
                  Alimentación
               </label>
            </div>
         </div>
         <div class="col-4 col-md-2">
            <input type="number" class="form-control" step="1" id="exampleFormControlInput1" placeholder="Cantidad" value="1">
         </div>
      </div>
   </div>
</form>