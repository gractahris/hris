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
<?php include_once "model/createDTRDAO.php" ?>
<?php

//
// Page class
//

$custompage = NULL; // Initialize page object first

class ccustompage {

	// Page ID
	var $PageID = 'custompage';

	// Project ID
	var $ProjectID = "{385D4C96-0DB9-4CC6-ACC4-87310A278BE6}";

	// Page object name
	var $PageObjName = 'custompage';

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

		// User table object (tbl_user)
		if (!isset($GLOBALS["tbl_user"])) $GLOBALS["tbl_user"] = new ctbl_user;

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'custompage', TRUE);

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

		// Uncomment codes below for security
		//if (!$Security->IsLoggedIn())
		//	$this->Page_Terminate("login.php");

		if (@$_GET["export"] <> "")
			$gsExport = $_GET["export"]; // Get export parameter, used in header
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
		global $Security, $Language;

		//$this->setSuccessMessage("Welcome " . CurrentUserName());
		// Put your custom codes here

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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($custompage)) $custompage = new ccustompage();

// Page init
$custompage->Page_Init();

// Page main
$custompage->Page_Main();
?>
<?php include_once "header.php" ?>
<?php
$custompage->ShowMessage();
?>
<?php
	function unableToAddMonth()
	{
	?>
		<script>
		swal("Unable to add kindly choose month");
		</script>
	<?php
	}
	
	function unableToAddYear()
	{
	?>
		<script>
		swal("Unable to add kindly choose year");
		</script>
	<?php
	}
	
	function unableToAddEmp()
	{
	?>
		<script>
		swal("Unable to add kindly choose Employee Name");
		</script>
	<?php
	}
	
	function unableToAdd()
	{
	?>
		<script>
		swal("Unable to add kindly choose month/year/Employee Name");
		</script>
	<?php
	}
	
	
?>
<form action = "create_dtr.php" method="GET">

<table>
	<tr>
		<td>Month</td>
		<td>
<?php
//carla
$createDTRDAO = new createDTRDAO();
$monthArr = array("January","February","March","April","May","June","July","August","September","October","November","December");

echo "<select id=month name=month>";
echo "<option id = # name = # value = # >Please Select Month</option>";
foreach($monthArr as $key => $val)
{
	$counter = $key + 1;
	
	if($counter < 10)
	{
		$month = "0".$counter;
		echo $month;
		
		echo "<option id = '".$month."' name = '".$month."' value = '".$month."'>" .$val. "</option>";
	}else
	{
		$counter;
		echo "<option id = '".$counter."' name = '".$counter."' value = '".$counter."'>" .$val. "</option>";
		
	}
		
}
echo "</select>";
?>
</td>
</tr>

<tr>
<td>Year</td>
<td>
<?php
$yearArr = array("2016","2017","2018","2019","2020");
echo "<select id=year name=year>";
echo "<option id = # name = # value = # >Please Select Year</option>";
foreach($yearArr as $keyYear => $valYear)
{
	
	echo "<option id = '".$keyYear."' name = '".$keyYear."' value = '".$valYear."'>" .$valYear. "</option>";
			
}
echo "</select>";

?> 
</td>
</tr>


<tr>
<td>Employee</td>
<td>
<?php

$getAllEmp = $createDTRDAO->getAllEmp();
// $yearArr = array("2016","2017","2018","2019","2020");
echo "<select id=emp_id name=emp_id>";
echo "<option id = # name = # value = # >Please Select Employee</option>";
foreach($getAllEmp as $keyEmp => $valEmp)
{
	$fullName = $valEmp['empLastName'].", ".$valEmp['empFirstName']." ".$valEmp['empMiddleName'].", ".$valEmp['empExtensionName'];
	
	echo "<option id = '".$valEmp['emp_id']."' name = '".$valEmp['emp_id']."' value = '".$valEmp['emp_id']."'>" .$fullName. "</option>";
			
}
echo "</select>";

?> 
</td>
</tr>

<?php

	if ($_GET["year"] == "" && $_GET["month"] == "" && $_GET["emp_id"] == "")
	{
		// unableToAdd();
		
	}else if ($_GET["month"] == "#" && $_GET["year"] == "#" && $_GET["emp_id"] == "#")
	{
		unableToAdd();
		
	}
	else if ($_GET["year"] == "#")
	{
		unableToAddYear();
		
	}else if ($_GET["month"] == "#")
	{
		unableToAddMonth();
		
	}else if ($_GET["emp_id"] == "#")
	{
		unableToAddEmp();
		
	} else
	{
		if($_GET["month"] <> "02")
		{
			if($_GET["month"] % 2 == true)
			{
				for($counter = 1; $counter <= 31; $counter++)
				{		
					$saveDTR = $createDTRDAO->saveDTR($_GET['emp_id'],$_GET["month"], $counter, $_GET["year"]);
					
					if($saveDTR == true)
					{
					?>
						<script>
							swal("Successfully Created DTR");
						</script>
					<?php } else { ?>
						<script>
						swal("Duplicate Entry");
						</script>
					<?php
						} // end of duplication
				
				}//end of for
				
			}else if($_GET["month"] % 2 == false)
			{
				for($counter = 1; $counter <= 30; $counter++)
				{		
					$saveDTR = $createDTRDAO->saveDTR($_GET['emp_id'],$_GET["month"], $counter, $_GET["year"]);
					
					if($saveDTR == true)
					{
					?>
						<script>
							swal("Successfully Created DTR");
						</script>
					<?php } else { ?>
						<script>
						swal("Duplicate Entry");
						</script>
					<?php
						} // end of duplication
				
				}//end of for
				
			}else
			{
				
				
			}
			
		}else{
			
			for($counter = 1; $counter <= 28; $counter++)
				{		
					$saveDTR = $createDTRDAO->saveDTR($_GET['emp_id'],$_GET["month"], $counter, $_GET["year"]);
					
					if($saveDTR == true)
					{
					?>
						<script>
							swal("Successfully Created DTR");
						</script>
					<?php } else { ?>
						<script>
						swal("Duplicate Entry");
						</script>
					<?php
						} // end of duplication
				
				}//end of for
		}	
		
	
	}
	

?>
<tr><td>
<input type = "submit" name ="Enter" id ="Enter" value="Enter" />
</td><tr>
</table>
</form>
<!-- Put your custom html here -->
<?php include_once "footer.php" ?>
<?php
$custompage->Page_Terminate();
?>
