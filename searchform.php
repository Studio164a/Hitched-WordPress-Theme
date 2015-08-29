<?php
/**
 * Search form template
 */
?>
	<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label for="s" class="screen-reader-text"><?php _e( 'Search', 'hitched' ); ?></label>
		<input type="text" class="field" name="s" id="s" placeholder="<?php esc_attr_e( 'To search type and hit enter', 'hitched' ) ?>" />
	</form>
