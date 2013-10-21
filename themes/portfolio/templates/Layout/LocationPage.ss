<% require javascript("themes/portfolio/javascript/MapPage.js") %>
<script src="$Key"></script>
<script type="text/javascript">
    $(document).ready(function() {
        initialize($Lat, $Lng);
    });
</script>

<div id="map-page" class="content-container">
	<article>
        <div class="page-header content">
            <h1 class="title">$Location</h1>
            <% if Subtitle %><h5 class="title-2">$Subtitle</h5><% end_if %>
        </div>
        <div class="map-container">
            <div id="map_canvas"></div>
        </div>
	</article>
</div>
