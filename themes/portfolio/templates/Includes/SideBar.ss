<div class="sidebar">
    <aside>  
        <div class="about">
            <a href="$BaseHref">
                $SiteConfig.TitleImage.SetWidth(88)
            </a>
            <h3 class="tagline">$SiteConfig.Tagline.RAW</h3>
            <a href="#navMain" class="mobile-nav-open"></a>
            <nav class="mobile-nav">
                <ul id="navMain">
                    <% loop $Menu(1) %>
                    <li class="list-item $LinkingMode"><a href="$Link">$MenuTitle</a></li>
                    <% end_loop %>
                </ul>
            </nav>
        </div>
        <nav class="navigation-main">
            <ul>
                <% loop Menu(1) %>
                <li class="$LinkingMode">
                    <a href="$Link" class="$LinkingMode <% if ClassName == 'ProjectsPage' %>category-link<% end_if %>" <% if ClassName == 'ProjectsPage' %> data-name="All" data-slug="all" rel="address:/?category=all" <% end_if %>>$MenuTitle.XML</a>
                    <% if Children %>
                        <ul class="level-2">
                            <% if ClassName == 'ProjectsPage' %>
                                <% if $Top.SectionProjectCategory || LinkOrSection = section %>
                                    <% loop $Top.AllPageCategories %>
                                        <li class="$LinkingMode"><a class="category-link" data-name="$Name" data-slug="$Slug" href="category/$Slug" rel="address:/?category=$Slug">$Name [$NumOfProjects]</a></li>
                                    <% end_loop %>
                                <% end_if %>
                            <% else_if ClassName == 'BlogEntries' %>
                                <% if $Top.SectionBlogCategory || LinkOrSection = section %>
                                    <% loop $Top.AllBlogCategories %>
                                        <% if BlogEntries %>
                                        <li class="$LinkingMode"><a href="blog-category/$Slug">$Name [$getNumOfEntries]</a></li>
                                        <% end_if %>
                                        <% end_loop %>
                                <% end_if %>
                            <% else %>
                                <% if LinkOrSection = section %>
                                    <% loop Children %>
                                        <li class="$LinkingMode"><a href="$Link">$MenuTitle.XML</a></li>
                                    <% end_loop %>
                                <% end_if %>
                            <% end_if %>
                        </ul>
                    <% end_if %>
                </li>
                <% end_loop %>
            </ul>
        </nav>        
        <nav class="navigation-bottom">
            <% include FooterContent %>
        </nav>
    </aside>
    <div class="top-deco"></div>
    <div class="bottom-deco"></div>
</div>
