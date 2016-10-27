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
define('DB_DATABASE', 'cosytree_rs_cosytree_staging');
//define('DB_PASS', '');
define('DB_PASS', 'iZXbVFs6=5{B');

$user_name = DB_USER;
$password = DB_PASS;
$database = DB_DATABASE;
$server = DB_HOST;
$db_handle = new mysqli($server, $user_name, $password,$database);

// Check connection
if ($db_handle->connect_error)
  {
  die("Failed to connect to MySQL: ". $db_handle->connect_error);
  }

?>
