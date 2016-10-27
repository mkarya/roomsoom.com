<?php

/*
$user_name = "fees0_4320930";
$password = "fergus";
$database = "fees0_4320930_bui";
$server = "sql212.0fees.net";
$db_handle = mysql_connect($server, $user_name, $password);
$db_found = mysql_select_db($database, $db_handle);
*/

date_default_timezone_set("Asia/Kolkata");
/* -----Database values----- */
define('DB_HOST', 'localhost');
define('DB_USER', 'cosytree_rs');
//define('DB_USER', 'root');
define('DB_DATABASE', 'cosytree_rs');
//define('DB_PASS', '');
define('DB_PASS', 'iZXbVFs6=5{B');

$user_name = DB_USER;
$password = DB_PASS;
$database = DB_DATABASE;
$server = DB_HOST;
$db_handle = mysqli_connect($server, $user_name, $password);

if (!$db_handle) {
    die("Connection failed: " . mysqli_connect_error());
}

$db_found = mysqli_select_db($db_handle,$database);

if (!$db_found) {
	die("DATABASE not found!");
}

?>