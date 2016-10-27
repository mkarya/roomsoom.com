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
	$query_id = $_GET["query_id"];
	$printForm = true;
}
include 'sqli.php';
include 'mysqlForm.class.php';

$formClass = new mysqlForm($db_handle);

$errList = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {	
	include 'formValidation.php';
	$printForm = false;
	$query_id = $_POST["query_id"];

	$validate = new formValidation($db_handle);
	$canNotBeNull = array("Name_of_Person","Contact_Number","query_owner",
				"Location","Teritory","Category");
	$validate->verifyParameters2NotNull($canNotBeNull);
	//$validate->verifyPairforNull("Conversion_Status","Buliding_Address");			
	$validate->verifyPairforNull("Conversion_Status","conversion_gap");
	$validate->verifyDate($_POST["Date"]);
	var_dump($validate->getValidationResult());
	var_dump($validate->errArray);
	
	if ($validate->getValidationResult() == true) {
		$sql01 = "UPDATE `rs_sales_query` SET ";
		$updateStr = '';

		foreach ($_POST as $key => $value) {
			$substring = 'Date';
			if ($value != "") {
			//$key = preg_replace("/&#?[a-z0-9]+;/i","",$key);
				//var_dump($key);
				//var_dump($_POST[$key]);
				$key = str_replace("--", " ",$key);
				$updateStr  .= addColumnUpdate($key,$value);
				$updateStr .= ", ";
			}
		}

		$sql = $sql01.$updateStr."WHERE `query_id` = '$query_id'";
		$sql = str_replace(", WHERE"," WHERE",$sql);
		echo $sql."<br>";

		$result = $db_handle->query($sql);

		if($result == false ) {
			$printForm = true;
			echo "<h2> Sales Lead update is not successful, record: $query_id is not updated in the Database <br> </h2>";
		}
		else echo "<h2> Sales Lead update is successful, record: $query_id is updated in the Database. please check dashboard of $user. <br> </h2>";
	}
	
	if( $validate->getValidationResult() == false || $printForm == true ) {
		echo "<h2>Result of query: ".$query_id;
		echo "  please make necessary updates and submit </h2>";
		$ignore_list = array("History");
		$formClass->printFormForPostAruments($_SERVER['PHP_SELF'],$ignore_list,"rs_sales_query");	
	}		
}
else {
	echo "<h2>Result of query: ".$query_id;
	echo "  please make necessary updates and submit </h2>";

	$sql = "select * from `rs_sales_query` WHERE `query_id`=".$query_id;
	$result = $db_handle->query($sql);
	$field_count = $result->field_count;
	$ignore_list = array("History");
	$formClass->printFormForRow($result,$_SERVER['PHP_SELF'],$ignore_list);
}

$db_handle->close();
?>

</maindiv>

</body>
</html>