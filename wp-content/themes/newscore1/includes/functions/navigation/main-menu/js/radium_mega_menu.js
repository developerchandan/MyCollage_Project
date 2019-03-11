/**
 * This file holds the main javascript functions needed to improve the radium mega menu backend
 */

(function($) {

	var radium_mega_menu = {
	
		recalcTimeout: false,
	
		// bind the click event to all elements with the class radium_uploader 
		bind_click: function() {
			
			$('.menu-item-radium-megamenu', '#menu-to-edit').on('click', function() {
				
					var checkbox = $(this),
						container = checkbox.parents('.menu-item:eq(0)');
				
					if(checkbox.is(':checked')) {
					
						container.addClass('radium_mega_active');
 					
					} else {
					
						container.removeClass('radium_mega_active');
					}
					
					//check if anything in the dom needs to be changed to reflect the (de)activation of the mega menu
					radium_mega_menu.recalc();
					
				});
			
			//cat megamenu
			$('.menu-item-radium-cat-megamenu').on('click', function() {
				
					var checkbox = $(this),
						container = checkbox.parents('.menu-item:eq(0)');
				
					if(checkbox.is(':checked')) {
						
						container.removeClass('radium_cat_mega_inactive');
					
						
					} else {
						
						container.addClass('radium_cat_mega_inactive');
					
					}
					
					//check if anything in the dom needs to be changed to reflect the (de)activation of the mega menu
					radium_mega_menu.recalc();
					
			});	
			
		},
		
		recalcInit: function() {
		
			$( ".menu-item-bar" ).on( "mouseup", function(event, ui) {
			
				if(!$(event.target).is('a')) {
				
					clearTimeout(radium_mega_menu.recalcTimeout);
					radium_mega_menu.recalcTimeout = setTimeout(radium_mega_menu.recalc, 500);  
				}
				
			});
			
		},
		
		
		recalc : function() {
		
			menuItems = $('.menu-item', '#menu-to-edit');
			
			menuItems.each(function(i) {
			
				var item = $(this),
					megaMenuCheckbox = $('.menu-item-radium-megamenu', this),
					CatmegaMenuCheckbox = $('.menu-item-radium-cat-megamenu', this);
				
				if(!item.is('.menu-item-depth-0')) {
				
					var checkItem = menuItems.filter(':eq('+(i-1)+')');
					
					if(checkItem.is('.radium_mega_active')) {
					
						item.addClass('radium_mega_active');
						megaMenuCheckbox.attr('checked','checked');
 
 					} else {
					
						item.removeClass('radium_mega_active');
						megaMenuCheckbox.attr('checked', '');
						
					}
					
					//cat megamenu
					if(checkItem.is('.radium_cat_mega_inactive')) {
						
 						item.addClass('radium_cat_mega_inactive');
						CatmegaMenuCheckbox.attr('checked','checked');
					 
 					} else {
					
						item.removeClass('radium_cat_mega_inactive');
						CatmegaMenuCheckbox.attr('checked', '');
						
					}
					
				}				
				
			});
			
		},
		
		//clone of the jquery menu-item function that calls a different ajax admin action so we can insert our own walker
		addItemToMenu : function(menuItem, processMethod, callback) {
			var menu = $('#menu').val(),
				nonce = $('#menu-settings-column-nonce').val();

			processMethod = processMethod || function(){};
			callback = callback || function(){};

			params = {
				'action': 'radium_ajax_switch_menu_walker',
				'menu': menu,
				'menu-settings-column-nonce': nonce,
				'menu-item': menuItem
			};

			$.post( ajaxurl, params, function(menuMarkup) {
				var ins = $('#menu-instructions');
				processMethod(menuMarkup, params);
				if( ! ins.hasClass('menu-instructions-inactive') && ins.siblings().length )
					ins.addClass('menu-instructions-inactive');
				callback();
			});
		}

};
	

	
$(function() {

	radium_mega_menu.bind_click();
	radium_mega_menu.recalcInit();
	radium_mega_menu.recalc();
	
	if(typeof wpNavMenu != 'undefined'){ wpNavMenu.addItemToMenu = radium_mega_menu.addItemToMenu; }
	
});

	
})(jQuery);	 