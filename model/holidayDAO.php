<?php

class holidayDAO extends DAO {

	
	public function getAllHoliday(){ //
	$sql = "SELECT holiday_id, holiday_title, holiday_month, holiday_day, holiday_year, holiday_type, holiday_payroll_val
		FROM `lib_holiday`;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	// $this->bindQueryParam(':adaRefID',  $adaRefID);
	// $this->bindQueryParam(':regionID',  $regionID);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"holiday_id"=>$row["holiday_id"],
					"holiday_title"=>$row["holiday_title"],
					"holiday_month"=>$row["holiday_month"],
					"holiday_day"=>$row["holiday_day"],
					"holiday_year"=>$row["holiday_year"],
					"holiday_type"=>$row["holiday_type"],
					"holiday_payroll_val"=>$row["holiday_payroll_val"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}

	public function insertHoliday($holiday_title, $holiday_month, $holiday_day, $holiday_year, $holiday_type, $holiday_payroll_val){ //
	$sql = "INSERT INTO lib_holiday(holiday_title, holiday_month, holiday_day, holiday_year, holiday_type, holiday_payroll_val)
		VALUES('".$holiday_title."','".
		$holiday_month."','".
		$holiday_day."','".
		$holiday_year."','".
		$holiday_type."','".
		$holiday_payroll_val."');";
	
		// echo $sql;
		$this->openDB();
		$this->prepareQuery($sql);
		$this->beginTrans();
				$result = $this->executeUpdate();
			
				if($result) {
					$this->commitTrans();
					$this->closeDB();
					return true; 
				} else {
					$this->rollbackTrans();
					$this->closeDB();
					return false; 
				}
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}

	public function getMonthByVal($month_val){ //
	$sql = "SELECT month_id, month_title, month_val
		FROM `lib_month`
		WHERE month_Val = :month_val;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	$this->bindQueryParam(':month_val',  $month_val);
	// $this->bindQueryParam(':regionID',  $regionID);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"month_id"=>$row["month_id"],
					"month_title"=>$row["month_title"],
					"month_val"=>$row["month_val"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}

	public function getAllMonth(){ //
	$sql = "SELECT month_id, month_title, month_val
		FROM `lib_month`;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	// $this->bindQueryParam(':month_val',  $month_val);
	// $this->bindQueryParam(':regionID',  $regionID);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"month_id"=>$row["month_id"],
					"month_title"=>$row["month_title"],
					"month_val"=>$row["month_val"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}

	public function getAllDay(){ //
	$sql = "SELECT day_id, day_title
		FROM `lib_day`;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	// $this->bindQueryParam(':month_val',  $month_val);
	// $this->bindQueryParam(':regionID',  $regionID);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"day_id"=>$row["day_id"],
					"day_title"=>$row["day_title"],
					// "month_val"=>$row["month_val"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}

	public function getAllYear(){ //
	$sql = "SELECT year_id, year_val
			FROM `lib_year`;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	// $this->bindQueryParam(':month_val',  $month_val);
	// $this->bindQueryParam(':regionID',  $regionID);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"year_id"=>$row["year_id"],
					"year_val"=>$row["year_val"],
					// "month_val"=>$row["month_val"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}

	public function delHoliday($holiday_id){

		$sql= "DELETE FROM lib_holiday
			   WHERE holiday_id = $holiday_id;";
		
		  // echo $sql;
		$this->openDB();
		$this->prepareQuery($sql);
		$this->beginTrans();
				$result = $this->executeUpdate();
			
				if($result) {
					$this->commitTrans();
					$this->closeDB();
					return true; 
				} else {
					$this->rollbackTrans();
					$this->closeDB();
					return false; 
				}
	}

	
	
	
}
	
?>
