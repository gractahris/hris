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
 include "filter_payroll.php";
 
 function getError($msg)
{
	echo $msg;
}
$getMonth = $_GET['month'];
$getYear = $_GET['year'];
$getCutOff = $_GET['cutOffID'];
$cutOffIDVal = $_GET['cutOffID'];

$_SESSION['getMonth'] = $getMonth;
$_SESSION['getYear'] = $getYear;
$_SESSION['getCutOff'] = $getCutOff;
if($getMonth == "#")
{
	$msg = "<font color = 'red'><b>Select Month</b></font><br/>";
	getError($msg);
	
}

if($getYear == "#")
{
	$msg = "<font color = 'red'><b>Select Year</b></font><br/>";
	getError($msg);
	
}

if($getCutOff == "#")
{
	$msg = "<font color = 'red'><b>Select Cut Off Dates</b></font><br/>";
	getError($msg);
	
}
?>
<table class=" table table-hover table-bordered">
<thead>
	<tr>
		<td><center><b>Employee ID</b></center></td>
		<!--<td>Salary ID</td>
		<th>Cut Off</th>-->
		<td><center><b>Total<br/>Hours<br/>Complete</b></center></td>
		<!--<th>Salary Amount</th>-->
		<td><center><b>Total<br/>OT Hours<br/>Complete</b></center></td>
		<td><center><b>Total<br/>Late<br/></b></center></td>
		<!--<td><center><b>Total<br/>Day<br/>Off<br/></b></center></td>-->
		<td><center><b>Salary As<br/>Per Logs</b></center></td>
			<td><center><b>Total<br/>Night Differential<br/></b></center></td>
		<!--<th>Salary BreakDown</th>-->
		<td><center><b>SSS Contribution</b></center></td>
		<td><center><b>Philhealth Contribution</b></center></td>
		<td><center><b>PAG-IBIG<br/>Contribution</b></center></td>
		<td><center><b>Witholding<br/>TAX</b></center></td>
		<td><center><b>Other<br/>Deductions</b></center></td>
		<td><center><b>Total Salary</b></center></td>

	</tr>
	</thead>

<?php

if($_GET['empid'] == "#" || $_GET['empid'] == NULL)
{
	
if($getCutOff <> "#" && $getMonth <> "#" && $getYear <> "#")
{
	if($getCutOff <> "" && $getMonth <> "" && $getYear <> "")
	{
		//echo "<input type='submit' id=btnPayroll name='btnPayroll' value = 'GeneratePayroll'>";
		
		echo "<a href = payroll_process.php?month=".$getMonth."&year=".$getYear."&cutOffID=".$getCutOff."&btnPayroll=GeneratePayroll >Generate Payroll</a>";
		echo "<br/>";
		if($_GET['btnPayroll'] == 'GeneratePayroll')
		{

			echo "<a href = payroll_payslip_export.php?month=".$getMonth."&year=".$getYear."&cutOffID=".$getCutOff."&btnPayroll=GeneratePayroll >Download Payslip</a>";echo "<br/>";
			
			echo "<a href = payroll_gen_export.php?month=".$getMonth."&year=".$getYear."&cutOffID=".$getCutOff."&btnPayroll=GeneratePayroll >Download Payroll</a>";
		}
		
		
		// $getAllEmp = $payrollDAO->getAllEmp();
		echo "<center>";
		include "paginate_style.php";
		include "pagination_payroll.php";
		echo "</center><br/>";
		//print_r($getAllEmp);

		foreach($getAllEmp as $keyEmp => $valEmp)
		{

		$emp_id = $valEmp['emp_id'];
		$salary_id =$valEmp['salary_id'];
		$schedule_id = $valEmp['schedule_id'];
		$fullName = $valEmp['empLastName'] . ", " . $valEmp['empFirstName'] ."  " . $valEmp['empMiddleName'];
		echo "<td><center>";
		echo "EMP_ID: ".$emp_id;
		echo "<br/>";
		echo  $fullName;
		echo  "<br/>";
		echo $schedule_id;
		echo "</center></td>";

		/*echo "<td>";
		echo $salary_id;
		echo "</td>";*/
		//$month = "04";
		//$year = "2016";
			$month = $_GET["month"];
			$year = $_GET["year"];
		$day = "";
		$daysInCalendar = "";
		$cutOff1 = "15";
		$cutOff2 = "30";
		$cutoffAll = "30";
		//$cut_off_id= "1";
		$cut_off_id= $_GET["cutOffID"];
		$dayStart ="";
		$dayEnd = "";
		

		$getSalaryByID = $payrollDAO->getSalaryByID($salary_id);

		/*$totalLateUndertimeHours= "";
					$totalLateUndertimeMin= "";
					$totalhoursExcess= "";
					$totalMinExcess= "";*/


			foreach($getSalaryByID as $keySalary =>$valSalary)
			{
				$salary = $valSalary['salary_amount'];

				if($cut_off_id == NULL)
				{
					$cut_off_id = "3";
					$getCutOff = $payrollDAO->getCutOff($cut_off_id);
				}else
				{
					//$cut_off_id = "3";
					$getCutOff = $payrollDAO->getCutOff($cut_off_id);
				}

				foreach($getCutOff as $keyCutOff => $valCutOff)
				{
					// echo "<td>";
					// echo "cut_off_start: ".$valCutOff['cut_off_start'];
					// echo "<br/>";
					// echo "cut_off_end: ".$valCutOff['cut_off_end'];
					// echo "cut_off_start: ".$valCutOff['cut_off_start'];
					// echo "</td>";
					


					$dayStart = $valCutOff['cut_off_start'];
					$dayEnd = $valCutOff['cut_off_end'];

					$getDTRByID = $payrollDAO->getDTRByID($emp_id,$month,$year,$dayStart,$dayEnd);

					//totalHooursComplete
					echo "<td align = center>";
					$totalHoursComplete = "";
					$totalMinComplete = "";
					$totalhoursExcess = "";
					$totalMinExcess = "";
					$hoursLate = "0";
					$minLate = "0";
					$hoursUndertime = "0";
					$minUndertime = "0";
					foreach ($getDTRByID as $keyDTR => $valDTR)
					{

						$day = $valDTR["day"];
						$valDTRDtr_id = $valDTR["dtr_id"];
						//echo $emp_id;
						$getEmpLogs = $payrollDAO->getEmpLogs($emp_id,$valDTRDtr_id);

							$quotient = "";
							$remainder = "";

							//print_r($getEmpLogs);
							if($getEmpLogs == true)
							{
							

							foreach($getEmpLogs as $key => $val) {

								//$totalHoursWeekEnd = $val['hoursWeekEnd'];
									


								/*$totalHoursWeekEnd = $val['hoursWeekEnd'];
								echo $totalHoursWeekEnd,"<br/>";
									$totalHoursWeekEnd = $totalHoursWeekEnd + $val['hoursWeekEnd'];

									$totalMinWeekEnd = $val['minWeekEnd'];
									$totalMinWeekEnd = $totalMinWeekEnd + $val['minWeekEnd'];*/

									// if($val['hoursLate'] == NULL)
									// {

									// 	echo "aaaa";
									// }else
									// {

									// 	echo "bbbb";
									// }

									/*$hoursLate = $hoursLate + $val['hoursLate'];
									$minLate = $minLate + $val['minLate'];
									$hoursUndertime = $hoursUndertime + $val['hoursUndertime'];
									$minUndertime = $minUndertime + $val['minUndertime'];	
									*/
								if($getEmpLogs <> NULL) {

									/*$totalHoursComplete = $totalHoursComplete + $val['hoursComplete'];
									$totalMinComplete = $totalMinComplete + $val['minComplete'];*/
									//echo  $val['minLate'];

									

									if($val['emp_excesstime'] >= "01:00:00")
									{


									$totalHoursComplete = $totalHoursComplete + $val['hoursComplete'];
									//$totalHoursComplete = $totalHoursComplete + $val['hoursExcess'];

									$totalhoursExcess =  $totalhoursExcess+ $val['hoursExcess'];
									$totalMinExcess =  $totalMinExcess + $val['minExcess'];
									$totalMinComplete = $totalMinComplete + $val['minComplete'];




									}
									else
									{

									$totalHoursComplete = $totalHoursComplete + $val['hoursComplete'];
									$totalMinComplete = $totalMinComplete + $val['minComplete'];
									//echo $valDTRDtr_id."=>";
									$totalHoursWeekEnd = $totalHoursWeekEnd + $val['hoursWeekEnd'];

									//$totalMinWeekEnd = $val['minWeekEnd'];
									$totalMinWeekEnd = $totalMinWeekEnd + $val['minWeekEnd'];
									//echo $totalHoursWeekEnd."<br/>";





									}

							
									$hoursLate = $hoursLate + $val['hoursLate'];
									$minLate = $minLate + $val['minLate'];
									$hoursUndertime = $hoursUndertime + $val['hoursUndertime'];
									$minUndertime = $minUndertime + $val['minUndertime'];
									
								}




								else
								{
									$totalHoursComplete = "0";
									$totalMinComplete = "0";
									


								}


										


							}//foreach getEmplogs

							}else
							{
								// $hoursLate = "0";
								// $hoursUndertime = "0";
								// $minLate = "0";
								// $minUndertime = "0";
							}



					}


						/*$totalHoursComplete = 0;
						$totalMinComplete = 0;*/
						// echo "THC: ".$totalHoursComplete;
						// echo "<br/>";
						// echo "totalMinComplete: ".$totalMinComplete;
						//carla
						if($totalHoursComplete <> "")
						{
							if($totalMinComplete >= 60)
							{
								$quotient = (int)($totalMinComplete / 60);
								$remainder = (int)($totalMinComplete % 60);
								$totalHoursComplete = $totalHoursComplete+$quotient;
								$totalMinComplete = $remainder;

							}

							echo $totalHoursComplete.":".$totalMinComplete;
							echo "<br/>";
							//echo $totalhoursExcess.":".$totalMinExcess;
							/*echo "quotient=".$quotient;echo "<br/>";
							echo "remainder=".$remainder;echo "<br/>";*/
						}else
						{
							$totalHoursComplete = "00";
							$totalMinComplete = "00";
							echo $totalHoursComplete.":".$totalMinComplete;
						}



					echo "</td>";
					//OT
					$quoExcess = "";
					$remainderExcess = "";
					echo "<td>";

					if($totalhoursExcess <> "" || $totalMinExcess <> "")
						{
							if($totalMinExcess >= 60)
							{
								$quoExcess = (int)($totalMinExcess / 60);
								$remainderExcess = (int)($totalMinExcess % 60);
								$totalhoursExcess = $totalhoursExcess+$quoExcess;
								$totalMinExcess = $remainderExcess;

							}

							/*echo $totalHoursComplete.":".$totalMinComplete;
							echo "<br/>";*/
							echo $totalhoursExcess.":".$totalMinExcess;
							/*echo "quotient=".$quotient;echo "<br/>";
							echo "remainder=".$remainder;echo "<br/>";*/
						}else
						{
							//echo "00:00";
							$totalhoursExcess = "00";
							$totalMinExcess = "00";
							echo $totalhoursExcess.":".$totalMinExcess;
						}
						

					echo "</td>";

					//absent late
					$quoLateUndertime = "";
					$remainderLateUnderTime = "";
					
					echo "<td>";
					/*echo $hoursLate.":".$minLate;
					echo "<br/>";
					echo $hoursUndertime.":".$minUndertime;
					echo "<br/>";*/
					$totalLateUndertimeHours = $hoursLate + $hoursUndertime;
					// $totalLateUndertimeHours = $hoursLate;
					// $totalLateUndertimeHours = $hoursUndertime;
					$totalLateUndertimeMin = $minLate + $minUndertime;
					// $totalLateUndertimeMin = $minLate;
					// $totalLateUndertimeMin = $minUndertime;
					//echo $totalLateUndertimeHours.":".$totalLateUndertimeMin;

					if($totalLateUndertimeHours <> "" || $totalLateUndertimeMin <> "")
					{
						if($totalLateUndertimeMin >= 60)
						{
							$quoLateUndertime = (int)($totalLateUndertimeMin / 60);
							$remainderLateUnderTime = (int)($totalLateUndertimeMin % 60);
							$totalLateUndertimeHours = $totalLateUndertimeHours+$quoLateUndertime;
							$totalLateUndertimeMin = $remainderLateUnderTime;
						}

						echo $totalLateUndertimeHours.":".$totalLateUndertimeMin;
						//echo "<br/>empid:".$emp_id;

					}else
					{
						$totalLateUndertimeHours = "0";
						$totalLateUndertimeMin = "0";
						echo "00:00";

					}

					//echo "<br/>";

					// if($totalHoursComplete <> "00")
					if($totalHoursComplete >= "70")
					{

					
					$weekHours = 119 - $totalHoursComplete;
					$weekMin = 60 - $totalMinComplete;
					//echo $weekHours . ":".$weekMin;

					//echo "<br/>";
					$weekHours = $weekHours-$totalLateUndertimeHours;
					$weekMin = $weekMin - $totalLateUndertimeMin;

						if($weekHours < 0 || $weekMin <0)
						{
							$weekMin = 0;
							$weekHours = 0;
						}else
						{
							$weekMin = $weekMin;
							$weekHours = $weekHours;
						}
					// echo $weekHours . ":".$weekMin;

					}

					echo "</td>";

					// echo "<td>";
					// echo $totalHoursWeekEnd . ":". $totalMinWeekEnd;
					// echo "</td>";


				}


				/*echo "<td>";
				echo "<pre>";
				//print_r($getDTRByID);
				echo "</pre>";
				echo "</td>";*/

				$hour = 8;
				$minute = 60;
				//$cutoff = 2;
				$daysInCalendar = "30";
				$salaryPerDay = round($salary/$daysInCalendar,5);
				$salaryPerHour = round(($salaryPerDay/$hour),5);
				$salaryPerMinute = round(($salaryPerHour/$minute),5);

				// echo "<td>";
				// echo $salary;
				// echo "</td>";
				


				$salaryLogPerMinuteWeekend = round($weekMin * $salaryPerMinute,5);
				$salaryLogPerHourWeekend = round($weekHours * $salaryPerHour,5);
				$totalSalaryLogWeekend = round($salaryLogPerHourWeekend + $salaryLogPerMinuteWeekend,5);

				// echo "<td>";
				// echo $totalSalaryLogWeekend;
				// echo "<br/>";
				// echo "</td>";

				

				echo "<td>";
				// echo "weekHours: ".$weekHours;
				// echo "weekMin: ".$weekMin;
				//echo $salary;
				// echo "totalHoursComplete".$totalHoursComplete."<br/>";
				// echo "totalMinComplete".$totalMinComplete."<br/><br/>";



				$salaryLogPerMinute = round($totalMinComplete * $salaryPerMinute,5);
				$salaryLogPerHour = round($totalHoursComplete * $salaryPerHour,5);
				$totalSalaryLog = round($salaryLogPerHour + $salaryLogPerMinute,5);

				$salaryLogPerMinuteAbsent = round($totalLateUndertimeMin * $salaryPerMinute,5);
				$salaryLogPerHourAbsent = round($totalLateUndertimeHours * $salaryPerHour,5);
				$totalSalaryLogAbsent = round($salaryLogPerMinuteAbsent + $salaryLogPerHourAbsent,5);


				$salaryLogPerMinuteExcess = round($totalMinExcess * $salaryPerMinute,5);
				$salaryLogPerHourExcess = round($totalhoursExcess * $salaryPerHour,5);
				$totalSalaryLogExcess = round($salaryLogPerHourExcess + $salaryLogPerMinuteExcess,5);

				

				// echo $salaryPerMinute;
				// echo "<br/>";
				// echo $salaryPerHour;
				// echo "<br/>";
				// echo $totalSalaryLog;
				// echo "<br/>";
				// echo $totalSalaryLogExcess;
				// echo "<br/>";
				// echo $totalSalaryLogWeekend;
				// echo "<br/>";
				$totalSalaryLogDisplay = $totalSalaryLog + $totalSalaryLogExcess + $totalSalaryLogWeekend;
				// $totalSalaryLogDisplay = $totalSalaryLogDisplay - $totalSalaryLogAbsent;

				if($schedule_id == "3")
				{
					//echo "YES";
					
					$totalSalaryLog = $totalSalaryLog + $totalSalaryLogExcess;
					//echo $totalSalaryLog;
					//echo "<br/>";
					$totalSalaryLog = $totalSalaryLog+ $totalSalaryLogWeekend;
					//echo $totalSalaryLog;
					//echo "<br/>";

					// $totalSalaryLog = $totalSalaryLog - $totalSalaryLogAbsent;
					// //echo $totalSalaryLog;
					// //echo "<br/>";

					$nightShiftDisplay =  round($totalSalaryLog * 0.10,5);
					$totalSalaryLog = $totalSalaryLog + (round($totalSalaryLog * 0.10,5));

				}else
				{
					//$nightShiftDisplay = 0;
					$totalSalaryLog = $totalSalaryLog + $totalSalaryLogExcess;
					// echo $totalSalaryLog;
					// echo "<br/>";
					$totalSalaryLog = $totalSalaryLog+ $totalSalaryLogWeekend;
					// echo $totalSalaryLog;
					// echo "<br/>";
					// $totalSalaryLog = $totalSalaryLog - $totalSalaryLogAbsent;
					// //echo $totalSalaryLog;
					// //echo "<br/>";
				}



				/*if($totalSalaryLog >= $totalSalaryLogWeekend)
				{
					$totalSalaryLog = $totalSalaryLog - $totalSalaryLogWeekend;
				}else
				{
					$totalSalaryLog = 0;
				}*/
				
				//$totalSalaryLog = $totalSalaryLog + $totalSalaryLogExcess;
				if($totalHoursComplete == "00" || $totalHoursComplete == "")
				{
					// echo "0";
					$totalSalaryLogDisplay = "0";
					$totalSalaryLog = "0";
					echo $totalSalaryLogDisplay;
					// echo "<br/>";
					// echo $totalSalaryLog;
				}else
				{
					echo $totalSalaryLogDisplay;
					// echo "<br/>";
					// echo $totalSalaryLog;
				}
				
				//echo $totalSalaryLogExcess;

				echo "</td>";

				echo "<td>";
				//echo $schedule_id;
				if($schedule_id == "3")
				{
					// echo "YES";
					echo $nightShiftDisplay;
				}else
				{
					//echo "NO";
					$nightShiftDisplay = 0;
					echo $nightShiftDisplay;

				}
				echo "</td>";

				// echo "<td>";
				// echo "salaryPerDay= ".$salaryPerDay;
				// echo "<br/>";
				// echo "salaryPerHour= ".$salaryPerHour;
				// echo "<br/>";
				// echo "salaryPerMinute= ".$salaryPerMinute;
				// echo "<br/>";
				// echo "</td>";

				$salaryAsPerCompHour = $salaryPerHour * $totalHoursComplete;
				$salaryAsPerCompMin = $salaryPerMinute * $totalMinComplete;
				//$totalSalaryForTheMonth = $salaryAsPerCompHour + $salaryAsPerCompMin;
				$totalSalaryForTheMonth = $totalSalaryLog;

				//sss
				$totalSalaryForTheMonthSSS = $totalSalaryForTheMonth * 2;
				// $getSSSCont = $payrollDAO->getSSSCont($salary);
				if($cutOffIDVal <> "3")
				{
					$getSSSCont = $payrollDAO->getSSSCont($totalSalaryForTheMonthSSS);
				}else
				{
					$getSSSCont = $payrollDAO->getSSSCont($totalSalaryForTheMonth);
				}

				$sssCont = "";
				$sssEP = "";
				$sssEE = "";
				echo "<td>";

				foreach($getSSSCont as $keySSS => $valSSS)
				{

					$sssCont = $valSSS["sss_total_contribution"];
					if($cutOffIDVal <> "3")
					{
						$sssEP = $valSSS["sss_employer_share"];
						$sssEP = $sssEP / 2;
						$sssEP = round($sssEP,5);

						$sssEE = $valSSS["sss_employee_share"];
						$sssEE = $sssEE / 2;
						$sssEE = round($sssEE,5);

					}else
					{
						$sssEP = $valSSS["sss_employer_share"];
						$sssEE = $valSSS["sss_employee_share"];
						$sssEP = round($sssEP,5);
						$sssEE = round($sssEE,5);
					}
					//echo "SSS Cont: ".$sssCont;echo "<br/>";
					// echo "SSS EP: ".$sssEP;echo "<br/>";
					echo "SSS EE: ".$sssEE;echo "<br/>";
					echo "<br/>";

				}
				echo "</td>";
				// $getPhilHealth = $payrollDAO->getPhilHealthCont($salary);
				$totalSalaryForTheMonthPh = $totalSalaryForTheMonth * 2;
				//$totalSalaryForTheMonthPh = $totalSalaryForTheMonthPh / 2;
				if($cutOffIDVal <> "3")
				{
					$getPhilHealth = $payrollDAO->getPhilHealthCont($totalSalaryForTheMonthPh);

				}else
				{
					$getPhilHealth = $payrollDAO->getPhilHealthCont($totalSalaryForTheMonth);
				}
				//$getPhilHealth = $payrollDAO->getPhilHealthCont($totalSalaryForTheMonth);
				$phCont = "";
				$phEP = "";
				$phEE = "";
				echo "<td>";
				foreach($getPhilHealth as $keyPh => $valPh)
				{

					$phCont = $valPh["ph_total_contribution"];
					if($cutOffIDVal <> "3")
					{
						$phEP = $valPh["ph_employer_share"];
						$phEP = $phEP / 2;
						$phEP = round($phEP,5);

						$phEE = $valPh["ph_employee_share"];
						$phEE = $phEE / 2;
						$phEE = round($phEE,5);

					}else
					{

						$phEP = $valPh["ph_employer_share"];
						$phEE = $valPh["ph_employee_share"];
						$phEP = round($phEP,5);
						$phEE = round($phEE,5);
					}
					
					//echo "Philhealth Cont: ".$phCont;echo "<br/>";
					// echo "Philhealth EP: ".$phEP;echo "<br/>";
					echo "Philhealth EE: ".$phEE;echo "<br/>";
					echo "<br/>";

				}
				echo "</td>";

				$pagibigContMax = "5000.00";
				$pagibigBaseMin = "1500.00";
				$pagibgContEP = "";
				$pagibgContEE = "";
				$pagIbigEE = "PAGIBIG EE: ";
				$pagIbigEP = "PAGIBIG EP: ";
				echo "<td>";
				// if($salary < $pagibigContMax)
				if($totalSalaryForTheMonth < $pagibigContMax)
				{
					// if($salary < $pagibigBaseMin)
					if($totalSalaryForTheMonth < $pagibigBaseMin)
					{
						if($cutOffIDVal <> "3")
						{
							// $pagibgContEP = $salary * "0.01";
							$pagibgContEP = $totalSalaryForTheMonth * "0.01";
							$pagibgContEP = $pagibgContEP / 2;
							$pagibgContEP = round($pagibgContEP,5);
							// echo $pagIbigEP.$pagibgContEP;echo "<br/>";

							// $pagibgContEE = $salary * "0.02";
							$pagibgContEE = $totalSalaryForTheMonth * "0.02";
							$pagibgContEE = $pagibgContEE / 2;
							$pagibgContEE = round($pagibgContEE,5);
							echo $pagIbigEE.$pagibgContEE;echo "<br/>";

						}else
						{
							// $pagibgContEP = $salary * "0.01";
							$pagibgContEP = $totalSalaryForTheMonth * "0.01";
							$pagibgContEP = round($pagibgContEP,5);
							// echo $pagIbigEP.$pagibgContEP;echo "<br/>";

							// $pagibgContEE = $salary * "0.02";
							$pagibgContEE = $totalSalaryForTheMonth * "0.02";
							$pagibgContEE = round($pagibgContEE,5);
							echo $pagIbigEE.$pagibgContEE;echo "<br/>";
						}

					}else
					{
						if($cutOffIDVal <> "3")
						{
							// $pagibgContEP = $salary * "0.02";
							$pagibgContEP = $totalSalaryForTheMonth * "0.02";
							$pagibgContEP = $pagibgContEP / 2;
							$pagibgContEP = round($pagibgContEP,5);
							// echo $pagIbigEP.$pagibgContEP;echo "<br/>";

							// $pagibgContEE = $salary * "0.02";
							$pagibgContEE = $totalSalaryForTheMonth * "0.02";
							$pagibgContEE = $pagibgContEE / 2;
							$pagibgContEE = round($pagibgContEE,5);
							echo $pagIbigEE.$pagibgContEE;echo "<br/>";
						}
						else
						{
							// $pagibgContEP = $salary * "0.02";
							$pagibgContEP = $totalSalaryForTheMonth * "0.02";
							$pagibgContEP = round($pagibgContEP,5);
							// echo $pagIbigEP.$pagibgContEP;echo "<br/>";

							// $pagibgContEE = $salary * "0.02";
							$pagibgContEE = $totalSalaryForTheMonth * "0.02";
							$pagibgContEE = round($pagibgContEE,5);
							echo $pagIbigEE.$pagibgContEE;echo "<br/>";
						}
					}
				}else
				{
					//echo "cutOffIDVal => ".$cutOffIDVal;
					//carla
					if($cutOffIDVal <> "3")
					{

						$pagibgContEP = $pagibigContMax * "0.02";
						$pagibgContEP = $pagibgContEP / 2;
						$pagibgContEP = round($pagibgContEP,5);
						// echo $pagIbigEP.$pagibgContEP;echo "<br/>";

						$pagibgContEE = $pagibigContMax * "0.02";
						$pagibgContEE = $pagibgContEE / 2;
						$pagibgContEE = round($pagibgContEE,5);
						echo $pagIbigEE.$pagibgContEE;echo "<br/>";echo "<br/>";

					}
					else
					{
						$pagibgContEP = $pagibigContMax * "0.02";
						$pagibgContEP = round($pagibgContEP,5);
						// echo $pagIbigEP.$pagibgContEP;echo "<br/>";

						$pagibgContEE = $pagibigContMax * "0.02";
						$pagibgContEE = round($pagibgContEE,5);
						echo $pagIbigEE.$pagibgContEE;echo "<br/>";echo "<br/>";
						}
				}

				echo "</td>";

				//TAX
				$tax_category_id = "";
				$deduction = $pagibgContEE+$sssEE+$phEE;
				$salaryLessDeduction = $totalSalaryForTheMonth-$deduction;
				$maxTaxCeiling = "";
				$maxExactTax = "";
				$maxOverPercentage = "";

				echo "<td>";
				$tax_category_id = $valEmp['tax_category_id'];
				//echo "tax_category_id: ".$tax_category_id;echo "<br/>";echo "<br/>";
				$salaryLessDeduction = round($salaryLessDeduction, 5);
				if($salaryLessDeduction <= 0){

					$salaryLessDeduction = 0;
					/*echo "Total Taxable amount= ".$salaryLessDeduction;
					echo "<br/>";echo "<br/>";*/
				}else
				{
					/*echo "Total Taxable amount= ".$salaryLessDeduction;
					echo "<br/>";echo "<br/>";*/
				}

				$getCutOff = $_GET['cutOffID'];
				if($getCutOff <> 3)
				{
					$identifyTax = "1";
					$getTax = $payrollDAO->getTax($tax_category_id,$salaryLessDeduction,$identifyTax);
				}else
				{
					$identifyTax = "2";
					$getTax = $payrollDAO->getTax($tax_category_id,$salaryLessDeduction,$identifyTax);
				}


				if($getTax == TRUE )
				{
					if($salaryLessDeduction <= 0)
					{

						$withHoldingTax = "0.00";
						//echo "Witholding Tax: ".$withHoldingTax;echo "<br/>";
						echo "P ".$withHoldingTax;echo "<br/>";

						$maxTaxCeiling = "0";
						$maxExactTax = "0";
						$maxOverPercentage = "0";

						/*echo "maxTaxCeiling: " . $maxTaxCeiling;
						echo "<br/>";
						echo "maxExactTax: " . $maxExactTax;
						echo "<br/>";
						echo "maxOverPercentage: " . $maxOverPercentage;
						echo "<br/>";
						echo "<br/>";*/


					}else
					{
						foreach($getTax as $keyTax => $valTax)
						{
							if ($valTax['maxTaxCeiling'] == NULL )
							{
								$maxTaxCeiling = "0";
								$maxExactTax = "0";
								$maxOverPercentage = "0";

								/*echo "maxTaxCeiling: " . $maxTaxCeiling;
								echo "<br/>";
								echo "maxExactTax: " . $maxExactTax;
								echo "<br/>";
								echo "maxOverPercentage: " . $maxOverPercentage;
								echo "<br/>";
								echo "<br/>";*/

							}else {
								$maxTaxCeiling = $valTax['maxTaxCeiling'];
								$maxExactTax = $valTax['maxExactTax'];
								$maxOverPercentage = $valTax['maxOverPercentage'];
								/*echo "maxTaxCeiling: " . $maxTaxCeiling;
								echo "<br/>";
								echo "maxExactTax: " . $maxExactTax;
								echo "<br/>";
								echo "maxOverPercentage: " . $maxOverPercentage;
								echo "<br/>";
								echo "<br/>";*/
							}
						}

						$salarysTaxCeiling = $salaryLessDeduction - $maxTaxCeiling;
						$salarysTaxCeiling = round($salarysTaxCeiling,5);
						$salaryPercentage = $salarysTaxCeiling * $maxOverPercentage;
						$salaryPercentage = round($salaryPercentage,5);
						$withHoldingTax = $maxExactTax + $salaryPercentage;
						$withHoldingTax = round($withHoldingTax,5);
						//echo "Witholding Tax: ".$withHoldingTax;
						echo "P ".$withHoldingTax;


					}

				}

				echo "</td>";

				echo "<td>";
				// echo "Other Deductions";
				// echo "<br/>";
				// echo $month;
				// echo "<br/>";
				// echo $year;
				// echo "<br/>";
				// echo $cutOffID;
				// echo "<br/>";
				// echo $emp_id;
				// echo "<br/>";
				// echo "<br/>";
				// echo "<br/>";
				$totalOD ="";
				if($cutOffIDVal <> "3")
				{
					$getSumAmount = $payrollDAO->getSumAmount($emp_id,$month,$year,$cutOffIDVal);
				}else
				{
					$getSumAmount = $payrollDAO->getSumAmountNoCutOff($emp_id,$month,$year);	
				}
				foreach($getSumAmount as $keySA => $valSA)
				{
					$totalOD = $valSA['totalOD'];
					if($totalOD <> "" || $totalOD <> NULL)
					{
						echo "P ".$totalOD;
					}else
					{
						echo "P 0.00";
					}
				}
				echo "</td>";

				echo "<td>";
				$finalSalaryForTheMonth = $salaryLessDeduction - $withHoldingTax;
				// echo "P ".$finalSalaryForTheMonth;
				// echo "<br/>";
				$finalSalaryForTheMonth = $finalSalaryForTheMonth - $totalOD;
				$finalSalaryForTheMonth = round($finalSalaryForTheMonth,2);
				
				echo "P ".$finalSalaryForTheMonth;
				echo "</td>";



			} // getSalaryByID
				
				/*$sql= "INSERT INTO tbl_payroll(
				emp_id,
				payroll_month,
				payroll_year,
				cut_off_start,
				cut_off_end,
				total_hours_comp,
				total_min_comp,
				salary_as_per_logs,
				sss_cont_ep,
				ph_cont_ep,
				pagibig_cont_ep,
				sss_cont_ee,
				ph_cont_ee,
				pagibig_cont_ee,
				tax_cont,
				total_salary)
		VALUES('".$emp_id."','".
		$getMonth."','".
		$getYear."','".
		$dayStart."','".
		$dayEnd."','".
		$totalHoursComplete."','".
		$totalMinComplete."','".
		$totalSalaryLog."','".
		$sssEP."','".
		$phEP."','".
		$pagibgContEP."','".
		$sssEE."','".
		$phEE."','".
		$pagibgContEE."','".
		$withHoldingTax."','".
		$finalSalaryForTheMonth."');";*/
		
		// echo "<td>";
		//echo $sql;
		// $savePayroll = $payrollDAO->savePayroll($emp_id,
							// $getMonth,
							// $getYear,
							// $dayStart,
							// $dayEnd,
							// $totalHoursComplete,
							// $totalMinComplete,
							// $totalSalaryLog,
							// $sssEP,
							// $phEP,
							// $pagibgContEP,
							// $sssEE,
							// $phEE,
							// $pagibgContEE,
							// $withHoldingTax,
							// $finalSalaryForTheMonth);
		//echo $sql;
		// echo "</td>";
		
		if($_GET['btnPayroll'] == 'GeneratePayroll')
		{	
			$getPayroll = $payrollDAO->getPayroll($getMonth,$getYear,$dayStart,$dayEnd);


			foreach($getPayroll as $keyPayroll => $valPayroll)
			{
				/*echo $valPayroll['total_hoursAbsent'];
				echo $totalLateUndertimeHours;*/

				if($valPayroll['total_hoursAbsent'] <> $totalLateUndertimeHours && $valPayroll['total_minAbsent'] <> $totalLateUndertimeMin)
				{

					$updatePayroll = $payrollDAO->updatePayroll($totalHoursComplete,$totalMinComplete,$totalSalaryLog,$sssEP,$phEP,$pagibgContEP,$sssEE,
							$phEE,
							$pagibgContEE,$finalSalaryForTheMonth,$withHoldingTax,$salary,
							$totalSalaryLogExcess,
							$totalSalaryLogAbsent,
							$totalLateUndertimeHours,
							$totalLateUndertimeMin,
							$totalhoursExcess,
							$totalMinExcess,$totalSalaryLogWeekend,$nightShiftDisplay,
							$getMonth,
							$getYear,
							$dayStart,
							$dayEnd,$emp_id);
				//	print_r($updatePayroll);

				}


				else if($valPayroll['total_hours_comp'] == $totalHoursComplete)
				{
					/*$savePayroll = $payrollDAO->savePayroll($emp_id,
							$getMonth,
							$getYear,
							$dayStart,
							$dayEnd,
							$totalHoursComplete,
							$totalMinComplete,
							$totalSalaryLog,
							$sssEP,
							$phEP,
							$pagibgContEP,
							$sssEE,
							$phEE,
							$pagibgContEE,
							$withHoldingTax,
							$finalSalaryForTheMonth,
							$salary);*/
							//echo "exces".$totalhoursExcess;

							$savePayroll = $payrollDAO->savePayroll($emp_id,
							$getMonth,
							$getYear,
							$dayStart,
							$dayEnd,
							$totalHoursComplete,
							$totalMinComplete,
							$totalSalaryLog,
							$sssEP,
							$phEP,
							$pagibgContEP,
							$sssEE,
							$phEE,
							$pagibgContEE,
							$withHoldingTax,
							$finalSalaryForTheMonth,
							$salary,
							$totalSalaryLogExcess,
							$totalSalaryLogAbsent,
							$totalLateUndertimeHours,
							$totalLateUndertimeMin,
							$totalhoursExcess,
							$totalMinExcess,
							$totalSalaryLogWeekend,
							$nightShiftDisplay
							);		
					//cmalvarez
					
				}
				else
				{
					//echo "NOTTTTT";
					$updatePayroll = $payrollDAO->updatePayroll($totalHoursComplete,$totalMinComplete,$totalSalaryLog,$sssEP,$phEP,$pagibgContEP,$sssEE,
							$phEE,
							$pagibgContEE,$finalSalaryForTheMonth,$withHoldingTax,$salary,
							$totalSalaryLogExcess,
							$totalSalaryLogAbsent,
							$totalLateUndertimeHours,
							$totalLateUndertimeMin,
							$totalhoursExcess,
							$totalMinExcess,$totalSalaryLogWeekend,$nightShiftDisplay,
							$getMonth,
							$getYear,
							$dayStart,
							$dayEnd,$emp_id);
					
				}
			}
			
			$updatePayroll = $payrollDAO->updatePayroll($totalHoursComplete,$totalMinComplete,$totalSalaryLog,$sssEP,$phEP,$pagibgContEP,$sssEE,
							$phEE,
							$pagibgContEE,$finalSalaryForTheMonth,$withHoldingTax,$salary,
							$totalSalaryLogExcess,
							$totalSalaryLogAbsent,
							$totalLateUndertimeHours,
							$totalLateUndertimeMin,
							$totalhoursExcess,
							$totalMinExcess,$totalSalaryLogWeekend,$nightShiftDisplay,
							$getMonth,
							$getYear,
							$dayStart,
							$dayEnd,$emp_id);
					//print_r($updatePayroll);

			$savePayroll = $payrollDAO->savePayroll($emp_id,
							$getMonth,
							$getYear,
							$dayStart,
							$dayEnd,
							$totalHoursComplete,
							$totalMinComplete,
							$totalSalaryLog,
							$sssEP,
							$phEP,
							$pagibgContEP,
							$sssEE,
							$phEE,
							$pagibgContEE,
							$withHoldingTax,
							$finalSalaryForTheMonth,
							$salary,
							$totalSalaryLogExcess,
							$totalSalaryLogAbsent,
							$totalLateUndertimeHours,
							$totalLateUndertimeMin,
							$totalhoursExcess,
							$totalMinExcess,
							$totalSalaryLogWeekend,$nightShiftDisplay
							);		
							
		}
		
		//echo "<td>";
		//echo $sql;
		//echo "</td>";
			echo "</tr>";
		} //getAllEmp
		
	}
}//end if filter for emp_id null

}else
{
	
		
if($getCutOff <> "#" && $getMonth <> "#" && $getYear <> "#")
{
	if($getCutOff <> "" && $getMonth <> "" && $getYear <> "")
	{
		//echo "<input type='submit' id=btnPayroll name='btnPayroll' value = 'GeneratePayroll'>";
		
		echo "<a href = payroll_process.php?month=".$getMonth."&year=".$getYear."&cutOffID=".$getCutOff."&empid=".$_GET['empid']."&btnPayroll=GeneratePayroll >Generate Payroll</a>";
		echo "<br/>";
		if($_GET['btnPayroll'] == 'GeneratePayroll')
		{

			echo "<a href = payslipPDF.php?month=".$getMonth."&year=".$getYear."&cutOffID=".$getCutOff."&empid=".$_GET['empid']."&btnPayroll=GeneratePayroll >Download Payslip</a>";echo "<br/>";
			
			// echo "<a href = payroll_payslip_export_person.php?month=".$getMonth."&year=".$getYear."&cutOffID=".$getCutOff."&empid=".$_GET['empid']."&btnPayroll=GeneratePayroll >Download Payslip</a>";echo "<br/>";
			
			echo "<a href = payroll_gen_export_person.php?month=".$getMonth."&year=".$getYear."&cutOffID=".$getCutOff."&empid=".$_GET['empid']."&btnPayroll=GeneratePayroll >Download Payroll</a>";
		}
		
		
		$getAllEmpViaID = $payrollDAO->getAllEmpViaID($_GET['empid']);
		//print_r($getAllEmp);

		foreach($getAllEmpViaID as $keyEmp => $valEmp)
		{

		$emp_id = $valEmp['emp_id'];
		$salary_id =$valEmp['salary_id'];
		$schedule_id = $valEmp['schedule_id'];
		$fullName = $valEmp['empLastName'] . ", " . $valEmp['empFirstName'] ."  " . $valEmp['empMiddleName'];
		echo "<td>";
		echo "EMP_ID: ".$emp_id;
		echo "<br/>";
		echo  $fullName;
		// echo "<br/>";
		// echo $schedule_id;
		echo "</td>";

		/*echo "<td>";
		echo $salary_id;
		echo "</td>";*/
		//$month = "04";
		//$year = "2016";
			$month = $_GET["month"];
			$year = $_GET["year"];
		$day = "";
		$daysInCalendar = "";
		$cutOff1 = "15";
		$cutOff2 = "30";
		$cutoffAll = "30";
		//$cut_off_id= "1";
		$cut_off_id= $_GET["cutOffID"];
		$dayStart ="";
		$dayEnd = "";
		$getSalaryByID = $payrollDAO->getSalaryByID($salary_id);


			foreach($getSalaryByID as $keySalary =>$valSalary)
			{
				$salary = $valSalary['salary_amount'];

				if($cut_off_id == NULL)
				{
					$cut_off_id = "3";
					$getCutOff = $payrollDAO->getCutOff($cut_off_id);
				}else
				{
					//$cut_off_id = "3";
					$getCutOff = $payrollDAO->getCutOff($cut_off_id);
				}

				foreach($getCutOff as $keyCutOff => $valCutOff)
				{
					// echo "<td>";
					// echo "cut_off_start: ".$valCutOff['cut_off_start'];
					// echo "<br/>";
					// echo "cut_off_end: ".$valCutOff['cut_off_end'];
					// echo "cut_off_start: ".$valCutOff['cut_off_start'];
					// echo "</td>";
					/*$totalLateUndertimeHours= "";
					$totalLateUndertimeMin= "";
					$totalhoursExcess= "";
					$totalMinExcess= "";*/


					$dayStart = $valCutOff['cut_off_start'];
					$dayEnd = $valCutOff['cut_off_end'];

					$getDTRByID = $payrollDAO->getDTRByID($emp_id,$month,$year,$dayStart,$dayEnd);

					//totalHooursComplete
					echo "<td>";
					$totalHoursComplete = "";
					$totalMinComplete = "";
					$totalhoursExcess = "";
					$totalMinExcess = "";
					$hoursLate = "0";
					$minLate = "0";
					$hoursUndertime = "0";
					$minUndertime = "0";
					
					foreach ($getDTRByID as $keyDTR => $valDTR)
					{

						$day = $valDTR["day"];
						$valDTRDtr_id = $valDTR["dtr_id"];
						//echo $emp_id;
						$getEmpLogs = $payrollDAO->getEmpLogs($emp_id,$valDTRDtr_id);


						if($getEmpLogs == true)
						{
							

							foreach($getEmpLogs as $key => $val) {
							
									/*$hoursLate = $hoursLate + $val['hoursLate'];
									$minLate = $minLate + $val['minLate'];
									$hoursUndertime = $hoursUndertime + $val['hoursUndertime'];
									$minUndertime = $minUndertime + $val['minUndertime'];	
*/
								if($getEmpLogs <> NULL) {

									if($val['emp_excesstime'] >= "01:00:00")
									{

									// $totalHoursComplete = $totalHoursComplete + $val['hoursComplete'];
									// $totalHoursComplete = $totalHoursComplete + $val['hoursExcess'];
									// echo "totalHoursComplete=>".$totalHoursComplete;

									// $totalMinComplete = $totalMinComplete + $val['minComplete'];
									// $totalMinComplete = $totalMinComplete + $val['minExcess'];
									// echo "totalMinComplete=>".$totalMinComplete;
									
									$totalHoursComplete = $totalHoursComplete + $val['hoursComplete'];
									//$totalHoursComplete = $totalHoursComplete + $val['hoursExcess'];

									$totalhoursExcess =  $totalhoursExcess+ $val['hoursExcess'];
									$totalMinExcess =  $totalMinExcess + $val['minExcess'];

									//echo $totalhoursExcess.":".$totalMinExcess."<br/>";

									$totalMinComplete = $totalMinComplete + $val['minComplete'];
									//$totalMinComplete = $totalMinComplete + $val['minExcess'];
									
																		

									}
									else
									{

									$totalHoursComplete = $totalHoursComplete + $val['hoursComplete'];
									$totalMinComplete = $totalMinComplete + $val['minComplete'];

									}

									$hoursLate = $hoursLate + $val['hoursLate'];
									$minLate = $minLate + $val['minLate'];

									$hoursUndertime = $hoursUndertime + $val['hoursUndertime'];
									$minUndertime = $minUndertime + $val['minUndertime'];



								}


								else
								{
									$totalHoursComplete = "0";
									$totalMinComplete = "0";
								}



							}//end foreach


						}//if getEmplogs
						else
							{
								// $hoursLate = "0";
								// $hoursUndertime = "0";
								// $minLate = "0";
								// $minUndertime = "0";
							}



					}


						/*$totalHoursComplete = 0;
						$totalMinComplete = 0;*/
						//echo "THC: ".$totalHoursComplete;
						//echo $totalHoursComplete.":".$totalMinComplete;
						//echo "<br/>";
						// echo "totalMinComplete: ".$totalMinComplete;

						if($totalHoursComplete <> "")
						{
							if($totalMinComplete >= 60)
							{
								$quotient = (int)($totalMinComplete / 60);
								$remainder = (int)($totalMinComplete % 60);
								$totalHoursComplete = $totalHoursComplete+$quotient;
								$totalMinComplete = $remainder;

							}

							echo $totalHoursComplete.":".$totalMinComplete;
						}else
						{
							echo "00:00";
						}



					echo "</td>";
					
					//OT
					$quoExcess = "";
					$remainderExcess = "";
					echo "<td>";

					if($totalhoursExcess <> "" || $totalMinExcess <> "")
						{
							if($totalMinExcess >= 60)
							{
								$quoExcess = (int)($totalMinExcess / 60);
								$remainderExcess = (int)($totalMinExcess % 60);
								$totalhoursExcess = $totalhoursExcess+$quoExcess;
								$totalMinExcess = $remainderExcess;

							}

							/*echo $totalHoursComplete.":".$totalMinComplete;
							echo "<br/>";*/
							echo $totalhoursExcess.":".$totalMinExcess;
							/*echo "quotient=".$quotient;echo "<br/>";
							echo "remainder=".$remainder;echo "<br/>";*/
						}else
						{
							echo "00:00";
						}
					echo "</td>";

					//absent late
					$quoLateUndertime = "";
					$remainderLateUnderTime = "";
					
					// echo "<td>";
					// /*echo $hoursLate.":".$minLate;
					// echo "<br/>";
					// echo $hoursUndertime.":".$minUndertime;
					// echo "<br/>";*/
					// $totalLateUndertimeHours = $hoursLate + $hoursUndertime;
					// $totalLateUndertimeMin = $minLate + $minUndertime;
					// // echo $totalLateUndertimeHours.":".$totalLateUndertimeMin;

					// if($totalLateUndertimeHours <> "")
					// {
					// 	if($totalLateUndertimeMin >= 60)
					// 	{
					// 		$quoLateUndertime = (int)($totalLateUndertimeMin / 60);
					// 		$remainderLateUnderTime = (int)($totalLateUndertimeMin % 60);
					// 		$totalLateUndertimeHours = $totalLateUndertimeHours+$quoLateUndertime;
					// 		$totalLateUndertimeMin = $remainderLateUnderTime;
					// 	}

					// 	echo $totalLateUndertimeHours.":".$totalLateUndertimeMin;
					// 	//echo "<br/>empid:".$emp_id;

					// }else
					// {
					// 	echo "00:00";

					// }
					// echo "</td>";

					echo "<td>";
					//carla
					/*echo $hoursLate.":".$minLate;
					echo "<br/>";
					echo $hoursUndertime.":".$minUndertime;
					echo "<br/>";*/
					$totalLateUndertimeHours = $hoursLate + $hoursUndertime;
					// $totalLateUndertimeHours = $hoursLate;
					// $totalLateUndertimeHours = $hoursUndertime;
					$totalLateUndertimeMin = $minLate + $minUndertime;
					// $totalLateUndertimeMin = $minLate;
					// $totalLateUndertimeMin = $minUndertime;
					//echo $totalLateUndertimeHours.":".$totalLateUndertimeMin;

					if($totalLateUndertimeHours <> "" ||  $totalLateUndertimeMin <> "")
					{
						if($totalLateUndertimeMin >= 60)
						{
							$quoLateUndertime = (int)($totalLateUndertimeMin / 60);
							$remainderLateUnderTime = (int)($totalLateUndertimeMin % 60);
							$totalLateUndertimeHours = $totalLateUndertimeHours+$quoLateUndertime;
							$totalLateUndertimeMin = $remainderLateUnderTime;
						}
						//echo "Absent: ";
						echo $totalLateUndertimeHours.":".$totalLateUndertimeMin;
						//echo "<br/>empid:".$emp_id;

					}else
					{
						$totalLateUndertimeHours = "0";
						$totalLateUndertimeMin = "0";
						echo "00:00";

					}

					echo "<br/>";

					// if($totalHoursComplete >= "80")
					if($totalHoursComplete >= "70")
					{

					
					$weekHours = 119 - $totalHoursComplete;
					$weekMin = 60 - $totalMinComplete;
					// echo $weekHours . ":".$weekMin;

					echo "<br/>";
					$weekHours = $weekHours-$totalLateUndertimeHours;
					$weekMin = $weekMin - $totalLateUndertimeMin;

					if($weekHours < 0 || $weekMin <0)
						{
							$weekMin = 0;
							$weekHours = 0;
						}else
						{
							$weekMin = $weekMin;
							$weekHours = $weekHours;
						}

					// echo $weekHours . ":".$weekMin;

					}

					echo "</td>";

				}


				/*echo "<td>";
				echo "<pre>";
				//print_r($getDTRByID);
				echo "</pre>";
				echo "</td>";*/

				$hour = 8;
				$minute = 60;
				//$cutoff = 2;
				$daysInCalendar = "30";
				$salaryPerDay = round($salary/$daysInCalendar,5);
				$salaryPerHour = round(($salaryPerDay/$hour),5);
				$salaryPerMinute = round(($salaryPerHour/$minute),5);

				// $salaryLogPerMinute = round($totalMinComplete * $salaryPerMinute,5);
				// $salaryLogPerHour = round($totalHoursComplete * $salaryPerHour,5);
				// $totalSalaryLog = round($salaryLogPerHour + $salaryLogPerMinute,5);

				// $salaryLogPerMinuteAbsent = round($totalLateUndertimeMin * $salaryPerMinute,5);
				// $salaryLogPerHourAbsent = round($totalLateUndertimeHours * $salaryPerHour,5);
				// $totalSalaryLogAbsent = round($salaryLogPerMinuteAbsent + $salaryLogPerHourAbsent,5);


				// $salaryLogPerMinuteExcess = round($totalMinExcess * $salaryPerMinute,5);
				// $salaryLogPerHourExcess = round($totalhoursExcess * $salaryPerHour,5);
				// $totalSalaryLogExcess = round($salaryLogPerHourExcess + $salaryLogPerMinuteExcess,5);



				// echo "<td>";
				// echo $salary;
				// echo "</td>";

				//echo "<td>";
				//echo $salary;
				/*echo "salaryPerHour=>".$salaryPerHour;echo "<br/>";
				echo "salaryPerMinute=>".$salaryPerMinute;echo "<br/>";*/


				// $salaryLogPerMinute = round($totalMinComplete * $salaryPerMinute,5);
				// $salaryLogPerHour = round($totalHoursComplete * $salaryPerHour,5);
				// $totalSalaryLog = round($salaryLogPerHour + $salaryLogPerMinute,5);
				// $totalSalaryLog = $totalSalaryLog + $totalSalaryLogExcess;

				/*echo "salaryLogPerMinute=>".$salaryLogPerMinute;echo "<br/>";
				echo "salaryLogPerHour=>".$salaryLogPerHour;echo "<br/>";*/
				//echo "salaryLogPerMinute=>".$salaryLogPerMinute;echo "<br/>";
				// echo "P ".$totalSalaryLog;


				// echo "</td>";


				$salaryLogPerMinuteWeekend = round($weekMin * $salaryPerMinute,5);
				$salaryLogPerHourWeekend = round($weekHours * $salaryPerHour,5);
				$totalSalaryLogWeekend = round($salaryLogPerHourWeekend + $salaryLogPerMinuteWeekend,5);

				// echo "<td>";
				// echo "P ".$totalSalaryLogWeekend;
				//echo "<br/>";
				// echo "</td>";

				echo "<td>";
				//echo $salary;

				$salaryLogPerMinute = round($totalMinComplete * $salaryPerMinute,5);
				$salaryLogPerHour = round($totalHoursComplete * $salaryPerHour,5);
				$totalSalaryLog = round($salaryLogPerHour + $salaryLogPerMinute,5);

				$salaryLogPerMinuteAbsent = round($totalLateUndertimeMin * $salaryPerMinute,5);
				$salaryLogPerHourAbsent = round($totalLateUndertimeHours * $salaryPerHour,5);
				$totalSalaryLogAbsent = round($salaryLogPerMinuteAbsent + $salaryLogPerHourAbsent,5);


				$salaryLogPerMinuteExcess = round($totalMinExcess * $salaryPerMinute,5);
				$salaryLogPerHourExcess = round($totalhoursExcess * $salaryPerHour,5);
				$totalSalaryLogExcess = round($salaryLogPerHourExcess + $salaryLogPerMinuteExcess,5);

				

				/* echo $salaryPerMinute;
				 echo "<br/>";
				 echo $salaryPerHour;
				 echo "<br/>";
				 echo $totalSalaryLog;
				 echo "<br/>";
				*/
				/*
				echo $totalSalaryLogExcess;
				echo "<br/>";*/

				//$totalSalaryLog = $totalSalaryLog + $totalSalaryLogExcess;

				//$totalSalaryLogDisplay = $totalSalaryLog + $totalSalaryLogExcess;

				$totalSalaryLogDisplay = $totalSalaryLog + $totalSalaryLogExcess + $totalSalaryLogWeekend;
				if($schedule_id == "3")
				{
					//echo "YES";
					
					$totalSalaryLog = $totalSalaryLog + $totalSalaryLogExcess;
					$totalSalaryLog = $totalSalaryLog+ $totalSalaryLogWeekend;
					// echo $totalSalaryLog;
					//echo "<br/>";

					$nightShiftDisplay =  round($totalSalaryLog * 0.10,5);
					$totalSalaryLog = $totalSalaryLog + (round($totalSalaryLog * 0.10,5));
				}else
				{
					
					$totalSalaryLog = $totalSalaryLog + $totalSalaryLogExcess;
					$totalSalaryLog = $totalSalaryLog+ $totalSalaryLogWeekend;
				}



				/*if($totalSalaryLog >= $totalSalaryLogWeekend)
				{
					$totalSalaryLog = $totalSalaryLog - $totalSalaryLogWeekend;
				}else
				{
					$totalSalaryLog = 0;
				}*/
				
				//$totalSalaryLog = $totalSalaryLog + $totalSalaryLogExcess;
				//echo $totalSalaryLogDisplay;
				//echo $totalSalaryLogExcess;
				if($totalHoursComplete == "00" || $totalHoursComplete == "")
				{
					//echo "0aaaa";
					$totalSalaryLogDisplay = "0";
					$totalSalaryLog = "0";
					echo $totalSalaryLogDisplay;
					// echo "<br/>";
					// echo $totalSalaryLog;
				}else
				{
					//echo $totalHoursComplete;
					//echo "<br/>";
					echo $totalSalaryLogDisplay;
					// echo "<br/>";
					// echo $totalSalaryLog;
				}
				
				echo "</td>";


				echo "<td>";
				if($schedule_id == 3)
				{
					echo $nightShiftDisplay;
				}else
				{
					$nightShiftDisplay = 0;
					echo $nightShiftDisplay;
				}
				
				echo "</td>";

				// echo "<td>";
				// echo "salaryPerDay= ".$salaryPerDay;
				// echo "<br/>";
				// echo "salaryPerHour= ".$salaryPerHour;
				// echo "<br/>";
				// echo "salaryPerMinute= ".$salaryPerMinute;
				// echo "<br/>";
				// echo "</td>";

				$salaryAsPerCompHour = $salaryPerHour * $totalHoursComplete;
				$salaryAsPerCompMin = $salaryPerMinute * $totalMinComplete;
				//$totalSalaryForTheMonth = $salaryAsPerCompHour + $salaryAsPerCompMin;
				$totalSalaryForTheMonth = $totalSalaryLog;
				//sss
				$totalSalaryForTheMonthSSS = $totalSalaryForTheMonth * 2;
				// $getSSSCont = $payrollDAO->getSSSCont($salary);
				if($cutOffIDVal <> "3")
				{
					$getSSSCont = $payrollDAO->getSSSCont($totalSalaryForTheMonthSSS);
				}else
				{
					$getSSSCont = $payrollDAO->getSSSCont($totalSalaryForTheMonth);
				}

				$sssCont = "";
				$sssEP = "";
				$sssEE = "";
				echo "<td>";
				foreach($getSSSCont as $keySSS => $valSSS)
				{

					$sssCont = $valSSS["sss_total_contribution"];
					if($cutOffIDVal <> "3")
					{
						$sssEP = $valSSS["sss_employer_share"];
						$sssEP = $sssEP / 2;

						$sssEE = $valSSS["sss_employee_share"];
						$sssEE = $sssEE / 2;
						$sssEP = round($sssEP,5);
						$sssEE = round($sssEE,5);

					}else
					{
						$sssEP = $valSSS["sss_employer_share"];
						$sssEE = $valSSS["sss_employee_share"];
						$sssEP = round($sssEP,5);
						$sssEE = round($sssEE,5);
					}
					//echo "SSS Cont: ".$sssCont;echo "<br/>";
					// echo "SSS EP: ".$sssEP;echo "<br/>";
					echo "SSS EE: ".$sssEE;echo "<br/>";
					echo "<br/>";

				}
				echo "</td>";
				// $getPhilHealth = $payrollDAO->getPhilHealthCont($salary);
				$totalSalaryForTheMonthPh = $totalSalaryForTheMonth * 2;
				//$totalSalaryForTheMonthPh = $totalSalaryForTheMonthPh / 2;
				if($cutOffIDVal <> "3")
				{
					$getPhilHealth = $payrollDAO->getPhilHealthCont($totalSalaryForTheMonthPh);

				}else
				{
					$getPhilHealth = $payrollDAO->getPhilHealthCont($totalSalaryForTheMonth);
				}
				//$getPhilHealth = $payrollDAO->getPhilHealthCont($totalSalaryForTheMonth);
				$phCont = "";
				$phEP = "";
				$phEE = "";
				echo "<td>";
				foreach($getPhilHealth as $keyPh => $valPh)
				{

					$phCont = $valPh["ph_total_contribution"];
					if($cutOffIDVal <> "3")
					{
						$phEP = $valPh["ph_employer_share"];
						$phEP = $phEP / 2;

						$phEE = $valPh["ph_employee_share"];
						$phEE = $phEE / 2;

						$phEP = round($phEP,5);
						$phEE = round($phEE,5);

					}else
					{

						$phEP = $valPh["ph_employer_share"];
						$phEE = $valPh["ph_employee_share"];
						$phEP = round($phEP,5);
						$phEE = round($phEE,5);
					}
					
					//echo "Philhealth Cont: ".$phCont;echo "<br/>";
					// echo "Philhealth EP: ".$phEP;echo "<br/>";
					echo "Philhealth EE: ".$phEE;echo "<br/>";
					echo "<br/>";

				}
				echo "</td>";

				$pagibigContMax = "5000.00";
				$pagibigBaseMin = "1500.00";
				$pagibgContEP = "";
				$pagibgContEE = "";
				$pagIbigEE = "PAGIBIG EE: ";
				$pagIbigEP = "PAGIBIG EP: ";
				echo "<td>";
				// if($salary < $pagibigContMax)
				if($totalSalaryForTheMonth < $pagibigContMax)
				{
					// if($salary < $pagibigBaseMin)
					if($totalSalaryForTheMonth < $pagibigBaseMin)
					{
						if($cutOffIDVal <> "3")
						{
							// $pagibgContEP = $salary * "0.01";
							$pagibgContEP = $totalSalaryForTheMonth * "0.01";
							$pagibgContEP = $pagibgContEP / 2;

							// $pagibgContEE = $salary * "0.02";
							$pagibgContEE = $totalSalaryForTheMonth * "0.02";
							$pagibgContEE = $pagibgContEE / 2;

							$pagibgContEP = round($pagibgContEP,5);
							$pagibgContEE = round($pagibgContEE,5);

							// echo $pagIbigEP.$pagibgContEP;echo "<br/>";
							echo $pagIbigEE.$pagibgContEE;echo "<br/>";

						}else
						{
							// $pagibgContEP = $salary * "0.01";
							$pagibgContEP = $totalSalaryForTheMonth * "0.01";
							//echo $pagIbigEP.$pagibgContEP;echo "<br/>";

							// $pagibgContEE = $salary * "0.02";
							$pagibgContEE = $totalSalaryForTheMonth * "0.02";
							//echo $pagIbigEE.$pagibgContEE;echo "<br/>";

							$pagibgContEP = round($pagibgContEP,5);
							$pagibgContEE = round($pagibgContEE,5);

							// echo $pagIbigEP.$pagibgContEP;echo "<br/>";
							echo $pagIbigEE.$pagibgContEE;echo "<br/>";


						}

					}else
					{
						if($cutOffIDVal <> "3")
						{
							// $pagibgContEP = $salary * "0.02";
							$pagibgContEP = $totalSalaryForTheMonth * "0.02";
							$pagibgContEP = $pagibgContEP / 2;
							//echo $pagIbigEP.$pagibgContEP;echo "<br/>";

							// $pagibgContEE = $salary * "0.02";
							$pagibgContEE = $totalSalaryForTheMonth * "0.02";
							$pagibgContEE = $pagibgContEE / 2;
							//echo $pagIbigEE.$pagibgContEE;echo "<br/>";

							$pagibgContEP = round($pagibgContEP,5);
							$pagibgContEE = round($pagibgContEE,5);

							// echo $pagIbigEP.$pagibgContEP;echo "<br/>";
							echo $pagIbigEE.$pagibgContEE;echo "<br/>";


						}
						else
						{
							// $pagibgContEP = $salary * "0.02";
							$pagibgContEP = $totalSalaryForTheMonth * "0.02";
							//echo $pagIbigEP.$pagibgContEP;echo "<br/>";

							// $pagibgContEE = $salary * "0.02";
							$pagibgContEE = $totalSalaryForTheMonth * "0.02";
							//echo $pagIbigEE.$pagibgContEE;echo "<br/>";

							$pagibgContEP = round($pagibgContEP,5);
							$pagibgContEE = round($pagibgContEE,5);

							// echo $pagIbigEP.$pagibgContEP;echo "<br/>";
							echo $pagIbigEE.$pagibgContEE;echo "<br/>";


						}
					}
				}else
				{
					//echo "cutOffIDVal => ".$cutOffIDVal;
					//carla
					if($cutOffIDVal <> "3")
					{

						$pagibgContEP = $pagibigContMax * "0.02";
						$pagibgContEP = $pagibgContEP / 2;
						//echo $pagIbigEP.$pagibgContEP;echo "<br/>";

						$pagibgContEE = $pagibigContMax * "0.02";
						$pagibgContEE = $pagibgContEE / 2;
						//echo $pagIbigEE.$pagibgContEE;echo "<br/>";echo "<br/>";

						$pagibgContEP = round($pagibgContEP,5);
							$pagibgContEE = round($pagibgContEE,5);

							// echo $pagIbigEP.$pagibgContEP;echo "<br/>";
							echo $pagIbigEE.$pagibgContEE;echo "<br/>";



					}
					else
					{
						$pagibgContEP = $pagibigContMax * "0.02";
						//echo $pagIbigEP.$pagibgContEP;echo "<br/>";

						$pagibgContEE = $pagibigContMax * "0.02";
						//echo $pagIbigEE.$pagibgContEE;echo "<br/>";echo "<br/>";

						$pagibgContEP = round($pagibgContEP,5);
							$pagibgContEE = round($pagibgContEE,5);

							// echo $pagIbigEP.$pagibgContEP;echo "<br/>";
							echo $pagIbigEE.$pagibgContEE;echo "<br/>";


						}
				}

				echo "</td>";

				//TAX
				$tax_category_id = "";
				$deduction = $pagibgContEE+$sssEE+$phEE;
				$salaryLessDeduction = $totalSalaryForTheMonth-$deduction;
				$maxTaxCeiling = "";
				$maxExactTax = "";
				$maxOverPercentage = "";

				echo "<td>";
				$tax_category_id = $valEmp['tax_category_id'];
				// echo "tax_category_id: ".$tax_category_id;echo "<br/>";echo "<br/>";
				$salaryLessDeduction = round($salaryLessDeduction, 5);
				if($salaryLessDeduction <= 0){

					$salaryLessDeduction = 0;
					// echo "Total Taxable amount= ".$salaryLessDeduction;
					// echo "<br/>";echo "<br/>";
				}else
				{	
					// echo "sssEE:".$sssEE;
					// echo "<br/>";
					/*echo "deduction: ".$deduction;
					echo "<br/>";
					echo "Total Taxable amount= ".$salaryLessDeduction;
					echo "<br/>";echo "<br/>";*/
				}

				//$getTax = $payrollDAO->getTax($tax_category_id,$salaryLessDeduction);
				$getCutOff = $_GET['cutOffID'];
				if($getCutOff <> 3)
				{
					//carla
					$identifyTax = "1";
					$getTax = $payrollDAO->getTax($tax_category_id,$salaryLessDeduction,$identifyTax);
				}else
				{
					$identifyTax = "2";
					$getTax = $payrollDAO->getTax($tax_category_id,$salaryLessDeduction,$identifyTax);
				}


				if($getTax == TRUE )
				{
					if($salaryLessDeduction <= 0)
					{

						$withHoldingTax = "0";
						// echo "Witholding Tax: ".$withHoldingTax;echo "<br/>";
						echo "P ".$withHoldingTax;echo "<br/>";

						$maxTaxCeiling = "0";
						$maxExactTax = "0";
						$maxOverPercentage = "0";

						/*echo "maxTaxCeiling: " . $maxTaxCeiling;
						echo "<br/>";
						echo "maxExactTax: " . $maxExactTax;
						echo "<br/>";
						echo "maxOverPercentage: " . $maxOverPercentage;
						echo "<br/>";
						echo "<br/>";*/


					}else
					{
						foreach($getTax as $keyTax => $valTax)
						{
							if ($valTax['maxTaxCeiling'] == NULL )
							{
								$maxTaxCeiling = "0";
								$maxExactTax = "0";
								$maxOverPercentage = "0";

								/*echo "maxTaxCeiling: " . $maxTaxCeiling;
								echo "<br/>";
								echo "maxExactTax: " . $maxExactTax;
								echo "<br/>";
								echo "maxOverPercentage: " . $maxOverPercentage;
								echo "<br/>";
								echo "<br/>";*/

							}else {
								$maxTaxCeiling = $valTax['maxTaxCeiling'];
								$maxExactTax = $valTax['maxExactTax'];
								$maxOverPercentage = $valTax['maxOverPercentage'];
								/*echo "maxTaxCeiling: " . $maxTaxCeiling;
								echo "<br/>";
								echo "maxExactTax: " . $maxExactTax;
								echo "<br/>";
								echo "maxOverPercentage: " . $maxOverPercentage;
								echo "<br/>";
								echo "<br/>";*/
							}
						}

						$salarysTaxCeiling = $salaryLessDeduction - $maxTaxCeiling;
						$salaryPercentage = $salarysTaxCeiling * $maxOverPercentage;
						$withHoldingTax = $maxExactTax + $salaryPercentage;

						$salarysTaxCeiling = round($salarysTaxCeiling,5);
						$salaryPercentage = round($salaryPercentage,5);
						$withHoldingTax = round($withHoldingTax,5);
						// echo "Witholding Tax: ".$withHoldingTax;
						echo "P ".$withHoldingTax;echo "<br/>";


					}

				}

				echo "</td>";

				echo "<td>";
				// echo "Other Deductions";
				// echo "<br/>";
				// echo $month;
				// echo "<br/>";
				// echo $year;
				// echo "<br/>";
				// echo $cutOffIDVal;
				// echo "<br/>";
				// echo $emp_id;
				// echo "<br/>";
				// echo "<br/>";
				// echo "<br/>";
				$totalOD ="";
				if($cutOffIDVal <> "3")
				{

					$getSumAmount = $payrollDAO->getSumAmount($emp_id,$month,$year,$cutOffIDVal);
				}else
				{
					$getSumAmount = $payrollDAO->getSumAmountNoCutOff($emp_id,$month,$year);	
				}

					foreach($getSumAmount as $keySA => $valSA)
					{
						$totalOD = $valSA['totalOD'];
						if($totalOD <> "" || $totalOD <> NULL)
						{
							echo "P ".$totalOD;
						}else
						{
							echo "P 0.00";
						}
					}

				echo "</td>";

				echo "<td>";
				$finalSalaryForTheMonth = $salaryLessDeduction - $withHoldingTax;
				// echo $finalSalaryForTheMonth;
				// echo "<br/>";
				$finalSalaryForTheMonth = $finalSalaryForTheMonth - $totalOD;
				$finalSalaryForTheMonth = round($finalSalaryForTheMonth,2);
				// echo "<td>";
				echo "P ".$finalSalaryForTheMonth;
				echo "</td>";



			} // getSalaryByID
				
				$sql= "INSERT INTO tbl_payroll(
				emp_id,
				payroll_month,
				payroll_year,
				cut_off_start,
				cut_off_end,
				total_hours_comp,
				total_min_comp,
				salary_as_per_logs,
				sss_cont_ep,
				ph_cont_ep,
				pagibig_cont_ep,
				sss_cont_ee,
				ph_cont_ee,
				pagibig_cont_ee,
				tax_cont,
				total_salary)
		VALUES('".$emp_id."','".
		$getMonth."','".
		$getYear."','".
		$dayStart."','".
		$dayEnd."','".
		$totalHoursComplete."','".
		$totalMinComplete."','".
		$totalSalaryLog."','".
		$sssEP."','".
		$phEP."','".
		$pagibgContEP."','".
		$sssEE."','".
		$phEE."','".
		$pagibgContEE."','".
		$withHoldingTax."','".
		$finalSalaryForTheMonth."');";
		
		// echo "<td>";
		//echo $sql;
		// $savePayroll = $payrollDAO->savePayroll($emp_id,
							// $getMonth,
							// $getYear,
							// $dayStart,
							// $dayEnd,
							// $totalHoursComplete,
							// $totalMinComplete,
							// $totalSalaryLog,
							// $sssEP,
							// $phEP,
							// $pagibgContEP,
							// $sssEE,
							// $phEE,
							// $pagibgContEE,
							// $withHoldingTax,
							// $finalSalaryForTheMonth);
		//echo $sql;
		// echo "</td>";
		
		if($_GET['btnPayroll'] == 'GeneratePayroll')
		{	
			$getPayroll = $payrollDAO->getPayroll($getMonth,$getYear,$dayStart,$dayEnd);

			foreach($getPayroll as $keyPayroll => $valPayroll)
			{
				if($valPayroll['total_hours_comp'] == $totalHoursComplete)
				{
					$savePayroll = $payrollDAO->savePayroll($emp_id,
							$getMonth,
							$getYear,
							$dayStart,
							$dayEnd,
							$totalHoursComplete,
							$totalMinComplete,
							$totalSalaryLog,
							$sssEP,
							$phEP,
							$pagibgContEP,
							$sssEE,
							$phEE,
							$pagibgContEE,
							$withHoldingTax,
							$finalSalaryForTheMonth,
							$salary,
							$totalSalaryLogExcess,
							$totalSalaryLogAbsent,
							$totalLateUndertimeHours,
							$totalLateUndertimeMin,
							$totalhoursExcess,
							$totalMinExcess,$totalSalaryLogWeekend,$nightShiftDisplay
							);
					
				}else
				{
					//echo "NOTTTTT";
					/*$updatePayroll = $payrollDAO->updatePayroll($totalHoursComplete,$totalMinComplete,$totalSalaryLog,$sssEP,$phEP,$pagibgContEP,$sssEE,
							$phEE,
							$pagibgContEE,$finalSalaryForTheMonth,$withHoldingTax,$salary,$getMonth,
							$getYear,
							$dayStart,
							$dayEnd,$emp_id);*/

							$updatePayroll = $payrollDAO->updatePayroll($totalHoursComplete,$totalMinComplete,$totalSalaryLog,$sssEP,$phEP,$pagibgContEP,$sssEE,
							$phEE,
							$pagibgContEE,$finalSalaryForTheMonth,$withHoldingTax,$salary,
							$totalSalaryLogExcess,
							$totalSalaryLogAbsent,
							$totalLateUndertimeHours,
							$totalLateUndertimeMin,
							$totalhoursExcess,
							$totalMinExcess,$totalSalaryLogWeekend,$nightShiftDisplay,
							$getMonth,
							$getYear,
							$dayStart,
							$dayEnd,$emp_id);


				}
			}
			
			/*$savePayroll = $payrollDAO->savePayroll($emp_id,
							$getMonth,
							$getYear,
							$dayStart,
							$dayEnd,
							$totalHoursComplete,
							$totalMinComplete,
							$totalSalaryLog,
							$sssEP,
							$phEP,
							$pagibgContEP,
							$sssEE,
							$phEE,
							$pagibgContEE,
							$withHoldingTax,
							$finalSalaryForTheMonth,
							$salary);	*/	
							$savePayroll = $payrollDAO->savePayroll($emp_id,
							$getMonth,
							$getYear,
							$dayStart,
							$dayEnd,
							$totalHoursComplete,
							$totalMinComplete,
							$totalSalaryLog,
							$sssEP,
							$phEP,
							$pagibgContEP,
							$sssEE,
							$phEE,
							$pagibgContEE,
							$withHoldingTax,
							$finalSalaryForTheMonth,
							$salary,
							$totalSalaryLogExcess,
							$totalSalaryLogAbsent,
							$totalLateUndertimeHours,
							$totalLateUndertimeMin,
							$totalhoursExcess,
							$totalMinExcess,$totalSalaryLogWeekend,$nightShiftDisplay
							);

							$updatePayroll = $payrollDAO->updatePayroll($totalHoursComplete,$totalMinComplete,$totalSalaryLog,$sssEP,$phEP,$pagibgContEP,$sssEE,
							$phEE,
							$pagibgContEE,$finalSalaryForTheMonth,$withHoldingTax,$salary,
							$totalSalaryLogExcess,
							$totalSalaryLogAbsent,
							$totalLateUndertimeHours,
							$totalLateUndertimeMin,
							$totalhoursExcess,
							$totalMinExcess,$totalSalaryLogWeekend,$nightShiftDisplay,
							$getMonth,
							$getYear,
							$dayStart,
							$dayEnd,$emp_id);
							
		}
		
		//echo "<td>";
		//echo $sql;
		//echo "</td>";
			echo "</tr>";
		} //getAllEmp
		
	}
}//end if filter
	
	
}


?>

	</table>
<?php include_once "footer.php" ?>
<?php
$custompage->Page_Terminate();
?>
