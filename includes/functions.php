<?php

include_once ($_SERVER['DOCUMENT_ROOT'] . "/../_globals/cfg_other.php");

function sec_session_start() {
    $session_name = 'sec_session_id';   // vergib einen Sessionnamen
    $secure = SECURE;
    // Damit wird verhindert, dass JavaScript auf die session id zugreifen kann.
    $httponly = true;
    // Zwingt die Sessions nur Cookies zu benutzen.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Holt Cookie-Parameter.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
    // Setzt den Session-Name zu oben angegebenem.
    session_name($session_name);
    session_start();            // Startet die PHP-Sitzung 
    session_regenerate_id();    // Erneuert die Session, löscht die alte. 
}

function login($email, $password, $mysqli) {
    // Das Benutzen vorbereiteter Statements verhindert SQL-Injektion.
    if ($stmt = $mysqli->prepare("SELECT id, name, password, salt
                                    FROM user
                                    WHERE email = ?
                                    LIMIT 1")) {
        $stmt->bind_param('s', $email); // Bind "$email" to parameter. 
        $stmt->execute(); // Führe die vorbereitete Anfrage aus.
        $stmt->store_result(); // hole Variablen von result.
        $stmt->bind_result($user_id, $username, $db_password, $salt);
        $stmt->fetch();

        // hash das Passwort mit dem eindeutigen salt.
        $password = hash('sha512', $password . $salt);
        if ($stmt->num_rows == 1) {
            // Wenn es den Benutzer gibt, dann wird überprüft ob das Konto
            // blockiert ist durch zu viele Login-Versuche
            //echo "num rows = 1";

            if (checkbrute($user_id, $mysqli) == true) {
                // Konto ist blockiert 
                // Schicke E-Mail an Benutzer, dass Konto blockiert ist
                //echo "checkbrutetrue";
                return false;
            } else {
                // Überprüfe, ob das Passwort in der Datenbank mit dem vom
                // Benutzer angegebenen übereinstimmt.
                //echo "nobrute";
                if ($db_password == $password) {
                    // Passwort ist korrekt!
                    // Hole den user-agent string des Benutzers.
                    echo "4";
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    // XSS-Schutz, denn eventuell wir der Wert gedruckt
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;
                    // XSS-Schutz, denn eventuell wir der Wert gedruckt
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512', $password . $user_browser);
                    // Login erfolgreich.
                    return true;
                } else {
                    echo "wrongpass";
                    // Passwort ist nicht korrekt
                    // Der Versuch wird in der Datenbank gespeichert
                    $now = time();
                    $mysqli->query("INSERT INTO login_attempts(user_id, time)
                                    VALUES ('$user_id', '$now')");
                    return false;
                }
            }
        } else {
            //Es gibt keinen Benutzer.
            echo "nosuchuser";
            return false;
        }
    }
}

function checkbrute($user_id, $mysqli) {
    // Hole den aktuellen Zeitstempel 
    $now = time();

    // Alle Login-Versuche der letzten zwei Stunden werden gezählt.
    $valid_attempts = $now - (2 * 60 * 60);

    if ($stmt = $mysqli->prepare("SELECT time 
                             FROM login_attempts <code><pre>
                             WHERE user_id = ? 
                            AND time > '$valid_attempts'")) {
        $stmt->bind_param('i', $user_id);

        // Führe die vorbereitet Abfrage aus. 
        $stmt->execute();
        $stmt->store_result();

        // Wenn es mehr als 5 fehlgeschlagene Versuche gab 
        if ($stmt->num_rows > 5) {
            return true;
        } else {
            return false;
        }
    }
}

function login_check($mysqli) {
    // Überprüfe, ob alle Session-Variablen gesetzt sind 
    if (isset($_SESSION['user_id'], $_SESSION['login_string'])) {

        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        
        // Hole den user-agent string des Benutzers.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];

        if ($stmt = $mysqli->prepare("SELECT password 
                                      FROM user 
                                      WHERE id = ? LIMIT 1")) {
            // Bind "$user_id" zum Parameter. 
            $stmt->bind_param('i', $user_id);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                // Wenn es den Benutzer gibt, hole die Variablen von result.
                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);

                if ($login_check == $login_string) {
                    // Eingeloggt!!!! 
                    return true;
                } else {
                    // Nicht eingeloggt
                    return false;
                }
            } else {
                // Nicht eingeloggt
                return false;
            }
        } else {
            // Nicht eingeloggt
            return false;
        }
    } else {
        // Nicht eingeloggt
        return false;
    }
}

function esc_url($url) {

    if ('' == $url) {
        return $url;
    }

    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);

    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;

    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }

    $url = str_replace(';//', '://', $url);

    $url = htmlentities($url);

    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);

    if ($url[0] !== '/') {
        // Wir wollen nur relative Links von $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}

//////////////////////////////////////////////////////////////////////////////
// get all the news including lazy load possibility
//////////////////////////////////////////////////////////////////////////////

function get_news($start_read, $npp, $private, $mysqli) {

    if ($private == true) {
        $private = '';
    } else {
        $private = ' and n.private = 0';
    }
  
    if ($start_read == 0) {
        $start_read = "";
    } else {
        $start_read = " AND n.id < $start_read";
    }
    
    $sql = "SELECT n.id, u.name, u.avatar, n.text, DATE_FORMAT(n.time, '%d.%m.%Y') as fulldate, DATE_FORMAT(n.time, '%T') as entry_day, n.linkurl, n.private
        FROM news n, user u 
        WHERE n.user = u.id $private
        $start_read
        ORDER BY n.id DESC LIMIT 0,$npp
        ";
    //echo($sql);
    $news = $mysqli->query($sql);
    $news_r = array();
    while ($row = $news->fetch_array()) {
        $id = $row['id'];
        $name = $row['name'];
        $avatar = $row['avatar'];
        $comment = insertImages($row['text']);
        $fulldate = $row['fulldate'];
        $time = $row['entry_day'];
        $link = $row['linkurl'];
        $private = $row['private'];
        $news_r[] = array(
            'id' => $id, 'name' => $name, 'avatar' => $avatar, 'comment' => $comment, 'fulldate' => $fulldate, 'time' => $time, 'link' => $link, 'private' => $private
        );
    }
    
    if (count($news_r) == 0) {
        return "Keine News, irgendwas passt nicht";
    } else {
        return json_encode($news_r);
    }
}

//////////////////////////////////////////////////////////////////////////////
// Input Handling
//////////////////////////////////////////////////////////////////////////////

function save_get($wert, $default, $db)
{  
  // get validated POST or GET variable
  if (isset($_POST[$wert]))
  {
    return ValidateInput($_POST[$wert], $db);
  }
  else if (isset($_GET[$wert]))
  {
    return ValidateInput($_GET[$wert], $db);
  }
  else return $default;
}

function ValidateInput($input, $db)
{
  // entfernt unerlaubte zeichen und tags aus $input
    $input = $db->real_escape_string(
    (get_magic_quotes_gpc() == 1 ? stripslashes($input) : $input)
  );
  // bestimte Tags zulassen
  $input =  strip_tags($input, '<b><img><font><center>'); 
  return $input;
}

//////////////////////////////////////////////////////////////////////////////
//Kedshandling
//////////////////////////////////////////////////////////////////////////////

function SetLoginCookie()
{
  if (isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {
    $expire = time()+(3600*24*180); //180 tage
    setcookie("keks_id",   $_SESSION['user_id'],         $expire, '/', false); // hostname=false needed to work on local webserver
    setcookie("keks_pass", $_SESSION['login_string'], $expire, '/', false);
  }
}

function GetCookie($wert, $default="")
{
  if (isset($_COOKIE[$wert]))
    return $_COOKIE[$wert];
  
  return $default;
}

function SAFE_COOKIE($name, $db)
{
  // get validated cookie value
  return ValidateInput(GetCookie($name), $db);
}

//////////////////////////////////////////////////////////////////////////////
// Try Login with Cookie based on function login logic
//////////////////////////////////////////////////////////////////////////////

function TryCookieLogin($db)
  {
    if (login_check($db) == true)
      return;
	
	// check if login cookie available
    // if yes, attempt login
	$cookId = SAFE_COOKIE("keks_id", $db);
    $cookPass = SAFE_COOKIE("keks_pass", $db);
	if ($cookId != "" && $cookPass != "")
    {
        //check analog login_check
        $user_id = $cookId;
        $login_string = $cookPass;
        
        // Hole den user-agent string des Benutzers.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];

        if ($stmt = $db->prepare("SELECT password 
                                      FROM user 
                                      WHERE id = ? LIMIT 1")) {
            // Bind "$user_id" zum Parameter. 
            $stmt->bind_param('i', $user_id);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                // Wenn es den Benutzer gibt, hole die Variablen von result.
                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);

                if ($login_check == $login_string) {
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['login_string'] = hash('sha512', $password . $user_browser);
                } else {
                    // Nicht eingeloggt
                }
            } else {
                // Nicht eingeloggt
            }
        } else {
            // Nicht eingeloggt
        }
    }
  }



//////////////////////////////////////////////////////////////////////////////
// Smilie Converter + Insert Linebreak
//////////////////////////////////////////////////////////////////////////////


function insertImages($text)
	{		
		// text parsen und alle smilies durch links ersetzen
		
		$result = "";
		$path = "smilies";
        $text = str_replace("\n","<br/>",$text);
    
		$argl = explode(":!", $text);		
		
        for ($i=0; $i < count($argl); $i++) 
		{			
			// erstes vorkommen von ':' suchen
			// wenn die 4 zeichen davor die gewünswchte dateiendung sind, treffer
			// => string durch link ersetzen, rest normal anhängen
			// wenn kein ':' vorkommt oder keine gesuchte datei drin ist, den teilstring 
			// komplett an $result hängen
			
			$pos = strpos($argl[$i], ":");			
			
			if ($pos !== false)
			{
				$file = substr($argl[$i], 0, $pos);
				
				if (substr($file, -4) == ".gif" or substr($file, -4) == ".png")
				{
					$result .= "<img src='$path/$file' alt='' />";
					$result .= substr($argl[$i], $pos+1);
				}
				else $result .= $argl[$i];
			}
			else
			{		
				$result .= $argl[$i];
			}							
			
		}		
		
		return $result;
		
		//return $text;
	}


?>