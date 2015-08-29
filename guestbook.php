<?php 
/*
Template Name: Guestbook
*/

get_header() ?>

		<!-- Main content area -->
		<div id="main">

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : ?>

					<?php the_post() ?>
					
					<?php get_template_part( 'entry', 'guestbook' ) ?>					

				<?php endwhile ?>

			<?php endif ?>

		</div>
		<!-- End main content area -->

<?php get_footer() ?>