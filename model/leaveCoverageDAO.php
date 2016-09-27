<?php

class leaveCoverageDAO extends DAO {

	public function getStatusByLeaveID($leave_application_id){ //
	$sql = "SELECT leave_application_id,status_id
		FROM tbl_employee_leaveapplication
		where leave_application_id = :leave_application_id";
	
	$this->openDB();
	$this->prepareQuery($sql);
	$this->bindQueryParam(':leave_application_id',  $leave_application_id);
	// $this->bindQueryParam(':regionID',  $regionID);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"leave_application_id"=>$row["leave_application_id"],
					"status_id"=>$row["status_id"],
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
	
	
}
	
?>
