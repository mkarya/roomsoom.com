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
<title>RoomSoom Reports
</title>
</head>
<body link="#0066FF" vlink="#6633CC" bgcolor="#FFFFCC" background="images/image001.jpg" style='margin:0'>

<?php include 'topbar.php' ?>
<?php include 'sidebar.php' ?>

<maindiv>

<?php
include 'sqli.php';
include 'mysqlForm.class.php';
$space = " ";
$customerNumber = "";
$mailid = "";
$query_id = "";
if($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["query_id"]))
		$customerNumber = $_POST["query_id"];
	if (isset($_POST["Mail_ID"]))
		$customerNumber = $_POST["Mail_ID"];
	if (isset($_POST["Contact_Number"]))
		$customerNumber = $_POST["Contact_Number"];
//echo  $reportMonth;
}

echo "<form action=".$_SERVER['PHP_SELF']. " method='post'>";
echo "Please Provide <br> Sales Lead Query ID:";
echo "<input type=text name='query_id' value=''>";
echo "&nbsp OR &nbsp";
echo "Customer Email:";
echo "<input type=text name='Mail_ID' value=''>";
echo "&nbsp OR &nbsp";
echo "Customer Contact Number:";
echo "<input type=text name='Contact_Number' value=''>";
echo "<input type=submit  value='SEARCH'>";
echo "</form>";

$form = new mysqlForm($db_handle);
$sql = "SELECT * FROM `rs_sales_query` WHERE "; 
if (isset($_POST["query_id"]) && $_POST["query_id"] != "") {
	$sql .= "`query_id` = '".$_POST["query_id"]."'";
	$sql .= $space."OR".$space;
}


if (isset($_POST["Mail_ID"] ) && $_POST["Mail_ID"] != "") {
	$sql .= "`Mail_ID` = '".$_POST["Mail_ID"]."'";
	$sql .= $space."OR".$space;
}

if (isset($_POST["Contact_Number"] ) && $_POST["Contact_Number"] != "") {
	$sql .= "`Contact_Number` = '".$_POST["Contact_Number"]."'";
	$sql .= $space."OR".$space;
}

$sql = preg_replace('/OR $/', '', $sql);
var_dump( $sql);

if (isset($_POST["query_id"]) || isset($_POST["query_id"]) || isset($_POST["Contact_Number"])) {
	$result = $db_handle->query($sql);
	$ignorelist = array();
	$form->printFormForRow($result,$_SERVER['PHP_SELF'],$ignorelist);
}

?>

</maindiv>

</body>
</html>
