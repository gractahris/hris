<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "userlevelsinfo.php" ?>
<?php include_once "tbl_userinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$userpriv = NULL; // Initialize page object first

class cuserpriv extends cuserlevels {

	// Page ID
	var $PageID = 'userpriv';

	// Project ID
	var $ProjectID = "{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}";

	// Page object name
	var $PageObjName = 'userpriv';

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

		// Table object (userlevels)
		if (!isset($GLOBALS["userlevels"])) {
			$GLOBALS["userlevels"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["userlevels"];
		}
		if (!isset($GLOBALS["userlevels"])) $GLOBALS["userlevels"] = &$this;

		// User table object (tbl_user)
		if (!isset($GLOBALS["tbl_user"])) $GLOBALS["tbl_user"] = new ctbl_user;

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'userpriv', TRUE);

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
		$Security->LoadCurrentUserLevel(CurrentProjectID() . 'userlevels');
		$Security->TablePermission_Loaded();
		if (!$Security->CanAdmin()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
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
	var $TempPriv;
	var $Disabled;
	var $Privileges;
	var $TableNameCount;
	var $ReportLanguage;
	var $UserLevelList = array();
	var $UserLevelPrivList = array();
	var $TableList = array();

	//
	// Page main
	//
	function Page_Main() {
		global $Security, $Language;
		global $EW_RELATED_LANGUAGE_FOLDER;
		global $Breadcrumb;
		$Breadcrumb = new cBreadcrumb;
		$Breadcrumb->Add("list", "<span>" . $Language->TablePhrase("userlevels", "TblCaption") . "</span>", "userlevelslist.php", "userlevels");
		$Breadcrumb->Add("userpriv", "<span id=\"ewPageCaption\">" . $Language->Phrase("UserLevelPermission") . "</span>", ew_CurrentUrl());

		// Try to load PHP Report Maker language file
		// Note: The langauge IDs must be the same in both projects

		$Security->LoadUserLevelFromConfigFile($this->UserLevelList, $this->UserLevelPrivList, $this->TableList, TRUE);
		if ($EW_RELATED_LANGUAGE_FOLDER <> "")
			$this->ReportLanguage = new cLanguage($EW_RELATED_LANGUAGE_FOLDER);
		$this->TableNameCount = count($this->TableList);
		$this->Privileges = &ew_InitArray($this->TableNameCount, 0);

		// Get action
		if (@$_POST["a_edit"] == "") {
			$this->CurrentAction = "I"; // Display with input box

			// Load key from QueryString
			if (@$_GET["userlevelid"] <> "") {
				$this->userlevelid->setQueryStringValue($_GET["userlevelid"]);
			} else {
				$this->Page_Terminate("userlevelslist.php"); // Return to list
			}
			if ($this->userlevelid->QueryStringValue == "-1") {
				$this->Disabled = " disabled=\"disabled\"";
			} else {
				$this->Disabled = "";
			}
		} else {
			$this->CurrentAction = $_POST["a_edit"];

			// Get fields from form
			$this->userlevelid->setFormValue($_POST["x_userlevelid"]);
			for ($i = 0; $i < $this->TableNameCount; $i++) {
				if (defined("EW_USER_LEVEL_COMPAT")) {
					$this->Privileges[$i] = intval(@$_POST["Add_" . $i]) + 
						intval(@$_POST["Delete_" . $i]) + intval(@$_POST["Edit_" . $i]) +
						intval(@$_POST["List_" . $i]);
				} else {
					$this->Privileges[$i] = intval(@$_POST["Add_" . $i]) +
						intval(@$_POST["Delete_" . $i]) + intval(@$_POST["Edit_" . $i]) +
						intval(@$_POST["List_" . $i]) + intval(@$_POST["View_" . $i]) +
						intval(@$_POST["Search_" . $i]);
				}
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Display
				if (!$Security->SetUpUserLevelEx()) // Get all User Level info
					$this->Page_Terminate("userlevelslist.php"); // Return to list
				break;
			case "U": // Update
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up update success message

					// Alternatively, comment out the following line to go back to this page
					$this->Page_Terminate("userlevelslist.php"); // Return to list
				}
		}
	}

	// Update privileges
	function EditRow() {
		global $conn;
		for ($i = 0; $i < $this->TableNameCount; $i++) {
			$Sql = "SELECT * FROM " . EW_USER_LEVEL_PRIV_TABLE . " WHERE " . 
				EW_USER_LEVEL_PRIV_TABLE_NAME_FIELD . " = '" . ew_AdjustSql($this->TableList[$i][4] . $this->TableList[$i][0]) . "' AND " .
				EW_USER_LEVEL_PRIV_USER_LEVEL_ID_FIELD . " = " . $this->userlevelid->CurrentValue;
			$rs = $conn->Execute($Sql);
			if ($rs && !$rs->EOF) {
				$Sql = "UPDATE " . EW_USER_LEVEL_PRIV_TABLE . " SET " . EW_USER_LEVEL_PRIV_PRIV_FIELD . " = " . $this->Privileges[$i] . " WHERE " .
					EW_USER_LEVEL_PRIV_TABLE_NAME_FIELD . " = '" . ew_AdjustSql($this->TableList[$i][4] . $this->TableList[$i][0]) . "' AND " .
					EW_USER_LEVEL_PRIV_USER_LEVEL_ID_FIELD . " = " . $this->userlevelid->CurrentValue;
				$conn->Execute($Sql);
			} else {
				$Sql = "INSERT INTO " . EW_USER_LEVEL_PRIV_TABLE . " (" . EW_USER_LEVEL_PRIV_TABLE_NAME_FIELD . ", " . EW_USER_LEVEL_PRIV_USER_LEVEL_ID_FIELD . ", " . EW_USER_LEVEL_PRIV_PRIV_FIELD . ") VALUES ('" . ew_AdjustSql($this->TableList[$i][4] . $this->TableList[$i][0]) . "', " . $this->userlevelid->CurrentValue . ", " . $this->Privileges[$i] . ")";
				$conn->Execute($Sql);
			}
			if ($rs)
				$rs->Close();
		}
		return TRUE;
	}

	// Get table caption
	function GetTableCaption($i) {
		global $Language, $EW_RELATED_PROJECT_ID;
		$caption = "";
		if ($i < $this->TableNameCount) {
			$report = ($this->TableList[$i][4] == $EW_RELATED_PROJECT_ID);
			$other = (!$report && $this->TableList[$i][4] <> CurrentProjectID());
			if (!$report && !$other)
				$caption = $Language->TablePhrase($this->TableList[$i][1], "TblCaption");
            if ($report && is_object($this->ReportLanguage))
				$caption = $this->ReportLanguage->TablePhrase($this->TableList[$i][1], "TblCaption");
			if ($caption == "")
				$caption = $this->TableList[$i][2];
			if ($caption == "") {
				$caption = $this->TableList[$i][0];
				$caption = preg_replace('/^\{\w{8}-\w{4}-\w{4}-\w{4}-\w{12}\}/', '', $caption); // Remove project id
			}
			if ($report)
				$caption .= "<span class=\"ewUserprivProject\"> (" . $Language->Phrase("Report") . ")</span>";
			if ($other) {
				if ($this->TableList[$i][5] <> "") {
					$pathinfo = pathinfo($this->TableList[$i][5]);
					$ext = $pathinfo['extension'];
					$project = basename($this->TableList[$i][5], "." . $ext);
				} else {
					$project = $this->TableList[$i][4];
				}

				//$project = $this->TableList[$i][4]; // *** Uncomment to use project id
				$caption .= "<span class=\"ewUserprivProject\"> (" . $project . ")</span>";
			}
		}
		return $caption;
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($userpriv)) $userpriv = new cuserpriv();

// Page init
$userpriv->Page_Init();

// Page main
$userpriv->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$userpriv->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var userpriv = new ew_Page("userpriv");
userpriv.PageID = "userpriv"; // Page ID
var EW_PAGE_ID = userpriv.PageID; // For backward compatibility

// Form object
var fuserpriv = new ew_Form("fuserpriv");

// Form_CustomValidate event
fuserpriv.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fuserpriv.ValidateRequired = true;
<?php } else { ?>
fuserpriv.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<p><?php echo $Language->Phrase("UserLevel") ?><?php echo $Security->GetUserLevelName($userlevels->userlevelid->CurrentValue) ?>(<?php echo $userlevels->userlevelid->CurrentValue ?>)</p>
<?php
$userpriv->ShowMessage();
?>
<script type="text/javascript">
var fuserpriv = new ew_Form("fuserpriv");
</script>
<form name="fuserpriv" id="fuserpriv" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<input type="hidden" name="t" value="userlevels">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<!-- hidden tag for User Level ID -->
<input type="hidden" name="x_userlevelid" id="x_userlevelid" value="<?php echo $userlevels->userlevelid->CurrentValue ?>">
<table id="tbl_userpriv" class="ewTable ewTableSeparate">
	<thead>
	<tr class="ewTableHeader">
		<td><?php echo $Language->Phrase("TableOrView") ?></td>
		<td><label class="checkbox"><?php echo $Language->Phrase("PermissionAddCopy") ?><input type="checkbox" name="Add" id="Add" onclick="ew_SelectAll(this);"<?php echo $userpriv->Disabled ?>></label></td>
		<td><label class="checkbox"><?php echo $Language->Phrase("PermissionDelete") ?><input type="checkbox" name="Delete" id="Delete" onclick="ew_SelectAll(this);"<?php echo $userpriv->Disabled ?>></label></td>
		<td><label class="checkbox"><?php echo $Language->Phrase("PermissionEdit") ?><input type="checkbox" name="Edit" id="Edit" onclick="ew_SelectAll(this);"<?php echo $userpriv->Disabled ?>></label></td>
<?php if (defined("EW_USER_LEVEL_COMPAT")) { ?>
		<td><label class="checkbox"><?php echo $Language->Phrase("PermissionListSearchView") ?><input type="checkbox" name="List" id="List" onclick="ew_SelectAll(this);"<?php echo $userpriv->Disabled ?>></label></td>
<?php } else { ?>
		<td><label class="checkbox"><?php echo $Language->Phrase("PermissionList") ?><input type="checkbox" name="List" id="List" onclick="ew_SelectAll(this);"<?php echo $userpriv->Disabled ?>></label></td>
		<td><label class="checkbox"><?php echo $Language->Phrase("PermissionView") ?><input type="checkbox" name="View" id="View" onclick="ew_SelectAll(this);"<?php echo $userpriv->Disabled ?>></label></td>
		<td><label class="checkbox"><?php echo $Language->Phrase("PermissionSearch") ?><input type="checkbox" name="Search" id="Search" onclick="ew_SelectAll(this);"<?php echo $userpriv->Disabled ?>></label></td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
for ($i = 0; $i < $userpriv->TableNameCount; $i++) {
	$userpriv->TempPriv = $Security->GetUserLevelPrivEx($userpriv->TableList[$i][4] . $userpriv->TableList[$i][0], $userlevels->userlevelid->CurrentValue);

		// Set row properties
		$userlevels->ResetAttrs();
?>
	<tr<?php echo $userlevels->RowAttributes() ?>>
		<td><?php echo $userpriv->GetTableCaption($i) ?></td>
		<td class="ewCheckbox"><label class="checkbox"><input type="checkbox" name="Add_<?php echo $i ?>" id="Add_<?php echo $i ?>" value="1"<?php if (($userpriv->TempPriv & EW_ALLOW_ADD) == EW_ALLOW_ADD) { ?> checked="checked"<?php } ?><?php echo $userpriv->Disabled ?>></label></td>
		<td class="ewCheckbox"><label class="checkbox"><input type="checkbox" name="Delete_<?php echo $i ?>" id="Delete_<?php echo $i ?>" value="2"<?php if (($userpriv->TempPriv & EW_ALLOW_DELETE) == EW_ALLOW_DELETE) { ?> checked="checked"<?php } ?><?php echo $userpriv->Disabled ?>></label></td>
		<td class="ewCheckbox"><label class="checkbox"><input type="checkbox" name="Edit_<?php echo $i ?>" id="Edit_<?php echo $i ?>" value="4"<?php if (($userpriv->TempPriv & EW_ALLOW_EDIT) == EW_ALLOW_EDIT) { ?> checked="checked"<?php } ?><?php echo $userpriv->Disabled ?>></label></td>
<?php if (defined("EW_USER_LEVEL_COMPAT")) { ?>
		<td class="ewCheckbox"><label class="checkbox"><input type="checkbox" name="List_<?php echo $i ?>" id="List_<?php echo $i ?>" value="8"<?php if (($userpriv->TempPriv & EW_ALLOW_LIST) == EW_ALLOW_LIST) { ?> checked="checked"<?php } ?><?php echo $userpriv->Disabled ?>></label></td>
<?php } else { ?>
		<td class="ewCheckbox"><label class="checkbox"><input type="checkbox" name="List_<?php echo $i ?>" id="List_<?php echo $i ?>" value="8"<?php if (($userpriv->TempPriv & EW_ALLOW_LIST) == EW_ALLOW_LIST) { ?> checked="checked"<?php } ?><?php echo $userpriv->Disabled ?>></label></td>
		<td class="ewCheckbox"><label class="checkbox"><input type="checkbox" name="View_<?php echo $i ?>" id="View_<?php echo $i ?>" value="32"<?php if (($userpriv->TempPriv & EW_ALLOW_VIEW) == EW_ALLOW_VIEW) { ?> checked="checked"<?php } ?><?php echo $userpriv->Disabled ?>></label></td>
		<td class="ewCheckbox"><label class="checkbox"><input type="checkbox" name="Search_<?php echo $i ?>" id="Search_<?php echo $i ?>" value="64"<?php if (($userpriv->TempPriv & EW_ALLOW_SEARCH) == EW_ALLOW_SEARCH) { ?> checked="checked"<?php } ?><?php echo $userpriv->Disabled ?>></label></td>
<?php } ?>
	</tr>
<?php } ?>
	</tbody>
</table>
</div>
</td></tr></table>
<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"<?php echo $userpriv->Disabled ?>><?php echo $Language->Phrase("Update") ?></button>
</form>
<script type="text/javascript">
fuserpriv.Init();
</script>
<script type="text/javascript">

// Write your startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$userpriv->Page_Terminate();
?>
