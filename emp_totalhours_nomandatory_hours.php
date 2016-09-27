<?php

if($emp_timein <> NULL && $emp_timeout <> NULL)
		{
			
			if($emp_timein <= $schedule_time_in )
			{
				if($emp_timeout >= $schedule_time_out)
				{
					$gettotalHoursNoBreak = $timesheetDAO->gettotalHoursNoBreak($schedule_time_out, $schedule_time_in);
					
					$totalHoursNoBreak = $gettotalHoursNoBreak[0]['totalHoursNoBreak'];
					echo $totalHoursNoBreak;
				}else
				{
					$gettotalHoursNoBreak = $timesheetDAO->gettotalHoursNoBreak($emp_timeout, $schedule_time_in);
					
					$totalHoursNoBreak = $gettotalHoursNoBreak[0]['totalHoursNoBreak'];
					echo $totalHoursNoBreak;
				}						
				
			}else if($emp_timein > $schedule_time_in )
			{
				if($emp_timeout > $schedule_time_out)
				{
					$gettotalHoursNoBreak = $timesheetDAO->gettotalHoursNoBreak($schedule_time_out, $emp_timein);
					$totalHoursNoBreak = $gettotalHoursNoBreak[0]['totalHoursNoBreak'];
					echo $totalHoursNoBreak;
					// if($gettotalHoursNoBreak[0]['totalHoursNoBreak'] > "00:00:00")
					// {
						// $totalHoursNoBreak = $gettotalHoursNoBreak[0]['totalHoursNoBreak'];
						// echo $totalHoursNoBreak;
					// }else
					// {
						// $totalHoursNoBreak = "00:00:00";
						// echo $totalHoursNoBreak;
					// }
				}else if($emp_timeout <= $schedule_time_out)
				{
					$gettotalHoursNoBreak = $timesheetDAO->gettotalHoursNoBreak($emp_timeout, $emp_timein);

					$totalHoursNoBreak = $gettotalHoursNoBreak[0]['totalHoursNoBreak'];
					echo $totalHoursNoBreak;
					// if($totalHoursNoBreak <= "00:00:00")
					// {
						// $totalHoursNoBreak = "00:00:00";
						// echo $totalHoursNoBreak;
					// }else
					// {
						// echo $totalHoursNoBreak;
					// }
				}else
				{
					$gettotalHoursNoBreak = $timesheetDAO->gettotalHoursNoBreak($emp_timeout, $emp_timein);
					
					$totalHoursNoBreak = $gettotalHoursNoBreak[0]['totalHoursNoBreak'];
					echo $totalHoursNoBreak;
				}						
				
			}else
			{
				$totalHoursNoBreak = "00:00:00";
				echo $totalHoursNoBreak;
			}
				
		}
		else if($emp_timeout == NULL) {

			//echo $totalHoursNoBreak;
			if($emp_timein >= $schedule_time_in)
			{
				$gettotalHoursNoBreak = $timesheetDAO->gettotalHoursNoBreak($emp_timein, $emp_timeout);
				// $totalHoursNoBreak = $gettotalHoursNoBreak[0]['totalHoursNoBreak'];
					// echo $totalHoursNoBreak;
				
				if($gettotalHoursNoBreak[0]['totalHoursNoBreak'] > "00:00:00") {
					$totalHoursNoBreak = $gettotalHoursNoBreak[0]['totalHoursNoBreak'];
					echo $totalHoursNoBreak;
				}
				
				else if($gettotalHoursNoBreak[0]['totalHoursNoBreak'] <= "00:00:00")
				{
					$totalHoursNoBreak = "00:00:00";
					// $totalHoursNoBreak = $gettotalHoursNoBreak[0]['totalHoursNoBreak'];
					echo $totalHoursNoBreak;
				}
				
				else
				{
					$totalHoursNoBreak = "00:00:00";
					echo $totalHoursNoBreak;
				}
				

			}else if($emp_timein == NULL && $emp_timein < $schedule_time_in)
			{
				//$totalHoursNoBreak = "00:00:00";
				$totalHoursNoBreak = "00:00:00";
				echo $totalHoursNoBreak;
			}else if($emp_timein <> NULL && $emp_timeout <> NULL ){
				$totalHoursNoBreak = "00:00:00";
				echo $totalHoursNoBreak;
			}else{
				$totalHoursNoBreak = "00:00:00";
				echo $totalHoursNoBreak;
			}

		}
		else

		{
			$totalHoursNoBreak = "00:00:00";
		}

?>