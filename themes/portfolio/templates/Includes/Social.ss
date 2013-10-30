<% if ShowSocial %>
    <div class="attribute-box social">
        <h5 class="title">I like:</h5>
        <div class="actions">
            <a class="icon-fb icon" href="http://www.facebook.com/sharer.php?u=$FacebookLink" target="_blank" title="Post on Facebook...">Facebook</a>
            <a class="icon-ilike icon" onclick="$('#counter-result span').load('$IlikeLink'); return false;" title="I like...">I like</a>
            <div id="counter-result" class="item counter-result"><span>$Count</span></div>
        </div>
    </div>
<% end_if %>