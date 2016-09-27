<?php

// emp_id
// empFirstName
// empMiddleName
// empLastName
// empExtensionName
// sex_id
// schedule_id
// salary_id
// tax_category_id
// date_hired

?>
<?php if ($tbl_employee->Visible) { ?>
<table cellspacing="0" id="t_tbl_employee" class="ewGrid"><tr><td>
<table id="tbl_tbl_employeemaster" class="table table-bordered table-striped">
	<tbody>
<?php if ($tbl_employee->emp_id->Visible) { // emp_id ?>
		<tr id="r_emp_id">
			<td><?php echo $tbl_employee->emp_id->FldCaption() ?></td>
			<td<?php echo $tbl_employee->emp_id->CellAttributes() ?>>
<span id="el_tbl_employee_emp_id" class="control-group">
<span<?php echo $tbl_employee->emp_id->ViewAttributes() ?>>
<?php echo $tbl_employee->emp_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tbl_employee->empFirstName->Visible) { // empFirstName ?>
		<tr id="r_empFirstName">
			<td><?php echo $tbl_employee->empFirstName->FldCaption() ?></td>
			<td<?php echo $tbl_employee->empFirstName->CellAttributes() ?>>
<span id="el_tbl_employee_empFirstName" class="control-group">
<span<?php echo $tbl_employee->empFirstName->ViewAttributes() ?>>
<?php echo $tbl_employee->empFirstName->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tbl_employee->empMiddleName->Visible) { // empMiddleName ?>
		<tr id="r_empMiddleName">
			<td><?php echo $tbl_employee->empMiddleName->FldCaption() ?></td>
			<td<?php echo $tbl_employee->empMiddleName->CellAttributes() ?>>
<span id="el_tbl_employee_empMiddleName" class="control-group">
<span<?php echo $tbl_employee->empMiddleName->ViewAttributes() ?>>
<?php echo $tbl_employee->empMiddleName->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tbl_employee->empLastName->Visible) { // empLastName ?>
		<tr id="r_empLastName">
			<td><?php echo $tbl_employee->empLastName->FldCaption() ?></td>
			<td<?php echo $tbl_employee->empLastName->CellAttributes() ?>>
<span id="el_tbl_employee_empLastName" class="control-group">
<span<?php echo $tbl_employee->empLastName->ViewAttributes() ?>>
<?php echo $tbl_employee->empLastName->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tbl_employee->empExtensionName->Visible) { // empExtensionName ?>
		<tr id="r_empExtensionName">
			<td><?php echo $tbl_employee->empExtensionName->FldCaption() ?></td>
			<td<?php echo $tbl_employee->empExtensionName->CellAttributes() ?>>
<span id="el_tbl_employee_empExtensionName" class="control-group">
<span<?php echo $tbl_employee->empExtensionName->ViewAttributes() ?>>
<?php echo $tbl_employee->empExtensionName->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tbl_employee->sex_id->Visible) { // sex_id ?>
		<tr id="r_sex_id">
			<td><?php echo $tbl_employee->sex_id->FldCaption() ?></td>
			<td<?php echo $tbl_employee->sex_id->CellAttributes() ?>>
<span id="el_tbl_employee_sex_id" class="control-group">
<span<?php echo $tbl_employee->sex_id->ViewAttributes() ?>>
<?php echo $tbl_employee->sex_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tbl_employee->schedule_id->Visible) { // schedule_id ?>
		<tr id="r_schedule_id">
			<td><?php echo $tbl_employee->schedule_id->FldCaption() ?></td>
			<td<?php echo $tbl_employee->schedule_id->CellAttributes() ?>>
<span id="el_tbl_employee_schedule_id" class="control-group">
<span<?php echo $tbl_employee->schedule_id->ViewAttributes() ?>>
<?php echo $tbl_employee->schedule_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tbl_employee->salary_id->Visible) { // salary_id ?>
		<tr id="r_salary_id">
			<td><?php echo $tbl_employee->salary_id->FldCaption() ?></td>
			<td<?php echo $tbl_employee->salary_id->CellAttributes() ?>>
<span id="el_tbl_employee_salary_id" class="control-group">
<span<?php echo $tbl_employee->salary_id->ViewAttributes() ?>>
<?php echo $tbl_employee->salary_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tbl_employee->tax_category_id->Visible) { // tax_category_id ?>
		<tr id="r_tax_category_id">
			<td><?php echo $tbl_employee->tax_category_id->FldCaption() ?></td>
			<td<?php echo $tbl_employee->tax_category_id->CellAttributes() ?>>
<span id="el_tbl_employee_tax_category_id" class="control-group">
<span<?php echo $tbl_employee->tax_category_id->ViewAttributes() ?>>
<?php echo $tbl_employee->tax_category_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tbl_employee->date_hired->Visible) { // date_hired ?>
		<tr id="r_date_hired">
			<td><?php echo $tbl_employee->date_hired->FldCaption() ?></td>
			<td<?php echo $tbl_employee->date_hired->CellAttributes() ?>>
<span id="el_tbl_employee_date_hired" class="control-group">
<span<?php echo $tbl_employee->date_hired->ViewAttributes() ?>>
<?php echo $tbl_employee->date_hired->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</td></tr></table>
<?php } ?>
