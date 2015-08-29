/** 
 * Hitched admin area scripts
 */
( function($){

	var toggleWidgetBorderField = function( $wrapper, $field ) {
		if ( $field.val() == 'open' ) {
			$wrapper.next('.widget_bordered').show();
		}
		else {
			$wrapper.next('.widget_bordered').hide();
		}
	}

	$(document).ready( function() {

		// Hide widget border setting if panel setting is selected for background
		$('.widget_bg_style').each( function() {
			toggleWidgetBorderField( $(this), $(this).children('select').first() );
		});

		$('.widget_bg_style select').on( 'change', function() {
			toggleWidgetBorderField( $(this).parents(), $(this) );
		})
	});

})( jQuery );