<?php
/**
 * Variable product add to cart
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */
if (!defined('ABSPATH')) {
    exit;
}

global $product;

$attribute_keys = array_keys($attributes);

do_action('woocommerce_before_add_to_cart_form');
?>

<form class="variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint($product->id); ?>" data-product_variations="<?php echo esc_attr(json_encode($available_variations)) ?>">
    <?php do_action('woocommerce_before_variations_form'); ?>

    <?php if (empty($available_variations) && false !== $available_variations) : ?>
        <p class="stock out-of-stock"><?php esc_html_e('This product is currently out of stock and unavailable.', 'fuse-wp'); ?></p>
    <?php else : ?>
        <table class="variations" cellspacing="0">
            <tbody>
                <?php
                $cols2 = 0;
                foreach ($attributes as $attribute_name => $options) :
                    if ($cols2 == 0) {
                        echo '<tr>';
                    }
                    ?>
               
                <td>
                    <span class="label"><h4><?php echo wc_attribute_label($attribute_name); ?></h4></span>
                    <span class="value">
                    <?php
                    $selected = isset($_REQUEST['attribute_' . sanitize_title($attribute_name)]) ? wc_clean($_REQUEST['attribute_' . sanitize_title($attribute_name)]) : $product->get_variation_default_attribute($attribute_name);
                    wc_dropdown_variation_attribute_options(array('options' => $options, 'attribute' => $attribute_name, 'product' => $product, 'selected' => $selected));
                    echo end($attribute_keys) === $attribute_name ? '<a class="reset_variations" href="#">' . esc_html__('Clear selection', 'fuse-wp') . '</a>' : '';
                    ?>
                    </span>
                </td>
                <?php
                if ($cols2 == 0) {
                    $cols2 = 1;
                } else {
                    echo '</tr>';
                    $cols2 = 0;
                }
            endforeach;
            ?>
            </tbody>
        </table>

        <?php do_action('woocommerce_before_add_to_cart_button'); ?>

        <div class="single_variation_wrap" style="display:none;">
            <?php
            /**
             * woocommerce_before_single_variation Hook
             */
            do_action('woocommerce_before_single_variation');
            ?>
            <?php
            $availability = $product->get_availability();
            if (!empty($availability['availability'])) {
                ?>
                <h5 class="heading_availability"><strong><?php echo esc_html__('Availability: ', 'fuse-wp'); ?></strong></h5>
            <?php }woocommerce_single_variation(); ?>

            <?php wc_get_template('single-product/price.php'); ?>
            <div class="nfw_left"><?php woocommerce_single_variation_add_to_cart_button(); ?></div>
            <?php
            /**
             * woocommerce_after_single_variation Hook
             */
            do_action('woocommerce_after_single_variation');
            ?>
        </div>

        <?php
        do_action('woocommerce_after_add_to_cart_button');
    endif;
    do_action('woocommerce_after_variations_form');
    ?>
</form>

<?php
do_action('woocommerce_after_add_to_cart_form');
