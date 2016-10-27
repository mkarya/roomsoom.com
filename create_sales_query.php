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
<title> Home(Member) </title>
</head>
<body link="#0066FF" vlink="#6633CC" bgcolor="#FFFFCC" background="images/image001.jpg" style='margin:0'>

<?php include 'topbar.php' ?>
<?php include 'sidebar.php' ?>


<?php
function getNewQueryId($conn) {
	$date2query = date("Y-m")."-01";
	echo $date2query."<br>";  
	
	$sql = "SELECT `query_id` FROM `rs_sales_query` WHERE `Date` >= '$date2query' ORDER BY `query_id` DESC LIMIT 1";
	echo $sql;

	$result = $conn->query($sql);
	if ($result != null) {
		$row = $result->fetch_assoc();
		$qid = $row["query_id"] + 1;
	} else {
		$qid = (int)(date("Ym")."1000");
	}
	
	return $qid;
}

function verifyUniqueQid($conn,$qid) {
	$sql = "select `query_id` from `rs_sales_query` where `query_id` = 'qid'";
	$res = $conn->query($sql);
	if ($res == false ) return true;
	return false;
}	

?>	

<maindiv>
<?php
$mess = "";
$user = $_SESSION['username'];
$query_id = $_GET["query_id"];
include 'sqli.php';
include 'mysqlForm.class.php';
include 'sendMail.php';
$formClass = new mysqlForm($db_handle);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	include 'formValidation.php';
	$printForm = false;
	$validate = new formValidation($db_handle);
	$canNotBeNull = array("Name_of_Person","Contact_Number","query_owner",
				"Location","Teritory","Mail_ID","Category");
	$validate->verifyParameters2NotNull($canNotBeNull);
	//$validate->verifyPairforNull("Conversion_Status","Buliding_Address");			
	$validate->verifyPairforNull("Conversion_Status","conversion_gap");
	$validate->verifyDate($_POST["Date"]);
	var_dump($validate->getValidationResult());
	var_dump($validate->errArray);
	
	if ($validate->getValidationResult() == true) {
		$qid = getNewQueryId($db_handle);
		
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
			echo "<h2> Sales Lead creation is not successful, record: is not enterted in the Database <br> </h2>";
			echo $db_handle->error."<br>";
			$printForm = true;
		}
		else { 
			echo "<h2> Sales Lead creation is successful, record: $qid is created and assigned to ".$_POST["query_owner"]. "</h2> <br>";
			$tmail = new sendMail();
			$tmail->sendMail2CustomerOnLead($_POST["Name_of_Person"],$_POST["Mail_ID"],$_POST["Location"]);
			$tmail->sendMail2CallingTeam($_POST["query_owner"],$qid);
		}
	}
	if( $validate->getValidationResult() == false || $printForm == true ) {
		$ignore_list = array("History");
		$formClass->printFormForPostAruments($_SERVER['PHP_SELF'],$ignore_list,"rs_sales_query");	
	}
}
else {
	$ignore_list = array("query_id","History","closing_status","booking_date","calling_status_y_n","sales_feedback_date");

	$formClass->pagefromTable("rs_sales_query",$_SERVER['PHP_SELF'], $ignore_list);
}

$db_handle->close();

?>

</maindiv>
</body>
</html>