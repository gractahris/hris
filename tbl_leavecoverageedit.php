<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "tbl_leavecoverageinfo.php" ?>
<?php include_once "tbl_userinfo.php" ?>
<?php include_once "tbl_employee_leaveapplicationinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$tbl_leavecoverage_edit = NULL; // Initialize page object first

class ctbl_leavecoverage_edit extends ctbl_leavecoverage {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}";

	// Table name
	var $TableName = 'tbl_leavecoverage';

	// Page object name
	var $PageObjName = 'tbl_leavecoverage_edit';

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

		// Table object (tbl_leavecoverage)
		if (!isset($GLOBALS["tbl_leavecoverage"])) {
			$GLOBALS["tbl_leavecoverage"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbl_leavecoverage"];
		}

		// Table object (tbl_user)
		if (!isset($GLOBALS['tbl_user'])) $GLOBALS['tbl_user'] = new ctbl_user();

		// Table object (tbl_employee_leaveapplication)
		if (!isset($GLOBALS['tbl_employee_leaveapplication'])) $GLOBALS['tbl_employee_leaveapplication'] = new ctbl_employee_leaveapplication();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_leavecoverage', TRUE);

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
			$this->Page_Terminate("tbl_leavecoveragelist.php");
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up curent action
		$this->leave_coverage_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		if (@$_GET["leave_coverage_id"] <> "") {
			$this->leave_coverage_id->setQueryStringValue($_GET["leave_coverage_id"]);
		}

		// Set up master detail parameters
		$this->SetUpMasterParms();

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
		if ($this->leave_coverage_id->CurrentValue == "")
			$this->Page_Terminate("tbl_leavecoveragelist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("tbl_leavecoveragelist.php"); // No matching record, return to list
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
		if (!$this->leave_coverage_id->FldIsDetailKey)
			$this->leave_coverage_id->setFormValue($objForm->GetValue("x_leave_coverage_id"));
		if (!$this->leave_application_id->FldIsDetailKey) {
			$this->leave_application_id->setFormValue($objForm->GetValue("x_leave_application_id"));
		}
		if (!$this->emp_id->FldIsDetailKey) {
			$this->emp_id->setFormValue($objForm->GetValue("x_emp_id"));
		}
		if (!$this->date_from->FldIsDetailKey) {
			$this->date_from->setFormValue($objForm->GetValue("x_date_from"));
			$this->date_from->CurrentValue = ew_UnFormatDateTime($this->date_from->CurrentValue, 5);
		}
		if (!$this->date_to->FldIsDetailKey) {
			$this->date_to->setFormValue($objForm->GetValue("x_date_to"));
			$this->date_to->CurrentValue = ew_UnFormatDateTime($this->date_to->CurrentValue, 5);
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->leave_coverage_id->CurrentValue = $this->leave_coverage_id->FormValue;
		$this->leave_application_id->CurrentValue = $this->leave_application_id->FormValue;
		$this->emp_id->CurrentValue = $this->emp_id->FormValue;
		$this->date_from->CurrentValue = $this->date_from->FormValue;
		$this->date_from->CurrentValue = ew_UnFormatDateTime($this->date_from->CurrentValue, 5);
		$this->date_to->CurrentValue = $this->date_to->FormValue;
		$this->date_to->CurrentValue = ew_UnFormatDateTime($this->date_to->CurrentValue, 5);
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
		$this->leave_coverage_id->setDbValue($rs->fields('leave_coverage_id'));
		$this->leave_application_id->setDbValue($rs->fields('leave_application_id'));
		$this->emp_id->setDbValue($rs->fields('emp_id'));
		$this->date_from->setDbValue($rs->fields('date_from'));
		$this->date_to->setDbValue($rs->fields('date_to'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->leave_coverage_id->DbValue = $row['leave_coverage_id'];
		$this->leave_application_id->DbValue = $row['leave_application_id'];
		$this->emp_id->DbValue = $row['emp_id'];
		$this->date_from->DbValue = $row['date_from'];
		$this->date_to->DbValue = $row['date_to'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// leave_coverage_id
		// leave_application_id
		// emp_id
		// date_from
		// date_to

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// leave_coverage_id
			$this->leave_coverage_id->ViewValue = $this->leave_coverage_id->CurrentValue;
			$this->leave_coverage_id->ViewCustomAttributes = "";

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

			// date_from
			$this->date_from->ViewValue = $this->date_from->CurrentValue;
			$this->date_from->ViewValue = ew_FormatDateTime($this->date_from->ViewValue, 5);
			$this->date_from->ViewCustomAttributes = "";

			// date_to
			$this->date_to->ViewValue = $this->date_to->CurrentValue;
			$this->date_to->ViewValue = ew_FormatDateTime($this->date_to->ViewValue, 5);
			$this->date_to->ViewCustomAttributes = "";

			// leave_coverage_id
			$this->leave_coverage_id->LinkCustomAttributes = "";
			$this->leave_coverage_id->HrefValue = "";
			$this->leave_coverage_id->TooltipValue = "";

			// leave_application_id
			$this->leave_application_id->LinkCustomAttributes = "";
			$this->leave_application_id->HrefValue = "";
			$this->leave_application_id->TooltipValue = "";

			// emp_id
			$this->emp_id->LinkCustomAttributes = "";
			$this->emp_id->HrefValue = "";
			$this->emp_id->TooltipValue = "";

			// date_from
			$this->date_from->LinkCustomAttributes = "";
			$this->date_from->HrefValue = "";
			$this->date_from->TooltipValue = "";

			// date_to
			$this->date_to->LinkCustomAttributes = "";
			$this->date_to->HrefValue = "";
			$this->date_to->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// leave_coverage_id
			$this->leave_coverage_id->EditCustomAttributes = "";
			$this->leave_coverage_id->EditValue = $this->leave_coverage_id->CurrentValue;
			$this->leave_coverage_id->ViewCustomAttributes = "";

			// leave_application_id
			$this->leave_application_id->EditCustomAttributes = "";
			if ($this->leave_application_id->getSessionValue() <> "") {
				$this->leave_application_id->CurrentValue = $this->leave_application_id->getSessionValue();
			$this->leave_application_id->ViewValue = $this->leave_application_id->CurrentValue;
			$this->leave_application_id->ViewCustomAttributes = "";
			} else {
			$this->leave_application_id->EditValue = ew_HtmlEncode($this->leave_application_id->CurrentValue);
			$this->leave_application_id->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->leave_application_id->FldCaption()));
			}

			// emp_id
			$this->emp_id->EditCustomAttributes = "";
			$this->emp_id->EditValue = ew_HtmlEncode($this->emp_id->CurrentValue);
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
					$this->emp_id->EditValue = $rswrk->fields('DispFld');
					$this->emp_id->EditValue .= ew_ValueSeparator(1,$this->emp_id) . $rswrk->fields('Disp2Fld');
					$this->emp_id->EditValue .= ew_ValueSeparator(2,$this->emp_id) . $rswrk->fields('Disp3Fld');
					$rswrk->Close();
				} else {
					$this->emp_id->EditValue = $this->emp_id->CurrentValue;
				}
			} else {
				$this->emp_id->EditValue = NULL;
			}
			$this->emp_id->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->emp_id->FldCaption()));

			// date_from
			$this->date_from->EditCustomAttributes = "";
			$this->date_from->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->date_from->CurrentValue, 5));
			$this->date_from->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->date_from->FldCaption()));

			// date_to
			$this->date_to->EditCustomAttributes = "";
			$this->date_to->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->date_to->CurrentValue, 5));
			$this->date_to->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->date_to->FldCaption()));

			// Edit refer script
			// leave_coverage_id

			$this->leave_coverage_id->HrefValue = "";

			// leave_application_id
			$this->leave_application_id->HrefValue = "";

			// emp_id
			$this->emp_id->HrefValue = "";

			// date_from
			$this->date_from->HrefValue = "";

			// date_to
			$this->date_to->HrefValue = "";
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
		if (!$this->leave_application_id->FldIsDetailKey && !is_null($this->leave_application_id->FormValue) && $this->leave_application_id->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->leave_application_id->FldCaption());
		}
		if (!ew_CheckInteger($this->leave_application_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->leave_application_id->FldErrMsg());
		}
		if (!$this->emp_id->FldIsDetailKey && !is_null($this->emp_id->FormValue) && $this->emp_id->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->emp_id->FldCaption());
		}
		if (!ew_CheckInteger($this->emp_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->emp_id->FldErrMsg());
		}
		if (!$this->date_from->FldIsDetailKey && !is_null($this->date_from->FormValue) && $this->date_from->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->date_from->FldCaption());
		}
		if (!ew_CheckDate($this->date_from->FormValue)) {
			ew_AddMessage($gsFormError, $this->date_from->FldErrMsg());
		}
		if (!$this->date_to->FldIsDetailKey && !is_null($this->date_to->FormValue) && $this->date_to->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->date_to->FldCaption());
		}
		if (!ew_CheckDate($this->date_to->FormValue)) {
			ew_AddMessage($gsFormError, $this->date_to->FldErrMsg());
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

			// leave_application_id
			$this->leave_application_id->SetDbValueDef($rsnew, $this->leave_application_id->CurrentValue, 0, $this->leave_application_id->ReadOnly);

			// emp_id
			$this->emp_id->SetDbValueDef($rsnew, $this->emp_id->CurrentValue, 0, $this->emp_id->ReadOnly);

			// date_from
			$this->date_from->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->date_from->CurrentValue, 5), NULL, $this->date_from->ReadOnly);

			// date_to
			$this->date_to->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->date_to->CurrentValue, 5), NULL, $this->date_to->ReadOnly);

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
		$rs->Close();
		return $EditRow;
	}

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "tbl_employee_leaveapplication") {
				$bValidMaster = TRUE;
				if (@$_GET["leave_application_id"] <> "") {
					$GLOBALS["tbl_employee_leaveapplication"]->leave_application_id->setQueryStringValue($_GET["leave_application_id"]);
					$this->leave_application_id->setQueryStringValue($GLOBALS["tbl_employee_leaveapplication"]->leave_application_id->QueryStringValue);
					$this->leave_application_id->setSessionValue($this->leave_application_id->QueryStringValue);
					if (!is_numeric($GLOBALS["tbl_employee_leaveapplication"]->leave_application_id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "tbl_employee_leaveapplication") {
				if ($this->leave_application_id->QueryStringValue == "") $this->leave_application_id->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); //  Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "tbl_leavecoveragelist.php", $this->TableVar);
		$PageCaption = $Language->Phrase("edit");
		$Breadcrumb->Add("edit", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", ew_CurrentUrl(), $this->TableVar);
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
if (!isset($tbl_leavecoverage_edit)) $tbl_leavecoverage_edit = new ctbl_leavecoverage_edit();

// Page init
$tbl_leavecoverage_edit->Page_Init();

// Page main
$tbl_leavecoverage_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tbl_leavecoverage_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var tbl_leavecoverage_edit = new ew_Page("tbl_leavecoverage_edit");
tbl_leavecoverage_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = tbl_leavecoverage_edit.PageID; // For backward compatibility

// Form object
var ftbl_leavecoverageedit = new ew_Form("ftbl_leavecoverageedit");

// Validate form
ftbl_leavecoverageedit.Validate = function() {
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
ftbl_leavecoverageedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_leavecoverageedit.ValidateRequired = true;
<?php } else { ?>
ftbl_leavecoverageedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftbl_leavecoverageedit.Lists["x_emp_id"] = {"LinkField":"x_emp_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_empLastName","x_empFirstName","x_empMiddleName",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $tbl_leavecoverage_edit->ShowPageHeader(); ?>
<?php
$tbl_leavecoverage_edit->ShowMessage();
?>
<form name="ftbl_leavecoverageedit" id="ftbl_leavecoverageedit" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="tbl_leavecoverage">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_tbl_leavecoverageedit" class="table table-bordered table-striped">
<?php if ($tbl_leavecoverage->leave_coverage_id->Visible) { // leave_coverage_id ?>
	<tr id="r_leave_coverage_id">
		<td><span id="elh_tbl_leavecoverage_leave_coverage_id"><?php echo $tbl_leavecoverage->leave_coverage_id->FldCaption() ?></span></td>
		<td<?php echo $tbl_leavecoverage->leave_coverage_id->CellAttributes() ?>>
<span id="el_tbl_leavecoverage_leave_coverage_id" class="control-group">
<span<?php echo $tbl_leavecoverage->leave_coverage_id->ViewAttributes() ?>>
<?php echo $tbl_leavecoverage->leave_coverage_id->EditValue ?></span>
</span>
<input type="hidden" data-field="x_leave_coverage_id" name="x_leave_coverage_id" id="x_leave_coverage_id" value="<?php echo ew_HtmlEncode($tbl_leavecoverage->leave_coverage_id->CurrentValue) ?>">
<?php echo $tbl_leavecoverage->leave_coverage_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_leavecoverage->leave_application_id->Visible) { // leave_application_id ?>
	<tr id="r_leave_application_id">
		<td><span id="elh_tbl_leavecoverage_leave_application_id"><?php echo $tbl_leavecoverage->leave_application_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_leavecoverage->leave_application_id->CellAttributes() ?>>
<?php if ($tbl_leavecoverage->leave_application_id->getSessionValue() <> "") { ?>
<span<?php echo $tbl_leavecoverage->leave_application_id->ViewAttributes() ?>>
<?php echo $tbl_leavecoverage->leave_application_id->ViewValue ?></span>
<input type="hidden" id="x_leave_application_id" name="x_leave_application_id" value="<?php echo ew_HtmlEncode($tbl_leavecoverage->leave_application_id->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_leave_application_id" name="x_leave_application_id" id="x_leave_application_id" size="30" placeholder="<?php echo $tbl_leavecoverage->leave_application_id->PlaceHolder ?>" value="<?php echo $tbl_leavecoverage->leave_application_id->EditValue ?>"<?php echo $tbl_leavecoverage->leave_application_id->EditAttributes() ?>>
<?php } ?>
<?php echo $tbl_leavecoverage->leave_application_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_leavecoverage->emp_id->Visible) { // emp_id ?>
	<tr id="r_emp_id">
		<td><span id="elh_tbl_leavecoverage_emp_id"><?php echo $tbl_leavecoverage->emp_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_leavecoverage->emp_id->CellAttributes() ?>>
<span id="el_tbl_leavecoverage_emp_id" class="control-group">
<?php
	$wrkonchange = trim(" " . @$tbl_leavecoverage->emp_id->EditAttrs["onchange"]);
	if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
	$tbl_leavecoverage->emp_id->EditAttrs["onchange"] = "";
?>
<span id="as_x_emp_id" style="white-space: nowrap; z-index: 8970">
	<input type="text" name="sv_x_emp_id" id="sv_x_emp_id" value="<?php echo $tbl_leavecoverage->emp_id->EditValue ?>" size="30" placeholder="<?php echo $tbl_leavecoverage->emp_id->PlaceHolder ?>"<?php echo $tbl_leavecoverage->emp_id->EditAttributes() ?>>&nbsp;<span id="em_x_emp_id" class="ewMessage" style="display: none"><?php echo str_replace("%f", "phpimages/", $Language->Phrase("UnmatchedValue")) ?></span>
	<div id="sc_x_emp_id" style="display: inline; z-index: 8970"></div>
</span>
<input type="hidden" data-field="x_emp_id" name="x_emp_id" id="x_emp_id" value="<?php echo $tbl_leavecoverage->emp_id->CurrentValue ?>"<?php echo $wrkonchange ?>>
<?php
$sSqlWrk = "SELECT `emp_id`, `empLastName` AS `DispFld`, `empFirstName` AS `Disp2Fld`, `empMiddleName` AS `Disp3Fld` FROM `tbl_employee`";
$sWhereWrk = "`empLastName` LIKE '{query_value}%' OR CONCAT(`empLastName`,'" . ew_ValueSeparator(1, $Page->emp_id) . "',`empFirstName`,'" . ew_ValueSeparator(2, $Page->emp_id) . "',`empMiddleName`) LIKE '{query_value}%'";

// Call Lookup selecting
$tbl_leavecoverage->Lookup_Selecting($tbl_leavecoverage->emp_id, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
?>
<input type="hidden" name="q_x_emp_id" id="q_x_emp_id" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>">
<script type="text/javascript">
var oas = new ew_AutoSuggest("x_emp_id", ftbl_leavecoverageedit, false, EW_AUTO_SUGGEST_MAX_ENTRIES);
oas.formatResult = function(ar) {
	var dv = ar[1];
	for (var i = 2; i <= 4; i++)
		dv += (ar[i]) ? ew_ValueSeparator(i - 1, "x_emp_id") + ar[i] : "";
	return dv;
}
ftbl_leavecoverageedit.AutoSuggests["x_emp_id"] = oas;
</script>
</span>
<?php echo $tbl_leavecoverage->emp_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_leavecoverage->date_from->Visible) { // date_from ?>
	<tr id="r_date_from">
		<td><span id="elh_tbl_leavecoverage_date_from"><?php echo $tbl_leavecoverage->date_from->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_leavecoverage->date_from->CellAttributes() ?>>
<span id="el_tbl_leavecoverage_date_from" class="control-group">
<input type="text" data-field="x_date_from" name="x_date_from" id="x_date_from" placeholder="<?php echo $tbl_leavecoverage->date_from->PlaceHolder ?>" value="<?php echo $tbl_leavecoverage->date_from->EditValue ?>"<?php echo $tbl_leavecoverage->date_from->EditAttributes() ?>>
<?php if (!$tbl_leavecoverage->date_from->ReadOnly && !$tbl_leavecoverage->date_from->Disabled && @$tbl_leavecoverage->date_from->EditAttrs["readonly"] == "" && @$tbl_leavecoverage->date_from->EditAttrs["disabled"] == "") { ?>
<button id="cal_x_date_from" name="cal_x_date_from" class="btn" type="button"><img src="phpimages/calendar.png" id="cal_x_date_from" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" style="border: 0;"></button><script type="text/javascript">
ew_CreateCalendar("ftbl_leavecoverageedit", "x_date_from", "%Y/%m/%d");
</script>
<?php } ?>
</span>
<?php echo $tbl_leavecoverage->date_from->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_leavecoverage->date_to->Visible) { // date_to ?>
	<tr id="r_date_to">
		<td><span id="elh_tbl_leavecoverage_date_to"><?php echo $tbl_leavecoverage->date_to->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_leavecoverage->date_to->CellAttributes() ?>>
<span id="el_tbl_leavecoverage_date_to" class="control-group">
<input type="text" data-field="x_date_to" name="x_date_to" id="x_date_to" placeholder="<?php echo $tbl_leavecoverage->date_to->PlaceHolder ?>" value="<?php echo $tbl_leavecoverage->date_to->EditValue ?>"<?php echo $tbl_leavecoverage->date_to->EditAttributes() ?>>
<?php if (!$tbl_leavecoverage->date_to->ReadOnly && !$tbl_leavecoverage->date_to->Disabled && @$tbl_leavecoverage->date_to->EditAttrs["readonly"] == "" && @$tbl_leavecoverage->date_to->EditAttrs["disabled"] == "") { ?>
<button id="cal_x_date_to" name="cal_x_date_to" class="btn" type="button"><img src="phpimages/calendar.png" id="cal_x_date_to" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" style="border: 0;"></button><script type="text/javascript">
ew_CreateCalendar("ftbl_leavecoverageedit", "x_date_to", "%Y/%m/%d");
</script>
<?php } ?>
</span>
<?php echo $tbl_leavecoverage->date_to->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("EditBtn") ?></button>
</form>
<script type="text/javascript">
ftbl_leavecoverageedit.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$tbl_leavecoverage_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_leavecoverage_edit->Page_Terminate();
?>
