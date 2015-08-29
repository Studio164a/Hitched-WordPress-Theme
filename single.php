<?php 
/**
 * Single post template. 
 */

if ( get_post_format() == 'gallery' ) {
	require_once( 'single-gallery.php' );
	return;
}

get_header() ?>

		<!-- Main content area -->
		<div id="main">

			<!-- Left column -->
			<div id="content">

				<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : ?>

						<?php the_post() ?>

						<?php get_template_part( 'entry', hitched_get_modifier( false ) ) ?>

					<?php endwhile ?>				

					<div class="pagination">
						<div class="float_right"><?php next_post_link( '%link', '%title <i class="icon-arrow-right"></i>' ) ?></div>
						<div class="float_left"><?php previous_post_link( '%link', '<i class="icon-arrow-left"></i> %title' ) ?></div>
					</div>

					<?php comments_template( '', true ); ?>

				<?php endif ?>

			</div>
			<!-- End left column -->

		<?php get_sidebar() ?>

		</div>
		<!-- End main content area -->

<?php get_footer() ?>