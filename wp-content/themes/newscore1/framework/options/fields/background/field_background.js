(function( $ ) {
    "use strict";

    radium_opts.field_objects = radium_opts.field_objects || {};
    radium_opts.field_objects.background = radium_opts.field_objects.background || {};

    $( document ).ready(
        function() {
            radium_opts.field_objects.background.init();
        }
    );

    radium_opts.field_objects.background.init = function( selector ) {
        if ( !selector ) {
            selector = $( document ).find( '.radium-opts-container-background' );
        }

        $( selector ).each(
            function() {
                var el = $( this );
                var parent = el;
                if ( !el.hasClass( 'radium-opts-field-container' ) ) {
                    parent = el.parents( '.radium-opts-field-container:first' );
                }
                if ( parent.hasClass( 'radium-opts-field-init' ) ) {
                    parent.removeClass( 'radium-opts-field-init' );
                } else {
                    return;
                }

                // Remove the image button
                el.find( '.radium-opts-remove-background' ).unbind( 'click' ).on(
                    'click', function( e ) {
                        e.preventDefault();
                        radium_opts.field_objects.background.removeImage( $( this ).parents( '.radium-opts-container-background:first' ) );
                        radium_opts.field_objects.background.preview( $( this ) );
                        return false;
                    }
                );

                // Upload media button
                el.find( '.radium-opts-background-upload' ).unbind().on(
                    'click', function( event ) {
                        radium_opts.field_objects.background.addImage(
                            event, $( this ).parents( '.radium-opts-container-background:first' )
                        );
                    }
                );

                el.find( '.radium-opts-background-input' ).on(
                    'change', function() {
                        radium_opts.field_objects.background.preview( $( this ) );
                    }
                );

                el.find( '.radium-opts-color' ).wpColorPicker({
                    change: function( u, ui ) {
                        radium_opts_change( $( this ) );
                        $( '#' + u.target.id + '-transparency' ).removeAttr( 'checked' );
                        $( this ).val( ui.color.toString() );
                        radium_opts.field_objects.background.preview( $( this ) );
                    },
                    
                    clear: function() {
                        radium_opts_change( $( this ).parent().find( '.radium-opts-color-init' ) );
                        radium_opts.field_objects.background.preview( $( this ) );
                    }
                });

                // Replace and validate field on blur
                el.find( '.radium-opts-color' ).on(
                    'blur', function() {
                        var value = $( this ).val();
                        var id = '#' + $( this ).attr( 'id' );

                        if ( value === "transparent" ) {
                            $( this ).parent().parent().find( '.wp-color-result' ).css(
                                'background-color', 'transparent'
                            );
                    
                            el.find( id + '-transparency' ).attr( 'checked', 'checked' );
                        } else {
                            if ( colorValidate( this ) === value ) {
                                if ( value.indexOf( "#" ) !== 0 ) {
                                    $( this ).val( $( this ).data( 'oldcolor' ) );
                                }
                            }

                            el.find( id + '-transparency' ).removeAttr( 'checked' );
                        }
                    }
                );

                el.find( '.radium-opts-color' ).on(
                    'focus', function() {
                        $( this ).data( 'oldcolor', $( this ).val() );
                    }
                );

                el.find( '.radium-opts-color' ).on(
                    'keyup', function() {
                        var value = $( this ).val();
                        var color = colorValidate( this );
                        var id = '#' + $( this ).attr( 'id' );

                        if ( value === "transparent" ) {
                            $( this ).parent().parent().find( '.wp-color-result' ).css(
                                'background-color', 'transparent'
                            );
                            el.find( id + '-transparency' ).attr( 'checked', 'checked' );
                        } else {
                            el.find( id + '-transparency' ).removeAttr( 'checked' );

                            if ( color && color !== $( this ).val() ) {
                                $( this ).val( color );
                            }
                        }
                    }
                );

                // When transparency checkbox is clicked
                el.find( '.color-transparency' ).on(
                    'click', function() {
                        if ( $( this ).is( ":checked" ) ) {
                            el.find( '.radium-opts-saved-color' ).val( $( '#' + $( this ).data( 'id' ) ).val() );
                            el.find( '#' + $( this ).data( 'id' ) ).val( 'transparent' );
                            el.find( '#' + $( this ).data( 'id' ) ).parent().parent().find( '.wp-color-result' ).css(
                                'background-color', 'transparent'
                            );
                        } else {
                            if ( el.find( '#' + $( this ).data( 'id' ) ).val() === 'transparent' ) {
                                var prevColor = $( '.radium-opts-saved-color' ).val();

                                if ( prevColor === '' ) {
                                    prevColor = $( '#' + $( this ).data( 'id' ) ).data( 'default-color' );
                                }

                                el.find( '#' + $( this ).data( 'id' ) ).parent().parent().find( '.wp-color-result' ).css(
                                    'background-color', prevColor
                                );
                                el.find( '#' + $( this ).data( 'id' ) ).val( prevColor );
                            }
                        }
                        radium_opts.field_objects.background.preview( $( this ) );
                    }
                );

                var default_params = {
                    width: 'resolve',
                    triggerChange: true,
                    allowClear: true
                };

                var select2_handle = el.find( '.select2_params' );
                if ( select2_handle.size() > 0 ) {
                    var select2_params = select2_handle.val();

                    select2_params = JSON.parse( select2_params );
                    default_params = $.extend( {}, default_params, select2_params );
                }

                el.find( " .radium-opts-background-repeat, .radium-opts-background-clip, .radium-opts-background-origin, .radium-opts-background-size, .radium-opts-background-attachment, .radium-opts-background-position" ).select2( default_params );

            }
        );
    };

    // Update the background preview
    radium_opts.field_objects.background.preview = function( selector ) {
        var parent = $( selector ).parents( '.radium-opts-container-background:first' );
        var preview = $( parent ).find( '.background-preview' );

        if ( !preview ) { // No preview present
            return;
        }
        var hide = true;
        var split = parent.data( 'id' ) + '][';
        var css = 'height:' + preview.height() + 'px;';
        $(parent).find('.radium-opts-background-input').each(function() {
                var data = $( this ).serializeArray();
                data = data[0];
                
                if ( data && data.name.indexOf( '[background-' ) != -1 ) {

                    if ( data.value !== "" ) {
                        hide = false;
                        data.name = data.name.split( split );
                        data.name = data.name[1].replace( ']', '' );
                        if ( data.name == "background-image" ) {
                            css += data.name + ':url("' + data.value + '");';
                        } else {
                            css += data.name + ':' + data.value + ';';
                        }
                    }
                }
            }
        );
        if ( !hide ) {
            preview.attr( 'style', css ).fadeIn();
        } else {
            preview.slideUp();
        }


    };

    // Add a file via the wp.media function
    radium_opts.field_objects.background.addImage = function( event, selector ) {
        event.preventDefault();

        var frame;
        var jQueryel = $( this );

        // If the media frame already exists, reopen it.
        if ( frame ) {
            frame.open();
            return;
        }

        // Create the media frame.
        frame = wp.media(
            {
                multiple: false,
                library: {
                    //type: 'image' //Only allow images
                },
                // Set the title of the modal.
                title: jQueryel.data( 'choose' ),
                // Customize the submit button.
                button: {
                    // Set the text of the button.
                    text: jQueryel.data( 'update' )
                    // Tell the button not to close the modal, since we're
                    // going to refresh the page when the image is selected.

                }
            }
        );

        // When an image is selected, run a callback.
        frame.on(
            'select', function() {
                // Grab the selected attachment.
                var attachment = frame.state().get( 'selection' ).first();
                frame.close();

                //console.log(attachment.attributes.type);

                if ( attachment.attributes.type !== "image" ) {
                    return;
                }

                selector.find( '.upload' ).val( attachment.attributes.url );
                selector.find( '.upload-id' ).val( attachment.attributes.id );
                selector.find( '.upload-height' ).val( attachment.attributes.height );
                selector.find( '.upload-width' ).val( attachment.attributes.width );
                radium_opts_change( $( selector ).find( '.upload-id' ) );
                var thumbSrc = attachment.attributes.url;
                if ( typeof attachment.attributes.sizes !== 'undefined' && typeof attachment.attributes.sizes.thumbnail !== 'undefined' ) {
                    thumbSrc = attachment.attributes.sizes.thumbnail.url;
                } else if ( typeof attachment.attributes.sizes !== 'undefined' ) {
                    var height = attachment.attributes.height;
                    for ( var key in attachment.attributes.sizes ) {
                        var object = attachment.attributes.sizes[key];
                        if ( object.height < height ) {
                            height = object.height;
                            thumbSrc = object.url;
                        }
                    }
                } else {
                    thumbSrc = attachment.attributes.icon;
                }
                selector.find( '.upload-thumbnail' ).val( thumbSrc );
                if ( !selector.find( '.upload' ).hasClass( 'noPreview' ) ) {
                    selector.find( '.screenshot' ).empty().hide().append( '<img class="radium-opts-option-image" src="' + thumbSrc + '">' ).slideDown( 'fast' );
                }

                selector.find( '.radium-opts-remove-background' ).removeClass( 'hide' );//show "Remove" button
                selector.find( '.radium-opts-background-input-properties' ).slideDown();
                radium_opts.field_objects.background.preview( selector.find( '.upload' ) );
            }
        );

        // Finally, open the modal.
        frame.open();
    };

    // Update the background preview
    radium_opts.field_objects.background.removeImage = function( selector ) {
		
        // This shouldn't have been run...
        if ( ! $( selector ).find( '.radium-opts-remove-background' ).addClass( 'hide' ) ) {
            return;
        }
         $( selector ).find( '.radium-opts-remove-background' ).addClass( 'hide' ); //hide "Remove" button

		$( selector ).find( '.upload' ).val( '' );
		$( selector ).find( '.upload-id' ).val( '' );
		$( selector ).find( '.upload-height' ).val( '' );
		$( selector ).find( '.upload-width' ).val( '' );
		$( selector ).find( '.radium-opts-background-input' ).val( '' );
		$( selector ).find( '.upload-thumbnail' ).val( '' );
		
    	radium_opts_change( $( selector ).find( '.upload-id' ) );
        $( selector ).find( '.radium-opts-background-input-properties' ).hide();
        var screenshot = $( selector ).find( '.screenshot' );

        // Hide the screenshot
        screenshot.slideUp();

       	$( selector ).find( '.remove-file' ).unbind();
        
        // We don't display the upload button if .upload-notice is present
        // This means the user doesn't have the WordPress 3.5 Media Library Support
        if ( $( '.section-upload .upload-notice' ).length > 0 ) {
            $( '.radium-opts-background-upload' ).remove();
        }
    };
})( jQuery );
