<?php include_once "tbl_userinfo.php" ?>
<?php

// Create page object
if (!isset($tbl_leavecoverage_grid)) $tbl_leavecoverage_grid = new ctbl_leavecoverage_grid();

// Page init
$tbl_leavecoverage_grid->Page_Init();

// Page main
$tbl_leavecoverage_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tbl_leavecoverage_grid->Page_Render();
?>
<?php if ($tbl_leavecoverage->Export == "") { ?>
<script type="text/javascript">

// Page object
var tbl_leavecoverage_grid = new ew_Page("tbl_leavecoverage_grid");
tbl_leavecoverage_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = tbl_leavecoverage_grid.PageID; // For backward compatibility

// Form object
var ftbl_leavecoveragegrid = new ew_Form("ftbl_leavecoveragegrid");
ftbl_leavecoveragegrid.FormKeyCountName = '<?php echo $tbl_leavecoverage_grid->FormKeyCountName ?>';

// Validate form
ftbl_leavecoveragegrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_leave_application_id");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_leavecoverage->leave_application_id->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_leave_application_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tbl_leavecoverage->leave_application_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_emp_id");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_leavecoverage->emp_id->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_emp_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tbl_leavecoverage->emp_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_date_from");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_leavecoverage->date_from->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_date_from");
			if (elm && !ew_CheckDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tbl_leavecoverage->date_from->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_date_to");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_leavecoverage->date_to->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_date_to");
			if (elm && !ew_CheckDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tbl_leavecoverage->date_to->FldErrMsg()) ?>");

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
ftbl_leavecoveragegrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "leave_application_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "emp_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "date_from", false)) return false;
	if (ew_ValueChanged(fobj, infix, "date_to", false)) return false;
	return true;
}

// Form_CustomValidate event
ftbl_leavecoveragegrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_leavecoveragegrid.ValidateRequired = true;
<?php } else { ?>
ftbl_leavecoveragegrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftbl_leavecoveragegrid.Lists["x_emp_id"] = {"LinkField":"x_emp_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_empLastName","x_empFirstName","x_empMiddleName",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php if ($tbl_leavecoverage->getCurrentMasterTable() == "" && $tbl_leavecoverage_grid->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $tbl_leavecoverage_grid->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
if ($tbl_leavecoverage->CurrentAction == "gridadd") {
	if ($tbl_leavecoverage->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$tbl_leavecoverage_grid->TotalRecs = $tbl_leavecoverage->SelectRecordCount();
			$tbl_leavecoverage_grid->Recordset = $tbl_leavecoverage_grid->LoadRecordset($tbl_leavecoverage_grid->StartRec-1, $tbl_leavecoverage_grid->DisplayRecs);
		} else {
			if ($tbl_leavecoverage_grid->Recordset = $tbl_leavecoverage_grid->LoadRecordset())
				$tbl_leavecoverage_grid->TotalRecs = $tbl_leavecoverage_grid->Recordset->RecordCount();
		}
		$tbl_leavecoverage_grid->StartRec = 1;
		$tbl_leavecoverage_grid->DisplayRecs = $tbl_leavecoverage_grid->TotalRecs;
	} else {
		$tbl_leavecoverage->CurrentFilter = "0=1";
		$tbl_leavecoverage_grid->StartRec = 1;
		$tbl_leavecoverage_grid->DisplayRecs = $tbl_leavecoverage->GridAddRowCount;
	}
	$tbl_leavecoverage_grid->TotalRecs = $tbl_leavecoverage_grid->DisplayRecs;
	$tbl_leavecoverage_grid->StopRec = $tbl_leavecoverage_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$tbl_leavecoverage_grid->TotalRecs = $tbl_leavecoverage->SelectRecordCount();
	} else {
		if ($tbl_leavecoverage_grid->Recordset = $tbl_leavecoverage_grid->LoadRecordset())
			$tbl_leavecoverage_grid->TotalRecs = $tbl_leavecoverage_grid->Recordset->RecordCount();
	}
	$tbl_leavecoverage_grid->StartRec = 1;
	$tbl_leavecoverage_grid->DisplayRecs = $tbl_leavecoverage_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$tbl_leavecoverage_grid->Recordset = $tbl_leavecoverage_grid->LoadRecordset($tbl_leavecoverage_grid->StartRec-1, $tbl_leavecoverage_grid->DisplayRecs);
}
$tbl_leavecoverage_grid->RenderOtherOptions();
?>
<?php $tbl_leavecoverage_grid->ShowPageHeader(); ?>
<?php
$tbl_leavecoverage_grid->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div id="ftbl_leavecoveragegrid" class="ewForm form-horizontal">
<?php if ($tbl_leavecoverage_grid->ShowOtherOptions) { ?>
<div class="ewGridUpperPanel ewListOtherOptions">
<?php
	foreach ($tbl_leavecoverage_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<?php } ?>
<div id="gmp_tbl_leavecoverage" class="ewGridMiddlePanel">
<table id="tbl_tbl_leavecoveragegrid" class="ewTable ewTableSeparate">
<?php echo $tbl_leavecoverage->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$tbl_leavecoverage_grid->RenderListOptions();

// Render list options (header, left)
$tbl_leavecoverage_grid->ListOptions->Render("header", "left");
?>
<?php if ($tbl_leavecoverage->leave_coverage_id->Visible) { // leave_coverage_id ?>
	<?php if ($tbl_leavecoverage->SortUrl($tbl_leavecoverage->leave_coverage_id) == "") { ?>
		<td><div id="elh_tbl_leavecoverage_leave_coverage_id" class="tbl_leavecoverage_leave_coverage_id"><div class="ewTableHeaderCaption"><?php echo $tbl_leavecoverage->leave_coverage_id->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_tbl_leavecoverage_leave_coverage_id" class="tbl_leavecoverage_leave_coverage_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_leavecoverage->leave_coverage_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_leavecoverage->leave_coverage_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_leavecoverage->leave_coverage_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_leavecoverage->leave_application_id->Visible) { // leave_application_id ?>
	<?php if ($tbl_leavecoverage->SortUrl($tbl_leavecoverage->leave_application_id) == "") { ?>
		<td><div id="elh_tbl_leavecoverage_leave_application_id" class="tbl_leavecoverage_leave_application_id"><div class="ewTableHeaderCaption"><?php echo $tbl_leavecoverage->leave_application_id->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_tbl_leavecoverage_leave_application_id" class="tbl_leavecoverage_leave_application_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_leavecoverage->leave_application_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_leavecoverage->leave_application_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_leavecoverage->leave_application_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_leavecoverage->emp_id->Visible) { // emp_id ?>
	<?php if ($tbl_leavecoverage->SortUrl($tbl_leavecoverage->emp_id) == "") { ?>
		<td><div id="elh_tbl_leavecoverage_emp_id" class="tbl_leavecoverage_emp_id"><div class="ewTableHeaderCaption"><?php echo $tbl_leavecoverage->emp_id->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_tbl_leavecoverage_emp_id" class="tbl_leavecoverage_emp_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_leavecoverage->emp_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_leavecoverage->emp_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_leavecoverage->emp_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_leavecoverage->date_from->Visible) { // date_from ?>
	<?php if ($tbl_leavecoverage->SortUrl($tbl_leavecoverage->date_from) == "") { ?>
		<td><div id="elh_tbl_leavecoverage_date_from" class="tbl_leavecoverage_date_from"><div class="ewTableHeaderCaption"><?php echo $tbl_leavecoverage->date_from->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_tbl_leavecoverage_date_from" class="tbl_leavecoverage_date_from">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_leavecoverage->date_from->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_leavecoverage->date_from->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_leavecoverage->date_from->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_leavecoverage->date_to->Visible) { // date_to ?>
	<?php if ($tbl_leavecoverage->SortUrl($tbl_leavecoverage->date_to) == "") { ?>
		<td><div id="elh_tbl_leavecoverage_date_to" class="tbl_leavecoverage_date_to"><div class="ewTableHeaderCaption"><?php echo $tbl_leavecoverage->date_to->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_tbl_leavecoverage_date_to" class="tbl_leavecoverage_date_to">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_leavecoverage->date_to->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_leavecoverage->date_to->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_leavecoverage->date_to->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$tbl_leavecoverage_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$tbl_leavecoverage_grid->StartRec = 1;
$tbl_leavecoverage_grid->StopRec = $tbl_leavecoverage_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($tbl_leavecoverage_grid->FormKeyCountName) && ($tbl_leavecoverage->CurrentAction == "gridadd" || $tbl_leavecoverage->CurrentAction == "gridedit" || $tbl_leavecoverage->CurrentAction == "F")) {
		$tbl_leavecoverage_grid->KeyCount = $objForm->GetValue($tbl_leavecoverage_grid->FormKeyCountName);
		$tbl_leavecoverage_grid->StopRec = $tbl_leavecoverage_grid->StartRec + $tbl_leavecoverage_grid->KeyCount - 1;
	}
}
$tbl_leavecoverage_grid->RecCnt = $tbl_leavecoverage_grid->StartRec - 1;
if ($tbl_leavecoverage_grid->Recordset && !$tbl_leavecoverage_grid->Recordset->EOF) {
	$tbl_leavecoverage_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $tbl_leavecoverage_grid->StartRec > 1)
		$tbl_leavecoverage_grid->Recordset->Move($tbl_leavecoverage_grid->StartRec - 1);
} elseif (!$tbl_leavecoverage->AllowAddDeleteRow && $tbl_leavecoverage_grid->StopRec == 0) {
	$tbl_leavecoverage_grid->StopRec = $tbl_leavecoverage->GridAddRowCount;
}

// Initialize aggregate
$tbl_leavecoverage->RowType = EW_ROWTYPE_AGGREGATEINIT;
$tbl_leavecoverage->ResetAttrs();
$tbl_leavecoverage_grid->RenderRow();
if ($tbl_leavecoverage->CurrentAction == "gridadd")
	$tbl_leavecoverage_grid->RowIndex = 0;
if ($tbl_leavecoverage->CurrentAction == "gridedit")
	$tbl_leavecoverage_grid->RowIndex = 0;
while ($tbl_leavecoverage_grid->RecCnt < $tbl_leavecoverage_grid->StopRec) {
	$tbl_leavecoverage_grid->RecCnt++;
	if (intval($tbl_leavecoverage_grid->RecCnt) >= intval($tbl_leavecoverage_grid->StartRec)) {
		$tbl_leavecoverage_grid->RowCnt++;
		if ($tbl_leavecoverage->CurrentAction == "gridadd" || $tbl_leavecoverage->CurrentAction == "gridedit" || $tbl_leavecoverage->CurrentAction == "F") {
			$tbl_leavecoverage_grid->RowIndex++;
			$objForm->Index = $tbl_leavecoverage_grid->RowIndex;
			if ($objForm->HasValue($tbl_leavecoverage_grid->FormActionName))
				$tbl_leavecoverage_grid->RowAction = strval($objForm->GetValue($tbl_leavecoverage_grid->FormActionName));
			elseif ($tbl_leavecoverage->CurrentAction == "gridadd")
				$tbl_leavecoverage_grid->RowAction = "insert";
			else
				$tbl_leavecoverage_grid->RowAction = "";
		}

		// Set up key count
		$tbl_leavecoverage_grid->KeyCount = $tbl_leavecoverage_grid->RowIndex;

		// Init row class and style
		$tbl_leavecoverage->ResetAttrs();
		$tbl_leavecoverage->CssClass = "";
		if ($tbl_leavecoverage->CurrentAction == "gridadd") {
			if ($tbl_leavecoverage->CurrentMode == "copy") {
				$tbl_leavecoverage_grid->LoadRowValues($tbl_leavecoverage_grid->Recordset); // Load row values
				$tbl_leavecoverage_grid->SetRecordKey($tbl_leavecoverage_grid->RowOldKey, $tbl_leavecoverage_grid->Recordset); // Set old record key
			} else {
				$tbl_leavecoverage_grid->LoadDefaultValues(); // Load default values
				$tbl_leavecoverage_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$tbl_leavecoverage_grid->LoadRowValues($tbl_leavecoverage_grid->Recordset); // Load row values
		}
		$tbl_leavecoverage->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($tbl_leavecoverage->CurrentAction == "gridadd") // Grid add
			$tbl_leavecoverage->RowType = EW_ROWTYPE_ADD; // Render add
		if ($tbl_leavecoverage->CurrentAction == "gridadd" && $tbl_leavecoverage->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$tbl_leavecoverage_grid->RestoreCurrentRowFormValues($tbl_leavecoverage_grid->RowIndex); // Restore form values
		if ($tbl_leavecoverage->CurrentAction == "gridedit") { // Grid edit
			if ($tbl_leavecoverage->EventCancelled) {
				$tbl_leavecoverage_grid->RestoreCurrentRowFormValues($tbl_leavecoverage_grid->RowIndex); // Restore form values
			}
			if ($tbl_leavecoverage_grid->RowAction == "insert")
				$tbl_leavecoverage->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$tbl_leavecoverage->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($tbl_leavecoverage->CurrentAction == "gridedit" && ($tbl_leavecoverage->RowType == EW_ROWTYPE_EDIT || $tbl_leavecoverage->RowType == EW_ROWTYPE_ADD) && $tbl_leavecoverage->EventCancelled) // Update failed
			$tbl_leavecoverage_grid->RestoreCurrentRowFormValues($tbl_leavecoverage_grid->RowIndex); // Restore form values
		if ($tbl_leavecoverage->RowType == EW_ROWTYPE_EDIT) // Edit row
			$tbl_leavecoverage_grid->EditRowCnt++;
		if ($tbl_leavecoverage->CurrentAction == "F") // Confirm row
			$tbl_leavecoverage_grid->RestoreCurrentRowFormValues($tbl_leavecoverage_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$tbl_leavecoverage->RowAttrs = array_merge($tbl_leavecoverage->RowAttrs, array('data-rowindex'=>$tbl_leavecoverage_grid->RowCnt, 'id'=>'r' . $tbl_leavecoverage_grid->RowCnt . '_tbl_leavecoverage', 'data-rowtype'=>$tbl_leavecoverage->RowType));

		// Render row
		$tbl_leavecoverage_grid->RenderRow();

		// Render list options
		$tbl_leavecoverage_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($tbl_leavecoverage_grid->RowAction <> "delete" && $tbl_leavecoverage_grid->RowAction <> "insertdelete" && !($tbl_leavecoverage_grid->RowAction == "insert" && $tbl_leavecoverage->CurrentAction == "F" && $tbl_leavecoverage_grid->EmptyRow())) {
?>
	<tr<?php echo $tbl_leavecoverage->RowAttributes() ?>>
<?php

// Render list options (body, left)
$tbl_leavecoverage_grid->ListOptions->Render("body", "left", $tbl_leavecoverage_grid->RowCnt);
?>
	<?php if ($tbl_leavecoverage->leave_coverage_id->Visible) { // leave_coverage_id ?>
		<td<?php echo $tbl_leavecoverage->leave_coverage_id->CellAttributes() ?>>
<?php if ($tbl_leavecoverage->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_leave_coverage_id" name="o<?php echo $tbl_leavecoverage_grid->RowIndex ?>_leave_coverage_id" id="o<?php echo $tbl_leavecoverage_grid->RowIndex ?>_leave_coverage_id" value="<?php echo ew_HtmlEncode($tbl_leavecoverage->leave_coverage_id->OldValue) ?>">
<?php } ?>
<?php if ($tbl_leavecoverage->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tbl_leavecoverage_grid->RowCnt ?>_tbl_leavecoverage_leave_coverage_id" class="control-group tbl_leavecoverage_leave_coverage_id">
<span<?php echo $tbl_leavecoverage->leave_coverage_id->ViewAttributes() ?>>
<?php echo $tbl_leavecoverage->leave_coverage_id->EditValue ?></span>
</span>
<input type="hidden" data-field="x_leave_coverage_id" name="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_leave_coverage_id" id="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_leave_coverage_id" value="<?php echo ew_HtmlEncode($tbl_leavecoverage->leave_coverage_id->CurrentValue) ?>">
<?php } ?>
<?php if ($tbl_leavecoverage->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $tbl_leavecoverage->leave_coverage_id->ViewAttributes() ?>>
<?php echo $tbl_leavecoverage->leave_coverage_id->ListViewValue() ?></span>
<input type="hidden" data-field="x_leave_coverage_id" name="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_leave_coverage_id" id="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_leave_coverage_id" value="<?php echo ew_HtmlEncode($tbl_leavecoverage->leave_coverage_id->FormValue) ?>">
<input type="hidden" data-field="x_leave_coverage_id" name="o<?php echo $tbl_leavecoverage_grid->RowIndex ?>_leave_coverage_id" id="o<?php echo $tbl_leavecoverage_grid->RowIndex ?>_leave_coverage_id" value="<?php echo ew_HtmlEncode($tbl_leavecoverage->leave_coverage_id->OldValue) ?>">
<?php } ?>
<a id="<?php echo $tbl_leavecoverage_grid->PageObjName . "_row_" . $tbl_leavecoverage_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($tbl_leavecoverage->leave_application_id->Visible) { // leave_application_id ?>
		<td<?php echo $tbl_leavecoverage->leave_application_id->CellAttributes() ?>>
<?php if ($tbl_leavecoverage->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($tbl_leavecoverage->leave_application_id->getSessionValue() <> "") { ?>
<span<?php echo $tbl_leavecoverage->leave_application_id->ViewAttributes() ?>>
<?php echo $tbl_leavecoverage->leave_application_id->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_leave_application_id" name="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_leave_application_id" value="<?php echo ew_HtmlEncode($tbl_leavecoverage->leave_application_id->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_leave_application_id" name="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_leave_application_id" id="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_leave_application_id" size="30" placeholder="<?php echo $tbl_leavecoverage->leave_application_id->PlaceHolder ?>" value="<?php echo $tbl_leavecoverage->leave_application_id->EditValue ?>"<?php echo $tbl_leavecoverage->leave_application_id->EditAttributes() ?>>
<?php } ?>
<input type="hidden" data-field="x_leave_application_id" name="o<?php echo $tbl_leavecoverage_grid->RowIndex ?>_leave_application_id" id="o<?php echo $tbl_leavecoverage_grid->RowIndex ?>_leave_application_id" value="<?php echo ew_HtmlEncode($tbl_leavecoverage->leave_application_id->OldValue) ?>">
<?php } ?>
<?php if ($tbl_leavecoverage->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($tbl_leavecoverage->leave_application_id->getSessionValue() <> "") { ?>
<span<?php echo $tbl_leavecoverage->leave_application_id->ViewAttributes() ?>>
<?php echo $tbl_leavecoverage->leave_application_id->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_leave_application_id" name="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_leave_application_id" value="<?php echo ew_HtmlEncode($tbl_leavecoverage->leave_application_id->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_leave_application_id" name="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_leave_application_id" id="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_leave_application_id" size="30" placeholder="<?php echo $tbl_leavecoverage->leave_application_id->PlaceHolder ?>" value="<?php echo $tbl_leavecoverage->leave_application_id->EditValue ?>"<?php echo $tbl_leavecoverage->leave_application_id->EditAttributes() ?>>
<?php } ?>
<?php } ?>
<?php if ($tbl_leavecoverage->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $tbl_leavecoverage->leave_application_id->ViewAttributes() ?>>
<?php echo $tbl_leavecoverage->leave_application_id->ListViewValue() ?></span>
<input type="hidden" data-field="x_leave_application_id" name="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_leave_application_id" id="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_leave_application_id" value="<?php echo ew_HtmlEncode($tbl_leavecoverage->leave_application_id->FormValue) ?>">
<input type="hidden" data-field="x_leave_application_id" name="o<?php echo $tbl_leavecoverage_grid->RowIndex ?>_leave_application_id" id="o<?php echo $tbl_leavecoverage_grid->RowIndex ?>_leave_application_id" value="<?php echo ew_HtmlEncode($tbl_leavecoverage->leave_application_id->OldValue) ?>">
<?php } ?>
<a id="<?php echo $tbl_leavecoverage_grid->PageObjName . "_row_" . $tbl_leavecoverage_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($tbl_leavecoverage->emp_id->Visible) { // emp_id ?>
		<td<?php echo $tbl_leavecoverage->emp_id->CellAttributes() ?>>
<?php if ($tbl_leavecoverage->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tbl_leavecoverage_grid->RowCnt ?>_tbl_leavecoverage_emp_id" class="control-group tbl_leavecoverage_emp_id">
<?php
	$wrkonchange = trim(" " . @$tbl_leavecoverage->emp_id->EditAttrs["onchange"]);
	if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
	$tbl_leavecoverage->emp_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id" style="white-space: nowrap; z-index: <?php echo (9000 - $tbl_leavecoverage_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id" id="sv_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id" value="<?php echo $tbl_leavecoverage->emp_id->EditValue ?>" size="30" placeholder="<?php echo $tbl_leavecoverage->emp_id->PlaceHolder ?>"<?php echo $tbl_leavecoverage->emp_id->EditAttributes() ?>>&nbsp;<span id="em_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id" class="ewMessage" style="display: none"><?php echo str_replace("%f", "phpimages/", $Language->Phrase("UnmatchedValue")) ?></span>
	<div id="sc_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id" style="display: inline; z-index: <?php echo (9000 - $tbl_leavecoverage_grid->RowCnt * 10) ?>"></div>
</span>
<input type="hidden" data-field="x_emp_id" name="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id" id="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id" value="<?php echo $tbl_leavecoverage->emp_id->CurrentValue ?>"<?php echo $wrkonchange ?>>
<?php
 $sSqlWrk = "SELECT `emp_id`, `empLastName` AS `DispFld`, `empFirstName` AS `Disp2Fld`, `empMiddleName` AS `Disp3Fld` FROM `tbl_employee`";
 $sWhereWrk = "`empLastName` LIKE '{query_value}%' OR CONCAT(`empLastName`,'" . ew_ValueSeparator(1, $Page->emp_id) . "',`empFirstName`,'" . ew_ValueSeparator(2, $Page->emp_id) . "',`empMiddleName`) LIKE '{query_value}%'";

 // Call Lookup selecting
 $tbl_leavecoverage->Lookup_Selecting($tbl_leavecoverage->emp_id, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
?>
<input type="hidden" name="q_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id" id="q_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>">
<script type="text/javascript">
var oas = new ew_AutoSuggest("x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id", ftbl_leavecoveragegrid, false, EW_AUTO_SUGGEST_MAX_ENTRIES);
oas.formatResult = function(ar) {
	var dv = ar[1];
	for (var i = 2; i <= 4; i++)
		dv += (ar[i]) ? ew_ValueSeparator(i - 1, "x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id") + ar[i] : "";
	return dv;
}
ftbl_leavecoveragegrid.AutoSuggests["x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id"] = oas;
</script>
</span>
<input type="hidden" data-field="x_emp_id" name="o<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id" id="o<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id" value="<?php echo ew_HtmlEncode($tbl_leavecoverage->emp_id->OldValue) ?>">
<?php } ?>
<?php if ($tbl_leavecoverage->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tbl_leavecoverage_grid->RowCnt ?>_tbl_leavecoverage_emp_id" class="control-group tbl_leavecoverage_emp_id">
<?php
	$wrkonchange = trim(" " . @$tbl_leavecoverage->emp_id->EditAttrs["onchange"]);
	if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
	$tbl_leavecoverage->emp_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id" style="white-space: nowrap; z-index: <?php echo (9000 - $tbl_leavecoverage_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id" id="sv_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id" value="<?php echo $tbl_leavecoverage->emp_id->EditValue ?>" size="30" placeholder="<?php echo $tbl_leavecoverage->emp_id->PlaceHolder ?>"<?php echo $tbl_leavecoverage->emp_id->EditAttributes() ?>>&nbsp;<span id="em_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id" class="ewMessage" style="display: none"><?php echo str_replace("%f", "phpimages/", $Language->Phrase("UnmatchedValue")) ?></span>
	<div id="sc_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id" style="display: inline; z-index: <?php echo (9000 - $tbl_leavecoverage_grid->RowCnt * 10) ?>"></div>
</span>
<input type="hidden" data-field="x_emp_id" name="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id" id="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id" value="<?php echo $tbl_leavecoverage->emp_id->CurrentValue ?>"<?php echo $wrkonchange ?>>
<?php
 $sSqlWrk = "SELECT `emp_id`, `empLastName` AS `DispFld`, `empFirstName` AS `Disp2Fld`, `empMiddleName` AS `Disp3Fld` FROM `tbl_employee`";
 $sWhereWrk = "`empLastName` LIKE '{query_value}%' OR CONCAT(`empLastName`,'" . ew_ValueSeparator(1, $Page->emp_id) . "',`empFirstName`,'" . ew_ValueSeparator(2, $Page->emp_id) . "',`empMiddleName`) LIKE '{query_value}%'";

 // Call Lookup selecting
 $tbl_leavecoverage->Lookup_Selecting($tbl_leavecoverage->emp_id, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
?>
<input type="hidden" name="q_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id" id="q_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>">
<script type="text/javascript">
var oas = new ew_AutoSuggest("x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id", ftbl_leavecoveragegrid, false, EW_AUTO_SUGGEST_MAX_ENTRIES);
oas.formatResult = function(ar) {
	var dv = ar[1];
	for (var i = 2; i <= 4; i++)
		dv += (ar[i]) ? ew_ValueSeparator(i - 1, "x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id") + ar[i] : "";
	return dv;
}
ftbl_leavecoveragegrid.AutoSuggests["x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id"] = oas;
</script>
</span>
<?php } ?>
<?php if ($tbl_leavecoverage->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $tbl_leavecoverage->emp_id->ViewAttributes() ?>>
<?php echo $tbl_leavecoverage->emp_id->ListViewValue() ?></span>
<input type="hidden" data-field="x_emp_id" name="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id" id="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id" value="<?php echo ew_HtmlEncode($tbl_leavecoverage->emp_id->FormValue) ?>">
<input type="hidden" data-field="x_emp_id" name="o<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id" id="o<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id" value="<?php echo ew_HtmlEncode($tbl_leavecoverage->emp_id->OldValue) ?>">
<?php } ?>
<a id="<?php echo $tbl_leavecoverage_grid->PageObjName . "_row_" . $tbl_leavecoverage_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($tbl_leavecoverage->date_from->Visible) { // date_from ?>
		<td<?php echo $tbl_leavecoverage->date_from->CellAttributes() ?>>
<?php if ($tbl_leavecoverage->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tbl_leavecoverage_grid->RowCnt ?>_tbl_leavecoverage_date_from" class="control-group tbl_leavecoverage_date_from">
<input type="text" data-field="x_date_from" name="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_from" id="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_from" placeholder="<?php echo $tbl_leavecoverage->date_from->PlaceHolder ?>" value="<?php echo $tbl_leavecoverage->date_from->EditValue ?>"<?php echo $tbl_leavecoverage->date_from->EditAttributes() ?>>
<?php if (!$tbl_leavecoverage->date_from->ReadOnly && !$tbl_leavecoverage->date_from->Disabled && @$tbl_leavecoverage->date_from->EditAttrs["readonly"] == "" && @$tbl_leavecoverage->date_from->EditAttrs["disabled"] == "") { ?>
<button id="cal_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_from" name="cal_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_from" class="btn" type="button"><img src="phpimages/calendar.png" id="cal_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_from" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" style="border: 0;"></button><script type="text/javascript">
ew_CreateCalendar("ftbl_leavecoveragegrid", "x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_from", "%Y/%m/%d");
</script>
<?php } ?>
</span>
<input type="hidden" data-field="x_date_from" name="o<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_from" id="o<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_from" value="<?php echo ew_HtmlEncode($tbl_leavecoverage->date_from->OldValue) ?>">
<?php } ?>
<?php if ($tbl_leavecoverage->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tbl_leavecoverage_grid->RowCnt ?>_tbl_leavecoverage_date_from" class="control-group tbl_leavecoverage_date_from">
<input type="text" data-field="x_date_from" name="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_from" id="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_from" placeholder="<?php echo $tbl_leavecoverage->date_from->PlaceHolder ?>" value="<?php echo $tbl_leavecoverage->date_from->EditValue ?>"<?php echo $tbl_leavecoverage->date_from->EditAttributes() ?>>
<?php if (!$tbl_leavecoverage->date_from->ReadOnly && !$tbl_leavecoverage->date_from->Disabled && @$tbl_leavecoverage->date_from->EditAttrs["readonly"] == "" && @$tbl_leavecoverage->date_from->EditAttrs["disabled"] == "") { ?>
<button id="cal_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_from" name="cal_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_from" class="btn" type="button"><img src="phpimages/calendar.png" id="cal_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_from" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" style="border: 0;"></button><script type="text/javascript">
ew_CreateCalendar("ftbl_leavecoveragegrid", "x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_from", "%Y/%m/%d");
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($tbl_leavecoverage->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $tbl_leavecoverage->date_from->ViewAttributes() ?>>
<?php echo $tbl_leavecoverage->date_from->ListViewValue() ?></span>
<input type="hidden" data-field="x_date_from" name="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_from" id="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_from" value="<?php echo ew_HtmlEncode($tbl_leavecoverage->date_from->FormValue) ?>">
<input type="hidden" data-field="x_date_from" name="o<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_from" id="o<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_from" value="<?php echo ew_HtmlEncode($tbl_leavecoverage->date_from->OldValue) ?>">
<?php } ?>
<a id="<?php echo $tbl_leavecoverage_grid->PageObjName . "_row_" . $tbl_leavecoverage_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($tbl_leavecoverage->date_to->Visible) { // date_to ?>
		<td<?php echo $tbl_leavecoverage->date_to->CellAttributes() ?>>
<?php if ($tbl_leavecoverage->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tbl_leavecoverage_grid->RowCnt ?>_tbl_leavecoverage_date_to" class="control-group tbl_leavecoverage_date_to">
<input type="text" data-field="x_date_to" name="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_to" id="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_to" placeholder="<?php echo $tbl_leavecoverage->date_to->PlaceHolder ?>" value="<?php echo $tbl_leavecoverage->date_to->EditValue ?>"<?php echo $tbl_leavecoverage->date_to->EditAttributes() ?>>
<?php if (!$tbl_leavecoverage->date_to->ReadOnly && !$tbl_leavecoverage->date_to->Disabled && @$tbl_leavecoverage->date_to->EditAttrs["readonly"] == "" && @$tbl_leavecoverage->date_to->EditAttrs["disabled"] == "") { ?>
<button id="cal_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_to" name="cal_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_to" class="btn" type="button"><img src="phpimages/calendar.png" id="cal_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_to" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" style="border: 0;"></button><script type="text/javascript">
ew_CreateCalendar("ftbl_leavecoveragegrid", "x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_to", "%Y/%m/%d");
</script>
<?php } ?>
</span>
<input type="hidden" data-field="x_date_to" name="o<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_to" id="o<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_to" value="<?php echo ew_HtmlEncode($tbl_leavecoverage->date_to->OldValue) ?>">
<?php } ?>
<?php if ($tbl_leavecoverage->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tbl_leavecoverage_grid->RowCnt ?>_tbl_leavecoverage_date_to" class="control-group tbl_leavecoverage_date_to">
<input type="text" data-field="x_date_to" name="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_to" id="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_to" placeholder="<?php echo $tbl_leavecoverage->date_to->PlaceHolder ?>" value="<?php echo $tbl_leavecoverage->date_to->EditValue ?>"<?php echo $tbl_leavecoverage->date_to->EditAttributes() ?>>
<?php if (!$tbl_leavecoverage->date_to->ReadOnly && !$tbl_leavecoverage->date_to->Disabled && @$tbl_leavecoverage->date_to->EditAttrs["readonly"] == "" && @$tbl_leavecoverage->date_to->EditAttrs["disabled"] == "") { ?>
<button id="cal_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_to" name="cal_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_to" class="btn" type="button"><img src="phpimages/calendar.png" id="cal_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_to" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" style="border: 0;"></button><script type="text/javascript">
ew_CreateCalendar("ftbl_leavecoveragegrid", "x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_to", "%Y/%m/%d");
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($tbl_leavecoverage->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $tbl_leavecoverage->date_to->ViewAttributes() ?>>
<?php echo $tbl_leavecoverage->date_to->ListViewValue() ?></span>
<input type="hidden" data-field="x_date_to" name="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_to" id="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_to" value="<?php echo ew_HtmlEncode($tbl_leavecoverage->date_to->FormValue) ?>">
<input type="hidden" data-field="x_date_to" name="o<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_to" id="o<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_to" value="<?php echo ew_HtmlEncode($tbl_leavecoverage->date_to->OldValue) ?>">
<?php } ?>
<a id="<?php echo $tbl_leavecoverage_grid->PageObjName . "_row_" . $tbl_leavecoverage_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$tbl_leavecoverage_grid->ListOptions->Render("body", "right", $tbl_leavecoverage_grid->RowCnt);
?>
	</tr>
<?php if ($tbl_leavecoverage->RowType == EW_ROWTYPE_ADD || $tbl_leavecoverage->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ftbl_leavecoveragegrid.UpdateOpts(<?php echo $tbl_leavecoverage_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($tbl_leavecoverage->CurrentAction <> "gridadd" || $tbl_leavecoverage->CurrentMode == "copy")
		if (!$tbl_leavecoverage_grid->Recordset->EOF) $tbl_leavecoverage_grid->Recordset->MoveNext();
}
?>
<?php
	if ($tbl_leavecoverage->CurrentMode == "add" || $tbl_leavecoverage->CurrentMode == "copy" || $tbl_leavecoverage->CurrentMode == "edit") {
		$tbl_leavecoverage_grid->RowIndex = '$rowindex$';
		$tbl_leavecoverage_grid->LoadDefaultValues();

		// Set row properties
		$tbl_leavecoverage->ResetAttrs();
		$tbl_leavecoverage->RowAttrs = array_merge($tbl_leavecoverage->RowAttrs, array('data-rowindex'=>$tbl_leavecoverage_grid->RowIndex, 'id'=>'r0_tbl_leavecoverage', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($tbl_leavecoverage->RowAttrs["class"], "ewTemplate");
		$tbl_leavecoverage->RowType = EW_ROWTYPE_ADD;

		// Render row
		$tbl_leavecoverage_grid->RenderRow();

		// Render list options
		$tbl_leavecoverage_grid->RenderListOptions();
		$tbl_leavecoverage_grid->StartRowCnt = 0;
?>
	<tr<?php echo $tbl_leavecoverage->RowAttributes() ?>>
<?php

// Render list options (body, left)
$tbl_leavecoverage_grid->ListOptions->Render("body", "left", $tbl_leavecoverage_grid->RowIndex);
?>
	<?php if ($tbl_leavecoverage->leave_coverage_id->Visible) { // leave_coverage_id ?>
		<td>
<?php if ($tbl_leavecoverage->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_tbl_leavecoverage_leave_coverage_id" class="control-group tbl_leavecoverage_leave_coverage_id">
<span<?php echo $tbl_leavecoverage->leave_coverage_id->ViewAttributes() ?>>
<?php echo $tbl_leavecoverage->leave_coverage_id->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_leave_coverage_id" name="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_leave_coverage_id" id="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_leave_coverage_id" value="<?php echo ew_HtmlEncode($tbl_leavecoverage->leave_coverage_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_leave_coverage_id" name="o<?php echo $tbl_leavecoverage_grid->RowIndex ?>_leave_coverage_id" id="o<?php echo $tbl_leavecoverage_grid->RowIndex ?>_leave_coverage_id" value="<?php echo ew_HtmlEncode($tbl_leavecoverage->leave_coverage_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tbl_leavecoverage->leave_application_id->Visible) { // leave_application_id ?>
		<td>
<?php if ($tbl_leavecoverage->CurrentAction <> "F") { ?>
<?php if ($tbl_leavecoverage->leave_application_id->getSessionValue() <> "") { ?>
<span<?php echo $tbl_leavecoverage->leave_application_id->ViewAttributes() ?>>
<?php echo $tbl_leavecoverage->leave_application_id->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_leave_application_id" name="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_leave_application_id" value="<?php echo ew_HtmlEncode($tbl_leavecoverage->leave_application_id->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_leave_application_id" name="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_leave_application_id" id="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_leave_application_id" size="30" placeholder="<?php echo $tbl_leavecoverage->leave_application_id->PlaceHolder ?>" value="<?php echo $tbl_leavecoverage->leave_application_id->EditValue ?>"<?php echo $tbl_leavecoverage->leave_application_id->EditAttributes() ?>>
<?php } ?>
<?php } else { ?>
<span<?php echo $tbl_leavecoverage->leave_application_id->ViewAttributes() ?>>
<?php echo $tbl_leavecoverage->leave_application_id->ViewValue ?></span>
<input type="hidden" data-field="x_leave_application_id" name="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_leave_application_id" id="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_leave_application_id" value="<?php echo ew_HtmlEncode($tbl_leavecoverage->leave_application_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_leave_application_id" name="o<?php echo $tbl_leavecoverage_grid->RowIndex ?>_leave_application_id" id="o<?php echo $tbl_leavecoverage_grid->RowIndex ?>_leave_application_id" value="<?php echo ew_HtmlEncode($tbl_leavecoverage->leave_application_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tbl_leavecoverage->emp_id->Visible) { // emp_id ?>
		<td>
<?php if ($tbl_leavecoverage->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tbl_leavecoverage_emp_id" class="control-group tbl_leavecoverage_emp_id">
<?php
	$wrkonchange = trim(" " . @$tbl_leavecoverage->emp_id->EditAttrs["onchange"]);
	if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
	$tbl_leavecoverage->emp_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id" style="white-space: nowrap; z-index: <?php echo (9000 - $tbl_leavecoverage_grid->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id" id="sv_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id" value="<?php echo $tbl_leavecoverage->emp_id->EditValue ?>" size="30" placeholder="<?php echo $tbl_leavecoverage->emp_id->PlaceHolder ?>"<?php echo $tbl_leavecoverage->emp_id->EditAttributes() ?>>&nbsp;<span id="em_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id" class="ewMessage" style="display: none"><?php echo str_replace("%f", "phpimages/", $Language->Phrase("UnmatchedValue")) ?></span>
	<div id="sc_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id" style="display: inline; z-index: <?php echo (9000 - $tbl_leavecoverage_grid->RowCnt * 10) ?>"></div>
</span>
<input type="hidden" data-field="x_emp_id" name="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id" id="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id" value="<?php echo $tbl_leavecoverage->emp_id->CurrentValue ?>"<?php echo $wrkonchange ?>>
<?php
 $sSqlWrk = "SELECT `emp_id`, `empLastName` AS `DispFld`, `empFirstName` AS `Disp2Fld`, `empMiddleName` AS `Disp3Fld` FROM `tbl_employee`";
 $sWhereWrk = "`empLastName` LIKE '{query_value}%' OR CONCAT(`empLastName`,'" . ew_ValueSeparator(1, $Page->emp_id) . "',`empFirstName`,'" . ew_ValueSeparator(2, $Page->emp_id) . "',`empMiddleName`) LIKE '{query_value}%'";

 // Call Lookup selecting
 $tbl_leavecoverage->Lookup_Selecting($tbl_leavecoverage->emp_id, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
?>
<input type="hidden" name="q_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id" id="q_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>">
<script type="text/javascript">
var oas = new ew_AutoSuggest("x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id", ftbl_leavecoveragegrid, false, EW_AUTO_SUGGEST_MAX_ENTRIES);
oas.formatResult = function(ar) {
	var dv = ar[1];
	for (var i = 2; i <= 4; i++)
		dv += (ar[i]) ? ew_ValueSeparator(i - 1, "x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id") + ar[i] : "";
	return dv;
}
ftbl_leavecoveragegrid.AutoSuggests["x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id"] = oas;
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_tbl_leavecoverage_emp_id" class="control-group tbl_leavecoverage_emp_id">
<span<?php echo $tbl_leavecoverage->emp_id->ViewAttributes() ?>>
<?php echo $tbl_leavecoverage->emp_id->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_emp_id" name="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id" id="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id" value="<?php echo ew_HtmlEncode($tbl_leavecoverage->emp_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_emp_id" name="o<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id" id="o<?php echo $tbl_leavecoverage_grid->RowIndex ?>_emp_id" value="<?php echo ew_HtmlEncode($tbl_leavecoverage->emp_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tbl_leavecoverage->date_from->Visible) { // date_from ?>
		<td>
<?php if ($tbl_leavecoverage->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tbl_leavecoverage_date_from" class="control-group tbl_leavecoverage_date_from">
<input type="text" data-field="x_date_from" name="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_from" id="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_from" placeholder="<?php echo $tbl_leavecoverage->date_from->PlaceHolder ?>" value="<?php echo $tbl_leavecoverage->date_from->EditValue ?>"<?php echo $tbl_leavecoverage->date_from->EditAttributes() ?>>
<?php if (!$tbl_leavecoverage->date_from->ReadOnly && !$tbl_leavecoverage->date_from->Disabled && @$tbl_leavecoverage->date_from->EditAttrs["readonly"] == "" && @$tbl_leavecoverage->date_from->EditAttrs["disabled"] == "") { ?>
<button id="cal_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_from" name="cal_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_from" class="btn" type="button"><img src="phpimages/calendar.png" id="cal_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_from" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" style="border: 0;"></button><script type="text/javascript">
ew_CreateCalendar("ftbl_leavecoveragegrid", "x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_from", "%Y/%m/%d");
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_tbl_leavecoverage_date_from" class="control-group tbl_leavecoverage_date_from">
<span<?php echo $tbl_leavecoverage->date_from->ViewAttributes() ?>>
<?php echo $tbl_leavecoverage->date_from->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_date_from" name="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_from" id="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_from" value="<?php echo ew_HtmlEncode($tbl_leavecoverage->date_from->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_date_from" name="o<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_from" id="o<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_from" value="<?php echo ew_HtmlEncode($tbl_leavecoverage->date_from->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tbl_leavecoverage->date_to->Visible) { // date_to ?>
		<td>
<?php if ($tbl_leavecoverage->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tbl_leavecoverage_date_to" class="control-group tbl_leavecoverage_date_to">
<input type="text" data-field="x_date_to" name="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_to" id="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_to" placeholder="<?php echo $tbl_leavecoverage->date_to->PlaceHolder ?>" value="<?php echo $tbl_leavecoverage->date_to->EditValue ?>"<?php echo $tbl_leavecoverage->date_to->EditAttributes() ?>>
<?php if (!$tbl_leavecoverage->date_to->ReadOnly && !$tbl_leavecoverage->date_to->Disabled && @$tbl_leavecoverage->date_to->EditAttrs["readonly"] == "" && @$tbl_leavecoverage->date_to->EditAttrs["disabled"] == "") { ?>
<button id="cal_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_to" name="cal_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_to" class="btn" type="button"><img src="phpimages/calendar.png" id="cal_x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_to" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" style="border: 0;"></button><script type="text/javascript">
ew_CreateCalendar("ftbl_leavecoveragegrid", "x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_to", "%Y/%m/%d");
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_tbl_leavecoverage_date_to" class="control-group tbl_leavecoverage_date_to">
<span<?php echo $tbl_leavecoverage->date_to->ViewAttributes() ?>>
<?php echo $tbl_leavecoverage->date_to->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_date_to" name="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_to" id="x<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_to" value="<?php echo ew_HtmlEncode($tbl_leavecoverage->date_to->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_date_to" name="o<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_to" id="o<?php echo $tbl_leavecoverage_grid->RowIndex ?>_date_to" value="<?php echo ew_HtmlEncode($tbl_leavecoverage->date_to->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$tbl_leavecoverage_grid->ListOptions->Render("body", "right", $tbl_leavecoverage_grid->RowCnt);
?>
<script type="text/javascript">
ftbl_leavecoveragegrid.UpdateOpts(<?php echo $tbl_leavecoverage_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($tbl_leavecoverage->CurrentMode == "add" || $tbl_leavecoverage->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $tbl_leavecoverage_grid->FormKeyCountName ?>" id="<?php echo $tbl_leavecoverage_grid->FormKeyCountName ?>" value="<?php echo $tbl_leavecoverage_grid->KeyCount ?>">
<?php echo $tbl_leavecoverage_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($tbl_leavecoverage->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $tbl_leavecoverage_grid->FormKeyCountName ?>" id="<?php echo $tbl_leavecoverage_grid->FormKeyCountName ?>" value="<?php echo $tbl_leavecoverage_grid->KeyCount ?>">
<?php echo $tbl_leavecoverage_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($tbl_leavecoverage->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ftbl_leavecoveragegrid">
</div>
<?php

// Close recordset
if ($tbl_leavecoverage_grid->Recordset)
	$tbl_leavecoverage_grid->Recordset->Close();
?>
<?php if ($tbl_leavecoverage_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel ewListOtherOptions">
<?php
	foreach ($tbl_leavecoverage_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<?php } ?>
</div>
</td></tr></table>
<?php if ($tbl_leavecoverage->Export == "") { ?>
<script type="text/javascript">
ftbl_leavecoveragegrid.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$tbl_leavecoverage_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$tbl_leavecoverage_grid->Page_Terminate();
?>
