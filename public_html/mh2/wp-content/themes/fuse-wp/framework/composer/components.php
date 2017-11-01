<?php

if (!defined('ABSPATH')) {
    exit();
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//                       Alert Component
//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function nfw_alert_elements_func($atts, $content = null) {
    extract(shortcode_atts(array(
        'nfw_alert_type' => 'info'
                    ), $atts));

    $content = esc_html($content);

    // Determines the type of alert
    if ($nfw_alert_type == "info") {
        return "<div class='alert info'><i class='ifc-christmas_star'></i>{$content}</div>";
    } elseif ($nfw_alert_type == "success") {
        return "<div class='alert success'><i class='ifc-checkmark'></i>{$content}</div>";
    } elseif ($nfw_alert_type == "warning") {
        return "<div class='alert warning'><i class='ifc-warning_shield'></i>{$content}</div>";
    } elseif ($nfw_alert_type == "error") {
        return "<div class='alert error'><i class='ifc-error'></i>{$content}</div>";
    } else {
        return "<div class='alert'><i class='ifc-info'></i>{$content}</div>";
    }
}

add_shortcode('nfw_alert_elements', 'nfw_alert_elements_func');

add_action('init', 'nfw_integrate_vc_alert_elements');

// integrates the custom element in the visual composer
function nfw_integrate_vc_alert_elements() {
    vc_map(
            array(
                "name" => esc_html__("Message box", 'fuse-wp'),
                "base" => "nfw_alert_elements",
                "icon" => get_template_directory_uri() . '/framework/admin/images/vc-icon.png',
                "category" => esc_html__('Fuse Elements', 'fuse-wp'),
                "params" => array(
                    array(
                        'type' => 'dropdown',
                        'holder' => 'div',
                        'heading' => esc_html__('Message Type', 'fuse-wp'),
                        'param_name' => 'nfw_alert_type',
                        'value' => array(
                            esc_html__('Info', 'fuse-wp') => 'info',
                            esc_html__('Default', 'fuse-wp') => 'default',
                            esc_html__('Success', 'fuse-wp') => 'success',
                            esc_html__('Warning', 'fuse-wp') => 'warning',
                            esc_html__('Error', 'fuse-wp') => 'error',
                        ),
                        'description' => esc_html__('Specify', 'fuse-wp')
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Message", 'fuse-wp'),
                        "param_name" => "content",
                        "description" => esc_html__("Specify the content of the message", 'fuse-wp')
                    )
                )
            )
    );
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//                       Animations Component
//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function nfw_animations_container_func($atts, $content = null) {
    extract(shortcode_atts(array(
        'nfw_animate_type' => 'bounce',
        'nfw_animate_delay' => '0',
        'nfw_animate_speed' => '1000',
        'nfw_animate_offset' => '90'
                    ), $atts));

    $content = wpb_js_remove_wpautop($content, false);
    $nfw_animate_type = esc_attr($nfw_animate_type);
    $nfw_animate_delay = esc_attr($nfw_animate_delay);
    $nfw_animate_speed = esc_attr($nfw_animate_speed);
    $nfw_animate_offset = esc_attr($nfw_animate_offset);
    if ($nfw_animate_offset > 100) {
        $nfw_animate_offset = 90;
    }

    return "<div class='animate' data-animation='{$nfw_animate_type}' data-animation-delay='{$nfw_animate_delay}' data-animation-speed='{$nfw_animate_speed}' data-animation-offset='{$nfw_animate_offset}%'>
                            {$content}
            </div>";
}

add_shortcode('nfw_animations_container', 'nfw_animations_container_func');
add_action('init', 'nfw_integrate_vc_animations_container_component');

// integrates the custom element in the visual composer
function nfw_integrate_vc_animations_container_component() {
    vc_map(array(
        "name" => esc_html__("Animations Container", 'fuse-wp'),
        "base" => "nfw_animations_container",
        "category" => esc_html__('Fuse Elements', 'fuse-wp'),
        'as_parent' => array('except' => 'nfw_animations_container'),
        "content_element" => true,
        "icon" => get_template_directory_uri() . '/framework/admin/images/vc-icon.png',
        "show_settings_on_create" => true,
        "params" => array(
            array(
                'type' => 'dropdown',
                'holder' => 'div',
                'heading' => esc_html__('Animation Type', 'fuse-wp'),
                'param_name' => 'nfw_animate_type',
                'value' => array(
                    esc_html__('bounce', 'fuse-wp') => 'bounce',
                    esc_html__('flash', 'fuse-wp') => 'flash',
                    esc_html__('pulse', 'fuse-wp') => 'pulse',
                    esc_html__('rubberBand', 'fuse-wp') => 'rubberBand',
                    esc_html__('shake', 'fuse-wp') => 'shake',
                    esc_html__('swing', 'fuse-wp') => 'swing',
                    esc_html__('tada', 'fuse-wp') => 'tada',
                    esc_html__('wobble', 'fuse-wp') => 'wobble',
                    esc_html__('bounceIn', 'fuse-wp') => 'bounceIn',
                    esc_html__('bounceInDown', 'fuse-wp') => 'bounceInDown',
                    esc_html__('bounceInLeft', 'fuse-wp') => 'bounceInLeft',
                    esc_html__('bounceInRight', 'fuse-wp') => 'bounceInRight',
                    esc_html__('bounceInUp', 'fuse-wp') => 'bounceInUp',
                    esc_html__('bounceOut', 'fuse-wp') => 'bounceOut',
                    esc_html__('bounceOutDown', 'fuse-wp') => 'bounceOutDown',
                    esc_html__('bounceOutLeft', 'fuse-wp') => 'bounceOutLeft',
                    esc_html__('bounceOutRight', 'fuse-wp') => 'bounceOutRight',
                    esc_html__('bounceOutUp', 'fuse-wp') => 'bounceOutUp',
                    esc_html__('fadeIn', 'fuse-wp') => 'fadeIn',
                    esc_html__('fadeInDown', 'fuse-wp') => 'fadeInDown',
                    esc_html__('fadeInDownBig', 'fuse-wp') => 'fadeInDownBig',
                    esc_html__('fadeInLeft', 'fuse-wp') => 'fadeInLeft',
                    esc_html__('fadeInLeftBig', 'fuse-wp') => 'fadeInLeftBig',
                    esc_html__('fadeInRight', 'fuse-wp') => 'fadeInRight',
                    esc_html__('fadeInRightBig', 'fuse-wp') => 'fadeInRightBig',
                    esc_html__('fadeInUp', 'fuse-wp') => 'fadeInUp',
                    esc_html__('fadeInUpBig', 'fuse-wp') => 'fadeInUpBig',
                    esc_html__('fadeOut', 'fuse-wp') => 'fadeOut',
                    esc_html__('fadeOutDown', 'fuse-wp') => 'fadeOutDown',
                    esc_html__('fadeOutDownBig', 'fuse-wp') => 'fadeOutDownBig',
                    esc_html__('fadeOutLeft', 'fuse-wp') => 'fadeOutLeft',
                    esc_html__('fadeOutLeftBig', 'fuse-wp') => 'fadeOutLeftBig',
                    esc_html__('fadeOutRight', 'fuse-wp') => 'fadeOutRight',
                    esc_html__('fadeOutRightBig', 'fuse-wp') => 'fadeOutRightBig',
                    esc_html__('fadeOutUp', 'fuse-wp') => 'fadeOutUp',
                    esc_html__('fadeOutUpBig', 'fuse-wp') => 'fadeOutUpBig',
                    esc_html__('flip', 'fuse-wp') => 'flip',
                    esc_html__('flipInX', 'fuse-wp') => 'flipInX',
                    esc_html__('flipInY', 'fuse-wp') => 'flipInY',
                    esc_html__('flipOutX', 'fuse-wp') => 'flipOutX',
                    esc_html__('flipOutY', 'fuse-wp') => 'flipOutY',
                    esc_html__('lightSpeedIn', 'fuse-wp') => 'lightSpeedIn',
                    esc_html__('lightSpeedOut', 'fuse-wp') => 'lightSpeedOut',
                    esc_html__('rotateIn', 'fuse-wp') => 'rotateIn',
                    esc_html__('rotateInDownLeft', 'fuse-wp') => 'rotateInDownLeft',
                    esc_html__('rotateInDownRight', 'fuse-wp') => 'rotateInDownRight',
                    esc_html__('rotateInUpLeft', 'fuse-wp') => 'rotateInUpLeft',
                    esc_html__('rotateInUpRight', 'fuse-wp') => 'rotateInUpRight',
                    esc_html__('rotateOut', 'fuse-wp') => 'rotateOut',
                    esc_html__('rotateOutDownLeft', 'fuse-wp') => 'rotateOutDownLeft',
                    esc_html__('rotateOutDownRight', 'fuse-wp') => 'rotateOutDownRight',
                    esc_html__('rotateOutUpLeft', 'fuse-wp') => 'rotateOutUpLeft',
                    esc_html__('rotateOutUpRight', 'fuse-wp') => 'rotateOutUpRight',
                    esc_html__('hinge', 'fuse-wp') => 'hinge',
                    esc_html__('rollIn', 'fuse-wp') => 'rollIn',
                    esc_html__('rollOut', 'fuse-wp') => 'rollOut',
                    esc_html__('zoomIn', 'fuse-wp') => 'zoomIn',
                    esc_html__('zoomInDown', 'fuse-wp') => 'zoomInDown',
                    esc_html__('zoomInLeft', 'fuse-wp') => 'zoomInLeft',
                    esc_html__('zoomInRight', 'fuse-wp') => 'zoomInRight',
                    esc_html__('zoomInUp', 'fuse-wp') => 'zoomInUp',
                    esc_html__('zoomOut', 'fuse-wp') => 'zoomOut',
                    esc_html__('zoomOutDown', 'fuse-wp') => 'zoomOutDown',
                    esc_html__('zoomOutLeft', 'fuse-wp') => 'zoomOutLeft',
                    esc_html__('zoomOutRight', 'fuse-wp') => 'zoomOutRight',
                    esc_html__('zoomOutUp', 'fuse-wp') => 'zoomOutUp'
                ),
                'description' => esc_html__('Specify', 'fuse-wp')
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Animation Delay", 'fuse-wp'),
                "param_name" => "nfw_animate_delay",
                "value" => '0',
                "description" => esc_html__("Specify the delay amount", 'fuse-wp')
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Animation Speed", 'fuse-wp'),
                "param_name" => "nfw_animate_speed",
                "value" => '1000',
                "description" => esc_html__("Specify the delay amount(in milliseconds, 1000 milliseconds = 1 second)", 'fuse-wp')
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Animation Offset", 'fuse-wp'),
                "param_name" => "nfw_animate_offset",
                "value" => '90',
                "description" => esc_html__("Specify the Offset amount (in percentage from 0 to 100)", 'fuse-wp')
            )
        ),
        'js_view' => 'VcColumnView'));
}

if (class_exists('WPBakeryShortCodesContainer')) {

    class WPBakeryShortCode_nfw_animations_container extends WPBakeryShortCodesContainer {
        
    }

}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//                       Button Component
//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function nfw_button_formats_func($atts) {
    extract(shortcode_atts(array(
        'nfw_link' => '',
        'nfw_icon' => '',
        'nfw_large' => '',
        'nfw_color' => '',
        'nfw_align' => ''
                    ), $atts));

    $nfw_icon = esc_attr($nfw_icon);
    $link_details = vc_build_link($nfw_link);
    $nfw_color = esc_attr($nfw_color);

    $large = $center_before = $center_after = $button_icon = $newtab = '';

    if (trim($nfw_icon) != "") {
        $button_icon = "<i class='{$nfw_icon}'></i>";
    }

    if ($nfw_large == "large") {
        $large = " btn-large";
    }

    if ($nfw_align == "center") {
        $center_before = "<div class='text-center'>";
        $center_after = "</div>";
    } else if ($nfw_align == "right") {
        $center_before = "<div class='text-right'>";
        $center_after = "</div>";
    }

    $link_details['target'] = esc_attr($link_details['target']);
    $link_details['url'] = esc_url($link_details['url']);
    $link_details['title'] = esc_html($link_details['title']);

    if ($link_details['target'] != '') {
        $newtab = "target='{$link_details['target']}'";
    }

    return "{$center_before}<a class='btn{$large}{$nfw_color}' href='{$link_details['url']}' {$newtab}>{$button_icon}{$link_details['title']}</a>{$center_after}";
}

add_shortcode('nfw_button_formats', 'nfw_button_formats_func');
add_action('init', 'nfw_integrate_vc_button_formats');

// integrates the custom element in the visual composer
function nfw_integrate_vc_button_formats() {
    vc_map(
            array(
                'name' => esc_html__('Button(s)', 'fuse-wp'),
                'base' => 'nfw_button_formats',
                'category' => esc_html__('Fuse Elements', 'fuse-wp'),
                'icon' => get_template_directory_uri() . '/framework/admin/images/vc-icon.png',
                'params' => array(
                    array(
                        'type' => 'vc_link',
                        'heading' => esc_html__('Link title &amp; URL', 'fuse-wp'),
                        'param_name' => 'nfw_link',
                        'description' => esc_html__('Specify the link pointing to another page', 'fuse-wp')
                    ),
                    array(
                        'type' => 'nfw_icomoon_icons_param',
                        'heading' => esc_html__('Select icon', 'fuse-wp'),
                        'param_name' => 'nfw_icon',
                        'description' => esc_html__('Select the icon you want', 'fuse-wp')
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => esc_html__('Button Size', 'fuse-wp'),
                        'param_name' => 'nfw_large',
                        'value' => array(esc_html__('Large', 'fuse-wp') => 'large')
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Button Position', 'fuse-wp'),
                        'param_name' => 'nfw_align',
                        'value' => array(
                            esc_html__('Left', 'fuse-wp') => '',
                            esc_html__('Center', 'fuse-wp') => 'center',
                            esc_html__('Right', 'fuse-wp') => 'right'
                        )
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Button Color', 'fuse-wp'),
                        'param_name' => 'nfw_color',
                        'value' => array(
                            esc_html__('Default', 'fuse-wp') => '',
                            esc_html__('Black', 'fuse-wp') => ' btn-black',
                            esc_html__('Grey', 'fuse-wp') => ' btn-grey'
                        )
                    )
                )
            )
    );
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//                       Divider Component
//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function nfw_dividers_func($atts) {
    extract(shortcode_atts(array(
        'nfw_divider_type' => 'single-line'
                    ), $atts));

    $nfw_divider_type = sanitize_html_class($nfw_divider_type);

    return "<div class='divider {$nfw_divider_type}'></div>";
}

add_shortcode('nfw_dividers', 'nfw_dividers_func');

add_action('init', 'nfw_integrate_vc_dividers');

// integrates the custom element in the visual composer
function nfw_integrate_vc_dividers() {
    vc_map(
            array(
                "name" => esc_html__("Divider", 'fuse-wp'),
                "base" => "nfw_dividers",
                "icon" => get_template_directory_uri() . '/framework/admin/images/vc-icon.png',
                "category" => esc_html__('Fuse Elements', 'fuse-wp'),
                "params" => array(
                    array(
                        'type' => 'dropdown',
                        'holder' => 'div',
                        'heading' => esc_html__('Divider Type', 'fuse-wp'),
                        'param_name' => 'nfw_divider_type',
                        'value' => array(
                            esc_html__('Single Line', 'fuse-wp') => 'single-line',
                            esc_html__('Double Line', 'fuse-wp') => 'double-line',
                            esc_html__('Single Dotted', 'fuse-wp') => 'single-dotted',
                            esc_html__('Double Dotted', 'fuse-wp') => 'double-dotted'
                        ),
                        'description' => esc_html__('Specify', 'fuse-wp')
                    )
                )
            )
    );
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//                       Google Map Component
//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function nfw_gmaps_func($atts) {
    extract(shortcode_atts(array(
        'nfw_zoom' => '16',
        'nfw_address' => '',
        'nfw_popup' => 'false',
        'nfw_height' => '635',
        'nfw_type' => 'ROADMAP',
        'nfw_caption' => ''
                    ), $atts));

    // Numeric validation
    $nfw_zoom = absint($nfw_zoom);
    $nfw_address = esc_attr($nfw_address);
    $nfw_caption = esc_attr($nfw_caption);
    $nfw_height = absint($nfw_height);

    return "<div class='google-map' data-zoom='{$nfw_zoom}' 
					data-address='{$nfw_address}' 
					data-caption='{$nfw_caption}' 
					data-maptype='{$nfw_type}'
					data-popup='{$nfw_popup}'
                                        data-mapheight='{$nfw_height}'>
					<p>" . esc_html__('This will be replaced with the Google Map.', 'fuse-wp') . "</p>
				</div>";
}

add_shortcode('nfw_gmaps', 'nfw_gmaps_func');

add_action('init', 'nfw_integrate_vc_gmaps');

// integrates the custom element in the visual composer
function nfw_integrate_vc_gmaps() {
    vc_map(
            array(
                "name" => esc_html__("Google Map", 'fuse-wp'),
                "base" => "nfw_gmaps",
                "category" => esc_html__('Fuse Elements', 'fuse-wp'),
                "icon" => get_template_directory_uri() . '/framework/admin/images/vc-icon.png',
                "params" => array(
                    array(
                        "type" => "textfield",
                        'holder' => 'div',
                        "heading" => esc_html__("Address", 'fuse-wp'),
                        "param_name" => "nfw_address",
                        "description" => esc_html__("The address where the map is centered", 'fuse-wp')
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Pinpoint caption", 'fuse-wp'),
                        "param_name" => "nfw_caption",
                        "description" => esc_html__("Specify text that will appear when you click on the pin", 'fuse-wp')
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => esc_html__('Pinpoint caption popup', 'fuse-wp'),
                        'param_name' => 'nfw_popup',
                        'value' => array(esc_html__('Show', 'fuse-wp') => 'true')
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Zoom', 'fuse-wp'),
                        'param_name' => 'nfw_zoom',
                        'value' => '16',
                        'description' => esc_html__('Specify a zoom value between 5 and 20', 'fuse-wp')
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Map height', 'fuse-wp'),
                        'param_name' => 'nfw_height',
                        'value' => '635',
                        'description' => esc_html__('Specify a height numeric value', 'fuse-wp')
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Map type', 'fuse-wp'),
                        'param_name' => 'nfw_type',
                        'value' => array(
                            esc_html__('ROADMAP', 'fuse-wp') => 'ROADMAP',
                            esc_html__('TERRAIN', 'fuse-wp') => 'TERRAIN',
                            esc_html__('SATELLITE', 'fuse-wp') => 'SATELLITE',
                            esc_html__('HYBRID', 'fuse-wp') => 'HYBRID'
                        )
                    ),
                )
            )
    );
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//                       Headline Component
//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function nfw_headline_func($atts) {
    extract(shortcode_atts(array(
        'nfw_title' => '',
        'nfw_subtitle' => ''
                    ), $atts));

    if (trim($nfw_subtitle) != '') {
        $nfw_subtitle = esc_html($nfw_subtitle);
        $nfw_subtitle = "<h5>{$nfw_subtitle}</h5>";
    }

    if (trim($nfw_title) != '') {
        $title_divide = mb_split('<br />', $nfw_title);
        $title = '<h2>';
        // Loops through each specifications row
        foreach ($title_divide as $element) {
            $title.= esc_html($element) . '<br class="hidden-phone">';
        }
        $title.= '</h2>';
    } else {
        $title = '';
    }

    return "<div class='headline'><h2>{$nfw_title}</h2>{$nfw_subtitle}</div>";
}

add_shortcode('nfw_headline', 'nfw_headline_func');

add_action('init', 'nfw_integrate_vc_headline');

// integrates the custom element in the visual composer
function nfw_integrate_vc_headline() {
    vc_map(
            array(
                'name' => esc_html__('Headline', 'fuse-wp'),
                'base' => 'nfw_headline',
                'category' => esc_html__('Fuse Elements', 'fuse-wp'),
                'icon' => get_template_directory_uri() . '/framework/admin/images/vc-icon.png',
                'params' => array(
                    array(
                        'type' => 'textarea',
                        'holder' => 'div',
                        'heading' => esc_html__('Title', 'fuse-wp'),
                        'param_name' => 'nfw_title',
                        'description' => esc_html__('Specify a title', 'fuse-wp')
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Subtitle', 'fuse-wp'),
                        'param_name' => 'nfw_subtitle',
                        'description' => esc_html__('Specify a subtitle', 'fuse-wp')
                    ),
                )
            )
    );
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//                       Icon Box Component
//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function nfw_icon_boxes_func($atts, $content = null) {
    extract(shortcode_atts(array(
        'nfw_icon' => '',
        'nfw_link' => '',
        'nfw_title' => '',
        'nfw_style' => '1',
        'nfw_image' => ''
                    ), $atts));

    if (trim($content) != '') {
        $content_p = wp_kses_post($content);
        $content_p = "<p>{$content}</p>";
    }

    $newtab = $link_start = $link_end = $icon = '';

    if ($nfw_style != '4') {
        if (trim($nfw_icon) != '') {
            $nfw_icon = esc_attr($nfw_icon);
            $icon = "<i class='{$nfw_icon}'></i>";
        }
    }
    $link_details = vc_build_link($nfw_link);

    if (trim($link_details['url']) != '') {

        if ($link_details['target'] !== '') {
            $newtab = "target='{$link_details['target']}'";
        }

        $link_details['url'] = esc_url($link_details['url']);
        $link_start = "<a href='{$link_details['url']}' {$newtab}>";
        $link_end = "</a>";
    }

    if (trim($link_details['title']) != '') {
        $link_details['title'] = esc_html($link_details['title']);
        $read_more = "<a class='btn btn-black' href='{$link_details['url']}'>{$link_details['title']}</a>";
    } else {
        $read_more = '';
    }

    if ($nfw_style == '2') {
        if (trim($nfw_title) != '') {
            $nfw_title = esc_html($nfw_title);
            $box_title = "<h4>{$link_start}{$nfw_title}{$link_end}</h4>";
        } else {
            $box_title = '';
        }
        return "<div class='icon-box-2'>{$icon}<div class='icon-box-content'>{$box_title}{$content_p}{$read_more}</div></div>";
    } else if ($nfw_style == '4') {
        if (trim($nfw_title) != '') {
            $nfw_title = esc_html($nfw_title);
            $box_title = "<h3>{$link_start}{$nfw_title}{$link_end}</h3>";
        } else {
            $box_title = '';
        }

        if ($nfw_image == null) {
            $image = '';
        } else {
            $image_data = wp_get_attachment_image_src($nfw_image, 'nfw_iconbox_size');
            $image_url = esc_url($image_data[0]);
            $image = "<img src='{$image_url}' alt=''>";
        }

        return "<div class='icon-box-4'>{$image}<div class='icon-box-content'>{$box_title}{$content_p}{$read_more}</div></div>";
    } else {
        if (trim($nfw_title) != '') {
            $nfw_title = esc_html($nfw_title);
            $box_title = "<h3>{$link_start}{$nfw_title}{$link_end}</h3>";
        } else {
            $box_title = '';
        }
        return "<div class='icon-box-{$nfw_style}'>{$icon}<div class='icon-box-content'>{$box_title}{$content_p}{$read_more}</div></div>";
    }
}

add_shortcode('nfw_icon_boxes', 'nfw_icon_boxes_func');
add_action('init', 'nfw_integrate_vc_icon_boxes');

// integrates the custom element in the visual composer
function nfw_integrate_vc_icon_boxes() {
    vc_map(
            array(
                'name' => esc_html__('Icon Box', 'fuse-wp'),
                'base' => 'nfw_icon_boxes',
                'icon' => get_template_directory_uri() . '/framework/admin/images/vc-icon.png',
                'category' => esc_html__('Fuse Elements', 'fuse-wp'),
                'params' => array(
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Iconbox Style', 'fuse-wp'),
                        'param_name' => 'nfw_style',
                        'value' => array(
                            esc_html__('Style 1', 'fuse-wp') => '1',
                            esc_html__('Style 2', 'fuse-wp') => '2',
                            esc_html__('Style 3', 'fuse-wp') => '3',
                            esc_html__('Style 4', 'fuse-wp') => '4'
                        )
                    ),
                    array(
                        'type' => 'textfield',
                        'holder' => 'div',
                        'heading' => esc_html__('Title', 'fuse-wp'),
                        'param_name' => 'nfw_title',
                        'value' => esc_html__('Title', 'fuse-wp')
                    ),
                    array(
                        'type' => 'attach_image',
                        'heading' => esc_html__('Image', 'fuse-wp'),
                        'param_name' => 'nfw_image',
                        'dependency' => array(
                            'element' => 'nfw_style',
                            'value' => '4'
                        ),
                        'description' => esc_html__('Add an image', 'fuse-wp')
                    ),
                    array(
                        'type' => 'vc_link',
                        'heading' => esc_html__('Iconbox link', 'fuse-wp'),
                        'param_name' => 'nfw_link',
                        'description' => esc_html__('Specify an optional link pointing to a details page', 'fuse-wp')
                    ),
                    array(
                        'type' => 'nfw_icomoon_icons_param',
                        'heading' => esc_html__('Select icon', 'fuse-wp'),
                        'param_name' => 'nfw_icon',
                        'dependency' => array(
                            'element' => 'nfw_style',
                            'value' => array('1', '2', '3')
                        ),
                        'description' => esc_html__('Select the icon you want', 'fuse-wp')
                    ),
                    array(
                        'type' => 'textarea_html',
                        'heading' => esc_html__('Content', 'fuse-wp'),
                        'param_name' => 'content',
                        'description' => esc_html__('Add description text for the iconbox', 'fuse-wp')
                    )
                )
            )
    );
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//                       Milestone Component
//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function nfw_milestones_func($atts, $content = null) {
    extract(shortcode_atts(array(
        'nfw_stop' => '100',
        'nfw_extra' => '',
        'nfw_speed' => '2000'
                    ), $atts));

    $content = esc_html($content);
    $extra = '';

    $nfw_stop = absint($nfw_stop);
    $nfw_speed = absint($nfw_speed);

    if (trim($nfw_extra) != '') {
        $nfw_extra = esc_html($nfw_extra);
        $extra = "<span>{$nfw_extra}</span>";
    }

    return "<div class='milestone'><div class='milestone-content'>
    <span class='milestone-value' data-stop='{$nfw_stop}' data-speed='{$nfw_speed}'></span>
            {$extra}<div class='milestone-description'>{$content}</div></div></div>";
}

add_shortcode('nfw_milestones', 'nfw_milestones_func');

add_action('init', 'nfw_integrate_vc_milestones');

// integrates the custom element in the visual composer
function nfw_integrate_vc_milestones() {
    vc_map(
            array(
                'name' => esc_html__('Milestone', 'fuse-wp'),
                'base' => 'nfw_milestones',
                'icon' => get_template_directory_uri() . '/framework/admin/images/vc-icon.png',
                'category' => esc_html__('Fuse Elements', 'fuse-wp'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Number', 'fuse-wp'),
                        'param_name' => 'nfw_stop',
                        'value' => '100',
                        'description' => esc_html__('The final value will animate to, from 0 to the number provided by you', 'fuse-wp')
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Speed', 'fuse-wp'),
                        'param_name' => 'nfw_speed',
                        'value' => '2000',
                        'description' => esc_html__('Specify the animation speed', 'fuse-wp')
                    ),
                    array(
                        'type' => 'textfield',
                        'holder' => 'div',
                        'heading' => esc_html__('Milestone Details', 'fuse-wp'),
                        'param_name' => 'content'
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Extra', 'fuse-wp'),
                        'param_name' => 'nfw_extra',
                        'description' => esc_html__('Add an extra marker beside the milestone number (optional)', 'fuse-wp')
                    ),
                )
            )
    );
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//                       Pie Chart Component
//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function nfw_pie_chart_func($atts) {
    extract(shortcode_atts(array(
        'nfw_data_barcolor' => '#000000',
        'nfw_data_trackcolor' => '',
        'nfw_center_value' => '',
        'nfw_percent' => '10',
        'nfw_linewidth' => '2',
        'nfw_barsize' => '215',
        'nfw_icon' => ''
                    ), $atts));

    $nfw_data_barcolor = esc_attr($nfw_data_barcolor);
    $nfw_data_trackcolor = esc_attr($nfw_data_trackcolor);

    $nfw_percent = absint($nfw_percent);
    $nfw_linewidth = absint($nfw_linewidth);
    $nfw_barsize = absint($nfw_barsize);
    $nfw_center_value = esc_html($nfw_center_value);

    if ($nfw_center_value == '') {
        $nfw_center_value = '<span></span>%';
    }
    if (trim($nfw_data_barcolor) == '') {
        $nfw_data_barcolor = 'transparent';
    }
    if (trim($nfw_data_trackcolor) == '') {
        $nfw_data_trackcolor = 'transparent';
    }

    $output = "<div class='pie-chart' data-percent='{$nfw_percent}' data-barColor='{$nfw_data_barcolor}' data-trackColor='{$nfw_data_trackcolor}' 
            data-lineWidth='{$nfw_linewidth}' data-barSize='{$nfw_barsize}'><div class='pie-chart-percent'>{$nfw_center_value}</div></div>";

    return $output;
}

add_shortcode('nfw_pie_chart', 'nfw_pie_chart_func');
add_action('init', 'nfw_integrate_vc_pie_chart');

// integrates the custom element in the visual composer
function nfw_integrate_vc_pie_chart() {
    vc_map(
            array(
                'name' => esc_html__('Pie Chart', 'fuse-wp'),
                'base' => 'nfw_pie_chart',
                'icon' => get_template_directory_uri() . '/framework/admin/images/vc-icon.png',
                'category' => esc_html__('Fuse Elements', 'fuse-wp'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'holder' => 'div',
                        'heading' => esc_html__('Chart top value', 'fuse-wp'),
                        'param_name' => 'nfw_center_value',
                        'description' => esc_html__('Specify a value that will be shown in the top left(optional)', 'fuse-wp')
                    ),
                    array(
                        'type' => 'textfield',
                        'holder' => 'div',
                        'heading' => esc_html__('Chart percent', 'fuse-wp'),
                        'param_name' => 'nfw_percent',
                        'value' => '10',
                        'description' => esc_html__('Specify a value from 0 to 100', 'fuse-wp')
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Pie Chart Bar Thickness', 'fuse-wp'),
                        'param_name' => 'nfw_linewidth',
                        'value' => '2',
                        'description' => esc_html__('Numeric value between 5 and 15', 'fuse-wp')
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Bar Width', 'fuse-wp'),
                        'param_name' => 'nfw_barsize',
                        'value' => '215',
                        'description' => esc_html__('Specify bar width', 'fuse-wp')
                    ),
                    array(
                        'type' => 'colorpicker',
                        'heading' => esc_html__('Bar Color', 'fuse-wp'),
                        'param_name' => 'nfw_data_barcolor',
                        'value' => '#000000',
                        'description' => esc_html__('Specify Bar-Color', 'fuse-wp')
                    ),
                    array(
                        'type' => 'colorpicker',
                        'class' => 'piechart_options_display_trigger',
                        'heading' => esc_html__('Track Color', 'fuse-wp'),
                        'param_name' => 'nfw_data_trackcolor',
                        'description' => esc_html__('Specify Track-Color', 'fuse-wp')
                    )
                )
            )
    );
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//                       VC CUSTOM PROCESS COMPONENTS ELEMENTS
//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function nfw_process_container_func($atts, $content = null) { // New function parameter $content is added!
    extract(shortcode_atts(array(
        'nfw_style' => 'horizontal'
                    ), $atts));

    $content = wpb_js_remove_wpautop($content, false);
    $class_part = '';

    if ($nfw_style == 'horizontal') {
        $content_elements = explode("<li>", $content);
        $count = count($content_elements);
        if ($count <= 3) {
            $class_part = 'two-items';
        } else if ($count == 4) {
            $class_part = 'three-items';
        } else if ($count == 5) {
            $class_part = 'four-items';
        } else {
            $class_part = 'five-items';
        }
    }

    return "<ul class='{$nfw_style}-process-builder {$class_part}'>{$content}</ul>";
}

add_shortcode('nfw_process_container', 'nfw_process_container_func');

function nfw_process_func($atts, $content = null) { // New function parameter $content is added!
    extract(shortcode_atts(array(
        'nfw_title' => '',
        'nfw_icon' => ''
                    ), $atts));

    $content = wpb_js_remove_wpautop($content, true);
    if (trim($nfw_icon)) {
        $nfw_icon = sanitize_html_class($nfw_icon);
        $top_part = "<i class='{$nfw_icon}'></i>";
    } else {
        $nfw_title = esc_html($nfw_title);
        $top_part = "<h1>{$nfw_title}</h1>";
    }

    $content = wp_kses_post($content);

    return "<li>{$top_part}<div class='process-description'>{$content}</div></li>";
}

add_shortcode('nfw_process', 'nfw_process_func');
add_action('init', 'nfw_integrate_vc_process_components');

// integrates the custom element in the visual composer
function nfw_integrate_vc_process_components() {
    vc_map(array(
        'name' => esc_html__('Our Process', 'fuse-wp'),
        'base' => 'nfw_process_container',
        'category' => esc_html__('Fuse Elements', 'fuse-wp'),
        'as_parent' => array('only' => 'nfw_process'),
        'content_element' => true,
        'icon' => get_template_directory_uri() . '/framework/admin/images/vc-icon.png',
        'show_settings_on_create' => true,
        'params' => array(
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Process type', 'fuse-wp'),
                'param_name' => 'nfw_style',
                'holder' => 'div',
                'value' => array(
                    esc_html__('Horizontal', 'fuse-wp') => 'horizontal',
                    esc_html__('Vertical', 'fuse-wp') => 'vertical'
                )
            )
        ),
        'js_view' => 'VcColumnView'
    ));
    vc_map(array(
        'name' => esc_html__('Process Step', 'fuse-wp'),
        'base' => 'nfw_process',
        'category' => esc_html__('Fuse Elements', 'fuse-wp'),
        'content_element' => true,
        'icon' => get_template_directory_uri() . '/framework/admin/images/vc-icon.png',
        'as_child' => array('only' => 'nfw_process_container'),
        'params' => array(
            // add params same as with any other content element
            array(
                'type' => 'nfw_icomoon_icons_param',
                'holder' => 'div',
                'heading' => esc_html__('Select icon', 'fuse-wp'),
                'param_name' => 'nfw_icon',
                'description' => esc_html__('Select the icon you want', 'fuse-wp')
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Title', 'fuse-wp'),
                'holder' => 'div',
                'param_name' => 'nfw_title',
                'description' => esc_html__('Specify the title of the process', 'fuse-wp')
            ),
            array(
                'type' => 'textarea_html',
                'heading' => esc_html__('Details', 'fuse-wp'),
                'param_name' => 'content',
                'description' => esc_html__('Specify the details of the process step', 'fuse-wp')
            )
        )
    ));
}

if (class_exists('WPBakeryShortCodesContainer')) {

    class WPBakeryShortCode_nfw_process_container extends WPBakeryShortCodesContainer {
        
    }

}
if (class_exists('WPBakeryShortCode')) {

    class WPBakeryShortCode_nfw_process extends WPBakeryShortCode {
        
    }

}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//                       Pricing Table Component
//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function nfw_pricing_table_func($atts) {
    extract(shortcode_atts(array(
        'nfw_price' => '25',
        'nfw_name' => '',
        'nfw_specifications' => '',
        'nfw_link' => '',
        'nfw_cost_type' => '$',
        'nfw_cost_time' => esc_html__("Month", 'fuse-wp')
                    ), $atts));

    $specifications_elements = mb_split('<br />', $nfw_specifications);
    $nfw_name = esc_html($nfw_name);
    $nfw_price = esc_html($nfw_price);
    $nfw_cost_type = esc_html($nfw_cost_type);
    $nfw_cost_time = esc_html($nfw_cost_time);

    $link_details = vc_build_link($nfw_link);
    $link_details['target'] = esc_attr($link_details['target']);
    $link_details['url'] = esc_url($link_details['url']);
    $link_details['title'] = esc_html($link_details['title']);

    $newtab = $table_link = $specifications_list = '';

    if ($link_details['target'] !== '') {
        $newtab = "target='{$link_details['target']}'";
    }

    if (trim($link_details['url']) != '' || trim($link_details['title']) != '') {
        $table_link = "<a class='btn' href='{$link_details['url']}' {$newtab}>{$link_details['title']}</a>";
    }

    // Loops through each specifications row
    foreach ($specifications_elements as $element) {
        $specifications_list.='<li>' . esc_html($element) . '</li>';
    }
    $output = "<div class='pricing-table'>
                            <div class='pricing-table-header'>
                                <h4>{$nfw_name}</h4>
                                <h1>{$nfw_cost_type}{$nfw_price}<small>{$nfw_cost_time}</small></h1>                
                            </div>
                            <div class='pricing-table-offer'>
                                <ul>{$specifications_list}</ul>
                            </div> 
                            {$table_link}  
                        </div>";

    return $output;
}

add_shortcode('nfw_pricing_table', 'nfw_pricing_table_func');

add_action('init', 'nfw_integrate_vc_pricing_table');

// integrates the custom element in the visual composer
function nfw_integrate_vc_pricing_table() {
    vc_map(
            array(
                'name' => esc_html__('Pricing Table', 'fuse-wp'),
                'base' => 'nfw_pricing_table',
                'icon' => get_template_directory_uri() . '/framework/admin/images/vc-icon.png',
                'category' => esc_html__('Fuse Elements', 'fuse-wp'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'holder' => 'div',
                        'heading' => esc_html__('Plan name', 'fuse-wp'),
                        'param_name' => 'nfw_name',
                        'value' => esc_html__('Starter edition', 'fuse-wp'),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Cost', 'fuse-wp'),
                        'param_name' => 'nfw_price',
                        'value' => '25',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Cost type', 'fuse-wp'),
                        'param_name' => 'nfw_cost_type',
                        'value' => '$',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Per', 'fuse-wp'),
                        'param_name' => 'nfw_cost_time',
                        'value' => esc_html__('Month', 'fuse-wp'),
                    ),
                    array(
                        'type' => 'textarea',
                        'heading' => esc_html__('Plan features (add one per line)', 'fuse-wp'),
                        'param_name' => 'nfw_specifications',
                        'description' => esc_html__('Write the specifications', 'fuse-wp')
                    ),
                    array(
                        'type' => 'vc_link',
                        'heading' => esc_html__('Read more button', 'fuse-wp'),
                        'param_name' => 'nfw_link',
                        'description' => esc_html__('Specify an optional link pointing to a details page', 'fuse-wp')
                    )
                )
            )
    );
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//                       Progress Bar Component
//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function nfw_progress_bar_func($atts, $content = null) {
    extract(shortcode_atts(array(
        'nfw_width' => '90'
                    ), $atts));

    $content = esc_html($content);
    $nfw_width = absint($nfw_width);

    return "<div class='fixed'><div class='progress-bar-description'>{$content}                               
        <span style='left:{$nfw_width}%'>{$nfw_width}%</span>
        </div><div class='progress-bar'><span class='progress-bar-outer' data-width='{$nfw_width}'> 
        <span class='progress-bar-inner'></span></span></div></div>";
}

add_shortcode('nfw_progress_bar', 'nfw_progress_bar_func');

add_action('init', 'nfw_integrate_vc_progress_bar');

// integrates the progess bar element in the visual composer
function nfw_integrate_vc_progress_bar() {
    vc_map(
            array(
                'name' => esc_html__('Progress Bar', 'fuse-wp'),
                'base' => 'nfw_progress_bar',
                'icon' => get_template_directory_uri() . '/framework/admin/images/vc-icon.png',
                'category' => esc_html__('Fuse Elements', 'fuse-wp'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'holder' => 'div',
                        'heading' => esc_html__('Title', 'fuse-wp'),
                        'param_name' => 'content',
                        'value' => esc_html__('title', 'fuse-wp'),
                        'description' => esc_html__('The title of the progress bar', 'fuse-wp')
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Value', 'fuse-wp'),
                        'param_name' => 'nfw_width',
                        'value' => '90',
                        'description' => esc_html__('Specify a value between 1 and 100, it represents the loaded percentage', 'fuse-wp')
                    )
                )
            )
    );
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//                      VC CUSTOM RECENT POSTS
//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function nfw_recent_posts_func($atts) {
    extract(shortcode_atts(array(
        'nfw_count' => '3',
        'nfw_type' => '6',
        'nfw_title' => esc_html__('Read the article', 'fuse-wp')
                    ), $atts));

    $args = array(
        'post_type' => 'post',
        'suppress_filters' => false,
        'post_status' => 'publish',
        'posts_per_page' => absint($nfw_count),
        'ignore_sticky_posts' => 1);

    $loop = new WP_Query($args);

    $output = '<div>';

    while ($loop->have_posts()) {
        $post_image = '';
        $loop->the_post();
        $post_id = get_the_ID();

        if (has_post_thumbnail($post_id)) {
            $image_data = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'nfw_post_size' . $nfw_type);
            $image_url = esc_url($image_data[0]);
            $post_image = "<div class='post-thumbnail'><img src='{$image_url}' alt=''></div>";
        }

        $post_title = esc_html(get_the_title());
        $post_link = esc_url(get_permalink());
        $post_date = get_the_date('F j, Y');

        if ($nfw_title != '') {
            $nfw_title = esc_html($nfw_title);
            $read_more = "<p><a class='more-link btn btn-grey' href='{$post_link}'>{$nfw_title}</a></p>";
        } else {
            $read_more = '';
        }

        $post_excerpt = apply_filters("the_content", get_the_excerpt());
        $output.="<div class='span{$nfw_type}'><div class='post format-standard'>{$post_image}<div class='post-header'><h4 class='post-title'>
	<a rel='bookmark' href='{$post_link}'>{$post_title}</a></h4><span class='posted-on'>{$post_date}</span>
	</div><div class='post-content'>{$post_excerpt}{$read_more}</div><div class='post-footer'></div></div></div>";
    }
    wp_reset_postdata();
    $output.= '</div>';
    return $output;
}

add_shortcode('nfw_recent_posts', 'nfw_recent_posts_func');
add_action('init', 'nfw_integrate_vc_recent_posts_components');

function nfw_integrate_vc_recent_posts_components() {
    vc_map(array(
        'name' => esc_html__('Recent Posts', 'fuse-wp'),
        'base' => 'nfw_recent_posts',
        'category' => esc_html__('Fuse Elements', 'fuse-wp'),
        'content_element' => true,
        'icon' => get_template_directory_uri() . '/framework/admin/images/vc-icon.png',
        'params' => array(
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Number of recent posts', 'fuse-wp'),
                'param_name' => 'nfw_count',
                'value' => '3',
                'holder' => 'div',
                'description' => esc_html__('Specify how many recent posts to show', 'fuse-wp')
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Read more button title', 'fuse-wp'),
                'param_name' => 'nfw_title',
                'value' => esc_html__('Read the article', 'fuse-wp')
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Columns number', 'fuse-wp'),
                'param_name' => 'nfw_type',
                'value' => array(
                    esc_html__('2 columns', 'fuse-wp') => '6',
                    esc_html__('3 columns', 'fuse-wp') => '4'
                )
            )
        )
    ));
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//                       VC CUSTOM SIMPLE SLIDER ELEMENTS
//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function nfw_simple_slider_container_func($atts, $content = null) {
    extract(shortcode_atts(array(
        'nfw_type' => 'features-slider',
        'nfw_images' => ''
                    ), $atts));

    $content = wpb_js_remove_wpautop($content, false);

    if ($nfw_type == 'image-rotator') {
        if ($nfw_images != null) {
            $nfw_ids = explode(',', $nfw_images);
            $images = '';
            foreach ($nfw_ids as $nfw_image) {
                if ($nfw_image != null) {
                    $image_data = wp_get_attachment_image_src($nfw_image, 'full');
                    $image_url = esc_url($image_data[0]);
                    $images .= "<li><img src='{$image_url}' alt=''></li>";
                }
            }
            return '<div class="' . $nfw_type . '"><ul class="slides">' . $images . '</ul><div class="image-rotator-text">' . $content . '</div></div>';
        }
    } else {
        return '<div class="' . $nfw_type . '"><div class="slides">' . $content . '</div></div>';
    }
}

add_shortcode('nfw_simple_slider_container', 'nfw_simple_slider_container_func');

add_action('init', 'nfw_integrate_vc_simple_slider_components');

// integrates the custom element in the visual composer
function nfw_integrate_vc_simple_slider_components() {
    vc_map(array(
        'name' => esc_html__('Simple slider', 'fuse-wp'),
        'base' => 'nfw_simple_slider_container',
        'category' => esc_html__('Fuse Elements', 'fuse-wp'),
        'as_parent' => array('except' => 'nfw_simple_slider_container'),
        'content_element' => true,
        'icon' => get_template_directory_uri() . '/framework/admin/images/vc-icon.png',
        'show_settings_on_create' => true,
        'params' => array(
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Slider type', 'fuse-wp'),
                'param_name' => 'nfw_type',
                'value' => array(
                    esc_html__('Features', 'fuse-wp') => 'features-slider',
                    esc_html__('Images', 'fuse-wp') => 'images-slider',
                    esc_html__('Images 2', 'fuse-wp') => 'images-slider-2',
                    esc_html__('Image rotator', 'fuse-wp') => 'image-rotator',
                )),
            array(
                'type' => 'attach_images',
                'heading' => esc_html__('Images', 'fuse-wp'),
                'param_name' => 'nfw_images',
                'dependency' => array(
                    'element' => 'nfw_type',
                    'value' => 'image-rotator'
                ),
                'description' => esc_html__('Select the images for rotator', 'fuse-wp')
            )
        ),
        'js_view' => 'VcColumnView'
    ));
}

if (class_exists('WPBakeryShortCodesContainer')) {

    class WPBakeryShortCode_nfw_simple_slider_container extends WPBakeryShortCodesContainer {
        
    }

}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//                       Social Media Component
//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function nfw_social_media_func($atts) {
    extract(shortcode_atts(array(
        'nfw_social_icon' => '',
        'nfw_social_link' => ''
                    ), $atts));

    $output = '';

    $nfw_social_icon = esc_attr($nfw_social_icon);

    $icon_parts = explode('-', $nfw_social_icon);

    if (isset($icon_parts[1])) {
        $icon = $icon_parts[1];

        if ($icon == 'stack') {
            $icon.='-' . $icon_parts[2];
        }
    }

    $nfw_social_link = esc_url($nfw_social_link);
    $icon = esc_attr($icon);
    return "<a href='{$nfw_social_link}' class='{$icon}-icon social-icon' target='_blank'><i class='{$nfw_social_icon}'></i></a>";
}

add_shortcode('nfw_social_media', 'nfw_social_media_func');
add_action('init', 'nfw_integrate_vc_social_media');

// integrates the custom element in the visual composer
function nfw_integrate_vc_social_media() {
    vc_map(array(
        "name" => esc_html__("Social Media", 'fuse-wp'),
        "base" => "nfw_social_media",
        "icon" => get_template_directory_uri() . '/framework/admin/images/vc-icon.png',
        "category" => esc_html__('Fuse Elements', 'fuse-wp'),
        "params" => array(
            array(
                "type" => "nfw_fa_icons_param",
                'holder' => 'div',
                "heading" => esc_html__("Social icon", 'fuse-wp'),
                "param_name" => "nfw_social_icon",
                "description" => esc_html__("Select social icon", 'fuse-wp')
            ),
            array(
                "type" => "textfield",
                'holder' => 'div',
                "heading" => esc_html__("Social link", 'fuse-wp'),
                "param_name" => "nfw_social_link",
                "description" => esc_html__("Specify social link", 'fuse-wp')
            )
        )
            )
    );
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//                       VC CUSTOM TEAM MEMBER ELEMENTS
//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// the short code function for the team member elements
function nfw_team_member_func($atts) { // New function parameter $content is added!
    extract(shortcode_atts(array(
        'nfw_name' => '',
        'nfw_job' => '',
        'nfw_link' => '',
        'nfw_image' => '',
        'nfw_pinteres' => '',
        'nfw_instagram' => '',
        'nfw_facebook' => '',
        'nfw_twitter' => '',
        'nfw_linkedin' => '',
        'nfw_youtube' => '',
        'nfw_google_plus' => ''
                    ), $atts));

    $nfw_name = esc_html($nfw_name);
    $nfw_job = esc_html($nfw_job);

    $facebook = $twitter = $googleplus = $linkedin = $youtube = $pinteres = $instagram = $image = $link_start = $link_end = $newtab='';

    if ($nfw_image == null) {
        $image_url = '';
    } else {
        $image_data = wp_get_attachment_image_src($nfw_image, 'nfw_team_size');
        $image_url = esc_url($image_data[0]);
        $image = "<img src='{$image_url}' alt=''>";
    }
    $link_details = vc_build_link($nfw_link);

    if (trim($link_details['url']) != '') {

        if ($link_details['target'] !== '') {
            $newtab = "target='{$link_details['target']}'";
        }

        $link_details['url'] = esc_url($link_details['url']);
        if (trim($link_details['title']) != '') {
            $link_title = esc_html($link_details['title']);
        } else {
            $link_title = '';
        }
        $link_start = "<a href='{$link_details['url']}' {$newtab} title='{$link_title}'>";
        $link_end = "</a>";
    }


    if (trim($nfw_google_plus) != null) {
        $nfw_google_plus = esc_url($nfw_google_plus);
        $googleplus = "<a class='googleplus-icon social-icon' href='{$nfw_google_plus}' target='_blank'><i class='fa fa-google-plus'></i></a>";
    }

    if (trim($nfw_instagram) != null) {
        $nfw_instagram = esc_url($nfw_instagram);
        $instagram = "<a class='instagram-icon social-icon' href = '{$nfw_instagram}' target='_blank'><i class='fa fa-instagram'></i></a>";
    }

    if (trim($nfw_pinteres) != null) {
        $nfw_pinteres = esc_url($nfw_pinteres);
        $pinteres = "<a class='pinterest-icon social-icon' href = '{$nfw_pinteres}' target='_blank'><i class='fa fa-pinterest'></i></a>";
    }

    if (trim($nfw_facebook) != null) {
        $nfw_facebook = esc_url($nfw_facebook);
        $facebook = "<a class='facebook-icon social-icon' href = '{$nfw_facebook}' target='_blank'><i class='fa fa-facebook'></i></a>";
    }

    if (trim($nfw_twitter) != null) {
        $nfw_twitter = esc_url($nfw_twitter);
        $twitter = "<a class='twitter-icon social-icon' href = '{$nfw_twitter}' target='_blank'><i class='fa fa-twitter'></i></a>";
    }
    if (trim($nfw_youtube) != null) {
        $nfw_youtube = esc_url($nfw_youtube);
        $youtube = "<a class='youtube-icon social-icon' href = '{$nfw_youtube}' target='_blank'><i class='fa fa-youtube'></i></a>";
    }
    if (trim($nfw_linkedin) != null) {
        $nfw_linkedin = esc_url($nfw_linkedin);
        $linkedin = "<a class='linkedin-icon social-icon' href = '{$nfw_linkedin}' target='_blank'><i class='fa fa-linkedin'></i></a>";
    }

    return "<div class='team-member'>
                            <div class='team-member-preview'>
                                {$link_start}{$image}{$link_end}
                             <div class='team-member-overlay'>
                                <div class='social-media'>
                                	{$facebook}
                                    {$instagram}
                                    {$twitter}
                                    {$googleplus}
                                    {$linkedin}
                                    {$youtube}
                                    {$pinteres}
                                </div>
                            </div>
                            </div>
                            <h5>{$nfw_name}</h5>
                            <h6>{$nfw_job}</h6>
                        </div>";
}

add_shortcode('nfw_team_member', 'nfw_team_member_func');
add_action('init', 'nfw_integrate_vc_team_member');

// integrates the custom element in the visual composer
function nfw_integrate_vc_team_member() {
    vc_map(
            array(
                'name' => esc_html__('Team Member', 'fuse-wp'),
                'base' => 'nfw_team_member',
                'icon' => get_template_directory_uri() . '/framework/admin/images/vc-icon.png',
                'category' => esc_html__('Fuse Elements', 'fuse-wp'),
                'params' => array(
                    array(
                        'type' => 'attach_image',
                        'heading' => esc_html__('Image', 'fuse-wp'),
                        'param_name' => 'nfw_image',
                        'description' => esc_html__('Add the image of the team member', 'fuse-wp')
                    ),
                    array(
                        'type' => 'textfield',
                        'holder' => 'div',
                        'heading' => esc_html__('Name', 'fuse-wp'),
                        'param_name' => 'nfw_name',
                        'value' => esc_html__('Sample name', 'fuse-wp'),
                        'description' => esc_html__('Specify the name of the member', 'fuse-wp')
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Job Title', 'fuse-wp'),
                        'param_name' => 'nfw_job',
                        'value' => esc_html__('Job Title', 'fuse-wp')
                    ),
                    array(
                        'type' => 'vc_link',
                        'heading' => esc_html__('Team memeber link', 'fuse-wp'),
                        'param_name' => 'nfw_link',
                        'description' => esc_html__('Specify a link for the team member', 'fuse-wp')
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Facebook', 'fuse-wp'),
                        'param_name' => 'nfw_facebook',
                        'description' => esc_html__('Add an optional link to Facebook profile page, leave blank if not available', 'fuse-wp')
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Instagram', 'fuse-wp'),
                        'param_name' => 'nfw_instagram',
                        'description' => esc_html__('Add an optional link to Instagram profile page, leave blank if not available', 'fuse-wp')
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Twitter', 'fuse-wp'),
                        'param_name' => 'nfw_twitter',
                        'description' => esc_html__('Add an optional link to Twitter profile page, leave blank if not available', 'fuse-wp')
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Google Plus', 'fuse-wp'),
                        'param_name' => 'nfw_google_plus',
                        'description' => esc_html__('Add an optional link to Google Plus profile page, leave blank if not available', 'fuse-wp')
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Linkedin', 'fuse-wp'),
                        'param_name' => 'nfw_linkedin',
                        'description' => esc_html__('Add an optional link to Linkedin profile page, leave blank if not available', 'fuse-wp')
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Youtube', 'fuse-wp'),
                        'param_name' => 'nfw_youtube',
                        'description' => esc_html__('Add an optional link to Youtube profile page, leave blank if not available', 'fuse-wp')
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Pinteres', 'fuse-wp'),
                        'param_name' => 'nfw_pinteres',
                        'description' => esc_html__('Add an optional link to Pinteres profile page, leave blank if not available', 'fuse-wp')
                    )
                )
            )
    );
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//                       Testimonial Component
//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function nfw_testimonial_func($atts, $content = null) {
    extract(shortcode_atts(array(
        'nfw_name' => '',
        'nfw_image' => '',
        'nfw_job' => ''
                    ), $atts));

    $nfw_name = esc_html($nfw_name);
    $nfw_job = esc_html($nfw_job);
    $specifications_elements = mb_split('<br />', $content);
    $specifications_list = '';
    // Loops through each specifications row
    foreach ($specifications_elements as $element) {
        $specifications_list.= esc_html($element) . '<br />';
    }

    if (trim($nfw_job) != '') {
        $testimonial_job = "<small>{$nfw_job}</small>";
    }

    if ($nfw_image == null) {
        $image = '';
    } else {
        $image_data = wp_get_attachment_image_src($nfw_image, 'nfw_iconbox_size');
        $image_url = esc_url($image_data[0]);
        $image = "<img src='{$image_url}' alt=''>";
    }

    return "<div class='testimonial'>{$image}<blockquote><p>{$specifications_list}</p></blockquote><h3>{$nfw_name}</h3><h6>{$testimonial_job}</h6></div>";
}

add_shortcode('nfw_testimonial', 'nfw_testimonial_func');
add_action('init', 'nfw_integrate_vc_testimonial');

// integrates the custom element in the visual composer
function nfw_integrate_vc_testimonial() {
    vc_map(
            array(
                'name' => esc_html__('Testimonial', 'fuse-wp'),
                'base' => 'nfw_testimonial',
                'icon' => get_template_directory_uri() . '/framework/admin/images/vc-icon.png',
                'category' => esc_html__('Fuse Elements', 'fuse-wp'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'holder' => 'div',
                        'heading' => esc_html__('Name', 'fuse-wp'),
                        'param_name' => 'nfw_name',
                        'value' => esc_html__('Sample name', 'fuse-wp'),
                        'description' => esc_html__('Specify the name of the testimonial author', 'fuse-wp')
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Job', 'fuse-wp'),
                        'param_name' => 'nfw_job',
                        'description' => esc_html__('Specify the job of the testimonial author', 'fuse-wp')
                    ),
                    array(
                        'type' => 'attach_image',
                        'heading' => esc_html__('Image', 'fuse-wp'),
                        'param_name' => 'nfw_image',
                        'description' => esc_html__('Add an image', 'fuse-wp')
                    ),
                    array(
                        'type' => 'textarea',
                        'heading' => esc_html__('Testimonial quote', 'fuse-wp'),
                        'param_name' => 'content',
                        'description' => esc_html__('Specify the text of the testimonial', 'fuse-wp')
                    )
                )
            )
    );
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//                       VC CUSTOM TESTIMONIAL SLIDER ELEMENTS
//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function nfw_testimonial_element_func($atts, $content = null) { // New function parameter $content is added!
    extract(shortcode_atts(array(
        'nfw_name' => '',
        'nfw_image' => '',
        'nfw_job' => ''
                    ), $atts));

    $nfw_name = esc_html($nfw_name);
    $nfw_job = esc_html($nfw_job);
    $specifications_elements = mb_split('<br />', $content);
    $specifications_list = '';
    // Loops through each specifications row
    foreach ($specifications_elements as $element) {
        $specifications_list.= esc_html($element) . '<br />';
    }

    if (trim($nfw_job) != '') {
        $testimonial_job = "<small>{$nfw_job}</small>";
    }

    if ($nfw_image == null) {
        $image = '';
    } else {
        $image_data = wp_get_attachment_image_src($nfw_image, 'nfw_iconbox_size');
        $image_url = esc_url($image_data[0]);
        $image = "<img src='{$image_url}' alt=''>";
    }

    return "<li><div class='testimonial'>{$image}<blockquote><p>{$specifications_list}</p></blockquote><h3>{$nfw_name}</h3><h6>{$testimonial_job}</h6></div></li>";
}

add_shortcode('nfw_testimonial_element', 'nfw_testimonial_element_func');

function nfw_testimonial_slider_container_func($atts, $content = null) { // New function parameter $content is added!
    extract(shortcode_atts(array(
        'nfw_class' => ''
                    ), $atts));

    $content = wpb_js_remove_wpautop($content, false);

    $nfw_class = esc_attr($nfw_class);

    return "<div class='testimonial-slider {$nfw_class}'><ul class='slides'>{$content}</ul></div>";
}

add_shortcode('nfw_testimonial_slider_container', 'nfw_testimonial_slider_container_func');

add_action('init', 'nfw_integrate_vc_testimonial_slider_components');

// integrates the custom element in the visual composer
function nfw_integrate_vc_testimonial_slider_components() {
    vc_map(array(
        'name' => esc_html__('Testimonial Slider Container', 'fuse-wp'),
        'base' => 'nfw_testimonial_slider_container',
        'category' => esc_html__('Fuse Elements', 'fuse-wp'),
        'as_parent' => array('only' => 'nfw_testimonial_element'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
        'content_element' => true,
        'icon' => get_template_directory_uri() . '/framework/admin/images/vc-icon.png',
        'show_settings_on_create' => false,
        'params' => array(
            array(
                'type' => 'textfield',
                'holder' => 'div',
                'heading' => esc_html__('Optional Class', 'fuse-wp'),
                'param_name' => 'nfw_class',
                'value' => '',
                'description' => esc_html__('Specify an optional extra class', 'fuse-wp')
            )
        ),
        'js_view' => 'VcColumnView'
    ));

    vc_map(
            array(
                'name' => esc_html__('Testimonial', 'fuse-wp'),
                'base' => 'nfw_testimonial_element',
                'icon' => get_template_directory_uri() . '/framework/admin/images/vc-icon.png',
                'category' => esc_html__('Fuse Elements', 'fuse-wp'),
                'as_child' => array('only' => 'nfw_testimonial_slider_container'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'holder' => 'div',
                        'heading' => esc_html__('Name', 'fuse-wp'),
                        'param_name' => 'nfw_name',
                        'value' => esc_html__('Sample name', 'fuse-wp'),
                        'description' => esc_html__('Specify the name of the testimonial author', 'fuse-wp')
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Job', 'fuse-wp'),
                        'param_name' => 'nfw_job',
                        'description' => esc_html__('Specify the job of the testimonial author', 'fuse-wp')
                    ),
                    array(
                        'type' => 'attach_image',
                        'heading' => esc_html__('Image', 'fuse-wp'),
                        'param_name' => 'nfw_image',
                        'description' => esc_html__('Add an image', 'fuse-wp')
                    ),
                    array(
                        'type' => 'textarea',
                        'heading' => esc_html__('Testimonial quote', 'fuse-wp'),
                        'param_name' => 'content',
                        'description' => esc_html__('Specify the text of the testimonial', 'fuse-wp')
                    )
                )
            )
    );
}

if (class_exists('WPBakeryShortCodesContainer')) {

    class WPBakeryShortCode_nfw_testimonial_slider_container extends WPBakeryShortCodesContainer {
        
    }

}
if (class_exists('WPBakeryShortCode')) {

    class WPBakeryShortCode_nfw_testimonial_element extends WPBakeryShortCode {
        
    }

}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//                       Text rotator Component
//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function nfw_text_rotator_elements_func($atts, $content = null) {
    extract(shortcode_atts(array(
        'nfw_size' => '1',
        'nfw_align' => 'text-center'
                    ), $atts));

    $content = esc_html($content);

    return "<h{$nfw_size} class='{$nfw_align}'><span class='text-rotate'>{$content}</span></h{$nfw_size}>";
}

add_shortcode('nfw_text_rotator_elements', 'nfw_text_rotator_elements_func');

add_action('init', 'nfw_integrate_vc_text_rotator_elements');

// integrates the custom element in the visual composer
function nfw_integrate_vc_text_rotator_elements() {
    vc_map(
            array(
                'name' => esc_html__('Text rotator', 'fuse-wp'),
                'base' => 'nfw_text_rotator_elements',
                'icon' => get_template_directory_uri() . '/framework/admin/images/vc-icon.png',
                'category' => esc_html__('Fuse Elements', 'fuse-wp'),
                'params' => array(
                    array(
                        'type' => 'textarea',
                        'heading' => esc_html__('Texts', 'fuse-wp'),
                        'param_name' => 'content',
                        'description' => esc_html__('Separate each text that will be rotated with: , ', 'fuse-wp')
                    ),
                    array(
                        'type' => 'dropdown',
                        'holder' => 'div',
                        'heading' => esc_html__('Heading size', 'fuse-wp'),
                        'param_name' => 'nfw_size',
                        'value' => array(
                            esc_html__('Size 1', 'fuse-wp') => '1',
                            esc_html__('Size 2', 'fuse-wp') => '2',
                            esc_html__('Size 3', 'fuse-wp') => '3',
                            esc_html__('Size 4', 'fuse-wp') => '4',
                            esc_html__('Size 5', 'fuse-wp') => '5',
                            esc_html__('Size 6', 'fuse-wp') => '6'
                        ),
                        'description' => esc_html__('Specify', 'fuse-wp')
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('align', 'fuse-wp'),
                        'param_name' => 'nfw_align',
                        'value' => array(
                            esc_html__('Center', 'fuse-wp') => 'text-center',
                            esc_html__('Left', 'fuse-wp') => 'text-left',
                            esc_html__('Right', 'fuse-wp') => 'text-right'
                        )
                    ),
                )
            )
    );
}
