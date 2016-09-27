<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "tbl_employee_deductioninfo.php" ?>
<?php include_once "tbl_employeeinfo.php" ?>
<?php include_once "tbl_userinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$tbl_employee_deduction_edit = NULL; // Initialize page object first

class ctbl_employee_deduction_edit extends ctbl_employee_deduction {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}";

	// Table name
	var $TableName = 'tbl_employee_deduction';

	// Page object name
	var $PageObjName = 'tbl_employee_deduction_edit';

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

		// Table object (tbl_employee_deduction)
		if (!isset($GLOBALS["tbl_employee_deduction"])) {
			$GLOBALS["tbl_employee_deduction"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbl_employee_deduction"];
		}

		// Table object (tbl_employee)
		if (!isset($GLOBALS['tbl_employee'])) $GLOBALS['tbl_employee'] = new ctbl_employee();

		// Table object (tbl_user)
		if (!isset($GLOBALS['tbl_user'])) $GLOBALS['tbl_user'] = new ctbl_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_employee_deduction', TRUE);

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
			$this->Page_Terminate("tbl_employee_deductionlist.php");
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up curent action
		$this->deduction_ref_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		if (@$_GET["deduction_ref_id"] <> "") {
			$this->deduction_ref_id->setQueryStringValue($_GET["deduction_ref_id"]);
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
		if ($this->deduction_ref_id->CurrentValue == "")
			$this->Page_Terminate("tbl_employee_deductionlist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("tbl_employee_deductionlist.php"); // No matching record, return to list
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
		if (!$this->deduction_ref_id->FldIsDetailKey)
			$this->deduction_ref_id->setFormValue($objForm->GetValue("x_deduction_ref_id"));
		if (!$this->deduction_id->FldIsDetailKey) {
			$this->deduction_id->setFormValue($objForm->GetValue("x_deduction_id"));
		}
		if (!$this->deduction_amount->FldIsDetailKey) {
			$this->deduction_amount->setFormValue($objForm->GetValue("x_deduction_amount"));
		}
		if (!$this->emp_id->FldIsDetailKey) {
			$this->emp_id->setFormValue($objForm->GetValue("x_emp_id"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->deduction_ref_id->CurrentValue = $this->deduction_ref_id->FormValue;
		$this->deduction_id->CurrentValue = $this->deduction_id->FormValue;
		$this->deduction_amount->CurrentValue = $this->deduction_amount->FormValue;
		$this->emp_id->CurrentValue = $this->emp_id->FormValue;
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
		$this->deduction_ref_id->setDbValue($rs->fields('deduction_ref_id'));
		$this->deduction_id->setDbValue($rs->fields('deduction_id'));
		$this->deduction_amount->setDbValue($rs->fields('deduction_amount'));
		$this->emp_id->setDbValue($rs->fields('emp_id'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->deduction_ref_id->DbValue = $row['deduction_ref_id'];
		$this->deduction_id->DbValue = $row['deduction_id'];
		$this->deduction_amount->DbValue = $row['deduction_amount'];
		$this->emp_id->DbValue = $row['emp_id'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// deduction_ref_id
		// deduction_id
		// deduction_amount
		// emp_id

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// deduction_ref_id
			$this->deduction_ref_id->ViewValue = $this->deduction_ref_id->CurrentValue;
			$this->deduction_ref_id->ViewCustomAttributes = "";

			// deduction_id
			if (strval($this->deduction_id->CurrentValue) <> "") {
				$sFilterWrk = "`deduction_id`" . ew_SearchString("=", $this->deduction_id->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `deduction_id`, `deduction_title` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lib_deduction`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->deduction_id, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->deduction_id->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->deduction_id->ViewValue = $this->deduction_id->CurrentValue;
				}
			} else {
				$this->deduction_id->ViewValue = NULL;
			}
			$this->deduction_id->ViewCustomAttributes = "";

			// deduction_amount
			$this->deduction_amount->ViewValue = $this->deduction_amount->CurrentValue;
			$this->deduction_amount->ViewCustomAttributes = "";

			// emp_id
			$this->emp_id->ViewValue = $this->emp_id->CurrentValue;
			$this->emp_id->ViewCustomAttributes = "";

			// deduction_ref_id
			$this->deduction_ref_id->LinkCustomAttributes = "";
			$this->deduction_ref_id->HrefValue = "";
			$this->deduction_ref_id->TooltipValue = "";

			// deduction_id
			$this->deduction_id->LinkCustomAttributes = "";
			$this->deduction_id->HrefValue = "";
			$this->deduction_id->TooltipValue = "";

			// deduction_amount
			$this->deduction_amount->LinkCustomAttributes = "";
			$this->deduction_amount->HrefValue = "";
			$this->deduction_amount->TooltipValue = "";

			// emp_id
			$this->emp_id->LinkCustomAttributes = "";
			$this->emp_id->HrefValue = "";
			$this->emp_id->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// deduction_ref_id
			$this->deduction_ref_id->EditCustomAttributes = "";
			$this->deduction_ref_id->EditValue = $this->deduction_ref_id->CurrentValue;
			$this->deduction_ref_id->ViewCustomAttributes = "";

			// deduction_id
			$this->deduction_id->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `deduction_id`, `deduction_title` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `lib_deduction`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->deduction_id, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->deduction_id->EditValue = $arwrk;

			// deduction_amount
			$this->deduction_amount->EditCustomAttributes = "";
			$this->deduction_amount->EditValue = ew_HtmlEncode($this->deduction_amount->CurrentValue);
			$this->deduction_amount->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->deduction_amount->FldCaption()));

			// emp_id
			$this->emp_id->EditCustomAttributes = "";
			if ($this->emp_id->getSessionValue() <> "") {
				$this->emp_id->CurrentValue = $this->emp_id->getSessionValue();
			$this->emp_id->ViewValue = $this->emp_id->CurrentValue;
			$this->emp_id->ViewCustomAttributes = "";
			} else {
			$this->emp_id->EditValue = ew_HtmlEncode($this->emp_id->CurrentValue);
			$this->emp_id->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->emp_id->FldCaption()));
			}

			// Edit refer script
			// deduction_ref_id

			$this->deduction_ref_id->HrefValue = "";

			// deduction_id
			$this->deduction_id->HrefValue = "";

			// deduction_amount
			$this->deduction_amount->HrefValue = "";

			// emp_id
			$this->emp_id->HrefValue = "";
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
		if (!$this->deduction_id->FldIsDetailKey && !is_null($this->deduction_id->FormValue) && $this->deduction_id->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->deduction_id->FldCaption());
		}
		if (!$this->deduction_amount->FldIsDetailKey && !is_null($this->deduction_amount->FormValue) && $this->deduction_amount->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->deduction_amount->FldCaption());
		}
		if (!ew_CheckInteger($this->deduction_amount->FormValue)) {
			ew_AddMessage($gsFormError, $this->deduction_amount->FldErrMsg());
		}
		if (!ew_CheckInteger($this->emp_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->emp_id->FldErrMsg());
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

			// deduction_id
			$this->deduction_id->SetDbValueDef($rsnew, $this->deduction_id->CurrentValue, 0, $this->deduction_id->ReadOnly);

			// deduction_amount
			$this->deduction_amount->SetDbValueDef($rsnew, $this->deduction_amount->CurrentValue, 0, $this->deduction_amount->ReadOnly);

			// emp_id
			$this->emp_id->SetDbValueDef($rsnew, $this->emp_id->CurrentValue, NULL, $this->emp_id->ReadOnly);

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
			if ($sMasterTblVar == "tbl_employee") {
				$bValidMaster = TRUE;
				if (@$_GET["emp_id"] <> "") {
					$GLOBALS["tbl_employee"]->emp_id->setQueryStringValue($_GET["emp_id"]);
					$this->emp_id->setQueryStringValue($GLOBALS["tbl_employee"]->emp_id->QueryStringValue);
					$this->emp_id->setSessionValue($this->emp_id->QueryStringValue);
					if (!is_numeric($GLOBALS["tbl_employee"]->emp_id->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "tbl_employee") {
				if ($this->emp_id->QueryStringValue == "") $this->emp_id->setSessionValue("");
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
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "tbl_employee_deductionlist.php", $this->TableVar);
		$PageCaption = $Language->Phrase("edit");
		$Breadcrumb->Add("edit", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", ew_CurrentUrl(), $this->TableVar);
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'tbl_employee_deduction';
	  $usr = CurrentUserName();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		if (!$this->AuditTrailOnEdit) return;
		$table = 'tbl_employee_deduction';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['deduction_ref_id'];

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
if (!isset($tbl_employee_deduction_edit)) $tbl_employee_deduction_edit = new ctbl_employee_deduction_edit();

// Page init
$tbl_employee_deduction_edit->Page_Init();

// Page main
$tbl_employee_deduction_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tbl_employee_deduction_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var tbl_employee_deduction_edit = new ew_Page("tbl_employee_deduction_edit");
tbl_employee_deduction_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = tbl_employee_deduction_edit.PageID; // For backward compatibility

// Form object
var ftbl_employee_deductionedit = new ew_Form("ftbl_employee_deductionedit");

// Validate form
ftbl_employee_deductionedit.Validate = function() {
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
ftbl_employee_deductionedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_employee_deductionedit.ValidateRequired = true;
<?php } else { ?>
ftbl_employee_deductionedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftbl_employee_deductionedit.Lists["x_deduction_id"] = {"LinkField":"x_deduction_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_deduction_title","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $tbl_employee_deduction_edit->ShowPageHeader(); ?>
<?php
$tbl_employee_deduction_edit->ShowMessage();
?>
<form name="ftbl_employee_deductionedit" id="ftbl_employee_deductionedit" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="tbl_employee_deduction">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_tbl_employee_deductionedit" class="table table-bordered table-striped">
<?php if ($tbl_employee_deduction->deduction_ref_id->Visible) { // deduction_ref_id ?>
	<tr id="r_deduction_ref_id">
		<td><span id="elh_tbl_employee_deduction_deduction_ref_id"><?php echo $tbl_employee_deduction->deduction_ref_id->FldCaption() ?></span></td>
		<td<?php echo $tbl_employee_deduction->deduction_ref_id->CellAttributes() ?>>
<span id="el_tbl_employee_deduction_deduction_ref_id" class="control-group">
<span<?php echo $tbl_employee_deduction->deduction_ref_id->ViewAttributes() ?>>
<?php echo $tbl_employee_deduction->deduction_ref_id->EditValue ?></span>
</span>
<input type="hidden" data-field="x_deduction_ref_id" name="x_deduction_ref_id" id="x_deduction_ref_id" value="<?php echo ew_HtmlEncode($tbl_employee_deduction->deduction_ref_id->CurrentValue) ?>">
<?php echo $tbl_employee_deduction->deduction_ref_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_employee_deduction->deduction_id->Visible) { // deduction_id ?>
	<tr id="r_deduction_id">
		<td><span id="elh_tbl_employee_deduction_deduction_id"><?php echo $tbl_employee_deduction->deduction_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_employee_deduction->deduction_id->CellAttributes() ?>>
<span id="el_tbl_employee_deduction_deduction_id" class="control-group">
<select data-field="x_deduction_id" id="x_deduction_id" name="x_deduction_id"<?php echo $tbl_employee_deduction->deduction_id->EditAttributes() ?>>
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
?>
</select>
<script type="text/javascript">
ftbl_employee_deductionedit.Lists["x_deduction_id"].Options = <?php echo (is_array($tbl_employee_deduction->deduction_id->EditValue)) ? ew_ArrayToJson($tbl_employee_deduction->deduction_id->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php echo $tbl_employee_deduction->deduction_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_employee_deduction->deduction_amount->Visible) { // deduction_amount ?>
	<tr id="r_deduction_amount">
		<td><span id="elh_tbl_employee_deduction_deduction_amount"><?php echo $tbl_employee_deduction->deduction_amount->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_employee_deduction->deduction_amount->CellAttributes() ?>>
<span id="el_tbl_employee_deduction_deduction_amount" class="control-group">
<input type="text" data-field="x_deduction_amount" name="x_deduction_amount" id="x_deduction_amount" size="30" placeholder="<?php echo $tbl_employee_deduction->deduction_amount->PlaceHolder ?>" value="<?php echo $tbl_employee_deduction->deduction_amount->EditValue ?>"<?php echo $tbl_employee_deduction->deduction_amount->EditAttributes() ?>>
</span>
<?php echo $tbl_employee_deduction->deduction_amount->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_employee_deduction->emp_id->Visible) { // emp_id ?>
	<tr id="r_emp_id">
		<td><span id="elh_tbl_employee_deduction_emp_id"><?php echo $tbl_employee_deduction->emp_id->FldCaption() ?></span></td>
		<td<?php echo $tbl_employee_deduction->emp_id->CellAttributes() ?>>
<?php if ($tbl_employee_deduction->emp_id->getSessionValue() <> "") { ?>
<span<?php echo $tbl_employee_deduction->emp_id->ViewAttributes() ?>>
<?php echo $tbl_employee_deduction->emp_id->ViewValue ?></span>
<input type="hidden" id="x_emp_id" name="x_emp_id" value="<?php echo ew_HtmlEncode($tbl_employee_deduction->emp_id->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_emp_id" name="x_emp_id" id="x_emp_id" size="30" placeholder="<?php echo $tbl_employee_deduction->emp_id->PlaceHolder ?>" value="<?php echo $tbl_employee_deduction->emp_id->EditValue ?>"<?php echo $tbl_employee_deduction->emp_id->EditAttributes() ?>>
<?php } ?>
<?php echo $tbl_employee_deduction->emp_id->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("EditBtn") ?></button>
</form>
<script type="text/javascript">
ftbl_employee_deductionedit.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$tbl_employee_deduction_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_employee_deduction_edit->Page_Terminate();
?>
