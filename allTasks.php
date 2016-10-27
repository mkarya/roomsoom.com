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
<link rel="stylesheet" href="vertical_bar.css">
<title>Home(Member)
</title>
</head>
<body link="#0066FF" vlink="#6633CC" bgcolor="#FFFFCC" background="images/image001.jpg" style='margin:0'>

<?php include 'topbar.php' ?>
<?php include 'sidebar.php' ?>



<maindiv>
<?php
$mess = "";
$user = $_SESSION['username'];
$state = $_GET["state"];
include 'sqli.php';
include 'mysqlForm.class.php';

$formClass = new mysqlForm($db_handle);

/* show tables */
if ($state == 'INPROGRESS') {
	$sql = "select * from `rs_super_tasks` WHERE `state` = '$state'";
} else {
	$sql = "select * from `rs_super_tasks` WHERE `state` <> '$state'";
}
$result = $db_handle->query($sql);
$field_count = $result->field_count;
$ignore_list = array("History");

if ($result) {
	echo "<h2> Overall tasks in state  - $state : $result->num_rows </h2>"; 
	echo '<table>';
	echo '<tr><th> <h2>'. "Task ID". '</h2> </th> <td><h2>'." Creation Date". '</h2></td>  <td><h2>'. "Owner".'</h2> </td> <td><h2>'. "Phone number".'</h2> </td><td><h2>'. "state".'</h2> </td> <td> <h2>'."title".'</h2> </td><td> <h2> estimated_completion_time </h2> </td></tr>';

	while($row = $result->fetch_assoc()) {
    		echo '<tr><td> <h4><a href = task_update.php?task_id='.$row["id"].'>'. $row["id"] .'</a></h4> </td> <td><h4>'. $row["created"] .'</h4></td> <td><h4>'. $row["owner"].'</h4> </td> <td><h4>'. NA.'</h4> </td><td><h4>'. $row["state"].'</h4> </td> <td> <h4>'.$row["Title"].'</h4> </td>'.'<td> <h4>'.$row["estimated_completion_time "].'</h4> </td></tr>';
        }
	echo '</table>';
} else {
	echo "<h2> no tasks are assigned to you </h2>";
	echo $db_handle->error;
}

$db_handle->close();
?>

</maindiv>
</body>
</html>