var ProjectPage = {
    scrollPaneApi: null,
    initProjectPage: function(){
        var pane =  $('.scroll-pane').jScrollPane();
        pane.jScrollPane();
        ProjectPage.scrollPaneApi = pane.data('jsp');   
        $(".fancybox").fancybox({padding: 0});
        
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
                                ProjectPage.scrollPaneApi.reinitialise();
                                throttleTimeout = null;
                            },
                            50
                        );
                    }
                } else {
                    ProjectPage.scrollPaneApi.reinitialise();
                }
            }
        )
    }
}