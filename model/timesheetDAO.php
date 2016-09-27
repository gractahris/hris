<?php

class timesheetDAO extends DAO {

	public function saveTimeIN($emp_id,$emp_timein,$emp_timeout, $emp_totalhours,$emp_late,$emp_excesstime,$emp_undertime,$dtr_id){

		$sql= "INSERT INTO tbl_employee_timelog(emp_id,
			emp_timein,
			emp_timeout,
			emp_totalhours,
			emp_late,
			emp_excesstime,
			emp_undertime,
			dtr_id)
		VALUES('".$emp_id."','".
		$emp_timein."','".
		$emp_timeout."','".
		$emp_totalhours."','".
		$emp_late."','".
		$emp_excesstime."','".
		$emp_undertime."','".
		$dtr_id."');";
		
		//echo $sql;
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

	public function saveLeaveStatus($emp_id,$emp_timein,$emp_timeout, $emp_totalhours,$emp_late,$emp_excesstime,$emp_undertime,$dtr_id,$emp_leave_status){

		$sql= "INSERT INTO tbl_employee_timelog(emp_id,
			emp_timein,
			emp_timeout,
			emp_totalhours,
			emp_late,
			emp_excesstime,
			emp_undertime,
			emp_leave_status,
			dtr_id)
		VALUES('".$emp_id."',".
		$emp_timein.",".
		$emp_timeout.",'".
		$emp_totalhours."','".
		$emp_late."','".
		$emp_excesstime."','".
		$emp_undertime."','".
		$emp_leave_status."','".
		$dtr_id."');";
		
		//echo $sql;
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

	public function saveAbsent($emp_id,$emp_timein,$emp_timeout, $emp_totalhours,$emp_late,$emp_excesstime,$emp_undertime,$dtr_id){

		$sql= "INSERT INTO tbl_employee_timelog(emp_id,
			emp_timein,
			emp_timeout,
			emp_totalhours,
			emp_late,
			emp_excesstime,
			emp_undertime,
			dtr_id)
		VALUES('".$emp_id."',".
		$emp_timein.",".
		$emp_timeout.",'".
		$emp_totalhours."','".
		$emp_late."','".
		$emp_excesstime."','".
		$emp_undertime."','".
		$dtr_id."');";
		
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

	public function saveWeekend($emp_id,$emp_timein,$emp_timeout, $emp_totalhours,$emp_late,$emp_excesstime,$emp_undertime,$emp_weekend,$dtr_id){

		$sql= "INSERT INTO tbl_employee_timelog(emp_id,
			emp_timein,
			emp_timeout,
			emp_totalhours,
			emp_late,
			emp_excesstime,
			emp_undertime,
			emp_weekend,
			dtr_id)
		VALUES('".$emp_id."',".
		$emp_timein.",".
		$emp_timeout.",'".
		$emp_totalhours."','".
		$emp_late."','".
		$emp_excesstime."','".
		$emp_undertime."','".
		$emp_weekend."','".
		$dtr_id."');";
		
		 //echo $sql;
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


	
		
	public function getDTR($emp_id,$month,$day, $year){ //
	$sql = "SELECT
			dtr_id,
			emp_id,
			month,
			day,
			year
			FROM `tbl_createDTR`
			WHERE emp_id = $emp_id
			AND month = $month
			AND day = $day
			AND year = $year;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	// echo $sql;
	$this->bindQueryParam(':emp_id',  $emp_id);
	$this->bindQueryParam(':month',  $month);
	$this->bindQueryParam(':day',  $day);
	$this->bindQueryParam(':year',  $year);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"dtr_id"=>$row["dtr_id"],
					"emp_id"=>$row["emp_id"],
					"month"=>$row["month"],
					"day"=>$row["day"],
					"year"=>$row["year"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	// return $sql;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}

	public function dtrIdInEmpTimelog($dtr_id){ //
	$sql = "SELECT
			dtr_id,
			emp_id,
			emp_timein,
			emp_timeout,
			emp_totalhours,
			emp_leave_status
			FROM `tbl_employee_timelog`
			WHERE dtr_id = $dtr_id;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	 //echo $sql;
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
					"dtr_id"=>$row["dtr_id"],
					"emp_id"=>$row["emp_id"],
					"emp_timein"=>$row["emp_timein"],
					"emp_timeout"=>$row["emp_timeout"],
					"emp_totalhours"=>$row["emp_totalhours"],
					"emp_leave_status"=>$row["emp_leave_status"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	// return $sql;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}
	
	public function getDTRPerDAY($emp_id,$month,$day, $year){ //
	$sql = "SELECT
			dtr_id,
			emp_id,
			month,
			day,
			year
			FROM `tbl_createDTR`
			WHERE emp_id = $emp_id
			AND month = $month
			AND day = $day
			AND year = $year;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	// echo $sql;
	$this->bindQueryParam(':emp_id',  $emp_id);
	$this->bindQueryParam(':month',  $month);
	$this->bindQueryParam(':day',  $day);
	$this->bindQueryParam(':year',  $year);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"dtr_id"=>$row["dtr_id"],
					"emp_id"=>$row["emp_id"],
					"month"=>$row["month"],
					"day"=>$row["day"],
					"year"=>$row["year"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	// return $sql;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}
	
	public function getTimeLogOfDay($emp_id,$dtr_id){ //
	$sql = "SELECT
			dtr_id,
			emp_id,
			emp_timein,
			emp_timeout
			FROM `tbl_employee_timelog`
			WHERE emp_id = $emp_id
			AND dtr_id = $dtr_id;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	// echo $sql;
	$this->bindQueryParam(':emp_id',  $emp_id);
	$this->bindQueryParam(':dtr_id',  $dtr_id);
	// $this->bindQueryParam(':day',  $day);
	// $this->bindQueryParam(':year',  $year);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"dtr_id"=>$row["dtr_id"],
					"emp_id"=>$row["emp_id"],
					"emp_timein"=>$row["emp_timein"],
					"emp_timeout"=>$row["emp_timeout"],
					// "year"=>$row["year"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	// return $sql;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}
	
	public function getTime(){ //
	$sql = "select SUBSTR(NOW() FROM 11 FOR 10) as time;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	// echo $sql;
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
					"time"=>$row["time"],
					// "month"=>$row["month"],
					// "day"=>$row["day"],
					// "year"=>$row["year"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	// return $sql;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}
	
	public function updateTimeOut($emp_id,$emp_timeout,$dtr_id){

		$sql= "UPDATE tbl_employee_timelog
				SET emp_timeout = '".$emp_timeout."'
				WHERE emp_id = $emp_id
				AND	dtr_id = $dtr_id;";
		
		
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
	
	
	public function getDTRofMonth($emp_id,$month,$year){ //
	$sql = "SELECT
			dtr_id,
			emp_id,
			month,
			day,
			year
			FROM `tbl_createDTR`
			WHERE emp_id = $emp_id
			AND month = '".$month."'
			AND year = '".$year."'
			ORDER BY dtr_id;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	// echo $sql;
	$this->bindQueryParam(':emp_id',  $emp_id);
	$this->bindQueryParam(':month',  $month);
	// $this->bindQueryParam(':day',  $day);
	$this->bindQueryParam(':year',  $year);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"dtr_id"=>$row["dtr_id"],
					"emp_id"=>$row["emp_id"],
					"month"=>$row["month"],
					"day"=>$row["day"],
					"year"=>$row["year"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	// return $sql;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}
	
		
	public function getSchedByEmp($emp_id){ //
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
			WHERE emp_id = $emp_id;";
			//AND schedule_id = $schedule_id;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	// echo $sql;
	$this->bindQueryParam(':emp_id',  $emp_id);
	// $this->bindQueryParam(':schedule_id',  $schedule_id);
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
					"schedule_id"=>$row["schedule_id"],
					// "day"=>$row["day"],
					// "year"=>$row["year"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	// return $sql;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}
	
	public function getSchedByID($schedule_id){ //
	$sql = "SELECT
			schedule_id,
			schedule_title,
			schedule_time_in,
			schedule_time_out
			FROM `lib_schedule`
			WHERE schedule_id = $schedule_id;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	// echo $sql;
	// $this->bindQueryParam(':emp_id',  $emp_id);
	$this->bindQueryParam(':schedule_id',  $schedule_id);
	// $this->bindQueryParam(':day',  $day);
	// $this->bindQueryParam(':year',  $year);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					// "emp_id"=>$row["emp_id"],
					"schedule_id"=>$row["schedule_id"],
					"schedule_title"=>$row["schedule_title"],
					"schedule_time_in"=>$row["schedule_time_in"],
					"schedule_time_out"=>$row["schedule_time_out"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	// return $sql;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}
	
	public function getTimeLate($emp_timein, $schedule_time_in){ //
	$sql = "SELECT TIMEDIFF('".
			$emp_timein."','".
			$schedule_time_in."') as totalLate;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	// echo $sql;
	// $this->bindQueryParam(':emp_id',  $emp_id);
	$this->bindQueryParam(':schedule_id',  $schedule_id);
	// $this->bindQueryParam(':day',  $day);
	// $this->bindQueryParam(':year',  $year);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"totalLate"=>$row["totalLate"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;

	}
	
	public function getTimeUndertime($schedule_time_out,$emp_timeout){ //
	$sql = "SELECT TIMEDIFF('".
			$schedule_time_out."','".
			$emp_timeout."') as totalUnderTime;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	// echo $sql;
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"totalUnderTime"=>$row["totalUnderTime"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;

	}
	
	public function getDateDiff($dateToday,$dateTodayLog){ //
	$sql = "SELECT DATEDIFF('".
			$dateToday."','".
			$dateTodayLog."') as totalDate;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	// echo $sql;
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"totalDate"=>$row["totalDate"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;

	}
	
	public function getTotalHours($timeSchedOut,$emp_timein){ //
	$sql = "SELECT TIMEDIFF(TIMEDIFF('".$timeSchedOut."','".$emp_timein."'),'01:00:00') as totalHours;";
	// $sql = "SELECT TIMEDIFF('".$timeSchedOut."','".$emp_timein."') as totalHours;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	// echo $sql;
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"totalHours"=>$row["totalHours"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;

	}
	
	public function getTotalHoursNight($totalHoursNoBreak){ //
	$sql = "SELECT TIMEDIFF('".$totalHoursNoBreak."','01:00:00') as totalHours;";
	// $sql = "SELECT TIMEDIFF('".$timeSchedOut."','".$emp_timein."') as totalHours;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	// echo $sql;
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"totalHours"=>$row["totalHours"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;

	}

	public function gettotalHoursNoBreak($timeSchedOut,$emp_timein){ //
		$sql = "SELECT TIMEDIFF('".$timeSchedOut."','".$emp_timein."') as totalHoursNoBreak;";
		// $sql = "SELECT TIMEDIFF('".$timeSchedOut."','".$emp_timein."') as totalHours;";

		$this->openDB();
		$this->prepareQuery($sql);
		// echo $sql;
		$result = $this->executeQuery();

		$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
			(
					"totalHoursNoBreak"=>$row["totalHoursNoBreak"],
			);
			$arrOfData[$i] = $dtr;
		}
		$this->closeDB();
		return $arrOfData;

	}
	
	public function gettotalHoursNoBreakNight($emp_timein){ //
		$sql = "SELECT TIMEDIFF('24:00:00','".$emp_timein."') as totalHoursNoBreak;";
		// $sql = "SELECT TIMEDIFF('".$timeSchedOut."','".$emp_timein."') as totalHours;";

		$this->openDB();
		$this->prepareQuery($sql);
		// echo $sql;
		$result = $this->executeQuery();

		$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
			(
					"totalHoursNoBreak"=>$row["totalHoursNoBreak"],
			);
			$arrOfData[$i] = $dtr;
		}
		$this->closeDB();
		return $arrOfData;

	}
	
	public function gettotalHoursNoBreakAMNight($timeSchedOut){ //
		$sql = "SELECT TIMEDIFF('".$timeSchedOut."','00:00:00') as totalHoursNoBreak;";
		// $sql = "SELECT TIMEDIFF('".$timeSchedOut."','".$emp_timein."') as totalHours;";

		$this->openDB();
		$this->prepareQuery($sql);
		// echo $sql;
		$result = $this->executeQuery();

		$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
			(
					"totalHoursNoBreak"=>$row["totalHoursNoBreak"],
			);
			$arrOfData[$i] = $dtr;
		}
		$this->closeDB();
		return $arrOfData;

	}
	
	public function getTotalTimeNight($timeIn,$timeOut){ //
		$sql = "SELECT addtime('".$timeIn."','".$timeOut."') as totalHoursNoBreak;";
		// $sql = "SELECT TIMEDIFF('".$timeSchedOut."','".$emp_timein."') as totalHours;";

		$this->openDB();
		$this->prepareQuery($sql);
		// echo $sql;
		$result = $this->executeQuery();

		$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
			(
					"totalHoursNoBreak"=>$row["totalHoursNoBreak"],
			);
			$arrOfData[$i] = $dtr;
		}
		$this->closeDB();
		return $arrOfData;

	}

	public function getAllHours($totalHours1,$totalHours2){ //
		$sql = "SELECT addtime('".$totalHours1."','".$totalHours1."') as totalHours;";
		// $sql = "SELECT TIMEDIFF('".$timeSchedOut."','".$emp_timein."') as totalHours;";

		$this->openDB();
		$this->prepareQuery($sql);
		// echo $sql;
		$result = $this->executeQuery();

		$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
			(
					"totalHours"=>$row["totalHours"],
			);
			$arrOfData[$i] = $dtr;
		}
		$this->closeDB();
		return $arrOfData;

	}
	
	public function getTimeExcessTime($schedule_time_out,$emp_timeout){ //
	$sql = "SELECT TIMEDIFF('".
			$emp_timeout."','".
			$schedule_time_out."') as excessTime;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	// echo $sql;
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"excessTime"=>$row["excessTime"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;

	}


	
	public function getLeave($leave_application_id){ //
	$sql = "SELECT
			leave_application_id,
			emp_id,
			leave_type_id,
			sickness,
			place_to_visit,
			days_to_leave,
			status_id
			FROM
			tbl_employee_leaveapplication
			WHERE leave_application_id = $leave_application_id";
	
	$this->openDB();
	$this->prepareQuery($sql);
	// echo $sql;
	// $this->bindQueryParam(':emp_id',  $emp_id);
	$this->bindQueryParam(':leave_application_id',  $leave_application_id);
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
					"status_id"=>$row["status_id"],
					// "year"=>$row["year"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;

	}
	
	// public function getLeaveCoverage($emp_id,$leave_application_id){ //
	public function getLeaveCoverage($emp_id,$date_from){ //
	$sql = "SELECT
			leave_coverage_id,
			leave_application_id,
			emp_id,
			date_from,
			SUBSTR(date_from FROM 1 FOR 4) as dateFromYear,
			SUBSTR(date_from FROM 6 FOR 2) as dateFromMonth,
			SUBSTR(date_from FROM 9 FOR 2) as dateFromDay,
			date_to,
			SUBSTR(date_to FROM 1 FOR 4) as dateToYear,
			SUBSTR(date_to FROM 6 FOR 2) as dateToMonth,
			SUBSTR(date_to FROM 9 FOR 2) as dateToDay
			FROM `tbl_leavecoverage`
			WHERE emp_id = $emp_id
			AND date_from = '".$date_from."';";
			//AND leave_application_id = $leave_application_id";
	
	$this->openDB();
	$this->prepareQuery($sql);
	 //echo $sql;
	$this->bindQueryParam(':emp_id',  $emp_id);
	$this->bindQueryParam(':date_from',  $date_from);
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
					"dateFromYear"=>$row["dateFromYear"],
					"dateFromMonth"=>$row["dateFromMonth"],
					"dateFromDay"=>$row["dateFromDay"],
					"dateToYear"=>$row["dateToYear"],
					"dateToMonth"=>$row["dateToMonth"],
					"dateToDay"=>$row["dateToDay"],
					"date_from"=>$row["date_from"],
					"date_to"=>$row["date_to"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;

	}


	
	public function getDateToday(){ //
	$sql = "select NOW(), SUBSTR(NOW() FROM 1 FOR 10) as dateToday, SUBSTR(NOW() FROM 6 FOR 2) as dateMonth, SUBSTR(NOW() FROM 9 FOR 2) as dateDay, SUBSTR(NOW() FROM 1 FOR 4) as dateYear;";
			//AND leave_application_id = $leave_application_id";
	
	$this->openDB();
	$this->prepareQuery($sql);
	// echo $sql;
	// $this->bindQueryParam(':emp_id',  $emp_id);
	// $this->bindQueryParam(':date_from',  $date_from);
	// $this->bindQueryParam(':day',  $day);
	// $this->bindQueryParam(':year',  $year);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"dateToday"=>$row["dateToday"],
					"dateMonth"=>$row["dateMonth"],
					"dateDay"=>$row["dateDay"],
					"dateYear"=>$row["dateYear"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;

	}
	
	public function getHoliday($holiday_month,$holiday_day,$holiday_year){ //
	$sql = "SELECT
			holiday_id,
			holiday_title,
			holiday_month,
			holiday_day,
			holiday_year
			FROM `lib_holiday`
			WHERE holiday_month = '".$holiday_month."'
			and holiday_day = '".$holiday_day."'
			and holiday_year = '".$holiday_year."';";
	
	$this->openDB();
	$this->prepareQuery($sql);
	  //echo $sql;
	$this->bindQueryParam(':holiday_month',  $holiday_month);
	$this->bindQueryParam(':holiday_day',  $holiday_day);
	$this->bindQueryParam(':holiday_year',  $holiday_year);
	// $this->bindQueryParam(':year',  $year);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"holiday_id"=>$row["holiday_id"],
					"holiday_title"=>$row["holiday_title"],
					"holiday_day"=>$row["holiday_day"],
					"holiday_month"=>$row["holiday_month"],
					"holiday_year"=>$row["holiday_year"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;

	}
	
	public function updateDtrHoliday($month,$day,$year,$is_holiday){

		$sql= "UPDATE tbl_createdtr
				SET is_holiday = $is_holiday
				WHERE month = $month
				AND	day = $day
				AND year = $year;";
		
		
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
