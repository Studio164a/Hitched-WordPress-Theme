<?php 
/* 
 * Image entry fragment
 */
?>
<div id="post-<?php the_ID() ?>" <?php post_class('post media photo') ?>>

	<?php if ( has_post_thumbnail() ) : ?>
		
		<figure>

			<?php $image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large') ?>	

			<a class="colorbox image_shadow" href="<?php echo $image_url[0] ?>" title="<?php the_title_attribute() ?>">
				<?php the_post_thumbnail('blog_large') ?>
			</a>

			<figcaption>
				<?php the_title() ?>
			</figcaption>

		</figure>

	<?php endif ?>

	<?php get_template_part( 'meta' ) ?>

</div>