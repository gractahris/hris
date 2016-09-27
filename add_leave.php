<?php
	// echo "x_leave_type_id => ".$_POST["x_leave_type_id"];
	// echo "<br/>";
	// echo "x_sickness => ".$_POST["x_sickness"];echo "<br/>";
	// echo "x_place_to_visit => ".$_POST["x_place_to_visit"];echo "<br/>";
	// echo "x_days_to_leave => ".$_POST["x_days_to_leave"];echo "<br/>";
	// echo "x_status_id => ".$_POST["x_status_id"];echo "<br/>";
	
	$leaveApplicationDAO = new leaveApplicationDAO();
	$leaveCreditDAO = new leaveCreditDAO();
	
	$x_leave_type_id =$_POST["x_leave_type_id"];
	$x_sickness = $_POST["x_sickness"];
	$x_place_to_visit =$_POST["x_place_to_visit"];
	$x_days_to_leave =$_POST["x_days_to_leave"];
	$x_status_id =$_POST["x_status_id"];
	if($_POST["x_leave_type_id"] <> "")
	{
		
		$getLeaveCreditByEmp = $leaveCreditDAO->getLeaveCreditByEmp($_SESSION['emp_id'],$x_leave_type_id);
	
	if($getLeaveCreditByEmp == NULL)
	{
	?>
		<div class="kode-alert kode-alert-icon alert11-light">
		<i class="fa fa-warning"></i>
		<a href="#" class="closed">&times;</a>
		No Leave Credits
		</div>
	<?php
		
	}else if($getLeaveCreditByEmp == "")
	{
		echo ""; 
		
	}else
	{
		foreach($getLeaveCreditByEmp as $key => $val)
		{
			if($val['leave_credit'] == NULL)
			{
				
			?>
				<div class="kode-alert kode-alert-icon alert1-light">
				<i class="fa fa-warning"></i>
				<a href="#" class="closed">&times;</a>
				No Leave Credits
				</div>
				
			<?php
			}else if($val['leave_credit'] == "0"){
			?>	
				<div class="kode-alert kode-alert-icon alert6-light">
				<i class="fa fa-warning"></i>
				<a href="#" class="closed">&times;</a>
				You have no Leave Credits left
				</div>
			<?php
			}else{
				
				// echo "Your Leave Credits are:".$val['leave_credit'];
				if($val['leave_credit'] < $x_days_to_leave)
				{
					?>
				  <div class="kode-alert kode-alert-icon alert5-light">
					<i class="fa fa-warning"></i>
					<a href="#" class="closed">&times;</a>
					Insufficient Leave Credit
				  </div>
				<?php

				}else{
					$getMaxLeaveApplicationID = $leaveApplicationDAO->getMaxLeaveApplicationID();	
					$maxLeaveApplicationID = $getMaxLeaveApplicationID[0]['maxLeaveApplicationID'];
					echo $maxLeaveApplicationID;

					$leaveApplicationDAO->saveLeave($maxLeaveApplicationID,$_SESSION['emp_id'],$x_leave_type_id,$x_sickness,$x_place_to_visit,$x_days_to_leave,$x_status_id);
					$leave_balance = $val['leave_credit'] - $x_days_to_leave;  
					header("Refresh:0");	
	
					//print_r($getMaxLeaveApplicationID);
					$newURL = "tbl_leavecoveragelist.php?showmaster=tbl_employee_leaveapplication&leave_application_id=".$maxLeaveApplicationID;
					//echo $newURL;
					// header('Location: tbl_leavecoveragelist.php?showmaster=tbl_employee_leaveapplication&leave_application_id=$maxLeaveApplicationID');
					header('Location: '.$newURL);

				?>
					<div class="kode-alert kode-alert-icon alert3-light">
					<i class="fa fa-check"></i>
					<a href="#" class="closed">&times;</a>
					Leave Applied
				  </div>
				<?php
				}
			}
			
		}
	
	}
	
	}
?>