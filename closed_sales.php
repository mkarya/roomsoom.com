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
<body link="#0066FF" vlink="#6633CC" bgcolor="#FFFFFF" background="images/image001.jpg" style='margin:0'>

<div style="top:20; left:270; position:absolute; z-index:1;">
<h1>RoomSoom Online SalesForce</h1>
</div>

<div style="top:150; left:20; position:absolute; z-index:1;">

<table >
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

<div style="top:100; right:50; position:absolute; z-index:1;">
<div style="top:0; right:0; position:absolute; z-index:1;">
<?php
	print("<table>");
	print "<tr><td><h1>". strtoupper($user)."</h1></td><td>(Member)</td></tr>";
	
	$mess = "";
	$user = $_SESSION['username'];
	include 'sqli.php';
	
	$sql = "SELECT * FROM `rs_super_tasks` where `owner`='query' AND `state`='INPROGRESS'";

	$result = $db_handle->query($sql);

	if ($result->num_rows > 0) 
		print("<tr><td> ". "Inprgress sales queries </td><td>"."<a href=". "member.php".">".$result->num_rows."</a></td></tr>");

	$sql = "SELECT * FROM `rs_super_tasks` where `owner`='query' AND `state`='CLOSED'";

	$result = $db_handle->query($sql);

	if ($result->num_rows > 0) {
		print("<tr><td>". "Open sales queries </td><td>".$result->num_rows."</td></tr>");


		
	print("</table>");
?>
</div>
</div>

<div style="top:200; left:255; position:absolute; z-index:1 border: 1px solid black;;">

<?php


echo '<table bgcolor="white" width="100%">';
echo '<tr><th> <h2>'. "Task ID". '</h2> </th> <td><h2>'." Creation Date". '</h2></td>  <td><h2>'. "Customer Name".'</h2> </td> <td><h2>'. "Phone number".'</h2> </td><td><h2>'. "email".'</h2> </td> <td> <h2>'."Location".'</h2> </td></tr>';

	while($row = $result->fetch_assoc()) {
    		$sql = "SELECT * FROM `rs_sales_query` where `query_id`=".$row["id"];
    		$sresult=$db_handle->query($sql);
    		$inner_row = $sresult->fetch_assoc();
    		echo '<tr><td> <h4><a href = sales_query.php?query_id='.$row["id"].'>'. $row["id"] .'</a></h4> </td> <td><h4>'. $inner_row["date"] .'</h4></td> <td><h4>'. $inner_row["query_source"].'</h4> </td> <td><h4>'. $inner_row["contact_number"].'</h4> </td><td><h4>'. $inner_row["mail_id"].'</h4> </td> <td> <h4>'.$inner_row["location"].'</h4> </td></tr>';
        	$inner_row="";
        	$sresult="";
    }
} else {
    echo "Good No unclosed task today for you";
}
echo '</table>';

$db_handle->close();
?>

</div>
</body>
</html>