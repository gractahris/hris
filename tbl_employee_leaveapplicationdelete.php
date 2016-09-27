<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "tbl_employee_leaveapplicationinfo.php" ?>
<?php include_once "tbl_userinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$tbl_employee_leaveapplication_delete = NULL; // Initialize page object first

class ctbl_employee_leaveapplication_delete extends ctbl_employee_leaveapplication {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}";

	// Table name
	var $TableName = 'tbl_employee_leaveapplication';

	// Page object name
	var $PageObjName = 'tbl_employee_leaveapplication_delete';

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

		// Table object (tbl_employee_leaveapplication)
		if (!isset($GLOBALS["tbl_employee_leaveapplication"])) {
			$GLOBALS["tbl_employee_leaveapplication"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbl_employee_leaveapplication"];
		}

		// Table object (tbl_user)
		if (!isset($GLOBALS['tbl_user'])) $GLOBALS['tbl_user'] = new ctbl_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_employee_leaveapplication', TRUE);

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
			$this->Page_Terminate("tbl_employee_leaveapplicationlist.php");
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up curent action
		$this->leave_application_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
			$this->Page_Terminate("tbl_employee_leaveapplicationlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in tbl_employee_leaveapplication class, tbl_employee_leaveapplicationinfo.php

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
		$this->leave_application_id->setDbValue($rs->fields('leave_application_id'));
		$this->emp_id->setDbValue($rs->fields('emp_id'));
		$this->leave_type_id->setDbValue($rs->fields('leave_type_id'));
		$this->sickness->setDbValue($rs->fields('sickness'));
		$this->place_to_visit->setDbValue($rs->fields('place_to_visit'));
		$this->days_to_leave->setDbValue($rs->fields('days_to_leave'));
		$this->status_id->setDbValue($rs->fields('status_id'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->leave_application_id->DbValue = $row['leave_application_id'];
		$this->emp_id->DbValue = $row['emp_id'];
		$this->leave_type_id->DbValue = $row['leave_type_id'];
		$this->sickness->DbValue = $row['sickness'];
		$this->place_to_visit->DbValue = $row['place_to_visit'];
		$this->days_to_leave->DbValue = $row['days_to_leave'];
		$this->status_id->DbValue = $row['status_id'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// leave_application_id
		// emp_id
		// leave_type_id
		// sickness
		// place_to_visit
		// days_to_leave
		// status_id

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// leave_application_id
			$this->leave_application_id->ViewValue = $this->leave_application_id->CurrentValue;
			$this->leave_application_id->ViewCustomAttributes = "";

			// emp_id
			$this->emp_id->ViewValue = $this->emp_id->CurrentValue;
			if (strval($this->emp_id->CurrentValue) <> "") {
				$sFilterWrk = "`emp_id`" . ew_SearchString("=", $this->emp_id->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `emp_id`, `empLastName` AS `DispFld`, `empFirstName` AS `Disp2Fld`, `empMiddleName` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tbl_employee`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->emp_id, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->emp_id->ViewValue = $rswrk->fields('DispFld');
					$this->emp_id->ViewValue .= ew_ValueSeparator(1,$this->emp_id) . $rswrk->fields('Disp2Fld');
					$this->emp_id->ViewValue .= ew_ValueSeparator(2,$this->emp_id) . $rswrk->fields('Disp3Fld');
					$rswrk->Close();
				} else {
					$this->emp_id->ViewValue = $this->emp_id->CurrentValue;
				}
			} else {
				$this->emp_id->ViewValue = NULL;
			}
			$this->emp_id->ViewCustomAttributes = "";

			// leave_type_id
			if (strval($this->leave_type_id->CurrentValue) <> "") {
				$sFilterWrk = "`leave_type_id`" . ew_SearchString("=", $this->leave_type_id->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `leave_type_id`, `leave_type_title` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lib_leave`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->leave_type_id, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->leave_type_id->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->leave_type_id->ViewValue = $this->leave_type_id->CurrentValue;
				}
			} else {
				$this->leave_type_id->ViewValue = NULL;
			}
			$this->leave_type_id->ViewCustomAttributes = "";

			// sickness
			$this->sickness->ViewValue = $this->sickness->CurrentValue;
			$this->sickness->ViewCustomAttributes = "";

			// place_to_visit
			$this->place_to_visit->ViewValue = $this->place_to_visit->CurrentValue;
			$this->place_to_visit->ViewCustomAttributes = "";

			// days_to_leave
			$this->days_to_leave->ViewValue = $this->days_to_leave->CurrentValue;
			$this->days_to_leave->ViewCustomAttributes = "";

			// status_id
			if (strval($this->status_id->CurrentValue) <> "") {
				$sFilterWrk = "`status_id`" . ew_SearchString("=", $this->status_id->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `status_id`, `status_title` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lib_status`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->status_id, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->status_id->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->status_id->ViewValue = $this->status_id->CurrentValue;
				}
			} else {
				$this->status_id->ViewValue = NULL;
			}
			$this->status_id->ViewCustomAttributes = "";

			// leave_application_id
			$this->leave_application_id->LinkCustomAttributes = "";
			$this->leave_application_id->HrefValue = "";
			$this->leave_application_id->TooltipValue = "";

			// emp_id
			$this->emp_id->LinkCustomAttributes = "";
			$this->emp_id->HrefValue = "";
			$this->emp_id->TooltipValue = "";

			// leave_type_id
			$this->leave_type_id->LinkCustomAttributes = "";
			$this->leave_type_id->HrefValue = "";
			$this->leave_type_id->TooltipValue = "";

			// sickness
			$this->sickness->LinkCustomAttributes = "";
			$this->sickness->HrefValue = "";
			$this->sickness->TooltipValue = "";

			// place_to_visit
			$this->place_to_visit->LinkCustomAttributes = "";
			$this->place_to_visit->HrefValue = "";
			$this->place_to_visit->TooltipValue = "";

			// days_to_leave
			$this->days_to_leave->LinkCustomAttributes = "";
			$this->days_to_leave->HrefValue = "";
			$this->days_to_leave->TooltipValue = "";

			// status_id
			$this->status_id->LinkCustomAttributes = "";
			$this->status_id->HrefValue = "";
			$this->status_id->TooltipValue = "";
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
				$sThisKey .= $row['leave_application_id'];
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
		} else {
			$conn->RollbackTrans(); // Rollback changes
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
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "tbl_employee_leaveapplicationlist.php", $this->TableVar);
		$PageCaption = $Language->Phrase("delete");
		$Breadcrumb->Add("delete", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", ew_CurrentUrl(), $this->TableVar);
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
if (!isset($tbl_employee_leaveapplication_delete)) $tbl_employee_leaveapplication_delete = new ctbl_employee_leaveapplication_delete();

// Page init
$tbl_employee_leaveapplication_delete->Page_Init();

// Page main
$tbl_employee_leaveapplication_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tbl_employee_leaveapplication_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var tbl_employee_leaveapplication_delete = new ew_Page("tbl_employee_leaveapplication_delete");
tbl_employee_leaveapplication_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = tbl_employee_leaveapplication_delete.PageID; // For backward compatibility

// Form object
var ftbl_employee_leaveapplicationdelete = new ew_Form("ftbl_employee_leaveapplicationdelete");

// Form_CustomValidate event
ftbl_employee_leaveapplicationdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_employee_leaveapplicationdelete.ValidateRequired = true;
<?php } else { ?>
ftbl_employee_leaveapplicationdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftbl_employee_leaveapplicationdelete.Lists["x_emp_id"] = {"LinkField":"x_emp_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_empLastName","x_empFirstName","x_empMiddleName",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_employee_leaveapplicationdelete.Lists["x_leave_type_id"] = {"LinkField":"x_leave_type_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_leave_type_title","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_employee_leaveapplicationdelete.Lists["x_status_id"] = {"LinkField":"x_status_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_status_title","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($tbl_employee_leaveapplication_delete->Recordset = $tbl_employee_leaveapplication_delete->LoadRecordset())
	$tbl_employee_leaveapplication_deleteTotalRecs = $tbl_employee_leaveapplication_delete->Recordset->RecordCount(); // Get record count
if ($tbl_employee_leaveapplication_deleteTotalRecs <= 0) { // No record found, exit
	if ($tbl_employee_leaveapplication_delete->Recordset)
		$tbl_employee_leaveapplication_delete->Recordset->Close();
	$tbl_employee_leaveapplication_delete->Page_Terminate("tbl_employee_leaveapplicationlist.php"); // Return to list
}
?>
<?php $Breadcrumb->Render(); ?>
<?php $tbl_employee_leaveapplication_delete->ShowPageHeader(); ?>
<?php
$tbl_employee_leaveapplication_delete->ShowMessage();
?>
<form name="ftbl_employee_leaveapplicationdelete" id="ftbl_employee_leaveapplicationdelete" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="tbl_employee_leaveapplication">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($tbl_employee_leaveapplication_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_tbl_employee_leaveapplicationdelete" class="ewTable ewTableSeparate">
<?php echo $tbl_employee_leaveapplication->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($tbl_employee_leaveapplication->leave_application_id->Visible) { // leave_application_id ?>
		<td><span id="elh_tbl_employee_leaveapplication_leave_application_id" class="tbl_employee_leaveapplication_leave_application_id"><?php echo $tbl_employee_leaveapplication->leave_application_id->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_employee_leaveapplication->emp_id->Visible) { // emp_id ?>
		<td><span id="elh_tbl_employee_leaveapplication_emp_id" class="tbl_employee_leaveapplication_emp_id"><?php echo $tbl_employee_leaveapplication->emp_id->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_employee_leaveapplication->leave_type_id->Visible) { // leave_type_id ?>
		<td><span id="elh_tbl_employee_leaveapplication_leave_type_id" class="tbl_employee_leaveapplication_leave_type_id"><?php echo $tbl_employee_leaveapplication->leave_type_id->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_employee_leaveapplication->sickness->Visible) { // sickness ?>
		<td><span id="elh_tbl_employee_leaveapplication_sickness" class="tbl_employee_leaveapplication_sickness"><?php echo $tbl_employee_leaveapplication->sickness->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_employee_leaveapplication->place_to_visit->Visible) { // place_to_visit ?>
		<td><span id="elh_tbl_employee_leaveapplication_place_to_visit" class="tbl_employee_leaveapplication_place_to_visit"><?php echo $tbl_employee_leaveapplication->place_to_visit->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_employee_leaveapplication->days_to_leave->Visible) { // days_to_leave ?>
		<td><span id="elh_tbl_employee_leaveapplication_days_to_leave" class="tbl_employee_leaveapplication_days_to_leave"><?php echo $tbl_employee_leaveapplication->days_to_leave->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_employee_leaveapplication->status_id->Visible) { // status_id ?>
		<td><span id="elh_tbl_employee_leaveapplication_status_id" class="tbl_employee_leaveapplication_status_id"><?php echo $tbl_employee_leaveapplication->status_id->FldCaption() ?></span></td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$tbl_employee_leaveapplication_delete->RecCnt = 0;
$i = 0;
while (!$tbl_employee_leaveapplication_delete->Recordset->EOF) {
	$tbl_employee_leaveapplication_delete->RecCnt++;
	$tbl_employee_leaveapplication_delete->RowCnt++;

	// Set row properties
	$tbl_employee_leaveapplication->ResetAttrs();
	$tbl_employee_leaveapplication->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$tbl_employee_leaveapplication_delete->LoadRowValues($tbl_employee_leaveapplication_delete->Recordset);

	// Render row
	$tbl_employee_leaveapplication_delete->RenderRow();
?>
	<tr<?php echo $tbl_employee_leaveapplication->RowAttributes() ?>>
<?php if ($tbl_employee_leaveapplication->leave_application_id->Visible) { // leave_application_id ?>
		<td<?php echo $tbl_employee_leaveapplication->leave_application_id->CellAttributes() ?>>
<span id="el<?php echo $tbl_employee_leaveapplication_delete->RowCnt ?>_tbl_employee_leaveapplication_leave_application_id" class="control-group tbl_employee_leaveapplication_leave_application_id">
<span<?php echo $tbl_employee_leaveapplication->leave_application_id->ViewAttributes() ?>>
<?php echo $tbl_employee_leaveapplication->leave_application_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_employee_leaveapplication->emp_id->Visible) { // emp_id ?>
		<td<?php echo $tbl_employee_leaveapplication->emp_id->CellAttributes() ?>>
<span id="el<?php echo $tbl_employee_leaveapplication_delete->RowCnt ?>_tbl_employee_leaveapplication_emp_id" class="control-group tbl_employee_leaveapplication_emp_id">
<span<?php echo $tbl_employee_leaveapplication->emp_id->ViewAttributes() ?>>
<?php echo $tbl_employee_leaveapplication->emp_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_employee_leaveapplication->leave_type_id->Visible) { // leave_type_id ?>
		<td<?php echo $tbl_employee_leaveapplication->leave_type_id->CellAttributes() ?>>
<span id="el<?php echo $tbl_employee_leaveapplication_delete->RowCnt ?>_tbl_employee_leaveapplication_leave_type_id" class="control-group tbl_employee_leaveapplication_leave_type_id">
<span<?php echo $tbl_employee_leaveapplication->leave_type_id->ViewAttributes() ?>>
<?php echo $tbl_employee_leaveapplication->leave_type_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_employee_leaveapplication->sickness->Visible) { // sickness ?>
		<td<?php echo $tbl_employee_leaveapplication->sickness->CellAttributes() ?>>
<span id="el<?php echo $tbl_employee_leaveapplication_delete->RowCnt ?>_tbl_employee_leaveapplication_sickness" class="control-group tbl_employee_leaveapplication_sickness">
<span<?php echo $tbl_employee_leaveapplication->sickness->ViewAttributes() ?>>
<?php echo $tbl_employee_leaveapplication->sickness->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_employee_leaveapplication->place_to_visit->Visible) { // place_to_visit ?>
		<td<?php echo $tbl_employee_leaveapplication->place_to_visit->CellAttributes() ?>>
<span id="el<?php echo $tbl_employee_leaveapplication_delete->RowCnt ?>_tbl_employee_leaveapplication_place_to_visit" class="control-group tbl_employee_leaveapplication_place_to_visit">
<span<?php echo $tbl_employee_leaveapplication->place_to_visit->ViewAttributes() ?>>
<?php echo $tbl_employee_leaveapplication->place_to_visit->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_employee_leaveapplication->days_to_leave->Visible) { // days_to_leave ?>
		<td<?php echo $tbl_employee_leaveapplication->days_to_leave->CellAttributes() ?>>
<span id="el<?php echo $tbl_employee_leaveapplication_delete->RowCnt ?>_tbl_employee_leaveapplication_days_to_leave" class="control-group tbl_employee_leaveapplication_days_to_leave">
<span<?php echo $tbl_employee_leaveapplication->days_to_leave->ViewAttributes() ?>>
<?php echo $tbl_employee_leaveapplication->days_to_leave->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_employee_leaveapplication->status_id->Visible) { // status_id ?>
		<td<?php echo $tbl_employee_leaveapplication->status_id->CellAttributes() ?>>
<span id="el<?php echo $tbl_employee_leaveapplication_delete->RowCnt ?>_tbl_employee_leaveapplication_status_id" class="control-group tbl_employee_leaveapplication_status_id">
<span<?php echo $tbl_employee_leaveapplication->status_id->ViewAttributes() ?>>
<?php echo $tbl_employee_leaveapplication->status_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$tbl_employee_leaveapplication_delete->Recordset->MoveNext();
}
$tbl_employee_leaveapplication_delete->Recordset->Close();
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
ftbl_employee_leaveapplicationdelete.Init();
</script>
<?php
$tbl_employee_leaveapplication_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_employee_leaveapplication_delete->Page_Terminate();
?>
