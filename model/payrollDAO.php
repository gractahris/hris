<?php

class payrollDAO extends DAO {
	public function savePayroll($emp_id,
							$payroll_month,
							$payroll_year,
							$cut_off_start,
							$cut_off_end,
							$total_hours_comp,
							$total_min_comp,
							$salary_as_per_logs,
							$sss_cont_ep,
							$ph_cont_ep,
							$pagibig_cont_ep,
							$sss_cont_ee,
							$ph_cont_ee,
							$pagibig_cont_ee,
							$tax_cont,
							$total_salary,
							$salary_as_per_contract,
							$emp_ot,
							$emp_lates,
							$total_hoursAbsent,
							$total_minAbsent,
							$total_hoursExcess,
							$total_minExcess,
							$weekend,
							$night_diff
							){

		$sql= "INSERT INTO tbl_payroll(emp_id,
				payroll_month,
				payroll_year,
				cut_off_start,
				cut_off_end,
				total_hours_comp,
				total_min_comp,
				salary_as_per_logs,
				sss_cont_ep,
				ph_cont_ep,
				pagibig_cont_ep,
				sss_cont_ee,
				ph_cont_ee,
				pagibig_cont_ee,
				tax_cont,
				total_salary,
				salary_as_per_contract,
				emp_ot,
				emp_lates,
				total_hoursAbsent,
				total_minAbsent,
				total_hoursExcess,
				total_minExcess,
				weekends,
				night_diff
				)
		VALUES('".$emp_id."','".
		$payroll_month."','".
		$payroll_year."','".
		$cut_off_start."','".
		$cut_off_end."','".
		$total_hours_comp."','".
		$total_min_comp."','".
		$salary_as_per_logs."','".
		$sss_cont_ep."','".
		$ph_cont_ep."','".
		$pagibig_cont_ep."','".
		$sss_cont_ee."','".
		$ph_cont_ee."','".
		$pagibig_cont_ee."','".
		$tax_cont."','".
		$total_salary."','".
		$salary_as_per_contract."','".
		$emp_ot."','".
		$emp_lates."','".
		$total_hoursAbsent."','".
		$total_minAbsent."','".
		$total_hoursExcess."','".
		$total_minExcess."','".
		$weekend."','".
		$night_diff."');";
		
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
	


	public function getEmpLogs($emp_id,$dtr_id){ //
	$sql = "SELECT
			ref_id,
			emp_id,
			dtr_id,
			emp_timein,
			emp_timeout,
			emp_totalhours,
			SUBSTR(emp_totalhours FROM 1 FOR 2) as hoursComplete,
			SUBSTR(emp_totalhours FROM 4 FOR 2) as minComplete,
			SUBSTR(emp_excesstime FROM 1 FOR 2) as hoursExcess,
			SUBSTR(emp_excesstime FROM 4 FOR 2) as minExcess,
			SUBSTR(emp_late FROM 1 FOR 2) as hoursLate,
			SUBSTR(emp_late FROM 4 FOR 2) as minLate,
			SUBSTR(emp_undertime FROM 1 FOR 2) as hoursUndertime,
			SUBSTR(emp_undertime FROM 4 FOR 2) as minUndertime,
			SUBSTR(emp_weekend FROM 1 FOR 2) as hoursWeekEnd,
			SUBSTR(emp_weekend FROM 4 FOR 2) as minWeekEnd,
			emp_late,
			emp_excesstime,
			emp_undertime,
			emp_weekend
			FROM `tbl_employee_timelog`
			WHERE emp_id = '".$emp_id."'
			AND dtr_id = '".$dtr_id."'
			ORDER BY dtr_id;";
	
	$this->openDB();
	$this->prepareQuery($sql);
	//echo $sql;
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
					"emp_totalhours"=>$row["emp_totalhours"],
					"emp_late"=>$row["emp_late"],
					"emp_excesstime"=>$row["emp_excesstime"],
					"emp_undertime"=>$row["emp_undertime"],
					"hoursComplete"=>$row["hoursComplete"],
					"minComplete"=>$row["minComplete"],
					"hoursExcess"=>$row["hoursExcess"],
					"minExcess"=>$row["minExcess"],
					"hoursLate"=>$row["hoursLate"],
					"minLate"=>$row["minLate"],
					"hoursUndertime"=>$row["hoursUndertime"],
					"minUndertime"=>$row["minUndertime"],
					"hoursWeekEnd"=>$row["hoursWeekEnd"],
					"minWeekEnd"=>$row["minWeekEnd"],
					
				);	
		$arrOfData[$i] = $dtr;
		}
	$this->closeDB();
	return $arrOfData;
	// return $sql;
	
	// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
	// return $totalPaxPerFO;
	}

	public function getEmpLogsOld($emp_id){ //
		$sql = "SELECT
			ref_id,
			emp_id,
			dtr_id,
			emp_timein,
			emp_timeout,
			emp_totalhours,
			SUBSTR(emp_totalhours FROM 1 FOR 2) as hoursComplete,
			SUBSTR(emp_totalhours FROM 4 FOR 2) as minComplete,
			emp_late,
			emp_excesstime,
			emp_undertime
			FROM `tbl_employee_timelog`
			WHERE emp_id = $emp_id";
		//AND dtr_id = '".$dtr_id."'
		//ORDER BY dtr_id;";

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
					"emp_totalhours"=>$row["emp_totalhours"],
					"emp_late"=>$row["emp_late"],
					"emp_excesstime"=>$row["emp_excesstime"],
					"emp_undertime"=>$row["emp_undertime"],
					"hoursComplete"=>$row["hoursComplete"],
					"minComplete"=>$row["minComplete"],

			);
			$arrOfData[$i] = $dtr;
		}
		$this->closeDB();
		return $arrOfData;
		// return $sql;

		// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
		// return $totalPaxPerFO;
	}

	//public function getSSSCont($sss_range_from,$sss_range_to){ //
	public function getSSSCont($salary){ //
		$sql = "SELECT
				sss_id,
				sss_range_from,
				sss_range_to,
				sss_employer_share,
				sss_employee_share,
				sss_total_contribution
				FROM `lib_sss`
				where $salary
				BETWEEN sss_range_from and sss_range_to;";
				/*where sss_range_from = $sss_range_from
				and sss_range_to = $sss_range_to*/";
		//AND dtr_id = '".
		//$dtr_id."'
		//ORDER BY dtr_id;";

		$this->openDB();
		$this->prepareQuery($sql);
		//echo $sql;
		/*$this->bindQueryParam(':sss_range_from',  $sss_range_from);
		$this->bindQueryParam(':sss_range_to',  $sss_range_to);*/
		 $this->bindQueryParam(':salary',  $salary);
		// $this->bindQueryParam(':year',  $year);
		$result = $this->executeQuery();

		$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
			(
					"sss_id"=>$row["sss_id"],
					"sss_range_from"=>$row["sss_range_from"],
					"sss_range_to"=>$row["sss_range_to"],
					"sss_employer_share"=>$row["sss_employer_share"],
					"sss_employee_share"=>$row["sss_employee_share"],
					"sss_total_contribution"=>$row["sss_total_contribution"],
					/*"hoursComplete"=>$row["hoursComplete"],
					"minComplete"=>$row["minComplete"],*/

			);
			$arrOfData[$i] = $dtr;
		}
		$this->closeDB();
		return $arrOfData;
		// return $sql;

		// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
		// return $totalPaxPerFO;
	}

	public function getPhilHealthCont($salary){ //
		$sql = "SELECT
				ph_id,
				ph_range_from,
				ph_range_to,
				ph_employer_share,
				ph_employee_share,
				ph_total_contribution
				FROM `lib_philhealth`
				where $salary
				BETWEEN ph_range_from and ph_range_to;";
		/*where ph_range_from = $ph_range_from
        and ph_range_to = $ph_range_to*/";
		//AND dtr_id = '".
		//$dtr_id."'
		//ORDER BY dtr_id;";

		$this->openDB();
		$this->prepareQuery($sql);
		//echo $sql;
		/*$this->bindQueryParam(':ph_range_from',  $ph_range_from);
		$this->bindQueryParam(':ph_range_to',  $ph_range_to);*/
		$this->bindQueryParam(':salary',  $salary);
		// $this->bindQueryParam(':year',  $year);
		$result = $this->executeQuery();

		$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
			(
					"ph_id"=>$row["ph_id"],
					"ph_range_from"=>$row["ph_range_from"],
					"ph_range_to"=>$row["ph_range_to"],
					"ph_employer_share"=>$row["ph_employer_share"],
					"ph_employee_share"=>$row["ph_employee_share"],
					"ph_total_contribution"=>$row["ph_total_contribution"],
				/*"hoursComplete"=>$row["hoursComplete"],
                "minComplete"=>$row["minComplete"],*/

			);
			$arrOfData[$i] = $dtr;
		}
		$this->closeDB();
		return $arrOfData;
		// return $sql;

		// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
		// return $totalPaxPerFO;
	}
	public function getAllEmp($start,$limit){ //
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
				order by empLastName
				LIMIT $start, $limit";
				//where emp_id = 1";
		/*where ph_range_from = $ph_range_from
        and ph_range_to = $ph_range_to*/";
		//AND dtr_id = '".
		//$dtr_id."'
		//ORDER BY dtr_id;";

		$this->openDB();
		$this->prepareQuery($sql);
		//echo $sql;
		/*$this->bindQueryParam(':ph_range_from',  $ph_range_from);
		$this->bindQueryParam(':ph_range_to',  $ph_range_to);*/
		//$this->bindQueryParam(':salary',  $salary);
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
					"empExtensionName"=>$row["empExtensionName"],
					"sex_id"=>$row["sex_id"],
					"schedule_id"=>$row["schedule_id"],
               		"salary_id"=>$row["salary_id"],
               		"tax_category_id"=>$row["tax_category_id"],
               		"date_hired"=>$row["date_hired"],

			);
			$arrOfData[$i] = $dtr;
		}
		$this->closeDB();
		return $arrOfData;
		// return $sql;

		// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
		// return $totalPaxPerFO;
	}
	
	public function getAllEmpViaID($emp_id){ //
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
				where emp_id = $emp_id
				order by empLastName";
				//where emp_id = 1";
		/*where ph_range_from = $ph_range_from
        and ph_range_to = $ph_range_to*/";
		//AND dtr_id = '".
		//$dtr_id."'
		//ORDER BY dtr_id;";

		$this->openDB();
		$this->prepareQuery($sql);
		//echo $sql;
		/*$this->bindQueryParam(':ph_range_from',  $ph_range_from);
		$this->bindQueryParam(':ph_range_to',  $ph_range_to);*/
		//$this->bindQueryParam(':salary',  $salary);
		$this->bindQueryParam(':emp_id',  $emp_id);
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

			);
			$arrOfData[$i] = $dtr;
		}
		$this->closeDB();
		return $arrOfData;
		// return $sql;

		// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
		// return $totalPaxPerFO;
	}

	//monthly
	public function getTax($tax_category_id, $salary,$cutOff){ //
		$sql = "SELECT max(CAST(tax_ceiling AS DECIMAL (11,2))) as maxTaxCeiling,
				max(CAST(exact_tax AS DECIMAL (11,2))) as maxExactTax,
				max(CAST(over_percentage AS DECIMAL (11,2))) as maxOverPercentage,
				tax_category_id,cutOff
				FROM `lib_tax_table`
				where tax_category_id = $tax_category_id
				and CAST(tax_ceiling AS DECIMAL (11,2)) <= '".$salary."'
				and cutOff = ".$cutOff.";";
				//and tax_ceiling <= '".$salary."';";
		/*where ph_range_from = $ph_range_from
        and ph_range_to = $ph_range_to*/";
		//AND dtr_id = '".
		//$dtr_id."'
		//ORDER BY dtr_id;";

		$this->openDB();
		$this->prepareQuery($sql);
		// echo $sql;
		$this->bindQueryParam(':tax_category_id',  $tax_category_id);
		$this->bindQueryParam(':salary',  $salary);
		$this->bindQueryParam(':cutOff',  $cutOff);
		// $this->bindQueryParam(':year',  $year);
		$result = $this->executeQuery();

		$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
			(
					"maxTaxCeiling"=>$row["maxTaxCeiling"],
					"maxExactTax"=>$row["maxExactTax"],
					"maxOverPercentage"=>$row["maxOverPercentage"],
					"tax_category_id"=>$row["tax_category_id"],
					"cutOff"=>$row["cutOff"],
					/*"empExtensionName"=>$row["empExtensionName"],
					"sex_id"=>$row["sex_id"],
					"schedule_id"=>$row["schedule_id"],
					"salary_id"=>$row["salary_id"],
					"tax_category_id"=>$row["tax_category_id"],
					"date_hired"=>$row["date_hired"],*/

			);
			$arrOfData[$i] = $dtr;
		}
		$this->closeDB();
		return $arrOfData;
		// return $sql;

		// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
		// return $totalPaxPerFO;
	}


	public function getTaxMin($tax_category_id){ //
		$sql = "SELECT MIN(CAST(tax_ceiling AS DECIMAL (11,2))) as minTaxCeiling
				FROM `lib_tax_table`
				where tax_category_id = $tax_category_id";
		/*where ph_range_from = $ph_range_from
        and ph_range_to = $ph_range_to*/";
		//AND dtr_id = '".
		//$dtr_id."'
		//ORDER BY dtr_id;";

		$this->openDB();
		$this->prepareQuery($sql);
		//echo $sql;
		$this->bindQueryParam(':tax_category_id',  $tax_category_id);
		//$this->bindQueryParam(':salary',  $salary);
		//$this->bindQueryParam(':salary',  $salary);
		// $this->bindQueryParam(':year',  $year);
		$result = $this->executeQuery();

		$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
			(
					"minTaxCeiling"=>$row["minTaxCeiling"],
					/*"maxExactTax"=>$row["maxExactTax"],
					"maxOverPercentage"=>$row["maxOverPercentage"],
					"tax_category_id"=>$row["tax_category_id"],*/
				/*"empExtensionName"=>$row["empExtensionName"],
                "sex_id"=>$row["sex_id"],
                "schedule_id"=>$row["schedule_id"],
                "salary_id"=>$row["salary_id"],
                "tax_category_id"=>$row["tax_category_id"],
                "date_hired"=>$row["date_hired"],*/

			);
			$arrOfData[$i] = $dtr;
		}
		$this->closeDB();
		return $arrOfData;
		// return $sql;

		// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
		// return $totalPaxPerFO;
	}

	public function getSalaryByID($salary_id){ //
		$sql = "SELECT
				salary_id,
				salary_amount
				FROM `lib_salary`
				WHERE salary_id = $salary_id";
		//where emp_id = 1";
		/*where ph_range_from = $ph_range_from
        and ph_range_to = $ph_range_to*/";
		//AND dtr_id = '".
		//$dtr_id."'
		//ORDER BY dtr_id;";

		$this->openDB();
		$this->prepareQuery($sql);
		//echo $sql;
		$this->bindQueryParam(':salary_id',  $salary_id);
		/*$this->bindQueryParam(':ph_range_to',  $ph_range_to);*/
		//$this->bindQueryParam(':salary',  $salary);
		// $this->bindQueryParam(':year',  $year);
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
		// return $sql;

		// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
		// return $totalPaxPerFO;
	}

	public function getDTRByID($emp_id,$month,$year,$dayStart,$dayEnd){ //
		$sql = "SELECT
				dtr_id,
				emp_id,
				`month`,
				`day`,
				`year`
				FROM
				tbl_createdtr
				WHERE emp_id = $emp_id
				AND month = $month
				and day >= $dayStart
				and day <= $dayEnd
				AND year = $year
				order by dtr_id";
		//where emp_id = 1";
		/*where ph_range_from = $ph_range_from
        and ph_range_to = $ph_range_to*/";
		//AND dtr_id = '".
		//$dtr_id."'
		//ORDER BY dtr_id;";

		$this->openDB();
		$this->prepareQuery($sql);
		//echo $sql;
		$this->bindQueryParam(':emp_id',  $emp_id);
		$this->bindQueryParam(':month',  $month);
		//$this->bindQueryParam(':salary',  $salary);
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


	public function getEmpLogsByDTR($emp_id){ //
		$sql = "SELECT
			ref_id,
			emp_id,
			dtr_id,
			emp_timein,
			emp_timeout,
			emp_totalhours,
			SUBSTR(emp_totalhours FROM 1 FOR 2) as hoursComplete,
			SUBSTR(emp_totalhours FROM 4 FOR 2) as minComplete,
			emp_late,
			emp_excesstime,
			emp_undertime
			FROM `tbl_employee_timelog`
			WHERE emp_id = $emp_id";
		//AND dtr_id = '".$dtr_id."'
		//ORDER BY dtr_id;";

		$this->openDB();
		$this->prepareQuery($sql);
		 echo $sql;
		$this->bindQueryParam(':emp_id',  $emp_id);
		//$this->bindQueryParam(':dtr_id',  $dtr_id);
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
					"emp_totalhours"=>$row["emp_totalhours"],
					"emp_late"=>$row["emp_late"],
					"emp_excesstime"=>$row["emp_excesstime"],
					"emp_undertime"=>$row["emp_undertime"],
					"hoursComplete"=>$row["hoursComplete"],
					"minComplete"=>$row["minComplete"],

			);
			$arrOfData[$i] = $dtr;
		}
		$this->closeDB();
		return $arrOfData;
		// return $sql;

		// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
		// return $totalPaxPerFO;
	}


	public function getCutOff($cut_off_id){ //
		$sql = "SELECT
			cut_off_id,
			cut_off_title,
			cut_off_start,
			cut_off_end
			FROM
			lib_cutoff
			WHERE cut_off_id = $cut_off_id";
		//AND dtr_id = '".$dtr_id."'
		//ORDER BY dtr_id;";

		$this->openDB();
		$this->prepareQuery($sql);
		// echo $sql;
		$this->bindQueryParam(':cut_off_id',  $cut_off_id);
		//$this->bindQueryParam(':dtr_id',  $dtr_id);
		// $this->bindQueryParam(':day',  $day);
		// $this->bindQueryParam(':year',  $year);
		$result = $this->executeQuery();

		$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
			(
					"cut_off_id"=>$row["cut_off_id"],
					"cut_off_title"=>$row["cut_off_title"],
					"cut_off_start"=>$row["cut_off_start"],
					"cut_off_end"=>$row["cut_off_end"],
					/*"emp_excesstime"=>$row["emp_excesstime"],
					"emp_undertime"=>$row["emp_undertime"],
					"hoursComplete"=>$row["hoursComplete"],
					"minComplete"=>$row["minComplete"],*/

			);
			$arrOfData[$i] = $dtr;
		}
		$this->closeDB();
		return $arrOfData;
		// return $sql;

		// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
		// return $totalPaxPerFO;
	}

	public function getAllCutOff(){ //
		$sql = "SELECT
			cut_off_id,
			cut_off_title,
			cut_off_start,
			cut_off_end
			FROM
			lib_cutoff";
		//AND dtr_id = '".$dtr_id."'
		//ORDER BY dtr_id;";

		$this->openDB();
		$this->prepareQuery($sql);
		// echo $sql;
		//$this->bindQueryParam(':cut_off_id',  $cut_off_id);
		//$this->bindQueryParam(':dtr_id',  $dtr_id);
		// $this->bindQueryParam(':day',  $day);
		// $this->bindQueryParam(':year',  $year);
		$result = $this->executeQuery();

		$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
			(
					"cut_off_id"=>$row["cut_off_id"],
					"cut_off_title"=>$row["cut_off_title"],
					"cut_off_start"=>$row["cut_off_start"],
					"cut_off_end"=>$row["cut_off_end"],
				/*"emp_excesstime"=>$row["emp_excesstime"],
                "emp_undertime"=>$row["emp_undertime"],
                "hoursComplete"=>$row["hoursComplete"],
                "minComplete"=>$row["minComplete"],*/

			);
			$arrOfData[$i] = $dtr;
		}
		$this->closeDB();
		return $arrOfData;
		// return $sql;

		// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
		// return $totalPaxPerFO;
	}
	
	public function getPayroll($payroll_month,$payroll_year,$cut_off_start, $cut_off_end){ //
		$sql = "SELECT
				payroll_id,
				emp_id,
				payroll_month,
				payroll_year,
				cut_off_start,
				cut_off_end,
				total_hours_comp,
				total_min_comp,
				salary_as_per_logs,
				sss_cont_ep,
				ph_cont_ep,
				pagibig_cont_ep,
				sss_cont_ee,
				ph_cont_ee,
				pagibig_cont_ee,
				total_salary,
				tax_cont,
				salary_as_per_contract,
				emp_ot,
				emp_lates,
				total_hoursAbsent,
				total_minAbsent,
				total_hoursExcess,
				total_minExcess,
				weekends,
				night_diff
				FROM `tbl_payroll`
				WHERE payroll_month = '".$payroll_month."'
				AND payroll_year = '".$payroll_year."'
				AND cut_off_start = '".$cut_off_start."'
				AND cut_off_end = '".$cut_off_end."';";
		//AND dtr_id = '".$dtr_id."'
		//ORDER BY dtr_id;";

		$this->openDB();
		$this->prepareQuery($sql);
		// echo $sql;
		$this->bindQueryParam(':payroll_month',  $payroll_month);
		$this->bindQueryParam(':payroll_year',  $payroll_year);
		$this->bindQueryParam(':cut_off_start',  $cut_off_start);
		$this->bindQueryParam(':cut_off_start', $cut_off_end);
		$result = $this->executeQuery();

		$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
			(
					"payroll_id"=>$row["payroll_id"],
					"emp_id"=>$row["emp_id"],
					"payroll_month"=>$row["payroll_month"],
					"payroll_year"=>$row["payroll_year"],
					"cut_off_start"=>$row["cut_off_start"],
					"cut_off_end"=>$row["cut_off_end"],
					"total_hours_comp"=>$row["total_hours_comp"],
					"total_min_comp"=>$row["total_min_comp"],
					"salary_as_per_logs"=>$row["salary_as_per_logs"],
					"sss_cont_ep"=>$row["sss_cont_ep"],
					"ph_cont_ep"=>$row["ph_cont_ep"],
					"pagibig_cont_ep"=>$row["pagibig_cont_ep"],
					"sss_cont_ee"=>$row["sss_cont_ee"],
					"ph_cont_ee"=>$row["ph_cont_ee"],
					"pagibig_cont_ee"=>$row["pagibig_cont_ee"],
					"total_salary"=>$row["total_salary"],
					"tax_cont"=>$row["tax_cont"],
					"salary_as_per_contract"=>$row["salary_as_per_contract"],
					"emp_ot"=>$row["emp_ot"],
					"emp_lates"=>$row["emp_lates"],
					"total_hoursAbsent"=>$row["total_hoursAbsent"],
					"total_minAbsent"=>$row["total_minAbsent"],
					"total_hoursExcess"=>$row["total_hoursExcess"],
					"total_minExcess"=>$row["total_minExcess"],
					"weekends"=>$row["weekends"],
					"night_diff"=>$row["night_diff"],

			);
			$arrOfData[$i] = $dtr;
		}
		$this->closeDB();
		return $arrOfData;
		// return $sql;

		// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
		// return $totalPaxPerFO;
	}
	
	public function getPayrollByID($payroll_month,$payroll_year,$cut_off_start, $cut_off_end,$emp_id){ //
		$sql = "SELECT
				payroll_id,
				emp_id,
				payroll_month,
				payroll_year,
				cut_off_start,
				cut_off_end,
				total_hours_comp,
				total_min_comp,
				salary_as_per_logs,
				sss_cont_ep,
				ph_cont_ep,
				pagibig_cont_ep,
				sss_cont_ee,
				ph_cont_ee,
				pagibig_cont_ee,
				total_salary,
				tax_cont,
				salary_as_per_contract,
				emp_ot,
				emp_lates,
				total_hoursAbsent,
				total_minAbsent,
				total_hoursExcess,
				total_minExcess,
				weekends,
				night_diff
				FROM `tbl_payroll`
				WHERE payroll_month = '".$payroll_month."'
				AND payroll_year = '".$payroll_year."'
				AND cut_off_start = '".$cut_off_start."'
				AND emp_id = '".$emp_id."'
				AND cut_off_end = '".$cut_off_end."';";
		//AND dtr_id = '".$dtr_id."'
		//ORDER BY dtr_id;";

		$this->openDB();
		$this->prepareQuery($sql);
		// echo $sql;
		$this->bindQueryParam(':payroll_month',  $payroll_month);
		$this->bindQueryParam(':payroll_year',  $payroll_year);
		$this->bindQueryParam(':cut_off_start',  $cut_off_start);
		$this->bindQueryParam(':cut_off_start', $cut_off_end);
		$this->bindQueryParam(':emp_id', $emp_id);
		$result = $this->executeQuery();

		$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
			(
					"payroll_id"=>$row["payroll_id"],
					"emp_id"=>$row["emp_id"],
					"payroll_month"=>$row["payroll_month"],
					"payroll_year"=>$row["payroll_year"],
					"cut_off_start"=>$row["cut_off_start"],
					"cut_off_end"=>$row["cut_off_end"],
					"total_hours_comp"=>$row["total_hours_comp"],
					"total_min_comp"=>$row["total_min_comp"],
					"salary_as_per_logs"=>$row["salary_as_per_logs"],
					"sss_cont_ep"=>$row["sss_cont_ep"],
					"ph_cont_ep"=>$row["ph_cont_ep"],
					"pagibig_cont_ep"=>$row["pagibig_cont_ep"],
					"sss_cont_ee"=>$row["sss_cont_ee"],
					"ph_cont_ee"=>$row["ph_cont_ee"],
					"pagibig_cont_ee"=>$row["pagibig_cont_ee"],
					"total_salary"=>$row["total_salary"],
					"tax_cont"=>$row["tax_cont"],
					"salary_as_per_contract"=>$row["salary_as_per_contract"],
					"emp_ot"=>$row["emp_ot"],
					"emp_lates"=>$row["emp_lates"],
					"total_hoursAbsent"=>$row["total_hoursAbsent"],
					"total_minAbsent"=>$row["total_minAbsent"],
					"total_hoursExcess"=>$row["total_hoursExcess"],
					"total_minExcess"=>$row["total_minExcess"],
					"weekends"=>$row["weekends"],
					"night_diff"=>$row["night_diff"],

			);
			$arrOfData[$i] = $dtr;
		}
		$this->closeDB();
		return $arrOfData;
		// return $sql;

		// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
		// return $totalPaxPerFO;
	}
	
	public function getAllCutOffByID($cut_off_id){ //
		$sql = "SELECT
			cut_off_id,
			cut_off_title,
			cut_off_start,
			cut_off_end
			FROM
			lib_cutoff
			WHERE cut_off_id = $cut_off_id";
		//AND dtr_id = '".$dtr_id."'
		//ORDER BY dtr_id;";

		$this->openDB();
		$this->prepareQuery($sql);
		// echo $sql;
		$this->bindQueryParam(':cut_off_id',  $cut_off_id);
		//$this->bindQueryParam(':dtr_id',  $dtr_id);
		// $this->bindQueryParam(':day',  $day);
		// $this->bindQueryParam(':year',  $year);
		$result = $this->executeQuery();

		$arrOfData = array();
		$trash = array_pop($arrOfData);
		foreach($result as $i=>$row)
		{
			$dtr = array
			(
					"cut_off_id"=>$row["cut_off_id"],
					"cut_off_title"=>$row["cut_off_title"],
					"cut_off_start"=>$row["cut_off_start"],
					"cut_off_end"=>$row["cut_off_end"],
				/*"emp_excesstime"=>$row["emp_excesstime"],
                "emp_undertime"=>$row["emp_undertime"],
                "hoursComplete"=>$row["hoursComplete"],
                "minComplete"=>$row["minComplete"],*/

			);
			$arrOfData[$i] = $dtr;
		}
		$this->closeDB();
		return $arrOfData;
		// return $sql;

		// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
		// return $totalPaxPerFO;
	}
	
	
	public function getAllEmpByID($emp_id){ //
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
				where emp_id = $emp_id
				order by empLastName;";
		/*where ph_range_from = $ph_range_from
        and ph_range_to = $ph_range_to*/";
		//AND dtr_id = '".
		//$dtr_id."'
		//ORDER BY dtr_id;";

		$this->openDB();
		$this->prepareQuery($sql);
		//echo $sql;
		$this->bindQueryParam(':emp_id',  $emp_id);
		// $this->bindQueryParam(':ph_range_to',  $ph_range_to);*/
		//$this->bindQueryParam(':salary',  $salary);
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
					"empExtensionName"=>$row["empExtensionName"],
					"sex_id"=>$row["sex_id"],
					"schedule_id"=>$row["schedule_id"],
               		"salary_id"=>$row["salary_id"],
               		"tax_category_id"=>$row["tax_category_id"],
               		"date_hired"=>$row["date_hired"],

			);
			$arrOfData[$i] = $dtr;
		}
		$this->closeDB();
		return $arrOfData;
		// return $sql;

		// $totalPaxPerFO = $result[0]['totalPaxPerFO'];
		// return $totalPaxPerFO;
	}
	
	public function updatePayroll($total_hours_comp,$total_min_comp,$salary_as_per_logs,$sss_cont_ep,$ph_cont_ep,$pagibig_cont_ep,$sss_cont_ee,$ph_cont_ee,$pagibig_cont_ee,$total_salary,$tax_cont,$salary_as_per_contract,$emp_ot,$emp_lates,$total_hoursAbsent,$total_minAbsent,$total_hoursExcess,$total_minExcess,$weekends,$night_diff, $payroll_month,$payroll_year,$cut_off_start,$cut_off_end,$emp_id){

		$sql= "UPDATE tbl_payroll
				SET total_hours_comp = '".$total_hours_comp."',
				total_min_comp = '".$total_min_comp."',
				salary_as_per_logs = '".$salary_as_per_logs."',
				sss_cont_ep = '".$sss_cont_ep."',
				ph_cont_ep = '".$ph_cont_ep."',
				pagibig_cont_ep = '".$pagibig_cont_ep."',
				sss_cont_ee = '".$sss_cont_ee."',
				ph_cont_ee = '".$ph_cont_ee."',
				pagibig_cont_ee = '".$pagibig_cont_ee."',
				total_salary = '".$total_salary."',
				tax_cont = '".$tax_cont."',
				salary_as_per_contract = '".$salary_as_per_contract."',
				emp_ot = '".$emp_ot."',
				emp_lates = '".$emp_lates."',
				total_hoursAbsent = '".$total_hoursAbsent."',
				total_minAbsent = '".$total_minAbsent."',
				total_hoursExcess = '".$total_hoursExcess."',
				total_minExcess = '".$total_minExcess."',
				weekends = '".$weekends."',
				night_diff = '".$night_diff."'
				WHERE payroll_month = '".$payroll_month."'
				AND payroll_year = '".$payroll_year."'
				AND emp_id = '".$emp_id."'
				AND cut_off_start = '".$cut_off_start."'
				AND cut_off_end = '".$cut_off_end."';";
		
		
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
	
	public function countEmpPayroll($emp_id){ //
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


	public function getAllEmpNew(){ //
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
				order by empLastName";
				//where emp_id = 1";
		/*where ph_range_from = $ph_range_from
        and ph_range_to = $ph_range_to*/";
		//AND dtr_id = '".
		//$dtr_id."'
		//ORDER BY dtr_id;";

		$this->openDB();
		$this->prepareQuery($sql);
		//echo $sql;
		/*$this->bindQueryParam(':ph_range_from',  $ph_range_from);
		$this->bindQueryParam(':ph_range_to',  $ph_range_to);*/
		//$this->bindQueryParam(':salary',  $salary);
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
					"empExtensionName"=>$row["empExtensionName"],
					"sex_id"=>$row["sex_id"],
					"schedule_id"=>$row["schedule_id"],
               		"salary_id"=>$row["salary_id"],
               		"tax_category_id"=>$row["tax_category_id"],
               		"date_hired"=>$row["date_hired"],

			);
			$arrOfData[$i] = $dtr;
		}
		$this->closeDB();
		return $arrOfData;
		// return $sql;

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

	public function getSumAmountNoCutOff($emp_id,$month,$year){ //
	$sql = "SELECT sum(deduction_amount) as totalOD
			FROM `tbl_other_deduction`
			where emp_id = '".$emp_id."'
			and month = '".$month."'
			and year = '".$year."';";
			//and cut_off_id = '".$cut_off_id."';";
	
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

	public function getSumDeAmount($emp_id,$month,$year,$cutOff){ //
		$sql = "SELECT emp_id, month, year,deduction_title,deduction_amount
				FROM `tbl_other_deduction`
				where emp_id = '".$emp_id."'
				and month = '".$month."'
				and year = '".$year."'
				and cut_off_id = '".$cutOff."';";
		
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
						// "totalOD"=>$row["totalOD"],
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

		public function getSumDeAmountNoCO($emp_id,$month,$year){ //
	$sql = "SELECT emp_id, month, year,deduction_title,deduction_amount
			FROM `tbl_other_deduction`
			where emp_id = '".$emp_id."'
			and month = '".$month."'
			and year = '".$year."';";
	
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
					// "totalOD"=>$row["totalOD"],
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

	
}
	
?>
