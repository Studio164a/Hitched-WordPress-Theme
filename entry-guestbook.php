<?php 
/* 
 * Guestbook entry fragment
 */
?>
<!-- Page -->	
<div id="post-<?php the_ID() ?>" <?php post_class('post panel') ?>>

	<div class="entry">					

		<?php the_content() ?>

		<?php comments_template( '/comments-guestbook.php', true ); ?>

	</div>

	<?php get_template_part( 'meta', 'page' ) ?>

	<div class="waves"></div>					

</div>
<!-- End page entry -->