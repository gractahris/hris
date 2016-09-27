<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "tbl_employeeinfo.php" ?>
<?php include_once "tbl_userinfo.php" ?>
<?php include_once "tbl_employee_deductiongridcls.php" ?>
<?php include_once "tbl_employee_leavecreditgridcls.php" ?>
<?php include_once "userfn10.php" ?>
<?php include_once "model/DAO.php" ?>
<?php include_once "model/createDTRDAO.php" ?>
<?php

//
// Page class
//

$tbl_employee_add = NULL; // Initialize page object first

class ctbl_employee_add extends ctbl_employee {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}";

	// Table name
	var $TableName = 'tbl_employee';

	// Page object name
	var $PageObjName = 'tbl_employee_add';

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
	var $AuditTrailOnAdd = TRUE;

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

		// Table object (tbl_employee)
		if (!isset($GLOBALS["tbl_employee"])) {
			$GLOBALS["tbl_employee"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbl_employee"];
		}

		// Table object (tbl_user)
		if (!isset($GLOBALS['tbl_user'])) $GLOBALS['tbl_user'] = new ctbl_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_employee', TRUE);

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
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("tbl_employeelist.php?emp_id=3");
			//carla
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up curent action

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
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["emp_id"] != "") {
				$this->emp_id->setQueryStringValue($_GET["emp_id"]);
				$this->setKey("emp_id", $this->emp_id->CurrentValue); // Set up key
			} else {
				$this->setKey("emp_id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
				$this->LoadDefaultValues(); // Load default values
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Set up detail parameters
		$this->SetUpDetailParms();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("tbl_employeelist.php?emp_id=3"); // No matching record, return to list carla
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					if ($this->getCurrentDetailTable() <> "") // Master/detail add
						$sReturnUrl = $this->GetDetailUrl();
					else
					{
						//$sReturnUrl = $this->getReturnUrl();
						$sReturnUrl = $this->getReturnUrl()."?emp_id=".$this->emp_id->CurrentValue;
						$_SESSION['hris_Success_Message'] = "Add Succeeded";
					}
					if (ew_GetPageName($sReturnUrl) == "tbl_employeeview.php")
						$sReturnUrl = $this->GetViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values

					// Set up detail parameters
					$this->SetUpDetailParms();
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->empFirstName->CurrentValue = NULL;
		$this->empFirstName->OldValue = $this->empFirstName->CurrentValue;
		$this->empMiddleName->CurrentValue = NULL;
		$this->empMiddleName->OldValue = $this->empMiddleName->CurrentValue;
		$this->empLastName->CurrentValue = NULL;
		$this->empLastName->OldValue = $this->empLastName->CurrentValue;
		$this->empExtensionName->CurrentValue = NULL;
		$this->empExtensionName->OldValue = $this->empExtensionName->CurrentValue;
		$this->sex_id->CurrentValue = NULL;
		$this->sex_id->OldValue = $this->sex_id->CurrentValue;
		$this->schedule_id->CurrentValue = NULL;
		$this->schedule_id->OldValue = $this->schedule_id->CurrentValue;
		$this->salary_id->CurrentValue = NULL;
		$this->salary_id->OldValue = $this->salary_id->CurrentValue;
		$this->tax_category_id->CurrentValue = NULL;
		$this->tax_category_id->OldValue = $this->tax_category_id->CurrentValue;
		$this->date_hired->CurrentValue = NULL;
		$this->date_hired->OldValue = $this->date_hired->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->empFirstName->FldIsDetailKey) {
			$this->empFirstName->setFormValue($objForm->GetValue("x_empFirstName"));
		}
		if (!$this->empMiddleName->FldIsDetailKey) {
			$this->empMiddleName->setFormValue($objForm->GetValue("x_empMiddleName"));
		}
		if (!$this->empLastName->FldIsDetailKey) {
			$this->empLastName->setFormValue($objForm->GetValue("x_empLastName"));
		}
		if (!$this->empExtensionName->FldIsDetailKey) {
			$this->empExtensionName->setFormValue($objForm->GetValue("x_empExtensionName"));
		}
		if (!$this->sex_id->FldIsDetailKey) {
			$this->sex_id->setFormValue($objForm->GetValue("x_sex_id"));
		}
		if (!$this->schedule_id->FldIsDetailKey) {
			$this->schedule_id->setFormValue($objForm->GetValue("x_schedule_id"));
		}
		if (!$this->salary_id->FldIsDetailKey) {
			$this->salary_id->setFormValue($objForm->GetValue("x_salary_id"));
		}
		if (!$this->tax_category_id->FldIsDetailKey) {
			$this->tax_category_id->setFormValue($objForm->GetValue("x_tax_category_id"));
		}
		if (!$this->date_hired->FldIsDetailKey) {
			$this->date_hired->setFormValue($objForm->GetValue("x_date_hired"));
			$this->date_hired->CurrentValue = ew_UnFormatDateTime($this->date_hired->CurrentValue, 5);
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->empFirstName->CurrentValue = $this->empFirstName->FormValue;
		$this->empMiddleName->CurrentValue = $this->empMiddleName->FormValue;
		$this->empLastName->CurrentValue = $this->empLastName->FormValue;
		$this->empExtensionName->CurrentValue = $this->empExtensionName->FormValue;
		$this->sex_id->CurrentValue = $this->sex_id->FormValue;
		$this->schedule_id->CurrentValue = $this->schedule_id->FormValue;
		$this->salary_id->CurrentValue = $this->salary_id->FormValue;
		$this->tax_category_id->CurrentValue = $this->tax_category_id->FormValue;
		$this->date_hired->CurrentValue = $this->date_hired->FormValue;
		$this->date_hired->CurrentValue = ew_UnFormatDateTime($this->date_hired->CurrentValue, 5);
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
		$this->emp_id->setDbValue($rs->fields('emp_id'));
		$this->empFirstName->setDbValue($rs->fields('empFirstName'));
		$this->empMiddleName->setDbValue($rs->fields('empMiddleName'));
		$this->empLastName->setDbValue($rs->fields('empLastName'));
		$this->empExtensionName->setDbValue($rs->fields('empExtensionName'));
		$this->sex_id->setDbValue($rs->fields('sex_id'));
		$this->schedule_id->setDbValue($rs->fields('schedule_id'));
		$this->salary_id->setDbValue($rs->fields('salary_id'));
		$this->tax_category_id->setDbValue($rs->fields('tax_category_id'));
		$this->date_hired->setDbValue($rs->fields('date_hired'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->emp_id->DbValue = $row['emp_id'];
		$this->empFirstName->DbValue = $row['empFirstName'];
		$this->empMiddleName->DbValue = $row['empMiddleName'];
		$this->empLastName->DbValue = $row['empLastName'];
		$this->empExtensionName->DbValue = $row['empExtensionName'];
		$this->sex_id->DbValue = $row['sex_id'];
		$this->schedule_id->DbValue = $row['schedule_id'];
		$this->salary_id->DbValue = $row['salary_id'];
		$this->tax_category_id->DbValue = $row['tax_category_id'];
		$this->date_hired->DbValue = $row['date_hired'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("emp_id")) <> "")
			$this->emp_id->CurrentValue = $this->getKey("emp_id"); // emp_id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// emp_id
			$this->emp_id->ViewValue = $this->emp_id->CurrentValue;
			$this->emp_id->ViewCustomAttributes = "";

			// empFirstName
			$this->empFirstName->ViewValue = $this->empFirstName->CurrentValue;
			$this->empFirstName->ViewCustomAttributes = "";

			// empMiddleName
			$this->empMiddleName->ViewValue = $this->empMiddleName->CurrentValue;
			$this->empMiddleName->ViewCustomAttributes = "";

			// empLastName
			$this->empLastName->ViewValue = $this->empLastName->CurrentValue;
			$this->empLastName->ViewCustomAttributes = "";

			// empExtensionName
			$this->empExtensionName->ViewValue = $this->empExtensionName->CurrentValue;
			$this->empExtensionName->ViewCustomAttributes = "";

			// sex_id
			if (strval($this->sex_id->CurrentValue) <> "") {
				$sFilterWrk = "`sex_id`" . ew_SearchString("=", $this->sex_id->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `sex_id`, `sex_title` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lib_sex`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->sex_id, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->sex_id->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->sex_id->ViewValue = $this->sex_id->CurrentValue;
				}
			} else {
				$this->sex_id->ViewValue = NULL;
			}
			$this->sex_id->ViewCustomAttributes = "";

			// schedule_id
			if (strval($this->schedule_id->CurrentValue) <> "") {
				$sFilterWrk = "`schedule_id`" . ew_SearchString("=", $this->schedule_id->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `schedule_id`, `schedule_title` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lib_schedule`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->schedule_id, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->schedule_id->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->schedule_id->ViewValue = $this->schedule_id->CurrentValue;
				}
			} else {
				$this->schedule_id->ViewValue = NULL;
			}
			$this->schedule_id->ViewCustomAttributes = "";

			// salary_id
			if (strval($this->salary_id->CurrentValue) <> "") {
				$sFilterWrk = "`salary_id`" . ew_SearchString("=", $this->salary_id->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `salary_id`, `salary_amount` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lib_salary`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->salary_id, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->salary_id->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->salary_id->ViewValue = $this->salary_id->CurrentValue;
				}
			} else {
				$this->salary_id->ViewValue = NULL;
			}
			$this->salary_id->ViewCustomAttributes = "";

			// tax_category_id
			if (strval($this->tax_category_id->CurrentValue) <> "") {
				$sFilterWrk = "`tax_category_id`" . ew_SearchString("=", $this->tax_category_id->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `tax_category_id`, `tax_category_code` AS `DispFld`, `tax_category_title` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lib_tax_category`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->tax_category_id, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->tax_category_id->ViewValue = $rswrk->fields('DispFld');
					$this->tax_category_id->ViewValue .= ew_ValueSeparator(1,$this->tax_category_id) . $rswrk->fields('Disp2Fld');
					$rswrk->Close();
				} else {
					$this->tax_category_id->ViewValue = $this->tax_category_id->CurrentValue;
				}
			} else {
				$this->tax_category_id->ViewValue = NULL;
			}
			$this->tax_category_id->ViewCustomAttributes = "";

			// date_hired
			$this->date_hired->ViewValue = $this->date_hired->CurrentValue;
			$this->date_hired->ViewValue = ew_FormatDateTime($this->date_hired->ViewValue, 5);
			$this->date_hired->ViewCustomAttributes = "";

			// empFirstName
			$this->empFirstName->LinkCustomAttributes = "";
			$this->empFirstName->HrefValue = "";
			$this->empFirstName->TooltipValue = "";

			// empMiddleName
			$this->empMiddleName->LinkCustomAttributes = "";
			$this->empMiddleName->HrefValue = "";
			$this->empMiddleName->TooltipValue = "";

			// empLastName
			$this->empLastName->LinkCustomAttributes = "";
			$this->empLastName->HrefValue = "";
			$this->empLastName->TooltipValue = "";

			// empExtensionName
			$this->empExtensionName->LinkCustomAttributes = "";
			$this->empExtensionName->HrefValue = "";
			$this->empExtensionName->TooltipValue = "";

			// sex_id
			$this->sex_id->LinkCustomAttributes = "";
			$this->sex_id->HrefValue = "";
			$this->sex_id->TooltipValue = "";

			// schedule_id
			$this->schedule_id->LinkCustomAttributes = "";
			$this->schedule_id->HrefValue = "";
			$this->schedule_id->TooltipValue = "";

			// salary_id
			$this->salary_id->LinkCustomAttributes = "";
			$this->salary_id->HrefValue = "";
			$this->salary_id->TooltipValue = "";

			// tax_category_id
			$this->tax_category_id->LinkCustomAttributes = "";
			$this->tax_category_id->HrefValue = "";
			$this->tax_category_id->TooltipValue = "";

			// date_hired
			$this->date_hired->LinkCustomAttributes = "";
			$this->date_hired->HrefValue = "";
			$this->date_hired->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// empFirstName
			$this->empFirstName->EditCustomAttributes = "";
			$this->empFirstName->EditValue = ew_HtmlEncode($this->empFirstName->CurrentValue);
			$this->empFirstName->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->empFirstName->FldCaption()));

			// empMiddleName
			$this->empMiddleName->EditCustomAttributes = "";
			$this->empMiddleName->EditValue = ew_HtmlEncode($this->empMiddleName->CurrentValue);
			$this->empMiddleName->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->empMiddleName->FldCaption()));

			// empLastName
			$this->empLastName->EditCustomAttributes = "";
			$this->empLastName->EditValue = ew_HtmlEncode($this->empLastName->CurrentValue);
			$this->empLastName->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->empLastName->FldCaption()));

			// empExtensionName
			$this->empExtensionName->EditCustomAttributes = "";
			$this->empExtensionName->EditValue = ew_HtmlEncode($this->empExtensionName->CurrentValue);
			$this->empExtensionName->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->empExtensionName->FldCaption()));

			// sex_id
			$this->sex_id->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `sex_id`, `sex_title` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `lib_sex`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->sex_id, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->sex_id->EditValue = $arwrk;

			// schedule_id
			$this->schedule_id->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `schedule_id`, `schedule_title` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `lib_schedule`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->schedule_id, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->schedule_id->EditValue = $arwrk;

			// salary_id
			$this->salary_id->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `salary_id`, `salary_amount` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `lib_salary`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->salary_id, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->salary_id->EditValue = $arwrk;

			// tax_category_id
			$this->tax_category_id->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `tax_category_id`, `tax_category_code` AS `DispFld`, `tax_category_title` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `lib_tax_category`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->tax_category_id, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->tax_category_id->EditValue = $arwrk;

			// date_hired
			$this->date_hired->EditCustomAttributes = "";
			$this->date_hired->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->date_hired->CurrentValue, 5));
			$this->date_hired->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->date_hired->FldCaption()));

			// Edit refer script
			// empFirstName

			$this->empFirstName->HrefValue = "";

			// empMiddleName
			$this->empMiddleName->HrefValue = "";

			// empLastName
			$this->empLastName->HrefValue = "";

			// empExtensionName
			$this->empExtensionName->HrefValue = "";

			// sex_id
			$this->sex_id->HrefValue = "";

			// schedule_id
			$this->schedule_id->HrefValue = "";

			// salary_id
			$this->salary_id->HrefValue = "";

			// tax_category_id
			$this->tax_category_id->HrefValue = "";

			// date_hired
			$this->date_hired->HrefValue = "";
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
		if (!$this->empFirstName->FldIsDetailKey && !is_null($this->empFirstName->FormValue) && $this->empFirstName->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->empFirstName->FldCaption());
		}
		if (!$this->empLastName->FldIsDetailKey && !is_null($this->empLastName->FormValue) && $this->empLastName->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->empLastName->FldCaption());
		}
		if (!$this->sex_id->FldIsDetailKey && !is_null($this->sex_id->FormValue) && $this->sex_id->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->sex_id->FldCaption());
		}
		if (!$this->schedule_id->FldIsDetailKey && !is_null($this->schedule_id->FormValue) && $this->schedule_id->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->schedule_id->FldCaption());
		}
		if (!$this->salary_id->FldIsDetailKey && !is_null($this->salary_id->FormValue) && $this->salary_id->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->salary_id->FldCaption());
		}
		if (!$this->tax_category_id->FldIsDetailKey && !is_null($this->tax_category_id->FormValue) && $this->tax_category_id->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->tax_category_id->FldCaption());
		}
		if (!$this->date_hired->FldIsDetailKey && !is_null($this->date_hired->FormValue) && $this->date_hired->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->date_hired->FldCaption());
		}
		if (!ew_CheckDate($this->date_hired->FormValue)) {
			ew_AddMessage($gsFormError, $this->date_hired->FldErrMsg());
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("tbl_employee_deduction", $DetailTblVar) && $GLOBALS["tbl_employee_deduction"]->DetailAdd) {
			if (!isset($GLOBALS["tbl_employee_deduction_grid"])) $GLOBALS["tbl_employee_deduction_grid"] = new ctbl_employee_deduction_grid(); // get detail page object
			$GLOBALS["tbl_employee_deduction_grid"]->ValidateGridForm();
		}
		if (in_array("tbl_employee_leavecredit", $DetailTblVar) && $GLOBALS["tbl_employee_leavecredit"]->DetailAdd) {
			if (!isset($GLOBALS["tbl_employee_leavecredit_grid"])) $GLOBALS["tbl_employee_leavecredit_grid"] = new ctbl_employee_leavecredit_grid(); // get detail page object
			$GLOBALS["tbl_employee_leavecredit_grid"]->ValidateGridForm();
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

	// Add record
	function AddRow($rsold = NULL) {
		global $conn, $Language, $Security;

		// Begin transaction
		if ($this->getCurrentDetailTable() <> "")
			$conn->BeginTrans();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// empFirstName
		$this->empFirstName->SetDbValueDef($rsnew, $this->empFirstName->CurrentValue, "", FALSE);

		// empMiddleName
		$this->empMiddleName->SetDbValueDef($rsnew, $this->empMiddleName->CurrentValue, NULL, FALSE);

		// empLastName
		$this->empLastName->SetDbValueDef($rsnew, $this->empLastName->CurrentValue, "", FALSE);

		// empExtensionName
		$this->empExtensionName->SetDbValueDef($rsnew, $this->empExtensionName->CurrentValue, NULL, FALSE);

		// sex_id
		$this->sex_id->SetDbValueDef($rsnew, $this->sex_id->CurrentValue, 0, FALSE);

		// schedule_id
		$this->schedule_id->SetDbValueDef($rsnew, $this->schedule_id->CurrentValue, 0, FALSE);

		// salary_id
		$this->salary_id->SetDbValueDef($rsnew, $this->salary_id->CurrentValue, 0, FALSE);

		// tax_category_id
		$this->tax_category_id->SetDbValueDef($rsnew, $this->tax_category_id->CurrentValue, 0, FALSE);

		// date_hired
		$this->date_hired->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->date_hired->CurrentValue, 5), ew_CurrentDate(), FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}

		// Get insert id if necessary
		if ($AddRow) {
			$this->emp_id->setDbValue($conn->Insert_ID());
			$rsnew['emp_id'] = $this->emp_id->DbValue;
		}

		// Add detail records
		if ($AddRow) {
			$DetailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("tbl_employee_deduction", $DetailTblVar) && $GLOBALS["tbl_employee_deduction"]->DetailAdd) {
				$GLOBALS["tbl_employee_deduction"]->emp_id->setSessionValue($this->emp_id->CurrentValue); // Set master key
				if (!isset($GLOBALS["tbl_employee_deduction_grid"])) $GLOBALS["tbl_employee_deduction_grid"] = new ctbl_employee_deduction_grid(); // Get detail page object
				$AddRow = $GLOBALS["tbl_employee_deduction_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["tbl_employee_deduction"]->emp_id->setSessionValue(""); // Clear master key if insert failed
			}
			if (in_array("tbl_employee_leavecredit", $DetailTblVar) && $GLOBALS["tbl_employee_leavecredit"]->DetailAdd) {
				$GLOBALS["tbl_employee_leavecredit"]->emp_id->setSessionValue($this->emp_id->CurrentValue); // Set master key
				if (!isset($GLOBALS["tbl_employee_leavecredit_grid"])) $GLOBALS["tbl_employee_leavecredit_grid"] = new ctbl_employee_leavecredit_grid(); // Get detail page object
				$AddRow = $GLOBALS["tbl_employee_leavecredit_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["tbl_employee_leavecredit"]->emp_id->setSessionValue(""); // Clear master key if insert failed
			}
		}

		// Commit/Rollback transaction
		if ($this->getCurrentDetailTable() <> "") {
			if ($AddRow) {
				$conn->CommitTrans(); // Commit transaction
			} else {
				$conn->RollbackTrans(); // Rollback transaction
			}
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
			$this->WriteAuditTrailOnAdd($rsnew);
		}
		return $AddRow;
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
			if (in_array("tbl_employee_deduction", $DetailTblVar)) {
				if (!isset($GLOBALS["tbl_employee_deduction_grid"]))
					$GLOBALS["tbl_employee_deduction_grid"] = new ctbl_employee_deduction_grid;
				if ($GLOBALS["tbl_employee_deduction_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["tbl_employee_deduction_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["tbl_employee_deduction_grid"]->CurrentMode = "add";
					$GLOBALS["tbl_employee_deduction_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["tbl_employee_deduction_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["tbl_employee_deduction_grid"]->setStartRecordNumber(1);
					$GLOBALS["tbl_employee_deduction_grid"]->emp_id->FldIsDetailKey = TRUE;
					$GLOBALS["tbl_employee_deduction_grid"]->emp_id->CurrentValue = $this->emp_id->CurrentValue;
					$GLOBALS["tbl_employee_deduction_grid"]->emp_id->setSessionValue($GLOBALS["tbl_employee_deduction_grid"]->emp_id->CurrentValue);
				}
			}
			if (in_array("tbl_employee_leavecredit", $DetailTblVar)) {
				if (!isset($GLOBALS["tbl_employee_leavecredit_grid"]))
					$GLOBALS["tbl_employee_leavecredit_grid"] = new ctbl_employee_leavecredit_grid;
				if ($GLOBALS["tbl_employee_leavecredit_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["tbl_employee_leavecredit_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["tbl_employee_leavecredit_grid"]->CurrentMode = "add";
					$GLOBALS["tbl_employee_leavecredit_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["tbl_employee_leavecredit_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["tbl_employee_leavecredit_grid"]->setStartRecordNumber(1);
					$GLOBALS["tbl_employee_leavecredit_grid"]->emp_id->FldIsDetailKey = TRUE;
					$GLOBALS["tbl_employee_leavecredit_grid"]->emp_id->CurrentValue = $this->emp_id->CurrentValue;
					$GLOBALS["tbl_employee_leavecredit_grid"]->emp_id->setSessionValue($GLOBALS["tbl_employee_leavecredit_grid"]->emp_id->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "tbl_employeelist.php", $this->TableVar);
		$PageCaption = ($this->CurrentAction == "C") ? $Language->Phrase("Copy") : $Language->Phrase("Add");
		$Breadcrumb->Add("add", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", ew_CurrentUrl(), $this->TableVar);
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'tbl_employee';
	  $usr = CurrentUserName();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		if (!$this->AuditTrailOnAdd) return;
		$table = 'tbl_employee';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['emp_id'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
	  $usr = CurrentUserName();
		foreach (array_keys($rs) as $fldname) {
			if ($this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) {
					if (EW_AUDIT_TRAIL_TO_DATABASE)
						$newvalue = $rs[$fldname];
					else
						$newvalue = "[MEMO]"; // Memo Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) {
					$newvalue = "[XML]"; // XML Field
				} else {
					$newvalue = $rs[$fldname];
				}
				ew_WriteAuditTrail("log", $dt, $id, $usr, "A", $table, $fldname, $key, "", $newvalue);
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
if (!isset($tbl_employee_add)) $tbl_employee_add = new ctbl_employee_add();

// Page init
$tbl_employee_add->Page_Init();

// Page main
$tbl_employee_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tbl_employee_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var tbl_employee_add = new ew_Page("tbl_employee_add");
tbl_employee_add.PageID = "add"; // Page ID
var EW_PAGE_ID = tbl_employee_add.PageID; // For backward compatibility

// Form object
var ftbl_employeeadd = new ew_Form("ftbl_employeeadd");

// Validate form
ftbl_employeeadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_empFirstName");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_employee->empFirstName->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_empLastName");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_employee->empLastName->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_sex_id");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_employee->sex_id->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_schedule_id");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_employee->schedule_id->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_salary_id");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_employee->salary_id->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_tax_category_id");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_employee->tax_category_id->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_date_hired");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_employee->date_hired->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_date_hired");
			if (elm && !ew_CheckDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tbl_employee->date_hired->FldErrMsg()) ?>");

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
ftbl_employeeadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_employeeadd.ValidateRequired = true;
<?php } else { ?>
ftbl_employeeadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftbl_employeeadd.Lists["x_sex_id"] = {"LinkField":"x_sex_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_sex_title","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_employeeadd.Lists["x_schedule_id"] = {"LinkField":"x_schedule_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_schedule_title","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_employeeadd.Lists["x_salary_id"] = {"LinkField":"x_salary_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_salary_amount","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_employeeadd.Lists["x_tax_category_id"] = {"LinkField":"x_tax_category_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_tax_category_code","x_tax_category_title","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $tbl_employee_add->ShowPageHeader(); ?>
<?php
$tbl_employee_add->ShowMessage();
?>
<form name="ftbl_employeeadd" id="ftbl_employeeadd" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="tbl_employee">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_tbl_employeeadd" class="table table-bordered table-striped">
<tr>
	<td><?php

	//echo $tbl_employee->emp_id->CurrentValue;
	//echo $this->emp_id->CurrentValue;
	//echo $this->getKey("emp_id");
	//carla

	?></td>
</tr>
<?php if ($tbl_employee->empFirstName->Visible) { // empFirstName ?>
	<tr id="r_empFirstName">
		<td><span id="elh_tbl_employee_empFirstName"><?php echo $tbl_employee->empFirstName->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_employee->empFirstName->CellAttributes() ?>>
<span id="el_tbl_employee_empFirstName" class="control-group">
<input type="text" data-field="x_empFirstName" name="x_empFirstName" id="x_empFirstName" size="30" maxlength="100" placeholder="<?php echo $tbl_employee->empFirstName->PlaceHolder ?>" value="<?php echo $tbl_employee->empFirstName->EditValue ?>"<?php echo $tbl_employee->empFirstName->EditAttributes() ?>>
</span>
<?php echo $tbl_employee->empFirstName->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_employee->empMiddleName->Visible) { // empMiddleName ?>
	<tr id="r_empMiddleName">
		<td><span id="elh_tbl_employee_empMiddleName"><?php echo $tbl_employee->empMiddleName->FldCaption() ?></span></td>
		<td<?php echo $tbl_employee->empMiddleName->CellAttributes() ?>>
<span id="el_tbl_employee_empMiddleName" class="control-group">
<input type="text" data-field="x_empMiddleName" name="x_empMiddleName" id="x_empMiddleName" size="30" maxlength="100" placeholder="<?php echo $tbl_employee->empMiddleName->PlaceHolder ?>" value="<?php echo $tbl_employee->empMiddleName->EditValue ?>"<?php echo $tbl_employee->empMiddleName->EditAttributes() ?>>
</span>
<?php echo $tbl_employee->empMiddleName->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_employee->empLastName->Visible) { // empLastName ?>
	<tr id="r_empLastName">
		<td><span id="elh_tbl_employee_empLastName"><?php echo $tbl_employee->empLastName->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_employee->empLastName->CellAttributes() ?>>
<span id="el_tbl_employee_empLastName" class="control-group">
<input type="text" data-field="x_empLastName" name="x_empLastName" id="x_empLastName" size="30" maxlength="100" placeholder="<?php echo $tbl_employee->empLastName->PlaceHolder ?>" value="<?php echo $tbl_employee->empLastName->EditValue ?>"<?php echo $tbl_employee->empLastName->EditAttributes() ?>>
</span>
<?php echo $tbl_employee->empLastName->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_employee->empExtensionName->Visible) { // empExtensionName ?>
	<tr id="r_empExtensionName">
		<td><span id="elh_tbl_employee_empExtensionName"><?php echo $tbl_employee->empExtensionName->FldCaption() ?></span></td>
		<td<?php echo $tbl_employee->empExtensionName->CellAttributes() ?>>
<span id="el_tbl_employee_empExtensionName" class="control-group">
<input type="text" data-field="x_empExtensionName" name="x_empExtensionName" id="x_empExtensionName" size="30" maxlength="10" placeholder="<?php echo $tbl_employee->empExtensionName->PlaceHolder ?>" value="<?php echo $tbl_employee->empExtensionName->EditValue ?>"<?php echo $tbl_employee->empExtensionName->EditAttributes() ?>>
</span>
<?php echo $tbl_employee->empExtensionName->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_employee->sex_id->Visible) { // sex_id ?>
	<tr id="r_sex_id">
		<td><span id="elh_tbl_employee_sex_id"><?php echo $tbl_employee->sex_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_employee->sex_id->CellAttributes() ?>>
<span id="el_tbl_employee_sex_id" class="control-group">
<select data-field="x_sex_id" id="x_sex_id" name="x_sex_id"<?php echo $tbl_employee->sex_id->EditAttributes() ?>>
<?php
if (is_array($tbl_employee->sex_id->EditValue)) {
	$arwrk = $tbl_employee->sex_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_employee->sex_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
ftbl_employeeadd.Lists["x_sex_id"].Options = <?php echo (is_array($tbl_employee->sex_id->EditValue)) ? ew_ArrayToJson($tbl_employee->sex_id->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php echo $tbl_employee->sex_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_employee->schedule_id->Visible) { // schedule_id ?>
	<tr id="r_schedule_id">
		<td><span id="elh_tbl_employee_schedule_id"><?php echo $tbl_employee->schedule_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_employee->schedule_id->CellAttributes() ?>>
<span id="el_tbl_employee_schedule_id" class="control-group">
<select data-field="x_schedule_id" id="x_schedule_id" name="x_schedule_id"<?php echo $tbl_employee->schedule_id->EditAttributes() ?>>
<?php
if (is_array($tbl_employee->schedule_id->EditValue)) {
	$arwrk = $tbl_employee->schedule_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_employee->schedule_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
ftbl_employeeadd.Lists["x_schedule_id"].Options = <?php echo (is_array($tbl_employee->schedule_id->EditValue)) ? ew_ArrayToJson($tbl_employee->schedule_id->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php echo $tbl_employee->schedule_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_employee->salary_id->Visible) { // salary_id ?>
	<tr id="r_salary_id">
		<td><span id="elh_tbl_employee_salary_id"><?php echo $tbl_employee->salary_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_employee->salary_id->CellAttributes() ?>>
<span id="el_tbl_employee_salary_id" class="control-group">
<select data-field="x_salary_id" id="x_salary_id" name="x_salary_id"<?php echo $tbl_employee->salary_id->EditAttributes() ?>>
<?php
if (is_array($tbl_employee->salary_id->EditValue)) {
	$arwrk = $tbl_employee->salary_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_employee->salary_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
ftbl_employeeadd.Lists["x_salary_id"].Options = <?php echo (is_array($tbl_employee->salary_id->EditValue)) ? ew_ArrayToJson($tbl_employee->salary_id->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php echo $tbl_employee->salary_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_employee->tax_category_id->Visible) { // tax_category_id ?>
	<tr id="r_tax_category_id">
		<td><span id="elh_tbl_employee_tax_category_id"><?php echo $tbl_employee->tax_category_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_employee->tax_category_id->CellAttributes() ?>>
<span id="el_tbl_employee_tax_category_id" class="control-group">
<select data-field="x_tax_category_id" id="x_tax_category_id" name="x_tax_category_id"<?php echo $tbl_employee->tax_category_id->EditAttributes() ?>>
<?php
if (is_array($tbl_employee->tax_category_id->EditValue)) {
	$arwrk = $tbl_employee->tax_category_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_employee->tax_category_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$tbl_employee->tax_category_id) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
<script type="text/javascript">
ftbl_employeeadd.Lists["x_tax_category_id"].Options = <?php echo (is_array($tbl_employee->tax_category_id->EditValue)) ? ew_ArrayToJson($tbl_employee->tax_category_id->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php echo $tbl_employee->tax_category_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_employee->date_hired->Visible) { // date_hired ?>
	<tr id="r_date_hired">
		<td><span id="elh_tbl_employee_date_hired"><?php echo $tbl_employee->date_hired->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_employee->date_hired->CellAttributes() ?>>
<span id="el_tbl_employee_date_hired" class="control-group">
<input type="text" data-field="x_date_hired" name="x_date_hired" id="x_date_hired" placeholder="<?php echo $tbl_employee->date_hired->PlaceHolder ?>" value="<?php echo $tbl_employee->date_hired->EditValue ?>"<?php echo $tbl_employee->date_hired->EditAttributes() ?>>
<?php if (!$tbl_employee->date_hired->ReadOnly && !$tbl_employee->date_hired->Disabled && @$tbl_employee->date_hired->EditAttrs["readonly"] == "" && @$tbl_employee->date_hired->EditAttrs["disabled"] == "") { ?>
<button id="cal_x_date_hired" name="cal_x_date_hired" class="btn" type="button"><img src="phpimages/calendar.png" id="cal_x_date_hired" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" style="border: 0;"></button><script type="text/javascript">
ew_CreateCalendar("ftbl_employeeadd", "x_date_hired", "%Y/%m/%d");
</script>
<?php } ?>
</span>
<?php echo $tbl_employee->date_hired->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<?php
	if (in_array("tbl_employee_deduction", explode(",", $tbl_employee->getCurrentDetailTable())) && $tbl_employee_deduction->DetailAdd) {
?>
<?php include_once "tbl_employee_deductiongrid.php" ?>
<?php } ?>
<?php
	if (in_array("tbl_employee_leavecredit", explode(",", $tbl_employee->getCurrentDetailTable())) && $tbl_employee_leavecredit->DetailAdd) {
?>
<?php include_once "tbl_employee_leavecreditgrid.php" ?>
<?php } ?>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
</form>
<script type="text/javascript">
ftbl_employeeadd.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$tbl_employee_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_employee_add->Page_Terminate();
?>
