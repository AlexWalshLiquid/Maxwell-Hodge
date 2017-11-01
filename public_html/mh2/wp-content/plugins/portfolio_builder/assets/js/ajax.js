if( typeof TEMPORARY_ERP_PORTFOLIO_INSTANCE != 'undefined' ){
	Shortcode_ERP_Extension.INSTANCE = TEMPORARY_ERP_PORTFOLIO_INSTANCE;
}
(function($){
	$(function(){
		function init_gallery(){
			$('.magnificPopup-gallery').magnificPopup({
				disableOn : 400,
				type      : 'image',
				gallery   : {
					enabled : true
				}
			});
		}
		// Isotope
		if( $('.isotope-init').length > 0 ){
			var $all = $('.isotope-init');
			$all.find('img').hide();
			$all.each(function(){
				var $self = $(this);
				$self.imagesLoaded(function(){
					$self.find('img').show();
					$self.prev().hide();
					$self.isotope({
						itemSelector : '.item',
						layoutMode   : $self.attr( 'data-layout' )
					});
					$(document).on( 'click', '.erp-filters a',function( evt ){
						evt.preventDefault();
						$( $(this).closest('.erp-filters').attr('data-target') ).isotope({
							filter : $(this).attr('data-filter')
						});
						$(this).closest('.erp-filters').find('a').removeClass('active');
						$(this).addClass('active');
					});
				});
			});
			// Pagination Actions
			$(document)
			.on('click','.erp-pagination a',function( evt ){
				evt.preventDefault();
				var $parent  = $(this).closest('.erp-pagination'),
					settings = Shortcode_ERP_Extension.INSTANCE[ $parent.attr('data-instance') ] ? Shortcode_ERP_Extension.INSTANCE[ $parent.attr('data-instance') ] : {},
					data     = {
						'action'    : 'load_erp_portfolio',
						'erp_nonce' : Shortcode_ERP_Extension.NONCE,
						'instance'  : settings,
					},
					page     = parseInt( this.href.split( '#' )[1].split('=')[1] );
				if( !isNaN( page ) ){
					data.instance.page   = page;
					data.instance.__id__ = $parent.attr('data-instance');
					var $container = $('#erp-instance-'+data.instance.__id__);
					$container.hide().prev().show();
					$container.isotope({ filter: '*' });
					$container.isotope( 'remove', $container.isotope('getItemElements') );
					$parent.hide();
					$.post(Shortcode_ERP_Extension.AJAX_URL,data,function(d){
						$('.erp-filters[data-target="#erp-instance-'+data.instance.__id__+'"]').html(d.filters);
						var $imgs = $(d.items);
						$imgs.imagesLoaded(function(){
							$container.show();
							$container.isotope( 'insert', $(d.items) );
							$container.prev().hide();
							$parent.show().html(d.nav);
							init_gallery();
						});
					},'json');
				}
			})
			.on('click','.erp-pagination-load a',function( evt ){
				evt.preventDefault();
				var $parent  = $(this).parent(),
					settings = Shortcode_ERP_Extension.INSTANCE[ $parent.attr('data-instance') ] ? Shortcode_ERP_Extension.INSTANCE[ $parent.attr('data-instance') ] : {},
					data     = {
						'action'    : 'load_erp_portfolio',
						'erp_nonce' : Shortcode_ERP_Extension.NONCE,
						'instance'  : settings,
					},
					page     = parseInt( this.href.split( '#' )[1].split('=')[1] );
				if( !isNaN( page ) ){
					data.instance.page   = page;
					data.instance.__id__ = $parent.attr('data-instance');
					var $container = $('#erp-instance-'+data.instance.__id__);
					$parent.html('<div class="erp-loader"></div>');
					$.post(Shortcode_ERP_Extension.AJAX_URL,data,function(d){
						var $filters = $('.erp-filters[data-target="#erp-instance-'+data.instance.__id__+'"]'),
							$li      = $filters.append( d.filters ).find('li'),
							itemsObj = {}, items = [], all = '';
						$li.each(function(){
							var idx = this.childNodes[0].innerHTML;
							if( !itemsObj[ idx ] && idx != Shortcode_ERP_Extension.LANG.ALL ){
								itemsObj[ idx ] = this.outerHTML;
							} else if( !itemsObj[ idx ] && idx == Shortcode_ERP_Extension.LANG.ALL ){
								all = this.outerHTML;
							}
						});
						for( n in itemsObj ){
							items.push( itemsObj[ n ] );
						}
						items.sort(function( a, b ){
							var aa = a.toLowerCase(), bb = b.toLowerCase();
							return aa < bb ? -1 : ( aa > bb ? 1 : 0 );
						});
						$filters.html( all + items.join('') );
						var $imgs = $( d.items );
						$imgs.imagesLoaded(function(){
							$container.isotope( 'insert', $(d.items) );
							$parent.html(d.nav);
							init_gallery();
						});
					},'json');
				}
			});
		}
		// Magnific PopUp
		$(document).on('click','.magnificPopup-link',function( evt ){
			var src = this.href+'?ajaxed';
			evt.preventDefault();
			$.magnificPopup.open({
				items : {
					src : '<div class="mfp-iframe-scaler erp-iframe-wrap">'+
								'<div class="mfp-close" title="Close (Esc)">&#xD7;</div>'+
								'<div class="erp-loader"></div>'+
								'<iframe class="mfp-iframe" frameborder="0" allowfullscreen="no" scrolling="no" src="' + src + '"' +
								' onload="jQuery(this).css({position:\'relative\',left:0}).height(jQuery(this).contents().height()).prev().hide();"></iframe>'+
							'</div>'
				}
			});
		});
		init_gallery();
	});
})(jQuery);