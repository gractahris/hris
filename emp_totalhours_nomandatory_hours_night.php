<?php

if($emp_timein <> NULL && $emp_timeout <> NULL)
		{
			//timeIn Less Schedule
			if($emp_timein <= $schedule_time_in)
			{	
				$gettotalHoursNoBreakNight = $timesheetDAO->gettotalHoursNoBreakNight($schedule_time_in);
				
				if($emp_timeout < $schedule_time_out)
				{
				
					$gettotalHoursNoBreakAMNight = $timesheetDAO->gettotalHoursNoBreakAMNight($emp_timeout);
				
				}else
				{
					$gettotalHoursNoBreakAMNight = $timesheetDAO->gettotalHoursNoBreakAMNight($schedule_time_out);
				}
				
				$totalHoursNoBreakPMNight = $gettotalHoursNoBreakNight[0]['totalHoursNoBreak'];
				$totalHoursNoBreakAMNight = $gettotalHoursNoBreakAMNight[0]['totalHoursNoBreak'];

					
				$getTotalTimeNight = $timesheetDAO->getTotalTimeNight($totalHoursNoBreakPMNight,$totalHoursNoBreakAMNight);
				
				
				$totalHoursNoBreak = $getTotalTimeNight[0]['totalHoursNoBreak'];
				echo $totalHoursNoBreak;
					
			}else if($emp_timein >= $schedule_time_in)
			{	
				$gettotalHoursNoBreakNight = $timesheetDAO->gettotalHoursNoBreakNight($emp_timein);
				$totalHoursNoBreakPMNight = $gettotalHoursNoBreakNight[0]['totalHoursNoBreak'];
				
				if($emp_timeout < $schedule_time_out)
				{
				
				
				$gettotalHoursNoBreakAMNight = $timesheetDAO->gettotalHoursNoBreakAMNight($emp_timeout);
				
				}
				else
				{
					$gettotalHoursNoBreakAMNight = $timesheetDAO->gettotalHoursNoBreakAMNight($schedule_time_out);
				}
				
				
				$totalHoursNoBreakAMNight = $gettotalHoursNoBreakAMNight[0]['totalHoursNoBreak'];
					// echo $totalHoursNoBreakPMNight;
					// echo "<br/>";
					// echo $totalHoursNoBreakAMNight;
					// echo "<br/>";
					
				$getTotalTimeNight = $timesheetDAO->getTotalTimeNight($totalHoursNoBreakPMNight,$totalHoursNoBreakAMNight);
				
				
				$totalHoursNoBreak = $getTotalTimeNight[0]['totalHoursNoBreak'];
				echo $totalHoursNoBreak;
					
			}
		}else
		{
			$totalHoursNoBreak = "00:00:00";
			echo $totalHoursNoBreak;
		}

?>