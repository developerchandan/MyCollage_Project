/** Sticky sidebar */
(function ($) {

    function Radium_Sideshare() {

        this.elems = {
            share_selector  : jQuery('#post-side-share-left'),
            window          : jQuery(window),
            container       : jQuery('#theme-wrapper-inner'),
            header          : jQuery('#header'),
            donotOverlap    : 'main footer'
        };

        var elems = this.elems;

        if ( !elems.share_selector.is('*') ) return;

        var panel_loc = elems.container.offset();
        var scroll_pos_left = panel_loc.left - elems.share_selector.width();
        var window_height = elems.window.height();

        elems.share_selector.stickyPanel({
            leftPos: scroll_pos_left,
            topPadding: 120,
            bottomPadding: 20,
            savePanelSpace: false,
            donotOverlap: elems.donotOverlap
         });

        this.ready();

    }

    Radium_Sideshare.prototype.ready = function () {

        var me = this;

        me.show();

        me.elems.window.on("scroll", function(){
            me.show();
        });

        me.elems.window.on("resize", function(){
            me.show();
        });

    };

    Radium_Sideshare.prototype.show = function () {

        var elems = this.elems;

        var window_scroll_y = elems.window.scrollTop();
        var window_height   = elems.window.height();
        var window_width    = elems.window.width();

        clearTimeout(window.__topTimeout);

        window.__topTimeout = setTimeout(function(){

            var share_selector = elems.share_selector;
            var panel_loc = elems.container.offset();
            var target_top_pos = elems.header.offset();
            var scroll_pos_top = target_top_pos.top;
            var panel_pos_x = panel_loc.left - share_selector.width() - 20;

            share_selector.css('left', panel_pos_x + 'px');

            if( window_width > 1100){

                if ( window_scroll_y > scroll_pos_top && !share_selector.is(":visible") ) {

                    share_selector.stop().fadeIn('fast');

                } else if ( window_scroll_y > scroll_pos_top && share_selector.is(":visible") ) {
                   
                    // do nothing
                    
                } else {

                    if ( share_selector.is(":visible") ) {
                        share_selector.stop().fadeOut('fast');
                    }
                    
                }

            } else {

                if ( share_selector.is(":visible") ) {
                    share_selector.stop().fadeOut('fast');
                }

            }

        }, 5);
    };

    $(document).ready(function () {
        if( window.radium_framework_globals.share_posts_js === "true") { new Radium_Sideshare(); }
    });

})(jQuery);