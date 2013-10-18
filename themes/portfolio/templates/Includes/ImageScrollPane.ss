<% if FolderImages %>
    <div class="scroll-pane">
        <div class="images-bg">
            <div class="animation-container">
                <div class="images-container">
                    <div class="images">
                        <% loop FolderImages %><a href="$Link" title="$Image.Title" class="fancybox image" rel="gallery">$SetHeight(240) </a><% end_loop %>
                    </div>
                </div>
            </div>
        </div>
    </div>
<% end_if %>