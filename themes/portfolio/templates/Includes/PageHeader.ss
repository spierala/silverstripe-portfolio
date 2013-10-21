<header class="page-header content">
    <div class="date-location">
        <span class="person-name">$AuthorName</span>
        <% if $Date %> | <time datetime="$Date" pubdate="pubdate">$Date.FormatI18N("%d.%m.%Y")</time><% end_if %>
        <% if $Location %> | <a href="/location/$Location.Slug"><span class="locality">$Location.Name</span></a><% end_if %>
    </div>
    <h1 class="title">$Title</h1>
    <% if Subtitle %><h5 class="title-2">$Subtitle</h5><% end_if%>
</header>