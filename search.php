<?php 
/**
 * Search results template
 */

get_header() ?>	

		<!-- Main content area -->
		<div id="main">

			<!-- Left column -->
			<div id="content">

				<h2 class="archive_title">
					<?php printf( '%s %s', __( 'You searched for:', 'hitched' ), '&#8220;<span>' . get_search_query() . '</span>&#8221;' ) ?>
				</h2>

				<?php if ( have_posts() ) : ?>

					<ul class="search_results">

					<?php while ( have_posts() ) : ?>

						<?php the_post() ?>
						
						<li>
							<h3><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
							<?php the_excerpt() ?>
						</li>

						<?php //get_template_part( 'entry', hitched_get_modifier( true ) ) ?>

					<?php endwhile ?>

					</ul>				

				<?php else : ?>

					<div class="search entry no_results">
						<p class="intro"><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'hitched' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->			

				<?php endif; ?>

			</div>
			<!-- End left column -->

		<?php get_sidebar() ?>

		</div>
		<!-- End main content area -->

<?php get_footer() ?>