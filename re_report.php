<?php

class rsSalesLeadsReport {
	var $teritory;
	var $conn;
	var $startDate;
	var $endDate;
	var $colMarker;
	var $space;
	var $report;

	function rsSalesLeadsReport($conn) { 
		$this->conn = $conn;
	}

	public function setMonthNumber($month) {
		$year = Date("Y");
		if ($month > Date("m")) $year = $year - 1;
		$this->startDate = $year."-".$month.'-1';
		$this->endDate = $year."-".$month.'-31';
		$this->colMarker = "`";
		$this->space = " ";
		$this->getDistinctTeritory();
	} 

	public function getDistinctTeritory() {
		$sql = "SELECT DISTINCT `Teritory` FROM `rs_sales_query` WHERE `Date` >= ".
			"'".$this->startDate."'".
			" AND `Date` <= ".
			"'".$this->endDate."'";
		//var_dump($sql);
		$res = $this->conn->query($sql);
		$this->teritory = array();
		if ($res) {
			$i = 0;
			while ($row = $res->fetch_assoc()) {
				$this->teritory[$i] = $row["Teritory"];
				$i += 1;
			}
			//var_dump($this->teritory);
		}
	}

	public function getCount($columnName, $condition) {
		$sql = "SELECT COUNT(`$columnName`) FROM `rs_sales_query` WHERE $condition";
		//var_dump($sql);
		$res = $this->conn->query($sql);
		if($res) {
			$row = $res->fetch_assoc();
			foreach ($row as $key => $value) return $value;
		}
		return 0;
	}
			
			

	public function printMonthReport() {
		if ($this->report == null) {
			$this->prepareThisMonthReport();
		}

		echo $this->report;
	}

	public function getThisMonthReport() {
		if ($this->report == null) {
			$this->prepareThisMonthReport();
		}
		
		return $this->report;
	}

	public function prepareThisMonthReport() {
		$totalLeads = 0;
		$totalConversion = 0;
		$tempSql = "`Date` >= '".$this->startDate."' AND `Date` <= '".$this->endDate."' AND `Teritory` =";
		$month = explode("-",$this->startDate);
		$monthName = date('F', mktime(0, 0, 0, $month[1], 10));
		$this->report .= "<p style='color:red;font-weight: bold;font-size:18px'> Report summary Month : ". $monthName.
			"</p>";
			
		$this->report .= "<table>";
		$this->report .= "<tr>";
		$this->report .= "<th> Teritory Name </th>".
			"<th> Totol Leads  </th>".
			"<th> Converted  Leads  </th>".
			"<th> % Conversion  </th>".
			"<th> Leads : Boys </th>".
			"<th> Leads : Girls </th>".
			"</tr>";

		foreach ($this->teritory as $key => $row) {
			$count1 = $this->getCount("Teritory",$tempSql." "."'".$row."'");
			$count2 = $this->getCount("Teritory",$tempSql.$this->space."'".$row."'"." AND `Conversion_Status` = 'Interested'");
			$count3 = $this->getCount("Teritory",$tempSql.$this->space."'".$row."'"." AND `Category` IN ('Boys','BOYS','boy','Boy')");
			$count4 = $this->getCount("Teritory",$tempSql.$this->space."'".$row."'"." AND `Category` IN ('Girls','GIRLS','girl','Girl')");
			$totalLeads += $count1;
			$totalConversion += $count2;
			$boys += $count3;
			$girls += $count4;
                	$this->report .= "<tr>";
                	$this->report .= "<td>".$row."  </td>".
                		"<td>".$count1 . " </td>".
                		"<td>".$count2 . " </td>".
                		"<td>".ceil(($count2/$count1)*100) . " </td>".
                		"<td>".$count3 . " </td>".
                		"<td>".$count4 . " </td>".
                        	"</tr>";
				
		}

		$this->report .= "<tr style='color:navy;font-weight: bold;font-size:18px'>" .
			"<td> Total </td>".
			"<td> $totalLeads </td>".
			"<td> $totalConversion </td>".
			"<td >". ceil(($totalConversion/$totalLeads)*100)." </td>".
			"<td> $boys </td>".
			"<td> $girls </td>".
			"</tr>";
					

		$this->report .= "</table>";
	}

}
?>
