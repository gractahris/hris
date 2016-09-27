<?php
$dtr_id = $valDTRMo['dtr_id'];
//echo $dtr_id;
$dtrIdInEmpTimelog = $timesheetDAO->dtrIdInEmpTimelog($dtr_id);
$dtrIdInEmpTimelogTotalHours = $dtrIdInEmpTimelog[0]["emp_totalhours"];
$dtrIdInEmpTimelogLeaveStatus = $dtrIdInEmpTimelog[0]["emp_leave_status"];
// echo "<pre>";
//print_r($dtrIdInEmpTimelog);
// echo "</pre>";

if($dtrIdInEmpTimelogLeaveStatus <> NULL)
{
	echo $dtrIdInEmpTimelogTotalHours;
}
else
{



if($emp_timein <> NULL && $emp_timeout <> NULL)
{

	if($emp_timein <= $schedule_time_in )
	{
		if($emp_timeout >= $schedule_time_out)
		{
			$getTotalHours = $timesheetAdminDAO->getTotalHours($schedule_time_out, $schedule_time_in);

			$totalHours = $getTotalHours[0]['totalHours'];
			echo $totalHours;
		}else
		{
			$getTotalHours = $timesheetAdminDAO->getTotalHours($emp_timeout, $schedule_time_in);
			if($is_holiday == 0)
			{
				$totalHours = $getTotalHours[0]['totalHours'];
				echo $totalHours;
			}else
			{
				$totalHours = $getTotalHours[0]['totalHours'];
				$totalHours = $totalHours * "02:00:00" ;
				echo $totalHours.":00:00";
			}
		}

	}else if($emp_timein > $schedule_time_in )
	{
		if($emp_timeout > $schedule_time_out)
		{
			$getTotalHours = $timesheetAdminDAO->getTotalHours($schedule_time_out, $emp_timein);

			if($getTotalHours[0]['totalHours'] > "00:00:00")
			{
				$totalHours = $getTotalHours[0]['totalHours'];
				echo $totalHours;
			}else
			{
				$totalHours = "00:00:00";
				echo $totalHours;
			}
		}else if($emp_timeout <= $schedule_time_out)
		{
			$getTotalHours = $timesheetAdminDAO->getTotalHours($emp_timeout, $emp_timein);

			$totalHours = $getTotalHours[0]['totalHours'];

			if($totalHours <= "00:00:00")
			{
				$totalHours = "00:00:00";
				echo $totalHours;
			}else
			{
				echo $totalHours;
			}
		}else
		{
			$getTotalHours = $timesheetAdminDAO->getTotalHours($emp_timeout, $emp_timein);

			$totalHours = $getTotalHours[0]['totalHours'];
			echo $totalHours;
		}

	}else
	{
		$totalHours = "00:00:00";
		echo $totalHours;
	}

}
else if($emp_timeout == NULL) {

	//echo $totalHours;
	if($emp_timein >= $schedule_time_in)
	{
		$getTotalHours = $timesheetAdminDAO->getTotalHours($emp_timein, $emp_timeout);

		if($getTotalHours[0]['totalHours'] > "00:00:00") {
			$totalHours = $getTotalHours[0]['totalHours'];
			echo $totalHours;
		}else if($getTotalHours[0]['totalHours'] <= "00:00:00")
		{
			$totalHours = "00:00:00";
			echo $totalHours;
		}else
		{
			$totalHours = "00:00:00";
			echo $totalHours;
		}

	}else if($emp_timein == NULL && $emp_timein < $schedule_time_in)
	{
		//$totalHours = "00:00:00";
		$totalHours = "00:00:00";
		echo $totalHours;
	}else if($emp_timein <> NULL && $emp_timeout <> NULL ){
		$totalHours = "00:00:00";
		echo $totalHours;
	}else if($is_holiday == 1 && $emp_timein <> NULL)
	{
		$totalHours = "08:00:00";
		echo $totalHours;
	}
	else{
		$totalHours = "00:00:00";
		echo $totalHours;
	}

}

else

{

	$totalHours = "00:00:00";

}


}// end else dtrIdInEmpTimelogLeaveStatus 




?>