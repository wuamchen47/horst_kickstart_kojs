<?php
//ajax files brauchen die includes extra
include_once ($_SERVER['DOCUMENT_ROOT'] . "/../_globals/cfg_other.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . "/" . SITE . "/includes/db_connect.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . "/" . SITE . "/includes/functions.php");
 
sec_session_start(); // Unsere selbstgemachte sichere Funktion um eine PHP-Sitzung zu starten.


if (login_check($mysqli) == true) {

  if (isset($_POST['p'], $_POST['u'])) {
      // Bereinige und überprüfe die Daten
      $userid = GetUserId();
      
      if (save_get("u", "", $mysqli) == $userid) {

          $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
          if (strlen($password) != 128) {
              // Das gehashte Passwort sollte 128 Zeichen lang sein.
              // Wenn nicht, dann ist etwas sehr seltsames passiert
              $error_msg .= '<p class="error">Invalid password configuration.</p>';
          }

          // Benutzername und Passwort wurde auf der Benutzer-Seite schon überprüft.
          // Das sollte genügen, denn niemand hat einen Vorteil, wenn diese Regeln   
          // verletzt werden.
          //

          $prep_stmt = "SELECT id FROM user WHERE id = ? LIMIT 1";
          $stmt = $mysqli->prepare($prep_stmt);

          if ($stmt) {
              $stmt->bind_param('s', $userid);
              $stmt->execute();
              $stmt->store_result();

              if ($stmt->num_rows == 1) {
                  // Ein Benutzer mit dieser id existiert schon - sehr gut
                }
          } else {
              $error_msg .= '<p class="error">Database error</p>';
          }

          // Noch zu tun: 
          // Wir müssen uns noch um den Fall kümmern, wo der Benutzer keine
          // Berechtigung für die Anmeldung hat indem wir überprüfen welche Art 
          // von Benutzer versucht diese Operation durchzuführen.

          if (empty($error_msg)) {
              // Erstelle ein zufälliges Salt
              $random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));

              // Erstelle saltet Passwort 
              $password = hash('sha512', $password . $random_salt);

              // Trage den neuen Benutzer in die Datenbank ein 
              if ($update_stmt = $mysqli->prepare("UPDATE user SET password=?, salt=? WHERE id=?")) {
                  $update_stmt->bind_param('sss', $password, $random_salt, $userid);
                  // Führe die vorbereitete Anfrage aus.
                  if (! $update_stmt->execute()) {
                      header('Location: ../chpw.php?err=Registration failure: INSERT');
                  }
              }
              header('Location: ../chpw.php?success=chpw');
          }
      }
      else {
        header('Location: ../chpw.php?error=chpw_user_manipulation');
      }
  }
}