jQuery(document).ready(function($) {

	jQuery(".widget-content").on('click', '.delete-radium-tweets-cache', function(e){
            
	    var that = $(this);
	    
		jQuery.ajax({
			type: "post",
			url: ajaxurl,
	        dataType: 'html',
	        data: "action=radium_tweets_widget_delete_cache&nonce="+radium_tweets_widget_ajax.nonce,
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