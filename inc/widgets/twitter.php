<?php
 
class OSF_Twitter_Widget extends WP_Widget {
  
    function OSF_Twitter_Widget() {
        $widget_ops = array(
            'classname' => 'osf_twitter_widget', 
            'description' => __('Display your most recent Twitter posts.', 'hitched')
        );
        
        $this->WP_Widget('OSF_Twitter_Widget', __('OSF Twitter'), $widget_ops);
    }
 
    function form($instance) {
        $defaults = array( 
            'title' => __('Tweets', 'hitched'), 
            'count' => 5, 
            'retweets' => false,
            'replies' => false, 
            'username' => ''
        );

        $instance = wp_parse_args((array) $instance, $defaults);

        $title = $instance['title'];
        $username = $instance['username'];
        $count = $instance['count'];
        $retweets = $instance['retweets'];
        $replies = $instance['replies'];
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'hitched') ?> 
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('username'); ?>"><?php _e('Twitter Username:', 'hitched') ?> 
                <input class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo esc_attr($username); ?>" />
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Number of Tweets:', 'hitched') ?>
                <input class="widefat" id="<?php echo $this->get_field_id('count') ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count ?>" />                
            </label>
        </p>    
        <p>
            <label for="<?php echo $this->get_field_id('retweets') ?>"><?php _e('Include retweets:', 'hitched') ?>
                <input id="<?php echo $this->get_field_id('retweets') ?>" name="<?php echo $this->get_field_name('retweets') ?>" value="1" <?php checked( $retweets ) ?> type="checkbox" />
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('replies') ?>"><?php _e('Include replies:', 'hitched') ?>
                <input id="<?php echo $this->get_field_id('replies') ?>" name="<?php echo $this->get_field_name('replies') ?>" value="1" <?php checked( $replies ) ?> type="checkbox" />
            </label>
        </p>
        <?php
    }
 
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['username'] = $new_instance['username'];
        $instance['count'] = $new_instance['count']; 
        $instance['retweets'] = isset( $new_instance['retweets'] ) ? $new_instance['retweets'] : false;
        $instance['replies'] = isset( $new_instance['replies'] ) ? $new_instance['replies'] : false;        
        return $instance;
    }
 
    function widget($args, $instance) {
        extract($args, EXTR_SKIP);
 
        echo $before_widget;
        $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
        $name = empty($instance['username']) ? '' : $instance['username'];
        $count = empty($instance['count']) ? '' : $instance['count'];
        $retweets = empty($instance['retweets']) ? false : $instance['retweets'];
        $replies = empty($instance['replies']) ? false : $instance['replies'];

        if (!empty($title)) {
          echo $before_title . $title . $after_title;;
        }

        $transient_key = sprintf( "twitter_%s_%d", $name, $count );

        // Try to fetch tweets from transient
        $tweets = get_transient($transient_key);
        $tweets = false;

        if ($tweets === false) {

            $url = sprintf( 
                    "http://api.twitter.com/1/statuses/user_timeline.json?screen_name=%s&count=%d&include_entities=1&include_rts=%d&exclude_replies=%d", 
                    $name, $count, $retweets, !$replies );
            $json = wp_remote_get( $url );          

            // Check that the object is created correctly 
            if ( is_wp_error( $json ) ) { 
                return _e( 'Unable to load tweets', 'hitched' );
            }

            $tweets = json_decode( $json['body'] );

            set_transient( $transient_key, $tweets, 60 * 5 ); // Cached for 5 minutes
        }

        if ($tweets) :
        ?>        
	
        <ul>
            <?php foreach ( $tweets as $t ) : ?>

            <?php $tweet_text = $this->get_parsed_tweet_text( $t ) ?>
            
            <li>
                <p class="tweet"><a href="http://twitter.com/<?php echo $name ?>" target="_blank"><i class="icon-twitter"></i></a> <?php echo $tweet_text ?></p>
                <p class="time_ago"><?php printf( "%s %s", human_time_diff( strtotime($t->created_at), current_time('timestamp') ), _x( 'ago', 'time since item was posted', 'hitched' ) ) ?></p>
            </li>

            <?php endforeach ?>

            <li class="float_right"><?php printf( '<a href="%s" title="%s"><i class="icon-twitter"></i> %s</a>', "http://twitter.com/$name", _x( 'Click to go to our Twitter profile', 'twitter profile link title attribute', 'hitched' ), __( 'Follow us on Twitter', 'hitched' ) ) ?></li>
        </ul>        

        <?php        
        endif;

        echo $after_widget;        
    }

    /**
     * Returns tweet text with links parsed
     * @return string
     */
    protected function get_parsed_tweet_text($tweet) {
        // Deal with HTML entities
        $output = htmlentities(html_entity_decode($tweet->text, ENT_NOQUOTES, 'UTF-8'), ENT_NOQUOTES, 'UTF-8');

        // Parse URLs
        foreach ($tweet->entities->urls as $url) {
            $output = str_replace( $url->url, $this->get_parsed_twitter_link( $url, 'url' ), $output );
        }

        // Parse hashtags
        foreach ($tweet->entities->hashtags as $hashtags) {
            $output = str_ireplace( '#'.$hashtags->text, $this->get_parsed_twitter_link( $hashtags, 'hashtag' ), $output);
        }

        // Parse usernames
        foreach ($tweet->entities->user_mentions as $user_mentions) {
            $output = str_ireplace( '@'.$user_mentions->screen_name, $this->get_parsed_twitter_link( $user_mentions, 'user_mention' ), $output );
        }

        return $output;
    }

    /** 
     * Return the parsed Twitter link     
     * @return string
     */
    protected function get_parsed_twitter_link( $entity, $type ) {   
        $target = apply_filters( 'jnewsticker_open_links_in_new_window', false ) === true ? ' target="_blank"' : '';        

        switch ( $type ) {
            case 'url': 
                return '<a href="' . $entity->url . '"' . $target . '>' . $entity->display_url . '</a>';
                break;
            case 'user_mention':
                return '<a href="https://twitter.com/#!/' . $entity->screen_name . '"' . $target . '>@' . $entity->screen_name . '</a>';
                break;
            case 'hashtag':
                return '<a href="https://twitter.com/#!/search/' . $entity->text . '"' . $target . '>#' . $entity->text . '</a>';                
                break; 
        }
    }
}