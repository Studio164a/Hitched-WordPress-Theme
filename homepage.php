<?php 
/* 
 * Template name: Homepage
 */

get_header('homepage') ?>	

		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : ?>

				<?php the_post() ?>
		
				<!-- First panel -->
				<div class="panel">

					<?php the_content() ?>

					<div class="waves"></div>

				</div>
				<!-- End first panel -->

				<!-- Carousel -->			
				<?php get_template_part( 'carousel', 'homepage' ) ?>
				<!-- End carousel -->

				<!-- Second panel -->
				<div class="panel panel_last">

					<?php echo apply_filters( 'the_content', get_post_meta( get_the_ID(), 'content_panel_two', true ) ) ?>
					
					<div class="waves"></div>

				</div>
				<!-- End second panel -->

			<?php endwhile ?>

		<?php endif ?>

<?php get_footer() ?>