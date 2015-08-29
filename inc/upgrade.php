<?php
/**
 * Handles version to version upgrading
 * 
 * @author Eric Daams <eric@ericnicolaas.com>
 */

class OSFUpgradeHelper {
    
    /**
     * Perform upgrade
     * @param int $current
     * @param int|false $db_version 
     * @static
     */
    public static function do_upgrade($current, $db_version) {
    	if ($db_version === false) {            
            self::upgrade_1_1();
        }
        
        // Upgrade to 1.3
        if ( $db_version < mktime(10,58,0,2,25,2013) ) {
            self::upgrade_1_3();
        }        

        // Upgrade to 1.4
        self::upgrade_1_4();

        return;
    }
    
    /**
     * Upgrade to version 1.1
     */
    protected static function upgrade_1_1() {
        $options = get_option('theme_hitched_options', array());
        if ( !array_key_exists('show_hitched_link', $options) ) {
            $options['show_hitched_link'] = 1;
            update_option('theme_hitched_options', $options);
        }
    }

    /**
     * Upgrade to version 1.3
     */
    protected static function upgrade_1_3() {
        $options = get_option('theme_hitched_options');
        if ( !array_key_exists('show_rss', $options) ) {
            $options['show_rss'] = 1;
            update_option('theme_hitched_options', $options);
        }
    }

    /**
     * Upgrade to version 1.4
     */
    protected static function upgrade_1_4() {
        $options = get_option('theme_hitched_options');

        foreach ( array( 'twitter_token_secret', 'twitter_consumer_secret', 'twitter_consumer_key' ) as $key ) {
            if ( !array_key_exists($key, $options) ) {
                $options[$key] = '';
            } 
        }

        update_option('theme_hitched_options', $options);
    }
}