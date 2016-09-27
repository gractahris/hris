<?php

// leave_application_id
// emp_id
// leave_type_id
// sickness
// place_to_visit
// days_to_leave
// status_id

?>
<?php if ($tbl_employee_leaveapplication->Visible) { ?>
<table cellspacing="0" id="t_tbl_employee_leaveapplication" class="ewGrid"><tr><td>
<table id="tbl_tbl_employee_leaveapplicationmaster" class="table table-bordered table-striped">
	<tbody>
<?php if ($tbl_employee_leaveapplication->leave_application_id->Visible) { // leave_application_id ?>
		<tr id="r_leave_application_id">
			<td><?php echo $tbl_employee_leaveapplication->leave_application_id->FldCaption() ?></td>
			<td><?php echo $tbl_employee_leaveapplication->emp_id->FldCaption() ?></td>
			<td><?php echo $tbl_employee_leaveapplication->leave_type_id->FldCaption() ?></td>
			<td><?php echo $tbl_employee_leaveapplication->sickness->FldCaption() ?></td>
			<td><?php echo $tbl_employee_leaveapplication->place_to_visit->FldCaption() ?></td>
			<td><?php echo $tbl_employee_leaveapplication->days_to_leave->FldCaption() ?></td>
			<td><?php echo $tbl_employee_leaveapplication->status_id->FldCaption() ?></td>
		</tr>
		<tr>
			<td<?php echo $tbl_employee_leaveapplication->leave_application_id->CellAttributes() ?>>
			<span id="el_tbl_employee_leaveapplication_leave_application_id" class="control-group">
			<span<?php echo $tbl_employee_leaveapplication->leave_application_id->ViewAttributes() ?>>
			<?php echo $tbl_employee_leaveapplication->leave_application_id->ListViewValue() ?></span>
			</span>
			</td>
			
			<td<?php echo $tbl_employee_leaveapplication->emp_id->CellAttributes() ?>>
			<span id="el_tbl_employee_leaveapplication_emp_id" class="control-group">
			<span<?php echo $tbl_employee_leaveapplication->emp_id->ViewAttributes() ?>>
			<?php echo $tbl_employee_leaveapplication->emp_id->ListViewValue() ?></span>
			</span>
			</td>
			
			<td<?php echo $tbl_employee_leaveapplication->leave_type_id->CellAttributes() ?>>
			<span id="el_tbl_employee_leaveapplication_leave_type_id" class="control-group">
			<span<?php echo $tbl_employee_leaveapplication->leave_type_id->ViewAttributes() ?>>
			<?php echo $tbl_employee_leaveapplication->leave_type_id->ListViewValue() ?></span>
			</span>
			</td>
			
			<td<?php echo $tbl_employee_leaveapplication->sickness->CellAttributes() ?>>
			<span id="el_tbl_employee_leaveapplication_sickness" class="control-group">
			<span<?php echo $tbl_employee_leaveapplication->sickness->ViewAttributes() ?>>
			<?php echo $tbl_employee_leaveapplication->sickness->ListViewValue() ?></span>
			</span>
			</td>
			
			<td<?php echo $tbl_employee_leaveapplication->place_to_visit->CellAttributes() ?>>
			<span id="el_tbl_employee_leaveapplication_place_to_visit" class="control-group">
			<span<?php echo $tbl_employee_leaveapplication->place_to_visit->ViewAttributes() ?>>
			<?php echo $tbl_employee_leaveapplication->place_to_visit->ListViewValue() ?></span>
			</span>
			</td>
			
			<td<?php echo $tbl_employee_leaveapplication->days_to_leave->CellAttributes() ?>>
			<span id="el_tbl_employee_leaveapplication_days_to_leave" class="control-group">
			<span<?php echo $tbl_employee_leaveapplication->days_to_leave->ViewAttributes() ?>>
			<?php echo $tbl_employee_leaveapplication->days_to_leave->ListViewValue() ?></span>
			</span>
			</td>
			
			<td<?php echo $tbl_employee_leaveapplication->status_id->CellAttributes() ?>>
			<span id="el_tbl_employee_leaveapplication_status_id" class="control-group">
			<span<?php echo $tbl_employee_leaveapplication->status_id->ViewAttributes() ?>>
			<?php echo $tbl_employee_leaveapplication->status_id->ListViewValue() ?></span>
			</span>
			</td>

		</tr>
					
<?php } ?>
<?php if ($tbl_employee_leaveapplication->emp_id->Visible) { // emp_id ?>
		<tr id="r_emp_id">
			
			
		</tr>
<?php } ?>
<?php if ($tbl_employee_leaveapplication->leave_type_id->Visible) { // leave_type_id ?>
		<tr id="r_leave_type_id">
			
			
		</tr>
<?php } ?>
<?php if ($tbl_employee_leaveapplication->sickness->Visible) { // sickness ?>
		<tr id="r_sickness">
			
			
		</tr>
<?php } ?>
<?php if ($tbl_employee_leaveapplication->place_to_visit->Visible) { // place_to_visit ?>
		<tr id="r_place_to_visit">
			
			
		</tr>
<?php } ?>
<?php if ($tbl_employee_leaveapplication->days_to_leave->Visible) { // days_to_leave ?>
		<tr id="r_days_to_leave">
			
			
		</tr>
<?php } ?>
<?php if ($tbl_employee_leaveapplication->status_id->Visible) { // status_id ?>
		<tr id="r_status_id">
			
			
		</tr>
<?php } ?>
	</tbody>
</table>
</td></tr></table>
<?php } ?>
