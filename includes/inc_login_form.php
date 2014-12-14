<div class="col_12">
<?php
if (isset($_GET['error'])) {
    echo '<p class="error">Error Logging In!</p>';
}
?> 
    next todo: form asynchron bauen
    <form action="includes/ajax_process_login.php" method="post" name="login_form">                      
        Email: <input type="text" name="email" />
        Password: <input type="password" 
                        name="password" 
                        id="password"/>
        <input type="button" 
           value="Login" 
           onclick="formhash(this.form, this.form.password);" /> 
    </form>
    <p>If you don't have a login, please <a href="register.php">register</a></p>
    <p>If you are done, please <a href="includes/logout.php">log out</a>.</p>
    <p>You are currently logged <?php echo $logged ?>.</p>
</div>