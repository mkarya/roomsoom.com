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

$sql01 = "INSERT INTO `rs_sales_query` ";

$columns = "(`query_id` ";

$colValue = "('$qid' ";

foreach ($_POST as $key => $value) {
	if ($value != "") {
		$fieldname = str_replace("--", " ",$key);
		$columns = $columns.","."`$fieldname`" ;
		$colValue = $colValue.","."'$value'";
	}
}

$columns = $columns." )";
$colValue = $colValue." )";

$sql = $sql01.$columns."VALUES".$colValue;
echo $sql."<br>";

$result = $db_handle->query($sql);
if($result == false ) {
	echo "<h2> Sales Lead creation is not successful, record: $query_id is not enterted in the Database <br> </h2>";
}
else echo "<h2> Sales Lead creation is successful, record: $query_id is entered  and assigned to $user. <br> </h2>";

//INSERT INTO `rs_sales_query` (`query_id` ,`Date`,`Call Time`,`Portal Name`,`Name of Person`,`Status`,`Contact Number`,`Mail ID`,`Sharing`,`Conversion Status`,`Buliding Address`) VALUES ('201610341' ,'2016-10-04','2:20 pm','aulekha','Mukesh Arya','picked','09886134624','mukesh.arya@gmail.com','double','open','REA-204 Purva Riviera' )

$db_handle->close();
?>
<h2> sales query has been entered successfully </h2>
</div>
</body>
</html>