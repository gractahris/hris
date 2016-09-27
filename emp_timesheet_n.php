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
<?php include "model/DAO.php" ?>
<?php include "model/userDAO.php" ?>
<?php include "model/employeeDeductionDAO.php" ?>
<?php include "model/leaveCreditDAO.php" ?>
<?php include_once "model/timesheetDAO.php" ?>
<?php include_once "model/timesheetAdminDAO.php" ?>
<?php include_once "DigitalClock.php" ?>
<?php

//
// Page class
//

$username = CurrentUserName();
// echo CurrentUserLevel();
// echo $username;
$userDAO = new userDAO();
$getUserByUserName = $userDAO->getUserByUserName($username);
foreach($getUserByUserName as $key => $val)
{
		
	$emp_id = $val['emp_id'];
	$_SESSION['emp_id'] = $emp_id;
	// echo $_SESSION['emp_id'];
	
}


$tbl_employee_list = NULL; // Initialize page object first

class ctbl_employee_list extends ctbl_employee {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}";

	// Table name
	var $TableName = 'tbl_employee';

	// Page object name
	var $PageObjName = 'tbl_employee_list';

	// Grid form hidden field names
	var $FormName = 'ftbl_employeelist';
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

		// Table object (tbl_employee)
		if (!isset($GLOBALS["tbl_employee"])) {
			$GLOBALS["tbl_employee"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbl_employee"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "tbl_employeeadd.php?" . EW_TABLE_SHOW_DETAIL . "=";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "tbl_employeedelete.php";
		$this->MultiUpdateUrl = "tbl_employeeupdate.php";

		// Table object (tbl_user)
		if (!isset($GLOBALS['tbl_user'])) $GLOBALS['tbl_user'] = new ctbl_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_employee', TRUE);

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
		$this->emp_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
			$this->emp_id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->emp_id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->empFirstName, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->empMiddleName, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->empLastName, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->empExtensionName, $Keyword);
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
			$this->UpdateSort($this->emp_id); // emp_id
			$this->UpdateSort($this->empFirstName); // empFirstName
			$this->UpdateSort($this->empMiddleName); // empMiddleName
			$this->UpdateSort($this->empLastName); // empLastName
			$this->UpdateSort($this->empExtensionName); // empExtensionName
			$this->UpdateSort($this->sex_id); // sex_id
			$this->UpdateSort($this->schedule_id); // schedule_id
			$this->UpdateSort($this->salary_id); // salary_id
			$this->UpdateSort($this->tax_category_id); // tax_category_id
			$this->UpdateSort($this->date_hired); // date_hired
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
				$this->emp_id->setSort("");
				$this->empFirstName->setSort("");
				$this->empMiddleName->setSort("");
				$this->empLastName->setSort("");
				$this->empExtensionName->setSort("");
				$this->sex_id->setSort("");
				$this->schedule_id->setSort("");
				$this->salary_id->setSort("");
				$this->tax_category_id->setSort("");
				$this->date_hired->setSort("");
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

		// "copy"
		// $item = &$this->ListOptions->Add("copy");
		// $item->CssStyle = "white-space: nowrap;";
		// $item->Visible = $Security->CanAdd();
		// $item->OnLeft = TRUE;
		if(CurrentUserLevel() <> 2)//carla
		{
		// "detail_tbl_employee_deduction"
		// $item = &$this->ListOptions->Add("detail_tbl_employee_deduction");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'tbl_employee_deduction') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["tbl_employee_deduction_grid"])) $GLOBALS["tbl_employee_deduction_grid"] = new ctbl_employee_deduction_grid;

		// "detail_tbl_employee_leavecredit"
		// $item = &$this->ListOptions->Add("detail_tbl_employee_leavecredit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'tbl_employee_leavecredit') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["tbl_employee_leavecredit_grid"])) $GLOBALS["tbl_employee_leavecredit_grid"] = new ctbl_employee_leavecredit_grid;
		
		}

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
		$item->Header = "<label class=\"checkbox\"><input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\"></label>";
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
		 /*$DetailViewTblVar = "";
		 $DetailCopyTblVar = "";
		 $DetailEditTblVar = "";*/

		// "detail_tbl_employee_deduction"
		// $oListOpt = &$this->ListOptions->Items["detail_tbl_employee_deduction"];
		// if ($Security->AllowList(CurrentProjectID() . 'tbl_employee_deduction')) {
			// $body = $Language->Phrase("DetailLink") . $Language->TablePhrase("tbl_employee_deduction", "TblCaption");
			// $body = "<a class=\"btn btn-small ewRowLink ewDetailList\" data-action=\"list\" href=\"" . ew_HtmlEncode("tbl_employee_deductionlist.php?" . EW_TABLE_SHOW_MASTER . "=tbl_employee&emp_id=" . strval($this->emp_id->CurrentValue) . "") . "\">" . $body . "</a>";
			// $links = "";
			// if ($GLOBALS["tbl_employee_deduction_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'tbl_employee_deduction')) {
				// $links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=tbl_employee_deduction")) . "\">" . $Language->Phrase("MasterDetailViewLink") . "</a></li>";
				// if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				// $DetailViewTblVar .= "tbl_employee_deduction";
			// }
			// if ($GLOBALS["tbl_employee_deduction_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'tbl_employee_deduction')) {
				// $links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=tbl_employee_deduction")) . "\">" . $Language->Phrase("MasterDetailEditLink") . "</a></li>";
				// if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				// $DetailEditTblVar .= "tbl_employee_deduction";
			// }
			// if ($GLOBALS["tbl_employee_deduction_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 'tbl_employee_deduction')) {
				// $links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=tbl_employee_deduction")) . "\">" . $Language->Phrase("MasterDetailCopyLink") . "</a></li>";
				// if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				// $DetailCopyTblVar .= "tbl_employee_deduction";
			// }
			// if ($links <> "") {
				// $body .= "<button class=\"btn btn-small dropdown-toggle\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				// $body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			// }
			// $body = "<div class=\"btn-group\">" . $body . "</div>";
			// $oListOpt->Body = $body;
			// if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		// }

		// "detail_tbl_employee_leavecredit"
		// $oListOpt = &$this->ListOptions->Items["detail_tbl_employee_leavecredit"];
		// if ($Security->AllowList(CurrentProjectID() . 'tbl_employee_leavecredit')) {
			// $body = $Language->Phrase("DetailLink") . $Language->TablePhrase("tbl_employee_leavecredit", "TblCaption");
			// $body = "<a class=\"btn btn-small ewRowLink ewDetailList\" data-action=\"list\" href=\"" . ew_HtmlEncode("tbl_employee_leavecreditlist.php?" . EW_TABLE_SHOW_MASTER . "=tbl_employee&emp_id=" . strval($this->emp_id->CurrentValue) . "") . "\">" . $body . "</a>";
			// $links = "";
			// if ($GLOBALS["tbl_employee_leavecredit_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'tbl_employee_leavecredit')) {
				// $links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=tbl_employee_leavecredit")) . "\">" . $Language->Phrase("MasterDetailViewLink") . "</a></li>";
				// if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				// $DetailViewTblVar .= "tbl_employee_leavecredit";
			// }
			// if ($GLOBALS["tbl_employee_leavecredit_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'tbl_employee_leavecredit')) {
				// $links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=tbl_employee_leavecredit")) . "\">" . $Language->Phrase("MasterDetailEditLink") . "</a></li>";
				// if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				// $DetailEditTblVar .= "tbl_employee_leavecredit";
			// }
			// if ($GLOBALS["tbl_employee_leavecredit_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 'tbl_employee_leavecredit')) {
				// $links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=tbl_employee_leavecredit")) . "\">" . $Language->Phrase("MasterDetailCopyLink") . "</a></li>";
				// if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				// $DetailCopyTblVar .= "tbl_employee_leavecredit";
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->emp_id->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event, this);'>";
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
		if(CurrentUserLevel() <> 2) //carla
		{
			$item = &$option->Add("detailadd_tbl_employee_deduction");
			$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" href=\"" . ew_HtmlEncode($this->GetAddUrl() . "?" . EW_TABLE_SHOW_DETAIL . "=tbl_employee_deduction") . "\">" . $Language->Phrase("AddLink") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["tbl_employee_deduction"]->TableCaption() . "</a>";
			$item->Visible = ($GLOBALS["tbl_employee_deduction"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 'tbl_employee_deduction') && $Security->CanAdd());
			if ($item->Visible) {
				if ($DetailTableLink <> "") $DetailTableLink .= ",";
				$DetailTableLink .= "tbl_employee_deduction";
			}
			$item = &$option->Add("detailadd_tbl_employee_leavecredit");
			$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" href=\"" . ew_HtmlEncode($this->GetAddUrl() . "?" . EW_TABLE_SHOW_DETAIL . "=tbl_employee_leavecredit") . "\">" . $Language->Phrase("AddLink") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["tbl_employee_leavecredit"]->TableCaption() . "</a>";
			$item->Visible = ($GLOBALS["tbl_employee_leavecredit"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 'tbl_employee_leavecredit') && $Security->CanAdd());
			if ($item->Visible) {
				if ($DetailTableLink <> "") $DetailTableLink .= ",";
				$DetailTableLink .= "tbl_employee_leavecredit";
			}
		
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
		$item->Body = "<a class=\"ewAction ewMultiDelete\" href=\"\" onclick=\"ew_SubmitSelected(document.ftbl_employeelist, '" . $this->MultiDeleteUrl . "');return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
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
				$item->Body = "<a class=\"ewAction ewCustomAction\" href=\"\" onclick=\"ew_SubmitSelected(document.ftbl_employeelist, '" . ew_CurrentUrl() . "', null, '" . $action . "');return false;\">" . $name . "</a>";
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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
		$item->Body = "<a id=\"emf_tbl_employee\" href=\"javascript:void(0);\" class=\"ewExportLink ewEmail\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_tbl_employee',hdr:ewLanguage.Phrase('ExportToEmail'),f:document.ftbl_employeelist,sel:false});\">" . $Language->Phrase("ExportToEmail") . "</a>";
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

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'tbl_employee';
	  $usr = CurrentUserName();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
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
if (!isset($tbl_employee_list)) $tbl_employee_list = new ctbl_employee_list();

// Page init
$tbl_employee_list->Page_Init();

// Page main
$tbl_employee_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tbl_employee_list->Page_Render();
?>
<?php include_once "header.php" ?>

<?php if ($tbl_employee->Export == "") { ?>
<script type="text/javascript">

// Page object
var tbl_employee_list = new ew_Page("tbl_employee_list");
tbl_employee_list.PageID = "list"; // Page ID
var EW_PAGE_ID = tbl_employee_list.PageID; // For backward compatibility

// Form object
var ftbl_employeelist = new ew_Form("ftbl_employeelist");
ftbl_employeelist.FormKeyCountName = '<?php echo $tbl_employee_list->FormKeyCountName ?>';

// Form_CustomValidate event
ftbl_employeelist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_employeelist.ValidateRequired = true;
<?php } else { ?>
ftbl_employeelist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftbl_employeelist.Lists["x_sex_id"] = {"LinkField":"x_sex_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_sex_title","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_employeelist.Lists["x_schedule_id"] = {"LinkField":"x_schedule_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_schedule_title","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_employeelist.Lists["x_salary_id"] = {"LinkField":"x_salary_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_salary_amount","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_employeelist.Lists["x_tax_category_id"] = {"LinkField":"x_tax_category_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_tax_category_code","x_tax_category_title","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
var ftbl_employeelistsrch = new ew_Form("ftbl_employeelistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($tbl_employee->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($tbl_employee_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $tbl_employee_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$tbl_employee_list->TotalRecs = $tbl_employee->SelectRecordCount();
	} else {
		if ($tbl_employee_list->Recordset = $tbl_employee_list->LoadRecordset())
			$tbl_employee_list->TotalRecs = $tbl_employee_list->Recordset->RecordCount();
	}
	$tbl_employee_list->StartRec = 1;
	if ($tbl_employee_list->DisplayRecs <= 0 || ($tbl_employee->Export <> "" && $tbl_employee->ExportAll)) // Display all records
		$tbl_employee_list->DisplayRecs = $tbl_employee_list->TotalRecs;
	if (!($tbl_employee->Export <> "" && $tbl_employee->ExportAll))
		$tbl_employee_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$tbl_employee_list->Recordset = $tbl_employee_list->LoadRecordset($tbl_employee_list->StartRec-1, $tbl_employee_list->DisplayRecs);
$tbl_employee_list->RenderOtherOptions();
?>

<?php if(CurrentUserLevel() == "-1") { ?>

<?php if ($Security->CanSearch()) { ?>
<?php if ($tbl_employee->Export == "" && $tbl_employee->CurrentAction == "") { ?>
<form name="ftbl_employeelistsrch" id="ftbl_employeelistsrch" class="ewForm form-inline" action="<?php echo ew_CurrentPage() ?>">
<table class="ewSearchTable"><tr><td>
<div class="accordion" id="ftbl_employeelistsrch_SearchGroup">
	<div class="accordion-group">
		<div class="accordion-heading">
<a class="accordion-toggle" data-toggle="collapse" data-parent="#ftbl_employeelistsrch_SearchGroup" href="#ftbl_employeelistsrch_SearchBody"><?php echo $Language->Phrase("Search") ?></a>
		</div>
		<div id="ftbl_employeelistsrch_SearchBody" class="accordion-body collapse in">
			<div class="accordion-inner">
<div id="ftbl_employeelistsrch_SearchPanel">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="tbl_employee">
<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="btn-group ewButtonGroup">
	<div class="input-append">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="input-large" value="<?php echo ew_HtmlEncode($tbl_employee_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo $Language->Phrase("Search") ?>">
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("QuickSearchBtn") ?></button>
	</div>
	</div>
	<div class="btn-group ewButtonGroup">
	<a class="btn ewShowAll" href="<?php echo $tbl_employee_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>
</div>
<div id="xsr_2" class="ewRow">
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="="<?php if ($tbl_employee_list->BasicSearch->getType() == "=") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($tbl_employee_list->BasicSearch->getType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($tbl_employee_list->BasicSearch->getType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
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
<?php } } //end of search carla ?>
<?php $tbl_employee_list->ShowPageHeader(); ?>
<?php
$tbl_employee_list->ShowMessage();
?>


<!--carla-->



<?php
$timesheetDAO = new timesheetDAO();
//$timesheetAdminDAO = new $timesheetAdminDAO();
	$getSchedByEmp = $timesheetDAO->getSchedByEmp($_SESSION["emp_id"]);
	//echo "SchedID=>".$getSchedByEmp[0]['schedule_id'];
	echo "<br/>";
	$schedule_id = $getSchedByEmp[0]['schedule_id'];
	
	$getSchedByID = $timesheetDAO->getSchedByID($schedule_id);
	//print_r($getSchedByID);
	echo "Schedule: ".$getSchedByID[0]['schedule_title'];
	
	//echo "Time IN=>".$getSchedByID[0]['schedule_time_in']; 
	$schedule_time_in = $getSchedByID[0]['schedule_time_in']; 
	echo "<br/>";
	//echo "Time Out=>".$getSchedByID[0]['schedule_time_out']; 
	$schedule_time_out = $getSchedByID[0]['schedule_time_out']; 
	
	$noLogsFound = "<font color = 'red'><b>No logs found!</b></font>";
?>
<?php

/*echo date('r');
echo phpinfo();*/
$clock=new DigitalClock();
//carla
?>

<script type="text/javascript"> 
//carla
/*
function display_c(){
var refresh=1000; // Refresh rate in milli seconds
mytime=setTimeout('display_ct()',refresh)
}

function display_ct() {
var strcount
var x = new Date()
var x1=x.toUTCString();// changing the display to UTC string
document.getElementById('ct').innerHTML = x1;
tt=display_c();
}
*/


/*function display_ct() {
var strcount
var x = new Date()
var x1=x.getMonth() + "/" + x.getDate() + "/" + x.getYear(); 
x1 = x1 + " - " + x.getHours( )+ ":" + x.getMinutes() + ":" + x.getSeconds();
document.getElementById('ct').innerHTML = x1;

tt=display_c();
}

<body onload=display_ct();>
<span id='ct' ></span>
*/

//carla
</script>




<?php
	// echo $clock->getMonth()."/".$clock->getDay()."/".$clock->getYear();
	
	// $dateToday = $clock->getYear()."-0".$clock->getMonthNo()."-".$clock->getDay();
	// echo $dateToday;
	$getDateToday = $timesheetDAO->getDateToday();
	 $dateToday = $getDateToday[0]['dateToday'];
	//$dateToday = '2016-04-21';
	echo $dateToday;
	
	$dateYear = $getDateToday[0]['dateYear'];	
	$dateMonth = $getDateToday[0]['dateMonth'];	
	$dateDay = $getDateToday[0]['dateDay'];	
	// $day = 21;
	$day = $dateDay;
	
	
	$digitalClock = $clock->jsDigitalClock(300, 300);
	// $day = $clock->getDay();
	
	//$day = 18;
	//echo $day;
				// echo $digitalClock;
?>				

<?php
$monthArr = array("January","February","March","April","May","June","July","August","September","October","November","December");
$breakHours = "01:00:00";
foreach($monthArr as $key => $val)
{
	$counter = $key + 1;
	// if($clock->getMonth() == $val)
	if($clock->getMonth() == $val)
	{
		// echo $counter."=>".$val;
		if($counter < 10)
		{
			$month = "0".$counter;
		}else
		{
			$month = $counter;
		}
			
			$getDTR = $timesheetDAO->getDTR($_SESSION['emp_id'],$month,$day,$dateYear);
			//if($getDTR == true)
			//{
				foreach($getDTR as  $keyDTR => $valDTR)
				{
					$getTime = $timesheetDAO->getTime();
					
					echo "<form method = 'GET'>";
					echo "<input type = 'hidden' id='txtTimeIn' name='txtTimeIn' value = '".$getTime[0]["time"]."'/ >";
					
					echo "<input type = 'hidden' id='txtTimeOut' name='txtTimeOut' value = '".$getTime[0]["time"]."'/ >";
										
					$emp_id = $_SESSION['emp_id'];
					$emp_timein = $_GET["txtTimeIn"];
					$emp_timeout = 'NULL';
					$emp_totalhours = "0";
					$emp_late = "0";
					$emp_excesstime = "0";
					$emp_undertime = "0";
					$dtr_id = $valDTR['dtr_id'];
					
					// echo "dtr_id=>".$dtr_id;

					echo "<input class ='btn btn-primary' type='submit' id ='timeIN' name='timeIn' value='Time In' />";

					echo "<input class ='btn btn-primary' type='submit' id ='timeOut' name='timeOut' value='Time Out' />";
					echo "</form>";


					?>
					
					
					<!-- <input class ="btn btn-primary" type="submit" id ="timeOut" name="timeOut" value="Time Out" /> -->
					


					<?php
					
					if($_GET["timeIn"] == true)
					{
						if($_GET["txtTimeIn"] <> NULL)
						{
							if($_GET["txtTimeIn"] <> "")
							{
								// echo "dtr_id=>".$dtr_id;
								$getTimeLogOfDay = $timesheetDAO->getTimeLogOfDay($_SESSION["emp_id"],$dtr_id);
								
								// print_r()
								if($getTimeLogOfDay[0]['emp_timein'] == "00:00:00")
								{
									$saveTimeIN = $timesheetDAO->saveTimeIN($emp_id,$emp_timein,$emp_timeout, $emp_totalhours,$emp_late,$emp_excesstime,$emp_undertime,$dtr_id);
									
								}else if($getTimeLogOfDay[0]['emp_timein'] == NULL)
								{
									$saveTimeIN = $timesheetDAO->saveTimeIN($emp_id,$emp_timein,$emp_timeout, $emp_totalhours,$emp_late,$emp_excesstime,$emp_undertime,$dtr_id);
									
								}
								else if($getTimeLogOfDay[0]['dtr_id'] == NULL)
								{
									$saveTimeIN = $timesheetDAO->saveTimeIN($emp_id,$emp_timein,$emp_timeout, $emp_totalhours,$emp_late,$emp_excesstime,$emp_undertime,$dtr_id);
									
									
								?>
								
									<script>
									alert("You are logged in");
									</script>
								<?php
								}
								else
								{
									
									?>
									<script>
									alert("You have timed in already for this day !");
									</script>
									
									<?php
								}
								
							}
							
						}
					}else

					{
						//echo "aaaaaaaaa";

					}
					
					if($_GET["timeOut"] == true)
					{
						if($_GET["txtTimeOut"] <> NULL)
						{
							if($_GET["txtTimeOut"] <> "")
							{
								$getTimeLogOfDay = $timesheetDAO->getTimeLogOfDay($_SESSION["emp_id"],$dtr_id);
								
								if($getTimeLogOfDay[0]['emp_timeout'] == "00:00:00")
								{
									$updateTimeOut = $timesheetDAO->updateTimeOut($emp_id,$_GET["txtTimeOut"],$dtr_id);
								
								?>
									<script>
									alert("You are logged out");
									</script>
								<?php
								}else if($getTimeLogOfDay[0]['emp_timeout'] == NULL)
								{	
									$updateTimeOut = $timesheetDAO->updateTimeOut($emp_id,$_GET["txtTimeOut"],$dtr_id);
								}
								else if($getTimeLogOfDay[0]['emp_timein'] == NULL)
								{			
								
								?>
									<script>
									alert("You havent TIMED IN yet !");
									</script>
								<?php
								}
								else
								{
									//echo "You have timed out already for this day";
									
									?>
									<script>
									alert("You have timed out already for this day !");
									</script>
									
									<?php
								}
							}
							
						}
					}
						
					
				}
				
			//}else{
				
			//	echo "NO DTR";
			//}
		
		
	}
	
	// else
	// {
		// $month = $counter;
	// }
}

//getDTR
// $month_val = "0".$clock->getMonthNo();
$month_val = $dateMonth;

$getDTRofMonth = $timesheetDAO->getDTRofMonth($_SESSION['emp_id'],$month_val, $dateYear);

?>

	
<br/><br/><br/>
<table class = "table table-hover" width = "100%">
<thead color = "blue">
	<tr>
		<!--
		<td>DTR ID</td>
		<td>Emp ID</td>
		-->
		<td>Month</td>
		<td>Day</td>
		<td>Year</td>
		<td> </td>
		<td> </td>
		<td>Time IN</td>
		<td>Time OUT</td>
		<td>Mandatory<br/>Break<br/>Hours</td>
		<td>Total<br/>Hours</td>
		<td>Total Hours<br/>Less Mandatory<br/>Break Hours</td>
		<td>Total<br/>Late</td>
		<td>Total<br/>UnderTime</td>
		<td>Total<br/>Excess<br/>Time</td>
		<td>Remarks</td>
		
	</tr>
</thead>
<tbody>
	<tr>
<?php
	foreach($getDTRofMonth as $keyDTRMo => $valDTRMo)
	{
		/*
		echo "<td>";
		echo $valDTRMo['dtr_id'];
		echo "</td>";
		
		echo "<td>";
		echo $valDTRMo['emp_id'];
		echo "</td>";
		*/
		echo "<td>";
		echo $valDTRMo['month'];
		echo "</td>";
		
		echo "<td>";
		echo $valDTRMo['day'];
		echo "</td>";
		
		echo "<td>";
		echo $valDTRMo['year'];
		echo "</td>";
		
		$getHoliday = $timesheetDAO->getHoliday($valDTRMo['month'],$valDTRMo['day'],$valDTRMo['year']);
		$dateTodayLog = $valDTRMo['year'] . "-" . $valDTRMo['month'] ."-".$valDTRMo['day'];
		//echo $dateTodayLog . "<br/>";
		echo "<td>";
		$date=date_create($dateTodayLog);

			$dateFormat = date_format($date,"l");//carla
			echo $dateFormat;
			echo "</td>";
			
			
			echo "<td>";
			if($getHoliday <> NULL)
			{
				echo "<font color = 'red'>Holiday</font>";
				$is_holiday = "1";
				
			}else
			{
				echo "";
				$is_holiday = "0";
				
			}
			echo "</td>";

		

		/*if($valDTRMo['day'] >=10)
		{
			
		$dateTodayLog = $valDTRMo['year'] . "-" . $valDTRMo['month'] ."-".$valDTRMo['day'];
		
		}else{
			$dateTodayLog = $valDTRMo['year'] . "-" . $valDTRMo['month'] ."-0".$valDTRMo['day'];
		}*/
		
		//timeIN
		$getTimeLogOfDay = $timesheetDAO->getTimeLogOfDay($_SESSION['emp_id'], $valDTRMo['dtr_id']);

		echo "<td>";
		if($getTimeLogOfDay[0]["emp_timein"] <> NULL )
		{
			/*$emp_timein =  $getTimeLogOfDay[0]["emp_timein"];*/

			$emp_timeVal = date_create($getTimeLogOfDay[0]["emp_timein"]);
			$emp_timein = date_format($emp_timeVal,"H:i");
			//echo $emp_timein;


			$emp_create_date = date_create($emp_timein);
			$emp_new_format = date_format($emp_create_date,"h:i A");
			echo $emp_new_format;

		}else if ($getTimeLogOfDay[0]["emp_timein"] == NULL)
		{
			$emp_timein = "00:00:00";
		}else
		{
			echo $noLogsFound;
			$emp_timein = "00:00:00";
		}
		echo "</td>";
		
		
		//time out
		echo "<td>";
		if($getTimeLogOfDay[0]["emp_timeout"] <> NULL && $getTimeLogOfDay[0]["emp_timeout"] <> "00:00:00")
		{
				$emp_timeoutVal = date_create($getTimeLogOfDay[0]["emp_timeout"]);
				$emp_timeout = date_format($emp_timeoutVal, "H:i");

				$emp_timeoutcreate_date = date_create($emp_timeout);
				$emp_timeoutnew_format = date_format($emp_timeoutcreate_date, "h:i A");
				echo $emp_timeoutnew_format;


			
		}else if ($getTimeLogOfDay[0]["emp_timeout"] == NULL)
		{
			$emp_timeoutVal = "00:00:00";
			$emp_timeout = date_format($emp_timeoutVal,"H:i");
			echo $emp_timeout;
		}
		else
		{
			//$emp_timeoutVal = date_create($getTimeLogOfDay[0]["emp_timeout"]);

			$emp_timeoutVal = "00:00:00";
			$emp_timeout = date_format($emp_timeoutVal,"H:i");
			echo $emp_timeout;
		}
			
		echo "</td>";


		echo "<td>";
		echo $breakHours;
		echo "</td>";

		
		if($schedule_id <> 3)
		{
			
			echo "<td>";
			include "emp_totalhours_nomandatory_hours.php";
			echo "</td>";

			echo "<td>";
			include "emp_totalhours_employee.php";
			echo "</td>";


		}else

		{	
			echo "<td>";
			include "emp_totalhours_nomandatory_hours_night.php";
			echo "</td>";

			echo "<td>";
			include "emp_dtr_totalhours_night.php";
			echo "</td>";


		}
	
		
		
		//LATE COMPUTATION
		echo "<td>";
		$getDateDiff = $timesheetDAO->getDateDiff($dateToday,$dateTodayLog);

		if($getDateDiff[0]['totalDate'] >= 0 && $emp_timein <> NULL)
		{
			include "late_computation.php";

			/*if ($emp_timein >= $schedule_time_in)
			{
				$getTimeLate = $timesheetDAO->getTimeLate($emp_timein,$schedule_time_in);

				if($emp_timein <> NULL)
				{
					$totalLate = $getTimeLate[0]['totalLate'];
					echo $totalLate;
				}else
				{
					$totalLate = "00:00:00";
					echo $totalLate;
				}

			}
			else
			{
				$totalLate = "00:00:00";
				echo $totalLate;
			}*/

		}else if($emp_timein <> NULL)
		{			
			include "late_computation.php";
			//include "emp_dtr_totalLate.php";

		/*	if ($emp_timein >= $schedule_time_in)
			{
				$getTimeLate = $timesheetDAO->getTimeLate($emp_timein,$schedule_time_in);

				if($emp_timein <> NULL)
				{
					$totalLate = $getTimeLate[0]['totalLate'];
					echo $totalLate;
				}else
				{
					$totalLate = "00:00:00";
					echo $totalLate;
				}

			}
			else
			{
				$totalLate = "00:00:00";
				echo $totalLate;
			}*/
		}
		else{
			// echo "Not in choices";
		}
		echo "</td>";
		//undertime
		echo "<td>";


		if ($emp_timeout <= $schedule_time_out && $emp_timeout <> NULL)
		{
			$getTimeUndertime = $timesheetDAO->getTimeUndertime($schedule_time_out,$emp_timeout);

			if($emp_timeout <> "00:00:00")
			{
				$totalUnderTime = $getTimeUndertime[0]['totalUnderTime'];
				echo $totalUnderTime;

			}else if ($emp_timeout == NULL)
			{
				$totalUnderTime = "00:00:00";
				echo $totalUnderTime;
			}else{
				$totalUnderTime = "00:00:00";
				echo $totalUnderTime;

			}

		}
		else
		{
			$totalUnderTime = "00:00:00";
			echo $totalUnderTime;
		}


		/*if ($emp_timeout <= $schedule_time_out)
		{
			$getTimeUndertime = $timesheetDAO->getTimeUndertime($schedule_time_out,$emp_timeout);
			
			if($emp_timeout <> "00:00:00")
			{
				$totalUnderTime = $getTimeUndertime[0]['totalUnderTime'];
				echo $totalUnderTime;
				
			}else if ($emp_timeout == NULL)
			{
				
			}else{
					
					
				}
			
		}else
		{
			$totalUnderTime = "00:00:00";
			echo $totalUnderTime;
		}*/
		echo "</td>";
		
		//excessTime

		
		echo "<td>";
		
		/*if($emp_timeout > $schedule_time_out)
		{
			$getTimeExcessTime = $timesheetDAO->getTimeExcessTime($schedule_time_out, $emp_timeout);
			$excessTime = $getTimeExcessTime[0]['excessTime'];
			echo $excessTime;
		}
		else if($emp_timeout == NULL)
		{
			$excessTime = "00:00:00";
			// echo $excessTime;
		}
		else
		{
			$excessTime = "00:00:00";
			echo $excessTime;
		}*/

		if($emp_timeout > $schedule_time_out)
		{
			$getTimeExcessTime = $timesheetDAO->getTimeExcessTime($schedule_time_out, $emp_timeout);
			$excessTime = $getTimeExcessTime[0]['excessTime'];
			echo $excessTime;
		}
		else if($emp_timeout == NULL)
		{
			$excessTime = "00:00:00";
			echo $excessTime;
		}
		else
		{
			$excessTime = "00:00:00";
			echo $excessTime;
		}

		echo "</td>";
		
		echo "<td>";
		
		// echo $emp_timein;
		// echo $emp_timeout;
		$undertimeMsg = "";
		$lateMsg = "";
		$absentMsg = "";
		$otMsg = "";
		$dateNow = date("Y-m-d");
		// echo $dateNow;
		foreach ($getDateDiff as $keyDate => $valDate)
		{
			//carla
			//$dateTodayLog1 = $dateTodayLog;
			//echo $dateTodayLog1;
			$getLeaveCoverage = $timesheetDAO->getLeaveCoverage($emp_id,$dateTodayLog);
			// echo "<pre>";
			// //print_r($getLeaveCoverage);
			// echo "</pre>";
			$leavemsg1 = "";
			if($getLeaveCoverage == true)
			{


				foreach($getLeaveCoverage as $keyLC => $valLC)
				{
								
					// echo "Year=>".$valLC['dateToYear'];
					// echo "month=>".$valLC['dateToMonth'];
					// echo "day=>".$valLC['dateToDay'];
					// echo "emp_id=>".$emp_id;
					// echo "<br/>";
										
					$getDTRForLeave = $timesheetDAO->getDTR($emp_id,$valLC['dateToMonth'],$valLC['dateToDay'],$valLC['dateToYear']);
					// echo "<pre>";
					// print_r($getDTRForLeave);	
					// echo "</pre>";

					$getDtrID = $getDTRForLeave[0]["dtr_id"];
						//echo $getDtrID;

					$dtrIdInEmpTimelog = $timesheetDAO->dtrIdInEmpTimelog($getDtrID);
										$getLeaveStatus = $dtrIdInEmpTimelog[0]['emp_leave_status'];
					// echo "<pre>";
					// print_r($getDTRForLeave);	
					// echo "</pre>";

					if($getLeaveStatus == 1)
					{
						$leavemsg1 = "Pending Leave";

					}else if($getLeaveStatus == 2)
					{
						$leavemsg1 = "Approve Leave";

					}else if($getLeaveStatus == 3)
					{
						$leavemsg1 = "Disapprove Leave";

					}else
					{
						//$absentMsg = "Absent";
					}
				}

				echo $leavemsg1;
			}
			else
			{
				//echo "aaaaaaa";
				$absentMsg = "Absent";
			}

				


			if($valDate['totalDate'] >= 0)
			{	
				$getDtrDate = $valDTRMo['year'] . "-" . $valDTRMo['month'] . "-" . $valDTRMo['day'];

					// if($valDTRMo['day'] >= 10)
					// {
					// 	$getDtrDate = $valDTRMo['year'] . "-" . $valDTRMo['month'] . "-" . $valDTRMo['day'];
					// 	// echo $getDtrDate;
					// }else
					// {
					// 	$getDtrDate = $valDTRMo['year'] . "-" . $valDTRMo['month'] . $valDTRMo['day'];
					// 	// echo $getDtrDate;

					// }
				//echo $getDtrDate;
				$getLeaveCoverage = $timesheetDAO->getLeaveCoverage($_SESSION['emp_id'],$getDtrDate);
				
				
				//echo $getLeaveCoverage;
				if($totalUnderTime > "00:00:00" && $getLeaveCoverage == false)
				{
					$undertimeMsg = "Undertime, ";
					echo $undertimeMsg;
				}

				if($totalLate > "00:00:00" && $getLeaveCoverage == false)
				{
					$lateMsg = "Late, ";
					echo $lateMsg;
				}
				
				if($excessTime > "01:00:00" && $getLeaveCoverage == false)
				{
					$otMsg = "Overtime, ";
					echo $otMsg;
				}
				
				
				// if($dateNow && $emp_timein == "00:00:00" && $emp_timeout == NULL)
				// {
					// $absentMsg = "aaaaaa";
					// echo $absentMsg;
				// }
				//carla
				
			
				
				//echo $is_holiday;
				if($emp_timein == "00:00:00" && $emp_timeout == NULL && $is_holiday == "1")
				{
							$absentMsg = "Holiday";
							echo $absentMsg;
				}
				
				if($emp_timein == "00:00:00" && $emp_timeout == NULL && $dateNow <> $getDtrDate)
				{
					if($is_holiday == 1)
					{
						$absentMsg = "";
						echo $absentMsg;

					}else
					{
						if($dateFormat == "Sunday" || $dateFormat == "Saturday")
						{
							$absentMsg = "";
						}else
						{
							
							if($getLeaveCoverage == true)
							{


							foreach($getLeaveCoverage as $keyLC => $valLC)
							{
								
								// echo "Year=>".$valLC['dateToYear'];
								// echo "month=>".$valLC['dateToMonth'];
								// echo "day=>".$valLC['dateToDay'];
								// echo "emp_id=>".$emp_id;
								
								$getDTRForLeave = $timesheetDAO->getDTR($emp_id,$valLC['dateToMonth'],$valLC['dateToDay'],$valLC['dateToYear']);
								
								$getDtrID = $getDTRForLeave[0]["dtr_id"];
								//echo $getDtrID;

								$dtrIdInEmpTimelog = $timesheetDAO->dtrIdInEmpTimelog($getDtrID);
								$getLeaveStatus = $dtrIdInEmpTimelog[0]['emp_leave_status'];

								if($getLeaveStatus == 1)
								{
									//$leavemsg = "Pending Leave";

								}else if($getLeaveStatus == 2)
								{
									//$leavemsg = "Approve Leave";

								}else if($getLeaveStatus == 3)
								{
									//$leavemsg = "Disapprove Leave";

								}else
								{
									$absentMsg = "Absent";
								}
							}
							}
							else
							{
								$absentMsg = "Absent";
							}

							
						}
						echo $absentMsg;
					}
				}
				
				else
				{
					//print_r($getLeaveCoverage);
					foreach($getLeaveCoverage as $keyLC => $valLC)
					{
						
						// echo "Year=>".$valLC['dateToYear'];
						// echo "month=>".$valLC['dateToMonth'];
						// echo "day=>".$valLC['dateToDay'];
						// echo "emp_id=>".$emp_id;
						
						$getDTRForLeave = $timesheetDAO->getDTR($emp_id,$valLC['dateToMonth'],$valLC['dateToDay'],$valLC['dateToYear']);
						
						$getDtrID = $getDTRForLeave[0]["dtr_id"];
						
						$saveTimeIN = $timesheetDAO->saveTimeIN($emp_id,$schedule_time_in,$schedule_time_out,"08:00:00","00:00:00","00:00:00","00:00:00",$getDtrID);
						
						
						// echo $valLC['leave_application_id'];
						$getLeave = $timesheetDAO->getLeave($valLC['leave_application_id']);
						//print_r($getLeave);
						foreach($getLeave as $keyLeave => $valLeave)
						{
							// echo $valLeave['status_id'];
							$leaveStatus = $valLeave['status_id'];
							$leavemsg = "";
							
							
							if($leaveStatus == 2)
							{
								//$leavemsg = "Leave Approved!";
								//echo $leavemsg;

							}else if($leaveStatus == 1)
							{
								//$leavemsg = "Pending Leave";
								//echo $leavemsg;

							}else if($leaveStatus == 3)
							{
								//$leavemsg = "Leave Disapproved";
								//echo $leavemsg;
							}
							
							else if($emp_timein == "00:00:00" && $emp_timeout == NULL && $dateNow == $getDtrDate)
							{
								
								$absentMsg = "No Time Log";
								echo $absentMsg;
							}
							
							
							{
								echo "";
							}
						}
					}
				
				}//end else
				
				
			}// if()
							
		}
		echo "</td>";
		
		echo "<td>";
		// echo "UPDATE TBL_employee_timelog SET EMP_TOTALHOURS = '".$totalHours."' , EMP_LATE = '".$totalLate."', EMP_EXCESSTIME = '".$excessTime."', EMP_UNDERTIME = '".$totalUnderTime."' WHERE dtr_id = ".$valDTRMo['dtr_id'].";";
		echo "</td>";
		echo "</tr>";
	}
?>
</tbody>
</table>

<!--carla-->

<?php if ($tbl_employee->Export == "") { ?>
<script type="text/javascript">
ftbl_employeelistsrch.Init();
ftbl_employeelist.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$tbl_employee_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($tbl_employee->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php
	if(CurrentUserLevel() == 2)
	{
		// include "employee_deduction.php";
		// include "leave_balances.php";
		
	}else{
		
		echo "";
	}
?>
<?php include_once "footer.php" ?>
<?php
$tbl_employee_list->Page_Terminate();
?>
