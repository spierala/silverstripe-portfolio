<!DOCTYPE html>
<html lang="$ContentLocale">
    <head>
        <% base_tag %>
        <title><% if MetaTitle %>$MetaTitle<% else %>$Title<% end_if %> $SiteConfig.Title</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;">
        <meta name="description" content="$MetaDescription" />

        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,400italic' rel='stylesheet' type='text/css'>
        <link rel="shortcut icon" href="$ThemeDir/images/favicon.ico" />

        <!--[if lt IE 9]>
        <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <script src="http://code.jquery.com/jquery-1.8.1.min.js"></script>

        <script type="text/javascript">
            var pageTitle = '$SiteConfig().Title';

            $(document).ready(function(){
                $('.navigation-responsive').bind('change', function(){
                    document.location.href = $(this).find('option:selected').data('href');
                });
            });
        </script>

        <% require themedCSS("layout") %>
        <% require themedCSS("typography") %>

        <% require css("themes/portfolio/javascript/lib/fancybox/jquery.fancybox.css") %>
        <% require css("themes/portfolio/javascript/lib/jScrollPane/jquery.jscrollpane.css") %>
        <% require javascript("themes/portfolio/javascript/lib/jScrollPane/jquery.jscrollpane.min.js") %>
        <% require javascript("themes/portfolio/javascript/lib/fancybox/jquery.fancybox.pack.js") %>
    </head>
    <body class="$ClassName">
        <div class="main">
            <% include SideBar %>
            <% include Header %>
            <div class="layout">
                $Layout
            </div>
            <nav class="mobile-contact">
                <% include FooterContent %>
            </nav>
        </div>
    </body>
</html>