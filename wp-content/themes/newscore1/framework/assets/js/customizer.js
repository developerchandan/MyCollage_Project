jQuery(document).ready(function($) {

    // Initial page load
    var logo_type = $('#customize-control-logo_type').find('select').val();

    if (logo_type === 'custom') {
        $('#customize-control-logo_image').hide();
    } else if (logo_type === 'image') {
        $('#customize-control-logo_custom').hide();
        $('#customize-control-logo_custom_tagline').hide();
    } else {
        $('#customize-control-logo_custom').hide();
        $('#customize-control-logo_custom_tagline').hide();
        $('#customize-control-logo_image').hide();
    }

    $('#customize-control-logo_type').find('select').change(function() {
        logo_type = $(this).val();
        if (logo_type === 'custom') {
            $('#customize-control-logo_custom').show();
            $('#customize-control-logo_custom_tagline').show();
            $('#customize-control-logo_image').hide();
        } else if (logo_type === 'image') {
            $('#customize-control-logo_custom').hide();
            $('#customize-control-logo_custom_tagline').hide();
            $('#customize-control-logo_image').show();
        } else {
            $('#customize-control-logo_custom').hide();
            $('#customize-control-logo_custom_tagline').hide();
            $('#customize-control-logo_image').hide();
        }
    });

});
