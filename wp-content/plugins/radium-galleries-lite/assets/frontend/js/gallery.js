jQuery(function($){
	var $sliders    = $('.gallery-slider'),
	 	$lightboxes = $('.radium-gallery');

	/*$sliders.each(function(){
		var $self = $(this),
	  		h     = parseInt($self.attr('height')),
	  		w     = parseInt($self.attr('width'));

	  	$self.galleria({
 	  		width  : w,
	  		debug: false,
	  		responsive: true,
	  		height:0.5,
	  	});
	}); */

	$lightboxes.each(function(){
 	  	$(this).find('a').prettyPhoto({ social_tools: false, });
	});
});

