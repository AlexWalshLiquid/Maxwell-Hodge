<form role="search" method="get" class="woocommerce-product-search searchform" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
 <div>	
    <label class="screen-reader-text" for="s"><?php esc_html_e( 'Search for:', 'fuse-wp' ); ?></label>
	<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search Products&hellip;', 'placeholder', 'fuse-wp' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'fuse-wp' ); ?>" />
	<input id="searchsubmit" type="submit" value="" />
	<input type="hidden" name="post_type" value="product" />
        </div>
</form>