tinymce.PluginManager.add( Tinymce_ERP_Extension.SHORTCODE, function( editor, url ){
    editor.addButton( Tinymce_ERP_Extension.SHORTCODE, {
        title: Tinymce_ERP_Extension.LANG.PLG_TEXT,
        text: Tinymce_ERP_Extension.LANG.PLG_TEXT,
        //image: Tinymce_ERP_Extension.COMPONENT_ICON,
        icon: 'dashicon dashicon-before dashicons-format-image',
        onclick: function() {
            editor.windowManager.open({
                title    : Tinymce_ERP_Extension.LANG.PLG_TITLE,
                body     : 
				Tinymce_ERP_Extension.PORTFOLIOS.length > 0 ?
					[
						{
							type : 'container',
							html : '<h2 style="font-weight:bold;font-size:16px;">'+Tinymce_ERP_Extension.LANG.SOURCE+'</h2>'
						},
						{
							type   : 'listbox',
							name   : 'build',
							label  : Tinymce_ERP_Extension.LANG.CHOOSE_PORTFOLIO,
							values : Tinymce_ERP_Extension.PORTFOLIOS
						},
						{
							type : 'container',
							html : '<h2 style="font-weight:bold;font-size:16px;">'+Tinymce_ERP_Extension.LANG.LAYOUT_SETTINGS+'</h2>'
						},
						{
							type   : 'listbox',
							name   : 'layout',
							label  : Tinymce_ERP_Extension.LANG.LAYOUT_TYPE,
							values : Tinymce_ERP_Extension.LAYOUTS
						},
						{
							type   : 'listbox',
							name   : 'columns',
							label  : Tinymce_ERP_Extension.LANG.NUMBER_OF_COLS,
							values : Tinymce_ERP_Extension.COLUMNS
						},
						{
							type      : 'textbox',
							name      : 'gutter',
							label     : Tinymce_ERP_Extension.LANG.PADDING_BETWEEN,
							maxWidth  : 36,
							maxLength :3,
							value     : '0',
							classes   : 'numeric'
						},
						{
							type : 'container',
							html : '<h2 style="font-weight:bold;font-size:16px;">'+Tinymce_ERP_Extension.LANG.DISPLAY_SETTINGS+'</h2>'
						},
						{
							type    : 'checkbox',
							name    : 'filtering',
							label   : Tinymce_ERP_Extension.LANG.FILTER_RESULTS,
							text    : Tinymce_ERP_Extension.LANG.ENB_DIS_FILTERING,
							checked : true
						},
						{
							type   : 'listbox',
							name   : 'filtering_align',
							label  : Tinymce_ERP_Extension.LANG.FILTERING_ALIGN,
							values : Tinymce_ERP_Extension.ALIGNMENTS
						},
						{
							type   : 'listbox',
							name   : 'pagination',
							label  : Tinymce_ERP_Extension.LANG.PAGINATION_TYPE,
							values : Tinymce_ERP_Extension.PAGINATION_TYPE
						},
						{
							type   : 'listbox',
							name   : 'pagination_align',
							label  : Tinymce_ERP_Extension.LANG.PAGINATION_ALIGN,
							values : Tinymce_ERP_Extension.ALIGNMENTS
						},
						{
							type      : 'textbox',
							name      : 'items',
							label     : Tinymce_ERP_Extension.LANG.ITEMS_TO_DISPLAY,
							maxWidth  : 36,
							maxLength :3,
							value     : '8',
							classes   : 'numeric'
						},
						{
							type : 'container',
							html : '<h2 style="font-weight:bold;font-size:16px;">'+Tinymce_ERP_Extension.LANG.ITEM_SETTINGS+'</h2>'
						},
						{
							type   : 'listbox',
							name   : 'ratio',
							label  : Tinymce_ERP_Extension.LANG.IMG_ASPECT_RATIO,
							values : Tinymce_ERP_Extension.ASPECT_RATIO
						},
						{
							type    : 'checkbox',
							name    : 'ajaxed',
							label   : Tinymce_ERP_Extension.LANG.LOAD_ITEM_AJAX,
							text    : Tinymce_ERP_Extension.LANG.OPEN_ITEM_MAGNIFIC,
							checked : true
						},
						{
							type    : 'checkbox',
							name    : 'zoomable',
							label   : Tinymce_ERP_Extension.LANG.ZOOM_ICON,
							text    : Tinymce_ERP_Extension.LANG.SHOW_HIDE,
							checked : false
						},
						/*{
							type    : 'checkbox',
							name    : 'linkable',
							label   : Tinymce_ERP_Extension.LANG.LINK_ICON,
							text    : Tinymce_ERP_Extension.LANG.SHOW_HIDE,
							checked : false
						},*/
						{
							type    : 'checkbox',
							name    : 'show_category',
							label   : Tinymce_ERP_Extension.LANG.SHOW_CATEGORIES,
							text    : Tinymce_ERP_Extension.LANG.SHOW_HIDE,
							checked : true
						},
						{
							type    : 'checkbox',
							name    : 'description',
							label   : Tinymce_ERP_Extension.LANG.DESCRIPTION,
							text    : Tinymce_ERP_Extension.LANG.SHOW_HIDE,
							checked : true
						},
						{
							type   : 'listbox',
							name   : 'desc_position',
							label  : Tinymce_ERP_Extension.LANG.DESC_POSITION,
							values : Tinymce_ERP_Extension.DESC_POSITIONS
						}
					] : [
						{
							type : 'container',
							html : '<h2 style="font-weight:bold;font-size:16px;">'+Tinymce_ERP_Extension.LANG.NO_RESULT+'</h2>'
						},
					]
				,
				minWidth : 480,
                onsubmit : function(e){
					if( Tinymce_ERP_Extension.PORTFOLIOS.length > 0 ){
						var ppp = parseInt( e.data.items ), gtr = parseInt( e.data.gutter );
						editor.insertContent(
							'[' + Tinymce_ERP_Extension.SHORTCODE + ' build="' + e.data.build + '" ratio="' + e.data.ratio + '" ' +
							'pagination="' + e.data.pagination + '" pagination_align="' + e.data.pagination_align + '" columns="' + e.data.columns + '" items="' + ( !isNaN( ppp ) ? ppp : 10 ) + '" ' +
							'filter="' + ( e.data.filtering ? 1 : 0 ) + '" filter_align="' + e.data.filtering_align + '" zoomable="' + ( e.data.zoomable ? 1 : 0 ) + '" ' +
							'linkable="' + ( e.data.linkable ? 1 : 0 ) + '" ajaxed="' + ( e.data.ajaxed ? 1 : 0 ) + '" ' +
							'gutter="' + ( !isNaN( gtr ) ? gtr : 0 ) + '" layout="' + e.data.layout + '" show_category="' + ( e.data.show_category ? 1 : 0 ) + '" '+
							'description="' + ( e.data.description ? 1 : 0 ) + '" desc_position="' + e.data.desc_position + '" ]'
						);
					}
                },
				onKeyUp : function( evt ){
					var reg   = /numeric/;
						match = evt.originalTarget.className.match( reg );
					if( match && match[0] === 'numeric' ){
						evt.originalTarget.value = evt.originalTarget.value.replace( /[^0-9]+/, '' );
					}
				}
            });
        }
    });
});