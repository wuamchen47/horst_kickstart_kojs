<?php
//ajax files brauchen die includes extra - da zieht der layoutmanager nicht
include_once ($_SERVER['DOCUMENT_ROOT'] . "/_globals/cfg_other.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . "/" . SITE . "/includes/db_connect.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . "/" . SITE . "/includes/functions.php");

sec_session_start();

$start_read = 0;
$npp = 47;
$priv = 0;

if (login_check($mysqli) == true) {
    $priv = 1;
}

echo get_news($start_read, $npp, $priv, $mysqli);

?>