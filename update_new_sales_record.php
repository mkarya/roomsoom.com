<?php
session_start();
$user = $_SESSION['username'];
$log = $_SESSION['member'];
if ($log != "log"){
	header ("Location: login.php");
}
?>


<html>
<head>
<title>Home(Member)
</title>
</head>
<body link="#0066FF" vlink="#6633CC" bgcolor="#FFFFCC" background="images/image001.jpg" style='margin:0'>


<div style="top:100; left:20; position:absolute; z-index:1;">

<table>
<tr><td>
<a href = "member.php"><h3> My Dashboard</h3></img></a>
</td></tr>

<tr><td>
<a href = "create_task.php"><h3> Create Task</h3></a>
</td></tr>

<tr><td>
<a href = "create_sales_query.php"><h3> New Sale</h3></a>
</td></tr>

<tr><td>
<a href = "index.php"><h3> Logout</h3></a>
</td></tr>

</table>

<div style="top:0; left:170; position:absolute; z-index:1;">
<img src = "images/image002.gif"></img>
</div>

</div>

<div style="top:100; left:250; position:absolute; z-index:1;">
<div style="top:0; left:0; position:absolute; z-index:1;">
<?php
	print("<table>");
	print "<tr><td><h1>". strtoupper($user)."</h1></td><td>(Member)</td></tr>";
	print("</table>");
?>
</div>
</div>

<div style="top:200; left:255; position:absolute; z-index:1;">
<?php
$mess = "";
$user = $_SESSION['username'];
$query_id = $_GET["query_id"];
include 'sqli.php';
//include 'mysqlForm.class.php';

$date2query = date("Y-m")."-01";
echo $date2query."<br>";  

$sql = "SELECT * FROM `rs_sales_query` WHERE `date` >= '$date2query'";
$result = $db_handle->query($sql);
$next = $result->num_rows + 1;
$qid = date("Ym").$next;

echo $qid."<br>";

$sql01 = "UPDATE `rs_sales_query` SET `query_id`='$qid'";

$columns = "(`query_id` ";

$colValue = "('$qid' ";,

foreach ($_POST as $key => $value) {
	if ($value != "") {
		$ustr = "`$key`"."=".'$value'.",";
		$fieldname = str_replace("--", " ",$key);
		$columns = $columns.","."`$fieldname`" ;
		$colValue = $colValue.","."'$value'";
		$ustr = "`$key`"."=".'$value'.",";
	}
}

$columns = $columns." )";
$colValue = $colValue." )";

//$sql = $sql01.$columns."VALUES".$colValue;
//echo $sql."<br>";

//$result = $db_handle->query($sql);

//UPDATE `rs_sales_query` SET `query_id`=[value-1],`Date`=[value-2],`Call Time`=[value-3],`Query Time`=[value-4],`Portal Name`=[value-5],`Name of Person`=[value-6],`Status`=[value-7],`Contact Number`=[value-8],`Mail ID`=[value-9],`Sharing`=[value-10],`Location`=[value-11],`Teritory`=[value-12],`Budget`=[value-13],`no_of_seat_request`=[value-14],`Food`=[value-15],`Category`=[value-16],`Remark`=[value-17],`query_owner`=[value-18],`Follow up call date`=[value-19],`follow_up_call_time`=[value-20],`Conversion Status`=[value-21],`conversion_gap`=[value-22],`Convert By`=[value-23],`Buliding Address`=[value-24],`Booking Date`=[value-25],`Institution_name`=[value-26],`Send SMS-Mail-Whatsapp`=[value-27],`Number Circulate to Care Taker & Sales Executive`=[value-28],`Name of sales person alloted`=[value-29],`Sales Person Allocation Time`=[value-30],`follow_up_call`=[value-31],`Feedback from sales team`=[value-32],`sales_feedback_date`=[value-33],`History`=[value-34],`closing_status`=[value-35],`calling_status_y_n`=[value-36] WHERE 1

$db_handle->close();
?>
<h2> sales query has been updated successfully </h2>
</div>
</body>
</html>