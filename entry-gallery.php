<?php 
/* 
 * Gallery template in archive
 */

// Get photos
$photos = get_posts( array(
    'post_type' => 'attachment',
    'posts_per_page' => -1,
    'post_status' => null,
    'post_parent' => $post->ID,
    'orderby' => 'menu_order',
    'order' => 'ASC'        
) );
?>
<div id="post-<?php the_ID() ?>" <?php post_class('post media') ?>>

	<header>
		<a href="<?php the_permalink() ?>"><h2 class="post_header"><?php the_title() ?></h2></a>
	</header>

	<div class="entry">

		<?php the_content() ?>

	</div>

	<?php get_template_part( 'meta' ) ?>

</div>