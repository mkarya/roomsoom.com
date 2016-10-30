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
<title>RoomSoom member password change
</title>
</head>
<body link="#0066FF" vlink="#6633CC" bgcolor="#FFFFCC" background="images/image001.jpg" style='margin:0'>

<?php include 'topbar.php' ?>
<?php include 'sidebar.php' ?>

<maindiv>

<?php
include 'sqli.php';
include 'rs_password_change_class.php';
$pAction = new rs_password_change_class($db_handle,$user);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$resNew = $pAction->verifyNewPassword($_POST["newPassword"],$_POST["confirmNewPassword"]);
	$resOld = $pAction->verifyOldPassword($_POST["oldPassword"]);
	if($resNew && $resOld) {
		$pAction->changePassWord($user);
	} 
}


if ($pAction->printForm) {
	echo $pAction->errorMsg."<br>";
	$pAction->printPassWordChangeForm($_SERVER["PHP_SELF"]);
}

$db_handle->close();
?>

</maindiv>

</body>
</html>
