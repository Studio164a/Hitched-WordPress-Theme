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
	<ul class="gallery fullwidth carousel colorbox_gallery" id="photos"  data-buttons-position="inside center">		
		<?php foreach ( $photos as $photo ) : ?>
			<li><a href="<?php echo $photo->guid ?>"><?php echo wp_get_attachment_image( $photo->ID, 'carousel_large' ) ?></a></li>
		<?php endforeach ?>
	</ul>
<?php endif ?>