<?php
error_reporting(E_ALL);
include_once ($_SERVER['DOCUMENT_ROOT'] . "/_globals/cfg_other.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . "/" . SITE . "/includes/db_connect.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . "/" . SITE . "/includes/functions.php");

sec_session_start();

$header = $_SERVER['DOCUMENT_ROOT'] . "/" . SITE . "/layout/header.php";
$nav = $_SERVER['DOCUMENT_ROOT'] . "/" . SITE . "/layout/nav.php";
$news = $_SERVER['DOCUMENT_ROOT'] . "/" . SITE . "/includes/inc_news.php";
$lgn = $_SERVER['DOCUMENT_ROOT'] . "/" . SITE . "/includes/inc_login_form.php";

require($header);
require($nav);
?>
<div class="grid">
    <?php
        if (isset($_GET['error'])) {
            echo '<p class="error">Error Logging In!</p>';
        }
        
        if (login_check($mysqli) == true) {
            
            echo "logged in";

        } else {
            require($lgn);
        }
        require($news);
     ?>
</div>
<?php
$footer = $_SERVER['DOCUMENT_ROOT'] . "/" . SITE . "/layout/footer.php";
require($footer);
?>
