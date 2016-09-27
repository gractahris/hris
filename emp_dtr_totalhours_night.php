<?php
$timesheetDAO = new timesheetDAO();
$dtr_id = $valDTRMo['dtr_id'];
$dtrIdInEmpTimelog = $timesheetDAO->dtrIdInEmpTimelog($dtr_id);
$dtrIdInEmpTimelogTotalHours = $dtrIdInEmpTimelog[0]["emp_totalhours"];
$dtrIdInEmpTimelogLeaveStatus = $dtrIdInEmpTimelog[0]["emp_leave_status"];

if($dtrIdInEmpTimelogLeaveStatus <> NULL)
{
	echo $dtrIdInEmpTimelogTotalHours;
}
else
{
if($emp_timein <> NULL && $emp_timeout <> NULL)
{
	$getTotalHoursNight = $timesheetDAO->getTotalHoursNight($totalHoursNoBreak);
	$totalHours = $getTotalHoursNight[0]['totalHours'];
	//echo $totalHours;

	if($is_holiday == 1)
	{
		 //$getAllHours = $timesheetDAO->getAllHours($totalHours,$totalHours);
		//$getAllHours = $timesheetDAO->getAllHours("00:00:00",$totalHours);
		//$totalHours += $totalHours;
		 //$totalHours = $getAllHours[0]['totalHours'];
		echo $totalHours;
		
	}else
	{
		if($totalHours <= "00:00:00")
		{
			$totalHours = "00:00:00";
		}else
		{
			$totalHours = $totalHours;
		}
		echo $totalHours;
	}
	//"isHoliday=".$is_holiday;
}else
{
	$totalHours = "00:00:00";
	//echo "isHoliday=";
	echo $totalHours;
}

}// end else dtrIdInEmpTimelogLeaveStatus 
?>