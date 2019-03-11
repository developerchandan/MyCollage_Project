/*
 * This Script processes ajax requests
 *
 */
(function ($) {

	window.blog_element_page = 1;
    window.latest_element_page = 1;

    window.Radium_Theme_Ajax_Globals = {

        init: function() { },

        reload : function () { },

        Load_More_Content: function(caller_object, categories, pageNumber, count, cache_id, totalPages) {

			var oldPage = pageNumber;
			var newPage = parseFloat(oldPage) + 1;

            $.ajax({
                url         : window.radium_framework_globals.ajaxurl,
                type        : 'GET',
                dataType    : 'JSON',
                data: {
                    'action' : 'radium_builder_blog_latest_element_ajax',
                    'categories' : categories,
                    'item_count' : count,
                    'cache_id' : cache_id,
                    'page'   : newPage,
                    'type': caller_object.data('type'),
                    'categories': caller_object.data('category'),
                    'lang': caller_object.data('lang'),
                },
                beforeSend  : function () {
                    $('#global-loading').fadeIn(400);
                }

            }).done(function( responseText, textStatus, jqXHR ) {

                var response = jQuery.parseHTML( responseText );

                caller_object.parent().siblings('.content-inner').css('opacity', 0).append(response);

               	var oldPage = pageNumber;
               	var newPage = parseFloat(oldPage) + 1;

                caller_object.data('page', newPage).removeClass('disabled');

                window.Radium_Theme_Scripts.LoadingImages();

            }).always(function( responseText, status, xhr ) {

                $('#global-loading').fadeOut(400);

                caller_object.parent().siblings('.content-inner').css('opacity', '');

				var oldPage = pageNumber;
				var newPage = parseFloat(oldPage) + 1;

                if (newPage < totalPages) {

                   caller_object.fadeIn(200);

                } else {

                    caller_object.parent().remove();

                }

            }).fail(function(jqXHR, textStatus, errorThrown) {

				console.log(errorThrown);

                // handle request failures
                $('.alert.alert-message').html(window.radium_framework_globals.ajax_error_message).fadeIn(400);

                setTimeout(function() {
                    $('.alert.alert-message').fadeOut(400);
                    $('.alert.alert-message').empty();
                }, 5000); //show alert for 5 secs

                $('#global-loading').fadeOut(400);

            }); //end ajax call

        },

        Load_More_Blog_Content: function(caller_object, count, blog_type, totalPages, sidebars, builder) {

			window.blog_element_page++;

            $.ajax({
                url         : window.radium_framework_globals.ajaxurl,
                type        : 'GET',
                dataType    : 'JSON',
                data: {
                    'action' : 'radium_builder_blog_element_ajax',
                    'item_count' : count,
                    'orderby' : caller_object.data('orderby'),
                    'order' : caller_object.data('order'),
                    'exclude' : caller_object.data('exclude'),
                    'offset' : caller_object.data('offset'),
                    'type' : caller_object.data('type'),
                    'page'   : window.blog_element_page,
                    'sidebars'   : sidebars,
                    'builder'   : builder,
                    'readmore'   : caller_object.data('readmore'),
                    'categories': caller_object.data('categories'),
                    'excerpt': caller_object.data('excerpt'),
                    'lang': caller_object.data('lang'),
                },
                beforeSend  : function () {
                    $('#global-loading').fadeIn(400);
                 }

            }).done(function( responseText, textStatus, jqXHR ) {

				var response = jQuery.parseHTML( responseText );
					response = $( response ).find('.blog-grid-container').html();

                $('.blog-grid-container').css('opacity', 0).append(response);

                caller_object.attr('data-page', window.blog_element_page).removeClass('disabled');

               	window.Radium_Theme_Scripts.LoadingImages();

            }).always(function( responseText, status, xhr ) {

                $('#global-loading').fadeOut(400);

                $('.blog-grid-container').css('opacity', '');

				var oldPage = window.blog_element_page;
				var newPage = parseFloat(oldPage) + 1;

                if (newPage < totalPages) {

                   caller_object.fadeIn(200);

                } else {

                    caller_object.parent().remove();

                    $('.blog-grid-container').find('.ajax-end').addClass('start-animation');

                }

            }).fail(function(jqXHR, textStatus, errorThrown) {

				console.log(errorThrown);

                // handle request failures
                $('.alert.alert-message').html(window.radium_framework_globals.ajax_error_message).fadeIn(400);

                setTimeout(function() {
                    $('.alert.alert-message').fadeOut(400);
                    $('.alert.alert-message').empty();
                }, 5000); //show alert for 5 secs

                $('#global-loading').fadeOut(400);

            }); //end ajax call

        },
    };

})(jQuery);
