<?php

if( !defined( 'ERP_PATH' ) ){
	exit;
}

class ERP_Setup {

	public static function activate(){
		global $wp_rewrite;
		$slug = get_option( 'erp_portfolio_slug_rewrite' );
		$trim = trim( $slug );
		if( !$slug ){
			add_option( 'erp_portfolio_slug_rewrite', ERP_Portfolio::$post_type );
		} elseif( empty( $trim ) ){
			update_option( 'erp_portfolio_slug_rewrite', ERP_Portfolio::$post_type );
		}
		ERP_BASE::register();
		flush_rewrite_rules();
	}

	public static function deactivate(){
		delete_option( 'rewrite_rules' );
	}

}