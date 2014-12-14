<?php
	include_once ($_SERVER['DOCUMENT_ROOT']."/_globals/cfg_db.php");	
	$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
        $mysqli->query("SET NAMES 'utf8'");
        $mysqli->query("SET CHARACTER SET utf8");
?>