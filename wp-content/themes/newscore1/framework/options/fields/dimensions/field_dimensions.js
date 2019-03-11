
/*global jQuery, document, redux*/

(function( $ ) {
    "use strict";

    radium_opts.field_objects = radium_opts.field_objects || {};
    radium_opts.field_objects.dimensions = radium_opts.field_objects.dimensions || {};

    $( document ).ready(
        function() {
            radium_opts.field_objects.dimensions.init();
        }
    );

    radium_opts.field_objects.dimensions.init = function() {

        $( '.radium-opts-dimensions-container' ).each( function() {
        
                var el = $( this );
                var parent = el;
              
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

                el.find( ".radium-opts-dimensions-units" ).select2( default_params );

                el.find( '.radium-opts-dimensions-input' ).on(
                    'change', function() {
                        var units = $( this ).parents( '.radium-opts-field:first' ).find( '.field-units' ).val();
                        if ( $( this ).parents( '.radium-opts-field:first' ).find( '.radium-opts-dimensions-units' ).length !== 0 ) {
                            units = $( this ).parents( '.radium-opts-field:first' ).find( '.radium-opts-dimensions-units option:selected' ).val();
                        }
                        if ( typeof units !== 'undefined' ) {
                            el.find( '#' + $( this ).attr( 'rel' ) ).val( $( this ).val() + units );
                        } else {
                            el.find( '#' + $( this ).attr( 'rel' ) ).val( $( this ).val() );
                        }
                    }
                );

                el.find( '.radium-opts-dimensions-units' ).on(
                    'change', function() {
                        $( this ).parents( '.radium-opts-field:first' ).find( '.radium-opts-dimensions-input' ).change();
                    }
                );
            }
        );


    };
})( jQuery );