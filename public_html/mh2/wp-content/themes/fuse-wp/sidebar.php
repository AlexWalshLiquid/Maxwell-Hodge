<?php
if ( is_page() || get_post_type() == 'erp-portfolio' ) {
    // Sidebar data for each page
    $current_page_id = get_queried_object_id();
    $sidebar_id = get_post_meta( $current_page_id, 'nfw_sidebar_source', true );
} else {
    // Sidebar data for the rest of the post types (blog sidebar)
    $page_for_posts = get_option( 'page_for_posts' );
    $sidebar_id = get_post_meta( $page_for_posts, 'nfw_sidebar_source', true );
    if ( $page_for_posts == 0 ) {
        $sidebar_id = 'nfw-default-sidebar';
    }
}

if (function_exists('is_shop')) {

    if (is_singular('product')) {
        $sidebar_id = get_post_meta(get_the_id(), 'nfw_sidebar_source', true);
    } else if (is_woocommerce()) {
        $sidebar_id = get_post_meta(get_option('woocommerce_shop_page_id'), 'nfw_sidebar_source', true);
    }
}

if ( !empty( $sidebar_id ) ) {
    if ( function_exists( 'dynamic_sidebar' ) ) {
        global $nfw_theme_options;
        if ( isset( $nfw_theme_options['nfw-sidebars-size'] ) ) {
            echo '<div class="span' . $nfw_theme_options['nfw-sidebars-size'] . '">';
        } else {
            echo '<div class="span3">';
        }
        dynamic_sidebar( $sidebar_id );
        echo '</div>';
    }
}