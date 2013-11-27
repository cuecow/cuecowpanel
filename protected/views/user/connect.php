<?php

$username = 'cuecow'; //DB Username
$password = 'cuec0w84'; //Password
$database = 'cuecow'; //Password

$link = mysql_connect('mysql.cuecow.com', $username, $password);
if (!$link) { die('<h1>Could not connect to the datbase: </h1>' . mysql_error()); }
@mysql_select_db($database) or die( "Unable to select database");
//echo 'Connected successfully';

?>