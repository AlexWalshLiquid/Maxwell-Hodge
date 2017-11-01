<?php

if( !defined( 'ERP_PATH' ) ){
	exit;
}

class Tinymce_ERP_Extension extends ERP_Extension_Model {

	private	$user_can_edit = false;

	function __construct(){
		$this->check_privileges();
		parent::__construct();
	}

	function register_hooks(){
		if( $this->user_can_edit ){
			ERP_HOOK::FILTER( 'mce_buttons',          $this, 'register_editor_button' );
			ERP_HOOK::FILTER( 'mce_external_plugins', $this, 'load_plugin' );
		}
	}

	function admin_scripts(){
		if( $this->user_can_edit ){
			wp_localize_script( 'jquery', __CLASS__, array(
					'AJAX_URL'       => admin_url( 'admin-ajax.php' ),
					'NONCE'          => wp_create_nonce( __CLASS__ ),
					'LANG'           => array(
						'NO_RESULT'          => __( 'We couldn`t find any portfolios. Please create a portfolio to use this feature.', ERP_Portfolio::$textdomain ),
						'PLG_TEXT'           => __( 'Portfolio Builder', ERP_Portfolio::$textdomain ),
						'PLG_TITLE'          => __( 'Portfolio Customizer', ERP_Portfolio::$textdomain ),
						'SOURCE'             => __( 'Source', ERP_Portfolio::$textdomain ),
						'LAYOUT_SETTINGS'    => __( 'Grid Layout', ERP_Portfolio::$textdomain ),
						'DISPLAY_SETTINGS'   => __( 'Display Settings', ERP_Portfolio::$textdomain ),
						'ITEM_SETTINGS'      => __( 'Item Settings', ERP_Portfolio::$textdomain ),
						'CHOOSE_PORTFOLIO'   => __( 'Choose a portfolio', ERP_Portfolio::$textdomain ),
						'LAYOUT_TYPE'        => __( 'Layout type', ERP_Portfolio::$textdomain ),
						'IMG_ASPECT_RATIO'   => __( 'Image aspect ratio', ERP_Portfolio::$textdomain ),
						'PAGINATION_TYPE'    => __( 'Pagination type', ERP_Portfolio::$textdomain ),
						'NUMBER_OF_COLS'     => __( 'Number of columns', ERP_Portfolio::$textdomain ),
						'ITEMS_TO_DISPLAY'   => __( 'Number of items to show / load', ERP_Portfolio::$textdomain ),
						'FILTER_RESULTS'     => __( 'Category filtering', ERP_Portfolio::$textdomain ),
						'ENB_DIS_FILTERING'  => __( 'enable / disable filtering ( show / hide categories )', ERP_Portfolio::$textdomain ),
						'LOAD_ITEM_AJAX'     => __( 'Load items page through AJAX', ERP_Portfolio::$textdomain ),
						'OPEN_ITEM_MAGNIFIC' => __( 'open item`s page through Magnific Popup', ERP_Portfolio::$textdomain ),
						'ZOOM_ICON'          => __( 'Zoom icon', ERP_Portfolio::$textdomain ),
						//'LINK_ICON'          => __( 'Link icon', ERP_Portfolio::$textdomain ),
						'SHOW_HIDE'          => __( 'show / hide', ERP_Portfolio::$textdomain ),
						'DESCRIPTION'        => __( 'Show description', ERP_Portfolio::$textdomain ),
						'DESC_POSITION'      => __( 'Description position', ERP_Portfolio::$textdomain ),
						'SHOW_CATEGORIES'    => __( 'Categories in description', ERP_Portfolio::$textdomain ),
						'PADDING_BETWEEN'    => __( 'Padding ( Gutter )', ERP_Portfolio::$textdomain ),
						'PAGINATION_ALIGN'   => __( 'Pagination alignment', ERP_Portfolio::$textdomain ),
						'FILTERING_ALIGN'    => __( 'Filter alignment', ERP_Portfolio::$textdomain ),
					),
					'SHORTCODE'        => ERP_Portfolio::$shortcode,
					'PORTFOLIOS'       => $this->get_portfolios(),
					'ASPECT_RATIO'     => $this->get_aspect_ratios(),
					'PAGINATION_TYPE'  => $this->get_pagination_types(),
					'ALIGNMENTS'       => $this->get_alignments(),
					'COLUMNS'          => $this->get_column_numbers(),
					'LAYOUTS'          => $this->get_layout_styles(),
					'DESC_POSITIONS'   => $this->get_description_positions(),
                                        'COMPONENT_ICON'   => ERP_ADMIN_ASSETS . 'img/vc-icon.png', 
				) );
		}
	}

	private function check_privileges(){
		global $typenow;
		if( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ){
			return;
		}
		if( get_user_option( 'rich_editing' ) == 'true' ){
			if( empty( $typenow ) && !empty( $_GET['post'] ) ){
				$post = get_post( $_GET['post'] );
				$typenow = $post->post_type;
			}
			$post_type = isset( $_GET['post_type'] ) ? $_GET['post_type'] : false;
			if( $typenow !== ERP_Portfolio::$post_type && $post_type !== ERP_Portfolio::$post_type ){
				$this->user_can_edit = true;
			}
		}
	}

	function register_editor_button( $buttons ){
		array_push( $buttons, 'separator', ERP_Portfolio::$shortcode );
		return $buttons;
	}
	 
	function load_plugin( $plugin_array ){
		$plugin_array[ ERP_Portfolio::$shortcode ] = ERP_ADMIN_ASSETS . 'js/tinymce/erp-portfolio.js';
		return $plugin_array;
	}

	private function get_portfolios(){
		$data  = array();
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
				$data[] = array(
					'value' => $terms[ $i ]->term_id,
					'text'  => esc_html( $title ),
				);
			}
		}
		return $data;
	}

	private function get_aspect_ratios(){
		return array(
			array(
				'value'    => 1,
				'text'     => __( '1 : auto ( default )', ERP_Portfolio::$textdomain ),
				'selected' => true,
			),
			array(
				'value'    => 2,
				'text'     => __( '1 : 1', ERP_Portfolio::$textdomain ),
			),
			array(
				'value'    => 3,
				'text'     => __( '16 : 9', ERP_Portfolio::$textdomain ),
			),
		);
	}

	private function get_pagination_types(){
		return array(
			array(
				'value'    => 1,
				'text'     => __( 'None', ERP_Portfolio::$textdomain ),
			),
			array(
				'value'    => 2,
				'text'     => __( 'Load More Button ( default )', ERP_Portfolio::$textdomain ),
				'selected' => true,
			),
			array(
				'value'    => 3,
				'text'     => __( 'Paginated', ERP_Portfolio::$textdomain ),
			),
		);
	}

	private function get_column_numbers(){
		return array(
			array(
				'value'    => 2,
				'text'     => __( '2 columns', ERP_Portfolio::$textdomain ),
			),
			array(
				'value'    => 3,
				'text'     => __( '3 columns', ERP_Portfolio::$textdomain ),
			),
			array(
				'value'    => 4,
				'text'     => __( '4 columns ( default )', ERP_Portfolio::$textdomain ),
				'selected' => true,
			),
			array(
				'value'    => 5,
				'text'     => __( '5 columns', ERP_Portfolio::$textdomain ),
			),
		);
	}

	private function get_layout_styles(){
		return array(
			array(
				'value'    => 'masonry',
				'text'     => __( 'Masonry ( default )', ERP_Portfolio::$textdomain ),
				'selected' => true,
			),
			array(
				'value'    => 'fitRows',
				'text'     => __( 'Fit Rows', ERP_Portfolio::$textdomain ),
			),
		);
	}

	private function get_description_positions(){
		return array(
			array(
				'value'    => 1,
				'text'     => __( 'Inside ( default )', ERP_Portfolio::$textdomain ),
				'selected' => true,
			),
			array(
				'value'    => 2,
				'text'     => __( 'Outside', ERP_Portfolio::$textdomain ),
			),
		);
	}

	private function get_alignments(){
		return array(
			array(
				'value'    => 'left',
				'text'     => __( 'Left', ERP_Portfolio::$textdomain ),
			),
			array(
				'value'    => 'center',
				'text'     => __( 'Center ( default )', ERP_Portfolio::$textdomain ),
				'selected' => true,
			),
			array(
				'value'    => 'right',
				'text'     => __( 'Right', ERP_Portfolio::$textdomain ),
			),
		);
	}

}

