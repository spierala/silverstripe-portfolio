<% if Tags %>
    <div class="attribute-box tags">
        <h5 class="title">Tags:</h5>
        <ul class="list">
            <% loop Tags %>
                <li class="list-item">
                    <span class="tag">
                        <% if HasTagPage %><a href="{$BaseHref}tag/$Slug" title="More of $Name..."><% end_if %>
                            <span class="tag-inner">$Name</span>
                        <% if HasTagPage %></a><% end_if %>
                    </span>
                </li>
            <% end_loop %>
        </ul>
    </div>
<% end_if %>