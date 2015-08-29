<?php
/**
 * Custom editor styles for Hitched. 
 * Based on the plugin provided on WPTuts: http://wp.tutsplus.com/tutorials/theme-development/adding-custom-styles-in-wordpress-tinymce-editor/
 * That plugin was in turn based on TinyMCE Kit plug-in for WordPress: http://plugins.svn.wordpress.org/tinymce-advanced/branches/tinymce-kit/tinymce-kit.php
 */

class OSFEditorStyles {

    /**
     * Stores instance of class.
     * @var OSFEditorStyles
     */
    private static $instance = null;

    /**
     * Private constructor. Singleton pattern.      
     */
    private function __construct() {
    	add_editor_style( 'media/css/editor-styles.css?0.1' );

    	add_filter( 'mce_buttons', array(&$this, 'mce_buttons') );    	
    	add_filter( 'mce_buttons_2', array(&$this, 'mce_buttons_2') );
    	add_filter( 'mce_external_plugins', array(&$this, 'mce_external_plugins') );
    	add_filter( 'tiny_mce_before_init', array(&$this, 'tiny_mce_before_init') );
    }

    /**
     * Get class instance
     * @static
     * @return OSFEditorStyles
     */
    public static function get_instance() {
        if (is_null(self::$instance)) {
          self::$instance = new OSFEditorStyles();
        }
        return self::$instance;
    } 

	/**
	 * Add buttons to the first row
	 * @param array $buttons
	 * @return array
	 */
	function mce_buttons( $buttons ) {
		array_push( $buttons, "hr" );
		return $buttons;
	}

	/**
	 * Add buttons on the second row
	 * @param array $buttons
	 * @return array
	 */
	function mce_buttons_2( $buttons ) {
		array_unshift( $buttons, 'styleselect' );
		array_push( $buttons, 'buttons' );
		return $buttons;
	}

	/**
	 * Add buttons plugin for TinyMCE
	 * @param array $plugin_array
	 * @return array
	 */
	public function mce_external_plugins( $plugin_array ) {
		$plugin_array['buttons'] = get_template_directory_uri() . '/inc/tinymce/editor-styles.js';;
		return $plugin_array;
	}

	/**
	 * Add styles/classes to the "Styles" drop-down
	 * @param array $settings
	 * @return array
	 */	
	function tiny_mce_before_init( $settings ) {
	    $style_formats = array(
	    	array(
	    		'title' => 'Header font variation',
	    		'selector' => 'h1,h2,h3,h4,h5,h6',
	    		'classes' => 'alt'
	    	),
	        array(
	            'title' => 'Header with underline',
	            'selector' => 'h1,h2,h3,h4,h5,h6',
	            'classes' => 'underline'
	        ),
	        array(
	            'title' => 'Header with overline',
	            'selector' => 'h1,h2,h3,h4,h5,h6',
	            'classes' => 'overline'
	        ),
	        array(
	        	'title' => 'Section header',
	        	'selector' => 'h1,h2,h3,h4,h5,h6',
	        	'classes' => 'section_label'
	        ),
	        array(
	            'title' => 'Horizontal list',
	            'selector' => 'ul',
	            'classes' => 'horizontal', 
	            'wrapper' => true
	        ),
	        array(
	            'title' => 'List with icons',
	            'selector' => 'ul',
	            'classes' => 'icons'
	        ), 
	        array(
	        	'title' => 'Centered list',
	        	'selector' => 'ul,ol',
	        	'classes' => 'centered'
	        ),
	        array(
	        	'title' => 'Intro paragraph',
	        	'selector' => 'p', 
	        	'classes' => 'intro'
	        ),
	        array(
	        	'title' => 'Left aligned blockquote',
	        	'selector' => 'blockquote',
	        	'classes' => 'float_left'
	        ),
	        array(
	        	'title' => 'Right aligned blockquote',
	        	'selector' => 'blockquote',
	        	'classes' => 'float_right'
	        )
	    );
	    $settings['style_formats'] = json_encode( $style_formats );
	    return $settings;
	}
}