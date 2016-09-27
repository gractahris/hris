<!DOCTYPE html>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "tbl_userinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php
include "model/DAO.php";
include "model/registerDAO.php";
?>
<html lang="en">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Kode is a Premium Bootstrap Admin Template, It's responsive, clean coded and mobile friendly">
  <meta name="keywords" content="bootstrap, admin, dashboard, flat admin template, responsive," />
  <title>GRAC-TA BUILDERS</title>
  
  <!-- ================================================
Sweet Alert
================================================ -->
<script src="js/sweet-alert/sweet-alert.min.js"></script>

<!-- ================================================
Kode Alert
================================================ -->
<script src="js/kode-alert/main.js"></script>

  <!-- ========== Css Files ========== -->
  <link href="css/root.css" rel="stylesheet">
  <style type="text/css">
    body{background: #F5F5F5;}
  </style>
  </head>
  <body>
<?php
$errorMsg = "";
if($_POST['btnRegister'] == 'btnRegister')
{
	
	if($_POST['username'] == "" || $_POST['username'] == NULL)
	{
		?>
		<script>
		
              swal("Enter Username");
            
		</script>
		<?php
	}
	
	if($_POST['firstName'] == "" || $_POST['firstName'] == NULL)
	{
		?>
		<script>
		
              swal("Enter First Name");
            
		</script>
		<?php
	}
	
	if($_POST['lastName'] == "" || $_POST['lastName'] == NULL)
	{
		?>
		<script>
		
              swal("Enter Last Name");
            
		</script>
		<?php
	}
	
	if($_POST['email'] == "" || $_POST['email'] == NULL)
	{
		?>
		<script>
		
              swal("Enter email");
            
		</script>
		<?php
	}
	
	if($_POST['password'] == "" || $_POST['password'] == NULL)
	{
		?>
		<script>
		
              swal("Enter password");
            
		</script>
		<?php
	}
	
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	$firstName = $_POST['firstName'];
	$midName = $_POST['midName'];
	$lastName = $_POST['lastName'];
	$extName = $_POST['extName'];
	$email = $_POST['email'];
	$position = "0";
	$designation = "0";
	$office_code = "0";
	$user_level = "0";
	$activate = "0";
	$profile = "0";
	$emp_id = "0";
	$contact_no = "0";
	// $username = $_POST[''];
	// $username = $_POST[''];
	
	// $sql = "INSERT INTO TBL_USER(username,password,email, firstName,middleName,surname,extensionname,position,designation,office_code, user_level, contact_no,activate,profile,emp_id)
	// VALUES('".$username."',
			// md5('".$password."'),
			// '".$email."',
			// '".$firstName."',
			// '".$midName."',
			// '".$lastName."',
			// '".$extName."',
			// '".$position."',
			// '".$designation."',
			// '".$office_code."',
			// '".$user_level."',
			// '".$contact_no."',
			// '".$activate."',
			// '".$profile."',
			// '".$emp_id."')";
			// echo $sql;
			
			$registerDAO = new registerDAO();
			$saveUserData = $registerDAO->saveUserData($username,$password,$email, $firstName,$midName,$lastName,$extName,$position,$designation,$office_code,$user_level,$contact_no,$activate,$profile,$emp_id);
			
		if($saveUserData == true)
		{
			?>
			<script>
		
              swal("Registration Succeeded");
            
			</script>
			<?php
		}else
		{
			?>
			<script>
		
              swal("Duplicate Entry");
            
			</script>
			<?php
		}
}

?>
    <div class="login-form">
	<?php
		if($saveUserData == true)
		{
			echo "<form method = 'POST' action= 'login.php'>";
		}else
		{
			echo "<form method = 'POST' action= 'register.php'>";
		}
	?>
      
        <div class="top">
          <h1>Register</h1>
        </div>
        <div class="form-area">
		  <div class="group">
            <input type="text" id="firstName" name="firstName" class="form-control" placeholder="First Name *">
            <i class="fa fa-user"></i>
          </div>
		  
		  <div class="group">
            <input type="text" id="midName" name="midName" class="form-control" placeholder="Middle Name">
            <i class="fa fa-user"></i>
          </div>
		  
		  <div class="group">
            <input type="text" id="lastName" name="lastName" class="form-control" placeholder="Last Name *">
            <i class="fa fa-user"></i>
          </div>
		  
		  <div class="group">
            <input type="text" id="extName" name="extName" class="form-control" placeholder="Ext Name (Jr., Sr., I, II)">
            <i class="fa fa-user"></i>
          </div>
		  
		  
          <div class="group">
            <input type="text" id="username" name="username" class="form-control" placeholder="Username *">
            <i class="fa fa-user"></i>
          </div>
          <div class="group">
            <input type="email" id="email" name="email" class="form-control" placeholder="E-mail *">
            <i class="fa fa-envelope-o"></i>
          </div>
          <div class="group">
            <input type="password" id="password" name = "password" class="form-control" placeholder="Password *">
            <i class="fa fa-key"></i>
          </div>
          <div class="group">
            <input type="password" id="confirmPass" name="confirmPass" class="form-control" placeholder="Confirm Password *">
            <i class="fa fa-key"></i>
          </div>
          <button type="submit" id="btnRegister" name="btnRegister" value = "btnRegister" class="btn btn-default btn-block">REGISTER NOW</button>
        </div>
      </form>
      <div class="footer-links row">
        <div class="col-xs-6"><a href="login.php"><i class="fa fa-sign-in"></i> Login</a></div>
        <!--<div class="col-xs-6 text-right"><a href="#"><i class="fa fa-lock"></i> Forgot password</a></div>-->
      </div>
    </div>


<!-- ================================================
jQuery Library
================================================ -->
<script type="text/javascript" src="js/jquery.min.js"></script>

<!-- ================================================
Bootstrap Core JavaScript File
================================================ -->
<script src="js/bootstrap/bootstrap.min.js"></script>

<!-- ================================================
Plugin.js - Some Specific JS codes for Plugin Settings
================================================ -->
<script type="text/javascript" src="js/plugins.js"></script>

<!-- ================================================
Sweet Alert
================================================ -->
<script src="js/sweet-alert/sweet-alert.min.js"></script>

<!-- ================================================
Kode Alert
================================================ -->
<script src="js/kode-alert/main.js"></script>
	
</body>
</html>