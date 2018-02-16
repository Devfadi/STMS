<?php	
include '../connection.php';
//--------------------------------------------
//			delete account
//--------------------------------------------
if(isset($_POST["deleteuserid"])){
	$uid=$_POST["deleteuserid"];
	mysqli_query($link, "update userdata set VISIBILITY='DELETED' where USERID='$uid'");
		$_SESSION['user_success_message'] = "Your have successfully been delete the account";
		$userurl='index.php?page=pending_requests';
		//echo '<script>window.location = "'.$userurl.'";</script>';
	
}else{}
//--------------------------------------------
//			unblock user

if(isset($_POST["unblockuserid"])){
	$uid=$_POST["unblockuserid"];
	mysqli_query($link, "update userdata set STATUS='ACTIVE' where USERID='$uid'");
		$_SESSION['user_success_message'] = "Your have successfully been unblock the account";
		$userurl='index.php?page=pending_requests';
		//echo '<script>window.location = "'.$userurl.'";</script>';
	
}else{}
		//----------------------------user panel notification messages---------------------------------->
	if(isset($_SESSION['user_success_message'])){
			echo"<div class='alert alert-block alert-success' style='color:green'>
					<button type='button' class='close' data-dismiss='alert'>
						<i class='ace-icon fa fa-times'></i>
					</button>
						<i class='ace-icon fa fa-check green'></i>
						",$_SESSION['user_success_message'],"
				</div>";
				unset($_SESSION['user_success_message']);
		}else{}
		if(isset($_SESSION['user_failure_message'])){
			echo"<div class='alert alert-block alert-danger'  style='color:red'>
					<button type='button' class='close' data-dismiss='alert'>
						<i class='ace-icon fa fa-times'></i>
					</button>
						<i class='ace-icon fa fa-remove red'></i>
						",$_SESSION['user_failure_message'],"
				</div>";
				unset($_SESSION['user_failure_message']);
		}else{}
		?>

<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
	</script>

	<ul class="breadcrumb">
		<li>
			<i class="ace-icon fa fa-home home-icon"></i>
			<a href="#">Home</a>
		</li>

		<li>
			<a href="#">Courses</a>
		</li>
		<li class="active">Students Requests</li>
	</ul><!-- /.breadcrumb -->
</div>
<hr>

<div class='row'>
	<div class="col-sm-12">
		<table id="simple-table" class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
			<thead>
				<tr>
					<th>Name</th>
					<th>Education</th>
					<th>Email</th>
					<th>Contact No.</th>
					<th>Account Type</th>
					<th>Registration Date</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$result=$link->query("select* FROM userdata WHERE STATUS='BLOCKED' and VISIBILITY='ACTIVE' ");
				if($result->num_rows>0){
					while($row=$result->fetch_assoc()){
						echo"
							<tr>
								<td>".$row["FIRSTNAME"]." ".$row["LASTNAME"]."</td>
								<td>".$row["EDUCATION"]."</td>
								<td>".$row["EMAIL"]."</td>
								<td>".$row["CONTACTNO"]."</td>
								<td>".$row["ACCOUNT"]."</td>
								<td class='hidden-480'>
									<span class='label label-sm label-warning'>".date('F j, Y H:i:s',strtotime($row["ADDEDDATE"]))."</span>
								</td>
								<td>
									<div class='hidden-sm hidden-xs btn-group'>
										<a href='#E".$row["USERID"]."' role='button' class='green' data-toggle='modal'> 
											<i class='ace-icon fa fa-check bigger-120'></i>
										</a>
										<a href='#D".$row["USERID"]."' role='button' class='red' data-toggle='modal'> 
											<i class='ace-icon fa fa-trash bigger-120'></i>
										</a>
									</div>
								</td>
							</tr>
						";
					}
				}else{}
				?>
				
			</table>
	</div>

<!-----------------------------------------------------------------------
				deny requests
<!----------------------------------------------------------------------->
<?php
$result=$link->query("select* FROM userdata WHERE STATUS='BLOCKED' and VISIBILITY='ACTIVE' ");
if($result->num_rows>0){
	while($row=$result->fetch_assoc()){
		echo"
		<div id='D".$row["USERID"]."' class='modal fade' tabindex='-1'>
			<div class='modal-dialog'>
				<div class='modal-content'>
					<div class='modal-header no-padding'>
						<div class='table-header' style='background:red;'>
							<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>
								<span class='white'>&times;</span>
							</button>
							Do you want to delete ".$row["FIRSTNAME"]." ".$row["LASTNAME"]."'s account?
						</div>
					</div>
					<form method='post' action='index.php?page=pending_requests' style='padding:20px'>
						<input name='deleteuserid' value='".$row["USERID"]."' type='hidden'/>
						
						<div class='modal-body no-padding'>
							<div class='modal-footer' style='background:#DDDBDB'>
								<button type='submit' class='btn btn-sm' data-dismiss='modal'>
									<i class='ace-icon fa fa-times'></i> Cancel
								</button>
								<button type='submit' class='btn btn-sm btn-danger'>
									<i class='ace-icon fa fa-check'></i> Yes, Please
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>";
	}
}else{}
?>


<!-----------------------------------------------------------------------
				accept requests
<!----------------------------------------------------------------------->
<?php
$result=$link->query("select* FROM userdata WHERE STATUS='BLOCKED' and VISIBILITY='ACTIVE' ");
if($result->num_rows>0){
	while($row=$result->fetch_assoc()){
		echo"
		<div id='E".$row["USERID"]."' class='modal fade' tabindex='-1'>
			<div class='modal-dialog'>
				<div class='modal-content'>
					<div class='modal-header no-padding'>
						<div class='table-header'>
							<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>
								<span class='white'>&times;</span>
							</button>
							Do you want to unblock ".$row["FIRSTNAME"]." ".$row["LASTNAME"]."'s account?
						</div>
					</div>
					<form method='post' action='index.php?page=pending_requests' style='padding:20px'>
						<input name='unblockuserid' value='".$row["USERID"]."' type='hidden'/>
						
						<div class='modal-body no-padding'>
							<div class='modal-footer' style='background:#DDDBDB'>
								<button type='submit' class='btn btn-sm' data-dismiss='modal'>
									<i class='ace-icon fa fa-times'></i> Cancel
								</button>
								<button type='submit' class='btn btn-sm btn-danger'>
									<i class='ace-icon fa fa-check'></i> Yes, Please
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>";
	}
}else{}
?>