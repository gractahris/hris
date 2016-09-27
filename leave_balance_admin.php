
<?php 
// include_once "model/DAO.php";
// include_once "model/leaveCreditDAO.php";

$leaveCreditDAO = new leaveCreditDAO();
 ?>

          <table class="table table-bordered">

			<tr>
				<th>Leave Type</th>
				<th>Leave Credit</th>
			</tr>
			
			<tbody>
			<tr>
				<?php
					// $getLeaveCreditBal = $leaveCreditDAO->getLeaveCreditBal($_SESSION['emp_id']);
					$getLeaveCreditBal = $leaveCreditDAO->getLeaveCreditBal($tbl_employee_leaveapplication->emp_id->CurrentValue);
					// print_r($getLeaveCreditBal);
					
					foreach($getLeaveCreditBal as $key=> $val)
					{
						$getLeaveTypeByID = $leaveCreditDAO->getLeaveTypeByID($val['leave_type_id']);
						
						foreach($getLeaveTypeByID as $typeKey => $typeVal)
						{
							echo "<td>";
							echo $typeVal['leave_type_title'];
							echo "</td>";
							
						}
						
						echo "<td>";
						echo "<center>";
						echo $val['leave_credit'];
						echo "</center>";
						echo "</td>";
						echo "</tr>";
					}
				?>
			</tbody>
          </table>
