<?php 
/**
 * Filter column shortcode defaults. Used for backwards compatibility.
 * @param array $defaults
 * @return array
 * @since 1.9
 */
function sofa_hitched_gc_column_defaults($defaults) {
    $defaults['width'] = '1/2';
    $defaults['divider'] = false;
    return $defaults;        
}

add_filter('gc_column_defaults', 'sofa_hitched_gc_column_defaults');

/**
 * Filter column shortcode arguments. Used for backwards compatibility.
 * @param array $atts
 * @return array
 * @since 1.9
 */
function sofa_hitched_gc_column_args($atts) {

    if ($atts['width'] == '1/2' && isset($atts['grid'])) {
        unset($atts['width']);
    }

    if ( isset($atts['width']) ) {

        // Allow for percentages
        if (strpos($atts['width'], '/') === false && '%' == substr($atts['width'], '-1') ) {
            switch ($atts['width']) {
                case 50: 
                    $atts['grid'] = 2; 
                    $atts['span'] = 1;
                    break; 
                case 33: 
                    $atts['grid'] = 3; 
                    $atts['span'] = 1;
                    break; 
                case 25: 
                    $atts['grid'] = 4; 
                    $atts['span'] = 1;
                    break; 
                case 20: 
                    $atts['grid'] = 5; 
                    $atts['span'] = 1;
                    break; 
                case 66: 
                    $atts['grid'] = 3; 
                    $atts['span'] = 2;
                    break; 
                case 40: 
                    $atts['grid'] = 5; 
                    $atts['span'] = 2;
                    break; 
                case 75: 
                    $atts['grid'] = 4; 
                    $atts['span'] = 3;
                    break; 
                case 60: 
                    $atts['grid'] = 5; 
                    $atts['span'] = 3;
                    break; 
                case 80:
                    $atts['grid'] = 5; 
                    $atts['span'] = 4;
                    break; 
            }
        }
        else {
            list($span, $grid) = explode('/', $atts['width']);
            $atts['span'] = $span;
            $atts['grid'] = $grid;
        }            
    }
    
    return $atts;
}

add_filter('gc_column_args', 'sofa_hitched_gc_column_args');

/**
 * Adds the divider column class if specified by users.
 * @param array $column_classes
 * @param array $atts
 * @return array
 * @since 1.9
 */
function sofa_hitched_gc_column_class($column_classes, $atts) {
    // echo "<pre>"; print_r( $atts ); echo '</pre>';
    if ($atts['divider'] == true) {
        $column_classes[] = 'divider';
    }
    return $column_classes;
}

add_filter('gc_column_class', 'sofa_hitched_gc_column_class', 10, 2);