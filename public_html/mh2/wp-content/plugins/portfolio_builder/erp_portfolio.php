<?php
/*
Plugin Name: Portfolio Builder
Plugin URI: http://plugins.europadns.net
Description: Portfolio plugin
Author: Mujnoi Tamas @ EuropaDNS
Version: 1.0.1
Author URI: http://www.europadns.com
*/
if( !defined( 'ABSPATH' ) ){
	exit;
}

define( 'ERP_PATH', plugin_dir_path( __FILE__ ) );
define( 'ERP_INCLUDES', ERP_PATH . 'includes' . DIRECTORY_SEPARATOR );
define( 'ERP_ASSETS', plugins_url( 'assets/', __FILE__ ) );
define( 'ERP_LANGUAGE_FILES_PATH', ERP_PATH . 'languages' . DIRECTORY_SEPARATOR );
define( 'ERP_ADMIN_PATH', ERP_PATH . 'admin' . DIRECTORY_SEPARATOR );
define( 'ERP_ADMIN_INCLUDES', ERP_ADMIN_PATH . 'includes' . DIRECTORY_SEPARATOR );
define( 'ERP_ADMIN_ASSETS', plugins_url( 'admin/assets/', __FILE__ ) );

include_once ERP_ADMIN_INCLUDES . 'class_ERP_Setup.php';
include_once ERP_INCLUDES . 'class_ERP_Portfolio.php';

register_activation_hook  ( __FILE__, array( 'ERP_Setup', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'ERP_Setup', 'deactivate' ) );

ERP_Portfolio::run();