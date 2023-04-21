<?php

/**
 * The main template file
 *
 * @package Aplicación_Web
 */
$peticionesasignadas = new WP_Query(array(
   'paged'         => get_query_var('paged', 1),
   'post_type'     => 'peticion',
   'meta_key'      => '_asignar_a',
   'orderby'       => '_f_seguimiento',
   'order'         => 'ASC',
   'meta_query'    => [
      [
         'key'   => '_asignar_a',
         'value' => '14'
      ],
      [
         'key'   => '_vigente',
         'value' => 1
      ]
   ]
));

get_header();
?>
<section class="container py-5">
   <?php if (is_user_logged_in()) : ?>
      <div class="row">
         <div class="col-xl-6">
            <?php
            if ($peticionesasignadas->have_posts()) {
               the_title('<h4 class="animate__animated animate__fadeInLeftBig">', '</h4>');
               while ($peticionesasignadas->have_posts()) :
                  $peticionesasignadas->the_post();
                  get_template_part('template-parts/content', get_post_type());
               endwhile;
               wp_reset_postdata();

               // 'total' => $peticionesasignadas->max_num_pages,

               // Setting up default values based on the current URL.
               $pagenum_link = html_entity_decode(get_pagenum_link());
               $url_parts    = explode('?', $pagenum_link);

               // Get max pages and current page out of the current query, if available.
               // $total   = isset($wp_query->max_num_pages) ? $wp_query->max_num_pages : 1;
               $total   = isset($peticionesasignadas->max_num_pages) ? $peticionesasignadas->max_num_pages : 1;
               $current = get_query_var('paged') ? intval(get_query_var('paged')) : 1;

               // Append the format placeholder to the base URL.
               $pagenum_link = trailingslashit($url_parts[0]) . '%_%';

               // URL base depends on permalink settings.
               $format  = $wp_rewrite->using_index_permalinks() && !strpos($pagenum_link, 'index.php') ? 'index.php/' : '';
               $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit($wp_rewrite->pagination_base . '/%#%', 'paged') : '?paged=%#%';
               $defaults = array(
                  'base'               => $pagenum_link, // http://example.com/all_posts.php%_% : %_% is replaced by format (below).
                  'format'             => $format, // ?page=%#% : %#% is replaced by the page number.
                  'total'              => $total,
                  'current'            => $current,
                  'aria_current'       => 'page',
                  'show_all'           => false,
                  'prev_next'          => true,
                  'prev_text'          => __('&laquo; Previous', 'staging'),
                  'next_text'          => __('Next &raquo;', 'staging'),
                  'end_size'           => 1,
                  'mid_size'           => 2,
                  'type'               => 'plain',
                  'add_args'           => array(), // Array of query args to add.
                  'add_fragment'       => '',
                  'before_page_number' => '',
                  'after_page_number'  => '',
               );

               echo paginate_links($defaults);
            } else {

               get_template_part('template-parts/content', 'none');
            }
            ?>
         </div>
         <div class="col-xl-6">
            <?= get_template_part('template-parts/content', 'busquedas') ?>
         </div>
      </div>
   <?php else : echo '<h3>Este contenido se muestra únicamente a personas ingresadas</h3>';
   endif; ?>
</section>
<?php
get_footer();
