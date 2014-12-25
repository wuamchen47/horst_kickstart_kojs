<div class="col_12">
	<h1 class="center"><img src="css/img/horstlogo.png"/></h1>
	    <?php
            $lgn = $_SERVER['DOCUMENT_ROOT'] . "/" . SITE . "/includes/inc_login_form.php";
            
            if (login_check($mysqli) == true) {
                echo "<a data-bind='click: logout'>Logout</a>";
                echo "<a data-bind='click: loadPost'>Post</a>";
            } else {
                require($lgn);
            }
        ?>
</div>
