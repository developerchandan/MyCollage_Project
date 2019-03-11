
/*
*   jQuery.stickyPanel
*   ----------------------
*   version: 1.4.1
*   date: 7/21/11
*
*   Copyright (c) 2011 Donny Velazquez
*   http://donnyvblog.blogspot.com/
*   http://code.google.com/p/sticky-panel/
*
*   Licensed under the Apache License 2.0
*
*/
(function ($) {

    $.fn.stickyPanel = function (options) {

        var options = $.extend({}, $.fn.stickyPanel.defaults, options);

        return this.each(function () {
            $(window).bind("scroll.stickyPanel", { selected: $(this), options: options }, Scroll);
        });

    };

    function Scroll(event) {

        var node = event.data.selected;
        var o = event.data.options;

        var isMobile = navigator.userAgent.toLowerCase().indexOf('mobile') > 0;

        var windowHeight = $(window).height();
        var nodeHeight = node.outerHeight(true);
        var scrollTop = $(document).scrollTop();

        //MAX
        if(o.donotOverlap){
            var footerTop = $(o.donotOverlap).offset().top;
            var footerHeight = $(o.donotOverlap).outerHeight(true);
        }
        //

        // when top of window reaches the top of the panel detach
        if (!isMobile && /** MAX **/ !node.data("PanelsFixed") && /**/
            scrollTop <= $(document).height() - windowHeight && // Fix for rubberband scrolling in Safari on Lion
            scrollTop > node.offset().top - o.topPadding) {

            // topPadding
            var newNodeTop = 0;
            if (o.topPadding != "undefined") {
                newNodeTop = newNodeTop + o.topPadding;
            }

            // get left before adding spacer
            if ( o.leftPos != "undefined" ) {
                var nodeLeft = o.leftPos;
            } else {
                var nodeLeft = node.offset().left;
            }

            // save panels top
            node.data("PanelsTop", node.offset().top - newNodeTop);

            // MOVED: savePanelSpace before afterDetachCSSClass to handle afterDetachCSSClass changing size of node
            // savePanelSpace
            if (o.savePanelSpace == true) {
                var nodeWidth = node.outerWidth(true);
                var nodeCssfloat = node.css("float");
                var nodeCssdisplay = node.css("display");
                var randomNum = Math.ceil(Math.random() * 9999); /* Pick random number between 1 and 9999 */
                node.data("PanelSpaceID", "stickyPanelSpace" + randomNum);
                node.before("<div id='" + node.data("PanelSpaceID") + "' style='width:" + nodeWidth + "px;height:" + nodeHeight + "px;float:" + nodeCssfloat + ";display:" + nodeCssdisplay + ";'>&nbsp;</div>");
            }

            // afterDetachCSSClass
            if (o.afterDetachCSSClass != "") {
                node.addClass(o.afterDetachCSSClass);
            }

            // save inline css
            node.data("Original_Inline_CSS", (!node.attr("style") ? "" : node.attr("style")));

            // detach panel
            node.css({
                "margin": 0,
                "left": nodeLeft,
                "top": newNodeTop,
                "position": "fixed"
            });

            //MAX
            node.data("PanelsFixed", true);
            //console.log("attach");
            //
        }

        //MAX
        if(o.donotOverlap && node.data("PanelsFixed")){
            if(scrollTop + nodeHeight >= footerTop - o.bottomPadding){
                //var footerDownCut = $(document).height() - scrollTop - windowHeight;
                //node.css("top", windowHeight - (footerHeight - footerDownCut) - o.bottomPadding - nodeHeight);
                node.css("top", footerTop - o.bottomPadding - nodeHeight - scrollTop);

                //console.log(footerTop - o.bottomPadding - nodeHeight);

                //console.log("windowHeight", windowHeight);
                //console.log("footerHeight", footerHeight);
                //console.log("footerDownCut", footerDownCut);
                //console.log("o.bottomPadding", o.bottomPadding);
                //console.log("nodeHeight", nodeHeight);

                //console.log("footer event");
            }else if(o.topPadding){
                node.css("top", o.topPadding);
                //console.log("footer event out");
            }
        }
        //

        // ADDED: css top check to avoid continuous reattachment
        if (scrollTop <= node.data("PanelsTop") && node.css("top") != "auto") {

            if (o.savePanelSpace == true) {
                $("#" + node.data("PanelSpaceID")).remove();
            }

            // attach panel
            node.attr("style", node.data("Original_Inline_CSS"));

            if (o.afterDetachCSSClass != "") {
                node.removeClass(o.afterDetachCSSClass);
            }

            //MAX
            node.data("PanelsFixed", false);
            //console.log("deattach");
            //
        }
    };

    $.fn.stickyPanel.defaults = {
        topPadding: 0,
        // Use this to set the top margin of the detached panel.
        bottomPadding: 0,

        afterDetachCSSClass: "",
        // This class is applied when the panel detaches.

        savePanelSpace: false
        // When set to true the space where the panel was is kept open.
    };

})(jQuery);
