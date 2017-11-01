<?php

if( !defined( 'ERP_PATH' ) ){
	exit;
}

class VisualComposer_ERP_Extension extends ERP_Extension_Model {

	function __construct(){
		if( function_exists( 'vc_map' ) ){
			vc_map( array(
				'name'             => __( 'Portfolio Builder', ERP_Portfolio::$textdomain ),
				'base'             => ERP_Portfolio::$shortcode,
				'class'            => '',
				'category'         => __( 'Content', ERP_Portfolio::$textdomain ),
				'description'      => __( 'Portfolio customizer', ERP_Portfolio::$textdomain ),
				'admin_enqueue_js' => ERP_ADMIN_ASSETS . 'js/js_composer/validation.js',
                    'icon' => ERP_ADMIN_ASSETS . 'img/vc-icon.png',
				'params'           => array(
					// Portfolio &amp; Grid Settings
					array(
						'type'        => 'dropdown',
						'heading'     => __( 'Portfolio', ERP_Portfolio::$textdomain ),
						'param_name'  => 'build',
						'value'       => $this->get_portfolios(),
						'admin_label' => true,
						'std'         => 0,
						'group'       => __( 'Portfolio &amp; Grid Settings', ERP_Portfolio::$textdomain ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => __( 'Layout', ERP_Portfolio::$textdomain ),
						'param_name'  => 'layout',
						'value'       => $this->get_layout_styles(),
						'admin_label' => true,
						'std'         => 1,
						'group'       => __( 'Portfolio &amp; Grid Settings', ERP_Portfolio::$textdomain ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => __( 'Number of columns', ERP_Portfolio::$textdomain ),
						'param_name'  => 'columns',
						'value'       => $this->get_column_numbers(),
						'admin_label' => true,
						'std'         => 4,
						'group'       => __( 'Portfolio &amp; Grid Settings', ERP_Portfolio::$textdomain ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => __( 'Padding ( Gutter )', ERP_Portfolio::$textdomain ),
						'param_name'  => 'gutter',
						'value'       => 0,
						'admin_label' => true,
						'group'       => __( 'Portfolio &amp; Grid Settings', ERP_Portfolio::$textdomain ),
					),
					// Display Settings
					array(
						'type'        => 'checkbox',
						'heading'     => __( 'Category filtering', ERP_Portfolio::$textdomain ),
						'description' => __( 'enable / disable filtering ( show / hide categories )', ERP_Portfolio::$textdomain ),
						'param_name'  => 'filter',
						'std'         => true,
						'admin_label' => true,
						'group'       => __( 'Display Settings', ERP_Portfolio::$textdomain ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => __( 'Filtering alignment', ERP_Portfolio::$textdomain ),
						'param_name'  => 'filter_align',
						'value'       => $this->get_alignments(),
						'std'         => 'center',
						'admin_label' => true,
						'group'       => __( 'Display Settings', ERP_Portfolio::$textdomain ),
						'dependency'  => array(
							'element'   => 'filter',
							'not_empty' => true,
						),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => __( 'Pagination type', ERP_Portfolio::$textdomain ),
						'param_name'  => 'pagination',
						'value'       => $this->get_pagination_types(),
						'admin_label' => true,
						'std'         => 2,
						'group'       => __( 'Display Settings', ERP_Portfolio::$textdomain ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => __( 'Pagination alignment', ERP_Portfolio::$textdomain ),
						'param_name'  => 'pagination_align',
						'value'       => $this->get_alignments(),
						'admin_label' => true,
						'std'         => 'center',
						'group'       => __( 'Display Settings', ERP_Portfolio::$textdomain ),
						'dependency'  => array(
							'element' => 'pagination',
							'value'   => array( '2', '3' ),
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => __( 'Number of items to show / load', ERP_Portfolio::$textdomain ),
						'param_name'  => 'items',
						'value'       => 8,
						'admin_label' => true,
						'group'       => __( 'Display Settings', ERP_Portfolio::$textdomain ),
					),
					// Item Settings
					array(
						'type'        => 'dropdown',
						'heading'     => __( 'Image aspect ratio', ERP_Portfolio::$textdomain ),
						'param_name'  => 'ratio',
						'value'       => $this->get_aspect_ratios(),
						'admin_label' => true,
						'std'         => 1,
						'group'       => __( 'Item Settings', ERP_Portfolio::$textdomain ),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => __( 'Load items page through AJAX', ERP_Portfolio::$textdomain ),
						'description' => __( 'open item`s page through Magnific Popup', ERP_Portfolio::$textdomain ),
						'param_name'  => 'ajaxed',
						'std'         => true,
						'admin_label' => true,
						'group'       => __( 'Item Settings', ERP_Portfolio::$textdomain ),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => __( 'Zoom icon', ERP_Portfolio::$textdomain ),
						'param_name'  => 'zoomable',
						'std'         => true,
						'admin_label' => true,
						'group'       => __( 'Item Settings', ERP_Portfolio::$textdomain ),
					),
					/*array(
						'type'        => 'checkbox',
						'heading'     => __( 'Link icon', ERP_Portfolio::$textdomain ),
						'param_name'  => 'linkable',
						'std'         => true,
						'admin_label' => true,
						'group'       => __( 'Item Settings', ERP_Portfolio::$textdomain ),
					),*/
					array(
						'type'        => 'checkbox',
						'heading'     => __( 'Categories in description', ERP_Portfolio::$textdomain ),
						'param_name'  => 'show_category',
						'std'         => true,
						'admin_label' => true,
						'group'       => __( 'Item Settings', ERP_Portfolio::$textdomain ),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => __( 'Show description', ERP_Portfolio::$textdomain ),
						'param_name'  => 'description',
						'std'         => true,
						'admin_label' => true,
						'group'       => __( 'Item Settings', ERP_Portfolio::$textdomain ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => __( 'Description position', ERP_Portfolio::$textdomain ),
						'param_name'  => 'desc_position',
						'value'       => $this->get_description_positions(),
						'admin_label' => true,
						'std'         => 1,
						'group'       => __( 'Item Settings', ERP_Portfolio::$textdomain ),
						'dependency'  => array(
							'element'   => 'description',
							'not_empty' => true,
						),
					),
				),
			) );
		}
	}

	private function get_portfolios(){
		$data  = array(
			__( 'Choose your portfolio', ERP_Portfolio::$textdomain ) => 0,
		);
		$args  = array(
			'hide_empty' => false,
		);
		$terms = get_terms( Builder_ERP_Extension::$taxonomy, $args );
		if( $terms && !is_wp_error( $terms ) ){
			for( $i = 0, $c = count( $terms ); $i < $c; $i++ ){
				$title   = $terms[ $i ]->name;
				$details = isset( $terms[ $i ]->description ) ? @unserialize( $terms[ $i ]->description ) : false;
				if( isset( $details['meta']['description'] ) && !empty( $details['meta']['description'] ) ){
					$title .= sprintf( ' - %s...', trim( substr( $details['meta']['description'], 0, 20 ) ) );
				}
				$data[ esc_html( $title ) ] = $terms[ $i ]->term_id;
			}
		}
		return $data;
	}

	private function get_aspect_ratios(){
		return array(
			__( '1 : auto ( default )', ERP_Portfolio::$textdomain ) => 1,
			__( '1 : 1', ERP_Portfolio::$textdomain )                => 2,
			__( '16 : 9', ERP_Portfolio::$textdomain )               => 3,
		);
	}

	private function get_pagination_types(){
		return array(
			__( 'None', ERP_Portfolio::$textdomain )                         => 1,
			__( 'Load More Button ( default )', ERP_Portfolio::$textdomain ) => 2,
			__( 'Paginated', ERP_Portfolio::$textdomain )                    => 3,
		);
	}

	private function get_column_numbers(){
		return array(
			__( '2 columns', ERP_Portfolio::$textdomain )             => 2,
			__( '3 columns', ERP_Portfolio::$textdomain )             => 3,
			__( '4 columns ( default )', ERP_Portfolio::$textdomain ) => 4,
			__( '5 columns', ERP_Portfolio::$textdomain )             => 5,
		);
	}

	private function get_layout_styles(){
		return array(
			__( 'Masonry ( default )', ERP_Portfolio::$textdomain ) => 'masonry',
			__( 'Fit Rows', ERP_Portfolio::$textdomain )            => 'fitRows',
		);
	}

	private function get_description_positions(){
		return array(
			__( 'Inside ( default )', ERP_Portfolio::$textdomain ) => 1,
			__( 'Outside', ERP_Portfolio::$textdomain )            => 2,
		);
	}

	private function get_alignments(){
		return array(
			__( 'Left', ERP_Portfolio::$textdomain )               => 'left',
			__( 'Center ( default )', ERP_Portfolio::$textdomain ) => 'center',
			__( 'Right', ERP_Portfolio::$textdomain )              => 'right',
		);
	}

}
