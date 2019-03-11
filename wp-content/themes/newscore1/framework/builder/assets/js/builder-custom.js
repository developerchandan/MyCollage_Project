/**
 * The javascript needed for managing layouts. 
 */

jQuery(document).ready(function($) {
	
	/*-----------------------------------------------------------------------------------*/
	/* Static Methods
	/*-----------------------------------------------------------------------------------*/
	
	var radium_builder = {
		
		//Featured Area Settings Toogle
		setting_toggle: function () {
		
			jQuery("#elements-container-setting a").toggle(function(){
			    var el = $('#elements-container-setting'),
			        curHeight = el.height(),
			        autoHeight = el.css('height', 'auto').height();
			    el.height(curHeight).animate({height: autoHeight}, 200);
			    $(this).addClass('active');
			},function(){
			    jQuery('#elements-container-setting').animate({height: 25},200);
			     if ($(this).hasClass('active') ) {
			     	$(this).removeClass('active');
			     }
 			});
			
		},
		
		//Color Picker
		colorPickerInit	: function () {
		
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
		},
		
		// Update Manage Layouts page's table
    	manager : function( table ) {
    	
    		if(table) {
				// We already have the table, so just throw it in.
				$('#radium_builder #manage_layouts .builder-ajax-container').html(table);
			} else {
				// We don't have the table yet, so let's grab it.
				$.ajax({
					type: "POST",
					url: ajaxurl,
					data: {
						action: 'radium_builder_update_table'
					}, 
					success: function(response) {	
						$('#radium_builder #manage_layouts .builder-ajax-container').html(response);
					}
				});
			}
    	},
    	
    	// Delete Layout
    	delete_layout : function( ids, action, location ) {
    	
    		var nonce  = $('#manage_builder').find('input[name="_wpnonce"]').val();
			radium_confirm( radium.delete_layout, {'confirm':true}, function(r) {
		    	if(r) {
		        	$.ajax({
						type: "POST",
						url: ajaxurl,
						data: {
							action: 'radium_builder_delete_layout',
							security: nonce,
							data: ids
						},
						success: function(response) {	

							// Prepare response
							response = response.split('[(=>)]');
							
							// Insert update message, fade it in, and then remove it 
							// after a few seconds.
							$('#radium_builder #manage_layout').prepend(response[1]);
							$('#radium_builder #manage_layout .ajax-update').fadeIn(500, function(){
								setTimeout( function(){
									$('#radium_builder #manage_layout .ajax-update').fadeOut(500, function(){
										$('#radium_builder #manage_layout .ajax-update').remove();
									});
						      	}, 1500);
							
							});
							
							// Change number of layouts
							$('#radium_builder .displaying-num').text(response[0]);
							
							// Update table
							if(action == 'submit') {
								$('#manage_builder').find('input[name="posts[]"]').each(function(){
									if( $(this).is(':checked') ) {
										var id = $(this).val();
										if( $('#edit_layout-tab').hasClass(id+'-edit') ) {
											$('#edit_layout-tab').hide();
										}
										$(this).closest('tr').remove();
									}
								});
							} else if(action == 'click') {
								var id = ids.replace('posts%5B%5D=', '');
								if( $('#edit_layout-tab').hasClass(id+'-edit') ) {
									$('#edit_layout-tab').hide();
								}
								$('#row-'+id).remove();
							}
							
							// Uncheck all checkboxes
							$('#manage_builder option').removeAttr('checked'); 
							
							// Forward back to manage layouts page if 
							// we're deleting this layout from the Edit 
							// Layout page.
							if(location == 'edit_page') {
								$('#radium_builder .group').hide();
								$('#radium_builder .group:first').fadeIn();
								$('#radium_builder .layout-nav-tab-wrapper li:first').addClass('active');
							}
						}
					});
		        }
		    });
    	},
		 
		
		// Setup element width
		element_width : function( name, page ) {
 			
			// size that element can be (text, class)
 			 var element_column_size = [ 
 			 	['1/4', 'element1-4'],
 			 	['1/3', 'element1-3'],
 			 	['1/2', 'element1-2'],
 			 	['2/3', 'element2-3'],
 			 	['3/4', 'element3-4'],
 			 	['1/1', 'element1-1']
 			 ];
   			  
			 //Add Element Size
			 jQuery("div#builder").find(".add-element-size").off('click').on('click', function(){
  			 
			 	var click_object = jQuery(this).parents('div[id^=element]');
			 	var object_type = click_object.attr('rel');
			 	var is_upper_style = false;
			 	var current_style = '';
			 					 	
			 	for(var i=0; i<element_column_size.length-1; i++){
			 	
			 		if( click_object.hasClass( element_column_size[i][1] ) ){ 
			 		
			 			is_upper_style = true; 
			 			current_style = element_column_size[i][1];
			 			
			 		}
			 		
			 		if( is_upper_style ){
			 			
			 			if( i < element_column_size.length-2 ){
			 				click_object.removeClass(current_style).addClass(element_column_size[i+1][1]);
			 				click_object.find(".element-size-text").html(element_column_size[i+1][0]);
			 				click_object.find(".element-width").val(element_column_size[i+1][1])
			 				
			 			} else if( i == element_column_size.length-2) {
			 			
			 				click_object.removeClass(current_style).addClass(element_column_size[i+1][1]);
			 				click_object.find(".element-size-text").html(element_column_size[i+1][0]);
			 				click_object.find(".element-width").val(element_column_size[i+1][1])
			 				
			 			}
			 			
			 			break;
			 			
			 		}
			 		
			 	}
			 	
 			});
			 
			 //Subtract Element size
			 jQuery("div#builder").find(".sub-element-size").off('click').on('click', function(){
			 
			 	var click_object = jQuery(this).parents('div[id^=element]');
			 	var object_type = click_object.attr('rel');
			 	var is_lower_style = false;
			 	var current_style = '';
			 			 	
			 	for(var i=element_column_size.length-1; i > 0; i--){
			 	
			 		if( click_object.hasClass(element_column_size[i][1]) ){ 
			 		
			 			is_lower_style = true; 
			 			current_style = element_column_size[i][1];
			 			
			 		}
			 		
			 		if( is_lower_style ){
			 		
			 			if( i > 1 ){
			 			
			 				click_object.removeClass(current_style).addClass(element_column_size[i-1][1]);
			 				click_object.find(".element-size-text").html(element_column_size[i-1][0]);
			 				click_object.find(".element-width").val(element_column_size[i-1][1]);
			 				
			 			} else if( i == 1) {
			 			
			 				click_object.removeClass(current_style).addClass(element_column_size[i-1][1]);
			 				click_object.find(".element-size-text").html(element_column_size[i-1][0]);
			 				click_object.find(".element-width").val(element_column_size[i-1][1]);
			 				
			 			}
			 			
			 			break;
			 		}
			 	}
			 	
			 });
			 
			
		},
 		
		// Manage add new layout form elements
		add_layout : function( object ) {
    		var value = object.val(), parent = object.closest('.controls');
					
			// Finish it up depending on if the user selected to 
			// start from scratch or a sample layout.
			if(value != '0') {
				parent.find('.sample-layouts div').hide();
				parent.find('#sample-'+value).show();
			} else {
				parent.find('.sample-layouts div').hide();
			}
    	},
    	
    	// Enter into editing a layout
    	edit : function ( name, page ) {
    	
    		// Get the ID from the beginning
			var page = page.split('[(=>)]');
			
			// Prepare the edit tab
			$('#radium_builder .layout-nav-tab-wrapper a.nav-edit-builder').text(radium.edit_layout+': '+name).addClass(page[0]+'-edit');
			$('#radium_builder #edit_layout .builder-ajax-container').html(page[1]);
					
			// Setup hints
			$('.sortable:not(:has(div))').addClass('empty');
			$('.sortable:has(div)').removeClass('empty');
			
			$(".sortable").sortable({
				placeholder: 'placeholder',
				handle: '.page-element-item',
				connectWith: '.sortable',
				forcePlaceholderSize: true,
			});
			 
			//$(".sortable").disableSelection(); //causes FF and ie issues
						
			// Sortable binded events
			$('.sortable').bind( 'sortreceive', function(event, ui) {
				$('.sortable:not(:has(div))').addClass('empty');
				$('.sortable:has(div)').removeClass('empty');
			});
			
			// Setup page-elements
			$('#radium_builder .page-element').radium('page_elements');
			
			// Setup options
			$('#radium_builder').radium('options', 'setup');
			
			// Take us to the tab
			$('#radium_builder .layout-nav-tab-wrapper li').removeClass('active');
			$('#radium_builder .layout-nav-tab-wrapper li.nav-edit-builder').show().addClass('active');
			$('#radium_builder .group').hide();
			$('#radium_builder .group:last').fadeIn();
			
    	},
    	
    	// Activate clonable options
    	cloneable_options : function() {
    	 	
    	 	toggle_remove_buttons();
    	 	
	 		function add_cloned_fields( $input ) {
	 		
	 			var $clone_last = $input.find( '.rwmb-clone:last' ),
	 				$clone = $clone_last.clone(),
	 				$input, name;
	 	
	 			$clone.insertAfter( $clone_last );
	 			$input = $clone.find( ':input' );
	 	
	 			// Reset value
	 			$input.val( '' );
	 	
	 			// Get the field name, and increment
	 			name = $input.attr( 'name' ).replace( /\[(\d+)\]/, function ( match, p1 ) {
	 				return '[' + ( parseInt( p1 ) + 1 ) + ']';
	 			});
	 	
	 			// Update the "name" attribute
	 			$input.attr( 'name', name );
	 	
	 			// Toggle remove buttons
	 			toggle_remove_buttons( $input );
	 	
	 			// Fix color picker
	 			if ( 'function' === typeof rwmb_update_color_picker )
	 				rwmb_update_color_picker();
	 	
	 			// Fix date picker
	 			if ( 'function' === typeof rwmb_update_date_picker )
	 				rwmb_update_date_picker();
	 	
	 			// Fix time picker
	 			if ( 'function' === typeof rwmb_update_time_picker )
	 				rwmb_update_time_picker();
	 	
	 			// Fix datetime picker
	 			if ( 'function' === typeof rwmb_update_datetime_picker )
	 				rwmb_update_datetime_picker();
	 		}
	 	
	 		// Add more clones
	 		$( '.add-clone' ).click( function () {
	 			var $input = $( this ).parents( '.rwmb-input' ),
	 				$clone_group = $( this ).parents( '.section' ).attr( "clone-group" );
	 	
	 			// If the field is part of a clone group, get all fields in that
	 			// group and iterate over them
	 			if ( $clone_group ) {
	 				// Get the parent metabox and then find the matching
	 				// clone-group elements inside
	 				var $metabox = $( this ).parents( '.page-element-content' );
	 				var $clone_group_list = $metabox.find( 'div[clone-group="' + $clone_group + '"]' );
	 	
	 				$.each( $clone_group_list.find( '.rwmb-input' ),
	 					function ( key, value ) {
	 						add_cloned_fields( $( value ) );
	 					} );
	 			} else
	 				add_cloned_fields( $input );
	 	
	 			toggle_remove_buttons( $input );
	 	
	 			return false;
	 		} );
	 	
	 		// Remove clones
	 		$( '.rwmb-input' ).delegate( '.remove-clone', 'click', function () {
	 			var $this = $( this ),
	 				$input = $this.parents( '.rwmb-input' ),
	 				$clone_group = $( this ).parents( '.section' ).attr( 'clone-group' );
	 	
	 			// Remove clone only if there're 2 or more of them
	 			if ( $input.find( '.rwmb-clone' ).length <= 1 )
	 				return false;
	 	
	 			if ( $clone_group ) {
	 				// Get the parent metabox and then find the matching
	 				// clone-group elements inside
	 				var $metabox = $( this ).parents( '.page-element-content' );
	 				var $clone_group_list = $metabox.find( 'div[clone-group="' + $clone_group + '"]' );
	 				var $index = $this.parent().index();
	 	
	 				$.each( $clone_group_list.find( '.rwmb-input' ),
	 					function ( key, value ) {
	 						$( value ).children( '.rwmb-clone' ).eq( $index ).remove();
	 	
	 						// Toggle remove buttons
	 						toggle_remove_buttons( $( value ) );
	 					} );
	 			} else {
	 				$this.parent().remove();
	 	
	 				// Toggle remove buttons
	 				toggle_remove_buttons( $input );
	 			}
	 	
	 			return false;
	 		} );
	 	
	 		/**
	 		 * Hide remove buttons when there's only 1 of them
	 		 *
	 		 * @param $el jQuery element. If not supplied, the function will applies for all fields
	 		 *
	 		 * @return void
	 		 */
	 		function toggle_remove_buttons( $el ) {
	 			var $button;
	 			if ( !$el )
	 				$el = $( '.rwmb-field' );
	 			$el.each( function () {
	 				$button = $( this ).find( '.remove-clone' );
	 				$button.length < 2 ? $button.hide() : $button.show();
	 			} );
	 		}
	
    	},
    	
    	// Activate clonable options
    	cloneable_option_groups :  function() { 
    	
			var $element_id = $('#element-content'),
				$element_clone_group  = $element_id.children('.clone-group');
						
			// Fix for sortable jumping "bug"
			function adjustContainerHeight() {
		
				$element_id.height('auto').height( $('#element-content').height() );
		
			}
			adjustContainerHeight();	

			//Update Image thumb with input
			/*function updateSliderImage(){
			
		 		$element_clone_group.( 'img.img-preview').attr('src', $element_clone_group.('input[type="text"]').val() );
		 	
			}
			updateSliderImage();*/
			
			var c = $('.clone-group').last().attr('data-element-group');
				
			// Add slide
			$('#clone-element-section').click(function( e ) {
					
				var $cloneElem = $element_id.children('.clone-group').last().clone();
		
				$cloneElem.removeClass('closed')
						  .children('.inside').show().end()
						  .find('.button-type').hide().end()
						  .find('.button-type.text').show().end()
		 				  .find('select').val('').end()
						  .find('input[type=text]').val('').end()
						  .find('textarea').val('').end()
						  .find('img.img-preview').attr('src','').end()
						  .attr('id', 'clone-group_'+(++c) ).attr('data-slide', (c) )
						  .find('input.popup-colorpicker').attr('id', (c) ).end()
						  .find('div.color-picker').attr('id', (c)+'picker' ).end()
		 				  .insertAfter( $element_id.children('.clone-group').last() );
		
				adjustContainerHeight();
				
				e.preventDefault();
			});
		
			// Delete slide
			$element_id.on('click', '.remove-slide', function( e ) {
		
				if( $element_id.children('.clone-group').length == 1 ) {
		
					alert('You need to have at least 1 slide!');
		
				} else {
		
					$(this).parents('.clone-group').remove();
					adjustContainerHeight();
				}
		
				e.preventDefault();
			});
			
			// Upload image
			$('#builder .setting-block, .page-element-content .section').each(function(){
			
				$(this).off().on('click', '.upload-image', function( e ){
			
	 				var jQueryel = $(this);
						
					e.preventDefault();
			
					// If the media frame already exists, reopen it.
					if ( typeof(custom_file_frame)!=="undefined" ) {
						custom_file_frame.open();
						return;
					}
		
					// Create the media frame.
					custom_file_frame = wp.media.frames.customHeader = wp.media({
					
						// Set the title of the modal.
						title: jQueryel.data("choose"),
		
	 					// Customize the submit button.
						button: {
							// Set the text of the button.
							text: jQueryel.data("update")
						}
						
					});
		
					custom_file_frame.on( "select", function() {
						// Grab the selected attachment.
						var attachment = custom_file_frame.state().get("selection").first();
			
						// Update value of the targetfield input with the attachment url.
						jQueryel.siblings().val(attachment.attributes.url);
					
					});		
			
					custom_file_frame.open();
					
					
				});
			
			});
			
    	}
		
	};
	
	/*-----------------------------------------------------------------------------------*/
	/* General setup
	/*-----------------------------------------------------------------------------------*/
	
	//hide edit tab title
	$('#radium_panel_opt #radium-builder-current-page h2').hide();
	
	$('#radium_builder #add_layout-tab a, #radium_builder #manage_layouts-tab a').live('click', function(){
		
		$('#radium_panel_opt #radium-builder-current-page h2').hide();
	
	});
	
	//show edit tab title on edit tab
	$('#radium_builder #edit_layout-tab a').live('click', function(){
		
		$('#radium_panel_opt #radium-builder-current-page h2').show();
	
	});
		
	// Hide secret tab when page loads
	$('#radium_builder .layout-nav-tab-wrapper a.nav-edit-builder').hide();
	
	// If the active tab is on edit layout page, we'll 
	// need to override the default functionality of 
	// the Options Framework JS, because we don't want 
	// to show a blank page.
	if (typeof(localStorage) != 'undefined' ) {
		if( localStorage.getItem('activetab') == '#edit_layout') {
			$('#radium_builder .group').hide();
			$('#radium_builder .group:first').fadeIn();
			$('#radium_builder .layout-nav-tab-wrapper li:first').addClass('active');
		}
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* Manage Layouts Page
	/*-----------------------------------------------------------------------------------*/
	
	// Edit layout (via Edit Link on manage page)
	$('#radium_builder #manage_layouts .edit-radium_layout').live( 'click', function(){
		var name = $(this).closest('tr').find('.post-title .title-link').text(),
			id = $(this).attr('href'), 
			id = id.replace('#', '');
		
		$.ajax({
			type: "POST",
			url: ajaxurl,
			data: {
				action: 'radium_builder_edit_layout',
				data: id
			},
			success: function(response) {	
			 
				radium_builder.edit( name, response );
				$('#radium_panel_opt #radium-builder-current-page h2').show();
				$('#radium_panel_opt #radium-builder-current-page h2 > span').html(name);

				radium_builder.element_width();
				radium_builder.cloneable_options();
				radium_builder.cloneable_option_groups();
				radium_builder.setting_toggle();
				radium_builder.colorPickerInit();
			}
		});
		return false;
	});
	
	// Delete layout (via Delete Link on manage page)
	$('#radium_builder .row-actions .trash a').live( 'click', function(){
		var href = $(this).attr('href'), id = href.replace('#', ''), ids = 'posts%5B%5D='+id;
		radium_builder.delete_layout( ids, 'click' );
		return false;
	});
	
	// Delete layouts via bulk action
	$('#manage_builder').live( 'submit', function(){
		var value = $(this).find('select[name="action"]').val(), ids = $(this).serialize();
		if(value == 'trash') {
			radium_builder.delete_layout( ids, 'submit' );
		}
		return false;
	});
	
	/*-----------------------------------------------------------------------------------*/
	/* Add New Layout Page
	/*-----------------------------------------------------------------------------------*/
	
	$('#layout_start').each( function(){
		radium_builder.add_layout( $(this) );
	});
	
	$('#layout_start').change(function(){ 
		radium_builder.add_layout( $(this) );
	});
	
	// Add new layout
	$('#radium_panel_opt #add_new_builder').submit(function(){		
		var el = $(this),
			data = el.serialize(),
			load = el.find('.ajax-loading'),
			name = el.find('input[name="options[layout_name]"]').val(),
			nonce = el.find('input[name="_wpnonce"]').val();
		
		// Tell user they forgot a name
		if(!name) {
			radium_confirm(radium.no_name, {'textOk':'Ok'});
		    return false;
		}
			
		$.ajax({
			type: "POST",
			url: ajaxurl,
			data: {
				action: 'radium_builder_add_layout',
				security: nonce,
				data: data
			},
			beforeSend: function() {
				load.fadeIn('fast');
			},
			success: function(response) {	
				// Scroll to top of page
				$('body').animate( { scrollTop: 0 }, 100, function(){						
					// Everything is good to go. So, forward 
					// on to the edit layout page.					
					radium_builder.edit( name, response );
					radium_alert.init(radium.layout_created, 'success');
					el.find('input[name="options[layout_name]"]').val('');
					
					// Update builder management table in background
					radium_builder.manager();

					radium_builder.element_width();
					radium_builder.cloneable_options();
					radium_builder.cloneable_option_groups();
					radium_builder.setting_toggle();
					radium_builder.colorPickerInit();
					
				});
				
				$('#radium_panel_opt #radium-builder-current-page h2').hide();

				// Hide loader no matter what.												
				load.hide();
			}
		});
		return false;
	});
	
	/*-----------------------------------------------------------------------------------*/
	/* Edit Layout Page
	/*-----------------------------------------------------------------------------------*/
	
	// Add new element
	$('#radium_panel_opt #add_new_element').live( 'click', function(){
		var el = $(this),
			id,
			trim_front,
			trim_back,
			element_id,
			primary_query = false,
			overlay = el.parent().find('.ajax-overlay'),
			load = el.parent().find('.ajax-loading');
			values = el.parent().find('select').val(),
			values = values.split('=>'),
			type = values[0],
			query = values[1];
			
		// Make sure the user doesn't have more than one "primary" 
		// query element. This just means that they can't add 
		// two elements that both use WordPress's primary loop. 
		// Examples would be anything that's paginated. Most other 
		// elements that require posts to be pulled are done with 
		// get_posts() in order to have multiple on a single page. 
		// This can't be done, really, with anything paginated. 
		if(query == 'primary') {
			// Run a check for other primary query items.
			$('#radium_builder #builder .element-query').each(function(){
				if( $(this).val() == 'primary' ) {
					primary_query = true;
				}
			});
			
			// Check if primary_query was set to true
			if(primary_query) {
				// Say, what? We found a second primary? Halt everything!
				radium_confirm(radium.primary_query, {'textOk':'Ok'});
				return false;
			}
		}
		
		// User doesn't have more than one "primary" query item, 
		// so let's proceed with the ajax.
		$.ajax({
			type: "POST",
			url: ajaxurl,
			data: {
				action: 'radium_builder_add_element',
				data: type
			},
			beforeSend: function() {
				overlay.fadeIn('fast');
				load.fadeIn('fast');
			},
			success: function(response) {	
				trim_front = response.split('<div id="');
				trim_back = trim_front[1].split('"');
				element_id = trim_back[0];
				$('#radium_builder #edit_layout #primary .sortable').append(response);
				$('#radium_builder #edit_layout #primary .sortable').removeClass('empty');
				$('#'+element_id).radium('page_elements');
				$('#'+element_id).radium('options', 'setup');
				$('#'+element_id).hide().fadeIn();									
				load.fadeOut('fast');
				overlay.fadeOut('fast');
				
				radium_builder.element_width();
				radium_builder.cloneable_options();
				radium_builder.cloneable_option_groups();
				radium_builder.setting_toggle();
				radium_builder.colorPickerInit();
				
			}
		});
		return false;
	});
	
	// Save Layout
	$('#radium_panel_opt #edit_builder').live('submit', function(){
		var el = $(this),
			data = el.serialize(),
			load = el.find('.publishing-action .ajax-loading'),
			nonce = el.find('input[name="_wpnonce"]').val();
			
		$.ajax({
			type: "POST",
			url: ajaxurl,
			data: {
				action: 'radium_builder_save_layout',
				security: nonce,
				data: data
			},
			beforeSend: function() {
				load.fadeIn('fast');
			},
			success: function(response) {	
				// Insert update message, fade it in, and then remove it 
				// after a few seconds.
				$('#radium_panel_opt #radium-builder-status-messages').html(response);
				
				// Scroll to top of page
				$('body').animate( { scrollTop: 0 }, 50, function(){						
					// Fade in the update message
					$('#radium_panel_opt #radium-opts-header .ajax-update').fadeIn(500, function(){
						
						setTimeout( function(){
							$('#radium_panel_opt #radium-opts-header .ajax-update').fadeOut(500, function(){
								$('#radium_panel_opt #radium-opts-header .ajax-update').remove();
							});
				      	}, 1500);
					
					});
				});	
				load.fadeOut('fast');
			}
		});
		return false;
	});
	
	// Delete layout (via Delete Link on edit layout page)
	$('#radium_builder #edit_layout .delete_layout').live( 'click', function(){
		var href = $(this).attr('href'), id = href.replace('#', ''), ids = 'posts%5B%5D='+id;
		radium_builder.delete_layout( ids, 'click', 'edit_page' );
		return false;
	});
	
});
 