<?php

if (!defined('ABSPATH')) {
    exit();
}
add_action("wp_ajax_nfw_admin_custom_sidebars", "nfw_admin_custom_sidebars");
add_action("wp_ajax_nopriv_nfw_admin_custom_sidebars", "nfw_admin_custom_sidebars");

// Provides the response results for load more grid type portfolio
function nfw_admin_custom_sidebars() {

    if (!is_admin()){
        die(esc_html__( 'Access denied!', 'fuse-wp' ));
    }

    $title = $_REQUEST["title"];
    $description = $_REQUEST["description"];

    $option_name = 'nfw-sidebars-custom';
    if (trim($title) != '' && trim($description) != '') {
        if (get_option($option_name) == false) {
            $sidebars_array = array();
            $current_count = 0;
            $check = 0;
        } else {
            $check = 0;
            $sidebars_array = get_option($option_name);
            $current_count = count($sidebars_array);

            for ($i = 0; $i < $current_count; $i = $i + 2) {

                if (sanitize_title_with_dashes($sidebars_array[$i]) == sanitize_title_with_dashes($title)) {
                    $check = 1;
                }
            }
        }

        if ($check == 0) {
            $sidebars_array[$current_count] = esc_html($title);
            $current_count++;
            $sidebars_array[$current_count] = esc_html($description);

            update_option($option_name, $sidebars_array);
            $result = 'created';
        } else {
            $result = esc_html__('A sidebar with this name already exists', 'fuse-wp');
        }
    } else if (trim($title) == '') {
        $result = esc_html__('Please specify a title', 'fuse-wp');
    } else {
        $result = esc_html__('Please specify a description', 'fuse-wp');
    }
    // Verifies the HTTP request
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        // Encodes and provides the response output
        echo json_encode($result);
    } else {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }

    die();
}

add_action("wp_ajax_nfw_remove_sidebar", "nfw_remove_sidebar");
add_action("wp_ajax_nopriv_nfw_remove_sidebar", "nfw_remove_sidebar");

function nfw_remove_sidebar() {

    if (!is_admin()){
        die(esc_html__( 'Access denied!', 'fuse-wp' ));
    }
    
    $sidebar_id = $_REQUEST["sidebar_id"];
    $parts = explode('-', $sidebar_id);
    $last = count($parts) - 1;
    unset($parts[$last]);
    $sidebar_check = implode('-', $parts);
    $removed_sidebar = 0;

    $option_name = 'nfw-sidebars-custom';
    if (get_option($option_name) !== false) {
        $sidebars_array = get_option($option_name);
        $count = count($sidebars_array);

        for ($i = 0; $i < $count; $i = $i + 2) {

            if (sanitize_title_with_dashes($sidebars_array[$i]) == sanitize_text_field($sidebar_check)) {
                unset($sidebars_array[$i]);
                $removed_sidebar = $i + 1;
                unset($sidebars_array[$removed_sidebar]);
            }
        }

        $sidebars_array = array_values($sidebars_array);
        update_option('nfw-sidebars-custom', $sidebars_array);
    }

    // Verifies the HTTP request
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        // Encodes and provides the response output
        if ($removed_sidebar != 0) {
            $result['sidebar_id'] = $sidebar_id;
            echo json_encode($result);
        }
    } else {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }

    die();
}

