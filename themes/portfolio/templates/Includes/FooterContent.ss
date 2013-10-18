<% if FooterPages %>
    <% loop FooterPages %>
        <a href="$Link">$Title</a>
    <% end_loop %>
    <br/>
<% end_if %>
<span class="text">Copyright &copy; $CurrentYear $SiteConfig.Title</span>