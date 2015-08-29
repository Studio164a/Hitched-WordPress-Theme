<?php 
/**
 * First panel
 */
if ( !function_exists('osfa_homepage_panel_1_metabox') ) {
	function osfa_homepage_panel_1_metabox( $post ) {
		// Nonce field for validation purposes
		wp_nonce_field( 'hitched_homepage_settings', '_hitched_nonce' );

		// Content editor
		wp_editor( $post->post_content, 'hitched_home_panel_1', array( 'textarea_name' => 'content' ) );
	}
}

/**
 * Second panel
 */
if ( !function_exists('osfa_homepage_panel_2_metabox') ) {
	function osfa_homepage_panel_2_metabox( $post ) {
		// Editor
		$content = get_post_meta( $post->ID, 'content_panel_two', true );		
		wp_editor( $content, 'hitched_home_panel_2', array( 'textarea_name' => 'content_panel_two' ) );
	}
}

/**
 * Carousel metabox
 */
if ( !function_exists('osfa_homepage_carousel_metabox') ) {
	function osfa_homepage_carousel_metabox( $post ) {
		$galleries = get_posts( array(
            'post_type' => 'gallery', 
            'post_status' => 'publish',
            'orderby' => 'title', 
            'posts_per_page' => -1,
            'order' => 'ASC',
        ));

        $selected = get_post_meta( $post->ID, 'carousel_gallery_id', true );
		
		if ( count( $galleries ) ) : ?>

			<p><?php printf( __( 'Select which gallery you would like to use for the carousel, or %screate a new gallery%s.', 'hitched' ),
				'<a href="'.admin_url( "post-new.php?post_type=gallery" ).'">', '</a>' ) ?>
			 </p>
			<select name="carousel_gallery_id">
	            <?php foreach ( $galleries as $gallery ) : ?>
	            <option value="<?php echo $gallery->ID ?>"<?php selected( $gallery->ID, $selected ) ?>><?php echo $gallery->post_title ?></option>
	            <?php endforeach ?>
	        </select>

        <?php else : ?>

        	<p><?php printf( __( 'It looks like you haven\'t created any galleries yet. %sCreate one now%s', 'hitched'), 
	        	'<a href="'.admin_url( "post-new.php?post_type=gallery" ).'">', '</a>' ) ?>
        	</p>

        <?php endif;
	}
}

/**
 * Slider metabox
 */
if ( !function_exists('osfa_homepage_slider_metabox') ) {
	function osfa_homepage_slider_metabox( $post ) {
		$galleries = get_posts( array(
            'post_type' => 'gallery', 
            'post_status' => 'publish',
            'orderby' => 'title', 
            'posts_per_page' => -1, 
            'order' => 'ASC',
        ));

        $selected = get_post_meta( $post->ID, 'slider_gallery_id', true );
		
		if ( count( $galleries ) ) : ?>

			<p><?php printf( __( 'Select which gallery you would like to use for the homepage slider, or %screate a new gallery%s.', 'hitched' ),
				'<a href="'.admin_url( "post-new.php?post_type=gallery" ).'">', '</a>' ) ?>
			</p>

			<select name="slider_gallery_id">
	            <?php foreach ( $galleries as $gallery ) : ?>
	            <option value="<?php echo $gallery->ID ?>"<?php selected( $gallery->ID, $selected ) ?>><?php echo $gallery->post_title ?></option>
	            <?php endforeach ?>
	        </select>

        <?php else : ?>

			<p><?php printf( __( 'It looks like you haven\'t created any galleries yet. %sCreate one now%s', 'hitched'), 
	        	'<a href="'.admin_url( "post-new.php?post_type=gallery" ).'">', '</a>' ) ?>
        	</p>

        <?php endif;
	}
}