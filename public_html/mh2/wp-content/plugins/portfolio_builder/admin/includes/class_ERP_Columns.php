<?php

if( !defined( 'ERP_PATH' ) ){
	exit;
}

class ERP_Columns {

	public static function portfolio( $columns ){
		$columns['featured_image'] = __( 'Featured Image', ERP_Portfolio::$textdomain );
		$columns                   =  array_slice( $columns, 0, 2, true ) + array(
			'category' => __( 'Category', ERP_Portfolio::$textdomain ),
		) + array_slice( $columns, 2, null, true );
		return $columns;
	}

	public static function portfolio_content( $column ){
		switch( $column ){
			case 'category':
				$terms = get_the_terms( get_the_ID(), ERP_Portfolio::$taxonomy );
				if( $terms && !is_wp_error( $terms ) ){
					$cats = array();
					foreach( $terms as $term ){
						$cats[] = esc_html( $term->name );
					}
					echo implode( ', ', $cats );
				}
				break;
			case 'featured_image':
				the_post_thumbnail( 'thumbnail' );
				break;
			default:
				echo '-';
		}
	}

	public static function categories( $columns ){
		$columns['order'] = __( 'Order', ERP_Portfolio::$textdomain );
		return $columns;
	}

	public static function categories_content( $out, $column_name, $id ){
		return get_option( sprintf( '%s_category_order_%u', ERP_Portfolio::$textdomain, $id ) );
	}

}