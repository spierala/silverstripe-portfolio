<div class="project-page content-container">
    <article>
        <% include PageHeader %>
        <% include ScrollMedia %>
        <div class="content left-col typography">
            $Content
        </div>
    </article>
    <aside class="more-info-box">
        <% include Tags %>
        <% loop ProjectAttributes %>
            <div class="attribute-box">
                <h5 class="title">$AttributeLabel.Name:</h5> <% if $Url %><a href="$Url" target="_blank">$Value</a><% else %> $Value <% end_if %>
            </div>
        <% end_loop %>
        <% include Social %>
    </aside>
    <a href="$Parent.URLSegment" class="btn-close">close project</a>
    <div class="page-navigation">
        <% if previousPager %>
            <a class="btn-prev" href="$previousPager.URLSegment" title="Go to Page $previousPager.Title" data-absolutelink="$previousPager.AbsoluteLink" data-id="$previousPager.ID">Previous Project</a>
        <% end_if %>
        <a class="btn-all" href="$Parent.URLSegment" title="Show all projects" data-absolutelink="$Parent.AbsoluteLink">All Projects</a>
        <% if nextPager %>
            <a class="btn-next" href="$nextPager.URLSegment" title="Go to Page $nextPager.Title" data-absolutelink="$nextPager.AbsoluteLink" data-id="$nextPager.ID">Next Project</a>
        <% end_if %>
    </div>
</div>
