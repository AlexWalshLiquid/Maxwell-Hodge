<?php

if( !defined( 'ERP_PATH' ) ){
	exit;
}

class ERP_HOOK {

	public static function ACTION( $hook, $controller, $method, $priority = 10, $accepted_args = 1 ){
		add_action( $hook, array( $controller, $method ), $priority, $accepted_args );
	}

	public static function FILTER( $hook, $controller, $method, $priority = 10, $accepted_args = 1 ){
		add_filter( $hook, array( $controller, $method ), $priority, $accepted_args );
	}

}