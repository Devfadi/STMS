
<div id="navbar" class="navbar navbar-default">
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>



<?php

 include '../connection.php';
if (!empty(isset($_SESSION['activeuserid']))){ //check for sessions
	$activeuserid=$_SESSION['activeuserid'];
	$displayuserdata="SELECT* from  userdata where USERID='$activeuserid'";
	$result=$link->query($displayuserdata);
	if($result->num_rows>0){
		while($row=$result->fetch_assoc()){
			$fname=$row["FIRSTNAME"];
			$lname=$row["LASTNAME"];
			$education=$row["EDUCATION"];
			$email=$row["EMAIL"];
			$contactno=$row["CONTACTNO"];
		}
	}else{}
}
else{
	//echo "session did not work";
	$userurl='../index.php';
	echo '<script>window.location = "'.$userurl.'";</script>';
}	

//******************************************************************************

//******************************************************************************
//update password---------------------------
if (isset($_POST['oldpassword'])){
	//$oldpassword=md5($_POST['oldpassword']);
	$oldpassword=$_POST['oldpassword'];
	$newpassword1=md5($_POST['newpassword1']);
	$newpassword2=md5($_POST['newpassword2']);
	
	$sql ="SELECT * FROM userdata WHERE USERID='".$activeuserid."' AND PASSWORD='".$oldpassword."'";
	$result = $link->query($sql);
		if ($result->num_rows > 0) {
			if($newpassword1==$newpassword2){
				$sql ="update userdata set PASSWORD='$newpassword1' where  USERID='$activeuserid' ";
				if (mysqli_query($link, $sql)) {
					//echo "Information Updated successfully";
					$userurl='index.php';
					echo '<script>window.location = "'.$userurl.'";</script>';
					$_SESSION['user_success_message']="The password has successfully been changed";
					exit();
				}
				else {
					//echo "query not working";
					$userurl='index.php';
					echo '<script>window.location = "'.$userurl.'";</script>';
					$_SESSION['user_failure_message']="Password can't be changed, please contact with the administrator";
					exit();
				}
			}else{
					//echo "old password is wrong";
					$userurl='index.php';
					echo '<script>window.location = "'.$userurl.'";</script>';
					$_SESSION['user_failure_message']="Passwords don't match, please try later";
					exit();
				}
}
else{
					//echo "old password is wrong";
					$userurl='index.php';
					echo '<script>window.location = "'.$userurl.'";</script>';
					$_SESSION['user_failure_message']="Old password is wrong, please try later";
					exit();
}
$link->close();
}		


//-----------------------------------------UPDATE INFORMATIONS----------------------------------------------------------------


if (!empty(isset($_POST['updatefirstname']))){
	$fname=$_POST['updatefirstname'];
	$lastname=$_POST['lastname'];
	$education=$_POST['education'];
	$contactno=$_POST['contactno'];
	

$sql ="update userdata
set 
FIRSTNAME='$fname',LASTNAME='$lname',EDUCATION='$education',CONTACTNO='$contactno'
	where USERID='$activeuserid'";
		
if (mysqli_query($link, $sql)) {
   // echo "Information Updated successfully";
	$_SESSION['user_success_message'] = "Your account information has successfully been updated";
	$userurl='index.php';
	echo '<script>window.location = "'.$userurl.'";</script>';
	exit();
	
}
else {
	//echo "query not working";
	$_SESSION['user_failure_message'] = 'Failed to update information, please contact with the system admin';
	$userurl='index.php';
	echo '<script>window.location = "'.$userurl.'";</script>';
	exit();
}
}
$link->close();

	//echo"session failed";
?>	


			<div class="navbar-container" id="navbar-container">
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
					<span class="sr-only">Toggle sidebar</span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>
				</button>
				<div class="navbar-header pull-left">
					<a href="index.php" class="navbar-brand">
						<small>
							<i class="fa fa-book"></i>
							Teacher Portal
						</small>
					</a>
				</div>
                
				<div class="navbar-buttons navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						<li><button class="btn btn-success"><a href="https://awkumsrh.slack.com/messages" class="btn btn-success" style=" border:2px solid white; border-radius:5px; margin-top:-5px; margin-right:-10px;" target="_blank">Message Portal</a></button></li>
						<li class="light-blue">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
							<img src="../images/defaultuser.png" width="30px" height="30px">

								<span class="user-info">
									<small>Welcome,</small>
									<?php echo $fname," ",$lname; ?>
								</span>

								<i class="ace-icon fa fa-caret-down"></i>
							</a>
                            
							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href='#V' role='button' data-toggle='modal'>
									<i class="ace-icon fa fa-lock"></i>
											Change Password
									</a>
								</li>
								<li>
									<a href='#P' role='button' data-toggle='modal'>
									<i class="ace-icon fa fa-user"></i>
											Edit Profile
									</a>
								</li>
								<li>
									<a href="logout.php">
										<i class="ace-icon fa fa-power-off"></i>
										Logout
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div><!-- /.navbar-container -->
		</div>

		<div id='V' class='modal fade' tabindex='-1'>
			<div class='modal-dialog'>
				<div class='modal-content'>
					<div class='modal-header no-padding'>
						<div class='table-header'>
							<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>
								<span class='white'>&times;</span>
							</button>
							Do you want to reset your password?
						</div>
					</div>
					<form method='post' action='index.php' style='padding:20px'>
						<div class='row'>
							<div class='col-sm-6' align='right'>
								<label> Old Password </label><br><br><br>
								<label> New Password </label><br><br>
								<label> Re-enter New Password </label><br><br>
							</div>
							<div class='col-sm-6' align='left'>
								<input name='oldpassword' type='password' > <br><br>
								<input name='newpassword1' type='password'><br><br>
								<input name='newpassword2' type='password'><br><br>
							</div>
						</div>
						
						
						<div class='modal-body no-padding'>
							<div class='modal-footer' style='background:#DDDBDB'>
								<button type='submit' class='btn btn-sm' data-dismiss='modal'>
									<i class='ace-icon fa fa-times'></i> Cancel
								</button>
								<button type='submit' class='btn btn-sm btn-primary'>
									<i class='ace-icon fa fa-check'></i> Yes, Please
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		
		
		
		<div id='P' class='modal fade' tabindex='-1'>
			<div class='modal-dialog'>
				<div class='modal-content'>
					<div class='modal-header no-padding'>
						<div class='table-header'>
							<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>
								<span class='white'>&times;</span>
							</button>
							Personal Profile
						</div>
					</div>
					<form method='post' action='index.php' style='padding:20px'>
						<div class='row'>
							<div class='col-sm-6' align=''>
								<label><b> FIRSTNAME </b></label>
								<input name='updatefirstname' type='text' value='<?php echo $fname; ?>'> <br><br>
								<label><b> EDUCATION</b></label><br>
								<input name='education' type='text' value='<?php echo $education; ?>' > <br><br>
							</div>
							<div class='col-sm-6' align=''>
								<label><b> LASTNAME </b></label><br>
								<input name='lastname' type='text' value='<?php echo $lname; ?>'> <br><br>
								<label><b> CONTACT# </b></label><br>
								<input name='contactno' type='text' value='<?php echo $contactno; ?>'> <br><br>
							</div>
						</div>
						 
						
						<div class='modal-body no-padding'>
							<div class='modal-footer' style='background:#DDDBDB'>
								<button type='submit' class='btn btn-sm' data-dismiss='modal'>
									<i class='ace-icon fa fa-times'></i> Cancel
								</button>
								<button type='submit' class='btn btn-sm btn-primary'>
									<i class='ace-icon fa fa-check'></i> Update Information
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>