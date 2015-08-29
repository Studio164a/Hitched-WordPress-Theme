<?php

/**
 * Admin theme settings page
 * @author Eric Daams <eric@nicolaas.com>
 */

class OSFAdminPage { 

    /**
    * Display admin page
    */
    public function display() {
        ?>

        <div class="wrap">

            <div id="icon-themes" class="icon32"><br /></div>   
            <h2><?php _e( 'Hitched Theme Options', 'hitched' ) ?></h2>         

            <?php if ( isset( $_GET['settings-updated'] ) ) : ?>
                <div class='updated'><p><?php _e( 'Theme settings updated successfully.', 'hitched' ) ?></p></div>
            <?php endif ?>

            <!-- Start form -->
            <form action="options.php" method="post">

                <?php settings_fields( 'theme_hitched_options' ) ?>
                <?php do_settings_sections( 'hitched' ) ?>

                <p class="submit">
                    <button name="theme_hitched_options[do-action]" value="submit" class="button-primary"><?php esc_attr_e( 'Save Settings', 'hitched' ) ?></button>
                    <button name="theme_hitched_options[do-action]" value="reset" class="button-secondary"><?php esc_attr_e( 'Reset Defaults', 'hitched' ) ?></button>
                </p>

            </form>
            <!-- End form -->

        </div>

        <?php
    }  

    /**
     * General settings tab
     * @return void
     */
    public function get_general_tab() {
        // Sections
        add_settings_section( 'hitched_settings_general_appearance', __( 'Appearance', 'hitched' ), array( &$this, 'get_appearance_section' ), 'hitched' );
        add_settings_section( 'hitched_settings_general_details', __( 'Wedding Details', 'hitched' ), array( &$this, 'get_details_section' ), 'hitched' );
        add_settings_section( 'hitched_settings_general_footer', __( 'Footer', 'hitched' ), array( &$this, 'get_footer_section' ), 'hitched' );        
        add_settings_section( 'hitched_settings_general_blog', __( 'Blog', 'hitched' ), array( &$this, 'get_blog_section' ), 'hitched' );
        add_settings_section( 'hitched_settings_general_ganalytics', __( 'Google Analytics', 'hitched' ), array( &$this, 'get_ganalytics_section' ), 'hitched' );        
        add_settings_section( 'hitched_settings_general_integrations', __( 'Integrations', 'hitched' ), array( &$this, 'get_integrations_section' ), 'hitched' );
        add_settings_section( 'textural_settings_general_twitter', __( 'Twitter', 'hitched' ), array( &$this, 'get_twitter_section' ), 'hitched' );

        // Appearance
        add_settings_field( 'hitched_settings_skin', __( 'Skin', 'hitched' ), array( &$this, 'get_skin_field'), 'hitched', 'hitched_settings_general_appearance' );
        add_settings_field( 'hitched_settings_background_pattern', __( 'Background pattern', 'hitched' ), array( &$this, 'get_background_pattern_field'), 'hitched', 'hitched_settings_general_appearance' );

        // Wedding details
        add_settings_field( 'hitched_settings_bride', __( 'Bride', 'hitched' ), array( &$this, 'get_bride_field' ), 'hitched', 'hitched_settings_general_details' );
        add_settings_field( 'hitched_settings_groom', __( 'Groom', 'hitched' ), array( &$this, 'get_groom_field' ), 'hitched', 'hitched_settings_general_details' );
        add_settings_field( 'hitched_settings_where_when', __( 'Where & When', 'hitched' ), array( &$this, 'get_where_when_field' ), 'hitched', 'hitched_settings_general_details' );

        // Footer
        add_settings_field( 'hitched_settings_connect_header', __( 'Footer header', 'hitched' ), array( &$this, 'get_connect_header_field' ), 'hitched', 'hitched_settings_general_footer' );
        add_settings_field( 'hitched_settings_contact_phone', __( 'Contact phone', 'hitched' ), array( &$this, 'get_phone_field' ), 'hitched', 'hitched_settings_general_footer' );
        add_settings_field( 'hitched_settings_contact_email', __( 'Contact email', 'hitched' ), array( &$this, 'get_email_field' ), 'hitched', 'hitched_settings_general_footer' );
        add_settings_field( 'hitched_settings_contact_twitter', __( 'Twitter URL', 'hitched' ), array( &$this, 'get_twitter_field' ), 'hitched', 'hitched_settings_general_footer' );
        add_settings_field( 'hitched_settings_contact_facebook', __( 'Facebook URL', 'hitched' ), array( &$this, 'get_facebook_field' ), 'hitched', 'hitched_settings_general_footer' );
        add_settings_field( 'hitched_settings_contact_flickr', __( 'Flickr URL', 'hitched' ), array( &$this, 'get_flickr_field' ), 'hitched', 'hitched_settings_general_footer' );
        add_settings_field( 'hitched_settings_contact_youtube', __( 'YouTube URL', 'hitched' ), array( &$this, 'get_youtube_field' ), 'hitched', 'hitched_settings_general_footer' );
        add_settings_field( 'hitched_settings_show_rss', __( 'Include RSS link', 'hitched' ), array( &$this, 'get_rss_field' ), 'hitched', 'hitched_settings_general_footer' );
        add_settings_field( 'hitched_settings_show_hitched_link', __( 'Include Studio164a credit', 'hitched' ), array( &$this, 'get_credit_field' ), 'hitched', 'hitched_settings_general_footer' );

        // Blog
        add_settings_field( 'hitched_settings_blog_title', __( 'Blog title', 'hitched'), array( &$this, 'get_blog_title_field' ), 'hitched', 'hitched_settings_general_blog' );

        // Scripts
        add_settings_field( 'hitched_settings_ganalytics_field', __( 'Google Analytics', 'hitched' ), array( &$this, 'get_ganalytics_field' ), 'hitched', 'hitched_settings_general_ganalytics' );

        // Plugin integrations        
        add_settings_field( 'hitched_settings_instagram_token_field', __( 'Instagram access token', 'hitched' ), array( &$this, 'get_instagram_token_field' ), 'hitched', 'hitched_settings_general_integrations' );
        add_settings_field( 'hitched_settings_flickr_api_key_field', __( 'Flickr API key', 'hitched' ), array( &$this, 'get_flickr_api_key_field' ), 'hitched', 'hitched_settings_general_integrations' );

        // Twitter integration
        add_settings_field( 'textural_settings_twitter_consumer_key_field', __( 'Consumer key', 'hitched' ), array( &$this, 'get_twitter_consumer_key_field' ), 'hitched', 'textural_settings_general_twitter' );
        add_settings_field( 'textural_settings_twitter_consumer_secret_field', __( 'Consumer secret', 'hitched' ), array( &$this, 'get_twitter_consumer_secret_field' ), 'hitched', 'textural_settings_general_twitter' );
        add_settings_field( 'textural_settings_twitter_token_field', __( 'Access token', 'hitched' ), array( &$this, 'get_twitter_token_field' ), 'hitched', 'textural_settings_general_twitter' );
        add_settings_field( 'textural_settings_twitter_token_secret_field', __( 'Access token secret', 'hitched' ), array( &$this, 'get_twitter_token_secret_field' ), 'hitched', 'textural_settings_general_twitter' );        
    }

    /**
     * Wedding details sections
     * @return void
     */
    public function get_details_section() {}

    /**
     * Footer section
     * @return void
     */
    public function get_footer_section() {}

    /**
     * Appearance section
     * @return void
     */
    public function get_appearance_section() {}

    /**
     * Blog section
     * @return void
     */
    public function get_blog_section() {}

    /**
     * Google Analytics section
     * @return void
     */
    public function get_ganalytics_section() {}

    /**
     * Integrations section
     * @return void
     */
    public function get_integrations_section() {}

    /**
     * Twitter section
     * @return void
     */
    public function get_twitter_section() {
        ?>
        <p><?php _e( 'In order to use the Twitter widget, you are required to create an app through Twitter. Follow these simple steps:', 'hitched' ) ?></p>
        <ol>
            <li><?php printf( __( 'Go to %s to register your app. You may be asked to log in.', 'hitched' ), '<a href="https://twitter.com/apps" target="_blank">https://twitter.com/apps</a>' ) ?></li>
            <li><?php printf( __( 'Once you are logged in, click the button that says %sCreate a new application%s.', 'hitched' ), '<strong>', '</strong>' ) ?></li>
            <li><?php _e( 'Complete the form, tick the terms and conditions and solve the Captcha. Create your application.', 'hitched' ) ?></li>
            <li><?php _e( 'You have now created a Twitter application. The final step is to create an access token. Do this by clicking the button at the bottom of the page.', 'hitched' ) ?></li>
            <li><?php _e( 'Finally, copy and paste the relevant details about your Twitter application into the fields below.', 'hitched' ) ?></li>
        </ol>
        <?php 
    }    

    /**
     * Bride field
     * @return void
     */
    public function get_bride_field() {
        $options = $this->get_options();
        ?>
        <input name="theme_hitched_options[bride]" type="text" value="<?php echo $options['bride'] ?>" />
        <?php
    }

    /**
     * Groom field
     * @return void
     */
    public function get_groom_field() {
        $options = $this->get_options();
        ?>
        <input name="theme_hitched_options[groom]" type="text" value="<?php echo $options['groom'] ?>" />
        <?php
    }

    /**
     * Where & when field
     * @return void
     */
    public function get_where_when_field() {
        $options = $this->get_options();
        ?>
        <input name="theme_hitched_options[where_when]" type="text" value="<?php echo $options['where_when'] ?>" />
        <?php
    }

    /**
     * Connect header
     * @return void
     */
    public function get_connect_header_field() {
        $options = $this->get_options();
        ?>
        <input name="theme_hitched_options[connect_header]" type="text" value="<?php echo $options['connect_header'] ?>" />
        <?php
    }

    /**
     * Contact phone number
     * @return void
     */
    public function get_phone_field() {
        $options = $this->get_options();
        ?>
        <input name="theme_hitched_options[contact_phone]" type="text" value="<?php echo $options['contact_phone'] ?>" />
        <?php
    } 

    /**
     * Contact email address
     * @return void
     */
    public function get_email_field() {
        $options = $this->get_options();
        ?>
        <input name="theme_hitched_options[contact_email]" type="email" value="<?php echo $options['contact_email'] ?>" />
        <?php
    }

    /**
     * Twitter URL
     * @return void
     */
    public function get_twitter_field() {
        $options = $this->get_options();
        ?>
        <input name="theme_hitched_options[twitter]" type="text" value="<?php echo $options['twitter'] ?>" />
        <?php
    }

    /**
     * Facebook URL
     * @return void
     */
    public function get_facebook_field() {
        $options = $this->get_options();
        ?>
        <input name="theme_hitched_options[facebook]" type="text" value="<?php echo $options['facebook'] ?>" />
        <?php
    } 

    /**
     * Flickr URL
     * @return void
     */
    public function get_flickr_field() {
        $options = $this->get_options();
        ?>
        <input name="theme_hitched_options[flickr]" type="text" value="<?php echo $options['flickr'] ?>" />
        <?php
    } 

    /**
     * YouTube URL
     * @return void
     */
    public function get_youtube_field() {
        $options = $this->get_options();
        ?>
        <input name="theme_hitched_options[youtube]" type="text" value="<?php echo $options['youtube'] ?>" />
        <?php
    }        

    /**
     * Show link to RSS feed
     * @return void
     */
    public function get_rss_field() {
        $options = $this->get_options();
        ?>
        <input name="theme_hitched_options[show_rss]" type="checkbox" value="1" <?php checked( array_key_exists('show_hitched_link', $options) && $options['show_hitched_link'] == true ) ?> />
        <?php
    }     

    /**
     * Show link to 164a
     * @return void
     */
    public function get_credit_field() {
        $options = $this->get_options();
        ?>
        <input name="theme_hitched_options[show_hitched_link]" type="checkbox" value="1" <?php checked( array_key_exists('show_hitched_link', $options) && $options['show_hitched_link'] == true ) ?> />
        <?php
    }

    /** 
     * Skin field
     * @return void
     */
    public function get_skin_field() {
        $options = $this->get_options();
        $theme = $options['theme'];
        ?>
        <select name="theme_hitched_options[theme]">
            <option value="charcoal_peach" <?php selected( 'charcoal_peach', $theme ) ?>><?php _e( 'Charcoal Peach', 'hitched' ) ?></option>
            <option value="peach_chocolate" <?php selected( 'peach_chocolate', $theme ) ?>><?php _e( 'Peach Chocolate', 'hitched' ) ?></option>
        </select>    
        <?php
    }

    /**
     * Background pattern field
     * @return void
     */
    public function get_background_pattern_field() {
        $options = $this->get_options();
        $bg_pattern = $options['bg_pattern'];
        ?>
        <select name="theme_hitched_options[bg_pattern]">
            <option value="grain" <?php selected( 'grain', $bg_pattern ) ?>><?php _e( 'Grain', 'hitched' ) ?></option>
            <option value="wood" <?php selected( 'wood', $bg_pattern ) ?>><?php _e( 'Wood', 'hitched' ) ?></option>
            <option value="stripes" <?php selected( 'stripes', $bg_pattern ) ?>><?php _e( 'Stripes', 'hitched' ) ?></option>
        </select>    
        <?php
    }

    /**
     * Blog title field
     * @return void
     */
    public function get_blog_title_field() {
        $options = $this->get_options();
        ?>
        <input name="theme_hitched_options[blog_title]" type="text" value="<?php echo $options['blog_title'] ?>" />
        <?php
    }

    /**
     * Google Analytics field
     * @return void
     */
    public function get_ganalytics_field() {
        $options = $this->get_options();
        ?>
        <textarea name="theme_hitched_options[analytics]" rows="10" cols="60"><?php echo stripslashes( $options['analytics'] ) ?></textarea>
        <?php
    }

    /**
     * Instagram token field
     * @return void
     */
    public function get_instagram_token_field() {
        $options = $this->get_options();
        
        // Add thickbox
        add_thickbox()
        ?>
        <input name="theme_hitched_options[instagram_token]" type="text" value="<?php echo $options['instagram_token'] ?>" />
        <p>
            <?php printf( __( 'Don\'t have an access token for Instagram? %sGet one here.%s', 'hitched' ), '<a href="http://164a.com/authenticate/instagram/osf_theme.php" target="_blank">', '</a>' ) ?>
        </p>
        <?php 
    }

    /**
     * Flickr API key field
     * @return void
     */
    public function get_flickr_api_key_field() {
        $options = $this->get_options();
        ?>
        <input name="theme_hitched_options[flickr_api_key]" type="text" value="<?php echo $options['flickr_api_key'] ?>" />
        <p>
            <?php printf( __( 'You will require a Flickr API Key to use the Flickr widget or shortcode. %sGet one from Flickr.%s', 'hitched' ), '<a href="http://www.flickr.com/services/apps/create/apply/" target="_blank">', '</a>') ?>
        </p>
        <?php 
    }    

    /**
     * Twitter consumer key
     * @return void
     */
    public function get_twitter_consumer_key_field() {
        $options = $this->get_options();
        ?>
        <input name="theme_hitched_options[twitter_consumer_key]" type="text" value="<?php echo $options['twitter_consumer_key'] ?>" />        
        <?php
    }

    /**
     * Twitter consumer secret
     * @return void
     */
    public function get_twitter_consumer_secret_field() {
        $options = $this->get_options();
        ?>
        <input name="theme_hitched_options[twitter_consumer_secret]" type="text" value="<?php echo $options['twitter_consumer_secret'] ?>" />        
        <?php
    }

    /**
     * Twitter token
     * @return void
     */
    public function get_twitter_token_field() {
        $options = $this->get_options();
        ?>
        <input name="theme_hitched_options[twitter_token]" type="text" value="<?php echo $options['twitter_token'] ?>" />        
        <?php
    }  

    /**
     * Twitter token secret
     * @return void
     */
    public function get_twitter_token_secret_field() {
        $options = $this->get_options();
        ?>
        <input name="theme_hitched_options[twitter_token_secret]" type="text" value="<?php echo $options['twitter_token_secret'] ?>" />        
        <?php
    }  

    /**
     * Sanitize option's value
     */
    public function validate( $input ) {
        $options = $this->get_options();

        // Get action (either "submit" or "reset")
        $action = $input['do-action'];
            
        if ( $action == 'submit' ) {
            unset( $input['do-action']);

            $checkboxes = array( 'show_hitched_link', 'show_rss' );

            foreach ( $checkboxes as $checkbox ) {
                if ( !array_key_exists( $checkbox, $input) ) {
                    $input[$checkbox] = 0;
                }
            }            

            $input = array_merge( $options, $input );
        } 
        elseif ( $action == 'reset' ) {
            $input = OSFBootstrap::get_instance()->get_default_theme_options();
        }

        return $input;
    }

    /**
     * Get current options
     * @return array
     */
    public function get_options() {
        if ( !isset( $this->options ) ) {
            $options = get_option( 'theme_hitched_options' );
            $defaults = get_sofa_bootstrap()->get_default_theme_options();
            $this->options = array_merge($defaults, $options);
        }
        return $this->options;
    }

    /**
     * Get galleries
     * @return array
     */
    public function get_galleries() {
        if ( !isset( $this->galleries ) ) {
            $this->galleries = get_posts( array(
                'post_type' => 'gallery', 
                'post_status' => 'publish',
                'orderby' => 'title'
            ));
        }
        return $this->galleries;
    }
}