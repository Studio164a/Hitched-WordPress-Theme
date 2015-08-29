		<!-- Footer -->
		<footer id="pre_footer">

			<div class="connect">
				<?php if ( hitched_get_option('connect_header') ) : ?><h4><?php echo hitched_get_option('connect_header') ?></h4><?php endif ?>
				<?php if ( hitched_get_option('contact_email') ) : ?><div class="email"><a href="mailto:<?php echo hitched_get_option('contact_email') ?>"><?php echo hitched_get_option('contact_email') ?></a></div><?php endif ?>
				<?php if ( hitched_get_option('contact_phone') ) : ?><div class="phone"><?php echo hitched_get_option('contact_phone') ?></div><?php endif ?>
				<ul class="social horizontal">
					<?php if ( hitched_get_option('facebook') ) : ?><li><a href="<?php echo hitched_get_option('facebook') ?>" class="facebook social_button"><?php _e( 'Facebook', 'hitched' ) ?></a></li><?php endif ?>
					<?php if ( hitched_get_option('twitter') ) : ?><li><a href="<?php echo hitched_get_option('twitter') ?>" class="twitter social_button"><?php _e( 'Twitter', 'hitched' ) ?></a></li><?php endif ?>
					<?php if ( hitched_get_option('flickr') ) : ?><li><a href="<?php echo hitched_get_option('flickr') ?>" class="flickr social_button"><?php _e( 'Flickr', 'hitched' ) ?></a></li><?php endif ?>
					<?php if ( hitched_get_option('youtube') ) : ?><li><a href="<?php echo hitched_get_option('youtube') ?>" class="youtube social_button"><?php _e( 'YouTube', 'hitched' ) ?></a></li><?php endif ?>
					<?php if ( hitched_get_option('show_rss') ) : ?><li><a href="<?php bloginfo('rss2_url') ?>" class="rss social_button"><?php _e( 'RSS', 'hitched' ) ?></a></li><?php endif ?>
				</ul>
			</div>

		</footer>
		<!-- End footer -->

	</div>

	<footer id="footer">

		<div class="wrapper">

			<div class="double_dotted">
				<h4><?php echo hitched_get_initial('groom') ?> <span class="ampersand">&</span> <?php echo hitched_get_initial('bride') ?></h4>
			</div>

			<div class="bottom">
				<span class="float_left">&copy; <?php _e( 'Copyright', 'hitched' ) ?> <?php echo date('Y') ?></span>
				<?php if ( hitched_get_option('show_hitched_link') ) : ?>
					<a class="float_right" href="http://164a.com?utm_source=campaign&utm_medium=hitched&utm_source=<?php echo site_url() ?>" target="_blank">Hitched theme by <span class="osfa">Studio 164a</span></a>
				<?php endif ?>
			</div>

		</div>

	</footer>

<?php wp_footer() ?>

</body>