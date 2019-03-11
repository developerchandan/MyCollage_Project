/**
 * Custom Horizontal Carousel
 * @param  object $        
 * @param  object window    
 * @param  object document
 * @param  null undefined 
 * @return null          
 */
(function($, window, document, undefined) {

    var pluginName = "horizontalCarousel",
        defaults = {};

    function Plugin(element, options) {

        this.element = element;
        this.options = $.extend({}, defaults, options);
        this._defaults = defaults;
        this._name = pluginName;
        this.init();
    
    }

    Plugin.prototype = {

        init: function() {
        	
        	var that = this,
        		el = $(that.element),
        		sampleRelatedTeaser = el.find('.horizontal-carousel ul li:first'),
        	 	widthOfRelatedTeaser = sampleRelatedTeaser.outerWidth(true);
        	 	
        	 	that.windowWidth = el.parent().width();
            	that.count = el.find('li').length;
            	that.numToShow =  el.find('.horizontal-carousel ul').data('columns') ? el.find('.horizontal-carousel ul').data('columns') : that.windowWidth / widthOfRelatedTeaser;
            	that.numToShow = Math.round(that.numToShow);
            	             	   
            if (that.count > that.numToShow ) {
 	        	     	
        		that.enableHorizontalCarousel(that, that.options);  
        		
        	} else {
        	
        		el.find('.horizontal-carousel-container .control').css('opacity', 0);
        		
        	}
      		
      		that.calculateWidth(that);
      		
        },
        
        calculateWidth: function( el ) {
        	$(window).smartresize(function(){
        		var $this = $(el.element);
        		var $sampleRelatedTeaser = $this.find('.horizontal-carousel ul li:first');
        		var widthOfRelatedTeaser = $sampleRelatedTeaser.outerWidth(true);
        		var windowWidth = $this.parent().width();
        		el.numToShow =  $this.find('.horizontal-carousel ul').data('columns') ? $this.find('.horizontal-carousel ul').data('columns') : el.windowWidth / widthOfRelatedTeaser;
        		el.numToShow = Math.round(el.numToShow);
        	});
        },
 
        enableHorizontalCarousel: function(el, opts) {

            var $this = $(el.element);
           
            var that = this;
            
            $this.find('.horizontal-carousel ul').removeClass('large-block-grid-4 small-block-grid-2');
						
            $this.find('.horizontal-carousel').jCarouselLite({
                responsive: true,
                visible: el.numToShow,
                init: that.initCarouselCallback,
                mouseWheel: false,
                speed: 600,
                easing: "easeOutCubic",
                swipe: true,
            }).css('width', that.windowWidth );

            $this.on('refreshCarousel.jc', function(e) {
                $(e.target).css('width', that.windowWidth );
            });

        },

        initCarouselCallback: function(opts, $lis) {

            var elementPrev = $(this).siblings('.control.prev');
            var elementNext = $(this).siblings('.control.next');
            var $carousel = $(this);

            elementPrev.on('click', function() {
                $carousel.trigger('go', '-=1');
                return false;
            });

            elementNext.on('click', function() {
                $carousel.trigger('go', '+=1');
                return false;
            });

        },

    };

    $.fn[pluginName] = function(options) {

        return this.each(function() {
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName, new Plugin(this, options));
            }
        });

    };

})(jQuery, window, document);