<?php
$undertimeMsg = "";
$lateMsg = "";
$absentMsg = "";
$otMsg = "";
$dateNow = date("Y-m-d");
foreach ($getDateDiff as $keyDate => $valDate)
		{
			
				$getLeaveCoverage = $timesheetDAO->getLeaveCoverage($emp_id,$dateTodayLog);
			// echo "<pre>";
			// //print_r($getLeaveCoverage);
			// echo "</pre>";
			$leavemsg1 = "";
			if($getLeaveCoverage == true)
			{


				foreach($getLeaveCoverage as $keyLC => $valLC)
				{
								
					// echo "Year=>".$valLC['dateToYear'];
					// echo "month=>".$valLC['dateToMonth'];
					// echo "day=>".$valLC['dateToDay'];
					// echo "emp_id=>".$emp_id;
					// echo "<br/>";
										
					$getDTRForLeave = $timesheetDAO->getDTR($emp_id,$valLC['dateToMonth'],$valLC['dateToDay'],$valLC['dateToYear']);
					// echo "<pre>";
					// print_r($getDTRForLeave);	
					// echo "</pre>";

					$getDtrID = $getDTRForLeave[0]["dtr_id"];
									// /	echo $getDtrID;

					$dtrIdInEmpTimelog = $timesheetDAO->dtrIdInEmpTimelog($getDtrID);
										$getLeaveStatus = $dtrIdInEmpTimelog[0]['emp_leave_status'];
					// echo "<pre>";
					// print_r($getDTRForLeave);	
					// echo "</pre>";

					if($getLeaveStatus == 1)
					{
						$leavemsg1 = "Pending Leave";

					}else if($getLeaveStatus == 2)
					{
						$leavemsg1 = "Approve Leave";

					}else if($getLeaveStatus == 3)
					{
						$leavemsg1 = "Disapprove Leave";

					}else
					{
						//$absentMsg = "Absent";
					}
				}

				echo $leavemsg1;
			}
			else
			{
				//echo "aaaaaaa";
				$absentMsg = "Absent";
			}


				if($valDate['totalDate'] >= 0)
				{
					
						if($totalUnderTime > "00:00:00" && $getLeaveCoverage == false)
						{
							$undertimeMsg = "Undertime, ";
							echo $undertimeMsg;
						}

						if($totalLate > "00:00:00" && $getLeaveCoverage == false)
						{
							$lateMsg = "Late, ";
							echo $lateMsg;
						}
						
						if($excessTime > "01:00:00" && $getLeaveCoverage == false)
						{
							$otMsg = "Overtime, ";
							echo $otMsg;
						}
						
						/*if($is_holiday == 0 && $emp_timein == "00:00:00" && $emp_timeout == NULL)
						{
							$absentMsg = "Absent";
							echo $absentMsg;
						}
						
						if($emp_timein == "00:00:00" && $emp_timeout == NULL && $is_holiday == 1)
						{
							$absentMsg = "Holiday";
							echo $absentMsg;
						}*/
						$getDtrDate = $valDTRMo['year'] . "-" . $valDTRMo['month'] . "-" . $valDTRMo['day'];

						// if($valDTRMo['day'] >= 10)
						// {
						// 	$getDtrDate = $valDTRMo['year'] . "-" . $valDTRMo['month'] . "-" . $valDTRMo['day'];
						// 	// echo $getDtrDate;
						// }else
						// {
						// 	$getDtrDate = $valDTRMo['year'] . "-" . $valDTRMo['month'] . "-0" . $valDTRMo['day'];
						// 	// echo $getDtrDate;

						// }
						
						$getLeaveCoverage = $timesheetAdminDAO->getLeaveCoverage($emp_id,$getDtrDate);
						
						
						if($emp_timein == "00:00:00" && $emp_timeout == NULL && $is_holiday == 1)
						{
									$absentMsg = "Holiday";
									echo $absentMsg;
						}
						
						if($emp_timein == "00:00:00" && $emp_timeout == NULL && $dateNow <> $getDtrDate)
						{
							if($is_holiday == 1)
							{
								$absentMsg = "";
								echo $absentMsg;

							}else
							{
								if($dateFormat == "Sunday" || $dateFormat == "Saturday")
								{
									$absentMsg = "";
								}else
								{
									//$absentMsg = "Absent";

									if($getLeaveCoverage == true)
							{


							foreach($getLeaveCoverage as $keyLC => $valLC)
							{
								
								// echo "Year=>".$valLC['dateToYear'];
								// echo "month=>".$valLC['dateToMonth'];
								// echo "day=>".$valLC['dateToDay'];
								// echo "emp_id=>".$emp_id;
								
								$getDTRForLeave = $timesheetDAO->getDTR($emp_id,$valLC['dateToMonth'],$valLC['dateToDay'],$valLC['dateToYear']);
								
								$getDtrID = $getDTRForLeave[0]["dtr_id"];
								//echo $getDtrID;

								$dtrIdInEmpTimelog = $timesheetDAO->dtrIdInEmpTimelog($getDtrID);
								$getLeaveStatus = $dtrIdInEmpTimelog[0]['emp_leave_status'];

								if($getLeaveStatus == 1)
								{
									//$leavemsg = "Pending Leave";

								}else if($getLeaveStatus == 2)
								{
									//$leavemsg = "Approve Leave";

								}else if($getLeaveStatus == 3)
								{
									//$leavemsg = "Disapprove Leave";

								}else
								{
									$absentMsg = "Absent";
								}
							}
							}
							else
							{
								$absentMsg = "Absent";
							}


								}
								
								echo $absentMsg;
							}
						}
				

						else
						{

						
						/*if($valDTRMo['day'] >= 10)
						{
							$getDtrDate = $valDTRMo['year'] . "-" . $valDTRMo['month'] . "-" . $valDTRMo['day'];
						}else
						{
							$getDtrDate = $valDTRMo['year'] . "-" . $valDTRMo['month'] . "-0" . $valDTRMo['day'];
							
						}
					*/

						
						// print_r($getLeaveCoverage);
						foreach($getLeaveCoverage as $keyLC => $valLC)
						{
							// echo $valLC['date_from'];
							// echo $valLC['leave_application_id'];
							$getLeave = $timesheetAdminDAO->getLeave($valLC['leave_application_id']);
							
							$getDTRForLeave = $timesheetDAO->getDTR($emp_id,$valLC['dateToMonth'],$valLC['dateToDay'],$valLC['dateToYear']);
						
							$getDtrID = $getDTRForLeave[0]["dtr_id"];
							
							$saveTimeIN = $timesheetDAO->saveTimeIN($emp_id,$schedule_time_in,$schedule_time_out,"08:00:00","00:00:00","00:00:00","00:00:00",$getDtrID);
							
							foreach($getLeave as $keyLeave => $valLeave)
							{
								// echo $valLeave['status_id'];
								$leaveStatus = $valLeave['status_id'];
								$leavemsg = "";
								if($leaveStatus == 2)
								{
									$leavemsg = "Leave Approved!";
									//echo $leavemsg;
									
								}else if($leaveStatus == 1)
								{
									$leavemsg = "Pending Leave";
									//echo $leavemsg;
									
								}else if($leaveStatus == 3)
								{
									$leavemsg = "Leave Disapproved";
									//echo $leavemsg;
								}else if($emp_timein == "00:00:00" && $emp_timeout == NULL && $dateNow == $getDtrDate)
								{
									
									$absentMsg = "No Time Log";
									echo $absentMsg;
								}
								
								else
								{
									echo "";
								}
							}
						
					
					}
					
					
					}
					// if()

					//$autoUpdateLogs = $timesheetAdminDAO->autoUpdateLogs($emp_id,$valDTRMo['dtr_id'], $totalHours, $totalLate, $excessTime,$totalUnderTime);
				}
			
			
		}

?>