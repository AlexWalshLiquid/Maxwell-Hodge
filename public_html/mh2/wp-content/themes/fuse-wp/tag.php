<?php
/**
 * The template for displaying Tag pages
 *
 * Used to display archive-type pages for posts in a tag.
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}
get_header();
?> 
<div class="container">	
    <div class="row">
        <div class="span12">
            <h1 class="text-center">
                <strong><?php printf( esc_html__( 'Tag Archives: %s', 'fuse-wp' ), single_tag_title( '', false ) ); ?></strong>
            </h1>
        </div>
    </div>
</div>
<br>
<br>
<?php
get_template_part( 'index' );
get_footer();
