<?php

class employeeDAO extends DAO {

	public function getAllEmployee(){ //
	$sql = "SELECT emp_id,
					empLastName,
					empFirstName,
					empMiddleName,
					empExtensionName,
					sex_id,
					schedule_id,
					salary_id,
					tax_category_id,
					date_hired,
					job_id
			FROM tbl_employee
			ORDER BY empLastName;
					";
	
	// echo $sql;
	$this->openDB();
	$this->prepareQuery($sql);
	// $this->bindQueryParam(':leave_application_id',  $leave_application_id);
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
					"sex_id"=>$row["sex_id"],
					"schedule_id"=>$row["schedule_id"],
					"salary_id"=>$row["salary_id"],
					"tax_category_id"=>$row["tax_category_id"],
					"date_hired"=>$row["date_hired"],
					"job_id"=>$row["job_id"],
					// "emp_id"=>$row["emp_id"],
					// "adaRefID"=>$row["adaRefID"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	}

	public function getEmpByID($emp_id){ //
	$sql = "SELECT emp_id,
					empLastName,
					empFirstName,
					empMiddleName,
					empExtensionName,
					sex_id,
					schedule_id,
					salary_id,
					tax_category_id,
					date_hired,
					job_id
			FROM tbl_employee
			WHERE emp_id = $emp_id
			ORDER BY empLastName;
					";
	
	// echo $sql;
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
					"emp_id"=>$row["emp_id"],
					"empLastName"=>$row["empLastName"],
					"empFirstName"=>$row["empFirstName"],
					"empMiddleName"=>$row["empMiddleName"],
					"empExtensionName"=>$row["empExtensionName"],
					"sex_id"=>$row["sex_id"],
					"schedule_id"=>$row["schedule_id"],
					"salary_id"=>$row["salary_id"],
					"tax_category_id"=>$row["tax_category_id"],
					"date_hired"=>$row["date_hired"],
					"job_id"=>$row["job_id"],
					// "emp_id"=>$row["emp_id"],
					// "adaRefID"=>$row["adaRefID"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	}

	public function searchEmp($searchEmp){ //
	$sql = "SELECT emp_id,
					empLastName,
					empFirstName,
					empMiddleName,
					empExtensionName,
					sex_id,
					schedule_id,
					salary_id,
					tax_category_id,
					date_hired,
					job_id
			FROM tbl_employee
			where empFirstName like '%$searchEmp%'
			OR empMiddleName like '%$searchEmp%'
			OR empLastName like '%$searchEmp%'
			OR empExtensionName like '$searchEmp%'
			OR sex_id IN (select sex_id from lib_sex where sex_title = '$searchEmp')
			OR schedule_id IN (select schedule_id from lib_schedule where schedule_title like '%$searchEmp%')
			OR salary_id IN (select salary_id from lib_salary where salary_amount like '%$searchEmp%')
			OR tax_category_id IN (select tax_category_id from lib_tax_category where tax_category_title like '%$searchEmp%')
			OR date_hired like '%$searchEmp%'
			OR job_id IN (select job_id from lib_job where job_title like '%$searchEmp%')
			OR DATE_FORMAT(date_hired,\"%M\") like '%$searchEmp%'
			OR DATE_FORMAT(date_hired,\"%d\") like '%$searchEmp%'
			OR DATE_FORMAT(date_hired,\"%Y\") like '%$searchEmp%'
			;
			ORDER BY empLastName;
					";
	
	// echo $sql;
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
					"emp_id"=>$row["emp_id"],
					"empLastName"=>$row["empLastName"],
					"empFirstName"=>$row["empFirstName"],
					"empMiddleName"=>$row["empMiddleName"],
					"empExtensionName"=>$row["empExtensionName"],
					"sex_id"=>$row["sex_id"],
					"schedule_id"=>$row["schedule_id"],
					"salary_id"=>$row["salary_id"],
					"tax_category_id"=>$row["tax_category_id"],
					"date_hired"=>$row["date_hired"],
					"job_id"=>$row["job_id"],
					// "emp_id"=>$row["emp_id"],
					// "adaRefID"=>$row["adaRefID"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	}

	public function getSexByID($sex_id){ //
	$sql = "SELECT sex_id,
			sex_title
			FROM lib_sex
			where sex_id = $sex_id;
					";
	
	// echo $sql;
	$this->openDB();
	$this->prepareQuery($sql);
	$this->bindQueryParam(':sex_id',  $sex_id);
	// $this->bindQueryParam(':regionID',  $regionID);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"sex_id"=>$row["sex_id"],
					"sex_title"=>$row["sex_title"],
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

	public function getAllSex(){ //
	$sql = "SELECT sex_id,
			sex_title
			FROM lib_sex;
					";
	
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
					"sex_id"=>$row["sex_id"],
					"sex_title"=>$row["sex_title"],
					// "emp_id"=>$row["emp_id"],
					// "adaRefID"=>$row["adaRefID"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;

	}

	public function getMaxEmpID(){ //
	$sql = "SELECT MAX(emp_id)+1 as maxEmpID
			FROM `tbl_employee`;";
	
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
					"maxEmpID"=>$row["maxEmpID"],
					// "sex_title"=>$row["sex_title"],
					// "emp_id"=>$row["emp_id"],
					// "adaRefID"=>$row["adaRefID"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;

	}

	public function getCountEmp(){ //
	$sql = "SELECT count(emp_id) as countOfEmp
			FROM `tbl_employee`;";
	
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
					"countOfEmp"=>$row["countOfEmp"],
					// "sex_title"=>$row["sex_title"],
					// "emp_id"=>$row["emp_id"],
					// "adaRefID"=>$row["adaRefID"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;

	}

	public function getScheduleByID($schedule_id){ //
	$sql = "SELECT schedule_id,
					schedule_title
			FROM lib_schedule
			where schedule_id = $schedule_id;
					";
	
	// echo $sql;
	$this->openDB();
	$this->prepareQuery($sql);
	$this->bindQueryParam(':schedule_id',  $schedule_id);
	// $this->bindQueryParam(':regionID',  $regionID);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"schedule_id"=>$row["schedule_id"],
					"schedule_title"=>$row["schedule_title"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	}

	public function getAllSchedule(){ //
	$sql = "SELECT schedule_id,
					schedule_title
			FROM lib_schedule;
					";
	
	// echo $sql;
	$this->openDB();
	$this->prepareQuery($sql);
	// $this->bindQueryParam(':schedule_id',  $schedule_id);
	// $this->bindQueryParam(':regionID',  $regionID);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"schedule_id"=>$row["schedule_id"],
					"schedule_title"=>$row["schedule_title"],
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
			where salary_id = $salary_id;
					";
	
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
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	}

	public function getAllSalary(){ //
	$sql = "SELECT salary_id,
					salary_amount
			FROM lib_salary;
					";
	
	// echo $sql;
	$this->openDB();
	$this->prepareQuery($sql);
	// $this->bindQueryParam(':salary_id',  $salary_id);
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
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	}


	public function getTaxCatByID($tax_category_id){ //
	$sql = "SELECT tax_category_id,
					tax_category_code,
					tax_category_title
			FROM lib_tax_category
			where tax_category_id = $tax_category_id;
					";
	
	// echo $sql;
	$this->openDB();
	$this->prepareQuery($sql);
	$this->bindQueryParam(':tax_category_id',  $tax_category_id);
	// $this->bindQueryParam(':regionID',  $regionID);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"tax_category_id"=>$row["tax_category_id"],
					"tax_category_code"=>$row["tax_category_code"],
					"tax_category_title"=>$row["tax_category_title"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	}

	public function getAllTaxCat(){ //
	$sql = "SELECT tax_category_id,
					tax_category_code,
					tax_category_title
			FROM lib_tax_category
					";
	
	// echo $sql;
	$this->openDB();
	$this->prepareQuery($sql);
	// $this->bindQueryParam(':tax_category_id',  $tax_category_id);
	// $this->bindQueryParam(':regionID',  $regionID);
	$result = $this->executeQuery();
	
	$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
				(
					"tax_category_id"=>$row["tax_category_id"],
					"tax_category_code"=>$row["tax_category_code"],
					"tax_category_title"=>$row["tax_category_title"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	}


	public function getJobByID($job_id){ //
	$sql = "SELECT job_id,
				job_title,
				job_desc
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
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	}

	public function getAllJob(){ //
	$sql = "SELECT job_id,
				job_title,
				job_desc
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
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	}


	public function saveEmp($emp_id,
							$empLastName,
							$empFirstName,
							$empMiddleName,
							$empExtensionName,
							$sex_id,
							$schedule_id,
							$salary_id,
							$tax_category_id,
							$date_hired,
							$job_id){

		$sql= "INSERT INTO tbl_employee(emp_id,empLastName,
				empFirstName,
				empMiddleName,
				empExtensionName,
				sex_id,
				schedule_id,
				salary_id,
				tax_category_id,
				date_hired,
				job_id)
		VALUES('".$emp_id."','".
		$empLastName."','".
		$empFirstName."','".
		$empMiddleName."','".
		$empExtensionName."',".
		$sex_id.",'".
		$schedule_id."','".
		$salary_id."','".
		$tax_category_id."','".
		$date_hired."','".
		$job_id."');";
		
		  // echo $sql;
		$this->openDB();
		$this->prepareQuery($sql);
		$this->beginTrans();
				$result = $this->executeUpdate();
				//carla
			
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

	public function updateEmp($empLastName,
							$empFirstName,
							$empMiddleName,
							$empExtensionName,
							$sex_id,
							$schedule_id,
							$salary_id,
							$tax_category_id,
							$date_hired,
							$job_id,$emp_id){

		$sql= "UPDATE tbl_employee
		SET empLastName = '".$empLastName."',
		empFirstName = '".$empFirstName."',
		empMiddleName = '".$empMiddleName."',
		empExtensionName = '".$empExtensionName."',
		sex_id = '".$sex_id."',
		schedule_id = '".$schedule_id."',
		salary_id = '".$salary_id."',
		tax_category_id = '".$tax_category_id."',
		date_hired = '".$date_hired."',
		job_id = '".$job_id."'
		WHERE emp_id=$emp_id;
		";
		
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

	public function delEmp($emp_id){

		$sql= "DELETE FROM tbl_employee
			   WHERE emp_id = $emp_id;";
		
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


	public function getFilterEmp($start,$limit){ //
	$sql = "SELECT emp_id,
					empLastName,
					empFirstName,
					empMiddleName,
					empExtensionName,
					sex_id,
					schedule_id,
					salary_id,
					tax_category_id,
					date_hired,
					job_id
			FROM tbl_employee
			ORDER BY empLastName
			LIMIT $start, $limit;
					";
	
	// echo $sql;
	$this->openDB();
	$this->prepareQuery($sql);
	// $this->bindQueryParam(':leave_application_id',  $leave_application_id);
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
					"sex_id"=>$row["sex_id"],
					"schedule_id"=>$row["schedule_id"],
					"salary_id"=>$row["salary_id"],
					"tax_category_id"=>$row["tax_category_id"],
					"date_hired"=>$row["date_hired"],
					"job_id"=>$row["job_id"],
					// "emp_id"=>$row["emp_id"],
					// "adaRefID"=>$row["adaRefID"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	}


	public function countSearchEmp($searchEmp){ //
	$sql = "SELECT count(emp_id) as countEmp,
					empLastName,
					empFirstName,
					empMiddleName,
					empExtensionName,
					sex_id,
					schedule_id,
					salary_id,
					tax_category_id,
					date_hired,
					job_id
			FROM tbl_employee
			where empFirstName like '%$searchEmp%'
			OR empMiddleName like '%$searchEmp%'
			OR empLastName like '%$searchEmp%'
			OR empExtensionName like '$searchEmp%'
			OR sex_id IN (select sex_id from lib_sex where sex_title = '$searchEmp')
			OR schedule_id IN (select schedule_id from lib_schedule where schedule_title like '%$searchEmp%')
			OR salary_id IN (select salary_id from lib_salary where salary_amount like '%$searchEmp%')
			OR tax_category_id IN (select tax_category_id from lib_tax_category where tax_category_title like '%$searchEmp%')
			OR date_hired like '%$searchEmp%'
			OR job_id IN (select job_id from lib_job where job_title like '%$searchEmp%')
			OR DATE_FORMAT(date_hired,\"%M\") like '%$searchEmp%'
			OR DATE_FORMAT(date_hired,\"%d\") like '%$searchEmp%'
			OR DATE_FORMAT(date_hired,\"%Y\") like '%$searchEmp%'
			;
			ORDER BY empLastName;
					";
	
	// echo $sql;
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
					"countEmp"=>$row["countEmp"],
					"empLastName"=>$row["empLastName"],
					"empFirstName"=>$row["empFirstName"],
					"empMiddleName"=>$row["empMiddleName"],
					"empExtensionName"=>$row["empExtensionName"],
					"sex_id"=>$row["sex_id"],
					"schedule_id"=>$row["schedule_id"],
					"salary_id"=>$row["salary_id"],
					"tax_category_id"=>$row["tax_category_id"],
					"date_hired"=>$row["date_hired"],
					"job_id"=>$row["job_id"],
					// "emp_id"=>$row["emp_id"],
					// "adaRefID"=>$row["adaRefID"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	}

	public function searchEmpDetails($searchEmp,$start,$limit){ //
	$sql = "SELECT count(emp_id) as countEmp,
					empLastName,
					empFirstName,
					empMiddleName,
					empExtensionName,
					sex_id,
					schedule_id,
					salary_id,
					tax_category_id,
					date_hired,
					job_id,emp_id
			FROM tbl_employee
			where empFirstName like '%$searchEmp%'
			OR empMiddleName like '%$searchEmp%'
			OR empLastName like '%$searchEmp%'
			OR empExtensionName like '$searchEmp%'
			OR sex_id IN (select sex_id from lib_sex where sex_title = '$searchEmp')
			OR schedule_id IN (select schedule_id from lib_schedule where schedule_title like '%$searchEmp%')
			OR salary_id IN (select salary_id from lib_salary where salary_amount like '%$searchEmp%')
			OR tax_category_id IN (select tax_category_id from lib_tax_category where tax_category_title like '%$searchEmp%')
			OR date_hired like '%$searchEmp%'
			OR job_id IN (select job_id from lib_job where job_title like '%$searchEmp%')
			OR DATE_FORMAT(date_hired,\"%M\") like '%$searchEmp%'
			OR DATE_FORMAT(date_hired,\"%d\") like '%$searchEmp%'
			OR DATE_FORMAT(date_hired,\"%Y\") like '%$searchEmp%'
			GROUP BY emp_id
			LIMIT $start, $limit;
					";
	
	// echo $sql;
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
					"countEmp"=>$row["countEmp"],
					"empLastName"=>$row["empLastName"],
					"empFirstName"=>$row["empFirstName"],
					"empMiddleName"=>$row["empMiddleName"],
					"empExtensionName"=>$row["empExtensionName"],
					"sex_id"=>$row["sex_id"],
					"schedule_id"=>$row["schedule_id"],
					"salary_id"=>$row["salary_id"],
					"tax_category_id"=>$row["tax_category_id"],
					"date_hired"=>$row["date_hired"],
					"job_id"=>$row["job_id"],
					"emp_id"=>$row["emp_id"],
					// "adaRefID"=>$row["adaRefID"],
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	}

	
	
	
}
	
?>
