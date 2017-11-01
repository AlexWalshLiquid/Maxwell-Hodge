<?php

if ( !defined( 'ABSPATH' ) ) {
    exit();
}
// Meta box structure for custom sidebars field in the edit page section of the admin
$nfw_meta_box = array(
    'id' => 'nfw-page-sidebar',
    'title' => esc_html__( 'Page Layout and Sidebar Manager', 'fuse-wp' ),
    'page' => 'page',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        // Sidebar positioning options
        array(
            'name' => esc_html__( 'Page Layout', 'fuse-wp' ),
            'id' => 'nfw_sidebar_position',
            'type' => 'radio',
            'options' => array(
                array('name' => 'Left', 'value' => 'left'),
                array('name' => 'None', 'value' => 'none'),
                array('name' => 'Right', 'value' => 'right')
            )
        ),
        // Sidebars list
        array(
            'name' => esc_html__( 'Sidebar', 'fuse-wp' ),
            'id' => 'nfw_sidebar_source',
            'type' => 'select'
        )
    )
);

add_action( 'admin_menu', 'nfw_sidebar_add_box' );

// Add the meta box
function nfw_sidebar_add_box () {
    global $nfw_meta_box;
    add_meta_box( $nfw_meta_box['id'], $nfw_meta_box['title'], 'nfw_sidebar_show_box', $nfw_meta_box['page'], $nfw_meta_box['context'], $nfw_meta_box['priority'] );
    if ( defined( 'ERP_PATH' ) ) {
        add_meta_box( $nfw_meta_box['id'], $nfw_meta_box['title'], 'nfw_sidebar_show_box', 'erp-portfolio', $nfw_meta_box['context'], $nfw_meta_box['priority'] );
    }
    if ( function_exists('is_shop') ) {
        add_meta_box( $nfw_meta_box['id'], $nfw_meta_box['title'], 'nfw_sidebar_show_box', 'product', $nfw_meta_box['context'], $nfw_meta_box['priority'] );
    }
}

// Callback function to show fields in meta box
function nfw_sidebar_show_box () {
    global $nfw_meta_box, $post;
    // Use nonce for verification

    echo '<input type="hidden" name="nfw_sidebar_meta_box_nonce" value="' . esc_attr( wp_create_nonce( get_template_directory() ) ) . '" />';
    echo '<table class="form-table">';
    foreach ( $nfw_meta_box['fields'] as $field ) {
        // Get current post meta data
        $meta = get_post_meta( $post->ID, $field['id'], true );
        echo '<tr>',
        '<th style="width:20%"><label for="', esc_attr( $field['id'] ), '">', esc_html( $field['name'] ), '</label></th>',
        '<td>';
        switch ( $field['type'] ) {
            case 'radio':
                echo '<div>';
                foreach ( $field['options'] as $option ) {
                    echo '<div class="sidebar_icon_radio">';
                    $check_title = '';
                    switch ( $option['value'] ) {
                        case 'left':
                            echo '<img title="' . esc_html__( 'Sidebar on the left', 'fuse-wp' ) . '" src="' . esc_url( get_template_directory_uri() ) . '/framework/admin/images/icon_sidebar_left.png" alt="sidebar left">';
                            break;
                        case 'none':
                            echo '<img title="' . esc_html__( 'No Sidebar', 'fuse-wp' ) . '" src="' . esc_url( get_template_directory_uri() ) . '/framework/admin/images/icon_sidebar_none.png" alt="sidebar none">';
                            break;
                        case 'right':
                            echo '<img title="' . esc_html__( 'Sidebar on the right', 'fuse-wp' ) . '" src="' . esc_url( get_template_directory_uri() ) . '/framework/admin/images/icon_sidebar_right.png" alt="sidebar right">';
                            break;
                    }
                    // Prepare the default option
                    if ( $meta == null && $option['value'] == 'none' ) {
                        $default_check = 'checked="checked"';
                    } else {
                        $default_check = '';
                    }
                    echo '<br><div class="sidebar_position_option_style">'
                    . '<input title="' . esc_html__( 'No Sidebar', 'fuse-wp' ) . '" type="radio" name="', esc_attr( $field['id'] ), '" '
                    . 'value="', esc_attr( $option['value'] ), '"', $meta == $option['value'] ? ' checked="checked"' : '', ' ' . esc_attr( $default_check ) . ' /></div>';
                    echo '</div>';
                }
                echo '</div>';
                echo '<br class="clear_nfw"><br><p>' . esc_html__( 'Select if the page should have a sidebar and how it should be positioned', 'fuse-wp' ) . '</p>';
                break;
            case 'select':
                global $wp_registered_sidebars;
                echo '<div>';
                echo '<select name="', esc_attr( $field['id'] ), '" id="', sanitize_html_class( $field['id'] ), '">';
                foreach ( $wp_registered_sidebars as $sidebar ) {
                    $check_sidebar = explode( 'nfw-footer-', $sidebar['id'] );
                    if ( count( $check_sidebar ) == 1 ) {
                        echo '<option ', $meta == $sidebar['id'] ? ' selected="selected"' : '', ' value="', $sidebar['id'], '">', $sidebar['name'], '</option>';
                    }
                }
                echo '</select>';
                echo '</div>';
                echo '<br class="clear_nfw"><p>' . esc_html__( 'Select the sidebar that should be used. You can create additional sidebars in the theme options panel', 'fuse-wp' ) . '</p>';
                break;
        }
        echo '</td><td>',
        '</td></tr>';
    }
    echo '</table>';
}

add_action( 'save_post', 'nfw_save_sidebar_data' );

// Save data from meta box
function nfw_save_sidebar_data ( $post_id ) {
    global $nfw_meta_box;
    if ( isset( $_POST['nfw_sidebar_meta_box_nonce'] ) ) {
        // Verify nonce
        if ( !wp_verify_nonce( $_POST['nfw_sidebar_meta_box_nonce'], get_template_directory() ) ) {
            return $post_id;
        }
        // Check autosave
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }
        // Check permissions
        if ( 'page' == $_POST['post_type'] ) {
            if ( !current_user_can( 'edit_page', $post_id ) ) {
                return $post_id;
            }
        } elseif ( !current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
        }
        // Populates the meta box fields with the appropriate data
        foreach ( $nfw_meta_box['fields'] as $field ) {
            $old = get_post_meta( $post_id, $field['id'], true );
            $new = $_POST[$field['id']];
            if ( $new && $new != $old ) {
                update_post_meta( absint( $post_id ), sanitize_text_field( $field['id'] ), sanitize_text_field( $new ) );
            } elseif ( '' == $new && $old ) {
                delete_post_meta( absint( $post_id ), sanitize_text_field( $field['id'] ), sanitize_text_field( $old ) );
            }
        }
    }
}


$nfw_metabox_page_header = array(
    'id' => 'nfw-page-header',
    'title' => esc_html__('Page Header', 'fuse-wp'),
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => esc_html__('Header Config', 'fuse-wp'),
            'id' => 'nfw_header_toggle',
            'type' => 'toggle',
            'options' => array(
                array('name' => 'Enable', 'value' => 'Enable'),
                array('name' => 'Disable', 'value' => 'Disable')
            )
        ),
        array(
            'name' => esc_html__('Page header title', 'fuse-wp'),
            'id' => 'nfw_header_title',
            'type' => 'text'
        ),
        array(
            'name' => esc_html__('Font color', 'fuse-wp'),
            'id' => 'nfw_header_font_color',
            'type' => 'colorpicker',
            'default' => ''
        ),
        array(
            'name' => esc_html__('Background image', 'fuse-wp'),
            'id' => 'nfw_header_image',
            'type' => 'image'
        ),
        array(
            'name' => esc_html__('Parallax', 'fuse-wp'),
            'id' => 'nfw_header_parallax',
            'type' => 'checkbox',
            'description' => esc_html__('Enable parallax for header background image', 'fuse-wp'),
            'value' => 'parallax'
        )
    )
);

add_action('admin_menu', 'nfw_page_header_add_box');

// Add the meta box
function nfw_page_header_add_box() {
    
    global $nfw_metabox_page_header;
    add_meta_box($nfw_metabox_page_header['id'], $nfw_metabox_page_header['title'], 'nfw_page_header_show_box', 'page', $nfw_metabox_page_header['context'], $nfw_metabox_page_header['priority']);
    if ( defined( 'ERP_PATH' ) ) {
        add_meta_box( $nfw_metabox_page_header['id'], $nfw_metabox_page_header['title'], 'nfw_page_header_show_box', 'erp-portfolio', $nfw_metabox_page_header['context'], $nfw_metabox_page_header['priority'] );
    }
    if ( function_exists('is_shop') ) {
        add_meta_box( $nfw_metabox_page_header['id'], $nfw_metabox_page_header['title'], 'nfw_page_header_show_box', 'product', $nfw_metabox_page_header['context'], $nfw_metabox_page_header['priority'] );
    }
}

// Callback function to show fields in meta box
function nfw_page_header_show_box() {
    global $nfw_metabox_page_header, $post;
    // Use nonce for verification
    echo '<input type="hidden" name="nfw_page_header_meta_box_nonce" value="', wp_create_nonce(get_template_directory()), '" />';
    echo '<table id="nfw_header_options_table" class="form-table">';
    foreach ($nfw_metabox_page_header['fields'] as $field) {
        // Get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);
        echo '<tr';
        if ($field['id'] == 'nfw_header_style') {
            echo ' id="nfw_style_container"';
        }
        echo '><th><label for="', $field['id'], '">', esc_html($field['name']), '</label></th>',
        '<td>';
        switch ($field['type']) {
            case 'toggle':
                echo '<div>';
                foreach ($field['options'] as $option) {
                    // Prepare the default option
                    if ($meta == null && ($option['value'] == 'Enable' || $option['value'] == 'on')) {
                        $default_check = 'checked="checked"';
                    } else {
                        $default_check = '';
                    }
                    echo ' <input type="radio" id="toggle-' . sanitize_html_class($option['value']) . '" class="toggle toggle-' . sanitize_html_class($option['value']) . '" name="', $field['id'], '" '
                    . 'value="', esc_attr($option['value']), '"', $meta == $option['value'] ? ' checked="checked"' : '', ' ' . $default_check . ' ', $field['id'] == 'nfw_style_toggle' ? 'onchange="nfw_style_select()"' : 'onclick="nfw_header_override()"', ' />'
                    . '<label for="toggle-' . esc_attr($option['value']) . '">' . esc_html($option['name']) . '</label>';
                }
                echo '</div>';
                break;
            case 'text':
                if ($meta == '') {
                    $meta = get_the_title();
                    update_post_meta($post->ID, $field['id'], $meta);
                }
                echo '<input type="text" name="' . $field['id'] . '" id="' . $field['id'] . '" value="' . esc_attr($meta) . '" size="30" /><br>';
                break;
            case 'colorpicker':
                echo '<div class="nfw_color_preview" id="nfw_color_preview_id" style="background-color:' . esc_attr($meta) . ';"></div><div id="nfw_color_preview_container_id">';
                echo '<input type="text" name="' . $field['id'] . '" id="' . $field['id'] . '" value="' . esc_attr($meta) . '" class="custom_header_color" data-default-color="#fff" /></div>';
                break;
            case 'checkbox':
                if ($meta == $field['value']) {
                    $default_check = 'checked="checked"';
                } else {
                    $default_check = '';
                }
                echo '<input type="checkbox" name="' . $field['id'] . '" id="' . $field['id'] . '" value="'.$field['value'].'" ' . $default_check . ' />' . esc_html__('Enable', 'fuse-wp') . '<br>';
                echo '<br class="clear_nfw"><p>' . esc_html($field['description']) . '</p>';
                break;  
            case 'image':
                echo '<span class="custom_default_image" style="display:none"></span>';
                 $image_none = get_template_directory_uri() . "/framework/admin/images/image-none.png";
                if ( $meta ) {
                    $image = wp_get_attachment_image_src( $meta, 'medium' );
                    $image = $image[0];
                } else {
                    $image = $image_none;
                }
                echo '<input name="' . esc_attr( $field['id'] ) . '" id="' . esc_attr( $field['id'] ) . '_upload_input" type="hidden" class="custom_upload_image" value="' . esc_attr( $meta ) . '" />
                <img src="' . esc_url( $image ) . '" class="custom_preview_image" id="' . esc_attr( $field['id'] ) . '_preview_image" alt="" /><br />
                    <input id="' . esc_attr( $field['id'] ) . '_trigger" class="custom_upload_image_button button nfw_custom_image_upload_trigger" name="custom_upload_image_button" type="button" value="' . esc_html__( 'Choose Image', 'fuse-wp' ) . '" onclick="nfw_upload_trigger(\'' . $field['id'] . '\')"/>
                    <input id="' . esc_attr( $field['id'] ) . '_upload_input_clear" class="button nfw_clear_img custom_upload_image_button" value="' . esc_html__( 'Remove Image', 'fuse-wp' ) . '" type="button" onclick="nfw_clear_image_trigger(\'' . $field['id'] . '\',\'' . $image_none . '\')">';

                echo '<br class="clear_nfw"><p>' . esc_html__( 'Select a background image', 'fuse-wp' ) . '</p>';

                break;
        }
        echo '</td><td>',
        '</td></tr>';
    }
    echo '</table>';
}

add_action('save_post', 'nfw_save_page_header_data');

// Save data from meta box
function nfw_save_page_header_data($post_id) {
    global $nfw_metabox_page_header;
    if (isset($_POST['nfw_page_header_meta_box_nonce'])) {
        // Verify nonce
        if (!wp_verify_nonce($_POST['nfw_page_header_meta_box_nonce'], get_template_directory())) {
            return $post_id;
        }
        // Check autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }
        // Check permissions
        if ('page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }
        // Populates the meta box fields with the appropriate data
        foreach ($nfw_metabox_page_header['fields'] as $field) {
            $old = get_post_meta(absint($post_id), sanitize_text_field($field['id']), true);
            if (isset($_POST[$field['id']])) {
                $new = $_POST[$field['id']];
                if ($new && $new != $old) {
                    update_post_meta(absint($post_id), sanitize_text_field($field['id']), sanitize_text_field($new));
                } elseif ('' == $new && $old) {
                    delete_post_meta(absint($post_id), sanitize_text_field($field['id']), sanitize_text_field($old));
                }
            } else {
                delete_post_meta(absint($post_id), sanitize_text_field($field['id']), sanitize_text_field($old));
            }
        }
    }
}

// Check autosave
if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
    return $post_id;
}