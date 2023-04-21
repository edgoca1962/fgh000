<?php

/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password,
 * return early without loading the comments.
 */
if (post_password_required()) {
	return;
}
$required_attribute = '';
$html5 = '';
$post_id = '';
$required_text = '';


$twenty_twenty_one_comment_count = get_comments_number();
?>

<div id="comments" class="comments-area default-max-width <?php echo get_option('show_avatars') ? 'show-avatars' : ''; ?>">

	<?php
	if (have_comments()) :
	?>
		<h2 class="comments-title">
			<?php if ('1' === $twenty_twenty_one_comment_count) : ?>
				<?php esc_html_e('1 comment', 'twentytwentyone'); ?>
			<?php else : ?>
				<?php
				printf(
					/* translators: %s: Comment count number. */
					esc_html(_nx('%s comment', '%s comments', $twenty_twenty_one_comment_count, 'Comments title', 'twentytwentyone')),
					esc_html(number_format_i18n($twenty_twenty_one_comment_count))
				);
				?>
			<?php endif; ?>
		</h2><!-- .comments-title -->

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'avatar_size' => 60,
					'style'       => 'ol',
					'short_ping'  => true,
				)
			);
			?>
		</ol><!-- .comment-list -->

		<?php
		the_comments_pagination(
			array(
				'before_page_number' => esc_html__('Page', 'twentytwentyone') . ' ',
				'mid_size'           => 0,
				'prev_text'          => sprintf(
					'%s <span class="nav-prev-text">%s</span>',
					is_rtl() ? twenty_twenty_one_get_icon_svg('ui', 'arrow_right') : twenty_twenty_one_get_icon_svg('ui', 'arrow_left'),
					esc_html__('Older comments', 'twentytwentyone')
				),
				'next_text'          => sprintf(
					'<span class="nav-next-text">%s</span> %s',
					esc_html__('Newer comments', 'twentytwentyone'),
					is_rtl() ? twenty_twenty_one_get_icon_svg('ui', 'arrow_left') : twenty_twenty_one_get_icon_svg('ui', 'arrow_right')
				),
			)
		);
		?>

		<?php if (!comments_open()) : ?>
			<p class="no-comments"><?php esc_html_e('Comments are closed.', 'twentytwentyone'); ?></p>
		<?php endif; ?>
	<?php endif; ?>

	<?php

	/***************************************************************************
	 * Formato para captura de comentarios de seguimiento
	 **************************************************************************/
	$fields = array(
		'author' => sprintf(
			'<div class="form-group mb-3">%s</div>',
			sprintf(
				'<input id="author" class="form-group" placeholder="Nombre" name="author" type="text" value="%s" maxlength="245"%s />',
				esc_attr($commenter['comment_author']),
				($req ? $required_attribute : '')
			)
		),
		'email'  => sprintf(
			'<div class="form-group mb-3">%s</div>',
			sprintf(
				'<input id="email" class="form-group" placeholder="E-mail" name="email" %s value="%s" maxlength="100" aria-describedby="email-notes"%s />',
				($html5 ? 'type="email"' : 'type="text"'),
				esc_attr($commenter['comment_author_email']),
				($req ? $required_attribute : '')
			)
		),
		'url'    => sprintf(
			'<p class="form-group">%s</p>',
			sprintf(
				'<input id="url" class="form-group" placeholder="Sitio Web" name="url" %s value="%s" maxlength="200" />',
				($html5 ? 'type="url"' : 'type="text"'),
				esc_attr($commenter['comment_author_url'])
			)
		),
	);

	$defaults = array(
		'fields'               => [], //campos adicionales después del comentario.
		'comment_field'        => sprintf(
			'<div class="form-group col-md-6 mb-3"> %s</div>',
			'<textarea id="comment" class="form-control" name="comment" cols="45" rows="8" placeholder="Espacio para incluir su comentario." maxlength="65525"' . $required_attribute . '></textarea>'
		),
		'must_log_in'          => sprintf(
			'<div class="form-group">%s</div>',
			sprintf(
				/* translators: %s: Login URL. */
				__('Tienes que estar <a href="%s">registrado</a> para incluir un comentario.', 'staging'),
				/** This filter is documented in wp-includes/link-template.php */
				wp_login_url(apply_filters('the_permalink', get_permalink($post_id), $post_id))
			)
		),
		'logged_in_as'         => sprintf(
			'<div class="form-group mb-3">%s%s</div>',
			sprintf(
				/* translators: 1: Edit user link, 2: Accessibility text, 3: User name, 4: Logout URL. */
				__('<a href="%1$s" aria-label="%2$s">Comentarista: %3$s</a>'),
				get_edit_user_link(),
				/* translators: %s: User name. */
				esc_attr(sprintf(__('Comentarista: %s. Editar perfil.', 'staging'), $user_identity)),
				$user_identity,
				/** This filter is documented in wp-includes/link-template.php */
				wp_logout_url(apply_filters('the_permalink', get_permalink($post_id), $post_id))
			),
			$required_text
		),
		'comment_notes_before' => sprintf(
			'<p class="comment-notes">%s%s</p>',
			sprintf(
				'<span id="email-notes">%s</span>',
				__('Su email no será publicado.')
			),
			$required_text
		),
		'comment_notes_after'  => '',
		'action'               => site_url('/wp-comments-post.php'),
		'id_form'              => 'commentform',
		'id_submit'            => 'submit',
		'class_container'      => 'comment-respond mb-3',
		'class_form'           => '',
		'class_submit'         => 'btn btn-warning',
		'name_submit'          => 'submit',
		'title_reply'          => __('Comentarios', 'staging'),
		/* translators: %s: Author of the comment being replied to. */
		'title_reply_to'       => __('Respuesta a %s', 'staging'),
		'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title">',
		'title_reply_after'    => '</h3>',
		'cancel_reply_before'  => ' <small>',
		'cancel_reply_after'   => '</small>',
		'cancel_reply_link'    => __('Cancelar respuesta', 'staging'),
		'label_submit'         => __('Incluir comentario', 'staging'),
		'submit_button'        => '<button id="%2$s" type="submit" class="btn btn-warning" name="%1$s"><i class="fas fa-save"></i> Incluir comentario</button>',
		'submit_field'         => '<div class="form-group text-center text-md-start">%1$s %2$s</div>',
		'format'               => 'xhtml',
	);
	//<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />
	/**
	 * **********Fin formato de formulario de búsqueda.
	 */

	comment_form($defaults);
	?>

</div><!-- #comments -->