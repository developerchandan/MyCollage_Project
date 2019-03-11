/**
 * window.Radium_WooCommerce_Ajax - View products quickly using ajax
 *
 * @type {Object}
 */
window.Radium_WooCommerce_Ajax = {

    init: function() {

        window.Radium_WooCommerce_Ajax.QuickView();

        /***************** WooCommerce Cart *****************/
        var productToAdd;

        //notification
        jQuery('.products .add_to_cart_button').on('click', function(){
            productToAdd = jQuery(this).closest('li').find('.name').text();
            jQuery('#global-alert').addClass('message').addClass('show-message').text(productToAdd + ' ' + window.radium_framework_globals.cart_added_message).hide('fast').delay(1500).show('fast');
			
            setTimeout(function() {
                jQuery('#global-alert').removeClass('show-message').fadeOut(400);
                jQuery('#global-alert').empty();
            }, 5000); //show alert for 5 secs

        	 jQuery( 'body' ).on('added_to_cart', function() {
        		window.Radium_WooCommerce_Ajax.UpdateCart();
        	 });

        });
       
        jQuery('.add_to_wishlist').on('click', function(){
			
			jQuery( 'body' ).on('added_to_wishlist', function() {
				window.Radium_WooCommerce_Ajax.UpdateWishlist();  
				//window.Radium_WooCommerce_Ajax.UpdateWishlistCount();         	
			});
		
		});
		
    },
    
    UpdateCart: function() {
    	    	
    	jQuery.ajax({
	        url         : window.radium_framework_globals.ajaxurl,
	        type        : 'GET',
	        dataType    : 'JSON',
	        data: {
	            'action' : 'radium_woocommerce_cart_ajax',
	        },
	        beforeSend  : function () {
	        }
	
	    }).done(function( responseText, textStatus, jqXHR ) {
			
			if( jQuery('li.parent.shopping-bag-item').find(".bag-empty").length ) {
				jQuery('li.parent.shopping-bag-item').find(".bag-empty").remove();
				jQuery('li.parent.shopping-bag-item').find("ul.sub-menu > li").html('<div class="shopping-bag"/>');
			}
			
			var response = jQuery.parseHTML( responseText );
				response = jQuery( response ).find('.shopping-bag').html();
				
        	jQuery('li.parent.shopping-bag-item').find('.shopping-bag').html(response);

       		jQuery('li.parent.shopping-bag-item').removeClass('loading');
				       		
	    }).always(function( responseText, status, xhr ) {
			
	        jQuery('li.parent.shopping-bag-item').addClass('loading');
	
	    }).fail(function(jqXHR, textStatus, errorThrown) {
	
			console.log(errorThrown);
	
	        // handle request failures
	        jQuery('.alert.alert-message').html(window.radium_framework_globals.ajax_error_message).fadeIn(400);
	
	        setTimeout(function() {
	            jQuery('.alert.alert-message').fadeOut(400);
	            jQuery('.alert.alert-message').empty();
	        }, 5000); //show alert for 5 secs
		
	    }); //end ajax call
    },
    
    UpdateWishlist: function() {
        	
    	jQuery.ajax({
	        url         : window.radium_framework_globals.ajaxurl,
	        type        : 'GET',
	        dataType    : 'JSON',
	        data: {
	            'action' : 'radium_woocommerce_wishlist_ajax',
	        },
	        beforeSend  : function () {
 	        }
	
	    }).done(function( responseText, textStatus, jqXHR ) {
			
			if( jQuery('li.parent.wishlist-item').find(".wishlist-empty").length ) {
				jQuery('li.parent.wishlist-item').find(".wishlist-empty").remove();
				jQuery('li.parent.wishlist-item').find("ul.sub-menu > li").html('<div class="wishlist-bag"/>');
			}
 			
			var response = jQuery.parseHTML( responseText ),
				parsedResponse = jQuery( response ).find('.wishlist-bag').html(),
				new_wishlist_count = jQuery( parsedResponse ).filter('.bag-contents').attr('data-count');	
				
        	jQuery('li.parent.wishlist-item').find('.wishlist-bag').html(parsedResponse);
        	jQuery('li.parent.wishlist-item').find('.wishlist-link span').text(new_wishlist_count);
       		jQuery('li.parent.wishlist-item').removeClass('loading');
				       		
	    }).always(function( responseText, status, xhr ) {
			
	        jQuery('li.parent.wishlist-item').addClass('loading');
	
	    }).fail(function(jqXHR, textStatus, errorThrown) {
	
			console.log(errorThrown);
	
	        // handle request failures
	        jQuery('.alert.alert-message').html(window.radium_framework_globals.ajax_error_message).fadeIn(400);
	
	        setTimeout(function() {
	            jQuery('.alert.alert-message').fadeOut(400);
	            jQuery('.alert.alert-message').empty();
	        }, 5000); //show alert for 5 secs
 	
	    }); //end ajax call
    },

	UpdateWishlistCount: function() {
	    	
		jQuery.ajax({
	        url         : window.radium_framework_globals.ajaxurl,
	        type        : 'GET',
	        dataType    : 'JSON',
	        data: {
	            'action' : 'radium_woocommerce_wishlist_ajax',
	        },
	        beforeSend  : function () { }
	
	    }).done(function( responseText, textStatus, jqXHR ) {
			
			var response = jQuery.parseHTML( responseText );
					    	
	    	jQuery('li.parent.wishlist-item').find('.wishlist-link span').html(response);
				
			console.log(response);
								       		
	    }).always(function( responseText, status, xhr ) {
	
	
	    }).fail(function(jqXHR, textStatus, errorThrown) {
	
			console.log(errorThrown);
 	      
	    }); //end ajax call
	},

    QuickView: function() {

        if ( window.Radium_WooCommerce_Ajax.getHashtag() ) {

            // Grab the rel index to trigger the click on the correct element
            var hashIndex = window.Radium_WooCommerce_Ajax.getHashtag(),
                hashRel = hashIndex;

            hashIndex = hashIndex.substring(hashIndex.indexOf('/')+1,hashIndex.length-1);
            window.Radium_WooCommerce_Ajax.getProduct(hashIndex, null);

        }

        jQuery('.quick-view').on('click', function(e){

            var $this = jQuery(this);

            e.preventDefault();

            var $product_id = $this.attr('data-prod');

            window.Radium_WooCommerce_Ajax.getProduct($product_id, $this);

            window.Radium_WooCommerce_Ajax.setHashtag('quickview', $product_id);

        }); // product lightbox

    },

    getProduct: function($product_id, $this ){

        var data = {
                action: 'radium_woocommerce_quickview',
                product_id: $product_id
            },
            
            ajaxContent = '#quickpop',
            globalLoading = jQuery('#global-loading'),
            alertMessage = jQuery('.alert-message');

            if ( window.Pace ) {
            	Pace.restart();
			}
			
            jQuery.ajax({
                url         : window.radium_framework_globals.ajaxurl,
                type        : 'POST',
                data        : data,
                dataType    : 'html',
                beforeSend  : function() { globalLoading.fadeIn(200); }
            }).done(function( responseText, textStatus, jqXHR ) {

                window.Radium_WooCommerce_Ajax.createPopup();

                jQuery(ajaxContent).empty().html('<div id="quick-pop-inner">'+responseText+"</div>").append('<a id="open-quickpop" rel="leanModal" href="#quickpop"/>');
                jQuery('#quickpop').append('<a id="close-quickpop" href="#"><span></span></>');

                jQuery('body').append("<div id='lean_overlay'></div>");
                jQuery('#lean_overlay').fadeTo(200, 0.5);

                window.Radium_WooCommerce_Ajax.resize();

                jQuery(ajaxContent).imagesLoaded(function ($images) {

                    setTimeout(function() {

                        // initialize theme scripts again
                        window.Radium_WooCommerce_Ajax.ReloadScripts();

                    }, 800);

                });

                setTimeout(function() {

                    //destroy popup on click
                    jQuery('#close-quickpop, #lean_overlay').on('click', function(e){

                        e.preventDefault();

                        window.Radium_WooCommerce_Ajax.destroy();

                    });

                }, 200);

            }).always(function( responseText, status, xhr ) {

                globalLoading.fadeOut(200);

            }).fail(function(jqXHR, textStatus, errorThrown) {

                // handle request failures
                alertMessage.html(window.radium_framework_globals.ajax_error_quick_view).fadeIn(300);

                setTimeout(function() {
                    alertMessage.fadeOut(300);
                    alertMessage.empty();
                }, 3000); //show alert for 5 secs

                if ( $this ) {

                    var url = $this.parent().parent().attr('href');
                    setTimeout(function() {
                        window.Radium_WooCommerce_Ajax.redirect(url);
                    }, 3400); //show alert for 5 secs

                }

            }); //end ajax call

    },

    createPopup: function() {

        if ( jQuery('#quickpop').length === 0 ) {
            jQuery('body').append('<div id="quickpop"/>');
        }

    },

    resize: function() {

        var modal_id = "#quickpop";

        var modal_height = jQuery(modal_id).outerHeight();
        var modal_width = jQuery(modal_id).outerWidth();

        jQuery(modal_id).css({
            'display': 'block',
            'position': 'fixed',
            'opacity': 0,
            'z-index': 11000,
            'left': 50 + '%',
            'margin-left': -(modal_width / 2) + "px",
            'top': 100 + "px"
        });

        jQuery(modal_id).fadeTo(200, 1);

    },

    ReloadScripts: function() {

        if( jQuery.wc_variation_form ) { jQuery('#quickpop form').wc_variation_form(); }

         // The slider being synced must be initialized first
        jQuery('.media-slider-nav').flexslider({
            controlsContainer: '.post-slider-nav',
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            itemWidth: 210,
            itemMargin: 5,
            asNavFor: '.media-slider'
        });

        jQuery('.media-slider').flexslider({
            controlsContainer: '.post-slider',
            slideDirection: "horizontal",
            animation: "slide",
            slideshow: true,
            pauseOnHover: true,
            slideshowSpeed: 7000,
            animationDuration: 600,
            controlNav: false,
            directionNav: true,
            prevText: "",
            nextText: "",
            sync: ".media-slider-nav",
            start: function(slider) {
                if ( slider ) {
                    var $new_height = slider.slides.eq(0).height();
                    slider.height($new_height);
                }
            },
            before: function(slider) {
                if ( slider ) {
                    var $new_height = slider.slides.eq(slider.animatingTo).height();
                    if($new_height !== slider.height()){
                        slider.animate({ height: $new_height  }, 300);
                    }
                }
            },
        });

        jQuery(".media-slider").css({ display : "block" });

        setTimeout(function() {
            jQuery(".media-slider").addClass("loaded").removeClass("loading");
        }, 200); //show alert for .2 secs

        jQuery("#quickpop div.quantity:not(.buttons_added), #quickpop td.quantity:not(.buttons_added)").addClass('buttons_added').append('<input type="button" value="+" class="plus" />').prepend('<input type="button" value="-" class="minus" />');

    },

    getHashtag : function(){
        var url = location.href,
            hashtag = (url.indexOf('#quickview') !== -1) ? decodeURI(url.substring(url.indexOf('#quickview')+1, url.length)) : false;

        return hashtag;
    },

    setHashtag: function (theRel, rel_index ){
        location.hash = theRel + '/'+rel_index+'/';
    },

    clearHashtag: function (){

        if ( location.href.indexOf('#quickview') !== -1 ) {
            history.replaceState("", document.title, window.location.pathname + window.location.search);
        }

    },

    destroy: function() {

        window.Radium_WooCommerce_Ajax.clearHashtag();

        jQuery("#lean_overlay").fadeOut(200).remove();

        jQuery('#quickpop').css({ 'display' : 'none' });

        setTimeout(function() {
            jQuery("#lean_overlay, #quickpop").remove();
        }, 210); //show alert for 5 secs

    },

    redirect: function(url_to_page) {

        window.location.href = url_to_page;

    }

};