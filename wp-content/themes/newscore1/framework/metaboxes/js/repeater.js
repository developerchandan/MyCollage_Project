jQuery(document).ready(function($){

    Radium_Metaboxes_Repeater_Field = {

        init : function () {

            var repeater = $('.rwmb-repeater-clone').find('.repeater');

            $('.postbox').find('.repeater').each(function(){

                var repeater = $(this);

                // set column widths
                Radium_Metaboxes_Repeater_Field.set_column_widths( repeater );

                // update classes based on row count
                Radium_Metaboxes_Repeater_Field.update_classes( repeater );

                // add sortable
                Radium_Metaboxes_Repeater_Field.add_sortable( repeater );

            });

            $('.repeater .repeater-footer .add-row-end').live('click', function(){

                var repeater = $(this).closest('.repeater');

                Radium_Metaboxes_Repeater_Field.add_row( repeater, false );

                return false;
            });

            $('.repeater td.remove .add-row-before').live('click', function(){

                var repeater = $(this).closest('.repeater'),
                    before = $(this).closest('tr');

                Radium_Metaboxes_Repeater_Field.add_row( repeater, before );

                return false;
            });

            $('.repeater td.remove .rwmb-button-remove').live('click', function(){

                var tr = $(this).closest('tr');

                Radium_Metaboxes_Repeater_Field.remove_row( tr );

                return false;
            });

            $('.repeater tr').live('mouseenter', function(){

                var button = $(this).find('> td.remove > a.rwmb-button-add');
                var margin = ( button.parent().height() / 2 ) + 9; // 9 = padding + border

                button.css('margin-top', '-' + margin + 'px' );

            });

            $('.repeater td.remove .rwmb-button-remove').live('click', function(){

                var tr = $(this).closest('tr');

                Radium_Metaboxes_Repeater_Field.remove_row( tr );

                return false;
            });

            $('.repeater tr').live('mouseenter', function(){

                var button = $(this).find('> td.remove > a.rwmb-button-add');
                var margin = ( button.parent().height() / 2 ) + 9; // 9 = padding + border

                button.css('margin-top', '-' + margin + 'px' );

            });

        },

        update_order : function( repeater ) {

            repeater.find('> table > tbody > tr.row').each(function(i){
                $(this).children('td.order').html( i+1 );
            });

        },

       set_column_widths : function( repeater ) {

            // validate
            if( repeater.children('.rwmb-input-table').hasClass('row_layout') )
            {
                return;
            }

            // accomodate for order / remove
            var column_width = 100;
            if( repeater.find('> .rwmb-input-table > thead > tr > th.order').length > 1 ) {
                column_width = 93;
            }

            // find columns that already have a width and remove these amounts from the column_width var
            repeater.find('> .rwmb-input-table  > thead > tr > th[width]').each(function( i ){
                column_width -= parseInt( $(this).attr('width') );
            });

            var ths = repeater.find('> .rwmb-input-table > thead > tr > th').not('[width]').has('span');

            if( ths.length > 1 ) {

                column_width = column_width / ths.length;

                ths.each(function( i ){

                    // dont add width to last th
                    if( (i+1) == ths.length  )
                    {
                        return;
                    }

                    $(this).attr('width', column_width + '%');

                });
            }

        },

        /*
        *  Sortable Helper
        *
        *  @description: keeps widths of td's inside a tr
        */

        sortable_helder : function(e, ui)
        {
            ui.children().each(function(){
                $(this).width($(this).width());
            });
            return ui;
        },

        add_sortable : function( repeater ){

            // vars
            var max_rows = parseFloat( repeater.attr('data-max_rows') );

            // validate
            if( max_rows <= 1 ) {
                return;
            }

            repeater.find('> table > tbody').unbind('sortable').sortable({

                items : '> tr.row',
                handle : '> td.order',
                helper : Radium_Metaboxes_Repeater_Field.sortable_helder,
                forceHelperSize : true,
                forcePlaceholderSize : true,
                scroll : true,
                start : function (event, ui) {

                    // add markup to the placeholder
                    var td_count = ui.item.children('td').length;
                    ui.placeholder.html('<td colspan="' + td_count + '"></td>');

                },
                stop : function (event, ui) {

                    // update order numbers
                    Radium_Metaboxes_Repeater_Field.update_order( repeater );

                }

            });
        },

        update_classes : function( repeater ) {

            // vars
            var max_rows = parseFloat( repeater.attr('data-max_rows') ),
                row_count = repeater.find('> table > tbody > tr.row').length;

            // empty?
            if( row_count == 0 )
            {
                repeater.addClass('empty');
            }
            else
            {
                repeater.removeClass('empty');
            }

            // row limit reached
            if( row_count >= max_rows )
            {
                repeater.addClass('disabled');
                repeater.find('> .repeater-footer .rwmb-button').addClass('disabled');
            }
            else
            {
                repeater.removeClass('disabled');
                repeater.find('> .repeater-footer .rwmb-button').removeClass('disabled');
            }

        },

        add_row : function( repeater, before ) {

            // vars
            var max_rows = parseInt( repeater.attr('data-max_rows') ),
                row_count = repeater.find('> table > tbody > tr.row').length;

            // validate
            if( row_count >= max_rows )
            {
                alert( rwmb_repeater_globals.max.replace('{max}', max_rows) );
                return false;
            }

            // create and add the new field
            var new_id = repeater.find('> table > tbody > tr:nth-last-child(-n+2) > td.order').html(),
                new_field_html = repeater.find('> table > tbody > tr.row-repeater-clone').html();

                var new_id = parseInt(new_id, 10);
                ++new_id; //increment last id by one evertime

            var new_field_html2 = new_field_html.replace(/(=["]*[\w-\[\]]*?)(rwmbcloneindex)/g, '$1' + new_id);

            var new_field = $('<tr class="row"></tr>').append( new_field_html2 );

            // add row
            if( !before )
            {
                before = repeater.find('> table > tbody > .row-repeater-clone');
            }

            before.before( new_field );

            // trigger mouseenter on parent repeater to work out css margin on add-row button
            repeater.closest('tr').trigger('mouseenter');

            // update order
            Radium_Metaboxes_Repeater_Field.update_order( repeater );

            // update classes based on row count
            Radium_Metaboxes_Repeater_Field.update_classes( repeater );

            // validation
            repeater.closest('.field').removeClass('error');
        },

        remove_row : function( tr ) {

            // vars
            var repeater =  tr.closest('.repeater'),
                min_rows = parseInt( repeater.attr('data-min_rows') ),
                row_count = repeater.find('> table > tbody > tr.row').length,
                column_count = tr.children('tr.row').length,
                row_height = tr.height();

            // validate
            if( row_count <= min_rows )
            {
                alert( rwmb_repeater_globals.min.replace('{min}', row_count) );
                return false;
            }

            // animate out tr
            tr.addClass('rwmb-remove-item');
            setTimeout(function(){

                tr.remove();

                // trigger mouseenter on parent repeater to work out css margin on add-row button
                repeater.closest('tr').trigger('mouseenter');


                // update order
                Radium_Metaboxes_Repeater_Field.update_order( repeater );


                // update classes based on row count
                Radium_Metaboxes_Repeater_Field.update_classes( repeater );

            }, 400);

        }

    }

    Radium_Metaboxes_Repeater_Field.init();

});