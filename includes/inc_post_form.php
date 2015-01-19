<div data-bind="visible: showPostForm" class="col_12 transp07">

    <form data-bind="submit: processPost" class="vertical">
      <div class="col_12">
        <input type="checkbox" name="post_from_priv" data-bind="checked: postPrivate"/>
        <label for="post_form_priv" class="inline">Nur für Horsts! <i class="fa fa-lock fa-large"></i></label>
      </div>
      <div class="col_12">
        <textarea data-bind="value: postText"></textarea>
      </div>
      <div class="col_12">
        <button class="small" data-bind="click: toggleSmilies"><i  class='fa fa-smile-o'></i></button>
      </div>
      <div id="lazySmilies" class="col_12" data-bind="visible: showSmilies">
          <?php
          $smile = $_SERVER['DOCUMENT_ROOT'] . "/" . SITE . "/includes/inc_smileySelector_new.php"; 
          require($smile);
          ?>
      </div>
      <div class="col_12">
        <input type="textbox" data-bind="value: postLink" size="47" maxlength="500"/>
        <button type="submit">Submit</button>
      </div>
    </form>
    
    
</div>