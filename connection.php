<?php
session_start();

define('DB_HOST', 'localhost');
define('DB_USER', 'panel_user');
define('DB_PASS', 'ewvdfgrt55');
define('DB_NAME', 'panel_cuecow');

$con = mysql_connect(DB_HOST, DB_USER, DB_PASS);

if(!$con)
	die('Could not connect: ' . mysql_error());

$db_selected = mysql_select_db(DB_NAME, $con);

if(!$db_selected)
	die('Database is not selected : ' . mysql_error());
	
?>
