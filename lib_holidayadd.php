<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "lib_holidayinfo.php" ?>
<?php include_once "tbl_userinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$lib_holiday_add = NULL; // Initialize page object first

class clib_holiday_add extends clib_holiday {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}";

	// Table name
	var $TableName = 'lib_holiday';

	// Page object name
	var $PageObjName = 'lib_holiday_add';

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

		// Table object (lib_holiday)
		if (!isset($GLOBALS["lib_holiday"])) {
			$GLOBALS["lib_holiday"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["lib_holiday"];
		}

		// Table object (tbl_user)
		if (!isset($GLOBALS['tbl_user'])) $GLOBALS['tbl_user'] = new ctbl_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'lib_holiday', TRUE);

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
			$this->Page_Terminate("lib_holidaylist.php");
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
			if (@$_GET["holiday_id"] != "") {
				$this->holiday_id->setQueryStringValue($_GET["holiday_id"]);
				$this->setKey("holiday_id", $this->holiday_id->CurrentValue); // Set up key
			} else {
				$this->setKey("holiday_id", ""); // Clear key
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
					$this->Page_Terminate("lib_holidaylist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "lib_holidayview.php")
						$sReturnUrl = $this->GetViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
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
		$this->holiday_title->CurrentValue = NULL;
		$this->holiday_title->OldValue = $this->holiday_title->CurrentValue;
		$this->holiday_month->CurrentValue = NULL;
		$this->holiday_month->OldValue = $this->holiday_month->CurrentValue;
		$this->holiday_day->CurrentValue = NULL;
		$this->holiday_day->OldValue = $this->holiday_day->CurrentValue;
		$this->holiday_year->CurrentValue = NULL;
		$this->holiday_year->OldValue = $this->holiday_year->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->holiday_title->FldIsDetailKey) {
			$this->holiday_title->setFormValue($objForm->GetValue("x_holiday_title"));
		}
		if (!$this->holiday_month->FldIsDetailKey) {
			$this->holiday_month->setFormValue($objForm->GetValue("x_holiday_month"));
		}
		if (!$this->holiday_day->FldIsDetailKey) {
			$this->holiday_day->setFormValue($objForm->GetValue("x_holiday_day"));
		}
		if (!$this->holiday_year->FldIsDetailKey) {
			$this->holiday_year->setFormValue($objForm->GetValue("x_holiday_year"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->holiday_title->CurrentValue = $this->holiday_title->FormValue;
		$this->holiday_month->CurrentValue = $this->holiday_month->FormValue;
		$this->holiday_day->CurrentValue = $this->holiday_day->FormValue;
		$this->holiday_year->CurrentValue = $this->holiday_year->FormValue;
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
		$this->holiday_id->setDbValue($rs->fields('holiday_id'));
		$this->holiday_title->setDbValue($rs->fields('holiday_title'));
		$this->holiday_month->setDbValue($rs->fields('holiday_month'));
		$this->holiday_day->setDbValue($rs->fields('holiday_day'));
		$this->holiday_year->setDbValue($rs->fields('holiday_year'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->holiday_id->DbValue = $row['holiday_id'];
		$this->holiday_title->DbValue = $row['holiday_title'];
		$this->holiday_month->DbValue = $row['holiday_month'];
		$this->holiday_day->DbValue = $row['holiday_day'];
		$this->holiday_year->DbValue = $row['holiday_year'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("holiday_id")) <> "")
			$this->holiday_id->CurrentValue = $this->getKey("holiday_id"); // holiday_id
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
		// holiday_id
		// holiday_title
		// holiday_month
		// holiday_day
		// holiday_year

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// holiday_id
			$this->holiday_id->ViewValue = $this->holiday_id->CurrentValue;
			$this->holiday_id->ViewCustomAttributes = "";

			// holiday_title
			$this->holiday_title->ViewValue = $this->holiday_title->CurrentValue;
			$this->holiday_title->ViewCustomAttributes = "";

			// holiday_month
			if (strval($this->holiday_month->CurrentValue) <> "") {
				$sFilterWrk = "`month_val`" . ew_SearchString("=", $this->holiday_month->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `month_val`, `month_val` AS `DispFld`, `month_title` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lib_month`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->holiday_month, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->holiday_month->ViewValue = $rswrk->fields('DispFld');
					$this->holiday_month->ViewValue .= ew_ValueSeparator(1,$this->holiday_month) . $rswrk->fields('Disp2Fld');
					$rswrk->Close();
				} else {
					$this->holiday_month->ViewValue = $this->holiday_month->CurrentValue;
				}
			} else {
				$this->holiday_month->ViewValue = NULL;
			}
			$this->holiday_month->ViewCustomAttributes = "";

			// holiday_day
			if (strval($this->holiday_day->CurrentValue) <> "") {
				$sFilterWrk = "`day_title`" . ew_SearchString("=", $this->holiday_day->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `day_title`, `day_title` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lib_day`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->holiday_day, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->holiday_day->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->holiday_day->ViewValue = $this->holiday_day->CurrentValue;
				}
			} else {
				$this->holiday_day->ViewValue = NULL;
			}
			$this->holiday_day->ViewCustomAttributes = "";

			// holiday_year
			if (strval($this->holiday_year->CurrentValue) <> "") {
				$sFilterWrk = "`year_val`" . ew_SearchString("=", $this->holiday_year->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `year_val`, `year_val` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `lib_year`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->holiday_year, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->holiday_year->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->holiday_year->ViewValue = $this->holiday_year->CurrentValue;
				}
			} else {
				$this->holiday_year->ViewValue = NULL;
			}
			$this->holiday_year->ViewCustomAttributes = "";

			// holiday_title
			$this->holiday_title->LinkCustomAttributes = "";
			$this->holiday_title->HrefValue = "";
			$this->holiday_title->TooltipValue = "";

			// holiday_month
			$this->holiday_month->LinkCustomAttributes = "";
			$this->holiday_month->HrefValue = "";
			$this->holiday_month->TooltipValue = "";

			// holiday_day
			$this->holiday_day->LinkCustomAttributes = "";
			$this->holiday_day->HrefValue = "";
			$this->holiday_day->TooltipValue = "";

			// holiday_year
			$this->holiday_year->LinkCustomAttributes = "";
			$this->holiday_year->HrefValue = "";
			$this->holiday_year->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// holiday_title
			$this->holiday_title->EditCustomAttributes = "";
			$this->holiday_title->EditValue = ew_HtmlEncode($this->holiday_title->CurrentValue);
			$this->holiday_title->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->holiday_title->FldCaption()));

			// holiday_month
			$this->holiday_month->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `month_val`, `month_val` AS `DispFld`, `month_title` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `lib_month`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->holiday_month, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->holiday_month->EditValue = $arwrk;

			// holiday_day
			$this->holiday_day->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `day_title`, `day_title` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `lib_day`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->holiday_day, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->holiday_day->EditValue = $arwrk;

			// holiday_year
			$this->holiday_year->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `year_val`, `year_val` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `lib_year`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->holiday_year, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->holiday_year->EditValue = $arwrk;

			// Edit refer script
			// holiday_title

			$this->holiday_title->HrefValue = "";

			// holiday_month
			$this->holiday_month->HrefValue = "";

			// holiday_day
			$this->holiday_day->HrefValue = "";

			// holiday_year
			$this->holiday_year->HrefValue = "";
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
		if (!$this->holiday_title->FldIsDetailKey && !is_null($this->holiday_title->FormValue) && $this->holiday_title->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->holiday_title->FldCaption());
		}
		if (!$this->holiday_month->FldIsDetailKey && !is_null($this->holiday_month->FormValue) && $this->holiday_month->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->holiday_month->FldCaption());
		}
		if (!$this->holiday_day->FldIsDetailKey && !is_null($this->holiday_day->FormValue) && $this->holiday_day->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->holiday_day->FldCaption());
		}
		if (!$this->holiday_year->FldIsDetailKey && !is_null($this->holiday_year->FormValue) && $this->holiday_year->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->holiday_year->FldCaption());
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

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// holiday_title
		$this->holiday_title->SetDbValueDef($rsnew, $this->holiday_title->CurrentValue, "", FALSE);

		// holiday_month
		$this->holiday_month->SetDbValueDef($rsnew, $this->holiday_month->CurrentValue, "", FALSE);

		// holiday_day
		$this->holiday_day->SetDbValueDef($rsnew, $this->holiday_day->CurrentValue, "", FALSE);

		// holiday_year
		$this->holiday_year->SetDbValueDef($rsnew, $this->holiday_year->CurrentValue, "", FALSE);

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
			$this->holiday_id->setDbValue($conn->Insert_ID());
			$rsnew['holiday_id'] = $this->holiday_id->DbValue;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "lib_holidaylist.php", $this->TableVar);
		$PageCaption = ($this->CurrentAction == "C") ? $Language->Phrase("Copy") : $Language->Phrase("Add");
		$Breadcrumb->Add("add", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", ew_CurrentUrl(), $this->TableVar);
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
if (!isset($lib_holiday_add)) $lib_holiday_add = new clib_holiday_add();

// Page init
$lib_holiday_add->Page_Init();

// Page main
$lib_holiday_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$lib_holiday_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var lib_holiday_add = new ew_Page("lib_holiday_add");
lib_holiday_add.PageID = "add"; // Page ID
var EW_PAGE_ID = lib_holiday_add.PageID; // For backward compatibility

// Form object
var flib_holidayadd = new ew_Form("flib_holidayadd");

// Validate form
flib_holidayadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_holiday_title");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($lib_holiday->holiday_title->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_holiday_month");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($lib_holiday->holiday_month->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_holiday_day");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($lib_holiday->holiday_day->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_holiday_year");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($lib_holiday->holiday_year->FldCaption()) ?>");

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
flib_holidayadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
flib_holidayadd.ValidateRequired = true;
<?php } else { ?>
flib_holidayadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
flib_holidayadd.Lists["x_holiday_month"] = {"LinkField":"x_month_val","Ajax":null,"AutoFill":false,"DisplayFields":["x_month_val","x_month_title","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
flib_holidayadd.Lists["x_holiday_day"] = {"LinkField":"x_day_title","Ajax":null,"AutoFill":false,"DisplayFields":["x_day_title","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
flib_holidayadd.Lists["x_holiday_year"] = {"LinkField":"x_year_val","Ajax":null,"AutoFill":false,"DisplayFields":["x_year_val","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $lib_holiday_add->ShowPageHeader(); ?>
<?php
$lib_holiday_add->ShowMessage();
?>
<form name="flib_holidayadd" id="flib_holidayadd" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="lib_holiday">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_lib_holidayadd" class="table table-bordered table-striped">
<?php if ($lib_holiday->holiday_title->Visible) { // holiday_title ?>
	<tr id="r_holiday_title">
		<td><span id="elh_lib_holiday_holiday_title"><?php echo $lib_holiday->holiday_title->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $lib_holiday->holiday_title->CellAttributes() ?>>
<span id="el_lib_holiday_holiday_title" class="control-group">
<input type="text" data-field="x_holiday_title" name="x_holiday_title" id="x_holiday_title" size="30" maxlength="255" placeholder="<?php echo $lib_holiday->holiday_title->PlaceHolder ?>" value="<?php echo $lib_holiday->holiday_title->EditValue ?>"<?php echo $lib_holiday->holiday_title->EditAttributes() ?>>
</span>
<?php echo $lib_holiday->holiday_title->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($lib_holiday->holiday_month->Visible) { // holiday_month ?>
	<tr id="r_holiday_month">
		<td><span id="elh_lib_holiday_holiday_month"><?php echo $lib_holiday->holiday_month->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $lib_holiday->holiday_month->CellAttributes() ?>>
<span id="el_lib_holiday_holiday_month" class="control-group">
<select data-field="x_holiday_month" id="x_holiday_month" name="x_holiday_month"<?php echo $lib_holiday->holiday_month->EditAttributes() ?>>
<?php
if (is_array($lib_holiday->holiday_month->EditValue)) {
	$arwrk = $lib_holiday->holiday_month->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($lib_holiday->holiday_month->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$lib_holiday->holiday_month) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
<script type="text/javascript">
flib_holidayadd.Lists["x_holiday_month"].Options = <?php echo (is_array($lib_holiday->holiday_month->EditValue)) ? ew_ArrayToJson($lib_holiday->holiday_month->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php echo $lib_holiday->holiday_month->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($lib_holiday->holiday_day->Visible) { // holiday_day ?>
	<tr id="r_holiday_day">
		<td><span id="elh_lib_holiday_holiday_day"><?php echo $lib_holiday->holiday_day->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $lib_holiday->holiday_day->CellAttributes() ?>>
<span id="el_lib_holiday_holiday_day" class="control-group">
<select data-field="x_holiday_day" id="x_holiday_day" name="x_holiday_day"<?php echo $lib_holiday->holiday_day->EditAttributes() ?>>
<?php
if (is_array($lib_holiday->holiday_day->EditValue)) {
	$arwrk = $lib_holiday->holiday_day->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($lib_holiday->holiday_day->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
flib_holidayadd.Lists["x_holiday_day"].Options = <?php echo (is_array($lib_holiday->holiday_day->EditValue)) ? ew_ArrayToJson($lib_holiday->holiday_day->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php echo $lib_holiday->holiday_day->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($lib_holiday->holiday_year->Visible) { // holiday_year ?>
	<tr id="r_holiday_year">
		<td><span id="elh_lib_holiday_holiday_year"><?php echo $lib_holiday->holiday_year->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $lib_holiday->holiday_year->CellAttributes() ?>>
<span id="el_lib_holiday_holiday_year" class="control-group">
<select data-field="x_holiday_year" id="x_holiday_year" name="x_holiday_year"<?php echo $lib_holiday->holiday_year->EditAttributes() ?>>
<?php
if (is_array($lib_holiday->holiday_year->EditValue)) {
	$arwrk = $lib_holiday->holiday_year->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($lib_holiday->holiday_year->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
flib_holidayadd.Lists["x_holiday_year"].Options = <?php echo (is_array($lib_holiday->holiday_year->EditValue)) ? ew_ArrayToJson($lib_holiday->holiday_year->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php echo $lib_holiday->holiday_year->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
</form>
<script type="text/javascript">
flib_holidayadd.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$lib_holiday_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$lib_holiday_add->Page_Terminate();
?>
