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
<?php include_once "model/timesheetAdminDAO.php" ?>
<?php include_once "model/calculateDTRDAO.php" ?>
<?php include_once "model/createDTRDAO.php" ?>
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
<?php //include_once "header.php" ?>
<?php
$custompage->ShowMessage();
?>
<!-- Put your custom html here -->

<?php
$timesheetDAO = new timesheetDAO();
$calculateDTRDAO = new calculateDTRDAO();
$createDTRDAO = new createDTRDAO();

$getDistinctEmp = $calculateDTRDAO->getDistinctEmp();
// print_r($getDistinctEmp);
foreach($getDistinctEmp as $keyDemp => $valDEmp)
{

$emp_id = $valDEmp['emp_id'];
$getSchedByEmp = $timesheetDAO->getSchedByEmp($emp_id);
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
					//echo $dateToday;

					$dateYear = $getDateToday[0]['dateYear'];
					$dateMonth = $getDateToday[0]['dateMonth'];
					$dateDay = $getDateToday[0]['dateDay'];
					// $day = 21;
					$day = $dateDay;


					//$digitalClock = $clock->jsDigitalClock(300, 300);
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

                            $getDTR = $timesheetDAO->getDTRPerDAY($emp_id,$month,$day,$dateYear);
                            if($getDTR == true)
                            {
                                foreach($getDTR as  $keyDTR => $valDTR)
                                {
                                    $getTime = $timesheetDAO->getTime();

                                    echo "<form method = 'GET'>";
                                    echo "<input type = 'hidden' id='txtTimeIn' name='txtTimeIn' value = '".$getTime[0]["time"]."'/ >";

                                    echo "<input type = 'hidden' id='txtTimeOut' name='txtTimeOut' value = '".$getTime[0]["time"]."'/ >";

                                    //$emp_id = $_SESSION['emp_id'];
                                    $emp_timein = $_GET["txtTimeIn"];
                                    $emp_timeout = 'NULL';
                                    $emp_totalhours = "0";
                                    $emp_late = "0";
                                    $emp_excesstime = "0";
                                    $emp_undertime = "0";
                                    $dtr_id = $valDTR['dtr_id'];

                                    // echo "dtr_id=>".$dtr_id;

                                    ?>

                                    </form>
                                    <?php


                                }

                            }else{

                                // echo "NO DTR";
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

				// $getDTRofMonth = $timesheetDAO->getDTRofMonth($emp_id,$month_val, $dateYear,$dateDay);
				$getDTRofMonth = $timesheetDAO->getDTRPerDAY($emp_id,$month_val,$dateDay, $dateYear);
				
				

				?>

<table class = "table table-hover">
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
				$updateDtrHoliday = $timesheetDAO->updateDtrHoliday($valDTRMo['month'],$valDTRMo['day'],$valDTRMo['year'],$is_holiday);
			}else
			{
				echo "";
				$is_holiday = "0";
				$updateDtrHoliday = $timesheetDAO->updateDtrHoliday($valDTRMo['month'],$valDTRMo['day'],$valDTRMo['year'],$is_holiday);
			}
			echo "</td>";

			if($valDTRMo['day'] >=10)
			{

				$dateTodayLog = $valDTRMo['year'] . "-" . $valDTRMo['month'] ."-".$valDTRMo['day'];

			}else{
				$dateTodayLog = $valDTRMo['year'] . "-" . $valDTRMo['month'] ."-0".$valDTRMo['day'];
			}

			//timeIN
			$getTimeLogOfDay = $timesheetDAO->getTimeLogOfDay($emp_id, $valDTRMo['dtr_id']);

			echo "<td>";
			if($getTimeLogOfDay[0]["emp_timein"] <> NULL )
			{
				/*$emp_timein =  $getTimeLogOfDay[0]["emp_timein"];*/

				$emp_timeVal = date_create($getTimeLogOfDay[0]["emp_timein"]);
				$emp_timein = date_format($emp_timeVal,"H:i");
				echo $emp_timein;


				$emp_create_date = date_create($emp_timein);
				$emp_new_format = date_format($emp_create_date,"h:i A");
				//echo $emp_new_format;
				// echo $emp_timein;

			}else if ($getTimeLogOfDay[0]["emp_timein"] == NULL)
			{
				$emp_timein = "00:00:00";
				echo $emp_timein;
			}else
			{
				//echo $noLogsFound;
				$emp_timein = "00:00:00";
				echo $emp_timein;
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
				//echo $emp_timeoutnew_format;
				echo $emp_timeout;



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
			
			//carla
			echo "<td>";
			if($schedule_id <> 3)
			{
				// echo $schedule_id;
				include "emp_totalhours_nomandatory_hours_calculate.php";
			}
			else
			
			{
				//night shift begin
				include "emp_totalhours_nomandatory_hours_night.php";
				//night shift end totalHoursNoBreak
			}
				
				
			echo "</td>";

			echo "<td>";
			if($schedule_id == "3")
			{
				include "emp_dtr_totalhours_night.php";
			}
			else
			{
			
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
						//echo $totalHours;
						// $getTotalHours = $timesheetAdmin->getTotalHours($emp_timeout, $schedule_time_in);
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
							$totalHours = "00:00:00";
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
				echo $totalHours;
			}
			
			}
			echo "</td>";



			//LATE COMPUTATION
			echo "<td>";
			include "emp_dtr_totalLate_night.php";
			echo "</td>";
			
			
			//undertime
			echo "<td>";
			include "emp_dtr_totalUndertime_night.php";
			echo "</td>";

			//excessTime


			echo "<td>";
			include "emp_dtr_totalExcess_night.php";
			echo "</td>";

			echo "<td>";

			// echo $emp_timein;
			// echo $emp_timeout;
			$undertimeMsg = "";
			$lateMsg = "";
			$absentMsg = "";
			$dateNow = date("Y-m-d");
			
			foreach ($getDateDiff as $keyDate => $valDate)
			{
				if($valDate['totalDate'] >= 0)
				{
					


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

					if($valDTRMo['day'] >= 10)
					{
						$getDtrDate = $valDTRMo['year'] . "-" . $valDTRMo['month'] . "-" . $valDTRMo['day'];
					}else
					{
						$getDtrDate = $valDTRMo['year'] . "-" . $valDTRMo['month'] . "-0" . $valDTRMo['day'];

					}
					
					$getLeaveCoverage = $timesheetDAO->getLeaveCoverage($emp_id,$getDtrDate);
					
					

					if($emp_timein == "00:00:00" && $emp_timeout == NULL && $is_holiday == 1)
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
						$absentMsg = "Absent";
						echo $absentMsg;
					}
				}

					else
					{

						// i



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
								}else if($emp_timein == "00:00:00" && $emp_timeout == NULL && $dateNow == $getDtrDate)
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
					// if()
				}
				//$mysqli = new mysqli(EW_CONN_HOST,EW_CONN_USER,EW_CONN_PASS,EW_CONN_DB);
				// if()
				$url1=$_SERVER['REQUEST_URI'];
				header("Refresh: 1; URL=$url1");
				//carla

		$dateLessNow = $dateDay - 1;
		if($dateLessNow <= 9)
		{
			$dateLessNow = "0".$dateLessNow;
			if($dateLessNow == 0)
			{
				echo $month_val;
				 $month_val = $month_val - 1;
				 	if($month_val <= 9)
				 	{
				 		$month_val = "0".$month_val;
				 	}else
				 	{
				 		$month_val = $month_val;
				 	}

				if($month_val > 6 && $month_val < 9)
				{
					 if($month_val % 2 == true )
					 {
					 	
					 	$dateLessNow = "31"; 
					 }else
					 {
					 	
					 	if($month_val == 8)
						{
											 	
							 	$dateLessNow = "31"; 
							 
						}else
						{
							$dateLessNow = "30"; 

						}
					 }
				}else if($month_val == 7)
				{
									 	
					 	$dateLessNow = "31"; 
					 
				}
				
				else if($month_val > 8)
				{
					 if($month_val % 2 == true )
					 {
					 	
					 	$dateLessNow = "30"; 
					 }else
					 {
					 	
					 	$dateLessNow = "31"; 
					 }
				}

				
				// echo "";
			}
		}else
		{
			$dateLessNow = $dateLessNow;
		}

		$dateYesterday = $dateYear."-".$month_val."-".$dateLessNow;
		$dateCreateYesterday = date_create($dateYesterday);
		$dateCreateYesterdayFormat = date_format($dateCreateYesterday,"l");

		// echo "is_holiday=". $is_holiday;
		// echo "dtr_id=". $dtr_id;

		if($dateDay == "01")
		{
			$prevMonth = $dateMonth - 1;	
		}else
		{
			$prevMonth = $dateMonth;
		}
		
		$getDTR = $timesheetDAO->getDTR($emp_id,$dateMonth,$dateDay,$dateYear);
		// echo "<br/>";
		$getDTRIfAbsent = $timesheetDAO->getDTR($emp_id,$prevMonth,$dateLessNow,$dateYear);
		$dtr_idAbsent = $getDTRIfAbsent[0]['dtr_id'];
		$dtr_idToday = $getDTR[0]['dtr_id'];

		if($is_holiday == 1)
		{
			$emp_weekend = "00:00:00";
			$emp_timein = "NULL";
			$emp_timeout = "NULL";
			$emp_totalhours = "08:00:00";
			$saveTimeIN = $timesheetDAO->saveAbsent($emp_id,$emp_timein,$emp_timeout, $emp_totalhours,$emp_late,$emp_excesstime,$emp_undertime,$dtr_idToday);

		}else
		{

			if($dateCreateYesterdayFormat == "Saturday" || $dateCreateYesterdayFormat == "Sunday")
			{
				$emp_weekend = "08:00:00";
			}else
			{
				$emp_weekend = "00:00:00";
			}
		}

			//carla

				$autoUpdateLogs = $calculateDTRDAO->autoUpdateLogs($emp_id,$valDTRMo['dtr_id'],$totalHours,$totalLate,$excessTime,$totalUnderTime,$emp_weekend);
				//if($mysql_affected_rows == 0)
				if($autoUpdateLogs == 1)
				{
					// echo "Records inserted !";
				}else
				{
					// echo "No Records inserted";
				}

			}
			echo "</td>";
			
			echo "<td>";
			// echo "UPDATE TBL_employee_timelog SET EMP_TOTALHOURS = '".$totalHours."' , EMP_LATE = '".$totalLate."', EMP_EXCESSTIME = '".$excessTime."', EMP_UNDERTIME = '".$totalUnderTime."' WHERE dtr_id = ".$valDTRMo['dtr_id'].";";
			echo "</td>";
			echo "</tr>";
		}
		echo "emp_id =>".$emp_id."<br/>";
		echo "schedule_id=>". $schedule_id."<br/>";

		
		

		echo "Date Yesterday => ".$dateYesterday.", ".$dateCreateYesterdayFormat."<br/>";
		echo "Date Today => ".$dateToday."<br/>";
		// echo "month=>".$dateMonth;
		// if($dateDay == "01")
		// {
		// 	$prevMonth = $dateMonth - 1;	
		// }else
		// {
		// 	$prevMonth = $dateMonth;
		// }
		
		// $getDTR = $timesheetDAO->getDTR($emp_id,$dateMonth,$dateDay,$dateYear);
		// // echo "<br/>";
		// $getDTRIfAbsent = $timesheetDAO->getDTR($emp_id,$prevMonth,$dateLessNow,$dateYear);
		// $dtr_idAbsent = $getDTRIfAbsent[0]['dtr_id'];
		// $dtr_idToday = $getDTR[0]['dtr_id'];

		echo "DTR_ID_Today=>".$dtr_idToday;
		echo "<br/>";
		echo "DTR_ID_Yesterday=>".$dtr_idAbsent;


		echo "<br/>";
		$getTimeLogOfDay =  $timesheetDAO->getTimeLogOfDay($emp_id,$getDTRIfAbsent[0]['dtr_id']);

		$getTimeLogOfDaySave =  $timesheetDAO->getTimeLogOfDay($emp_id,$dtr_idToday);
		print_r($getTimeLogOfDaySave);
		echo "<br/>";
		if($dtr_idAbsent <> 0)
		{
		if(!$getTimeLogOfDay)
		{

			if($dateCreateYesterdayFormat == "Saturday" || $dateCreateYesterdayFormat == "Sunday")
			{

				echo "Weekend";
				$emp_timeinAbsent = "NULL";
				$emp_timeoutAbsent = "NULL";
				$emp_totalhoursAbsent = "00:00:00";
				$emp_lateAbsent = "00:00:00";
				$emp_excesstimeAbsent = "00:00:00";
				$emp_undertimeAbsent = "00:00:00";
				$emp_weekend = "08:00:00";

				$saveWeekend = $timesheetDAO->saveWeekend($emp_id,$emp_timeinAbsent,$emp_timeoutAbsent,$emp_totalhoursAbsent,$emp_lateAbsent,$emp_excesstimeAbsent,$emp_undertimeAbsent,$emp_weekend,$dtr_idAbsent);
			}
			else
			{
				echo "Weekday=>";
				echo "array is null";
				$emp_timeinAbsent = "NULL";
				$emp_timeoutAbsent = "NULL";
				$emp_totalhoursAbsent = "00:00:00";
				$emp_lateAbsent = "08:00:00";
				$emp_excesstimeAbsent = "00:00:00";
				$emp_undertimeAbsent = "00:00:00";

				$saveAbsent = $timesheetDAO->saveAbsent($emp_id,$emp_timeinAbsent,$emp_timeoutAbsent,$emp_totalhoursAbsent,$emp_lateAbsent,$emp_excesstimeAbsent,$emp_undertimeAbsent,$dtr_idAbsent);
			}
			//carla

		}else
		{
			echo "Weekday=>";
			echo "with";
			//print_r($getTimeLogOfDay);
		}

		}

		/*echo "<br/>";
		echo $month_val."-".$dateLessNow."-".$dateYear;*/
		//print_r($getDTRIfAbsent);

		}//getDistinctEmp
		?>
	</tbody>
</table>
<?php //include_once "footer.php" ?>
<?php
$custompage->Page_Terminate();
?>
