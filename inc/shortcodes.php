<?php
/**
 * A collection of shortcodes
 */

/**
 * Create a button
 * @param array $atts
 * @param string $content
 * @return string
 */
if ( !function_exists('osfa_button_shortcode') ) {
    function osfa_button_shortcode($atts, $content = null) {
        extract(shortcode_atts( array(
            'variation' => '', 'large' => false, 'link' => ''
        ), $atts));        

        if ( strlen( $variation ) )
            $variation = ' alt_'.$variation.' ';

        if ( $large ) 
            $large = ' large';

        // return '<button class="submit'.$variation.$large.'">'.$content.'</button>';
        return '<a href="'.$link.'" class="button submit'.$variation.$large.'">'.$content.'</a>';
    }
}

/**
 * Display recent posts
 * @param array $atts
 * @param string $content
 * @return string
 */
if ( !function_exists('osfa_recent_posts_shortcode') ) {
    function osfa_recent_posts_shortcode( $atts, $content = null ) {
        extract( shortcode_atts( array(
            'count' => 5, 'post_type' => 'post', 'excerpt_length' => 18
        ), $atts) ); 

        // Grab latest posts, excluding any posts with formats other than "Standard"
        $posts = new WP_Query( array( 
            'posts_per_page' => $count, 
            'post_type' => $post_type, 
            'tax_query' => array(
                array(
                    'taxonomy' => 'post_format',
                    'field' => 'slug', 
                    'terms' => array( 'post-format-gallery', 'post-format-quote', 'post-format-image', 'post-format-aside', 'post-format-link', 'post-format-status', 'post-format-video', 'post-format-audio', 'post-format-chat' ),
                    'operator' => 'NOT IN' 
                )               
            )
        ) );

        // Start HTML output
        $html = '<ul class="posts_widget">';

        if ( $posts->have_posts() ) {
            while ( $posts->have_posts() ) {
                $posts->the_post();

                $excerpt = wpautop( wp_trim_words( get_the_content(), $excerpt_length ) );
                $html .= '<li><h4 class="no_margin"><a href="'.get_permalink().'">'.get_the_title().'</a></h4>'.$excerpt.'</li>';
            }
        }
        
        $html .= '</ul>';

        // The global $post variable has to be returned to the current post
        wp_reset_postdata();

        return $html;
    }
}

/**
 * Display gallery
 * @param string $html
 * @param array $attr       Shortcode attributes. 
 * @return string
 */
if ( !function_exists('osfa_gallery_shortcode') ) {
    function osfa_gallery_shortcode( $html, $attr = array() ) {
        global $post;        

        // NOTE: This is all more or less the same as WP's gallery_shortcode() method,
        // but it sets up Hitched-specific markup for the gallery
        static $instance = 0;
        $instance++;

        // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
        if ( isset( $attr['orderby'] ) ) {
            $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
            if ( !$attr['orderby'] )
                unset( $attr['orderby'] );
        }

        extract(shortcode_atts(array(
            'order'      => 'ASC',
            'orderby'    => 'menu_order ID',
            'id'         => $post->ID,
            'itemtag'    => 'li',
            'captiontag' => 'p',
            'columns'    => '',
            'size'       => 'thumbnail',
            'include'    => '',
            'exclude'    => ''
        ), $attr));

        $image_size = $size;        
        if ( is_singular() && in_array( $size, array( 'thumbnail', 'medium', 'large' ) ) ) {
            $image_size = 'gallery_'.$size;
        }   
        elseif ( !is_singular() ) {
            $image_size = 'blog_large';
        }     

        $id = intval($id);
        if ( 'RAND' == $order )
            $orderby = 'none';

        if ( !empty($include) ) {
            $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

            $attachments = array();
            foreach ( $_attachments as $key => $val ) {
                $attachments[$val->ID] = $_attachments[$key];
            }
        } elseif ( !empty($exclude) ) {
            $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
        } else {
            $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
        }

        if ( empty($attachments) )
            return '';

        if ( is_feed() ) {
            $output = "\n";
            foreach ( $attachments as $att_id => $attachment )
                $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
            return $output;
        }

        $itemtag = tag_escape($itemtag);
        $captiontag = tag_escape($captiontag);
        $columns = intval($columns);
        $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
        $float = is_rtl() ? 'right' : 'left';

        $selector = "gallery-{$instance}";

        $size_class = is_singular() ? sanitize_html_class( $size ) : '';
        $gallery_class = is_singular() ? 'gallery' : 'rslides';        
        $gallery_ul = "<ul id='$selector' class='{$gallery_class} colorbox_gallery galleryid-{$id} gallery-columns-{$columns} {$size_class}'>";
        if ( !is_singular() ) 
            $gallery_ul = "<div class=\"slider\">{$gallery_ul}\n";
        $output = apply_filters( 'gallery_style', $gallery_ul );

        $i = 0;
        foreach ( $attachments as $id => $attachment ) {
            $image_attr = wp_get_attachment_image_src( $id, 'full' );
            $link = sprintf( '<a %s href="%s" title="%s">%s</a>', ( is_singular() ? '' : 'class="image_shadow"' ), $image_attr[0], $attachment->post_title, wp_get_attachment_image($id, $image_size) );

            $output .= "<{$itemtag} class='gallery-item'>$link";
            if ( $captiontag && ( trim($attachment->post_excerpt) || trim($attachment->post_title) ) && $size != 'thumbnail' ) {
                $caption = trim($attachment->post_excerpt) ? trim($attachment->post_excerpt) : trim($attachment->post_title);
                $output .= "
                    <{$captiontag} class='wp-caption-text gallery-caption'>
                    " . wptexturize($caption) . "
                    </{$captiontag}>";
            }
            $output .= "</{$itemtag}>";
            if ( $columns > 0 && ++$i % $columns == 0 )
                $output .= '<br style="clear: both" />';
        }

        $output .= "
            </ul>\n";

        if ( !is_singular() )
            $output .= "</div>\n";

        return $output;
    }
}

/**
 * Flickr shortcode
 * @param array $atts
 * @return string
 */
if (!function_exists('osfa_flickr_shortcode')) {
    function osfa_flickr_shortcode($atts) {
        $f = new OSF_Flickr();
        return $f->shortcode($atts);
    }
}

/**
 * Instagram shortcode
 * @param array $atts
 * @return string
 */
if (!function_exists('osfa_instagram_shortcode')) {
    function osfa_instagram_shortcode($atts) {
        $i = new OSF_Instagram();
        return $i->shortcode($atts);
    }
}