<?php

//LATE COMPUTATION
$getDateDiff = $timesheetDAO->getDateDiff($dateToday,$dateTodayLog);

			if($getDateDiff[0]['totalDate'] >= 0 && $emp_timein <> NULL)
			{
				//include "late_computation.php";

				if ($emp_timein >= $schedule_time_in)
                {
                    $getTimeLate = $timesheetDAO->getTimeLate($emp_timein,$schedule_time_in);

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

			}else if($emp_timein <> NULL)
			{
				//include "late_computation.php";
				//include "emp_dtr_totalLate.php";

					if ($emp_timein >= $schedule_time_in)
                    {
                        $getTimeLate = $timesheetDAO->getTimeLate($emp_timein,$schedule_time_in);

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
			}
			else{
				$totalLate = "00:00:00";
                       echo $totalLate;
			}

?>