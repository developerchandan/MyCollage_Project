//http://goo.gl/fc9GP

jQuery( document ).ready( function($) {

	var	ratingSettings  = $('.rating-options').hide(),
 		ratings_switch   = $('#_radium_post_score');
	
	ratings_switch.each(function() {
		
		if( $(this).val() == '1' )
			ShowRatingOptions( $(this).val() );

	});

	ratings_switch.change(function() {

		ShowRatingOptions( $(this).val() );

	});

	function ShowRatingOptions( val ) {

		ratingSettings.hide();
 		
		if( val === '1' ) {

			ratingSettings.show();

		} 			
		 
	}
}); 