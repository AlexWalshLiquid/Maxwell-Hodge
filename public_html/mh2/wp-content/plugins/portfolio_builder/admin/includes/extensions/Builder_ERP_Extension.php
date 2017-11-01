<?php

if( !defined( 'ERP_PATH' ) ){
	exit;
}

class Builder_ERP_Extension extends ERP_Extension_Model {

	static	$taxonomy        = 'erp-portfolio-builder';
	private $page            = 'erp-portfolio-builder',
			$builds_per_page = 2,
			$datetimeformat  = 'Y-m-d H:i:s',
			$defaults        = array(
				'count'    => 0,
				'items'    => array(),
				'meta'     => array(
					'created'     => 0,
					'updated'     => 0,
					'description' => '',
				),
			);

	function __construct(){
		$this->datetimeformat              = sprintf( '%s %s', get_option( 'date_format' ), get_option( 'time_format' ) );
		$this->defaults['meta']['created'] = $this->defaults['meta']['updated'] = current_time( 'timestamp' );
		parent::__construct();
	}

	function register_hooks(){
		$this->register_taxonomy();
		ERP_HOOK::ACTION( 'wp_ajax_erp_create_portfolio', $this, 'ajax_create_portfolio' );
		ERP_HOOK::ACTION( 'wp_ajax_erp_get_portfolio',    $this, 'ajax_get_portfolio' );
		ERP_HOOK::ACTION( 'wp_ajax_erp_update_portfolio', $this, 'ajax_update_portfolio' );
		ERP_HOOK::ACTION( 'wp_ajax_erp_delete_portfolio', $this, 'ajax_delete_portfolio' );
		ERP_HOOK::ACTION( 'wp_ajax_erp_get_items',        $this, 'ajax_get_items' );
	}

	private function register_taxonomy(){
		register_taxonomy( self::$taxonomy, ERP_Portfolio::$post_type, array(
			'labels'            => array(
				'name'                       => __( 'Portfolios Built via Builder', ERP_Portfolio::$textdomain ),
				'singular_name'              => __( 'Portfolio Build', ERP_Portfolio::$textdomain ),
				'search_items'               => __( 'Search Portfolio Builds', ERP_Portfolio::$textdomain ),
				'popular_items'              => __( 'Popular Portfolio Builds', ERP_Portfolio::$textdomain ),
				'all_items'                  => __( 'All Portfolio Builds', ERP_Portfolio::$textdomain ),
				'parent_item'                => __( 'Parent Portfolio Build', ERP_Portfolio::$textdomain ),
				'parent_item_colon'          => __( 'Parent Portfolio Build:', ERP_Portfolio::$textdomain ),
				'edit_item'                  => __( 'Edit Portfolio Build', ERP_Portfolio::$textdomain ),
				'update_item'                => __( 'Update Portfolio Build', ERP_Portfolio::$textdomain ),
				'add_new_item'               => __( 'Add New Portfolio Build', ERP_Portfolio::$textdomain ),
				'new_item_name'              => __( 'New Portfolio Build', ERP_Portfolio::$textdomain ),
				'separate_items_with_commas' => __( 'Separate builds with commas', ERP_Portfolio::$textdomain ),
				'add_or_remove_items'        => __( 'Add or remove Portfolio Builds', ERP_Portfolio::$textdomain ),
				'choose_from_most_used'      => __( 'Choose from most used builds', ERP_Portfolio::$textdomain ),
				'menu_name'                  => __( 'Portfolio Builds', ERP_Portfolio::$textdomain ),
  			),
			'public'            => false,
			'show_in_nav_menus' => false,
			'show_ui'           => false,
			'show_tagcloud'     => false,
			'hierarchical'      => false,
			'rewrite'           => false,
			'query_var'         => true,
		) );
	}

	function admin_menu(){
		$this->hook = add_submenu_page(
			sprintf( 'edit.php?post_type=%s', ERP_Portfolio::$post_type ),
			__( 'Portfolio Builder', ERP_Portfolio::$textdomain ),
			__( 'Portfolio Builder', ERP_Portfolio::$textdomain ),
			'edit_posts',
			$this->page,
			array( $this, 'render' )
		);
	}

	function admin_styles( $hook ){
		if( $this->hook === $hook ){
			wp_enqueue_style( 'chosen',    ERP_ADMIN_ASSETS . '3rd_party/chosen/chosen.min.css',        false, ERP_Portfolio::$version );
			wp_enqueue_style( $this->page, ERP_ADMIN_ASSETS . 'css/builder.css',                        false, ERP_Portfolio::$version );
		}
	}

	function admin_scripts( $hook ){
		if( $this->hook === $hook ){
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'chosen',    ERP_ADMIN_ASSETS . '3rd_party/chosen/chosen.jquery.min.js', array( 'jquery' ), ERP_Portfolio::$version, true );
			wp_enqueue_script( $this->page, ERP_ADMIN_ASSETS . 'js/builder.js',                         array( 'jquery' ), ERP_Portfolio::$version, true );
			wp_localize_script( $this->page, __CLASS__, array(
				'AJAX_URL'          => admin_url( 'admin-ajax.php' ),
				'NONCE'             => wp_create_nonce( __CLASS__ ),
				'NO_RESULT'         => __( 'We couldn`t find any portfolio with a name of ', ERP_Portfolio::$textdomain ),
				'NO_RESULT_CAT'     => __( 'We couldn`t find any category with a name of ', ERP_Portfolio::$textdomain ),
				'NO_RESULT_ITEM'    => __( 'We couldn`t find any item with a name of ', ERP_Portfolio::$textdomain ),
				'CONFIRM_DEL_BUILD' => __( 'Do you really want to delete this portfolio?', ERP_Portfolio::$textdomain ),
				'CONFIRM_DEL_ITEM'  => __( 'Do you really want to delete this portfolio item?', ERP_Portfolio::$textdomain ),
			) );
		}
	}

	function render(){
		$builds = $this->get_portfolios();
		echo '<div class="wrap">
				<h2>', esc_html( __( 'Portfolio Builder', ERP_Portfolio::$textdomain ) ), '</h2>
				<div id="erp-ajax-response"></div>
				<div id="poststuff">
					<div id="post-body" class="metabox-holder columns-2">
						<div id="post-body-content" style="position:relative;">
							<p>', esc_html( __( 'Please create or select an existing portfolio...', ERP_Portfolio::$textdomain ) ), '</p>
							<div class="erp-build-container"></div>
						</div>
						<div id="postbox-container-1" class="postbox-container">
							<div id="side-sortables" class="meta-box-sortables ui-sortable">
								<h3>&nbsp;</h3>
								<div class="postbox">
									<h3 class="hndle erp-prtf-h">', esc_html( __( 'Build New Portfolio', ERP_Portfolio::$textdomain ) ), '</h3>
									<h3 class="erp-prtf-h"></h3>
									<div class="inside">
										<label id="erp-prtf-name-label" for="erp-prtf-name">', esc_html( __( 'Portfolio Name', ERP_Portfolio::$textdomain ) ), '</label>
										<input type="text" name="erp_portfolio_name" maxlenght="100" id="erp-prtf-name" autocomplete="off"/>
										<button type="button" id="erp-prtf-create" class="button-primary erp-prtf-button"><span class="dashicons dashicons-plus"></span></button>
									</div>
									<h3 class="hndle erp-prtf-h"></h3>
									<h3 class="hndle erp-prtf-h">', esc_html( __( 'Or Select Existing Portfolio', ERP_Portfolio::$textdomain ) ), '</h3> 
									<div class="inside">
										<select class="erp-chosen-builds" data-placeholder="', esc_attr( __( 'Choose a portfolio', ERP_Portfolio::$textdomain ) ), '">
											', $this->get_option_html( $builds, 'add_empty_option', 'extra_title' ), '
										</select>
									</div>
								</div>
								<div class="postbox erp-prtf-actions">
									<input type="button" name="erp_portfolio_update" id="erp_portfolio_update" value="', esc_attr( __( 'Update Portfolio', ERP_Portfolio::$textdomain ) ), '" class="button-primary" autocomplete="off"/>
									<input type="button" name="erp_portfolio_delete" id="erp_portfolio_delete" value="', esc_attr( __( 'Delete Portfolio', ERP_Portfolio::$textdomain ) ), '" class="button" autocomplete="off"/>
									<div class="erp-loader-wrap"><div class="erp-loader"></div></div>
								</div>
							</div>
						</div>
					</div>
					<br class="clear">
				</div>
			</div>';
	}

	private function get_portfolios( $args = array() ){
		$args = wp_parse_args( $args, array(
			'hide_empty' => false,
			'search'     => null,
		) );
		return get_terms( self::$taxonomy, $args );
	}

	private function get_categories( $args = array() ){
		$args = wp_parse_args( $args, array(
			'hide_empty' => false,
			'search'     => null,
		) );
		return get_terms( ERP_Portfolio::$taxonomy, $args );
	}

	private function get_items( $args = array() ){
		$args = wp_parse_args( $args, array(
			'tax_query' => array(),
			'post__in'  => array(),
		) );
		$args  = array_merge( $args, array(
			'post_type'      => ERP_Portfolio::$post_type,
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'meta_query'     => array(
				array(
					'key'     => '_thumbnail_id',
					'compare' => 'EXISTS',
				),
			),
		) );
		$page  = new WP_Query( $args );
		$items = array();
		if( $page->have_posts() ){
			while( $page->have_posts() ){
				$page->the_post();
				$img   = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail' );
				$items[] = array(
					'id'    => get_the_id(),
					'title' => get_the_title(),
					'image' => $img[0],
				);
			}
                        wp_reset_postdata();
		}
		return $items;
	}

	private function count_pages( $all, $listed = array() ){
		$data = array(
			'total'  => count( $all ),
			'showed' => count( $listed ),
			'pages'  => 0,
			'offset' => 0,
		);
		$data['pages']  = (int)ceil( $data['total'] / $this->builds_per_page );
		$page           = isset( $_POST['erp_page'] ) ? (int)$_POST['erp_page'] : 0;
		if( $page >= $data['pages'] || $page < 0 ){
			$page = 0;
		}
		$data['offset'] = $page * $this->builds_per_page;
		return $data;
	}

	function ajax_create_portfolio(){
		$data  = array(
			'err'  => true,
			'msg'  => 'Ooops!',
			'html' => '',
		);
		if( isset( $_POST['erp_nonce'] ) && wp_verify_nonce( $_POST['erp_nonce'], __CLASS__ ) ){
			$name = isset( $_POST['erp_name'] ) ? trim( $_POST['erp_name'] ) : false;
			if( $name && $name !== '' ){
				$result = wp_insert_term( $name, self::$taxonomy, array(
					'slug'        => sanitize_title( $name ),
					'description' => serialize( $this->defaults ),
				) );
				if( is_array( $result ) ){
					$data['err']  = false;
					$data['msg']  = __( 'Portfolio created successfully.', ERP_Portfolio::$textdomain );
					$builds       = $this->get_portfolios();
					$data['html'] = $this->get_option_html( $builds, 'add_empty_option', 'extra_title' );
				} else {
					$data['msg'] = $result->errors['term_exists'][0];
				}
			} else {
				$data['msg'] = __( 'Please provide a name for your new portfolio.', ERP_Portfolio::$textdomain );
			}
		}
		if( $data['err'] ){
			$data['msg'] = sprintf( '<div class="error"><p>%s</p></div>', $data['msg'] );
		} else {
			$data['msg'] = sprintf( '<div class="updated"><p>%s</p></div>', $data['msg'] );
		}
		exit( json_encode( $data ) );
	}

	function ajax_update_portfolio(){
		$data  = array(
			'err'  => true,
			'msg'  => 'Ooops!',
			'html' => '',
		);
		if( isset( $_POST['erp_nonce'], $_POST['erp_term'] ) && wp_verify_nonce( $_POST['erp_nonce'], __CLASS__ ) ){
			$term = get_term( absint( $_POST['erp_term'] ), self::$taxonomy );
			if( $term && !is_wp_error( $term ) ){
				$portfolio         = $this->defaults;
				$term_data         = unserialize( $term->description );
				$portfolio['meta'] = isset( $term_data['meta'] ) ? wp_parse_args( $term_data['meta'], $portfolio['meta'] ) : $portfolio['meta'];
				if( isset( $_POST['erp_description'] ) ){
					$portfolio['meta']['description'] = stripslashes( $_POST['erp_description'] );
				}
				if( isset( $_POST['erp_items'] ) && is_array( $_POST['erp_items'] ) ){
					$items =& $portfolio['items'];
					foreach( $_POST['erp_items'] as $item ){
						$id  = absint( $item );
						if( $id ){
							$items[] = $id;
							$portfolio['count']++;
						}
					}
				}
				$args = array(
					'description' => serialize( $portfolio ),
				);
				$updated = wp_update_term( (int)$_POST['erp_term'], self::$taxonomy, $args );
				if( $updated ){
					$data['err']  = false;
					$data['msg']  = __( 'Portfolio updated successfully!', ERP_Portfolio::$textdomain );
				} else {
					$data['msg']  = __( 'We encountered an error while trying to update your portfolio.', ERP_Portfolio::$textdomain );
				}
			} else {
				$data['msg']  = __( 'We encountered an error while trying to read your portfolio.', ERP_Portfolio::$textdomain );
			}
		}
		if( $data['err'] ){
			$data['msg'] = sprintf( '<div class="error"><p>%s</p></div>', $data['msg'] );
		} else {
			$data['msg'] = sprintf( '<div class="updated"><p>%s</p></div>', $data['msg'] );
		}
		exit( json_encode( $data ) );
	}

	function ajax_delete_portfolio(){
		$data  = array(
			'err'  => true,
			'msg'  => 'Ooops!',
			'html' => '',
		);
		if( isset( $_POST['erp_nonce'], $_POST['erp_term'] ) && wp_verify_nonce( $_POST['erp_nonce'], __CLASS__ ) ){
			$deleted = wp_delete_term( (int)$_POST['erp_term'], self::$taxonomy );
			if( $deleted ){
				$data['err']  = false;
				$data['msg']  = __( 'Portfolio deleted successfully!', ERP_Portfolio::$textdomain );
				$data['html'] = $this->get_option_html( $this->get_portfolios(), 'add_empty_option', 'extra_title' );
			} else {
				$data['msg']  = __( 'We encountered an error while trying to delete your portfolio.', ERP_Portfolio::$textdomain );
			}
		}
		if( $data['err'] ){
			$data['msg'] = sprintf( '<div class="error"><p>%s</p></div>', $data['msg'] );
		} else {
			$data['msg'] = sprintf( '<div class="updated"><p>%s</p></div>', $data['msg'] );
		}
		exit( json_encode( $data ) );
	}

	function ajax_get_portfolio(){
		$data  = array(
			'err'  => true,
			'msg'  => 'Ooops!',
			'html' => '',
		);
		if( isset( $_POST['erp_nonce'], $_POST['erp_term'] ) && wp_verify_nonce( $_POST['erp_nonce'], __CLASS__ ) ){
			$term = get_term( absint( $_POST['erp_term'] ), self::$taxonomy );
			if( $term && !is_wp_error( $term ) ){
				$portfolio  = !empty( $term->description ) ? @unserialize( $term->description ) : false;
				$portfolio  = wp_parse_args( $portfolio, $this->defaults );
				$items_html = '';
				if( $portfolio['count'] > 0 ){
					for( $i = 0, $ids = array(); $i < $portfolio['count']; $i++ ){
						$ids[] = $portfolio['items'][ $i ];
					}
					$__items = $this->get_items( array( 'post__in' => $ids ) );
					for( $i = 0; $i < $portfolio['count']; $i++ ){
						$item = false;
						for( $x = 0, $y = count( $__items ); $x < $y; $x++ ){
							if( (int)$portfolio['items'][ $i ] === (int)$__items[ $x ]['id'] ){
								$items_html.= '<div class="erp-sortable-item" data-id="' . absint( $__items[ $x ]['id'] ) . '">
									<div class="rm dashicons dashicons-welcome-comments"></div>
									<img src="' . esc_url( $__items[ $x ]['image'] ) . '"/>
								</div>';
								break;
							}
						}
					}
				}
				$data['err']  = false;
				$data['msg']  = '';
				$data['html'] = str_replace(
					array( "\n", "\r", "\t" ), '',
					'<h3>' . esc_html( $term->name ) . '</h3>
					<p class="description">Created on: ' . esc_html( date( $this->datetimeformat, $portfolio['meta']['created'] ) ) . ' &nbsp;&nbsp;-&nbsp;&nbsp; Updated on: ' . esc_html( date( $this->datetimeformat, $portfolio['meta']['updated'] ) ) . '</p>
					<div class="postbox">
						<h3 class="hndle erp-prtf-h">' . esc_html( __( 'Add Portfolio Items', ERP_Portfolio::$textdomain ) ) . '</h3>
						<div class="inside">
							<table class="widefat">
								<tr>
									<th width="25%">' . esc_html( __( 'Portfolio Categories', ERP_Portfolio::$textdomain ) ) . '</th>
									<td width="50%">
										<select class="erp-chosen-categories" data-placeholder="' . esc_attr( __( 'Choose a category', ERP_Portfolio::$textdomain ) ) . '">
											<option value="-1">' . esc_html( __( 'All', ERP_Portfolio::$textdomain ) ) . '</option>
											' . $this->get_option_html( $this->get_categories() ) . '
										</select>
									</td>
									<td width="5%">
										<input type="button" id="erp-add-category" class="button" value="' . esc_attr( __( 'Add Selected Category Items', ERP_Portfolio::$textdomain ) ) . '"/>
									</td>
									<td rowspan="2"><img id="erp-preview-img" width="75"/></td>
								</tr>
								<tr>
									<th>' . esc_html( __( 'Add Item to Portfolio', ERP_Portfolio::$textdomain ) ) . '</th>
									<td>
										<select class="erp-chosen-items" data-placeholder="' . esc_attr( __( 'Choose an item', ERP_Portfolio::$textdomain ) ) . '">
											' . $this->get_items_option_html( $this->get_items() ) . '
										</select>
									</td>
									<td>
										<input type="button" id="erp-add-item" class="button" value="' . esc_attr( __( 'Add Selected Item', ERP_Portfolio::$textdomain ) ) . '"/>
									</td>
								</tr>
							</table>
						</div>
					</div>
					<div class="postbox">
						<h3 class="hndle erp-prtf-h">' . esc_html( __( 'Portfolio Description', ERP_Portfolio::$textdomain ) ) . '</h3>
						<div class="inside">
							<textarea name="erp_description" id="erp-description" rows="2" cols="2" style="width:100%">' . esc_html( $portfolio['meta']['description'] ) . '</textarea>
						</div>
					</div>
					<div class="postbox">
						<h3 class="hndle erp-prtf-h">' . esc_html( __( 'Builder', ERP_Portfolio::$textdomain ) ) . '</h3>
						<div class="inside">
						<div class="erp-builder-wrap">
							<div class="erp-builder">' . $items_html . '</div>
						</div>
						</div>
					</div>'
				);
			} else {
				$data['msg']  = __( 'We encountered an error while trying to load your portfolio.', ERP_Portfolio::$textdomain );
			}
		}
		if( $data['err'] ){
			$data['msg'] = sprintf( '<div class="error"><p>%s</p></div>', $data['msg'] );
		} else {
			$data['msg'] = sprintf( '<div class="updated"><p>%s</p></div>', $data['msg'] );
		}
		exit( json_encode( $data ) );
	}

	function ajax_get_items(){
		$data  = array(
			'err'  => true,
			'msg'  => 'Ooops!',
			'html' => '',
		);
		if( isset( $_POST['erp_nonce'], $_POST['erp_cat'] ) && wp_verify_nonce( $_POST['erp_nonce'], __CLASS__ ) ){
			$catID = (int)$_POST['erp_cat'];
			$error = false;
			$args  = array();
			if( $catID === -1 ){
				// nothing to do / get all items
			} elseif( $catID > 0 ){
				$args['tax_query'] = array( array(
					'taxonomy'         => ERP_Portfolio::$taxonomy,
					'field'            => 'term_id',
					'terms'            => $catID,
					'include_children' => false,
				) );
			} else {
				$data['msg']  = __( 'Invalid category!', ERP_Portfolio::$textdomain );
			}
			if( !$error ){
				$data['err']  = false;
				$data['msg']  = '';
				$data['html'] = sprintf(
					'<select class="erp-chosen-items" data-placeholder="' . esc_attr( __( 'Choose an item', ERP_Portfolio::$textdomain ) ) . '">%s</select>',
					$this->get_items_option_html( $this->get_items( $args ) )
				);
			}
		}
		if( $data['err'] ){
			$data['msg'] = sprintf( '<div class="error"><p>%s</p></div>', $data['msg'] );
		} else {
			$data['msg'] = sprintf( '<div class="updated"><p>%s</p></div>', $data['msg'] );
		}
		exit( json_encode( $data ) );
	}

	private function get_option_html( $builds, $set_empty = 'add_empty_option', $extra_header = null ){
		$html = $set_empty === 'add_empty_option' ? '<option value=""></option>' : '';
		foreach( $builds as $build ){
			$title = $build->name;
			if( $extra_header === 'extra_title' ){
				$details = isset( $build->description ) ? @unserialize( $build->description ) : false;
				if( isset( $details['meta']['description'] ) && !empty( $details['meta']['description'] ) ){
					$title .= sprintf( ' - %s...', trim( substr( $details['meta']['description'], 0, 20 ) ) );
				}
			}
			$html.= sprintf( '<option value="%u">%s</option>', $build->term_id, esc_html( $title ) );
		}
		return $html;
	}

	private function get_items_option_html( $posts, $set_empty = 'add_empty_option' ){
		$html = $set_empty === 'add_empty_option' ? '<option value=""></option>' : '';
		foreach( $posts as $post ){
			$html.= sprintf( '<option value="%u" data-img-src="%s">%s</option>', $post['id'], esc_url( $post['image'] ), esc_html( $post['title'] ) );
		}
		return $html;
	}

}