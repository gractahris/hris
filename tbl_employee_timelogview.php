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

$tbl_employee_timelog_view = NULL; // Initialize page object first

class ctbl_employee_timelog_view extends ctbl_employee_timelog {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}";

	// Table name
	var $TableName = 'tbl_employee_timelog';

	// Page object name
	var $PageObjName = 'tbl_employee_timelog_view';

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

		// Table object (tbl_employee_timelog)
		if (!isset($GLOBALS["tbl_employee_timelog"])) {
			$GLOBALS["tbl_employee_timelog"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbl_employee_timelog"];
		}
		$KeyUrl = "";
		if (@$_GET["ref_id"] <> "") {
			$this->RecKey["ref_id"] = $_GET["ref_id"];
			$KeyUrl .= "&ref_id=" . urlencode($this->RecKey["ref_id"]);
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
			define("EW_TABLE_NAME", 'tbl_employee_timelog', TRUE);

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
			$this->Page_Terminate("tbl_employee_timeloglist.php");
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
		if (@$_GET["ref_id"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["ref_id"]);
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up curent action

		// Setup export options
		$this->SetupExportOptions();
		$this->ref_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
			if (@$_GET["ref_id"] <> "") {
				$this->ref_id->setQueryStringValue($_GET["ref_id"]);
				$this->RecKey["ref_id"] = $this->ref_id->QueryStringValue;
			} else {
				$sReturnUrl = "tbl_employee_timeloglist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "tbl_employee_timeloglist.php"; // No matching record, return to list
					}
			}

			// Export data only
			if (in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
				$this->ExportData();
				$this->Page_Terminate(); // Terminate response
				exit();
			}
		} else {
			$sReturnUrl = "tbl_employee_timeloglist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();
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
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

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
		$item->Body = "<a id=\"emf_tbl_employee_timelog\" href=\"javascript:void(0);\" class=\"ewExportLink ewEmail\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_tbl_employee_timelog',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.ftbl_employee_timelogview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "tbl_employee_timeloglist.php", $this->TableVar);
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
if (!isset($tbl_employee_timelog_view)) $tbl_employee_timelog_view = new ctbl_employee_timelog_view();

// Page init
$tbl_employee_timelog_view->Page_Init();

// Page main
$tbl_employee_timelog_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tbl_employee_timelog_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($tbl_employee_timelog->Export == "") { ?>
<script type="text/javascript">

// Page object
var tbl_employee_timelog_view = new ew_Page("tbl_employee_timelog_view");
tbl_employee_timelog_view.PageID = "view"; // Page ID
var EW_PAGE_ID = tbl_employee_timelog_view.PageID; // For backward compatibility

// Form object
var ftbl_employee_timelogview = new ew_Form("ftbl_employee_timelogview");

// Form_CustomValidate event
ftbl_employee_timelogview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_employee_timelogview.ValidateRequired = true;
<?php } else { ?>
ftbl_employee_timelogview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($tbl_employee_timelog->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($tbl_employee_timelog->Export == "") { ?>
<div class="ewViewExportOptions">
<?php $tbl_employee_timelog_view->ExportOptions->Render("body") ?>
<?php if (!$tbl_employee_timelog_view->ExportOptions->UseDropDownButton) { ?>
</div>
<div class="ewViewOtherOptions">
<?php } ?>
<?php
	foreach ($tbl_employee_timelog_view->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<?php } ?>
<?php $tbl_employee_timelog_view->ShowPageHeader(); ?>
<?php
$tbl_employee_timelog_view->ShowMessage();
?>
<form name="ftbl_employee_timelogview" id="ftbl_employee_timelogview" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="tbl_employee_timelog">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_tbl_employee_timelogview" class="table table-bordered table-striped">
<?php if ($tbl_employee_timelog->ref_id->Visible) { // ref_id ?>
	<tr id="r_ref_id">
		<td><span id="elh_tbl_employee_timelog_ref_id"><?php echo $tbl_employee_timelog->ref_id->FldCaption() ?></span></td>
		<td<?php echo $tbl_employee_timelog->ref_id->CellAttributes() ?>>
<span id="el_tbl_employee_timelog_ref_id" class="control-group">
<span<?php echo $tbl_employee_timelog->ref_id->ViewAttributes() ?>>
<?php echo $tbl_employee_timelog->ref_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_employee_timelog->emp_id->Visible) { // emp_id ?>
	<tr id="r_emp_id">
		<td><span id="elh_tbl_employee_timelog_emp_id"><?php echo $tbl_employee_timelog->emp_id->FldCaption() ?></span></td>
		<td<?php echo $tbl_employee_timelog->emp_id->CellAttributes() ?>>
<span id="el_tbl_employee_timelog_emp_id" class="control-group">
<span<?php echo $tbl_employee_timelog->emp_id->ViewAttributes() ?>>
<?php echo $tbl_employee_timelog->emp_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_employee_timelog->emp_datelog->Visible) { // emp_datelog ?>
	<tr id="r_emp_datelog">
		<td><span id="elh_tbl_employee_timelog_emp_datelog"><?php echo $tbl_employee_timelog->emp_datelog->FldCaption() ?></span></td>
		<td<?php echo $tbl_employee_timelog->emp_datelog->CellAttributes() ?>>
<span id="el_tbl_employee_timelog_emp_datelog" class="control-group">
<span<?php echo $tbl_employee_timelog->emp_datelog->ViewAttributes() ?>>
<?php echo $tbl_employee_timelog->emp_datelog->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_employee_timelog->emp_timein->Visible) { // emp_timein ?>
	<tr id="r_emp_timein">
		<td><span id="elh_tbl_employee_timelog_emp_timein"><?php echo $tbl_employee_timelog->emp_timein->FldCaption() ?></span></td>
		<td<?php echo $tbl_employee_timelog->emp_timein->CellAttributes() ?>>
<span id="el_tbl_employee_timelog_emp_timein" class="control-group">
<span<?php echo $tbl_employee_timelog->emp_timein->ViewAttributes() ?>>
<?php echo $tbl_employee_timelog->emp_timein->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_employee_timelog->emp_timeout->Visible) { // emp_timeout ?>
	<tr id="r_emp_timeout">
		<td><span id="elh_tbl_employee_timelog_emp_timeout"><?php echo $tbl_employee_timelog->emp_timeout->FldCaption() ?></span></td>
		<td<?php echo $tbl_employee_timelog->emp_timeout->CellAttributes() ?>>
<span id="el_tbl_employee_timelog_emp_timeout" class="control-group">
<span<?php echo $tbl_employee_timelog->emp_timeout->ViewAttributes() ?>>
<?php echo $tbl_employee_timelog->emp_timeout->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_employee_timelog->emp_totalhours->Visible) { // emp_totalhours ?>
	<tr id="r_emp_totalhours">
		<td><span id="elh_tbl_employee_timelog_emp_totalhours"><?php echo $tbl_employee_timelog->emp_totalhours->FldCaption() ?></span></td>
		<td<?php echo $tbl_employee_timelog->emp_totalhours->CellAttributes() ?>>
<span id="el_tbl_employee_timelog_emp_totalhours" class="control-group">
<span<?php echo $tbl_employee_timelog->emp_totalhours->ViewAttributes() ?>>
<?php echo $tbl_employee_timelog->emp_totalhours->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_employee_timelog->emp_late->Visible) { // emp_late ?>
	<tr id="r_emp_late">
		<td><span id="elh_tbl_employee_timelog_emp_late"><?php echo $tbl_employee_timelog->emp_late->FldCaption() ?></span></td>
		<td<?php echo $tbl_employee_timelog->emp_late->CellAttributes() ?>>
<span id="el_tbl_employee_timelog_emp_late" class="control-group">
<span<?php echo $tbl_employee_timelog->emp_late->ViewAttributes() ?>>
<?php echo $tbl_employee_timelog->emp_late->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_employee_timelog->emp_excesstime->Visible) { // emp_excesstime ?>
	<tr id="r_emp_excesstime">
		<td><span id="elh_tbl_employee_timelog_emp_excesstime"><?php echo $tbl_employee_timelog->emp_excesstime->FldCaption() ?></span></td>
		<td<?php echo $tbl_employee_timelog->emp_excesstime->CellAttributes() ?>>
<span id="el_tbl_employee_timelog_emp_excesstime" class="control-group">
<span<?php echo $tbl_employee_timelog->emp_excesstime->ViewAttributes() ?>>
<?php echo $tbl_employee_timelog->emp_excesstime->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($tbl_employee_timelog->emp_undertime->Visible) { // emp_undertime ?>
	<tr id="r_emp_undertime">
		<td><span id="elh_tbl_employee_timelog_emp_undertime"><?php echo $tbl_employee_timelog->emp_undertime->FldCaption() ?></span></td>
		<td<?php echo $tbl_employee_timelog->emp_undertime->CellAttributes() ?>>
<span id="el_tbl_employee_timelog_emp_undertime" class="control-group">
<span<?php echo $tbl_employee_timelog->emp_undertime->ViewAttributes() ?>>
<?php echo $tbl_employee_timelog->emp_undertime->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
</form>
<script type="text/javascript">
ftbl_employee_timelogview.Init();
</script>
<?php
$tbl_employee_timelog_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($tbl_employee_timelog->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$tbl_employee_timelog_view->Page_Terminate();
?>
