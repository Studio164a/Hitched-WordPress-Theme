<?php 
// Get the photos to be displayed in the carousel
$slides = OSFBootstrap::get_instance()->get_slider_photos() ?>

<div class="slider">

	<?php 
	// If there are photos, loop over them
	if ( count( $slides ) ) : ?>
		<ul class="rslides">
			<?php foreach ( $slides as $slide ) : ?>
				<li><?php echo wp_get_attachment_image( $slide->ID, 'slider' ) ?></li>
			<?php endforeach ?>
		</ul>
	<?php endif ?>

</div>

<?php
// Reset the global $post variable
wp_reset_postdata() ?>