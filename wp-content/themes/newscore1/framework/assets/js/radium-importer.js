(function($){
	
	"use strict";
		
    $(document).ready(function(){
		
		$("#radium-importer-form").submit(function(e){
			
			if ( !confirm("Are you sure? The import will start immediately") ) {
				e.preventDefault();
				return;
			} 
			
		});
		
	});

})(jQuery);
