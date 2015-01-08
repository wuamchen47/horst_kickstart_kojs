<?php
include_once ($_SERVER['DOCUMENT_ROOT']."/horst_kickstart_kojs/includes/functions.php");
sec_session_start();
 
// Setze alle Session-Werte zurück 
$_SESSION = array();

$expire = time()-42000;
setcookie("keks_id",  "", $expire, '/', false); // hostname=false needed to work on local webserver
setcookie("keks_pass", "", $expire, '/', false);
session_destroy();
header('Location: ../horst.php');
?>