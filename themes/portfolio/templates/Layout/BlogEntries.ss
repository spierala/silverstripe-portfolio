<div class="blogentries-page content-container white-bg">
    <% include PageHeader %>
    <div class="content">
        <% loop Entries %>
            <article class="article typography">
                <div class="more-info">
                    <h5>
                        <% loop BlogCategories %>
                            $Name<% if Last = 0 %>,<% end_if %> 
                        <% end_loop %>
                    </h5>  
                </div>
                <h2 class="heading-1"><a href="$Link" title="$title">$Title</a></h2>
                <p>
                    <% if Excerpt %>
                        $Excerpt
                    <% else %>
                        $Content.LimitWordCount(20)
                    <% end_if %>
                    <a href="$Link" title="$title">Zum Artikel</a>      
                </p>
            </article>            
        <% end_loop %>
    </div>
</div>
