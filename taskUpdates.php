<?php

class taskUpdates
{

var $db;	
	function mysqlForm($conn)
	{
		
	} 

//This function assumes that $_POST has all values Prints result set as a table
function compareDB2Post($DB_values) {
$row = "";
$changedValues = "";
if ($DB_values->num_rows != 1) {
	$row = $DB_values->fetch_assoc();
}

foreach($row as $key => $value) {
	if ($value != $_POST($key) {
		$changedValues[$key] = $_POST($key);
	}
}


		 

	

function printResult($result,$format="border=1")
{
if($result)
	{
	echo "<table $format><tr>";	
	$totalField=mysql_num_fields($result);
	
	//printing heading
	for($i=0;$i < $totalField ; $i++)
		echo "<th>".mysql_field_name($result,$i) ."</th>";
	echo "</tr>";	
	
	//Printing rows
	while ($row = mysql_fetch_array($result,MYSQL_NUM))
		{
		echo "<tr>";
			foreach($row as $v)
			{
			echo "<td>". $v ."</td>";	
			} 
		echo "</tr>";	
		}
	echo "</table>";		
	}
else
	{
		echo "Sorry! Not a valid result set: ".mysql_error();
	}		
}//end of printResult	

//Create combobox for enumaration fields
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


//Prints form for a table
function printForm($table,$action,$skip="-1")
{
//$result=mysql_query("Select * from  $table limit 0,1",$this->link);
$sql="Select * from  $table limit 0,1";
$result = $this->$link->query($sql);	
if($result->num_rows > 0)
	{
	$skipfields=explode(',',$skip);
	$stracture=$this->link->query("describe $table");	
	$isEnum=false;
	
		
	echo "<form name=anisForm action='$action' method=post>";	
	echo "<table border=0 cellpadding=3 cellspacing=0>";	
	
	//Printing Fields
	//$totalField=mysql_num_fields($result);
	$totalField=$result->num_rows;
	
	//printing heading
	for($i=0;$i < $totalField ; $i++)
	{
	//If this field to avoid cresting input field	
	if(in_array($i,$skipfields))
		continue;

	//Detacting if this field is ENUM	
	$type=mysqli_result($stracture,$i,1);
	if(strpos($type,'enum')===false)
	 	$isEnum=false;
	 else
	 	$isEnum=true;			
		
	echo "<tr>";
	$field_info = $resule->fetch_field();
	//$fieldname=mysql_field_name($result,$i);
	//$fieldlength=mysql_field_len($result,$i);
	//$fieldtype=mysql_field_type($result,$i);
	$fieldname=$field_info->name;
	$fieldlength=$field_info->max_lenght;
	$fieldtype=$field_info->type;
	
		echo "<td align=left>". $fieldname."</td>";
		echo "<td align=left> &nbsp;&nbsp;&nbsp;";
		
		if($isEnum) $this->createList($type,$fieldname);
		else if($fieldname=='password')
			echo "<input type=password name=$fieldname size=20>";
		else if($fieldlength>50)
			echo "<textarea rows='5' cols='50' wrap='virtual' name=$fieldname ></textarea>";
		else
			echo "<input type=text name=$fieldname size=".($fieldlength+5)*1 .">";
		echo "</td>";
	echo "</tr>";	
	}
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

function printFormForRow($result,$action,$skip="-1")
{
//$result = $data;	
if($result )
	{
	$skipfields=explode(',',$skip);
	//$stracture=$this->link->query("describe $table");	
	$isEnum=false;
	
		
	echo "<form name=anisForm action='$action' method=post>";	
	//echo '<table border="0" bgcolor="grey" width="100%">';	
	echo '<table style="width:50%">';
	//Printing Fields
	//$totalField=mysql_num_fields($result);
	//$totalField=$result->field_count;;
	
	//printing heading
	$row2 = $result->fetch_assoc();
	$counter=0;
	
	foreach($row2 as $key => $value)
	{		
		if($counter%2 == 0) {
			echo "<tr>";
		}
		$counter = $counter + 1;
		$field_info = $result->fetch_field();
		//$fieldname=mysql_field_name($result,$i);
		//$fieldlength=mysql_field_len($result,$i);
		//$fieldtype=mysql_field_type($result,$i);
		$fieldname=$field_info->name;
		$fieldlength=$field_info->max_lenght;
		$fieldtype=$field_info->type;
		if(strpos($fieldtype,'enum')===false)
	 		$isEnum=false;
	 	else
	 		$isEnum=true;
	
		echo "<td align=left>". $fieldname."</td>";
		echo "<td align=left> &nbsp;&nbsp;&nbsp;";
		$row2 = $result->fetch_assoc();
		
		if($isEnum) $this->createList($type,$fieldname);
		else if($fieldname=='password')
			echo "<input type=password name=$fieldname size=20>";
		else if($fieldlength>50)
			echo "<textarea rows='5' cols='50' wrap='virtual' name=$key value=".$value.  "></textarea>";
		else if ($fieldtype=='date') 
			echo "<input type=date name=$key value=$value>";
		else
			echo "<input type=text name=$key value=$value>";
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