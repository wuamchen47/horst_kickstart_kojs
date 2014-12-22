<?php
//ajax files brauchen die includes extra
include_once ($_SERVER['DOCUMENT_ROOT'] . "/_globals/cfg_other.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . "/" . SITE . "/includes/db_connect.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . "/" . SITE . "/includes/functions.php");
 
sec_session_start(); // Unsere selbstgemachte sichere Funktion um eine PHP-Sitzung zu starten.

if (isset($_POST['e'], $_POST['p'])) {
    $email = $_POST['e'];
    $password = $_POST['p']; // Das gehashte Passwort.

    if (login($email, $password, $mysqli) == true) {
        // Login erfolgreich 
        //header('Location: ../protected_page.php');
        echo("7");
    } else {
        // Login fehlgeschlagen 
        //echo "auafail";
        //header('Location: ../horst.php?error=1');
        echo(" - aua");
    }
} else {
    // Die korrekten POST-Variablen wurden nicht zu dieser Seite geschickt. 
    echo 'Invalid Request';
}
?>