<div class="col_12">
	<h1 class="center"><img src="css/img/horstlogo.png"/></h1>
	    <?php
            
            if (login_check($mysqli) == true) {
                echo "<button data-bind='click: logout' class='large red pull-right'><i class='icon-signout'></i></button>";
                echo "<button data-bind='click: togglePost' class='large orange pull-left'><i class='icon-comments'></i></button>";
                $postForm = $_SERVER['DOCUMENT_ROOT'] . "/" . SITE . "/includes/inc_post_form.php";
                require($postForm);
            } else {
                $lgn = $_SERVER['DOCUMENT_ROOT'] . "/" . SITE . "/includes/inc_login_form.php";
                require($lgn);
            }
        ?>
</div>
