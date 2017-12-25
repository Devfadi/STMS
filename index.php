<?php
session_start();
include 'connection.php';




$currenttime=date('Y-m-d H:i:s');

if(isset($_POST["retrievepassword"])){
	$email=$_POST["retrievepassword"];
	$result = $link->query("select* from userdata where EMAIL='$email'");
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()){
			$random = substr(md5(mt_rand()), 0, 7);
			$newpass=md5($random);
			mysqli_query($link,"update userdata set TEMPASSWORD='$newpass' where EMAIL='$email'");
			
			//************************************************************
			$subject ="Password Recovery";
			$msg="Your temporary password is ".$random;
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= "From: Password Notification <system@email.com>" . "\r\n";
			$headers .= 'Cc: ' . "\r\n";

		//	mail($email,$subject,$msg,$headers);
			//************************************************************
			
			$_SESSION["user_success_message"]="A new password ($random) is generated and sent it to to '$email', please check your email and try again";
			$url='index.php';
			//echo '<script>window.location = "'.$url.'";</script>';
		}
	}else{
		$_SESSION["user_failure_message"]="Seems like you entered the wrong email, because we did not find '$email' in our system";
		$url='index.php';
		//echo '<script>window.location = "'.$url.'";</script>';
	}
}else{}

//*********************************************************************
//					CREATE AN ACCOUNT
//*********************************************************************
if(isset($_POST["firstname"]) && isset($_POST["email"])&& isset($_POST["password1"])){
	$fname=$_POST["firstname"];
	$lname=$_POST["lastname"];
	$email=$_POST["email"];
	$contactno=$_POST["contactno"];
	$account=$_POST["account"];
	$password1=$_POST["password1"];
	$password2=$_POST["password2"];
	$password=md5($_POST["password2"]);
	
	if($password1==$password2){
		$result = $link->query("select* from userdata where EMAIL='$email'");
		if ($result->num_rows > 0) {
			$_SESSION["user_failure_message"]="The email ($email) has already been used, please try an another email for registration.";
			$url='index.php';
		//	echo '<script>window.location = "'.$url.'";</script>';
		}else{
			mysqli_query($link,"insert into userdata (FIRSTNAME,LASTNAME,EMAIL,CONTACTNO,PASSWORD,ACCOUNT,ADDEDDATE)VALUES('$fname','$lname','$email','$contactno','$password','$account','$currenttime')");
			$_SESSION["user_success_message"]="Your account has successfully been created. You can login into  your account now. Thanks";
			$url='index.php';
			//echo '<script>window.location = "'.$url.'";</script>';
		}
	}else{
		$_SESSION["user_failure_message"]="Passwords do not match, please try again";
		$url='index.php';
		//echo '<script>window.location = "'.$url.'";</script>';
	}
}else{}
?>
<style>	
body {
    background-image: url("images/bb.jpg");
    background-size: 100% 100%;
	background-repeat: no-repeat;
}
</style>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Portal</title>

		<meta name="description" content="User login page" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />

		<!-- text fonts -->
		<link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="assets/css/ace.min.css" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="assets/css/ace-part2.min.css" />
		<![endif]-->
		<link rel="stylesheet" href="assets/css/ace-rtl.min.css" />

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
	</head>

	<body class="login-layout">
		<div class="main-container">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container">
							<div class="center">
								<h1>
									<span class="red">ST</span>
									<span class="white" id="id-text2">MS</span>
								</h1>
								<h4 class="blue" id="id-company-text">&copy; [GROUP G]</h4>
							</div>

							<div class="space-6"></div>
							<?php
							if(isset($_SESSION['user_success_message'])){
								echo"<div class='alert alert-block alert-success' style='color:green'>
										<button type='button' class='close' data-dismiss='alert'>
										</button>
											",$_SESSION['user_success_message'],"
									</div>";
									unset($_SESSION['user_success_message']);
							}else{}
							if(isset($_SESSION['user_failure_message'])){
								echo"<div class='alert alert-block alert-danger'  style='color:red'>
										<button type='button' class='close' data-dismiss='alert'>
										</button>
											",$_SESSION['user_failure_message'],"
									</div>";
									unset($_SESSION['user_failure_message']);
							}else{}
		
							?>

							<div class="position-relative">
								<div id="login-box" class="login-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header blue lighter bigger">
												<i class="ace-icon fa fa-coffee green"></i>
												Please Enter Your Information
											</h4>

											<div class="space-6"></div>

											<form method="post" action="login1.php">
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" name ="email" class="form-control" placeholder="Email" required />
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" name="password" class="form-control" placeholder="Password" required />
															<i class="ace-icon fa fa-lock"></i>
														</span>
													</label>

													<div class="space"></div>
													<p style='color:red'>
													<?php
													if(isset($_SESSION["loginfailed"])){
													echo $_SESSION["loginfailed"];
													unset($_SESSION["loginfailed"]);
;													}else{}												
													?>
													</p>

													<div class="clearfix">
														<label class="inline">
															<input type="checkbox" class="ace" />
															<span class="lbl"> Remember Me</span>
														</label>

														<button  class="width-35 pull-right btn btn-sm btn-primary">
															<i class="ace-icon fa fa-key"></i>
															<span class="bigger-110">Login</span>
														</button>
													</div>

													<div class="space-4"></div>
												</fieldset>
											</form>
										</div><!-- /.widget-main -->

										<div class="toolbar clearfix">
											<div>
												<a href="#" data-target="#forgot-box" class="forgot-password-link">
													<i class="ace-icon fa fa-arrow-left"></i>
													I forgot my password
												</a>
											</div>

											<div>
												<a href="#" data-target="#signup-box" class="user-signup-link">
													I want to register
													<i class="ace-icon fa fa-arrow-right"></i>
												</a>
											</div>
										</div>
									</div><!-- /.widget-body -->
								</div><!-- /.login-box -->

								<div id="forgot-box" class="forgot-box widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header red lighter bigger">
												<i class="ace-icon fa fa-key"></i>
												Retrieve Password
											</h4>

											<div class="space-6"></div>
											<p>
												Enter your email and to receive instructions
											</p>

											<form method="post" action="index.php">
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="email" name="retrievepassword" class="form-control" placeholder="Email" />
															<i class="ace-icon fa fa-envelope"></i>
														</span>
													</label>

													<div class="clearfix">
														<button class="width-35 pull-right btn btn-sm btn-danger">
															<i class="ace-icon fa fa-lightbulb-o"></i>
															<span class="bigger-110">Send Me!</span>
														</button>
													</div>
												</fieldset>
											</form>
										</div><!-- /.widget-main -->

										<div class="toolbar center">
											<a href="#" data-target="#login-box" class="back-to-login-link">
												Back to login
												<i class="ace-icon fa fa-arrow-right"></i>
											</a>
										</div>
									</div><!-- /.widget-body -->
								</div><!-- /.forgot-box -->

								<div id="signup-box" class="signup-box widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header green lighter bigger">
												<i class="ace-icon fa fa-users blue"></i>
												New User Registration
											</h4>

											<div class="space-6"></div>
											<p> Enter your details to begin: </p>

											<form method="post" action="index.php">
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" name="firstname" class="form-control" placeholder="First Name" required/>
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" name="lastname" class="form-control" placeholder="Last Name" required/>
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="email" name="email" class="form-control" placeholder="Email" required/>
															<i class="ace-icon fa fa-envelope"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" name="contactno" class="form-control" placeholder="Contact Number" required/>
															<i class="ace-icon fa fa-phone"></i>
														</span>
													</label>
													
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<select class="form-control" name="account"  />
																<option value="TEACHER">Teacher</option>
																<option value="STUDENT">Student</option>
															</select>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" name="password1"  placeholder="Password" required/>
															<i class="ace-icon fa fa-lock"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" name="password2" placeholder="Repeat password" required/>
															<i class="ace-icon fa fa-retweet"></i>
														</span>
													</label>

													<div class="space-24"></div>

													<div class="clearfix">
														<button type="reset" class="width-30 pull-left btn btn-sm">
															<i class="ace-icon fa fa-refresh"></i>
															<span class="bigger-110">Reset</span>
														</button>

														<button class="width-65 pull-right btn btn-sm btn-success">
															<span class="bigger-110">Register</span>

															<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
														</button>
													</div>
												</fieldset>
											</form>
										</div>

										<div class="toolbar center">
											<a href="#" data-target="#login-box" class="back-to-login-link">
												<i class="ace-icon fa fa-arrow-left"></i>
												Back to login
											</a>
										</div>
									</div><!-- /.widget-body -->
								</div><!-- /.signup-box -->
							</div><!-- /.position-relative -->

						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.main-content -->
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script src="assets/js/jquery-2.1.4.min.js"></script>

		<!-- <![endif]-->

		<!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
			 $(document).on('click', '.toolbar a[data-target]', function(e) {
				e.preventDefault();
				var target = $(this).data('target');
				$('.widget-box.visible').removeClass('visible');//hide others
				$(target).addClass('visible');//show target
			 });
			});
			
			
			
			//you don't need this, just used for changing background
			jQuery(function($) {
			 $('#btn-login-dark').on('click', function(e) {
				$('body').attr('class', 'login-layout');
				$('#id-text2').attr('class', 'white');
				$('#id-company-text').attr('class', 'blue');
				
				e.preventDefault();
			 });
			 $('#btn-login-light').on('click', function(e) {
				$('body').attr('class', 'login-layout light-login');
				$('#id-text2').attr('class', 'grey');
				$('#id-company-text').attr('class', 'blue');
				
				e.preventDefault();
			 });
			 $('#btn-login-blur').on('click', function(e) {
				$('body').attr('class', 'login-layout blur-login');
				$('#id-text2').attr('class', 'white');
				$('#id-company-text').attr('class', 'light-blue');
				
				e.preventDefault();
			 });
			 
			});
		</script>
	</body>
</html>
