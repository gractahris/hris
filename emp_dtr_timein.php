<?php
$getTimeLogOfDay = $timesheetAdminDAO->getTimeLogOfDay($emp_id, $valDTRMo['dtr_id']);
if($getTimeLogOfDay[0]["emp_timein"] <> NULL )
			{
				/*$emp_timein =  $getTimeLogOfDay[0]["emp_timein"];*/

				$emp_timeVal = date_create($getTimeLogOfDay[0]["emp_timein"]);
				$emp_timein = date_format($emp_timeVal,"H:i");
				//echo $emp_timein;


				$emp_create_date = date_create($emp_timein);
				$emp_new_format = date_format($emp_create_date,"h:i A");
				echo $emp_new_format;

			}else if ($getTimeLogOfDay[0]["emp_timein"] == NULL)
			{
				$emp_timein = "00:00:00";
			}else
			{
				echo $noLogsFound;
				$emp_timein = "00:00:00";
			}
			?>