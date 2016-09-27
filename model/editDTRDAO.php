<?php

class editDTRDAO extends DAO {

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
		$emp_timein."',".
		$emp_timeout.",'".
		$emp_totalhours."','".
		$emp_late."','".
		$emp_excesstime."','".
		$emp_undertime."','".
		$dtr_id."');";
		
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

	public function getEmpTimeLog($emp_id,$dtr_id){ //
	$sql = "SELECT
			ref_id,
			emp_id,
			dtr_id,
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
/*	$this->bindQueryParam(':day',  $day);
	$this->bindQueryParam(':year',  $year);*/
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"dtr_id"=>$row["dtr_id"],
					"emp_id"=>$row["emp_id"],
					"ref_id"=>$row["ref_id"],
					"emp_timein"=>$row["emp_timein"],
					"emp_timeout"=>$row["emp_timeout"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	// return $sql;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}
	

	
	public function updateTimeLogs($emp_id,$dtr_id, $emp_timeout, $emp_timein){

		$sql= "UPDATE tbl_employee_timelog
				SET emp_timeout = '".$emp_timeout."',
				emp_timein  = '".$emp_timein."'
				WHERE emp_id = $emp_id
				AND	dtr_id = $dtr_id;";
		
		
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

}
	
?>
