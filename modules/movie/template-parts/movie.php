<div class="col">
   <a class="text-decoration-none" href="<?php the_permalink() ?>">
      <div class="card bg-dark shadowcss h-100">
         <img src="<?php echo get_post_meta($post->ID, '_poster_path', true) ?>" class="card-img-top" alt="<?php the_title() ?>">
         <div class="card-footer">
            <div class="d-flex bg-warning text-black justify-content-center align-items-center border border-secondary border-5" style="border-radius: 50%; width:50px; height:50px; margin-top:-2.3em;">
               <div><?php echo round(get_post_meta($post->ID, '_vote_average', true) * 10) . '%' ?></div>
            </div>
            <h5 class="mt-3"><?php the_title() ?></h5>
            <p class="text-mute"><?php echo $release_date = date('d-M-Y', strtotime(get_the_date())) ?></p>
         </div>
      </div>
   </a>
</div>