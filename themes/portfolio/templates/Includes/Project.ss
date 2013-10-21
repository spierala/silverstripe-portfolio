<a class="projects-page--project isotope<% if knockout %> knockout<% end_if %>" data-pageid="$ID" data-categories='[$CategoriesDataAttribute]' data-absolutelink="$AbsoluteLink" href="$Link" title="$Title.XML" rel="address:/?page=$ID">
    <article class="project-content">
        $FirstFolderImage.SetHeight(270)
        <div class="project-preview-text">
            <h2 class="project-title">$MenuTitle.XML</h2>
            <p class="project-text">
                <% if Excerpt %>
                    $Excerpt
                <% else %>
                    $Content.LimitWordCount(17)
                <% end_if %>
            </p>
        </div>
    </article>
</a>     