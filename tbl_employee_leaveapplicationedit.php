<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "tbl_employee_leaveapplicationinfo.php" ?>
<?php include_once "tbl_userinfo.php" ?>
<?php include_once "tbl_leavecoveragegridcls.php" ?>
<?php include_once "userfn10.php" ?>
<?php include_once "model/DAO.php" ?>
<?php include_once "model/leaveApplicationDAO.php" ?>
<?php include_once "model/leaveCreditDAO.php" ?>
<?php

//
// Page class
//

$tbl_employee_leaveapplication_edit = NULL; // Initialize page object first

class ctbl_employee_leaveapplication_edit extends ctbl_employee_leaveapplication {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}";

	// Table name
	var $TableName = 'tbl_employee_leaveapplication';

	// Page object name
	var $PageObjName = 'tbl_employee_leaveapplication_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("tbl_employee_leaveapplicationlist.php");
		}

		// Create form object
		$objForm = new cFormObj();
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
	var $DbMasterFilter;
	var $DbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Load key from QueryString
		if (@$_GET["leave_application_id"] <> "") {
			$this->leave_application_id->setQueryStringValue($_GET["leave_application_id"]);
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Set up detail parameters
			$this->SetUpDetailParms();
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->leave_application_id->CurrentValue == "")
			$this->Page_Terminate("tbl_employee_leaveapplicationlist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("tbl_employee_leaveapplicationlist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			Case "U": // Update
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					if ($this->getCurrentDetailTable() <> "") // Master/detail edit
						// $sReturnUrl = $this->GetDetailUrl();
						$sReturnUrl = "tbl_employee_leaveapplicationlist.php";//carla
					else
						// $sReturnUrl = $this->getReturnUrl();
						$sReturnUrl = "tbl_employee_leaveapplicationlist.php";//carla
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed

					// Set up detail parameters
					$this->SetUpDetailParms();
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
		if (!$this->leave_application_id->FldIsDetailKey)
			$this->leave_application_id->setFormValue($objForm->GetValue("x_leave_application_id"));
		if (!$this->emp_id->FldIsDetailKey) {
			$this->emp_id->setFormValue($objForm->GetValue("x_emp_id"));
		}
		if (!$this->leave_type_id->FldIsDetailKey) {
			$this->leave_type_id->setFormValue($objForm->GetValue("x_leave_type_id"));
		}
		if (!$this->sickness->FldIsDetailKey) {
			$this->sickness->setFormValue($objForm->GetValue("x_sickness"));
		}
		if (!$this->place_to_visit->FldIsDetailKey) {
			$this->place_to_visit->setFormValue($objForm->GetValue("x_place_to_visit"));
		}
		if (!$this->days_to_leave->FldIsDetailKey) {
			$this->days_to_leave->setFormValue($objForm->GetValue("x_days_to_leave"));
		}
		if (!$this->status_id->FldIsDetailKey) {
			$this->status_id->setFormValue($objForm->GetValue("x_status_id"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->leave_application_id->CurrentValue = $this->leave_application_id->FormValue;
		$this->emp_id->CurrentValue = $this->emp_id->FormValue;
		$this->leave_type_id->CurrentValue = $this->leave_type_id->FormValue;
		$this->sickness->CurrentValue = $this->sickness->FormValue;
		$this->place_to_visit->CurrentValue = $this->place_to_visit->FormValue;
		$this->days_to_leave->CurrentValue = $this->days_to_leave->FormValue;
		$this->status_id->CurrentValue = $this->status_id->FormValue;
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
			// $sWhereWrk = "";
			//carla
			
			if(CurrentUserLevel() == 2)
			{
				$sWhereWrk = "status_id = 1";
			}else{
				$sWhereWrk = "";
			}
			
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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// leave_application_id
			$this->leave_application_id->EditCustomAttributes = "";
			$this->leave_application_id->EditValue = $this->leave_application_id->CurrentValue;
			$this->leave_application_id->ViewCustomAttributes = "";

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

			// leave_type_id
			$this->leave_type_id->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `leave_type_id`, `leave_type_title` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `lib_leave`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->leave_type_id, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->leave_type_id->EditValue = $arwrk;

			// sickness
			$this->sickness->EditCustomAttributes = "";
			$this->sickness->EditValue = ew_HtmlEncode($this->sickness->CurrentValue);
			$this->sickness->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->sickness->FldCaption()));

			// place_to_visit
			$this->place_to_visit->EditCustomAttributes = "";
			$this->place_to_visit->EditValue = ew_HtmlEncode($this->place_to_visit->CurrentValue);
			$this->place_to_visit->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->place_to_visit->FldCaption()));

			// days_to_leave
			$this->days_to_leave->EditCustomAttributes = "";
			$this->days_to_leave->EditValue = ew_HtmlEncode($this->days_to_leave->CurrentValue);
			$this->days_to_leave->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->days_to_leave->FldCaption()));

			// status_id
			$this->status_id->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `status_id`, `status_title` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `lib_status`";
			// $sWhereWrk = "";
			//carla
			
			if(CurrentUserLevel() == 2)
			{
				$sWhereWrk = "status_id = 1";
			}else{
				$sWhereWrk = "";
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->status_id, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->status_id->EditValue = $arwrk;

			// Edit refer script
			// leave_application_id

			$this->leave_application_id->HrefValue = "";

			// emp_id
			$this->emp_id->HrefValue = "";

			// leave_type_id
			$this->leave_type_id->HrefValue = "";

			// sickness
			$this->sickness->HrefValue = "";

			// place_to_visit
			$this->place_to_visit->HrefValue = "";

			// days_to_leave
			$this->days_to_leave->HrefValue = "";

			// status_id
			$this->status_id->HrefValue = "";
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
		if (!$this->leave_type_id->FldIsDetailKey && !is_null($this->leave_type_id->FormValue) && $this->leave_type_id->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->leave_type_id->FldCaption());
		}
		if (!$this->days_to_leave->FldIsDetailKey && !is_null($this->days_to_leave->FormValue) && $this->days_to_leave->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->days_to_leave->FldCaption());
		}
		if (!ew_CheckInteger($this->days_to_leave->FormValue)) {
			ew_AddMessage($gsFormError, $this->days_to_leave->FldErrMsg());
		}
		if (!$this->status_id->FldIsDetailKey && !is_null($this->status_id->FormValue) && $this->status_id->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->status_id->FldCaption());
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("tbl_leavecoverage", $DetailTblVar) && $GLOBALS["tbl_leavecoverage"]->DetailEdit) {
			if (!isset($GLOBALS["tbl_leavecoverage_grid"])) $GLOBALS["tbl_leavecoverage_grid"] = new ctbl_leavecoverage_grid(); // get detail page object
			$GLOBALS["tbl_leavecoverage_grid"]->ValidateGridForm();
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

			// Begin transaction
			if ($this->getCurrentDetailTable() <> "")
				$conn->BeginTrans();

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// emp_id
			$this->emp_id->SetDbValueDef($rsnew, $this->emp_id->CurrentValue, 0, $this->emp_id->ReadOnly);

			// leave_type_id
			$this->leave_type_id->SetDbValueDef($rsnew, $this->leave_type_id->CurrentValue, 0, $this->leave_type_id->ReadOnly);

			// sickness
			$this->sickness->SetDbValueDef($rsnew, $this->sickness->CurrentValue, NULL, $this->sickness->ReadOnly);

			// place_to_visit
			$this->place_to_visit->SetDbValueDef($rsnew, $this->place_to_visit->CurrentValue, NULL, $this->place_to_visit->ReadOnly);

			// days_to_leave
			$this->days_to_leave->SetDbValueDef($rsnew, $this->days_to_leave->CurrentValue, NULL, $this->days_to_leave->ReadOnly);

			// status_id
			$this->status_id->SetDbValueDef($rsnew, $this->status_id->CurrentValue, 0, $this->status_id->ReadOnly);

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

				// Update detail records
				if ($EditRow) {
					$DetailTblVar = explode(",", $this->getCurrentDetailTable());
					if (in_array("tbl_leavecoverage", $DetailTblVar) && $GLOBALS["tbl_leavecoverage"]->DetailEdit) {
						if (!isset($GLOBALS["tbl_leavecoverage_grid"])) $GLOBALS["tbl_leavecoverage_grid"] = new ctbl_leavecoverage_grid(); // Get detail page object
						$EditRow = $GLOBALS["tbl_leavecoverage_grid"]->GridUpdate();
					}
				}

				// Commit/Rollback transaction
				if ($this->getCurrentDetailTable() <> "") {
					if ($EditRow) {
						$conn->CommitTrans(); // Commit transaction
					} else {
						$conn->RollbackTrans(); // Rollback transaction
					}
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

	// Set up detail parms based on QueryString
	function SetUpDetailParms() {

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_DETAIL])) {
			$sDetailTblVar = $_GET[EW_TABLE_SHOW_DETAIL];
			$this->setCurrentDetailTable($sDetailTblVar);
		} else {
			$sDetailTblVar = $this->getCurrentDetailTable();
		}
		if ($sDetailTblVar <> "") {
			$DetailTblVar = explode(",", $sDetailTblVar);
			if (in_array("tbl_leavecoverage", $DetailTblVar)) {
				if (!isset($GLOBALS["tbl_leavecoverage_grid"]))
					$GLOBALS["tbl_leavecoverage_grid"] = new ctbl_leavecoverage_grid;
				if ($GLOBALS["tbl_leavecoverage_grid"]->DetailEdit) {
					$GLOBALS["tbl_leavecoverage_grid"]->CurrentMode = "edit";
					$GLOBALS["tbl_leavecoverage_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["tbl_leavecoverage_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["tbl_leavecoverage_grid"]->setStartRecordNumber(1);
					$GLOBALS["tbl_leavecoverage_grid"]->leave_application_id->FldIsDetailKey = TRUE;
					$GLOBALS["tbl_leavecoverage_grid"]->leave_application_id->CurrentValue = $this->leave_application_id->CurrentValue;
					$GLOBALS["tbl_leavecoverage_grid"]->leave_application_id->setSessionValue($GLOBALS["tbl_leavecoverage_grid"]->leave_application_id->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "tbl_employee_leaveapplicationlist.php", $this->TableVar);
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
if (!isset($tbl_employee_leaveapplication_edit)) $tbl_employee_leaveapplication_edit = new ctbl_employee_leaveapplication_edit();

// Page init
$tbl_employee_leaveapplication_edit->Page_Init();

// Page main
$tbl_employee_leaveapplication_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tbl_employee_leaveapplication_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var tbl_employee_leaveapplication_edit = new ew_Page("tbl_employee_leaveapplication_edit");
tbl_employee_leaveapplication_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = tbl_employee_leaveapplication_edit.PageID; // For backward compatibility

// Form object
var ftbl_employee_leaveapplicationedit = new ew_Form("ftbl_employee_leaveapplicationedit");

// Validate form
ftbl_employee_leaveapplicationedit.Validate = function() {
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
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_employee_leaveapplication->emp_id->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_emp_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tbl_employee_leaveapplication->emp_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_leave_type_id");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_employee_leaveapplication->leave_type_id->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_days_to_leave");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_employee_leaveapplication->days_to_leave->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_days_to_leave");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tbl_employee_leaveapplication->days_to_leave->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_status_id");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_employee_leaveapplication->status_id->FldCaption()) ?>");

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
ftbl_employee_leaveapplicationedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_employee_leaveapplicationedit.ValidateRequired = true;
<?php } else { ?>
ftbl_employee_leaveapplicationedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftbl_employee_leaveapplicationedit.Lists["x_emp_id"] = {"LinkField":"x_emp_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_empLastName","x_empFirstName","x_empMiddleName",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_employee_leaveapplicationedit.Lists["x_leave_type_id"] = {"LinkField":"x_leave_type_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_leave_type_title","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_employee_leaveapplicationedit.Lists["x_status_id"] = {"LinkField":"x_status_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_status_title","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $tbl_employee_leaveapplication_edit->ShowPageHeader(); ?>
<?php
$tbl_employee_leaveapplication_edit->ShowMessage();
?>

<form name="ftbl_employee_leaveapplicationedit" id="ftbl_employee_leaveapplicationedit" class="ewForm form-horizontal" action="<?php echo "tbl_employee_leaveapplicationlist.php";  ?>" method="post">
<input type="hidden" name="t" value="tbl_employee_leaveapplication">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_tbl_employee_leaveapplicationedit" class="table table-bordered table-striped">
<?php if ($tbl_employee_leaveapplication->leave_application_id->Visible) { // leave_application_id ?>
	<tr id="r_leave_application_id">
		<td><span id="elh_tbl_employee_leaveapplication_leave_application_id"><?php echo $tbl_employee_leaveapplication->leave_application_id->FldCaption() ?></span></td>
		<td<?php echo $tbl_employee_leaveapplication->leave_application_id->CellAttributes() ?>>
<span id="el_tbl_employee_leaveapplication_leave_application_id" class="control-group">
<span<?php echo $tbl_employee_leaveapplication->leave_application_id->ViewAttributes() ?>>
<?php echo $tbl_employee_leaveapplication->leave_application_id->EditValue ?></span>
</span>
<input type="hidden" data-field="x_leave_application_id" name="x_leave_application_id" id="x_leave_application_id" value="<?php echo ew_HtmlEncode($tbl_employee_leaveapplication->leave_application_id->CurrentValue) ?>">
<?php echo $tbl_employee_leaveapplication->leave_application_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_employee_leaveapplication->emp_id->Visible) { // emp_id ?>
	<?php /*<tr id="r_emp_id">
		<td><span id="elh_tbl_employee_leaveapplication_emp_id"><?php echo $tbl_employee_leaveapplication->emp_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_employee_leaveapplication->emp_id->CellAttributes() ?>>
<span id="el_tbl_employee_leaveapplication_emp_id" class="control-group">
<?php
	$wrkonchange = trim(" " . @$tbl_employee_leaveapplication->emp_id->EditAttrs["onchange"]);
	if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
	$tbl_employee_leaveapplication->emp_id->EditAttrs["onchange"] = "";
?>*/ ?>
<span id="as_x_emp_id" style="white-space: nowrap; z-index: 8980">
	<input type="hidden" name="sv_x_emp_id" id="sv_x_emp_id" value="<?php echo $tbl_employee_leaveapplication->emp_id->EditValue ?>" size="30" placeholder="<?php echo $tbl_employee_leaveapplication->emp_id->PlaceHolder ?>"<?php echo $tbl_employee_leaveapplication->emp_id->EditAttributes() ?>>&nbsp;<span id="em_x_emp_id" class="ewMessage" style="display: none"><?php echo str_replace("%f", "phpimages/", $Language->Phrase("UnmatchedValue")) ?></span>
	<div id="sc_x_emp_id" style="display: inline; z-index: 8980"></div>
</span>
<input type="hidden" data-field="x_emp_id" name="x_emp_id" id="x_emp_id" value="<?php echo $tbl_employee_leaveapplication->emp_id->CurrentValue ?>"<?php echo $wrkonchange ?>>
<?php
$sSqlWrk = "SELECT `emp_id`, `empLastName` AS `DispFld`, `empFirstName` AS `Disp2Fld`, `empMiddleName` AS `Disp3Fld` FROM `tbl_employee`";
$sWhereWrk = "`empLastName` LIKE '{query_value}%' OR CONCAT(`empLastName`,'" . ew_ValueSeparator(1, $Page->emp_id) . "',`empFirstName`,'" . ew_ValueSeparator(2, $Page->emp_id) . "',`empMiddleName`) LIKE '{query_value}%'";

// Call Lookup selecting
$tbl_employee_leaveapplication->Lookup_Selecting($tbl_employee_leaveapplication->emp_id, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
?>
<input type="hidden" name="q_x_emp_id" id="q_x_emp_id" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>">
<script type="text/javascript">
var oas = new ew_AutoSuggest("x_emp_id", ftbl_employee_leaveapplicationedit, false, EW_AUTO_SUGGEST_MAX_ENTRIES);
oas.formatResult = function(ar) {
	var dv = ar[1];
	for (var i = 2; i <= 4; i++)
		dv += (ar[i]) ? ew_ValueSeparator(i - 1, "x_emp_id") + ar[i] : "";
	return dv;
}
ftbl_employee_leaveapplicationedit.AutoSuggests["x_emp_id"] = oas;
</script>
</span>
<?php echo $tbl_employee_leaveapplication->emp_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_employee_leaveapplication->leave_type_id->Visible) { // leave_type_id ?>
	<tr id="r_leave_type_id">
		<td><span id="elh_tbl_employee_leaveapplication_leave_type_id"><?php echo $tbl_employee_leaveapplication->leave_type_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_employee_leaveapplication->leave_type_id->CellAttributes() ?>>
<span id="el_tbl_employee_leaveapplication_leave_type_id" class="control-group">
<select data-field="x_leave_type_id" id="x_leave_type_id" name="x_leave_type_id"<?php echo $tbl_employee_leaveapplication->leave_type_id->EditAttributes() ?>>
<?php
if (is_array($tbl_employee_leaveapplication->leave_type_id->EditValue)) {
	$arwrk = $tbl_employee_leaveapplication->leave_type_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_employee_leaveapplication->leave_type_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
ftbl_employee_leaveapplicationedit.Lists["x_leave_type_id"].Options = <?php echo (is_array($tbl_employee_leaveapplication->leave_type_id->EditValue)) ? ew_ArrayToJson($tbl_employee_leaveapplication->leave_type_id->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php echo $tbl_employee_leaveapplication->leave_type_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_employee_leaveapplication->sickness->Visible) { // sickness ?>
	<tr id="r_sickness">
		<td><span id="elh_tbl_employee_leaveapplication_sickness"><?php echo $tbl_employee_leaveapplication->sickness->FldCaption() ?></span></td>
		<td<?php echo $tbl_employee_leaveapplication->sickness->CellAttributes() ?>>
<span id="el_tbl_employee_leaveapplication_sickness" class="control-group">
<input type="text" data-field="x_sickness" name="x_sickness" id="x_sickness" size="30" maxlength="255" placeholder="<?php echo $tbl_employee_leaveapplication->sickness->PlaceHolder ?>" value="<?php echo $tbl_employee_leaveapplication->sickness->EditValue ?>"<?php echo $tbl_employee_leaveapplication->sickness->EditAttributes() ?>>
</span>
<?php echo $tbl_employee_leaveapplication->sickness->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php /*
<?php if ($tbl_employee_leaveapplication->place_to_visit->Visible) { // place_to_visit ?>
	<tr id="r_place_to_visit">
		<td><span id="elh_tbl_employee_leaveapplication_place_to_visit"><?php echo $tbl_employee_leaveapplication->place_to_visit->FldCaption() ?></span></td>
		<td<?php echo $tbl_employee_leaveapplication->place_to_visit->CellAttributes() ?>>
<span id="el_tbl_employee_leaveapplication_place_to_visit" class="control-group">
<input type="text" data-field="x_place_to_visit" name="x_place_to_visit" id="x_place_to_visit" size="30" maxlength="255" placeholder="<?php echo $tbl_employee_leaveapplication->place_to_visit->PlaceHolder ?>" value="<?php echo $tbl_employee_leaveapplication->place_to_visit->EditValue ?>"<?php echo $tbl_employee_leaveapplication->place_to_visit->EditAttributes() ?>>
</span>
<?php echo $tbl_employee_leaveapplication->place_to_visit->CustomMsg ?></td>
	</tr>
<?php } ?>
*/ ?>
<?php if ($tbl_employee_leaveapplication->days_to_leave->Visible) { // days_to_leave ?>
	<tr id="r_days_to_leave">
		<td><span id="elh_tbl_employee_leaveapplication_days_to_leave"><?php echo $tbl_employee_leaveapplication->days_to_leave->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_employee_leaveapplication->days_to_leave->CellAttributes() ?>>
<span id="el_tbl_employee_leaveapplication_days_to_leave" class="control-group">
<input type="text" data-field="x_days_to_leave" name="x_days_to_leave" id="x_days_to_leave" size="30" placeholder="<?php echo $tbl_employee_leaveapplication->days_to_leave->PlaceHolder ?>" value="<?php echo $tbl_employee_leaveapplication->days_to_leave->EditValue ?>"<?php echo $tbl_employee_leaveapplication->days_to_leave->EditAttributes() ?>>
</span>
<?php echo $tbl_employee_leaveapplication->days_to_leave->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_employee_leaveapplication->status_id->Visible) { // status_id ?>
	<tr id="r_status_id">
		<td><span id="elh_tbl_employee_leaveapplication_status_id"><?php echo $tbl_employee_leaveapplication->status_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_employee_leaveapplication->status_id->CellAttributes() ?>>
<span id="el_tbl_employee_leaveapplication_status_id" class="control-group">
<select data-field="x_status_id" id="x_status_id" name="x_status_id"<?php echo $tbl_employee_leaveapplication->status_id->EditAttributes() ?>>
<?php
if (is_array($tbl_employee_leaveapplication->status_id->EditValue)) {
	$arwrk = $tbl_employee_leaveapplication->status_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_employee_leaveapplication->status_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
ftbl_employee_leaveapplicationedit.Lists["x_status_id"].Options = <?php echo (is_array($tbl_employee_leaveapplication->status_id->EditValue)) ? ew_ArrayToJson($tbl_employee_leaveapplication->status_id->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php echo $tbl_employee_leaveapplication->status_id->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<?php
	if (in_array("tbl_leavecoverage", explode(",", $tbl_employee_leaveapplication->getCurrentDetailTable())) && $tbl_leavecoverage->DetailEdit) {
?>
<?php include_once "tbl_leavecoveragegrid.php" ?>
<?php } ?>
	<script language="javascript">
		function checkMe() {

			alert("Update Succeeded");
			location.reload();
			return true;

			/*if (confirm("Are you sure")) {
				location.reload();
				return true;*/
			}
		}
	</script>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" onClick="return checkMe()" type="submit"><?php echo $Language->Phrase("EditBtn") ?></button>
</form>
<script type="text/javascript">
ftbl_employee_leaveapplicationedit.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$tbl_employee_leaveapplication_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_employee_leaveapplication_edit->Page_Terminate();
?>
