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

<!-- ================================================
Sweet Alert
================================================ -->
<script src="js/sweet-alert/sweet-alert.min.js"></script>

<!-- ================================================
Kode Alert
================================================ -->
<script src="js/kode-alert/main.js"></script>

<?php if (@$gsExport == "" || @$gsExport == "print") { ?>
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
<?php } ?>

<?php if (@$gsExport == "") { ?>
<link rel="stylesheet" href="phpcss/jquery.fileupload-ui.css">
<?php } ?>
	
  <!-- ========== Css Files ========== -->
  <link href="css/root.css" rel="stylesheet">
  
<?php if (@$gsExport == "" || @$gsExport == "print") { ?>
<link rel="stylesheet" type="text/css" href="<?php echo EW_PROJECT_STYLESHEET_FILENAME ?>">

<?php if (ew_IsMobile()) { ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="phpcss/ewmobile.css">
<?php } ?>
<?php if (@$gsExport == "print" && @$_GET["pdf"] == "1" && EW_PDF_STYLESHEET_FILENAME <> "") { ?>
<link rel="stylesheet" type="text/css" href="<?php echo EW_PDF_STYLESHEET_FILENAME ?>">
<?php } ?>
<script type="text/javascript" src="<?php echo ew_jQueryFile("jquery-%v.min.js") ?>"></script>
<?php if (ew_IsMobile()) { ?>
<link rel="stylesheet" type="text/css" href="<?php echo ew_jQueryFile("jquery.mobile-%v.min.css") ?>">
<script type="text/javascript">
jQuery(document).bind("mobileinit", function() {
	jQuery.mobile.ajaxEnabled = false;
	jQuery.mobile.ignoreContentEnabled = true;
});
</script>
<script type="text/javascript" src="<?php echo ew_jQueryFile("jquery.mobile-%v.min.js") ?>"></script>
<?php } ?>
<?php } ?>
<?php if (@$gsExport == "") { ?>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
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
var EW_UPLOAD_ALLOWED_FILE_EXT = "gif,jpg,jpeg,bmp,png,doc,xls,pdf,zip"; // Allowed upload file extension

// Ajax settings
var EW_LOOKUP_FILE_NAME = "ewlookup10.php"; // Lookup file name
var EW_AUTO_SUGGEST_MAX_ENTRIES = <?php echo EW_AUTO_SUGGEST_MAX_ENTRIES ?>; // Auto-Suggest max entries

// Common JavaScript messages
var EW_DISABLE_BUTTON_ON_SUBMIT = true;
var EW_IMAGE_FOLDER = "phpimages/"; // Image folder
var EW_UPLOAD_URL = "<?php echo EW_UPLOAD_URL ?>"; // Upload url
var EW_UPLOAD_THUMBNAIL_WIDTH = <?php echo EW_UPLOAD_THUMBNAIL_WIDTH ?>; // Upload thumbnail width
var EW_UPLOAD_THUMBNAIL_HEIGHT = <?php echo EW_UPLOAD_THUMBNAIL_HEIGHT ?>; // Upload thumbnail height
var EW_USE_JAVASCRIPT_MESSAGE = false;
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

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<!--<meta name="generator" content="PHPMaker v10.0.1">-->


<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Kode is a Premium Bootstrap Admin Template, It's responsive, clean coded and mobile friendly">
  <meta name="keywords" content="bootstrap, admin, dashboard, flat admin template, responsive," />
  <title>HRIS</title>


</head>
<body>

<!-- Start Page Loading -->
  <div class="loading"><img src="img/loading.gif" alt="loading-img"></div>
  <!-- End Page Loading -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 
  <!-- START TOP -->
  <div id="top" class="clearfix">

  	<!-- Start App Logo -->
  	<div class="applogo">
  		<a href="#" class="logo">GRAC-TA BUILDERS</a>
  	</div>
	<br/>
  	<!-- End App Logo -->

    <!-- Start Sidebar Show Hide Button -->
    <a href="#" class="sidebar-open-button"><i class="fa fa-bars"></i></a>
    <a href="#" class="sidebar-open-button-mobile"><i class="fa fa-bars"></i></a>
    <!-- End Sidebar Show Hide Button -->

  </div>
  <!-- END TOP -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 


<!-- //////////////////////////////////////////////////////////////////////////// --> 
<!-- START SIDEBAR -->
<div class="sidebar clearfix">

<ul class="sidebar-panel nav">

	<?php
		//carla
		
		$user_level = CurrentUserLevel();
		
		if (IsLoggedIn()) {
			
			if($user_level == 2) //employee access
			{
			?>
				<li><a href="tbl_employeelist.php"><span class="icon color8"><i class="fa fa-users"></i></span>My Details</a></li>
				<li><a href="emp_timesheet.php"><span class="icon color8"><i class="fa fa-calendar"></i></span>Time Sheet</a></li>
				<li><a href="tbl_employee_leaveapplicationlist.php"><span class="icon color8"><i class="fa fa-sheqel"></i></span>Leave Application</a></li>
			<?php
				
			}
			if($user_level == "-1") //admin access
			{
				?>
					<li><a href="tbl_employeelist.php"><span class="icon color8"><i class="fa fa-users"></i></span>Employee List</a></li>
					
					<li><a href="tbl_employee_leaveapplicationlist.php"><span class="icon color8"><i class="fa fa-sheqel"></i></span>Leave Application List</a></li>
					
					<li><a href="payroll_process.php"><span class="icon color8"><i class="fa fa-money"></i></span>Payroll</a></li>
					<li><a href="lib_holidaylist.php"><span class="icon color8"><i class="fa fa-codepen"></i></span>Holiday Management</a></li>
					<li><a href="#"><span class="icon color9"><i class="fa fa-calendar"></i></span>Daily Timesheet Record<span class="caret"></span></a>
					<ul>
					  <li><a href="create_dtr.php">Create DTR</a></li>
					  <li><a href="emp_timesheet_admin.php">DTR of Employees</a></li>
					</ul>
				  </li>
					
					<li><a href="#"><span class="icon color9"><i class="fa fa-database"></i></span>Libraries<span class="caret"></span></a>
					<ul>
					  <li><a href="lib_deductionlist.php">Deductions</a></li>
					  <li><a href="lib_leavelist.php">Leave Types</a></li>
					  <li><a href="lib_salarylist.php">Salary</a></li>
					  <li><a href="lib_sexlist.php">Sex</a></li>
					  <li><a href="lib_tax_categorylist.php">Tax Category</a></li>
					</ul>
				  </li>
				  
				  
				  <li><a href="#"><span class="icon color9"><i class="fa fa-eye"></i></span>User Controls<span class="caret"></span></a>
					<ul>
					  <li><a href="tbl_userlist.php">Users</a></li>
					  <!--<li><a href="userlevelslist.php">Userlevels</a></li>
					  <li><a href="userlevelpermissionslist.php">User Level Permission</a></li>-->
					  <li><a href="audittraillist.php">Auditrail</a></li>
					</ul>
				  </li>
				  
				  
		<?php 		
			}// end of admin
			
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


</div>
<!-- END SIDEBAR -->
<!-- //////////////////////////////////////////////////////////////////////////// --> 


 <!-- //////////////////////////////////////////////////////////////////////////// --> 
<!-- START CONTENT -->
<div class="content">

 <!-- //////////////////////////////////////////////////////////////////////////// --> 
<!-- START CONTAINER -->
<div class="container-padding">


  
  <!-- Start Row -->
  <div class="row">

    <div class="col-md-12">
      <div class="panel panel-default">

        <div class="panel-title">
          
          <ul class="panel-tools">
            <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
            <li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
            <!--<li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>-->
          </ul>
        </div>

            <div class="panel-body">
              



 <!-- //////////////////////////////////////////////////////////////////////////// --> 

<!-- //////////////////////////////////////////////////////////////////////////// --> 


<?php /*

<?php if (@$gsExport == "" || @$gsExport == "print") { ?>
<?php if (ew_IsMobile()) { ?>
<div data-role="page">
	<div data-role="header">
		<a href="mobilemenu.php"><?php echo $Language->Phrase("MobileMenu") ?></a>
		<h1 id="ewPageTitle"></h1>
	<?php if (IsLoggedIn()) { ?>
		<a href="logout.php"><?php echo $Language->Phrase("Logout") ?></a>
	<?php } elseif (substr(ew_ScriptName(), 0 - strlen("login.php")) <> "login.php") { ?>
		<a href="login.php"><?php echo $Language->Phrase("Login") ?></a>
	<?php } ?>
	</div>
<?php } ?>
<?php } ?>
<?php if (@!$gbSkipHeaderFooter) { ?>
<?php if (@$gsExport == "") { ?>
<div class="ewLayout">
<?php if (!ew_IsMobile()) { ?>
	<!-- header (begin) --><!-- *** Note: Only licensed users are allowed to change the logo *** -->
  <div id="ewHeaderRow" class="ewHeaderRow"><img src="phpimages/hris.png" alt="" style="border: 0;">	</div>
	<!-- header (end) -->
<?php } ?>
<?php if (ew_IsMobile()) { ?>
	<div data-role="content" data-enhance="false">
	<table id="ewContentTable" class="ewContentTable">
		<tr>
<?php } else { ?>
	<!-- content (begin) -->
	<table id="ewContentTable" cellspacing="0" class="ewContentTable">
		<tr><td id="ewMenuColumn" class="ewMenuColumn">
			<!-- left column (begin) -->
<?php include_once "ewmenu.php" ?>
			<!-- left column (end) -->
		</td>
<?php } ?>
		<td id="ewContentColumn" class="ewContentColumn">
			<!-- right column (begin) -->
				<p class="ewSiteTitle"><?php echo $Language->ProjectPhrase("BodyTitle") ?></p>
<?php } ?>
<?php } ?>
*/ ?>
<table>
							<?php 
								// foreach ($_SESSION as $key => $value) {
									   // echo "<tr>";
									   // echo "<td>[".$key."] = ".$value."</td>";
									   // echo "</tr>";
								// } 
							?>
						</table>
