<?php
/**
 * The template for displaying Category pages
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
                <strong><?php echo esc_html__( 'Viewing post categorized under: ', 'fuse-wp' ) . single_cat_title( '', false ); ?></strong>
            </h1>
        </div>
    </div>
</div>
<br>
<br>
<?php
get_template_part( 'index' );
get_footer();
