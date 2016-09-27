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

$tbl_employee_timelog_edit = NULL; // Initialize page object first

class ctbl_employee_timelog_edit extends ctbl_employee_timelog {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}";

	// Table name
	var $TableName = 'tbl_employee_timelog';

	// Page object name
	var $PageObjName = 'tbl_employee_timelog_edit';

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
	var $AuditTrailOnEdit = TRUE;

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
			define("EW_PAGE_ID", 'edit', TRUE);

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
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("tbl_employee_timeloglist.php");
		}

		// Create form object
		$objForm = new cFormObj();
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
	var $DbMasterFilter;
	var $DbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Load key from QueryString
		if (@$_GET["ref_id"] <> "") {
			$this->ref_id->setQueryStringValue($_GET["ref_id"]);
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->ref_id->CurrentValue == "")
			$this->Page_Terminate("tbl_employee_timeloglist.php"); // Invalid key, return to list

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("tbl_employee_timeloglist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $this->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->ref_id->FldIsDetailKey)
			$this->ref_id->setFormValue($objForm->GetValue("x_ref_id"));
		if (!$this->emp_id->FldIsDetailKey) {
			$this->emp_id->setFormValue($objForm->GetValue("x_emp_id"));
		}
		if (!$this->emp_datelog->FldIsDetailKey) {
			$this->emp_datelog->setFormValue($objForm->GetValue("x_emp_datelog"));
			$this->emp_datelog->CurrentValue = ew_UnFormatDateTime($this->emp_datelog->CurrentValue, 5);
		}
		if (!$this->emp_timein->FldIsDetailKey) {
			$this->emp_timein->setFormValue($objForm->GetValue("x_emp_timein"));
		}
		if (!$this->emp_timeout->FldIsDetailKey) {
			$this->emp_timeout->setFormValue($objForm->GetValue("x_emp_timeout"));
		}
		if (!$this->emp_totalhours->FldIsDetailKey) {
			$this->emp_totalhours->setFormValue($objForm->GetValue("x_emp_totalhours"));
		}
		if (!$this->emp_late->FldIsDetailKey) {
			$this->emp_late->setFormValue($objForm->GetValue("x_emp_late"));
		}
		if (!$this->emp_excesstime->FldIsDetailKey) {
			$this->emp_excesstime->setFormValue($objForm->GetValue("x_emp_excesstime"));
		}
		if (!$this->emp_undertime->FldIsDetailKey) {
			$this->emp_undertime->setFormValue($objForm->GetValue("x_emp_undertime"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->ref_id->CurrentValue = $this->ref_id->FormValue;
		$this->emp_id->CurrentValue = $this->emp_id->FormValue;
		$this->emp_datelog->CurrentValue = $this->emp_datelog->FormValue;
		$this->emp_datelog->CurrentValue = ew_UnFormatDateTime($this->emp_datelog->CurrentValue, 5);
		$this->emp_timein->CurrentValue = $this->emp_timein->FormValue;
		$this->emp_timeout->CurrentValue = $this->emp_timeout->FormValue;
		$this->emp_totalhours->CurrentValue = $this->emp_totalhours->FormValue;
		$this->emp_late->CurrentValue = $this->emp_late->FormValue;
		$this->emp_excesstime->CurrentValue = $this->emp_excesstime->FormValue;
		$this->emp_undertime->CurrentValue = $this->emp_undertime->FormValue;
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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// ref_id
			$this->ref_id->EditCustomAttributes = "";
			$this->ref_id->EditValue = $this->ref_id->CurrentValue;
			$this->ref_id->ViewCustomAttributes = "";

			// emp_id
			$this->emp_id->EditCustomAttributes = "";
			$this->emp_id->EditValue = ew_HtmlEncode($this->emp_id->CurrentValue);
			$this->emp_id->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->emp_id->FldCaption()));

			// emp_datelog
			$this->emp_datelog->EditCustomAttributes = "";
			$this->emp_datelog->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->emp_datelog->CurrentValue, 5));
			$this->emp_datelog->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->emp_datelog->FldCaption()));

			// emp_timein
			$this->emp_timein->EditCustomAttributes = "";
			$this->emp_timein->EditValue = ew_HtmlEncode($this->emp_timein->CurrentValue);
			$this->emp_timein->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->emp_timein->FldCaption()));

			// emp_timeout
			$this->emp_timeout->EditCustomAttributes = "";
			$this->emp_timeout->EditValue = ew_HtmlEncode($this->emp_timeout->CurrentValue);
			$this->emp_timeout->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->emp_timeout->FldCaption()));

			// emp_totalhours
			$this->emp_totalhours->EditCustomAttributes = "";
			$this->emp_totalhours->EditValue = ew_HtmlEncode($this->emp_totalhours->CurrentValue);
			$this->emp_totalhours->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->emp_totalhours->FldCaption()));

			// emp_late
			$this->emp_late->EditCustomAttributes = "";
			$this->emp_late->EditValue = ew_HtmlEncode($this->emp_late->CurrentValue);
			$this->emp_late->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->emp_late->FldCaption()));

			// emp_excesstime
			$this->emp_excesstime->EditCustomAttributes = "";
			$this->emp_excesstime->EditValue = ew_HtmlEncode($this->emp_excesstime->CurrentValue);
			$this->emp_excesstime->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->emp_excesstime->FldCaption()));

			// emp_undertime
			$this->emp_undertime->EditCustomAttributes = "";
			$this->emp_undertime->EditValue = ew_HtmlEncode($this->emp_undertime->CurrentValue);
			$this->emp_undertime->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->emp_undertime->FldCaption()));

			// Edit refer script
			// ref_id

			$this->ref_id->HrefValue = "";

			// emp_id
			$this->emp_id->HrefValue = "";

			// emp_datelog
			$this->emp_datelog->HrefValue = "";

			// emp_timein
			$this->emp_timein->HrefValue = "";

			// emp_timeout
			$this->emp_timeout->HrefValue = "";

			// emp_totalhours
			$this->emp_totalhours->HrefValue = "";

			// emp_late
			$this->emp_late->HrefValue = "";

			// emp_excesstime
			$this->emp_excesstime->HrefValue = "";

			// emp_undertime
			$this->emp_undertime->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->emp_id->FldIsDetailKey && !is_null($this->emp_id->FormValue) && $this->emp_id->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->emp_id->FldCaption());
		}
		if (!ew_CheckInteger($this->emp_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->emp_id->FldErrMsg());
		}
		if (!$this->emp_datelog->FldIsDetailKey && !is_null($this->emp_datelog->FormValue) && $this->emp_datelog->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->emp_datelog->FldCaption());
		}
		if (!ew_CheckDate($this->emp_datelog->FormValue)) {
			ew_AddMessage($gsFormError, $this->emp_datelog->FldErrMsg());
		}
		if (!$this->emp_timein->FldIsDetailKey && !is_null($this->emp_timein->FormValue) && $this->emp_timein->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->emp_timein->FldCaption());
		}
		if (!ew_CheckTime($this->emp_timein->FormValue)) {
			ew_AddMessage($gsFormError, $this->emp_timein->FldErrMsg());
		}
		if (!$this->emp_timeout->FldIsDetailKey && !is_null($this->emp_timeout->FormValue) && $this->emp_timeout->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->emp_timeout->FldCaption());
		}
		if (!ew_CheckTime($this->emp_timeout->FormValue)) {
			ew_AddMessage($gsFormError, $this->emp_timeout->FldErrMsg());
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// emp_id
			$this->emp_id->SetDbValueDef($rsnew, $this->emp_id->CurrentValue, 0, $this->emp_id->ReadOnly);

			// emp_datelog
			$this->emp_datelog->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->emp_datelog->CurrentValue, 5), ew_CurrentDate(), $this->emp_datelog->ReadOnly);

			// emp_timein
			$this->emp_timein->SetDbValueDef($rsnew, $this->emp_timein->CurrentValue, ew_CurrentTime(), $this->emp_timein->ReadOnly);

			// emp_timeout
			$this->emp_timeout->SetDbValueDef($rsnew, $this->emp_timeout->CurrentValue, ew_CurrentTime(), $this->emp_timeout->ReadOnly);

			// emp_totalhours
			$this->emp_totalhours->SetDbValueDef($rsnew, $this->emp_totalhours->CurrentValue, NULL, $this->emp_totalhours->ReadOnly);

			// emp_late
			$this->emp_late->SetDbValueDef($rsnew, $this->emp_late->CurrentValue, NULL, $this->emp_late->ReadOnly);

			// emp_excesstime
			$this->emp_excesstime->SetDbValueDef($rsnew, $this->emp_excesstime->CurrentValue, NULL, $this->emp_excesstime->ReadOnly);

			// emp_undertime
			$this->emp_undertime->SetDbValueDef($rsnew, $this->emp_undertime->CurrentValue, NULL, $this->emp_undertime->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		if ($EditRow) {
			$this->WriteAuditTrailOnEdit($rsold, $rsnew);
		}
		$rs->Close();
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "tbl_employee_timeloglist.php", $this->TableVar);
		$PageCaption = $Language->Phrase("edit");
		$Breadcrumb->Add("edit", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", ew_CurrentUrl(), $this->TableVar);
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'tbl_employee_timelog';
	  $usr = CurrentUserName();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		if (!$this->AuditTrailOnEdit) return;
		$table = 'tbl_employee_timelog';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['ref_id'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
	  $usr = CurrentUserName();
		foreach (array_keys($rsnew) as $fldname) {
			if ($this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldDataType == EW_DATATYPE_DATE) { // DateTime field
					$modified = (ew_FormatDateTime($rsold[$fldname], 0) <> ew_FormatDateTime($rsnew[$fldname], 0));
				} else {
					$modified = !ew_CompareValue($rsold[$fldname], $rsnew[$fldname]);
				}
				if ($modified) {
					if ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) { // Memo field
						if (EW_AUDIT_TRAIL_TO_DATABASE) {
							$oldvalue = $rsold[$fldname];
							$newvalue = $rsnew[$fldname];
						} else {
							$oldvalue = "[MEMO]";
							$newvalue = "[MEMO]";
						}
					} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) { // XML field
						$oldvalue = "[XML]";
						$newvalue = "[XML]";
					} else {
						$oldvalue = $rsold[$fldname];
						$newvalue = $rsnew[$fldname];
					}
					ew_WriteAuditTrail("log", $dt, $id, $usr, "U", $table, $fldname, $key, $oldvalue, $newvalue);
				}
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($tbl_employee_timelog_edit)) $tbl_employee_timelog_edit = new ctbl_employee_timelog_edit();

// Page init
$tbl_employee_timelog_edit->Page_Init();

// Page main
$tbl_employee_timelog_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tbl_employee_timelog_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var tbl_employee_timelog_edit = new ew_Page("tbl_employee_timelog_edit");
tbl_employee_timelog_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = tbl_employee_timelog_edit.PageID; // For backward compatibility

// Form object
var ftbl_employee_timelogedit = new ew_Form("ftbl_employee_timelogedit");

// Validate form
ftbl_employee_timelogedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_emp_id");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_employee_timelog->emp_id->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_emp_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tbl_employee_timelog->emp_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_emp_datelog");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_employee_timelog->emp_datelog->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_emp_datelog");
			if (elm && !ew_CheckDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tbl_employee_timelog->emp_datelog->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_emp_timein");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_employee_timelog->emp_timein->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_emp_timein");
			if (elm && !ew_CheckTime(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tbl_employee_timelog->emp_timein->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_emp_timeout");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_employee_timelog->emp_timeout->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_emp_timeout");
			if (elm && !ew_CheckTime(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tbl_employee_timelog->emp_timeout->FldErrMsg()) ?>");

			// Set up row object
			ew_ElementsToRow(fobj);

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
ftbl_employee_timelogedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_employee_timelogedit.ValidateRequired = true;
<?php } else { ?>
ftbl_employee_timelogedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $tbl_employee_timelog_edit->ShowPageHeader(); ?>
<?php
$tbl_employee_timelog_edit->ShowMessage();
?>
<form name="ftbl_employee_timelogedit" id="ftbl_employee_timelogedit" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="tbl_employee_timelog">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_tbl_employee_timelogedit" class="table table-bordered table-striped">
<?php if ($tbl_employee_timelog->ref_id->Visible) { // ref_id ?>
	<tr id="r_ref_id">
		<td><span id="elh_tbl_employee_timelog_ref_id"><?php echo $tbl_employee_timelog->ref_id->FldCaption() ?></span></td>
		<td<?php echo $tbl_employee_timelog->ref_id->CellAttributes() ?>>
<span id="el_tbl_employee_timelog_ref_id" class="control-group">
<span<?php echo $tbl_employee_timelog->ref_id->ViewAttributes() ?>>
<?php echo $tbl_employee_timelog->ref_id->EditValue ?></span>
</span>
<input type="hidden" data-field="x_ref_id" name="x_ref_id" id="x_ref_id" value="<?php echo ew_HtmlEncode($tbl_employee_timelog->ref_id->CurrentValue) ?>">
<?php echo $tbl_employee_timelog->ref_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_employee_timelog->emp_id->Visible) { // emp_id ?>
	<tr id="r_emp_id">
		<td><span id="elh_tbl_employee_timelog_emp_id"><?php echo $tbl_employee_timelog->emp_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_employee_timelog->emp_id->CellAttributes() ?>>
<span id="el_tbl_employee_timelog_emp_id" class="control-group">
<input type="text" data-field="x_emp_id" name="x_emp_id" id="x_emp_id" size="30" placeholder="<?php echo $tbl_employee_timelog->emp_id->PlaceHolder ?>" value="<?php echo $tbl_employee_timelog->emp_id->EditValue ?>"<?php echo $tbl_employee_timelog->emp_id->EditAttributes() ?>>
</span>
<?php echo $tbl_employee_timelog->emp_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_employee_timelog->emp_datelog->Visible) { // emp_datelog ?>
	<tr id="r_emp_datelog">
		<td><span id="elh_tbl_employee_timelog_emp_datelog"><?php echo $tbl_employee_timelog->emp_datelog->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_employee_timelog->emp_datelog->CellAttributes() ?>>
<span id="el_tbl_employee_timelog_emp_datelog" class="control-group">
<input type="text" data-field="x_emp_datelog" name="x_emp_datelog" id="x_emp_datelog" placeholder="<?php echo $tbl_employee_timelog->emp_datelog->PlaceHolder ?>" value="<?php echo $tbl_employee_timelog->emp_datelog->EditValue ?>"<?php echo $tbl_employee_timelog->emp_datelog->EditAttributes() ?>>
</span>
<?php echo $tbl_employee_timelog->emp_datelog->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_employee_timelog->emp_timein->Visible) { // emp_timein ?>
	<tr id="r_emp_timein">
		<td><span id="elh_tbl_employee_timelog_emp_timein"><?php echo $tbl_employee_timelog->emp_timein->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_employee_timelog->emp_timein->CellAttributes() ?>>
<span id="el_tbl_employee_timelog_emp_timein" class="control-group">
<input type="text" data-field="x_emp_timein" name="x_emp_timein" id="x_emp_timein" size="30" placeholder="<?php echo $tbl_employee_timelog->emp_timein->PlaceHolder ?>" value="<?php echo $tbl_employee_timelog->emp_timein->EditValue ?>"<?php echo $tbl_employee_timelog->emp_timein->EditAttributes() ?>>
</span>
<?php echo $tbl_employee_timelog->emp_timein->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_employee_timelog->emp_timeout->Visible) { // emp_timeout ?>
	<tr id="r_emp_timeout">
		<td><span id="elh_tbl_employee_timelog_emp_timeout"><?php echo $tbl_employee_timelog->emp_timeout->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_employee_timelog->emp_timeout->CellAttributes() ?>>
<span id="el_tbl_employee_timelog_emp_timeout" class="control-group">
<input type="text" data-field="x_emp_timeout" name="x_emp_timeout" id="x_emp_timeout" size="30" placeholder="<?php echo $tbl_employee_timelog->emp_timeout->PlaceHolder ?>" value="<?php echo $tbl_employee_timelog->emp_timeout->EditValue ?>"<?php echo $tbl_employee_timelog->emp_timeout->EditAttributes() ?>>
</span>
<?php echo $tbl_employee_timelog->emp_timeout->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_employee_timelog->emp_totalhours->Visible) { // emp_totalhours ?>
	<tr id="r_emp_totalhours">
		<td><span id="elh_tbl_employee_timelog_emp_totalhours"><?php echo $tbl_employee_timelog->emp_totalhours->FldCaption() ?></span></td>
		<td<?php echo $tbl_employee_timelog->emp_totalhours->CellAttributes() ?>>
<span id="el_tbl_employee_timelog_emp_totalhours" class="control-group">
<input type="text" data-field="x_emp_totalhours" name="x_emp_totalhours" id="x_emp_totalhours" size="30" maxlength="10" placeholder="<?php echo $tbl_employee_timelog->emp_totalhours->PlaceHolder ?>" value="<?php echo $tbl_employee_timelog->emp_totalhours->EditValue ?>"<?php echo $tbl_employee_timelog->emp_totalhours->EditAttributes() ?>>
</span>
<?php echo $tbl_employee_timelog->emp_totalhours->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_employee_timelog->emp_late->Visible) { // emp_late ?>
	<tr id="r_emp_late">
		<td><span id="elh_tbl_employee_timelog_emp_late"><?php echo $tbl_employee_timelog->emp_late->FldCaption() ?></span></td>
		<td<?php echo $tbl_employee_timelog->emp_late->CellAttributes() ?>>
<span id="el_tbl_employee_timelog_emp_late" class="control-group">
<input type="text" data-field="x_emp_late" name="x_emp_late" id="x_emp_late" size="30" maxlength="10" placeholder="<?php echo $tbl_employee_timelog->emp_late->PlaceHolder ?>" value="<?php echo $tbl_employee_timelog->emp_late->EditValue ?>"<?php echo $tbl_employee_timelog->emp_late->EditAttributes() ?>>
</span>
<?php echo $tbl_employee_timelog->emp_late->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_employee_timelog->emp_excesstime->Visible) { // emp_excesstime ?>
	<tr id="r_emp_excesstime">
		<td><span id="elh_tbl_employee_timelog_emp_excesstime"><?php echo $tbl_employee_timelog->emp_excesstime->FldCaption() ?></span></td>
		<td<?php echo $tbl_employee_timelog->emp_excesstime->CellAttributes() ?>>
<span id="el_tbl_employee_timelog_emp_excesstime" class="control-group">
<input type="text" data-field="x_emp_excesstime" name="x_emp_excesstime" id="x_emp_excesstime" size="30" maxlength="10" placeholder="<?php echo $tbl_employee_timelog->emp_excesstime->PlaceHolder ?>" value="<?php echo $tbl_employee_timelog->emp_excesstime->EditValue ?>"<?php echo $tbl_employee_timelog->emp_excesstime->EditAttributes() ?>>
</span>
<?php echo $tbl_employee_timelog->emp_excesstime->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_employee_timelog->emp_undertime->Visible) { // emp_undertime ?>
	<tr id="r_emp_undertime">
		<td><span id="elh_tbl_employee_timelog_emp_undertime"><?php echo $tbl_employee_timelog->emp_undertime->FldCaption() ?></span></td>
		<td<?php echo $tbl_employee_timelog->emp_undertime->CellAttributes() ?>>
<span id="el_tbl_employee_timelog_emp_undertime" class="control-group">
<input type="text" data-field="x_emp_undertime" name="x_emp_undertime" id="x_emp_undertime" size="30" maxlength="10" placeholder="<?php echo $tbl_employee_timelog->emp_undertime->PlaceHolder ?>" value="<?php echo $tbl_employee_timelog->emp_undertime->EditValue ?>"<?php echo $tbl_employee_timelog->emp_undertime->EditAttributes() ?>>
</span>
<?php echo $tbl_employee_timelog->emp_undertime->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("EditBtn") ?></button>
</form>
<script type="text/javascript">
ftbl_employee_timelogedit.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$tbl_employee_timelog_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_employee_timelog_edit->Page_Terminate();
?>
