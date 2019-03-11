/* global radium_opts_change, wp */

(function($) {
    "use strict";
    $.radium_opts = $.radium_opts || {};
    $(document).ready(function() {
        $.radium_opts.radium_importer();
    });
    $.radium_opts.radium_importer = function() {

        $('.wrap-importer.theme.not-imported, #radium-importer-reimport').unbind('click').on('click', function(e) {
            e.preventDefault();

            var parent = jQuery(this);

            var reimport = false;

            var message = 'Import Demo Content?';

            if (e.target.id == 'radium-importer-reimport') {
                reimport = true;
                message = 'Re-Import Content?';

                if (!jQuery(this).hasClass('rendered')) {
                    parent = jQuery(this).parents('.wrap-importer');
                }
            }

            if (parent.hasClass('imported') && reimport == false) return;

            var r = confirm(message);

            if (r == false) return;

            if (reimport == true) {
                parent.removeClass('active imported').addClass('not-imported');
            }

            parent.find('.spinner').css('display', 'inline-block');

            parent.removeClass('active imported');

            parent.find('.importer-button').hide();

            var data = jQuery(this).data();

            data.action = "radium_opts_radium_importer";
            data.demo_import_id = parent.attr("data-demo-id");
            data.nonce = parent.attr("data-nonce");
            data.type = 'import-demo-content';
            data.radium_import = (reimport == true) ? 're-importing' : ' ';
            parent.find('.radium_image').css('opacity', '0.5');
            jQuery.post(ajaxurl, data, function(response) {
                parent.find('.radium_image').css('opacity', '1');
                parent.find('.spinner').css('display', 'none');

                if (response.length > 0 && response.match(/Have fun!/gi)) {

                    if (reimport == false) {
                        parent.addClass('rendered').find('.radium-importer-buttons .importer-button').removeClass('import-demo-data');

                        var reImportButton = '<div id="radium-importer-reimport" class="radium-importer-buttons button-primary import-demo-data importer-button">Re-Import</div>';
                        parent.find('.theme-actions .radium-importer-buttons').append(reImportButton);
                    }
                    parent.find('.importer-button:not(#radium-importer-reimport)').removeClass('button-primary').addClass('button').text('Imported').show();
                    parent.find('.importer-button').attr('style', '');
                    parent.addClass('imported active').removeClass('not-imported');
                } else {
                    parent.find('.import-demo-data').show();

                    if (reimport == true) {
                        parent.find('.importer-button:not(#radium-importer-reimport)').removeClass('button-primary').addClass('button').text('Imported').show();
                        parent.find('.importer-button').attr('style', '');
                        parent.addClass('imported active').removeClass('not-imported');
                    }

                    alert('There was an error importing demo content: \n\n' + response.replace(/(<([^>]+)>)/gi, ""));
                }
            });
            return false;
        });
    };
})(jQuery);