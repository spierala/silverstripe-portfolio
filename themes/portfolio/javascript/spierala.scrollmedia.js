var ScrollMedia = {
    scrollPaneApi: null,
    init: function() {
        //init scrollpane
        var pane =  $('.scroll-pane').jScrollPane();
        pane.jScrollPane();
        ScrollMedia.scrollPaneApi = pane.data('jsp');

        //handle scrollpane resizing
        $(window).bind(
            'resize',
            function(){
                if ($.browser.msie) {
                    var throttleTimeout;
                    // IE fires multiple resize events while you are dragging the browser window which
                    // causes it to crash if you try to update the scrollpane on every one. So we need
                    // to throttle it to fire a maximum of once every 50 milliseconds...
                    if (!throttleTimeout) {
                        throttleTimeout = setTimeout(
                            function()
                            {
                                ScrollMedia.scrollPaneApi.reinitialise();
                                throttleTimeout = null;
                            },
                            50
                        );
                    }
                } else {
                    ScrollMedia.scrollPaneApi.reinitialise();
                }
            }
        );

        // init fancybox
        $(".fancybox").fancybox({padding: 0});
    }
}