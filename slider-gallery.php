<?php global $post;

$slides = get_posts( array(
    'post_type' => 'attachment',
    'posts_per_page' => -1,
    'post_status' => null,
    'post_parent' => $post->ID,
    'orderby' => 'menu_order',
    'order' => 'ASC'        
) );
?>

<div class="slider">
	<?php if ( count( $slides ) ) : ?>
		<ul class="rslides colorbox_gallery">
			<?php foreach ( $slides as $slide ) : ?>
				<li>
					<a class="image_shadow" href="<?php echo $slide->guid ?>" title="<?php echo $slide->post_title ?>"><?php echo wp_get_attachment_image( $slide->ID, 'blog_large' ) ?></a>
				</li>
			<?php endforeach ?>
		</ul>
	<?php endif ?>
</div>