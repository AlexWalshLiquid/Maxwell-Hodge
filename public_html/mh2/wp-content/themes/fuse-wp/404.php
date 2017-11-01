<?php
/**
 * Template Name: 404
 * The template for displaying 404 pages (Not Found)
 */
if ( !defined( 'ABSPATH' ) ) {
    exit();
}
//
global $nfw_theme_options;

$nfw_404_selection = "";
if ( isset( $nfw_theme_options['nfw-404-selection'] ) ) {
    $nfw_404_selection = $nfw_theme_options['nfw-404-selection'];
}
    
// Verifies if a certain a custom page was selected to be displayed as the 404 page
if ( $nfw_404_selection == 'default' || $nfw_404_selection == '' || get_permalink( $nfw_404_selection ) == '' ) {
    // Display the default 404 page content
    get_header();
    ?>  
    <div class="container">
        <div class="row">
            <div class="span12 text-center">

                <header>
                    <h1><?php esc_html_e( 'Not Found', 'fuse-wp' ); ?></h1>
                </header>

                <p><?php esc_html_e( 'Nothing was found at this location.', 'fuse-wp' ); ?></p>

                <?php get_search_form(); ?>

            </div>
        </div>
    </div>
    <?php
     get_footer();
} else {
    // A custom page was selected to be displayed as the 404 page    
    wp_redirect( get_page_link($nfw_404_selection) );
}