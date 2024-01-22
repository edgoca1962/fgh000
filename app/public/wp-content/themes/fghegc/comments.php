<?php

/**
 * The template for displaying Comments.
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

use FGHEGC\modules\core\CommentsForm;

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */

if (post_password_required()) {
   return;
}
?>

<div id="comments" class="comments-area">

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
               'callback'           => 'fghegc_get_comments',
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

      <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
         <nav class="navigation comment-navigation" role="navigation">
            <h1 class="screen-reader-text section-heading"><?php _e('Comment navigation', 'fghmvc'); ?></h1>
            <div class="nav-previous"><?php previous_comments_link(__('&larr; Comentarios antigüos', 'fghmvc')); ?></div>
            <div class="nav-next"><?php next_comments_link(__('Nuevos comentarios &rarr;', 'fghmvc')); ?></div>
         </nav><!-- .comment-navigation -->
      <?php endif; // Check for comment navigation 
      ?>

      <?php if (!comments_open() && get_comments_number()) : ?>
         <p class="no-comments"><?php _e('Comments are closed.', 'fghmvc'); ?></p>
      <?php endif; ?>

   <?php endif; // have_comments() 
   ?>
   <?php
   /***************************************************************************
    * Formato para captura de comentarios de seguimiento
    ********/

   $fields = array(
      'author' => sprintf(
         '<div class="form-group mb-3">%s</div>',
         sprintf(
            '<input id="author" class="form-group" placeholder="Nombre" name="author" type="text" value="%s" maxlength="245"%s />',
            esc_attr($commenter['comment_author']),
            ''
         )
      ),
      'email'  => sprintf(
         '<div class="form-group mb-3">%s</div>',
         sprintf(
            '<input id="email" class="form-group" placeholder="E-mail" name="email" %s value="%s" maxlength="100" aria-describedby="email-notes"%s />',
            '',
            esc_attr($commenter['comment_author_email']),
            ''
         )
      ),
      'url'    => sprintf(
         '<p class="form-group">%s</p>',
         sprintf(
            '<input id="url" class="form-group" placeholder="Sitio Web" name="url" %s value="%s" maxlength="200" />',
            '',
            esc_attr($commenter['comment_author_url'])
         )
      ),
   );


   $defaults = array(
      'fields'               => $fields,
      'comment_field'        => sprintf(
         '<div class="form-group mb-3 col col-md-6"> %s</div>',
         '<textarea id="comment" class="form-control" name="comment" cols="45" rows="8" placeholder="Espacio para incluir comentario de seguimiento." maxlength="65525"' . '*' . '></textarea>'
      ),
      'must_log_in'          => sprintf(
         '<div class="form-group">%s</div>',
         sprintf(
            // /* translators: %s: Login URL.
            __('Tienes que estar <a href="%s">registrado</a> para incluir un comentario.', 'fghmvc'),
            // /** This filter is documented in wp-includes/link-template.php 
            wp_login_url(apply_filters('the_permalink', get_permalink(get_the_ID()), get_the_ID()))
         )
      ),
      'logged_in_as'         => sprintf(
         '<div class="form-group mb-3">%s%s</div>',
         sprintf(
            // /* translators: 1: Edit user link, 2: Accessibility text, 3: User name, 4: Logout URL. 
            __('<a href="%1$s" aria-label="%2$s">Autor(a): %3$s</a>'),
            get_edit_user_link(),
            // /* translators: %s: User name. 
            esc_attr(sprintf(__('Autor(a): %s. Editar perfil.', 'fghmvc'), $user_identity)),
            $user_identity,
            // /** This filter is documented in wp-includes/link-template.php 
            wp_logout_url(apply_filters('the_permalink', get_permalink(get_the_ID()), get_the_ID()))
         ),
         ''
      ),
      'comment_notes_before' => sprintf(
         '<p class="comment-notes">%s%s</p>',
         sprintf(
            '<span id="email-notes">%s</span>',
            __('Your email address will not be published.')
         ),
         ''
      ),
      'comment_notes_after'  => '',
      'action'               => site_url('/wp-comments-post.php'),
      'id_form'              => 'commentform',
      'id_submit'            => 'submit',
      'class_container'      => 'comment-respond mb-3',
      'class_form'           => '',
      'class_submit'         => 'btn btn-warning',
      'name_submit'          => 'submit',
      'title_reply'          => __('Comentario de seguimiento', 'fghmvc'),
      'title_reply_to'       => __('Comentario de seguimiento a %s', 'fghmvc'),
      'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title">',
      'title_reply_after'    => '</h3>',
      'cancel_reply_before'  => ' <small>',
      'cancel_reply_after'   => '</small>',
      'cancel_reply_link'    => __('Cancel reply', 'fghmvc'),
      'label_submit'         => __('Incluir comentario', 'fghmvc'),
      'submit_button'        => '<button id="%2$s" type="submit" class="btn btn-warning" name="%1$s"><i class="fas fa-save"></i> Incluir comentario</button>',
      'submit_field'         => '<div class="form-group text-center text-md-start">%1$s %2$s</div>',
      'format'               => 'xhtml',
   );
   /**
    * **********Fin formato de formulario de búsqueda.
    */

   comment_form($defaults);
   ?>

</div><!-- #comments -->