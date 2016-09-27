<?php
	/*echo "x_leave_type_id => ".$_POST["x_leave_type_id"];
	echo "<br/>";
	echo "x_sickness => ".$_POST["x_sickness"];echo "<br/>";
	echo "x_place_to_visit => ".$_POST["x_place_to_visit"];echo "<br/>";
	echo "x_days_to_leave => ".$_POST["x_days_to_leave"];echo "<br/>";
	echo "x_status_id => ".$_POST["x_status_id"];echo "<br/>";
	echo "x_leave_application_id => ".$_POST["x_leave_application_id"];echo "<br/>";
	echo "emp_id ";
	echo $_POST['x_emp_id'];
	echo "<br/>";*/

	$leaveApplicationDAO = new leaveApplicationDAO();
	$timesheetDAO = new timesheetDAO();
	
	$x_leave_application_id =$_POST["x_leave_application_id"];
	$x_leave_type_id =$_POST["x_leave_type_id"];
	$x_sickness = $_POST["x_sickness"];
	$x_place_to_visit =$_POST["x_place_to_visit"];
	$x_days_to_leave =$_POST["x_days_to_leave"];
	$x_status_id =$_POST["x_status_id"];
	$x_emp_id =$_POST["x_emp_id"];

	$leaveCreditDAO = new leaveCreditDAO();
	$getLeaveCreditByEmp = $leaveCreditDAO->getLeaveCreditByEmp($x_emp_id,$x_leave_type_id);
	 //print_r($getLeaveCreditByEmp);

?>

<?php

if($x_leave_application_id <> NULL)
{
	if($getLeaveCreditByEmp <> NULL)
	{
	foreach($getLeaveCreditByEmp as $key=> $val)
	{
		$getLeaveTypeByID = $leaveCreditDAO->getLeaveTypeByID($x_leave_type_id);
		
		//print_r($getLeaveTypeByID);

		if($x_status_id == 1) {

			$updateLeaveApplication = $leaveApplicationDAO->updateLeaveApplication($x_leave_application_id, $x_status_id,$x_leave_type_id);
			if($updateLeaveApplication == true)
			{
				header("Refresh:0");
			}
			$leaveApplicationDAO->updateLeaveApplication($x_leave_application_id, $x_status_id,$x_leave_type_id);
			//pending leave
		}else
		{
			$leaveApplicationDAO->updateLeaveApplication($x_leave_application_id, $x_status_id,$x_leave_type_id);


			$getLeaveCoverage = $leaveApplicationDAO->getLeaveCoverage($x_leave_application_id);

			// echo "<pre>";
			// print_r($getLeaveCoverage);
			// echo "</pre>";
			echo "<br/>";
			foreach($getLeaveCoverage as $key=>$val)
			{
				$dateFrom = $val['date_from'];
				// echo "dateFrom=>".$dateFrom;
				// echo "<br/>";

				
				$arrOfDateFrom = explode('-', $dateFrom);
				//print_r($arrOfDateFrom);
				$yearFrom = $arrOfDateFrom[0];
				$monthFrom = $arrOfDateFrom[1];
				$dayFrom = $arrOfDateFrom[2];
				//echo "<br/>";

				$getDTR = $timesheetDAO->getDTR($x_emp_id,$monthFrom, $dayFrom, $yearFrom);
				$getDtrID = $getDTR[0]['dtr_id'];
				//echo "dtrID = ".$getDtrID; echo "<br/>";

				// $emp_totalhours = "08:00:00";
				// $updateLeaveStatusTimeLog = $leaveApplicationDAO->updateLeaveStatusTimeLog($getDtrID,$x_status_id,$emp_totalhours);
				// echo "<br/>";
				
				$emp_totalhours = "08:00:00";
				$emp_late = "00:00:00";
				$emp_timein = "NULL";
				$emp_timeout = "NULL";
				
				$saveLeaveStatusTimeLog = $leaveApplicationDAO->saveLeaveStatusTimeLog($x_emp_id,$getDtrID,$emp_timein,$emp_timeout,$emp_totalhours,$emp_late,$emp_late,$emp_late,$emp_late,$x_status_id);
				
				$updateLeaveStatusTimeLog = $leaveApplicationDAO->updateLeaveStatusTimeLog($getDtrID,$x_status_id,$emp_totalhours,$emp_timein,$emp_timeout,$emp_late);
				
				

			}

			header("Refresh:0");

		}
		if($x_status_id == 2)
		{
			// $leaveApplicationDAO->updateLeaveApplication($x_leave_application_id, $x_status_id);

			$leave_balance = $val['leave_credit'] - $x_days_to_leave;
			echo "val credit=>".$val['leave_credit'];
			if($leave_balance < 0 || $x_days_to_leave > $val['leave_credit']) {
				?>
				<script>
					swal("Insufficient leave balance");
				</script>
				<?php

			}else
			{
				//checkMe();

			$leaveApplicationDAO->updateLeaveCredit($x_emp_id, $x_leave_type_id,$leave_balance);
			$leaveApplicationDAO->updateLeaveApplication($x_leave_application_id, $x_status_id,$x_leave_type_id);
			$updateLeaveApplication = $leaveApplicationDAO->updateLeaveApplication($x_leave_application_id, $x_status_id,$x_leave_type_id);echo "<br/>";

				if($updateLeaveApplication == true)
				{
					header("Refresh:0");
				}

			}
			
			// echo "Leave Approved";
		}else
		{
			$leaveApplicationDAO->updateLeaveApplication($x_leave_application_id, $x_status_id,$x_leave_type_id);

			$getLeaveCoverage = $leaveApplicationDAO->getLeaveCoverage($x_leave_application_id);

			// echo "<pre>";
			// print_r($getLeaveCoverage);
			// echo "</pre>";
			echo "<br/>";
			foreach($getLeaveCoverage as $key=>$val)
			{
				$dateFrom = $val['date_from'];
				// echo "dateFrom=>".$dateFrom;
				// echo "<br/>";

				
				$arrOfDateFrom = explode('-', $dateFrom);
				//print_r($arrOfDateFrom);
				$yearFrom = $arrOfDateFrom[0];
				$monthFrom = $arrOfDateFrom[1];
				$dayFrom = $arrOfDateFrom[2];
				//echo "<br/>";

				$getDTR = $timesheetDAO->getDTR($x_emp_id,$monthFrom, $dayFrom, $yearFrom);
				$getDtrID = $getDTR[0]['dtr_id'];
				//echo "dtrID = ".$getDtrID; echo "<br/>";

				// $emp_totalhours = "08:00:00";
				// $updateLeaveStatusTimeLog = $leaveApplicationDAO->updateLeaveStatusTimeLog($getDtrID,$x_status_id,$emp_totalhours);
				// echo "<br/>";
				
				$emp_totalhours = "08:00:00";
				$emp_late = "00:00:00";
				$emp_timein = "NULL";
				$emp_timeout = "NULL";
				
				$saveLeaveStatusTimeLog = $leaveApplicationDAO->saveLeaveStatusTimeLog($x_emp_id,$getDtrID,$emp_timein,$emp_timeout,$emp_totalhours,$emp_late,$emp_late,$emp_late,$emp_late,$x_status_id);
				
				$updateLeaveStatusTimeLog = $leaveApplicationDAO->updateLeaveStatusTimeLog($getDtrID,$x_status_id,$emp_totalhours,$emp_timein,$emp_timeout,$emp_late);
				
				
				

			}

			header("Refresh:0");

		}
		
		if($x_status_id == 3)
		{
			//checkMe();
			$leaveApplicationDAO->updateLeaveApplication($x_leave_application_id, $x_status_id,$x_leave_type_id);
			$updateLeaveApplication = $leaveApplicationDAO->updateLeaveApplication($x_leave_application_id, $x_status_id,$x_leave_type_id);

			if($updateLeaveApplication == true)
			{
				header("Refresh:0");
			}

		}else{
			$leaveApplicationDAO->updateLeaveApplication($x_leave_application_id, $x_status_id,$x_leave_type_id);
			//echo "cccccccccccc111111111111<br/>";

			$getLeaveCoverage = $leaveApplicationDAO->getLeaveCoverage($x_leave_application_id);

			// echo "<pre>";
			// print_r($getLeaveCoverage);
			// echo "</pre>";
			echo "<br/>";
			foreach($getLeaveCoverage as $key=>$val)
			{
				$dateFrom = $val['date_from'];
				// echo "dateFrom=>".$dateFrom;
				// echo "<br/>";

				
				$arrOfDateFrom = explode('-', $dateFrom);
				//print_r($arrOfDateFrom);
				$yearFrom = $arrOfDateFrom[0];
				$monthFrom = $arrOfDateFrom[1];
				$dayFrom = $arrOfDateFrom[2];
				//echo "<br/>";

				$getDTR = $timesheetDAO->getDTR($x_emp_id,$monthFrom, $dayFrom, $yearFrom);
				$getDtrID = $getDTR[0]['dtr_id'];
				// echo $getDtrID;

				$emp_totalhours = "08:00:00";
				$emp_late = "00:00:00";
				$emp_timein = "NULL";
				$emp_timeout = "NULL";
				
				$saveLeaveStatusTimeLog = $leaveApplicationDAO->saveLeaveStatusTimeLog($x_emp_id,$getDtrID,$emp_timein,$emp_timeout,$emp_totalhours,$emp_late,$emp_late,$emp_late,$emp_late,$x_status_id);
				
				$updateLeaveStatusTimeLog = $leaveApplicationDAO->updateLeaveStatusTimeLog($getDtrID,$x_status_id,$emp_totalhours,$emp_timein,$emp_timeout,$emp_late);
				// echo "<br/>";
				
				
				// echo "<br/>";echo "<br/>";

				//CARLA
				

			}
			header("Refresh:0");
		}
		
		
	}

	}else
	{
		?>
		<script>
			swal("Unable to update. No leave balance");
		</script>
		<?php
	}
}
?>