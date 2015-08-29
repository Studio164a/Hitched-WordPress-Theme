<?php 
// Get the photos to be displayed in the carousel
$photos = OSFBootstrap::get_instance()->get_carousel_photos();

// If there are photos, loop over them
if ( count( $photos ) ) : ?>
	<ul class="gallery medium carousel colorbox_gallery" id="photos">
		<?php foreach ( $photos as $photo ) : ?>
			<li><a href="<?php echo $photo->guid ?>"><?php echo wp_get_attachment_image( $photo->ID, 'carousel_medium' ) ?></a></li>
		<?php endforeach ?>
	</ul>
<?php endif ?>

<?php 
// Reset the global $post variable
wp_reset_postdata() ?>