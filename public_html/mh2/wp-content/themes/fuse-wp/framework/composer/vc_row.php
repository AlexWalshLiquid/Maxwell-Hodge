<?php

if (!defined('ABSPATH')) {
    exit();
}
/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $full_width
 * @var $full_height
 * @var $content_placement
 * @var $parallax
 * @var $parallax_image
 * @var $css
 * @var $el_id
 * @var $video_bg
 * @var $video_bg_url
 * @var $video_bg_parallax
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Row
 */
$el_class = $full_height = $parallax_speed_bg = $parallax_speed_video = $full_width = $equal_height = $flex_row = $columns_placement = $content_placement = $parallax = $parallax_image = $css = $el_id = $video_bg = $video_bg_url = $video_bg_parallax = '';
$output = $after_output = '';
$overlay_opacity = '0.5';
$overlay_color = '#000000';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

wp_enqueue_script('wpb_composer_front_js');

$el_class = $this->getExtraClass($el_class);

$css_classes = array(
    'vc_row',
    'wpb_row', //deprecated
    'vc_row-fluid',
    $el_class,
    vc_shortcode_custom_css_class($css),
);
$wrapper_attributes = array();
// build attributes for wrapper
if (!empty($el_id)) {
    $wrapper_attributes[] = 'id="' . esc_attr($el_id) . '"';
}

if (!empty($atts['gap'])) {
	$css_classes[] = 'vc_column-gap-'.$atts['gap'];
}

if ($overlay_enable == '1') {
    if ($overlay_color != '#000000' && trim($overlay_color) != '' && $overlay_opacity != '0.5') {
        $overlay_style = ' style="background-color:' . esc_attr($overlay_color) . ';opacity:' . $overlay_opacity . '"';
    } else if ($overlay_color != '#000000') {
        $overlay_style = ' style="background-color:' . esc_attr($overlay_color) . ';"';
    } else if ($overlay_opacity != '0.5') {
        $overlay_style = ' style="opacity:' . $overlay_opacity . '"';
    } else {
        $overlay_style = '';
    }
    $nfw_overlay = "<div class='nfw-row-overlay'{$overlay_style}></div>";
    $css_classes[] = ' row-with-overlay';
} else {
    $nfw_overlay = '';
}

if ( ! empty( $full_height ) ) {
	$css_classes[] = ' vc_row-o-full-height';
	if ( ! empty( $columns_placement ) ) {
		$flex_row = true;
		$css_classes[] = ' vc_row-o-columns-' . $columns_placement;
	}
}

if ( ! empty( $equal_height ) ) {
	$flex_row = true;
	$css_classes[] = ' vc_row-o-equal-height';
}

if ( ! empty( $content_placement ) ) {
	$flex_row = true;
	$css_classes[] = ' vc_row-o-content-' . $content_placement;
}

if ( ! empty( $flex_row ) ) {
	$css_classes[] = ' vc_row-flex';
}

$has_video_bg = (!empty($video_bg) && !empty($video_bg_url) && vc_extract_youtube_id($video_bg_url) );

if ($has_video_bg) {
    $parallax = $video_bg_parallax;
    $parallax_image = $video_bg_url;
    $css_classes[] = ' vc_video-bg-container';
    wp_enqueue_script('vc_youtube_iframe_api_js');
}

if (!empty($parallax)) {
    if ($parallax == 'theme-parallax') {
        $css_classes[] = 'parallax';
        $wrapper_attributes[] = 'data-bg-animation-type="horizontal" data-animation-repeat="x" data-parallax_sense="75"';
    } else if ($parallax == 'horizontal-parallax') {
        $css_classes[] = 'horizontal-parallax';
        $wrapper_attributes[] = 'data-parallax_sense="100"';
    } else if ($parallax == 'animated-parallax') {
        $css_classes[] = 'animated-parallax';
        $wrapper_attributes[] = 'data-bg-animation-type="horizontal" data-animation-repeat="x" data-parallax_sense="75"';
    } else {
        wp_enqueue_script('vc_jquery_skrollr_js');
        $wrapper_attributes[] = 'data-vc-parallax="1.5"'; // parallax speed
        $css_classes[] = 'vc_general vc_parallax vc_parallax-' . $parallax;
        if (strpos($parallax, 'fade') !== false) {
            $css_classes[] = 'js-vc_parallax-o-fade';
            $wrapper_attributes[] = 'data-vc-parallax-o-fade="on"';
        } elseif (strpos($parallax, 'fixed') !== false) {
            $css_classes[] = 'js-vc_parallax-o-fixed';
        }
    }
}
if (!empty($parallax_image)) {
    if ($has_video_bg) {
        $parallax_image_src = $parallax_image;
    } else {
        $parallax_image_id = preg_replace('/[^\d]/', '', $parallax_image);
        $parallax_image_src = wp_get_attachment_image_src($parallax_image_id, 'full');
        if (!empty($parallax_image_src[0])) {
            $parallax_image_src = $parallax_image_src[0];
        }
    }
    if ($parallax == 'theme-parallax' || $parallax == 'horizontal-parallax' || $parallax == 'animated-parallax') {
         $wrapper_attributes[] = 'style="background-image:url(' . esc_attr($parallax_image_src) . ');"';
    }
    $wrapper_attributes[] = 'data-vc-parallax-image="' . esc_attr($parallax_image_src) . '"';
}
if (!$parallax && $has_video_bg) {
    $wrapper_attributes[] = 'data-vc-video-bg="' . esc_attr($video_bg_url) . '"';
}
$css_class = preg_replace('/\s+/', ' ', apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode(' ', array_filter($css_classes)), $this->settings['base'], $atts));
$wrapper_attributes[] = 'class="' . esc_attr(trim($css_class)) . '"';

if ($nfw_row_font_color != '') {
    $output .= '<div class="custom-color" style="color:' . esc_attr($nfw_row_font_color) . ';">';
}

if ($full_width == 'stretch_row') {
    $output .= '<div class="container-fluid">';
} else if ($full_width == 'stretch_row_content_no_spaces') {
    $output .= '<div class="container-fluid">';
} else {
    $output .= '<div class="container-inner">';
}

$output .= '<div ' . implode(' ', $wrapper_attributes) . '>';
$output .= $nfw_overlay;

if ($full_width == 'stretch_row') {
    $output .= '<div class="container-inner">';
}
$output .= wpb_js_remove_wpautop($content);

if ($full_width == 'stretch_row') {
    $output .= '</div></div>';
} else {
    $output .= '</div>';
}

$output .= '</div>';
$output .= $after_output;

if ($nfw_row_font_color != '') {
    $output .= '</div>';
}
echo $output;
