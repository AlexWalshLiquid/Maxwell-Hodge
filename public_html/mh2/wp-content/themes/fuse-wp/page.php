<?php

/**
 * The template for displaying all pages
 */
if ( !defined( 'ABSPATH' ) ) {
    exit();
}
get_header();
if ( have_posts() ) {
    // Current page sidebar related meta
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
            global $nfw_theme_options;
            if ( isset( $nfw_theme_options['nfw-sidebars-size'] ) ) {
                $span_size = 12 - $nfw_theme_options['nfw-sidebars-size'];
                echo '<div class="span' . $span_size . '">';
            } else {
                echo '<div class="span9">';
            }
        } else if ( strpos( $content, '[/vc_row]' ) === false ) {
            echo '<div class="span12">';
        }
        
        the_content();
        
        if ( comments_open() || get_comments_number() ){
            comments_template( '', true );
        }
       
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
