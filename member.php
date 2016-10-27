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
<title>Home(Member)</title>
<link rel="stylesheet" href="vertical_bar.css">
</head>
<body link="#0066FF" vlink="#6633CC" bgcolor="#FFFFFF" background="images/image001.jpg" style='margin:0'>

<?php include 'topbar.php' ?>
<?php include 'sidebar.php' ?>

<maindiv>
<?php
	
	$mess = "";
	$user = $_SESSION['username'];
	include 'sqli.php';
	
	$yy=date("m") - 1;
	$xx=date("Y")."-".$yy."-".'1';

	$sql = "SELECT * FROM `rs_sales_query` where `query_owner`='$user' and `Date` >='$xx' and `Conversion_Status`='' ORDER BY `query_id` DESC";
	$result = $db_handle->query($sql);
	echo "<h2> Total sales leads need closure: ".$result->num_rows."</h2></a><br>";
		

	echo '<table bgcolor="white" width="90%">';
	echo '<tr><th> <h2>'. "Lead ID". '</h2> </th> <td><h2>'." Creation Date". '</h2></td>  <td><h2>'. "Customer Name".'</h2> </td> <td><h2>'. "Phone number".'</h2> </td><td><h2>'. "email".'</h2> </td> <td> <h2>'."Location".'</h2> </td><td> <h2> Convertion Status </h2> </td></tr>';

	while($row = $result->fetch_assoc()) {
    		echo '<tr><td> <h4><a href = sales_query.php?query_id='.$row["query_id"].'>'. $row["query_id"] .'</a></h4> </td> <td><h4>'. $row["Date"] .'</h4></td> <td><h4>'. $row["Name_of_Person"].'</h4> </td> <td><h4>'. str_replace(" ","",$row["Contact_Number"]).'</h4> </td><td><h4>'. $row["Mail_ID"].'</h4> </td> <td> <h4>'.$row["Location"].'</h4> </td>'.'<td> <h4>'.$row["Conversion_Status"].'</h4> </td></tr>';
        }
	echo '</table>';

	$db_handle->close();
?>

</maindiv>
</body>
</html>