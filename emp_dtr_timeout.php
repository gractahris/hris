<?php
$getTimeLogOfDay = $timesheetAdminDAO->getTimeLogOfDay($emp_id, $valDTRMo['dtr_id']);
if($getTimeLogOfDay[0]["emp_timeout"] <> NULL && $getTimeLogOfDay[0]["emp_timeout"] <> "00:00:00")
			{
				$emp_timeoutVal = date_create($getTimeLogOfDay[0]["emp_timeout"]);
				$emp_timeout = date_format($emp_timeoutVal, "H:i");

				$emp_timeoutcreate_date = date_create($emp_timeout);
				$emp_timeoutnew_format = date_format($emp_timeoutcreate_date, "h:i A");
				echo $emp_timeoutnew_format;



			}else if ($getTimeLogOfDay[0]["emp_timeout"] == NULL)
			{
				$emp_timeoutVal = "00:00:00";
				$emp_timeout = date_format($emp_timeoutVal,"H:i");
				echo $emp_timeout;
			}
			else
			{
				//$emp_timeoutVal = date_create($getTimeLogOfDay[0]["emp_timeout"]);

				$emp_timeoutVal = "00:00:00";
				$emp_timeout = date_format($emp_timeoutVal,"H:i");
				echo $emp_timeout;
			}

?>