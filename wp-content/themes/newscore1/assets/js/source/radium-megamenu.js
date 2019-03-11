/** -----------------------------------------------------
 * Radium Mega Menu
 * http://radiumthemes.com
 * Franklin Gitonga
 *
 * ver 1.3.2
 /* ----------------------------------------------------- */

;( function( $, window, undefined ) {

    'use strict';

    // global
    var Modernizr = window.Modernizr,
        $body = $('body');

    $.Radium_Megamenu = function( options, element ) {
        this.$elem = $( element );
        this._init( options );
    };

    // the options
    $.Radium_Megamenu.defaults = {
        position: true,
        sensitivity: 2, // number = sensitivity threshold (must be 1 or higher)
        interval: 100, // number = milliseconds for onMouseOver polling interval
        timeout: 500, // number = milliseconds delay before onMouseOut
        container: '#theme-wrapper-inner', //menu container - used to calculate drop down position - use class or id,
        even_spacing: false, //space first level items evenly
    };

    $.Radium_Megamenu.prototype = {

        _init: function(options, elem) {

            var self        = this;

            // options
            self.options = $.extend( true, {}, $.Radium_Megamenu.defaults, options );

            // cache some elements and initialize some variables
            self._config();

            self.elem   = elem;

            if( self.descriptions.length ) { self.$elem.addClass('menu-has-desc'); }

            self._firstLevelMenuItems();
            self._dropDownItems();

            if( self.options.even_spacing === 'true' ) { self._evenSpace(); } //run after menu hax initialised

            self._initEvents();

        },

        _config : function() {

            this.open = false;
            this.menuItems              = this.$elem.find(">li");
            this.megaItems              = this.menuItems.find(">div").parent();
            this.dropdownItems          = this.menuItems.find(">ul").parent();
            this.parentContainerWidth   = this.$elem.parent().width();
            this.descriptions           = this.$elem.find('.menu-desc');

        },

        _initEvents: function () {

            var self = this;

			// listen for evenSpacing, call teardown
			self.$elem.on("evenSpacing", $.proxy(self.evenSpace, self));

            // listen for destroyed, call teardown
            self.$elem.on("destroyed", $.proxy(self.teardown, self));

            $(window).resize(function() {
                self._resize();
            });

        },

        _firstLevelMenuItems: function () {

            var self = this;

            self.menuItems.each(function() {

                var item = $(this),
                    megaDiv = item.find("div:first"),
                    normalDropdown = item.find('>a');

                //check if we got a mega menu
                if( !megaDiv.length ) {
                	normalDropdown = item.find(">ul");
                }

                //if we got a mega menu or dropdown menu add the arrow beside the menu item
                if( megaDiv.length || normalDropdown.length ) {

                    var link = item.addClass('has-submenu').find('>a');

                    if ( !link.find('span').hasClass('submenu-link') ) {

                        link.html("<span class='submenu-link'>"+link.html()+"</span>");
                        link.find('.submenu-link').append('<span class="submenu-indicator"></span>');

                        //is a mega menu main item doesn't have a link to click use the default cursor
                        if(typeof link.attr('href') !== 'string'){ link.css('cursor', 'default'); }

                    }

                }

            });

        },

        _dropDownItems: function () {

            var self = this;

            // bind events for normal dropdown menus
            self.dropdownItems.find('li').andSelf().each(function() {

                var currentItem = $(this),
                    sublist = currentItem.find('ul:first'),
                    showList = false;

                if(sublist.length) {

                    sublist.removeClass('open');

                    var currentLink = currentItem.find('>a');

                    if ( currentLink.hasClass('has-icon') ) {
                    	currentLink.siblings('ul').addClass('parent-has-icon');
                    }

                    var menuConfig2 = {
                        sensitivity: self.options.sensitivity,
                        interval: self.options.interval,
                        timeout: self.options.timeout,
                        over: function() {
                            sublist.stop().addClass('open');
                            currentLink.addClass('open-sub-a');

                            //correct position of dropdown
                            if(self.options.position && sublist.length) {
                                self.getPostion(sublist);
                            }

                        },
                        out: function() {
                            sublist.stop().removeClass('open');
                            currentLink.removeClass('open-sub-a');
                        }
                    };

                    $(this).hoverIntent(menuConfig2);

                    //correct position of dropdown
                    if(self.options.position && currentItem.length) {

                        self.setPostion(currentItem);

                    }

                }

            }); //bind

            //bind event for mega menu
            self.megaItems.each(function(i) {

                var Item = $(this),
                    sublist = Item.find('div>ul>li>ul');

                sublist.removeClass('sub-menu');

                var menuConfig = {
                    sensitivity: self.options.sensitivity,
                    interval: self.options.interval,
                    timeout: self.options.timeout,
                    over: function() { self.megaDivShow(i); },
                    out: function() { self.megaDivHide(i); }
                 };

                $(this).hoverIntent(menuConfig);

                //correct position of dropdown
                if(self.options.position && Item.length) {

                    self.setPostion(Item);

                }

            });


        },

        megaDivShow : function (i) {

            var self = this;

            var Item = self.megaItems.filter(':eq('+i+')').find("div:first"),
                link = self.megaItems.filter(':eq('+i+')').find("a:first");

            self.megaItems.filter(':eq('+i+')').find(">.radium-mega-div").addClass('open');

            if(Item.length) {
                link.addClass('open-mega-a');
            }

            //correct position of dropdown
            if(self.options.position && Item.length) {
                self.getPostion(Item);
            }

        },

         setPostion : function(item) {

            var self = this,
                $container_width = 0,
                $item_width = 0,
                $item_pos = 0;

            $container_width = item.closest(self.options.container).width();

            if (item) {
                $item_width = item.width();
                $item_pos = item.show().offset();
            }

            item.parent().one("mouseenter", function() {

                item.attr('data-pos', Math.floor($item_pos.left));

            }); //we want to fire this once on hover, reset on resize and fire once again

        },

        //does nothing more than add a class in reference to position
        getPostion : function(item) {

            var self = this,
                $container_width = item.closest(self.options.container).width(),
                $item_pos = parseInt(item.parent().attr('data-pos'), 10),
                $item_width = parseInt(item.width(), 10);

            if ( $item_pos + $item_width > $container_width ) {

                item.removeClass('position-right').addClass('position-left');

            } else {

                item.removeClass('position-left').addClass('position-right');

            }

        },

        _resize : function () {

            var self = this;

        },

        megaDivHide : function (i) {

            var self = this;

            self.megaItems.filter(':eq('+i+')').find(">.radium-mega-div").removeClass('open');
            self.megaItems.filter(':eq('+i+')').find(">a").removeClass('open-mega-a');

            var listItem = self.megaItems.filter(':eq('+i+')'),
                item = listItem.find("div:first");

        },

        evenSpace: function () {

            var self = this;
			
			function runEvenSpacing() {
            	self.$elem.off("evenSpacing", self._evenSpace);
            	self._evenSpace();
            }
            
			window.setTimeout( runEvenSpacing, 50 ); //before running even spacng (attempting to make it more reliable)

        },

        _evenSpace: function () {

			var self = this;

			// Get the widths
			var realWidth = 0,
				defualtPadding = 10, //parseInt(self.menuItems.find('>a').css('padding-left'), 10),
				containerWidth = self.$elem.width();

			// calculate elements widths minus padding etc
			self.menuItems.andSelf().each(function() {

				realWidth += $(this).find('>a').width();

			});

			// Count the number of nav items
			var navCount = self.menuItems.length;

			// Calculate leftover width available for padding
			var leftoverWidth = containerWidth - realWidth;

			// Divide leftover width amongst menu items to get padding
			var padding = ( Math.floor( leftoverWidth / (navCount * 2) ) );

			//determine if padding will cause items to overflow
			var newWidth = (padding * (navCount * 2)) + realWidth ;

			if ( (newWidth < containerWidth) && (padding > defualtPadding) ) {

				// add class to first level menu links
			    self.menuItems.andSelf().each(function() {

			    	$(this).find('>a').css({
			    	  paddingLeft : padding,
			    	  paddingRight: padding
			    	});

			    });

                // adjust positions
                self.dropdownItems.find('li').andSelf().each(function() {

                    var currentItem = $(this),
                        sublist = currentItem.find('ul:first');

                    //correct position of dropdown
                    if(self.options.position && currentItem.length) {

                        self.setPostion(currentItem);

                    }

                });

                //bind event for mega menu
                self.megaItems.each(function(i) {

                    var Item = $(this),
                        sublist = Item.find('div>ul>li>ul');

                    //correct position of dropdown
                    if(self.options.position && Item.length) {

                        self.setPostion(Item);

                    }

                });


		    }

        },

        destroy: function () {

            var self = this;

            self.$elem.off("destroyed", self.teardown);
            self.teardown();

        },

        teardown: function () {

            var self = this;

            // roll back changes
            self.menuItems.each(function() {

                var item = $(this),
                    pos = item.position(),
                    megaDiv = item.find("div:first"),
                    normalDropdown = "";

                //check if we got a mega menu
                if(!megaDiv.length) {
                    normalDropdown = item.find(">ul");
                }

                //if we got a mega menu or dropdown menu add the arrow beside the menu item
                if(megaDiv.length || normalDropdown.length) {

                    var link = item.removeClass('has-submenu').find('>a');

                    //link.find('.submenu-indicator').remove().end().find('>span').replaceWith( link.text() );

                }

                //correct position of mega menus
                if(self.options.position && item.length) {
                    item.removeClass('position-left').removeClass('position-right');
                }

                // reverse space nav
                self.menuItems.andSelf().each(function() {

                	$(this).find('>a').removeAttr('style');

                });

            });

            // bind events for normal dropdown menus
            self.dropdownItems.find('li').andSelf().each(function() {

                var $ul = $(this).find('ul');

                $ul.removeClass('open');

                // unbind the hoverIntent
                $ul.unbind("mouseenter").unbind("mouseleave");
                $ul.removeProp('hoverIntent_t');
                $ul.removeProp('hoverIntent_s');
                // rebind the hoverIntent

            }); //bind

            this.$elem.removeData();
            this.$elem = null;
        }

    };

    var logError = function( message ) {
        if ( window.console ) {
            window.console.error( message );
        }
    };

    $.fn.radiumMegamenu = function( options ) {

        if ( typeof options === 'string' ) {

            var args = Array.prototype.slice.call( arguments, 1 );

            this.each(function() {

                var instance = $.data( this, 'radium-megamenu' );

                if ( !instance ) {
                    logError( "cannot call methods on radium-megamenu prior to initialization; " + "attempted to call method '" + options + "'" );
                    return;
                }

                if ( !$.isFunction( instance[options] ) || options.charAt(0) === "_" ) {
                    logError( "no such method '" + options + "' for radium-megamenu instance" );
                    return;
                }

                instance[ options ].apply( instance, args );

            });

        } else {

            this.each(function() {

                var instance = $.data( this, 'radium-megamenu' );

                if ( instance ) {
                    instance._init();
                } else {
                    instance = $.data( this, 'radium-megamenu', new $.Radium_Megamenu( options, this ) );
                }

            });
        }

        return this;

    };

})( jQuery, window );