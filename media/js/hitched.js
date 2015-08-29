/**
 * Primary Javascript file for Hithed Wordpress Theme by Studio 164a
 *
 * Copyright 2012, Studio 164a
 */

// Initialize all Javascript
(function($) {

	// Run setup functions once document is ready
    $(document).ready( function() {     
        // Sliders
		$('.rslides').responsiveSlides({ pager : true, timeout : 4000, speed: 1000 });

		// Carousel
		$('.carousel').carouselSwipe({ nextButtonText : false, previousButtonText : false, buttonsPosition : 'outside center', easing : 'ease-in-out' });

		// RoundRect (for IE7&8)		
		if ( window.PIE ) {
			$('.rslides_tabs li, .panel, img').each( function() {
				PIE.attach(this);
			});
		}			

		// Dropdown menus
		$('#primary_nav ul').dropdownMenu({ alignment : 'left' });
    });

    // Run setup functions once window is loaded
    $(window).load( function() {    
        var $window = $(window), 
			colorbox_defaults = { 
				opacity: '0.5', 
				maxWidth: '94%', 
				maxHeight: '94%', 
				initialWidth: '100px', 
				initialHeight : '100px',
				previous : '<i class="icon-arrow-left"></i>',
				next : '<i class="icon-arrow-right"></i>',
				close : '<i class="icon-remove"></i>',
				slideshowStop : '<i class="icon-pause"></i>',
				slideshowStart : '<i class="icon-play"></i>',
				slideshow : false, 
				rel : false };
	
		$(".responsive_menu").flexNav({ 
			breakpoint: 600, 
			toggleCallback: function($button) {
				$button.children('i').toggleClass('icon-chevron-down').toggleClass('icon-chevron-up');
			} 
		});
	
		// Individual Colorbox photos
		$('a.colorbox').colorbox( colorbox_defaults );

		// Colorbox galleries
		$('.colorbox_gallery').each( function() {
			$(this).find('a').colorbox( $.extend( colorbox_defaults, {
				rel : $(this).data().album || 'colorbox_gallery',
				slideshow : $(this).data().slideshow
			}));
		});

		if ( window.addEventListener ) {
			window.addEventListener("orientationchange", function() {
			    if($('#cboxOverlay').is(':visible')){
			        $.colorbox.load(true);
			    }
			}, false);
		}

		// Image Hover
		$('a.colorbox img, figure img, .wp-caption img, .gallery img, .colorbox_gallery img').imageHover();
    }); 
})(jQuery);