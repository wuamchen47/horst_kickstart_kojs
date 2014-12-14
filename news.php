<?php
    // hol u.a. die site
    include_once ($_SERVER['DOCUMENT_ROOT']."/_globals/cfg_other.php");
    $header = $_SERVER['DOCUMENT_ROOT']."/".SITE."/layout/header.php";
    $nav = $_SERVER['DOCUMENT_ROOT']."/".SITE."/layout/nav.php";
    $login_form = $_SERVER['DOCUMENT_ROOT']."/".SITE."/includes/inc_login_form.php";
    //
    $main = $_SERVER['DOCUMENT_ROOT']."/".SITE."/includes/inc_news.php";
    //
    $footer = $_SERVER['DOCUMENT_ROOT']."/".SITE."/layout/footer.php";
    require_once($_SERVER['DOCUMENT_ROOT']."/".SITE."/layout/layout_mgr.php");
?>

