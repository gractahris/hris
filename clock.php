<?php
foreach($monthArr as $key => $val)
{
	$counter = $key + 1;
	if($clock->getMonth() == $val)
	{
		// echo $counter."=>".$val;
		if($counter < 10)
		{
			$month = "0".$counter;
			
			$getDTR = $timesheetDAO->getDTR($_SESSION['emp_id'],$month,$day,$clock->getYear());
			if($getDTR == true)
			{
				foreach($getDTR as  $keyDTR => $valDTR)
				{
					$getTime = $timesheetDAO->getTime();
					
					echo "<form method = 'GET'>";
					echo "<input type = 'hidden' id='txtTimeIn' name='txtTimeIn' value = '".$getTime[0]["time"]."'/ >";
					
					echo "<input type = 'hidden' id='txtTimeOut' name='txtTimeOut' value = '".$getTime[0]["time"]."'/ >";
										
					$emp_id = $_SESSION['emp_id'];
					$emp_timein = $_GET["txtTimeIn"];
					$emp_timeout = 'NULL';
					$emp_totalhours = "0";
					$emp_late = "0";
					$emp_excesstime = "0";
					$emp_undertime = "0";
					$dtr_id = $valDTR['dtr_id'];
					
					// echo "dtr_id=>".$dtr_id;
					
					?>
					
                    
                 
					<input class ="btn btn-primary" type="submit" id ="timeIN" name="timeIn" value="Time In" />
					
					
					<input class ="btn btn-primary" type="submit" id ="timeOut" name="timeOut" value="Time Out" />
					 
					</form>
					<?php
					
					if($_GET["timeIn"] == true)
					{
						if($_GET["txtTimeIn"] <> NULL)
						{
							if($_GET["txtTimeIn"] <> "")
							{
								// echo "dtr_id=>".$dtr_id;
								$getTimeLogOfDay = $timesheetDAO->getTimeLogOfDay($_SESSION["emp_id"],$dtr_id);
								
								// print_r()
								if($getTimeLogOfDay[0]['emp_timein'] == "00:00:00")
								{
									$saveTimeIN = $timesheetDAO->saveTimeIN($emp_id,$emp_timein,$emp_timeout, $emp_totalhours,$emp_late,$emp_excesstime,$emp_undertime,$dtr_id);
									
								}
								else if($getTimeLogOfDay[0]['dtr_id'] == NULL)
								{
									$saveTimeIN = $timesheetDAO->saveTimeIN($emp_id,$emp_timein,$emp_timeout, $emp_totalhours,$emp_late,$emp_excesstime,$emp_undertime,$dtr_id);
									
								?>
									<script>
									swal("You are logged in");
									</script>
								<?php
								}
								else
								{
									
									?>
									<script>
									swal("You have timed in already for this day !");
									</script>
									
									<?php
								}
								
							}
							
						}
					}
					
					if($_GET["timeOut"] == true)
					{
						if($_GET["txtTimeOut"] <> NULL)
						{
							if($_GET["txtTimeOut"] <> "")
							{
								$getTimeLogOfDay = $timesheetDAO->getTimeLogOfDay($_SESSION["emp_id"],$dtr_id);
								
								if($getTimeLogOfDay[0]['emp_timeout'] == "00:00:00")
								{
									$updateTimeOut = $timesheetDAO->updateTimeOut($emp_id,$_GET["txtTimeOut"],$dtr_id);
								
								?>
									<script>
									swal("You are logged out");
									</script>
								<?php
								}
								else if($getTimeLogOfDay[0]['emp_timein'] == NULL)
								{			
								
								?>
									<script>
									swal("You havent TIMED IN yet !");
									</script>
								<?php
								}
								else
								{
									//echo "You have timed out already for this day";
									
									?>
									<script>
									swal("You have timed out already for this day !");
									</script>
									
									<?php
								}
							}
							
						}
					}
						
					
				}
				
			}else{
				
				echo "NO DTR";
			}
		}
		
	}
	
	// else
	// {
		// $month = $counter;
	// }
	
	}
	?>