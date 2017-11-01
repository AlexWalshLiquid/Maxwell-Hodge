<?php

if( !defined( 'ERP_PATH' ) ){
	exit;
}

class ERP_Base {

	public static function register(){
		register_post_type( ERP_Portfolio::$post_type,
			array(
				'labels'              => array(
					'name'               => __( 'All Portfolio Items', ERP_Portfolio::$textdomain ),
					'singular_name'      => __( 'Portfolio Builder', ERP_Portfolio::$textdomain ),
					'add_new'            => __( 'Add new', ERP_Portfolio::$textdomain ),
					'add_new_item'       => __( 'Add new portfolio item', ERP_Portfolio::$textdomain ),
					'edit_item'          => __( 'Edit portfolio item', ERP_Portfolio::$textdomain ),
					'search_items'       => __( 'Search portfolio items', ERP_Portfolio::$textdomain ),
					'not_found'          => __( 'Portfolio item not found.', ERP_Portfolio::$textdomain ),
					'not_found_in_trash' => __( 'No portfolio item found in Trash.', ERP_Portfolio::$textdomain ),
				),
				'public'              => true,
				'has_archive'         => true,
				'exclude_from_search' => false,
				'show_ui'             => sprintf( 'edit.php?post_type=%s', ERP_Portfolio::$post_type ),
				'show_in_nav_menus'   => true,
				'menu_icon'           => 'dashicons-products',
				'supports'            => array( 'title', 'excerpt', 'editor', 'thumbnail' ),
				'taxonomies'          => array( ERP_Portfolio::$taxonomy ),
				'rewrite'             => array(
					'slug' => get_option( 'erp_portfolio_slug_rewrite' ),
				),
			)
		);
		register_taxonomy( ERP_Portfolio::$taxonomy, ERP_Portfolio::$post_type, array(
			'label'             => __( 'Portfolio Categories', ERP_Portfolio::$textdomain ),
			'hierarchical'      => true,
			'show_in_nav_menus' => false,
		) );
		self::feature_image_custom_sizes();
	}

	public static function admin_menu(){
		// top level menu
		add_menu_page(
			__( 'Portfolio Builder', ERP_Portfolio::$textdomain ),
			__( 'Portfolio', ERP_Portfolio::$textdomain ),
			'edit_posts',
			sprintf( 'edit.php?post_type=%s', ERP_Portfolio::$post_type ),
			null,
			'dashicons-format-image',
			30
		);
		// add new page
		add_submenu_page(
			sprintf( 'edit.php?post_type=%s', ERP_Portfolio::$post_type ),
			__( 'Add Portfolio Item', ERP_Portfolio::$textdomain ),
			__( 'Add Portfolio Item', ERP_Portfolio::$textdomain ),
			'edit_posts',
			sprintf( 'post-new.php?post_type=%s', ERP_Portfolio::$post_type )
		);
		// categories page
		add_submenu_page(
			sprintf( 'edit.php?post_type=%s', ERP_Portfolio::$post_type ),
			__( 'ERP Portfolio Categories', ERP_Portfolio::$textdomain ),
			__( 'Portfolio Categories', ERP_Portfolio::$textdomain ),
			'edit_posts',
			sprintf( 'edit-tags.php?taxonomy=%s&amp;post_type=%s', ERP_Portfolio::$taxonomy, ERP_Portfolio::$post_type )
		);
	}

	public static function feature_image_custom_sizes(){
		add_image_size( 'erp_480_1-auto', 480, 0 );
		add_image_size( 'erp_480_1-1', 480, 480, true );
		add_image_size( 'erp_480_16-9', 480, 270, true ); // 480 / ( 16 / 9 ) = 270
		add_image_size( 'erp_960_1-auto', 960, 0 );
		add_image_size( 'erp_960_1-1', 960, 960, true );
		add_image_size( 'erp_960_16-9', 960, 540, true ); // 960 / ( 16 / 9 ) = 540
	}

	public static function feature_image_support(){
		$support = get_theme_support( 'post-thumbnails' );
		if( $support === false ){
			add_theme_support( 'post-thumbnails', array( ERP_Portfolio::$post_type ) );
		} elseif( is_array( $support ) ){
			$support[0][] = ERP_Portfolio::$post_type;
			add_theme_support( 'post-thumbnails', $support[0] );
		}
	}

	public static function feature_image_notice(){
		global $current_screen, $post;
		if( $current_screen->id === ERP_Portfolio::$post_type && $current_screen->parent_base == 'edit' ){
			if( !has_post_thumbnail( $post->ID ) ){
				echo '<div class="error"><p>', __( 'Warning! Feature image is missing. This Item won`t be visible on the Portfolio Builder Page.', ERP_Portfolio::$textdomain ) , '</p></div>';
			}
		}
	}
}