<?php

if($emp_timeout > $schedule_time_out)
			{
				$getTimeExcessTime = $timesheetDAO->getTimeExcessTime($schedule_time_out, $emp_timeout);
				$excessTime = $getTimeExcessTime[0]['excessTime'];
				echo $excessTime;
			}
			else if($emp_timeout == NULL)
			{
				$excessTime = "00:00:00";
				echo $excessTime;
			}else if($is_holiday == 1)
			{
				//$excessTime = "00:00:00";
				$excessTime = $totalHours;
				echo $excessTime;
			}
			else
			{
				$excessTime = "00:00:00";
				echo $excessTime;
			}

?>