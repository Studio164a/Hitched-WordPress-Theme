<?php 
/**
 * Category template
 */

get_header() ?>	

		<!-- Main content area -->
		<div id="main">

			<!-- Left column -->
			<div id="content">

				<h2 class="archive_title"><?php single_cat_title( __('Browsing: ', 'hitched' ) ) ?></h2>

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