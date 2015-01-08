<div data-bind="visible: showPostForm" class="col_12 transp07">
    <form data-bind="submit: processPost">
         <input type="checkbox" data-bind="checked: postPrivate"/>
        Nur für Horsts!
        <i class="icon-lock icon-large"></i>
        <textarea data-bind="value: postText"></textarea>
        <div class="col_12">
            <input type="textbox" data-bind="value: postLink" size="47" maxlength="500"/>
        </div>
        <button type="submit">Submit</button>
    </form>
</div>