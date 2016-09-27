<?php include_once "tbl_userinfo.php" ?>
<?php

// Create page object
if (!isset($tbl_employee_deduction_grid)) $tbl_employee_deduction_grid = new ctbl_employee_deduction_grid();

// Page init
$tbl_employee_deduction_grid->Page_Init();

// Page main
$tbl_employee_deduction_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tbl_employee_deduction_grid->Page_Render();
?>
<?php if ($tbl_employee_deduction->Export == "") { ?>
<script type="text/javascript">

// Page object
var tbl_employee_deduction_grid = new ew_Page("tbl_employee_deduction_grid");
tbl_employee_deduction_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = tbl_employee_deduction_grid.PageID; // For backward compatibility

// Form object
var ftbl_employee_deductiongrid = new ew_Form("ftbl_employee_deductiongrid");
ftbl_employee_deductiongrid.FormKeyCountName = '<?php echo $tbl_employee_deduction_grid->FormKeyCountName ?>';

// Validate form
ftbl_employee_deductiongrid.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	this.PostAutoSuggest();
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
			elm = this.GetElements("x" + infix + "_deduction_id");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_employee_deduction->deduction_id->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_deduction_amount");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_employee_deduction->deduction_amount->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_deduction_amount");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tbl_employee_deduction->deduction_amount->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_emp_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tbl_employee_deduction->emp_id->FldErrMsg()) ?>");

			// Set up row object
			ew_ElementsToRow(fobj);

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ftbl_employee_deductiongrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "deduction_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "deduction_amount", false)) return false;
	if (ew_ValueChanged(fobj, infix, "emp_id", false)) return false;
	return true;
}

// Form_CustomValidate event
ftbl_employee_deductiongrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_employee_deductiongrid.ValidateRequired = true;
<?php } else { ?>
ftbl_employee_deductiongrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftbl_employee_deductiongrid.Lists["x_deduction_id"] = {"LinkField":"x_deduction_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_deduction_title","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php if ($tbl_employee_deduction->getCurrentMasterTable() == "" && $tbl_employee_deduction_grid->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $tbl_employee_deduction_grid->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
if ($tbl_employee_deduction->CurrentAction == "gridadd") {
	if ($tbl_employee_deduction->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$tbl_employee_deduction_grid->TotalRecs = $tbl_employee_deduction->SelectRecordCount();
			$tbl_employee_deduction_grid->Recordset = $tbl_employee_deduction_grid->LoadRecordset($tbl_employee_deduction_grid->StartRec-1, $tbl_employee_deduction_grid->DisplayRecs);
		} else {
			if ($tbl_employee_deduction_grid->Recordset = $tbl_employee_deduction_grid->LoadRecordset())
				$tbl_employee_deduction_grid->TotalRecs = $tbl_employee_deduction_grid->Recordset->RecordCount();
		}
		$tbl_employee_deduction_grid->StartRec = 1;
		$tbl_employee_deduction_grid->DisplayRecs = $tbl_employee_deduction_grid->TotalRecs;
	} else {
		$tbl_employee_deduction->CurrentFilter = "0=1";
		$tbl_employee_deduction_grid->StartRec = 1;
		$tbl_employee_deduction_grid->DisplayRecs = $tbl_employee_deduction->GridAddRowCount;
	}
	$tbl_employee_deduction_grid->TotalRecs = $tbl_employee_deduction_grid->DisplayRecs;
	$tbl_employee_deduction_grid->StopRec = $tbl_employee_deduction_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$tbl_employee_deduction_grid->TotalRecs = $tbl_employee_deduction->SelectRecordCount();
	} else {
		if ($tbl_employee_deduction_grid->Recordset = $tbl_employee_deduction_grid->LoadRecordset())
			$tbl_employee_deduction_grid->TotalRecs = $tbl_employee_deduction_grid->Recordset->RecordCount();
	}
	$tbl_employee_deduction_grid->StartRec = 1;
	$tbl_employee_deduction_grid->DisplayRecs = $tbl_employee_deduction_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$tbl_employee_deduction_grid->Recordset = $tbl_employee_deduction_grid->LoadRecordset($tbl_employee_deduction_grid->StartRec-1, $tbl_employee_deduction_grid->DisplayRecs);
}
$tbl_employee_deduction_grid->RenderOtherOptions();
?>
<?php $tbl_employee_deduction_grid->ShowPageHeader(); ?>
<?php
$tbl_employee_deduction_grid->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div id="ftbl_employee_deductiongrid" class="ewForm form-horizontal">
<?php if ($tbl_employee_deduction_grid->ShowOtherOptions) { ?>
<div class="ewGridUpperPanel ewListOtherOptions">
<?php
	foreach ($tbl_employee_deduction_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<?php } ?>
<div id="gmp_tbl_employee_deduction" class="ewGridMiddlePanel">
<table id="tbl_tbl_employee_deductiongrid" class="ewTable ewTableSeparate">
<?php echo $tbl_employee_deduction->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$tbl_employee_deduction_grid->RenderListOptions();

// Render list options (header, left)
$tbl_employee_deduction_grid->ListOptions->Render("header", "left");
?>
<?php if ($tbl_employee_deduction->deduction_ref_id->Visible) { // deduction_ref_id ?>
	<?php if ($tbl_employee_deduction->SortUrl($tbl_employee_deduction->deduction_ref_id) == "") { ?>
		<td><div id="elh_tbl_employee_deduction_deduction_ref_id" class="tbl_employee_deduction_deduction_ref_id"><div class="ewTableHeaderCaption"><?php echo $tbl_employee_deduction->deduction_ref_id->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_tbl_employee_deduction_deduction_ref_id" class="tbl_employee_deduction_deduction_ref_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_employee_deduction->deduction_ref_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_employee_deduction->deduction_ref_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_employee_deduction->deduction_ref_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_employee_deduction->deduction_id->Visible) { // deduction_id ?>
	<?php if ($tbl_employee_deduction->SortUrl($tbl_employee_deduction->deduction_id) == "") { ?>
		<td><div id="elh_tbl_employee_deduction_deduction_id" class="tbl_employee_deduction_deduction_id"><div class="ewTableHeaderCaption"><?php echo $tbl_employee_deduction->deduction_id->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_tbl_employee_deduction_deduction_id" class="tbl_employee_deduction_deduction_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_employee_deduction->deduction_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_employee_deduction->deduction_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_employee_deduction->deduction_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_employee_deduction->deduction_amount->Visible) { // deduction_amount ?>
	<?php if ($tbl_employee_deduction->SortUrl($tbl_employee_deduction->deduction_amount) == "") { ?>
		<td><div id="elh_tbl_employee_deduction_deduction_amount" class="tbl_employee_deduction_deduction_amount"><div class="ewTableHeaderCaption"><?php echo $tbl_employee_deduction->deduction_amount->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_tbl_employee_deduction_deduction_amount" class="tbl_employee_deduction_deduction_amount">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_employee_deduction->deduction_amount->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_employee_deduction->deduction_amount->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_employee_deduction->deduction_amount->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_employee_deduction->emp_id->Visible) { // emp_id ?>
	<?php if ($tbl_employee_deduction->SortUrl($tbl_employee_deduction->emp_id) == "") { ?>
		<td><div id="elh_tbl_employee_deduction_emp_id" class="tbl_employee_deduction_emp_id"><div class="ewTableHeaderCaption"><?php echo $tbl_employee_deduction->emp_id->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_tbl_employee_deduction_emp_id" class="tbl_employee_deduction_emp_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_employee_deduction->emp_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_employee_deduction->emp_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_employee_deduction->emp_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$tbl_employee_deduction_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$tbl_employee_deduction_grid->StartRec = 1;
$tbl_employee_deduction_grid->StopRec = $tbl_employee_deduction_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($tbl_employee_deduction_grid->FormKeyCountName) && ($tbl_employee_deduction->CurrentAction == "gridadd" || $tbl_employee_deduction->CurrentAction == "gridedit" || $tbl_employee_deduction->CurrentAction == "F")) {
		$tbl_employee_deduction_grid->KeyCount = $objForm->GetValue($tbl_employee_deduction_grid->FormKeyCountName);
		$tbl_employee_deduction_grid->StopRec = $tbl_employee_deduction_grid->StartRec + $tbl_employee_deduction_grid->KeyCount - 1;
	}
}
$tbl_employee_deduction_grid->RecCnt = $tbl_employee_deduction_grid->StartRec - 1;
if ($tbl_employee_deduction_grid->Recordset && !$tbl_employee_deduction_grid->Recordset->EOF) {
	$tbl_employee_deduction_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $tbl_employee_deduction_grid->StartRec > 1)
		$tbl_employee_deduction_grid->Recordset->Move($tbl_employee_deduction_grid->StartRec - 1);
} elseif (!$tbl_employee_deduction->AllowAddDeleteRow && $tbl_employee_deduction_grid->StopRec == 0) {
	$tbl_employee_deduction_grid->StopRec = $tbl_employee_deduction->GridAddRowCount;
}

// Initialize aggregate
$tbl_employee_deduction->RowType = EW_ROWTYPE_AGGREGATEINIT;
$tbl_employee_deduction->ResetAttrs();
$tbl_employee_deduction_grid->RenderRow();
if ($tbl_employee_deduction->CurrentAction == "gridadd")
	$tbl_employee_deduction_grid->RowIndex = 0;
if ($tbl_employee_deduction->CurrentAction == "gridedit")
	$tbl_employee_deduction_grid->RowIndex = 0;
while ($tbl_employee_deduction_grid->RecCnt < $tbl_employee_deduction_grid->StopRec) {
	$tbl_employee_deduction_grid->RecCnt++;
	if (intval($tbl_employee_deduction_grid->RecCnt) >= intval($tbl_employee_deduction_grid->StartRec)) {
		$tbl_employee_deduction_grid->RowCnt++;
		if ($tbl_employee_deduction->CurrentAction == "gridadd" || $tbl_employee_deduction->CurrentAction == "gridedit" || $tbl_employee_deduction->CurrentAction == "F") {
			$tbl_employee_deduction_grid->RowIndex++;
			$objForm->Index = $tbl_employee_deduction_grid->RowIndex;
			if ($objForm->HasValue($tbl_employee_deduction_grid->FormActionName))
				$tbl_employee_deduction_grid->RowAction = strval($objForm->GetValue($tbl_employee_deduction_grid->FormActionName));
			elseif ($tbl_employee_deduction->CurrentAction == "gridadd")
				$tbl_employee_deduction_grid->RowAction = "insert";
			else
				$tbl_employee_deduction_grid->RowAction = "";
		}

		// Set up key count
		$tbl_employee_deduction_grid->KeyCount = $tbl_employee_deduction_grid->RowIndex;

		// Init row class and style
		$tbl_employee_deduction->ResetAttrs();
		$tbl_employee_deduction->CssClass = "";
		if ($tbl_employee_deduction->CurrentAction == "gridadd") {
			if ($tbl_employee_deduction->CurrentMode == "copy") {
				$tbl_employee_deduction_grid->LoadRowValues($tbl_employee_deduction_grid->Recordset); // Load row values
				$tbl_employee_deduction_grid->SetRecordKey($tbl_employee_deduction_grid->RowOldKey, $tbl_employee_deduction_grid->Recordset); // Set old record key
			} else {
				$tbl_employee_deduction_grid->LoadDefaultValues(); // Load default values
				$tbl_employee_deduction_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$tbl_employee_deduction_grid->LoadRowValues($tbl_employee_deduction_grid->Recordset); // Load row values
		}
		$tbl_employee_deduction->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($tbl_employee_deduction->CurrentAction == "gridadd") // Grid add
			$tbl_employee_deduction->RowType = EW_ROWTYPE_ADD; // Render add
		if ($tbl_employee_deduction->CurrentAction == "gridadd" && $tbl_employee_deduction->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$tbl_employee_deduction_grid->RestoreCurrentRowFormValues($tbl_employee_deduction_grid->RowIndex); // Restore form values
		if ($tbl_employee_deduction->CurrentAction == "gridedit") { // Grid edit
			if ($tbl_employee_deduction->EventCancelled) {
				$tbl_employee_deduction_grid->RestoreCurrentRowFormValues($tbl_employee_deduction_grid->RowIndex); // Restore form values
			}
			if ($tbl_employee_deduction_grid->RowAction == "insert")
				$tbl_employee_deduction->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$tbl_employee_deduction->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($tbl_employee_deduction->CurrentAction == "gridedit" && ($tbl_employee_deduction->RowType == EW_ROWTYPE_EDIT || $tbl_employee_deduction->RowType == EW_ROWTYPE_ADD) && $tbl_employee_deduction->EventCancelled) // Update failed
			$tbl_employee_deduction_grid->RestoreCurrentRowFormValues($tbl_employee_deduction_grid->RowIndex); // Restore form values
		if ($tbl_employee_deduction->RowType == EW_ROWTYPE_EDIT) // Edit row
			$tbl_employee_deduction_grid->EditRowCnt++;
		if ($tbl_employee_deduction->CurrentAction == "F") // Confirm row
			$tbl_employee_deduction_grid->RestoreCurrentRowFormValues($tbl_employee_deduction_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$tbl_employee_deduction->RowAttrs = array_merge($tbl_employee_deduction->RowAttrs, array('data-rowindex'=>$tbl_employee_deduction_grid->RowCnt, 'id'=>'r' . $tbl_employee_deduction_grid->RowCnt . '_tbl_employee_deduction', 'data-rowtype'=>$tbl_employee_deduction->RowType));

		// Render row
		$tbl_employee_deduction_grid->RenderRow();

		// Render list options
		$tbl_employee_deduction_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($tbl_employee_deduction_grid->RowAction <> "delete" && $tbl_employee_deduction_grid->RowAction <> "insertdelete" && !($tbl_employee_deduction_grid->RowAction == "insert" && $tbl_employee_deduction->CurrentAction == "F" && $tbl_employee_deduction_grid->EmptyRow())) {
?>
	<tr<?php echo $tbl_employee_deduction->RowAttributes() ?>>
<?php

// Render list options (body, left)
$tbl_employee_deduction_grid->ListOptions->Render("body", "left", $tbl_employee_deduction_grid->RowCnt);
?>
	<?php if ($tbl_employee_deduction->deduction_ref_id->Visible) { // deduction_ref_id ?>
		<td<?php echo $tbl_employee_deduction->deduction_ref_id->CellAttributes() ?>>
<?php if ($tbl_employee_deduction->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_deduction_ref_id" name="o<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_ref_id" id="o<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_ref_id" value="<?php echo ew_HtmlEncode($tbl_employee_deduction->deduction_ref_id->OldValue) ?>">
<?php } ?>
<?php if ($tbl_employee_deduction->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tbl_employee_deduction_grid->RowCnt ?>_tbl_employee_deduction_deduction_ref_id" class="control-group tbl_employee_deduction_deduction_ref_id">
<span<?php echo $tbl_employee_deduction->deduction_ref_id->ViewAttributes() ?>>
<?php echo $tbl_employee_deduction->deduction_ref_id->EditValue ?></span>
</span>
<input type="hidden" data-field="x_deduction_ref_id" name="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_ref_id" id="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_ref_id" value="<?php echo ew_HtmlEncode($tbl_employee_deduction->deduction_ref_id->CurrentValue) ?>">
<?php } ?>
<?php if ($tbl_employee_deduction->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $tbl_employee_deduction->deduction_ref_id->ViewAttributes() ?>>
<?php echo $tbl_employee_deduction->deduction_ref_id->ListViewValue() ?></span>
<input type="hidden" data-field="x_deduction_ref_id" name="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_ref_id" id="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_ref_id" value="<?php echo ew_HtmlEncode($tbl_employee_deduction->deduction_ref_id->FormValue) ?>">
<input type="hidden" data-field="x_deduction_ref_id" name="o<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_ref_id" id="o<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_ref_id" value="<?php echo ew_HtmlEncode($tbl_employee_deduction->deduction_ref_id->OldValue) ?>">
<?php } ?>
<a id="<?php echo $tbl_employee_deduction_grid->PageObjName . "_row_" . $tbl_employee_deduction_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($tbl_employee_deduction->deduction_id->Visible) { // deduction_id ?>
		<td<?php echo $tbl_employee_deduction->deduction_id->CellAttributes() ?>>
<?php if ($tbl_employee_deduction->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tbl_employee_deduction_grid->RowCnt ?>_tbl_employee_deduction_deduction_id" class="control-group tbl_employee_deduction_deduction_id">
<select data-field="x_deduction_id" id="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_id" name="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_id"<?php echo $tbl_employee_deduction->deduction_id->EditAttributes() ?>>
<?php
if (is_array($tbl_employee_deduction->deduction_id->EditValue)) {
	$arwrk = $tbl_employee_deduction->deduction_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_employee_deduction->deduction_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $tbl_employee_deduction->deduction_id->OldValue = "";
?>
</select>
<script type="text/javascript">
ftbl_employee_deductiongrid.Lists["x_deduction_id"].Options = <?php echo (is_array($tbl_employee_deduction->deduction_id->EditValue)) ? ew_ArrayToJson($tbl_employee_deduction->deduction_id->EditValue, 1) : "[]" ?>;
</script>
</span>
<input type="hidden" data-field="x_deduction_id" name="o<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_id" id="o<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_id" value="<?php echo ew_HtmlEncode($tbl_employee_deduction->deduction_id->OldValue) ?>">
<?php } ?>
<?php if ($tbl_employee_deduction->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tbl_employee_deduction_grid->RowCnt ?>_tbl_employee_deduction_deduction_id" class="control-group tbl_employee_deduction_deduction_id">
<select data-field="x_deduction_id" id="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_id" name="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_id"<?php echo $tbl_employee_deduction->deduction_id->EditAttributes() ?>>
<?php
if (is_array($tbl_employee_deduction->deduction_id->EditValue)) {
	$arwrk = $tbl_employee_deduction->deduction_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_employee_deduction->deduction_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $tbl_employee_deduction->deduction_id->OldValue = "";
?>
</select>
<script type="text/javascript">
ftbl_employee_deductiongrid.Lists["x_deduction_id"].Options = <?php echo (is_array($tbl_employee_deduction->deduction_id->EditValue)) ? ew_ArrayToJson($tbl_employee_deduction->deduction_id->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php } ?>
<?php if ($tbl_employee_deduction->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $tbl_employee_deduction->deduction_id->ViewAttributes() ?>>
<?php echo $tbl_employee_deduction->deduction_id->ListViewValue() ?></span>
<input type="hidden" data-field="x_deduction_id" name="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_id" id="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_id" value="<?php echo ew_HtmlEncode($tbl_employee_deduction->deduction_id->FormValue) ?>">
<input type="hidden" data-field="x_deduction_id" name="o<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_id" id="o<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_id" value="<?php echo ew_HtmlEncode($tbl_employee_deduction->deduction_id->OldValue) ?>">
<?php } ?>
<a id="<?php echo $tbl_employee_deduction_grid->PageObjName . "_row_" . $tbl_employee_deduction_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($tbl_employee_deduction->deduction_amount->Visible) { // deduction_amount ?>
		<td<?php echo $tbl_employee_deduction->deduction_amount->CellAttributes() ?>>
<?php if ($tbl_employee_deduction->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tbl_employee_deduction_grid->RowCnt ?>_tbl_employee_deduction_deduction_amount" class="control-group tbl_employee_deduction_deduction_amount">
<input type="text" data-field="x_deduction_amount" name="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_amount" id="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_amount" size="30" placeholder="<?php echo $tbl_employee_deduction->deduction_amount->PlaceHolder ?>" value="<?php echo $tbl_employee_deduction->deduction_amount->EditValue ?>"<?php echo $tbl_employee_deduction->deduction_amount->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_deduction_amount" name="o<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_amount" id="o<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_amount" value="<?php echo ew_HtmlEncode($tbl_employee_deduction->deduction_amount->OldValue) ?>">
<?php } ?>
<?php if ($tbl_employee_deduction->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tbl_employee_deduction_grid->RowCnt ?>_tbl_employee_deduction_deduction_amount" class="control-group tbl_employee_deduction_deduction_amount">
<input type="text" data-field="x_deduction_amount" name="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_amount" id="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_amount" size="30" placeholder="<?php echo $tbl_employee_deduction->deduction_amount->PlaceHolder ?>" value="<?php echo $tbl_employee_deduction->deduction_amount->EditValue ?>"<?php echo $tbl_employee_deduction->deduction_amount->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tbl_employee_deduction->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $tbl_employee_deduction->deduction_amount->ViewAttributes() ?>>
<?php echo $tbl_employee_deduction->deduction_amount->ListViewValue() ?></span>
<input type="hidden" data-field="x_deduction_amount" name="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_amount" id="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_amount" value="<?php echo ew_HtmlEncode($tbl_employee_deduction->deduction_amount->FormValue) ?>">
<input type="hidden" data-field="x_deduction_amount" name="o<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_amount" id="o<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_amount" value="<?php echo ew_HtmlEncode($tbl_employee_deduction->deduction_amount->OldValue) ?>">
<?php } ?>
<a id="<?php echo $tbl_employee_deduction_grid->PageObjName . "_row_" . $tbl_employee_deduction_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($tbl_employee_deduction->emp_id->Visible) { // emp_id ?>
		<td<?php echo $tbl_employee_deduction->emp_id->CellAttributes() ?>>
<?php if ($tbl_employee_deduction->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($tbl_employee_deduction->emp_id->getSessionValue() <> "") { ?>
<span<?php echo $tbl_employee_deduction->emp_id->ViewAttributes() ?>>
<?php echo $tbl_employee_deduction->emp_id->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_emp_id" name="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_emp_id" value="<?php echo ew_HtmlEncode($tbl_employee_deduction->emp_id->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_emp_id" name="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_emp_id" id="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_emp_id" size="30" placeholder="<?php echo $tbl_employee_deduction->emp_id->PlaceHolder ?>" value="<?php echo $tbl_employee_deduction->emp_id->EditValue ?>"<?php echo $tbl_employee_deduction->emp_id->EditAttributes() ?>>
<?php } ?>
<input type="hidden" data-field="x_emp_id" name="o<?php echo $tbl_employee_deduction_grid->RowIndex ?>_emp_id" id="o<?php echo $tbl_employee_deduction_grid->RowIndex ?>_emp_id" value="<?php echo ew_HtmlEncode($tbl_employee_deduction->emp_id->OldValue) ?>">
<?php } ?>
<?php if ($tbl_employee_deduction->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($tbl_employee_deduction->emp_id->getSessionValue() <> "") { ?>
<span<?php echo $tbl_employee_deduction->emp_id->ViewAttributes() ?>>
<?php echo $tbl_employee_deduction->emp_id->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_emp_id" name="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_emp_id" value="<?php echo ew_HtmlEncode($tbl_employee_deduction->emp_id->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_emp_id" name="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_emp_id" id="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_emp_id" size="30" placeholder="<?php echo $tbl_employee_deduction->emp_id->PlaceHolder ?>" value="<?php echo $tbl_employee_deduction->emp_id->EditValue ?>"<?php echo $tbl_employee_deduction->emp_id->EditAttributes() ?>>
<?php } ?>
<?php } ?>
<?php if ($tbl_employee_deduction->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $tbl_employee_deduction->emp_id->ViewAttributes() ?>>
<?php echo $tbl_employee_deduction->emp_id->ListViewValue() ?></span>
<input type="hidden" data-field="x_emp_id" name="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_emp_id" id="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_emp_id" value="<?php echo ew_HtmlEncode($tbl_employee_deduction->emp_id->FormValue) ?>">
<input type="hidden" data-field="x_emp_id" name="o<?php echo $tbl_employee_deduction_grid->RowIndex ?>_emp_id" id="o<?php echo $tbl_employee_deduction_grid->RowIndex ?>_emp_id" value="<?php echo ew_HtmlEncode($tbl_employee_deduction->emp_id->OldValue) ?>">
<?php } ?>
<a id="<?php echo $tbl_employee_deduction_grid->PageObjName . "_row_" . $tbl_employee_deduction_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$tbl_employee_deduction_grid->ListOptions->Render("body", "right", $tbl_employee_deduction_grid->RowCnt);
?>
	</tr>
<?php if ($tbl_employee_deduction->RowType == EW_ROWTYPE_ADD || $tbl_employee_deduction->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ftbl_employee_deductiongrid.UpdateOpts(<?php echo $tbl_employee_deduction_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($tbl_employee_deduction->CurrentAction <> "gridadd" || $tbl_employee_deduction->CurrentMode == "copy")
		if (!$tbl_employee_deduction_grid->Recordset->EOF) $tbl_employee_deduction_grid->Recordset->MoveNext();
}
?>
<?php
	if ($tbl_employee_deduction->CurrentMode == "add" || $tbl_employee_deduction->CurrentMode == "copy" || $tbl_employee_deduction->CurrentMode == "edit") {
		$tbl_employee_deduction_grid->RowIndex = '$rowindex$';
		$tbl_employee_deduction_grid->LoadDefaultValues();

		// Set row properties
		$tbl_employee_deduction->ResetAttrs();
		$tbl_employee_deduction->RowAttrs = array_merge($tbl_employee_deduction->RowAttrs, array('data-rowindex'=>$tbl_employee_deduction_grid->RowIndex, 'id'=>'r0_tbl_employee_deduction', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($tbl_employee_deduction->RowAttrs["class"], "ewTemplate");
		$tbl_employee_deduction->RowType = EW_ROWTYPE_ADD;

		// Render row
		$tbl_employee_deduction_grid->RenderRow();

		// Render list options
		$tbl_employee_deduction_grid->RenderListOptions();
		$tbl_employee_deduction_grid->StartRowCnt = 0;
?>
	<tr<?php echo $tbl_employee_deduction->RowAttributes() ?>>
<?php

// Render list options (body, left)
$tbl_employee_deduction_grid->ListOptions->Render("body", "left", $tbl_employee_deduction_grid->RowIndex);
?>
	<?php if ($tbl_employee_deduction->deduction_ref_id->Visible) { // deduction_ref_id ?>
		<td>
<?php if ($tbl_employee_deduction->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_tbl_employee_deduction_deduction_ref_id" class="control-group tbl_employee_deduction_deduction_ref_id">
<span<?php echo $tbl_employee_deduction->deduction_ref_id->ViewAttributes() ?>>
<?php echo $tbl_employee_deduction->deduction_ref_id->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_deduction_ref_id" name="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_ref_id" id="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_ref_id" value="<?php echo ew_HtmlEncode($tbl_employee_deduction->deduction_ref_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_deduction_ref_id" name="o<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_ref_id" id="o<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_ref_id" value="<?php echo ew_HtmlEncode($tbl_employee_deduction->deduction_ref_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tbl_employee_deduction->deduction_id->Visible) { // deduction_id ?>
		<td>
<?php if ($tbl_employee_deduction->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tbl_employee_deduction_deduction_id" class="control-group tbl_employee_deduction_deduction_id">
<select data-field="x_deduction_id" id="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_id" name="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_id"<?php echo $tbl_employee_deduction->deduction_id->EditAttributes() ?>>
<?php
if (is_array($tbl_employee_deduction->deduction_id->EditValue)) {
	$arwrk = $tbl_employee_deduction->deduction_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_employee_deduction->deduction_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $tbl_employee_deduction->deduction_id->OldValue = "";
?>
</select>
<script type="text/javascript">
ftbl_employee_deductiongrid.Lists["x_deduction_id"].Options = <?php echo (is_array($tbl_employee_deduction->deduction_id->EditValue)) ? ew_ArrayToJson($tbl_employee_deduction->deduction_id->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_tbl_employee_deduction_deduction_id" class="control-group tbl_employee_deduction_deduction_id">
<span<?php echo $tbl_employee_deduction->deduction_id->ViewAttributes() ?>>
<?php echo $tbl_employee_deduction->deduction_id->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_deduction_id" name="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_id" id="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_id" value="<?php echo ew_HtmlEncode($tbl_employee_deduction->deduction_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_deduction_id" name="o<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_id" id="o<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_id" value="<?php echo ew_HtmlEncode($tbl_employee_deduction->deduction_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tbl_employee_deduction->deduction_amount->Visible) { // deduction_amount ?>
		<td>
<?php if ($tbl_employee_deduction->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tbl_employee_deduction_deduction_amount" class="control-group tbl_employee_deduction_deduction_amount">
<input type="text" data-field="x_deduction_amount" name="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_amount" id="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_amount" size="30" placeholder="<?php echo $tbl_employee_deduction->deduction_amount->PlaceHolder ?>" value="<?php echo $tbl_employee_deduction->deduction_amount->EditValue ?>"<?php echo $tbl_employee_deduction->deduction_amount->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_tbl_employee_deduction_deduction_amount" class="control-group tbl_employee_deduction_deduction_amount">
<span<?php echo $tbl_employee_deduction->deduction_amount->ViewAttributes() ?>>
<?php echo $tbl_employee_deduction->deduction_amount->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_deduction_amount" name="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_amount" id="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_amount" value="<?php echo ew_HtmlEncode($tbl_employee_deduction->deduction_amount->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_deduction_amount" name="o<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_amount" id="o<?php echo $tbl_employee_deduction_grid->RowIndex ?>_deduction_amount" value="<?php echo ew_HtmlEncode($tbl_employee_deduction->deduction_amount->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tbl_employee_deduction->emp_id->Visible) { // emp_id ?>
		<td>
<?php if ($tbl_employee_deduction->CurrentAction <> "F") { ?>
<?php if ($tbl_employee_deduction->emp_id->getSessionValue() <> "") { ?>
<span<?php echo $tbl_employee_deduction->emp_id->ViewAttributes() ?>>
<?php echo $tbl_employee_deduction->emp_id->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_emp_id" name="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_emp_id" value="<?php echo ew_HtmlEncode($tbl_employee_deduction->emp_id->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_emp_id" name="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_emp_id" id="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_emp_id" size="30" placeholder="<?php echo $tbl_employee_deduction->emp_id->PlaceHolder ?>" value="<?php echo $tbl_employee_deduction->emp_id->EditValue ?>"<?php echo $tbl_employee_deduction->emp_id->EditAttributes() ?>>
<?php } ?>
<?php } else { ?>
<span<?php echo $tbl_employee_deduction->emp_id->ViewAttributes() ?>>
<?php echo $tbl_employee_deduction->emp_id->ViewValue ?></span>
<input type="hidden" data-field="x_emp_id" name="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_emp_id" id="x<?php echo $tbl_employee_deduction_grid->RowIndex ?>_emp_id" value="<?php echo ew_HtmlEncode($tbl_employee_deduction->emp_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_emp_id" name="o<?php echo $tbl_employee_deduction_grid->RowIndex ?>_emp_id" id="o<?php echo $tbl_employee_deduction_grid->RowIndex ?>_emp_id" value="<?php echo ew_HtmlEncode($tbl_employee_deduction->emp_id->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$tbl_employee_deduction_grid->ListOptions->Render("body", "right", $tbl_employee_deduction_grid->RowCnt);
?>
<script type="text/javascript">
ftbl_employee_deductiongrid.UpdateOpts(<?php echo $tbl_employee_deduction_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($tbl_employee_deduction->CurrentMode == "add" || $tbl_employee_deduction->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $tbl_employee_deduction_grid->FormKeyCountName ?>" id="<?php echo $tbl_employee_deduction_grid->FormKeyCountName ?>" value="<?php echo $tbl_employee_deduction_grid->KeyCount ?>">
<?php echo $tbl_employee_deduction_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($tbl_employee_deduction->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $tbl_employee_deduction_grid->FormKeyCountName ?>" id="<?php echo $tbl_employee_deduction_grid->FormKeyCountName ?>" value="<?php echo $tbl_employee_deduction_grid->KeyCount ?>">
<?php echo $tbl_employee_deduction_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($tbl_employee_deduction->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ftbl_employee_deductiongrid">
</div>
<?php

// Close recordset
if ($tbl_employee_deduction_grid->Recordset)
	$tbl_employee_deduction_grid->Recordset->Close();
?>
<?php if ($tbl_employee_deduction_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel ewListOtherOptions">
<?php
	foreach ($tbl_employee_deduction_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<?php } ?>
</div>
</td></tr></table>
<?php if ($tbl_employee_deduction->Export == "") { ?>
<script type="text/javascript">
ftbl_employee_deductiongrid.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$tbl_employee_deduction_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$tbl_employee_deduction_grid->Page_Terminate();
?>
