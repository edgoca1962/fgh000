<h3>Comentarios</h3>
<?php if (have_comments()) : ?>
   <h5 class="mb-3">
      <?php
      printf(
         _nx(
            'Comentario para "%2$s"',
            '%1$s Comentarios para "%2$s"',
            get_comments_number(),
            'comments title',
            'fghmvc'
         ),
         number_format_i18n(get_comments_number()),
         '<span>' . get_the_title() . '</span>'
      );
      ?>
   </h5>

   <ol class="comment-list">
      <?php
      $args =
         [
            'walker'             => null,
            'max_depth'          => '',
            'style'              => 'ol',
            'callback'           => 'fghegc_get_comments_peticion',
            'end-callback'       => null,
            'type'               => 'all',
            'replay_text'        => 'Comentar',
            'page'               => '',
            'per_page'           => '',
            'avatar_size'        => 32,
            'reverse_top_level'  => '',
            'reverse_children'   => '',
            'format'             => 'html5',
            'short_ping'         => false,
            'echo'               => true
         ];
      wp_list_comments($args);
      ?>
   </ol><!-- .comment-list -->
<?php endif; ?>