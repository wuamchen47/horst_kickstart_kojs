
<?php
//ajax files brauchen die includes extra
include_once ($_SERVER['DOCUMENT_ROOT'] . "/_globals/cfg_other.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . "/" . SITE . "/includes/db_connect.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . "/" . SITE . "/includes/functions.php");
 
sec_session_start(); // Unsere selbstgemachte sichere Funktion um eine PHP-Sitzung zu starten.

    if (login_check($mysqli) == true) {
    
        $what = save_get("pwhat", "", $mysqli);
        
        if ($what == "newPost")
        {
            // eintrag checken und eintragen wenn i.O.
            $priv = save_get("ppriv", 0, $mysqli);
            $txt = save_get("ptext", "", $mysqli);
            $link = save_get("plink", "", $mysqli);


            if (strlen($txt) > 1 && strlen($txt) < 3000)
            {
                if ($link == "http://") 
                    $link = "";

                $d = date("Y-m-d H:i:s");
                $userid = $_SESSION['user_id'];

                $sql = "INSERT INTO news (user,time,text,linkurl,private) VALUES ('$userid','$d','$txt','$link',$priv)";
                $mysqli->query($sql);
                echo"insertSQL";
            }

        } else {
            echo"todoEdit";
        }
    }
    else {
        echo"Not logged in!!";
    }
?>