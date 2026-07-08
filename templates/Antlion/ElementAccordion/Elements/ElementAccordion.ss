<% if $Title && $ShowTitle %>
    <% with $HeadingTag %>
        <{$Me} class="element-title">$Up.Title.XML</{$Me}>
    <% end_with %>
<% end_if %>
<% if $Content %><div class="element-content">$Content</div><% end_if %>

<% if $Panels %>
    <ul id="accordion-{$ID}" class="accordion <% if $ExtraClass %> $ExtraClass<% end_if %>" data-accordion>
        <% loop $Panels %>
            <li class="accordion-item" data-accordion-item>
                <a href="#" class="accordion-title <% if $isFirst %>is-active<% end_if %>">$Title</a>
                <div class="accordion-content" data-tab-content>
                    <div class="grid-x grid-margin-x grid-margin-y">
                        <% if $Image %>
                            <div class="cell large-2">
                                <img src="$Image.URL" class="img-responsive" alt="$Title.ATT">
                            </div>
                        <% end_if %>
                        <div class="cell auto">
                            $Content
                            <% if $Links.Exists %>
                            <div class="button-group <% if $Align == 'center' %>align-center<% else_if $Align == 'right' %>align-right<% else %>align-left<% end_if %>">
                                    <% loop $Links %>
                                    <a class="button $CssClass $ExtraClass" href="$URL" <% if $OpenInNew %>target="_blank" rel="noopener noreferrer"<% end_if %>>$Title.XML</a>
                                    <% end_loop %>
                                </div>
                            <% end_if %>
                        </div>
                    </div>
                </div>
            </li>
        <% end_loop %>
    </ul>
<% end_if %>