<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

get_header( 'shop' );

$sidebar_position = get_post_meta( woocommerce_get_page_id('shop'), 'nfw_sidebar_position', true );

if (!empty($sidebar_position) && $sidebar_position != 'none' ) {
    echo '<div class="container"><div class="row">';
}

if (!empty($sidebar_position)) {
    if ($sidebar_position == 'left') {
        get_sidebar();
    }
}

if (!empty($sidebar_position) && $sidebar_position != 'none') {
                echo '<div class="span9">';
} 


/**
 * woocommerce_before_main_content hook
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 */
do_action( 'woocommerce_before_main_content' );
if ( apply_filters( 'woocommerce_show_page_title', true ) ) :
    ?>

    <h1 class="page-title"><?php woocommerce_page_title(); ?></h1>

    <?php
endif;
do_action( 'woocommerce_archive_description' );
if ( have_posts() ) :

    /**
     * woocommerce_before_shop_loop hook
     *
     * @hooked woocommerce_result_count - 20
     * @hooked woocommerce_catalog_ordering - 30
     */
    do_action( 'woocommerce_before_shop_loop' );
    woocommerce_product_loop_start();
    woocommerce_product_subcategories();
    while ( have_posts() ) : the_post();
        wc_get_template_part( 'content', 'product' );
    endwhile; // end of the loop. 

    woocommerce_product_loop_end();
    /**
     * woocommerce_after_shop_loop hook
     *
     * @hooked woocommerce_pagination - 10
     */
    do_action( 'woocommerce_after_shop_loop' );
elseif ( !woocommerce_product_subcategories( array('before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false )) ) ) :

    wc_get_template( 'loop/no-products-found.php' );

endif;
/**
 * woocommerce_after_main_content hook
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

if (!empty($sidebar_position) && $sidebar_position != 'none') {
    echo '</div>';
}

if (!empty($sidebar_position)) {
    if ($sidebar_position == 'right') {
        get_sidebar();
    }
}

if (!empty($sidebar_position) && $sidebar_position != 'none') {
    echo '</div></div>';
}

get_footer( 'shop' );