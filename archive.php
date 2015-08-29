<?php 
/**
 * Generic archive template
 */

get_header() ?>	

		<!-- Main content area -->
		<div id="main">

			<!-- Left column -->
			<div id="content">

				<h2 class="archive_title">
					<?php if ( is_day() ) : ?>
						<?php printf( __( 'Daily Archives: %s', 'hitched' ), '<span>' . get_the_date() . '</span>' ); ?>
					<?php elseif ( is_month() ) : ?>
						<?php printf( __( 'Monthly Archives: %s', 'hitched' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'hitched' ) ) . '</span>' ); ?>
					<?php elseif ( is_year() ) : ?>
						<?php printf( __( 'Yearly Archives: %s', 'hitched' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'hitched' ) ) . '</span>' ); ?>
					<?php else : ?>
						<?php _e( 'Blog Archives', 'hitched' ); ?>
					<?php endif; ?>
				</h2>

				<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : ?>

						<?php the_post() ?>
						
						<?php get_template_part( 'entry', hitched_get_modifier( true ) ) ?>

					<?php endwhile ?>

				<?php endif ?>

			</div>
			<!-- End left column -->

		<?php get_sidebar() ?>

		</div>
		<!-- End main content area -->

<?php get_footer() ?>