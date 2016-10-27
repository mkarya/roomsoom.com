<?php
include 'myTableInformation.php';

class mysqlForm
{
var $link;
var $db;
var $tableInfo;	
var $currentQueryResult;
var $errList;

	function mysqlForm($conn)
	{
		$this->link=$conn; 
					
	} 
	
	function getTableInformation() {
		if ($this->tableInfo != null ) {
			return;
		}
		else {
			$this->tableInfo = new myTableInformation($this->link, $this->currentQueryResult,null);
		}
		return;
	}
	


function createList($type,$name)
{
	$ENUMvalues=substr($type,5,strlen($type)-6);
	echo "<select name=$name>";
	foreach(explode(',',$ENUMvalues) as $val)
	{
		$fieldValue=substr($val,1,strlen($val)-2);
		echo "<option value='$fieldValue'>$fieldValue</option>";
	} 
	echo "</select>";
	
}

function addOption($key,$value) {
	$res = $this->tableInfo->getComment($key);
	if($res != "") {
		echo "<select name=$key>";
		switch($res) {
			case "type_employee":
				$sql = "select username from user_profile";
				$res1 = $this->link->query($sql);
				echo "<option value='$value'>".$value."</option>";
				while($row = $res1->fetch_assoc()) {
					echo "<option value=".$row["username"].">".$row["username"]."</option>";
				}
				echo "</select>";
				break;
			default:
				echo "<option value='$value'>".$value."</option>";
				$item = explode(",",$res);
				foreach($item as $kk) {
					echo "<option value='$kk'>$kk</option>";
				}
		}
		
		echo "</select>";
		return 'PASS';					
	}
	//print $sql;
	return 'FAIL';
}
	


function printFormForPostAruments($action,$ignore_list,$tablename)
{
	$sql = "select 'query_id' from `$tablename`";
	$result = $this->link->query($sql);
	$this->tableInfo = new myTableInformation($this->link, $result, $tablename);
				
	echo "<form action='$action' method='POST'>";		
	echo '<table style="width:100%">';
	
	foreach($_POST as $key => $value)
	{		
		$fieldtype = $this->tableInfo->getType($key);
		if($counter%2 == 0) {
			echo "<tr>";
		}
		$counter = $counter + 1;
	
		echo "<td align=left>". $key."</td>";
		echo "<td align=left> &nbsp;&nbsp;&nbsp;";
		
		if ($fieldtype=='date') {
			echo "<input type=date name=$key value='$value'>";
			echo "format: yyyy-mm-dd";
		}
		else if ($this->tableInfo->getPrimary($key) == "PRI") {
			echo "<input type=text name='$key' value='$value'>";
			
		}
		else if ($this->addOption($key,$value) == 'FAIL') { 
			echo "<input type=text name='$key' value='$value'>";

		}	
		echo "</td>";
		if($counter%2 == 0) {
			echo "</tr>";
		}	
		
	}
	echo "</tr>";
	echo "<tr> <td colspan=2>  <div align=center>
			<input type=Submit value=Submit>
	        <input type=reset value=Reset>
		</div></td></tr>";	
	echo "</table>";
	echo "</form>";		
		
}//end of printForm

function printFormForRow($result,$action,$ignore_list)
{
$this->currentQueryResult = $result;
$this->getTableInformation();
$this->errList = $errorList;
	
if($result ){			
	echo "<form action='$action' method='POST'>";		
	echo '<table style="width:100%">';

	$row2 = $result->fetch_assoc();
	$row = $row2;
	
	foreach($row2 as $key => $value)
	{		
		$fieldtype = $this->tableInfo->getType($key);
		if($counter%2 == 0) {
			echo "<tr>";
		}
		$counter = $counter + 1;
	
		echo "<td align=left>". $key."</td>";
		echo "<td align=left> &nbsp;&nbsp;&nbsp;";
		
		if ($fieldtype=='date') {
			echo "<input type=date name=$key value='$value'>";
			echo "format: yyyy-mm-dd";
		}
		else if ($this->tableInfo->getPrimary($key) == "PRI") {
			echo "<input type=text name=$key value='$value'>";
			
		}
		else if ($this->addOption($key,$value) == 'FAIL') { 
			$kk = str_replace(" ", "--", $key);
			$kv = str_replace(" ", "--", $value);
			echo "<input type=text name='$kk' value='$value'>";

		}	
		echo "</td>";
		if($counter%2 == 0) {
			echo "</tr>";
		}	
		
	}
	echo "</tr>";
	echo "<tr> <td colspan=2>  <div align=center>
			<input type=Submit value=Submit>
	        <input type=reset value=Reset>
		</div></td></tr>";	
	echo "</table>";
	echo "</form>";		
	}
else
	{
		echo "Sorry! Not a valid result set";
	}		
}//end of printForm

function pagefromTable($table,$action,$ignore_fields)
{
$sql="select * from $table";
$result = $this->link->query($sql);
$this->currentQueryResult = $result;
$this->getTableInformation();
$sql = "describe $table";
$result = $this->link->query($sql);

if($result != null ){	
	echo "<p style='color:navy;'> please use date format : yyyy-mm-dd </p>";	
	echo "<form action='$action' method='post'>";		
	
	$counter=0;
	
	while($row = $result->fetch_assoc())
	{		
		
		if($counter%2 == 0) {
			echo "<tr>";
		}
		$counter = $counter + 1;
		
		$fieldname=$row["Field"];
		$fieldtype=$row["Type"];
		if (in_array($fieldname, $ignore_fields)){
			continue;
		}
	
		echo $fieldname.":   ";
		
		if ($fieldtype=='date') {
			echo "<input type=date name=$fieldname value=''>";
		}
		else if ($this->addOption($fieldname,"") == 'FAIL') { 
			$kk = $this->tableInfo->getDefault($fieldname );
			$kf = str_replace(" ","--",$fieldname);
			$len = $this->tableInfo->getFieldLenght($fieldname);
			
			if ($len > 700) {
				echo "<input style='width:50%;height:120px;' type=text name='$kf' value='$kk'>";
			}
			else echo "<input type=text name='$kf' value='$kk'>";
		}
		
		if($counter%2 == 0) {
			echo "<br>";
		}
		else echo "<span class='white-text' style='margin: 7em;'> ";	
		
	}

		echo " <div align=center>
				<input type=Submit value=Submit>
		        <input type=reset value=Reset>
			</div>";	
		echo "</form>";		
    }// end of if statement.
		
}//end of printForm 

function pagefromTableorig($table,$action,$ignore_fields)
{
$sql="select * from $table";
$result = $this->link->query($sql);
$this->currentQueryResult = $result;
$this->getTableInformation();
$sql = "describe $table";
$result = $this->link->query($sql);

if($result != null ){		
	echo "<form action='$action' method='post'>";	
	//echo '<table border="0" bgcolor="grey" width="100%">';	
	echo '<table style="width:90%">';	
	//printing heading
	$counter=0;
	
	while($row = $result->fetch_assoc())
	{		
		if($counter%2 == 0) {
			echo "<tr>";
		}
		$counter = $counter + 1;
		
		$fieldname=$row["Field"];
		$fieldtype=$row["Type"];
		if (in_array($fieldname, $ignore_fields)){
			continue;
		}
	
		echo "<td align=left>". $fieldname."</td>";
		echo "<td align=left> &nbsp;&nbsp;&nbsp;";
		
		if ($fieldtype=='date') {
			echo "<input type=date name=$fieldname value=''>";
			echo "format : yyyy-mm-dd";
		}
		else if ($this->addOption($fieldname,"") == 'FAIL') { 
			$kk = $this->tableInfo->getDefault($fieldname );
			$kf = str_replace(" ","--",$fieldname);
			echo "<input type=text name='$kf' value='$kk'>";
		}
		echo "</td>";
		if($counter%2 == 0) {
			echo "</tr>";
		}	
		
	}
	echo "</tr>";
	echo "<tr> <td colspan=2>  <div align=center>
			<input type=Submit value=Submit>
	        <input type=reset value=Reset>
		</div></td></tr>";	
	echo "</table>";
	echo "</form>";		
	}
else
	{
		echo "Sorry! Not a valid result set";
	}		
}//end of printForm
}//end of class
?>