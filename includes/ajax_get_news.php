<?php
//ajax files brauchen die includes extra - da zieht der layoutmanager nicht
include_once ($_SERVER['DOCUMENT_ROOT'] . "/_globals/cfg_other.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . "/" . SITE . "/includes/db_connect.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . "/" . SITE . "/includes/functions.php");

$start_read = 0;
$npp = 47;

echo get_news($start_read, $npp, $mysqli);

?>