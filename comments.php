<?php
?>
	<div class="comments_section">
	<?php if ( post_password_required() ) : ?>
		<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'hitched' ); ?></p>
	</div><!-- #comments -->
	<?php
			/* Stop the rest of comments.php from being processed,
			 * but don't kill the script entirely -- we still have
			 * to fully load the template.
			 */
			return;
		endif;
	?>

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h3>
			<?php
				printf( _n( '<i class="icon-comment"></i> One comment', '<i class="icon-comments"></i> %1$s comments', get_comments_number(), 'hitched' ),
					number_format_i18n( get_comments_number() ) );
			?>
		</h2>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-above">
			<h1 class="assistive-text"><?php _e( 'Comment navigation', 'hitched' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'hitched' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'hitched' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

		<ol class="comments_list">
			<?php
				/* Loop through and list the comments. Tell wp_list_comments()
				 * to use hitched_comment() to format the comments.
				 * If you want to overload this in a child theme then you can
				 * define hitched_comment() and that will be used instead.
				 * See hitched_comment() in hitched/functions.php for more.
				 */
				wp_list_comments( array( 'callback' => 'osfa_comment' ) );
			?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below">
			<h1 class="assistive-text"><?php _e( 'Comment navigation', 'hitched' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'hitched' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'hitched' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

	<?php
		/* If there are no comments and comments are closed, let's leave a little note, shall we?
		 * But we don't want the note on pages or post types that do not support comments.
		 */
		elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="nocomments"><?php _e( 'Comments are closed.', 'hitched' ); ?></p>
	<?php endif; ?>

	<?php comment_form( array( 
		'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',	
		'title_reply' => sprintf( '<i class="icon-comment"></i> %s', __( 'Leave a comment', 'hitched' ) ), 
		'label_submit' => _x( 'Submit', 'post comment', 'hitched' )
	) ) ?>

</div><!-- #comments -->
