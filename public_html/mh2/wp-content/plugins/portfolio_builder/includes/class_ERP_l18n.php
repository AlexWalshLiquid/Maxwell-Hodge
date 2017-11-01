<?php

if( !defined( 'ERP_PATH' ) ){
	exit;
}

class ERP_l18n {
	private $domain;

	public function __construct( $domain ){
		$this->domain = $domain;
	}

	public function localize(){
		load_plugin_textdomain( $this->domain, false, ERP_LANGUAGE_FILES_PATH );
	}

}