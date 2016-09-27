<?php

class createDTRDAO extends DAO {

	public function saveDTR($emp_id,$month,$day, $year){

		$sql= "INSERT INTO tbl_createDTR(emp_id,month,day,year)
		VALUES('".$emp_id."','".
		$month."','".
		$day."','".
		$year."');";
		
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
	
	public function getDupDTR($emp_id,$month,$year){ //
	$sql = "SELECT
			emp_id,
			month,year
			FROM `tbl_createDTR`
			WHERE emp_id = $emp_id
			AND month = $month
			AND year = $year;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	// echo $sql;
	$this->bindQueryParam(':emp_id',  $emp_id);
	$this->bindQueryParam(':month',  $month);
	$this->bindQueryParam(':regionID',  $regionID);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"emp_id"=>$row["emp_id"],
					"month"=>$row["month"],
					"year"=>$row["year"],
					// "leave_credit"=>$row["leave_credit"],
					// "adaRefID"=>$row["adaRefID"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	// return $sql;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}
	
	public function getAllEmp(){ //
	$sql = "SELECT
			emp_id,
			empLastName,
			empFirstName,
			empMiddleName,
			empExtensionName,
			sex_id,
			schedule_id,
			salary_id,
			tax_category_id,
			date_hired
			FROM `tbl_employee`
			ORDER BY empLastName;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	// echo $sql;
	// $this->bindQueryParam(':emp_id',  $emp_id);
	// $this->bindQueryParam(':month',  $month);
	// $this->bindQueryParam(':regionID',  $regionID);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"emp_id"=>$row["emp_id"],
					"empLastName"=>$row["empLastName"],
					"empFirstName"=>$row["empFirstName"],
					"empMiddleName"=>$row["empMiddleName"],
					"empExtensionName"=>$row["empExtensionName"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	// return $sql;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}
	
	
	
	public function getAllMonth(){ //
	$sql = "SELECT month_id,month_val,month_title FROM `lib_month`;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	// echo $sql;
	// $this->bindQueryParam(':emp_id',  $emp_id);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"month_id"=>$row["month_id"],
					"month_val"=>$row["month_val"],
					"month_title"=>$row["month_title"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	// return $sql;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}
	
	public function getAllDay(){ //
	$sql = "SELECT day_id,day_title FROM `lib_day`;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	// echo $sql;
	// $this->bindQueryParam(':emp_id',  $emp_id);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"day_id"=>$row["day_id"],
					"day_title"=>$row["day_title"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	// return $sql;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}
	
	public function getAllYear(){ //
	$sql = "SELECT year_id,year_val FROM `lib_year` where year_val = '2016';";
	
	$this->openDB();
	$this->prepareQuery($sql);
	// echo $sql;
	// $this->bindQueryParam(':emp_id',  $emp_id);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"year_id"=>$row["year_id"],
					"year_val"=>$row["year_val"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	// return $sql;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}
	
	
	public function getAllEmp2($month,$year){ //
	$sql = "SELECT
			emp_id,
			empLastName,
			empFirstName,
			empMiddleName,
			empExtensionName,
			sex_id,
			schedule_id,
			salary_id,
			tax_category_id,
			date_hired
			FROM `tbl_employee`
			where emp_id not in (Select emp_id from tbl_createDTR where month='".$month."' and year = '".$year."')
			ORDER BY empLastName;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	// echo $sql;
	// $this->bindQueryParam(':emp_id',  $emp_id);
	$this->bindQueryParam(':month',  $month);
	$this->bindQueryParam(':year',  $year);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"emp_id"=>$row["emp_id"],
					"empLastName"=>$row["empLastName"],
					"empFirstName"=>$row["empFirstName"],
					"empMiddleName"=>$row["empMiddleName"],
					"empExtensionName"=>$row["empExtensionName"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	// return $sql;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}
	
	public function getYearNow(){ //
	$sql = "SELECT SUBSTR(now() FROM 1 FOR 4) as YearNow, SUBSTR(now() FROM 6 FOR 2) as MonthNow;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	// echo $sql;
	// $this->bindQueryParam(':emp_id',  $emp_id);
	// $this->bindQueryParam(':month',  $month);
	// $this->bindQueryParam(':year',  $year);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"YearNow"=>$row["YearNow"],
					"MonthNow"=>$row["MonthNow"],
					// "empFirstName"=>$row["empFirstName"],
					// "empMiddleName"=>$row["empMiddleName"],
					// "empExtensionName"=>$row["empExtensionName"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	// return $sql;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}
	
	
}
	
?>
