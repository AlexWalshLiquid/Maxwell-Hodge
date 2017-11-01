(function($){
	$(document).on('keyup','input.items.textfield[name="items"],input.gutter.textfield[name="gutter"]',function(){
		this.value = this.value.replace( /[^0-9]+/, '' );
		if( this.maxLength !== 3 ){
			this.maxLength = 3;
		}
	});
})(jQuery);