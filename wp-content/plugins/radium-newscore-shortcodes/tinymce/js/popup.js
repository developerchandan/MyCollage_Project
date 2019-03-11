
// start the popup specific scripts
// safe to use $
jQuery(document).ready(function($) {
    var radiums = {
    
    	loadVals: function(){
    		var shortcode = $('#_radium_shortcode').text(),
    			uShortcode = shortcode;
    		
    		// fill in the gaps eg {{param}}
    		$('.radium-input').each(function() {
    			var input = $(this),
    				id = input.attr('id'),
    				id = id.replace('radium_', ''),		// gets rid of the radium_ prefix
    				re = new RegExp("{{"+id+"}}","g");
    				
    			uShortcode = uShortcode.replace(re, input.val());
    		});
    		
    		// adds the filled-in shortcode as hidden input
    		$('#_radium_ushortcode').remove();
    		$('#radium-sc-form-table').prepend('<div id="_radium_ushortcode" class="hidden">' + uShortcode + '</div>');
    	},
    	
    	cLoadVals: function(){
    		var shortcode = $('#_radium_cshortcode').text(),
    			pShortcode = '';
    			shortcodes = '';
    		
    		// fill in the gaps eg {{param}}
    		$('.child-clone-row').each(function() {
    			var row = $(this),
    				rShortcode = shortcode;
    			
    			$('.radium-cinput', this).each(function() {
    				var input = $(this),
    					id = input.attr('id'),
    					id = id.replace('radium_', '')		// gets rid of the radium_ prefix
    					re = new RegExp("{{"+id+"}}","g");
    					
    				rShortcode = rShortcode.replace(re, input.val());
    			});
    	
    			shortcodes = shortcodes + rShortcode + "\n";
    		});
    		
    		// adds the filled-in shortcode as hidden input
    		$('#_radium_cshortcodes').remove();
    		$('.child-clone-rows').prepend('<div id="_radium_cshortcodes" class="hidden">' + shortcodes + '</div>');
    		
    		// add to parent shortcode
    		this.loadVals();
    		pShortcode = $('#_radium_ushortcode').text().replace('{{child_shortcode}}', shortcodes);
    		
    		// add updated parent shortcode
    		$('#_radium_ushortcode').remove();
    		$('#radium-sc-form-table').prepend('<div id="_radium_ushortcode" class="hidden">' + pShortcode + '</div>');
    	},
    	
    	children: function() {
    		// assign the cloning plugin
    		$('.child-clone-rows').appendo({
    			subSelect: '> div.child-clone-row:last-child',
    			allowDelete: false,
    			focusFirst: false
    		});
    		
    		// remove button
    		$('.child-clone-row-remove').live('click', function() {
    			var	btn = $(this),
    				row = btn.parent();
    			
    			if( $('.child-clone-row').size() > 1 )
    			{
    				row.remove();
    			}
    			else
    			{
    				alert('You need a minimum of one row');
    			}
    			
    			return false;
    		});
    		
    		// assign jUI sortable
    		$( ".child-clone-rows" ).sortable({
				placeholder: "sortable-placeholder",
				items: '.child-clone-row'
				
			});
    	},
    	
    	resizeTB: function(){
			var	ajaxCont = $('#TB_ajaxContent'),
				tbWindow = $('#TB_window'),
				radiumPopup = $('#radium-popup');

            tbWindow.css({
                height: radiumPopup.outerHeight() + 50,
                width: radiumPopup.outerWidth(),
                marginLeft: -(radiumPopup.outerWidth()/2)
            });

			ajaxCont.css({
				paddingTop: 0,
				paddingLeft: 0,
				paddingRight: 0,
				height: (tbWindow.outerHeight()-47),
				overflow: 'auto', // IMPORTANT
				width: radiumPopup.outerWidth()
			});
			
			$('#radium-popup').addClass('no_preview');
    	},
    	
    	load: function(){
    	
    		var	radiums = this,
    			popup = $('#radium-popup'),
    			form = $('#radium-sc-form', popup),
    			shortcode = $('#_radium_shortcode', form).text(),
    			popupType = $('#_radium_popup', form).text(),
    			uShortcode = '';
    		
    		// resize TB
    		radiums.resizeTB();
    		$(window).resize(function() { radiums.resizeTB() });
    		
    		// initialise
    		radiums.loadVals();
    		radiums.children();
    		radiums.cLoadVals();
    		
    		// update on children value change
    		$('.radium-cinput', form).live('change', function() {
    			radiums.cLoadVals();
    		});
    		
    		// update on value change
    		$('.radium-input', form).change(function() {
    			radiums.loadVals();
    		});
    		
    		// when insert is clicked
    		$('.radium-insert', form).click(function() {
    			if(window.tinyMCE){
                    window.tinyMCE.execCommand('mceInsertContent', false, $('#_radium_ushortcode', form).html());
                    tb_remove();
				}
    		});	
    		
    		//icon selection
    		$('.icon-option i').click(function(){
    			$('.icon-option i').removeClass('selected');
    			$(this).addClass('selected');
    			$('.radium-form-icon').val( $(this).data('icon') ).change();
    		});
    		
    	}
	}
    
    // run
    $('#radium-popup').livequery( function() { 
    
    	radiums.load(); 
	    
    });
    
   
	
});
