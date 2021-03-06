<?php
/**
 * One Six Foray's Flickr widget
 * @author Eric Daams <eric@ericnicolaas.com>
 */
 
class OSF_Flickr_Widget extends WP_Widget {
    
    function OSF_Flickr_Widget() {
        $widget_ops = array(
            'classname' => 'osf_flickr_widget', 
            'description' => __('Display pictures from your Flickr gallery', 'hitched')
        );
        
        $control_ops = array( 
            'width' => 400, 
            'height' => 350, 
            'id_base' => 'osf_flickr_widget'
        );    
        
        $this->WP_Widget('OSF_Flickr_Widget', __('Flickr by Studio 164a', 'hitched'), $widget_ops, $control_ops);
    }
   
    function form($instance) {
        $instance = wp_parse_args((array) $instance, array( 'title' => '', 'username' => '', 'count' => 12 ));
        $title = $instance['title'];
        $username = $instance['username'];    
        $count = $instance['count'];
        ?>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'hitched') ?>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
            </label>
        </p> 
        <p>
            <label for="<?php echo $this->get_field_id('username'); ?>"><?php _e('Your Username on Flickr:', 'hitched') ?>        
                <input class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo esc_attr($username); ?>" />        
            </label>      
        </p>    
        <p>
            <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Number of Photos to Display:', 'hitched') ?> 
                <input id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count ?>" />              
            </label>
        </p>

        <?php
    }
 
    function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['title'] = $new_instance['title'];
        $instance['username'] = $new_instance['username'];    
        $instance['count'] = $new_instance['count'];
        // $instance['photo_size'] = $new_instance['photo_size'];

        return $instance;
    }
 
    function widget($args, $instance) {
        extract($args, EXTR_SKIP);
        
        $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);    
        $username = empty($instance['username']) ? '' : $instance['username'];
        $count = empty($instance['count']) ? 12 : $instance['count'];
        $size = 's'; // We're hardcoding this for theme purposes

        // Verify username length
        echo $before_widget;

        // Show title
        if (!empty($title)) {
          echo $before_title . $title . $after_title;
        }         

        if ( strlen($username) < 2 ) {
            echo '<p>' . __( 'Invalid Flickr username.', 'hitched' ) . '</p>';
        }
        else {
            $flickr = new OSF_Flickr();    
            $flickr_id = $flickr->get_flickr_id($username);    

            if ( $flickr_id === false ) {
                echo '<p>' . $flickr->get_error() . '</p>';
            }
            else {
                $flickr->display_gallery( $flickr_id, array( 'count' => $count, 'size' => $size, 'height' => 74, 'width' => 74 ) );
            }
        }        

        echo $after_widget;
    }
}