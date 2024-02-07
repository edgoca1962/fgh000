<h3>Comentarios</h3>

<div class="row">
   <div class="col-12 wp-block-group__inner-container">
      <h4>Comentarios de seguimiento</h4>
      <?php $recent_comments = get_comments(array(
         'number'      => 5,
         'status'      => 'approve',
         'post_status' => 'publish'
      ));

      if ($recent_comments) {
         echo '<ol style="color: rgb(163, 158, 158);" class="has-dates has-excerpts wp-block-latest-comments">';
         foreach ($recent_comments as $comment) { ?>

            <li class="wp-block-latest-comments__comment">
               <article>
                  <footer class="wp-block-latest-comments__comment-meta">
                     <a href="<?= esc_url(get_comment_link($comment)) ?>"><span>Comentario de <?= $comment->comment_author ?> en </span><?= get_the_title($comment->comment_post_ID) ?></a>
                     <time datetime="<?= $comment->comment_date ?>" class="wp-block-latest-comments__comment-date"><?= $comment->comment_date ?></time>
                  </footer>
                  <div class="wp-block-latest-comments__comment-excerpt">
                     <p><?= $comment->comment_content ?></p>
                  </div>
               </article>
            </li>
         <?php
         }
         ?>
         </ol>

      <?php } ?>
   </div>
</div>