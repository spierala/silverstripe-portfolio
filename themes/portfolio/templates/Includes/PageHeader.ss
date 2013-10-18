<header class="page-header content">
    <div class="date-location">
        <span class="person-name">$AuthorName</span>
        <% if $Date %> | <time datetime="$Date" pubdate="pubdate">$Date.FormatI18N("%d.%m.%Y")</time><% end_if %>
        <% if $Location %> | <span class="locality">$Location</span><% end_if %>
    </div>
    <h1 class="title">$Title</h1>
    <% if Subtitle %><h5 class="title-2">$Subtitle</h5><% end_if%>
</header>