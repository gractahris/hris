<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "tbl_userinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$tbl_user_edit = NULL; // Initialize page object first

class ctbl_user_edit extends ctbl_user {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}";

	// Table name
	var $TableName = 'tbl_user';

	// Page object name
	var $PageObjName = 'tbl_user_edit';

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

		// Table object (tbl_user)
		if (!isset($GLOBALS["tbl_user"])) {
			$GLOBALS["tbl_user"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbl_user"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_user', TRUE);

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
			$this->Page_Terminate("tbl_userlist.php");
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up curent action
		$this->uid->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		if (@$_GET["uid"] <> "") {
			$this->uid->setQueryStringValue($_GET["uid"]);
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
		if ($this->uid->CurrentValue == "")
			$this->Page_Terminate("tbl_userlist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("tbl_userlist.php"); // No matching record, return to list
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
		if (!$this->uid->FldIsDetailKey)
			$this->uid->setFormValue($objForm->GetValue("x_uid"));
		if (!$this->emp_id->FldIsDetailKey) {
			$this->emp_id->setFormValue($objForm->GetValue("x_emp_id"));
		}
		if (!$this->username->FldIsDetailKey) {
			$this->username->setFormValue($objForm->GetValue("x_username"));
		}
		if (!$this->password->FldIsDetailKey) {
			$this->password->setFormValue($objForm->GetValue("x_password"));
		}
		if (!$this->_email->FldIsDetailKey) {
			$this->_email->setFormValue($objForm->GetValue("x__email"));
		}
		if (!$this->firstname->FldIsDetailKey) {
			$this->firstname->setFormValue($objForm->GetValue("x_firstname"));
		}
		if (!$this->middlename->FldIsDetailKey) {
			$this->middlename->setFormValue($objForm->GetValue("x_middlename"));
		}
		if (!$this->surname->FldIsDetailKey) {
			$this->surname->setFormValue($objForm->GetValue("x_surname"));
		}
		if (!$this->extensionname->FldIsDetailKey) {
			$this->extensionname->setFormValue($objForm->GetValue("x_extensionname"));
		}
		if (!$this->position->FldIsDetailKey) {
			$this->position->setFormValue($objForm->GetValue("x_position"));
		}
		if (!$this->designation->FldIsDetailKey) {
			$this->designation->setFormValue($objForm->GetValue("x_designation"));
		}
		if (!$this->office_code->FldIsDetailKey) {
			$this->office_code->setFormValue($objForm->GetValue("x_office_code"));
		}
		if (!$this->user_level->FldIsDetailKey) {
			$this->user_level->setFormValue($objForm->GetValue("x_user_level"));
		}
		if (!$this->contact_no->FldIsDetailKey) {
			$this->contact_no->setFormValue($objForm->GetValue("x_contact_no"));
		}
		if (!$this->activate->FldIsDetailKey) {
			$this->activate->setFormValue($objForm->GetValue("x_activate"));
		}
		if (!$this->profile->FldIsDetailKey) {
			$this->profile->setFormValue($objForm->GetValue("x_profile"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->uid->CurrentValue = $this->uid->FormValue;
		$this->emp_id->CurrentValue = $this->emp_id->FormValue;
		$this->username->CurrentValue = $this->username->FormValue;
		$this->password->CurrentValue = $this->password->FormValue;
		$this->_email->CurrentValue = $this->_email->FormValue;
		$this->firstname->CurrentValue = $this->firstname->FormValue;
		$this->middlename->CurrentValue = $this->middlename->FormValue;
		$this->surname->CurrentValue = $this->surname->FormValue;
		$this->extensionname->CurrentValue = $this->extensionname->FormValue;
		$this->position->CurrentValue = $this->position->FormValue;
		$this->designation->CurrentValue = $this->designation->FormValue;
		$this->office_code->CurrentValue = $this->office_code->FormValue;
		$this->user_level->CurrentValue = $this->user_level->FormValue;
		$this->contact_no->CurrentValue = $this->contact_no->FormValue;
		$this->activate->CurrentValue = $this->activate->FormValue;
		$this->profile->CurrentValue = $this->profile->FormValue;
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
		$this->uid->setDbValue($rs->fields('uid'));
		$this->emp_id->setDbValue($rs->fields('emp_id'));
		$this->username->setDbValue($rs->fields('username'));
		$this->password->setDbValue($rs->fields('password'));
		$this->_email->setDbValue($rs->fields('email'));
		$this->firstname->setDbValue($rs->fields('firstname'));
		$this->middlename->setDbValue($rs->fields('middlename'));
		$this->surname->setDbValue($rs->fields('surname'));
		$this->extensionname->setDbValue($rs->fields('extensionname'));
		$this->position->setDbValue($rs->fields('position'));
		$this->designation->setDbValue($rs->fields('designation'));
		$this->office_code->setDbValue($rs->fields('office_code'));
		$this->user_level->setDbValue($rs->fields('user_level'));
		$this->contact_no->setDbValue($rs->fields('contact_no'));
		$this->activate->setDbValue($rs->fields('activate'));
		$this->profile->setDbValue($rs->fields('profile'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->uid->DbValue = $row['uid'];
		$this->emp_id->DbValue = $row['emp_id'];
		$this->username->DbValue = $row['username'];
		$this->password->DbValue = $row['password'];
		$this->_email->DbValue = $row['email'];
		$this->firstname->DbValue = $row['firstname'];
		$this->middlename->DbValue = $row['middlename'];
		$this->surname->DbValue = $row['surname'];
		$this->extensionname->DbValue = $row['extensionname'];
		$this->position->DbValue = $row['position'];
		$this->designation->DbValue = $row['designation'];
		$this->office_code->DbValue = $row['office_code'];
		$this->user_level->DbValue = $row['user_level'];
		$this->contact_no->DbValue = $row['contact_no'];
		$this->activate->DbValue = $row['activate'];
		$this->profile->DbValue = $row['profile'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// uid
		// emp_id
		// username
		// password
		// email
		// firstname
		// middlename
		// surname
		// extensionname
		// position
		// designation
		// office_code
		// user_level
		// contact_no
		// activate
		// profile

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// uid
			$this->uid->ViewCustomAttributes = "";

			// emp_id
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

			// username
			$this->username->ViewValue = $this->username->CurrentValue;
			$this->username->ViewCustomAttributes = "";

			// password
			$this->password->ViewValue = "********";
			$this->password->ViewCustomAttributes = "";

			// email
			$this->_email->ViewValue = $this->_email->CurrentValue;
			$this->_email->ViewCustomAttributes = "";

			// firstname
			$this->firstname->ViewValue = $this->firstname->CurrentValue;
			$this->firstname->ViewCustomAttributes = "";

			// middlename
			$this->middlename->ViewValue = $this->middlename->CurrentValue;
			$this->middlename->ViewCustomAttributes = "";

			// surname
			$this->surname->ViewValue = $this->surname->CurrentValue;
			$this->surname->ViewCustomAttributes = "";

			// extensionname
			$this->extensionname->ViewValue = $this->extensionname->CurrentValue;
			$this->extensionname->ViewCustomAttributes = "";

			// position
			$this->position->ViewValue = $this->position->CurrentValue;
			$this->position->ViewCustomAttributes = "";

			// designation
			$this->designation->ViewValue = $this->designation->CurrentValue;
			$this->designation->ViewCustomAttributes = "";

			// office_code
			$this->office_code->ViewValue = $this->office_code->CurrentValue;
			$this->office_code->ViewCustomAttributes = "";

			// user_level
			if ($Security->CanAdmin()) { // System admin
			if (strval($this->user_level->CurrentValue) <> "") {
				$sFilterWrk = "`userlevelid`" . ew_SearchString("=", $this->user_level->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `userlevelid`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `userlevels`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->user_level, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->user_level->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->user_level->ViewValue = $this->user_level->CurrentValue;
				}
			} else {
				$this->user_level->ViewValue = NULL;
			}
			} else {
				$this->user_level->ViewValue = "********";
			}
			$this->user_level->ViewCustomAttributes = "";

			// contact_no
			$this->contact_no->ViewValue = $this->contact_no->CurrentValue;
			$this->contact_no->ViewCustomAttributes = "";

			// activate
			if (strval($this->activate->CurrentValue) <> "") {
				switch ($this->activate->CurrentValue) {
					case $this->activate->FldTagValue(1):
						$this->activate->ViewValue = $this->activate->FldTagCaption(1) <> "" ? $this->activate->FldTagCaption(1) : $this->activate->CurrentValue;
						break;
					case $this->activate->FldTagValue(2):
						$this->activate->ViewValue = $this->activate->FldTagCaption(2) <> "" ? $this->activate->FldTagCaption(2) : $this->activate->CurrentValue;
						break;
					default:
						$this->activate->ViewValue = $this->activate->CurrentValue;
				}
			} else {
				$this->activate->ViewValue = NULL;
			}
			$this->activate->ViewCustomAttributes = "";

			// profile
			$this->profile->ViewValue = $this->profile->CurrentValue;
			$this->profile->ViewCustomAttributes = "";

			// uid
			$this->uid->LinkCustomAttributes = "";
			$this->uid->HrefValue = "";
			$this->uid->TooltipValue = "";

			// emp_id
			$this->emp_id->LinkCustomAttributes = "";
			$this->emp_id->HrefValue = "";
			$this->emp_id->TooltipValue = "";

			// username
			$this->username->LinkCustomAttributes = "";
			$this->username->HrefValue = "";
			$this->username->TooltipValue = "";

			// password
			$this->password->LinkCustomAttributes = "";
			$this->password->HrefValue = "";
			$this->password->TooltipValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";
			$this->_email->TooltipValue = "";

			// firstname
			$this->firstname->LinkCustomAttributes = "";
			$this->firstname->HrefValue = "";
			$this->firstname->TooltipValue = "";

			// middlename
			$this->middlename->LinkCustomAttributes = "";
			$this->middlename->HrefValue = "";
			$this->middlename->TooltipValue = "";

			// surname
			$this->surname->LinkCustomAttributes = "";
			$this->surname->HrefValue = "";
			$this->surname->TooltipValue = "";

			// extensionname
			$this->extensionname->LinkCustomAttributes = "";
			$this->extensionname->HrefValue = "";
			$this->extensionname->TooltipValue = "";

			// position
			$this->position->LinkCustomAttributes = "";
			$this->position->HrefValue = "";
			$this->position->TooltipValue = "";

			// designation
			$this->designation->LinkCustomAttributes = "";
			$this->designation->HrefValue = "";
			$this->designation->TooltipValue = "";

			// office_code
			$this->office_code->LinkCustomAttributes = "";
			$this->office_code->HrefValue = "";
			$this->office_code->TooltipValue = "";

			// user_level
			$this->user_level->LinkCustomAttributes = "";
			$this->user_level->HrefValue = "";
			$this->user_level->TooltipValue = "";

			// contact_no
			$this->contact_no->LinkCustomAttributes = "";
			$this->contact_no->HrefValue = "";
			$this->contact_no->TooltipValue = "";

			// activate
			$this->activate->LinkCustomAttributes = "";
			$this->activate->HrefValue = "";
			$this->activate->TooltipValue = "";

			// profile
			$this->profile->LinkCustomAttributes = "";
			$this->profile->HrefValue = "";
			$this->profile->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// uid
			$this->uid->EditCustomAttributes = "";
			$this->uid->ViewCustomAttributes = "";

			// emp_id
			$this->emp_id->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `emp_id`, UPPER(`empLastName`) AS `DispFld`, UPPER(`empFirstName`) AS `Disp2Fld`, UPPER(`empMiddleName`) AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tbl_employee`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->emp_id, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->emp_id->EditValue = $arwrk;

			// username
			$this->username->EditCustomAttributes = "";
			$this->username->EditValue = ew_HtmlEncode($this->username->CurrentValue);
			$this->username->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->username->FldCaption()));

			// password
			$this->password->EditCustomAttributes = "";
			$this->password->EditValue = ew_HtmlEncode($this->password->CurrentValue);

			// email
			$this->_email->EditCustomAttributes = "";
			$this->_email->EditValue = ew_HtmlEncode($this->_email->CurrentValue);
			$this->_email->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->_email->FldCaption()));

			// firstname
			$this->firstname->EditCustomAttributes = "";
			$this->firstname->EditValue = ew_HtmlEncode($this->firstname->CurrentValue);
			$this->firstname->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->firstname->FldCaption()));

			// middlename
			$this->middlename->EditCustomAttributes = "";
			$this->middlename->EditValue = ew_HtmlEncode($this->middlename->CurrentValue);
			$this->middlename->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->middlename->FldCaption()));

			// surname
			$this->surname->EditCustomAttributes = "";
			$this->surname->EditValue = ew_HtmlEncode($this->surname->CurrentValue);
			$this->surname->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->surname->FldCaption()));

			// extensionname
			$this->extensionname->EditCustomAttributes = "";
			$this->extensionname->EditValue = ew_HtmlEncode($this->extensionname->CurrentValue);
			$this->extensionname->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->extensionname->FldCaption()));

			// position
			$this->position->EditCustomAttributes = "";
			$this->position->EditValue = ew_HtmlEncode($this->position->CurrentValue);
			$this->position->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->position->FldCaption()));

			// designation
			$this->designation->EditCustomAttributes = "";
			$this->designation->EditValue = ew_HtmlEncode($this->designation->CurrentValue);
			$this->designation->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->designation->FldCaption()));

			// office_code
			$this->office_code->EditCustomAttributes = "";
			$this->office_code->EditValue = ew_HtmlEncode($this->office_code->CurrentValue);
			$this->office_code->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->office_code->FldCaption()));

			// user_level
			$this->user_level->EditCustomAttributes = "";
			if (!$Security->CanAdmin()) { // System admin
				$this->user_level->EditValue = "********";
			} else {
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `userlevelid`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `userlevels`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->user_level, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->user_level->EditValue = $arwrk;
			}

			// contact_no
			$this->contact_no->EditCustomAttributes = "";
			$this->contact_no->EditValue = ew_HtmlEncode($this->contact_no->CurrentValue);
			$this->contact_no->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->contact_no->FldCaption()));

			// activate
			$this->activate->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->activate->FldTagValue(1), $this->activate->FldTagCaption(1) <> "" ? $this->activate->FldTagCaption(1) : $this->activate->FldTagValue(1));
			$arwrk[] = array($this->activate->FldTagValue(2), $this->activate->FldTagCaption(2) <> "" ? $this->activate->FldTagCaption(2) : $this->activate->FldTagValue(2));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->activate->EditValue = $arwrk;

			// profile
			$this->profile->EditCustomAttributes = "";
			$this->profile->EditValue = ew_HtmlEncode($this->profile->CurrentValue);
			$this->profile->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->profile->FldCaption()));

			// Edit refer script
			// uid

			$this->uid->HrefValue = "";

			// emp_id
			$this->emp_id->HrefValue = "";

			// username
			$this->username->HrefValue = "";

			// password
			$this->password->HrefValue = "";

			// email
			$this->_email->HrefValue = "";

			// firstname
			$this->firstname->HrefValue = "";

			// middlename
			$this->middlename->HrefValue = "";

			// surname
			$this->surname->HrefValue = "";

			// extensionname
			$this->extensionname->HrefValue = "";

			// position
			$this->position->HrefValue = "";

			// designation
			$this->designation->HrefValue = "";

			// office_code
			$this->office_code->HrefValue = "";

			// user_level
			$this->user_level->HrefValue = "";

			// contact_no
			$this->contact_no->HrefValue = "";

			// activate
			$this->activate->HrefValue = "";

			// profile
			$this->profile->HrefValue = "";
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
		if (!$this->username->FldIsDetailKey && !is_null($this->username->FormValue) && $this->username->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->username->FldCaption());
		}
		if (!$this->password->FldIsDetailKey && !is_null($this->password->FormValue) && $this->password->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->password->FldCaption());
		}
		if (!$this->_email->FldIsDetailKey && !is_null($this->_email->FormValue) && $this->_email->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->_email->FldCaption());
		}
		// if (!$this->firstname->FldIsDetailKey && !is_null($this->firstname->FormValue) && $this->firstname->FormValue == "") {
		// 	ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->firstname->FldCaption());
		// }
		// if (!$this->middlename->FldIsDetailKey && !is_null($this->middlename->FormValue) && $this->middlename->FormValue == "") {
		// 	ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->middlename->FldCaption());
		// }
		// if (!$this->surname->FldIsDetailKey && !is_null($this->surname->FormValue) && $this->surname->FormValue == "") {
		// 	ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->surname->FldCaption());
		// }
		if (!ew_CheckInteger($this->office_code->FormValue)) {
			ew_AddMessage($gsFormError, $this->office_code->FldErrMsg());
		}
		if (!$this->user_level->FldIsDetailKey && !is_null($this->user_level->FormValue) && $this->user_level->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->user_level->FldCaption());
		}
		if (!$this->activate->FldIsDetailKey && !is_null($this->activate->FormValue) && $this->activate->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->activate->FldCaption());
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
			if ($this->emp_id->CurrentValue <> "") { // Check field with unique index
			$sFilterChk = "(`emp_id` = " . ew_AdjustSql($this->emp_id->CurrentValue) . ")";
			$sFilterChk .= " AND NOT (" . $sFilter . ")";
			$this->CurrentFilter = $sFilterChk;
			$sSqlChk = $this->SQL();
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$rsChk = $conn->Execute($sSqlChk);
			$conn->raiseErrorFn = '';
			if ($rsChk === FALSE) {
				return FALSE;
			} elseif (!$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->emp_id->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->emp_id->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
			$rsChk->Close();
		}
			if ($this->_email->CurrentValue <> "") { // Check field with unique index
			$sFilterChk = "(`email` = '" . ew_AdjustSql($this->_email->CurrentValue) . "')";
			$sFilterChk .= " AND NOT (" . $sFilter . ")";
			$this->CurrentFilter = $sFilterChk;
			$sSqlChk = $this->SQL();
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$rsChk = $conn->Execute($sSqlChk);
			$conn->raiseErrorFn = '';
			if ($rsChk === FALSE) {
				return FALSE;
			} elseif (!$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->_email->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->_email->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
			$rsChk->Close();
		}
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

			// username
			$this->username->SetDbValueDef($rsnew, $this->username->CurrentValue, "", $this->username->ReadOnly);

			// password
			$this->password->SetDbValueDef($rsnew, $this->password->CurrentValue, "", $this->password->ReadOnly || (EW_ENCRYPTED_PASSWORD && $rs->fields('password') == $this->password->CurrentValue));

			// email
			$this->_email->SetDbValueDef($rsnew, $this->_email->CurrentValue, "", $this->_email->ReadOnly);

			// firstname
			$this->firstname->SetDbValueDef($rsnew, $this->firstname->CurrentValue, "", $this->firstname->ReadOnly);

			// middlename
			$this->middlename->SetDbValueDef($rsnew, $this->middlename->CurrentValue, "", $this->middlename->ReadOnly);

			// surname
			$this->surname->SetDbValueDef($rsnew, $this->surname->CurrentValue, "", $this->surname->ReadOnly);

			// extensionname
			$this->extensionname->SetDbValueDef($rsnew, $this->extensionname->CurrentValue, NULL, $this->extensionname->ReadOnly);

			// position
			$this->position->SetDbValueDef($rsnew, $this->position->CurrentValue, NULL, $this->position->ReadOnly);

			// designation
			$this->designation->SetDbValueDef($rsnew, $this->designation->CurrentValue, NULL, $this->designation->ReadOnly);

			// office_code
			$this->office_code->SetDbValueDef($rsnew, $this->office_code->CurrentValue, NULL, $this->office_code->ReadOnly);

			// user_level
			if ($Security->CanAdmin()) { // System admin
			$this->user_level->SetDbValueDef($rsnew, $this->user_level->CurrentValue, NULL, $this->user_level->ReadOnly);
			}

			// contact_no
			$this->contact_no->SetDbValueDef($rsnew, $this->contact_no->CurrentValue, NULL, $this->contact_no->ReadOnly);

			// activate
			$this->activate->SetDbValueDef($rsnew, $this->activate->CurrentValue, 0, $this->activate->ReadOnly);

			// profile
			$this->profile->SetDbValueDef($rsnew, $this->profile->CurrentValue, NULL, $this->profile->ReadOnly);

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
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "tbl_userlist.php", $this->TableVar);
		$PageCaption = $Language->Phrase("edit");
		$Breadcrumb->Add("edit", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", ew_CurrentUrl(), $this->TableVar);
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'tbl_user';
	  $usr = CurrentUserName();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		if (!$this->AuditTrailOnEdit) return;
		$table = 'tbl_user';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['uid'];

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
if (!isset($tbl_user_edit)) $tbl_user_edit = new ctbl_user_edit();

// Page init
$tbl_user_edit->Page_Init();

// Page main
$tbl_user_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tbl_user_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var tbl_user_edit = new ew_Page("tbl_user_edit");
tbl_user_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = tbl_user_edit.PageID; // For backward compatibility

// Form object
var ftbl_useredit = new ew_Form("ftbl_useredit");

// Validate form
ftbl_useredit.Validate = function() {
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
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_user->emp_id->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_username");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_user->username->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_password");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_user->password->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "__email");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_user->_email->FldCaption()) ?>");
			
			// elm = this.GetElements("x" + infix + "_firstname");
			// if (elm && !ew_HasValue(elm))
			// 	return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_user->firstname->FldCaption()) ?>");
			// elm = this.GetElements("x" + infix + "_middlename");
			// if (elm && !ew_HasValue(elm))
			// 	return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_user->middlename->FldCaption()) ?>");
			// elm = this.GetElements("x" + infix + "_surname");
			// if (elm && !ew_HasValue(elm))
			// 	return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_user->surname->FldCaption()) ?>");

			elm = this.GetElements("x" + infix + "_office_code");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tbl_user->office_code->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_user_level");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_user->user_level->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_activate");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_user->activate->FldCaption()) ?>");

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
ftbl_useredit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_useredit.ValidateRequired = true;
<?php } else { ?>
ftbl_useredit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftbl_useredit.Lists["x_emp_id"] = {"LinkField":"x_emp_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_empLastName","x_empFirstName","x_empMiddleName",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_useredit.Lists["x_user_level"] = {"LinkField":"x_userlevelid","Ajax":null,"AutoFill":false,"DisplayFields":["x_userlevelname","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $tbl_user_edit->ShowPageHeader(); ?>
<?php
$tbl_user_edit->ShowMessage();
?>
<form name="ftbl_useredit" id="ftbl_useredit" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="tbl_user">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_tbl_useredit" class="table table-bordered table-striped">
<?php if ($tbl_user->uid->Visible) { // uid ?>
	<tr id="r_uid">
		<td><span id="elh_tbl_user_uid"><?php echo $tbl_user->uid->FldCaption() ?></span></td>
		<td<?php echo $tbl_user->uid->CellAttributes() ?>>
<span id="el_tbl_user_uid" class="control-group">
<span<?php echo $tbl_user->uid->ViewAttributes() ?>>
<?php echo $tbl_user->uid->EditValue ?></span>
</span>
<input type="hidden" data-field="x_uid" name="x_uid" id="x_uid" value="<?php echo ew_HtmlEncode($tbl_user->uid->CurrentValue) ?>">
<?php echo $tbl_user->uid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->emp_id->Visible) { // emp_id ?>
	<tr id="r_emp_id">
		<td><span id="elh_tbl_user_emp_id"><?php echo $tbl_user->emp_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_user->emp_id->CellAttributes() ?>>
<span id="el_tbl_user_emp_id" class="control-group">
<select data-field="x_emp_id" id="x_emp_id" name="x_emp_id"<?php echo $tbl_user->emp_id->EditAttributes() ?>>
<?php
if (is_array($tbl_user->emp_id->EditValue)) {
	$arwrk = $tbl_user->emp_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_user->emp_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$tbl_user->emp_id) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
<?php if ($arwrk[$rowcntwrk][3] <> "") { ?>
<?php echo ew_ValueSeparator(2,$tbl_user->emp_id) ?><?php echo $arwrk[$rowcntwrk][3] ?>
<?php } ?>
</option>
<?php
	}
}
?>
</select>
<script type="text/javascript">
ftbl_useredit.Lists["x_emp_id"].Options = <?php echo (is_array($tbl_user->emp_id->EditValue)) ? ew_ArrayToJson($tbl_user->emp_id->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php echo $tbl_user->emp_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->username->Visible) { // username ?>
	<tr id="r_username">
		<td><span id="elh_tbl_user_username"><?php echo $tbl_user->username->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_user->username->CellAttributes() ?>>
<span id="el_tbl_user_username" class="control-group">
<input type="text" data-field="x_username" name="x_username" id="x_username" size="30" maxlength="50" placeholder="<?php echo $tbl_user->username->PlaceHolder ?>" value="<?php echo $tbl_user->username->EditValue ?>"<?php echo $tbl_user->username->EditAttributes() ?>>
</span>
<?php echo $tbl_user->username->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->password->Visible) { // password ?>
	<tr id="r_password">
		<td><span id="elh_tbl_user_password"><?php echo $tbl_user->password->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_user->password->CellAttributes() ?>>
<span id="el_tbl_user_password" class="control-group">
<input type="password" data-field="x_password" name="x_password" id="x_password" value="<?php echo $tbl_user->password->EditValue ?>" size="30" maxlength="80"<?php echo $tbl_user->password->EditAttributes() ?>>
</span>
<?php echo $tbl_user->password->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->_email->Visible) { // email ?>
	<tr id="r__email">
		<td><span id="elh_tbl_user__email"><?php echo $tbl_user->_email->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_user->_email->CellAttributes() ?>>
<span id="el_tbl_user__email" class="control-group">
<input type="text" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="50" placeholder="<?php echo $tbl_user->_email->PlaceHolder ?>" value="<?php echo $tbl_user->_email->EditValue ?>"<?php echo $tbl_user->_email->EditAttributes() ?>>
</span>
<?php echo $tbl_user->_email->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php /*
<?php if ($tbl_user->firstname->Visible) { // firstname ?>
	<tr id="r_firstname">
		<td><span id="elh_tbl_user_firstname"><?php echo $tbl_user->firstname->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_user->firstname->CellAttributes() ?>>
<span id="el_tbl_user_firstname" class="control-group">
<input type="text" data-field="x_firstname" name="x_firstname" id="x_firstname" size="30" maxlength="40" placeholder="<?php echo $tbl_user->firstname->PlaceHolder ?>" value="<?php echo $tbl_user->firstname->EditValue ?>"<?php echo $tbl_user->firstname->EditAttributes() ?>>
</span>
<?php echo $tbl_user->firstname->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->middlename->Visible) { // middlename ?>
	<tr id="r_middlename">
		<td><span id="elh_tbl_user_middlename"><?php echo $tbl_user->middlename->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_user->middlename->CellAttributes() ?>>
<span id="el_tbl_user_middlename" class="control-group">
<input type="text" data-field="x_middlename" name="x_middlename" id="x_middlename" size="30" maxlength="40" placeholder="<?php echo $tbl_user->middlename->PlaceHolder ?>" value="<?php echo $tbl_user->middlename->EditValue ?>"<?php echo $tbl_user->middlename->EditAttributes() ?>>
</span>
<?php echo $tbl_user->middlename->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->surname->Visible) { // surname ?>
	<tr id="r_surname">
		<td><span id="elh_tbl_user_surname"><?php echo $tbl_user->surname->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_user->surname->CellAttributes() ?>>
<span id="el_tbl_user_surname" class="control-group">
<input type="text" data-field="x_surname" name="x_surname" id="x_surname" size="30" maxlength="40" placeholder="<?php echo $tbl_user->surname->PlaceHolder ?>" value="<?php echo $tbl_user->surname->EditValue ?>"<?php echo $tbl_user->surname->EditAttributes() ?>>
</span>
<?php echo $tbl_user->surname->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->extensionname->Visible) { // extensionname ?>
	<tr id="r_extensionname">
		<td><span id="elh_tbl_user_extensionname"><?php echo $tbl_user->extensionname->FldCaption() ?></span></td>
		<td<?php echo $tbl_user->extensionname->CellAttributes() ?>>
<span id="el_tbl_user_extensionname" class="control-group">
<input type="text" data-field="x_extensionname" name="x_extensionname" id="x_extensionname" size="30" maxlength="3" placeholder="<?php echo $tbl_user->extensionname->PlaceHolder ?>" value="<?php echo $tbl_user->extensionname->EditValue ?>"<?php echo $tbl_user->extensionname->EditAttributes() ?>>
</span>
<?php echo $tbl_user->extensionname->CustomMsg ?></td>
	</tr>
<?php } ?>

*/ ?>
<?php /*
<?php if ($tbl_user->position->Visible) { // position ?>
	<tr id="r_position">
		<td><span id="elh_tbl_user_position"><?php echo $tbl_user->position->FldCaption() ?></span></td>
		<td<?php echo $tbl_user->position->CellAttributes() ?>>
<span id="el_tbl_user_position" class="control-group">
<input type="text" data-field="x_position" name="x_position" id="x_position" size="30" maxlength="80" placeholder="<?php echo $tbl_user->position->PlaceHolder ?>" value="<?php echo $tbl_user->position->EditValue ?>"<?php echo $tbl_user->position->EditAttributes() ?>>
</span>
<?php echo $tbl_user->position->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->designation->Visible) { // designation ?>
	<tr id="r_designation">
		<td><span id="elh_tbl_user_designation"><?php echo $tbl_user->designation->FldCaption() ?></span></td>
		<td<?php echo $tbl_user->designation->CellAttributes() ?>>
<span id="el_tbl_user_designation" class="control-group">
<input type="text" data-field="x_designation" name="x_designation" id="x_designation" size="30" maxlength="80" placeholder="<?php echo $tbl_user->designation->PlaceHolder ?>" value="<?php echo $tbl_user->designation->EditValue ?>"<?php echo $tbl_user->designation->EditAttributes() ?>>
</span>
<?php echo $tbl_user->designation->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->office_code->Visible) { // office_code ?>
	<tr id="r_office_code">
		<td><span id="elh_tbl_user_office_code"><?php echo $tbl_user->office_code->FldCaption() ?></span></td>
		<td<?php echo $tbl_user->office_code->CellAttributes() ?>>
<span id="el_tbl_user_office_code" class="control-group">
<input type="text" data-field="x_office_code" name="x_office_code" id="x_office_code" size="30" placeholder="<?php echo $tbl_user->office_code->PlaceHolder ?>" value="<?php echo $tbl_user->office_code->EditValue ?>"<?php echo $tbl_user->office_code->EditAttributes() ?>>
</span>
<?php echo $tbl_user->office_code->CustomMsg ?></td>
	</tr>
<?php } ?>
*/ ?>
<?php if ($tbl_user->user_level->Visible) { // user_level ?>
	<tr id="r_user_level">
		<td><span id="elh_tbl_user_user_level"><?php echo $tbl_user->user_level->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_user->user_level->CellAttributes() ?>>
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn()) { // Non system admin ?>
<span id="el_tbl_user_user_level" class="control-group">
<?php echo $tbl_user->user_level->EditValue ?>
</span>
<?php } else { ?>
<span id="el_tbl_user_user_level" class="control-group">
<select data-field="x_user_level" id="x_user_level" name="x_user_level"<?php echo $tbl_user->user_level->EditAttributes() ?>>
<?php
if (is_array($tbl_user->user_level->EditValue)) {
	$arwrk = $tbl_user->user_level->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_user->user_level->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
ftbl_useredit.Lists["x_user_level"].Options = <?php echo (is_array($tbl_user->user_level->EditValue)) ? ew_ArrayToJson($tbl_user->user_level->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php } ?>
<?php echo $tbl_user->user_level->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->contact_no->Visible) { // contact_no ?>
	<tr id="r_contact_no">
		<td><span id="elh_tbl_user_contact_no"><?php echo $tbl_user->contact_no->FldCaption() ?></span></td>
		<td<?php echo $tbl_user->contact_no->CellAttributes() ?>>
<span id="el_tbl_user_contact_no" class="control-group">
<input type="text" data-field="x_contact_no" name="x_contact_no" id="x_contact_no" size="30" maxlength="20" placeholder="<?php echo $tbl_user->contact_no->PlaceHolder ?>" value="<?php echo $tbl_user->contact_no->EditValue ?>"<?php echo $tbl_user->contact_no->EditAttributes() ?>>
</span>
<?php echo $tbl_user->contact_no->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->activate->Visible) { // activate ?>
	<tr id="r_activate">
		<td><span id="elh_tbl_user_activate"><?php echo $tbl_user->activate->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_user->activate->CellAttributes() ?>>
<span id="el_tbl_user_activate" class="control-group">
<select data-field="x_activate" id="x_activate" name="x_activate"<?php echo $tbl_user->activate->EditAttributes() ?>>
<?php
if (is_array($tbl_user->activate->EditValue)) {
	$arwrk = $tbl_user->activate->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_user->activate->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
</span>
<?php echo $tbl_user->activate->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->profile->Visible) { // profile ?>
	<tr id="r_profile">
		<td><span id="elh_tbl_user_profile"><?php echo $tbl_user->profile->FldCaption() ?></span></td>
		<td<?php echo $tbl_user->profile->CellAttributes() ?>>
<span id="el_tbl_user_profile" class="control-group">
<input type="text" data-field="x_profile" name="x_profile" id="x_profile" size="30" maxlength="255" placeholder="<?php echo $tbl_user->profile->PlaceHolder ?>" value="<?php echo $tbl_user->profile->EditValue ?>"<?php echo $tbl_user->profile->EditAttributes() ?>>
</span>
<?php echo $tbl_user->profile->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("EditBtn") ?></button>
</form>
<script type="text/javascript">
ftbl_useredit.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$tbl_user_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_user_edit->Page_Terminate();
?>
