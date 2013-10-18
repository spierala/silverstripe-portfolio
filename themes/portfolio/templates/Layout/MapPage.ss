<% require javascript("themes/portfolio/javascript/MapPage.js") %>
<script src="$Key"></script>
<script type="text/javascript">
    $(document).ready(function() {
        initialize('$Location');
    });
</script>

<div id="map-page" class="content-container">
	<article>
        <div class="page-header content">
            <h1>Current Location</h1>
            <h5 class="subheader">$LocationLabel</h5>
        </div>
        <div class="map-container">
            <div id="map_canvas"></div>
        </div>
	</article>
</div>
