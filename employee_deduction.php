<?php

$employeeDeductionDAO = new employeeDeductionDAO();

$getDeductionByEmp = $employeeDeductionDAO->getDeductionByEmp($_SESSION['emp_id']);

// print_r($getDeductionByEmp);

?>
<!-- Start Panel -->
    <div class="col-md-6 col-lg-4">
      <div class="panel panel-default">

        <div class="panel-title">
          DEDUCTIONS
        </div>
        
        <div class="panel-body">
         
 
<table class="table table-hover">
	<tr>
		<td>Deduction/Contribution Type</td>
		<td>Amount</td>
	</tr>
	
	<tr>
	<?php
		foreach($getDeductionByEmp as $key => $val)
		{
			$getDeductionType = $employeeDeductionDAO->getDeductionType($val["deduction_id"]);
			
			echo "<td>";
			foreach($getDeductionType as $keyDeduction => $valDeduction)
			{
				echo $valDeduction["deduction_title"];
				
			}
			echo "</td>";
			
			
			echo "<td>";
			echo $val["deduction_amount"];
			echo "</td>";
			
			echo "</tr>";
			
		}
	?>
	
	
</table>
       </div>

      </div>
    </div>
    <!-- End Panel -->