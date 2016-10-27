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
<title>Room Soom SalesForce </title>
</head>
<body link="#0066FF" vlink="#6633CC" bgcolor="#FFFFCC" background="images/image001.jpg" style='margin:0'>

<?php include 'topbar.php' ?>
<?php include 'sidebar.php' ?>

<maindiv>

<?php
function addColumnUpdate($colname, $colValue) {
	$substring = 'Date';
	if ($colValue != '' ) {
		// to take care of - in form values.
		$colValue = str_replace("--", " ", $colValue);
		$tempStr = " `$colname` = '$colValue' ";
		return $tempStr;
	}
	return '';
}

$user = $_SESSION['username'];
if ($_SERVER["REQUEST_METHOD"] == "GET"){
	$task_id = $_GET["task_id"];
	$printForm = true;
}
include 'sqli.php';
include 'mysqlForm.class.php';

$formClass = new mysqlForm($db_handle);

$errList = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {	
	include 'formValidation.php';
	$printForm = false;
	$task_id = $_POST["id"];

	$validate = new formValidation($db_handle);
	$canNotBeNull = array("owner","created","state");
	$validate->verifyParameters2NotNull($canNotBeNull);
	$validate->verifyDate($_POST["created"]);
	var_dump($validate->getValidationResult());
	var_dump($validate->errArray);
	
	if ($validate->getValidationResult() == true) {
		$sql01 = "UPDATE `rs_super_tasks` SET ";
		$updateStr = '';

		foreach ($_POST as $key => $value) {
			$substring = 'Date';
			if ($value != "") {
				$updateStr  .= addColumnUpdate($key,$value);
				$updateStr .= ", ";
			}
		}

		$sql = $sql01.$updateStr."WHERE `id` = '$task_id'";
		$sql = str_replace(", WHERE"," WHERE",$sql);
		echo $sql."<br>";

		$result = $db_handle->query($sql);
		echo $db_handle->error;

		if($result == null) {
			$printForm = true;
			echo "<h2> Task update is not successful, record: $task_id is not updated in the Database <br> </h2>";
		}
		else echo "<h2> Sales Lead update is successful, record: $task_id is updated in the Database. please check dashboard of $user. <br> </h2>";
	}
	
	if( $validate->getValidationResult() == false || $printForm == true ) {
		echo "<h2>Result of Task: ".$task_id;
		echo "  please make necessary updates and submit </h2>";
		$ignore_list = array("id");
		$formClass->printFormForPostAruments($_SERVER['PHP_SELF'],$ignore_list,"rs_super_tasks");	
	}		
}
else {
	echo "<h2> please complete all field and submit </h2>";

	$sql = "select * from `rs_super_tasks` WHERE `id`=".$task_id;
	$result = $db_handle->query($sql);
	$ignore_list = array("id");
	echo $db_handle->error;
	$formClass->printFormForRow($result,$_SERVER['PHP_SELF'],$ignore_list);
}

$db_handle->close();
?>

</maindiv>

</body>
</html>