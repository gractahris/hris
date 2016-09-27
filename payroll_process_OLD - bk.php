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
<?php include_once "model/payrollDAO.php" ?>
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
<!-- Put your custom html here -->

<?php
$payrollDAO = new payrollDAO();
$getAllEmp = $payrollDAO->getAllEmp();
foreach($getAllEmp as $keyEmp => $valEmp)
{

$emp_id = $valEmp['emp_id'];
$salary = "26100";
$daysInCalendar = 22;
$hour = 8;
$minute = 60;
$cutoff = 2;
$tax = 6000;
$pagibig = 100;
$sss = 100;

$salaryPerDay = $salary/$daysInCalendar;
$salaryPerHour = ($salaryPerDay/$hour);
$salaryPerMinute = ($salaryPerHour/$minute);
echo "salary= ".$salary;
echo "<br/>";
echo "<br/>";

$getEmpLogs = $payrollDAO->getEmpLogs($emp_id);

// echo "<pre>";
// print_r($getEmpLogs);
// echo "</pre>";

$totalHoursComplete = 0;
$totalMinComplete = 0;


foreach($getEmpLogs as $key => $val)
{
	$totalHoursComplete += $val['hoursComplete'];
	$totalMinComplete += $val['minComplete'];

}

echo "salaryPerDay= ".$salaryPerDay;
echo "<br/>";
echo "salaryPerHour= ".$salaryPerHour;
echo "<br/>";
echo "salaryPerMinute= ".$salaryPerMinute;
echo "<br/>";

echo "totalHoursComplete= ".$totalHoursComplete;
echo "<br/>";
echo "totalMinComplete= ".$totalMinComplete;
echo "<br/>";


$salaryAsPerCompHour = $salaryPerHour * $totalHoursComplete;
echo "salaryAsPerCompHour = ".$salaryAsPerCompHour;
echo "<br/>";echo "<br/>";

$salaryAsPerCompMin = $salaryPerMinute * $totalMinComplete;
echo "salaryAsPerCompMin = ".$salaryAsPerCompMin;
echo "<br/>";
echo "<br/>";

$totalSalaryForTheMonth = $salaryAsPerCompHour + $salaryAsPerCompMin;
echo "totalSalaryForTheMonth=".$totalSalaryForTheMonth;
echo "<br/>";
echo "<br/>";

/*$salaryLessDeduction = $totalSalaryForTheMonth - $deduction;*/

/*$ifSemiMonthly = $salaryLessDeduction/$cutoff;*/
echo "Semi Monthly= ".$ifSemiMonthly;

//$getSSSCont = $payrollDAO->getSSSCont($salary,$salary);
$getSSSCont = $payrollDAO->getSSSCont($salary);
$getPhilHealth = $payrollDAO->getPhilHealthCont($salary);
$sssCont = "";
$sssEP = "";
$sssEE = "";
foreach($getSSSCont as $keySSS => $valSSS)
{

	$sssCont = $valSSS["sss_total_contribution"];
	$sssEP = $valSSS["sss_employer_share"];
	$sssEE = $valSSS["sss_employee_share"];
	echo "SSS Cont: ".$sssCont;echo "<br/>";
	//echo "SSS Employer Cont: ".$sssEP;echo "<br/>";
	echo "SSS Employee Cont: ".$sssEE;echo "<br/>";
	echo "<br/>";

}
$phCont = "";
$phEP = "";
$phEE = "";
foreach($getPhilHealth as $keyPh => $valPh)
{

	$phCont = $valPh["ph_total_contribution"];
	$phEP = $valPh["ph_employer_share"];
	$phEE = $valPh["ph_employee_share"];
	echo "Philhealth Cont: ".$phCont;echo "<br/>";
	//echo "Philhealth Employer Cont: ".$phEP;echo "<br/>";
	echo "Philhealth Employee Cont: ".$phEE;echo "<br/>";
	echo "<br/>";

}

$pagibigContMax = "5000.00";
$pagibigBaseMin = "1500.00";
$pagibgContEP = "";
$pagibgContEE = "";

if($salary < $pagibigContMax)
{
	if($salary < $pagibigBaseMin)
	{
		$pagibgContEP = $salary * "0.01";
		//echo "PAGIBIG Cont: Employer: ".$pagibgContEP;echo "<br/>";

		$pagibgContEE = $salary * "0.02";
		echo "PAGIBIG Cont: Employee: ".$pagibgContEE;echo "<br/>";

	}else
	{
		$pagibgContEP = $salary * "0.02";
		//echo "PAGIBIG Cont: Employer: ".$pagibgContEP;echo "<br/>";

		$pagibgContEE = $salary * "0.02";
		echo "PAGIBIG Cont: Employee: ".$pagibgContEE;echo "<br/>";
	}
}else
{
	$pagibgContEP = $pagibigContMax * "0.02";
	//echo "PAGIBIG Cont: Employer: ".$pagibgContEP;echo "<br/>";

	$pagibgContEE = $pagibigContMax * "0.02";
	echo "PAGIBIG Cont: Employee: ".$pagibgContEE;echo "<br/>";echo "<br/>";
}


$tax_category_id = "";
$deduction = $pagibgContEE+$sssEE+$phEE;
$salaryLessDeduction = $totalSalaryForTheMonth-$deduction;
$maxTaxCeiling = "";
$maxExactTax = "";
$maxOverPercentage = "";

	$tax_category_id = $valEmp['tax_category_id'];
	echo "tax_category_id: ".$tax_category_id;echo "<br/>";echo "<br/>";

	$getTax = $payrollDAO->getTax($tax_category_id,$salaryLessDeduction);

	foreach($getTax as $keyTax => $valTax)
	{
		$maxTaxCeiling = $valTax['maxTaxCeiling'];
		$maxExactTax = $valTax['maxExactTax'];
		$maxOverPercentage = $valTax['maxOverPercentage'];

		echo "maxTaxCeiling: ".$maxTaxCeiling;echo "<br/>";
		echo "maxExactTax: ".$maxExactTax;echo "<br/>";
		echo "maxOverPercentage: ".$maxOverPercentage;echo "<br/>";echo "<br/>";
	}


$salarysTaxCeiling = ($salaryLessDeduction - $maxTaxCeiling);
$salaryPercentage = $salarysTaxCeiling * $maxOverPercentage;
$withHoldingTax = $maxExactTax + $salaryPercentage;

$finalSalaryForTheMonth = $salaryLessDeduction - $withHoldingTax;
echo "Total Deduction= ".$deduction;
echo "<br/>";echo "<br/>";
echo "Total Taxable amount= ".$salaryLessDeduction;
echo "<br/>";echo "<br/>";
echo "Total Withholding Tax= ".$withHoldingTax;
echo "<br/>";echo "<br/>";
echo "Total Salary Less Tax= ".$finalSalaryForTheMonth;
echo "<br/>";echo "<br/>";

} //getAllEmp

?>

<?php include_once "footer.php" ?>
<?php
$custompage->Page_Terminate();
?>
