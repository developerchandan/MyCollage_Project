jQuery(document).ready(function($) {

	jQuery(".widget-content").on('click', '.delete-social-fans-cache', function(e){
            
	    var that = $(this);
	    
		jQuery.ajax({
			type: "post",
			url: ajaxurl,
	        dataType: 'html',
	        data: "action=radium_social_followers_delete_cache&nonce="+radium_framework_social_fans.nonce,
			beforeSend: function() {
	        	that.next('span').text(' deleting...').hide().fadeIn();
			},
			success: function(data){
	        	that.next('span').text(' done...').delay(1000).fadeOut();
			}
			
		});	
		return false;
	})
})