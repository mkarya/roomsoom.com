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

$report = new rsSalesLeadsReport($db_handle);
$report->setMonthNumber(Date(m));
$report->printMonthReport();
$db_handle->close();
?>

</maindiv>

</body>
</html>
