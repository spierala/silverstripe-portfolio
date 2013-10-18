<form $FormAttributes>
    <div class="form-container" data-visible="true">
        <fieldset>
            <label for="{$FormName}_Name" class="input">Name:<span class="red">*</span></label>
            $Fields.FieldByName(Name) 
            <label for="{$FormName}_Email" class="input">E-Mail:<span class="red">*</span></label>
            $Fields.FieldByName(Email) 
            <label for="{$FormName}_URL" class="input">URL:</label>
            $Fields.FieldByName(URL) 
            <label for="{$FormName}_Comment" class="input">Comment:<span class="red">*</span></label>
            $Fields.FieldByName(Comment) 
            <div class="message-to">
                <label for="Message" class="input">Message:<span class="red">*</span></label>
                <textarea name="Message"></textarea>
            </div>
            $Fields.FieldByName(SecurityID)
        </fieldset>
        <span class="red mandatory">* Required</span>
        <% if Actions %>
        <div class="Actions">
            <% loop Actions %>$Field<% end_loop %>
        </div>
        <% end_if %>
    </div>
</form>