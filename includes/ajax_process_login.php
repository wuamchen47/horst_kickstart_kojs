<?php
//ajax files brauchen die includes extra
include_once ($_SERVER['DOCUMENT_ROOT'] . "/../_globals/cfg_other.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . "/" . SITE . "/includes/db_connect.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . "/" . SITE . "/includes/functions.php");
 
sec_session_start(); // Unsere selbstgemachte sichere Funktion um eine PHP-Sitzung zu starten.

if (isset($_POST['e'], $_POST['p'], $_POST['r'])) {
    $email = save_get("e", "", $mysqli);
    $password = save_get("p", "", $mysqli); // Das gehashte Passwort.
    $remember = filter_var(save_get("r", 0, $mysqli), FILTER_VALIDATE_BOOLEAN);

    if (login($email, $password, $mysqli) == true) {
        // Login erfolgreich
        if ($remember)
        {
          SetLoginCookie();
        }
        
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