jQuery( document ).ready( function($) {

    $('.rwmb-radio-image').parent().addClass('rwmb-label-radio-image').each(function() {

        var $this = $(this);

        // Highlight current selection
        $(this).on('click', function() {
            $this.siblings().removeClass('selected');
            $(this).addClass('selected');
        });

    });

});