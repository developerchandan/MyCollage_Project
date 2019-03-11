$(document).ready(function(){
	var menu_ul = $('.contents > li > ul'),
		menu_a  = $('.contents > li > a');
		 
	menu_ul.hide();
		 
	menu_a.click(function(e) {
		e.preventDefault();
		if(!$(this).hasClass('active')) {
		    menu_a.removeClass('active');
		    menu_ul.filter(':visible').slideUp('normal');
		    $(this).addClass('active').next().stop(true,true).slideDown('normal');
		} else {
		    $(this).removeClass('active');
		    $(this).next().stop(true,true).slideUp('normal');
		}
	});

	// $('a[href^="#"]').bind('click.smoothscroll',function (e) {
	// 	e.preventDefault();
	// 	var target = this.hash,
	// 		$target = $(target);
	// 	$('html, body').stop().animate({
	// 		'scrollTop': $target.offset().top
	// 	}, 500, 'swing', function () {
	// 		window.location.hash = target;
	// 	});
	// });


	var tooltip = $('.tooltip');

	tooltip.hide();

	$('.bookmark').mouseenter(function(){
		tooltip.fadeIn();
	});	
	$('.bookmark').mouseleave(function(){
		tooltip.fadeOut();
	});

	$(".scroll").click(function(event){		

		$('html,body').animate({scrollTop:$(this.hash).offset().top-73}, 1000);
		return false;
	});

			
});
