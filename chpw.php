<?php
error_reporting(E_ALL);
include_once ($_SERVER['DOCUMENT_ROOT'] . "/../_globals/cfg_other.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . "/" . SITE . "/includes/db_connect.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . "/" . SITE . "/includes/functions.php");

sec_session_start();
TryCookieLogin($mysqli);	

$header = $_SERVER['DOCUMENT_ROOT'] . "/" . SITE . "/layout/header.php";

require($header);
?>
<div class="grid">
    <div class="col_10">
      
      <?php if (login_check($mysqli) == true) : ?>
            <h1>Welcome <?php echo GetUserName(); ?>!</h1>
        <?php
        if (!empty($error_msg)) {
            echo $error_msg;
        }
        ?>
        <ul>
            <li>Passwörter müssen mindest sechs Zeichen lang sein.</li>
            <li>Passwörter müssen enthalten
                <ul>
                    <li>mindestens einen Großbuchstaben (A..Z)</li>
                    <li>mindestens einen Kleinbuchstabenr (a..z)</li>
                    <li>mindestens eine Ziffer (0..9)</li>
                </ul>
            </li>
            <li>Das Passwort und die Bestätigung müssen exakt übereinstimmen.</li>
        </ul>
        <form   action="includes/process_chpw.php" 
                method="post" 
                name="registration_form">
                    Password: <input    type="password"
                                        name="password" 
                                        id="password"/><br>
            Confirm password: <input type="password" 
                                     name="confirmpwd" 
                                     id="confirmpwd" /><br>
            <input type="hidden" name="u" id="u" value="<?php echo GetUserId(); ?>"/>
            <input type="button" 
                   value="Register" 
                   onclick="return regformhash(this.form,
                                    this.form.password,
                                   this.form.confirmpwd);" /> 
        </form>
       
            
        <?php else : ?>
            <p>
                <span class="error">You are not authorized to access this page.</span>.
            </p>
        <?php endif; ?>
   
    </div>
</div>
<script type="text/JavaScript" src="js/chpw.js"></script> 
                                                              
                                                              </body>
                                                              </html>