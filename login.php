<?php
session_start();
session_destroy();
$user = "";
$pass = "";
$msg = "";
$flag = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	include 'sqli.php';

	$user = $_POST['uname'];
	$pass = $_POST['pword'];
		
	//unwanted HTML (scripting attacks)
	$user = htmlspecialchars($user);
	$pass = htmlspecialchars($pass);
	
	$SQL = "SELECT * FROM info";
	$result = mysqli_query($db_handle,$SQL);
	while ($db_field = mysqli_fetch_assoc($result)) {
		$a = $db_field['username'];
		$b = $db_field['password'];
		$pos = $db_field['position'];
		if(($user == $a) AND ($pass == $b)){
			if($pos == "admin"){
				session_start();
				$_SESSION['username'] = $user;
				$_SESSION['admin'] = "log";
				mysqli_close($db_handle);
				header("Location: admin.php");
				break;
			}
			else if($pos == "leader"){
				session_start();
				$_SESSION['username'] = $user;
				$_SESSION['leader'] = "log";
				mysqli_close($db_handle);
				header("Location: leader.php");
				break;
			}
			else if($pos == "member"){
				session_start();
				$_SESSION['username'] = $user;
				$_SESSION['member'] = "log";
				mysqli_close($db_handle);
				header("Location: member.php");
				break;
			}
		}
		else $flag = 1;
	}
	if ($flag == 1) {
		$msg = "Check username and/or password.";
	}
	mysqli_close($db_handle);
}
?>


<html>
<head>
<title>Home
</title>
</head>
<body link="#0066FF" vlink="#6633CC" bgcolor="#FFFFCC" background="images/image001.jpg" style='margin:0'>

<div style="top:20; left:270; position:absolute; z-index:1;">
<h1>RoomSoom Online Task Management System</h1>
</div>

<div style="top:150; left:20; position:absolute; z-index:1;">

<table>
<tr><td>
<a href = "index.php"><img border = "none" src = "images/home.gif"></img></a>
</td></tr>

</table>
<div style="top:0; left:170; position:absolute; z-index:1;">
<img src = "images/image002.gif"></img>
</div>

</div>


<div style="top:220; left:370; position:absolute; z-index:1;">
<?php
echo "<font color = 'red'>$msg</font>";
?>
<form name='login_form' method='post' action='login.php'>
<table border = "0">
<tr>
	<th align = 'right'>Username*:</th>
	<td><input name = 'uname' type = 'text' value = ''></td>
</tr>
<tr><td></td></tr>
<tr>
	<th align = 'right'>Password:</th>
	<td><input name = 'pword' type = 'password' value = ''></td>
</tr>
<tr>
	<th align = 'right'></th>
	<td><input name = 'login' type = 'submit' value = 'Login'></td>
</tr>


</table>
</form>
</div>

<div style="top:270; left:383; position:absolute; z-index:1;">
<?php
?>
</div>

<div style="top:150; left:800; position:absolute; z-index:1;">
<img src = "images/image002.gif"></img>

<div style="top:50; left:10; position:absolute; z-index:1;">
<a href = "verify.php"><img src = "images/verify.gif" border = "0"></img></a>
</div>

<div style="top:100; left:10; position:absolute; z-index:1;">
<a href = "signup.php"><img src = "images/signup.gif" border = "0"></img></a>
</div>

</div>

</body>
</html>
