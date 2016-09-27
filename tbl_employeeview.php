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
<?php

//
// Page class
//

$tbl_employee_view = NULL; // Initialize page object first

class ctbl_employee_view extends ctbl_employee {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}";

	// Table name
	var $TableName = 'tbl_employee';

	// Page object name
	var $PageObjName = 'tbl_employee_view';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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
		$KeyUrl = "";
		if (@$_GET["emp_id"] <> "") {
			$this->RecKey["emp_id"] = $_GET["emp_id"];
			$KeyUrl .= "&emp_id=" . urlencode($this->RecKey["emp_id"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (tbl_user)
		if (!isset($GLOBALS['tbl_user'])) $GLOBALS['tbl_user'] = new ctbl_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_employee', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "span";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "span";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "span";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
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
		if (!$Security->CanView()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("tbl_employeelist.php");
		}

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$this->Export = $_GET["export"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$this->Export = $_POST["exporttype"];
		} else {
			$this->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExport = $this->Export; // Get export parameter, used in header
		$gsExportFile = $this->TableVar; // Get export file, used in header
		if (@$_GET["emp_id"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["emp_id"]);
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up curent action

		// Setup export options
		$this->SetupExportOptions();
		$this->emp_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Update url if printer friendly for Pdf
		if ($this->PrinterFriendlyForPdf)
			$this->ExportOptions->Items["pdf"]->Body = str_replace($this->ExportPdfUrl, $this->ExportPrintUrl . "&pdf=1", $this->ExportOptions->Items["pdf"]->Body);
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn;

		// Page Unload event
		$this->Page_Unload();
		if ($this->Export == "print" && @$_GET["pdf"] == "1") { // Printer friendly version and with pdf=1 in URL parameters
			$pdf = new cExportPdf($GLOBALS["Table"]);
			$pdf->Text = ob_get_contents(); // Set the content as the HTML of current page (printer friendly version)
			ob_end_clean();
			$pdf->Export();
		}

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
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 1;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $RecCnt;
	var $RecKey = array();
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Load current record
		$bLoadCurrentRecord = FALSE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["emp_id"] <> "") {
				$this->emp_id->setQueryStringValue($_GET["emp_id"]);
				$this->RecKey["emp_id"] = $this->emp_id->QueryStringValue;
			} else {
				$sReturnUrl = "tbl_employeelist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "tbl_employeelist.php"; // No matching record, return to list
					}
			}

			// Export data only
			if (in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
				$this->ExportData();
				$this->Page_Terminate(); // Terminate response
				exit();
			}
		} else {
			$sReturnUrl = "tbl_employeelist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();

		// Set up detail parameters
		$this->SetUpDetailParms();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = &$options["action"];

		// Add
		$item = &$option->Add("add");
		$item->Body = "<a class=\"ewAction ewAdd\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());

		// Edit
		$item = &$option->Add("edit");
		$item->Body = "<a class=\"ewAction ewEdit\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		$item->Visible = ($this->EditUrl <> "" && $Security->CanEdit());

		// Copy
		$item = &$option->Add("copy");
		$item->Body = "<a class=\"ewAction ewCopy\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		$item->Visible = ($this->CopyUrl <> "" && $Security->CanAdd());

		// Delete
		$item = &$option->Add("delete");
		$item->Body = "<a class=\"ewAction ewDelete\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		$item->Visible = ($this->DeleteUrl <> "" && $Security->CanDelete());
		$DetailTableLink = "";
		$option = &$options["detail"];

		// Detail table 'tbl_employee_deduction'
		$body = $Language->TablePhrase("tbl_employee_deduction", "TblCaption");
		$body = "<a class=\"ewAction ewDetailList\" href=\"" . ew_HtmlEncode("tbl_employee_deductionlist.php?" . EW_TABLE_SHOW_MASTER . "=tbl_employee&emp_id=" . strval($this->emp_id->CurrentValue) . "") . "\">" . $body . "</a>";
		$item = &$option->Add("detail_tbl_employee_deduction");
		$item->Body = $body;
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'tbl_employee_deduction');
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "tbl_employee_deduction";
		}

		// Detail table 'tbl_employee_leavecredit'
		$body = $Language->TablePhrase("tbl_employee_leavecredit", "TblCaption");
		$body = "<a class=\"ewAction ewDetailList\" href=\"" . ew_HtmlEncode("tbl_employee_leavecreditlist.php?" . EW_TABLE_SHOW_MASTER . "=tbl_employee&emp_id=" . strval($this->emp_id->CurrentValue) . "") . "\">" . $body . "</a>";
		$item = &$option->Add("detail_tbl_employee_leavecredit");
		$item->Body = $body;
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'tbl_employee_leavecredit');
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "tbl_employee_leavecredit";
		}

		// Multiple details
		if ($this->ShowMultipleDetails) {
			$body = $Language->Phrase("MultipleMasterDetails");
			$body = "<a class=\"ewAction ewDetailView\" data-action=\"view\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailTableLink)) . "\">" . $body . "</a>";
			$item = &$option->Add("details");
			$item->Body = $body;
			$item->Visible = ($DetailTableLink <> "");

			// Hide single master/detail items
			$ar = explode(",", $DetailTableLink);
			$cnt = count($ar);
			for ($i = 0; $i < $cnt; $i++) {
				if ($item = &$option->GetItem("detail_" . $ar[$i]))
					$item->Visible = FALSE;
			}
		}

		// Set up options default
		foreach ($options as &$option) {
			$option->UseDropDownButton = FALSE;
			$option->UseButtonGroup = TRUE;
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
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

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

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

			// emp_id
			$this->emp_id->LinkCustomAttributes = "";
			$this->emp_id->HrefValue = "";
			$this->emp_id->TooltipValue = "";

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up export options
	function SetupExportOptions() {
		global $Language;

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ewExportLink ewPrint\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = FALSE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ewExportLink ewExcel\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a href=\"" . $this->ExportWordUrl . "\" class=\"ewExportLink ewWord\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = FALSE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a href=\"" . $this->ExportHtmlUrl . "\" class=\"ewExportLink ewHtml\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = FALSE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a href=\"" . $this->ExportXmlUrl . "\" class=\"ewExportLink ewXml\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = FALSE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a href=\"" . $this->ExportCsvUrl . "\" class=\"ewExportLink ewCsv\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = TRUE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a href=\"" . $this->ExportPdfUrl . "\" class=\"ewExportLink ewPdf\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$item->Body = "<a id=\"emf_tbl_employee\" href=\"javascript:void(0);\" class=\"ewExportLink ewEmail\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_tbl_employee',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.ftbl_employeeview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
		$item->Visible = FALSE;

		// Drop down button for export
		$this->ExportOptions->UseDropDownButton = FALSE;
		$this->ExportOptions->DropDownButtonPhrase = $Language->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide options for export
		if ($this->Export <> "")
			$this->ExportOptions->HideAllOptions();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = FALSE;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $this->SelectRecordCount();
		} else {
			if ($rs = $this->LoadRecordset())
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;
		$this->SetUpStartRec(); // Set up start record position

		// Set the last record to display
		if ($this->DisplayRecs <= 0) {
			$this->StopRec = $this->TotalRecs;
		} else {
			$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
		}
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$ExportDoc = ew_ExportDocument($this, "v");
		$ParentTable = "";
		if ($bSelectLimit) {
			$StartRec = 1;
			$StopRec = $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs;
		} else {
			$StartRec = $this->StartRec;
			$StopRec = $this->StopRec;
		}
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		$ExportDoc->Text .= $sHeader;
		$this->ExportDocument($ExportDoc, $rs, $StartRec, $StopRec, "view");
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		$ExportDoc->Text .= $sFooter;

		// Close recordset
		$rs->Close();

		// Export header and footer
		$ExportDoc->ExportHeaderAndFooter();

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED)
			echo ew_DebugMsg();

		// Output data
		$ExportDoc->Export();
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
				if ($GLOBALS["tbl_employee_deduction_grid"]->DetailView) {
					$GLOBALS["tbl_employee_deduction_grid"]->CurrentMode = "view";

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
				if ($GLOBALS["tbl_employee_leavecredit_grid"]->DetailView) {
					$GLOBALS["tbl_employee_leavecredit_grid"]->CurrentMode = "view";

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
		$PageCaption = $Language->Phrase("view");
		$Breadcrumb->Add("view", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", ew_CurrentUrl(), $this->TableVar);
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
if (!isset($tbl_employee_view)) $tbl_employee_view = new ctbl_employee_view();

// Page init
$tbl_employee_view->Page_Init();

// Page main
$tbl_employee_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tbl_employee_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($tbl_employee->Export == "") { ?>
<script type="text/javascript">

// Page object
var tbl_employee_view = new ew_Page("tbl_employee_view");
tbl_employee_view.PageID = "view"; // Page ID
var EW_PAGE_ID = tbl_employee_view.PageID; // For backward compatibility

// Form object
var ftbl_employeeview = new ew_Form("ftbl_employeeview");

// Form_CustomValidate event
ftbl_employeeview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_employeeview.ValidateRequired = true;
<?php } else { ?>
ftbl_employeeview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftbl_employeeview.Lists["x_sex_id"] = {"LinkField":"x_sex_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_sex_title","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_employeeview.Lists["x_schedule_id"] = {"LinkField":"x_schedule_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_schedule_title","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_employeeview.Lists["x_salary_id"] = {"LinkField":"x_salary_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_salary_amount","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_employeeview.Lists["x_tax_category_id"] = {"LinkField":"x_tax_category_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_tax_category_code","x_tax_category_title","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($tbl_employee->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($tbl_employee->Export == "") { ?>
<div class="ewViewExportOptions">
<?php $tbl_employee_view->ExportOptions->Render("body") ?>
<?php if (!$tbl_employee_view->ExportOptions->UseDropDownButton) { ?>
</div>
<div class="ewViewOtherOptions">
<?php } ?>
<?php
	foreach ($tbl_employee_view->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<?php } ?>
<?php $tbl_employee_view->ShowPageHeader(); ?>
<?php
$tbl_employee_view->ShowMessage();
?>
<form name="ftbl_employeeview" id="ftbl_employeeview" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="tbl_employee">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_tbl_employeeview" class="table table-bordered table-striped">
<?php if ($tbl_employee->emp_id->Visible) { // emp_id ?>
	<tr id="r_emp_id">
		<td><span id="elh_tbl_employee_emp_id"><?php echo $tbl_employee->emp_id->FldCaption() ?></span></td>
		<td<?php echo $tbl_employee->emp_id->CellAttributes() ?>>
<span id="el_tbl_employee_emp_id" class="control-group">
<span<?php echo $tbl_employee->emp_id->ViewAttributes() ?>>
<?php echo $tbl_employee->emp_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_employee->empFirstName->Visible) { // empFirstName ?>
	<tr id="r_empFirstName">
		<td><span id="elh_tbl_employee_empFirstName"><?php echo $tbl_employee->empFirstName->FldCaption() ?></span></td>
		<td<?php echo $tbl_employee->empFirstName->CellAttributes() ?>>
<span id="el_tbl_employee_empFirstName" class="control-group">
<span<?php echo $tbl_employee->empFirstName->ViewAttributes() ?>>
<?php echo $tbl_employee->empFirstName->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_employee->empMiddleName->Visible) { // empMiddleName ?>
	<tr id="r_empMiddleName">
		<td><span id="elh_tbl_employee_empMiddleName"><?php echo $tbl_employee->empMiddleName->FldCaption() ?></span></td>
		<td<?php echo $tbl_employee->empMiddleName->CellAttributes() ?>>
<span id="el_tbl_employee_empMiddleName" class="control-group">
<span<?php echo $tbl_employee->empMiddleName->ViewAttributes() ?>>
<?php echo $tbl_employee->empMiddleName->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_employee->empLastName->Visible) { // empLastName ?>
	<tr id="r_empLastName">
		<td><span id="elh_tbl_employee_empLastName"><?php echo $tbl_employee->empLastName->FldCaption() ?></span></td>
		<td<?php echo $tbl_employee->empLastName->CellAttributes() ?>>
<span id="el_tbl_employee_empLastName" class="control-group">
<span<?php echo $tbl_employee->empLastName->ViewAttributes() ?>>
<?php echo $tbl_employee->empLastName->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_employee->empExtensionName->Visible) { // empExtensionName ?>
	<tr id="r_empExtensionName">
		<td><span id="elh_tbl_employee_empExtensionName"><?php echo $tbl_employee->empExtensionName->FldCaption() ?></span></td>
		<td<?php echo $tbl_employee->empExtensionName->CellAttributes() ?>>
<span id="el_tbl_employee_empExtensionName" class="control-group">
<span<?php echo $tbl_employee->empExtensionName->ViewAttributes() ?>>
<?php echo $tbl_employee->empExtensionName->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_employee->sex_id->Visible) { // sex_id ?>
	<tr id="r_sex_id">
		<td><span id="elh_tbl_employee_sex_id"><?php echo $tbl_employee->sex_id->FldCaption() ?></span></td>
		<td<?php echo $tbl_employee->sex_id->CellAttributes() ?>>
<span id="el_tbl_employee_sex_id" class="control-group">
<span<?php echo $tbl_employee->sex_id->ViewAttributes() ?>>
<?php echo $tbl_employee->sex_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_employee->schedule_id->Visible) { // schedule_id ?>
	<tr id="r_schedule_id">
		<td><span id="elh_tbl_employee_schedule_id"><?php echo $tbl_employee->schedule_id->FldCaption() ?></span></td>
		<td<?php echo $tbl_employee->schedule_id->CellAttributes() ?>>
<span id="el_tbl_employee_schedule_id" class="control-group">
<span<?php echo $tbl_employee->schedule_id->ViewAttributes() ?>>
<?php echo $tbl_employee->schedule_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_employee->salary_id->Visible) { // salary_id ?>
	<tr id="r_salary_id">
		<td><span id="elh_tbl_employee_salary_id"><?php echo $tbl_employee->salary_id->FldCaption() ?></span></td>
		<td<?php echo $tbl_employee->salary_id->CellAttributes() ?>>
<span id="el_tbl_employee_salary_id" class="control-group">
<span<?php echo $tbl_employee->salary_id->ViewAttributes() ?>>
<?php echo $tbl_employee->salary_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_employee->tax_category_id->Visible) { // tax_category_id ?>
	<tr id="r_tax_category_id">
		<td><span id="elh_tbl_employee_tax_category_id"><?php echo $tbl_employee->tax_category_id->FldCaption() ?></span></td>
		<td<?php echo $tbl_employee->tax_category_id->CellAttributes() ?>>
<span id="el_tbl_employee_tax_category_id" class="control-group">
<span<?php echo $tbl_employee->tax_category_id->ViewAttributes() ?>>
<?php echo $tbl_employee->tax_category_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_employee->date_hired->Visible) { // date_hired ?>
	<tr id="r_date_hired">
		<td><span id="elh_tbl_employee_date_hired"><?php echo $tbl_employee->date_hired->FldCaption() ?></span></td>
		<td<?php echo $tbl_employee->date_hired->CellAttributes() ?>>
<span id="el_tbl_employee_date_hired" class="control-group">
<span<?php echo $tbl_employee->date_hired->ViewAttributes() ?>>
<?php echo $tbl_employee->date_hired->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<?php
	if (in_array("tbl_employee_deduction", explode(",", $tbl_employee->getCurrentDetailTable())) && $tbl_employee_deduction->DetailView) {
?>
<?php include_once "tbl_employee_deductiongrid.php" ?>
<?php } ?>
<?php
	if (in_array("tbl_employee_leavecredit", explode(",", $tbl_employee->getCurrentDetailTable())) && $tbl_employee_leavecredit->DetailView) {
?>
<?php include_once "tbl_employee_leavecreditgrid.php" ?>
<?php } ?>
</form>
<script type="text/javascript">
ftbl_employeeview.Init();
</script>
<?php
$tbl_employee_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($tbl_employee->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$tbl_employee_view->Page_Terminate();
?>
