<?php 

class multiplePages {
	var $pageNo;
	var $numberOfRecord;
	var $range;
	var $conn;
	var $sql;
	var $data;

	function multiplePages($pageNo, $numberOfRecord, $sql, $conn, $header) {
		$this->pageNo = $pageNo;
		$this->numberOfRecord = $numberOfRecord; 
		$this->conn = $conn;
		$this->sql = $sql;
		$this->calculateRange();
	}

	private function calculateRange() {
		$first = $this->pageNo * $this->numberOfRecord;
		$second = $first + $this->numberOfRecord;
		$this->range = " LIMIT ".$this->numberOfRecord. " OFFSET ".$first;
	}


	private function getData() {
		$sql = $this->sql." ".$this->range;
		$result = $this->conn->query($sql);
		echo $this->conn->error;
		if ($result != null ) {
			$this->data = $result->fetch_assoc();
		}

	}

	public function totalRecord() {
		$res = $this->conn->query($this->sql);
		if ($res) {return $res->num_rows;}
		return 0;
	}

	public function printTable() {
		echo "<table style='bgcolor:white;width:90%;' >";
		echo "<tr>";
		foreach ($header as $key) {
			echo "<td> $key </td>";
		}
		echo "<\tr>";
		while($data) {
                	echo "<tr>";
                	foreach ($data as $key) {
                        	echo "<td> $key </td>";
                	}
			echo "<\tr>";
		}

	}

}

?>




 	
	

	
		
