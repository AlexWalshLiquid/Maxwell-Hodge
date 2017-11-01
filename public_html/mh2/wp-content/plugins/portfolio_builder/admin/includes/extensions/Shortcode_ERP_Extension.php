<?php

if( !defined( 'ERP_PATH' ) ){
	exit;
}

class Shortcode_ERP_Extension extends ERP_Extension_Model {

	static		$instance = 0;

	function __construct(){
		parent::__construct();
	}

	function register_hooks(){
		add_shortcode(    ERP_Portfolio::$shortcode,    array( $this, 'do_shortcode' ) );
		ERP_HOOK::FILTER( 'single_template',                   $this, 'iframe_view' );
		ERP_HOOK::ACTION( 'wp_ajax_load_erp_portfolio',        $this, 'load_portfolio' );
		ERP_HOOK::ACTION( 'wp_ajax_nopriv_load_erp_portfolio', $this, 'load_portfolio' );
	}

	function iframe_view( $single ){
		global $post;
		if( $post->post_type === ERP_Portfolio::$post_type && isset( $_GET['ajaxed'] ) ){
			return ERP_INCLUDES . 'template/iframe.php';
		}
		return $single;
	}

	function front_scripts(){
		wp_enqueue_script( 'imagesloaded',   ERP_ASSETS . '3rd_party/imagesloaded/imagesloaded.min.js',    array( 'jquery' ), ERP_Portfolio::$version, true );
		wp_enqueue_script( 'isotope',        ERP_ASSETS . '3rd_party/isotope/isotope.min.js',              array( 'jquery' ), ERP_Portfolio::$version, true );
		wp_enqueue_script( 'magnificpopup',  ERP_ASSETS . '3rd_party/magnificpopup/magnific-popup.min.js', array( 'jquery' ), ERP_Portfolio::$version, true );
		wp_enqueue_script( 'erp-shortcode',  ERP_ASSETS . 'js/ajax.js',                                    array( 'jquery' ), ERP_Portfolio::$version, true );
		wp_localize_script( 'erp-shortcode', __CLASS__, array(
			'AJAX_URL'       => admin_url( 'admin-ajax.php' ),
			'NONCE'          => wp_create_nonce( __CLASS__ ),
			'INSTANCE'       => array(),
			'LANG'           => array(
				'ALL' => __( 'All', ERP_Portfolio::$textdomain ),
			),
		) );
	}

	function front_styles(){
		wp_enqueue_style( 'font-awesome',            ERP_ASSETS . '3rd_party/font-awesome/css/font-awesome.min.css', false, ERP_Portfolio::$version );
		wp_enqueue_style( 'magnificpopup',           ERP_ASSETS . '3rd_party/magnificpopup/magnific-popup.css',      false, ERP_Portfolio::$version );
		wp_enqueue_style( ERP_Portfolio::$post_type, ERP_ASSETS . 'css/portfolio.css',                               false, ERP_Portfolio::$version );
	}

	function do_shortcode( $atts ){
		$atts = shortcode_atts( array(
			'build'            => 0,
			'ratio'            => 1,
			'pagination'       => 2,
			'columns'          => 4,
			'items'            => 10,
			'filter'           => true,
			'zoomable'         => true,
			'linkable'         => false,
			'ajaxed'           => true,
			'layout'           => 'masonry',
			'gutter'           => 0,
			'show_category'    => true,
			'description'      => true,
			'desc_position'    => 1,
			'filter_align'     => 'center',
			'pagination_align' => 'center',
		), $atts, ERP_Portfolio::$shortcode );
		$portfolio = $this->get_single_portfolio( $atts );
		$html      = '';
		if( $portfolio['count'] > 0 ){
			$html.= sprintf( '<script type="text/javascript">
			// <![CDATA[
			if( typeof TEMPORARY_ERP_PORTFOLIO_INSTANCE == "undefined" ){
				var TEMPORARY_ERP_PORTFOLIO_INSTANCE = [];
			}
			TEMPORARY_ERP_PORTFOLIO_INSTANCE[%u] = %s;
			// ]]>
			</script>', self::$instance, json_encode( array_merge( $atts, array( 'page' => 1 ) ) ) );
			if( (bool)$atts['filter'] ){
				$align = $atts['filter_align'] === 'left' ? 'text-left' : ( $atts['filter_align'] === 'right' ? 'text-right' : 'text-center' );
				$html.= '
				<div class="portfolio-filter ' . esc_attr( $align ) . '">
					<ul class="erp-filters" data-target="#erp-instance-' . esc_attr( self::$instance ) . '">
						<li><a href="#" class="active" data-filter="*">' . esc_html( __( 'All', ERP_Portfolio::$textdomain ) ) . '</a></li>';
				for( $i = 0; $i < $portfolio['cats']['count']; $i++ ){
					$slug = $portfolio['cats']['items'][ $i ]['slug'];
					$name = $portfolio['cats']['items'][ $i ]['name'];
					$html.= '<li><a href="#" data-filter=".' . esc_attr( $slug ) . '">' . esc_html( $name ) . '</a></li>';
				}
				$html.= '
					</ul>
				</div>';
			}
			switch( $atts['columns'] ){
				case 2 : $cols = 'two-cols'; break;
				case 3 : $cols = 'three-cols'; break;
				case 4 : $cols = 'four-cols'; break;
				case 5 : $cols = 'five-cols'; break;
				default: $cols = 'four-cols';
			}
			$gutter = absint( $atts['gutter'] ) > 0 ? 'gutter' : '';
			if( $gutter ){
				$html.= sprintf( '
				<style type="text/css">
					#erp-instance-%1$u.portfolio-grid.gutter{margin-top:-%2$upx;margin-right:-%2$upx;margin-left:-%2$upx;}
					#erp-instance-%1$u.portfolio-grid.gutter .item{padding:%2$upx;}
				</style>
				', self::$instance, absint( $atts['gutter'] ) );

			}
			$html.= '<div class="erp-loader"></div>';
			$html.= '<div id="erp-instance-' . esc_attr( self::$instance ) . '" class="isotope-init portfolio-grid ' . esc_attr( $gutter ) . ' ' . esc_attr( $cols ) . '" data-layout="' . esc_attr( $atts['layout'] ) . '">';
			for( $i = 0; $i < $portfolio['count']; $i++ ){
				$item = $portfolio['items'][ $i ];
                                
                                if(has_excerpt()){
                                            $excerpt='<p>'.get_the_excerpt().'</p>';
                                        }else{
                                            $excerpt='';
                                        }
                                
				$html.= '<div class="item ' . esc_attr( $item['classes'] ) . '">
					<div class="portfolio-item">
						<div class="portfolio-item-preview">
							<img src="' . esc_attr( $item['thumbnail'] ) . '" alt=""/>
							<div class="portfolio-item-overlay">
								<div class="portfolio-item-overlay-actions"><a class="portfolio-item-zoom magnificPopup-gallery" href="' . esc_url( $item['large_img'] ) . '">+</a>' .
									( (bool)$atts['linkable'] ?
									'<a class="portfolio-item-link' . ( (bool)$atts['ajaxed'] ? ' magnificPopup-link' : '' ) . '" href="' . esc_url( $item['link'] ) . '">
										<i class="fa fa-link"></i>
									</a>' : '' ) . '
								</div>' .
								( ( (bool)$atts['description'] && absint( $atts['desc_position'] ) === 1 ) ?
								'<div class="portfolio-item-description">
									<h4><a href="' . esc_url( $item['link'] ) . '"' . ( (bool)$atts['ajaxed'] ? ' class="magnificPopup-link"' : '' ) . '>' . esc_html( $item['title'] ) . '</a></h4>
									<p>' . $excerpt . '</p>' .
									( (bool)$atts['show_category'] ? '<h6>' . esc_html( $item['categories'] ) . '</h6>' : '' ) .
								'</div>' : '' ) .
							'</div>
						</div>' .
						( ( (bool)$atts['description'] && absint( $atts['desc_position'] ) === 2 ) ?
							'<div class="portfolio-item-description">
								<h4><a href="' . esc_url( $item['link'] ) . '"' . ( (bool)$atts['ajaxed'] ? ' class="magnificPopup-link"' : '' ) . '>' . esc_html( $item['title'] ) . '</a></h4>
								<p>' . $excerpt . '</p>' .
								( (bool)$atts['show_category'] ? '<h6>' . esc_html( $item['categories'] ) . '<h/6>' : '' ) .
							'</div>' : '' ) .
					'</div>
				</div>';
			}
			$html.= '</div>';
			if( absint( $atts['pagination'] ) !== 1 && $portfolio['more'] ){
				$align = $atts['pagination_align'] === 'left' ? 'text-left' : ( $atts['pagination_align'] === 'right' ? 'text-right' : 'text-center' );
				switch( absint( $atts['pagination'] ) ){
					case 2:
						$html.= '<p class="erp-pagination-load ' . esc_attr( $align ) . '" data-instance="' . esc_attr( self::$instance ) . '">';
						$html.= '<a href="#page=2" class="btn btn-black btn-large load-more erp-load-more">'.__( 'Load more', ERP_Portfolio::$textdomain ).'</a>';
						$html.= '</p>';
						break;
					case 3:
						$html.= '<div class="erp-pagination ' . esc_attr( $align ) . '" data-instance="' . esc_attr( self::$instance ) . '">';
						$html.= paginate_links( array(
							'total'   => $portfolio['pages'],
							'current' => 1,
							'base'    => '#erp-page=%#%',
							'type'    => 'list',
                                                        'prev_next'  => False,
						) );
						$html.= '</div>';
						break;
				}
			}
			self::$instance++;
		}
		return $html;
	}

	function load_portfolio(){
		if( isset( $_POST['erp_nonce'] ) && wp_verify_nonce( $_POST['erp_nonce'], __CLASS__ ) ){
			$atts = wp_parse_args( $_POST['instance'], array(
				'build'            => 0,
				'ratio'            => 1,
				'pagination'       => 2,
				'columns'          => 4,
				'items'            => 10,
				'filter'           => true,
				'zoomable'         => true,
				'linkable'         => false,
				'ajaxed'           => true,
				'layout'           => 'masonry',
				'gutter'           => 0,
				'show_category'    => true,
				'description'      => true,
				'desc_position'    => 1,
				'filter_align'     => 'center',
				'pagination_align' => 'center',
				'page'             => 1,
				'__id__'           => 0,
			) );
			$portfolio = $this->get_single_portfolio( $atts );
			$data      = array(
				'filters' => '',
				'items'   => '',
				'nav'     => '',
			);
			if( (bool)$atts['filter'] ){
				if( absint( $atts['pagination'] ) !== 2 ){
					$data['filters'].= '
					<div class="portfolio-filter">
						<ul class="erp-filters" data-target="#erp-instance-' . esc_attr( $atts['__id__'] ) . '">
							<li><a href="#" class="active" data-filter="*">' . esc_html( __( 'All', ERP_Portfolio::$textdomain ) ) . '</a></li>';
				}
				for( $i = 0; $i < $portfolio['cats']['count']; $i++ ){
					$slug = $portfolio['cats']['items'][ $i ]['slug'];
					$name = $portfolio['cats']['items'][ $i ]['name'];
					$data['filters'].= '<li><a href="#" data-filter=".' . esc_attr( $slug ) . '">' . esc_html( $name ) . '</a></li>';
				}
				if( absint( $atts['pagination'] ) !== 2 ){
					$data['filters'].= '
						</ul>
					</div>';
				}
			}
			if( $portfolio['count'] > 0 ){
				switch( $atts['columns'] ){
					case 2 : $cols = 'two-cols'; break;
					case 3 : $cols = 'three-cols'; break;
					case 4 : $cols = 'four-cols'; break;
					case 5 : $cols = 'five-cols'; break;
					default: $cols = 'four-cols';
				}
				for( $i = 0; $i < $portfolio['count']; $i++ ){
					$item = $portfolio['items'][ $i ];
                                        
                                        if($item['excerpt']!=''){
                                            $excerpt='<p>'.esc_html($item['excerpt']).'</p>';
                                        }else{
                                            $excerpt='';
                                        }
                                        
					$data['items'].= '<div class="item ' . esc_attr( $item['classes'] ) . '">
						<div class="portfolio-item">
							<div class="portfolio-item-preview">
								<img src="' . esc_attr( $item['thumbnail'] ) . '" alt=""/>
								<div class="portfolio-item-overlay">
									<div class="portfolio-item-overlay-actions">
										' . ( (bool)$atts['zoomable'] ?
										'<a class="portfolio-item-zoom magnificPopup-gallery" href="' . esc_url( $item['large_img'] ) . '">+</a>' : '' ) .
										( (bool)$atts['linkable'] ?
										'<a class="portfolio-item-link' . ( (bool)$atts['ajaxed'] ? ' magnificPopup-link' : '' ) . '" href="' . esc_url( $item['link'] ) . '"></i>
										</a>' : '' ) . '
									</div>' .
									( ( (bool)$atts['description'] && absint( $atts['desc_position'] ) === 1 ) ?
									'<div class="portfolio-item-description">
										<h4><a href="' . esc_url( $item['link'] ) . '"' . ( (bool)$atts['ajaxed'] ? ' class="magnificPopup-link"' : '' ) . '>' . esc_html( $item['title'] ) . '</a></h4>
										<p>' . $excerpt . '</p>' .
										( (bool)$atts['show_category'] ? '<h6>' . esc_html( $item['categories'] ) . '</h6>' : '' ) .
									'</div>' : '' ) .
								'</div>
							</div>' .
							( ( (bool)$atts['description'] && absint( $atts['desc_position'] ) === 2 ) ?
								'<div class="portfolio-item-description">
									<h4><a href="' . esc_url( $item['link'] ) . '"' . ( (bool)$atts['ajaxed'] ? ' class="magnificPopup-link"' : '' ) . '>' . esc_html( $item['title'] ) . '</a></h4>
									<p>' . $excerpt . '</p>' .
									( (bool)$atts['show_category'] ? '<h6>' . esc_html( $item['categories'] ) . '</h6>' : '' ) .
								'</div>' : '' ) .
						'</div>
					</div>';
				}
				switch( absint( $atts['pagination'] ) ){
					case 2:
						if( $portfolio['more'] ){
							$data['nav'].= '<a href="#page=' . absint( $atts['page'] + 1 ) . '" class="btn btn-black btn-large load-more erp-load-more">'.__( 'Load more', ERP_Portfolio::$textdomain ).'</a>';
						}
						break;
					case 3:
						$data['nav'].= paginate_links( array(
							'total'   => $portfolio['pages'],
							'current' => $atts['page'],
							'base'    => '#erp-page=%#%',
							'type'    => 'list',
						) );
						break;
				}
			}
			$data['filters'] = str_replace( array( "\t", "\r", "\n" ), '', $data['filters'] );
			$data['items']   = str_replace( array( "\t", "\r", "\n" ), '', $data['items'] );
			$data['nav']     = str_replace( array( "\t", "\r", "\n" ), '', $data['nav'] );
			exit( json_encode( $data ) );
		}
	}

	private function get_single_portfolio( $atts ){
		$term = get_term( $atts['build'], Builder_ERP_Extension::$taxonomy );
		if( $term && !is_wp_error( $term ) ){
			$portfolio = isset( $term->description ) ? @unserialize( $term->description ) : false;
			$offset    = absint( ( isset( $atts['page'] ) ? absint( $atts['page'] - 1 ) : 0 ) * $atts['items'] );
			if( $portfolio['count'] > 0 ){
				$c = min(
					$portfolio['count'],
					min( absint( $atts['items'] ), 999 )
				) + $offset;
				for( $i = 0, $ids = array(); $i < $c; $i++ ){
					if( $i >= $offset && isset( $portfolio['items'][ $i ] ) ){
						$ids[] = $portfolio['items'][ $i ];
					}
				}
				$args  = array(
					'post_type'      => ERP_Portfolio::$post_type,
					'post_status'    => 'publish',
					'posts_per_page' => min( absint( $atts['items'] ), 999 ),
					'post__in'       => $ids,
					'meta_query'     => array(
						array(
							'key'     => '_thumbnail_id',
							'compare' => 'EXISTS',
						),
					),
				);
				$page    = new WP_Query( $args );
				$items   = array();
				$__items = array(
					'count' => 0,
					'more'  => false,
					'pages' => ceil( $portfolio['count'] / min( absint( $atts['items'] ), 999 ) ),
					'items' => array(),
					'cats'  => array(
						'count' => 0,
						'items' => array(),
					),
				);
				if( $page->have_posts() ){

					while( $page->have_posts() ){
						$page->the_post();
						$use_default_img = false;
						$image_type      = '';
						// columns
						switch( $atts['columns'] ){
							case 2 :
							case 3 : $image_type     .= 'erp_960_'; break;
							case 4 :
							case 5 : $image_type     .= 'erp_480_'; break;
							default: $use_default_img = true;
						}
						// aspect ratio
						switch( $atts['ratio'] ){
							case 1 : $image_type     .= '1-auto'; break;
							case 2 : $image_type     .= '1-1';    break;
							case 3 : $image_type     .= '16-9';   break;
							default: $use_default_img = true;
						}
						if( $use_default_img ){
							$image_type = 'large';
						}
						$thumbnail      = wp_get_attachment_image_src( get_post_thumbnail_id(), $image_type );
						$large_img      = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
						$categories = array(
							'slug' => array(),
							'name' => array(),
						);
						$x_cats     = get_the_terms( get_the_ID(), ERP_Portfolio::$taxonomy );
						if( $x_cats && !is_wp_error( $x_cats ) ){
							for( $x = 0, $y = count( $x_cats ); $x < $y; $x++ ){
								$categories['slug'][] = $x_cats[ $x ]->slug;
								$categories['name'][] = $x_cats[ $x ]->name;
							}
						}
						$items[] = array(
							'id'         => get_the_ID(),
							'title'      => get_the_title(),
							'excerpt'    => get_the_excerpt(),
							'link'       => get_the_permalink(),
							'thumbnail'  => $thumbnail[0],
							'large_img'  => $large_img[0],
							'categories' => $categories,
						);
					}
                                        wp_reset_postdata();
				}
				$c = min(
					$portfolio['count'],
					min( absint( $atts['items'] ), 999 )
				) + $offset;
				for( $i = 0; $i < $c; $i++ ){
					if( $i >= $offset ){
						$item = false;
						for( $x = 0, $y = count( $items ); $x < $y; $x++ ){
							if( isset( $portfolio['items'][ $i ] ) && (int)$portfolio['items'][ $i ] === (int)$items[ $x ]['id'] ){
								$item = $items[ $x ];
								break;
							}
						}
						if( $item ){
							$__items['count']++;
							$__items['items'][] = array(
								'id'         => $item['id'],
								'thumbnail'  => $item['thumbnail'],
								'large_img'  => $item['large_img'],
								'title'      => $item['title'],
								'excerpt'    => $item['excerpt'],
								'link'       => $item['link'],
								'classes'    => implode( ' ', $item['categories']['slug'] ),
								'categories' => implode( ', ', $item['categories']['name'] ),
							);
							// if by any chance the collections in the [slug] array don`t match the collections in the [name] array,
							// then the count is the minimum number of items between them,
							// obviously this may produce unwanted offsets if there not equal
							$v = min(
								count( $item['categories']['slug'] ),
								count( $item['categories']['name'] )
							);
							for( $z = 0; $z < $v; $z++ ){
								$__items['cats']['items'][] = array(
									'slug' => $item['categories']['slug'][ $z ],
									'name' => $item['categories']['name'][ $z ],
								);
							}
						}
					}
				}
				if( absint( $atts['pagination'] ) !== 1 && ( $portfolio['count'] - $offset ) > $args['posts_per_page'] ){
					$__items['more'] = true;
				}
				$__items['cats']['items'] = array_values( array_map( 'unserialize', array_unique( array_map( 'serialize', $__items['cats']['items'] ) ) ) );
				for( $i = 0, $__items['cats']['count'] = count( $__items['cats']['items'] ), $sorter = array(); $i < $__items['cats']['count']; $i++ ){
					$sorter[] = strtolower( $__items['cats']['items'][ $i ]['name'] );
				}
				array_multisort( $sorter, SORT_ASC, $__items['cats']['items'] );
				return $__items;
			}
		}
		return;
	}

}
