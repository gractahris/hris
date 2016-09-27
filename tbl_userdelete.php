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

$tbl_user_delete = NULL; // Initialize page object first

class ctbl_user_delete extends ctbl_user {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}";

	// Table name
	var $TableName = 'tbl_user';

	// Page object name
	var $PageObjName = 'tbl_user_delete';

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
	var $AuditTrailOnDelete = TRUE;

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
			define("EW_PAGE_ID", 'delete', TRUE);

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
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("tbl_userlist.php");
		}
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
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("tbl_userlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in tbl_user class, tbl_userinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		switch ($this->CurrentAction) {
			case "D": // Delete
				$this->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // Delete rows
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($this->getReturnUrl()); // Return to caller
				}
		}
	}

// No functions
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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$conn->BeginTrans();
		if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteBegin")); // Batch delete begin

		// Clone old rows
		$rsold = ($rs) ? $rs->GetRows() : array();
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['uid'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
			if ($DeleteRows) {
				foreach ($rsold as $row)
					$this->WriteAuditTrailOnDelete($row);
			}
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteSuccess")); // Batch delete success
		} else {
			$conn->RollbackTrans(); // Rollback changes
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteRollback")); // Batch delete rollback
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "tbl_userlist.php", $this->TableVar);
		$PageCaption = $Language->Phrase("delete");
		$Breadcrumb->Add("delete", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", ew_CurrentUrl(), $this->TableVar);
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'tbl_user';
	  $usr = CurrentUserName();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (delete page)
	function WriteAuditTrailOnDelete(&$rs) {
		if (!$this->AuditTrailOnDelete) return;
		$table = 'tbl_user';

		// Get key value
		$key = "";
		if ($key <> "")
			$key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['uid'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
	  $curUser = CurrentUserName();
		foreach (array_keys($rs) as $fldname) {
			if (array_key_exists($fldname, $this->fields) && $this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) {
					if (EW_AUDIT_TRAIL_TO_DATABASE)
						$oldvalue = $rs[$fldname];
					else
						$oldvalue = "[MEMO]"; // Memo field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) {
					$oldvalue = "[XML]"; // XML field
				} else {
					$oldvalue = $rs[$fldname];
				}
				ew_WriteAuditTrail("log", $dt, $id, $curUser, "D", $table, $fldname, $key, $oldvalue, "");
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($tbl_user_delete)) $tbl_user_delete = new ctbl_user_delete();

// Page init
$tbl_user_delete->Page_Init();

// Page main
$tbl_user_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tbl_user_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var tbl_user_delete = new ew_Page("tbl_user_delete");
tbl_user_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = tbl_user_delete.PageID; // For backward compatibility

// Form object
var ftbl_userdelete = new ew_Form("ftbl_userdelete");

// Form_CustomValidate event
ftbl_userdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_userdelete.ValidateRequired = true;
<?php } else { ?>
ftbl_userdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftbl_userdelete.Lists["x_emp_id"] = {"LinkField":"x_emp_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_empLastName","x_empFirstName","x_empMiddleName",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftbl_userdelete.Lists["x_user_level"] = {"LinkField":"x_userlevelid","Ajax":null,"AutoFill":false,"DisplayFields":["x_userlevelname","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($tbl_user_delete->Recordset = $tbl_user_delete->LoadRecordset())
	$tbl_user_deleteTotalRecs = $tbl_user_delete->Recordset->RecordCount(); // Get record count
if ($tbl_user_deleteTotalRecs <= 0) { // No record found, exit
	if ($tbl_user_delete->Recordset)
		$tbl_user_delete->Recordset->Close();
	$tbl_user_delete->Page_Terminate("tbl_userlist.php"); // Return to list
}
?>
<?php $Breadcrumb->Render(); ?>
<?php $tbl_user_delete->ShowPageHeader(); ?>
<?php
$tbl_user_delete->ShowMessage();
?>
<form name="ftbl_userdelete" id="ftbl_userdelete" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="tbl_user">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($tbl_user_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_tbl_userdelete" class="ewTable ewTableSeparate">
<?php echo $tbl_user->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($tbl_user->uid->Visible) { // uid ?>
		<td><span id="elh_tbl_user_uid" class="tbl_user_uid"><?php echo $tbl_user->uid->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_user->emp_id->Visible) { // emp_id ?>
		<td><span id="elh_tbl_user_emp_id" class="tbl_user_emp_id"><?php echo $tbl_user->emp_id->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_user->_email->Visible) { // email ?>
		<td><span id="elh_tbl_user__email" class="tbl_user__email"><?php echo $tbl_user->_email->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_user->firstname->Visible) { // firstname ?>
		<td><span id="elh_tbl_user_firstname" class="tbl_user_firstname"><?php echo $tbl_user->firstname->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_user->middlename->Visible) { // middlename ?>
		<td><span id="elh_tbl_user_middlename" class="tbl_user_middlename"><?php echo $tbl_user->middlename->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_user->surname->Visible) { // surname ?>
		<td><span id="elh_tbl_user_surname" class="tbl_user_surname"><?php echo $tbl_user->surname->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_user->extensionname->Visible) { // extensionname ?>
		<td><span id="elh_tbl_user_extensionname" class="tbl_user_extensionname"><?php echo $tbl_user->extensionname->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_user->user_level->Visible) { // user_level ?>
		<td><span id="elh_tbl_user_user_level" class="tbl_user_user_level"><?php echo $tbl_user->user_level->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_user->contact_no->Visible) { // contact_no ?>
		<td><span id="elh_tbl_user_contact_no" class="tbl_user_contact_no"><?php echo $tbl_user->contact_no->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_user->activate->Visible) { // activate ?>
		<td><span id="elh_tbl_user_activate" class="tbl_user_activate"><?php echo $tbl_user->activate->FldCaption() ?></span></td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$tbl_user_delete->RecCnt = 0;
$i = 0;
while (!$tbl_user_delete->Recordset->EOF) {
	$tbl_user_delete->RecCnt++;
	$tbl_user_delete->RowCnt++;

	// Set row properties
	$tbl_user->ResetAttrs();
	$tbl_user->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$tbl_user_delete->LoadRowValues($tbl_user_delete->Recordset);

	// Render row
	$tbl_user_delete->RenderRow();
?>
	<tr<?php echo $tbl_user->RowAttributes() ?>>
<?php if ($tbl_user->uid->Visible) { // uid ?>
		<td<?php echo $tbl_user->uid->CellAttributes() ?>>
<span id="el<?php echo $tbl_user_delete->RowCnt ?>_tbl_user_uid" class="control-group tbl_user_uid">
<span<?php echo $tbl_user->uid->ViewAttributes() ?>>
<?php echo $tbl_user->uid->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_user->emp_id->Visible) { // emp_id ?>
		<td<?php echo $tbl_user->emp_id->CellAttributes() ?>>
<span id="el<?php echo $tbl_user_delete->RowCnt ?>_tbl_user_emp_id" class="control-group tbl_user_emp_id">
<span<?php echo $tbl_user->emp_id->ViewAttributes() ?>>
<?php echo $tbl_user->emp_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_user->_email->Visible) { // email ?>
		<td<?php echo $tbl_user->_email->CellAttributes() ?>>
<span id="el<?php echo $tbl_user_delete->RowCnt ?>_tbl_user__email" class="control-group tbl_user__email">
<span<?php echo $tbl_user->_email->ViewAttributes() ?>>
<?php echo $tbl_user->_email->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_user->firstname->Visible) { // firstname ?>
		<td<?php echo $tbl_user->firstname->CellAttributes() ?>>
<span id="el<?php echo $tbl_user_delete->RowCnt ?>_tbl_user_firstname" class="control-group tbl_user_firstname">
<span<?php echo $tbl_user->firstname->ViewAttributes() ?>>
<?php echo $tbl_user->firstname->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_user->middlename->Visible) { // middlename ?>
		<td<?php echo $tbl_user->middlename->CellAttributes() ?>>
<span id="el<?php echo $tbl_user_delete->RowCnt ?>_tbl_user_middlename" class="control-group tbl_user_middlename">
<span<?php echo $tbl_user->middlename->ViewAttributes() ?>>
<?php echo $tbl_user->middlename->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_user->surname->Visible) { // surname ?>
		<td<?php echo $tbl_user->surname->CellAttributes() ?>>
<span id="el<?php echo $tbl_user_delete->RowCnt ?>_tbl_user_surname" class="control-group tbl_user_surname">
<span<?php echo $tbl_user->surname->ViewAttributes() ?>>
<?php echo $tbl_user->surname->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_user->extensionname->Visible) { // extensionname ?>
		<td<?php echo $tbl_user->extensionname->CellAttributes() ?>>
<span id="el<?php echo $tbl_user_delete->RowCnt ?>_tbl_user_extensionname" class="control-group tbl_user_extensionname">
<span<?php echo $tbl_user->extensionname->ViewAttributes() ?>>
<?php echo $tbl_user->extensionname->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_user->user_level->Visible) { // user_level ?>
		<td<?php echo $tbl_user->user_level->CellAttributes() ?>>
<span id="el<?php echo $tbl_user_delete->RowCnt ?>_tbl_user_user_level" class="control-group tbl_user_user_level">
<span<?php echo $tbl_user->user_level->ViewAttributes() ?>>
<?php echo $tbl_user->user_level->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_user->contact_no->Visible) { // contact_no ?>
		<td<?php echo $tbl_user->contact_no->CellAttributes() ?>>
<span id="el<?php echo $tbl_user_delete->RowCnt ?>_tbl_user_contact_no" class="control-group tbl_user_contact_no">
<span<?php echo $tbl_user->contact_no->ViewAttributes() ?>>
<?php echo $tbl_user->contact_no->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_user->activate->Visible) { // activate ?>
		<td<?php echo $tbl_user->activate->CellAttributes() ?>>
<span id="el<?php echo $tbl_user_delete->RowCnt ?>_tbl_user_activate" class="control-group tbl_user_activate">
<span<?php echo $tbl_user->activate->ViewAttributes() ?>>
<?php echo $tbl_user->activate->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$tbl_user_delete->Recordset->MoveNext();
}
$tbl_user_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<div class="btn-group ewButtonGroup">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ftbl_userdelete.Init();
</script>
<?php
$tbl_user_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_user_delete->Page_Terminate();
?>
