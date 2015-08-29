<?php

/** 
 * A collection of useful functions to be used in the templates
 * @author Eric Daams
 */


/**
 * Return the currently set value for the given option key
 * @param string $option_key
 * @return mixed
 */
if ( !function_exists( 'hitched_get_option' ) ) {
	function hitched_get_option( $option_key ) {
		$options = get_option('theme_hitched_options');		
		return isset( $options[$option_key] ) ? $options[$option_key] : false;
	}
}

/**
 * Return the initial for the bride/groom
 * @param string $who
 * @return char|false
 */
if ( !function_exists( 'hitched_get_initial' ) ) {
	function hitched_get_initial( $who ) {
		$name = hitched_get_option( $who );
		return $name === false || strlen( $name ) == 0 ? false : $name[0];
	}
}

/**
 * Return the page title
 * @param 
 * @return string
 */
if ( !function_exists( 'hitched_page_title' ) ) {
	function hitched_page_title() {
		global $wp_query;

		if ( is_search() ) {
			return __( 'Search Results', 'hitched' );
		}			

		if ( is_404() ) {
			return __( '404', 'hitched' );
		}

		if ( is_single() && get_post_type() == 'post' && get_post_format() != 'gallery' 			
			|| is_home() 
			|| is_archive() && get_post_type() == 'post' ) {
			return hitched_get_option( 'blog_title' );
		}

		return get_the_title();
	}
}

/**
 * Return page permalik
 * @return string
 */
if ( !function_exists( 'hitched_page_permalink' ) ) {
	function hitched_page_permalink() {
		if ( is_single() && get_post_type() == 'post' ) {
			return '';
		}
	}
}

/**
 * Get template modifier
 * @return sting
 */
if ( !function_exists( 'hitched_get_modifier' ) ) {
	function hitched_get_modifier() {
		global $post; 

		// If it's a post, return the post format. Otherwise return the post type. 
		return get_post_type() == 'post' ? get_post_format() : get_post_type();		
	}
}