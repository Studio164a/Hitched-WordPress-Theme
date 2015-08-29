<?php 
/**
 * 404 template
 */

get_header() ?>	

		<!-- Main content area -->
		<div id="main">

			<!-- Left column -->
			<div id="content">
					
					<h2 class="archive_title"><?php _e( 'Whoops, nothing here...', 'hitched' ) ?></h2>

					<div class="entry no_results">
						<p class="intro"><?php _e( 'Sorry, but you\'ve reached a dead end.', 'hitched' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->			

			</div>
			<!-- End left column -->

		<?php get_sidebar() ?>

		</div>
		<!-- End main content area -->

<?php get_footer() ?>