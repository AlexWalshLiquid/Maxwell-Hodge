<?php
/**
 * Simple product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $product;

if (!$product->is_purchasable()) {
    return;
}

// Availability
$availability = $product->get_availability();
$availability_html = empty($availability['availability']) ? '' : '<h5 class="heading_availability"><strong>'. esc_html__('Availability: ', 'fuse-wp').'</strong></h5><p class="stock ' . esc_attr($availability['class']) . '">' . esc_html($availability['availability']) . '</p><br>';

echo apply_filters('woocommerce_stock_html', $availability_html, $availability['availability'], $product);

if ($product->is_in_stock()) :

    do_action('woocommerce_before_add_to_cart_form');
    ?>
    <form class="cart" method="post" enctype='multipart/form-data'>
        <div class="price_wrap">
        <?php
        wc_get_template('single-product/price.php');?>
        </div>
<?php
        do_action('woocommerce_before_add_to_cart_button');
        if (!$product->is_sold_individually()) {
            woocommerce_quantity_input(array(
                'min_value' => apply_filters('woocommerce_quantity_input_min', 1, $product),
                'max_value' => apply_filters('woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product),
                'input_value' => ( isset($_POST['quantity']) ? wc_stock_amount($_POST['quantity']) : 1 )
            ));
        }
        ?>

        <input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product->id); ?>" />

        <button type="submit" class="single_add_to_cart_button button alt"><?php echo esc_html($product->single_add_to_cart_text()); ?></button>

        <?php do_action('woocommerce_after_add_to_cart_button'); ?>
    </form>

    <?php
    do_action('woocommerce_after_add_to_cart_form'); 

 endif;
