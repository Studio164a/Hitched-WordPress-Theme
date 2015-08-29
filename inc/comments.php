<?php
/**
 * Filters and function to customize the post comments area
 */


/**
 * Customize comment form default fields
 * @uses comment_form_field_comment filter
 * @param string $field
 * @return string
 */
if ( !function_exists( 'osfa_comment_form_field_comment') ) {
	function osfa_comment_form_default_fields( $fields ) {
		//echo '<pre>'; print_r( $fields ); echo '</pre>';
		$fields = '
		<div class="required" tabindex="1">
			<input type="text" name="author" id="commenter_name" required />
			<label for="author">Name</label>
		</div>
		<div class="required" tabindex="2">
			<input type="email" name="email" id="commenter_email" required />
			<label for="email">Email</label>																	
		</div>
		<div tabindex="3">
			<input type="text" name="url" id="commenter_url" />
			<label for="url">Website</label>																	
		</div>
		';
		return $fields;
	}

	add_filter( 'comment_form_default_fields', 'osfa_comment_form_default_fields', 10, 2 );
}

/**
 * Customize comment output
 * @param 
 * @param array $args
 * @param 
 * @return string
 */
if ( !function_exists( 'osfa_comment' ) ) {
	function osfa_comment( $comment, $args, $depth ) {
		global $post;

		// if ( $post->post_type == 'page' && get_page_tempate() )

		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
		?>

		<li class="pingback">
			<p><?php _e( 'Pingback:', 'hitched' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'hitched' ), '<span class="edit-link">', '</span>' ); ?></p>
		</li>
		
		<?php	
				break;
			default :
		?>

		<li <?php comment_class() ?> id="li-comment-<?php comment_ID(); ?>">

			<?php echo get_avatar( $comment, 50 ) ?>

			<div class="comment_details">
				<h6 class="comment_author vcard"><?php comment_author_link() ?></h6>
				<p class="comment_meta">
					<span class="comment_date"><?php printf( '<i class="icon-comment"></i> %1$s %2$s %3$s', get_comment_date(), _x( 'at', 'comment post on date at time', 'hitched'), get_comment_time() ) ?></span>
					<span class="comment_reply"><?php comment_reply_link( array_merge( $args, array( 'reply_text' => sprintf( '<i class="icon-pencil"></i> %s', _x( 'Reply', 'reply to comment' , 'hitched' ) ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ) ?></span>
				</p>
				<div class="comment_text"><?php comment_text() ?></div>
			</div>		

		</li>

		<?php
				break;
		endswitch;	
	}
}

/**
 * Customize guestbook comment
 *
 * @param 
 * @param array $args
 * @param 
 * @return string
 */
if ( !function_exists( 'osfa_comment_guestbook' ) ) {
	function osfa_comment_guestbook( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;

		// Don't display pingbacks or trackbacks
		if ( in_array( $comment->comment_type, array( 'pingback', 'trackback' ) ) )
			return;

		?>
		<li <?php comment_class() ?> id="li-comment-<?php comment_ID(); ?>">

			<?php //echo get_avatar( $comment, 50 ) ?>

			<blockquote>
				<?php comment_text() ?>
				<cite><?php comment_author_link() ?></cite>
			</blockquote>

		</li>

		<?php
	}
}