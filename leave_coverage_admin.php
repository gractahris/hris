
<?php 
// include_once "model/DAO.php";
// include_once "model/leaveCreditDAO.php";

$leaveCreditDAO = new leaveCreditDAO();
 ?>

          <table class="table table-bordered">

			<tr>
				<th>Date From</th>
				<th>Date To</th>
			</tr>
			
			<tbody>
			<tr>
				<?php
					// $getLeaveCreditBal = $leaveCreditDAO->getLeaveCreditBal($_SESSION['emp_id']);
					$getLeaveCreditBal = $leaveCreditDAO->getLeaveCreditBal($tbl_employee_leaveapplication->emp_id->CurrentValue);
					$getLeaveCoverage = $leaveCreditDAO->getLeaveCoverage($tbl_employee_leaveapplication->leave_application_id->CurrentValue);
					
					// print_r($getLeaveCreditBal);
					
					// foreach($getLeaveCreditBal as $key=> $val)
					foreach($getLeaveCoverage as $key=> $val)
					{
											
						// echo "<td>";
						// echo "<center>";
						// echo $val['leave_application_id'];
						// echo "</center>";
						// echo "</td>";
												
						echo "<td>";
						echo "<center>";
						echo $val['date_from'];
						echo "</center>";
						echo "</td>";
						
						echo "<td>";
						echo "<center>";
						echo $val['date_to'];
						echo "</center>";
						echo "</td>";
						echo "</tr>";
					}
				?>
			</tbody>
          </table>
