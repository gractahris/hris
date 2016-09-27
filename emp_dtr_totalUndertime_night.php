<?php

if ($emp_timeout <= $schedule_time_out && $emp_timeout <> NULL)
				{
					$getTimeUndertime = $timesheetDAO->getTimeUndertime($schedule_time_out,$emp_timeout);

					if($emp_timeout <> "00:00:00")
					{
						$totalUnderTime = $getTimeUndertime[0]['totalUnderTime'];
						echo $totalUnderTime;

					}else if ($emp_timeout == NULL)
					{
						$totalUnderTime = "00:00:00";
						echo $totalUnderTime;
					}else{
						$totalUnderTime = "00:00:00";
						echo $totalUnderTime;

					}

				}
				else
				{
					$totalUnderTime = "00:00:00";
					echo $totalUnderTime;
				}

?>