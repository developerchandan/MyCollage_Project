/*
 * Horizontal Post Gallery.js
 * Version 0.1
 * jQuery Plugin for Sliding Images
 * http://radiumthemes.com
 *
 * Copyright (c) 2012 Franklin M Gitonga (http://radiumthemes.com) @FrankGM1
 * Licensed under the MIT License:
 * http://www.opensource.org/licenses/mit-license.php
 *
 * Dependencies
 *  - jQuery: http://jquery.com
 *
 * TODO:
 *  - Go to Slide
 *  - Progress bar
 */

(function($){

    $.radium_post_gallery_h = function(options, el) {

  		/* Variables
  		----------------------------*/
  		var slider 				= $(el), //this instance
  			radium_post_gallery_h 	= slider,
  			gallery 			= slider,
  			totalLoaded 		= 0,

  			vars 				= $.radium_post_gallery_h.vars;

	  		// Access to jQuery and DOM versions of element
	  		slider.el 	= el;

	  	// Add a reverse reference to the DOM object
	  	$.data(el, "radium_custom_horizontal_slider", slider);

  		slider.init = function(){

  			// Combine options
  			$.radium_post_gallery_h.vars.options = $.extend({},$.radium_post_gallery_h.defaultOptions, options);
  		    slider.options = $.radium_post_gallery_h.vars.options;

  		    slider._build();

  		};

  		/* Build Elements
  		----------------------------*/
 		slider._build = function() {

            /* CSS Slider */
            $(this).find(".carousel-item").first().attr('data-first', 'true');
            $(this).find(".carousel-item").last().attr('data-last', 'true');

            // Show Arrows
            if (slider.options.showArrows) {
                slider.navigation();
            }

            $(gallery).find('.carousel-item').each(function(index) {

                switch (index) {

                case 1:
                    $(this).addClass(slider.options.positionClassNames[3]);
                    break;
                case 3:
                    $(this).addClass(slider.options.positionClassNames[1]);
                    break;
                default:
                    $(this).addClass(slider.options.positionClassNames[index]);
                }

            });

        }; // init

        slider.start = function() {

            var $this = $(gallery);

            $(gallery).find('.carousel-item').each(function(index) {

                slider.RemoveClass($(this));

            });

            var first_el  = $this.find("[data-first='true']");

            $(first_el).addClass('move-at-bat');
            $(first_el).next().addClass('move-on-deck');
            $(first_el).next().next().addClass('move-in-the-hole');
            $this.find("[data-last='true']").addClass('move-last-up');

        };

        slider.startReverse = function() {

            var $this = $(gallery);

            $(gallery).find('.carousel-item').each(function(index) {

                slider.RemoveClass($(this));

            });

            var last_el  = $this.find("[data-last='true']");

            $(last_el).addClass('move-at-bat');
            $(last_el).prev().addClass('move-last-up');
            $this.find("[data-first='true']").next().addClass('move-in-the-hole');
            $this.find("[data-first='true']").addClass('move-on-deck');

        };

        slider.cycleForward = function(event) {

            var $this = $(gallery);

            $(gallery).find('.carousel-content').removeClass('carousel-reverse');

            if ( !$this.find("[data-active='true']").length ) {

                slider.start();

            } else {

                $this.find('.carousel-item.move-at-bat').data('active', null); //reset before

            }

            if ($.support.transition) {

                if (slider.options.isAnimating) return;

                slider.options.isAnimating = true;

                setTimeout($this, function() {
                    slider.options.isAnimating = false;
                }, slider.options.clickCycleThreshold);

            }

            slider.options.transitionStarted = true;

            if( slider.options.last === true) {

                slider.options.last = false; //reset last item check

                slider.start();

                //return;
            } else {

                $(gallery).find('.carousel-item').each(function(index) {

                    if($(this).hasClass('move-at-bat') ) {

                        $(this).attr('data-active', true);

                    } else {

                        $(this).attr('data-active', false);

                    }

                    slider.RemoveClass($(this));

                });

                var cur_img  = $this.find("[data-active='true']"),
                    next_img = $(cur_img).next(),
                    up_next  = $(next_img).next(),
                    last_up  = $(cur_img).prev();

                $(cur_img).addClass('move-last-up');
                $(next_img).addClass('move-at-bat');
                $(up_next).addClass('move-on-deck');
                $(up_next).next().addClass('move-in-the-hole');
                $(last_up).addClass('move-in-the-hole');

                $this.find('.carousel-item.move-at-bat').removeData(); //reset once complete

                $(gallery).find('.carousel-item').each(function(index) {

                    if($(this).hasClass('move-at-bat') ) {

                        $(this).attr('data-active', true);

                    } else {

                        $(this).attr('data-active', null);

                    }

                    if( !$(this).hasClass('move-last-up') && !$(this).hasClass('move-at-bat') && !$(this).hasClass('move-on-deck') ) {
                        $(this).hasClass('move-in-the-hole');
                    }

                });

                //loop to first item if on last item
                if( $(gallery).find('.carousel-item.move-at-bat').data('last') ) {

                    slider.options.last = true;

                    $(gallery).find("[data-first='true']").addClass('move-on-deck');
                    $(gallery).find("[data-first='true']").next().addClass('move-next-up');

                } else {

                    slider.options.last = false;

                }

            }

        };

        slider.cycleReverse = function(event) {

            var $this = $(gallery);

            $(gallery).find('.carousel-content').addClass('carousel-reverse');

            if ( !$this.find("[data-active='true']").length ) {

                slider.startReverse();
                $(gallery).find("[data-first='true']").addClass('move-in-the-hole');

            } else {

                $this.find('.carousel-item.move-at-bat').data('active', null); //reset before

            }

            if ($.support.transition) {

                if (slider.options.isAnimating) return;

                slider.options.isAnimating = true;

                setTimeout($this, function() {
                    slider.options.isAnimating = false;
                }, slider.options.clickCycleThreshold);

            }

            slider.options.transitionStarted = true;

            if( slider.options.first === true) {

                slider.options.first = false; //reset last item check
                slider.startReverse();

            //return;
            } else {

                $(gallery).find('.carousel-item').each(function(index) {

                    if($(this).hasClass('move-at-bat') ) {

                        $(this).attr('data-active', true);

                    } else {

                        $(this).attr('data-active', false);

                    }

                    slider.RemoveClass($(this));

                });

                var cur_img  = $this.find("[data-active='true']"),

                    prev_img = $(cur_img).prev(),
                    up_next  = $(prev_img).prev(),
                    last_up  = $(cur_img).next();

                $(cur_img).addClass('move-on-deck');
                $(cur_img).prev().addClass('move-at-bat');
                $(cur_img).prev().prev().addClass('move-last-up');
                $(cur_img).next().addClass('move-in-the-hole');

                if( !$(cur_img).next().length ) {
                    $(gallery).find("[data-first='true']").addClass('move-in-the-hole');
                }

                $this.find('.carousel-item.move-at-bat').removeData(); //reset once complete

                $(gallery).find('.carousel-item').each(function(index) {

                    if($(this).hasClass('move-at-bat') ) {

                        $(this).attr('data-active', true);

                    } else {

                        $(this).attr('data-active', null);

                    }

                    if( !$(this).hasClass('move-last-up') && !$(this).hasClass('move-at-bat') && !$(this).hasClass('move-on-deck') ) {
                        $(this).hasClass('move-in-the-hole');
                    }

                });

                //loop to first item if on last item
                if( $(gallery).find('.carousel-item.move-at-bat').data('first') ) {

                    slider.options.first = true;

                    $(gallery).find("[data-last='true']").addClass('move-last-up');
                    //$(gallery).find("[data-last='true']").prev().addClass('move-on-deck');

                } else {

                    slider.options.first = false;

                }

            }

        };

        slider.slideTo = function(img) {

            $(gallery).scrollTo(img, 500, slider.scrollToOptions);

            $(gallery).find('.carousel-item').removeClass('active');
            $(img).addClass('active');

            if (slider.options.lightbox) {
                $(gallery).find('.carousel-item').not('.active').animate({opacity: '0.2'});
                $(gallery).find('.carousel-item.active').animate({opacity: '1'});
            }

        };


        slider.navigation = function () {

            $(gallery).find('.arrow-control-prev').on('click', function(e) {
                slider.cycleReverse();
            });

            $(gallery).find('.arrow-control-next').on('click', function(e) {
                slider.cycleForward();
            });

        }; // navigation

        slider.RemoveClass = function($this) {

            var classList = $this.attr('class').split(/\s+/);
            jQuery.each( classList, function(index, item){

                if(item.indexOf('move-') !== -1){
                    $this.removeClass(item);
                }

            });

        };

 		// Run it!
 		slider.init();
  	};

	/* Global Variables
	----------------------------*/
	$.radium_post_gallery_h.vars = {

		// Internal variables
 		options					:	{}			// Stores assembled options list

	};

	/* Default Options
	----------------------------*/
  	$.radium_post_gallery_h.defaultOptions = {

  	    enableKeyboardNavigation: true,
  	    loop			: true,
  	    showArrows		: true,
        clickCycleThreshold : 444,
        classNames : ["carousel-content"],
        positionClassNames : ["move-at-bat", "move-last-up", "move-in-the-hole", "move-on-deck"],
        classNameBindings : ["transitionStarted:carousel-transition", "reverse:carousel-reverse"],
        itemViewClass : "carousel",
        isAnimating : false,
        transitionStarted : false,
        reverse : false,
        MAX_INDEX : 3,
        last: false,
        first: false,
  	};

  	$.fn.radium_post_gallery_h  = function(options) {

  		return this.each(function(){
  	        (new $.radium_post_gallery_h(options, this));
  	    });

  	};

})(jQuery);
