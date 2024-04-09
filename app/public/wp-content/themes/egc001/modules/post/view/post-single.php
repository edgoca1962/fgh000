<div class="col">
   <h2 class="card-title"><?php the_title() ?></h2>
   <?php the_content() ?>
   <small class="text">
      <?php if (has_tag()) {
         echo get_the_tag_list('<p><span><i class="fas fa-tag"></i></span> Etiquetas: ', ', ', '</p>');
      } else {
         echo '<span><i class="fas fa-tag"></i></span> Sin etiquetas.';
      } ?>
   </small>
</div>