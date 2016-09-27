<?php

//LATE COMPUTATION
if ($emp_timein >= $schedule_time_in)
{
	$getTimeLate = $timesheetAdminDAO->getTimeLate($emp_timein,$schedule_time_in);

	if($emp_timein <> NULL)
	{
		$totalLate = $getTimeLate[0]['totalLate'];
		echo $totalLate;
	}else
	{
		$totalLate = "00:00:00";
		echo $totalLate;
	}

}
else
{
	$totalLate = "00:00:00";
	echo $totalLate;
}

?>