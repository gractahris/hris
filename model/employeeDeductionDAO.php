<?php
class employeeDeductionDAO extends DAO {

	public function getDeductionByEmp($emp_id){ //
	$sql = "SELECT
			deduction_ref_id,
			deduction_id,
			deduction_amount,
			emp_id
			FROM `tbl_employee_deduction`
			WHERE emp_id = $emp_id";
	
	$this->openDB();
	$this->prepareQuery($sql);
	$this->bindQueryParam(':emp_id',  $emp_id);
	// $this->bindQueryParam(':regionID',  $regionID);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"deduction_id"=>$row["deduction_id"],
					"deduction_amount"=>$row["deduction_amount"],
					"emp_id"=>$row["emp_id"],
					// "adaRefID"=>$row["adaRefID"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}

	public function getDeductionType($deduction_id){ //
	$sql = "SELECT
			deduction_id,
			deduction_title
			FROM `lib_deduction`
			WHERE deduction_id = $deduction_id";
	
	$this->openDB();
	$this->prepareQuery($sql);
	$this->bindQueryParam(':deduction_id',  $deduction_id);
	// $this->bindQueryParam(':regionID',  $regionID);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"deduction_id"=>$row["deduction_id"],
					"deduction_title"=>$row["deduction_title"],
					// "emp_id"=>$row["emp_id"],
					// "adaRefID"=>$row["adaRefID"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}


	public function getAllMonth(){ //
	$sql = "SELECT
			month_id,
			month_val,
			month_title
			FROM `lib_month`";
	
	$this->openDB();
	$this->prepareQuery($sql);
	// $this->bindQueryParam(':emp_id',  $emp_id);
	// $this->bindQueryParam(':regionID',  $regionID);
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
					// "adaRefID"=>$row["adaRefID"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}

	public function getAllYear(){ //
	$sql = "SELECT
			year_id,
			year_val
			FROM `lib_year`";
	
	$this->openDB();
	$this->prepareQuery($sql);
	// $this->bindQueryParam(':emp_id',  $emp_id);
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
					// "month_title"=>$row["month_title"],
					// "adaRefID"=>$row["adaRefID"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}
	

	public function saveOtherDeduction($emp_id,$deduction_title,$deduction_amount,$month,$year,$cut_off_id){

		$sql= "INSERT INTO tbl_other_deduction(emp_id,deduction_title,deduction_amount,month,year,cut_off_id)
		VALUES('".$emp_id."','".
		$deduction_title."','".
		$deduction_amount."','".
		$month."','".
		$year."','".
		$cut_off_id."');";
		
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


	public function getOtherDeductionByID($emp_id){ //
	$sql = "SELECT other_deduction_id,
			deduction_title,
			deduction_amount,
			month,year,emp_id,cut_off_id
			FROM `tbl_other_deduction`
			WHERE emp_id = $emp_id";
	
	$this->openDB();
	$this->prepareQuery($sql);
	// echo $sql;
	$this->bindQueryParam(':emp_id',  $emp_id);
	// $this->bindQueryParam(':regionID',  $regionID);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"emp_id"=>$row["emp_id"],
					"deduction_title"=>$row["deduction_title"],
					"deduction_amount"=>$row["deduction_amount"],
					"month"=>$row["month"],
					"year"=>$row["year"],
					"other_deduction_id"=>$row["other_deduction_id"],
					"cut_off_id"=>$row["cut_off_id"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}

	public function getAllCutOff(){ //
	$sql = "SELECT cut_off_id,
				cut_off_title
			FROM `lib_cutoff`";
	
	$this->openDB();
	$this->prepareQuery($sql);
	// echo $sql;
	$this->bindQueryParam(':emp_id',  $emp_id);
	// $this->bindQueryParam(':regionID',  $regionID);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"cut_off_id"=>$row["cut_off_id"],
					"cut_off_title"=>$row["cut_off_title"],
					// "deduction_amount"=>$row["deduction_amount"],
					// "month"=>$row["month"],
					// "year"=>$row["year"],
					// "other_deduction_id"=>$row["other_deduction_id"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}
	

	public function updateOtherDeduction($other_deduction_id,
							$deduction_title,
							$deduction_amount,$month,$year
							){

		$sql= "UPDATE tbl_other_deduction
				SET deduction_title = '".$deduction_title."',
				deduction_amount = '".$deduction_amount."',
				month = '".$month."',
				year = '".$year."'
				WHERE other_deduction_id = ".$other_deduction_id.";";
		
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


	public function getOtherDeduction($other_deduction_id){ //
	$sql = "SELECT other_deduction_id,
			deduction_title,
			deduction_amount,
			month,year,emp_id,cut_off_id
			FROM `tbl_other_deduction`
			WHERE other_deduction_id = $other_deduction_id";
	
	$this->openDB();
	$this->prepareQuery($sql);
	// echo $sql;
	$this->bindQueryParam(':other_deduction_id',  $other_deduction_id);
	// $this->bindQueryParam(':regionID',  $regionID);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"emp_id"=>$row["emp_id"],
					"deduction_title"=>$row["deduction_title"],
					"deduction_amount"=>$row["deduction_amount"],
					"month"=>$row["month"],
					"year"=>$row["year"],
					"other_deduction_id"=>$row["other_deduction_id"],
					"cut_off_id"=>$row["cut_off_id"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}

	public function getSumAmount($emp_id,$month,$year,$cut_off_id){ //
	$sql = "SELECT sum(deduction_amount) as totalOD
			FROM `tbl_other_deduction`
			where emp_id = '".$emp_id."'
			and month = '".$month."'
			and year = '".$year."'
			and cut_off_id = '".$cut_off_id."';";
	
	$this->openDB();
	$this->prepareQuery($sql);
	// echo $sql;
	$this->bindQueryParam(':emp_id',  $emp_id);
	// $this->bindQueryParam(':regionID',  $regionID);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"totalOD"=>$row["totalOD"],
					// "deduction_title"=>$row["deduction_title"],
					// "deduction_amount"=>$row["deduction_amount"],
					// "month"=>$row["month"],
					// "year"=>$row["year"],
					// "other_deduction_id"=>$row["other_deduction_id"],
					// "cut_off_id"=>$row["cut_off_id"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}


}
	
?>
