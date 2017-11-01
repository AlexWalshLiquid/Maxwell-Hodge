<?php

if (!defined('ABSPATH')) {
    exit();
}

include_once( dirname(__FILE__) . '/ReduxCore/framework.php' );

// Removes the demo
function nfw_removeDemoModeLink() {
    if (class_exists('ReduxFrameworkPlugin')) {
        remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2);
    }
    if (class_exists('ReduxFrameworkPlugin')) {
        remove_action('admin_notices', array(ReduxFrameworkPlugin::get_instance(), 'admin_notices'));
    }
}

add_action('init', 'nfw_removeDemoModeLink');

// Adds the custom CSS and the custom color schemes 
add_action('wp_head', 'nfw_theme_options_styles');

function nfw_theme_options_styles() {
    if (!is_admin()) {
        global $nfw_theme_options;

        echo '<style type="text/css">' . "\n";

        if (is_admin_bar_showing()) {
            echo '#header.stuck {padding-top: 40px;} #custom-search-form #s {margin: 75px auto;} #custom-search-submit {top: 80px;}';
        }
        
        $nfw_header_padding = 0;

        if( isset( $nfw_theme_options['nfw-header-menu-padding'] ) ){
            $nfw_header_padding = $nfw_theme_options['nfw-header-menu-padding'];
        }

        if( $nfw_header_padding != 0 ){
            echo '@media (min-width: 1300px) { 
                #header-wrap { padding-top: ' . absint( $nfw_header_padding ) . 'px; } 
                }';
        }

        $nfw_header_offset = 0;

        if( isset( $nfw_theme_options['nfw-header-menu-offset'] ) ){
            $nfw_header_offset = $nfw_theme_options['nfw-header-menu-offset'];
        }

        if( $nfw_header_offset > 0 ){
            echo '.sf-menu { margin-top: ' . absint( $nfw_header_offset ) . 'px; }';
        }

        $nfw_accent_colors_enable = 0;

        if (isset($nfw_theme_options['nfw-accent-colors-enable'])) {
            $nfw_accent_colors_enable = $nfw_theme_options['nfw-accent-colors-enable'];
        }
        if ($nfw_accent_colors_enable == 1) {

            $body_font = "#333";
            if (isset($nfw_theme_options['nfw-color-body-font'])) {
                if (preg_match('/(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i', $nfw_theme_options['nfw-color-body-font'])) {
                    $body_font = $nfw_theme_options['nfw-color-body-font'];
                }
            }

            if ($body_font != "#333") {
                echo 'body { color: ' . esc_attr($body_font) . '; }';
            }

            $headings_font = "#000";
            if (isset($nfw_theme_options['nfw-color-headings-font'])) {
                if (preg_match('/(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i', $nfw_theme_options['nfw-color-headings-font'])) {
                    $headings_font = $nfw_theme_options['nfw-color-headings-font'];
                }
            }

            if ($headings_font != "#000") {
                echo 'h1, 
                    h2, 
                    h3, 
                    h4, 
                    h5, 
                    h6 { color: ' . esc_attr($headings_font) . '; }';
            }

            $color_accent = "#000";
            if (isset($nfw_theme_options['nfw-color-scheme-accent'])) {
                if (preg_match('/(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i', $nfw_theme_options['nfw-color-scheme-accent'])) {
                    $color_accent = $nfw_theme_options['nfw-color-scheme-accent'];
                }
            }
            
            if ($color_accent != "#000") {
                
                echo '.alert,
                    .btn
                    .icon-box-1 > i,
                    .horizontal-process-builder li i,
                    .horizontal-process-builder li h1,
                    .vertical-process-builder li i,
                    .vertical-process-builder li h1,
                    a.social-icon,
                    .bx-wrapper .bx-pager.bx-default-pager a,
                    .woocommerce-pagination .page-numbers .page-numbers.current,
                    .woocommerce-pagination .page-numbers li:hover,
                    .woocommerce-pagination .page-numbers.current li,
                    .custom-color .team-member .social-media,
                    ul.check li:before,
                    button,
                    input[type="reset"],
                    input[type="submit"],
                    input[type="button"],
                    #mobile-menu li.menu-cart .btn,
                    .format-quote .post-content blockquote,
                    .pagination .page-numbers a:hover,
                    .pagination .current a,
                    .comment-list .reply a,
                    .comment-form #submit,
                    .widget_recent_entries ul li .post-date
                    { border-color: ' . esc_attr($color_accent) . '; }';

                echo '.fuse-a .vc_tta-panel-title a:hover,
                    .btn-black,
                    .woocommerce #respond input#submit, 
                    .woocommerce a.button, 
                    .woocommerce button.button, 
                    .woocommerce input.button
                    { border-color: ' . esc_attr($color_accent) . ' !important; }';

              echo '.sf-arrows .sf-with-ul:after
                    { border-top-color: ' . esc_attr($color_accent) . '; }';

              echo '.icon-box-1:hover > i,
                    .horizontal-process-builder li:hover i,
                    .horizontal-process-builder li:hover h1,
                    .vertical-process-builder li:hover i,
                    .vertical-process-builder li:hover h1,
                    .progress-bar .progress-bar-outer,
                    .tp-caption.price,
                    .bx-wrapper .bx-pager.bx-default-pager a:hover,
                    .bx-wrapper .bx-pager.bx-default-pager a.active,
                    .woocommerce-pagination .page-numbers li a.page-numbers:hover,
                    .woocommerce-pagination .page-numbers .page-numbers.current,
                    .woocommerce-pagination .page-numbers li:hover,
                    .woocommerce-pagination .page-numbers.current li,
                    .text-highlight,
                    #back-to-top,
                    .sticky-post,
                    .pagination .page-numbers a:hover,
                    .pagination .current a,
                    #wp-calendar tbody a,
                    #wp-calendar #today
                    { background-color: ' . esc_attr($color_accent) . '; }';
              
                echo '.btn-black,
                    .woocommerce #respond input#submit, 
                    .woocommerce a.button, 
                    .woocommerce button.button, 
                    .woocommerce input.button
                    { background-color: ' . esc_attr($color_accent) . ' !important; }';

                echo '
                    { color: ' . esc_attr($color_accent) . '; }';

                echo '
                    { color: ' . esc_attr($color_accent) . ' !important; }';

            }
            
            $color_accent1 = "#000";
            if (isset($nfw_theme_options['nfw-color-scheme-accent1'])) {
                if (preg_match('/(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i', $nfw_theme_options['nfw-color-scheme-accent1'])) {
                    $color_accent1 = $nfw_theme_options['nfw-color-scheme-accent1'];
                }
            }
            
            if ($color_accent1 != "#000") {
                
                echo '.fuse-h .vc_tta-tab.vc_active a
                    .fuse-v .vc_tta-tab.vc_active a,
                    .alert,
                    .btn,
                    a.btn,
                    .icon-box-1 > i,
                    .icon-box-2 > i,
                    .icon-box-3 > i,
                    .milestone .milestone-content,
                    .horizontal-process-builder li:after,
                    .horizontal-process-builder li i,
                    .horizontal-process-builder li h1,
                    .vertical-process-builder li:after,
                    .vertical-process-builder li i,
                    .vertical-process-builder li h1,
                    .pie-chart i, 
                    .pie-chart .pie-chart-custom-text, 
                    .pie-chart .pie-chart-percent,
                    .pie-chart-description,
                    .pricing-table-offer ul,
                    .progress-bar-description,
                    .tp-caption.title-3,
                    .tp-caption .btn:hover,
                    a.social-icon,
                    .custom-color .team-member .social-media,
                    .custom-color .portfolio-item-overlay-actions a,
                    a, 
                    a:visited,
                    ul.project-details li span,
                    ul.fill-circle li:before,
                    ul.check li:before,
                    button,
                    input[type="reset"],
                    input[type="submit"],
                    input[type="button"],
                    .format-quote .post-content blockquote,
                    .format-aside .post-content,
                    .format-status .post-content,
                    .format-link .post-content a,
                    .pagination .prev:hover,
                    .pagination .prev:focus,
                    .pagination .next:hover,
                    .pagination .next:focus,
                    .comment-author a,
                    .comment-list .reply a,
                    .comment-form #submit,
                    #footer .widget_tag_cloud a:hover,
                    h3.price span
                    { color: ' . esc_attr($color_accent1) . '; }';

                echo '.fuse-a .vc_tta-panel-title a,
                    .fuse-h .vc_tta-tab a,
                    .fuse-v .vc_tta-tab a,
                    .woocommerce div.product .woocommerce-tabs ul.tabs li a
                    { color: ' . esc_attr($color_accent1) . ' !important; }';

            }
            
            $color_accent2 = "#777777";
            if (isset($nfw_theme_options['nfw-color-scheme-accent2'])) {
                if (preg_match('/(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i', $nfw_theme_options['nfw-color-scheme-accent2'])) {
                    $color_accent2 = $nfw_theme_options['nfw-color-scheme-accent2'];
                }
            }
            
            if ($color_accent2 != "#777777") {
                
                echo '.alert.info,
                    .icon-box-2:hover > i,
                    .pricing-table-header h1,
                    .tp-caption.text,
                    .team-member h6,
                    .product .summary h1.price small,
                    .sf-mega li.sf-mega-section-title,
                    #custom-search-form a.custom-search-form-close,
                    .posted-on a,
                    .byline a,
                    .cat-links a,
                    .tags-links a,
                    .comments-link a,
                    .post-format a,
                    .full-size-link a,
                    .format-quote .post-content blockquote:before,
                    .format-quote .post-content blockquote h5,
                    .format-link .post-content:before,
                    .pagination .page-numbers.dots a:hover,
                    .comment-meta a,
                    .widget_pages a,
                    .widget_archive a,
                    .widget_product_categories a,
                    .widget_categories a,
                    .widget_meta a,
                     .widget_product_tag_cloud a,
                    .widget_tag_cloud a,
                    .widget_nav_menu a,
                    .nfw_widget_navigation a
                    { color: ' . esc_attr($color_accent2) . '; }';

                echo '.alert.info
                    { border-color: ' . esc_attr($color_accent2) . '; }';
                
                echo '.sf-arrows > li > .sf-with-ul:focus:after,
                    .sf-arrows > li:hover > .sf-with-ul:after,
                    .sf-arrows > .sfHover > .sf-with-ul:after
                    { border-top-color: ' . esc_attr($color_accent2) . '; }';

                echo '.sf-arrows ul li > .sf-with-ul:focus:after,
                    .sf-arrows ul li:hover > .sf-with-ul:after,
                    .sf-arrows ul .sfHover > .sf-with-ul:after
                    { border-left-color: ' . esc_attr($color_accent2) . '; }';
                
                echo '.sf-arrows li.dropdown:last-child ul li > .sf-with-ul:focus:after,
                    .sf-arrows li.dropdown:last-child ul li:hover > .sf-with-ul:after,
                    .sf-arrows li.dropdown:last-child ul .sfHover > .sf-with-ul:after 
                    { border-right-color: ' . esc_attr($color_accent2) . '; }';

                echo '.custom-color .progress-bar .progress-bar-outer
                    { background-color: ' . esc_attr($color_accent2) . '; }';

            }
            
            $menu_font = "#212121";

            if (isset($nfw_theme_options['nfw-color-scheme-menu'])) {
                if (preg_match('/(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i', $nfw_theme_options['nfw-color-scheme-menu'])) {
                    $menu_font = $nfw_theme_options['nfw-color-scheme-menu'];
                }
            }

            if ($menu_font != "#212121") {
                echo '.sf-menu a,
                    .sf-menu > li > a,
                    .sf-menu > li.dropdown > a,
                    #mobile-menu li > a,
                    #mobile-menu .mobile-menu-submenu-arrow
                    { color: ' . esc_attr($menu_font) . '; }';
            }

            $menu_hover = "#999999";

            if (isset($nfw_theme_options['nfw-color-hover-menu'])) {
                if (preg_match('/(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i', $nfw_theme_options['nfw-color-hover-menu'])) {
                    $menu_hover = $nfw_theme_options['nfw-color-hover-menu'];
                }
            }

            if ($menu_hover != "#999999") {
                echo '.sf-menu > li.current > a,
                    .sf-menu li.sfHover > a,
                    .sf-menu a:hover,
                    .sf-menu li.sfHover a:hover,
                    .sf-menu > li.current-menu-parent > a,
                    .header-style-2 .sf-menu > li.current > a
                    { color: ' . esc_attr($menu_hover) . '; }';
            }
             $footer_top_font = "#ffffff";

            if (isset($nfw_theme_options['nfw-color-footer-top-font'])) {
                if (preg_match('/(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i', $nfw_theme_options['nfw-color-footer-top-font'])) {
                    $footer_top_font = $nfw_theme_options['nfw-color-footer-top-font'];
                }
            }

            if ($footer_top_font != "#ffffff") {
                echo '#footer-top,
                    #footer-top a,
                        #footer h1, 
                        #footer-top h2, 
                        #footer-top h3, 
                        #footer-top h4, 
                        #footer-top h5, 
                        #footer-top h6 
                        { color: ' . esc_attr($footer_top_font) . '; }';
            }

            $footer_top_background = "#000";

            if (isset($nfw_theme_options['nfw-color-footer-top-background'])) {
                if (preg_match('/(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i', $nfw_theme_options['nfw-color-footer-top-background'])) {
                    $footer_top_background = $nfw_theme_options['nfw-color-footer-top-background'];
                }
            }

            if ($footer_top_background != "#000") {
                echo '#footer-top { background-color: ' . esc_attr($footer_top_background) . '; }';
            }

            $footer_font = "#ffffff";

            if (isset($nfw_theme_options['nfw-color-footer-font'])) {
                if (preg_match('/(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i', $nfw_theme_options['nfw-color-footer-font'])) {
                    $footer_font = $nfw_theme_options['nfw-color-footer-font'];
                }
            }

            if ($footer_font != "#ffffff") {
                echo '#footer,
                    #footer a,
                    #footer h1, 
                        #footer h2, 
                        #footer h3, 
                        #footer h4, 
                        #footer h5, 
                        #footer h6 
                        { color: ' . esc_attr($footer_font) . '; }';
            }

            $footer_background = "#000";

            if (isset($nfw_theme_options['nfw-color-footer-background'])) {
                if (preg_match('/(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i', $nfw_theme_options['nfw-color-footer-background'])) {
                    $footer_background = $nfw_theme_options['nfw-color-footer-background'];
                }
            }

            if ($footer_background != "#000") {
                echo '#footer { background-color: ' . esc_attr($footer_background) . '; }';
            }

            $footer_bottom_font = "#ffffff";

            if (isset($nfw_theme_options['nfw-color-footer-bottom-font'])) {
                if (preg_match('/(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i', $nfw_theme_options['nfw-color-footer-bottom-font'])) {
                    $footer_bottom_font = $nfw_theme_options['nfw-color-footer-bottom-font'];
                }
            }

            if ($footer_bottom_font != "#ffffff") {
                echo '#footer-bottom,
                    #footer-bottom a,
                    #footer h1, 
                        #footer-bottom h2, 
                        #footer-bottom h3, 
                        #footer-bottom h4, 
                        #footer-bottom h5, 
                        #footer-bottom h6 
                        { color: ' . esc_attr($footer_bottom_font) . '; }';
            }

            $footer_bottom_background = "#000";

            if (isset($nfw_theme_options['nfw-color-footer-bottom-background'])) {
                if (preg_match('/(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i', $nfw_theme_options['nfw-color-footer-bottom-background'])) {
                    $footer_bottom_background = $nfw_theme_options['nfw-color-footer-bottom-background'];
                }
            }

            if ($footer_bottom_background != "#000") {
                echo '#footer-bottom { background-color: ' . esc_attr($footer_bottom_background) . '; }';
            }
            
        }

        /* Theme options custom css related field */
        $nfw_custom_css = "";
        if (isset($nfw_theme_options['nfw-custom-css'])) {
            $nfw_custom_css = $nfw_theme_options['nfw-custom-css'];
        }
        if (trim($nfw_custom_css) != '') {
            print $nfw_custom_css;
        }

        echo '</style>' . "\n";
    }
}

function nfw_hex_to_rgba($color, $opacity = false) {

    $default = 'rgb(0,0,0)';

    //Return default if no color provided
    if (empty($color))
        return $default;

    //Sanitize $color if "#" is provided 
    if ($color[0] == '#') {
        $color = substr($color, 1);
    }

    //Check if color has 6 or 3 characters and get values
    if (strlen($color) == 6) {
        $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
    } elseif (strlen($color) == 3) {
        $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
    } else {
        return $default;
    }

    //Convert hexadec to rgb
    $rgb = array_map('hexdec', $hex);

    //Check if opacity is set(rgba or rgb)
    if ($opacity) {
        if (abs($opacity) > 1)
            $opacity = 1.0;
        $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
    } else {
        $output = 'rgb(' . implode(",", $rgb) . ')';
    }

    //Return rgb(a) color string
    return $output;
}

/**
 * ReduxFramework Sample Config File
 * For full documentation, please visit: http://docs.reduxframework.com/
 */
if (!class_exists('Redux')) {
    return;
}


// This is your option name where all the Redux data is stored.
$opt_name = "nfw_theme_options";


/*
 *
 * --> Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
 *
 */

$sampleHTML = '';
if (file_exists(dirname(__FILE__) . '/info-html.html')) {
    Redux_Functions::initWpFilesystem();

    global $wp_filesystem;

    $sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
}

// Background Patterns Reader
$sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
$sample_patterns_url = ReduxFramework::$_url . '../sample/patterns/';
$sample_patterns = array();

if (is_dir($sample_patterns_path)) {

    if ($sample_patterns_dir = opendir($sample_patterns_path)) {
        $sample_patterns = array();

        while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {

            if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                $name = explode('.', $sample_patterns_file);
                $name = str_replace('.' . end($name), '', $sample_patterns_file);
                $sample_patterns[] = array(
                    'alt' => $name,
                    'img' => $sample_patterns_url . $sample_patterns_file
                );
            }
        }
    }
}

/*
 *
 * --> Action hook examples
 *
 */

// If Redux is running as a plugin, this will remove the demo notice and links
//add_action( 'redux/loaded', 'remove_demo' );
// Function to test the compiler hook and demo CSS output.
// Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
//add_filter('redux/options/' . $opt_name . '/compiler', 'compiler_action', 10, 3);
// Change the arguments after they've been declared, but before the panel is created
//add_filter('redux/options/' . $opt_name . '/args', 'change_arguments' );
// Change the default value of a field after it's been set, but before it's been useds
//add_filter('redux/options/' . $opt_name . '/defaults', 'change_defaults' );
// Dynamically add a section. Can be also used to modify sections/fields
//add_filter('redux/options/' . $opt_name . '/sections', 'dynamic_section');


/**
 * ---> SET ARGUMENTS
 * All the possible arguments for Redux.
 * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
 * */
$theme = wp_get_theme(); // For use with some settings. Not necessary.

$args = array(
    // TYPICAL -> Change these values as you need/desire
    'opt_name' => $opt_name,
    // This is where your data is stored in the database and also becomes your global variable name.
    'display_name' => $theme->get('Name'),
    // Name that appears at the top of your panel
    'display_version' => $theme->get('Version'),
    // Version that appears at the top of your panel
    'menu_type' => 'menu',
    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
    'allow_sub_menu' => true,
    // Show the sections below the admin menu item or not
    'menu_title' => esc_html__('Theme Options', 'fuse-wp'),
    'page_title' => esc_html__('Theme Options', 'fuse-wp'),
    // You will need to generate a Google API key to use this feature.
    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
    'google_api_key' => '',
    // Set it you want google fonts to update weekly. A google_api_key value is required.
    'google_update_weekly' => false,
    // Must be defined to add google fonts to the typography module
    'async_typography' => true,
    // Use a asynchronous font on the front end or font string
    //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
    'admin_bar' => true,
    // Show the panel pages on the admin bar
    'admin_bar_icon' => 'dashicons-portfolio',
    // Choose an icon for the admin bar menu
    'admin_bar_priority' => 50,
    // Choose an priority for the admin bar menu
    'global_variable' => '',
    // Set a different name for your global variable other than the opt_name
    'dev_mode' => false,
    // Show the time the page took to load, etc
    'update_notice' => false,
    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
    'customizer' => true,
    // Enable basic customizer support
    //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
    //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field
    // OPTIONAL -> Give you extra features
    'page_priority' => 57,
    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
    'page_parent' => 'themes.php',
    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
    'page_permissions' => 'manage_options',
    // Permissions needed to access the options panel.
    'menu_icon' => '',
    // Specify a custom URL to an icon
    'last_tab' => '',
    // Force your panel to always open to a specific tab (by id)
    'page_icon' => 'icon-themes',
    // Icon displayed in the admin panel next to your menu_title
    'page_slug' => '',
    // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
    'save_defaults' => true,
    // On load save the defaults to DB before user clicks save or not
    'default_show' => false,
    // If true, shows the default value next to each field that is not the default value.
    'default_mark' => '',
    // What to print by the field's title if the value shown is default. Suggested: *
    'show_import_export' => true,
    // Shows the Import/Export panel when not used as a field.
    // CAREFUL -> These options are for advanced use only
    'transient_time' => 60 * MINUTE_IN_SECONDS,
    'output' => true,
    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
    'output_tag' => true,
    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.
    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
    'database' => '',
    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
    'system_info' => false,
    // REMOVE
    //'compiler'             => true,
    // HINTS
    'hints' => array(
        'icon' => 'el el-question-sign',
        'icon_position' => 'right',
        'icon_color' => 'lightgray',
        'icon_size' => 'normal',
        'tip_style' => array(
            'color' => 'red',
            'shadow' => true,
            'rounded' => false,
            'style' => '',
        ),
        'tip_position' => array(
            'my' => 'top left',
            'at' => 'bottom right',
        ),
        'tip_effect' => array(
            'show' => array(
                'effect' => 'slide',
                'duration' => '500',
                'event' => 'mouseover',
            ),
            'hide' => array(
                'effect' => 'slide',
                'duration' => '500',
                'event' => 'click mouseleave',
            ),
        ),
    )
);

Redux::setArgs($opt_name, $args);

/*
 * ---> END ARGUMENTS
 */


/*
 * ---> START HELP TABS
 */

$tabs = array(
    array(
        'id' => 'redux-help-tab-1',
        'title' => esc_html__('Theme Information 1', 'fuse-wp'),
        'content' => esc_html__('<p>This is the tab content, HTML is allowed.</p>', 'fuse-wp')
    ),
    array(
        'id' => 'redux-help-tab-2',
        'title' => esc_html__('Theme Information 2', 'fuse-wp'),
        'content' => esc_html__('<p>This is the tab content, HTML is allowed.</p>', 'fuse-wp')
    )
);
Redux::setHelpTab($opt_name, $tabs);

// Set the help sidebar
$content = esc_html__('<p>This is the sidebar content, HTML is allowed.</p>', 'fuse-wp');
Redux::setHelpSidebar($opt_name, $content);


/*
 * <--- END HELP TABS
 */


/*
 *
 * ---> START SECTIONS
 *
 */

/*

  As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for


 */

// -> START Basic Fields
$page_ids = get_all_page_ids();
$pages_array = array();
$pages_array['default'] = 'Default';
foreach ($page_ids as $page_id) {
    // do not include the Auto Draft pages
    if (get_the_title($page_id) != 'Auto Draft') {
        $pages_array[$page_id] = esc_html(get_the_title($page_id));
    }
}
Redux::setSection($opt_name, array(
    'icon' => 'el-icon-cogs',
    'title' => esc_html__('General', 'fuse-wp'),
    'subsection' => false,
    'fields' => array(
        array(
            'id' => 'nfw-smoothscroll-toggle',
            'type' => 'button_set',
            'title' => esc_html__('Smoothscoll enable', 'fuse-wp'),
            'desc' => esc_html__('Toggle On or Off', 'fuse-wp'),
            'options' => array(
                '1' => 'On',
                '2' => 'Off'
            ),
            'default' => '2'
        ),
        array(
            'id' => 'nfw-404-selection',
            'type' => 'select',
            'title' => esc_html__('404 Page Selection', 'fuse-wp'),
            'subtitle' => esc_html__('Can replace the page displayed when error 404 occurs', 'fuse-wp'),
            'desc' => esc_html__('Chose a page for 404 error', 'fuse-wp'),
            'options' => $pages_array,
            'default' => 'default',
        ),
        array(
            'id' => 'nfw-custom-css',
            'type' => 'textarea',
            'title' => esc_html__('Custom CSS', 'fuse-wp'),
            'subtitle' => esc_html__('Only CSS code allowed', 'fuse-wp'),
            'desc' => esc_html__('This field is CSS validated.', 'fuse-wp'),
            'validate' => 'css',
        )
    )
));

Redux::setSection($opt_name, array(
    'icon' => 'el-icon-home',
    'title' => esc_html__('Header', 'fuse-wp'),
    'subsection' => false,
    'fields' => array(
        array(
            'id' => 'nfw-header-stickyheader-toggle',
            'type' => 'button_set',
            'title' => esc_html__('Sticky Header', 'fuse-wp'),
            'subtitle' => esc_html__('Enable or disable the sticky header', 'fuse-wp'),
            'desc' => esc_html__('Toggle On or Off', 'fuse-wp'),
            'options' => array(
                '1' => 'On',
                '2' => 'Off'
            ),
            'default' => '1'
        ),
        array(
            'id' => 'nfw-header-logo',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('Header Logo Selection', 'fuse-wp'),
            'desc' => esc_html__('Upload a new logo image', 'fuse-wp'),
            'subtitle' => esc_html__('Replace or remove the existing logo', 'fuse-wp'),
            'default' => array(
                'url' => get_template_directory_uri() . '/assets/images/logo.png')
        ),
        array(
            'id' => 'nfw-header-search-toggle',
            'type' => 'button_set',
            'title' => esc_html__('Header Search', 'fuse-wp'),
            'subtitle' => esc_html__('Enable or disable the header search', 'fuse-wp'),
            'desc' => esc_html__('Toggle On or Off', 'fuse-wp'),
            'options' => array(
                '1' => 'On',
                '2' => 'Off'
            ),
            'default' => '1'
        ),
        array(
            'id' => 'nfw-header-fullwidth-menu',
            'type' => 'button_set',
            'title' => esc_html__('Header menu fullwidth', 'fuse-wp'),
            'subtitle' => esc_html__('Enable or disable the fullwidth menu', 'fuse-wp'),
            'desc' => esc_html__('Toggle On or Off', 'fuse-wp'),
            'options' => array(
                '1' => 'On',
                '2' => 'Off'
            ),
            'default' => '1'
        ),
        array(
            'id' => 'nfw-header-menu-padding',
            'type' => 'slider',
            'title' => esc_html__( 'Header Height', 'fuse-wp' ),
            'subtitle' => esc_html__( 'Allows you to adjust header height. It is needed when the custom logo you add does not fit in the header.', 'fuse-wp' ),
            'desc' => esc_html__( 'If needed, adjust height until you are happy with how the logo fits in the header', 'fuse-wp' ),
            "default" => 0,
            "min" => 0,
            "step" => 1,
            "max" => 500,
            'display_value' => 'text'
        ),
        array(
            'id' => 'nfw-header-menu-offset',
            'type' => 'slider',
            'title' => esc_html__( 'Header Menu Offset', 'fuse-wp' ),
            'subtitle' => esc_html__( 'Allows you to adjust menu position. It is needed when you want to adjust the menu position to the menu logo.', 'fuse-wp' ),
            "default" => 0,
            "min" => 0,
            "step" => 1,
            "max" => 500,
            'display_value' => 'text'
        ),
    )
));
Redux::setSection($opt_name, array(
    'icon' => 'el-icon-credit-card',
    'title' => esc_html__('Footer', 'fuse-wp'),
    'subsection' => false,
    'fields' => array(
        array(
            'id' => 'nfw-footer-top-switch',
            'type' => 'button_set',
            'title' => esc_html__('Footer Top', 'fuse-wp'),
            'subtitle' => esc_html__('Enable or disable footer area', 'fuse-wp'),
            'desc' => esc_html__('Enable or disable footer area', 'fuse-wp'),
            'options' => array(
                '1' => 'Enable',
                '2' => 'Disable'
            ),
            'default' => '1'
        ),
        array(
            'id' => 'nfw-footer-top-layout',
            'type' => 'image_select',
            'required' => array('nfw-footer-top-switch', 'equals', '1'),
            'title' => esc_html__('Footer Top Layout', 'fuse-wp'),
            'subtitle' => esc_html__('Select the number of widgetable areas', 'fuse-wp'),
            'options' => array(
                '1' => array(
                    'alt' => '1 Area',
                    'title' => '1',
                    'img' => get_template_directory_uri() . '/framework/admin/images/l1.png'
                ),
                '2' => array(
                    'alt' => '2 Areas',
                    'title' => '2',
                    'img' => get_template_directory_uri() . '/framework/admin/images/l2.png'
                ),
                '3' => array(
                    'alt' => '3 Areas',
                    'title' => '3',
                    'img' => get_template_directory_uri() . '/framework/admin/images/l3.png'
                ),
                '4' => array(
                    'alt' => '4 Areas',
                    'title' => '4',
                    'img' => get_template_directory_uri() . '/framework/admin/images/l4.png'
                )
            ),
            'default' => '4'
        ),
        array(
            'id' => 'nfw-footer-middle-switch',
            'type' => 'button_set',
            'title' => esc_html__('Footer Middle', 'fuse-wp'),
            'subtitle' => esc_html__('Enable or disable footer middle area', 'fuse-wp'),
            'desc' => esc_html__('Enable or disable footer middle area', 'fuse-wp'),
            'options' => array(
                '1' => 'Enable',
                '2' => 'Disable'
            ),
            'default' => '1'
        ),
        array(
            'id' => 'nfw-footer-middle-layout',
            'type' => 'image_select',
            'required' => array('nfw-footer-middle-switch', 'equals', '1'),
            'title' => esc_html__('Footer Middle Layout', 'fuse-wp'),
            'subtitle' => esc_html__('Select the number of widgetable areas', 'fuse-wp'),
            'options' => array(
                '1' => array(
                    'alt' => '1 Area',
                    'title' => '1',
                    'img' => get_template_directory_uri() . '/framework/admin/images/l1.png'
                ),
                '2' => array(
                    'alt' => '2 Areas',
                    'title' => '2',
                    'img' => get_template_directory_uri() . '/framework/admin/images/l2.png'
                ),
                '3' => array(
                    'alt' => '3 Areas',
                    'title' => '3',
                    'img' => get_template_directory_uri() . '/framework/admin/images/l3.png'
                ),
                '4' => array(
                    'alt' => '4 Areas',
                    'title' => '4',
                    'img' => get_template_directory_uri() . '/framework/admin/images/l4.png'
                )
            ),
            'default' => '4'
        ),
        array(
            'id' => 'nfw-footer-bottom-switch',
            'type' => 'button_set',
            'title' => esc_html__('Footer Bottom', 'fuse-wp'),
            'subtitle' => esc_html__('Enable or disable footer bottom area', 'fuse-wp'),
            'desc' => esc_html__('Enable or disable footer bottom area', 'fuse-wp'),
            'options' => array(
                '1' => 'Enable',
                '2' => 'Disable'
            ),
            'default' => '1'
        ),
        array(
            'id' => 'nfw-footer-bottom-layout',
            'type' => 'image_select',
            'required' => array('nfw-footer-bottom-switch', 'equals', '1'),
            'title' => esc_html__('Footer Bottom Layout', 'fuse-wp'),
            'subtitle' => esc_html__('Select the number of widgetable areas', 'fuse-wp'),
            'options' => array(
                '1' => array(
                    'alt' => '1 Area',
                    'title' => '1',
                    'img' => get_template_directory_uri() . '/framework/admin/images/l1.png'
                ),
                '2' => array(
                    'alt' => '2 Areas',
                    'title' => '2',
                    'img' => get_template_directory_uri() . '/framework/admin/images/l2.png'
                ),
                '3' => array(
                    'alt' => '3 Areas',
                    'title' => '3',
                    'img' => get_template_directory_uri() . '/framework/admin/images/l3.png'
                ),
                '4' => array(
                    'alt' => '4 Areas',
                    'title' => '4',
                    'img' => get_template_directory_uri() . '/framework/admin/images/l4.png'
                )
            ),
            'default' => '4'
        )
    )
));

Redux::setSection($opt_name, array(
    'icon' => 'el-icon-list',
    'title' => esc_html__('Color Schemes', 'fuse-wp'),
    'subsection' => false,
    'fields' => array(
        array(
            'id' => 'nfw-accent-colors-enable',
            'type' => 'button_set',
            'title' => esc_html__('Color scheme', 'fuse-wp'),
            'subtitle' => esc_html__('Enable or disable custom color scheme', 'fuse-wp'),
            'desc' => esc_html__('If it is disabled, then the default color scheme will be used.', 'fuse-wp'),
            'options' => array(
                '1' => 'Enable',
                '2' => 'Disable'
            ),
            'default' => '2'
        ),
        array(
            'id' => 'nfw-color-scheme-accent',
            'type' => 'color',
            'required' => array('nfw-accent-colors-enable', 'equals', '1'),
            'title' => esc_html__('Borders and backgrounds color', 'fuse-wp'),
            'subtitle' => esc_html__('Pick a color for theme borders and backgrounds', 'fuse-wp'),
            'default' => '#000',
            'transparent' => false,
            'validate' => 'color',
        ),
        array(
            'id' => 'nfw-color-scheme-accent1',
            'type' => 'color',
            'required' => array('nfw-accent-colors-enable', 'equals', '1'),
            'title' => esc_html__('Components font color', 'fuse-wp'),
            'subtitle' => esc_html__('Pick a color for theme components font color', 'fuse-wp'),
            'default' => '#000',
            'transparent' => false,
            'validate' => 'color',
        ),
        array(
            'id' => 'nfw-color-scheme-accent2',
            'type' => 'color',
            'required' => array('nfw-accent-colors-enable', 'equals', '1'),
            'title' => esc_html__('Secondary color', 'fuse-wp'),
            'subtitle' => esc_html__('Pick a color for theme secondary color', 'fuse-wp'),
            'default' => '#777777',
            'transparent' => false,
            'validate' => 'color',
        ),
        array(
            'id' => 'nfw-color-body-font',
            'type' => 'color',
            'required' => array('nfw-accent-colors-enable', 'equals', '1'),
            'title' => esc_html__('Body font color', 'fuse-wp'),
            'subtitle' => esc_html__('Pick a font color', 'fuse-wp'),
            'default' => '#333',
            'transparent' => false,
            'validate' => 'color',
        ),
        array(
            'id' => 'nfw-color-headings-font',
            'type' => 'color',
            'required' => array('nfw-accent-colors-enable', 'equals', '1'),
            'title' => esc_html__('Headings font color', 'fuse-wp'),
            'subtitle' => esc_html__('Pick a font color', 'fuse-wp'),
            'default' => '#000',
            'transparent' => false,
            'validate' => 'color',
        ),
        array(
            'id' => 'nfw-color-scheme-menu',
            'type' => 'color',
            'required' => array('nfw-accent-colors-enable', 'equals', '1'),
            'title' => esc_html__('Menu font color', 'fuse-wp'),
            'subtitle' => esc_html__('Pick a font color', 'fuse-wp'),
            'default' => '#212121',
            'transparent' => false,
            'validate' => 'color',
        ),
        array(
            'id' => 'nfw-color-hover-menu',
            'type' => 'color',
            'required' => array('nfw-accent-colors-enable', 'equals', '1'),
            'title' => esc_html__('Menu hover font color', 'fuse-wp'),
            'subtitle' => esc_html__('Pick a font color', 'fuse-wp'),
            'default' => '#999999',
            'transparent' => false,
            'validate' => 'color',
        ),
        array(
            'id' => 'nfw-color-footer-top-background',
            'type' => 'color',
            'required' => array('nfw-accent-colors-enable', 'equals', '1'),
            'title' => esc_html__('Footer top background color', 'fuse-wp'),
            'subtitle' => esc_html__('Pick a footer top background color', 'fuse-wp'),
            'default' => '#000',
            'transparent' => false,
            'validate' => 'color',
        ),
        array(
            'id' => 'nfw-color-footer-top-font',
            'type' => 'color',
            'required' => array('nfw-accent-colors-enable', 'equals', '1'),
            'title' => esc_html__('Footer top font color', 'fuse-wp'),
            'subtitle' => esc_html__('Pick a footer top font color', 'fuse-wp'),
            'default' => '#ffffff',
            'transparent' => false,
            'validate' => 'color',
        ),
        array(
            'id' => 'nfw-color-footer-background',
            'type' => 'color',
            'required' => array('nfw-accent-colors-enable', 'equals', '1'),
            'title' => esc_html__('Footer background color', 'fuse-wp'),
            'subtitle' => esc_html__('Pick a footer background color', 'fuse-wp'),
            'default' => '#000',
            'transparent' => false,
            'validate' => 'color',
        ),
        array(
            'id' => 'nfw-color-footer-font',
            'type' => 'color',
            'required' => array('nfw-accent-colors-enable', 'equals', '1'),
            'title' => esc_html__('Footer font color', 'fuse-wp'),
            'subtitle' => esc_html__('Pick a footer font color', 'fuse-wp'),
            'default' => '#ffffff',
            'transparent' => false,
            'validate' => 'color',
        ),
        array(
            'id' => 'nfw-color-footer-bottom-background',
            'type' => 'color',
            'required' => array('nfw-accent-colors-enable', 'equals', '1'),
            'title' => esc_html__('Footer bottom background color', 'fuse-wp'),
            'subtitle' => esc_html__('Pick a footer bottom background color', 'fuse-wp'),
            'default' => '#000',
            'transparent' => false,
            'validate' => 'color',
        ),
        array(
            'id' => 'nfw-color-footer-bottom-font',
            'type' => 'color',
            'required' => array('nfw-accent-colors-enable', 'equals', '1'),
            'title' => esc_html__('Footer bottom font color', 'fuse-wp'),
            'subtitle' => esc_html__('Pick a footer bottom font color', 'fuse-wp'),
            'default' => '#ffffff',
            'transparent' => false,
            'validate' => 'color',
        ),
        array(
            'id' => 'nfw-color-android-theme',
            'type' => 'color',
            'required' => array('nfw-accent-colors-enable', 'equals', '1'),
            'title' => esc_html__('Android theme color', 'fuse-wp'),
            'subtitle' => esc_html__('Pick a color', 'fuse-wp'),
            'default' => '#000',
            'transparent' => false,
            'validate' => 'color',
        ),
        array(
            'id' => 'nfw-ms-color',
            'type' => 'color',
            'required' => array('nfw-accent-colors-enable', 'equals', '1'),
            'title' => esc_html__('Mstile theme color', 'fuse-wp'),
            'subtitle' => esc_html__('Pick a color', 'fuse-wp'),
            'default' => '#000',
            'transparent' => false,
            'validate' => 'color',
        )
    )
));

/*
 * <--- END SECTIONS
 */

/**
 * This is a test function that will let you see when the compiler hook occurs.
 * It only runs if a field    set with compiler=>true is changed.
 * */
function compiler_action($options, $css, $changed_values) {
    echo '<h1>The compiler hook has run!</h1>';
    echo "<pre>";
    print_r($changed_values); // Values that have changed since the last save
    echo "</pre>";
    //print_r($options); //Option values
    //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
}

/**
 * Custom function for the callback validation referenced above
 * */
if (!function_exists('redux_validate_callback_function')) {

    function redux_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $warning = false;

        //do your validation
        if ($value == 1) {
            $error = true;
            $value = $existing_value;
        } elseif ($value == 2) {
            $warning = true;
            $value = $existing_value;
        }

        $return['value'] = $value;

        if ($error == true) {
            $return['error'] = $field;
            $field['msg'] = 'your custom error message';
        }

        if ($warning == true) {
            $return['warning'] = $field;
            $field['msg'] = 'your custom warning message';
        }

        return $return;
    }

}

/**
 * Custom function for the callback referenced above
 */
if (!function_exists('redux_my_custom_field')) {

    function redux_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }

}

/**
 * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
 * Simply include this function in the child themes functions.php file.
 * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
 * so you must use get_template_directory_uri() if you want to use any of the built in icons
 * */
function dynamic_section($sections) {
    //$sections = array();
    $sections[] = array(
        'title' => esc_html__('Section via hook', 'fuse-wp'),
        'desc' => esc_html__('This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.', 'fuse-wp'),
        'icon' => 'el el-paper-clip',
        // Leave this as a blank section, no options just some intro text set above.
        'fields' => array()
    );

    return $sections;
}

/**
 * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
 * */
function change_arguments($args) {
    //$args['dev_mode'] = true;

    return $args;
}

/**
 * Filter hook for filtering the default value of any given field. Very useful in development mode.
 * */
function change_defaults($defaults) {
    $defaults['str_replace'] = 'Testing filter hook!';

    return $defaults;
}

// Remove the demo link and the notice of integrated demo from the redux-framework plugin
function remove_demo() {

    // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
    if (class_exists('ReduxFrameworkPlugin')) {
        remove_filter('plugin_row_meta', array(
            ReduxFrameworkPlugin::instance(),
            'plugin_metalinks'
                ), null, 2);

        // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
        remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
    }
}
