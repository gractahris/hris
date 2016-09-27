<?php

class leaveCreditDAO extends DAO {

	public function getLeaveCreditByEmp($emp_id,$leave_type_id){ //
	$sql = "SELECT
			emp_leave_credit_id,
			emp_id,
			leave_type_id,
			leave_credit
			FROM `tbl_employee_leavecredit`
			WHERE emp_id = $emp_id
			and leave_type_id = $leave_type_id";
	
	$this->openDB();
	$this->prepareQuery($sql);
	// echo $sql;
	$this->bindQueryParam(':emp_id',  $emp_id);
	$this->bindQueryParam(':leave_type_id',  $leave_type_id);
	// $this->bindQueryParam(':regionID',  $regionID);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"emp_leave_credit_id"=>$row["emp_leave_credit_id"],
					"emp_id"=>$row["emp_id"],
					"leave_type_id"=>$row["leave_type_id"],
					"leave_credit"=>$row["leave_credit"],
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
	
	public function getLeaveCreditBal($emp_id){ //
	$sql = "SELECT
			emp_leave_credit_id,
			emp_id,
			leave_type_id,
			leave_credit
			FROM `tbl_employee_leavecredit`
			WHERE emp_id = $emp_id";;
	
	$this->openDB();
	$this->prepareQuery($sql);
	// echo $sql;
	$this->bindQueryParam(':emp_id',  $emp_id);
	// $this->bindQueryParam(':leave_type_id',  $leave_type_id);
	// $this->bindQueryParam(':regionID',  $regionID);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"emp_leave_credit_id"=>$row["emp_leave_credit_id"],
					"emp_id"=>$row["emp_id"],
					"leave_type_id"=>$row["leave_type_id"],
					"leave_credit"=>$row["leave_credit"],
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
	
	public function getLeaveCreditByID($emp_leave_credit_id){ //
	$sql = "SELECT
			emp_leave_credit_id,
			emp_id,
			leave_type_id,
			leave_credit
			FROM `tbl_employee_leavecredit`
			WHERE emp_leave_credit_id = $emp_leave_credit_id";;
	
	$this->openDB();
	$this->prepareQuery($sql);
	// echo $sql;
	$this->bindQueryParam(':emp_leave_credit_id',  $emp_leave_credit_id);
	// $this->bindQueryParam(':leave_type_id',  $leave_type_id);
	// $this->bindQueryParam(':regionID',  $regionID);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"emp_leave_credit_id"=>$row["emp_leave_credit_id"],
					"emp_id"=>$row["emp_id"],
					"leave_type_id"=>$row["leave_type_id"],
					"leave_credit"=>$row["leave_credit"],
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

	public function getLeaveTypeByID($leave_type_id){ //
	$sql = "SELECT
			leave_type_id,
			leave_type_title
			FROM `lib_leave`
			WHERE leave_type_id = $leave_type_id";
	
	$this->openDB();
	$this->prepareQuery($sql);
	// echo $sql;
	$this->bindQueryParam(':leave_type_id',  $leave_type_id);
	// $this->bindQueryParam(':leave_type_id',  $leave_type_id);
	// $this->bindQueryParam(':regionID',  $regionID);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"leave_type_id"=>$row["leave_type_id"],
					"leave_type_title"=>$row["leave_type_title"],
					// "leave_type_id"=>$row["leave_type_id"],
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

	public function getAllLeaveType(){ //
	$sql = "SELECT
			leave_type_id,
			leave_type_title
			FROM `lib_leave`";
			//WHERE leave_type_id = $leave_type_id";
	
	$this->openDB();
	$this->prepareQuery($sql);
	// echo $sql;
	// $this->bindQueryParam(':leave_type_id',  $leave_type_id);
	// $this->bindQueryParam(':leave_type_id',  $leave_type_id);
	// $this->bindQueryParam(':regionID',  $regionID);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"leave_type_id"=>$row["leave_type_id"],
					"leave_type_title"=>$row["leave_type_title"],
					// "leave_type_id"=>$row["leave_type_id"],
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
	
	public function getLeaveCoverage($leave_application_id){ //
	$sql = "SELECT leave_coverage_id,leave_application_id,emp_id, date_from, date_to
			FROM `tbl_leavecoverage`
			where leave_application_id = $leave_application_id";
	
	$this->openDB();
	$this->prepareQuery($sql);
	 //echo $sql;
	$this->bindQueryParam(':leave_application_id',  $leave_application_id);
	// $this->bindQueryParam(':leave_type_id',  $leave_type_id);
	// $this->bindQueryParam(':regionID',  $regionID);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"leave_coverage_id"=>$row["leave_coverage_id"],
					"emp_id"=>$row["emp_id"],
					"date_from"=>$row["date_from"],
					"date_to"=>$row["date_to"],
					"leave_application_id"=>$row["leave_application_id"],
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


	public function saveLeaveType($emp_id,
							$leave_type_id,
							$leave_credit
							){

		$sql= "INSERT INTO tbl_employee_leavecredit(emp_id,
				leave_type_id,leave_credit
				)
		VALUES('".$emp_id."','".
		$leave_type_id."','".
		$leave_credit."');";
		
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


	public function updateLeaveType($emp_leave_credit_id,
							$leave_type_id,
							$leave_credit
							){

		$sql= "UPDATE tbl_employee_leavecredit
				SET leave_type_id = '".$leave_type_id."',
				leave_credit = '".$leave_credit."'
				WHERE emp_leave_credit_id = ".$emp_leave_credit_id.";";
		
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
