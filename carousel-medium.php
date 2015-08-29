<?php global $post;

// Get photos
$photos = get_posts( array(
    'post_type' => 'attachment',
    'posts_per_page' => -1,
    'post_status' => null,
    'post_parent' => $post->ID,
    'orderby' => 'menu_order',
    'order' => 'ASC'        
) );

// Iterate through photos
if ( count( $photos ) ) : ?>
	<ul class="gallery medium carousel colorbox_gallery" id="photos">		
		<?php foreach ( $photos as $photo ) : ?>
			<li><a href="<?php echo $photo->guid ?>"><?php echo wp_get_attachment_image( $photo->ID, 'carousel_medium' ) ?></a></li>
		<?php endforeach ?>
	</ul>
<?php endif ?>