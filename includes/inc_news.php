<div data-bind="foreach: news">
    <div class="col_12 transp07">
        <div class="col_12">
            <span data-bind="html: imgavatar"></span>
            <span class="horstName" data-bind="text: name"></span>&nbsp;<span data-bind="html: lockIcon"></span></br>
            <span class="horstTime" data-bind="text: fulldate"></span> | <span class="horstTime" data-bind="text: t"></span>
            <button class="small"><i class="fa fa-edit"></i>edit</button>
        </div>
        <div class="col_12">
            <blockquote class="small" data-bind="html: comment"></blockquote>
        </div>
    </div>
</div>
<?php 
  if (login_check($mysqli) == true) {
    echo("<div data-bind='scroll: news().length < 470, scrollOptions: { loadFunc: loadNews, offset: 10 }'>loading</div>");
  }
?>