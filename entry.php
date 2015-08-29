<!-- Post -->	
<div id="post-<?php the_ID() ?>" <?php post_class('post panel') ?>>					

	<header>
		<h2 class="post_header">
			<a href="<?php the_permalink() ?>"><?php the_title() ?></a>
		</h2>
	</header>

	<div class="entry">			

		<?php the_content() ?>

	</div>

	<?php get_template_part( 'meta' ) ?>

	<div class="waves"></div>	

</div>
<!-- End post -->