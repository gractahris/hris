<?php

class jobDAO extends DAO {

	public function getAllJob(){ //
	$sql = "SELECT job_id,
				job_title,
				job_desc,
				salary_id
			FROM lib_job
					";
	
	// echo $sql;
	$this->openDB();
	$this->prepareQuery($sql);
	// $this->bindQueryParam(':job_id',  $job_id);
	// $this->bindQueryParam(':regionID',  $regionID);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"job_id"=>$row["job_id"],
					"job_title"=>$row["job_title"],
					"job_desc"=>$row["job_desc"],
					"salary_id"=>$row["salary_id"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	}

	public function getSalaryByID($salary_id){ //
	$sql = "SELECT salary_id,
				salary_amount
			FROM lib_salary
			WHERE salary_id = $salary_id";
	
	// echo $sql;
	$this->openDB();
	$this->prepareQuery($sql);
	$this->bindQueryParam(':salary_id',  $salary_id);
	// $this->bindQueryParam(':regionID',  $regionID);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"salary_id"=>$row["salary_id"],
					"salary_amount"=>$row["salary_amount"],
					// "job_desc"=>$row["job_desc"],
					// "salary_id"=>$row["salary_id"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	}

	public function getAllSalary(){ //
	$sql = "SELECT salary_id,
				salary_amount
			FROM lib_salary";
	
	// echo $sql;
	$this->openDB();
	$this->prepareQuery($sql);
	// $this->bindQueryParam(':job_id',  $job_id);
	// $this->bindQueryParam(':regionID',  $regionID);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"salary_id"=>$row["salary_id"],
					"salary_amount"=>$row["salary_amount"],
					// "job_desc"=>$row["job_desc"],
					// "salary_id"=>$row["salary_id"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	}

	public function saveJob($job_title,
							$job_desc,$salary_id){

		$sql= "INSERT INTO lib_job(job_title,
				job_desc,salary_id)
		VALUES('".$job_title."','".
		$job_desc."',".
		$salary_id.
		");";
		
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

	public function editJob($job_title,
							$job_desc,
							$job_id,$salary_id){

		$sql= "UPDATE lib_job
				SET job_title = '".$job_title."',
				job_desc = '".$job_desc."',
				salary_id = '".$salary_id."'
				WHERE job_id = $job_id;";
		
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

	public function getJobByID($job_id){ //
	$sql = "SELECT job_id,
				job_title,
				job_desc,
				salary_id
			FROM lib_job
			where job_id = $job_id;
					";
	
	// echo $sql;
	$this->openDB();
	$this->prepareQuery($sql);
	$this->bindQueryParam(':job_id',  $job_id);
	// $this->bindQueryParam(':regionID',  $regionID);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"job_id"=>$row["job_id"],
					"job_title"=>$row["job_title"],
					"job_desc"=>$row["job_desc"],
					"salary_id"=>$row["salary_id"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	}

}


?>