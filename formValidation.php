<?php

class formValidation
{
var $link;
var $errArray;

	function formValidation($conn)
	{
		$this->link = $conn;
		$this->errArray["result_value_not_null_check"] = "pass";
		$this->errArray["result_pair_not_null_check"] = "pass";	
		$this->errArray["result_date_verification"] = "pass";	
	}
	
	function verifyDate($date) {
		list($y, $m, $d) = array_pad(explode('-', $date, 3), 3, 0);
		$res = checkdate($m, $d, $y);		
		if ($res == false ) {
			echo "<p><font size='3' color='red'> Date is in wrong format. </font> </p><br>";
			$this->errArray["result_date_verification"] = "fail";
		}
	}
	
	function initializaErrorArrayFromPost() {
		foreach ($_POST as $key => $value) {
			$this->errArray[$key] = '';
		}
	}
	
	
	function verifyParameters2NotNull($fieldname) {
		//if ($this->errArray["result_value_not_null_check"] == "pass") {
			foreach ($fieldname as $field) {
				if (empty($_POST[$field])) {
					$this->errArray[$field] = "$field can not be empty.";
					echo "<p><font size='3' color='red'> $field:  can not be enpty. </font> </p><br>";
					$this->errArray["result_value_not_null_check"] = "fail";
				}
			}
		//}
	}
	
	function verifyPairforNull($first,$second) {
		if ($this->errArray["result_pair_not_null_check"] == "pass") {
			if (empty($_POST[$first]) && empty($_POST[$second])) $this->errArray["result_pair_not_null_check"] = "pass";
			else if (!empty($_POST[$first]) && !empty($_POST[$second])) $this->errArray["result_pair_not_null_check"] = "pass";
			else {
				echo "<p><font size='3' color='red'> $first or $second field need input. </font> </p><br>";
				$this->errArray["result_pair_not_null_check"] = "fail";
			}
		}
	}
	
	function getValidationResult() {
		if ($this->errArray["result_value_not_null_check"] == "pass" && $this->errArray["result_pair_not_null_check"] == "pass" && 
		    $this->errArray["result_date_verification"] == "pass") return true;
		else return false;
	}
	
}//end of class
?>