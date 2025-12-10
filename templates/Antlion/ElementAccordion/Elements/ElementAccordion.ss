<div class="cell">
<% if $Title && $ShowTitle %>
    <% with $HeadingTag %>
        <{$Me} class="element-title">$Up.Title.XML</{$Me}>
    <% end_with %>
<% end_if %>
<% if $Content %><div class="element__content">$Content</div><% end_if %>

<% if $Panels %>
    <ul id="accordion-{$ID}" class="accordion" data-accordion>
        <% loop $Panels %>
            <li class="accordion-item" data-accordion-item>
                <a href="#" class="<% if $isFirst %>is-active<% end_if %>"><h3 class="accordion-title" style="margin:0;">$Title</h3></a>
                <div class="accordion-content" data-tab-content>
                    <div class="grid-x grid-margin-x grid-margin-y">
                        <% if $Image %>
                            <div class="cell large-2">
                                <img src="$Image.URL" class="img-responsive" alt="$Title.ATT">
                            </div>
                        <% end_if %>
                        <div class="cell auto">
                            $Content
                        </div>
                    </div>
                </div>            
            </li>
        <% end_loop %>
    </ul>
<% end_if %>
</div>
