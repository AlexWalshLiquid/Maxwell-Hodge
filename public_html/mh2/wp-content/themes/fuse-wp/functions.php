<?php

if (!defined('ABSPATH')) {
    exit();
}

// CSS and JS files for the site
function nfw_front_styles_scripts() {

    wp_enqueue_style('nfw-font-awesome-admin', get_template_directory_uri() . '/assets/fonts/fontawesome/font-awesome.min.css');

    wp_enqueue_style('nfw-iconfontcustom-css', get_template_directory_uri() . '/assets/fonts/iconfontcustom/icon-font-custom.css');

    // gMap 
    //wp_enqueue_script('nfw_gmap_sensor_js', '//maps.google.com/maps/api/js?sensor=false', array('jquery'), false, true);

    // Combined scripts
    wp_enqueue_script('nfw_scripts_js', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), false, true);

    // custom scripts
    wp_enqueue_script('nfw_main_js', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), false, true);
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    if (isset($nfw_theme_options['nfw-smoothscroll-toggle'])) {
        if ($nfw_theme_options['nfw-smoothscroll-toggle'] == 1) {
            wp_enqueue_script('nfw_smoothscroll_js', get_template_directory_uri() . '/assets/vendors/smoothscroll/smoothscroll.js', array('jquery'), false, true);
        }
    }

    wp_enqueue_style('nfw_style_css', get_template_directory_uri() . '/style.css');

    wp_enqueue_style('nfw_fonts', nfw_fonts_url(), array(), null);
}

if (!is_admin()) {
    add_action('wp_enqueue_scripts', 'nfw_front_styles_scripts');
}

function nfw_custom_header_fonts() {
    wp_enqueue_style('nfw-fonts', nfw_fonts_url(), array(), null);
}

add_action('admin_print_styles-appearance_page_custom-header', 'nfw_custom_header_fonts');

function nfw_fonts_url() {
    $fonts_url = '';

    /* Translators: If there are characters in your language that are not
     * supported by Lora, translate this to 'off'. Do not translate
     * into your own language.
     */
    $roboto = esc_html_x('on', 'Roboto font: on or off', 'fuse-wp');

    /* Translators: If there are characters in your language that are not
     * supported by Open Sans, translate this to 'off'. Do not translate
     * into your own language.
     */
    $raleway = esc_html_x('on', 'Raleway font: on or off', 'fuse-wp');

    if ('off' !== $roboto || 'off' !== $raleway) {
        $font_families = array();

        if ('off' !== $roboto) {
            $font_families[] = 'Roboto:300,400,700,400italic,300italic,300,700italic';
        }

        if ('off' !== $raleway) {
            $font_families[] = 'Raleway:400,500,700';
        }

        $query_args = array(
            'family' => urlencode(implode('|', $font_families)),
            'subset' => urlencode('latin,latin-ext'),
        );

        $fonts_url = add_query_arg($query_args, '//fonts.googleapis.com/css');
    }

    return esc_url_raw($fonts_url);
}

function nfw_is_edit_page($new_edit = null) {
    global $pagenow;
    //make sure we are on the backend
    if (!is_admin()) {
        return false;
    }

    if ($new_edit == "edit") {
        return in_array($pagenow, array('post.php',));
    } else if ($new_edit == "new") {//check for new post page
        return in_array($pagenow, array('post-new.php'));
    } else {//check for either new or edit
        return in_array($pagenow, array('post.php', 'post-new.php'));
    }
}

// ENQUEUE SCRIPTS AND STYLES
// CSS and JS for admin panels
function nfw_admin_scripts_and_styles() {
    if (is_admin()) {
        wp_enqueue_media();
        global $typenow;
        global $pagenow;
        if (defined('ERP_PATH')) {
            $erp_slug = 'erp-portfolio';
        } else {
            $erp_slug = false;
        }
        wp_enqueue_script('wp-link');
        if (nfw_is_edit_page() && $erp_slug == $typenow || nfw_is_edit_page() || $pagenow == "nav-menus.php" || $pagenow == 'admin.php' || $pagenow == "widgets.php") {

            wp_enqueue_style('wp-color-picker');
            wp_enqueue_script('wp-color-picker');

            wp_enqueue_style('nfw-font-awesome-admin', get_template_directory_uri() . '/assets/fonts/fontawesome/font-awesome.min.css');

            wp_enqueue_style('nfw-iconfontcustom-css', get_template_directory_uri() . '/assets/fonts/iconfontcustom/icon-font-custom.css');

            wp_enqueue_script('nfw-functions-js', get_template_directory_uri() . '/framework/admin/js/functions.js', array('jquery', 'media-upload'), false, true);
            wp_localize_script('nfw-functions-js', 'nfw_ajax', array('ajaxurl' => admin_url('admin-ajax.php')));
        }
        wp_enqueue_style('nfw-styles-css', get_template_directory_uri() . '/framework/admin/css/styles.css');
    }
}

add_action('admin_enqueue_scripts', 'nfw_admin_scripts_and_styles');


// Set up the content width value based on the theme's design.
if (!isset($content_width)) {
    $content_width = 1170;
}

if (!function_exists('nfw_theme_config')) {

    function nfw_theme_config() {
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(1140, 0);

        // Crops the uploaded images to certain sizes used for different components and elements
        if (function_exists('add_image_size')) {
            add_image_size('nfw_iconbox_size', 115, 165, true);
            add_image_size('nfw_testimonial_size', 60, 60, true);
            add_image_size('nfw_team_size', 360, 360, true);
            add_image_size('nfw_post_size6', 555, 330, true);
            add_image_size('nfw_post_size4', 360, 215, true);
        }

        add_theme_support('menus');
        register_nav_menu('nfw-main-nav-menu', esc_html__('Fuse Menu', 'fuse-wp'));

        // translation file
        // Localization Support
        load_theme_textdomain('fuse-wp', get_template_directory() . '/languages');

        $locale = get_locale();
        $locale_file = get_template_directory() . "/languages/$locale.php";
        if (is_readable($locale_file)) {
            require_once($locale_file);
        }
        // Add RSS feed links to <head> for posts and comments.
        add_theme_support('automatic-feed-links');

        add_theme_support('title-tag');

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
        ));

        // Allows to link a custom stylesheet file to the TinyMCE visual editor
        add_editor_style(get_template_directory() . '/framework/admin/css/lists.css');

        // Add support for featured content.
        add_theme_support('featured-content', array(
            'featured_content_filter' => 'nfw_get_featured_content',
            'max_posts' => 6,
        ));

        add_theme_support('woocommerce');
    }

}
add_action('after_setup_theme', 'nfw_theme_config');

function nfw_custom_wp_title($title, $sep) {
    global $paged, $page;

    if (is_feed()) {
        return $title;
    } // end if
    // Add the site name.
    $title = get_bloginfo('name');
    $sep = '-';
    // Add the site description for the home/front page.
    $site_description = get_bloginfo('description', 'display');
    if ($site_description && ( is_home() || is_front_page() )) {
        $title = "$title $sep $site_description";
    } else if (is_search()) {
        $title = esc_html__('Search', 'fuse-wp') . " $sep $title";
    } else if (is_tag()) {
        $title = esc_html__('Tag', 'fuse-wp') . " $sep $title";
    } else if (is_category()) {
        $title = esc_html__('Category', 'fuse-wp') . " $sep $title";
    } else if (is_tax()) {
        $title = esc_html__('Taxonomy', 'fuse-wp') . " $sep $title";
    } else if (is_archive()) {
        $title = esc_html__('Archive', 'fuse-wp') . " $sep $title";
    } else {
        $title = get_the_title() . " $sep $title";
    }
    // Add a page number if necessary.
    if ($paged >= 2 || $page >= 2) {
        $title = sprintf(esc_html__('Page %s', 'fuse-wp'), max($paged, $page)) . " $sep $title";
    } // end if

    return esc_html($title);
}

add_filter('wp_title', 'nfw_custom_wp_title', 10, 2);


/*
 * conditional statement will show the featured content if at least there is one present
 * and while the page is not being paged (it is not in the second page onwards).
 */

function nfw_get_featured_content($num = 1) {
    global $featured;
    $featured = apply_filters('nfw_featured_content', array());

    if (is_array($featured) || $num >= count($featured))
        return true;

    return false;
}

// A helper conditional function that returns a boolean value.
function nfw_has_featured_posts() {
    return !is_paged() && (bool) nfw_get_featured_content();
}

// Pagination function
function nfw_pagination($pages = '', $range = 3) {
    $showitems = ($range * 2) + 1;
    //$showitems = $range-1;

    global $paged;
    if (empty($paged))
        $paged = 1;

    if ($pages == '') {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if (!$pages) {
            $pages = 1;
        }
    }

    if (1 != $pages) {
        echo "<ul class=\"pagination\">";

        if ($paged > 2 && $paged > $range + 1 && $showitems < $pages) {
            echo "<li class=\"page-numbers prev\"><a  href='" . esc_url(get_pagenum_link(1)) . "' title='" . esc_html__('First page', 'fuse-wp') . "'>&lt;</a></li>";
        }

        for ($i = 1; $i <= $pages; $i++) {
            if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems )) {
                echo ($paged == $i) ? "<li class=\"page-numbers nav-links current\"><a href='" . esc_url(get_pagenum_link($i)) . "'>" . $i . "</a></li>" :
                        "<li class=\"page-numbers nav-links\"><a href='" . esc_url(get_pagenum_link($i)) . "'>" . esc_html($i) . "</a></li>";
            }
        }

        if ($paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages) {
            echo "<li class=\"page-numbers next\"><a href='" . esc_url(get_pagenum_link($pages)) . "' title='" . esc_html__('Last page', 'fuse-wp') . "'>&gt;</a></li>";
        }

        echo "</ul>\n";
    }
}

function nfw_add_editor_styles() {
    add_editor_style(get_template_directory() . '/framework/admin/css/lists.css');
}

add_action('admin_init', 'nfw_add_editor_styles');

// Add Formats Dropdown Menu To MCE
if (!function_exists('nfw_style_select')) {

    function nfw_style_select($buttons) {
        array_push($buttons, 'styleselect');
        return $buttons;
    }

}

add_filter('mce_buttons', 'nfw_style_select');
// Add new styles to the TinyMCE "formats" menu dropdown
if (!function_exists('nfw_styles_dropdown')) {

    function nfw_styles_dropdown($settings) {

        // Create array of new styles
        $new_styles = array(
            array(
                'title' => esc_html__('List Styles', 'fuse-wp'),
                'items' => array(
                    array(
                        'title' => esc_html__('Check', 'fuse-wp'),
                        'selector' => 'ul',
                        'classes' => 'check'
                    ),
                    array(
                        'title' => esc_html__('Square', 'fuse-wp'),
                        'selector' => 'ul',
                        'classes' => 'square'
                    ),
                    array(
                        'title' => esc_html__('Fill Circle', 'fuse-wp'),
                        'selector' => 'ul',
                        'classes' => 'fill-circle'
                    ),
                    array(
                        'title' => esc_html__('Circle', 'fuse-wp'),
                        'selector' => 'ul',
                        'classes' => 'circle'
                    )
                )
            )
        );

        // Merge old & new styles
        $settings['style_formats_merge'] = true;

        // Add new styles
        $settings['style_formats'] = json_encode($new_styles);

        // Return New Settings
        return $settings;
    }

}
add_filter('tiny_mce_before_init', 'nfw_styles_dropdown');

// Widget areas
function nfw_widgets_init() {
    // creates the default sidebar
    register_sidebar(array(
        'name' => esc_html__('Default Sidebar', 'fuse-wp'),
        'id' => 'nfw-default-sidebar',
        'description' => esc_html__('Default widget area', 'fuse-wp'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));

    // Generates the the top widget areas of the footer
    for ($count = 1; $count <= 4; $count++) {
        register_sidebar(array(
            'name' => esc_html__('Footer Widget Area ', 'fuse-wp') . $count,
            'id' => 'nfw-footer-top-sidebar-' . $count,
            'description' => esc_html__('Widget area', 'fuse-wp'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="widget-title">',
            'after_title' => '</h4>',
        ));
    }

    // Generates the the middle widget areas of the footer
    for ($count = 1; $count <= 4; $count++) {
        register_sidebar(array(
            'name' => esc_html__('Footer Middle Widget Area ', 'fuse-wp') . $count,
            'id' => 'nfw-footer-middle-sidebar-' . $count,
            'description' => esc_html__('Widget area', 'fuse-wp'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="widget-title">',
            'after_title' => '</h4>',
        ));
    }

    for ($count = 1; $count <= 4; $count++) {
        register_sidebar(array(
            'name' => esc_html__('Footer Bottom Widget Area ', 'fuse-wp') . $count,
            'id' => 'nfw-footer-bottom-sidebar-' . $count,
            'description' => esc_html__('Widget area', 'fuse-wp'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="widget-title">',
            'after_title' => '</h4>',
        ));
    }


    $option_name = 'nfw-sidebars-custom';
    if (get_option($option_name) != false) {

        $sidebars_array = get_option($option_name);
        if ($sidebars_array != null) {
            $count = count($sidebars_array);
            $j = 0;

            for ($i = 0; $i < $count; $i = $i + 2) {

                // Stores sidebars titles
                $sidebars_title[$j] = esc_html($sidebars_array[$i]);
                // Stores sidebars description
                $sidebars_description[$j] = esc_html($sidebars_array[$i + 1]);

                if (function_exists('register_sidebar')) {
                    // Registers each sidebar with title and description
                    register_sidebar(array(
                        'name' => $sidebars_title[$j],
                        'id' => sanitize_title_with_dashes($sidebars_title[$j]) . '-' . $j,
                        'description' => $sidebars_description[$j],
                        'before_widget' => '<div id="%1$s" class="widget %2$s">',
                        'after_widget' => '</div>',
                        'class' => 'nfw-sidebars-custom',
                        'before_title' => '<h4 class="widget-title">',
                        'after_title' => '</h4>',
                    ));
                }
                $j++;
            }
        }
    }
}

add_action('widgets_init', 'nfw_widgets_init');

function nfw_excerpt($more) {
    return '...';
}

add_filter('excerpt_more', 'nfw_excerpt');

if (defined('WPB_VC_VERSION')) {
    include_once(trailingslashit(get_template_directory()) . 'framework/composer/init.php');
}

include_once(trailingslashit(get_template_directory()) . 'framework/admin/theme-options/theme_options.php');
include_once(trailingslashit(get_template_directory()) . 'framework/plugins/required_plugins.php');
include_once(trailingslashit(get_template_directory()) . 'framework/metaboxes.php');
include_once(trailingslashit(get_template_directory()) . 'framework/sidebar_ajax.php');
include_once(trailingslashit(get_template_directory()) . 'framework/widgets.php');
// Global value used to determine the first menu item
global $nfw_mega_menu;
global $nfw_mega_section;
$nfw_mega_menu = 0;
$nfw_mega_section = 0;

class nfw_Nav_Menu_Walker extends Walker_Nav_Menu {

    function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
        $this->child_count = ( isset($children_elements[$element->ID]) ) ? count($children_elements[$element->ID]) : 0;
        $this->ID = $element->ID;
        $this->depth = $depth;
        $this->have_current = true;
        $mega_count = 0;

        if ($this->child_count > 0) {

            foreach ($children_elements[$element->ID] as $child) {
                if (isset($child->classes)) {
                    foreach ($child->classes as $class) {
                        if ($class == 'nfw-nav-mega-enabled') {
                            $mega_count++;
                        }
                    }
                }
            }
        }
        $element->classes[] = 'mega-section-count-' . $mega_count;
        parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }

    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $indent = ( $depth ) ? str_repeat("\t", $depth) : '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $check = $check2 = 0;
        foreach ($classes as $class_single) {
            if (trim($class_single) == 'menu-item-has-children') {
                $check = 1;
            }
            if (trim($class_single) == 'nfw-nav-mega-enabled') {
                $check2 = 1;
            }
        }
        $classes[] = 'menu-item-' . $item->ID;
        if ($check == 1 && $check2 == 0) {
            $classes[] = 'dropdown';
        }

        /**
         * Filter the CSS class(es) applied to a menu item's <li>.
         *
         * @since 3.0.0
         *
         * @see wp_nav_menu()
         *
         * @param array  $classes The CSS classes that are applied to the menu item's <li>.
         * @param object $item    The current menu item.
         * @param array  $args    An array of wp_nav_menu() arguments.
         */
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));

        $class_parts = explode(' ', $class_names);

        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $mega_count = 0;

        foreach ($class_parts as $class_part) {
            $mega_count_class = explode('mega-section-count-', $class_names);

            if (isset($mega_count_class[1])) {
                $mega_count = (int) $mega_count_class[1];
            }
        }

        /**
         * Filter the ID applied to a menu item's <li>.
         *
         * @since 3.0.1
         *
         * @see wp_nav_menu()
         *
         * @param string $menu_id The ID that is applied to the menu item's <li>.
         * @param object $item    The current menu item.
         * @param array  $args    An array of wp_nav_menu() arguments.
         */
        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $nfw_mega_menu_start = $nfw_mega_section_start = '';
        global $nfw_mega_section;
        global $nfw_mega_menu;


        if ($depth == 0) {

            foreach ($classes as $class) {
                if (trim($class) == "nfw-nav-mega-enabled") {
                    $mega_col = '';
                    if ($mega_count != 0) {
                        if ($mega_count >= 4) {
                            $mega_col = ' sf-mega-4-col';
                        } else {
                            $mega_col = ' sf-mega-' . $mega_count . '-col';
                        }
                    }

                    $nfw_mega_menu_start = '<div class="sf-mega' . $mega_col . '">';
                    $nfw_mega_menu = 1;
                }
            }
        }

        if ($depth == 1) {
            foreach ($classes as $class) {
                if (trim($class) == "nfw-nav-mega-enabled" && $nfw_mega_menu == 1) {
                    if ($nfw_mega_section == 1) {
                        $output .= '</ul></div>';
                    }
                    $nfw_mega_section_start = '<div class="sf-mega-section"><ul>';
                    $nfw_mega_section = 1;
                }
            }
        }

        if ($nfw_mega_section_start != '') {
            $output .= $nfw_mega_section_start;
        }
        $output .= $indent . '<li' . $id . $class_names . '>';

        $atts = array();
        $atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel'] = !empty($item->xfn) ? $item->xfn : '';
        $atts['href'] = !empty($item->url) ? $item->url : '';

        /**
         * Filter the HTML attributes applied to a menu item's <a>.
         *
         * @since 3.6.0
         *
         * @see wp_nav_menu()
         *
         * @param array $atts {
         *     The HTML attributes applied to the menu item's <a>, empty strings are ignored.
         *
         *     @type string $title  Title attribute.
         *     @type string $target Target attribute.
         *     @type string $rel    The rel attribute.
         *     @type string $href   The href attribute.
         * }
         * @param object $item The current menu item.
         * @param array  $args An array of wp_nav_menu() arguments.
         */
        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ( 'href' === $attr ) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        /** This filter is documented in wp-includes/post-template.php */
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';
        if ($nfw_mega_menu_start != '') {
            $item_output .= $nfw_mega_menu_start;
        }
        $item_output .= $args->after;

        /**
         * Filter a menu item's starting output.
         *
         * The menu item's starting output only includes $args->before, the opening <a>,
         * the menu item's title, the closing </a>, and $args->after. Currently, there is
         * no filter for modifying the opening and closing <li> for a menu item.
         *
         * @since 3.0.0
         *
         * @see wp_nav_menu()
         *
         * @param string $item_output The menu item's starting HTML output.
         * @param object $item        Menu item data object.
         * @param int    $depth       Depth of menu item. Used for padding.
         * @param array  $args        An array of wp_nav_menu() arguments.
         */
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    function end_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        global $nfw_mega_section;
        global $nfw_mega_menu;
        if ($nfw_mega_section == 1) {
            $output .= '</ul></div></div>';
            $nfw_mega_section = 0;
            $output .= "$indent\n";
            $nfw_mega_menu = 0;
        } else {
            $output .= "$indent</ul>\n";
        }
    }

    function start_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        global $nfw_mega_menu;
        if ($nfw_mega_menu == 1) {
            $output .= "\n$indent\n";
        } else {
            $output .= "\n$indent<ul class=\"sub-menu\">\n";
        }
    }

}

add_filter('the_content_more_link', 'nfw_read_more_link');

function nfw_read_more_link() {
    return '<p><a class="more-link btn btn-grey" href="' . get_permalink() . '">' . esc_html__('Read the article', 'fuse-wp') . '</a></p>';
}

add_filter('wp_nav_menu_items', 'nfw_append_to_nav', 10, 2);

function nfw_append_to_nav($items, $args) {
    if ($args->theme_location == 'nfw-main-nav-menu') {
        global $nfw_theme_options;
        if (isset($nfw_theme_options['nfw-header-search-toggle'])) {
            if ($nfw_theme_options['nfw-header-search-toggle'] == 1) {
                $items .= '<li class="menu-search"><a id="custom-search-button" href="#"><i class="ifc-search"></i><span>' . esc_html__('Search', 'fuse-wp') . '</span></a>
               <div id="custom-search-form-container"><form id="custom-search-form" name="search-form" action="' . home_url('/') . '">
               <input type="submit" id="custom-search-submit" value="">
               <input type="text" placeholder="' . esc_html__('Search here and press enter...', 'fuse-wp') . '" name="s" id="s"></form></div></li>';
            }
        }

        if (defined('WOOCOMMERCE_VERSION')) {
            $items .= '<li class="dropdown menu-cart"><a class="cart-contents" href="' . WC()->cart->get_cart_url() . '">
            <span class="cart-link-text"><i class="fa fa-shopping-cart"></i> 
            <span>' . esc_html__('Cart', 'fuse-wp') . ' (' . WC()->cart->cart_contents_count . ')</span></span></a><ul><li>
            <div class="widget woocommerce widget_shopping_cart">
            <h5>Cart content</h5><div class="divider single-line"></div><div class="widget_shopping_cart_content"><h5>Cart content</h5><div class="divider single-line"></div>
            </div></div></li></ul></li>';
        }
        if (defined('ICL_SITEPRESS_VERSION')) {
            $languages = icl_get_languages('skip_missing=0');
            $active = $lang_list = '';

            foreach ($languages as $language) {
                if ($language['active'] == 1) {
                    $active = '<a href="' . $language['url'] . '"><span>' . esc_html__('Language: ', 'fuse-wp') . '</span>' . $language['language_code'] . '</a>';
                }
                $lang_list.='<li><a href="' . $language['url'] . '">' . $language['translated_name'] . '</a></li>';
            }
            $items .= '<li class="menu-language dropdown">' . $active . '<ul>' . $lang_list . '</ul></li>';
        }
    }
    return $items;
}
