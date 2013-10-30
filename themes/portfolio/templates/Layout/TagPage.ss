<div class="tag-page content-container white-bg">
    <article>
        <% include PageHeader %>
        <div class="content typography left-col">
            $Content
            <% if Links %>
                <h5>Related Links:</h5>
                <ul class="tag-links">
                    <% loop Links %>
                        <li class="tag-link"><a target="_blank" title="Go to $Name" href="$URL">$Name</a></li>
                    <% end_loop %>
                </ul>
            <% end_if %>
        </div>
    </article>
    <aside class="more-info-box">
        <div class="attribute-box projects">
            <h5 class="title">$Title Projects:</h5>
            <ul class="list">
                <% loop ProjectPages %>
                <li class="list-item"><a href="$Link" title="Show Project: $Title">$Title</a></li>
                <% end_loop %>
            </ul>
        </div>
        <% include Social %>
    </aside>
</div>