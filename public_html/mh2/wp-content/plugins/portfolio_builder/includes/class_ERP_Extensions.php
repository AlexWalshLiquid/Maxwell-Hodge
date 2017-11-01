<?php

if( !defined( 'ERP_PATH' ) ){
	exit;
}

class ERP_Extensions {

	private static	$instance,
					$modules = array();

	public static function register(){
		if( !self::$instance ){
			self::$instance = new ERP_Extensions;
		}
		return self::$instance;
	}

	private function __construct(){
		self::register_module( 'Builder_ERP_Extension',        ERP_ADMIN_INCLUDES . 'extensions' );
		self::register_module( 'Settings_ERP_Extension',       ERP_ADMIN_INCLUDES . 'extensions' );
		self::register_module( 'Shortcode_ERP_Extension',      ERP_ADMIN_INCLUDES . 'extensions' );
		self::register_module( 'Tinymce_ERP_Extension',        ERP_ADMIN_INCLUDES . 'extensions' );
		self::register_module( 'VisualComposer_ERP_Extension', ERP_ADMIN_INCLUDES . 'extensions' );
	}

	public static function register_module( $module, $location ){
		$location = rtrim( $location, '/' );
		$location = rtrim( $location, '\\' );
		$location = sprintf( '%s%s%s.php', $location, DIRECTORY_SEPARATOR, $module );
		if( @include_once( $location ) ){
			if( class_exists( $module ) && ( !isset( self::$modules[ $module ] ) || !self::$modules[ $module ] ) ){
				self::$modules[ $module ] = new $module;
			}
		}
	}

}

abstract class ERP_Extension_Model {

	protected $hook;

	public function __construct(){
		$this->register_extension_hooks();
		$this->register_hooks();
	}

	private function register_extension_hooks(){
		ERP_HOOK::ACTION( 'admin_menu',            $this, 'admin_menu' );
		ERP_HOOK::ACTION( 'admin_enqueue_scripts', $this, 'admin_scripts' );
		ERP_HOOK::ACTION( 'admin_enqueue_scripts', $this, 'admin_styles' );
		ERP_HOOK::ACTION( 'wp_enqueue_scripts',    $this, 'front_scripts' );
		ERP_HOOK::ACTION( 'wp_enqueue_scripts',    $this, 'front_styles' );
	}

	protected function register_hooks(){}
	public function admin_menu(){}
	public function admin_styles(){}
	public function admin_scripts(){}
	public function front_styles(){}
	public function front_scripts(){}

}