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
<?php include_once "model/leaveCreditDAO.php" ?>
<?php include_once "model/leaveApplicationDAO.php" ?>
<?php include_once "model/timesheetDAO.php" ?>
<?php

//
// Page class
//

$tbl_employee_leaveapplication_list = NULL; // Initialize page object first

class ctbl_employee_leaveapplication_list extends ctbl_employee_leaveapplication {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}";

	// Table name
	var $TableName = 'tbl_employee_leaveapplication';

	// Page object name
	var $PageObjName = 'tbl_employee_leaveapplication_list';

	// Grid form hidden field names
	var $FormName = 'ftbl_employee_leaveapplicationlist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

		// Table object (tbl_employee_leaveapplication)
		if (!isset($GLOBALS["tbl_employee_leaveapplication"])) {
			$GLOBALS["tbl_employee_leaveapplication"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbl_employee_leaveapplication"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "tbl_employee_leaveapplicationadd.php?" . EW_TABLE_SHOW_DETAIL . "=";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "tbl_employee_leaveapplicationdelete.php";
		$this->MultiUpdateUrl = "tbl_employee_leaveapplicationupdate.php";

		// Table object (tbl_user)
		if (!isset($GLOBALS['tbl_user'])) $GLOBALS['tbl_user'] = new ctbl_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_employee_leaveapplication', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "span";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "span";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "span";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "span";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
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
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("login.php");
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
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up curent action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();

		// Setup export options
		$this->SetupExportOptions();
		$this->leave_application_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Setup other options
		$this->SetupOtherOptions();

		// Set "checkbox" visible
		if (count($this->CustomActions) > 0)
			$this->ListOptions->Items["checkbox"]->Visible = TRUE;

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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;	
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process custom action first
			$this->ProcessCustomAction();

			// Set up records per page
			$this->SetUpDisplayRecs();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			$this->SetupBreadcrumb();

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide export options
			if ($this->Export <> "" || $this->CurrentAction <> "")
				$this->ExportOptions->HideAllOptions();

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Restore search parms from Session if not searching / reset
			if ($this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall" && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} else {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";

		// Export data only
		if (in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		$sWrk = @$_GET[EW_TABLE_REC_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->DisplayRecs = intval($sWrk);
			} else {
				if (strtolower($sWrk) == "all") { // Display all records
					$this->DisplayRecs = -1;
				} else {
					$this->DisplayRecs = 20; // Non-numeric, load default
				}
			}
			$this->setRecordsPerPage($this->DisplayRecs); // Save to Session

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue("k_key"));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue("k_key"));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->leave_application_id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->leave_application_id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->sickness, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->place_to_visit, $Keyword);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSql(&$Where, &$Fld, $Keyword) {
		if ($Keyword == EW_NULL_VALUE) {
			$sWrk = $Fld->FldExpression . " IS NULL";
		} elseif ($Keyword == EW_NOT_NULL_VALUE) {
			$sWrk = $Fld->FldExpression . " IS NOT NULL";
		} else {
			$sFldExpression = ($Fld->FldVirtualExpression <> $Fld->FldExpression) ? $Fld->FldVirtualExpression : $Fld->FldBasicSearchExpression;
			$sWrk = $sFldExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING));
		}
		if ($Where <> "") $Where .= " OR ";
		$Where .= $sWrk;
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere() {
		global $Security;
		$sSearchStr = "";
		if (!$Security->CanSearch()) return "";
		$sSearchKeyword = $this->BasicSearch->Keyword;
		$sSearchType = $this->BasicSearch->Type;
		if ($sSearchKeyword <> "") {
			$sSearch = trim($sSearchKeyword);
			if ($sSearchType <> "=") {
				while (strpos($sSearch, "  ") !== FALSE)
					$sSearch = str_replace("  ", " ", $sSearch);
				$arKeyword = explode(" ", trim($sSearch));
				foreach ($arKeyword as $sKeyword) {
					if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
					$sSearchStr .= "(" . $this->BasicSearchSQL($sKeyword) . ")";
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL($sSearch);
			}
			$this->Command = "search";
		}
		if ($this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->leave_application_id); // leave_application_id
			$this->UpdateSort($this->emp_id); // emp_id
			$this->UpdateSort($this->leave_type_id); // leave_type_id
			$this->UpdateSort($this->sickness); // sickness
			$this->UpdateSort($this->place_to_visit); // place_to_visit
			$this->UpdateSort($this->days_to_leave); // days_to_leave
			$this->UpdateSort($this->status_id); // status_id
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->SqlOrderBy() <> "") {
				$sOrderBy = $this->SqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->leave_application_id->setSort("");
				$this->emp_id->setSort("");
				$this->leave_type_id->setSort("");
				$this->sickness->setSort("");
				$this->place_to_visit->setSort("");
				$this->days_to_leave->setSort("");
				$this->status_id->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanView();
		$item->OnLeft = TRUE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = TRUE;
		
		// "Approve"
		// $item = &$this->ListOptions->Add("copy");
		// $item->CssStyle = "white-space: nowrap;";
		// $item->Visible = $Security->CanEdit();
		// $item->OnLeft = TRUE;

		// "copy"
		// $item = &$this->ListOptions->Add("copy");
		// $item->CssStyle = "white-space: nowrap;";
		// $item->Visible = $Security->CanAdd();
		// $item->OnLeft = TRUE;

		// "detail_tbl_leavecoverage"
		// $item = &$this->ListOptions->Add("detail_tbl_leavecoverage");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'tbl_leavecoverage') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["tbl_leavecoverage_grid"])) $GLOBALS["tbl_leavecoverage_grid"] = new ctbl_leavecoverage_grid;

		// Multiple details
		if ($this->ShowMultipleDetails) {
			$item = &$this->ListOptions->Add("details");
			$item->CssStyle = "white-space: nowrap;";
			$item->Visible = $this->ShowMultipleDetails;
			$item->OnLeft = TRUE;
			$item->ShowInButtonGroup = FALSE;
		}

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = $Security->CanDelete();
		$item->OnLeft = TRUE;
		// $item->Header = "<label class=\"checkbox\"><input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\"></label>";
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->MoveTo(0);
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		$this->ListOptions->ButtonClass = "btn-small"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		if ($Security->CanView())
			$oListOpt->Body = "<a class=\"ewRowLink ewView\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewLink")) . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
		else
			$oListOpt->Body = "";

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($Security->CanEdit()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "copy"
		// $oListOpt = &$this->ListOptions->Items["copy"];
		// if ($Security->CanAdd()) {
			// $oListOpt->Body = "<a class=\"ewRowLink ewCopy\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CopyLink")) . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("CopyLink") . "</a>";
		// } else {
			// $oListOpt->Body = "";
		// }
		// $DetailViewTblVar = "";
		// $DetailCopyTblVar = "";
		// $DetailEditTblVar = "";

		// "detail_tbl_leavecoverage"
		// $oListOpt = &$this->ListOptions->Items["detail_tbl_leavecoverage"];
		// if ($Security->AllowList(CurrentProjectID() . 'tbl_leavecoverage')) {
			// $body = $Language->Phrase("DetailLink") . $Language->TablePhrase("tbl_leavecoverage", "TblCaption");
			// $body = "<a class=\"btn btn-small ewRowLink ewDetailList\" data-action=\"list\" href=\"" . ew_HtmlEncode("tbl_leavecoveragelist.php?" . EW_TABLE_SHOW_MASTER . "=tbl_employee_leaveapplication&leave_application_id=" . strval($this->leave_application_id->CurrentValue) . "") . "\">" . $body . "</a>";
			// $links = "";
			// if ($GLOBALS["tbl_leavecoverage_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'tbl_leavecoverage')) {
				// $links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=tbl_leavecoverage")) . "\">" . $Language->Phrase("MasterDetailViewLink") . "</a></li>";
				// if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				// $DetailViewTblVar .= "tbl_leavecoverage";
			// }
			// if ($GLOBALS["tbl_leavecoverage_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'tbl_leavecoverage')) {
				// $links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=tbl_leavecoverage")) . "\">" . $Language->Phrase("MasterDetailEditLink") . "</a></li>";
				// if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				// $DetailEditTblVar .= "tbl_leavecoverage";
			// }
			// if ($GLOBALS["tbl_leavecoverage_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 'tbl_leavecoverage')) {
				// $links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=tbl_leavecoverage")) . "\">" . $Language->Phrase("MasterDetailCopyLink") . "</a></li>";
				// if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				// $DetailCopyTblVar .= "tbl_leavecoverage";
			// }
			// if ($links <> "") {
				// $body .= "<button class=\"btn btn-small dropdown-toggle\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				// $body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			// }
			// $body = "<div class=\"btn-group\">" . $body . "</div>";
			// $oListOpt->Body = $body;
			// if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		// }
		if ($this->ShowMultipleDetails) {
			$body = $Language->Phrase("MultipleMasterDetails");
			$body = "<div class=\"btn-group\">" .
				"<a class=\"btn btn-small ewRowLink ewDetailView\" data-action=\"list\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailViewTblVar)) . "\">" . $body . "</a>";
			$links = "";
			if ($DetailViewTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailViewTblVar)) . "\">" . $Language->Phrase("MasterDetailViewLink") . "</a></li>";
			}
			if ($DetailEditTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailEditTblVar)) . "\">" . $Language->Phrase("MasterDetailEditLink") . "</a></li>";
			}
			if ($DetailCopyTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailCopyTblVar)) . "\">" . $Language->Phrase("MasterDetailCopyLink") . "</a></li>";
			}
			if ($links <> "") {
				$body .= "<button class=\"btn btn-small dropdown-toggle\" data-toggle=\"dropdown\">&nbsp;<b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body .= "</div>";

			// Multiple details
			$oListOpt = &$this->ListOptions->Items["details"];
			$oListOpt->Body = $body;
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->leave_application_id->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event, this);'>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$item->Body = "<a class=\"ewAddEdit ewAdd\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());
		$option = $options["detail"];
		$DetailTableLink = "";
		$item = &$option->Add("detailadd_tbl_leavecoverage");
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" href=\"" . ew_HtmlEncode($this->GetAddUrl() . "?" . EW_TABLE_SHOW_DETAIL . "=tbl_leavecoverage") . "\">" . $Language->Phrase("AddLink") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["tbl_leavecoverage"]->TableCaption() . "</a>";
		$item->Visible = ($GLOBALS["tbl_leavecoverage"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 'tbl_leavecoverage') && $Security->CanAdd());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "tbl_leavecoverage";
		}

		// Add multiple details
		if ($this->ShowMultipleDetails) {
			$item = &$option->Add("detailsadd");
			$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" href=\"" . ew_HtmlEncode($this->GetAddUrl() . "?" . EW_TABLE_SHOW_DETAIL . "=" . $DetailTableLink) . "\">" . $Language->Phrase("AddMasterDetailLink") . "</a>";
			$item->Visible = ($DetailTableLink <> "" && $Security->CanAdd());

			// Hide single master/detail items
			$ar = explode(",", $DetailTableLink);
			$cnt = count($ar);
			for ($i = 0; $i < $cnt; $i++) {
				if ($item = &$option->GetItem("detailadd_" . $ar[$i]))
					$item->Visible = FALSE;
			}
		}
		$option = $options["action"];

		// Add multi delete
		$item = &$option->Add("multidelete");
		$item->Body = "<a class=\"ewAction ewMultiDelete\" href=\"\" onclick=\"ew_SubmitSelected(document.ftbl_employee_leaveapplicationlist, '" . $this->MultiDeleteUrl . "');return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
		$item->Visible = ($Security->CanDelete());

		// Set up options default
		foreach ($options as &$option) {
			$option->UseDropDownButton = FALSE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-small"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
			$option = &$options["action"];
			foreach ($this->CustomActions as $action => $name) {

				// Add custom action
				$item = &$option->Add("custom_" . $action);
				$item->Body = "<a class=\"ewAction ewCustomAction\" href=\"\" onclick=\"ew_SubmitSelected(document.ftbl_employee_leaveapplicationlist, '" . ew_CurrentUrl() . "', null, '" . $action . "');return false;\">" . $name . "</a>";
			}

			// Hide grid edit, multi-delete and multi-update
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$item = &$option->GetItem("multidelete");
				if ($item) $item->Visible = FALSE;
				$item = &$option->GetItem("multiupdate");
				if ($item) $item->Visible = FALSE;
			}
	}

	// Process custom action
	function ProcessCustomAction() {
		global $conn, $Language, $Security;
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$rsuser = ($rs) ? $rs->GetRows() : array();
			if ($rs)
				$rs->Close();

			// Call row custom action event
			if (count($rsuser) > 0) {
				$conn->BeginTrans();
				foreach ($rsuser as $row) {
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $UserAction, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $UserAction, $Language->Phrase("CustomActionCancelled")));
					}
				}
			}
		}
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("leave_application_id")) <> "")
			$this->leave_application_id->CurrentValue = $this->getKey("leave_application_id"); // leave_application_id
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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
		$item->Body = "<a id=\"emf_tbl_employee_leaveapplication\" href=\"javascript:void(0);\" class=\"ewExportLink ewEmail\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_tbl_employee_leaveapplication',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.ftbl_employee_leaveapplicationlist,sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
		$item->Visible = FALSE;

		// Drop down button for export
		$this->ExportOptions->UseDropDownButton = FALSE;
		$this->ExportOptions->DropDownButtonPhrase = $Language->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = EW_SELECT_LIMIT;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $this->SelectRecordCount();
		} else {
			if ($rs = $this->LoadRecordset())
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;

		// Export all
		if ($this->ExportAll) {
			set_time_limit(EW_EXPORT_ALL_TIME_LIMIT);
			$this->DisplayRecs = $this->TotalRecs;
			$this->StopRec = $this->TotalRecs;
		} else { // Export one page only
			$this->SetUpStartRec(); // Set up start record position

			// Set the last record to display
			if ($this->DisplayRecs <= 0) {
				$this->StopRec = $this->TotalRecs;
			} else {
				$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
			}
		}
		if ($bSelectLimit)
			$rs = $this->LoadRecordset($this->StartRec-1, $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs);
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$ExportDoc = ew_ExportDocument($this, "h");
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
		$this->ExportDocument($ExportDoc, $rs, $StartRec, $StopRec, "");
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
		$url = ew_CurrentUrl();
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", $url, $this->TableVar);
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($tbl_employee_leaveapplication_list)) $tbl_employee_leaveapplication_list = new ctbl_employee_leaveapplication_list();

// Page init
$tbl_employee_leaveapplication_list->Page_Init();

// Page main
$tbl_employee_leaveapplication_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tbl_employee_leaveapplication_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php


if($_POST['btnAction'] == true)
{
	echo "aaaaaaaaaaaaaaa";
}



?>
<?php if ($tbl_employee_leaveapplication->Export == "") { ?>
<script type="text/javascript">

// Page object
var tbl_employee_leaveapplication_list = new ew_Page("tbl_employee_leaveapplication_list");
tbl_employee_leaveapplication_list.PageID = "list"; // Page ID
var EW_PAGE_ID = tbl_employee_leaveapplication_list.PageID; // For backward compatibility

// Form object
var ftbl_employee_leaveapplicationlist = new ew_Form("ftbl_employee_leaveapplicationlist");
ftbl_employee_leaveapplicationlist.FormKeyCountName = '<?php echo $tbl_employee_leaveapplication_list->FormKeyCountName ?>';

// Form_CustomValidate event
ftbl_employee_leaveapplicationlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_employee_leaveapplicationlist.ValidateRequired = true;
<?php } else { ?>
ftbl_employee_leaveapplicationlist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftbl_employee_leaveapplicationlist.Lists["x_emp_id"] = {"LinkField":"x_emp_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_empLastName","x_empFirstName","x_empMiddleName",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_employee_leaveapplicationlist.Lists["x_leave_type_id"] = {"LinkField":"x_leave_type_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_leave_type_title","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_employee_leaveapplicationlist.Lists["x_status_id"] = {"LinkField":"x_status_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_status_title","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
var ftbl_employee_leaveapplicationlistsrch = new ew_Form("ftbl_employee_leaveapplicationlistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($tbl_employee_leaveapplication->Export == "") { ?>
<?php //$Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($tbl_employee_leaveapplication_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $tbl_employee_leaveapplication_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$tbl_employee_leaveapplication_list->TotalRecs = $tbl_employee_leaveapplication->SelectRecordCount();
	} else {
		if ($tbl_employee_leaveapplication_list->Recordset = $tbl_employee_leaveapplication_list->LoadRecordset())
			$tbl_employee_leaveapplication_list->TotalRecs = $tbl_employee_leaveapplication_list->Recordset->RecordCount();
	}
	$tbl_employee_leaveapplication_list->StartRec = 1;
	if ($tbl_employee_leaveapplication_list->DisplayRecs <= 0 || ($tbl_employee_leaveapplication->Export <> "" && $tbl_employee_leaveapplication->ExportAll)) // Display all records
		$tbl_employee_leaveapplication_list->DisplayRecs = $tbl_employee_leaveapplication_list->TotalRecs;
	if (!($tbl_employee_leaveapplication->Export <> "" && $tbl_employee_leaveapplication->ExportAll))
		$tbl_employee_leaveapplication_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$tbl_employee_leaveapplication_list->Recordset = $tbl_employee_leaveapplication_list->LoadRecordset($tbl_employee_leaveapplication_list->StartRec-1, $tbl_employee_leaveapplication_list->DisplayRecs);
$tbl_employee_leaveapplication_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($tbl_employee_leaveapplication->Export == "" && $tbl_employee_leaveapplication->CurrentAction == "") { ?>
<form name="ftbl_employee_leaveapplicationlistsrch" id="ftbl_employee_leaveapplicationlistsrch" class="ewForm form-inline" action="<?php echo ew_CurrentPage() ?>">
<table class="table table-hover"><tr><td>
<div class="accordion" id="ftbl_employee_leaveapplicationlistsrch_SearchGroup">
	<div class="accordion-group">
		<div class="accordion-heading">
<a class="accordion-toggle" data-toggle="collapse" data-parent="#ftbl_employee_leaveapplicationlistsrch_SearchGroup" href="#ftbl_employee_leaveapplicationlistsrch_SearchBody"><?php echo $Language->Phrase("Search") ?></a>
		</div>
		<div id="ftbl_employee_leaveapplicationlistsrch_SearchBody" class="accordion-body collapse in">
			<div class="accordion-inner">
<div id="ftbl_employee_leaveapplicationlistsrch_SearchPanel">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="tbl_employee_leaveapplication">
<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="btn-group ewButtonGroup">
	<div class="input-append">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="input-large" value="<?php echo ew_HtmlEncode($tbl_employee_leaveapplication_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo $Language->Phrase("Search") ?>">
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("QuickSearchBtn") ?></button>
	</div>
	</div>
	<div class="btn-group ewButtonGroup">
	<a class="btn ewShowAll" href="<?php echo $tbl_employee_leaveapplication_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>
</div>
<div id="xsr_2" class="ewRow">
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="="<?php if ($tbl_employee_leaveapplication_list->BasicSearch->getType() == "=") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($tbl_employee_leaveapplication_list->BasicSearch->getType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($tbl_employee_leaveapplication_list->BasicSearch->getType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
</div>
</div>
</div>
			</div>
		</div>
	</div>
</div>
</td></tr></table>
</form>
<?php } ?>
<?php } ?>
<?php $tbl_employee_leaveapplication_list->ShowPageHeader(); ?>
<?php
$tbl_employee_leaveapplication_list->ShowMessage();


if(CurrentUserLevel() == "-1")
{
	include "edit_leave.php";
}

if($hris_Success_Message == "Add succeeded")
{
	//cmalvarez
	$leaveApplicationDAO = new leaveApplicationDAO();
	$getMaxLeaveApplicationID = $leaveApplicationDAO->getMaxLeaveApplicationID();
					//print_r($getMaxLeaveApplicationID);
					$maxLeaveApplicationID = $getMaxLeaveApplicationID[0]['maxLeaveApplicationID'];
					echo $maxLeaveApplicationID;
					 header('Location: tbl_leavecoveragelist.php?showmaster=tbl_employee_leaveapplication&leave_application_id=$maxLeaveApplicationID');
}

if(CurrentUserLevel() == "2")
{
	
include "add_leave.php";//carla	

echo "<center>";
include "leave_balances.php";
echo "</center>";
echo "<br/>";echo "<br/>";echo "<br/>";echo "<br/>";echo "<br/>";
echo "<br/>";echo "<br/>";echo "<br/>";echo "<br/>";echo "<br/>";
echo "<br/>";echo "<br/>";echo "<br/>";echo "<br/>";echo "<br/>";
echo "<br/>";echo "<br/>";
}
?>
<table cellspacing="0"  class="table" width = "100%"><tr><td class="ewGridContent">
<?php if ($tbl_employee_leaveapplication->Export == "") { ?>
<div class="ewGridUpperPanel">

<?php if ($tbl_employee_leaveapplication->CurrentAction <> "gridadd" && $tbl_employee_leaveapplication->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager">
<tr><td>
<?php if (!isset($tbl_employee_leaveapplication_list->Pager)) $tbl_employee_leaveapplication_list->Pager = new cNumericPager($tbl_employee_leaveapplication_list->StartRec, $tbl_employee_leaveapplication_list->DisplayRecs, $tbl_employee_leaveapplication_list->TotalRecs, $tbl_employee_leaveapplication_list->RecRange) ?>
<?php if ($tbl_employee_leaveapplication_list->Pager->RecordCount > 0) { ?>
<table cellspacing="0" class="ewStdTable"><tbody><tr><td>
<div class="pagination"><ul>
	<?php if ($tbl_employee_leaveapplication_list->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $tbl_employee_leaveapplication_list->PageUrl() ?>start=<?php echo $tbl_employee_leaveapplication_list->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($tbl_employee_leaveapplication_list->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $tbl_employee_leaveapplication_list->PageUrl() ?>start=<?php echo $tbl_employee_leaveapplication_list->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($tbl_employee_leaveapplication_list->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $tbl_employee_leaveapplication_list->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($tbl_employee_leaveapplication_list->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $tbl_employee_leaveapplication_list->PageUrl() ?>start=<?php echo $tbl_employee_leaveapplication_list->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($tbl_employee_leaveapplication_list->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $tbl_employee_leaveapplication_list->PageUrl() ?>start=<?php echo $tbl_employee_leaveapplication_list->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
	<?php } ?>
</ul></div>
</td>
<td>
	<?php if ($tbl_employee_leaveapplication_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $tbl_employee_leaveapplication_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $tbl_employee_leaveapplication_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $tbl_employee_leaveapplication_list->Pager->RecordCount ?>
</td>
</tr></tbody></table>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($tbl_employee_leaveapplication_list->SearchWhere == "0=101") { ?>
	<p><?php echo $Language->Phrase("EnterSearchCriteria") ?></p>
	<?php } else { ?>
	<p><?php echo $Language->Phrase("NoRecord") ?></p>
	<?php } ?>
	<?php } else { ?>
	<p><?php echo $Language->Phrase("NoPermission") ?></p>
	<?php } ?>
<?php } ?>
</td>
<?php if ($tbl_employee_leaveapplication_list->TotalRecs > 0) { ?>
<td>
	&nbsp;&nbsp;&nbsp;&nbsp;
<input type="hidden" name="t" value="tbl_employee_leaveapplication">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="input-small" onchange="this.form.submit();">
<option value="10"<?php if ($tbl_employee_leaveapplication_list->DisplayRecs == 10) { ?> selected="selected"<?php } ?>>10</option>
<option value="20"<?php if ($tbl_employee_leaveapplication_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="50"<?php if ($tbl_employee_leaveapplication_list->DisplayRecs == 50) { ?> selected="selected"<?php } ?>>50</option>
<option value="100"<?php if ($tbl_employee_leaveapplication_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="ALL"<?php if ($tbl_employee_leaveapplication->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($tbl_employee_leaveapplication_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
</div>
<?php } ?>
<form name="ftbl_employee_leaveapplicationlist" id="ftbl_employee_leaveapplicationlist" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="tbl_employee_leaveapplication">
<div id="gmp_tbl_employee_leaveapplication" class="ewGridMiddlePanel">
<?php if ($tbl_employee_leaveapplication_list->TotalRecs > 0) { ?>
<table id="tbl_tbl_employee_leaveapplicationlist" class="table table-hover" width = "100%">
<!--carla-->
<?php echo $tbl_employee_leaveapplication->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$tbl_employee_leaveapplication_list->RenderListOptions();

// Render list options (header, left)
$tbl_employee_leaveapplication_list->ListOptions->Render("header", "left");
?>
<?php 

if(CurrentUserLevel() == "-1")
{
?>
<?php if ($tbl_employee_leaveapplication->leave_application_id->Visible) { // leave_application_id ?>
	<?php if ($tbl_employee_leaveapplication->SortUrl($tbl_employee_leaveapplication->leave_application_id) == "") { ?>
		<td><div id="elh_tbl_employee_leaveapplication_leave_application_id" class="tbl_employee_leaveapplication_leave_application_id"><div class="ewTableHeaderCaption"><?php echo "Leave Balance" ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_employee_leaveapplication->SortUrl($tbl_employee_leaveapplication->leave_application_id) ?>',1);"><div id="elh_tbl_employee_leaveapplication_leave_application_id" class="tbl_employee_leaveapplication_leave_application_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo "Leave Balance" ?></span><span class="ewTableHeaderSort"><?php if ($tbl_employee_leaveapplication->leave_application_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_employee_leaveapplication->leave_application_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>
<?php } ?>
<td>Leave Coverage</td>		
<?php if ($tbl_employee_leaveapplication->emp_id->Visible) { // emp_id ?>
	<?php if ($tbl_employee_leaveapplication->SortUrl($tbl_employee_leaveapplication->emp_id) == "") { ?>
		<td><div id="elh_tbl_employee_leaveapplication_emp_id" class="tbl_employee_leaveapplication_emp_id"><div class="ewTableHeaderCaption"><?php echo $tbl_employee_leaveapplication->emp_id->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_employee_leaveapplication->SortUrl($tbl_employee_leaveapplication->emp_id) ?>',1);"><div id="elh_tbl_employee_leaveapplication_emp_id" class="tbl_employee_leaveapplication_emp_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_employee_leaveapplication->emp_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_employee_leaveapplication->emp_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_employee_leaveapplication->emp_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_employee_leaveapplication->leave_type_id->Visible) { // leave_type_id ?>
	<?php if ($tbl_employee_leaveapplication->SortUrl($tbl_employee_leaveapplication->leave_type_id) == "") { ?>
		<td><div id="elh_tbl_employee_leaveapplication_leave_type_id" class="tbl_employee_leaveapplication_leave_type_id"><div class="ewTableHeaderCaption"><?php echo $tbl_employee_leaveapplication->leave_type_id->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_employee_leaveapplication->SortUrl($tbl_employee_leaveapplication->leave_type_id) ?>',1);"><div id="elh_tbl_employee_leaveapplication_leave_type_id" class="tbl_employee_leaveapplication_leave_type_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_employee_leaveapplication->leave_type_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_employee_leaveapplication->leave_type_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_employee_leaveapplication->leave_type_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_employee_leaveapplication->sickness->Visible) { // sickness ?>
	<?php if ($tbl_employee_leaveapplication->SortUrl($tbl_employee_leaveapplication->sickness) == "") { ?>
		<td><div id="elh_tbl_employee_leaveapplication_sickness" class="tbl_employee_leaveapplication_sickness"><div class="ewTableHeaderCaption"><?php echo $tbl_employee_leaveapplication->sickness->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_employee_leaveapplication->SortUrl($tbl_employee_leaveapplication->sickness) ?>',1);"><div id="elh_tbl_employee_leaveapplication_sickness" class="tbl_employee_leaveapplication_sickness">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_employee_leaveapplication->sickness->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($tbl_employee_leaveapplication->sickness->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_employee_leaveapplication->sickness->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_employee_leaveapplication->place_to_visit->Visible) { // place_to_visit ?>
	<?php if ($tbl_employee_leaveapplication->SortUrl($tbl_employee_leaveapplication->place_to_visit) == "") { ?>
		<td><div id="elh_tbl_employee_leaveapplication_place_to_visit" class="tbl_employee_leaveapplication_place_to_visit"><div class="ewTableHeaderCaption"><?php echo $tbl_employee_leaveapplication->place_to_visit->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_employee_leaveapplication->SortUrl($tbl_employee_leaveapplication->place_to_visit) ?>',1);"><div id="elh_tbl_employee_leaveapplication_place_to_visit" class="tbl_employee_leaveapplication_place_to_visit">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_employee_leaveapplication->place_to_visit->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($tbl_employee_leaveapplication->place_to_visit->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_employee_leaveapplication->place_to_visit->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_employee_leaveapplication->days_to_leave->Visible) { // days_to_leave ?>
	<?php if ($tbl_employee_leaveapplication->SortUrl($tbl_employee_leaveapplication->days_to_leave) == "") { ?>
		<td><div id="elh_tbl_employee_leaveapplication_days_to_leave" class="tbl_employee_leaveapplication_days_to_leave"><div class="ewTableHeaderCaption"><?php echo $tbl_employee_leaveapplication->days_to_leave->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_employee_leaveapplication->SortUrl($tbl_employee_leaveapplication->days_to_leave) ?>',1);"><div id="elh_tbl_employee_leaveapplication_days_to_leave" class="tbl_employee_leaveapplication_days_to_leave">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_employee_leaveapplication->days_to_leave->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_employee_leaveapplication->days_to_leave->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_employee_leaveapplication->days_to_leave->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_employee_leaveapplication->status_id->Visible) { // status_id ?>
	<?php if ($tbl_employee_leaveapplication->SortUrl($tbl_employee_leaveapplication->status_id) == "") { ?>
		<td><div id="elh_tbl_employee_leaveapplication_status_id" class="tbl_employee_leaveapplication_status_id"><div class="ewTableHeaderCaption"><?php echo $tbl_employee_leaveapplication->status_id->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_employee_leaveapplication->SortUrl($tbl_employee_leaveapplication->status_id) ?>',1);"><div id="elh_tbl_employee_leaveapplication_status_id" class="tbl_employee_leaveapplication_status_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_employee_leaveapplication->status_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_employee_leaveapplication->status_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_employee_leaveapplication->status_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$tbl_employee_leaveapplication_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($tbl_employee_leaveapplication->ExportAll && $tbl_employee_leaveapplication->Export <> "") {
	$tbl_employee_leaveapplication_list->StopRec = $tbl_employee_leaveapplication_list->TotalRecs;
} else {

	// Set the last record to display
	if ($tbl_employee_leaveapplication_list->TotalRecs > $tbl_employee_leaveapplication_list->StartRec + $tbl_employee_leaveapplication_list->DisplayRecs - 1)
		$tbl_employee_leaveapplication_list->StopRec = $tbl_employee_leaveapplication_list->StartRec + $tbl_employee_leaveapplication_list->DisplayRecs - 1;
	else
		$tbl_employee_leaveapplication_list->StopRec = $tbl_employee_leaveapplication_list->TotalRecs;
}
$tbl_employee_leaveapplication_list->RecCnt = $tbl_employee_leaveapplication_list->StartRec - 1;
if ($tbl_employee_leaveapplication_list->Recordset && !$tbl_employee_leaveapplication_list->Recordset->EOF) {
	$tbl_employee_leaveapplication_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $tbl_employee_leaveapplication_list->StartRec > 1)
		$tbl_employee_leaveapplication_list->Recordset->Move($tbl_employee_leaveapplication_list->StartRec - 1);
} elseif (!$tbl_employee_leaveapplication->AllowAddDeleteRow && $tbl_employee_leaveapplication_list->StopRec == 0) {
	$tbl_employee_leaveapplication_list->StopRec = $tbl_employee_leaveapplication->GridAddRowCount;
}

// Initialize aggregate
$tbl_employee_leaveapplication->RowType = EW_ROWTYPE_AGGREGATEINIT;
$tbl_employee_leaveapplication->ResetAttrs();
$tbl_employee_leaveapplication_list->RenderRow();
while ($tbl_employee_leaveapplication_list->RecCnt < $tbl_employee_leaveapplication_list->StopRec) {
	$tbl_employee_leaveapplication_list->RecCnt++;
	if (intval($tbl_employee_leaveapplication_list->RecCnt) >= intval($tbl_employee_leaveapplication_list->StartRec)) {
		$tbl_employee_leaveapplication_list->RowCnt++;

		// Set up key count
		$tbl_employee_leaveapplication_list->KeyCount = $tbl_employee_leaveapplication_list->RowIndex;

		// Init row class and style
		$tbl_employee_leaveapplication->ResetAttrs();
		$tbl_employee_leaveapplication->CssClass = "";
		if ($tbl_employee_leaveapplication->CurrentAction == "gridadd") {
		} else {
			$tbl_employee_leaveapplication_list->LoadRowValues($tbl_employee_leaveapplication_list->Recordset); // Load row values
		}
		$tbl_employee_leaveapplication->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$tbl_employee_leaveapplication->RowAttrs = array_merge($tbl_employee_leaveapplication->RowAttrs, array('data-rowindex'=>$tbl_employee_leaveapplication_list->RowCnt, 'id'=>'r' . $tbl_employee_leaveapplication_list->RowCnt . '_tbl_employee_leaveapplication', 'data-rowtype'=>$tbl_employee_leaveapplication->RowType));

		// Render row
		$tbl_employee_leaveapplication_list->RenderRow();

		// Render list options
		$tbl_employee_leaveapplication_list->RenderListOptions();
?>
	<tr<?php echo $tbl_employee_leaveapplication->RowAttributes() ?>>
<?php

// Render list options (body, left)
$tbl_employee_leaveapplication_list->ListOptions->Render("body", "left", $tbl_employee_leaveapplication_list->RowCnt);
?>
<?php 
	if(CurrentUserLevel() == "-1")
	{
		?>
	<?php if ($tbl_employee_leaveapplication->leave_application_id->Visible) { // leave_application_id ?>
		<td<?php echo $tbl_employee_leaveapplication->leave_application_id->CellAttributes() ?>>
<span<?php echo $tbl_employee_leaveapplication->leave_application_id->ViewAttributes() ?>>

<?php
		include "leave_balance_admin.php";
		//carla echo $tbl_employee_leaveapplication->leave_application_id->ListViewValue() 
	?>
</span>
<a id="<?php echo $tbl_employee_leaveapplication_list->PageObjName . "_row_" . $tbl_employee_leaveapplication_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php } ?>
	
		<?php if ($tbl_employee_leaveapplication->leave_application_id->Visible) { // leave_application_id ?>
		<td<?php echo $tbl_employee_leaveapplication->leave_application_id->CellAttributes() ?>>
<span<?php echo $tbl_employee_leaveapplication->leave_application_id->ViewAttributes() ?>>
<?php 
	//echo $tbl_employee_leaveapplication->leave_application_id->CurrentValue;
	if(CurrentUserLevel() == "-1")
	{
		include "leave_coverage_admin.php";
	}else
	{
		?>
		
	<a href = "tbl_leavecoveragelist.php?showmaster=tbl_employee_leaveapplication&leave_application_id=<?php echo $tbl_employee_leaveapplication->leave_application_id->CurrentValue; ?>"> Leave Coverage</a>
		<?php
	}
//carla echo $tbl_employee_leaveapplication->leave_application_id->ListViewValue() ?></span>
<a id="<?php echo $tbl_employee_leaveapplication_list->PageObjName . "_row_" . $tbl_employee_leaveapplication_list->RowCnt ?>"></a></td>
	<?php } ?>
	
	
	<?php if ($tbl_employee_leaveapplication->emp_id->Visible) { // emp_id ?>
		<td<?php echo $tbl_employee_leaveapplication->emp_id->CellAttributes() ?>>
<span<?php echo $tbl_employee_leaveapplication->emp_id->ViewAttributes() ?>>
<?php echo $tbl_employee_leaveapplication->emp_id->ListViewValue() ?></span>
<a id="<?php echo $tbl_employee_leaveapplication_list->PageObjName . "_row_" . $tbl_employee_leaveapplication_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($tbl_employee_leaveapplication->leave_type_id->Visible) { // leave_type_id ?>
		<td<?php echo $tbl_employee_leaveapplication->leave_type_id->CellAttributes() ?>>
<span<?php echo $tbl_employee_leaveapplication->leave_type_id->ViewAttributes() ?>>
<?php echo $tbl_employee_leaveapplication->leave_type_id->ListViewValue() ?></span>
<a id="<?php echo $tbl_employee_leaveapplication_list->PageObjName . "_row_" . $tbl_employee_leaveapplication_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($tbl_employee_leaveapplication->sickness->Visible) { // sickness ?>
		<td<?php echo $tbl_employee_leaveapplication->sickness->CellAttributes() ?>>
<span<?php echo $tbl_employee_leaveapplication->sickness->ViewAttributes() ?>>
<?php echo $tbl_employee_leaveapplication->sickness->ListViewValue() ?></span>
<a id="<?php echo $tbl_employee_leaveapplication_list->PageObjName . "_row_" . $tbl_employee_leaveapplication_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($tbl_employee_leaveapplication->place_to_visit->Visible) { // place_to_visit ?>
		<td<?php echo $tbl_employee_leaveapplication->place_to_visit->CellAttributes() ?>>
<span<?php echo $tbl_employee_leaveapplication->place_to_visit->ViewAttributes() ?>>
<?php echo $tbl_employee_leaveapplication->place_to_visit->ListViewValue() ?></span>
<a id="<?php echo $tbl_employee_leaveapplication_list->PageObjName . "_row_" . $tbl_employee_leaveapplication_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($tbl_employee_leaveapplication->days_to_leave->Visible) { // days_to_leave ?>
		<td<?php echo $tbl_employee_leaveapplication->days_to_leave->CellAttributes() ?>>
<span<?php echo $tbl_employee_leaveapplication->days_to_leave->ViewAttributes() ?>>
<?php echo $tbl_employee_leaveapplication->days_to_leave->ListViewValue() ?></span>
<a id="<?php echo $tbl_employee_leaveapplication_list->PageObjName . "_row_" . $tbl_employee_leaveapplication_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($tbl_employee_leaveapplication->status_id->Visible) { // status_id ?>
		<td<?php echo $tbl_employee_leaveapplication->status_id->CellAttributes() ?>>
<span<?php echo $tbl_employee_leaveapplication->status_id->ViewAttributes() ?>>
<?php echo $tbl_employee_leaveapplication->status_id->ListViewValue() ?></span>
<a id="<?php echo $tbl_employee_leaveapplication_list->PageObjName . "_row_" . $tbl_employee_leaveapplication_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$tbl_employee_leaveapplication_list->ListOptions->Render("body", "right", $tbl_employee_leaveapplication_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($tbl_employee_leaveapplication->CurrentAction <> "gridadd")
		$tbl_employee_leaveapplication_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($tbl_employee_leaveapplication->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($tbl_employee_leaveapplication_list->Recordset)
	$tbl_employee_leaveapplication_list->Recordset->Close();
?>
<?php if ($tbl_employee_leaveapplication_list->TotalRecs > 0) { ?>
<?php if ($tbl_employee_leaveapplication->Export == "") { ?>
<div class="ewGridLowerPanel">
<?php if ($tbl_employee_leaveapplication->CurrentAction <> "gridadd" && $tbl_employee_leaveapplication->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager">
<tr><td>
<?php if (!isset($tbl_employee_leaveapplication_list->Pager)) $tbl_employee_leaveapplication_list->Pager = new cNumericPager($tbl_employee_leaveapplication_list->StartRec, $tbl_employee_leaveapplication_list->DisplayRecs, $tbl_employee_leaveapplication_list->TotalRecs, $tbl_employee_leaveapplication_list->RecRange) ?>
<?php if ($tbl_employee_leaveapplication_list->Pager->RecordCount > 0) { ?>
<table cellspacing="0" class="ewStdTable"><tbody><tr><td>
<div class="pagination"><ul>
	<?php if ($tbl_employee_leaveapplication_list->Pager->FirstButton->Enabled) { ?>
	<li><a href="<?php echo $tbl_employee_leaveapplication_list->PageUrl() ?>start=<?php echo $tbl_employee_leaveapplication_list->Pager->FirstButton->Start ?>"><?php echo $Language->Phrase("PagerFirst") ?></a></li>
	<?php } ?>
	<?php if ($tbl_employee_leaveapplication_list->Pager->PrevButton->Enabled) { ?>
	<li><a href="<?php echo $tbl_employee_leaveapplication_list->PageUrl() ?>start=<?php echo $tbl_employee_leaveapplication_list->Pager->PrevButton->Start ?>"><?php echo $Language->Phrase("PagerPrevious") ?></a></li>
	<?php } ?>
	<?php foreach ($tbl_employee_leaveapplication_list->Pager->Items as $PagerItem) { ?>
		<li<?php if (!$PagerItem->Enabled) { echo " class=\" active\""; } ?>><a href="<?php if ($PagerItem->Enabled) { echo $tbl_employee_leaveapplication_list->PageUrl() . "start=" . $PagerItem->Start; } else { echo "#"; } ?>"><?php echo $PagerItem->Text ?></a></li>
	<?php } ?>
	<?php if ($tbl_employee_leaveapplication_list->Pager->NextButton->Enabled) { ?>
	<li><a href="<?php echo $tbl_employee_leaveapplication_list->PageUrl() ?>start=<?php echo $tbl_employee_leaveapplication_list->Pager->NextButton->Start ?>"><?php echo $Language->Phrase("PagerNext") ?></a></li>
	<?php } ?>
	<?php if ($tbl_employee_leaveapplication_list->Pager->LastButton->Enabled) { ?>
	<li><a href="<?php echo $tbl_employee_leaveapplication_list->PageUrl() ?>start=<?php echo $tbl_employee_leaveapplication_list->Pager->LastButton->Start ?>"><?php echo $Language->Phrase("PagerLast") ?></a></li>
	<?php } ?>
</ul></div>
</td>
<td>
	<?php if ($tbl_employee_leaveapplication_list->Pager->ButtonCount > 0) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $tbl_employee_leaveapplication_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $tbl_employee_leaveapplication_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $tbl_employee_leaveapplication_list->Pager->RecordCount ?>
</td>
</tr></tbody></table>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($tbl_employee_leaveapplication_list->SearchWhere == "0=101") { ?>
	<p><?php echo $Language->Phrase("EnterSearchCriteria") ?></p>
	<?php } else { ?>
	<p><?php echo $Language->Phrase("NoRecord") ?></p>
	<?php } ?>
	<?php } else { ?>
	<p><?php echo $Language->Phrase("NoPermission") ?></p>
	<?php } ?>
<?php } ?>
</td>
<?php if ($tbl_employee_leaveapplication_list->TotalRecs > 0) { ?>
<td>
	&nbsp;&nbsp;&nbsp;&nbsp;
<input type="hidden" name="t" value="tbl_employee_leaveapplication">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="input-small" onchange="this.form.submit();">
<option value="10"<?php if ($tbl_employee_leaveapplication_list->DisplayRecs == 10) { ?> selected="selected"<?php } ?>>10</option>
<option value="20"<?php if ($tbl_employee_leaveapplication_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="50"<?php if ($tbl_employee_leaveapplication_list->DisplayRecs == 50) { ?> selected="selected"<?php } ?>>50</option>
<option value="100"<?php if ($tbl_employee_leaveapplication_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="ALL"<?php if ($tbl_employee_leaveapplication->getRecordsPerPage() == -1) { ?> selected="selected"<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</td>
<?php } ?>
</tr></table>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($tbl_employee_leaveapplication_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
</div>
<?php } ?>
<?php } ?>
</td></tr></table>
<?php if ($tbl_employee_leaveapplication->Export == "") { ?>
<script type="text/javascript">
ftbl_employee_leaveapplicationlistsrch.Init();
ftbl_employee_leaveapplicationlist.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$tbl_employee_leaveapplication_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($tbl_employee_leaveapplication->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$tbl_employee_leaveapplication_list->Page_Terminate();
?>
