<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "tbl_userinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php include_once "model/DAO.php" ?>
<?php include_once "model/userDAO.php" ?>
<?php
// ini_set('display_errors',1);
// error_reporting(E_ALL);
//
// Page class
//

$register = NULL; // Initialize page object first

class cregister extends ctbl_user {

	// Page ID
	var $PageID = 'register';

	// Project ID
	var $ProjectID = "{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}";

	// Page object name
	var $PageObjName = 'register';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
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
		return TRUE;
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
		if (!isset($GLOBALS["tbl_user"])) $GLOBALS["tbl_user"] = new ctbl_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'register', TRUE);

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

	//
	// Page main
	//
	function Page_Main() {
		global $conn, $Security, $Language, $gsFormError, $objForm;
		global $Breadcrumb;

		// Set up Breadcrumb
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("register", "<span id=\"ewPageCaption\">" . $Language->Phrase("RegisterPage") . "</span>", ew_CurrentUrl());
		$bUserExists = FALSE;
		if (@$_POST["a_register"] <> "") {

			// Get action
			$this->CurrentAction = $_POST["a_register"];
			$this->LoadFormValues(); // Get form values

			// Validate form
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->setFailureMessage($gsFormError);
			}
		} else {
			$this->CurrentAction = "I"; // Display blank record
			$this->LoadDefaultValues(); // Load default values
		}

		// Handle email activation
		if (@$_GET["action"] <> "") {
			$sAction = $_GET["action"];
			$sEmail = @$_GET["email"];
			$sCode = @$_GET["token"];
			@list($sApprovalCode, $sUsr, $sPwd) = explode(",", $sCode, 3);
			$sApprovalCode = ew_Decrypt($sApprovalCode);
			$sUsr = ew_Decrypt($sUsr);
			$sPwd = ew_Decrypt($sPwd);
			if ($sEmail == $sApprovalCode) {
				if (strtolower($sAction) == "confirm") { // Email activation
					if ($this->ActivateEmail($sEmail)) { // Activate this email
						if ($this->getSuccessMessage() == "")
							$this->setSuccessMessage($Language->Phrase("ActivateAccount")); // Set up message acount activated
						$this->Page_Terminate("login.php"); // Go to login page
					}
				}
			}
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("ActivateFailed")); // Set activate failed message
			$this->Page_Terminate("login.php"); // Go to login page
		}
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "A": // Add

				// Check for duplicate User ID
				$sFilter = str_replace("%u", ew_AdjustSql($this->username->CurrentValue), EW_USER_NAME_FILTER);

				// Set up filter (SQL WHERE clause) and get return SQL
				// SQL constructor in tbl_user class, tbl_userinfo.php

				$this->CurrentFilter = $sFilter;
				$sUserSql = $this->SQL();
				if ($rs = $conn->Execute($sUserSql)) {
					if (!$rs->EOF) {
						$bUserExists = TRUE;
						$this->RestoreFormValues(); // Restore form values
						$this->setFailureMessage($Language->Phrase("UserExists")); // Set user exist message
					}
					$rs->Close();
				}
				if (!$bUserExists) {
					$this->SendEmail = TRUE; // Send email on add success
					if ($this->AddRow()) { // Add record
						if ($this->getSuccessMessage() == "")
							//$this->setSuccessMessage($Language->Phrase("RegisterSuccessActivate")); // Activate success
							$this->setSuccessMessage($Language->Phrase("RegisterSuccess")); // Activate success
						$this->Page_Terminate("login.php"); // Return
					} else {
						$this->RestoreFormValues(); // Restore form values
					}
				}
		}

		// Render row
		$this->RowType = EW_ROWTYPE_ADD; // Render add
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Activate account based on email
	function ActivateEmail($email) {
		global $conn, $Language;
		$sFilter = str_replace("%e", ew_AdjustSql($email), EW_USER_EMAIL_FILTER);
		$sSql = $this->GetSQL($sFilter, "");
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if (!$rs)
			return FALSE;
		if (!$rs->EOF) {
			$rsnew = $rs->fields;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
			$rsact = array('activate' => 1); // Auto register
			$this->CurrentFilter = $sFilter;
			$res = $this->Update($rsact);
			if ($res) { // Call User Activated event
				$rsnew['activate'] = 1;
				$this->User_Activated($rsnew);
			}
			return $res;
		} else {
			$this->setFailureMessage($Language->Phrase("NoRecord"));
			$rs->Close();
			return FALSE;
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->username->CurrentValue = NULL;
		$this->username->OldValue = $this->username->CurrentValue;
		$this->password->CurrentValue = NULL;
		$this->password->OldValue = $this->password->CurrentValue;
		$this->_email->CurrentValue = NULL;
		$this->_email->OldValue = $this->_email->CurrentValue;
		$this->firstname->CurrentValue = NULL;
		$this->firstname->OldValue = $this->firstname->CurrentValue;
		$this->middlename->CurrentValue = NULL;
		$this->middlename->OldValue = $this->middlename->CurrentValue;
		$this->surname->CurrentValue = NULL;
		$this->surname->OldValue = $this->surname->CurrentValue;
		$this->extensionname->CurrentValue = NULL;
		$this->extensionname->OldValue = $this->extensionname->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->username->FldIsDetailKey) {
			$this->username->setFormValue($objForm->GetValue("x_username"));
		}
		if (!$this->password->FldIsDetailKey) {
			$this->password->setFormValue($objForm->GetValue("x_password"));
		}
		$this->password->ConfirmValue = $objForm->GetValue("c_password");
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
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->username->CurrentValue = $this->username->FormValue;
		$this->password->CurrentValue = $this->password->FormValue;
		$this->_email->CurrentValue = $this->_email->FormValue;
		$this->firstname->CurrentValue = $this->firstname->FormValue;
		$this->middlename->CurrentValue = $this->middlename->FormValue;
		$this->surname->CurrentValue = $this->surname->FormValue;
		$this->extensionname->CurrentValue = $this->extensionname->FormValue;
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

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

			// Edit refer script
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
		/*if (!$this->username->FldIsDetailKey && !is_null($this->username->FormValue) && $this->username->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterUserName"));
		}
		if (!$this->password->FldIsDetailKey && !is_null($this->password->FormValue) && $this->password->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterPassword"));
		}
		if (!$this->_email->FldIsDetailKey && !is_null($this->_email->FormValue) && $this->_email->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->_email->FldCaption());
		}
		if (!$this->firstname->FldIsDetailKey && !is_null($this->firstname->FormValue) && $this->firstname->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->firstname->FldCaption());
		}
		if (!$this->middlename->FldIsDetailKey && !is_null($this->middlename->FormValue) && $this->middlename->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->middlename->FldCaption());
		}
		if (!$this->surname->FldIsDetailKey && !is_null($this->surname->FormValue) && $this->surname->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->surname->FldCaption());
		}*/

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
		if ($this->emp_id->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(emp_id = " . ew_AdjustSql($this->emp_id->CurrentValue) . ")";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->emp_id->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->emp_id->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
		if ($this->_email->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(email = '" . ew_AdjustSql($this->_email->CurrentValue) . "')";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->_email->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->_email->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// username
		$this->username->SetDbValueDef($rsnew, $this->username->CurrentValue, "", FALSE);

		// password
		$this->password->SetDbValueDef($rsnew, $this->password->CurrentValue, "", FALSE);

		// email
		$this->_email->SetDbValueDef($rsnew, $this->_email->CurrentValue, "", FALSE);

		// firstname
		$this->firstname->SetDbValueDef($rsnew, $this->firstname->CurrentValue, "", FALSE);

		// middlename
		$this->middlename->SetDbValueDef($rsnew, $this->middlename->CurrentValue, "", FALSE);

		// surname
		$this->surname->SetDbValueDef($rsnew, $this->surname->CurrentValue, "", FALSE);

		// extensionname
		$this->extensionname->SetDbValueDef($rsnew, $this->extensionname->CurrentValue, NULL, FALSE);

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
			$this->uid->setDbValue($conn->Insert_ID());
			$rsnew['uid'] = $this->uid->DbValue;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
			$this->WriteAuditTrailOnAdd($rsnew);

			// Call User Registered event
			$this->User_Registered($rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'tbl_user';
	  $usr = CurrentUserName();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		if (!$this->AuditTrailOnAdd) return;
		$table = 'tbl_user';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['uid'];

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
	// $type = ''|'success'|'failure'
	function Message_Showing(&$msg, $type) {

		// Example:
		//if ($type == 'success') $msg = "your success message";

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

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}

	// User Registered event
	function User_Registered(&$rs) {

	  //echo "User_Registered";
	}

	// User Activated event
	function User_Activated(&$rs) {

	  //echo "User_Activated";
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($register)) $register = new cregister();

// Page init
$register->Page_Init();

// Page main
$register->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$register->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var register = new ew_Page("register");
register.PageID = "register"; // Page ID
var EW_PAGE_ID = register.PageID; // For backward compatibility

// Form object
var fregister = new ew_Form("fregister");

// Validate form
fregister.Validate = function() {
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
			
			/*elm = this.GetElements("x" + infix + "_username");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterUserName"));
			elm = this.GetElements("x" + infix + "_password");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterPassword"));
			if (fobj.c_password.value != fobj.x_password.value)
				return this.OnError(fobj.c_password, ewLanguage.Phrase("MismatchPassword"));
			elm = this.GetElements("x" + infix + "__email");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php //echo ew_JsEncode2($tbl_user->_email->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_firstname");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php //echo ew_JsEncode2($tbl_user->firstname->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_middlename");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php //echo ew_JsEncode2($tbl_user->middlename->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_surname");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php //echo ew_JsEncode2($tbl_user->surname->FldCaption()) ?>");*/

			// Set up row object
			ew_ElementsToRow(fobj);

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
fregister.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fregister.ValidateRequired = true;
<?php } else { ?>
fregister.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $register->ShowPageHeader(); ?>
<?php
$register->ShowMessage();
?>

<?php /*

<form name="fregister" id="fregister" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="tbl_user">
<input type="hidden" name="a_register" id="a_register" value="A">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_register" class="table table-bordered table-striped">
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
<span id="el_c_tbl_user_password" class="control-group">
<input type="password" data-field="x_password" name="x_password" id="x_password" size="30" maxlength="80"<?php echo $tbl_user->password->EditAttributes() ?>>
</span>
<?php echo $tbl_user->password->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_user->password->Visible) { // password ?>
	<tr id="r_c_password">
		<td><span id="elh_c_tbl_user_password"><?php echo $Language->Phrase("Confirm") ?>&nbsp;<?php echo $tbl_user->password->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_user->password->CellAttributes() ?>>
<span id="el_c_tbl_user_password" class="control-group">
<input type="password" data-field="c_password" name="c_password" id="c_password" size="30" maxlength="80"<?php echo $tbl_user->password->EditAttributes() ?>>
</span>
</td>
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
</table>
</td></tr></table>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("RegisterBtn") ?></button>
</form>
*/ ?>
<form method="GET">
<table width="100%" class = "table table-striped table-bordered table-hover">
	<tr>
		<td>
		First Name
		<font color = "red"><b> * </b></font>
		</td>

		<td>
		<?php
			echo "<input type = \"text\" name = \"firstName\" id = \"firstName\" />";
		?>
		</td>
	</tr>

	<tr>

		<td>
		Middle Name
		</td>

		<td>
		<?php
			echo "<input type = \"text\" name = \"middleName\" id = \"middleName\" />";
		?>
		</td>
	</tr>

	<tr>
		<td>
		Last Name
		<font color = "red"><b> * </b></font>
		</td>

		<td>
		<?php
			echo "<input type = \"text\" name = \"lastName\" id = \"lastName\" />";
		?>
		</td>

	</tr>

	<tr>
		<td>
		Extension Name (Jr, Sr, I, II)
		</td>

		<td>
		<?php
			echo "<input type = \"text\" name = \"extName\" id = \"extName\" />";
		?>
		</td>


	</tr>

	<tr>
		<td>
		UserName
		<font color = "red"><b> * </b></font>
		</td>

		<td>
		<?php
			echo "<input type = \"text\" name = \"userName\" id = \"userName\" />";
		?>
		</td>


	</tr>

	<tr>
		<td>
		Password
		<font color = "red"><b> * </b></font>
		</td>

		<td>
		<?php
			echo "<input type = \"password\" name = \"password\" id = \"password\" />";
		?>
		</td>


	</tr>

	<tr>
		<td>
		Confirm Password
		<font color = "red"><b> * </b></font>
		</td>

		<td>
		<?php
			echo "<input type = \"password\" name = \"cpassword\" id = \"cpassword\" />";
		?>
		</td>

	</tr>

	<tr>
		<td>
		Email Address
		<font color = "red"><b> * </b></font>
		</td>

		<td>
		<?php
			echo "<input type = \"text\" name = \"email\" id = \"email\" />";
		?>
		</td>


	</tr>

	<tr>
		<td>
		Contact No
		</td>

		<td>
		<?php
			echo "<input type = \"text\" name = \"contactNo\" id = \"contactNo\" />";
		?>
		</td>


	</tr>

	<tr >
		<td colspan = "2" >
		<center>
		<input type = "submit" value="Register" id="btnRegister" name = "btnRegister" />
		</center>
		</td>
	</tr>

</table>
</form>

<?php
require 'phpmailer/PHPMailerAutoload.php';
if(isset($_GET['btnRegister']))
{
	$firstName = $_GET['firstName'];
	$middleName = $_GET['middleName'];
	$lastName = $_GET['lastName'];
	$extName = $_GET['extName'];
	$userName = $_GET['userName'];
	$password = $_GET['password'];
	$cpassword = $_GET['cpassword'];
	$email = $_GET['email'];
	$contactNo = $_GET['contactNo'];
	$enc_password = md5($password);

	$email_from = "gractahris@gmail.com";
	$password_from = "gracta@12345";

	$user_level=0;
	$activate=0;
	$emp_id = 0;

	$userDAO = new userDAO();


	$subject= "GRACTA-HRIS Account Registeration";
	$message= "<br/><br/>Dear $firstName $lastName: <br/><br/> Thank you for your registration ! <br/><br/> The following are your account credentials to GRACTA-HRIS <br/><br/>
		Username : ".$userName."<br/>Encrypted password : ".$password."<br/><br/><br/> Kindly approach your HR focal to activate your account ! <br/><br/><br/>";

	$mail = new PHPMailer;

    $mail->isSMTP();

    $mail->Host = 'smtp.gmail.com';

    $mail->Port = 587;

    $mail->SMTPSecure = 'tls';

    $mail->SMTPAuth = true;

    $mail->Username = $email_from;

    $mail->Password = $password_from;

    $mail->setFrom('from@example.com', 'GRACTA-HRIS-NO-REPLY');

    // $mail->addReplyTo('replyto@example.com', 'First Last');

     $mail->addAddress($email);

    $mail->Subject = $subject;

    $mail->msgHTML($message);	

	if($password <> $cpassword)
	{
		?>

		<script LANGUAGE='JavaScript'>
           window.alert('Unable to register Password not the same!');
           //window.location.href='tbl_upload_pax_profile.php';
       </script>
     

		<?php
	}

	if($firstName == "" || $firstName == NULL)
	{
		?>

		<script LANGUAGE='JavaScript'>
           window.alert('Enter FirstName !');
           //window.location.href='tbl_upload_pax_profile.php';
       </script>
      
		<?php
	}

	if($lastName == "" || $lastName == NULL)
	{
		?>

		<script LANGUAGE='JavaScript'>
           window.alert('Enter Last Name !');
           //window.location.href='tbl_upload_pax_profile.php';
       </script>

		<?php
	}

	if($userName == "" || $userName == NULL)
	{
		?>

		<script LANGUAGE='JavaScript'>
           window.alert('Enter User Name !');
           //window.location.href='tbl_upload_pax_profile.php';
       </script>
       

		<?php
	}

	if($password == "" || $password == NULL)
	{
		?>

		<script LANGUAGE='JavaScript'>
           window.alert('Enter Password !');
           //window.location.href='tbl_upload_pax_profile.php';
       </script>
       

		<?php
	}

	if($email == "" || $email == NULL)
	{
		?>

		<script LANGUAGE='JavaScript'>
           window.alert('Enter Email Address !');
           //window.location.href='tbl_upload_pax_profile.php';
       </script>
       

		<?php
	}

	//$checkEmail = test_input($email);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	  ?>

		<script LANGUAGE='JavaScript'>
           window.alert('Invalid Email Address !');
           //window.location.href='tbl_upload_pax_profile.php';
       </script>
       

		<?php
	}

	$checkEmp = $userDAO->checkEmp($lastName, $firstName, $middleName);
	// print_r($checkEmp);
	$emp_id = $checkEmp[0]['emp_id'];

	if($checkEmp <> NULL)
	{
		$saveUser = $userDAO->saveUser($userName,$enc_password,$email,$firstName,$middleName,$lastName,$extName,$user_level,$activate,$emp_id);


		if (!$mail->send()) {
			
			?>

			<script LANGUAGE='JavaScript'>
	           window.alert('Invalid Email Address !');
	           //window.location.href='tbl_upload_pax_profile.php';
	       </script>
	       

			<?php


			$error = "Mailer Error: " . $mail->ErrorInfo;
			echo '<p id="para">'.$error.'</p>';
		}
		else {
			
			
			?>

			<script LANGUAGE='JavaScript'>
	           window.alert('Registration Succeeded! Email Notification has been sent! ');
	           //window.location.href='tbl_upload_pax_profile.php';
	       </script>
	       

			<?php
		}
	}else
	{
		?>

			<script LANGUAGE='JavaScript'>
	           window.alert('Employee Not existing!');
	           //window.location.href='tbl_upload_pax_profile.php';
	       </script>
	       

			<?php
	}
	
	// else{
	// echo '<p id="para">Please enter valid data</p>';
	// }

}

?>
<script type="text/javascript">
fregister.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$register->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$register->Page_Terminate();
?>
