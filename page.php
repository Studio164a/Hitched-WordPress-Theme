<?php get_header() ?>

		<!-- Main content area -->
		<div id="main">

			<!-- Left column -->
			<div id="content">

				<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : ?>

						<?php the_post() ?>

						<?php get_template_part( 'entry', 'page' ) ?>

						<?php comments_template( '', true ); ?>

					<?php endwhile ?>									

				<?php endif ?>

			</div>
			<!-- End left column -->

		<?php get_sidebar() ?>

		</div>
		<!-- End main content area -->

<?php get_footer() ?>