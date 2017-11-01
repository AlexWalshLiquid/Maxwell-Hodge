<?php
/**
 * The Header template for nfw theme
 */
if (!defined('ABSPATH')) {
    exit();
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
    <head>
        <meta charset="<?php echo esc_attr(bloginfo('charset')); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> 

        <?php
        global $nfw_theme_options;
        ?>

        <meta name="msapplication-TileColor" content="<?php
        if (isset($nfw_theme_options['nfw-color-android-theme'])) {
            echo esc_attr($nfw_theme_options['nfw-color-android-theme']);
        } else {
            echo '#000';
        }
        ?>">
        <meta name="theme-color" content="<?php
        if (isset($nfw_theme_options['nfw-ms-color'])) {
            echo esc_attr($nfw_theme_options['nfw-ms-color']);
        } else {
            echo '#000';
        }
        ?>">

        <?php
        wp_head();
        ?>
<link href="http://www.maxwellhodge.co.uk/mh2/wp-content/addedCSS/additional_styles.css"  rel="stylesheet" type="text/css"  media="all"  />
<link href="http://www.maxwellhodge.co.uk/mh2/wp-content/addedCSS/additional_styles.css"  rel="stylesheet" type="text/css"  media="all"  />

    </head>

    <body <?php
    $body_class = '';
    if (isset($nfw_theme_options['nfw-header-stickyheader-toggle'])) {
        if ($nfw_theme_options['nfw-header-stickyheader-toggle'] == 1) {
            $body_class.=' sticky-header';
        }
    }
    body_class($body_class);
    ?>>
            <?php
            if (is_page() || get_post_type() == 'erp-portfolio' && !is_search()) {
                $post_id = get_queried_object_id();
            } else {
                $post_id = get_option('page_for_posts');
            }

            if (function_exists('is_shop')) {

                if (is_singular('product')) {
                    $post_id = get_the_id();
                } else if (is_shop() || get_post_type() == 'product') {
                    $post_id = get_option('woocommerce_shop_page_id');
                }
            }

            $header_text = $image_header = $font_color = $header_parallax = '';

            if (is_search()) {
                $header_text = sprintf(esc_html__('The search for %s returned:', 'fuse-wp'), get_search_query());
                $page_header_toggle = 'Enable';
                $image_header[0] = '';
            } else {

                $page_header_toggle = get_post_meta($post_id, 'nfw_header_toggle', true);
                if ($page_header_toggle == null) {
                    update_post_meta($post_id, 'nfw_header_toggle', 'Enable');
                    update_post_meta($post_id, 'nfw_header_title', get_the_title($post_id));
                    $page_header_toggle = 'Enable';
                }

                if ($page_header_toggle == 'Enable') {
                    $header_text = get_post_meta($post_id, 'nfw_header_title', true);
                    $font_color = get_post_meta($post_id, 'nfw_header_font_color', true);
                    $header_image_id = get_post_meta($post_id, 'nfw_header_image', true);
                    $image_header = wp_get_attachment_image_src($header_image_id, 'full');
                    $header_parallax = get_post_meta($post_id, 'nfw_header_parallax', true);
                }
            }
            ?>  

        <div id="wrap">

            <div id="header-wrap">
                <div id="header">                        

                    <!-- /// HEADER  //////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

                    <div class="<?php
                    if (isset($nfw_theme_options['nfw-header-fullwidth-menu'])) {
                        if ($nfw_theme_options['nfw-header-fullwidth-menu'] == 1) {
                            echo 'container-fluid';
                        } else {
                            echo 'container';
                        }
                    } else {
                        echo 'container-fluid';
                    }
                    ?>">
                        <div class="row">
                            <div class="span3">

                                <!-- // Logo // -->
                                <div id="logo">
                                    <a href="<?php echo esc_url(home_url()); ?>">
                                        <img src="<?php
                                        if (isset($nfw_theme_options['nfw-header-logo'])) {
                                            echo esc_url($nfw_theme_options['nfw-header-logo']['url']);
                                        }
                                        ?>" alt="website logo">
                                    </a>
                                </div>

                            </div><!-- end .span3 -->
                            <div class="span9">

                                <!-- // Mobile menu trigger // -->

                                <a href="#" id="mobile-menu-trigger">
                                    <i class="fa fa-bars"></i>
                                </a>

                                <!-- // Menu // -->
                                <nav>
                                    <?php
                                    // Wordpress navigation menu
                                    if (has_nav_menu('nfw-main-nav-menu')) {
                                        wp_nav_menu(array(
                                            'theme_location' => 'nfw-main-nav-menu',
                                            'container' => false,
                                            'fallback_cb' => false,
                                            'items_wrap' => '<ul id="menu" class="sf-menu fixed">%3$s</ul>',
                                            'walker' => new nfw_Nav_Menu_Walker())
                                        );
                                    } else {
                                        $menu_items = '';
                                        if (isset($nfw_theme_options['nfw-header-search-toggle'])) {
                                            if ($nfw_theme_options['nfw-header-search-toggle'] == 1) {
                                                $menu_items .= '<li class="menu-search"><a id="custom-search-button" href="#"><i class="ifc-search"></i><span>' . esc_html__('Search', 'fuse-wp') . '</span></a>
                                                                <div id="custom-search-form-container"><form id="custom-search-form" name="search-form" action="' . esc_url(home_url('/')) . '">
                                                                <input type="submit" id="custom-search-submit" value="">
                                                                <input type="text" placeholder="' . esc_html__('Search here and press enter...', 'fuse-wp') . '" name="s" id="s"></form></div></li>';
                                            }
                                        }
                                        if (defined('WOOCOMMERCE_VERSION')) {
                                            $menu_items .= '<li class="dropdown menu-cart"><a class="cart-contents" href="' . WC()->cart->get_cart_url() . '">
                                                            <span class="cart-link-text"><i class="fa fa-shopping-cart"></i> 
                                                            <span>' . esc_html__('Cart', 'fuse-wp') . ' (' . WC()->cart->cart_contents_count . ')</span></span></a><ul><li>
                                                            <div class="widget woocommerce widget_shopping_cart">
                                                            <h5>Cart content</h5><div class="divider single-line"></div><div class="widget_shopping_cart_content">
                                                            <h5>Cart content</h5><div class="divider single-line"></div>
                                                            </div></div></li></ul></li>';
                                        }

                                        if (defined('ICL_SITEPRESS_VERSION')) {
                                            $languages = icl_get_languages('skip_missing=0');
                                            $active = $lang_list = '';

                                            foreach ($languages as $language) {
                                                if ($language['active'] == 1) {
                                                    $active = '<a href="' . esc_url($language['url']) . '"><span>' . esc_html__('Language: ', 'fuse-wp') . '</span>' . $language['language_code'] . '</a>';
                                                }
                                                $lang_list.='<li><a href="' . esc_url($language['url']) . '">' . $language['translated_name'] . '</a></li>';
                                            }
                                            $menu_items .= '<li class="menu-language dropdown">' . $active . '<ul>' . $lang_list . '</ul></li>';
                                        }

                                        if ($menu_items != '') {
                                            ?>
                                            <ul id="menu" class="sf-menu fixed">
                                                <?php echo $menu_items; ?>
                                            </ul>
                                            <?php
                                        }
                                    }
                                    ?>
                                </nav>	

                            </div><!-- end .span9 -->
                        </div><!-- end .row -->		
                    </div><!-- end .container -->

                    <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

                </div><!-- end #header -->
            </div><!-- end #header-wrap -->	
            <div id="content">
                <?php if ($page_header_toggle == 'Enable') : ?>
                    <div id="page-header"<?php
                    if (trim($image_header[0]) != '') {
                        if ($header_parallax != '') {
                            echo ' class="parallax"';
                        }
                        echo ' style="background-image:url(' . esc_url($image_header[0]) . ');"';
                    }
                    ?>>

                        <div class="container">
                            <div class="row">
                                <div class="span12">

                                    <?php if (trim($header_text) != '') { ?>
                                        <div class="page-header-title"<?php if (trim($font_color) != '') echo ' style="color:' . esc_attr($font_color) . ';"'; ?>><?php echo esc_html($header_text); ?></div>
                                    <?php } ?>

                                </div><!-- end .span12 -->
                            </div><!-- end .row -->
                        </div><!-- end .container -->

                    </div><!-- end #page-header -->
                <?php endif; ?>