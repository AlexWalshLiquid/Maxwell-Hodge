<?php
/**
 * The template for displaying portfolio posts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}
get_header();
if ( have_posts() ) {
    // Current portfolio post sidebar related meta
    $sidebar_position = get_post_meta( get_the_ID(), 'nfw_sidebar_position', true );

    // Start the Loop.
    while ( have_posts() ) {
        the_post();
        
        $content = $post->post_content;

        if ( !empty( $sidebar_position ) && $sidebar_position != 'none' || strpos( $content, '[/vc_row]' ) === false ) {
            echo '<div class="container"><div class="row">';
        }

        if ( !empty( $sidebar_position ) ) {
            if ( $sidebar_position == 'left' ) {
                get_sidebar();
            }
        }

        if ( !empty( $sidebar_position ) && $sidebar_position != 'none' ) {
            echo '<div class="span8">';
        } else if ( strpos( $content, '[/vc_row]' ) === false ) {
            echo '<div class="span12">';
        }

        the_content();

        if ( !empty( $sidebar_position ) && $sidebar_position != 'none' || strpos( $content, '[/vc_row]' ) === false ) {
            echo '</div>';
        }

        if ( !empty( $sidebar_position ) ) {
            if ( $sidebar_position == 'right' ) {
                get_sidebar();
            }
        }

        if ( !empty( $sidebar_position ) && $sidebar_position != 'none' || strpos( $content, '[/vc_row]' ) === false ) {
            echo '</div></div>';
        }
    }
} else {
    get_template_part( 'template-parts/content', 'none' );
}
get_footer();