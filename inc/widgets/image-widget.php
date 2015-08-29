<?php

/**
 * This overrides the default view template for the Image Widget plugin
 * @author Eric Daams
 */

// Block direct requests
if ( !defined('ABSPATH') )
	die('-1');

$style = empty( $instance['style'] ) ? 'panel' : $instance['style'];

// Change to an open plan widget
if ( $style == 'open' ) {
    $before_widget = str_replace( 'panel', 'open', $before_widget );
    $after_widget = str_replace( '<div class="waves"></div>', '', $after_widget );
}

echo $before_widget;
if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }
if ( !empty( $imageurl ) ) {
	if ( $link ) {
		echo '<a class="'.$this->widget_options['classname'].'-image-link colorbox" href="'.$link.'" target="'.$linktarget.'" title="'.(!empty( $alt ) ? $alt : $title).'">';
	}
	if ( $imageurl ) {
		echo '<img src="'.$imageurl.'" style="';
		if ( !empty( $width ) && is_numeric( $width ) ) {
			echo "max-width: {$width}px;";
		}
		if ( !empty( $height ) && is_numeric( $height ) ) {
			echo "max-height: {$height}px;";
		}
		echo "\"";
		if ( !empty( $align ) && $align != 'none' ) {
			echo " class=\"align{$align}\"";
		}
		if ( !empty( $alt ) ) {
			echo " alt=\"{$alt}\"";
		} else {
			echo " alt=\"{$title}\"";
		}
		echo " />";
		// echo "<span class=\"image_hover\"></span>";
	}

	if ( $link ) { echo '</a>'; }
}
if ( !empty( $description ) ) {
	echo '<div class="'.$this->widget_options['classname'].'-description" >';
	echo wpautop( $description );
	echo "</div>";
}
echo $after_widget;