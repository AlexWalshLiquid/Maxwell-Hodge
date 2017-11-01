<?php
/*
 * Search form template
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}
?>
<form action="<?php echo esc_url( home_url( '/' ) ); ?>" class="searchform" id="searchform" method="get" name="searchform">
    <div>
        <label class="screen-reader-text" for="s"><?php esc_html_e( 'Search for:', 'fuse-wp' ); ?></label> 
        <input id="s" name="s" type="text" value="" placeholder="<?php esc_html_e( 'enter keyword here...', 'fuse-wp' ); ?>"> 
        <input id="searchsubmit" type="submit" value="">
    </div>
</form>