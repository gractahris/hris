
<?php 
// include_once "model/DAO.php";
// include_once "model/leaveCreditDAO.php";

$leaveCreditDAO = new leaveCreditDAO();
 ?>

<!-- Start Panel -->
    <div class="col-md-6 col-lg-4">
      <div class="panel panel-default">

        <div class="panel-title">
          LEAVE BALANCES
          <ul class="panel-tools">
           
            <li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
            
          </ul>
        </div>

        <div class="panel-body">
          <table class="table table-bordered">

			<tr>
				<th>Leave Type</th>
				<th>Leave Credit</th>
			</tr>
			
			<tbody>
			<tr>
				<?php
					$getLeaveCreditBal = $leaveCreditDAO->getLeaveCreditBal($_SESSION['emp_id']);
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

        </div>
      </div>
    </div>
