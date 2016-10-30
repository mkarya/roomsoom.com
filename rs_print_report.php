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
include 're_report.php';
$reportMonth = date("m");
if($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["month"]) == false)
		$reportMonth = $_POST["month"];
//echo  $reportMonth;
}

echo "<form action=".$_SERVER['PHP_SELF']." method='post'>";
echo "Choose Month for report :";
echo "<select name='month'>";
echo "<option value=''> </option>";
echo "<option value='1'> January </option>";
echo "<option value='2'> February </option>";
echo "<option value='3'> March </option>";
echo "<option value='4'> April </option>";
echo "<option value='5'> May </option>";
echo "<option value='6'> June </option>";
echo "<option value='7'> July </option>";
echo "<option value='8'> August </option>";
echo "<option value='9'> September </option>";
echo "<option value='10'> October </option>";
echo "<option value='11'>  November</option>";
echo "<option value='12'> December </option>";
echo "<input type='submit' value='SUBMIT'>";
echo "</form>";

$report = new rsSalesLeadsReport($db_handle);
$report->setMonthNumber($reportMonth);
$report->printMonthReport();
$db_handle->close();
?>

</maindiv>

</body>
</html>
