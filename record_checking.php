#!/usr/local/bin/php


<?php
include 'sqli.php';


$myfile = fopen("booked", "r") or die("Unable to open file!");
while($xx = fgets($myfile)) {
	$sql = "select * from `rs_sales_query` where `Contact_Number` = '".trim($xx)."'";
	$res = $db_handle->query($sql);
	if ($res == null) echo $xx;
	else {
		$row = $res->fetch_assoc();
		echo trim($xx) . ": ". $row['Conversion_Status']."\n";
		
	}
}
fclose($myfile);


?>

