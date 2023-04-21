<?php
$postDate = new DateTime(get_the_date());

/************************************
 * Fecha Seguimiento y asignación
 ***********************************/
$time_string = '<time datetime="%1$s">%2$s</time>';
if (get_the_time('U') !== get_the_modified_time('U')) {
   $time_string = '<time datetime="%1$s">%2$s</time>';
} else {
   $time_string = 'Sin seguimiento';
}

$time_string = sprintf(
   $time_string,
   esc_attr(get_the_modified_date(DATE_W3C)),
   esc_html(get_the_modified_date())
);

$posted_on = sprintf(
   esc_html_x('Fecha Seguimiento: %s', 'post date', 'fghegc'),
   '<span>' . $time_string . '</span>'
);
$nombreasignada = get_user_by('id', get_post_meta($post->ID, '_asignar_a', true));
$asignada_a = '<a href="' . site_url('/asignado-' . get_post_meta($post->ID, '_asignar_a', true))  . '">' . $nombreasignada->display_name . '</a>';
$asignada = (get_post_meta($post->ID, '_asignar_a', true) == '') ? ' Sin asignar.' : $asignada_a;
$byline = sprintf(
   /* translators: %s: post author. */
   esc_html_x('Asignada a: %s', '', 'fghegc'),
   '<span>' . $asignada . '</span>'
);
/*********************************/

?>
<div id="tarjeta" class="py-5">
   <div class="card border-0 shadowcss">
      <div class="card-header text-dark">
         <p>
            <?php
            echo '<span>' . $posted_on . '</span>';
            echo '<span> ' . $byline . '</span>';
            ?>
         </p>
      </div>
      <div class="card-body background-blend">

         <?= the_title(
            sprintf(
               '<h4><a href="%s">',
               esc_url(get_permalink())
            ),
            '</a></h4>'
         );
         ?>
         <?php
         $taxonomy = 'category';

         // Get the term IDs assigned to post.
         $post_terms = wp_get_object_terms($post->ID, $taxonomy, array('fields' => 'ids'));
         unset($post_terms[4]);

         // Separator between links.
         $separator = ', ';

         if (!empty($post_terms) && !is_wp_error($post_terms)) {

            $term_ids = implode(',', $post_terms);

            $terms = wp_list_categories(array(
               'title_li' => '',
               'style'    => 'none',
               'echo'     => false,
               'taxonomy' => $taxonomy,
               'include'  => $term_ids,
               'exclude' => array(3)
            ));

            $terms = rtrim(trim(str_replace('<br />',  $separator, $terms)), $separator);

            // Display post categories.
            echo  $terms;
         }
         ?>
         <p class="card-text">
            <?php
            if (has_excerpt()) {
               echo get_the_excerpt();
            } else {
               echo wp_trim_words(get_the_content(), 18);
            } ?><a href="<?= the_permalink() ?>" class="nu gray"><span class="ps-3 pe-1 fs-4"><i class="fas fa-glasses"></i></span>Leer más</a>
         </p>
         <a href="tel:<?= get_post_meta($post->ID, '_telefono', true) ?>"><span class="pe-2"><i class="fas fa-phone-alt"></i></span><?= get_post_meta($post->ID, '_telefono', true) ?></a><br>
         <a href="mailto:<?= get_post_meta($post->ID, '_email', true) ?>"><span class="pe-2"><i class="fas fa-envelope"></i></span><?= get_post_meta($post->ID, '_email', true) ?></a>
      </div>
      <div class="card-footer text-dark">
         <small class="text-muted">
            <?php if (has_tag()) {
               echo get_the_tag_list('<p><span><i class="fas fa-tag"></i></span> Etiquetas: ', ', ', '</p>');
            } else {
               echo '<span><i class="fas fa-tag"></i></span> Sin etiquetas.';
            } ?>
         </small>
      </div>
      <input type="hidden" name="post_id" value="<?= the_ID()  ?>">
   </div><!-- #post-<?php the_ID(); ?> -->
</div>