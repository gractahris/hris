<?php

class calculateDTRDAO extends DAO {


	public function getDistinctEmp(){ //
		//$sql = "SELECT distinct emp_id
		//		FROM `tbl_employee_timelog`";
		$sql = "SELECT distinct emp_id
				FROM `tbl_employee`";

		$this->openDB();
		$this->prepareQuery($sql);
		//$this->bindQueryParam(':dtr_id',  $dtr_id);
		// $this->bindQueryParam(':regionID',  $regionID);
		$result = $this->executeQuery();

		$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
			(
					//"ref_id"=>$row["ref_id"],
					"emp_id"=>$row["emp_id"],
				/*	"dtr_id"=>$row["dtr_id"],
					"emp_timein"=>$row["emp_timein"],
					"emp_timein"=>$row["emp_timein"],
					"emp_timeout"=>$row["emp_timeout"],
					"emp_totalhours"=>$row["emp_totalhours"],
					"emp_late"=>$row["emp_late"],
					"emp_excesstime"=>$row["emp_excesstime"],
					"emp_undertime"=>$row["emp_undertime"],*/

				// "adaRefID"=>$row["adaRefID"],
			);
			$arrOfData[$i] = $dtr;
		}
		$this->closeDB();
		return $arrOfData;

		// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
		// return $totalPaxPerFO;
	}

	public function getAllEmpTimeLogs($dtr_id){ //
	$sql = "SELECT
			ref_id,
			emp_id,
			dtr_id,
			emp_timein,
			emp_timeout,
			emp_totalhours,
			emp_late,
			emp_excesstime,
			emp_undertime
			FROM `tbl_employee_timelog`
			WHERE dtr_id = $dtr_id";
	
	$this->openDB();
	$this->prepareQuery($sql);
	$this->bindQueryParam(':dtr_id',  $dtr_id);
	// $this->bindQueryParam(':regionID',  $regionID);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"ref_id"=>$row["ref_id"],
					"emp_id"=>$row["emp_id"],
					"dtr_id"=>$row["dtr_id"],
					"emp_timein"=>$row["emp_timein"],
					"emp_timein"=>$row["emp_timein"],
					"emp_timeout"=>$row["emp_timeout"],
					"emp_totalhours"=>$row["emp_totalhours"],
					"emp_late"=>$row["emp_late"],
					"emp_excesstime"=>$row["emp_excesstime"],
					"emp_undertime"=>$row["emp_undertime"],

					// "adaRefID"=>$row["adaRefID"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}

	public function autoUpdateLogs($emp_id,$dtr_id,$emp_totalhours,$emp_late,$emp_excesstime,$emp_undertime,$emp_weekend){

		$sql= "UPDATE tbl_employee_timelog
				SET emp_totalhours = '".$emp_totalhours."',
				 emp_late = '".$emp_late."',
				 emp_excesstime = '".$emp_excesstime."',
				 emp_undertime = '".$emp_undertime."',
				 emp_weekend = '".$emp_weekend."'
				WHERE emp_id = '".$emp_id."'
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
	
	public function getAllEmp(){ //
	$sql = "SELECT emp_id,empLastName,empFirstName
			FROM `tbl_employee`;";
	
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
					"emp_id"=>$row["emp_id"],
					"empLastName"=>$row["empLastName"],
					"empFirstName"=>$row["empFirstName"],
					// "year"=>$row["year"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	// return $sql;

	}
	
	
}
	
?>
