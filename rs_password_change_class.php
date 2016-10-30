<?php

class rs_password_change_class {

	var $user;
	var $link;
	var $errorMsg;
	var $oldPassword;
	var $newPassword;
	var $oldPasswordError;
	var $newPasswordError;
	var $printForm;

	function rs_password_change_class($conn, $user) {
		$this->user = $user;
		$this->link = $conn;
		$this->oldPasswordError = "";
		$this->newPasswordError = "";
		$this->newPassword = "";
		$this->printForm = true;
		$sql = "SELECT * FROM `info` WHERE `username` = '$user'";
		$res = $this->link->query($sql); 
		if ($res == null) {
			$this->errorMasg = $this->link->error;
		} else {
			$row = $res->fetch_assoc();
			$this->oldPassword = $row["password"];
		}
	}
		
	function verifyOldPassword($oldPassword){
		echo "$this->oldPassword !== $oldPassword";
		if ($this->oldPassword !== $oldPassword) {
			$this->oldPasswordError = "old password does not match with Database";
			$this->printForm = true;
			return false;
		}
		return true;
	}

	function verifyNewPassword($oldPassword, $confirmOldPassword){
		echo "$oldPassword !== $confirmOldPassword";
		if ($oldPassword !== $confirmOldPassword) {
			$this->newPasswordError = "New password does not match with Cofirm password";
			$this->printForm = true;
			return false;
		}
		$this->newPassword = $oldPassword;
		return true;
	}


	function printPassWordChangeForm($actionFile) {
		echo "<p style='color:red'> Please complete password change  form and submit.  </p>";
		echo "<form action=$actionFile method='post'>";
		echo "Old Password        :";
		echo "<input type='password' name='oldPassword' value=''>";
		echo "<p style='color:red'>". $this->oldPasswordError . "</p>";
		echo "New Password        :";
		echo "<input type='password' name='newPassword' value=''>";
		echo "<p style='color:red'>". $this->newPasswordError . "</p>";
		echo "Confirm New Password :";
		echo "<input type='password' name='confirmNewPassword' value=''>";
		echo "<br>";
		echo "<input type='submit' value='SUBMIT'>";
		echo "</form>";
	}

	function changePassWord($user) {
		$sql = "UPDATE `info` SET `password` = '$this->newPassword' WHERE `username` = '$user'";
		echo $sql;
		$res = $this->link->query($sql);
		if ($res == false) {
			$this->errorMsg = "password change to DB is not successful, please try afain".$this->link->error;
			$this->printForm = true;
		} else { 
			$this->printForm = false; 
			echo "Password change is succesful, please use new password at time of next login.";}
	}
		

} // end of class
?>

