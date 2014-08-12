<% if Locales %>
    <div class="attribute-box locales">
        <h5 class="title"><%t General.Languages "Artikel Sprachen" %>:</h5>
        <nav class="locale-menu">
            <ul>
                <% loop Locales %>
                    <% if $LinkingMode != 'invalid' %>
                        <li class="list-item $LinkingMode">
                            <a href="$Link.ATT" <% if $LinkingMode != 'invalid' %>rel="alternate" hreflang="$LocaleRFC1766"<% end_if %>>$LanguageNative</a>
                        </li>
                    <% end_if %>
                <% end_loop %>
            </ul>
        </nav>
    </div>
<% end_if %>