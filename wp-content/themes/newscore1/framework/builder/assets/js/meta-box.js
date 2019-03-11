/**
 * All scripts for metaboxes.
 */

jQuery(document).ready(function($) {
	
	/*-----------------------------------------------------------------------------------*/
	/* Hi-jacked Page Attributes meta box
	/*-----------------------------------------------------------------------------------*/
	
	// Show the proper option on page load
	var page_atts = $('#radium_pageparentdiv'),
	
		template = page_atts.find('select[name="page_template"]').val();
	
	if( template === 'page-builder.php' || template === 'page-templates/page-builder.php' || template === 'page-templates/page-home.php' ) {
				
		page_atts.find('select[name="_radium_custom_layout"]').show().prev('p').show();
	
	} else {
				
		page_atts.find('select[name="_radium_custom_layout"]').hide().prev('p').hide();
		
	}
	
	// Show the proper option when user changes <select>
	page_atts.find('select[name="page_template"]').change(function(){
	
		var template = $(this).val();
		
		if( template === 'page-builder.php' || template === 'page-templates/page-builder.php' || template === 'page-templates/page-home.php' ) {
					
			page_atts.find('select[name="_radium_custom_layout"]').show().prev('p').show();
			
		} else {
					
			page_atts.find('select[name="_radium_custom_layout"]').hide().prev('p').hide();
			
		}
		
	});

});