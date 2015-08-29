<?php 
/**
 * Quote entry template. 
 */
?>

<div id="post-<?php the_ID() ?>" <?php post_class('post quote') ?>>

	<div class="entry">

		<blockquote>
			<h2><?php the_content() ?></h2>
		</blockquote>
		
		<p class="stated_by"><?php the_title() ?></p>

	</div>

	<?php get_template_part( 'meta' ) ?>

</div>