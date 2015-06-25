<div class="col_12">
  <div class="col_6">
    <?php
      $logo = $_SERVER['DOCUMENT_ROOT'] . "/" . SITE . "/css/img/horstlogo.php";
      require($logo);
    ?>
  </div>
  <div class="col_6">
  <?php if (login_check($mysqli) == true) {  ?>
          <button data-bind='click: logout' class='large red pull-right'><i class='fa fa-sign-out'></i></button>
          <button data-bind='click: togglePost' class='large orange pull-left'><i class='fa fa-comments'>&nbsp;<?php echo GetUserName(); ?></i></button>
  <?php } ?>
  </div>
</div>
<div class="col_12">
  <?php if (login_check($mysqli) == true) {
          $postForm = $_SERVER['DOCUMENT_ROOT'] . "/" . SITE . "/includes/inc_post_form.php";
          require($postForm);
        }
        else {
          $lgn = $_SERVER['DOCUMENT_ROOT'] . "/" . SITE . "/includes/inc_login_form.php";
          require($lgn);
        }
  ?>
</div>

 