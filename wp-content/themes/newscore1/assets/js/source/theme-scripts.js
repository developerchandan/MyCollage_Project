
// On document ready functions
// ======================================================================
 // If JavaScript is enabled remove 'no-js' class and give 'js' class
jQuery('html').removeClass('no-js').addClass('js');

jQuery(document).ready(function($) {

     //This will be called by ajax scripts and is available in the global scope
    Radium_Theme_Scripts = {

         init : function () {

            window.Radium_Theme_Scripts.MainScripts();
            window.Radium_Theme_Scripts.Reload();
            window.Radium_Theme_Scripts.PopupGallery();
            window.Radium_Theme_Scripts.LoadingImages();

        },

        MainScripts : function () {

            // smart resize
            $(window).smartresize(function(){
                window.Radium_Theme_Scripts.Reload(); //reloaded on resize
            });

            $('.subfeatured-articles, .recent-posts-carousel, .video-central-carousel, .radium-product-carousel').horizontalCarousel();

            //BuddyPress activity loading more
            $('.buddypress #activity-stream .load-more').on('click', function () {
                $(this).addClass('loading');
            });

            //Latest News Ajax
            $('.load-more-latest-element > button').on('click', function(e) {

                if( !$(this).hasClass('disabled') ) {

                    $(this).addClass('disabled');

                    var categories = $(this).data('cat'),
                        page =  parseInt($(this).data('page')),
                        count = $(this).data('count'),
                        cache_id = $(this).data('cache_id'),
                        totalPages = $(this).data('pages');

                    Radium_Theme_Ajax_Globals.Load_More_Content( $(this), categories, page, count, cache_id, totalPages );

                }

            });

            //Latest News Ajax
            $('.load-more-blog > button').on('click', function(e) {

                if( !$(this).hasClass('disabled') ) {

                    $(this).addClass('disabled');

                    var page = $(this).data('page'),
                        count = $(this).data('count'),
                        blog_type = $(this).data('blog_type'),
                        totalPages = $(this).data('pages'),
                        sidebars = $(this).data('sidebars'),
                        builder = $(this).data('builder');

                    Radium_Theme_Ajax_Globals.Load_More_Blog_Content( $(this), count, blog_type, totalPages, sidebars, builder);

                }

            });

            //Header Search Bar
            $('#header-search').on('click', function(e) {

                e.preventDefault();

                $('.search-form').toggleClass('is-visible');

                if ( !$('.site-navigation').hasClass('search-form-is-visible') ) {

                    $('.search-form input').trigger('focus');

                } else {

                    $('.search-form input').trigger('blur');
                }

                $('.site-navigation').toggleClass('search-form-is-visible');

            });

            //header tooltips
            if ( $('#header').hasClass('has-news') ) {

                var header_tooltip_position = 'left';

           } else if ( $('#header').hasClass('has-search has-random') ) {

                var header_tooltip_position = 'top';

            } else {

                var header_tooltip_position = 'left';

            }

            $('#header-nav-extras a').each(function(){

                $(this).tooltip({
                    animation : true,
                    placement: header_tooltip_position,
                 });

            });

            $('.radium-gallery, .products, .radium_slider_wrapper_outer, .main-flexslider ul.slides').each(function() {
                $(this).removeClass('loading');
            });

            // FitVid Magic - Target all videos
            $("body").fitVids();
            $('body').fitVids({ customSelector: "iframe[src*='vine']" });
            $('body').fitVids({ customSelector: "iframe[src*='instagram']" });
            $('body').fitVids({ customSelector: "iframe[src*='livestream']" });
            $('body').fitVids({ customSelector: "iframe[src*='soundcloud']" });

             /* Sliders
            -----------------------------------------------------------------------------*/
            $(".main-flexslider").flexslider({
                controlNav: false,
                keyboardNav: true,
                mousewheel: false,
                pausePlay: false,
                randomize: false,
                animationLoop: true,
                pauseOnAction: false,
                easing: "easeInCubic",
                prevText: "",
                nextText: "",
                start: function(slider) {
                    var $new_height = slider.slides.eq(0).height();
                    slider.height($new_height);
                },
                before: function(slider) {
                    var $new_height = slider.slides.eq(slider.animatingTo).height();
                    if($new_height !== slider.height()){
                        slider.animate({ height: $new_height  }, 300);
                    }
                },
            });

            $('.radium-slider, .post-slider').hover(function(){
                $('.flex-pauseplay span, .flex-direction-nav li a',this).stop().fadeTo(500, 1);
            }, function() {
                $('.flex-pauseplay span, .flex-direction-nav li a',this).stop().fadeTo(500, 0);
            });

            // The slider being synced must be initialized first
            $('.media-slider-nav').flexslider({
                controlsContainer: '.post-slider-nav',
                animation: "slide",
                controlNav: false,
                animationLoop: false,
                slideshow: false,
                itemWidth: 150,
                itemMargin: 5,
                prevText: "",
                nextText: "",
                asNavFor: '.media-slider'
            });

            jQuery('.media-slider').flexslider({
                controlsContainer: '.post-slider',
                slideDirection: "horizontal",
                animation: "slide",
                slideshow: false,
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
                        var $new_height = Math.round(slider.slides.eq(0).width() / 1.7777);
                        slider.height($new_height);
                    }
                },
                before: function(slider) {
                    if ( slider ) {
                        var $new_height = Math.round(slider.slides.eq(slider.animatingTo).width() / 1.7777);
                        if( $new_height !== slider.height() ){
                        slider.animate({ height: $new_height  }, 300);
                    }
                }
                },
            });

            $(".media-slider").css({ display : "block" });
            $(".media-slider").addClass("loaded").removeClass("loading");

            //megamenu tabs On Click Event
            $("ul.tabs li").on('click', function(e) {

                $(this).find("a").on('click', function(e) {
                    e.preventDefault();
                });

                $(this).parents('.tabs-wrapper').find("ul.tabs li").removeClass("active"); //Remove any "active" class
                $(this).addClass("active"); //Add "active" class to selected tab
                $(this).parents('.tabs-wrapper').find(".tab_content").hide(); //Hide all tab content

                var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
                $(this).parents('.tabs-wrapper').find(activeTab).fadeIn(); //Fade in the active ID content

            });

            jQuery('.tabs').find('> li a').each( function() {

                jQuery(this).on('click', function(e) {
                    e.preventDefault();
                });

            });

            //With ul list
            $('.news-tab .nav-tabs a').on('click', function(e) {
                e.preventDefault();
                $(this).tab('show');
            });

            //Top News
           $('.top-news').find('.dropdown-toggle').on('click', function(){
                $(this).parent().siblings('.submenu').toggleClass('open');
            });

            /* Back to top */
            if( window.radium_framework_globals.back_to_top === 'true' ) {

                $().UItoTop({
                    containerID: 'gototop', // fading element id
                    containerHoverID: 'gototophover', // fading element hover id
                    scrollSpeed: 1200,
                    easingType: 'easeOutQuart'
                });

            }

            // Appear
            // -----------------------------------------------------------------------------
            /* add animations to banners in view */
            $('.animated-content, .score-box, .entry-rating').waypoint(function( direction ) {

              if(!$(this).parents().hasClass('slider')){

                 var animation = $(this).attr("data-animate");

                 $(this).addClass(animation);
                 $(this).addClass('start-animation');

              }

            }, { offset: '80%' });

            /* vertical center texts in banners */
            $('.radium-banner .center').vAlign();
            $('.content-carousel-inner-super-big').find('header').vAlign();


            /* Responsive Tables
            -----------------------------------------------------------------------------*/
            $('table').addClass('responsive');

            /* Radium WooCommerce Ajax
            -----------------------------------------------------------------------------*/
            if ( Modernizr.mq('screen and (min-width:768px)') ) {

                window.Radium_WooCommerce_Ajax.init();

                 /* Tooltips
                 -----------------------------------------------------------------------*/
                $('.yith-wcwl-wishlistexistsbrowse.show').each(function(){

                    var message = $(this).find('a').text();

                    $(this).tooltip({
                        animation : true,
                        title : message,
                        placement : 'right'
                    });

                });

                $('.yith-wcwl-add-button').find('a').not('.add_to_wishlist').remove();

                $('.yith-wcwl-add-button.show').each(function(){

                    var message = $(this).find('a.add_to_wishlist').text();

                    $(this).tooltip({
                        animation : true,
                        title : message,
                        placement : 'right'
                    });

                });

                $('.social-icon').each(function(){

                    $(this).tooltip({
                        animation : true,
                        title : $(this).data('type'),
                      });

                });

            }

            /* WooCommerce Review Form
            -----------------------------------------------------------------------------*/
            $("#review_form_wrapper").show();

            var review_html = $('#review_form_wrapper').html(),
                height 		= $(window).height(),
                width 		= $(window).width();

            $('.radium_show_review_form').on('click', function () {

                 $('body').addClass('overlay_active').append('<div id="review-form-wrapper-overlay" />');
                 $('#review-form-wrapper-overlay').append(review_html).show().height(height).width(width).append('<div id="review_form_wrapper_overlay_close"><span class="icon-remove"></span></div>');
             });

            // Open review form lightbox if accessed via anchor
            if( window.location.hash === '#review_form' ) {
                $('.radium_show_review_form').trigger('click');
            }

            $('#review_form_wrapper_overlay_close').live('click', function () {

                $("#review-form-wrapper-overlay").remove();
                $('body').removeClass('overlay_active');

             });

             /* Lightbox
            -----------------------------------------------------------------------------*/
            if ( jQuery.prettyPhoto ) {

                $("a[rel^='lightbox']").prettyPhoto({ social_tools: false, });

                var $sliders    = $('.gallery-slider'),
                    $lightboxes = $('.radium-gallery');

                if ( jQuery.fn.galleria ) {

                    $sliders.each(function(){
                        var $self = $(this),
                            h     = parseInt($self.attr('height')),
                            w     = parseInt($self.attr('width'));

                             $self.galleria({
                                width  : w,
                                debug: false,
                                responsive: true,
                                height:0.5,
                            });

                    });

                }

                $lightboxes.each(function(){
                    $(this).find('a').prettyPhoto({ social_tools: false, });
                });

            }

            //minor fix for post pagination
            var post_link = $('.entry-content').find('.radium-theme-pagination .page-numbers > li');

            $(post_link).each(function() {

                if( !$(this).children().length > 0 ) {
                    $(this).wrapInner('<span class="current" />');
                }

            });

            /* Accordion and Tabs
            -----------------------------------------------------------------------------*/
            // Tabs and Toggle
            jQuery(".radium-tabs").tabs();

            jQuery(".radium-toggle").each( function () {
                if(jQuery(this).attr('data-id') == 'closed') {
                    jQuery(this).accordion({ header: '.radium-toggle-title', collapsible: true, active: false, heightStyle: "content" });
                } else {
                    jQuery(this).accordion({ header: '.radium-toggle-title', collapsible: true, heightStyle: "content" });
                }
            });

            var allPanels = $('.accordion > .inner').hide();

              $('.accordion > .title > a').on('click', function(e) {

                $this = $(this);
                $target =  $this.parent().next();

                if(!$target.hasClass('active')){

                    allPanels.slideUp(400, 'easeOutCirc');
                    $target.slideDown(400, 'easeOutCirc');
                    $this.parent().parent().find('.title').removeClass('active');
                    $this.parent().addClass('active');

                }

                e.preventDefault();
              });


          },

          LoadingImages : function() {

            $('.post-thumb').waypoint(function() {

                 var animation = $(this).data("animate");

                 $(this).addClass(animation);
                 $(this).removeClass('image-loading');

            }, { offset: '80%' });

          },

          PopupGallery : function() {

              var Gallery = {
                  shouldDisplayAd: false
              };

              // In case there are multiple galleries
              $('.popup-gallery').each(function() {
                  $(this).find('.gallery-image').fancybox({
                      padding: 0,
                      margin: [45, 20, 20, 20],
                      scrolling: 'visible',
                      width: 300,
                      height: 270,
                      //autoCenter: true,
                      helpers : {
                          thumbs : true,
                      },
                      afterShow: function() {
                          //if ( Gallery.shouldDisplayAd ) {
                              //googletag.cmd.push(function() {
                                  //googletag.pubads().refresh([slideshowAdSlot]);
                              //});
                              //Gallery.shouldDisplayAd = false;
                          //}

                      },
                      beforeShow : function() {

                      },
                      /**
                       * Do additional stuff after load but before showing:
                       *
                       * Modify title
                       * Track pageview and event in GA
                       * Refresh Ad
                       *
                       * @param  {[type]} current  [description]
                       * @param  {[type]} previous [description]
                       * @return {[type]}          [description]
                       */
                      afterLoad: function( current, previous ) {
                          // Modify title to include title and caption
                          var alt = this.element.attr('alt') !== undefined ? this.element.attr('alt') : '';
                          var title = this.element.attr('title') !== undefined ? this.element.attr('title') : '';
                          this.title = alt;

                          /*if (current.href === '#gallery-ad' ) {
                              Gallery.shouldDisplayAd = true;
                          }

                          // Track pageview and events
                          if ( typeof _gaq !== 'undefined' ) {
                              _gaq.push( ['_trackPageview'] );
                              _gaq.push( ['_trackEvent', 'slideshow-click', 'Photo Gallery', 'Photo viewed' ] );
                          } */
                      },
                      tpl : {
                          closeBtn : '<a title="Close" class="fancybox-item fancybox-close" href="javascript:;">&times;</a>',
                          next     : '<a title="Next" class="fancybox-nav fancybox-next" href="javascript:;"><span><i class="icon-chevron-right"></i></span></a>',
                          prev     : '<a title="Previous" class="fancybox-nav fancybox-prev" href="javascript:;"><span><i class="icon-chevron-left"></i></span></a>'
                      }

                      }).promise().done( function() {
                          $('.gallery').find('.gallery-image').css('visibility','visible');
                      });

                  });

          },

          Reload : function() {

              var megamenu_instance 	= $(".main_menu .radium_mega").data('radium-megamenu');

             var mobilemenu_instance = $('#main-menu').data('dlmenu');

            //desktop and large screens
            if ( Modernizr.mq('screen and (min-width:768px)') ) {

                // action for screen widths including and above 768 pixels
                $(".main_menu .radium_mega").radiumMegamenu({
                    sensitivity: 7, // number = sensitivity threshold (must be 1 or higher)
                    interval: 100, // number = milliseconds for onMouseOver polling interval
                    timeout: 500, // number = milliseconds delay before onMouseOut
                    position: true,
                    container: '#theme-wrapper-inner',
                    even_spacing: window.radium_framework_globals.space_menu_evenly
                });

                //destroy mobile menu if active
                if ( mobilemenu_instance ) {
                    $( '#main-menu' ).dlmenu('destroy');
                }

                $('.dl-trigger').fadeOut();

                // Add parent class to items with sub-menus
                 jQuery("ul.sub-menu").parent().addClass('parent');

                 // Mega menu script
                $('#main-menu .sub-menu > li').on( 'hover', function(){

                    var menuid= this.id.split('-')[2];

                    var mparent = $(this).closest('.sub-mega-wrap');

                    mparent.find('.sub-menu > li').removeClass('active');

                    $(this).addClass('active');

                    mparent.find('.subcat > li').removeClass('active');
                    mparent.find('#cat-latest-'+menuid).addClass('active');

                });

                //Submenu auto align
                $('#main-menu .menu-item').on('hover',function(event){

                    var $this = $(this),
                        submenu = $this.find('.sub-mega-wrap');

                    if( submenu.length > 0 ) {
                        var offset = submenu.offset(),
                            w = submenu.width();
                        if( offset.left + w > $(window).width() ) {
                            $this.addClass('sub-menu-left');
                        } else {
                            $this.removeClass('sub-menu-left');
                        }
                    }

                }); // End submenu auto align


                 // Enable hover dropdowns for window size above tablet width
                 jQuery(".header-tools").find(".menu li.parent").hoverIntent({
                    sensitivity: 7, // number = sensitivity threshold (must be 1 or higher)
                    interval: 100, // number = milliseconds for onMouseOver polling interval
                    timeout: 500, // number = milliseconds delay before onMouseOut
                     over: function() { jQuery(this).find('ul.sub-menu').first().addClass('open'); },
                     out:function() { jQuery(this).find('ul.sub-menu').first().removeClass('open'); }
                 });

                 if ( $('#header .meta-bar').length > 0 ) {

                      $('#header .meta-bar').vTicker({
                         speed: 700,
                         pause: 4000,
                         showItems: 1,
                         mousePause: true,
                         height: 45,
                         animate: true,
                         margin: 0,
                         padding: 0,
                         startPaused: false
                     });
                 }

                /* HEADER TOOLS */
                if ( window.radium_framework_globals.sticky_header !== 'false') {

                    //$('#header').RadiumStickUp();
                    $('.site-navigation .nav-primary').waypoint('sticky', {
                        direction: 'down right',
                        stuckClass: 'stuck',
                        wrapper: '<div class="sticky-wrapper" />'
                    });


                }

            } else if( Modernizr.mq('screen and (max-width:767px)') ) {

                // action for screen widths below 768 pixels
                if ( mobilemenu_instance ) {
                    $( '#main-menu' ).dlmenu('destroy'); //kill it
                }

                if ( megamenu_instance ) {
                    $( '.main_menu .radium_mega' ).radiumMegamenu('destroy'); //kill it
                }

                $( '#main-menu' ).dlmenu();
                $('.dl-trigger').fadeIn();

            }

          }

    };

    Radium_Theme_Scripts.init();

});

/*
 * Vertical Align
 *
 * Placed here because jslint is screwing it up
 * Link http://snipplr.com/view/12566/vertical-align-jquery-plugin/
 */
(function (jQuery) {
jQuery.fn.vAlign = function() {
    return this.each(function(){
        var d = jQuery(this).outerHeight();
        jQuery(this).css('margin-bottom', -d/2);
    });
};
})(jQuery);
