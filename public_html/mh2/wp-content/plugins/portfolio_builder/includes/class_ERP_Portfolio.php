<?php

if( !defined( 'ERP_PATH' ) ){
	exit;
}

class ERP_Portfolio {

	private static	$instance   = null,
					$modules    = array();
	public static	$textdomain = 'erp_portfolio',
					$post_type  = 'erp-portfolio',
					$taxonomy   = 'erp-portfolio-categories',
					$shortcode  = 'erp_portfolio',
					$version    = '1.0.1';

	public static function run(){
		if( !self::$instance ){
			self::$instance = new ERP_Portfolio();
		}
		return self::$instance;
	}

	private function __construct(){
		$this->load_dependencies();
		$this->localize();
		$this->register_hooks();
	}

	private function load_dependencies(){
		include_once ERP_INCLUDES . 'class_ERP_Base.php';
		include_once ERP_INCLUDES . 'class_ERP_Extensions.php';
		include_once ERP_INCLUDES . 'class_ERP_HOOK.php';
		include_once ERP_INCLUDES . 'class_ERP_l18n.php';
		if( is_admin() ){
			include_once ERP_ADMIN_INCLUDES . 'class_ERP_Columns.php';
		}
	}

	private function localize(){
		$l18n = new ERP_l18n( self::$textdomain );
		ERP_HOOK::ACTION( 'plugins_loaded', $l18n, 'localize' );
	}

	private function register_hooks(){
		ERP_HOOK::ACTION( 'init', 'ERP_BASE',       'register' );
		ERP_HOOK::ACTION( 'init', 'ERP_Extensions', 'register' );
		if( is_admin() ){
			ERP_HOOK::ACTION( 'admin_init',                                'ERP_BASE',       'feature_image_support', 9999 );
			ERP_HOOK::ACTION( 'admin_notices',                             'ERP_BASE',       'feature_image_notice' );
			ERP_HOOK::ACTION( 'admin_menu',                                'ERP_BASE',       'admin_menu' );
			ERP_HOOK::ACTION( 'manage_edit-portfolio_columns',             'ERP_Columns',    'portfolio' );
			ERP_HOOK::ACTION( 'manage_portfolio_posts_custom_column',      'ERP_Columns',    'portfolio_content' );
		}
	}

}