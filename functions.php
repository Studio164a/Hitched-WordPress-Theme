<?php 
/**
 * Bootstraps the theme and all its associated functionality. 
 * 
 * This class can only be instantiated once and cannot be extended.
 * 
 * @author Eric Daams <eric@ericnicolaas.com>
 * @final
 */

class OSFBootstrap {
  
    /**
    * Stores instance of class.
    * @var OSFBootstrap
    */
    private static $instance = null;

    /**
    * CSS folder
    * @var string
    */
    private $css_dir;

    /**
    * JS folder
    * @var string
    */
    private $js_dir;

    /**
    * Includes folder
    * @var string
    */
    private $inc_dir;

    /**
     * Theme database version
     * @var string
     */
    private $theme_db_version;

    /**
    * Private constructor
    * @access private
    */
    private function __construct() { 
        $base_dir = get_theme_root() . '/hitched/media';
        $this->css_dir = $base_dir . '/css/';
        $this->js_dir = $base_dir . '/js/';
        $this->inc_dir = get_theme_root() . '/hitched/inc/';            

        // Load extra files
        $this->load_files();

        // Check for theme update
        $this->theme_db_version = mktime(23,04,0,3,1,2013);
        $this->version_update();
        
        // Hooks
        add_action('init', array(&$this, 'init'));
        add_action('wp_head', array(&$this, 'wp_head'));
        add_action('save_post', array(&$this, 'save_meta'), 1, 2);
        add_action('admin_menu', array(&$this, 'admin_menu'));    
        add_action('admin_enqueue_scripts', array(&$this, 'admin_enqueue_scripts') );
        add_action('widgets_init', array(&$this, 'widgets_init'), 15); // Runs after widgets_init is usually run
        add_action('wp_footer', array(&$this, 'wp_footer'));
        add_action('after_setup_theme', array(&$this, 'after_setup_theme'));
        add_action('admin_init', array(&$this, 'admin_init'));
        add_action('add_meta_boxes', array(&$this, 'add_meta_boxes'));
          
        if (!is_admin()) {
            add_action('wp_enqueue_scripts', array(&$this, 'load_scripts_and_styles'));
        }

        add_action('in_widget_form', array(&$this, 'widget_form'), 10, 3);

        // Filters
        add_filter('after_setup_theme',array(&$this, 'theme_setup'));
        add_filter('body_class', array(&$this, 'body_classes'));
        add_filter('wp_title', array(&$this, 'wp_title'), 10, 3 );
        add_filter('the_content_more_link', array(&$this, 'the_content_more_link'), 10, 2);
        add_filter('dynamic_sidebar_params',array(&$this, 'dynamic_sidebar_params'));
        add_filter('widget_update_callback', array(&$this, 'widget_update_callback'), 10, 3);

        if ( class_exists('Tribe_Image_Widget') ) {
            add_filter('sp_template_image-widget_widget.php', array(&$this, 'image_widget_filter'));
        }        

        // Add Grid Columns support, with backwards compatibility
        if ( class_exists('Grid_Columns') ) {
            include_once('inc/grid-columns.php');
        }

        add_filter( 'visual-form-builder-css', '__return_false' );        

        // Shortcodes        
        add_shortcode('button', 'osfa_button_shortcode');        
        add_shortcode('recent_posts', 'osfa_recent_posts_shortcode');
        add_shortcode('flickr', 'osfa_flickr_shortcode');
        add_shortcode('instagram', 'osfa_instagram_shortcode');

        // This is not technically a shortcode, but it's overriding the 
        // in-built Wordpress shortcode for generating gallery templates
        add_filter('post_gallery', 'osfa_gallery_shortcode', 10, 2);        
    }

    /**
     * Get class instance
     * @static
     * @return OSFBootstrap
     */
    public static function get_instance() {
        if (is_null(self::$instance)) {
          self::$instance = new OSFBootstrap();
        }
        return self::$instance;
    } 

    /**
     * Load library files
     * @access private
     */
    private function load_files() {    
        $files = array(
            'admin/OSFAdminPage.class.php',
            'twitter/widget.php',
            'twitter/twitteroauth/twitteroauth.php',
            'widgets/flickr.php',
            'widgets/instawidget.php',
            'shortcodes.php',
            'metaboxes.php', 
            'template-tags.php',
            'comments.php', 
            'flickr.php',
            'instagram.php'
        );

        foreach ($files as $file) {
          require_once($this->inc_dir . $file);
        }
    }

    /**
     * Check for plugin version update
     */
    public function version_update() {
        // Check whether we are updated to the most recent version
        $db_version = get_option('hitched_db_version');
        if ( $db_version === false || $db_version < $this->theme_db_version ) {                
            require_once('inc/upgrade.php');        
            OSFUpgradeHelper::do_upgrade($this->theme_db_version, $db_version);
            update_option('hitched_db_version', $this->theme_db_version);
        }    
    }    
    
    /**
    * Runs on init hook
    * @return void
    */
    public function init() {
        if ( isset( $_POST['hitched_rsvp'] ) ) {
            $this->rsvp_form_submission();
        }

        $labels = array(
            'name' => _x( 'Galleries', 'post type general name', 'hitched' ),
            'singular_name' => _x( 'Gallery', 'post type singular name', 'hitched' ),
            'add_new' => _x( 'Add New', 'gallery', 'hitched' ),
            'add_new_item' => __( 'Add New Gallery', 'hitched' ),
            'edit_item' => __( 'Edit Gallery', 'hitched' ),
            'new_item' => __( 'New Gallery', 'hitched' ),
            'all_items' => __( 'All Galleries', 'hitched' ),
            'view_item' => __( 'View Gallery', 'hitched' ),
            'search_items' => __( 'Search Galleries', 'hitched' ),
            'not_found' =>  __( 'No galleries found', 'hitched' ),
            'not_found_in_trash' => __( 'No galleries found in Trash', 'hitched' ), 
            'parent_item_colon' => '',
            'menu_name' => __( 'Galleries', 'hitched' )

        );
        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true, 
            'show_in_menu' => true, 
            'query_var' => true,
            'rewrite' => array( 'slug' => _x( 'gallery', 'URL slug', 'hitched' ) ),
            'capability_type' => 'post',
            'has_archive' => true, 
            'hierarchical' => false,
            'menu_position' => null,
            'supports' => array( 'title', 'editor', 'author', 'thumbnail' )
        ); 

        register_post_type('gallery', $args);
    }

    /**
     * Runs on admin_init hook
     * @return void
     */
    public function admin_init() {
        global $pagenow;

        $this->admin_page = new OSFAdminPage();

        // Register Hitched settings object
        register_setting( 'theme_hitched_options', 'theme_hitched_options', array( $this->admin_page, 'validate' ) );

        if ( 'themes.php' == $pagenow && isset( $_GET['page'] ) && 'hitched-options' == $_GET['page'] ) {
            $this->admin_page->get_general_tab();
        }

        // Load custom editor styles
        require_once($this->inc_dir . 'editor-styles.php');
        $editor = OSFEditorStyles::get_instance();
    }

    /**
     * Action performed after theme is set up, but before init is called
     * @return void
     */
    public function after_setup_theme() {
        // Set up theme supports
        add_theme_support( 'post-formats', array( 'image', 'quote', 'gallery' ) );

        // Carousel
        add_image_size( 'blog_large', 570 );
        add_image_size( 'slider', 912, 345, true );
        add_image_size( 'carousel_medium', 204 );
        add_image_size( 'carousel_large', 440 );
        add_image_size( 'gallery_large', 440 );
        add_image_size( 'gallery_medium', 204 );
        add_image_size( 'gallery_thumbnail', 137 );
        
        // Set up theme options
        $this->options = get_option( 'theme_hitched_options' );    
        if ( false === $this->options ) {
            $this->options = $this->get_default_theme_options();
        }

        update_option( 'theme_hitched_options', $this->options );
    }

    /**
    * Enqueue stylesheets
    * @return void
    */
    public function load_scripts_and_styles() {    
        $options = get_option( 'theme_hitched_options', array() );
        $options['theme'] = isset( $options['theme'] ) ? $options['theme'] : 'charcoal_peach';
        
        // Theme directory
        $theme_dir = get_template_directory_uri();

        // Stylesheets
        $sheets = array( 'common', 'form', 'colorbox', $options['theme'] );

        // First load style.css
        wp_register_style('reset', get_bloginfo('stylesheet_url'));
        wp_enqueue_style('reset');

        // Register and enqueue all other stylesheets        
        foreach ($sheets as $sheet) {
            wp_register_style( $sheet, sprintf( "%s/media/css/%s.css", $theme_dir, $sheet ) );
            wp_enqueue_style( $sheet );
        }            

        // Scripts
        wp_register_script('flexNav', sprintf( "%s/media/js/jquery.flexnav.js", $theme_dir ), array('jquery'), 0.1, true);        
        wp_register_script('imageHover', sprintf( "%s/media/js/jquery.imageHover.js", $theme_dir ), array('jquery'), 0.1, true);
        wp_register_script('colorbox', sprintf( "%s/media/js/jquery.colorbox.min.js", $theme_dir ), array('jquery'), 0.1, true);
        wp_register_script('dropdownMenu', sprintf( "%s/media/js/jquery.dropdownmenu.js", $theme_dir ), array('jquery'), 0.1, true);
        wp_register_script('carouselSwipe', sprintf( "%s/media/js/jquery.carouselSwipe.js", $theme_dir ), array('jquery'), 0.1, true);
        wp_register_script('responsiveSlides', sprintf( "%s/media/js/responsiveslides.min.js", $theme_dir ), array('jquery'), 0.1, true );
        wp_register_script('hitchedJs', sprintf( "%s/media/js/hitched.js", $theme_dir ), array('jquery'), 0.1, true);        

        foreach ( array( 'flexNav', 'hoverIntent', 'imageHover', 'colorbox', 'dropdownMenu', 'carouselSwipe', 'responsiveSlides', 'hitchedJs' ) as $script ) {
            wp_enqueue_script( $script );
        }
    }

    /**
    * Save meta
    * @return void
    */
    public function save_meta($post_id, $post) {
        // Verify if this is an auto save routine. 
        // If it is our form has not been submitted, so we dont want to do anything
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
          return;

        // Save custom fields for homepage
        if ( isset( $_POST['post_type'] ) ) {

            $post_type = $_POST['post_type'];

            if ( 'page' == $post_type ) {

                if ( isset( $_POST['page_template'] ) && 'homepage.php' == $_POST['page_template'] ) {

                    // Verify this came from the our screen and with proper authorization,
                    // because save_post can be triggered at other times
                    if ( !array_key_exists('_hitched_nonce', $_POST ) || !wp_verify_nonce( $_POST['_hitched_nonce'], 'hitched_homepage_settings' ) )
                      return;

                    // Ensure current user can edit pages
                    if ( !current_user_can( 'edit_page', $post_id ) )
                        return;

                    foreach ( array( 'content_panel_two', 'slider_gallery_id', 'carousel_gallery_id' ) as $meta_key ) {
                        $meta_value = isset( $_POST[$meta_key] ) ? $_POST[$meta_key] : false;
                        update_post_meta( $post_id, $meta_key, $meta_value );
                    }
                }    
            }     
            
            elseif ( 'gallery' == $post_type || ( isset( $_POST['post_format'] ) && 'gallery' == $_POST['post_format'] ) ) {
                // Verify this came from the our screen and with proper authorization,
                // because save_post can be triggered at other times
                if ( !array_key_exists('_hitched_nonce', $_POST ) || !wp_verify_nonce( $_POST['_hitched_nonce'], 'hitched_gallery_settings' ) )
                  return;

                // Ensure current user can edit pages
                if ( !current_user_can( 'edit_page', $post_id ) )
                    return;

                foreach ( array( 'gallery_size', 'lightbox_slideshow' ) as $meta_key ) {
                    $meta_value = isset( $_POST[$meta_key] ) ? $_POST[$meta_key] : false;
                    update_post_meta( $post_id, $meta_key, $meta_value );
                }
            }
        }
    }

    /**
    * Add admin menu items
    * @return void
    */
    public function admin_menu() {   
        $this->admin_page = new OSFAdminPage();         
        $page = add_theme_page('Hitched Options', 'Hitched Theme Settings', 'edit_theme_options', 'hitched-options', array( $this->admin_page, 'display' ) );
    }

    /**
    * Fired on admin_init hook
    * @return void
    */
    public function admin_enqueue_scripts( $hook ) {
        if ( in_array( $hook, array( 'post.php', 'widgets.php' ) ) ) {
            wp_register_script('OSFAdminJs', get_template_directory_uri().'/inc/admin/admin.js', array('jquery'));
            wp_enqueue_script('OSFAdminJs');
        }        

        wp_register_style('OSFAdminCss', get_template_directory_uri().'/inc/admin/admin.css');
        wp_enqueue_style('OSFAdminCss');
    }  

    /**
    * Theme setup. Executed on after_setup_theme hook
    */
    public function theme_setup() {
        // Set up localization
        load_theme_textdomain( 'hitched', get_template_directory() . '/languages' );

        // Enable post thumbnail support
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(190, 120, true);

        // Add automatic feed links
        add_theme_support( 'automatic-feed-links' );

        // Register menu
        register_nav_menus(array(
            'primary_navigation' => 'Primary Navigation'
        ));
    }    

    /**
     * Add meta boxes
     */
    public function add_meta_boxes() {
        global $pagenow;        

        // Only apply to post/page edits
        if ( $pagenow == 'post.php') {

            $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
            $template_file = get_post_meta( $post_id, '_wp_page_template', true );
            $post_format = get_post_format( $post_id );

            // Custom metabox setup for homepage template
            if ( $template_file == 'homepage.php' ) {

                add_meta_box( 'homepage_panel_1', __( 'First Panel', 'hitched' ), 'osfa_homepage_panel_1_metabox', 'page', 'normal', 'high' );
                add_meta_box( 'homepage_panel_2', __( 'Second Panel', 'hitched' ), 'osfa_homepage_panel_2_metabox', 'page', 'normal', 'high' );
                add_meta_box( 'homepage_carousel', __( 'Carousel', 'hitched' ), 'osfa_homepage_carousel_metabox', 'page', 'normal', 'high' );
                add_meta_box( 'homepage_slider', __( 'Slider', 'hitched' ), 'osfa_homepage_slider_metabox', 'page', 'normal', 'high' );            

                remove_post_type_support('page', 'editor');
                remove_meta_box( 'commentsdiv' , 'page' , 'normal' );
                remove_meta_box( 'commentstatusdiv' , 'page' , 'normal' );
                remove_meta_box( 'postimagediv', 'page', 'side' );
            }
        }    
    }

    /**
    * Executed on widgets_init hook
    */
    public function widgets_init() {
           
        // Primary sidebar
        register_sidebar( array(
            'name' => __( 'Blog Sidebar', 'hitched' ),
            'id' => 'sidebar',
            'before_widget' => '<div id="%1$s" class="widget panel %2$s">',
            'after_widget' => '<div class="waves"></div></div>',
            'before_title' => '<header><h3 class="widget_title">',
            'after_title' => '</h3></header>'
        ));

        // Register custom widgets
        register_widget('OSF_Flickr_Widget');
        register_widget('OSFA_Twitter_Widget');        
        register_widget('OSFA_Insta_Widget');
    }  

    /** 
     * Appended to all widgets
     * @return void
     */
    public function widget_form($widget, $return, $instance) { 
        ?>
        <p class="widget_bg_style">
            <label for="<?php echo $widget->get_field_id('style') ?>"><?php _e('Background style:', 'hitched') ?></label>
            <select name="<?php echo $widget->get_field_name('style') ?>">
                <option value="open" <?php selected( isset( $instance['style'] ) && $instance['style'], 'open') ?>><?php _e('Open', 'hitched') ?></option>
                <option value="panel" <?php selected( isset( $instance['style'] ) && $instance['style'], 'panel') ?>><?php _e('Panel', 'hitched') ?></option>
            </select>
        </p>
        <?php if ( !is_a( $widget, 'Tribe_Image_Widget' ) ) : ?>
            <p class="widget_bordered">
                <label for="<?php echo $widget->get_field_id('bordered') ?>">
                    <input type="checkbox" name="<?php echo $widget->get_field_name('bordered') ?>" <?php checked( isset( $instance['bordered'] ) && $instance['bordered'], 'on' ) ?> />
                    <?php _e('Apply bottom border', 'hitched') ?>
                </label>
            </p>        
        <?php
        endif;
    }
  
    /**
    * Executed on wp_head hook
    */
    public function wp_head() {      
        $template_directory = get_template_directory_uri();        
        ?>          
        <link rel="stylesheet" type="text/css" media="screen and (max-width: 600px)" href="<?php echo $template_directory ?>/media/css/mobile.css" />        
        <link rel="stylesheet" type="text/css" media="screen and (min-width: 601px)" href="<?php echo $template_directory ?>/media/css/default.css" />
        <link rel="stylesheet" type="text/css" media="screen and (max-width: 700px)" href="<?php echo $template_directory ?>/media/css/small.css" />  
        <link href='http://fonts.googleapis.com/css?family=Bitter:400,400italic,700|Sofia' rel='stylesheet' type='text/css'> 

        <!-- Adaptive Images -->
        <script>document.cookie='resolution='+Math.max(screen.width,screen.height)+'; path=/';</script>    

        <!--[if lt IE 9]>
            <script src="<?php echo $template_directory ?>/media/js/html5shiv.js" type="text/javascript"></script>
            <script src="<?php echo $template_directory ?>/media/js/selectivizr-min.js" type="text/javascript"></script>
            <script src="<?php echo $template_directory ?>/media/js/PIE.js" type="text/javascript"></script>
            <link rel="stylesheet" type="text/css" media="all" href="<?php echo $template_directory ?>/media/css/default.css" />
            <link rel="stylesheet" type="text/css" media="all" href="<?php echo $template_directory ?>/media/css/ie8.css" />
        <![endif]-->        
        <?php 
    }
  
    /**
    * Executed on wp_footer hook
    * @return void
    */
    public function wp_footer() {   
        $options = get_option( 'theme_hitched_options' ); 
        echo stripslashes($options['analytics']);  
    }
  
    /**
    * Filters the body classes
    * @return string
    */
    public function body_classes($classes) {
        $options = get_option( 'theme_hitched_options' );
        $classes[] = $options['bg_pattern'] ? $options['bg_pattern'] : '';
        return $classes;
    }

    /**
     * Filters the wp_title output
     * @return string
     */
    public function wp_title($title, $sep, $seplocation) {
        // account for $seplocation
        $left_sep = ( $seplocation != 'right' ? ' ' . $sep . ' ' : '' );
        $right_sep = ( $seplocation != 'right' ? '' : ' ' . $sep . ' ' );
     
        // get special page type (if any)
        if( is_category() ) $page_type = $left_sep . 'Category' . $right_sep;
        elseif( is_tag() ) $page_type = $left_sep . 'Tag' . $right_sep;
        elseif( is_author() ) $page_type = $left_sep . 'Author' . $right_sep;
        elseif( is_archive() || is_date() ) $page_type = $left_sep . 'Archives'. $right_sep;
        else $page_type = '';
     
        // get the page number
        if( get_query_var( 'paged' ) ) $page_num = $left_sep. get_query_var( 'paged' ) . $right_sep; // on index
        elseif( get_query_var( 'page' ) ) $page_num = $left_sep . get_query_var( 'page' ) . $right_sep; // on single
        else $page_num = '';
     
        // concoct and return title
        if( !is_feed() ) return get_bloginfo( 'name' ) . $page_type . $title . $page_num;
        else return $old_title;
    }    

    /**
     * Filters the "more" link on post archives
     * @return string
     */
    public function the_content_more_link($more_link, $more_link_text) {
        return str_replace( $more_link_text, __( 'Read More', 'hitched' ), $more_link );
    }

    /**
     * Filters the widget parameters
     * @return string
     */
    public function dynamic_sidebar_params($params) {
        global $wp_registered_widgets;

        $widget_arr = $wp_registered_widgets[$params[0]['widget_id']];
        $widget = $widget_arr['callback'][0];
        $instances = $widget->get_settings();
        $instance = $instances[$params[1]['number']];

        if ( isset( $instance['style'] ) && $instance['style'] == 'open' ) {

            $replace = 'open';

            // Check if widget should be borderless
            if ( isset( $instance['bordered'] ) && $instance['bordered'] === false ) {
                $replace .= ' borderless';
            }

            $params[0]['before_widget'] = str_replace( 'panel', $replace, $params[0]['before_widget'] );
            $params[0]['after_widget'] = str_replace( '<div class="waves"></div>', '', $params[0]['after_widget'] );
        }        

        return $params;
    }

    /**
     * Filters the widget update
     * @return array
     */
    public function widget_update_callback($instance, $new_instance, $old_instance) {        
        $instance['style'] = isset( $new_instance['style'] ) 
            ? $new_instance['style'] 
            : ( isset( $old_instance['style'] ) ? $old_instance['style'] : '' );
        $instance['bordered'] = isset( $new_instance['bordered'] ) ? $new_instance['bordered'] : false;        
        return $instance;
    }    

    /** 
     * Filter image widget
     * @return resource
     */
    public function image_widget_filter($template) {     
        return get_template_directory() . '/inc/widgets/image-widget.php';
    }

    /** 
     * Get slider images
     * @param int $post_id
     * @return array
     */
    public function get_slider_photos() {
        global $post;

        $gallery_id = get_post_meta( $post->ID, 'slider_gallery_id', true );
        
        if ( $gallery_id === false ) 
            return;

        // Get the gallery's database record
        $gallery = get_post( $gallery_id );

        // Return the images for this gallery
        return $this->get_gallery_images( $gallery );
    }

    /**
     * Get carousel images.
     *
     * @param int $post_id
     * @return array
     */
    public function get_carousel_photos() {
        global $post;

        $gallery_id = get_post_meta( $post->ID, 'carousel_gallery_id', true );
        
        // If the carousel gallery ID hasn't been set, return
        if ( $gallery_id === false ) 
            return;

        // Get the gallery's database record
        $gallery = get_post( $gallery_id );

        // Return the images for this gallery
        return $this->get_gallery_images( $gallery );
    }

    /**
     * Returns the first gallery from the content.
     *
     * @param string $content
     * @return array        Will return an empty array if there are no matches.
     * @since Hitched 1.3
     */
    public function get_gallery_shortcode($content) {
        preg_match('/\[gallery(.*)]/', $content, $matches);
        return $matches;
    }

    /**
     * Returns the images for the gallery.
     *
     * This will either return all images attached to the gallery, or if a [gallery]
     * shortcode is found with a string of IDs, it will return the photos associated
     * with those IDs. 
     *
     * @param string $content
     * @return array
     * @since Hitched 1.3
     */
    public function get_gallery_images($post) {
        $match = $this->get_gallery_shortcode($post->post_content);

        // Get the user-passed attributes
        $attr = shortcode_parse_atts( substr( $match[0], 1, -1 ) );

        extract( shortcode_atts( array( 'orderby' => 'menu_order', 'order' => 'ASC', 'ids' => false ), $attr ) );

        // Get all attached images if specific image IDs weren't specified
        if ( empty( $match ) || $ids === false /* Match found without "ids" specified */ ) {      
            $images = get_posts( array( 'post_type' => 'attachment', 'posts_per_page' => -1, 'post_status' => 'any', 'post_parent' => $post->ID, 'orderby' => $orderby, 'order' => $order ) );
        }
        else {
            $images = get_posts( array( 'include' => $ids, 'post_per_page' => -1, 'post_type' => 'attachment', 'post_status' => 'any', 'orderby' => $orderby, 'order' => $order ) );
        }
        return $images;
    }

    /**
     * Get default theme settings
     * @return array
     */
    public function get_default_theme_options() {
        return array(
            'bride' => '', 
            'groom' => '', 
            'where_when' => '',
            'connect_header' => __( 'Connect', 'hitched'), 
            'contact_email' => '',
            'contact_phone' => '', 
            'twitter' => '', 
            'facebook' => '', 
            'flickr' => '', 
            'youtube' => '',
            'theme' => 'charcoal_peach', 
            'bg_pattern' => 'grain',
            'blog_title' => 'Our Blog',
            'analytics' => '', 
            'flickr_api_key' => '',
            'instagram_token' => '',
            'twitter_token' => '',
            'twitter_token_secret' => '', 
            'twitter_consumer_secret' => '',
            'twitter_consumer_key' => '',
            'theme_version' => '1.8', 
            'show_hitched_link' => 1, 
            'show_rss' => 1
        );
    }    
}

// Function to get the one true instance of our theme
function get_sofa_bootstrap() {
    return OSFBootstrap::get_instance();
}

// Instantiate OSFBootstrap, loading all our theme stuff
get_sofa_bootstrap();

// Set $content_width global variable
if ( ! isset( $content_width ) ) $content_width = 822;