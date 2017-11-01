<?php
/**
 * The template for displaying Archive pages
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
                <strong><?php
                    if ( is_day() ) :
                        echo esc_html__( 'Viewing posts from : ', 'fuse-wp' ) . get_the_date();

                    elseif ( is_month() ) :
                        echo esc_html__( 'Viewing posts from : ', 'fuse-wp' ) . get_the_date( esc_html_x( 'F Y', 'monthly archives date format', 'fuse-wp' ) );

                    elseif ( is_year() ) :
                        echo esc_html__( 'Viewing posts from : ', 'fuse-wp' ) . get_the_date( esc_html_x( 'Y', 'yearly archives date format', 'fuse-wp' ) );

                    else :
                        esc_html_e( 'Archives!', 'fuse-wp' );

                    endif;
                    ?></strong>
            </h1>
        </div>
    </div>
</div>
<br>
<br>
<?php
get_template_part( 'index' );
get_footer();
