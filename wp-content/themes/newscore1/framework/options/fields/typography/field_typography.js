(function( $ ) {
    "use strict";
    radium_opts.field_objects = radium_opts.field_objects || {};
    radium_opts.field_objects.typography = radium_opts.field_objects.typography || {};

    var selVals = [];
    var isSelecting = false;

    var default_params = {
        width: 'resolve',
        triggerChange: true,
        allowClear: true
    };

    $( document ).ready(function() {
    	
    	var selector = '.typography-open';
    		
		//$(selector).find('.compact_font_preview').append('<span class="toggle">edit</span>');
		
		//$('.compact_font_preview, .toggle').on('click', function(e){
		//	$(this).parents('.typography').find(".compact_font_preview").attr('style', $(this).find("#font-preview").attr('style'));
		//});
    	 
    	$(selector).on('click', function (e) {
    		
    		$(this).siblings('.type-typography').toggleClass( "compact" );
    		
    		var siblings = $(this).siblings(selector);
    				
    		siblings.each(function(){
    			
    			if( !$(this).find('.type-typography').hasClass('compact') ) {
    				$(this).find('.type-typography').addClass('compact') 
    			}
    			
    		});
    	
    	});
     		
    	$(selector).each(function($i){
    			
    	    //$(this).find('.toggle').css('top', $(this).find('.compact_font_preview').height() );
    	    //$(this).append('<div class="compact_font_preview"><span class="selector">'+$(this).find('.font-selector').val()+'</span><span /class="type_title">'+$(this).find('.title label').text()+'</span></div>');
    	    //$(this).find(".compact_font_preview").attr('style',$(this).find("#font-preview").attr('style'));
    	
    	});
           	
    	radium_opts.field_objects.typography.init();    
    		
    });

    radium_opts.field_objects.typography.init = function() {
   
	  var selector = $( document ).find( '.radium-opts-container-typography, .radium-opts-container-multi_typography' );
      
      $( selector ).each( function() {     	       
    
            var el = $(this);
            var parent = el;
            
            if ( !el.hasClass( 'radium-opts-field-container' ) ) {
                parent = el.parents( '.radium-opts-field-container:first' );
            }
            
            if ( parent.hasClass( 'radium-opts-field-init' ) ) {
                parent.removeClass( 'radium-opts-field-init' );
            } else {
                return;
            } 
            
            el.each( function() {
                  
                 // init each typography field
                $( this ).find( '.radium-opts-typography-container' ).each(function() {
                    var family = $( this ).find( '.radium-opts-typography-family' );

                    if ( family.data( 'value' ) !== "" ) {
                        $( family ).val( family.data( 'value' ) );
                    }

                    var select2_handle = $( this ).find( '.select2_params' );
                    if ( select2_handle.size() > 0 ) {
                        var select2_params = select2_handle.val();

                        select2_params = JSON.parse( select2_params );
                        default_params = $.extend( {}, default_params, select2_params );
                    }

                    radium_opts.field_objects.typography.reload( family );

                    window.onbeforeunload = null;
                      
				});
         
                //init when value is changed
                $( this ).find( '.radium-opts-typography' ).on('change', function() {
                	radium_opts.field_objects.typography.reload( $( this )); //.parents('.radium-opts-typography-container'));
                });
                
                $( this ).find( '.radium-opts-typography-customize' ).each( function() {
                	radium_opts.field_objects.typography.visibility( $( this ));
                });
                
                $( this ).find( '.radium-opts-typography-customize' ).on('change', function() {
                	radium_opts.field_objects.typography.visibility( $( this ));
                });

                //init when value is changed
                $( this ).find( '.radium-opts-typography-font-size, .radium-opts-typography-line-height, .radium-opts-typography-word-spacing, .radium-opts-typography-letter-spacing, .radium-opts-typography-align, .radium-opts-typography-transform, .radium-opts-typography-font-variant, .radium-opts-typography-decoration, .radium-opts-typography-shadow' ).keyup(function() {
					radium_opts.field_objects.typography.reload( $( this ).parents( '.radium-opts-typography-container' ));
                });

                // Have to redeclare the wpColorPicker to get a callback function
                $( this ).find( '.radium-opts-typography-color' ).wpColorPicker({ change: function( event, ui ) {
                    	radium_opts_change( $( this ) );
                    	$( this ).val( ui.color.toString() );
                    	radium_opts.field_objects.typography.reload( $( this ) );
                    }
                });

                // Don't allow negative numbers for size field
                $( this ).find( ".radium-opts-typography-font-size" ).numeric({
               		allowMinus: false
                });

                // Allow negative numbers for indicated fields
                $( this ).find( ".radium-opts-typography-line-height, .radium-opts-typography-word-spacing, .radium-opts-typography-letter-spacing" ).numeric({
                	allowMinus: true
                });

                // select2 magic, to load font-family dynamically
                var data = [{id: 'none', text: 'none'}];
                
                $( this ).find( ".radium-opts-typography-family" ).select2({
                    matcher: function( term, text ) {
                        return text.toUpperCase().indexOf( term.toUpperCase() ) === 0;
                    },

                    query: function( query ) {
                        return window.Select2.query.local( data )( query );
                    },

                    initSelection: function( element, callback ) {
                        var data = {id: element.val(), text: element.val()};
                        callback( data );
                    }

                    // when one clicks on the font-family select box
                }).on("select2-opening", function( e ) {

                    // Get field ID
                    var thisID = $( this ).attr( 'data-id' );
										
                    // User included fonts?
                    var isUserFonts = $( '#' + thisID + ' .radium-opts-typography-font-family' ).data( 'user-fonts' );
                    isUserFonts = isUserFonts ? 1 : 0;

                    // Google font isn use?
                    var usingGoogleFonts = $( '#' + thisID + ' .radium-opts-typography-google' ).val();
                    usingGoogleFonts = usingGoogleFonts ? 1 : 0;

                    // Set up data array
                    var buildData = [];

                    // If custom fonts, push onto array
                    if ( radium_opts.customfonts !== undefined ) {
                        buildData.push( radium_opts.customfonts );
                    }

                    // If standard fonts, push onto array
                    if ( radium_opts.stdfonts !== undefined && isUserFonts === 0 ) {
                        buildData.push( radium_opts.stdfonts );
                    }

                    // If user fonts, pull from localize and push into array
                    if ( isUserFonts == 1 ) {
                        var fontKids = [];

                        // <option>
                        for ( var key in radium_opts.typography[thisID] ) {
                            var obj = radium_opts.typography[thisID].std_font;

                            for ( var prop in obj ) {
                                if ( obj.hasOwnProperty( prop ) ) {
                                    fontKids.push(
                                        {
                                            id: prop,
                                            text: prop,
                                            'data-google': 'false'
                                        }
                                    );
                                }
                            }
                        }

                        // <optgroup>
                        var fontData = {
                            text: 'Standard Fonts',
                            children: fontKids
                        };

                        buildData.push( fontData );
                    }

                    // If googfonts on and had data, push into array
                    if ( usingGoogleFonts == 1 || usingGoogleFonts === true && radium_opts.googlefonts !== undefined ) {
                        buildData.push( radium_opts.googlefonts );
                    }

                    // output data to drop down
                    data = buildData;

                    // get placeholder
                    var selFamily = $( '#' + thisID + ' #' + thisID + '-family' ).attr( 'placeholder' );
                    if ( !selFamily ) {
                        selFamily = null;
                    }

                    // select current font
                    $( '#' + thisID + " .radium-opts-typography-family" ).select2( 'val', selFamily );

                    // When selection is made.
                }).on('select2-selecting', function( val, object ) {
                       
                        var fontName = val.object.text;
                        var thisID = $( this ).parents( '.radium-opts-typography-container' ).attr( 'data-id' );

                        $( '#' + thisID + ' #' + thisID + '-family' ).data( 'value', fontName );
                        $( '#' + thisID + ' #' + thisID + '-family' ).attr( 'placeholder', fontName );

                        // option values
                        selVals = val;
                        isSelecting = true;

                        radium_opts_change( $( this ) );
                    }
                );
                
                // Init select2 for indicated fields
                el.find( ".radium-opts-typography-family-backup, .radium-opts-typography-align, .radium-opts-typography-transform, .radium-opts-typography-font-variant, .radium-opts-typography-decoration, .radium-opts-typography-shadow" ).select2( default_params );
            
        	});
        
        });
        
    };
	// Return font size
	radium_opts.field_objects.typography.visibility = function( obj ) {
	
		var el_class = $(obj).data('select');
  		
		var el = $(obj).parents('.radium-opts-typography-container').find('.customize-' + el_class);
				
		if($(obj).is(':checked')) {
       
           el.fadeIn('fast');
       
       } else {
       
           el.fadeOut('fast');
       
       }
       
 	};
	
    // Return font size
    radium_opts.field_objects.typography.size = function( obj ) {
        var size = 0,
            key;

        for ( key in obj ) {
            if ( obj.hasOwnProperty( key ) ) {
                size++;
            }
        }

        return size;
    };

    // Return proper bool value
    radium_opts.field_objects.typography.makeBool = function( val ) {
        if ( val == 'false' || val == '0' || val === false || val === 0 ) {
            return false;
        } else if ( val == 'true' || val == '1' || val === true || val == 1 ) {
            return true;
        }
    };

    radium_opts.field_objects.typography.contrastColour = function( hexcolour ) {
      
        // default value is black.
        var retVal = '#444444';

        // In case - for some reason - a blank value is passed.
        // This should *not* happen.  If a function passing a value
        // is canceled, it should pass the current value instead of
        // a blank.  This is how the Windows Common Controls do it.  :P
        if ( hexcolour !== '' ) {

            // Replace the hash with a blank.
            hexcolour = hexcolour.replace( '#', '' );

            var r = parseInt( hexcolour.substr( 0, 2 ), 16 );
            var g = parseInt( hexcolour.substr( 2, 2 ), 16 );
            var b = parseInt( hexcolour.substr( 4, 2 ), 16 );
            var res = ((r * 299) + (g * 587) + (b * 114)) / 1000;

            // Instead of pure black, I opted to use WP 3.8 black, so it looks uniform.  :) - kp
            retVal = (res >= 128) ? '#444444' : '#ffffff';
        }

        return retVal;
    };

    //  Sync up font options
    radium_opts.field_objects.typography.reload = function(selector) {
		
        // Main id for selected field
        var mainID = $(selector).attr('data-id');
		
        // Set all the variables to be checked against
        var family          = $('#' + mainID + ' #' + mainID + '-family').val();

        if (!family) {
            family = null; //"inherit";
        }

        var familyBackup    = $('#' + mainID + ' select.radium-opts-typography-family-backup').val();
        var size            = parseInt($('#' + mainID + ' .radium-opts-typography-font-size').val(), 10);
        var height          = parseInt($('#' + mainID + ' .radium-opts-typography-line-height').val(), 10);
        var word            = parseInt($('#' + mainID + ' .radium-opts-typography-word-spacing').val(), 10);
        var letter          = parseInt($('#' + mainID + ' .radium-opts-typography-letter-spacing').val(), 10);
        var align           = $('#' + mainID + ' select.radium-opts-typography-align').val();
        var transform       = $('#' + mainID + ' select.radium-opts-typography-transform').val();
        var fontVariant     = $('#' + mainID + ' select.radium-opts-typography-font-variant').val();
        var decoration      = $('#' + mainID + ' select.radium-opts-typography-decoration').val();
        var style           = $('#' + mainID + ' select.radium-opts-typography-style').val();
        var script          = $('#' + mainID + ' select.radium-opts-typography-subsets').val();
        var color           = $('#' + mainID + ' .radium-opts-typography-color').val();
        var units           = $('#' + mainID).data('units');
        var textShadow      = $('#' + mainID + ' .radium-opts-typography-shadow').val();
               
        var output = family;

        // Is selected font a google font?
        var google;
        if (isSelecting === true) {
            google = radium_opts.field_objects.typography.makeBool(selVals.object['data-google']);
            $('#' + mainID + ' .radium-opts-typography-google-font').val(google);
        } else {
            google = radium_opts.field_objects.typography.makeBool($('#' + mainID + ' .radium-opts-typography-google-font').val()); // Check if font is a google font
        }

        // Page load. Speeds things up memory wise to offload to client
        if (!$('#' + mainID).hasClass('typography-initialized')) {
            style   = $('#' + mainID + ' select.radium-opts-typography-style').data('value');
            script  = $('#' + mainID + ' select.radium-opts-typography-subsets').data('value');

            if (style !== "") {
                style = String(style);
            }

            if (typeof (script) !== undefined) {
                script = String(script);
            }
        }
        
        // Something went wrong trying to read google fonts, so turn google off
        if (radium_opts.fonts.google === undefined) {
            google = false;
        }

        // Get font details
        var details = '';
        if (google === true && ( family in radium_opts.fonts.google)) {
            details = radium_opts.fonts.google[family];
        } else {
            details = {
                '400':          'Normal 400',
                '700':          'Bold 700',
                '400italic':    'Normal 400 Italic',
                '700italic':    'Bold 700 Italic'
            };
        }

        // If we changed the font
        if ($(selector).hasClass('radium-opts-typography-family')) {
            var html = '<option value=""></option>';

            // Google specific stuff
            if (google === true) {

                // STYLES
                var selected = "";
                $.each(details.variants, function(index, variant) {
                    if (variant.id === style || radium_opts.field_objects.typography.size(details.variants) === 1) {
                        selected = ' selected="selected"';
                        style = variant.id;
                    } else {
                        selected = "";
                    }

                    html += '<option value="' + variant.id + '"' + selected + '>' + variant.name.replace(/\+/g, " ") + '</option>';
                });

                // destroy select2
                $('#' + mainID + ' .radium-opts-typography-style').select2("destroy");

                // Instert new HTML
                $('#' + mainID + ' .radium-opts-typography-style').html(html);

                // Init select2
                $('#' + mainID +  ' .radium-opts-typography-style').select2(default_params);


                // SUBSETS
                selected = "";
                html = '<option value=""></option>';

                $.each(details.subsets, function(index, subset) {
                    if (subset.id === script || radium_opts.field_objects.typography.size(details.subsets) === 1) {
                        selected = ' selected="selected"';
                        script = subset.id;
                    } else {
                        selected = "";
                    }

                    html += '<option value="' + subset.id + '"' + selected + '>' + subset.name.replace(/\+/g, " ") + '</option>';
                });

                if (typeof (familyBackup) !== "undefined" && familyBackup !== "") {
                    output += ', ' + familyBackup;
                }
                
                // Destroy select2
                $('#' + mainID + ' .radium-opts-typography-subsets').select2("destroy");

                // Inset new HTML
                $('#' + mainID + ' .radium-opts-typography-subsets').html(html);

                // Init select2
                $('#' + mainID +  ' .radium-opts-typography-subsets').select2(default_params);

                $('#' + mainID + ' .radium-opts-typography-subsets').parent().fadeIn('fast');
                $('#' + mainID + ' .typography-family-backup').fadeIn('fast');
                
            } else {
                if (details) {
                    $.each(details, function(index, value) {
                        if (index === style || index === "normal") {
                            selected = ' selected="selected"';
                            $('#' + mainID + ' .typography-style .select2-chosen').text(value);
                        } else {
                            selected = "";
                        }

                        html += '<option value="' + index + '"' + selected + '>' + value.replace('+', ' ') + '</option>';
                    });

                    // Destory select2
                    $('#' + mainID + ' .radium-opts-typography-style').select2("destroy");

                    // Insert new HTML
                    $('#' + mainID + ' .radium-opts-typography-style').html(html);

                    // Init select2
                    $('#' + mainID + ' .radium-opts-typography-style').select2(default_params);

                    // Prettify things
                    $('#' + mainID + ' .radium-opts-typography-subsets').parent().fadeOut('fast');
                    $('#' + mainID + ' .typography-family-backup').fadeOut('fast');
                }
            }

            $('#' + mainID + ' .radium-opts-typography-font-family').val(output);
        } else if ($(selector).hasClass('radium-opts-typography-family-backup') && familyBackup !== "") {
            $('#' + mainID + ' .radium-opts-typography-font-family').val(output);
        }

        // Check if the selected value exists. If not, empty it. Else, apply it.
        if ($('#' + mainID + " select.radium-opts-typography-style option[value='" + style + "']").length === 0) {
            style = "";
            $('#' + mainID + ' select.radium-opts-typography-style').select2('val', '');
        } else if (style === "400") {
            $('#' + mainID +  ' select.radium-opts-typography-style').select2('val', style);
        }

        // Handle empty subset select
        if ($('#' + mainID + " select.radium-opts-typography-subsets option[value='" + script + "']").length === 0) {
            script = "";
            $('#' + mainID + ' select.radium-opts-typography-subsets').select2('val', '');
        }

        var _linkclass = 'style_link_' + mainID;

        //remove other elements crested in <head>
        $('.' + _linkclass).remove();
        if (family !== null && family !== "inherit" && $('#' + mainID).hasClass('typography-initialized')) {

            //replace spaces with "+" sign
            var the_font = family.replace(/\s+/g, '+');
            if (google === true) {

                //add reference to google font family
                var link = the_font;

                if (style) {
                    link += ':' + style.replace(/\-/g, " ");
                }

                if (script) {
                    link += '&subset=' + script;
                }
                
                if (typeof (WebFont) !== "undefined" && WebFont) {
                    WebFont.load({google: {families: [link]}});
                }

                $('#' + mainID + ' .radium-opts-typography-google').val(true);
            } else {
                $('#' + mainID + ' .radium-opts-typography-google').val(false);
            }
        }

        // Weight and italic
        if (style.indexOf("italic") !== -1) {
            $('#' + mainID + ' .typography-preview').css('font-style', 'italic');
            $('#' + mainID + ' .typography-font-style').val('italic');
            style = style.replace('italic', '');
        } else {
            $('#' + mainID + ' .typography-preview').css('font-style', "normal");
            $('#' + mainID + ' .typography-font-style').val('');
        }

        $('#' + mainID + ' .typography-font-weight').val(style);

        // Show more preview stuff
        if ($('#' + mainID).hasClass('typography-initialized')) {
        
            var isPreviewSize = $('#' + mainID + ' .typography-preview').data('preview-size');

            if (isPreviewSize == '0') {
                $('#' + mainID + ' .typography-preview').css('font-size', size + units);
            }
            
            $('#' + mainID + ' .typography-preview').css('font-weight', style);

            //show in the preview box the font
            $('#' + mainID + ' .typography-preview').css('font-family', family + ', sans-serif');

            if (family === 'none' && family === '') {
                //if selected is not a font remove style "font-family" at preview box
                $('#' + mainID + ' .typography-preview').css('font-family', 'inherit');
            }

            $('#' + mainID + ' .typography-preview').css('line-height', height + units);
            $('#' + mainID + ' .typography-preview').css('word-spacing', word + units);
            $('#' + mainID + ' .typography-preview').css('letter-spacing', letter + units);

            if (color) {
                $('#' + mainID + ' .typography-preview').css('color', color);
                $('#' + mainID + ' .typography-preview').css('background-color', radium_opts.field_objects.typography.contrastColour(color));
            }

            $('#' + mainID + ' .typography-style .select2-chosen').text($('#' + mainID + ' .radium-opts-typography-style option:selected').text());
            $('#' + mainID + ' .typography-script .select2-chosen').text($('#' + mainID + ' .radium-opts-typography-subsets option:selected').text());

            if (align) {
                $('#' + mainID + ' .typography-preview').css('text-align', align);
            }

            if (transform) {
                $('#' + mainID + ' .typography-preview').css('text-transform', transform);
            }

            if (fontVariant) {
                $('#' + mainID + ' .typography-preview').css('font-variant', fontVariant);
            }

            if (decoration) {
                $('#' + mainID + ' .typography-preview').css('text-decoration', decoration);
            }
            
            if(textShadow) {
                $('#' + mainID + ' .typography-preview').css('text-shadow', textShadow);
            }
                        
            $('#' + mainID + ' .typography-preview').slideDown();
        }
        // end preview stuff
		
		// if not preview showing, then set preview to show
		if (!$('#' + mainID).hasClass('typography-initialized')) {
			$('#' + mainID).addClass('typography-initialized');
		}
		
        isSelecting = false;

    };

})( jQuery );
