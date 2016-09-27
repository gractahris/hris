<?php

class leaveApplicationDAO extends DAO {

	public function saveLeave($maxLeaveApplicationID, $emp_id,$leave_type_id,$sickness,$place_to_visit,$days_to_leave,$status_id,$date_applied){

		$sql= "INSERT INTO tbl_employee_leaveapplication(leave_application_id, emp_id,leave_type_id,sickness,place_to_visit,days_to_leave,status_id,date_applied)
		VALUES('".$maxLeaveApplicationID."','".
		$emp_id."','".
		$leave_type_id."','".
		$sickness."',".
		$place_to_visit.",'".
		$days_to_leave."','".
		$status_id."','".
		$date_applied."');";
		
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
	

	public function saveLeaveCoverage($leave_application_id, $emp_id, $dateFrom, $dateTo){

		$sql= "INSERT INTO tbl_leavecoverage(leave_application_id,emp_id,date_from,date_to)
		VALUES('".$leave_application_id."','".
		$emp_id."','".
		$dateFrom."','".
		$dateTo."');";
		
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

	public function getLeaveCoverage($leave_application_id){ //
	$sql = "SELECT
			leave_application_id,
			emp_id,
			date_from,
			date_to
			FROM `tbl_leavecoverage`
			WHERE leave_application_id = $leave_application_id;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	 // echo $sql;
	$this->bindQueryParam(':dtr_id',  $dtr_id);
	// $this->bindQueryParam(':month',  $month);
	// $this->bindQueryParam(':day',  $day);
	// $this->bindQueryParam(':year',  $year);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"leave_application_id"=>$row["leave_application_id"],
					"emp_id"=>$row["emp_id"],
					"date_from"=>$row["date_from"],
					"date_to"=>$row["date_to"],
					//"emp_leave_status"=>$row["emp_leave_status"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	// return $sql;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}

	public function getMaxLeaveApplicationID(){ //
	$sql = "SELECT max(leave_application_id) + 1 as maxLeaveApplicationID FROM `tbl_employee_leaveapplication`;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	 //echo $sql;
	//$this->bindQueryParam(':dtr_id',  $dtr_id);
	// $this->bindQueryParam(':month',  $month);
	// $this->bindQueryParam(':day',  $day);
	// $this->bindQueryParam(':year',  $year);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"maxLeaveApplicationID"=>$row["maxLeaveApplicationID"],
					"emp_id"=>$row["emp_id"],
					"date_from"=>$row["date_from"],
					"date_to"=>$row["date_to"],
					//"emp_leave_status"=>$row["emp_leave_status"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	}

	public function getMaxDateTo($leave_application_id){ //
	$sql = "SELECT  min(date_from) as minDateFrom, max(date_to) as maxDateTo
			FROM `tbl_leavecoverage`
			WHERE leave_application_id = $leave_application_id;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	 // echo $sql;
	$this->bindQueryParam(':leave_application_id',  $leave_application_id);
	// $this->bindQueryParam(':month',  $month);
	// $this->bindQueryParam(':day',  $day);
	// $this->bindQueryParam(':year',  $year);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"maxDateTo"=>$row["maxDateTo"],
					"minDateFrom"=>$row["minDateFrom"],
					// "date_from"=>$row["date_from"],
					// "date_to"=>$row["date_to"],
					//"emp_leave_status"=>$row["emp_leave_status"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	}

	public function updateLeaveCredit($emp_id,$leave_type_id,$leave_balance){
		$sql= "UPDATE tbl_employee_leavecredit
		SET leave_credit = '".$leave_balance."'
		WHERE emp_id = $emp_id
		AND leave_type_id = $leave_type_id";
		
		echo $sql;
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
	
	public function updateLeaveApplication($leave_application_id,$status_id,$x_leave_type_id){
		$sql= "UPDATE tbl_employee_leaveapplication
		SET status_id = '".$status_id."',
		leave_type_id = '".$x_leave_type_id."'
		WHERE leave_application_id = $leave_application_id";
		
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

	public function updateLeaveStatusTimeLog($dtr_id,$emp_leave_status,$emp_totalhours,$emp_timein,$emp_timeout,$emp_late){
		$sql= "UPDATE tbl_employee_timelog
		SET emp_leave_status = '".$emp_leave_status."',
		emp_totalhours = '".$emp_totalhours."',
		emp_timein = ".$emp_timein.",
		emp_timeout = ".$emp_timeout.",
		emp_late = '".$emp_late."'
		WHERE dtr_id = $dtr_id;";
		
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
	
	public function saveLeaveStatusTimeLog($emp_id,
$dtr_id,
$emp_timein,
$emp_timeout,
$emp_totalhours,
$emp_late,
$emp_excesstime,
$emp_undertime,
$emp_weekend,
$emp_leave_status){
		$sql= "INSERT INTO tbl_employee_timelog(emp_id,
			dtr_id,
			emp_timein,
			emp_timeout,
			emp_totalhours,
			emp_late,
			emp_excesstime,
			emp_undertime,
			emp_weekend,
			emp_leave_status)
			VALUE('".$emp_id."','".
			$dtr_id."',".
			$emp_timein.",".
			$emp_timeout.",'".
			$emp_totalhours."','".
			$emp_late."','".
			$emp_excesstime."','".
			$emp_undertime."','".
			$emp_weekend."','".
			$emp_leave_status."');";
		
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


	public function getLeavePerEMP($emp_id,$start,$limit){ //
	$sql = "SELECT
			leave_application_id,
			emp_id,
			leave_type_id,
			sickness,
			days_to_leave,
			status_id,
			date_applied
			FROM `tbl_employee_leaveapplication`
			WHERE emp_id = $emp_id
			LIMIT $start, $limit;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	 // echo $sql;
	$this->bindQueryParam(':emp_id',  $emp_id);
	// $this->bindQueryParam(':month',  $month);
	// $this->bindQueryParam(':day',  $day);
	// $this->bindQueryParam(':year',  $year);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"leave_application_id"=>$row["leave_application_id"],
					"emp_id"=>$row["emp_id"],
					"leave_type_id"=>$row["leave_type_id"],
					"sickness"=>$row["sickness"],
					"days_to_leave"=>$row["days_to_leave"],
					"status_id"=>$row["status_id"],
					"date_applied"=>$row["date_applied"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	// return $sql;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}


	public function getLeavePending($start,$limit){ //
	$sql = "SELECT
			leave_application_id,
			emp_id,
			leave_type_id,
			sickness,
			days_to_leave,
			status_id,date_applied
			FROM `tbl_employee_leaveapplication`
			WHERE status_id = 1
			LIMIT $start, $limit;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	 // echo $sql;
	// $this->bindQueryParam(':status_id',  $status_id);
	// $this->bindQueryParam(':month',  $month);
	// $this->bindQueryParam(':day',  $day);
	// $this->bindQueryParam(':year',  $year);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"leave_application_id"=>$row["leave_application_id"],
					"emp_id"=>$row["emp_id"],
					"leave_type_id"=>$row["leave_type_id"],
					"sickness"=>$row["sickness"],
					"days_to_leave"=>$row["days_to_leave"],
					"status_id"=>$row["status_id"],
					"date_applied"=>$row["date_applied"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	// return $sql;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}

	public function getLeaveApproved($start,$limit){ //
	$sql = "SELECT
			leave_application_id,
			emp_id,
			leave_type_id,
			sickness,
			days_to_leave,
			status_id,date_applied
			FROM `tbl_employee_leaveapplication`
			WHERE status_id = 2
			LIMIT $start, $limit;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	 // echo $sql;
	// $this->bindQueryParam(':status_id',  $status_id);
	// $this->bindQueryParam(':month',  $month);
	// $this->bindQueryParam(':day',  $day);
	// $this->bindQueryParam(':year',  $year);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"leave_application_id"=>$row["leave_application_id"],
					"emp_id"=>$row["emp_id"],
					"leave_type_id"=>$row["leave_type_id"],
					"sickness"=>$row["sickness"],
					"days_to_leave"=>$row["days_to_leave"],
					"status_id"=>$row["status_id"],
					"date_applied"=>$row["date_applied"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	// return $sql;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}

	public function getLeaveDisapproved($start,$limit){ //
	$sql = "SELECT
			leave_application_id,
			emp_id,
			leave_type_id,
			sickness,
			days_to_leave,
			status_id,date_applied
			FROM `tbl_employee_leaveapplication`
			WHERE status_id = 3
			LIMIT $start, $limit;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	 // echo $sql;
	// $this->bindQueryParam(':status_id',  $status_id);
	// $this->bindQueryParam(':month',  $month);
	// $this->bindQueryParam(':day',  $day);
	// $this->bindQueryParam(':year',  $year);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"leave_application_id"=>$row["leave_application_id"],
					"emp_id"=>$row["emp_id"],
					"leave_type_id"=>$row["leave_type_id"],
					"sickness"=>$row["sickness"],
					"days_to_leave"=>$row["days_to_leave"],
					"status_id"=>$row["status_id"],
					"date_applied"=>$row["date_applied"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	// return $sql;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}

	public function getLeavePerAllEMP($start,$limit){ //
	$sql = "SELECT
			leave_application_id,
			emp_id,
			leave_type_id,
			sickness,
			days_to_leave,
			status_id,date_applied
			FROM `tbl_employee_leaveapplication`
			ORDER BY date_applied desc
			LIMIT $start,$limit;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	 // echo $sql;
	$this->bindQueryParam(':emp_id',  $emp_id);
	// $this->bindQueryParam(':month',  $month);
	// $this->bindQueryParam(':day',  $day);
	// $this->bindQueryParam(':year',  $year);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"leave_application_id"=>$row["leave_application_id"],
					"emp_id"=>$row["emp_id"],
					"leave_type_id"=>$row["leave_type_id"],
					"sickness"=>$row["sickness"],
					"days_to_leave"=>$row["days_to_leave"],
					"status_id"=>$row["status_id"],
					"date_applied"=>$row["date_applied"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	// return $sql;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}
	
	
	public function getLeaveType($leave_type_id){ //
	$sql = "SELECT
			leave_type_id,
			leave_type_title
			FROM `lib_leave`
			WHERE leave_type_id = $leave_type_id;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	 //echo $sql;
	$this->bindQueryParam(':leave_type_id',  $leave_type_id);
	// $this->bindQueryParam(':month',  $month);
	// $this->bindQueryParam(':day',  $day);
	// $this->bindQueryParam(':year',  $year);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					// "leave_application_id"=>$row["leave_application_id"],
					"leave_type_title"=>$row["leave_type_title"],
					"leave_type_id"=>$row["leave_type_id"],
					// "sickness"=>$row["sickness"],
					// "days_to_leave"=>$row["days_to_leave"],
					// "status_id"=>$row["status_id"],
					//"emp_leave_status"=>$row["emp_leave_status"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	// return $sql;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}


	public function getStatus($status_id){ //
	$sql = "SELECT
			status_id,
			status_title
			FROM `lib_status`
			WHERE status_id = $status_id;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	 //echo $sql;
	$this->bindQueryParam(':status_id',  $status_id);
	// $this->bindQueryParam(':month',  $month);
	// $this->bindQueryParam(':day',  $day);
	// $this->bindQueryParam(':year',  $year);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					// "leave_application_id"=>$row["leave_application_id"],
					"status_title"=>$row["status_title"],
					"status_id"=>$row["status_id"],
					// "sickness"=>$row["sickness"],
					// "days_to_leave"=>$row["days_to_leave"],
					// "status_id"=>$row["status_id"],
					//"emp_leave_status"=>$row["emp_leave_status"],
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
			FROM `lib_leave`;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	 //echo $sql;
	// $this->bindQueryParam(':leave_type_id',  $leave_type_id);
	// $this->bindQueryParam(':month',  $month);
	// $this->bindQueryParam(':day',  $day);
	// $this->bindQueryParam(':year',  $year);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					// "leave_application_id"=>$row["leave_application_id"],
					"leave_type_title"=>$row["leave_type_title"],
					"leave_type_id"=>$row["leave_type_id"],
					// "sickness"=>$row["sickness"],
					// "days_to_leave"=>$row["days_to_leave"],
					// "status_id"=>$row["status_id"],
					//"emp_leave_status"=>$row["emp_leave_status"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	// return $sql;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}

	public function getAllStatus(){ //
	$sql = "SELECT
			status_id,
			status_title
			FROM `lib_status`
			where status_id = 1;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	 //echo $sql;
	// $this->bindQueryParam(':status_id',  $status_id);
	// $this->bindQueryParam(':month',  $month);
	// $this->bindQueryParam(':day',  $day);
	// $this->bindQueryParam(':year',  $year);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					// "leave_application_id"=>$row["leave_application_id"],
					"status_title"=>$row["status_title"],
					"status_id"=>$row["status_id"],
					// "sickness"=>$row["sickness"],
					// "days_to_leave"=>$row["days_to_leave"],
					// "status_id"=>$row["status_id"],
					//"emp_leave_status"=>$row["emp_leave_status"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	// return $sql;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}
	
	public function getEmpByID($emp_id){ //
	$sql = "SELECT
			emp_id,
			empLastName,
			empFirstName,
			empMiddleName
			FROM `tbl_employee`
			where emp_id = $emp_id;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	 //echo $sql;
	$this->bindQueryParam(':emp_id',  $emp_id);
	// $this->bindQueryParam(':month',  $month);
	// $this->bindQueryParam(':day',  $day);
	// $this->bindQueryParam(':year',  $year);
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
					// "days_to_leave"=>$row["days_to_leave"],
					// "status_id"=>$row["status_id"],
					//"emp_leave_status"=>$row["emp_leave_status"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;

	}
	
	public function getAllEmp(){ //
	$sql = "SELECT
			emp_id,
			empLastName,
			empFirstName,
			empMiddleName
			FROM `tbl_employee`
			ORDER BY empLastName ASC;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	 //echo $sql;
	// $this->bindQueryParam(':emp_id',  $emp_id);
	// $this->bindQueryParam(':month',  $month);
	// $this->bindQueryParam(':day',  $day);
	// $this->bindQueryParam(':year',  $year);
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
					// "days_to_leave"=>$row["days_to_leave"],
					// "status_id"=>$row["status_id"],
					//"emp_leave_status"=>$row["emp_leave_status"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;

	}

	public function getLeaveDateDiff($toDate){ //
	$sql = "SELECT DATEDIFF('".$toDate."',NOW()) + 1 as dateDiff;";
	
	// echo $sql;
	$this->openDB();
	$this->prepareQuery($sql);
	// $this->bindQueryParam(':sex_id',  $sex_id);
	// $this->bindQueryParam(':regionID',  $regionID);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"dateDiff"=>$row["dateDiff"],
					// "sex_title"=>$row["sex_title"],
					// "emp_id"=>$row["emp_id"],
					// "adaRefID"=>$row["adaRefID"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;

	}


	public function countAllLeave(){ //
	$sql = "SELECT
			count(leave_application_id) as countOfLeave
			FROM `tbl_employee_leaveapplication`;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	 //echo $sql;
	$this->bindQueryParam(':emp_id',  $emp_id);
	// $this->bindQueryParam(':month',  $month);
	// $this->bindQueryParam(':day',  $day);
	// $this->bindQueryParam(':year',  $year);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"countOfLeave"=>$row["countOfLeave"],
					// "emp_id"=>$row["emp_id"],
					// "leave_type_id"=>$row["leave_type_id"],
					// "sickness"=>$row["sickness"],
					// "days_to_leave"=>$row["days_to_leave"],
					// "status_id"=>$row["status_id"],
					// "date_applied"=>$row["date_applied"],
					// "date_applied"=>$row["date_applied"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	// return $sql;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}
	

	public function countPendingLeave(){ //
	$sql = "SELECT
			count(leave_application_id) as countOfLeave
			FROM `tbl_employee_leaveapplication`
			WHERE status_id = 1";
	
	$this->openDB();
	$this->prepareQuery($sql);
	 //echo $sql;
	$this->bindQueryParam(':emp_id',  $emp_id);
	// $this->bindQueryParam(':month',  $month);
	// $this->bindQueryParam(':day',  $day);
	// $this->bindQueryParam(':year',  $year);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"countOfLeave"=>$row["countOfLeave"],
					// "emp_id"=>$row["emp_id"],
					// "leave_type_id"=>$row["leave_type_id"],
					// "sickness"=>$row["sickness"],
					// "days_to_leave"=>$row["days_to_leave"],
					// "status_id"=>$row["status_id"],
					// "date_applied"=>$row["date_applied"],
					// "date_applied"=>$row["date_applied"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	// return $sql;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}


	public function countApLeave(){ //
	$sql = "SELECT
			count(leave_application_id) as countOfLeave
			FROM `tbl_employee_leaveapplication`
			WHERE status_id = 2";
	
	$this->openDB();
	$this->prepareQuery($sql);
	 //echo $sql;
	$this->bindQueryParam(':emp_id',  $emp_id);
	// $this->bindQueryParam(':month',  $month);
	// $this->bindQueryParam(':day',  $day);
	// $this->bindQueryParam(':year',  $year);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"countOfLeave"=>$row["countOfLeave"],
					// "emp_id"=>$row["emp_id"],
					// "leave_type_id"=>$row["leave_type_id"],
					// "sickness"=>$row["sickness"],
					// "days_to_leave"=>$row["days_to_leave"],
					// "status_id"=>$row["status_id"],
					// "date_applied"=>$row["date_applied"],
					// "date_applied"=>$row["date_applied"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	// return $sql;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}

	public function countDpLeave(){ //
	$sql = "SELECT
			count(leave_application_id) as countOfLeave
			FROM `tbl_employee_leaveapplication`
			WHERE status_id = 3";
	
	$this->openDB();
	$this->prepareQuery($sql);
	 //echo $sql;
	$this->bindQueryParam(':emp_id',  $emp_id);
	// $this->bindQueryParam(':month',  $month);
	// $this->bindQueryParam(':day',  $day);
	// $this->bindQueryParam(':year',  $year);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"countOfLeave"=>$row["countOfLeave"],
					// "emp_id"=>$row["emp_id"],
					// "leave_type_id"=>$row["leave_type_id"],
					// "sickness"=>$row["sickness"],
					// "days_to_leave"=>$row["days_to_leave"],
					// "status_id"=>$row["status_id"],
					// "date_applied"=>$row["date_applied"],
					// "date_applied"=>$row["date_applied"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	// return $sql;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}


	public function countEmpForLeave($emp_id){ //
	$sql = "SELECT
			count(leave_application_id) as countOfLeave
			FROM `tbl_employee_leaveapplication`
			where emp_id = $emp_id";
	
	$this->openDB();
	$this->prepareQuery($sql);
	 //echo $sql;
	$this->bindQueryParam(':emp_id',  $emp_id);
	// $this->bindQueryParam(':month',  $month);
	// $this->bindQueryParam(':day',  $day);
	// $this->bindQueryParam(':year',  $year);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"countOfLeave"=>$row["countOfLeave"],
					// "emp_id"=>$row["emp_id"],
					// "leave_type_id"=>$row["leave_type_id"],
					// "sickness"=>$row["sickness"],
					// "days_to_leave"=>$row["days_to_leave"],
					// "status_id"=>$row["status_id"],
					// "date_applied"=>$row["date_applied"],
					// "date_applied"=>$row["date_applied"],
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
