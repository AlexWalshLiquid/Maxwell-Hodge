<?php

if( !defined( 'ERP_PATH' ) ){
	exit;
}

class Settings_ERP_Extension extends ERP_Extension_Model {

	function __construct(){
		parent::__construct();
	}

	function admin_menu(){
		add_submenu_page(
			sprintf( 'edit.php?post_type=%s', ERP_Portfolio::$post_type ),
			__( 'Portfolio Builder Settings', ERP_Portfolio::$textdomain ),
			__( 'Portfolio Settings', ERP_Portfolio::$textdomain ),
			'manage_options',
			'erp-portfolio-settings',
			array( $this, 'render' )
		);
	}

	function render(){
		$msg  = '';
		$tabs = array(
			'general' => esc_html( __( 'General', ERP_Portfolio::$textdomain ) ),
		);
		$current = isset( $_GET['tab'] ) ? $_GET['tab'] : key( $tabs );
		$url     = admin_url( 'edit.php?post_type=%s&page=erp-portfolio-settings&tab=%s' );
		if( !array_key_exists( $current, $tabs ) ){
			$current = key( $tabs );
		}
		// save
		if( isset( $_POST['submit'] ) ){
			$rewrite = trim( sanitize_title( $_POST['erp_portfolio_slug_rewrite'] ) );
			if( !empty( $rewrite ) ){
				update_option( 'erp_portfolio_slug_rewrite', $rewrite );
				delete_option( 'rewrite_rules' );
				echo '<div class="updated"><p>' . esc_html( __( 'Portfolio slug updated successfully', ERP_Portfolio::$textdomain ) ) . '</p></div>';
			}
		}
		// view
		echo '<h1>', esc_html( __( 'Portfolio Builder Settings', ERP_Portfolio::$textdomain ) ), '</h1>';
		echo '<h2 class="nav-tab-wrapper">';
		foreach( $tabs as $tab => $name ){
			$class = ( $tab === $current ) ? ' nav-tab-active' : '';
			echo '<a class="nav-tab', esc_attr( $class ), '" href="', esc_attr( sprintf( $url, ERP_Portfolio::$post_type, $tab ) ), '">', esc_html( $name ), '</a>';
		}
		echo '</h2>';
		echo '<form action="', esc_attr( sprintf( $url, ERP_Portfolio::$post_type, $current ) ), '" method="post">';
		echo '<table class="form-table">';
		switch( $current ){
			case 'general':
				echo
				'<tr>',
					'<th>', esc_html( __( 'Change portfolio slug', ERP_Portfolio::$textdomain ) ), '</th>',
					'<td>',
						'<input type="text" name="erp_portfolio_slug_rewrite" value="', esc_attr( get_option( 'erp_portfolio_slug_rewrite' ) ), '"/>',
					'</td>',
				'</tr>';
				break;
			default:
		}
		echo '</table>';
			submit_button();
		echo '</form>';
	}

}