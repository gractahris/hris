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
<?php include_once "model/timesheetDAO.php" ?>
<?php include_once "DigitalClock.php" ?>

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
$timesheetDAO = new timesheetDAO();
//$timesheetAdminDAO = new $timesheetAdminDAO();
	$getSchedByEmp = $timesheetDAO->getSchedByEmp($_SESSION["emp_id"]);
	//echo "SchedID=>".$getSchedByEmp[0]['schedule_id'];
	echo "<br/>";
	$schedule_id = $getSchedByEmp[0]['schedule_id'];
	
	$getSchedByID = $timesheetDAO->getSchedByID($schedule_id);
	
	//echo "Time IN=>".$getSchedByID[0]['schedule_time_in']; 
	$schedule_time_in = $getSchedByID[0]['schedule_time_in']; 
	echo "<br/>";
	//echo "Time Out=>".$getSchedByID[0]['schedule_time_out']; 
	$schedule_time_out = $getSchedByID[0]['schedule_time_out']; 
	
	$noLogsFound = "<font color = 'red'><b>No logs found!</b></font>";
?>
<?php


$clock=new DigitalClock();
?>


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
			
			$getDTR = $timesheetDAO->getDTR($_SESSION['emp_id'],$month,$day,$dateYear);
			if($getDTR == true)
			{
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
					
					?>
					
					<input class ="btn btn-primary" type="submit" id ="timeIN" name="timeIn" value="Time In" />
					<input class ="btn btn-primary" type="submit" id ="timeOut" name="timeOut" value="Time Out" />
					</form>
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
									swal("You are logged in");
									</script>
								<?php
								}
								else
								{
									
									?>
									<script>
									swal("You have timed in already for this day !");
									</script>
									
									<?php
								}
								
							}
							
						}
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
									swal("You are logged out");
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
									swal("You havent TIMED IN yet !");
									</script>
								<?php
								}
								else
								{
									//echo "You have timed out already for this day";
									
									?>
									<script>
									swal("You have timed out already for this day !");
									</script>
									
									<?php
								}
							}
							
						}
					}
						
					
				}
				
			}else{
				
				echo "NO DTR";
			}
		}
		
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
<table>
<thead>
	<tr>
		<!--
		<td>DTR ID</td>
		<td>Emp ID</td>
		-->
		<td>Month</td>
		<td>Day</td>
		<td>Year</td>
		<td> </td>
		<td>Time IN</td>
		<td>Time OUT</td>
		<td>Mandatory Break Hours</td>
		<td>Total Hours</td>
		<td>Total Hours Less<br/>Mandatory Break Hours</td>
		<td>Total Late</td>
		<td>Total UnderTime</td>
		<td>Total Excess Time</td>
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
			
			
			echo "<td>";
			if($getHoliday == true)
			{
				echo "<font color = 'red'>Holiday</font>";
				$is_holiday = "1";
				
			}else
			{
				echo "";
				
			}
			echo "</td>";
		
		if($valDTRMo['day'] >=10)
		{
			
		$dateTodayLog = $valDTRMo['year'] . "-" . $valDTRMo['month'] ."-".$valDTRMo['day'];
		
		}else{
			$dateTodayLog = $valDTRMo['year'] . "-" . $valDTRMo['month'] ."-0".$valDTRMo['day'];
		}
		
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

		echo "<td>";
		include "emp_totalhours_nomandatory_hours.php";
		echo "</td>";

		echo "<td>";
		if($emp_timein <> NULL && $emp_timeout <> NULL)
		{
			
			if($emp_timein <= $schedule_time_in )
			{
				if($emp_timeout >= $schedule_time_out)
				{
					$getTotalHours = $timesheetDAO->getTotalHours($schedule_time_out, $schedule_time_in);
					
					$totalHours = $getTotalHours[0]['totalHours'];
					echo $totalHours;
				}else
				{
					$getTotalHours = $timesheetDAO->getTotalHours($emp_timeout, $schedule_time_in);
					
					// $totalHours = $getTotalHours[0]['totalHours'];
					// echo $totalHours;
					
					if($is_holiday == 0)
					{
						$totalHours = $getTotalHours[0]['totalHours'];
						echo $totalHours;
					}else
					{
						$totalHours = $getTotalHours[0]['totalHours'];
						$totalHours = $totalHours * "02:00:00" ;
						$totalHours = $totalHours.":00:00";
						echo $totalHours;
					}
				}						
				
			}else if($emp_timein > $schedule_time_in )
			{
				if($emp_timeout > $schedule_time_out)
				{
					$getTotalHours = $timesheetDAO->getTotalHours($schedule_time_out, $emp_timein);

					if($getTotalHours[0]['totalHours'] > "00:00:00")
					{
						$totalHours = $getTotalHours[0]['totalHours'];
						echo $totalHours;
					}else
					{
						$totalHours = "00:00:00";
						echo $totalHours;
					}
				}else if($emp_timeout <= $schedule_time_out)
				{
					$getTotalHours = $timesheetDAO->getTotalHours($emp_timeout, $emp_timein);

					$totalHours = $getTotalHours[0]['totalHours'];

					if($totalHours <= "00:00:00")
					{
						$totalHours = "00:00:00";
						echo $totalHours;
					}else
					{
						echo $totalHours;
					}
				}else
				{
					$getTotalHours = $timesheetDAO->getTotalHours($emp_timeout, $emp_timein);
					
					$totalHours = $getTotalHours[0]['totalHours'];
					echo $totalHours;
				}						
				
			}else
			{
				$totalHours = "00:00:00";
				echo $totalHours;
			}
				
		}
		else if($emp_timeout == NULL) {

			//echo $totalHours;
			if($emp_timein >= $schedule_time_in)
			{
				$getTotalHours = $timesheetDAO->getTotalHours($emp_timein, $emp_timeout);

				if($getTotalHours[0]['totalHours'] > "00:00:00") {
					$totalHours = $getTotalHours[0]['totalHours'];
					echo $totalHours;
				}else if($getTotalHours[0]['totalHours'] <= "00:00:00")
				{
					$totalHours = "00:00:00";
					echo $totalHours;
				}else
				{
					$totalHours = "00:00:00";
					echo $totalHours;
				}

			}else if($emp_timein == NULL && $emp_timein < $schedule_time_in)
			{
				//$totalHours = "00:00:00";
				$totalHours = "00:00:00";
				echo $totalHours;
			}else if($emp_timein <> NULL && $emp_timeout <> NULL ){
				$totalHours = "00:00:00";
				echo $totalHours;
			}else if($is_holiday == 1 && $emp_timein <> NULL)
			{
				$totalHours = "08:00:00";
				echo $totalHours;
			}else{
				$totalHours = "00:00:00";
				echo $totalHours;
			}

		}
		else

		{
			$totalHours = "00:00:00";
		}
		echo "</td>";
		
		
		
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
		foreach ($getDateDiff as $keyDate => $valDate)
		{
			if($valDate['totalDate'] >= 0)
			{
				$getLeaveCoverage = $timesheetDAO->getLeaveCoverage($_SESSION['emp_id'],$getDtrDate);


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
				
				if($excessTime > "00:00:00" && $getLeaveCoverage == false)
				{
					$otMsg = "Overtime, ";
					echo $otMsg;
				}


				if($emp_timein == "00:00:00" && $emp_timeout == NULL)
				{
					$absentMsg = "Absent";
					echo $absentMsg;
				}
				else
				{
				
					if($valDTRMo['day'] >= 10)
					{
						$getDtrDate = $valDTRMo['year'] . "-" . $valDTRMo['month'] . "-" . $valDTRMo['day'];
					}else
					{
						$getDtrDate = $valDTRMo['year'] . "-" . $valDTRMo['month'] . "-0" . $valDTRMo['day'];

					}



					// print_r($getLeaveCoverage);
					foreach($getLeaveCoverage as $keyLC => $valLC)
					{
						// echo $valLC['date_from'];
						// echo $valLC['leave_application_id'];
						$getLeave = $timesheetDAO->getLeave($valLC['leave_application_id']);

						foreach($getLeave as $keyLeave => $valLeave)
						{
							// echo $valLeave['status_id'];
							$leaveStatus = $valLeave['status_id'];
							$leavemsg = "";
							if($leaveStatus == 2)
							{
								$leavemsg = "Leave Approved!";
								echo $leavemsg;

							}else if($leaveStatus == 1)
							{
								$leavemsg = "Pending Leave";
								echo $leavemsg;

							}else if($leaveStatus == 3)
							{
								$leavemsg = "Leave Disapproved";
								echo $leavemsg;
							}
							{
								echo "";
							}
						}
					}
				
				}//end else
				// if()
			}
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
<?php include_once "footer.php" ?>
<?php
$custompage->Page_Terminate();
?>
