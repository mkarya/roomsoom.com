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
<body link="#0066FF" vlink="#6633CC" bgcolor="#FFFFFF" background="images/image001.jpg" style='margin:0'>

<?php include 'topbar.php' ?>
<?php include 'sidebar.php' ?>

<maindiv>
<?php
	include 'multiplePages.Class.php';
	
	$page_no = 0;
	$no_of_pages = 20;
	$user = $_GET['username'];
	$conversionStatus = $_GET['conversionStatus'];
	if (isset($_GET['pageNo'])) {
		$page_no = $_GET['pageNo']; 
	}

	if (isset($_GET['numOfRec'])) {
		$no_of_pages = $_GET['numOfRec']; 
	}
	
	include 'sqli.php';
	
	$yy=date("m") - 1;
	$xx=date("Y")."-".$yy."-".'1';
	
	if ($user == 'na' && $conversionStatus == 'open') {
		$sql = "SELECT * FROM `rs_sales_query` where `Date` >='$xx'  AND `Conversion_Status`= '' ORDER BY `query_id` DESC ";
	} else if ($user == 'na' && $conversionStatus == 'close') {
		$sql = "SELECT * FROM `rs_sales_query` where `Date` >='$xx'  AND `Conversion_Status` <> '' ORDER BY `query_id`  DESC ";	
	} else if ($user == 'na' && $conversionStatus == 'Interested') {
			$sql = "SELECT * FROM `rs_sales_query` where  `Conversion_Status` = '$conversionStatus'  ORDER BY `query_id`  DESC ";
	}
	else if ($user != 'na' && $conversionStatus == 'open') {
		$user = $_SESSION['username'];
		$sql = "SELECT * FROM `rs_sales_query` where `Date` >='$xx'  AND `Conversion_Status`= '' AND `query_owner` = '$user' ORDER BY `query_id`  DESC ";
	}
	else {
		$user = $_SESSION['username'];
		$sql = "SELECT * FROM `rs_sales_query` where `Date` >='$xx'  AND `Conversion_Status` <> '' AND  `query_owner` = '$user' ORDER BY `query_id`  DESC ";
	}

	$user = $_SESSION['username'];

	$pages = new multiplePages($page_no,$no_of_pages,$sql,$db_handle,null);
	$records = $pages->totalRecord();

        echo "<p style='color:navy; font-size:20px;'> Totol records in this and last months: $records </p>";

	$fullSql = $sql.$pages->range;

	//echo $fullSql;

	$result = $db_handle->query($fullSql);
	echo $db_handle->error;

	$nextPage = $page_no + 1;

        $user = $_GET['username'];
        $conversionStatus = $_GET['conversionStatus'];

	$previousPage = $page_no;
	if ($previousPage != 1 ) $previousPage = $page_no - 1;
	else $previousPage = 0;

	echo "<multiPage>";
	echo '<a href = twoMonthsLeads.php?pageNo='.$previousPage.
		'&username='.$user.
		'&conversionStatus='.$conversionStatus. '>'.
		'   << '.' </a>';
	echo "***20 rec***";
	echo '<a href = twoMonthsLeads.php?pageNo='.$nextPage.
		'&username='.$user.
		'&conversionStatus='.$conversionStatus. '>'.
		'      >> </a>';
	echo "</multiPage>";
	
	echo '<table bgcolor="white" width="90%">';
	echo    '<tr>'.
		'<td> <h2> Lead ID </h2> </td>'.
		'<td> <h2> Creation Date </h2></td>'. 
		'<td> <h2> Customer Name </h2> </td>'.
		'<td> <h2> Phone number</h2> </td>'.
		'<td> <h2> Email </h2> </td>'. 
		'<td> <h2> Location </h2> </td>'.
		'<td> <h2> Convertion Status </h2> </td>'.
		'<td> <h2> Owner </h2> </td>'.
		'<td> <h2> Convert By </h2> </td>'.
		'</tr>';

	if ($result != null) {
        	while($row = $result->fetch_assoc()) {
                	echo    '<tr>'.
				'<td> <a href = sales_query.php?query_id='.$row["query_id"].'>'. $row["query_id"] .'</a> </td>'.
				'<td>'. $row["Date"] .'</td>'.
				'<td>'. $row["Name_of_Person"].'</td>'.
				'<td>'. str_replace(" ", "",$row["Contact_Number"]).'</td>'.
				'<td>'. $row["Mail_ID"].' </td> '.
				'<td>'.$row["Location"].'</td>'.
				'<td>'.$row["Conversion_Status"].' </td>'.
				'<td>'.$row["query_owner"].'</td>'.
				'<td>'.$row["Convert_By"].'</td>'.
				'</tr>';
		}
	}

$db_handle->close();
?>

</maindiv>
</body>
</html>
