<% require javascript("themes/portfolio/javascript/lib/validate/jquery.validate.min.js") %>
<% require javascript("themes/portfolio/javascript/BlogEntry.js") %>

<% cached 'database', LastEdited %>
<div class="blogentry-page content-container white-bg">
    <article>
        <% include PageHeader %>
        <% include ImageScrollPane %>
        <div class="left-col content typography">
            $Content
            <div class="comments form">
                <% if ApprovedComments %>
                    <h5 class="comments-header">Comments ($ApprovedComments.Count)</h5>
                    <div class="commentsList">
                        <% loop ApprovedComments %>
                            <div class="comment">
                                <div class="date-location">
                                    <% if Name %><span class="person-name">$Name</span> | <% end_if %>
                                    <span class="date">$Created.FormatI18N("%d.%m.%Y")</span>
                                    <% if URL %> | <span class="url"><a target="_blank" href="http://$URL">$URL</a></span> <% end_if %>
                                </div>
                                <p>$NiceComment</p>
                            </div>
                        <% end_loop %>
                    </div>
                <% end_if %>
                <h5>Write Comment</h5>
                <% uncached %>
                    $CustomMessage
                    $CommentForm
                <% end_uncached %>
            </div>
        </div>
    </article>
    <aside class="more-info-box">
        <% include Tags %>
        <% uncached %>
            <% include Social %>
        <% end_uncached %>
    </aside>
    <div class="page-navigation">
        <% if previousPager %>
            <a class="btn-prev" href="$previousPager.URLSegment" title="Go to page $previousPager.Title">Previous Entry</a>
        <% end_if %>
        <a class="btn-all" href="$Parent.URLSegment" title="Show all">All Blog-Entries</a>
        <% if nextPager %>
            <a class="btn-next" href="$nextPager.URLSegment" title="Go to page $nextPager.Title">Next Entry</a>
        <% end_if %>
    </div>
</div>
<% end_cached %>