<?php

class myTableInformation
{
var $link;
var $tablename;	
var $name;
var $type;
var $key;
var $default;
var $extra;
var $length;

	function myTableInformation($conn,$result,$tablename)
	{
		$this->link = $conn;
		if ($tablename == null) {
	  		while ($fieldinfo=$result->fetch_field())
	    		{
	    			
	    			$this->tablename = $fieldinfo->table;
	    			break;
	    		}
	    	}
	    	else {
	    		$this->tablename = $tablename;
	    	}
	    	
    		$this->setTableConfiguration();
    	}
    	
    	
    	Private function setTableConfiguration() {	
    		
    		$sql = "SHOW FULL COLUMNS FROM ".$this->tablename;
    		$res = $this->link->query($sql);
    		$sql01 = "select * from ". $this->tablename. " limit 2";
    		$res01 = $this->link->query($sql01);
    		$len = $res01->lengths;//$res->lengths;
    		
    		while ($row = $res->fetch_assoc()) {
    			$this->name["Field"] = $row["Field"];
    			$field = $row["Field"];
    			$this->type[$field] = $row["Type"];
    			$this->key[$field] = $row["Key"];
    			$this->default[$field] = $row["Default"];
    			$this->extra[$field] = $row["Extra"];
    			$this->comment[$field] = $row["Comment"];
    			$this->lenght[$field] = $this->fieldLenght($row["Type"]);		 
    		}
	} 
	
	private function fieldLenght($fieldType) {
	        $kk = explode("(", $fieldType);
	        if ($kk[0] = "varchar") {
	        	$lenght = explode( ")", $kk[1]);
	        	return (int)$lenght[0];
	        }
	 	return (int)0;
	 }

	
	function getType($fieldname) {
		return $this->type[$fieldname];
	}

	function getPrimary($fieldname) {
		return $this->key[$fieldname];
	}
	
	function getDefault($fieldname) {
		return $this->default[$fieldname];
	}
	
	function getExtra($fieldname) {
		return $this->extra[$fieldname];
	}
	
	function getComment($fieldname) {
		return $this->comment[$fieldname];
	}
	
	public function getFieldLenght ($fieldname) {
		return $this->lenght[$fieldname];
	}

}//end of class
?>