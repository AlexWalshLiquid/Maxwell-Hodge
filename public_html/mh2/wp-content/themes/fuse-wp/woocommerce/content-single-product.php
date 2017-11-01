<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>

<?php
/**
 * woocommerce_before_single_product hook
 *
 * @hooked wc_print_notices - 10
 */
do_action('woocommerce_before_single_product');

if (post_password_required()) {
    echo get_the_password_form();
    return;
}

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
?>

<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php
    wc_get_template('single-product/sale-flash.php');

    global $post, $product;
    $product_images = $product->get_gallery_attachment_ids();
    $attachment_count = count($product_images);
    $min_images = $attachment_count;

    if (has_post_thumbnail()) {
        $min_images++;
    }
    if ($min_images >= 1) :
        ?>
        <div class="images">
            <?php
            if ($min_images > 1):
                ?>
            <div class="images-slider">
                <?php endif; ?>
                <ul class="slides">
                    <?php
                    if (has_post_thumbnail()) {
                        $image_data = get_the_post_thumbnail(get_the_id(), 'shop_single');
                        echo '<li>' . $image_data . '</li>';
                    }
                    if ($attachment_count > 0) {
                        foreach ($product_images as $product_image) {
                            $image_data = wp_get_attachment_image_src($product_image, 'shop_single');
                            $image_url = esc_url($image_data[0]);
                            echo '<li><img src="' . $image_url . '" alt=""></li>';
                        }
                    }
                    ?>
                </ul>
                <?php
                if ($min_images > 1):
                    ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="summary entry-summary">

        <?php
        global $product;
        if ($product->product_type != 'external' && $product->product_type != 'grouped') {
            wc_get_template('single-product/title.php');
            wc_get_template('single-product/rating.php');
            ?>
            <br>
            <?php
            wc_get_template('single-product/short-description.php');
            wc_get_template('single-product/meta.php');
            wc_get_template('single-product/share.php');
            if ($product->product_type == 'variable') {
                ?>
                <?php
            }
            do_action('woocommerce_' . $product->product_type . '_add_to_cart');
        } else {
            do_action('woocommerce_single_product_summary');
        }
        ?>

    </div><!-- .summary -->

    <?php
    /**
     * woocommerce_after_single_product_summary hook
     *
     * @hooked woocommerce_output_product_data_tabs - 10
     * @hooked woocommerce_upsell_display - 15
     * @hooked woocommerce_output_related_products - 20
     */
    do_action('woocommerce_after_single_product_summary');
    ?>

    <meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->

<?php
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

do_action('woocommerce_after_single_product');
