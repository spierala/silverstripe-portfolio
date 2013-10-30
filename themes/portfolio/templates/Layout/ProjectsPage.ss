<% require javascript("themes/portfolio/javascript/lib/jquery.address-1.4.min.js") %>
<% require javascript("themes/portfolio/javascript/spierala.isotope.js") %>
<% require javascript("themes/portfolio/javascript/spierala.projectspage.js") %>

<h1 class="projects-page--title">$Title</h1>
<div id="projects-page--ajax"></div>
<div class="projects-page--projects isotope-holder">
    <div class="projects-page--projects-container isotope-container">
        <% loop Projects %>
            <% include Project %>
        <% end_loop %>
        <% if OtherProjects %>
            <% loop OtherProjects %>
                <% include Project %>
            <% end_loop %>
        <% end_if %>
    </div>
</div>
