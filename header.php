<?php

// Compatibility with PHP Report Maker
if (!isset($Language)) {
	include_once "ewcfg10.php";
	include_once "ewshared10.php";
	$Language = new cLanguage();
}
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $Language->ProjectPhrase("BodyTitle") ?></title>
<?php if (@$gsExport == "" || @$gsExport == "print") { ?>
<!-- <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css"> -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="assets/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="assets/css/font-awesome.min.css">
		<!-- <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300"> -->
		<link rel="stylesheet" href="assets/css/google.css">
		<link rel="stylesheet" href="assets/css/ace.min.css">
		<link rel="stylesheet" href="assets/css/ace-rtl.min.css">
		<link rel="stylesheet" href="assets/css/ace-skins.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap-datetimepicker.min.css">
		<script src="assets/js/ace-extra.min.js"></script>
		
		<?php 
		$pageparts = explode(".",ew_CurrentPage());
		$page = str_replace("TBL_","",str_replace("LIB_","",strtoupper($pageparts[0])));
		?>
		<?php if($page == "DTR_ADJUSTMENTS_FORM" || $page = "PAD_EMPLOYEE_DTREDIT"){ ?>
		<script type="text/javascript"
		 src="js/jquery.min.js">
		</script> 
		<script type="text/javascript"
		 src="assets/js/bootstrap-datetimepicker.min.js">
		</script>
		<?php } ?>
<?php } ?>
<?php if (@$gsExport == "") { ?>
<link rel="stylesheet" href="phpcss/jquery.fileupload-ui.css">
<?php } ?>
<?php if (@$gsExport == "" || @$gsExport == "print") { ?>
<link rel="stylesheet" type="text/css" href="<?php echo EW_PROJECT_STYLESHEET_FILENAME ?>">
<?php if (@$gsExport == "print" && @$_GET["pdf"] == "1" && EW_PDF_STYLESHEET_FILENAME <> "") { ?>
<link rel="stylesheet" type="text/css" href="<?php echo EW_PDF_STYLESHEET_FILENAME ?>">
<?php } ?>
<script type="text/javascript" src="<?php echo ew_jQueryFile("jquery-%v.min.js") ?>"></script>
<?php } ?>
<?php if (@$gsExport == "") { ?>
<script type="text/javascript" src="jqueryfileupload/jquery.ui.widget.js"></script>
<script type="text/javascript" src="jqueryfileupload/jqueryfileupload.min.js"></script>
<link href="calendar/calendar.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="calendar/calendar.min.js"></script>
<script type="text/javascript" src="calendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="calendar/calendar-setup.js"></script>
<script type="text/javascript" src="phpjs/ewcalendar.js"></script>
<script type="text/javascript">
var EW_LANGUAGE_ID = "<?php echo $gsLanguage ?>";
var EW_DATE_SEPARATOR = "/" || "/"; // Default date separator
var EW_DECIMAL_POINT = "<?php echo $DEFAULT_DECIMAL_POINT ?>";
var EW_THOUSANDS_SEP = "<?php echo $DEFAULT_THOUSANDS_SEP ?>";
var EW_MAX_FILE_SIZE = <?php echo EW_MAX_FILE_SIZE ?>; // Upload max file size
var EW_UPLOAD_ALLOWED_FILE_EXT = "gif,jpg,jpeg,bmp,png,doc,xls,pdf,zip,tiff,xlsx,docx,pptx,ppt"; // Allowed upload file extension

// Ajax settings
var EW_LOOKUP_FILE_NAME = "ewlookup10.php"; // Lookup file name
var EW_AUTO_SUGGEST_MAX_ENTRIES = <?php echo EW_AUTO_SUGGEST_MAX_ENTRIES ?>; // Auto-Suggest max entries

// Common JavaScript messages
var EW_DISABLE_BUTTON_ON_SUBMIT = true;
var EW_IMAGE_FOLDER = "phpimages/"; // Image folder
var EW_UPLOAD_URL = "<?php echo EW_UPLOAD_URL ?>"; // Upload url
var EW_UPLOAD_THUMBNAIL_WIDTH = <?php echo EW_UPLOAD_THUMBNAIL_WIDTH ?>; // Upload thumbnail width
var EW_UPLOAD_THUMBNAIL_HEIGHT = <?php echo EW_UPLOAD_THUMBNAIL_HEIGHT ?>; // Upload thumbnail height
var EW_USE_JAVASCRIPT_MESSAGE = true;
<?php if (ew_IsMobile()) { ?>
var EW_IS_MOBILE = true;
<?php } else { ?>
var EW_IS_MOBILE = false;
<?php } ?>
</script>
<?php } ?>
<?php if (@$gsExport == "" || @$gsExport == "print") { ?>
<script type="text/javascript" src="phpjs/jsrender.min.js"></script>
<script type="text/javascript" src="phpjs/ewp10.js"></script>
<?php } ?>
<?php if (@$gsExport == "") { ?>
<script type="text/javascript" src="phpjs/userfn10.js"></script>
<script type="text/javascript">
<?php echo $Language->ToJSON() ?>
</script>
<script type="text/javascript">
function printPage(id)
{
   var html="<html>";
   html+= document.getElementById(id).innerHTML;
   html+="</html>";

   var printWin = window.open('','','left=0,top=0,width=800,height=800,toolbar=0,scrollbars=0,status=0');
   printWin.document.write(html);
   printWin.document.close();
   printWin.focus();
   printWin.print();
   printWin.close();
}
</script>

<?php } ?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="<?php echo ew_ConvertFullUrl("dswd1.ico") ?>">
<link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo ew_ConvertFullUrl("dswd1.ico") ?>"> -->
<link rel="shortcut icon" href="phpimages/dswdfavicon.png"/>
</head>
<body>
<div class="navbar navbar-default" id="navbar">
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>
			<div class="navbar-container" id="navbar-container">
				<div class="navbar-header pull-left">
					<a href="#" class="navbar-brand">
						<small>
							<i class="icon-gear"></i>
							<?php echo $Language->ProjectPhrase("BodyTitle") ?>
						</small>
					</a><!-- /.brand -->
				</div><!-- /.navbar-header -->
				<div class="navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
					<!-- Begin nav messages -->
						<?php // include_once('nav_menu.php'); //comment out to reactivate nav menu (notifications) ?>
					<!-- End nav messages -->
						<li class="light-blue">
							<?php if(IsLoggedIn()){?>
								<a data-toggle="dropdown" href="#" class="dropdown-toggle">
									<img class="nav-user-photo" src="empPhoto.php?staffid=<?php echo CurrentUserID(); ?>" alt="<?php echo CurrentUserName();?>">
									<span class="user-info">
										<small>Welcome,</small>
										<?php echo CurrentUserName();?>
									</span>
									<i class="icon-caret-down"></i>
								</a>
								<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
									<li>
										<a href="#">
											<i class="icon-cog"></i>
											Settings
										</a>
									</li>
									<li>
										<a href="profile.php">
											<i class="icon-user"></i>
											Profile
										</a>
									</li>
									<li class="divider"></li>
									<li>
										<a href="logout.php">
											<i class="icon-off"></i>
											Logout
										</a>
									</li>
							<?php }else{?>
									<li>
										<a href="login.php">
											<i class="icon-user"></i>
											Not Logged
										</a>
									</li>
							<?php } ?>
							</ul>
						</li>
					</ul><!-- /.ace-nav -->
				</div><!-- /.navbar-header -->
			</div><!-- /.container -->
		</div>
		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>
			<div class="main-container-inner">
				<a class="menu-toggler" id="menu-toggler" href="#">
					<span class="menu-text"></span>
				</a>
				<div class="sidebar" id="sidebar">
					<script type="text/javascript">
						try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
					</script>
					
					<ul class="nav nav-list">
					<?php
					
					$user_level = CurrentUserLevel();
					if(IsLoggedIn())
					{
						
						if($user_level == 2) //employee access
						{
					?>
						<li><a href="tbl_employeelist.php"><span class="icon color8"><i class="fa fa-users"></i></span>My Details</a></li>
						<li><a href="emp_timesheet_n.php"><span class="icon color8"><i class="fa fa-calendar"></i></span>Time Sheet</a></li>
						<li><a href="leave_application_u.php"><span class="icon color8"><i class="fa fa-sheqel"></i></span>Leave Application</a></li>
					
					<?php
						}//employee
						else
						{
							
					?>
						<!--<li><a href="tbl_employeelist.php"><span class="icon color8"><i class="fa fa-users"></i></span>Employee List</a></li>-->
						<li><a href="tbl_employee_detailslist.php"><span class="icon color8"><i class="fa fa-users"></i></span>Employee List</a></li>
					
					<li><a href="leave_application_list.php"><span class="icon color8"><i class="fa fa-sheqel"></i></span>Leave Application List</a></li>
					<!--<li><a href="tbl_employee_leaveapplicationlist.php"><span class="icon color8"><i class="fa fa-sheqel"></i></span>Leave Application List</a></li>-->
					
					<li><a href="payroll_process.php"><span class="icon color8"><i class="fa fa-money"></i></span>Payroll</a></li>
					<li><a href="lib_holiday_a_list.php"><span class="icon color8"><i class="fa fa-codepen"></i></span>Holiday / OT Management</a></li>
					<li><a href="#" class="dropdown-toggle"><span class="icon color9"><i class="fa fa-calendar"></i></span>Daily Timesheet Record<span class="caret"></span></a>
					
					<ul class="submenu">
					  <li><a href="create_dtr.php" >Create DTR</a></li>
					  <li><a href="emp_timesheet_admin_n.php">DTR of Employees</a></li>
					</ul>
					
				  </li>
					
					<li><a href="#" class="dropdown-toggle"><span class="icon color9"><i class="fa fa-database"></i></span>Libraries<span class="caret"></span></a>
					
					<ul class="submenu">
					  <li><a href="lib_deductionlist.php">Deductions</a></li>
					  <li><a href="lib_leavelist.php">Leave Types</a></li>
					  <li><a href="lib_salarylist.php">Salary</a></li>
					  <li><a href="lib_sexlist.php">Sex</a></li>
					  <li><a href="lib_tax_categorylist.php">Tax Category</a></li>
					  <li><a href="lib_schedulelist.php">Schedule</a></li>
					  <li><a href="lib_joblist.php">Job Title</a></li>
					</ul>
					
				  </li>
				  
				  
				  <li><a href="#" class="dropdown-toggle"><span class="icon color9"><i class="fa fa-eye"></i></span>User Controls<span class="caret"></span></a>
				  
					<ul class="submenu">
					  <li><a href="tbl_userlist.php">Users</a></li>
					  <!--<li><a href="userlevelslist.php">Userlevels</a></li>
					  <li><a href="userlevelpermissionslist.php">User Level Permission</a></li>-->
					  <li><a href="audittraillist.php">Auditrail</a></li>
					</ul>
					
				  </li>
					<?php
						}//admin
						
					?>
					<li><a href="changepwd.php"><?php echo "Change Password"; ?><span class="icon color9"><i class = "fa fa-ellipsis-h"></i></span></a></li>
	<li><a href="logout.php"><?php echo $Language->Phrase("Logout") ?><span class="icon color9"><i class = "fa fa-exclamation"></i></span></a></li>
					<?php
					}else{
					?>	
					<li><a href="login.php"><?php echo $Language->Phrase("Login") ?></a></li>
					<?php
						}//end of else if loggedin
					?>
					</ul>
					
					
					
					<!--carla-->
					
					
					
					
					
					<!-- <div class="sidebar-collapse" id="sidebar-collapse">
						<i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
					</div> -->
					<script type="text/javascript">
						try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
					</script>
				</div>
				<div class="main-content">
					
			<div class="page-content">
						<div class="page-header">
							<h1>
							<?php if (IsLoggedIn()){?>
								
								<?php } else{ echo "Please Login";}?>
								
							</h1>
						</div><!-- /.page-header -->
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<div class="row">
									<div class="col-xs-12">
										<div class="table-responsive">
										
							<table>
							<?php 
								// foreach ($_SESSION as $key => $value) {
									   // echo "<tr>";
									   // echo "<td>[".$key."] = ".$value."</td>";
									   // echo "</tr>";
								// } 
							?>
						</table>

						<?php
						// $aaaa = $this->leave_application_id->CurrentValue;
						// echo "tbl_leavecoveragelist.php?showmaster=tbl_employee_leaveapplication&leave_application_id=".$aaaa;
						?>