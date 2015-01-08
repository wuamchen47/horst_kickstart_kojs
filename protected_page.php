<?php
error_reporting(E_ALL);
include_once ($_SERVER['DOCUMENT_ROOT'] . "/_globals/cfg_other.php");
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
            <p>Welcome <?php echo htmlentities($_SESSION['username']); ?>!</p>
            <p>
                Eine Hilfsseite, um ein neues Passwort zu speichern.
            </p>
            
        <?php else : ?>
            <p>
                <span class="error">You are not authorized to access this page.</span>.
            </p>
        <?php endif; ?>
   
    </div>
</div>
<?php
    $footer = $_SERVER['DOCUMENT_ROOT'] . "/" . SITE . "/layout/footer.php";
    require($footer);
?>

