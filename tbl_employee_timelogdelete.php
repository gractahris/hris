<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "tbl_employee_timeloginfo.php" ?>
<?php include_once "tbl_userinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$tbl_employee_timelog_delete = NULL; // Initialize page object first

class ctbl_employee_timelog_delete extends ctbl_employee_timelog {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}";

	// Table name
	var $TableName = 'tbl_employee_timelog';

	// Page object name
	var $PageObjName = 'tbl_employee_timelog_delete';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}
	var $AuditTrailOnDelete = TRUE;

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-error ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<table class=\"ewStdTable\"><tr><td><div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div></td></tr></table>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language, $UserAgent;

		// User agent
		$UserAgent = ew_UserAgent();
		$GLOBALS["Page"] = &$this;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (tbl_employee_timelog)
		if (!isset($GLOBALS["tbl_employee_timelog"])) {
			$GLOBALS["tbl_employee_timelog"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbl_employee_timelog"];
		}

		// Table object (tbl_user)
		if (!isset($GLOBALS['tbl_user'])) $GLOBALS['tbl_user'] = new ctbl_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_employee_timelog', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
		$Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		$Security->TablePermission_Loaded();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("tbl_employee_timeloglist.php");
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up curent action
		$this->ref_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();
		$this->Page_Redirecting($url);

		 // Close connection
		$conn->Close();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("tbl_employee_timeloglist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in tbl_employee_timelog class, tbl_employee_timeloginfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		switch ($this->CurrentAction) {
			case "D": // Delete
				$this->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // Delete rows
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($this->getReturnUrl()); // Return to caller
				}
		}
	}

// No functions
	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn;

		// Call Recordset Selecting event
		$this->Recordset_Selecting($this->CurrentFilter);

		// Load List page SQL
		$sSql = $this->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn;
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->ref_id->setDbValue($rs->fields('ref_id'));
		$this->emp_id->setDbValue($rs->fields('emp_id'));
		$this->emp_datelog->setDbValue($rs->fields('emp_datelog'));
		$this->emp_timein->setDbValue($rs->fields('emp_timein'));
		$this->emp_timeout->setDbValue($rs->fields('emp_timeout'));
		$this->emp_totalhours->setDbValue($rs->fields('emp_totalhours'));
		$this->emp_late->setDbValue($rs->fields('emp_late'));
		$this->emp_excesstime->setDbValue($rs->fields('emp_excesstime'));
		$this->emp_undertime->setDbValue($rs->fields('emp_undertime'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->ref_id->DbValue = $row['ref_id'];
		$this->emp_id->DbValue = $row['emp_id'];
		$this->emp_datelog->DbValue = $row['emp_datelog'];
		$this->emp_timein->DbValue = $row['emp_timein'];
		$this->emp_timeout->DbValue = $row['emp_timeout'];
		$this->emp_totalhours->DbValue = $row['emp_totalhours'];
		$this->emp_late->DbValue = $row['emp_late'];
		$this->emp_excesstime->DbValue = $row['emp_excesstime'];
		$this->emp_undertime->DbValue = $row['emp_undertime'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// ref_id
		// emp_id
		// emp_datelog
		// emp_timein
		// emp_timeout
		// emp_totalhours
		// emp_late
		// emp_excesstime
		// emp_undertime

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// ref_id
			$this->ref_id->ViewValue = $this->ref_id->CurrentValue;
			$this->ref_id->ViewCustomAttributes = "";

			// emp_id
			$this->emp_id->ViewValue = $this->emp_id->CurrentValue;
			$this->emp_id->ViewCustomAttributes = "";

			// emp_datelog
			$this->emp_datelog->ViewValue = $this->emp_datelog->CurrentValue;
			$this->emp_datelog->ViewValue = ew_FormatDateTime($this->emp_datelog->ViewValue, 5);
			$this->emp_datelog->ViewCustomAttributes = "";

			// emp_timein
			$this->emp_timein->ViewValue = $this->emp_timein->CurrentValue;
			$this->emp_timein->ViewCustomAttributes = "";

			// emp_timeout
			$this->emp_timeout->ViewValue = $this->emp_timeout->CurrentValue;
			$this->emp_timeout->ViewCustomAttributes = "";

			// emp_totalhours
			$this->emp_totalhours->ViewValue = $this->emp_totalhours->CurrentValue;
			$this->emp_totalhours->ViewCustomAttributes = "";

			// emp_late
			$this->emp_late->ViewValue = $this->emp_late->CurrentValue;
			$this->emp_late->ViewCustomAttributes = "";

			// emp_excesstime
			$this->emp_excesstime->ViewValue = $this->emp_excesstime->CurrentValue;
			$this->emp_excesstime->ViewCustomAttributes = "";

			// emp_undertime
			$this->emp_undertime->ViewValue = $this->emp_undertime->CurrentValue;
			$this->emp_undertime->ViewCustomAttributes = "";

			// ref_id
			$this->ref_id->LinkCustomAttributes = "";
			$this->ref_id->HrefValue = "";
			$this->ref_id->TooltipValue = "";

			// emp_id
			$this->emp_id->LinkCustomAttributes = "";
			$this->emp_id->HrefValue = "";
			$this->emp_id->TooltipValue = "";

			// emp_datelog
			$this->emp_datelog->LinkCustomAttributes = "";
			$this->emp_datelog->HrefValue = "";
			$this->emp_datelog->TooltipValue = "";

			// emp_timein
			$this->emp_timein->LinkCustomAttributes = "";
			$this->emp_timein->HrefValue = "";
			$this->emp_timein->TooltipValue = "";

			// emp_timeout
			$this->emp_timeout->LinkCustomAttributes = "";
			$this->emp_timeout->HrefValue = "";
			$this->emp_timeout->TooltipValue = "";

			// emp_totalhours
			$this->emp_totalhours->LinkCustomAttributes = "";
			$this->emp_totalhours->HrefValue = "";
			$this->emp_totalhours->TooltipValue = "";

			// emp_late
			$this->emp_late->LinkCustomAttributes = "";
			$this->emp_late->HrefValue = "";
			$this->emp_late->TooltipValue = "";

			// emp_excesstime
			$this->emp_excesstime->LinkCustomAttributes = "";
			$this->emp_excesstime->HrefValue = "";
			$this->emp_excesstime->TooltipValue = "";

			// emp_undertime
			$this->emp_undertime->LinkCustomAttributes = "";
			$this->emp_undertime->HrefValue = "";
			$this->emp_undertime->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$conn->BeginTrans();
		if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteBegin")); // Batch delete begin

		// Clone old rows
		$rsold = ($rs) ? $rs->GetRows() : array();
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['ref_id'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
			if ($DeleteRows) {
				foreach ($rsold as $row)
					$this->WriteAuditTrailOnDelete($row);
			}
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteSuccess")); // Batch delete success
		} else {
			$conn->RollbackTrans(); // Rollback changes
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteRollback")); // Batch delete rollback
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "tbl_employee_timeloglist.php", $this->TableVar);
		$PageCaption = $Language->Phrase("delete");
		$Breadcrumb->Add("delete", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", ew_CurrentUrl(), $this->TableVar);
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'tbl_employee_timelog';
	  $usr = CurrentUserName();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (delete page)
	function WriteAuditTrailOnDelete(&$rs) {
		if (!$this->AuditTrailOnDelete) return;
		$table = 'tbl_employee_timelog';

		// Get key value
		$key = "";
		if ($key <> "")
			$key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['ref_id'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
	  $curUser = CurrentUserName();
		foreach (array_keys($rs) as $fldname) {
			if (array_key_exists($fldname, $this->fields) && $this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) {
					if (EW_AUDIT_TRAIL_TO_DATABASE)
						$oldvalue = $rs[$fldname];
					else
						$oldvalue = "[MEMO]"; // Memo field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) {
					$oldvalue = "[XML]"; // XML field
				} else {
					$oldvalue = $rs[$fldname];
				}
				ew_WriteAuditTrail("log", $dt, $id, $curUser, "D", $table, $fldname, $key, $oldvalue, "");
			}
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($tbl_employee_timelog_delete)) $tbl_employee_timelog_delete = new ctbl_employee_timelog_delete();

// Page init
$tbl_employee_timelog_delete->Page_Init();

// Page main
$tbl_employee_timelog_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tbl_employee_timelog_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var tbl_employee_timelog_delete = new ew_Page("tbl_employee_timelog_delete");
tbl_employee_timelog_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = tbl_employee_timelog_delete.PageID; // For backward compatibility

// Form object
var ftbl_employee_timelogdelete = new ew_Form("ftbl_employee_timelogdelete");

// Form_CustomValidate event
ftbl_employee_timelogdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_employee_timelogdelete.ValidateRequired = true;
<?php } else { ?>
ftbl_employee_timelogdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($tbl_employee_timelog_delete->Recordset = $tbl_employee_timelog_delete->LoadRecordset())
	$tbl_employee_timelog_deleteTotalRecs = $tbl_employee_timelog_delete->Recordset->RecordCount(); // Get record count
if ($tbl_employee_timelog_deleteTotalRecs <= 0) { // No record found, exit
	if ($tbl_employee_timelog_delete->Recordset)
		$tbl_employee_timelog_delete->Recordset->Close();
	$tbl_employee_timelog_delete->Page_Terminate("tbl_employee_timeloglist.php"); // Return to list
}
?>
<?php $Breadcrumb->Render(); ?>
<?php $tbl_employee_timelog_delete->ShowPageHeader(); ?>
<?php
$tbl_employee_timelog_delete->ShowMessage();
?>
<form name="ftbl_employee_timelogdelete" id="ftbl_employee_timelogdelete" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="tbl_employee_timelog">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($tbl_employee_timelog_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_tbl_employee_timelogdelete" class="ewTable ewTableSeparate">
<?php echo $tbl_employee_timelog->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($tbl_employee_timelog->ref_id->Visible) { // ref_id ?>
		<td><span id="elh_tbl_employee_timelog_ref_id" class="tbl_employee_timelog_ref_id"><?php echo $tbl_employee_timelog->ref_id->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_employee_timelog->emp_id->Visible) { // emp_id ?>
		<td><span id="elh_tbl_employee_timelog_emp_id" class="tbl_employee_timelog_emp_id"><?php echo $tbl_employee_timelog->emp_id->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_employee_timelog->emp_datelog->Visible) { // emp_datelog ?>
		<td><span id="elh_tbl_employee_timelog_emp_datelog" class="tbl_employee_timelog_emp_datelog"><?php echo $tbl_employee_timelog->emp_datelog->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_employee_timelog->emp_timein->Visible) { // emp_timein ?>
		<td><span id="elh_tbl_employee_timelog_emp_timein" class="tbl_employee_timelog_emp_timein"><?php echo $tbl_employee_timelog->emp_timein->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_employee_timelog->emp_timeout->Visible) { // emp_timeout ?>
		<td><span id="elh_tbl_employee_timelog_emp_timeout" class="tbl_employee_timelog_emp_timeout"><?php echo $tbl_employee_timelog->emp_timeout->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_employee_timelog->emp_totalhours->Visible) { // emp_totalhours ?>
		<td><span id="elh_tbl_employee_timelog_emp_totalhours" class="tbl_employee_timelog_emp_totalhours"><?php echo $tbl_employee_timelog->emp_totalhours->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_employee_timelog->emp_late->Visible) { // emp_late ?>
		<td><span id="elh_tbl_employee_timelog_emp_late" class="tbl_employee_timelog_emp_late"><?php echo $tbl_employee_timelog->emp_late->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_employee_timelog->emp_excesstime->Visible) { // emp_excesstime ?>
		<td><span id="elh_tbl_employee_timelog_emp_excesstime" class="tbl_employee_timelog_emp_excesstime"><?php echo $tbl_employee_timelog->emp_excesstime->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_employee_timelog->emp_undertime->Visible) { // emp_undertime ?>
		<td><span id="elh_tbl_employee_timelog_emp_undertime" class="tbl_employee_timelog_emp_undertime"><?php echo $tbl_employee_timelog->emp_undertime->FldCaption() ?></span></td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$tbl_employee_timelog_delete->RecCnt = 0;
$i = 0;
while (!$tbl_employee_timelog_delete->Recordset->EOF) {
	$tbl_employee_timelog_delete->RecCnt++;
	$tbl_employee_timelog_delete->RowCnt++;

	// Set row properties
	$tbl_employee_timelog->ResetAttrs();
	$tbl_employee_timelog->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$tbl_employee_timelog_delete->LoadRowValues($tbl_employee_timelog_delete->Recordset);

	// Render row
	$tbl_employee_timelog_delete->RenderRow();
?>
	<tr<?php echo $tbl_employee_timelog->RowAttributes() ?>>
<?php if ($tbl_employee_timelog->ref_id->Visible) { // ref_id ?>
		<td<?php echo $tbl_employee_timelog->ref_id->CellAttributes() ?>>
<span id="el<?php echo $tbl_employee_timelog_delete->RowCnt ?>_tbl_employee_timelog_ref_id" class="control-group tbl_employee_timelog_ref_id">
<span<?php echo $tbl_employee_timelog->ref_id->ViewAttributes() ?>>
<?php echo $tbl_employee_timelog->ref_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_employee_timelog->emp_id->Visible) { // emp_id ?>
		<td<?php echo $tbl_employee_timelog->emp_id->CellAttributes() ?>>
<span id="el<?php echo $tbl_employee_timelog_delete->RowCnt ?>_tbl_employee_timelog_emp_id" class="control-group tbl_employee_timelog_emp_id">
<span<?php echo $tbl_employee_timelog->emp_id->ViewAttributes() ?>>
<?php echo $tbl_employee_timelog->emp_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_employee_timelog->emp_datelog->Visible) { // emp_datelog ?>
		<td<?php echo $tbl_employee_timelog->emp_datelog->CellAttributes() ?>>
<span id="el<?php echo $tbl_employee_timelog_delete->RowCnt ?>_tbl_employee_timelog_emp_datelog" class="control-group tbl_employee_timelog_emp_datelog">
<span<?php echo $tbl_employee_timelog->emp_datelog->ViewAttributes() ?>>
<?php echo $tbl_employee_timelog->emp_datelog->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_employee_timelog->emp_timein->Visible) { // emp_timein ?>
		<td<?php echo $tbl_employee_timelog->emp_timein->CellAttributes() ?>>
<span id="el<?php echo $tbl_employee_timelog_delete->RowCnt ?>_tbl_employee_timelog_emp_timein" class="control-group tbl_employee_timelog_emp_timein">
<span<?php echo $tbl_employee_timelog->emp_timein->ViewAttributes() ?>>
<?php echo $tbl_employee_timelog->emp_timein->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_employee_timelog->emp_timeout->Visible) { // emp_timeout ?>
		<td<?php echo $tbl_employee_timelog->emp_timeout->CellAttributes() ?>>
<span id="el<?php echo $tbl_employee_timelog_delete->RowCnt ?>_tbl_employee_timelog_emp_timeout" class="control-group tbl_employee_timelog_emp_timeout">
<span<?php echo $tbl_employee_timelog->emp_timeout->ViewAttributes() ?>>
<?php echo $tbl_employee_timelog->emp_timeout->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_employee_timelog->emp_totalhours->Visible) { // emp_totalhours ?>
		<td<?php echo $tbl_employee_timelog->emp_totalhours->CellAttributes() ?>>
<span id="el<?php echo $tbl_employee_timelog_delete->RowCnt ?>_tbl_employee_timelog_emp_totalhours" class="control-group tbl_employee_timelog_emp_totalhours">
<span<?php echo $tbl_employee_timelog->emp_totalhours->ViewAttributes() ?>>
<?php echo $tbl_employee_timelog->emp_totalhours->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_employee_timelog->emp_late->Visible) { // emp_late ?>
		<td<?php echo $tbl_employee_timelog->emp_late->CellAttributes() ?>>
<span id="el<?php echo $tbl_employee_timelog_delete->RowCnt ?>_tbl_employee_timelog_emp_late" class="control-group tbl_employee_timelog_emp_late">
<span<?php echo $tbl_employee_timelog->emp_late->ViewAttributes() ?>>
<?php echo $tbl_employee_timelog->emp_late->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_employee_timelog->emp_excesstime->Visible) { // emp_excesstime ?>
		<td<?php echo $tbl_employee_timelog->emp_excesstime->CellAttributes() ?>>
<span id="el<?php echo $tbl_employee_timelog_delete->RowCnt ?>_tbl_employee_timelog_emp_excesstime" class="control-group tbl_employee_timelog_emp_excesstime">
<span<?php echo $tbl_employee_timelog->emp_excesstime->ViewAttributes() ?>>
<?php echo $tbl_employee_timelog->emp_excesstime->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_employee_timelog->emp_undertime->Visible) { // emp_undertime ?>
		<td<?php echo $tbl_employee_timelog->emp_undertime->CellAttributes() ?>>
<span id="el<?php echo $tbl_employee_timelog_delete->RowCnt ?>_tbl_employee_timelog_emp_undertime" class="control-group tbl_employee_timelog_emp_undertime">
<span<?php echo $tbl_employee_timelog->emp_undertime->ViewAttributes() ?>>
<?php echo $tbl_employee_timelog->emp_undertime->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$tbl_employee_timelog_delete->Recordset->MoveNext();
}
$tbl_employee_timelog_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<div class="btn-group ewButtonGroup">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ftbl_employee_timelogdelete.Init();
</script>
<?php
$tbl_employee_timelog_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_employee_timelog_delete->Page_Terminate();
?>
