<footer class="post_meta">					

	<div class="post_date"><?php _e( sprintf( 'Posted by %s on %s', '<a href="'.get_author_posts_url(get_the_author_meta( 'ID' )).'"><i class="icon-user"></i> '.get_the_author().'</a>', get_the_time( get_option('date_format') ) ) ) ?></div>
	<?php if ( comments_open() ) : ?>
		<div class="comments">
			<a href="<?php comments_link() ?>">
				<?php comments_number( 
					sprintf( '<i class="icon-comments"></i> %s', __( 'No comments', 'hitched' )  ), // No comments
					sprintf( '<i class="icon-comment"></i> %s', __( 'One comment', 'hitched' )  ), // One comment
					sprintf( '<i class="icon-comments"></i> %s', _x( '% comments', 'number of comments', 'hitched' )  ) // More than one comment
				) ?>		
			</a>
		</div>	
	<?php endif ?>
	<?php if ( has_tag() ) : ?>
		<div class="tags"><?php the_tags( '<i class="icon-tag"></i> ' ) ?></div>
	<?php endif ?>

</footer>