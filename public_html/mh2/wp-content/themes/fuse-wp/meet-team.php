<?php

/*
  Template Name: Meet Team
 */
if ( !defined( 'ABSPATH' ) ) {
    exit();
}
get_header();
if ( have_posts() ) {
    // Current page sidebar related meta
    $sidebar_position = get_post_meta( get_the_ID(), 'nfw_sidebar_position', true );

    // checks if a static page was selected as front page
    if ( 'page' == get_option( 'show_on_front' ) ) {

        // Start the Loop.
        while ( have_posts() ) {
            the_post();

        $content = $post->post_content; 
			{
			echo '<div class="container">
			<div class="row"><div>YABBADABBADOO</div>
				</div></div>';
			}
    
        }
    } else {
        get_template_part( 'index' );
    }
} else {
    get_template_part( 'template-parts/content', 'none' );
}
get_footer();
