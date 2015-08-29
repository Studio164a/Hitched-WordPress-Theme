<?php 
/**
 * Gallery template
 */

get_header() ?>

		<!-- Main content area -->
		<div id="main">			

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : ?>

					<?php the_post() ?>

					<div id="post-<?php the_ID() ?>" <?php post_class('post format-gallery') ?>>

						<div class="entry">						
							
							<?php the_content() ?>

						</div>

						<?php get_template_part( 'meta', 'page' ) ?>

					</div>
					
				<?php endwhile ?>

				<?php if ( get_post_type() == 'post' ) : ?>

					<div class="pagination">
						<div class="float_right"><?php next_post_link( '%link', '%title <i class="icon-arrow-right"></i>' ) ?></div>
						<div class="float_left"><?php previous_post_link( '%link', '<i class="icon-arrow-left"></i> %title' ) ?></div>
					</div>

					<?php comments_template( '', true ); ?>

				<?php endif ?>

			<?php endif ?>

		</div>
		<!-- End main content area -->

<?php get_footer() ?>