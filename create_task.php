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

<?php
function getNewTaskId($conn) {
	$date2query = date("Y-m")."-01";
	echo $date2query."<br>";  
	
	$sql = "SELECT `id` FROM `rs_super_tasks` WHERE `created` >= '$date2query' ORDER BY `id` DESC LIMIT 1";
	echo $sql;

	$result = $conn->query($sql);
	echo $conn->error;
	if ($result != null) {
		$row = $result->fetch_assoc();
		$qid = $row["id"] + 1;
	} else {
		$qid = (int)(date("Ym")."1000");
	}
	
	return $qid;
}	

?>	

<maindiv>
<?php
$user = $_SESSION['username'];
include 'sqli.php';
include 'mysqlForm.class.php';
$formClass = new mysqlForm($db_handle);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	include 'formValidation.php';
	$printForm = false;
	$validate = new formValidation($db_handle);
	$canNotBeNull = array("owner","state","Title","created");
	$validate->verifyParameters2NotNull($canNotBeNull);			
	$validate->verifyDate($_POST["created"]);
	var_dump($validate->getValidationResult());
	var_dump($validate->errArray);
	
	if ($validate->getValidationResult() == true) {
		$qid = getNewTaskId($db_handle);
		
		$sql01 = "INSERT INTO `rs_super_tasks` ";

		$columns = "(`id` ";

		$colValue = "('$qid' ";

		foreach ($_POST as $key => $value) {
			if ($value != "") {
				$columns = $columns.","."`$key`" ;
				$colValue = $colValue.","."'$value'";
			}
		}

		$columns = $columns." )";
		$colValue = $colValue." )";

		$sql = $sql01.$columns."VALUES".$colValue;
		echo $sql."<br>";

		$result = $db_handle->query($sql);
		if($result == false ) {
			echo "<h2> Task creation is not successful, Task is not enterted in the Database <br> </h2>";
			echo $db_handle->error."<br>";
			$printForm = true;
		}
		else { 
			echo "<h2> Task creation is successful, Task: $qid is created and assigned to ".$_POST["owner"]. "</h2> <br>";		
		}
	}
	if( $validate->getValidationResult() == false || $printForm == true ) {
		$ignore_list = array("id");
		$formClass->printFormForPostAruments($_SERVER['PHP_SELF'],$ignore_list,"rs_super_tasks");	
	}
}
else {
	$ignoreList = array("id");
	$formClass->pagefromTable("rs_super_tasks",$_SERVER['PHP_SELF'], $ignoreList);
}

$db_handle->close();

?>

</maindiv>
</body>
</html>