<div class="col_12">
	<h1 class="center"><img src="css/img/horstlogo.png"/></h1>
	<h4 style="color:#999;margin-bottom:40px;" class="center">
        <?php    
            if (login_check($mysqli) == true) {
                echo "<a data-bind='attr: { href: logoutUrl}'>Logout</a>";
            }
        ?>
    </h4>
</div>
