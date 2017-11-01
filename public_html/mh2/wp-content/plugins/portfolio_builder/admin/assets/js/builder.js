(function($){
	$(function(){
		var timeout, modified = false,
			chosenOptions = {
				no_results_text: Builder_ERP_Extension.NO_RESULT,
				width: '100%'
			},
			chosenCategory = {
				no_results_text: Builder_ERP_Extension.NO_RESULT_CAT,
				width: '100%'
			},
			chosenItem = {
				no_results_text: Builder_ERP_Extension.NO_RESULT_ITEM,
				width: '100%'
			};
		function ERP_Portfolio(){
			this.container = function( a, x ){
				var x = x || '';
				if( a == 'show' ){
					$('.erp-build-container').html(x).prev().hide();
					$('.erp-chosen-categories').chosen(chosenCategory);
					$('.erp-chosen-items').chosen(chosenItem);
				} else if( a == 'hide' ){
					$('.erp-chosen-categories').chosen('destroy');
					$('.erp-chosen-items').chosen('destroy');
					$('.erp-build-container').html(x).prev().show();
				}
			};
			this.grids_init = function(){
				$('.erp-builder').sortable();
			};
			this.add_widget = function( src, id ){
				$('.erp-builder').append('<div class="erp-sortable-item" data-id="'+parseInt( id )+'"><div class="rm dashicons dashicons-welcome-comments"></div><img src="'+src+'"/></div>');
			};
			this.remove_widget = function( elem ){
				$(elem).remove();
			};
		}
		PRTF = new ERP_Portfolio;
		$('#portfolio-manager-form').on('submit',function(e){e.preventDefault()});
		$('#erp-prtf-create').click(function(){
			var self = this;
			if($('#erp-prtf-name').val().trim() != ''){
				self.disabled = true;
				data = {
					'action'   : 'erp_create_portfolio',
					'erp_nonce': Builder_ERP_Extension.NONCE,
					'erp_name' : $('#erp-prtf-name').val().trim()
				};
				$.post(Builder_ERP_Extension.AJAX_URL,data,function(d){
					if( !d.err ){
						$('.erp-chosen-builds').chosen('destroy').html(d.html).chosen(chosenOptions);
						$('.erp-prtf-actions').hide();
						$('#erp-prtf-name').val('');
					}
					PRTF.container('hide');
					$('#erp-ajax-response').html(d.msg);
					self.disabled = false;
				},'json');
			}
		});
		$('.erp-chosen-builds').chosen(chosenOptions).on('change',function(){
			if( this.value > 0 ){
				var data = {
					'action'   : 'erp_get_portfolio',
					'erp_nonce': Builder_ERP_Extension.NONCE,
					'erp_term' : $('.erp-chosen-builds').val()
				};
				PRTF.container('show','<div class="erp-loader"></div>');
				$('.erp-prtf-actions').hide().find('input').removeAttr('disabled');
				$('.erp-loader-wrap').hide();
				$.post(Builder_ERP_Extension.AJAX_URL,data,function(d){
					if( !d.err ){
						PRTF.container('show',d.html);
						PRTF.grids_init();
						$('.erp-prtf-actions').fadeIn();
						$('#erp-ajax-response').html('');
					} else {
						PRTF.container('hide');
						$('#erp-ajax-response').html(d.msg);
					}
				},'json');
			}
		}).change();
		$('#erp_portfolio_delete').on('click',function(){
			if( confirm( Builder_ERP_Extension.CONFIRM_DEL_BUILD ) ){
				var self = this,
					data = {
						'action'   : 'erp_delete_portfolio',
						'erp_nonce': Builder_ERP_Extension.NONCE,
						'erp_term' : $('.erp-chosen-builds').val()
					};
				$('.erp-prtf-actions input').attr('disabled','disabled');
				$('.erp-loader-wrap').show();
				$.post(Builder_ERP_Extension.AJAX_URL,data,function(d){
					if( !d.err ){
						$('.erp-chosen-builds').chosen('destroy').html(d.html).chosen(chosenOptions);
						$('.erp-prtf-actions').hide();
					} else {
						$('.erp-build-default-text').show().next().html('');
					}
					$('#erp-ajax-response').html(d.msg);
					PRTF.container('hide');
					$('.erp-prtf-actions input').removeAttr('disabled');
					$('.erp-loader-wrap').hide();
				},'json');
			}
		});
		$('#erp_portfolio_update').on('click',function(){
			var self = this,
				data = {
					'action'          : 'erp_update_portfolio',
					'erp_nonce'       : Builder_ERP_Extension.NONCE,
					'erp_term'        : $('.erp-chosen-builds').val(),
					'erp_description' : document.getElementById('erp-description').value,
					'erp_items'       : []
				};
			$('.erp-prtf-actions input').attr('disabled','disabled');
			$('.erp-loader-wrap').show();
			$('.erp-sortable-item').each(function(){
				data.erp_items.push($(this).attr('data-id'));
			});
			$.post(Builder_ERP_Extension.AJAX_URL,data,function(d){
				$('#erp-ajax-response').html(d.msg);
				$('.erp-prtf-actions input').removeAttr('disabled');
				$('.erp-loader-wrap').hide();
			},'json');
		});
		$('.erp-chosen-categories').chosen(chosenCategory);
		$('.erp-chosen-items').chosen(chosenItem);
		$(document)
			.on('change','.erp-chosen-categories',function(){
				var data = {
					'action'   : 'erp_get_items',
					'erp_nonce': Builder_ERP_Extension.NONCE,
					'erp_cat'  : this.value
				};
				$('#erp-preview-img').removeAttr('src');
				$('#erp-add-item').hide();
				$('.erp-chosen-items').chosen('destroy').replaceWith('<div class="erp-loader"></div>');
				$.post(Builder_ERP_Extension.AJAX_URL,data,function(d){
					$('.erp-loader').replaceWith(d.html);
					$('.erp-chosen-items').chosen(chosenItem);
					if( d.err ){
						$('#erp-ajax-response').html(d.msg);
					}
				},'json');
			})
			.on('change','.erp-chosen-items',function(){
				var img = $(this.options[ this.selectedIndex ]).attr('data-img-src');
				document.getElementById('erp-preview-img').src = img;
				document.getElementById('erp-add-item').style.display = 'inline';
			})
			.on('click','#erp-add-category',function(){
				$($('.erp-chosen-items')[0].options).each(function(){
					if( $(this).attr('data-img-src') ){
						PRTF.add_widget( $(this).attr('data-img-src'), $(this).val() );
					}
				});
			})
			.on('click','#erp-add-item',function(){
				var $opt = $('.erp-chosen-items :selected');
				PRTF.add_widget( $opt.attr('data-img-src'), $opt.val() );
			})
			.on('click','.erp-sortable-item .rm',function(){
				if( confirm( Builder_ERP_Extension.CONFIRM_DEL_ITEM ) ){
					PRTF.remove_widget( this.parentNode );
				}
			});
	});
})(jQuery);