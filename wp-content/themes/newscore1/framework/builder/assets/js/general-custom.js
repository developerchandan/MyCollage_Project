

/**
 * Prints out the inline javascript that is shared between all 
 * framework admin areas.
 */

(function($){
	
	// Setup methods for radium namespace
	var radium_shared = {
    	
    	// All general binded events
    	init : function() {
    	
    		var $this = this;
    	
    		// Toggle page-elements
			$this.find('a.edit-element').live('click', function(){
			
				var el = $(this), 
					content_closed = el.closest('.page-element-item').hasClass('page-element-content-closed');
					
				el.closest('.page-element')
 					.find('.page-element-style').slideUp(200).end()
 					.find('.page-element-item').addClass('page-element-style-closed');
					
				if(content_closed) {
				
					el.closest('.page-element')
						.find('.page-element-content').slideDown(200).end()
  						.find('.page-element-item').removeClass('page-element-content-closed');
					
				} else {
				
					el.closest('.page-element')
						.find('.page-element-content').slideUp(200).end()
  						.find('.page-element-item').addClass('page-element-content-closed');
					
				}
				
				return false;
				
			});
			
			$this.find('.element-style').live('click', function(e){
				
				e.preventDefault();					
						
				var el = $(this), 
					style_closed = el.closest('.page-element-item').hasClass('page-element-style-closed');
				
				el.closest('.page-element')
					.find('.page-element-content').slideUp(200).end()
					.find('.page-element-item').addClass('page-element-content-closed'); 
					
 				if(style_closed) {
				
					el.closest('.page-element')
						.find('.page-element-style').slideDown(200).end()
						.find('.page-element-item').removeClass('page-element-style-closed');
					
				} else {
				
					el.closest('.page-element')
						.find('.page-element-style').slideUp(200).end()
						.find('.page-element-item').addClass('page-element-style-closed');
					
				}
				
 			});
			
			// Help tooltips
			$this.find('.tooltip-link').live('click', function(){
				var message = $(this).attr('title');
				radium_confirm(message, {'textOk':'Ok'});
				return false;						
			});
			
			// Delete item by ID passed through link's href
			$this.find('.delete-me').live('click', function(){
				var item = $(this).attr('href');
				radium_confirm($(this).attr('title'), {'confirm':true}, function(r) {
			    	if(r) {
			        	$(item).remove();
			        }
			    });
			    return false;
			});	
    	},
    	
    	// Setup custom option combos
    	options : function( type ) {
    		return this.each(function(){
				
				var $this = $(this);	
			
	    		// Apply all actions that need applying when an 
	    		// option set is loaded. This will be called any 
	    		// time a new options set is inserted.
	    		if(type === 'setup') {
	    		
	    			// Custom content
	    			$this.find('.custom-content-types').each(function(){
	    			
	    				var el = $(this), value = el.find('select').val(), parent = el.closest('.subgroup');
	    				
	    				if(value === 'external') {
	    					parent.find('.page-content').show();
	    				} else if (value === 'raw') {
	    					parent.find('.raw-content').show();
	    				}
	    				
	    			});
 	    			
	    			// Tabs only
	    			$this.find('.tabs').each(function(){
	    				var el = $(this), i = 1, num = el.find('.tabs-num').val();
	    				el.find('.tab-names .tab-name').hide();
	    				el.find('.section-content').hide();
	    				while (i <= num) {
							el.find('.tab-names .tab-name-'+i).show();
							el.find('#section-tab_'+i).show();
							i++;
	    				}
	    			});
	    			
	    			// Columns AND Tabs
	    			$this.find('.section-content').each(function(){
    					var section = $(this), type = section.find('.column-content-types select.select-type').val();
    					section.find('.column-content-type').hide();
    					section.find('.column-content-type-'+type).show();
    				});
    				
    				// Show/Hide groupings
    				$this.find('.show-hide').each(function(){
    					var el = $(this), checkbox = el.find('.trigger input');
    					if( checkbox.is(':checked') ) {
    						el.find('.receiver').show();
    					}    					
    				});
    	
    				
    				// Homepage Content
	    			$this.find('#section-homepage_content').each(function(){
    					var value = $(this).find('input:checked').val();
    					if( value != 'custom_layout' )
    					{
    						$this.find('#section-homepage_custom_layout').hide();
    					}				
    				});
	    				
	    		}
	    		// Apply all binded actions. This will only need
	    		// to be called once on the original page load.
	    		else if(type == 'bind') {
	    		
	    			// Custom content
	    			$this.find('.custom-content-types select').live('change', function(){
	    				var el = $(this), value = el.val(), parent = el.closest('.subgroup');
	    				if(value == 'current') {
	    				
	    					parent.find('.page-content').fadeOut('fast');
	    					parent.find('.raw-content').fadeOut('fast');
	    					
	    				} else if(value == 'external') {
	    				
	    					parent.find('.page-content').fadeIn('fast');
	    					parent.find('.raw-content').hide();
	    					
	    				} else if (value == 'raw') {
	    				
	    					parent.find('.raw-content').fadeIn('fast');
	    					parent.find('.page-content').hide();
	    					
	    				}
	    			});
	    			
	    			// Column widths and number
	    			$this.find('.columns .column-num').live('change', function(){
	    				var el = $(this), i = 1, num = el.val(), parent = el.closest('.columns');
	    				parent.find('.column-width').hide();
	    				parent.find('.column-width-'+num).fadeIn('fast');
	    				parent.find('.section-content').hide();
	    				while (i <= num) {
							parent.find('.col_'+i).show();
							i++;
	    				}
	    			});
	    			
	    			// Tabs number
	    			$this.find('.tabs .tabs-num').live('change', function(){
	    				var el = $(this), i = 1, num = el.val(), parent = el.closest('.tabs');
	    				parent.find('.tab-names .tab-name').hide();
	    				parent.find('.section-content').hide();
	    				while (i <= num) {
							parent.find('.tab-names .tab-name-'+i).show();
							parent.find('#section-tab_'+i).show();
							i++;
	    				}
	    			});
	    			
	    			// Column/Tab content types
	    			$this.find('.column-content-types select.select-type').live('change', function(){
						var section = $(this).closest('.section-content'), type = $(this).val();
	    				section.find('.column-content-type').hide();
	    				section.find('.column-content-type-'+type).show();
	    			});
	    			
	    			// Show/Hide groupings
    				$this.find('.show-hide .trigger input').live('click', function(){
    					var checkbox = $(this);
    					if( checkbox.is(':checked') ) {
    						checkbox.closest('.show-hide').find('.receiver').fadeIn('fast');
    					} else {
    						checkbox.closest('.show-hide').find('.receiver').hide();
    					}    					
    				});
    			
    				// Homepage Content
	    			$this.find('#section-homepage_content input:checked').live('change', function() {  					
    					if( $(this).val() == 'custom_layout' ) {
    						$this.find('#section-homepage_custom_layout').fadeIn('fast');
    					} else {
    						$this.find('#section-homepage_custom_layout').fadeOut('fast');
    					}			
    				});
	    		}
    		
    		});
    	},
    	
    	// page-elements		
		page_elements : function() {
		
			return this.each(function(){
				var el = $(this);
				el.find('.page-element-content, .page-element-style').hide();
				el.find('.page-element-item').addClass('page-element-content-closed page-element-style-closed');			
			});
			
		},
		
		// Accordion		
		accordion : function()
		{
			return this.each(function(){
				var el = $(this);
				
				// Set it up
				el.find('.element-content').hide();
				el.find('.element-content:first').show();
				
				// The click
				el.find('.element-trigger').click(function(){
					var anchor = $(this);
					if( ! anchor.hasClass('active') ) 
					{
						el.find('.element-content').hide();
						el.find('.element-trigger').removeClass('active');
						anchor.addClass('active');
						anchor.next('.element-content').show();
					}
					return false;
				});	
			});
		}

	};
	
	// Setup radium namespace
	$.fn.radium = function(method) {

		if( radium_shared[method] ) {
			return radium_shared[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if( typeof method === 'object' || ! method ) {
			return radium_shared.init.apply( this, arguments );
		} else {
			$.error( 'Method ' +  method + ' does not exist.' );
		}    
	
	};

})(jQuery);

/**
 * Show alert popup. Used for warnings and confirmations,
 * mostly intended to be used with AJAX actions.
 */
 
(function ($) {

	radium_alert = {
		init: function(alert_text, alert_class) {
		
		  	// Available classes:
			// success (green)
			// reset (red)
			// warning (yellow)
			
			// Initial HTML markup	
			var alert_markup	= '<div id="radium-alert"> \
										<div class="radium-alert-inner">  \
											<div class="radium-alert-pad">  \
												<div class="radium-alert-message"> \
													<p>Replace this with message text.</p> \
												</div> \
											</div><!-- .radium-alert-pad  --> \
										</div><!-- .radium-alert-inner  --> \
									 </div><!-- .radium-alert  -->';
			
			// Add initial markup to site				
			$('body').append(alert_markup);
			
			var	$this 			= $('#radium-alert'),
				window_height 	= $(window).height();
			
			// Insert dynamic elements into markup
			$this.addClass('radium-'+alert_class);
			$this.find('.radium-alert-message p').text(alert_text);
			
			// Position it
			$this.animate({'top' : ( window_height - ( window_height-75 ) ) + $(window).scrollTop() + "px"}, 100);
			
			// Show it and fade it out 1.5 secs later
			$this.fadeIn(500, function(){
				setTimeout( function(){
					$this.fadeOut(500, function(){
						$this.remove();
					});
					
		      	}, 1500);
			});

		}
	};
	
})(jQuery);	

/**
 * Confirmation
 */

(function($){

	radium_confirm = function(string, args, callback) 	{
		var default_args = {
			'confirm'		:	false, 		// Ok and Cancel buttons
			'verify'		:	false,		// Yes and No buttons
			'input'			:	false, 		// Text input (can be true or string for default text)
			'animate'		:	false,		// Groovy animation (can true or number, default is 400)
			'textOk'		:	'Ok',		// Ok button default text
			'textCancel'	:	'Cancel',	// Cancel button default text
			'textYes'		:	'Yes',		// Yes button default text
			'textNo'		:	'No'		// No button default text
			}
	
	if(args) {
		for(var index in default_args) 
			{ if(typeof args[index] == "undefined") args[index] = default_args[index]; } 
		}
	
	var aHeight = $(document).height();
	var aWidth = $(document).width();
	$('body').append('<div class="appriseOverlay" id="aOverlay"></div>');
	$('.appriseOverlay').css('height', aHeight).css('width', aWidth).fadeIn(100);
	$('body').append('<div class="appriseOuter"></div>');
	$('.appriseOuter').append('<div class="appriseInner"></div>');
	$('.appriseInner').append(string);
	$('.appriseOuter').css("left", ( $(window).width() - $('.appriseOuter').width() ) / 2+$(window).scrollLeft() + "px");
	
	if(args) {
		if(args['animate']) { 
			var aniSpeed = args['animate'];
			if(isNaN(aniSpeed)) { aniSpeed = 400; }
			$('.appriseOuter').css('top', '-200px').show().animate({top:"100px"}, aniSpeed);
		} else { 
			$('.appriseOuter').css('top', '100px').fadeIn(200); }
	} else { $('.appriseOuter').css('top', '100px').fadeIn(200); }
	
	if(args) {
	
		if(args['input']) {
		
			if(typeof(args['input'])=='string') {
				$('.appriseInner').append('<div class="aInput"><input type="text" class="aTextbox" t="aTextbox" value="'+args['input']+'" /></div>');
			} else {
				$('.appriseInner').append('<div class="aInput"><input type="text" class="aTextbox" t="aTextbox" /></div>');
			} 			
			
			$('.aTextbox').focus();
			
		}
	}
	
	$('.appriseInner').append('<div class="aButtons"></div>');
	
	if(args) {
	
		if(args['confirm'] || args['input']) { 
		
			$('.aButtons').append('<button value="ok">'+args['textOk']+'</button>');
			$('.aButtons').append('<button value="cancel">'+args['textCancel']+'</button>'); 
			
		} else if(args['verify']) {
		
			$('.aButtons').append('<button value="ok">'+args['textYes']+'</button>');
			$('.aButtons').append('<button value="cancel">'+args['textNo']+'</button>');
			
		} else { 
		
			$('.aButtons').append('<button value="ok">'+args['textOk']+'</button>'); 
			
		}
		
	} else {
		
		$('.aButtons').append('<button value="ok">Ok</button>'); 
		
	}
	
	$(document).keydown(function(e) {
	
		if($('.appriseOverlay').is(':visible')) {
		
			if(e.keyCode == 13) { 
				$('.aButtons > button[value="ok"]').click();
			}
			
			if(e.keyCode == 27) { 
				$('.aButtons > button[value="cancel"]').click(); 
			}
			
		}
	});
	
	var aText = $('.aTextbox').val();
	if(!aText) { aText = false; }
	
	$('.aTextbox').keyup(function() { 
		aText = $(this).val(); 
	});
	
	$('.aButtons > button').click(function() {
	
		$('.appriseOverlay').remove();
		$('.appriseOuter').remove();
		if(callback) {
		
			var wButton = $(this).attr("value");
			
			if(wButton=='ok') { 
			
				if(args) {
				
					if(args['input']) { 
						callback(aText); 
					} else { 
						callback(true); 
					}
					
				} else { 
					callback(true); 
				}
				
			} else if(wButton=='cancel') { 
				callback(false);
			}
		}
	});
}

})(jQuery);

/**
 * Prints out the inline javascript needed for the colorpicker and choosing
 * the tabs in the panel.
 */

jQuery(document).ready(function($) {
	
	// Fade out the save message
	$('.fade').delay(1000).fadeOut(1000);
	
	// Color Picker
	$('.colorSelector').each(function(){
		var Othis = this; //cache a copy of the this variable for use inside nested function
		var initialColor = $(Othis).next('input').attr('value');
		$(this).ColorPicker({
			color: initialColor,
			onShow: function (colpkr) {
				$(colpkr).fadeIn(500);
				return false;
			},
			onHide: function (colpkr) {
				$(colpkr).fadeOut(500);
				return false;
			},
			onChange: function (hsb, hex, rgb) {
				$(Othis).children('div').css('backgroundColor', '#' + hex);
				$(Othis).next('input').attr('value','#' + hex);
			}
		});
	}); //end color picker
	
	// Switches option sections
	$('.group').hide();
	var activetab = '';
	if (typeof(localStorage) != 'undefined' ) {
		activetab = localStorage.getItem("activetab");
	}
	if (activetab != '' && $(activetab).length ) {
		$(activetab).fadeIn();
	} else {
		$('.group:first').fadeIn();
	}
	$('.group .collapsed').each(function(){
		$(this).find('input:checked').parent().parent().parent().nextAll().each( 
			function(){
				if ($(this).hasClass('last')) {
					$(this).removeClass('hidden');
						return false;
					}
				$(this).filter('.hidden').removeClass('hidden');
			});
	});
	
	if (activetab != '' && $(activetab + '-tab').length ) {
		$(activetab + '-tab').addClass('active');
	}
	else {
		$('.layout-nav-tab-wrapper li:first').addClass('active');
	}
	
	$('.layout-nav-tab-wrapper li').click(function(evt) {
		$('.layout-nav-tab-wrapper li').removeClass('active');
		$(this).addClass('active').blur();
		var clicked_group = $(this).children('a').attr('href');
		if (typeof(localStorage) != 'undefined' ) {
			localStorage.setItem("activetab", $(this).attr('href'));
		}
		$('.group').hide();
		$(clicked_group).fadeIn();
		evt.preventDefault();
	});
           					
	$('.group .collapsed input:checkbox').click(unhideHidden);
				
	function unhideHidden(){
		if ($(this).attr('checked')) {
			$(this).parent().parent().parent().nextAll().removeClass('hidden');
		}
		else {
			$(this).parent().parent().parent().nextAll().each( 
			function(){
				if ($(this).filter('.last').length) {
					$(this).addClass('hidden');
					return false;		
					}
				$(this).addClass('hidden');
			});
           					
		}
	}
	
	// Image Options
	$('.of-radio-img-img').click(function(){
		$(this).parent().parent().find('.of-radio-img-img').removeClass('of-radio-img-selected');
		$(this).addClass('of-radio-img-selected');		
	});
		
	$('.of-radio-img-label').hide();
	$('.of-radio-img-img').show();
	$('.of-radio-img-radio').hide();
	
	//Tooltip
	jQuery('.radio_img').tooltip({
			selector: '[rel=tooltip]',
			animation: true
		});
		
	// radium namespace
	$('#radium_panel_opt').radium('init');
	$('#radium_panel_opt').radium('options', 'bind');
	$('#radium_panel_opt').radium('options', 'setup');
		 		
});	
