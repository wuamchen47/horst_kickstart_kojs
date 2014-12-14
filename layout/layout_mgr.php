<?php
    error_reporting (E_ALL);
    include_once ($_SERVER['DOCUMENT_ROOT']."/".SITE."/includes/db_connect.php");
    include_once ($_SERVER['DOCUMENT_ROOT']."/".SITE."/includes/functions.php");
    sec_session_start();

    if (login_check($mysqli) == true) { 
        $logged = 'in';
    } else {
        $logged = 'out';
    }
    
    require($header);
?>
<div class="grid">
    <?php require($nav); ?>
    <?php require($login_form); ?>
    <?php require($main); ?>
</div>
<?php require($footer); ?>

