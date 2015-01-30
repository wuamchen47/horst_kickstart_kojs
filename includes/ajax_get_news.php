<?php
//ajax files brauchen die includes extra - da zieht der layoutmanager nicht
include_once ($_SERVER['DOCUMENT_ROOT'] . "/../_globals/cfg_other.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . "/" . SITE . "/includes/db_connect.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . "/" . SITE . "/includes/functions.php");

sec_session_start();

$start_read = 0;
$lid = 0;
$npp = 10;
$priv = 0;

if (login_check($mysqli) == true) {
    $priv = 1;
    $lid = save_get("lid", "", $mysqli);
    if (is_numeric($lid) && $lid > 10) {
      $start_read = $lid;
    }
}

header('Content-Type: application/json');
echo get_news($start_read, $npp, $priv, $mysqli);

?>