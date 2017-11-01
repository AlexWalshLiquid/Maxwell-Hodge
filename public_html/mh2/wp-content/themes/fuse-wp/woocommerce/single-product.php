<?php

/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

get_header();
$sidebar_position = get_post_meta(get_the_ID(), 'nfw_sidebar_position', true);

if (!empty($sidebar_position) && $sidebar_position != 'none') {
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

while ( have_posts() ) : the_post();

    wc_get_template_part( 'content', 'single-product' );


endwhile; // end of the loop. 

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

get_footer();